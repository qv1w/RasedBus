<?php $__env->startSection('title', 'إعدادات الدفعات'); ?>

<?php $__env->startSection('header'); ?>
<div class="d-flex justify-content-between align-items-center w-100">
    <div>
        <h2 class="mb-1">
            <i class="fas fa-cog text-info me-2"></i>
            إعدادات الدفعات
        </h2>
        <p class="text-light mb-0 opacity-75">
            تخصيص إعدادات الدفعات والدفعات التلقائية
        </p>
    </div>
    <a href="<?php echo e(route('admin.payments.index')); ?>" class="btn btn-outline-light">
        <i class="fas fa-arrow-right me-1"></i>
        العودة للدفعات
    </a>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<?php if(session('success')): ?>
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <i class="fas fa-check-circle me-2"></i>
    <?php echo e(session('success')); ?>

    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
<?php endif; ?>

<?php if(session('error')): ?>
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <i class="fas fa-exclamation-circle me-2"></i>
    <?php echo e(session('error')); ?>

    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
<?php endif; ?>

<div class="row justify-content-center">
    <div class="col-lg-8">
        <form action="<?php echo e(route('admin.payments.settings.update')); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>
            
            <!-- إعدادات الدفعة الافتراضية -->
            <div class="content-card mb-4">
                <h5 class="mb-4">
                    <i class="fas fa-money-bill-wave text-success me-2"></i>
                    إعدادات الدفعة الافتراضية
                </h5>

                <div class="row">
                    <div class="col-md-6 mb-4">
                        <label class="form-label">المبلغ الافتراضي <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="number" name="default_payment_amount" class="form-control" 
                                   value="<?php echo e($settings['default_payment_amount']); ?>" step="0.01" min="1" required>
                            <span class="input-group-text">ريال</span>
                        </div>
                        <small class="text-muted">المبلغ الذي سيُستخدم تلقائياً عند إنشاء دفعات جديدة</small>
                    </div>

                    <div class="col-md-6 mb-4">
                        <label class="form-label">وصف الدفعة الافتراضي <span class="text-danger">*</span></label>
                        <input type="text" name="default_payment_description" class="form-control" 
                               value="<?php echo e($settings['default_payment_description']); ?>" required
                               placeholder="مثال: رسوم النقل">
                        <small class="text-muted">الوصف الذي سيظهر للطالب</small>
                    </div>
                </div>
            </div>

            <!-- إعدادات الدفعة التلقائية -->
            <div class="content-card mb-4">
                <h5 class="mb-4">
                    <i class="fas fa-magic text-primary me-2"></i>
                    الدفعة التلقائية عند قبول طالب جديد
                </h5>

                <div class="alert alert-info mb-4">
                    <i class="fas fa-info-circle me-2"></i>
                    عند تفعيل هذا الخيار، سيتم إنشاء دفعة تلقائياً لكل طالب جديد فور قبوله
                </div>

                <div class="mb-4">
                    <label class="form-label">الدفعة التلقائية</label>
                    <div class="d-flex gap-4">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="auto_payment_enabled" 
                                   value="yes" id="autoYes" <?php echo e($settings['auto_payment_enabled'] == 'yes' ? 'checked' : ''); ?>>
                            <label class="form-check-label text-success" for="autoYes">
                                <i class="fas fa-check-circle me-1"></i>
                                مفعّل
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="auto_payment_enabled" 
                                   value="no" id="autoNo" <?php echo e($settings['auto_payment_enabled'] == 'no' ? 'checked' : ''); ?>>
                            <label class="form-check-label text-danger" for="autoNo">
                                <i class="fas fa-times-circle me-1"></i>
                                معطّل
                            </label>
                        </div>
                    </div>
                </div>

                <!-- شرح كيف تعمل -->
                <div class="how-it-works">
                    <h6 class="text-muted mb-3">
                        <i class="fas fa-question-circle me-1"></i>
                        كيف تعمل الدفعة التلقائية؟
                    </h6>
                    <ol class="text-muted small mb-0">
                        <li class="mb-2">عند قبول طالب جديد، يتحقق النظام من وجود دفعة سابقة له</li>
                        <li class="mb-2">إذا لم يكن للطالب دفعة في السنة الحالية، يتم إنشاء دفعة جديدة</li>
                        <li class="mb-2">الدفعة تُنشأ بحالة "بانتظار الإيصال" حتى يرفع الطالب إيصال الدفع</li>
                        <li>يتم استخدام المبلغ والوصف الافتراضي المحدد أعلاه</li>
                    </ol>
                </div>
            </div>

            <!-- أزرار التحكم -->
            <div class="d-flex justify-content-between">
                <a href="<?php echo e(route('admin.payments.index')); ?>" class="btn btn-outline-secondary">
                    <i class="fas fa-times me-1"></i>
                    إلغاء
                </a>
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-save me-1"></i>
                    حفظ الإعدادات
                </button>
            </div>
        </form>
    </div>
