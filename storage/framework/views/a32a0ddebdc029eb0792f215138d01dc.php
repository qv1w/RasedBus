

<?php $__env->startSection('title', 'إضافة دفعة جديدة'); ?>

<?php $__env->startSection('header'); ?>
<div class="d-flex justify-content-between align-items-center w-100">
    <div>
        <h2 class="mb-1">
            <i class="fas fa-plus-circle text-success me-2"></i>
            إضافة دفعة جديدة
        </h2>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="<?php echo e(route('admin.dashboard')); ?>">لوحة التحكم</a></li>
                <li class="breadcrumb-item"><a href="<?php echo e(route('admin.payments.index')); ?>">الدفعات</a></li>
                <li class="breadcrumb-item active">إضافة دفعة</li>
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
            <div class="alert alert-info mb-4">
                <i class="fas fa-info-circle me-2"></i>
                <strong>ملاحظة:</strong>  مايحتاج الا تحط الطالبه و المبلغ اما التاريخ اختياري
            </div>

            <form action="<?php echo e(route('admin.payments.store')); ?>" method="POST">
                <?php echo csrf_field(); ?>

                <div class="mb-4">
                    <label class="form-label">الطالبة <span class="text-danger">*</span></label>
                    <select name="student_id" class="form-select <?php $__errorArgs = ['student_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                        <option value="">-- اختر الطالبة --</option>
                        <?php $__currentLoopData = $students; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($student->id); ?>" 
                                    <?php echo e((old('student_id') == $student->id || ($selectedStudent && $selectedStudent->id == $student->id)) ? 'selected' : ''); ?>>
                                <?php echo e($student->name); ?> - <?php echo e($student->student_id); ?> (<?php echo e($student->center->center_name); ?>)
                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                    <?php $__errorArgs = ['student_id'];
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
                                   value="<?php echo e(old('amount')); ?>" step="0.01" min="1" required placeholder="0.00">
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
                               value="<?php echo e(old('due_date')); ?>">
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
                        <small class="text-muted">اختياري - تاريخ آخر موعد للسداد</small>
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
                              rows="3" placeholder="مثال: رسوم الفصل الدراسي الأول..."><?php echo e(old('notes')); ?></textarea>
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
                    <small class="text-muted">ستظهر هذه الملاحظات للطالبة</small>
                </div>

                <hr class="border-secondary my-4">

                <div class="d-flex justify-content-between">
                    <a href="<?php echo e(route('admin.payments.index')); ?>" class="btn btn-outline-secondary">
                        <i class="fas fa-times me-1"></i>
                        إلغاء
                    </a>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-plus me-1"></i>
                        إضافة الدفعة
                    </button>
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
        border-color: #28a745;
        color: #fff;
        box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.25);
    }
    .form-select option {
        background: #1a1a2e;
        color: #fff;
    }
    .input-group-text {
        background: rgba(40, 167, 69, 0.2);
        border-color: rgba(255,255,255,0.2);
        color: #90EE90;
    }
</style>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\project-bus\resources\views/admin/payments/create.blade.php ENDPATH**/ ?>