<?php

namespace App\Services;

use App\Models\Payment;
use App\Models\Student;
use App\Models\PaymentSetting;
use Illuminate\Support\Facades\Log;

class PaymentService
{
    /**
     * إنشاء دفعة تلقائية لطالب جديد
     */
    public static function createAutoPayment(Student $student, $amount = null, $description = null)
    {
        // تحقق من تفعيل الدفعة التلقائية
        if (!PaymentSetting::isAutoPaymentEnabled()) {
            return null;
        }

        // تحقق من عدم وجود دفعة معلقة للطالب في نفس السنة
        $existingPayment = Payment::where('student_id', $student->id)
                                  ->where('academic_year', date('Y'))
                                  ->whereIn('status', ['awaiting_receipt', 'pending'])
                                  ->first();

        if ($existingPayment) {
            return null; // عنده دفعة معلقة
        }

        try {
            $payment = Payment::create([
                'payment_number' => Payment::generatePaymentNumber(),
                'student_id' => $student->id,
                'amount' => $amount ?? PaymentSetting::getDefaultAmount(),
                'payment_method' => 'bank_transfer',
                'description' => $description ?? PaymentSetting::getDefaultDescription(),
                'status' => 'awaiting_receipt',
                'academic_year' => date('Y'),
                'semester' => self::getCurrentSemester(),
            ]);

            Log::info("Auto payment created for student {$student->id}: {$payment->payment_number}");
            return $payment;

        } catch (\Exception $e) {
            Log::error("Failed to create auto payment for student {$student->id}: " . $e->getMessage());
            return null;
        }
    }

    /**
     * الحصول على الطلاب بدون دفعات في السنة الحالية
     */
    public static function getStudentsWithoutPayments($centerIds = null)
    {
        $query = Student::where('status', 'approved')
                        ->whereDoesntHave('payments', function ($q) {
                            $q->where('academic_year', date('Y'));
                        });

        if ($centerIds) {
            $query->whereIn('center_id', (array) $centerIds);
        }

        return $query->with('center')->get();
    }

    /**
     * إنشاء دفعات للطلاب بدون دفعات
     */
    public static function createPaymentsForMissingStudents($centerIds = null, $amount = null, $description = null)
    {
        $students = self::getStudentsWithoutPayments($centerIds);
        $created = 0;
        $failed = 0;

        $paymentAmount = $amount ?? PaymentSetting::getDefaultAmount();
        $paymentDescription = $description ?? PaymentSetting::getDefaultDescription();

        foreach ($students as $student) {
            try {
                Payment::create([
                    'payment_number' => Payment::generatePaymentNumber(),
                    'student_id' => $student->id,
                    'amount' => $paymentAmount,
                    'payment_method' => 'bank_transfer',
                    'description' => $paymentDescription,
                    'status' => 'awaiting_receipt',
                    'academic_year' => date('Y'),
                    'semester' => self::getCurrentSemester(),
                ]);
                $created++;
            } catch (\Exception $e) {
                Log::error("Failed to create payment for student {$student->id}: " . $e->getMessage());
                $failed++;
            }
        }

        return [
            'created' => $created,
            'failed' => $failed,
            'total' => $students->count(),
        ];
    }

    /**
     * الحصول على الفصل الدراسي الحالي
     */
    public static function getCurrentSemester()
    {
        $month = date('n');
        if ($month >= 9 || $month <= 1) {
            return 'الفصل الأول';
        } elseif ($month >= 2 && $month <= 6) {
            return 'الفصل الثاني';
        } else {
            return 'الفصل الصيفي';
        }
    }
}
