

<?php $__env->startSection('title', 'إدارة الباصات'); ?>

<?php $__env->startSection('header'); ?>
<div class="d-flex justify-content-between align-items-center w-100">
    <div>
        <h2 class="mb-1">
            <i class="fas fa-bus me-2"></i>
            إدارة الباصات
        </h2>
        <p class="text-light opacity-75 mb-0">إدارة وتنظيم باصات النقل للطالبات</p>
    </div>
    <a href="<?php echo e(route('admin.buses.create')); ?>" class="btn btn-primary">
        <i class="fas fa-plus me-1"></i>
        إضافة باص جديد
    </a>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<?php
    $totalBuses = $buses->total();
    $activeBuses = $buses->where('status', 'active')->count();
    $totalStudents = $buses->sum('students_count');
?>

<div class="row mb-4">
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="stats-card">
            <div class="d-flex align-items-center">
                <div class="stats-icon bg-primary bg-opacity-20 me-3">
                    <i class="fas fa-bus fa-lg text-primary"></i>
                </div>
                <div>
                    <h3 class="mb-0"><?php echo e($totalBuses); ?></h3>
                    <small class="text-muted">إجمالي الباصات</small>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="stats-card">
            <div class="d-flex align-items-center">
                <div class="stats-icon bg-success bg-opacity-20 me-3">
                    <i class="fas fa-check-circle fa-lg text-success"></i>
                </div>
                <div>
                    <h3 class="mb-0"><?php echo e($activeBuses); ?></h3>
                    <small class="text-muted">الباصات النشطة</small>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="stats-card">
            <div class="d-flex align-items-center">
                <div class="stats-icon bg-info bg-opacity-20 me-3">
                    <i class="fas fa-user-graduate fa-lg text-info"></i>
                </div>
                <div>
                    <h3 class="mb-0"><?php echo e($totalStudents); ?></h3>
                    <small class="text-muted">إجمالي الطالبات</small>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="stats-card">
            <div class="d-flex align-items-center">
                <div class="stats-icon bg-warning bg-opacity-20 me-3">
                    <i class="fas fa-school fa-lg text-warning"></i>
                </div>
                <div>
                    <h3 class="mb-0"><?php echo e(\App\Models\Center::where('status', 'active')->count()); ?></h3>
                    <small class="text-muted">الجهات التعليمية</small>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="content-card">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h5 class="mb-0">
            <i class="fas fa-list me-2"></i>
            قائمة الباصات
        </h5>
    </div>

    <?php if($buses->count() > 0): ?>
    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>#</th>
                    <th>رقم الباص</th>
                    <th>الموديل</th>
                    <th>الجهات</th>
                    <th>السائق</th>
                    <th>الطالبات</th>
                    <th>الحالة</th>
                    <th>الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $buses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bus): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($loop->iteration); ?></td>
                    <td>
                        <div class="d-flex align-items-center">
                            <div class="icon-box me-2">
                                <i class="fas fa-bus text-primary"></i>
                            </div>
                            <div>
                                <strong><?php echo e($bus->number); ?></strong>
                                <?php if($bus->plate_number): ?>
                                <br><small class="text-muted"><?php echo e($bus->plate_number); ?></small>
                                <?php endif; ?>
                            </div>
                        </div>
                    </td>
                    <td>
                        <i class="fas fa-car text-muted me-1"></i>
                        <?php echo e($bus->model ?? 'غير محدد'); ?>

                    </td>
                    <td>
                        <?php if($bus->centers->count() > 0): ?>
                            <?php $__currentLoopData = $bus->centers->take(2); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $center): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="mb-1">
                                    <span class="badge bg-info">
                                        <?php echo e($center->center_name); ?>

                                    </span>
                                    <small class="text-muted">
                                        (<?php echo e($center->pivot->current_students); ?>/<?php echo e($center->pivot->capacity); ?>)
                                    </small>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php if($bus->centers->count() > 2): ?>
                                <small class="text-muted">+<?php echo e($bus->centers->count() - 2); ?> أخرى</small>
                            <?php endif; ?>
                        <?php else: ?>
                            <span class="text-muted">غير مرتبط</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if($bus->driver): ?>
                        <div class="d-flex align-items-center">
                            <i class="fas fa-user text-success me-2"></i>
                            <div>
                                <span><?php echo e($bus->driver->name); ?></span>
                                <br><small class="text-muted"><?php echo e($bus->driver->mobile); ?></small>
                            </div>
                        </div>
                        <?php else: ?>
                        <span class="text-muted">
                            <i class="fas fa-user-slash me-1"></i>
                            بدون سائق
                        </span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php
                            $totalCapacity = $bus->centers->sum('pivot.capacity');
                            $totalStudents = $bus->centers->sum('pivot.current_students');
                            $percentage = $totalCapacity > 0 ? ($totalStudents / $totalCapacity * 100) : 0;
                            $color = $percentage >= 90 ? 'danger' : ($percentage >= 70 ? 'warning' : 'success');
                        ?>
                        <div style="min-width: 100px;">
                            <div class="d-flex justify-content-between mb-1">
                                <small><?php echo e($totalStudents); ?>/<?php echo e($totalCapacity); ?></small>
                                <small><?php echo e(round($percentage)); ?>%</small>
                            </div>
                            <div class="progress" style="height: 6px;">
                                <div class="progress-bar bg-<?php echo e($color); ?>" style="width: <?php echo e($percentage); ?>%"></div>
                            </div>
                            <small class="text-muted"><?php echo e($bus->centers->count()); ?> جهة</small>
                        </div>
                    </td>
                    <td>
                        <?php
                            $statusColors = ['active' => 'success', 'inactive' => 'danger', 'maintenance' => 'warning'];
                            $statusTexts = ['active' => 'نشط', 'inactive' => 'متوقف', 'maintenance' => 'صيانة'];
                        ?>
                        <span class="badge bg-<?php echo e($statusColors[$bus->status] ?? 'secondary'); ?>">
                            <?php echo e($statusTexts[$bus->status] ?? $bus->status); ?>

                        </span>
                    </td>
                    <td>
                        <div class="btn-group">
                            <a href="<?php echo e(route('admin.buses.show', $bus)); ?>" 
                               class="btn btn-sm btn-outline-info" title="عرض">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="<?php echo e(route('admin.buses.edit', $bus)); ?>" 
                               class="btn btn-sm btn-outline-warning" title="تعديل">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="<?php echo e(route('admin.buses.destroy', $bus)); ?>" method="POST" 
                                  class="d-inline" onsubmit="return confirm('هل أنت متأكد من الحذف؟')">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="btn btn-sm btn-outline-danger" title="حذف"
                                        <?php echo e($bus->students_count > 0 ? 'disabled' : ''); ?>>
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
    
    <div class="d-flex justify-content-center mt-4">
        <?php echo e($buses->links('vendor.pagination.bootstrap-5')); ?>

    </div>
    <?php else: ?>
    <div class="text-center py-5">
        <i class="fas fa-bus fa-4x text-muted opacity-50 mb-3"></i>
        <h5>لا توجد باصات</h5>
        <p class="text-muted">لم يتم إضافة أي باص بعد</p>
        <a href="<?php echo e(route('admin.buses.create')); ?>" class="btn btn-primary">
            <i class="fas fa-plus me-1"></i>
            إضافة باص جديد
        </a>
    </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
<style>
.icon-box {
    width: 40px;
    height: 40px;
    border-radius: 10px;
    background: rgba(13, 202, 240, 0.2);
    display: flex;
    align-items: center;
    justify-content: center;
}

.stats-card {
    background: rgba(255,255,255,0.05);
    border-radius: 12px;
    padding: 1.25rem;
    border: 1px solid rgba(255,255,255,0.1);
}

.stats-icon {
    width: 50px;
    height: 50px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
}
</style>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\project-bus\resources\views/admin/buses/index.blade.php ENDPATH**/ ?>