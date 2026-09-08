<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use App\Models\Center;
use App\Models\Admin;
use Illuminate\Http\Request;

class DriverController extends Controller
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

    public function index(Request $request)
    {
        // ✅ التحقق من الصلاحية
        $this->checkPermission('drivers.view');

        try {
            $query = Driver::with(['buses', 'activeBus', 'center']);

            if ($request->filled('status')) {
                $query->where('status', $request->status);
            }

            if ($request->filled('center_id')) {
                $query->where('center_id', $request->center_id);
            }

            if ($request->filled('search')) {
                $query->search($request->search);
            }

            $drivers = $query->latest()->paginate(20);
            $centers = Center::where('status', 'active')->get();

            return view('admin.drivers.index', compact('drivers', 'centers'));

        } catch (\Exception $e) {
            \Log::error('Drivers Index Error: ' . $e->getMessage());
            return back()->with('error', 'حدث خطأ في تحميل قائمة السائقين');
        }
    }

    public function create()
    {
        // ✅ التحقق من الصلاحية
        $this->checkPermission('drivers.create');

        $centers = Center::where('status', 'active')
            ->pluck('center_name', 'id');

        return view('admin.drivers.create', compact('centers'));
    }

    public function store(Request $request)
    {
        // ✅ التحقق من الصلاحية
        $this->checkPermission('drivers.create');

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'mobile' => 'required|string|max:20',
            'license_number' => 'nullable|string|max:50|unique:drivers,license_number',
            'license_type' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string|max:500',
            'experience_years' => 'nullable|integer|min:0|max:50',
            'hire_date' => 'nullable|date',
            'center_id' => 'nullable|exists:centers,id', 
            'status' => 'required|in:active,inactive,on_leave',
            'salary' => 'nullable|numeric|min:0',
            'emergency_contact' => 'nullable|string|max:255',
            'emergency_phone' => 'nullable|string|max:20',
            'notes' => 'nullable|string|max:1000',
        ], [
            'name.required' => 'اسم السائق مطلوب',
            'mobile.required' => 'رقم الجوال مطلوب',
            'license_number.unique' => 'رقم الرخصة مستخدم مسبقاً',
            'center_id.exists' => 'المركز المحدد غير موجود',
        ]);

        try {
            $driver = Driver::create($validated);

            return redirect()
                ->route('admin.drivers.index')
                ->with('success', 'تم إضافة السائق بنجاح - رقم السائق: ' . $driver->driver_id);

        } catch (\Exception $e) {
            \Log::error('Driver Store Error: ' . $e->getMessage());
            return back()->with('error', 'حدث خطأ أثناء إضافة السائق')->withInput();
        }
    }

    public function show(Driver $driver)
    {
        // ✅ التحقق من الصلاحية
        $this->checkPermission('drivers.view');

        try {
            $driver->load(['buses', 'activeBus', 'center']);

            $stats = [
                'total_buses' => $driver->buses->count(),
                'active_buses' => $driver->buses->where('status', 'active')->count(),
                'has_active_bus' => $driver->activeBus ? true : false,
                'years_of_service' => $driver->hire_date ?
                    now()->diffInYears($driver->hire_date) : null
            ];

            return view('admin.drivers.show', compact('driver', 'stats'));

        } catch (\Exception $e) {
            \Log::error('Driver Show Error: ' . $e->getMessage());
            return redirect()->route('admin.drivers.index')
                ->with('error', 'حدث خطأ في عرض تفاصيل السائق');
        }
    }

    public function edit(Driver $driver)
    {
        // ✅ التحقق من الصلاحية
        $this->checkPermission('drivers.edit');

        $centers = Center::where('status', 'active')
            ->pluck('center_name', 'id');

        return view('admin.drivers.edit', compact('driver', 'centers'));
    }

    public function update(Request $request, Driver $driver)
    {
        // ✅ التحقق من الصلاحية
        $this->checkPermission('drivers.edit');

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'mobile' => 'required|string|max:20',
            'license_number' => 'nullable|string|max:50|unique:drivers,license_number,' . $driver->id,
            'license_type' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string|max:500',
            'experience_years' => 'nullable|integer|min:0|max:50',
            'hire_date' => 'nullable|date',
            'center_id' => 'nullable|exists:centers,id', 
            'status' => 'required|in:active,inactive,on_leave',
            'salary' => 'nullable|numeric|min:0',
            'emergency_contact' => 'nullable|string|max:255',
            'emergency_phone' => 'nullable|string|max:20',
            'notes' => 'nullable|string|max:1000',
        ]);

        try {
            $driver->update($validated);

            return redirect()
                ->route('admin.drivers.show', $driver)
                ->with('success', 'تم تحديث بيانات السائق بنجاح');

        } catch (\Exception $e) {
            \Log::error('Driver Update Error: ' . $e->getMessage());
            return back()->with('error', 'حدث خطأ أثناء تحديث البيانات')->withInput();
        }
    }

    public function destroy(Driver $driver)
    {
        // ✅ التحقق من الصلاحية
        $this->checkPermission('drivers.delete');

        try {
            if ($driver->buses()->exists()) {
                return response()->json([
                    'success' => false,
                    'message' => 'لا يمكن حذف السائق لأنه مرتبط بباصات'
                ], 400);
            }

            $driver->delete();

            return response()->json([
                'success' => true,
                'message' => 'تم حذف السائق بنجاح'
            ]);

        } catch (\Exception $e) {
            \Log::error('Driver Delete Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ أثناء الحذف'
            ], 400);
        }
    }

    public function updateStatus(Request $request, Driver $driver)
    {
        // ✅ التحقق من الصلاحية
        $this->checkPermission('drivers.edit');

        $request->validate([
            'status' => 'required|in:active,inactive,on_leave'
        ]);

        try {
            $driver->update(['status' => $request->status]);

            return response()->json([
                'success' => true,
                'message' => 'تم تحديث حالة السائق بنجاح'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ أثناء تحديث الحالة'
            ], 400);
        }
    }

    /**
     * جلب السائقين المتاحين لمركز معين (للـ AJAX)
     */
    public function availableForCenter(Request $request, $centerId)
    {
        try {
            $currentDriverId = $request->get('current');

            $query = Driver::where('status', 'active')
                ->where(function ($q) use ($centerId) {
                    $q->where('center_id', $centerId)
                      ->orWhereNull('center_id');
                });

            if ($currentDriverId) {
                $query->orWhere('id', $currentDriverId);
            }

            $drivers = $query->get(['id', 'name', 'mobile', 'driver_id', 'center_id']);

            return response()->json([
                'success' => true,
                'drivers' => $drivers
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'حدث خطأ في تحميل السائقين المتاحين'
            ], 500);
        }
    }
}