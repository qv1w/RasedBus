<?php

namespace App\Http\Controllers;

use App\Models\Center;
use App\Models\Admin;
use App\Models\AdminActivity;
use Illuminate\Http\Request;

class CenterController extends Controller
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

    // ==================== الدوال الأساسية ====================
    
    /**
     * عرض قائمة الجهات مع الفلترة
     */
    public function index(Request $request)
    {
        // ✅ التحقق من الصلاحية
        $admin = $this->checkPermission('centers.view');
        $allowedCenterIds = $admin->getAllowedCenterIds();

        // ✅ تصفية حسب الجهات المسموحة
        $query = Center::whereIn('id', $allowedCenterIds);
        
        // فلترة حسب النوع
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }
        
        // فلترة حسب الحالة
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        // فلترة حسب الجنس
        if ($request->filled('gender')) {
            $query->where('gender', $request->gender);
        }
        
        // البحث
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('center_name', 'like', "%{$search}%")
                  ->orWhere('address', 'like', "%{$search}%");
            });
        }
        
        $centers = $query->orderBy('center_name')->paginate(15);
        
        return view('admin.centers.index', compact('centers'));
    }

    /**
     * عرض صفحة إضافة جهة جديدة
     * (فقط developer و super_admin يقدرون يضيفون جهات)
     */
    public function create(Request $request)
    {
        $admin = $this->getAdmin();
        
        // ✅ فقط المطور والمدير العام يقدرون يضيفون جهات
        if (!$admin || !$admin->isSuper()) {
            return redirect('admin/centers')
                ->with('error', 'ليس لديك صلاحية لإضافة جهات جديدة. هذه العملية متاحة للمدير العام فقط.');
        }
        
        return view('admin.centers.create');
    }

    /**
     * حفظ جهة جديدة
     */
    public function store(Request $request)
    {
        $admin = $this->getAdmin();
        
        // ✅ فقط المطور والمدير العام
        if (!$admin || !$admin->isSuper()) {
            return redirect('admin/centers')
                ->with('error', 'ليس لديك صلاحية لإضافة جهات جديدة');
        }
        
        $validated = $request->validate([
            'center_name' => 'required|string|max:255|unique:centers,center_name',
            'type' => 'required|in:دار,مركز,برنامج',
            'gender' => 'required|in:بنات,بنين',
            'status' => 'required|in:active,inactive',
            'address' => 'nullable|string|max:500',
            'transport_fee' => 'nullable|numeric|min:0',
            'morning_available' => 'nullable',
            'morning_start' => 'nullable',
            'morning_end' => 'nullable',
            'evening_available' => 'nullable',
            'evening_start' => 'nullable',
            'evening_end' => 'nullable',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'coverage_area' => 'nullable|string',
            'morning_coverage_area' => 'nullable|string',
            'evening_coverage_area' => 'nullable|string',
            'notes' => 'nullable|string|max:1000',
        ]);

        // تحويل النطاقات من JSON إلى Array
        if (!empty($validated['coverage_area'])) {
            $validated['coverage_area'] = json_decode($validated['coverage_area'], true);
        }
        if (!empty($validated['morning_coverage_area'])) {
            $validated['morning_coverage_area'] = json_decode($validated['morning_coverage_area'], true);
        }
        if (!empty($validated['evening_coverage_area'])) {
            $validated['evening_coverage_area'] = json_decode($validated['evening_coverage_area'], true);
        }

        // تحويل القيم البولية
        $validated['morning_available'] = $request->has('morning_available') ? 1 : 0;
        $validated['evening_available'] = $request->has('evening_available') ? 1 : 0;

        $center = Center::create($validated);
        
        // تسجيل النشاط
        if (class_exists(AdminActivity::class)) {
            AdminActivity::log('add_center', 'إضافة جهة جديدة: ' . $center->center_name);
        }

        return redirect('admin/centers?type=' . urlencode($center->type))
            ->with('success', 'تم إضافة ' . $center->center_name . ' بنجاح');
    }

    /**
     * عرض تفاصيل جهة
     */
    public function show(Center $center)
    {
        // ✅ التحقق من الصلاحية والجهة
        $admin = $this->checkPermission('centers.view');
        
        if (!$admin->hasAccessToCenter($center->id)) {
            abort(403, 'ليس لديك صلاحية للوصول لهذه الجهة');
        }

        $center->load(['students', 'buses']);
        return view('admin.centers.show', compact('center'));
    }

    /**
     * عرض صفحة تعديل جهة
     */
    public function edit(Center $center)
    {
        // ✅ التحقق من الصلاحية
        $admin = $this->checkPermission('centers.edit');
        
        if (!$admin->hasAccessToCenter($center->id)) {
            abort(403, 'ليس لديك صلاحية للوصول لهذه الجهة');
        }
        
        return view('admin.centers.edit', compact('center'));
    }

    /**
     * تحديث بيانات جهة
     */
    public function update(Request $request, Center $center)
    {
        // ✅ التحقق من الصلاحية
        $admin = $this->checkPermission('centers.edit');
        
        if (!$admin->hasAccessToCenter($center->id)) {
            abort(403, 'ليس لديك صلاحية للوصول لهذه الجهة');
        }
        
        $validated = $request->validate([
            'center_name' => 'required|string|max:255|unique:centers,center_name,' . $center->id,
            'type' => 'required|in:دار,مركز,برنامج',
            'gender' => 'required|in:بنات,بنين',
            'status' => 'required|in:active,inactive',
            'address' => 'nullable|string|max:500',
            'transport_fee' => 'nullable|numeric|min:0',
            'morning_available' => 'nullable',
            'morning_start' => 'nullable',
            'morning_end' => 'nullable',
            'evening_available' => 'nullable',
            'evening_start' => 'nullable',
            'evening_end' => 'nullable',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'coverage_area' => 'nullable|string',
            'morning_coverage_area' => 'nullable|string',
            'evening_coverage_area' => 'nullable|string',
            'notes' => 'nullable|string|max:1000',
        ]);

        // تحويل النطاقات من JSON إلى Array
        if (!empty($validated['coverage_area'])) {
            $decoded = json_decode($validated['coverage_area'], true);
            $validated['coverage_area'] = $decoded ?: null;
        } else {
            $validated['coverage_area'] = null;
        }
        
        if (!empty($validated['morning_coverage_area'])) {
            $decoded = json_decode($validated['morning_coverage_area'], true);
            $validated['morning_coverage_area'] = $decoded ?: null;
        } else {
            $validated['morning_coverage_area'] = null;
        }
        
        if (!empty($validated['evening_coverage_area'])) {
            $decoded = json_decode($validated['evening_coverage_area'], true);
            $validated['evening_coverage_area'] = $decoded ?: null;
        } else {
            $validated['evening_coverage_area'] = null;
        }

        // تحويل القيم البولية
        $validated['morning_available'] = $request->has('morning_available') ? 1 : 0;
        $validated['evening_available'] = $request->has('evening_available') ? 1 : 0;

        $center->update($validated);
        
        // تسجيل النشاط
        if (class_exists(AdminActivity::class)) {
            AdminActivity::log('update_center', 'تحديث جهة: ' . $center->center_name);
        }

        return redirect('admin/centers?type=' . urlencode($center->type))
            ->with('success', 'تم تحديث ' . $center->center_name . ' بنجاح');
    }

    /**
     * تبديل حالة الجهة
     */
    public function toggleStatus(Center $center)
    {
        // ✅ التحقق من الصلاحية
        $admin = $this->checkPermission('centers.edit');
        
        if (!$admin->hasAccessToCenter($center->id)) {
            return back()->with('error', 'ليس لديك صلاحية للوصول لهذه الجهة');
        }
        
        $center->status = $center->status === 'active' ? 'inactive' : 'active';
        $center->save();

        $statusText = $center->status === 'active' ? 'تفعيل' : 'إيقاف';
        
        // تسجيل النشاط
        if (class_exists(AdminActivity::class)) {
            AdminActivity::log('toggle_center_status', $statusText . ' جهة: ' . $center->center_name);
        }
        
        return back()->with('success', "تم {$statusText} {$center->center_name}");
    }

    /**
     * حذف جهة (فقط developer و super_admin)
     */
    public function destroy(Center $center)
    {
        $admin = $this->getAdmin();
        
        // ✅ فقط المطور والمدير العام يقدرون يحذفون
        if (!$admin || !$admin->isSuper()) {
            return redirect('admin/centers')
                ->with('error', 'ليس لديك صلاحية لحذف الجهات. هذه العملية متاحة للمدير العام فقط.');
        }
        
        // التحقق من عدم وجود طلاب
        if ($center->students()->count() > 0) {
            return back()->with('error', 'لا يمكن حذف الجهة لوجود ' . $center->students()->count() . ' طالب/ة مسجل/ة. يجب نقل أو حذف الطلاب أولاً.');
        }
        
        // التحقق من الباصات
        if ($center->buses()->count() > 0) {
            return back()->with('error', 'لا يمكن حذف الجهة لوجود ' . $center->buses()->count() . ' باص مرتبط. يجب نقل أو حذف الباصات أولاً.');
        }
        
        $name = $center->center_name;
        $type = $center->type;
        
        // تسجيل النشاط قبل الحذف
        if (class_exists(AdminActivity::class)) {
            AdminActivity::log('delete_center', 'حذف جهة: ' . $name . ' (نوع: ' . $type . ')');
        }
        
        $center->delete();

        return redirect('admin/centers')
            ->with('success', "تم حذف {$name} بنجاح");
    }
    
    /**
     * عرض طلاب الجهة
     */
    public function students(Center $center)
    {
        // ✅ التحقق من الصلاحية
        $admin = $this->checkPermission('centers.view');
        
        if (!$admin->hasAccessToCenter($center->id)) {
            abort(403, 'ليس لديك صلاحية للوصول لهذه الجهة');
        }

        $students = $center->students()->paginate(20);
        return view('admin.centers.students', compact('center', 'students'));
    }
    
    /**
     * عرض باصات الجهة
     */
    public function buses(Center $center)
    {
        // ✅ التحقق من الصلاحية
        $admin = $this->checkPermission('centers.view');
        
        if (!$admin->hasAccessToCenter($center->id)) {
            abort(403, 'ليس لديك صلاحية للوصول لهذه الجهة');
        }

        $buses = $center->buses()->paginate(20);
        return view('admin.centers.buses', compact('center', 'buses'));
    }
    
    /**
     * إحصائيات الجهة
     */
    public function statistics(Center $center)
    {
        // ✅ التحقق من الصلاحية
        $admin = $this->checkPermission('centers.view');
        
        if (!$admin->hasAccessToCenter($center->id)) {
            abort(403, 'ليس لديك صلاحية للوصول لهذه الجهة');
        }

        $stats = [
            'total_students' => $center->students()->count(),
            'approved_students' => $center->students()->where('status', 'approved')->count(),
            'pending_students' => $center->students()->where('status', 'pending')->count(),
            'total_buses' => $center->buses()->count(),
            'active_buses' => $center->buses()->where('status', 'active')->count(),
        ];
        
        return view('admin.centers.statistics', compact('center', 'stats'));
    }
    
    /**
     * تحديث أعداد الجهة
     */
    public function updateCounts(Center $center)
    {
        // ✅ التحقق من الصلاحية
        $admin = $this->checkPermission('centers.edit');
        
        if (!$admin->hasAccessToCenter($center->id)) {
            return back()->with('error', 'ليس لديك صلاحية للوصول لهذه الجهة');
        }

        $center->update([
            'current_students' => $center->students()->where('status', 'approved')->count(),
            'bus_count' => $center->buses()->where('status', 'active')->count(),
        ]);
        
        return back()->with('success', 'تم تحديث الأعداد');
    }
}