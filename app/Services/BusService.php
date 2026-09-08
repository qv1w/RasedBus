<?php

namespace App\Services;

use App\Models\Bus;
use App\Models\Driver;
use App\Models\Center;
use App\Models\Student;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;

class BusService
{
    /**
     * إنشاء باص جديد
     */
    public function create(array $data): Bus
    {
        return DB::transaction(function () use ($data) {
            // التحقق من توفر السائق
            if (isset($data['driver_id'])) {
                $this->validateDriverAvailability($data['driver_id']);
            }

            $bus = Bus::create([
                'number' => $data['number'],
                'plate_number' => $data['plate_number'],
                'model' => $data['model'],
                'capacity' => $data['capacity'],
                'center_id' => $data['center_id'],
                'driver_id' => $data['driver_id'] ?? null,
                'status' => $data['status'],
                'current_students' => 0,
                'notes' => $data['notes'] ?? null
            ]);

            // تحديث عداد الباصات في المركز
            $this->updateCenterBusCount($data['center_id']);

            Log::info('تم إنشاء باص جديد', [
                'bus_id' => $bus->id,
                'number' => $bus->number,
                'admin_id' => session('admin_id')
            ]);

            return $bus;
        });
    }

    /**
     * تحديث بيانات باص
     */
    public function update(Bus $bus, array $data): Bus
    {
        return DB::transaction(function () use ($bus, $data) {
            $oldCenter = $bus->center_id;

            // التحقق من توفر السائق الجديد
            if (isset($data['driver_id']) && $data['driver_id'] != $bus->driver_id) {
                $this->validateDriverAvailability($data['driver_id']);
            }

            $bus->update($data);

            // تحديث عداد الباصات في المراكز
            if ($oldCenter !== $data['center_id']) {
                $this->updateCenterBusCount($oldCenter);
                $this->updateCenterBusCount($data['center_id']);
            }

            Log::info('تم تحديث باص', [
                'bus_id' => $bus->id,
                'changes' => $bus->getChanges(),
                'admin_id' => session('admin_id')
            ]);

            return $bus->fresh();
        });
    }

    /**
     * حذف باص
     */
    public function delete(Bus $bus): bool
    {
        if ($bus->current_students > 0) {
            throw new Exception('لا يمكن حذف الباص - يوجد طالبات محجوزات');
        }

        return DB::transaction(function () use ($bus) {
            $centerName = $bus->center_id;
            $busNumber = $bus->number;
            
            $bus->delete();

            $this->updateCenterBusCount($centerName);

            Log::info('تم حذف باص', [
                'bus_number' => $busNumber,
                'admin_id' => session('admin_id')
            ]);

            return true;
        });
    }

    /**
     * تحديث حالة باص
     */
    public function updateStatus(Bus $bus, string $status): Bus
    {
        if ($status !== 'active' && $bus->current_students > 0) {
            throw new Exception("لا يمكن تغيير حالة الباص - يوجد {$bus->current_students} طالب محجوز");
        }

        $bus->update(['status' => $status]);

        Log::info('تم تحديث حالة باص', [
            'bus_id' => $bus->id,
            'new_status' => $status,
            'admin_id' => session('admin_id')
        ]);

        return $bus;
    }

    /**
     * تحديث حالة باصات متعددة
     */
    public function bulkUpdateStatus(array $busIds, string $status): int
    {
        return DB::transaction(function () use ($busIds, $status) {
            $buses = Bus::whereIn('id', $busIds)->get();

            // التحقق من وجود طلاب في حالة عدم التفعيل
            if ($status !== 'active') {
                $busesWithStudents = $buses->where('current_students', '>', 0);
                if ($busesWithStudents->count() > 0) {
                    $busNumbers = $busesWithStudents->pluck('number')->implode(', ');
                    throw new Exception("لا يمكن تغيير حالة الباصات التالية لوجود طلاب: {$busNumbers}");
                }
            }

            $updated = Bus::whereIn('id', $busIds)->update(['status' => $status]);

            Log::info('تحديث مجمع لحالة باصات', [
                'count' => $updated,
                'status' => $status,
                'admin_id' => session('admin_id')
            ]);

            return $updated;
        });
    }

