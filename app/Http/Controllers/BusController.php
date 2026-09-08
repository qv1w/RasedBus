<?php

namespace App\Http\Controllers;

use App\Models\Bus;
use App\Models\Driver;
use App\Models\Student;
use App\Models\Center;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BusController extends Controller
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

    public function index()
    {
        // ✅ التحقق من الصلاحية
        $admin = $this->checkPermission('buses.view');
        $allowedCenterIds = $admin->getAllowedCenterIds();

        // ✅ تصفية حسب الجهات المسموحة
        $buses = Bus::with(['driver', 'centers'])
            ->whereHas('centers', function($q) use ($allowedCenterIds) {
                $q->whereIn('centers.id', $allowedCenterIds);
            })
            ->withCount('students')
            ->latest()
            ->paginate(20);

        return view('admin.buses.index', compact('buses'));
    }

    public function create()
    {
        // ✅ التحقق من الصلاحية
        $admin = $this->checkPermission('buses.create');
        $allowedCenterIds = $admin->getAllowedCenterIds();

        $drivers = Driver::where('status', 'active')->get();
        
        // ✅ فقط الجهات المسموحة
        $centers = Center::whereIn('id', $allowedCenterIds)
                        ->where('status', 'active')
                        ->get();

        return view('admin.buses.create', compact('drivers', 'centers'));
    }

    public function store(Request $request)
    {
        // ✅ التحقق من الصلاحية
        $admin = $this->checkPermission('buses.create');
        $allowedCenterIds = $admin->getAllowedCenterIds();

        $validated = $request->validate([
            'number'        => 'required|unique:buses',
            'plate_number'  => 'required|unique:buses',
            'model'         => 'nullable|string',
            'capacity'      => 'required|integer|min:1',
            'center_ids'    => 'required|array|min:1',
            'center_ids.*'  => 'exists:centers,id',
            'schedules'     => 'required|array',
            'schedules.*'   => 'in:morning,evening,both',
            'capacities'    => 'required|array',
            'capacities.*'  => 'integer|min:1',
            'driver_id'     => 'nullable|exists:drivers,id',
            'status'        => 'nullable|in:active,inactive,maintenance',
            'notes'         => 'nullable|string',
        ]);

        // ✅ تأكد أن الجهات المختارة ضمن المسموح
        $selectedCenters = array_intersect($validated['center_ids'], $allowedCenterIds);
        if (empty($selectedCenters)) {
            return back()->with('error', 'يجب اختيار جهة واحدة على الأقل من الجهات المسموح بها')->withInput();
        }

        $bus = Bus::create([
            'number'       => $validated['number'],
            'plate_number' => $validated['plate_number'],
            'model'        => $validated['model'] ?? null,
            'capacity'     => $validated['capacity'],
            'driver_id'    => $validated['driver_id'] ?? null,
            'status'       => $validated['status'] ?? 'active',
            'notes'        => $validated['notes'] ?? null,
            'center_id'    => $selectedCenters[0],
        ]);

        foreach ($selectedCenters as $centerId) {
            $bus->centers()->attach($centerId, [
                'schedule' => $validated['schedules'][$centerId] ?? 'both',
                'capacity' => $validated['capacities'][$centerId] ?? $validated['capacity'],
                'current_students' => 0,
            ]);
        }

        return redirect()
            ->route('admin.buses.index')
            ->with('success', 'تم إضافة الباص بنجاح');
    }

    public function show(Bus $bus)
    {
        // ✅ التحقق من الصلاحية
        $admin = $this->checkPermission('buses.view');
        $allowedCenterIds = $admin->getAllowedCenterIds();

        // ✅ تأكد أن الباص يخدم جهة مسموح بها
        $hasCenterAccess = $bus->centers()->whereIn('centers.id', $allowedCenterIds)->exists();
        if (!$hasCenterAccess) {
            abort(403, 'ليس لديك صلاحية للوصول لهذا الباص');
        }

        $bus->load(['driver', 'centers', 'students' => function($q) use ($allowedCenterIds) {
            $q->whereIn('center_id', $allowedCenterIds);
        }, 'students.center']);
        
        return view('admin.buses.show', compact('bus'));
    }

    public function edit(Bus $bus)
    {
        // ✅ التحقق من الصلاحية
        $admin = $this->checkPermission('buses.edit');
        $allowedCenterIds = $admin->getAllowedCenterIds();

        // ✅ تأكد أن الباص يخدم جهة مسموح بها
        $hasCenterAccess = $bus->centers()->whereIn('centers.id', $allowedCenterIds)->exists();
        if (!$hasCenterAccess) {
            abort(403, 'ليس لديك صلاحية للوصول لهذا الباص');
        }

        $bus->load('centers');
        
        $drivers = Driver::where('status', 'active')
            ->orWhere('id', $bus->driver_id)
            ->get();

        // ✅ فقط الجهات المسموحة
        $centers = Center::whereIn('id', $allowedCenterIds)
                        ->where('status', 'active')
                        ->get();
        
        $selectedCenters = [];
        foreach ($bus->centers as $center) {
            $selectedCenters[$center->id] = [
                'schedule' => $center->pivot->schedule,
                'capacity' => $center->pivot->capacity,
                'current_students' => $center->pivot->current_students,
            ];
        }

        return view('admin.buses.edit', compact('bus', 'drivers', 'centers', 'selectedCenters'));
    }

    public function update(Request $request, Bus $bus)
    {
        // ✅ التحقق من الصلاحية
        $admin = $this->checkPermission('buses.edit');
        $allowedCenterIds = $admin->getAllowedCenterIds();

        // ✅ تأكد أن الباص يخدم جهة مسموح بها
        $hasCenterAccess = $bus->centers()->whereIn('centers.id', $allowedCenterIds)->exists();
        if (!$hasCenterAccess) {
            abort(403, 'ليس لديك صلاحية للوصول لهذا الباص');
        }

        $validated = $request->validate([
            'number'        => 'required|unique:buses,number,' . $bus->id,
            'plate_number'  => 'required|unique:buses,plate_number,' . $bus->id,
            'model'         => 'nullable|string',
            'capacity'      => 'required|integer|min:1',
            'status'        => 'required|in:active,inactive,maintenance',
            'center_ids'    => 'required|array|min:1',
            'center_ids.*'  => 'exists:centers,id',
            'schedules'     => 'required|array',
            'schedules.*'   => 'in:morning,evening,both',
            'capacities'    => 'required|array',
            'capacities.*'  => 'integer|min:1',
            'driver_id'     => 'nullable|exists:drivers,id',
            'notes'         => 'nullable|string',
        ]);

        // ✅ تأكد أن الجهات المختارة ضمن المسموح
        $selectedCenters = array_intersect($validated['center_ids'], $allowedCenterIds);
        if (empty($selectedCenters)) {
            return back()->with('error', 'يجب اختيار جهة واحدة على الأقل من الجهات المسموح بها')->withInput();
        }

        // التحقق من السعة
        foreach ($selectedCenters as $centerId) {
            $currentStudents = $bus->getStudentsCountForCenter($centerId);
            $newCapacity = $validated['capacities'][$centerId] ?? $validated['capacity'];
            
            if ($newCapacity < $currentStudents) {
                return back()->withErrors([
                    'capacities' => "لا يمكن تقليل سعة الجهة لأقل من عدد الطالبات الحاليات ({$currentStudents})"
                ])->withInput();
            }
        }

        $bus->update([
            'number'       => $validated['number'],
            'plate_number' => $validated['plate_number'],
            'model'        => $validated['model'] ?? null,
            'capacity'     => $validated['capacity'],
            'driver_id'    => $validated['driver_id'] ?? null,
            'status'       => $validated['status'],
            'notes'        => $validated['notes'] ?? null,
            'center_id'    => $selectedCenters[0],
        ]);

        // ✅ تحديث الجهات - احتفظ بالجهات خارج صلاحياته
        $otherCenters = $bus->centers()
                           ->whereNotIn('centers.id', $allowedCenterIds)
                           ->get();

        $syncData = [];
        
        // الجهات المختارة من المسموحة
        foreach ($selectedCenters as $centerId) {
            $currentStudents = $bus->getStudentsCountForCenter($centerId);
            $syncData[$centerId] = [
                'schedule' => $validated['schedules'][$centerId] ?? 'both',
                'capacity' => $validated['capacities'][$centerId] ?? $validated['capacity'],
                'current_students' => $currentStudents,
            ];
        }
        
        // ✅ أضف الجهات خارج صلاحياته كما هي
        foreach ($otherCenters as $center) {
            $syncData[$center->id] = [
                'schedule' => $center->pivot->schedule,
                'capacity' => $center->pivot->capacity,
                'current_students' => $center->pivot->current_students,
            ];
        }
        
        $bus->centers()->sync($syncData);

        return redirect()
            ->route('admin.buses.index')
            ->with('success', 'تم تحديث الباص بنجاح');
    }

    public function destroy(Bus $bus)
    {
        // ✅ التحقق من الصلاحية
        $admin = $this->checkPermission('buses.delete');
        $allowedCenterIds = $admin->getAllowedCenterIds();

        // ✅ تأكد أن الباص يخدم فقط جهات ضمن صلاحياته
        $otherCentersCount = $bus->centers()
                                ->whereNotIn('centers.id', $allowedCenterIds)
                                ->count();
        
        if ($otherCentersCount > 0) {
            return back()->with('error', 'لا يمكن حذف هذا الباص لأنه يخدم جهات أخرى خارج صلاحياتك');
        }

        if ($bus->students()->exists()) {
            return back()->with('error', 'لا يمكن حذف الباص لوجود طالبات مخصصات له');
        }

        $bus->centers()->detach();
        $bus->delete();

        return redirect()
            ->route('admin.buses.index')
            ->with('success', 'تم حذف الباص بنجاح');
    }

    public function showAssignStudents(Bus $bus)
    {
        // ✅ التحقق من الصلاحية
        $admin = $this->checkPermission('buses.assign_students');
        $allowedCenterIds = $admin->getAllowedCenterIds();

        // ✅ تأكد أن الباص يخدم جهة مسموح بها
        $hasCenterAccess = $bus->centers()->whereIn('centers.id', $allowedCenterIds)->exists();
        if (!$hasCenterAccess) {
            abort(403, 'ليس لديك صلاحية للوصول لهذا الباص');
        }

        $bus->load('centers');
        
        // ✅ فقط الجهات المسموحة المرتبطة بالباص
        $centerIds = $bus->centers->pluck('id')->intersect($allowedCenterIds)->toArray();
        
        $students = Student::where('status', 'approved')
            ->whereIn('center_id', $centerIds)
            ->whereNull('assigned_bus_id')
            ->with('center')
            ->get()
            ->groupBy('center_id');

        return view('admin.buses.assign-students', compact('bus', 'students'));
    }

    public function storeStudents(Request $request, Bus $bus)
    {
        // ✅ التحقق من الصلاحية
        $admin = $this->checkPermission('buses.assign_students');
        $allowedCenterIds = $admin->getAllowedCenterIds();

        $request->validate([
            'student_ids'   => 'required|array',
            'student_ids.*' => 'exists:students,id',
        ]);

        $added = 0;
        $skipped = 0;

        foreach ($request->student_ids as $studentId) {
            $student = Student::find($studentId);
            
            // ✅ تأكد أن الطالب من جهة مسموح بها
            if (!in_array($student->center_id, $allowedCenterIds)) {
                $skipped++;
                continue;
            }
            
            if ($bus->addStudent($student)) {
                $added++;
            } else {
                $skipped++;
            }
        }

        $message = "تم تخصيص {$added} طالبة للباص";
        if ($skipped > 0) {
            $message .= " (تم تخطي {$skipped} لامتلاء السعة أو عدم الصلاحية)";
        }

        return redirect()
            ->route('admin.buses.show', $bus)
            ->with('success', $message);
    }

    public function removeStudent(Bus $bus, Student $student)
    {
        // ✅ التحقق من الصلاحية
        $admin = $this->checkPermission('buses.assign_students');
        $allowedCenterIds = $admin->getAllowedCenterIds();

        // ✅ تأكد أن الطالب من جهة مسموح بها
        if (!in_array($student->center_id, $allowedCenterIds)) {
            return back()->with('error', 'ليس لديك صلاحية لإزالة هذه الطالبة');
        }

        $bus->removeStudent($student);

        return back()->with('success', 'تم إزالة الطالبة من الباص');
    }

    public function removeAllStudents(Bus $bus)
    {
        // ✅ التحقق من الصلاحية
        $admin = $this->checkPermission('buses.assign_students');
        $allowedCenterIds = $admin->getAllowedCenterIds();

        $removed = 0;
        foreach ($bus->students as $student) {
            // ✅ فقط الطالبات من جهات مسموح بها
            if (in_array($student->center_id, $allowedCenterIds)) {
                $bus->removeStudent($student);
                $removed++;
            }
        }

        return back()->with('success', "تم إزالة {$removed} طالبة من الباص");
    }

    // API: الحصول على معلومات جهة معينة للباص
    public function getCenterInfo(Bus $bus, Center $center)
    {
        if (!$bus->servesCenter($center->id)) {
            return response()->json(['error' => 'الباص لا يخدم هذه الجهة'], 404);
        }

        return response()->json([
            'capacity' => $bus->getCapacityForCenter($center->id),
            'current_students' => $bus->getStudentsCountForCenter($center->id),
            'available_seats' => $bus->getAvailableSeatsForCenter($center->id),
            'is_full' => $bus->isFullForCenter($center->id),
        ]);
    }
}