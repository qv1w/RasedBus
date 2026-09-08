<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Student;
use App\Models\Center;
use App\Models\PaymentSetting;
use App\Services\PaymentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    /**
     * عرض قائمة الدفعات
     */
    public function index(Request $request)
    {
        $query = Payment::with('student.center');

        // البحث
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('payment_number', 'like', "%{$search}%")
                  ->orWhereHas('student', function($sq) use ($search) {
                      $sq->where('name', 'like', "%{$search}%")
                         ->orWhere('student_id', 'like', "%{$search}%");
                  });
            });
        }

        // فلتر الحالة
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        // فلتر الجهة
        if ($request->filled('center_id')) {
            $query->whereHas('student', function($q) use ($request) {
                $q->where('center_id', $request->center_id);
            });
        }

        $payments = $query->latest()->paginate(20);

        // إحصائيات
        $stats = [
            'total' => Payment::count(),
            'awaiting_receipt' => Payment::where('status', 'awaiting_receipt')->count(),
            'pending' => Payment::where('status', 'pending')->count(),
            'approved' => Payment::where('status', 'approved')->count(),
            'rejected' => Payment::where('status', 'rejected')->count(),
            'total_amount' => Payment::where('status', 'approved')->sum('amount'),
        ];

        return view('admin.payments.index', compact('payments', 'stats'));
    }

    /**
     * صفحة إضافة دفعة جديدة
     */
    public function create(Request $request)
    {
        $students = Student::where('status', 'approved')
                          ->with('center')
                          ->orderBy('name')
                          ->get();
        
        $selectedStudent = null;
        if ($request->filled('student_id')) {
            $selectedStudent = Student::find($request->student_id);
        }

        return view('admin.payments.create', compact('students', 'selectedStudent'));
    }

    /**
     * حفظ دفعة جديدة
     */
    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'amount' => 'required|numeric|min:1',
            'due_date' => 'nullable|date',
            'notes' => 'nullable|string|max:500',
        ], [
            'student_id.required' => 'يجب اختيار الطالب',
            'amount.required' => 'المبلغ مطلوب',
            'amount.min' => 'المبلغ يجب أن يكون أكبر من صفر',
        ]);

        try {
            $payment = Payment::create([
                'payment_number' => Payment::generatePaymentNumber(),
                'student_id' => $request->student_id,
                'amount' => $request->amount,
                'payment_method' => 'bank_transfer',
                'due_date' => $request->due_date,
                'notes' => $request->notes,
                'status' => 'awaiting_receipt',
                'academic_year' => date('Y'),
                'semester' => $this->getCurrentSemester(),
            ]);

            return redirect()->route('admin.payments.index')
                           ->with('success', 'تم إضافة الدفعة بنجاح');

        } catch (\Exception $e) {
            Log::error('Payment Create Error: ' . $e->getMessage());
            return back()->with('error', 'حدث خطأ أثناء إضافة الدفعة')->withInput();
        }
    }

    /**
     * ========================================
     * صفحة إنشاء دفعات جماعية
     * ========================================
     */
    public function bulkCreate()
    {
        return view('admin.payments.bulk-create');
    }

    /**
     * ========================================
     * حفظ الدفعات الجماعية
     * ========================================
     */
    public function bulkStore(Request $request)
    {
        $request->validate([
            'center_ids' => 'required|array|min:1',
            'center_ids.*' => 'exists:centers,id',
            'amount' => 'required|numeric|min:1',
            'due_date' => 'nullable|date',
            'description' => 'nullable|string|max:255',
            'notes' => 'nullable|string|max:500',
        ], [
            'center_ids.required' => 'يجب اختيار جهة تعليمية واحدة على الأقل',
            'center_ids.min' => 'يجب اختيار جهة تعليمية واحدة على الأقل',
            'amount.required' => 'المبلغ مطلوب',
            'amount.min' => 'المبلغ يجب أن يكون أكبر من صفر',
        ]);

        try {
            DB::beginTransaction();
            
            // جلب الطلاب المقبولين في الجهات المحددة
            $students = Student::where('status', 'approved')
                              ->whereIn('center_id', $request->center_ids)
                              ->get();
            
            if ($students->isEmpty()) {
                return back()->with('error', 'لا يوجد طلاب مقبولين في الجهات المحددة');
            }
            
            $createdCount = 0;
            $skippedCount = 0;
            $academicYear = date('Y');
            $semester = $this->getCurrentSemester();
            
            foreach ($students as $student) {
                // التحقق من عدم وجود دفعة مماثلة معلقة للطالب
                $existingPayment = Payment::where('student_id', $student->id)
                                         ->where('amount', $request->amount)
                                         ->where('academic_year', $academicYear)
                                         ->whereIn('status', ['awaiting_receipt', 'pending'])
                                         ->first();
                
                if ($existingPayment) {
                    $skippedCount++;
                    continue;
                }
                
                Payment::create([
                    'payment_number' => Payment::generatePaymentNumber(),
                    'student_id' => $student->id,
                    'amount' => $request->amount,
                    'payment_method' => 'bank_transfer',
                    'due_date' => $request->due_date,
                    'description' => $request->description ?? 'رسوم النقل',
                    'notes' => $request->notes,
                    'status' => 'awaiting_receipt',
                    'academic_year' => $academicYear,
                    'semester' => $semester,
                ]);
                
                $createdCount++;
            }
            
            DB::commit();
            
            $message = "تم إنشاء {$createdCount} دفعة بنجاح";
            if ($skippedCount > 0) {
                $message .= " (تم تخطي {$skippedCount} طالب لوجود دفعات معلقة)";
            }
            
            return redirect()->route('admin.payments.index')
                           ->with('success', $message);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Bulk Payment Create Error: ' . $e->getMessage());
            return back()->with('error', 'حدث خطأ أثناء إنشاء الدفعات: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * عرض تفاصيل دفعة
     */
    public function show(Payment $payment)
    {
        $payment->load('student.center');
        return view('admin.payments.show', compact('payment'));
    }

    /**
     * صفحة تعديل دفعة
     */
    public function edit(Payment $payment)
    {
        $students = Student::where('status', 'approved')
                          ->with('center')
                          ->orderBy('name')
                          ->get();

        return view('admin.payments.edit', compact('payment', 'students'));
    }

    /**
     * تحديث دفعة
     */
    public function update(Request $request, Payment $payment)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1',
            'due_date' => 'nullable|date',
            'notes' => 'nullable|string|max:500',
            'status' => 'nullable|in:awaiting_receipt,pending,approved,rejected',
        ]);

        try {
            $payment->amount = $request->amount;
            $payment->due_date = $request->due_date;
            $payment->notes = $request->notes;

            // تحديث الحالة إذا تغيرت
            if ($request->filled('status') && $request->status != $payment->status) {
                $payment->status = $request->status;
                
                // إذا تم القبول، سجل وقت المعالجة
                if ($request->status == 'approved') {
                    $payment->processed_by = session('admin_id');
                    $payment->processed_at = now();
                }
            }

            $payment->save();

            // تحديث المبلغ المدفوع للطالب
            $this->updateStudentTotalPaid($payment->student_id);

            return redirect()->route('admin.payments.index')
                           ->with('success', 'تم تحديث الدفعة بنجاح');

        } catch (\Exception $e) {
            Log::error('Payment Update Error: ' . $e->getMessage());
            return back()->with('error', 'حدث خطأ أثناء التحديث')->withInput();
        }
    }

    /**
     * حذف دفعة
     */
    public function destroy(Payment $payment)
    {
        try {
            // حذف الإيصال إن وجد
            if ($payment->receipt_image) {
                Storage::disk('public')->delete($payment->receipt_image);
            }

            $studentId = $payment->student_id;
            $payment->delete();
            
            // تحديث المبلغ المدفوع للطالب
            $this->updateStudentTotalPaid($studentId);

            return redirect()->route('admin.payments.index')
                           ->with('success', 'تم حذف الدفعة بنجاح');

        } catch (\Exception $e) {
            return back()->with('error', 'حدث خطأ أثناء الحذف');
        }
    }

    /**
     * قبول دفعة
     */
    public function approve(Payment $payment)
    {
        try {
            $payment->status = 'approved';
            $payment->processed_by = session('admin_id');
            $payment->processed_at = now();
            $payment->save();

            // تحديث المبلغ المدفوع للطالب
            $this->updateStudentTotalPaid($payment->student_id);

            return back()->with('success', 'تم قبول الدفعة بنجاح');

        } catch (\Exception $e) {
            Log::error('Payment Approve Error: ' . $e->getMessage());
            return back()->with('error', 'حدث خطأ أثناء قبول الدفعة');
        }
    }

    /**
     * رفض دفعة
     */
    public function reject(Request $request, Payment $payment)
    {
        $request->validate([
            'rejection_reason' => 'required|string|max:500',
        ], [
            'rejection_reason.required' => 'يجب كتابة سبب الرفض',
        ]);

        try {
            $payment->status = 'rejected';
            $payment->rejection_reason = $request->rejection_reason;
            $payment->processed_by = session('admin_id');
            $payment->processed_at = now();
            $payment->save();

            return back()->with('success', 'تم رفض الدفعة');

        } catch (\Exception $e) {
            Log::error('Payment Reject Error: ' . $e->getMessage());
            return back()->with('error', 'حدث خطأ أثناء رفض الدفعة');
        }
    }

    /**
     * إجراء جماعي
     */
    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => 'required|in:approve,reject,delete',
            'payment_ids' => 'required|array',
            'payment_ids.*' => 'exists:payments,id',
        ]);

        try {
            $payments = Payment::whereIn('id', $request->payment_ids)->get();
            $count = 0;

            foreach ($payments as $payment) {
                if ($request->action === 'approve') {
                    $payment->update([
                        'status' => 'approved',
                        'processed_by' => session('admin_id'),
                        'processed_at' => now(),
                    ]);
                    $this->updateStudentTotalPaid($payment->student_id);
                } elseif ($request->action === 'reject') {
                    $payment->update([
                        'status' => 'rejected',
                        'processed_by' => session('admin_id'),
                        'processed_at' => now(),
                    ]);
                } elseif ($request->action === 'delete') {
                    if ($payment->receipt_image) {
                        Storage::disk('public')->delete($payment->receipt_image);
                    }
                    $payment->delete();
                }
                $count++;
            }

            return response()->json([
                'success' => true,
                'message' => "تم تنفيذ الإجراء على {$count} دفعة"
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ أثناء تنفيذ الإجراء'
            ], 400);
        }
    }

    /**
     * الحصول على الفصل الدراسي الحالي
     */
    private function getCurrentSemester()
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
    
    /**
     * تحديث إجمالي المدفوع للطالب
     */
    private function updateStudentTotalPaid($studentId)
    {
        if (!$studentId) return;
        
        try {
            $totalPaid = Payment::where('student_id', $studentId)
                               ->where('status', 'approved')
                               ->sum('amount');
            
            DB::table('students')
                ->where('id', $studentId)
                ->update(['totalPaid' => $totalPaid]);
        } catch (\Exception $e) {
            // تجاهل الخطأ
            Log::warning('Failed to update student total paid: ' . $e->getMessage());
        }
    }

    /**
     * ========================================
     * صفحة الطلاب بدون دفعات
     * ========================================
     */
    public function missingStudents(Request $request)
    {
        $centerIds = $request->get('center_ids');
        $students = PaymentService::getStudentsWithoutPayments($centerIds);
        
        $centers = Center::where('status', 'active')
                        ->withCount(['students' => function($q) {
                            $q->where('status', 'approved');
                        }])
                        ->orderBy('type')
                        ->orderBy('center_name')
                        ->get();

        $settings = [
            'amount' => PaymentSetting::getDefaultAmount(),
            'description' => PaymentSetting::getDefaultDescription(),
        ];

        return view('admin.payments.missing-students', compact('students', 'centers', 'settings'));
    }

    /**
     * ========================================
     * إنشاء دفعات للطلاب بدون دفعات
     * ========================================
     */
    public function createMissingPayments(Request $request)
    {
        $request->validate([
            'student_ids' => 'required|array|min:1',
            'student_ids.*' => 'exists:students,id',
            'amount' => 'required|numeric|min:1',
            'description' => 'nullable|string|max:255',
        ], [
            'student_ids.required' => 'يجب اختيار طالب واحد على الأقل',
            'amount.required' => 'المبلغ مطلوب',
        ]);

        try {
            DB::beginTransaction();
            
            $created = 0;
            $skipped = 0;
            
            foreach ($request->student_ids as $studentId) {
                // تحقق من عدم وجود دفعة
                $exists = Payment::where('student_id', $studentId)
                                ->where('academic_year', date('Y'))
                                ->whereIn('status', ['awaiting_receipt', 'pending'])
                                ->exists();
                
                if ($exists) {
                    $skipped++;
                    continue;
                }
                
                Payment::create([
                    'payment_number' => Payment::generatePaymentNumber(),
                    'student_id' => $studentId,
                    'amount' => $request->amount,
                    'payment_method' => 'bank_transfer',
                    'description' => $request->description ?? PaymentSetting::getDefaultDescription(),
                    'status' => 'awaiting_receipt',
                    'academic_year' => date('Y'),
                    'semester' => $this->getCurrentSemester(),
                ]);
                
                $created++;
            }
            
            DB::commit();
            
            $message = "تم إنشاء {$created} دفعة بنجاح";
            if ($skipped > 0) {
                $message .= " (تم تخطي {$skipped} لوجود دفعات سابقة)";
            }
            
            return redirect()->route('admin.payments.index')
                           ->with('success', $message);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Create Missing Payments Error: ' . $e->getMessage());
            return back()->with('error', 'حدث خطأ: ' . $e->getMessage());
        }
    }

    /**
     * ========================================
     * صفحة إعدادات الدفعات
     * ========================================
     */
    public function settings()
    {
        $settings = [
            'default_payment_amount' => PaymentSetting::get('default_payment_amount', 500),
            'auto_payment_enabled' => PaymentSetting::get('auto_payment_enabled', 'yes'),
            'default_payment_description' => PaymentSetting::get('default_payment_description', 'رسوم النقل'),
        ];

        return view('admin.payments.settings', compact('settings'));
    }

    /**
     * ========================================
     * تحديث إعدادات الدفعات
     * ========================================
     */
    public function updateSettings(Request $request)
    {
        $request->validate([
            'default_payment_amount' => 'required|numeric|min:1',
            'auto_payment_enabled' => 'required|in:yes,no',
            'default_payment_description' => 'required|string|max:255',
        ]);

        try {
            PaymentSetting::set('default_payment_amount', $request->default_payment_amount, 'المبلغ الافتراضي للدفعة');
            PaymentSetting::set('auto_payment_enabled', $request->auto_payment_enabled, 'تفعيل الدفعة التلقائية');
            PaymentSetting::set('default_payment_description', $request->default_payment_description, 'وصف الدفعة الافتراضي');

            return back()->with('success', 'تم حفظ الإعدادات بنجاح');

        } catch (\Exception $e) {
            Log::error('Update Payment Settings Error: ' . $e->getMessage());
            return back()->with('error', 'حدث خطأ أثناء حفظ الإعدادات');
        }
    }
}