    /**
     * إضافة طالبات للباص
     */
    public function assignStudents(Bus $bus, array $studentIds): array
    {
        return DB::transaction(function () use ($bus, $studentIds) {
            // جلب الطالبات المؤهلات
            $students = Student::whereIn('id', $studentIds)
                              ->where('center', $bus->center_id)
                              ->where('status', 'approved')
                              ->whereNull('assigned_bus_id')
                              ->get();

            // التحقق من أن جميع الطالبات مؤهلات
            if ($students->count() !== count($studentIds)) {
                throw new Exception('بعض الطالبات غير مؤهلات للإضافة');
            }

            // التحقق من المقاعد المتاحة
            $availableSeats = $bus->getAvailableSeats();
            if ($students->count() > $availableSeats) {
                throw new Exception("المقاعد المتاحة ({$availableSeats}) غير كافية");
            }

            // إضافة الطالبات
            $addedCount = 0;
            foreach ($students as $student) {
                $bus->addStudent($student);
                $addedCount++;
            }

            // تحديث عداد المركز
            if ($bus->center) {
                $bus->center->updateCounts();
            }

            Log::info('تم إضافة طالبات للباص', [
                'bus_id' => $bus->id,
                'bus_number' => $bus->number,
                'students_count' => $addedCount,
                'admin_id' => session('admin_id')
            ]);

            return [
                'success' => true,
                'count' => $addedCount,
                'message' => "تم إضافة {$addedCount} طالبة بنجاح"
            ];
        });
    }

    /**
     * إزالة طالبة من الباص
     */
    public function removeStudent(Bus $bus, Student $student): bool
    {
        return DB::transaction(function () use ($bus, $student) {
            // التحقق من أن الطالبة مسجلة في الباص
            if ($student->assigned_bus_id !== $bus->id) {
                throw new Exception('الطالبة ليست مسجلة في هذا الباص');
            }

            // إزالة الطالبة
            $bus->removeStudent($student);

            // تحديث عداد المركز
            if ($bus->center) {
                $bus->center->updateCounts();
            }

            Log::info('تم إزالة طالبة من الباص', [
                'bus_id' => $bus->id,
                'bus_number' => $bus->number,
                'student_id' => $student->id,
                'student_name' => $student->name,
                'admin_id' => session('admin_id')
            ]);

            return true;
        });
    }

    /**
     * الحصول على الطالبات المتاحات للإضافة لباص معين
     */
    public function getAvailableStudentsForBus(Bus $bus)
    {
        $query = Student::where('center', $bus->center_id)
                       ->where('status', 'approved')
                       ->whereNull('assigned_bus_id');

        // تصفية حسب الفترة إذا كانت محددة للباص
        if ($bus->shift) {
            $query->where('preferred_schedule', $bus->shift);
        }

        return $query->orderBy('name')->get();
    }

    /**
     * إحصائيات الباص
     */
    public function getBusStats(Bus $bus): array
    {
        return [
            'occupancy_rate' => $bus->getOccupancyPercentage(),
            'available_seats' => $bus->getAvailableSeats(),
            'students_count' => $bus->current_students,
            'capacity' => $bus->capacity,
            'has_driver' => !is_null($bus->driver_id),
            'driver_name' => $bus->driver?->name,
            'is_active' => $bus->status === 'active',
            'center_name' => $bus->center_id,
            'schedule' => $bus->schedule_text ?? 'غير محدد',
            'time_range' => $bus->time_range ?? 'غير محدد',
        ];
    }

    /**
     * إزالة جميع الطالبات من الباص
     */
    public function removeAllStudents(Bus $bus): int
    {
        return DB::transaction(function () use ($bus) {
            $students = $bus->students;
            $count = $students->count();

            if ($count === 0) {
                throw new Exception('لا يوجد طالبات في الباص');
            }

            foreach ($students as $student) {
                $bus->removeStudent($student);
            }

            // تحديث عداد المركز
            if ($bus->center) {
                $bus->center->updateCounts();
            }

            Log::info('تم إزالة جميع الطالبات من الباص', [
                'bus_id' => $bus->id,
                'bus_number' => $bus->number,
                'students_count' => $count,
                'admin_id' => session('admin_id')
            ]);

            return $count;
        });
    }

