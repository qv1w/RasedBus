<?php $__env->startSection('title', 'إدارة الدفعات'); ?>

<?php $__env->startSection('header'); ?>
<div class="d-flex justify-content-between align-items-center w-100">
    <div>
        <h2 class="mb-1">
            <i class="fas fa-credit-card text-success me-2"></i>
            إدارة الدفعات
        </h2>
        <p class="text-light mb-0 opacity-75">
            إدارة ومتابعة دفعات الطلاب
        </p>
    </div>
    <div class="d-flex gap-2 flex-wrap">
        <!-- زر الإعدادات -->
        <a href="<?php echo e(route('admin.payments.settings')); ?>" class="btn btn-outline-info" title="الإعدادات">
            <i class="fas fa-cog"></i>
        </a>
        <!-- زر الطلاب بدون دفعات -->
        <a href="<?php echo e(route('admin.payments.missing')); ?>" class="btn btn-warning">
            <i class="fas fa-user-clock me-1"></i>
            <span class="d-none d-md-inline">بدون دفعات</span>
        </a>
        <!-- زر الدفعات الجماعية -->
        <a href="<?php echo e(route('admin.payments.bulk-create')); ?>" class="btn btn-primary">
            <i class="fas fa-layer-group me-1"></i>
            <span class="d-none d-md-inline">دفعات جماعية</span>
        </a>
        <!-- زر إضافة دفعة فردية -->
        <a href="<?php echo e(route('admin.payments.create')); ?>" class="btn btn-success">
            <i class="fas fa-plus me-1"></i>
            <span class="d-none d-md-inline">إضافة دفعة</span>
        </a>
    </div>
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

<!-- إحصائيات -->
<div class="row mb-4">
    <div class="col-lg-2 col-md-4 mb-3">
        <div class="stats-card text-center">
            <i class="fas fa-list fa-2x text-info mb-2"></i>
            <h3 class="text-info mb-0"><?php echo e($stats['total']); ?></h3>
            <small class="text-muted">الإجمالي</small>
        </div>
    </div>
    <div class="col-lg-2 col-md-4 mb-3">
        <div class="stats-card text-center">
            <i class="fas fa-upload fa-2x text-primary mb-2"></i>
            <h3 class="text-primary mb-0"><?php echo e($stats['awaiting_receipt']); ?></h3>
            <small class="text-muted">بانتظار الإيصال</small>
        </div>
    </div>
    <div class="col-lg-2 col-md-4 mb-3">
        <div class="stats-card text-center">
            <i class="fas fa-clock fa-2x text-warning mb-2"></i>
            <h3 class="text-warning mb-0"><?php echo e($stats['pending']); ?></h3>
            <small class="text-muted">قيد المراجعة</small>
        </div>
    </div>
    <div class="col-lg-2 col-md-4 mb-3">
        <div class="stats-card text-center">
            <i class="fas fa-check-circle fa-2x text-success mb-2"></i>
            <h3 class="text-success mb-0"><?php echo e($stats['approved']); ?></h3>
            <small class="text-muted">مقبولة</small>
        </div>
    </div>
    <div class="col-lg-2 col-md-4 mb-3">
        <div class="stats-card text-center">
            <i class="fas fa-times-circle fa-2x text-danger mb-2"></i>
            <h3 class="text-danger mb-0"><?php echo e($stats['rejected']); ?></h3>
            <small class="text-muted">مرفوضة</small>
        </div>
    </div>
    <div class="col-lg-2 col-md-4 mb-3">
        <div class="stats-card text-center">
            <i class="fas fa-money-bill-wave fa-2x text-success mb-2"></i>
            <h3 class="text-success mb-0"><?php echo e(number_format($stats['total_amount'])); ?></h3>
            <small class="text-muted">المحصّل (ريال)</small>
        </div>
    </div>
</div>

