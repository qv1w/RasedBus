<?php $__env->startSection('title', 'تفاصيل الطالبة - ' . $student->name); ?>

<?php $__env->startSection('header'); ?>
<div class="d-flex justify-content-between align-items-center w-100">
    <div>
        <h2 class="mb-1">
            <i class="fas fa-user-graduate text-info me-2"></i>
            <?php echo e($student->name); ?>

        </h2>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="<?php echo e(route('admin.dashboard')); ?>">لوحة التحكم</a></li>
                <li class="breadcrumb-item"><a href="<?php echo e(route('admin.students.index')); ?>">الطالبات</a></li>
                <li class="breadcrumb-item active"><?php echo e($student->name); ?></li>
            </ol>
        </nav>
    </div>
    <div class="d-flex gap-2">
        <a href="<?php echo e(route('admin.students.edit', $student)); ?>" class="btn btn-warning">
            <i class="fas fa-edit me-1"></i>
            تعديل
        </a>
        <a href="<?php echo e(route('admin.students.index')); ?>" class="btn btn-outline-light">
            <i class="fas fa-arrow-right me-1"></i>
            العودة
        </a>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<?php
    $assignedBus = null;
    if ($student->assigned_bus_id) {
        $assignedBus = \App\Models\Bus::with('driver')->find($student->assigned_bus_id);
    }
    
    // جلب اسم المركز من العلاقة
    $centerName = $student->centerRelation ? $student->centerRelation->center_name : 'غير محدد';
?>