    /**
     * إحصائيات عامة للباصات
     */
    public function getStatistics(): array
    {
        $allBuses = Bus::all();
        $activeBuses = $allBuses->where('status', 'active');

        return [
            'total_buses' => $allBuses->count(),
            'active_buses' => $activeBuses->count(),
            'inactive_buses' => $allBuses->where('status', 'inactive')->count(),
            'maintenance_buses' => $allBuses->where('status', 'maintenance')->count(),
            'buses_with_drivers' => $activeBuses->whereNotNull('driver_id')->count(),
            'buses_without_drivers' => $activeBuses->whereNull('driver_id')->count(),
            'total_capacity' => $activeBuses->sum('capacity'),
            'occupied_seats' => $activeBuses->sum('current_students'),
            'available_seats' => $activeBuses->sum('capacity') - $activeBuses->sum('current_students'),
            'total_students' => $activeBuses->sum('current_students'),
            'occupancy_rate' => $activeBuses->sum('capacity') > 0 ? 
                round(($activeBuses->sum('current_students') / $activeBuses->sum('capacity')) * 100, 1) : 0
        ];
    }

    /**
     * الحصول على الباصات المتاحة لمركز معين
     */
    public function getAvailableBusesForCenter(string $centerName)
    {
        return Bus::where('center_id', $centerName)
                  ->where('status', 'active')
                  ->whereRaw('current_students < capacity')
                  ->orderBy('number')
                  ->get();
    }

    /**
     * نقل طالبات من باص إلى آخر
     */
    public function transferStudents(Bus $fromBus, Bus $toBus, array $studentIds): array
    {
        return DB::transaction(function () use ($fromBus, $toBus, $studentIds) {
            // التحقق من أن الباصين في نفس المركز
            if ($fromBus->center_id !== $toBus->center_id) {
                throw new Exception('لا يمكن نقل الطالبات بين باصات من مراكز مختلفة');
            }

            // جلب الطالبات
            $students = Student::whereIn('id', $studentIds)
                              ->where('assigned_bus_id', $fromBus->id)
                              ->get();

            if ($students->count() !== count($studentIds)) {
                throw new Exception('بعض الطالبات غير موجودات في الباص الأول');
            }

            // التحقق من المقاعد المتاحة
            if ($toBus->getAvailableSeats() < $students->count()) {
                throw new Exception('المقاعد المتاحة في الباص الثاني غير كافية');
            }

            // نقل الطالبات
            $transferredCount = 0;
            foreach ($students as $student) {
                $fromBus->removeStudent($student);
                $toBus->addStudent($student);
                $transferredCount++;
            }

            Log::info('تم نقل طالبات بين باصين', [
                'from_bus' => $fromBus->number,
                'to_bus' => $toBus->number,
                'count' => $transferredCount,
                'admin_id' => session('admin_id')
            ]);

            return [
                'success' => true,
                'count' => $transferredCount,
                'message' => "تم نقل {$transferredCount} طالبة بنجاح"
            ];
        });
    }

    /**
     * التحقق من توفر السائق
     */
   protected function validateDriverAvailability(?int $driverId): void
{
    if (!$driverId) {
        return;
    }

    $driver = Driver::find($driverId);
    
    if (!$driver) {
        throw new Exception('السائق غير موجود');
    }

    // استخدم status مباشرة بدلاً من isActive()
    if ($driver->status !== 'active') {
        throw new Exception('السائق غير نشط');
    }

    // تحقق من وجود باص نشط بدلاً من hasActiveBus()
    $hasActiveBus = Bus::where('driver_id', $driverId)
                      ->where('status', 'active')
                      ->exists();
                      
    if ($hasActiveBus) {
        throw new Exception('السائق المحدد مخصص لباص آخر');
    }
}

    /**
     * تحديث عداد الباصات في المركز
     */
    protected function updateCenterBusCount(?string $centerName): void
    {
        if (!$centerName) {
            return;
        }

        $center = Center::where('center_name', $centerName)->first();
        
        if ($center) {
            $busCount = Bus::where('center_id', $centerName)
                          ->where('status', 'active')
                          ->count();
            $center->update(['bus_count' => $busCount]);
        }
    }
}