</div>

<!-- روابط سريعة -->
<div class="row justify-content-center mt-4">
    <div class="col-lg-8">
        <div class="content-card">
            <h5 class="mb-4">
                <i class="fas fa-link text-info me-2"></i>
                روابط سريعة
            </h5>
            <div class="row">
                <div class="col-md-4 mb-3">
                    <a href="<?php echo e(route('admin.payments.bulk-create')); ?>" class="quick-link-card">
                        <i class="fas fa-layer-group text-primary mb-2"></i>
                        <span>دفعات جماعية</span>
                        <small class="text-muted">إنشاء دفعات لجهات محددة</small>
                    </a>
                </div>
                <div class="col-md-4 mb-3">
                    <a href="<?php echo e(route('admin.payments.missing')); ?>" class="quick-link-card">
                        <i class="fas fa-user-clock text-warning mb-2"></i>
                        <span>طلاب بدون دفعات</span>
                        <small class="text-muted">عرض وإنشاء دفعات للمفقودين</small>
                    </a>
                </div>
                <div class="col-md-4 mb-3">
                    <a href="<?php echo e(route('admin.payments.index')); ?>?status=pending" class="quick-link-card">
                        <i class="fas fa-clock text-info mb-2"></i>
                        <span>دفعات قيد المراجعة</span>
                        <small class="text-muted">مراجعة الإيصالات المرفوعة</small>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
<style>
    .content-card {
        background: rgba(255, 255, 255, 0.05);
        border-radius: 15px;
        padding: 1.5rem;
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
    .input-group-text {
        background: rgba(40, 167, 69, 0.2);
        border-color: rgba(255,255,255,0.2);
        color: #90EE90;
    }
    .form-check-input:checked {
        background-color: #28a745;
        border-color: #28a745;
    }
    .how-it-works {
        background: rgba(255, 255, 255, 0.03);
        border-radius: 10px;
        padding: 1rem;
        border: 1px dashed rgba(255, 255, 255, 0.1);
    }
    .how-it-works ol {
        padding-right: 1.2rem;
    }
    .quick-link-card {
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
        padding: 1.5rem;
        background: rgba(255, 255, 255, 0.03);
        border-radius: 12px;
        border: 1px solid rgba(255, 255, 255, 0.1);
        text-decoration: none;
        color: #fff;
        transition: all 0.3s ease;
    }
    .quick-link-card:hover {
        background: rgba(255, 255, 255, 0.08);
        border-color: rgba(127, 176, 105, 0.5);
        color: #fff;
        transform: translateY(-3px);
    }
    .quick-link-card i {
        font-size: 2rem;
    }
    .quick-link-card span {
        font-weight: 600;
        margin-top: 0.5rem;
    }
    .quick-link-card small {
        font-size: 0.75rem;
    }
</style>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/rasedbus/project-bus/resources/views/admin/payments/settings.blade.php ENDPATH**/ ?>