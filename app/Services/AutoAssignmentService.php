<?php

namespace App\Services;

use App\Models\Student;
use App\Models\Bus;
use App\Models\Center;
use Exception;

class AutoAssignmentService
{
    public function assignStudentAutomatically(Student $student)
    {
        try {
            // التحقق من وجود إحداثيات الطالب
            if (!$student->latitude || !$student->longitude) {
                return [
                    'success' => false,
                    'message' => 'لا توجد إحداثيات للطالب'
                ];
            }

            // البحث عن أقرب باص متاح
            $availableBus = Bus::where('center_id', $student->center)
                             ->where('status', 'active')
                             ->whereRaw('current_students < capacity')
                             ->first();

            if ($availableBus) {
                $student->assigned_bus_id = $availableBus->id;
                $student->pickup_point = 'نقطة تجمع ' . $student->center;
                $student->pickup_time = $availableBus->departure_time;
                $student->save();
                
                // تحديث عدد الطلاب في الباص
                $availableBus->current_students = $availableBus->students()->count();
                $availableBus->save();

                return [
                    'success' => true,
                    'message' => 'تم التسكين تلقائياً في الباص رقم ' . $availableBus->bus_number,
                    'bus_id' => $availableBus->id,
                    'bus_number' => $availableBus->bus_number
                ];
            }

            return [
                'success' => false,
                'message' => 'لا توجد باصات متاحة في هذا المركز حالياً'
            ];

        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => 'خطأ في التسكين: ' . $e->getMessage()
            ];
        }
    }

    public function redistributeAll()
    {
        try {
            $unassignedStudents = Student::whereNull('assigned_bus_id')
                                       ->where('status', 'approved')
                                       ->get();

            $successCount = 0;
            $failureCount = 0;

            foreach ($unassignedStudents as $student) {
                $result = $this->assignStudentAutomatically($student);
                if ($result['success']) {
                    $successCount++;
                } else {
                    $failureCount++;
                }
            }

            return [
                'success' => true,
                'message' => "تم تسكين {$successCount} طالب بنجاح، فشل في تسكين {$failureCount} طالب",
                'assigned' => $successCount,
                'failed' => $failureCount
            ];

        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => 'خطأ في إعادة التوزيع: ' . $e->getMessage()
            ];
        }
    }
}