<!-- فلتر البحث -->
<div class="content-card mb-4">
    <form method="GET" action="<?php echo e(route('admin.payments.index')); ?>" class="row g-3">
        <div class="col-md-4">
            <label class="form-label">بحث</label>
            <input type="text" class="form-control" name="search" value="<?php echo e(request('search')); ?>" 
                   placeholder="رقم الدفعة أو اسم الطالب...">
        </div>
        <div class="col-md-3">
            <label class="form-label">الحالة</label>
            <select class="form-select" name="status">
                <option value="">كل الحالات</option>
                <option value="awaiting_receipt" <?php echo e(request('status') == 'awaiting_receipt' ? 'selected' : ''); ?>>بانتظار الإيصال</option>
                <option value="pending" <?php echo e(request('status') == 'pending' ? 'selected' : ''); ?>>قيد المراجعة</option>
                <option value="approved" <?php echo e(request('status') == 'approved' ? 'selected' : ''); ?>>مقبولة</option>
                <option value="rejected" <?php echo e(request('status') == 'rejected' ? 'selected' : ''); ?>>مرفوضة</option>
            </select>
        </div>
        <div class="col-md-3">
            <label class="form-label">الجهة التعليمية</label>
            <select class="form-select" name="center_id">
                <option value="">كل الجهات</option>
                <?php
                    $centers = \App\Models\Center::where('status', 'active')->orderBy('type')->orderBy('center_name')->get();
                ?>
                <?php $__currentLoopData = $centers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $center): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($center->id); ?>" <?php echo e(request('center_id') == $center->id ? 'selected' : ''); ?>>
                        <?php echo e($center->center_name); ?>

                    </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
        <div class="col-md-2 d-flex align-items-end gap-2">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-search me-1"></i>بحث
            </button>
            <a href="<?php echo e(route('admin.payments.index')); ?>" class="btn btn-outline-light">
                <i class="fas fa-times"></i>
            </a>
        </div>
    </form>
</div>

<!-- جدول الدفعات -->
<div class="content-card">
    <?php if($payments->count() > 0): ?>
    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead>
                <tr>
                    <th>رقم الدفعة</th>
                    <th>الطالب/ة</th>
                    <th>الجهة</th>
                    <th>المبلغ</th>
                    <th>تاريخ الاستحقاق</th>
                    <th>الإيصال</th>
                    <th>الحالة</th>
                    <th>العمليات</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $payments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                    $center = $payment->student && $payment->student->center ? $payment->student->center : null;
                    $typeClass = $center ? (['دار' => 'dar', 'مركز' => 'markaz', 'برنامج' => 'program'][$center->type] ?? 'secondary') : 'secondary';
                    $typeIcon = $center ? (['دار' => 'mosque', 'مركز' => 'graduation-cap', 'برنامج' => 'seedling'][$center->type] ?? 'school') : 'school';
                ?>
                <tr>
                    <td>
                        <span class="badge bg-secondary"><?php echo e($payment->payment_number); ?></span>
                    </td>
                    <td>
                        <?php if($payment->student): ?>
                        <div>
                            <strong class="text-white"><?php echo e($payment->student->name); ?></strong>
                            <br>
                            <small class="text-muted"><?php echo e($payment->student->student_id); ?></small>
                        </div>
                        <?php else: ?>
                        <span class="text-muted">-</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if($center): ?>
                        <span class="badge badge-type-<?php echo e($typeClass); ?>">
                            <i class="fas fa-<?php echo e($typeIcon); ?> me-1"></i>
                            <?php echo e($center->center_name); ?>

                        </span>
                        <?php else: ?>
                        <span class="text-muted">-</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <span class="text-success fw-bold"><?php echo e(number_format($payment->amount, 2)); ?> ريال</span>
                    </td>
                    <td>
                        <?php if($payment->due_date): ?>
                            <?php echo e(\Carbon\Carbon::parse($payment->due_date)->format('Y/m/d')); ?>

                        <?php else: ?>
                            <span class="text-muted">-</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if($payment->receipt_image): ?>
                            <a href="<?php echo e(asset('storage/' . $payment->receipt_image)); ?>" target="_blank" class="btn btn-sm btn-outline-info">
                                <i class="fas fa-eye me-1"></i>عرض
                            </a>
                        <?php else: ?>
                            <span class="badge bg-secondary">لم يُرفع</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php
                            $statusColors = [
                                'awaiting_receipt' => 'primary',
                                'pending' => 'warning',
                                'approved' => 'success',
                                'rejected' => 'danger'
                            ];
                            $statusTexts = [
                                'awaiting_receipt' => 'بانتظار الإيصال',
                                'pending' => 'قيد المراجعة',
                                'approved' => 'مقبولة',
                                'rejected' => 'مرفوضة'
                            ];
                        ?>
                        <span class="badge bg-<?php echo e($statusColors[$payment->status] ?? 'secondary'); ?>">
                            <?php echo e($statusTexts[$payment->status] ?? $payment->status); ?>

                        </span>
                    </td>
                    <td>
                        <div class="btn-group">
                            <?php if($payment->status == 'pending' && $payment->receipt_image): ?>
                            <form action="<?php echo e(route('admin.payments.approve', $payment)); ?>" method="POST" class="d-inline">
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="btn btn-sm btn-outline-success" title="قبول">
                                    <i class="fas fa-check"></i>
                                </button>
                            </form>
                            <button type="button" class="btn btn-sm btn-outline-danger" title="رفض"
                                    onclick="showRejectModal(<?php echo e($payment->id); ?>)">
                                <i class="fas fa-times"></i>
                            </button>
                            <?php endif; ?>
                            
                            <a href="<?php echo e(route('admin.payments.edit', $payment)); ?>" class="btn btn-sm btn-outline-warning" title="تعديل">
                                <i class="fas fa-edit"></i>
                            </a>
                            
                            <form action="<?php echo e(route('admin.payments.destroy', $payment)); ?>" method="POST" class="d-inline">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="btn btn-sm btn-outline-danger" title="حذف"
                                        onclick="return confirm('هل تريد حذف هذه الدفعة؟')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>

    <!-- الترقيم -->
    <?php if(method_exists($payments, 'links')): ?>
    <div class="d-flex justify-content-center mt-4">
        <?php echo e($payments->withQueryString()->links()); ?>

    </div>
    <?php endif; ?>

    <?php else: ?>
    <div class="text-center py-5">
        <i class="fas fa-credit-card fa-4x text-muted opacity-50 mb-3"></i>
        <h4 class="text-light">لا توجد دفعات</h4>
        <p class="text-muted">لم يتم العثور على دفعات تطابق معايير البحث</p>
        <div class="d-flex justify-content-center gap-2 mt-3">
            <a href="<?php echo e(route('admin.payments.bulk-create')); ?>" class="btn btn-primary">
                <i class="fas fa-layer-group me-1"></i>إنشاء دفعات جماعية
            </a>
            <a href="<?php echo e(route('admin.payments.create')); ?>" class="btn btn-success">
                <i class="fas fa-plus me-1"></i>إضافة دفعة فردية
            </a>
        </div>
    </div>
    <?php endif; ?>
