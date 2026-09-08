

<?php $__env->startSection('title', 'تفاصيل الباص - ' . $bus->number); ?>

<?php $__env->startSection('header'); ?>
<div class="d-flex justify-content-between align-items-center w-100">
    <div>
        <h2 class="mb-1">
            <i class="fas fa-bus text-info me-2"></i>
            تفاصيل الباص: <?php echo e($bus->number); ?>

        </h2>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="<?php echo e(route('admin.dashboard')); ?>">لوحة التحكم</a></li>
                <li class="breadcrumb-item"><a href="<?php echo e(route('admin.buses.index')); ?>">الباصات</a></li>
                <li class="breadcrumb-item active"><?php echo e($bus->number); ?></li>
            </ol>
        </nav>
    </div>
    <div class="d-flex gap-2">
        <a href="<?php echo e(route('admin.buses.edit', $bus)); ?>" class="btn btn-warning">
            <i class="fas fa-edit me-1"></i>
            تعديل
        </a>
        <a href="<?php echo e(route('admin.buses.index')); ?>" class="btn btn-outline-light">
            <i class="fas fa-arrow-right me-1"></i>
            العودة
        </a>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <!-- معلومات الباص الأساسية -->
    <div class="col-lg-4">
        <!-- بطاقة الباص -->
        <div class="content-card mb-4">
            <div class="text-center mb-4">
                <div class="bus-icon-large mx-auto mb-3">
                    <i class="fas fa-bus"></i>
                </div>
                <h3 class="text-primary mb-1"><?php echo e($bus->number); ?></h3>
                <p class="text-light opacity-75 mb-2"><?php echo e($bus->plate_number); ?></p>
                
                <?php
                    $statusConfig = [
                        'active' => ['class' => 'success', 'icon' => 'check-circle', 'text' => 'نشط'],
                        'inactive' => ['class' => 'danger', 'icon' => 'times-circle', 'text' => 'غير نشط'],
                        'maintenance' => ['class' => 'warning', 'icon' => 'tools', 'text' => 'صيانة']
                    ];
                    $config = $statusConfig[$bus->status] ?? ['class' => 'secondary', 'icon' => 'question', 'text' => $bus->status];
                ?>
                <span class="badge bg-<?php echo e($config['class']); ?> px-3 py-2">
                    <i class="fas fa-<?php echo e($config['icon']); ?> me-1"></i>
                    <?php echo e($config['text']); ?>

                </span>
            </div>

            <hr class="border-secondary">

            <div class="info-list">
                <div class="info-item">
                    <span class="info-label"><i class="fas fa-car me-2"></i>الموديل</span>
                    <span class="info-value"><?php echo e($bus->model ?? 'غير محدد'); ?></span>
                </div>
                <div class="info-item">
                    <span class="info-label"><i class="fas fa-school me-2"></i>عدد الجهات</span>
                    <span class="info-value"><?php echo e($bus->centers->count()); ?> جهة</span>
                </div>
                <div class="info-item">
                    <span class="info-label"><i class="fas fa-calendar me-2"></i>تاريخ الإضافة</span>
                    <span class="info-value"><?php echo e($bus->created_at->format('Y/m/d')); ?></span>
                </div>
                <?php if($bus->notes): ?>
                <div class="info-item">
                    <span class="info-label"><i class="fas fa-sticky-note me-2"></i>ملاحظات</span>
                    <span class="info-value"><?php echo e($bus->notes); ?></span>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- بطاقة السائق -->
        <div class="content-card mb-4">
            <h5 class="mb-3">
                <i class="fas fa-user-tie text-warning me-2"></i>
                السائق
            </h5>
            
            <?php if($bus->driver): ?>
                <div class="driver-card">
                    <div class="d-flex align-items-center mb-3">
                        <div class="driver-avatar me-3">
                            <i class="fas fa-user"></i>
                        </div>
                        <div>
                            <h6 class="mb-0 text-light"><?php echo e($bus->driver->name); ?></h6>
                            <small class="text-muted"><?php echo e($bus->driver->driver_id ?? ''); ?></small>
                        </div>
                        <span class="badge bg-<?php echo e($bus->driver->status == 'active' ? 'success' : 'secondary'); ?> ms-auto">
                            <?php echo e($bus->driver->status == 'active' ? 'نشط' : 'غير نشط'); ?>

                        </span>
                    </div>
                    
                    <div class="info-list small">
                        <div class="info-item">
                            <span class="info-label"><i class="fas fa-phone me-2"></i>الجوال</span>
                            <span class="info-value">
                                <a href="tel:<?php echo e($bus->driver->mobile); ?>" class="text-info">
                                    <?php echo e($bus->driver->mobile); ?>

                                </a>
                            </span>
                        </div>
                    </div>
                    
                    <a href="<?php echo e(route('admin.drivers.show', $bus->driver)); ?>" class="btn btn-sm btn-outline-info w-100 mt-3">
                        <i class="fas fa-eye me-1"></i>
                        عرض تفاصيل السائق
                    </a>
                </div>
            <?php else: ?>
                <div class="text-center py-4">
                    <i class="fas fa-user-slash fa-3x text-muted opacity-50 mb-3"></i>
                    <p class="text-muted mb-3">لا يوجد سائق مخصص</p>
                    <a href="<?php echo e(route('admin.buses.edit', $bus)); ?>" class="btn btn-sm btn-outline-warning">
                        <i class="fas fa-plus me-1"></i>
                        تخصيص سائق
                    </a>
                </div>
            <?php endif; ?>
        </div>

        <!-- الجهات التعليمية -->
        <div class="content-card">
            <h5 class="mb-3">
                <i class="fas fa-school text-info me-2"></i>
                الجهات التعليمية
                <span class="badge bg-info ms-2"><?php echo e($bus->centers->count()); ?></span>
            </h5>
            
            <?php if($bus->centers->count() > 0): ?>
                <?php $__currentLoopData = $bus->centers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $center): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                    $capacity = $center->pivot->capacity;
                    $current = $center->pivot->current_students;
                    $available = $capacity - $current;
                    $percentage = $capacity > 0 ? round(($current / $capacity) * 100) : 0;
                    $progressColor = $percentage >= 90 ? 'danger' : ($percentage >= 70 ? 'warning' : 'success');
                ?>
                <div class="center-info-card mb-3">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <div>
                            <strong class="text-light"><?php echo e($center->center_name); ?></strong>
                            <br>
                            <small class="text-muted">
                                <i class="fas fa-clock me-1"></i>
                                <?php echo e($center->pivot->schedule == 'both' ? 'صباحي ومسائي' : ($center->pivot->schedule == 'morning' ? 'صباحي' : 'مسائي')); ?>

                            </small>
                        </div>
                        <span class="badge bg-<?php echo e($progressColor); ?>"><?php echo e($percentage); ?>%</span>
                    </div>
                    
                    <div class="progress mb-2" style="height: 8px;">
                        <div class="progress-bar bg-<?php echo e($progressColor); ?>" style="width: <?php echo e($percentage); ?>%"></div>
                    </div>
                    
                    <div class="d-flex justify-content-between small">
                        <span class="text-success">
                            <i class="fas fa-chair me-1"></i>
                            متاح: <?php echo e($available); ?>

                        </span>
                        <span class="text-info">
                            <i class="fas fa-users me-1"></i>
                            <?php echo e($current); ?>/<?php echo e($capacity); ?>

                        </span>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php else: ?>
                <div class="text-center py-3">
                    <p class="text-muted mb-0">لا توجد جهات مرتبطة</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- قائمة الطالبات -->
    <div class="col-lg-8">
        <!-- إضافة طالبات -->
        <?php if($bus->status === 'active' && $bus->centers->sum('pivot.capacity') > $bus->centers->sum('pivot.current_students')): ?>
        <div class="content-card mb-4">
            <a href="<?php echo e(route('admin.buses.assign-students', $bus)); ?>" class="btn btn-success">
                <i class="fas fa-plus me-2"></i>
                إضافة طالبات للباص
            </a>
        </div>
        <?php endif; ?>

        <!-- الطالبات مجمعة حسب الجهة -->
        <?php $__currentLoopData = $bus->centers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $center): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php
            $centerStudents = $bus->students->where('center_id', $center->id);
            $capacity = $center->pivot->capacity;
            $current = $centerStudents->count();
            $available = $capacity - $current;
            $percentage = $capacity > 0 ? round(($current / $capacity) * 100) : 0;
            $progressColor = $percentage >= 90 ? 'danger' : ($percentage >= 70 ? 'warning' : 'success');
        ?>
        <div class="content-card mb-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h5 class="mb-1">
                        <i class="fas fa-school text-info me-2"></i>
                        <?php echo e($center->center_name); ?>

                    </h5>
                    <div class="d-flex align-items-center gap-3">
                        <small class="text-muted">
                            <i class="fas fa-clock me-1"></i>
                            <?php echo e($center->pivot->schedule == 'both' ? 'صباحي ومسائي' : ($center->pivot->schedule == 'morning' ? 'صباحي' : 'مسائي')); ?>

                        </small>
                        <span class="badge bg-<?php echo e($progressColor); ?>">
                            <?php echo e($current); ?>/<?php echo e($capacity); ?> طالبة
                        </span>
                        <?php if($available > 0): ?>
                        <span class="badge bg-success">
                            <?php echo e($available); ?> متاح
                        </span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <?php if($centerStudents->count() > 0): ?>
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr>
                                <th width="5%">#</th>
                                <th width="30%">الطالبة</th>
                                <th width="20%">الجوال</th>
                                <th width="25%">نقطة الالتقاء</th>
                                <th width="20%">إجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $centerStudents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($index + 1); ?></td>
                                    <td>
                                        <div>
                                            <strong><?php echo e($student->name); ?></strong>
                                            <br>
                                            <small class="text-muted"><?php echo e($student->student_id); ?></small>
                                        </div>
                                    </td>
                                    <td>
                                        <a href="tel:<?php echo e($student->mobile); ?>" class="text-info">
                                            <?php echo e($student->mobile); ?>

                                        </a>
                                    </td>
                                    <td>
                                        <?php if($student->pickup_point): ?>
                                            <span class="text-light"><?php echo e($student->pickup_point); ?></span>
                                            <?php if($student->pickup_time): ?>
                                            <br><small class="text-muted"><?php echo e($student->pickup_time); ?></small>
                                            <?php endif; ?>
                                        <?php else: ?>
                                            <span class="text-muted">غير محدد</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <a href="<?php echo e(route('admin.students.show', $student)); ?>" 
                                               class="btn btn-outline-info" title="عرض">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <button type="button" 
                                                    class="btn btn-outline-warning"
                                                    onclick="editPickup(<?php echo e($student->id); ?>, '<?php echo e($student->pickup_point); ?>', '<?php echo e($student->pickup_time); ?>')"
                                                    title="تعديل نقطة الالتقاء">
                                                <i class="fas fa-map-marker-alt"></i>
                                            </button>
                                            <form action="<?php echo e(route('admin.buses.remove-student', [$bus, $student])); ?>" 
                                                  method="POST" class="d-inline"
                                                  onsubmit="return confirm('هل أنت متأكد من إزالة <?php echo e($student->name); ?> من الباص؟')">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('DELETE'); ?>
                                                <button type="submit" class="btn btn-outline-danger" title="إزالة">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="text-center py-4">
                    <i class="fas fa-users fa-3x text-muted opacity-50 mb-3"></i>
                    <p class="text-muted mb-0">لا توجد طالبات لهذه الجهة</p>
                    <small class="text-muted">المقاعد المتاحة: <?php echo e($available); ?></small>
                </div>
            <?php endif; ?>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        <?php if($bus->centers->count() == 0): ?>
        <div class="content-card">
            <div class="text-center py-5">
                <i class="fas fa-school fa-4x text-muted opacity-50 mb-3"></i>
                <h5 class="text-muted">لا توجد جهات مرتبطة</h5>
                <p class="text-muted mb-4">يرجى إضافة جهات تعليمية للباص أولاً</p>
                <a href="<?php echo e(route('admin.buses.edit', $bus)); ?>" class="btn btn-primary">
                    <i class="fas fa-edit me-2"></i>
                    تعديل الباص
                </a>
            </div>
        </div>
        <?php endif; ?>

        <!-- إزالة جميع الطالبات -->
        <?php if($bus->students->count() > 0): ?>
        <div class="content-card">
            <div class="d-flex justify-content-between align-items-center">
                <spa
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/rasedbus/project-bus/resources/views/admin/buses/show.blade.php ENDPATH**/ ?>