<div class="row">
    <!-- العمود الأيمن - البطاقة الرئيسية -->
    <div class="col-lg-4 mb-4">
        <!-- بطاقة الطالبة -->
        <div class="content-card text-center mb-4">
            <div class="student-avatar mb-3">
                <i class="fas fa-user-graduate"></i>
            </div>
            <h4 class="mb-1"><?php echo e($student->name); ?></h4>
            <p class="text-muted mb-3"><?php echo e($student->student_id); ?></p>
            
            <span class="badge bg-<?php echo e($student->status_color); ?> fs-6 px-3 py-2 mb-3">
                <?php echo e($student->status_text); ?>

            </span>
            
            <div class="info-list mt-3">
                <div class="info-item">
                    <i class="fas fa-phone text-success"></i>
                    <span class="label">الجوال</span>
                    <span class="value">
                        <a href="tel:<?php echo e($student->mobile); ?>" class="text-info"><?php echo e($student->mobile); ?></a>
                    </span>
                </div>
                <div class="info-item">
                    <i class="fas fa-envelope text-primary"></i>
                    <span class="label">البريد</span>
                    <span class="value"><?php echo e($student->email); ?></span>
                </div>
                <div class="info-item">
                    <i class="fas fa-building text-warning"></i>
                    <span class="label">المركز</span>
                    <span class="value">
                        <span class="badge bg-info"><?php echo e($centerName); ?></span>
                    </span>
                </div>
                <div class="info-item">
                    <i class="fas fa-clock text-info"></i>
                    <span class="label">الفترة</span>
                    <span class="value"><?php echo e($student->preferred_schedule); ?></span>
                </div>
                <div class="info-item">
                    <i class="fas fa-calendar text-success"></i>
                    <span class="label">تاريخ التسجيل</span>
                    <span class="value"><?php echo e($student->created_at->format('Y/m/d')); ?></span>
                </div>
            </div>
        </div>
        
        <!-- بطاقة الباص -->
        <div class="content-card">
            <h5 class="mb-3">
                <i class="fas fa-bus text-warning me-2"></i>
                معلومات الباص
            </h5>
            
            <?php if($assignedBus): ?>
                <div class="text-center mb-3">
                    <div class="bus-icon-large mb-2">
                        <i class="fas fa-bus"></i>
                    </div>
                    <h5 class="mb-1"><?php echo e($assignedBus->number); ?></h5>
                    <small class="text-muted"><?php echo e($assignedBus->plate_number); ?></small>
                </div>
                
                <div class="info-list">
                    <div class="info-item">
                        <i class="fas fa-car text-primary"></i>
                        <span class="label">الموديل</span>
                        <span class="value"><?php echo e($assignedBus->model ?? '-'); ?></span>
                    </div>
                    <?php if($assignedBus->driver): ?>
                    <div class="info-item">
                        <i class="fas fa-user text-success"></i>
                        <span class="label">السائق</span>
                        <span class="value"><?php echo e($assignedBus->driver->name); ?></span>
                    </div>
                    <div class="info-item">
                        <i class="fas fa-phone text-info"></i>
                        <span class="label">جوال السائق</span>
                        <span class="value">
                            <a href="tel:<?php echo e($assignedBus->driver->mobile); ?>" class="text-info">
                                <?php echo e($assignedBus->driver->mobile ?? '-'); ?>

                            </a>
                        </span>
                    </div>
                    <?php endif; ?>
                    <?php if($student->pickup_point): ?>
                    <div class="info-item">
                        <i class="fas fa-map-marker-alt text-danger"></i>
                        <span class="label">نقطة الالتقاء</span>
                        <span class="value"><?php echo e($student->pickup_point); ?></span>
                    </div>
                    <?php endif; ?>
                    <?php if($student->pickup_time): ?>
                    <div class="info-item">
                        <i class="fas fa-clock text-warning"></i>
                        <span class="label">وقت الالتقاء</span>
                        <span class="value"><?php echo e($student->pickup_time); ?></span>
                    </div>
                    <?php endif; ?>
                </div>
                
                <a href="<?php echo e(route('admin.buses.show', $assignedBus)); ?>" class="btn btn-outline-info w-100 mt-3">
                    <i class="fas fa-eye me-1"></i>
                    عرض تفاصيل الباص
                </a>
                
                <form action="<?php echo e(route('admin.students.unassign.bus', $student)); ?>" method="POST" class="mt-2">
                    <?php echo csrf_field(); ?>
                    <button type="submit" class="btn btn-outline-danger w-100" onclick="return confirm('هل تريد إلغاء تخصيص الباص؟')">
                        <i class="fas fa-times me-1"></i>
                        إلغاء تخصيص الباص
                    </button>
                </form>
            <?php else: ?>
                <div class="text-center py-3">
                    <i class="fas fa-bus fa-3x text-muted opacity-50 mb-3"></i>
                    <p class="text-muted mb-3">لم يتم تخصيص باص بعد</p>
                </div>
                
                <?php if($student->status == 'approved'): ?>
                <div class="bus-assignment-form">
                    <h6 class="text-info mb-3">
                        <i class="fas fa-plus-circle me-1"></i>
                        تخصيص باص للطالبة
                    </h6>
                    
                    <form action="<?php echo e(route('admin.students.assign.bus', $student)); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        
                        <div class="mb-3">
                            <label class="form-label">اختر الباص <span class="text-danger">*</span></label>
                            <select name="bus_id" class="form-select" required>
                                <option value="">-- اختر الباص --</option>
                                <?php if(isset($availableBuses) && $availableBuses->count() > 0): ?>
                                    <?php $__currentLoopData = $availableBuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bus): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($bus->id); ?>">
                                            <?php echo e($bus->number); ?> - <?php echo e($bus->plate_number); ?> 
                                            (<?php echo e($bus->students_count); ?>/<?php echo e($bus->capacity); ?>)
                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php else: ?>
                                    <?php
                                        $buses = \App\Models\Bus::where('status', 'active')
                                            ->where('center_id', $student->center_id)
                                            ->withCount('students')
                                            ->get()
                                            ->filter(function($bus) {
                                                return $bus->students_count < $bus->capacity;
                                            });
                                    ?>
                                    <?php $__currentLoopData = $buses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bus): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($bus->id); ?>">
                                            <?php echo e($bus->number); ?> - <?php echo e($bus->plate_number); ?> 
                                            (<?php echo e($bus->students_count); ?>/<?php echo e($bus->capacity); ?>)
                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>
                            </select>
                            <small class="text-muted">الباصات المتاحة في مركز: <?php echo e($centerName); ?></small>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">نقطة الالتقاء</label>
                            <input type="text" name="pickup_point" class="form-control" 
                                   placeholder="مثال: أمام المسجد الكبير">
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">وقت الالتقاء</label>
                            <input type="time" name="pickup_time" class="form-control">
                        </div>
                        
                        <button type="submit" class="btn btn-success w-100">
                            <i class="fas fa-check me-1"></i>
                            تخصيص الباص
                        </button>
                    </form>
                </div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>

    <!-- العمود الأيسر - التفاصيل -->
    <div class="col-lg-8">
        <!-- معلومات ولي الأمر -->
        <div class="content-card mb-4">
            <h5 class="mb-3">
                <i class="fas fa-user-shield text-warning me-2"></i>
                معلومات ولي الأمر
            </h5>
            <div class="row">
                <div class="col-md-4 mb-3">
                    <div class="detail-item">
                        <span class="detail-label">اسم ولي الأمر</span>
                        <span class="detail-value"><?php echo e($student->guardian_name ?: '-'); ?></span>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="detail-item">
                        <span class="detail-label">جوال ولي الأمر</span>
                        <span class="detail-value">
                            <?php if($student->guardian_mobile): ?>
                                <a href="tel:<?php echo e($student->guardian_mobile); ?>" class="text-info"><?php echo e($student->guardian_mobile); ?></a>
                            <?php else: ?>
                                -
                            <?php endif; ?>
                        </span>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="detail-item">
                        <span class="detail-label">صلة القرابة</span>
                        <span class="detail-value"><?php echo e($student->guardian_relation ?: '-'); ?></span>
                    </div>
                </div>
            </div>
        </div>

        <!-- العنوان والموقع -->
        <div class="content-card mb-4">
            <h5 class="mb-3">
                <i class="fas fa-map-marker-alt text-danger me-2"></i>
                الموقع والعنوان
            </h5>
            
            <?php if($student->address): ?>
            <div class="mb-3">
                <span class="detail-label">العنوان:</span>
                <span class="detail-value"><?php echo e($student->address); ?></span>
            </div>
            <?php endif; ?>
            
            <?php if($student->latitude && $student->longitude): ?>
            <div id="studentMap" style="height: 300px; border-radius: 10px;"></div>
            <div class="mt-2 text-center">
                <a href="https://www.google.com/maps?q=<?php echo e($student->latitude); ?>,<?php echo e($student->longitude); ?>" 
                   target="_blank" class="btn btn-sm btn-outline-info">
                    <i class="fas fa-external-link-alt me-1"></i>
                    فتح في Google Maps
                </a>
            </div>
            <?php else: ?>
            <div class="text-center py-3">
                <i class="fas fa-map-marker-alt fa-2x text-muted opacity-50 mb-2"></i>
                <p class="text-muted mb-0">لم يتم تحديد الموقع</p>
            </div>
            <?php endif; ?>
        </div>

        <!-- ملاحظات وإجراءات -->
        <div class="content-card">
            <h5 class="mb-3">
                <i class="fas fa-cog text-info me-2"></i>
                الإجراءات
            </h5>
            
            <?php if($student->notes): ?>
            <div class="alert alert-info mb-3">
                <i class="fas fa-sticky-note me-2"></i>
                <strong>ملاحظات:</strong> <?php echo e($student->notes); ?>

            </div>
            <?php endif; ?>
            
            <?php if($student->status == 'rejected' && $student->rejection_reason): ?>
            <div class="alert alert-danger mb-3">
                <i class="fas fa-times-circle me-2"></i>
                <strong>سبب الرفض:</strong> <?php echo e($student->rejection_reason); ?>

            </div>
            <?php endif; ?>
            
            <div class="d-flex flex-wrap gap-2">
                <?php if($student->status == 'pending'): ?>
                <form action="<?php echo e(route('admin.students.approve', $student)); ?>" method="POST" class="d-inline">
                    <?php echo csrf_field(); ?>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-check me-1"></i>
                        قبول
                    </button>
                </form>
                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#rejectModal">
                    <i class="fas fa-times me-1"></i>
                    رفض
                </button>
                <?php elseif($student->status == 'approved'): ?>
                <form action="<?php echo e(route('admin.students.suspend', $student)); ?>" method="POST" class="d-inline">
                    <?php echo csrf_field(); ?>
                    <button type="submit" class="btn btn-secondary" onclick="return confirm('هل تريد تعليق هذه الطالبة؟')">
                        <i class="fas fa-pause me-1"></i>
                        تعليق
                    </button>
                </form>
                <?php elseif($student->status == 'suspended'): ?>
                <form action="<?php echo e(route('admin.students.unsuspend', $student)); ?>" method="POST" class="d-inline">
                    <?php echo csrf_field(); ?>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-play me-1"></i>
                        إلغاء التعليق
                    </button>
                </form>
                <?php endif; ?>
                
                <form action="<?php echo e(route('admin.students.destroy', $student)); ?>" method="POST" class="d-inline"
                      onsubmit="return confirm('هل أنت متأكد من حذف هذه الطالبة؟')">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('DELETE'); ?>
                    <button type="submit" class="btn btn-outline-danger">
                        <i class="fas fa-trash me-1"></i>
                        حذف
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal الرفض -->
<div class="modal fade" id="rejectModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content bg-dark">
            <div class="modal-header border-secondary">
                <h5 class="modal-title">رفض الطالبة</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="<?php echo e(route('admin.students.reject', $student)); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">سبب الرفض <span class="text-danger">*</span></label>
                        <textarea name="rejection_reason" class="form-control" rows="3" required
                                  placeholder="اكتب سبب الرفض هنا..."></textarea>
                    </div>
                </div>
                <div class="modal-footer border-secondary">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                    <button type="submit" class="btn btn-danger">تأكيد الرفض</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<style>
    .student-avatar {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        background: linear-gradient(135deg, #667eea, #764ba2);
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto;
    }
    
    .student-avatar i {
        font-size: 3rem;
        color: white;
    }
    
    .bus-icon-large {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background: linear-gradient(135deg, #ffc107, #fd7e14);
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto;
    }
    
    .bus-icon-large i {
        font-size: 2.5rem;
        color: white;
    }
    
    .info-list {
        border-top: 1px solid rgba(255,255,255,0.1);
        padding-top: 1rem;
    }
    
    .info-item {
        display: flex;
        align-items: center;
        padding: 0.75rem 0;
        border-bottom: 1px solid rgba(255,255,255,0.05);
    }
    
    .info-item:last-child {
        border-bottom: none;
    }
    
    .info-item i {
        width: 30px;
        text-align: center;
    }
    
    .info-item .label {
        color: rgba(255,255,255,0.6);
        margin-left: 0.5rem;
        min-width: 80px;
    }
    
    .info-item .value {
        margin-right: auto;
        color: #fff;
    }
    
    .detail-item {
        background: rgba(255,255,255,0.05);
        border-radius: 8px;
        padding: 1rem;
    }
    
    .detail-label {
        display: block;
        color: rgba(255,255,255,0.6);
        font-size: 0.85rem;
        margin-bottom: 0.25rem;
    }
    
    .detail-value {
        color: #fff;
        font-weight: 500;
    }
    
    .detail-value a {
        color: #17a2b8;
        text-decoration: none;
    }
    
    .detail-value a:hover {
        text-decoration: underline;
    }
    
    .content-card {
        background: rgba(255,255,255,0.05);
        backdrop-filter: blur(10px);
        border-radius: 15px;
        padding: 1.5rem;
        border: 1px solid rgba(255,255,255,0.1);
    }
    
    .bus-assignment-form {
        background: rgba(0,0,0,0.2);
        border-radius: 10px;
        padding: 1rem;
        margin-top: 1rem;
    }
    
    .form-control, .form-select {
        background: rgba(255,255,255,0.1);
        border-color: rgba(255,255,255,0.2);
        color: #fff;
    }
    
    .form-control:focus, .form-select:focus {
        background: rgba(255,255,255,0.15);
        border-color: #17a2b8;
        color: #fff;
        box-shadow: 0 0 0 0.2rem rgba(23, 162, 184, 0.25);
    }
    
    .form-select option {
        background: #1a1a2e;
        color: #fff;
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    <?php if($student->latitude && $student->longitude): ?>
    var map = L.map('studentMap').setView([<?php echo e($student->latitude); ?>, <?php echo e($student->longitude); ?>], 15);
    
    L.tileLayer('https://mt1.google.com/vt/lyrs=y&x={x}&y={y}&z={z}', {
        maxZoom: 20,
        attribution: '© Google Maps'
    }).addTo(map);
    
    L.marker([<?php echo e($student->latitude); ?>, <?php echo e($student->longitude); ?>])
        .addTo(map)
        .bindPopup('<strong><?php echo e($student->name); ?></strong><br><?php echo e($centerName); ?>')
        .openPopup();
    <?php endif; ?>
});
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\project-bus\resources\views/admin/students/show.blade.php ENDPATH**/ ?>