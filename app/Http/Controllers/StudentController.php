<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Center;
use App\Models\Bus;
use App\Models\Payment;
use App\Models\Admin;
use App\Models\AdminActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class StudentController extends Controller
{
    // ==================== دوال الصلاحيات ====================

    protected function getAdmin()
    {
        return Admin::find(session('admin_id'));
    }

    protected function checkPermission(string $permission)
    {
        $admin = $this->getAdmin();
        
        if (!$admin || !$admin->hasPermission($permission)) {
            abort(403, 'ليس لديك صلاحية للوصول لهذه الصفحة');
        }

        return $admin;
    }

    protected function checkCenterAccess(int $centerId)
    {
        $admin = $this->getAdmin();
        
        if (!$admin || !$admin->hasAccessToCenter($centerId)) {
            abort(403, 'ليس لديك صلاحية للوصول لهذه الجهة');
        }

        return $admin;
    }

    /**
     * ✅ التحقق من الوصول للفترة
     */
    protected function checkScheduleAccess(string $schedule)
    {
        $admin = $this->getAdmin();
        
        if (!$admin || !$admin->hasAccessToSchedule($schedule)) {
            abort(403, 'ليس لديك صلاحية للوصول لهذه الفترة');
        }

        return $admin;
    }

    // ==================== واجهة الطالب/الطالبة (بدون تغيير) ====================

    public function selectType()
    {
        return view('student.select-type');
    }

    public function create(Request $request)
    {
        $type = $request->query('type');
        $gender = $request->query('gender');
        
        $query = Center::where('status', 'active');
        
        if ($type) {
            $query->where('type', $type);
        }
        
        if ($gender) {
            $query->where('gender', $gender);
        }
        
        $centers = $query->get();
        
        $pageTitle = 'تسجيل جديد';
        if ($type == 'دار') {
            $pageTitle = 'التسجيل في دار تحفيظ';
        } elseif ($type == 'مركز') {
            $pageTitle = 'التسجيل في مركز إعداد المعلمات';
        } elseif ($type == 'برنامج') {
            $pageTitle = $gender == 'بنين' ? 'التسجيل في برنامج الرياحين (بنين)' : 'التسجيل في برنامج الرياحين (بنات)';
        }
        
        return view('student.create', compact('centers', 'type', 'gender', 'pageTitle'));
    }

    private function generateStudentNumber()
    {
        $year = date('Y');
        
        $lastStudent = Student::where('student_id', 'like', "STU-{$year}-%")
            ->orderBy('id', 'desc')
            ->first();
        
        if ($lastStudent && preg_match('/STU-\d{4}-(\d+)/', $lastStudent->student_id, $matches)) {
            $nextNumber = intval($matches[1]) + 1;
        } else {
            $nextNumber = 1;
        }
        
        return 'STU-' . $year . '-' . str_pad($nextNumber, 6, '0', STR_PAD_LEFT);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:50',
            'gender' => 'required|in:ذكر,أنثى',
            'national_id' => 'required|string|size:10|unique:students,national_id',
            'birthdate' => 'required|date|before:today',
            'email' => 'nullable|email|unique:students,email',
            'mobile' => 'required|regex:/^05[0-9]{8}$/',
            'address' => 'nullable|string|max:500',
            'guardian_name' => 'required|string|max:50',
            'guardian_mobile' => 'required|regex:/^05[0-9]{8}$/',
            'preferred_schedule' => 'required|in:صباحية,مسائية',
            'center_id' => 'required|exists:centers,id',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'notes' => 'nullable|string|max:1000',
        ], [
            'name.required' => 'الاسم مطلوب',
            'gender.required' => 'الجنس مطلوب',
            'national_id.required' => 'رقم الهوية مطلوب',
            'national_id.size' => 'رقم الهوية يجب أن يكون 10 أرقام',
            'national_id.unique' => 'رقم الهوية مسجل مسبقاً',
            'birthdate.required' => 'تاريخ الميلاد مطلوب',
            'email.email' => 'البريد الإلكتروني غير صحيح',
            'email.unique' => 'البريد الإلكتروني مسجل مسبقاً',
            'mobile.required' => 'رقم الجوال مطلوب',
            'mobile.regex' => 'رقم الجوال يجب أن يبدأ بـ 05',
            'guardian_name.required' => 'اسم ولي الأمر مطلوب',
            'guardian_mobile.required' => 'جوال ولي الأمر مطلوب',
            'guardian_mobile.regex' => 'جوال ولي الأمر يجب أن يبدأ بـ 05',
            'preferred_schedule.required' => 'الفترة مطلوبة',
            'center_id.required' => 'يرجى اختيار الجهة',
            'center_id.exists' => 'الجهة المختارة غير موجودة',
            'latitude.required' => 'يرجى تحديد الموقع على الخريطة',
            'longitude.required' => 'يرجى تحديد الموقع على الخريطة',
        ]);

        $center = Center::find($validated['center_id']);
        $studentNumber = $this->generateStudentNumber();

        $student = Student::create([
            'student_id' => $studentNumber,
            'name' => $validated['name'],
            'gender' => $validated['gender'],
            'national_id' => $validated['national_id'],
            'birthdate' => $validated['birthdate'],
            'email' => $validated['email'] ?? null,
            'mobile' => $validated['mobile'],
            'address' => $validated['address'] ?? null,
            'guardian_name' => $validated['guardian_name'],
            'guardian_mobile' => $validated['guardian_mobile'],
            'preferred_schedule' => $validated['preferred_schedule'],
            'center_id' => $validated['center_id'],
            'latitude' => $validated['latitude'],
            'longitude' => $validated['longitude'],
            'notes' => $validated['notes'] ?? null,
            'status' => 'pending',
            'total_required' => $center->transport_fee ?? 500,
        ]);

        return redirect()->route('student.success', $student->national_id);
    }

    public function success($nationalId)
    {
        $student = Student::where('national_id', $nationalId)->firstOrFail();
        return view('student.success', compact('student'));
    }

    public function showLoginForm()
    {
        if (session()->has('student_id')) {
            return redirect()->route('student.dashboard');
        }
        return view('student.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'national_id' => 'required|string|size:10',
        ], [
            'national_id.required' => 'رقم الهوية مطلوب',
            'national_id.size' => 'رقم الهوية يجب أن يكون 10 أرقام',
        ]);

        $student = Student::where('national_id', $request->national_id)->first();

        if (!$student) {
            return back()->withErrors([
                'login_error' => 'رقم الهوية غير مسجل في النظام'
            ])->withInput();
        }

        session([
            'student_id' => $student->id,
            'student_name' => $student->name,
            'student_number' => $student->student_id,
        ]);

        return redirect()->route('student.dashboard')
            ->with('success', 'مرحباً بك ' . $student->name);
    }

    public function dashboard()
    {
        $student = Student::with(['assignedBus', 'assignedBus.driver', 'center'])
            ->findOrFail(session('student_id'));
        
        return view('student.dashboard', compact('student'));
    }

    public function profile()
    {
        $student = Student::with(['assignedBus', 'assignedBus.driver', 'center'])
            ->findOrFail(session('student_id'));
        
        return view('student.profile', compact('student'));
    }

    public function payments()
    {
        $studentId = session('student_id');
        $student = Student::with('center')->find($studentId);

        if (!$student) {
            return redirect()->route('student.login');
        }

        $payments = Payment::where('student_id', $studentId)
                           ->orderBy('created_at', 'desc')
                           ->get();

        $totalFees = $payments->sum('amount');
        $paidAmount = $payments->where('status', 'approved')->sum('amount');
        $remainingAmount = $totalFees - $paidAmount;

        return view('student.payments', compact('payments', 'totalFees', 'paidAmount', 'remainingAmount', 'student'));
    }

    public function uploadReceipt(Request $request, Payment $payment)
    {
        $studentId = session('student_id');

        if (!$studentId) {
            return redirect()->route('student.login');
        }

        if ($payment->student_id != $studentId) {
            return back()->with('error', 'غير مصرح لك بهذا الإجراء');
        }

        if (!in_array($payment->status, ['awaiting_receipt', 'rejected'])) {
            return back()->with('error', 'لا يمكن رفع إيصال لهذه الدفعة');
        }

        $request->validate([
            'receipt_image' => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120',
        ], [
            'receipt_image.required' => 'صورة الإيصال مطلوبة',
            'receipt_image.mimes' => 'صيغة الملف غير مدعومة (JPG, PNG, PDF)',
            'receipt_image.max' => 'حجم الملف كبير جداً (الحد الأقصى 5MB)',
        ]);

        try {
            if ($payment->receipt_image) {
                Storage::disk('public')->delete($payment->receipt_image);
            }

            $path = $request->file('receipt_image')->store('receipts', 'public');

            $payment->receipt_image = $path;
            $payment->status = 'pending';
            $payment->save();

            return back()->with('success', 'تم رفع الإيصال بنجاح، سيتم مراجعته من قبل الإدارة');
        } catch (\Exception $e) {
            return back()->with('error', 'حدث خطأ أثناء رفع الإيصال');
        }
    }

    public function logout()
    {
        session()->forget(['student_id', 'student_name', 'student_number']);
        return redirect()->route('student.login')
            ->with('success', 'تم تسجيل الخروج بنجاح');
    }

    // ==================== واجهة الإدارة (مع الصلاحيات والفترات) ====================

    public function adminIndex(Request $request)
    {
        $admin = $this->checkPermission('students.view');
        $allowedCenterIds = $admin->getAllowedCenterIds();
        $allowedSchedules = $admin->getAllowedSchedules(); // ✅ الفترات المسموحة

        // ✅ تصفية حسب الجهات والفترات المسموحة
        $query = Student::with('center')
                       ->whereIn('center_id', $allowedCenterIds)
                       ->whereIn('preferred_schedule', $allowedSchedules);

        // فلترة حسب النوع
        if ($request->filled('type')) {
            $query->whereHas('center', function($q) use ($request) {
                $q->where('type', $request->type);
            });
        }

        // فلترة حسب الجنس
        if ($request->filled('gender')) {
            $query->where('gender', $request->gender);
        }

        // فلترة حسب المركز
        if ($request->filled('center_id') && in_array($request->center_id, $allowedCenterIds)) {
            $query->where('center_id', $request->center_id);
        }

        // فلترة حسب الحالة
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        // ✅ فلترة حسب الفترة (فقط من المسموحة)
        if ($request->filled('schedule') && in_array($request->schedule, $allowedSchedules)) {
            $query->where('preferred_schedule', $request->schedule);
        }

        // البحث
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('national_id', 'like', "%{$search}%")
                  ->orWhere('student_id', 'like', "%{$search}%")
                  ->orWhere('mobile', 'like', "%{$search}%");
            });
        }

        $students = $query->orderBy('created_at', 'desc')->paginate(15);
        
        $centers = Center::whereIn('id', $allowedCenterIds)
                        ->where('status', 'active')
                        ->pluck('center_name', 'id');
        
        $statuses = [
            'pending' => 'قيد المراجعة',
            'approved' => 'مقبول',
            'rejected' => 'مرفوض',
            'suspended' => 'موقوف',
        ];
        
        // ✅ فقط الفترات المسموحة في الفلتر
        $schedules = [];
        if (in_array('صباحية', $allowedSchedules)) {
            $schedules['صباحية'] = 'صباحية';
        }
        if (in_array('مسائية', $allowedSchedules)) {
            $schedules['مسائية'] = 'مسائية';
        }
        
        // ✅ إحصائيات الجهات والفترات المسموحة فقط
        $stats = [
            'total' => Student::whereIn('center_id', $allowedCenterIds)
                             ->whereIn('preferred_schedule', $allowedSchedules)->count(),
            'pending' => Student::whereIn('center_id', $allowedCenterIds)
                               ->whereIn('preferred_schedule', $allowedSchedules)
                               ->where('status', 'pending')->count(),
            'approved' => Student::whereIn('center_id', $allowedCenterIds)
                                ->whereIn('preferred_schedule', $allowedSchedules)
                                ->where('status', 'approved')->count(),
            'rejected' => Student::whereIn('center_id', $allowedCenterIds)
                                ->whereIn('preferred_schedule', $allowedSchedules)
                                ->where('status', 'rejected')->count(),
        ];

        return view('admin.students.index', compact('students', 'centers', 'statuses', 'schedules', 'stats'));
    }

    public function adminShow(Student $student)
    {
        $admin = $this->checkPermission('students.view');
        $this->checkCenterAccess($student->center_id);
        
        // ✅ تحقق من الفترة
        if (!$admin->hasAccessToSchedule($student->preferred_schedule)) {
            abort(403, 'ليس لديك صلاحية للوصول لهذه الفترة');
        }

        $student->load(['center', 'assignedBus', 'assignedBus.driver']);
        
        $allowedCenterIds = $admin->getAllowedCenterIds();
        $buses = Bus::where('status', 'active')
            ->whereHas('centers', function($q) use ($student) {
                $q->where('centers.id', $student->center_id);
            })
            ->withCount('students')
            ->get();

        return view('admin.students.show', compact('student', 'buses'));
    }

    public function adminCreate()
    {
        $admin = $this->checkPermission('students.create');
        $allowedCenterIds = $admin->getAllowedCenterIds();
        $allowedSchedules = $admin->getAllowedSchedules(); // ✅

        $centers = Center::whereIn('id', $allowedCenterIds)
                        ->where('status', 'active')
                        ->get();
        
        // ✅ مرر الفترات المسموحة للواجهة
        $schedules = $allowedSchedules;
                        
        return view('admin.students.create', compact('centers', 'schedules'));
    }

    public function adminStore(Request $request)
    {
        $admin = $this->checkPermission('students.create');
        
        if ($request->filled('center_id')) {
            $this->checkCenterAccess($request->center_id);
        }
        
        // ✅ تحقق من الفترة
        if ($request->filled('preferred_schedule') && !$admin->hasAccessToSchedule($request->preferred_schedule)) {
            return back()->with('error', 'ليس لديك صلاحية لإضافة طالبات لهذه الفترة');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'gender' => 'required|in:ذكر,أنثى',
            'national_id' => 'required|string|size:10|unique:students,national_id',
            'birthdate' => 'required|date|before:today',
            'email' => 'nullable|email|unique:students,email',
            'mobile' => 'required|regex:/^05[0-9]{8}$/',
            'address' => 'nullable|string|max:500',
            'guardian_name' => 'required|string|max:255',
            'guardian_mobile' => 'required|regex:/^05[0-9]{8}$/',
            'preferred_schedule' => 'required|in:صباحية,مسائية',
            'center_id' => 'required|exists:centers,id',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'status' => 'required|in:pending,approved,rejected,suspended',
            'notes' => 'nullable|string|max:1000',
        ]);

        $center = Center::find($validated['center_id']);
        $studentNumber = $this->generateStudentNumber();

        if (!$admin->hasPermission('students.approve') && $validated['status'] != 'pending') {
            $validated['status'] = 'pending';
        }

        Student::create([
            'student_id' => $studentNumber,
            'name' => $validated['name'],
            'gender' => $validated['gender'],
            'national_id' => $validated['national_id'],
            'birthdate' => $validated['birthdate'],
            'email' => $validated['email'] ?? null,
            'mobile' => $validated['mobile'],
            'address' => $validated['address'] ?? null,
            'guardian_name' => $validated['guardian_name'],
            'guardian_mobile' => $validated['guardian_mobile'],
            'preferred_schedule' => $validated['preferred_schedule'],
            'center_id' => $validated['center_id'],
            'latitude' => $validated['latitude'],
            'longitude' => $validated['longitude'],
            'status' => $validated['status'],
            'notes' => $validated['notes'] ?? null,
            'total_required' => $center->transport_fee ?? 500,
        ]);

        return redirect()->route('admin.students.index')
            ->with('success', 'تم إضافة الطالب/ة بنجاح');
    }

    public function adminEdit(Student $student)
    {
        $admin = $this->checkPermission('students.edit');
        $this->checkCenterAccess($student->center_id);
        
        // ✅ تحقق من الفترة
        if (!$admin->hasAccessToSchedule($student->preferred_schedule)) {
            abort(403, 'ليس لديك صلاحية للوصول لهذه الفترة');
        }

        $allowedCenterIds = $admin->getAllowedCenterIds();
        $allowedSchedules = $admin->getAllowedSchedules();

        $centers = Center::whereIn('id', $allowedCenterIds)
                        ->where('status', 'active')
                        ->pluck('center_name', 'id');

        $buses = Bus::whereHas('centers', function($q) use ($allowedCenterIds) {
            $q->whereIn('centers.id', $allowedCenterIds);
        })->where('status', 'active')->get();
        
        // ✅ الفترات المسموحة
        $schedules = [];
        if (in_array('صباحية', $allowedSchedules)) {
            $schedules['صباحية'] = 'صباحية';
        }
        if (in_array('مسائية', $allowedSchedules)) {
            $schedules['مسائية'] = 'مسائية';
        }
        
        $statuses = [
            'pending' => 'قيد المراجعة',
            'approved' => 'مقبول/ة',
            'rejected' => 'مرفوض/ة',
            'suspended' => 'معلق/ة',
        ];
        
        return view('admin.students.edit', compact('student', 'centers', 'buses', 'schedules', 'statuses'));
    }

    public function adminUpdate(Request $request, Student $student)
    {
        $admin = $this->checkPermission('students.edit');
        $this->checkCenterAccess($student->center_id);
        
        // ✅ تحقق من الفترة الحالية
        if (!$admin->hasAccessToSchedule($student->preferred_schedule)) {
            abort(403, 'ليس لديك صلاحية للوصول لهذه الفترة');
        }
        
        if ($request->filled('center_id') && $request->center_id != $student->center_id) {
            $this->checkCenterAccess($request->center_id);
        }
        
        // ✅ تحقق من الفترة الجديدة
        if ($request->filled('preferred_schedule') && !$admin->hasAccessToSchedule($request->preferred_schedule)) {
            return back()->with('error', 'ليس لديك صلاحية لنقل الطالبة لهذه الفترة');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'gender' => 'required|in:ذكر,أنثى',
            'national_id' => 'required|string|size:10|unique:students,national_id,' . $student->id,
            'email' => 'nullable|email|unique:students,email,' . $student->id,
            'mobile' => 'required|regex:/^05[0-9]{8}$/',
            'guardian_name' => 'required|string|max:255',
            'guardian_mobile' => 'required|regex:/^05[0-9]{8}$/',
            'preferred_schedule' => 'required|in:صباحية,مسائية',
            'center_id' => 'required|exists:centers,id',
            'status' => 'required|in:pending,approved,rejected,suspended',
            'birthdate' => 'nullable|date',
            'address' => 'nullable|string|max:500',
            'notes' => 'nullable|string|max:1000',
        ]);

        $center = Center::find($validated['center_id']);

        if (!$admin->hasPermission('students.approve')) {
            unset($validated['status']);
        }

        $student->update([
            'name' => $validated['name'],
            'gender' => $validated['gender'],
            'national_id' => $validated['national_id'],
            'email' => $validated['email'] ?? null,
            'mobile' => $validated['mobile'],
            'guardian_name' => $validated['guardian_name'],
            'guardian_mobile' => $validated['guardian_mobile'],
            'preferred_schedule' => $validated['preferred_schedule'],
            'center_id' => $validated['center_id'],
            'status' => $validated['status'] ?? $student->status,
            'birthdate' => $validated['birthdate'] ?? $student->birthdate,
            'address' => $validated['address'] ?? $student->address,
            'notes' => $validated['notes'] ?? $student->notes,
            'total_required' => $center->transport_fee ?? $student->total_required,
        ]);

        return redirect()->route('admin.students.show', $student)
            ->with('success', 'تم تحديث البيانات بنجاح');
    }

    public function adminDestroy(Student $student)
    {
        $admin = $this->checkPermission('students.delete');
        $this->checkCenterAccess($student->center_id);
        
        // ✅ تحقق من الفترة
        if (!$admin->hasAccessToSchedule($student->preferred_schedule)) {
            abort(403, 'ليس لديك صلاحية للوصول لهذه الفترة');
        }

        $student->delete();
        return redirect()->route('admin.students.index')
            ->with('success', 'تم حذف الطالب/ة بنجاح');
    }

    public function deleteAll()
    {
        $admin = $this->getAdmin();
        
        if (!$admin || !$admin->canDeleteAllStudents()) {
            return redirect()->route('admin.students.index')
                ->with('error', 'ليس لديك صلاحية لتنفيذ هذا الإجراء');
        }

        try {
            DB::beginTransaction();

            $count = Student::count();
            Payment::query()->delete();
            Bus::query()->update(['current_students' => 0]);
            Student::query()->delete();

            AdminActivity::create([
                'admin_id' => session('admin_id'),
                'action' => 'delete_all_students',
                'description' => 'حذف جميع الطلاب - العدد: ' . $count,
                'ip_address' => request()->ip(),
            ]);

            DB::commit();

            Log::warning('تم حذف جميع الطلاب', [
                'admin_id' => session('admin_id'),
                'admin_name' => session('admin_name'),
                'count' => $count,
                'ip' => request()->ip()
            ]);

            return redirect()->route('admin.students.index')
                ->with('success', 'تم حذف جميع الطلاب بنجاح (العدد: ' . $count . ')');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('خطأ في حذف جميع الطلاب', ['error' => $e->getMessage()]);
            
            return redirect()->route('admin.students.index')
                ->with('error', 'حدث خطأ أثناء الحذف: ' . $e->getMessage());
        }
    }

    public function approve(Student $student)
    {
        $admin = $this->checkPermission('students.approve');
        $this->checkCenterAccess($student->center_id);
        
        if (!$admin->hasAccessToSchedule($student->preferred_schedule)) {
            abort(403, 'ليس لديك صلاحية للوصول لهذه الفترة');
        }

        $student->status = 'approved';
        $student->save();

        return back()->with('success', 'تم قبول ' . $student->name . ' بنجاح');
    }

    public function reject(Request $request, Student $student)
    {
        $admin = $this->checkPermission('students.approve');
        $this->checkCenterAccess($student->center_id);
        
        if (!$admin->hasAccessToSchedule($student->preferred_schedule)) {
            abort(403, 'ليس لديك صلاحية للوصول لهذه الفترة');
        }

        $student->status = 'rejected';
        $student->notes = $request->rejection_reason ?? null;
        $student->save();

        return back()->with('success', 'تم رفض ' . $student->name);
    }

    public function suspend(Student $student)
    {
        $admin = $this->checkPermission('students.approve');
        $this->checkCenterAccess($student->center_id);
        
        if (!$admin->hasAccessToSchedule($student->preferred_schedule)) {
            abort(403, 'ليس لديك صلاحية للوصول لهذه الفترة');
        }

        $student->status = 'suspended';
        $student->save();

        return back()->with('success', 'تم تعليق ' . $student->name);
    }

    public function unsuspend(Student $student)
    {
        $admin = $this->checkPermission('students.approve');
        $this->checkCenterAccess($student->center_id);
        
        if (!$admin->hasAccessToSchedule($student->preferred_schedule)) {
            abort(403, 'ليس لديك صلاحية للوصول لهذه الفترة');
        }

        $student->status = 'approved';
        $student->save();

        return back()->with('success', 'تم إلغاء تعليق ' . $student->name);
    }

    public function assignBus(Request $request, Student $student)
    {
        $admin = $this->checkPermission('students.assign_bus');
        $this->checkCenterAccess($student->center_id);
        
        if (!$admin->hasAccessToSchedule($student->preferred_schedule)) {
            abort(403, 'ليس لديك صلاحية للوصول لهذه الفترة');
        }

        $request->validate([
            'bus_id' => 'required|exists:buses,id',
            'pickup_point' => 'nullable|string|max:255',
            'pickup_time' => 'nullable',
        ]);
        
        $student->assigned_bus_id = $request->bus_id;
        $student->pickup_point = $request->pickup_point;
        $student->pickup_time = $request->pickup_time;
        $student->bus_assigned_at = now();
        $student->save();
        
        return back()->with('success', 'تم تخصيص الباص لـ ' . $student->name . ' بنجاح');
    }

    public function unassignBus(Student $student)
    {
        $admin = $this->checkPermission('students.assign_bus');
        $this->checkCenterAccess($student->center_id);
        
        if (!$admin->hasAccessToSchedule($student->preferred_schedule)) {
            abort(403, 'ليس لديك صلاحية للوصول لهذه الفترة');
        }

        $student->assigned_bus_id = null;
        $student->pickup_point = null;
        $student->pickup_time = null;
        $student->bus_assigned_at = null;
        $student->save();

        return back()->with('success', 'تم إلغاء تخصيص الباص بنجاح');
    }

    public function updatePickup(Request $request, Student $student)
    {
        $admin = $this->checkPermission('students.assign_bus');
        $this->checkCenterAccess($student->center_id);
        
        if (!$admin->hasAccessToSchedule($student->preferred_schedule)) {
            abort(403, 'ليس لديك صلاحية للوصول لهذه الفترة');
        }

        $request->validate([
            'pickup_point' => 'nullable|string|max:255',
            'pickup_time' => 'nullable'
        ]);

        $student->pickup_point = $request->pickup_point;
        $student->pickup_time = $request->pickup_time;
        $student->save();

        return back()->with('success', 'تم تحديث نقطة الالتقاء بنجاح');
    }

    public function export()
    {
        $this->checkPermission('students.view');
        return back()->with('info', 'سيتم إضافة خاصية التصدير قريباً');
    }
}