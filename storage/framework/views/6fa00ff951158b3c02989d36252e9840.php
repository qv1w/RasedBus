

<?php $__env->startSection('title', 'تعديل الدفعة - ' . $payment->payment_number); ?>

<?php $__env->startSection('header'); ?>
<div class="d-flex justify-content-between align-items-center w-100">
    <div>
        <h2 class="mb-1">
            <i class="fas fa-edit text-warning me-2"></i>
            تعديل الدفعة
        </h2>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="<?php echo e(route('admin.dashboard')); ?>">لوحة التحكم</a></li>
                <li class="breadcrumb-item"><a href="<?php echo e(route('admin.payments.index')); ?>">الدفعات</a></li>
                <li class="breadcrumb-item active"><?php echo e($payment->payment_number); ?></li>
            </ol>
        </nav>
    </div>
    <a href="<?php echo e(route('admin.payments.index')); ?>" class="btn btn-outline-light">
        <i class="fas fa-arrow-right me-1"></i>
        العودة
    </a>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="content-card">
            <!-- معلومات الطالبة -->
            <div class="alert alert-info mb-4">
                <i class="fas fa-user-graduate me-2"></i>
                <strong>الطالبة:</strong> 
                <?php if($payment->student): ?>
                    <?php echo e($payment->student->name); ?> (<?php echo e($payment->student->student_id); ?>)
                <?php else: ?>
                    غير محدد
                <?php endif; ?>
            </div>

            <form action="<?php echo e(route('admin.payments.update', $payment)); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>

                <div class="row">
                    <div class="col-md-6 mb-4">
                        <label class="form-label">رقم الدفعة</label>
                        <input type="text" class="form-control" value="<?php echo e($payment->payment_number); ?>" readonly disabled>
                    </div>

                    <div class="col-md-6 mb-4">
                        <label class="form-label">الحالة</label>
                        <select name="status" class="form-select <?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                            <option value="awaiting_receipt" <?php echo e($payment->status == 'awaiting_receipt' ? 'selected' : ''); ?>>بانتظار الإيصال</option>
                            <option value="pending" <?php echo e($payment->status == 'pending' ? 'selected' : ''); ?>>قيد المراجعة</option>
                            <option value="approved" <?php echo e($payment->status == 'approved' ? 'selected' : ''); ?>>مقبولة</option>
                            <option value="rejected" <?php echo e($payment->status == 'rejected' ? 'selected' : ''); ?>>مرفوضة</option>
                        </select>
                        <?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-4">
                        <label class="form-label">المبلغ المطلوب <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="number" name="amount" class="form-control <?php $__errorArgs = ['amount'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                   value="<?php echo e(old('amount', $payment->amount)); ?>" step="0.01" min="1" required>
                            <span class="input-group-text">ريال</span>
                        </div>
                        <?php $__errorArgs = ['amount'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback d-block"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="col-md-6 mb-4">
                        <label class="form-label">تاريخ الاستحقاق</label>
                        <input type="date" name="due_date" class="form-control <?php $__errorArgs = ['due_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                               value="<?php echo e(old('due_date', $payment->due_date ? $payment->due_date->format('Y-m-d') : '')); ?>">
                        <?php $__errorArgs = ['due_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label">ملاحظات للطالبة</label>
                    <textarea name="notes" class="form-control <?php $__errorArgs = ['notes'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                              rows="3"><?php echo e(old('notes', $payment->notes)); ?></textarea>
                    <?php $__errorArgs = ['notes'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <!-- معلومات الإيصال إن وجد -->
                <?php if($payment->receipt_image): ?>
                <div class="mb-4">
                    <label class="form-label">الإيصال المرفق</label>
                    <div class="d-flex align-items-center gap-3">
                        <a href="<?php echo e(asset('storage/' . $payment->receipt_image)); ?>" target="_blank" class="btn btn-outline-info">
                            <i class="fas fa-eye me-1"></i>
                            عرض الإيصال
                        </a>
                        <span class="text-muted">تم رفعه من الطالبة</span>
                    </div>
                </div>
                <?php endif; ?>

                <hr class="border-secondary my-4">

                <div class="d-flex justify-content-between">
                    <a href="<?php echo e(route('admin.payments.index')); ?>" class="btn btn-outline-secondary">
                        <i class="fas fa-times me-1"></i>
                        إلغاء
                    </a>
                    <div class="d-flex gap-2">
                        <?php if($payment->status == 'pending' && $payment->receipt_image): ?>
                        <form action="<?php echo e(route('admin.payments.approve', $payment)); ?>" method="POST" class="d-inline">
                            <?php echo csrf_field(); ?>
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-check me-1"></i>
                                قبول الدفعة
                            </button>
                        </form>
                        <?php endif; ?>
                        
                        <button type="submit" class="btn btn-warning">
                            <i class="fas fa-save me-1"></i>
                            حفظ التغييرات
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
<style>
    .content-card {
        background: rgba(255, 255, 255, 0.05);
        border-radius: 15px;
        padding: 2rem;
        border: 1px solid rgba(127, 176, 105, 0.2);
    }
    .form-control, .form-select {
        background: rgba(255,255,255,0.05);
        border-color: rgba(255,255,255,0.2);
        color: #fff;
    }
    .form-control:focus, .form-select:focus {
        background: rgba(255,255,255,0.1);
        border-color: #ffc107;
        color: #fff;
        box-shadow: 0 0 0 0.2rem rgba(255, 193, 7, 0.25);
    }
    .form-control:disabled {
        background: rgba(255,255,255,0.02);
        color: rgba(255,255,255,0.5);
    }
    .input-group-text {
        background: rgba(255, 193, 7, 0.2);
        border-color: rgba(255,255,255,0.2);
        color: #ffc107;
    }
</style>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/rasedbus/project-bus/resources/views/admin/payments/edit.blade.php ENDPATH**/ ?>