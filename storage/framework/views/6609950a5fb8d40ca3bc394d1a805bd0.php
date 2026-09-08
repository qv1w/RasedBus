

<?php $__env->startSection('title', 'أرشيف التقارير'); ?>

<?php $__env->startSection('header'); ?>
<div class="d-flex justify-content-between align-items-center w-100">
    <div>
        <h2 class="mb-1">
            <i class="fas fa-archive me-2"></i>
            أرشيف التقارير
        </h2>
        <p class="text-light opacity-75 mb-0">جميع التقارير المحفوظة</p>
    </div>
    <a href="<?php echo e(route('admin.reports')); ?>" class="btn btn-primary">
        <i class="fas fa-chart-bar me-1"></i>
        تقرير جديد
    </a>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="content-card">
    <!-- فلاتر البحث -->
    <form method="GET" class="mb-4">
        <div class="row g-3">
            <div class="col-md-4">
                <label class="form-label">بحث</label>
                <input type="text" name="search" class="form-control" 
                       placeholder="رقم التقرير أو العنوان..." 
                       value="<?php echo e(request('search')); ?>">
            </div>
            <div class="col-md-3">
                <label class="form-label">من تاريخ</label>
                <input type="date" name="date_from" class="form-control" value="<?php echo e(request('date_from')); ?>">
            </div>
            <div class="col-md-3">
                <label class="form-label">إلى تاريخ</label>
                <input type="date" name="date_to" class="form-control" value="<?php echo e(request('date_to')); ?>">
            </div>
            <div class="col-md-2 d-flex align-items-end">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="fas fa-search me-1"></i> بحث
                </button>
            </div>
        </div>
    </form>

    <!-- جدول التقارير -->
    <?php if($reports->count() > 0): ?>
    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>#</th>
                    <th>رقم التقرير</th>
                    <th>العنوان</th>
                    <th>الملاحظات</th>
                    <th>أنشئ بواسطة</th>
                    <th>تاريخ الإنشاء</th>
                    <th>الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $reports; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $report): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($reports->firstItem() + $index); ?></td>
                    <td>
                        <span class="badge bg-primary"><?php echo e($report->report_number); ?></span>
                    </td>
                    <td><?php echo e($report->title); ?></td>
                    <td><?php echo e(Str::limit($report->notes, 50) ?? '-'); ?></td>
                    <td><?php echo e($report->creator->name ?? 'غير معروف'); ?></td>
                    <td><?php echo e($report->created_at->format('Y-m-d H:i')); ?></td>
                    <td>
                        <div class="btn-group btn-group-sm">
                            <a href="<?php echo e(route('admin.reports.show', $report)); ?>" 
                               class="btn btn-outline-info" title="عرض">
                                <i class="fas fa-eye"></i>
                            </a>
                            <form action="<?php echo e(route('admin.reports.destroy', $report)); ?>" 
                                  method="POST" class="d-inline"
                                  onsubmit="return confirm('هل أنت متأكد من حذف هذا التقرير؟')">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="btn btn-outline-danger" title="حذف">
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
    <div class="d-flex justify-content-center mt-4">
        <?php echo e($reports->withQueryString()->links()); ?>

    </div>
    <?php else: ?>
    <div class="text-center py-5">
        <i class="fas fa-folder-open fa-4x text-muted mb-3"></i>
        <h5>لا توجد تقارير محفوظة</h5>
        <p class="text-muted">قم بإنشاء تقرير جديد وحفظه في الأرشيف</p>
        <a href="<?php echo e(route('admin.reports')); ?>" class="btn btn-primary">
            <i class="fas fa-plus me-1"></i> إنشاء تقرير
        </a>
    </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/rasedbus/project-bus/resources/views/admin/reports/archive.blade.php ENDPATH**/ ?>