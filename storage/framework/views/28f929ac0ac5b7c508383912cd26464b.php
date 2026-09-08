

<?php $__env->startSection('title', 'تفاصيل الباص - ' . $bus->number); ?>

<?php
    // حساب الإحصائيات داخلياً
    $currentStudents = $bus->students->count();
    $capacity = $bus->capacity;
    $available = $capacity - $currentStudents;
    $percentage = $capacity > 0 ? round(($currentStudents / $capacity) * 100) : 0;
    $progressColor = $percentage > 80 ? 'danger' : ($percentage > 50 ? 'warning' : 'success');
?>

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
                    <span class="info-label"><i class="fas fa-chair me-2"></i>السعة</span>
                    <span class="info-value"><?php echo e($bus->capacity); ?> مقعد</span>
                </div>
                <div class="info-item">
                    <span class="info-label"><i class="fas fa-school me-2"></i>المركز</span>
                    <span class="info-value">
                        <?php if($bus->center): ?>
                            <span class="badge bg-info"><?php echo e($bus->center->center_name); ?></span>
                        <?php else: ?>
                            <span class="text-muted">غير مخصص</span>
                        <?php endif; ?>
                    </span>
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
                        <span class="badge bg-<?php echo e($bus->driver->status_color); ?> ms-auto">
                            <?php echo e($bus->driver->status_name); ?>

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
                        <?php if($bus->driver->license_number): ?>
                        <div class="info-item">
                            <span class="info-label"><i class="fas fa-id-card me-2"></i>رقم الرخصة</span>
                            <span class="info-value"><?php echo e($bus->driver->license_number); ?></span>
                        </div>
                        <?php endif; ?>
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

        <!-- إحصائيات الإشغال -->
        <div class="content-card">
            <h5 class="mb-3">
                <i class="fas fa-chart-pie text-success me-2"></i>
                الإشغال
            </h5>
            
            <?php
                $currentStudents = $bus->students->count();
                $capacity = $bus->capacity;
                $available = $capacity - $currentStudents;
                $percentage = $capacity > 0 ? round(($currentStudents / $capacity) * 100) : 0;
                $progressColor = $percentage > 80 ? 'danger' : ($percentage > 50 ? 'warning' : 'success');
            ?>
            
            <div class="occupancy-chart text-center mb-4">
                <div class="circular-progress" style="--progress: <?php echo e($percentage); ?>%; --color: var(--bs-<?php echo e($progressColor); ?>);">
                    <span class="progress-value"><?php echo e($percentage); ?>%</span>
                </div>
            </div>
            
            <div class="row text-center">
                <div class="col-4">
                    <h4 class="text-primary mb-0"><?php echo e($currentStudents); ?></h4>
                    <small class="text-muted">مشغول</small>
                </div>
                <div class="col-4">
                    <h4 class="text-success mb-0"><?php echo e($available); ?></h4>
                    <small class="text-muted">متاح</small>
                </div>
                <div class="col-4">
                    <h4 class="text-light mb-0"><?php echo e($capacity); ?></h4>
                    <small class="text-muted">الكلي</small>
                </div>
            </div>
        </div>
    </div>

    <!-- قائمة الطالبات -->
    <div class="col-lg-8">
        <div class="content-card">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="mb-0">
                    <i class="fas fa-user-graduate text-info me-2"></i>
                    الطالبات المخصصات
                    <span class="badge bg-info ms-2"><?php echo e($bus->students->count()); ?></span>
                </h5>
                
                <?php if($bus->status === 'active' && $available > 0): ?>
                    <a href="<?php echo e(route('admin.buses.assign-students', $bus)); ?>" class="btn btn-success btn-sm">
                        <i class="fas fa-plus me-1"></i>
                        إضافة طالبات
                    </a>
                <?php endif; ?>
            </div>

            <?php if($bus->students->count() > 0): ?>
                <div class="table-responsive">
                    <table class="table table-dark table-hover align-middle">
                        <thead>
                            <tr>
                                <th width="5%">#</th>
                                <th width="25%">الطالبة</th>
                                <th width="20%">الجوال</th>
                                <th width="20%">نقطة الالتقاء</th>
                                <th width="15%">الوقت</th>
                                <th width="15%">إجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $bus->students; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
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
                                        <?php else: ?>
                                            <span class="text-muted">غير محدد</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if($student->pickup_time): ?>
                                            <span class="badge bg-secondary"><?php echo e($student->pickup_time); ?></span>
                                        <?php else: ?>
                                            <span class="text-muted">-</span>
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

                <!-- إجراءات جماعية -->
                <div class="d-flex justify-content-between align-items-center mt-3 pt-3 border-top border-secondary">
                    <span class="text-muted">
                        <i class="fas fa-info-circle me-1"></i>
                        <?php echo e($bus->students->count()); ?> طالبة من أصل <?php echo e($bus->capacity); ?>

                    </span>
                    
                    <?php if($bus->students->count() > 0): ?>
                        <form action="<?php echo e(route('admin.buses.remove-all-students', $bus)); ?>" 
                              method="POST"
                              onsubmit="return confirm('⚠️ تحذير!\n\nسيتم إزالة جميع الطالبات (<?php echo e($bus->students->count()); ?>) من هذا الباص.\n\nهل أنت متأكد؟')">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button type="submit" class="btn btn-outline-danger btn-sm">
                                <i class="fas fa-trash me-1"></i>
                                إزالة جميع الطالبات
                            </button>
                        </form>
                    <?php endif; ?>
                </div>
            <?php else: ?>
                <div class="text-center py-5">
                    <i class="fas fa-users fa-4x text-muted opacity-50 mb-3"></i>
                    <h5 class="text-muted">لا توجد طالبات مخصصات</h5>
                    <p class="text-muted mb-4">المقاعد المتاحة: <?php echo e($available); ?></p>
                    
                    <?php if($bus->status === 'active'): ?>
                        <a href="<?php echo e(route('admin.buses.assign-students', $bus)); ?>" class="btn btn-success">
                            <i class="fas fa-plus me-2"></i>
                            إضافة طالبات
                        </a>
                    <?php else: ?>
                        <div class="alert alert-warning d-inline-block">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            يجب تفعيل الباص أولاً لإضافة طالبات
                        </div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Modal تعديل نقطة الالتقاء -->
