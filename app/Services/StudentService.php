<?php

namespace App\Services;

use App\Models\Student;
use App\Models\Center;
use App\Models\Bus;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class StudentService
{
    public function create(array $data): Student
    {
        return DB::transaction(function () use ($data) {
            // التحقق من المركز
            $center = $this->validateCenter($data['center'], $data['preferred_schedule']);
            
            // التحقق من النطاق الجغرافي
            $this->validateLocation(
                $data['latitude'], 
                $data['longitude'], 
                $center, 
                $data['preferred_schedule']
            );

            // توليد رقم طالب فريد
            $studentId = $this->generateStudentId();

           
            $student = Student::create(array_merge($data, [
                'student_id' => $studentId,
                'status' => 'pending',
                'gender' => 'female', 
                'registration_date' => now(),
                'total_required' => 500.00,
                'total_paid' => 0.00
            ]));

            // تحديث عداد المركز
            if (method_exists($center, 'updateCounts')) {
                $center->updateCounts();
            }

            Log::info('تسجيل طالبة جديدة', [
                'student_id' => $studentId,
                'name' => $data['name'],
                'center' => $data['center']
            ]);

            return $student;
        });
    }

    public function update(Student $student, array $data): Student
    {
        return DB::transaction(function () use ($student, $data) {
            $oldCenter = $student->center;
            
            $student->update($data);

            // تحديث عدادات المراكز إذا تغير المركز
            if (isset($data['center']) && $oldCenter !== $data['center']) {
                $oldCenterModel = Center::where('center_name', $oldCenter)->first();
                $newCenterModel = Center::where('center_name', $data['center'])->first();
                
                if ($oldCenterModel && method_exists($oldCenterModel, 'updateCounts')) {
                    $oldCenterModel->updateCounts();
                }
                if ($newCenterModel && method_exists($newCenterModel, 'updateCounts')) {
                    $newCenterModel->updateCounts();
                }
            }

            Log::info('تحديث بيانات طالبة', [
                'student_id' => $student->student_id,
                'changes' => $student->getChanges(),
                'admin_id' => session('admin_id')
            ]);

            return $student->fresh();
        });
    }

    public function approve(Student $student): Student
    {
        $student->update(['status' => 'approved']);

        Log::info('قبول طالبة', [
            'student_id' => $student->student_id,
            'admin_id' => session('admin_id')
        ]);

        return $student;
    }

    public function reject(Student $student, string $reason): Student
    {
        $student->update([
            'status' => 'rejected',
            'notes' => $reason
        ]);

        Log::info('رفض طالبة', [
            'student_id' => $student->student_id,
            'reason' => $reason,
            'admin_id' => session('admin_id')
        ]);

        return $student;
    }

    public function suspend(Student $student): Student
    {
        $student->update(['status' => 'suspended']);

        Log::info('تعليق طالبة', [
            'student_id' => $student->student_id,
            'admin_id' => session('admin_id')
        ]);

        return $student;
    }

    public function unsuspend(Student $student): Student
    {
        $student->update(['status' => 'approved']);

        Log::info('إلغاء تعليق طالبة', [
            'student_id' => $student->student_id,
            'admin_id' => session('admin_id')
        ]);

        return $student;
    }

    public function assignBus(Student $student, int $busId, ?string $pickupPoint = null, ?string $pickupTime = null): Student
    {
        $bus = Bus::findOrFail($busId);

        if (method_exists($bus, 'canAddStudent') && !$bus->canAddStudent($student)) {
            throw new \Exception('لا يمكن تخصيص هذا الباص للطالبة');
        }

        return DB::transaction(function () use ($student, $busId, $pickupPoint, $pickupTime, $bus) {
            $student->update([
                'assigned_bus_id' => $busId,
                'pickup_point' => $pickupPoint,
                'pickup_time' => $pickupTime
            ]);

            $bus->increment('current_students');

            Log::info('تخصيص باص لطالبة', [
                'student_id' => $student->student_id,
                'bus_id' => $busId,
                'admin_id' => session('admin_id')
            ]);

            return $student->fresh();
        });
    }

    public function unassignBus(Student $student): Student
    {
        if (!$student->assigned_bus_id) {
            return $student;
        }

        return DB::transaction(function () use ($student) {
            $bus = Bus::find($student->assigned_bus_id);
            
            $student->update([
                'assigned_bus_id' => null,
                'pickup_point' => null,
                'pickup_time' => null
            ]);

            if ($bus) {
                $bus->decrement('current_students');
            }

            Log::info('إلغاء تخصيص باص من طالبة', [
                'student_id' => $student->student_id,
                'admin_id' => session('admin_id')
            ]);

            return $student->fresh();
        });
    }

    public function delete(Student $student): bool
    {
        return DB::transaction(function () use ($student) {
            // إلغاء تخصيص الباص أولاً
            if ($student->assigned_bus_id) {
                $this->unassignBus($student);
            }

            $studentId = $student->student_id;
            $centerName = $student->center;
            
            $student->delete();

            // تحديث عداد المركز
            $center = Center::where('center_name', $centerName)->first();
            if ($center && method_exists($center, 'updateCounts')) {
                $center->updateCounts();
            }

            Log::info('حذف طالبة', [
                'student_id' => $studentId,
                'admin_id' => session('admin_id')
            ]);

            return true;
        });
    }

    protected function validateCenter(string $centerName, string $schedule): Center
    {
        $center = Center::where('center_name', $centerName)
                       ->where('status', 'active')
                       ->first();

        if (!$center) {
            throw new \Exception('المركز المختار غير متوفر حالياً');
        }

        if ($schedule === 'صباحية' && !$center->morning_available) {
            throw new \Exception('الفترة الصباحية غير متوفرة في هذا المركز');
        }

        if ($schedule === 'مسائية' && !$center->evening_available) {
            throw new \Exception('الفترة المسائية غير متوفرة في هذا المركز');
        }

        return $center;
    }

    protected function validateLocation(float $lat, float $lng, Center $center, string $schedule): void
    {
        $coverage = null;

        if ($schedule === 'صباحية' && $center->morning_coverage_area) {
            $coverage = $center->morning_coverage_area;
        } elseif ($schedule === 'مسائية' && $center->evening_coverage_area) {
            $coverage = $center->evening_coverage_area;
        } else {
            $coverage = $center->coverage_area;
        }

        if (!$coverage || !is_array($coverage) || count($coverage) < 3) {
            return; // لا يوجد نطاق محدد - السماح بالتسجيل
        }

        if (!$this->isPointInPolygon($lat, $lng, $coverage)) {
            throw new \Exception('موقعك خارج نطاق خدمة المركز المختار. يرجى اختيار مركز آخر أو التواصل مع الإدارة.');
        }
    }

    protected function isPointInPolygon(float $lat, float $lng, array $polygon): bool
    {
        $inside = false;
        $count = count($polygon);

        for ($i = 0, $j = $count - 1; $i < $count; $j = $i++) {
            $xi = $polygon[$i]['lat'] ?? $polygon[$i][0] ?? 0;
            $yi = $polygon[$i]['lng'] ?? $polygon[$i][1] ?? 0;
            $xj = $polygon[$j]['lat'] ?? $polygon[$j][0] ?? 0;
            $yj = $polygon[$j]['lng'] ?? $polygon[$j][1] ?? 0;

            $intersect = (($yi > $lng) !== ($yj > $lng)) && 
                        ($lat < ($xj - $xi) * ($lng - $yi) / ($yj - $yi) + $xi);
            
            if ($intersect) {
                $inside = !$inside;
            }
        }

        return $inside;
    }

    protected function generateStudentId(): string
    {
        $year = date('Y');
        $prefix = 'STD-' . $year . '-';
        
        // الحصول على آخر رقم
        $lastStudent = Student::where('student_id', 'like', $prefix . '%')
                             ->orderBy('student_id', 'desc')
                             ->first();
        
        if ($lastStudent) {
            $lastNumber = (int) substr($lastStudent->student_id, -4);
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }
        
        return $prefix . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
    }
}