</div>

<!-- Modal الرفض -->
<div class="modal fade" id="rejectModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content bg-dark">
            <form id="rejectForm" method="POST">
                <?php echo csrf_field(); ?>
                <div class="modal-header border-secondary">
                    <h5 class="modal-title text-danger">
                        <i class="fas fa-times-circle me-2"></i>رفض الدفعة
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">سبب الرفض <span class="text-danger">*</span></label>
                        <textarea name="rejection_reason" class="form-control" rows="3" required
                                  placeholder="اكتب سبب رفض الدفعة..."></textarea>
                    </div>
                </div>
                <div class="modal-footer border-secondary">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                    <button type="submit" class="btn btn-danger">رفض الدفعة</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
<style>
    .stats-card {
        background: rgba(255, 255, 255, 0.05);
        border-radius: 15px;
        padding: 1.5rem;
        border: 1px solid rgba(127, 176, 105, 0.2);
    }
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
    }
    
    /* ألوان الأنواع */
    .badge-type-dar {
        background: rgba(176, 39, 39, 0.15) !important;
        color: #c86868 !important;
        border: 1px solid rgba(176, 39, 39, 0.3) !important;
    }
    .badge-type-markaz {
        background: rgba(255, 152, 0, 0.15) !important;
        color: #ffb74d !important;
        border: 1px solid rgba(255, 152, 0, 0.3) !important;
    }
    .badge-type-program {
        background: rgba(76, 175, 80, 0.15) !important;
        color: #81c784 !important;
        border: 1px solid rgba(76, 175, 80, 0.3) !important;
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
function showRejectModal(paymentId) {
    document.getElementById('rejectForm').action = `/admin/payments/${paymentId}/reject`;
    const modal = new bootstrap.Modal(document.getElementById('rejectModal'));
    modal.show();
}
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\project-bus\resources\views/admin/payments/index.blade.php ENDPATH**/ ?>