<div class="modal fade" id="editPickupModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content bg-dark">
            <form id="editPickupForm" method="POST">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>
                <div class="modal-header border-secondary">
                    <h5 class="modal-title">
                        <i class="fas fa-map-marker-alt text-warning me-2"></i>
                        تعديل نقطة الالتقاء
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">نقطة الالتقاء</label>
                        <input type="text" name="pickup_point" id="pickupPoint" class="form-control"
                               placeholder="مثال: أمام مسجد الرحمة">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">وقت الالتقاء</label>
                        <input type="time" name="pickup_time" id="pickupTime" class="form-control">
                    </div>
                </div>
                <div class="modal-footer border-secondary">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                    <button type="submit" class="btn btn-warning">
                        <i class="fas fa-save me-1"></i>
                        حفظ
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
<style>
.bus-icon-large {
    width: 100px;
    height: 100px;
    background: linear-gradient(135deg, #0dcaf0 0%, #0aa2c0 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2.5rem;
    color: white;
    box-shadow: 0 10px 30px rgba(13, 202, 240, 0.3);
}

.info-list .info-item {
    display: flex;
    justify-content: space-between;
    padding: 0.75rem 0;
    border-bottom: 1px solid rgba(255,255,255,0.1);
}

.info-list .info-item:last-child {
    border-bottom: none;
}

.info-label {
    color: rgba(255,255,255,0.6);
}

.info-value {
    color: #fff;
    font-weight: 500;
}

.driver-card {
    background: rgba(255,255,255,0.05);
    border-radius: 10px;
    padding: 1rem;
}

.driver-avatar {
    width: 50px;
    height: 50px;
    background: linear-gradient(135deg, #ffc107 0%, #cc9a06 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #000;
    font-size: 1.25rem;
}

.circular-progress {
    width: 120px;
    height: 120px;
    border-radius: 50%;
    background: conic-gradient(var(--color) var(--progress), rgba(255,255,255,0.1) 0);
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto;
    position: relative;
}

.circular-progress::before {
    content: '';
    position: absolute;
    width: 90px;
    height: 90px;
    background: var(--bs-dark);
    border-radius: 50%;
}

.progress-value {
    position: relative;
    z-index: 1;
    font-size: 1.5rem;
    font-weight: bold;
    color: #fff;
}
 
.content-card {
    background: rgba(255,255,255,0.05);
    backdrop-filter: blur(10px);
    border-radius: 15px;
    padding: 1.5rem;
    border: 1px solid rgba(255,255,255,0.1);
}
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
function editPickup(studentId, pickupPoint, pickupTime) {
    document.getElementById('editPickupForm').action = `/admin/students/${studentId}/update-pickup`;
    document.getElementById('pickupPoint').value = pickupPoint || '';
    document.getElementById('pickupTime').value = pickupTime || '';
    
    new bootstrap.Modal(document.getElementById('editPickupModal')).show();
}
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\project-bus\resources\views/admin/buses/show.blade.php ENDPATH**/ ?>