<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use App\Models\Admin;
use App\Models\Student;
use App\Models\Center;
use App\Models\Bus;
use App\Models\Driver;
use App\Models\Payment;
use App\Models\AdminActivity;

class AdminController extends Controller
{
    // ==================== تسجيل الدخول ====================

    public function showLoginForm()
    {
        if (session('admin_logged_in')) {
            return redirect()->route('admin.dashboard');
        }

        return view('admin.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|min:6'
        ], [
            'username.required' => 'اسم المستخدم مطلوب',
            'password.required' => 'كلمة المرور مطلوبة',
            'password.min' => 'كلمة المرور يجب أن تكون 6 أحرف على الأقل'
        ]);

        try {
            $admin = Admin::where('username', $request->username)
                         ->orWhere('email', $request->username)
                         ->first();

            if (!$admin) {
                return back()->withErrors(['login_error' => 'بيانات تسجيل الدخول غير صحيحة'])
                           ->withInput($request->only('username'));
            }

            if (!Hash::check($request->password, $admin->password)) {
                return back()->withErrors(['login_error' => 'بيانات تسجيل الدخول غير صحيحة'])
                           ->withInput($request->only('username'));
            }

            if ($admin->status !== 'active') {
                return back()->withErrors(['login_error' => 'حسابك غير نشط'])
                           ->withInput($request->only('username'));
            }

            session([
                'admin_id' => $admin->id,
                'admin_logged_in' => true,
                'admin_name' => $admin->name,
                'admin_username' => $admin->username,
                'admin_email' => $admin->email,
                'admin_role' => $admin->role ?? 'admin',
                'login_time' => now() 
            ]);

            $admin->increment('login_count');
            $admin->update(['last_login' => now()]);

            AdminActivity::create([
                'admin_id' => $admin->id,
                'action' => 'login',
                'description' => 'تسجيل دخول للنظام',
                'ip_address' => $request->ip(),
            ]);

            Log::info('تسجيل دخول إدارة ناجح', ['admin_id' => $admin->id]);

            return redirect()->route('admin.dashboard')
                           ->with('success', 'مرحباً بك ' . $admin->name);

        } catch (\Exception $e) {
            Log::error('خطأ في تسجيل دخول الإدارة', ['error' => $e->getMessage()]);

            return back()->withErrors(['login_error' => 'حدث خطأ أثناء تسجيل الدخول'])
                        ->withInput($request->only('username'));
        }
    }

    public function logout()
    {
        if (session('admin_id')) {
            AdminActivity::create([
                'admin_id' => session('admin_id'),
                'action' => 'logout',
                'description' => 'تسجيل خروج من النظام',
                'ip_address' => request()->ip(),
            ]);
        }

        Log::info('تسجيل خروج إدارة', ['admin_id' => session('admin_id')]);

        session()->flush();
        session()->regenerate();

        return redirect()->route('admin.login')->with('success', 'تم تسجيل الخروج بنجاح');
    }

    // ==================== لوحة التحكم ====================

    public function dashboard()
    {
        try {
            $currentAdmin = $this->getAdmin();
            $allowedCenterIds = $currentAdmin->getAllowedCenterIds();
            $allowedSchedules = $currentAdmin->getAllowedSchedules();

            $stats = [
                'total_students' => Student::whereIn('center_id', $allowedCenterIds)
                                          ->whereIn('preferred_schedule', $allowedSchedules)->count(),
                'pending_students' => Student::whereIn('center_id', $allowedCenterIds)
                                            ->whereIn('preferred_schedule', $allowedSchedules)
                                            ->where('status', 'pending')->count(),
                'approved_students' => Student::whereIn('center_id', $allowedCenterIds)
                                             ->whereIn('preferred_schedule', $allowedSchedules)
                                             ->where('status', 'approved')->count(),
                'rejected_students' => Student::whereIn('center_id', $allowedCenterIds)
                                             ->whereIn('preferred_schedule', $allowedSchedules)
                                             ->where('status', 'rejected')->count(),
                'suspended_students' => Student::whereIn('center_id', $allowedCenterIds)
                                              ->whereIn('preferred_schedule', $allowedSchedules)
                                              ->where('status', 'suspended')->count(),
                'total_centers' => Center::whereIn('id', $allowedCenterIds)->count(),
                'active_centers' => Center::whereIn('id', $allowedCenterIds)->where('status', 'active')->count(),
                'total_buses' => Bus::count(),
                'active_buses' => Bus::where('status', 'active')->count(),
                'total_drivers' => Driver::count(),
                'available_drivers' => Driver::where('status', 'available')->count(),
                'pending_payments' => Payment::whereHas('student', fn($q) => $q->whereIn('center_id', $allowedCenterIds)
                                                                              ->whereIn('preferred_schedule', $allowedSchedules))
                                            ->where('status', 'pending')->count(),
                'total_payments' => Payment::whereHas('student', fn($q) => $q->whereIn('center_id', $allowedCenterIds)
                                                                            ->whereIn('preferred_schedule', $allowedSchedules))
                                          ->where('status', 'approved')->sum('amount')
            ];

            $centers = Center::whereIn('id', $allowedCenterIds)
                            ->withCount(['students' => function($q) use ($allowedSchedules) {
                                $q->where('status', 'approved')
                                  ->whereIn('preferred_schedule', $allowedSchedules);
                            }])->get();

            $recent_students = Student::whereIn('center_id', $allowedCenterIds)
                                     ->whereIn('preferred_schedule', $allowedSchedules)
                                     ->latest()
                                     ->take(10)
                                     ->get();

            return view('admin.dashboard', compact('stats', 'centers', 'recent_students', 'currentAdmin'));

        } catch (\Exception $e) {
            Log::error('خطأ في لوحة التحكم', ['error' => $e->getMessage()]);

            return view('admin.dashboard', [
                'stats' => $this->getEmptyStats(),
                'centers' => collect(),
                'recent_students' => collect(),
                'currentAdmin' => $this->getAdmin()
            ])->with('warning', 'بعض البيانات غير متوفرة');
        }
    }

    // ==================== الملف الشخصي ====================

    public function profile()
    {
        $admin = Admin::find(session('admin_id'));
        
        if (!$admin) {
            return redirect()->route('admin.login');
        }

        $adminId = $admin->id;
        
        $loginCount = $admin->login_count ?? AdminActivity::where('admin_id', $adminId)
                                                          ->where('action', 'login')
                                                          ->count();
        
        $lastLogin = $admin->last_login ? \Carbon\Carbon::parse($admin->last_login)->format('Y-m-d H:i') : 'غير محدد';
        
        $studentsAdded = AdminActivity::where('admin_id', $adminId)
                                      ->where('action', 'add_student')
                                      ->count();
        
        $approvedRequests = AdminActivity::where('admin_id', $adminId)
                                         ->where('action', 'approve_student')
                                         ->count();
        
        $modificationsCount = AdminActivity::where('admin_id', $adminId)
                                           ->whereNotIn('action', ['login', 'logout'])
                                           ->count();
        
        $activityHours = $this->calculateActivityHours($adminId);

        $recentActivities = AdminActivity::where('admin_id', $adminId)
                                         ->latest()
                                         ->take(10)
                                         ->get();

        return view('admin.profile', compact(
            'admin', 'loginCount', 'lastLogin', 
            'studentsAdded', 'approvedRequests', 
            'modificationsCount', 'activityHours',
            'recentActivities'
        ));
    }

    private function calculateActivityHours($adminId)
    {
        $loginTime = session('login_time');
        $currentSessionHours = 0;
        
        if ($loginTime) {
            $currentSessionHours = now()->diffInMinutes($loginTime) / 60;
        }
        
        return round($currentSessionHours, 1);
    }

    public function updateProfile(Request $request)
    {
        $admin = Admin::find(session('admin_id'));

        if (!$admin) {
            return redirect()->route('admin.login')->with('error', 'الجلسة منتهية');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:admins,email,' . $admin->id,
            'phone' => 'nullable|string|max:20',
            'job_title' => 'nullable|string|max:100',
            'bio' => 'nullable|string|max:500'
        ]);

        try {
            $admin->update($request->only(['name', 'email', 'phone', 'job_title', 'bio']));
            session(['admin_name' => $request->name]);

            AdminActivity::create([
                'admin_id' => $admin->id,
                'action' => 'update_profile',
                'description' => 'تحديث المعلومات الشخصية',
                'ip_address' => request()->ip(),
            ]);

            return redirect()->route('admin.profile')
                ->with('success', 'تم تحديث المعلومات الشخصية بنجاح');

        } catch (\Exception $e) {
            Log::error('Profile Update Error: ' . $e->getMessage());
            return back()->with('error', 'حدث خطأ أثناء التحديث')->withInput();
        }
    }

    public function changePassword(Request $request)
    {
        $admin = Admin::find(session('admin_id'));

        if (!$admin) {
            return redirect()->route('admin.login')->with('error', 'الجلسة منتهية');
        }

        $request->validate([
            'current_password' => 'required',
            'password' => 'required|min:6|confirmed'
        ], [
            'current_password.required' => 'كلمة المرور الحالية مطلوبة',
            'password.required' => 'كلمة المرور الجديدة مطلوبة',
            'password.min' => 'كلمة المرور يجب أن تكون 6 أحرف على الأقل',
            'password.confirmed' => 'كلمة المرور غير متطابقة'
        ]);

        try {
            if (!Hash::check($request->current_password, $admin->password)) {
                return back()->withErrors(['current_password' => 'كلمة المرور الحالية غير صحيحة']);
            }

            $admin->update(['password' => Hash::make($request->password)]);

            AdminActivity::create([
                'admin_id' => $admin->id,
                'action' => 'change_password',
                'description' => 'تغيير كلمة المرور',
                'ip_address' => request()->ip(),
            ]);

            Log::info('تم تغيير كلمة المرور', ['admin_id' => $admin->id]);

            return redirect()->route('admin.profile')
                ->with('success', 'تم تغيير كلمة المرور بنجاح');

        } catch (\Exception $e) {
            Log::error('Change Password Error: ' . $e->getMessage());
            return back()->with('error', 'حدث خطأ أثناء تغيير كلمة المرور');
        }
    }

    public function updateSettings(Request $request)
    {
        $admin = Admin::find(session('admin_id'));

        if (!$admin) {
            return redirect()->route('admin.login');
        }

        $admin->update([
            'email_notifications' => $request->has('email_notifications'),
            'sms_notifications' => $request->has('sms_notifications'),
            'two_factor' => $request->has('two_factor'),
            'language' => $request->language ?? 'ar',
        ]);

        return back()->with('success', 'تم حفظ الإعدادات بنجاح');
    }

    // ==================== التقارير ====================

    public function reports()
    {
        $currentAdmin = $this->getAdmin();
        $allowedCenterIds = $currentAdmin->getAllowedCenterIds();
        $allowedSchedules = $currentAdmin->getAllowedSchedules();

        $stats = [
            'total_students' => Student::whereIn('center_id', $allowedCenterIds)
                                      ->whereIn('preferred_schedule', $allowedSchedules)->count(),
            'approved_students' => Student::whereIn('center_id', $allowedCenterIds)
                                         ->whereIn('preferred_schedule', $allowedSchedules)
                                         ->where('status', 'approved')->count(),
            'pending_students' => Student::whereIn('center_id', $allowedCenterIds)
                                        ->whereIn('preferred_schedule', $allowedSchedules)
                                        ->where('status', 'pending')->count(),
            'rejected_students' => Student::whereIn('center_id', $allowedCenterIds)
                                         ->whereIn('preferred_schedule', $allowedSchedules)
                                         ->where('status', 'rejected')->count(),
            'morning_students' => Student::whereIn('center_id', $allowedCenterIds)
                                        ->where('preferred_schedule', 'صباحية')
                                        ->where('status', 'approved')->count(),
            'evening_students' => Student::whereIn('center_id', $allowedCenterIds)
                                        ->where('preferred_schedule', 'مسائية')
                                        ->where('status', 'approved')->count(),
            'total_buses' => Bus::count(),
            'active_buses' => Bus::where('status', 'active')->count(),
            'maintenance_buses' => Bus::where('status', 'maintenance')->count(),
            'inactive_buses' => Bus::where('status', 'inactive')->count(),
            'total_capacity' => Bus::where('status', 'active')->sum('capacity'),
            'occupied_seats' => Bus::where('status', 'active')->sum('current_students'),
            'total_centers' => Center::whereIn('id', $allowedCenterIds)->where('status', 'active')->count(),
        ];

        $stats['occupancy_rate'] = $stats['total_capacity'] > 0
            ? round(($stats['occupied_seats'] / $stats['total_capacity']) * 100)
            : 0;

        $centerStats = Center::select('center_name')
            ->whereIn('id', $allowedCenterIds)
            ->withCount([
                'students as students_count' => function($q) use ($allowedSchedules) {
                    $q->where('status', 'approved')
                      ->whereIn('preferred_schedule', $allowedSchedules);
                },
                'buses as buses_count' => function($q) {
                    $q->where('status', 'active');
                }
            ])
            ->where('status', 'active')
            ->orderByDesc('students_count')
            ->get();

        return view('admin.reports', compact('stats', 'centerStats', 'currentAdmin'));
    }

    // ==================== إدارة الموظفين ====================

    /**
     * قائمة الموظفين
     */
    public function adminsIndex(Request $request)
    {
        $currentAdmin = $this->getAdmin();
        
        // التحقق من الصلاحية
        if (!$currentAdmin->canView('admins')) {
            return redirect()->route('admin.dashboard')->with('error', 'ليس لديك صلاحية للوصول لهذه الصفحة');
        }

        $query = Admin::with('centers');

        // البحث
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('username', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        // فلترة بالرتبة
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        // فلترة بالحالة
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $admins = $query->orderByRaw("FIELD(role, 'developer', 'super_admin', 'admin', 'data_entry', 'accountant', 'supervisor')")
                       ->paginate(15);

        // إحصائيات
        $stats = [
            'total' => Admin::count(),
            'active' => Admin::where('status', 'active')->count(),
            'super_admins' => Admin::where('role', 'super_admin')->count(),
        ];

        return view('admin.admins.index', compact('admins', 'stats', 'currentAdmin'));
    }

    /**
     * صفحة إضافة موظف جديد
     */
    public function adminsCreate()
    {
        $currentAdmin = $this->getAdmin();
        
        if (!$currentAdmin->canCreate('admins')) {
            return redirect()->route('admin.dashboard')->with('error', 'ليس لديك صلاحية');
        }

        $roles = $currentAdmin->getCreatableRoles();
        $centers = Center::where('status', 'active')->orderBy('center_name')->get();
        $allPermissions = Admin::allPermissions();

        return view('admin.admins.create', compact('currentAdmin', 'roles', 'centers', 'allPermissions'));
    }

    /**
     * حفظ موظف جديد
     */
    public function adminsStore(Request $request)
    {
        $currentAdmin = $this->getAdmin();
        
        if (!$currentAdmin->canCreate('admins')) {
            return redirect()->route('admin.dashboard')->with('error', 'ليس لديك صلاحية');
        }

        $allowedRoles = array_keys($currentAdmin->getCreatableRoles());

        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:admins,username',
            'email' => 'nullable|email|unique:admins,email',
            'phone' => 'nullable|string|max:20',
            'job_title' => 'nullable|string|max:100',
            'password' => 'required|min:6|confirmed',
            'role' => 'required|in:' . implode(',', $allowedRoles),
            'status' => 'required|in:active,inactive',
            'center_ids' => 'nullable|array',
            'center_ids.*' => 'exists:centers,id',
            'permissions' => 'nullable|array',
            'allowed_schedules' => 'nullable|array',
            'allowed_schedules.*' => 'in:صباحية,مسائية',
        ], [
            'name.required' => 'الاسم مطلوب',
            'username.required' => 'اسم المستخدم مطلوب',
            'username.unique' => 'اسم المستخدم موجود مسبقاً',
            'email.unique' => 'البريد الإلكتروني موجود مسبقاً',
            'password.required' => 'كلمة المرور مطلوبة',
            'password.min' => 'كلمة المرور يجب أن تكون 6 أحرف على الأقل',
            'password.confirmed' => 'تأكيد كلمة المرور غير مطابق',
            'role.required' => 'الرتبة مطلوبة',
        ]);

        try {
            $admin = Admin::create([
                'name' => $request->name,
                'username' => $request->username,
                'email' => $request->email,
                'phone' => $request->phone,
                'job_title' => $request->job_title,
                'password' => Hash::make($request->password),
                'role' => $request->role,
                'status' => $request->status,
                'permissions' => $request->permissions,
                'allowed_schedules' => $request->allowed_schedules,
            ]);

            // ربط الجهات
            if ($request->has('center_ids') && !empty($request->center_ids)) {
                $admin->centers()->sync($request->center_ids);
            }

            AdminActivity::create([
                'admin_id' => $currentAdmin->id,
                'action' => 'create_admin',
                'description' => 'إنشاء حساب موظف: ' . $admin->name . ' (' . ($admin->role_name ?? $admin->role) . ')',
                'ip_address' => request()->ip(),
            ]);

            Log::info('تم إنشاء موظف جديد', ['admin_id' => $admin->id, 'by' => $currentAdmin->id]);

            return redirect()->route('admin.admins.index')
                ->with('success', 'تم إضافة الموظف بنجاح');

        } catch (\Exception $e) {
            Log::error('خطأ في إنشاء موظف', ['error' => $e->getMessage()]);
            return back()->with('error', 'حدث خطأ أثناء الإضافة: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * صفحة تعديل موظف
     */
    public function adminsEdit(Admin $admin)
    {
        $currentAdmin = $this->getAdmin();
        
        if (!$currentAdmin->canEditAdmin($admin)) {
            return redirect()->route('admin.admins.index')
                ->with('error', 'ليس لديك صلاحية لتعديل هذا الموظف');
        }

        $roles = $currentAdmin->getCreatableRoles();
        
        // إذا كان الموظف المستهدف له رتبة أعلى، أضفها للقائمة
        if (!isset($roles[$admin->role])) {
            $roles[$admin->role] = Admin::ROLE_NAMES[$admin->role] ?? $admin->role;
        }

        $centers = Center::where('status', 'active')->orderBy('center_name')->get();
        $selectedCenterIds = $admin->centers->pluck('id')->toArray();
        $allPermissions = Admin::allPermissions();

        return view('admin.admins.edit', compact('admin', 'currentAdmin', 'roles', 'centers', 'selectedCenterIds', 'allPermissions'));
    }

    /**
     * تحديث بيانات موظف
     */
    public function adminsUpdate(Request $request, Admin $admin)
    {
        $currentAdmin = $this->getAdmin();
        
        if (!$currentAdmin->canEditAdmin($admin)) {
            return redirect()->route('admin.admins.index')
                ->with('error', 'ليس لديك صلاحية لتعديل هذا الموظف');
        }

        $allowedRoles = array_keys($currentAdmin->getCreatableRoles());
        
        // إذا الموظف له رتبة أعلى، السماح بالإبقاء عليها
        if (!in_array($admin->role, $allowedRoles)) {
            $allowedRoles[] = $admin->role;
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'username' => ['required', 'string', 'max:255', Rule::unique('admins')->ignore($admin->id)],
            'email' => ['nullable', 'email', Rule::unique('admins')->ignore($admin->id)],
            'phone' => 'nullable|string|max:20',
            'job_title' => 'nullable|string|max:100',
            'password' => 'nullable|min:6|confirmed',
            'role' => 'required|in:' . implode(',', $allowedRoles),
            'status' => 'required|in:active,inactive',
            'center_ids' => 'nullable|array',
            'center_ids.*' => 'exists:centers,id',
            'permissions' => 'nullable|array',
            'allowed_schedules' => 'nullable|array',
            'allowed_schedules.*' => 'in:صباحية,مسائية',
        ]);

        try {
            $data = [
                'name' => $request->name,
                'username' => $request->username,
                'email' => $request->email,
                'phone' => $request->phone,
                'job_title' => $request->job_title,
                'role' => $request->role,
                'status' => $request->status,
                'permissions' => $request->permissions,
                'allowed_schedules' => $request->allowed_schedules,
            ];

            if ($request->filled('password')) {
                $data['password'] = Hash::make($request->password);
            }

            $admin->update($data);

            // تحديث الجهات
            $admin->centers()->sync($request->center_ids ?? []);

            AdminActivity::create([
                'admin_id' => $currentAdmin->id,
                'action' => 'update_admin',
                'description' => 'تعديل بيانات موظف: ' . $admin->name,
                'ip_address' => request()->ip(),
            ]);

            return redirect()->route('admin.admins.index')
                ->with('success', 'تم تحديث بيانات الموظف بنجاح');

        } catch (\Exception $e) {
            Log::error('خطأ في تحديث موظف', ['error' => $e->getMessage()]);
            return back()->with('error', 'حدث خطأ أثناء التحديث')->withInput();
        }
    }

    /**
     * حذف موظف
     */
    public function adminsDestroy(Admin $admin)
    {
        $currentAdmin = $this->getAdmin();
        
        if (!$currentAdmin->canDeleteAdmin($admin)) {
            return back()->with('error', 'لا يمكنك حذف هذا الموظف');
        }

        try {
            $adminName = $admin->name;
            $adminRole = $admin->role_name ?? $admin->role;
            
            $admin->centers()->detach();
            $admin->delete();

            AdminActivity::create([
                'admin_id' => $currentAdmin->id,
                'action' => 'delete_admin',
                'description' => 'حذف حساب موظف: ' . $adminName . ' (' . $adminRole . ')',
                'ip_address' => request()->ip(),
            ]);

            return redirect()->route('admin.admins.index')
                ->with('success', 'تم حذف الموظف بنجاح');

        } catch (\Exception $e) {
            Log::error('خطأ في حذف موظف', ['error' => $e->getMessage()]);
            return back()->with('error', 'حدث خطأ أثناء الحذف');
        }
    }

    /**
     * تفعيل/تعطيل موظف
     */
    public function adminsToggleStatus(Admin $admin)
    {
        $currentAdmin = $this->getAdmin();
        
        if (!$currentAdmin->canEditAdmin($admin)) {
            return back()->with('error', 'ليس لديك صلاحية لتعديل هذا الموظف');
        }

        // لا أحد يعطل المطور
        if ($admin->role == 'developer') {
            return back()->with('error', 'لا يمكن تعطيل حساب مطور النظام');
        }

        // منع تعطيل نفسك
        if ($admin->id == $currentAdmin->id) {
            return back()->with('error', 'لا يمكنك تعطيل حسابك الشخصي');
        }

        $newStatus = $admin->status == 'active' ? 'inactive' : 'active';
        $admin->update(['status' => $newStatus]);

        $statusText = $newStatus == 'active' ? 'تفعيل' : 'تعطيل';

        AdminActivity::create([
            'admin_id' => $currentAdmin->id,
            'action' => 'toggle_admin_status',
            'description' => $statusText . ' حساب موظف: ' . $admin->name,
            'ip_address' => request()->ip(),
        ]);

        return back()->with('success', 'تم ' . $statusText . ' الحساب بنجاح');
    }

    /**
     * إعادة تعيين كلمة المرور
     */
    public function adminsResetPassword(Request $request, Admin $admin)
    {
        $currentAdmin = $this->getAdmin();
        
        if (!$currentAdmin->canEditAdmin($admin)) {
            return back()->with('error', 'ليس لديك صلاحية لتعديل هذا الموظف');
        }

        $request->validate([
            'new_password' => 'required|string|min:6',
        ]);

        $admin->update(['password' => Hash::make($request->new_password)]);

        AdminActivity::create([
            'admin_id' => $currentAdmin->id,
            'action' => 'reset_admin_password',
            'description' => 'إعادة تعيين كلمة مرور موظف: ' . $admin->name,
            'ip_address' => request()->ip(),
        ]);

        return back()->with('success', 'تم تغيير كلمة مرور الموظف بنجاح');
    }

    // ==================== دوال مساعدة ====================

    /**
     * الحصول على الموظف الحالي
     */
    protected function getAdmin(): Admin
    {
        return Admin::findOrFail(session('admin_id'));
    }

    public function createDefaultAdmin()
    {
        try {
            if (Admin::count() > 0) {
                return redirect()->route('admin.login')
                               ->with('info', 'يوجد مستخدمون بالفعل في النظام');
            }

            $admin = Admin::create([
                'name' => 'مدير النظام',
                'username' => 'admin',
                'email' => 'admin@quran-society.sa',
                'password' => Hash::make('123456'),
                'phone' => '0500000000',
                'role' => 'super_admin',
                'status' => 'active',
                'login_count' => 0
            ]);

            Log::info('تم إنشاء مدير افتراضي', ['admin_id' => $admin->id]);

            return redirect()->route('admin.login')
                           ->with('success', 'تم إنشاء المستخدم الافتراضي<br>اسم المستخدم: admin<br>كلمة المرور: 123456');

        } catch (\Exception $e) {
            Log::error('خطأ في إنشاء المدير الافتراضي', ['error' => $e->getMessage()]);

            return redirect()->route('admin.login')
                           ->with('error', 'حدث خطأ في إنشاء المستخدم');
        }
    }

    public function testLogin()
    {
        $admins = Admin::all();

        return response()->json([
            'admin_count' => Admin::count(),
            'admins' => $admins->map(function($admin) {
                return [
                    'id' => $admin->id,
                    'username' => $admin->username,
                    'email' => $admin->email,
                    'status' => $admin->status,
                    'role' => $admin->role,
                    'centers' => $admin->centers->pluck('center_name'),
                ];
            })
        ]);
    }

    public function quickStats()
    {
        try {
            $currentAdmin = $this->getAdmin();
            $allowedCenterIds = $currentAdmin->getAllowedCenterIds();
            $allowedSchedules = $currentAdmin->getAllowedSchedules();

            return response()->json([
                'total_students' => Student::whereIn('center_id', $allowedCenterIds)
                                          ->whereIn('preferred_schedule', $allowedSchedules)->count(),
                'pending_students' => Student::whereIn('center_id', $allowedCenterIds)
                                            ->whereIn('preferred_schedule', $allowedSchedules)
                                            ->where('status', 'pending')->count(),
                'approved_students' => Student::whereIn('center_id', $allowedCenterIds)
                                             ->whereIn('preferred_schedule', $allowedSchedules)
                                             ->where('status', 'approved')->count(),
                'active_buses' => Bus::where('status', 'active')->count(),
                'active_drivers' => Driver::where('status', 'active')->count(),
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'حدث خطأ'], 500);
        }
    }

    protected function getEmptyStats(): array
    {
        return [
            'total_students' => 0,
            'pending_students' => 0,
            'approved_students' => 0,
            'rejected_students' => 0,
            'suspended_students' => 0,
            'total_centers' => 0,
            'active_centers' => 0,
            'total_buses' => 0,
            'active_buses' => 0,
            'total_drivers' => 0,
            'available_drivers' => 0,
            'pending_payments' => 0,
            'total_payments' => 0
        ];
    }
}