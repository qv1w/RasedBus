

<?php $__env->startSection('title', 'تعديل الباص ' . $bus->number); ?>

<?php $__env->startSection('header'); ?>
<div class="d-flex justify-content-between align-items-center w-100">
    <div>
        <h2 class="mb-1">
            <i class="fas fa-edit text-warning me-2"></i>
            تعديل الباص <?php echo e($bus->number); ?>

        </h2>
        <p class="text-light mb-0 opacity-75">
            تعديل معلومات وإعدادات الباص
        </p>
    </div>
    <div class="d-flex gap-2">
        <a href="<?php echo e(route('admin.buses.show', $bus)); ?>" class="btn btn-outline-light">
            <i class="fas fa-eye me-2"></i>
            عرض التفاصيل
        </a>
        <a href="<?php echo e(route('admin.buses.index')); ?>" class="btn btn-outline-light">
            <i class="fas fa-arrow-right me-2"></i>
            العودة للقائمة
        </a>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-lg-8">
        <form method="POST" action="<?php echo e(route('admin.buses.update', $bus)); ?>" id="busForm">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>
            
            <!-- معلومات الباص الأساسية -->
            <div class="content-card mb-4">
                <h5 class="text-primary mb-4">
                    <i class="fas fa-bus me-2"></i>
                    معلومات الباص الأساسية
                </h5>
                
                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="number" class="form-label">
                            رقم الباص <span class="text-danger">*</span>
                        </label>
                        <input type="text" 
                               class="form-control <?php $__errorArgs = ['number'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                               id="number" 
                               name="number" 
                               value="<?php echo e(old('number', $bus->number)); ?>" 
                               required>
                        <?php $__errorArgs = ['number'];
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
                    
                    <div class="col-md-6">
                        <label for="plate_number" class="form-label">
                            رقم اللوحة <span class="text-danger">*</span>
                        </label>
                        <input type="text" 
                               class="form-control <?php $__errorArgs = ['plate_number'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                               id="plate_number" 
                               name="plate_number" 
                               value="<?php echo e(old('plate_number', $bus->plate_number)); ?>" 
                               required>
                        <?php $__errorArgs = ['plate_number'];
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
                    
                    <div class="col-md-4">
                        <label for="model" class="form-label">الموديل</label>
                        <input type="text" 
                               class="form-control <?php $__errorArgs = ['model'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                               id="model" 
                               name="model" 
                               value="<?php echo e(old('model', $bus->model)); ?>">
                        <?php $__errorArgs = ['model'];
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
                    
                    <div class="col-md-4">
                        <label for="capacity" class="form-label">
                            السعة الافتراضية <span class="text-danger">*</span>
                        </label>
                        <input type="number" 
                               class="form-control <?php $__errorArgs = ['capacity'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                               id="defaultCapacity" 
                               name="capacity" 
                               value="<?php echo e(old('capacity', $bus->capacity)); ?>" 
                               min="1" 
                               max="100" 
                               required>
                        <?php $__errorArgs = ['capacity'];
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
                    
                    <div class="col-md-4">
                        <label for="status" class="form-label">الحالة <span class="text-danger">*</span></label>
                        <select class="form-select <?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                id="status" 
                                name="status" 
                                required>
                            <option value="active" <?php echo e(old('status', $bus->status) == 'active' ? 'selected' : ''); ?>>
                                نشط
                            </option>
                            <option value="inactive" <?php echo e(old('status', $bus->status) == 'inactive' ? 'selected' : ''); ?>>
                                غير نشط
                            </option>
                            <option value="maintenance" <?php echo e(old('status', $bus->status) == 'maintenance' ? 'selected' : ''); ?>>
                                صيانة
                            </option>
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
            </div>

            <!-- الجهات التعليمية -->
            <div class="content-card mb-4">
                <h5 class="text-info mb-4">
                    <i class="fas fa-school me-2"></i>
                    الجهات التعليمية
                    <small class="text-muted fs-6">(كل جهة لها سعة منفصلة)</small>
                </h5>
                
                <?php $__errorArgs = ['center_ids'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <div class="alert alert-danger"><?php echo e($message); ?></div>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                <?php $__errorArgs = ['capacities'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <div class="alert alert-danger"><?php echo e($message); ?></div>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                
                <div class="centers-container">
                    <?php $__currentLoopData = $centers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $center): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                        $isSelected = isset($selectedCenters[$center->id]);
                        $centerData = $selectedCenters[$center->id] ?? ['schedule' => 'both', 'capacity' => $bus->capacity, 'current_students' => 0];
                    ?>
                    <div class="center-card mb-3 <?php echo e($isSelected ? 'selected' : ''); ?>" id="centerCard_<?php echo e($center->id); ?>">
                        <div class="d-flex justify-content-between align-items-start">
                            <div class="form-check">
                                <input class="form-check-input center-checkbox" 
                                       type="checkbox" 
                                       name="center_ids[]" 
                                       value="<?php echo e($center->id); ?>" 
                                       id="center_<?php echo e($center->id); ?>"
                                       data-center-id="<?php echo e($center->id); ?>"
                                       <?php echo e($isSelected ? 'checked' : ''); ?>>
                                <label class="form-check-label fw-bold" for="center_<?php echo e($center->id); ?>">
                                    <i class="fas fa-school text-info me-1"></i>
                                    <?php echo e($center->center_name); ?>

                                </label>
                            </div>
                            
                            <?php if($isSelected && $centerData['current_students'] > 0): ?>
                            <span class="badge bg-warning">
                                <i class="fas fa-users me-1"></i>
                                <?php echo e($centerData['current_students']); ?> طالبة
                            </span>
                            <?php endif; ?>
                        </div>
                        
                        <div class="center-details mt-3" id="centerDetails_<?php echo e($center->id); ?>" 
                             style="<?php echo e($isSelected ? '' : 'display: none;'); ?>">
                            <div class="row">
                                <div class="col-md-6 mb-2">
                                    <label class="form-label small">السعة لهذه الجهة</label>
                                    <input type="number" 
                                           name="capacities[<?php echo e($center->id); ?>]" 
                                           class="form-control form-control-sm capacity-input"
                                           value="<?php echo e(old('capacities.'.$center->id, $centerData['capacity'])); ?>"
                                           min="<?php echo e($centerData['current_students']); ?>"
                                           max="100"
                                           data-min-students="<?php echo e($centerData['current_students']); ?>">
                                    <?php if($centerData['current_students'] > 0): ?>
                                    <small class="text-warning">
                                        <i class="fas fa-exclamation-triangle me-1"></i>
                                        الحد الأدنى: <?php echo e($centerData['current_students']); ?>

                                    </small>
                                    <?php endif; ?>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <label class="form-label small">الفترة</label>
                                    <select name="schedules[<?php echo e($center->id); ?>]" class="form-select form-select-sm">
                                        <option value="both" <?php echo e(old('schedules.'.$center->id, $centerData['schedule']) == 'both' ? 'selected' : ''); ?>>صباحية ومسائية</option>
                                        <option value="morning" <?php echo e(old('schedules.'.$center->id, $centerData['schedule']) == 'morning' ? 'selected' : ''); ?>>صباحية فقط</option>
                                        <option value="evening" <?php echo e(old('schedules.'.$center->id, $centerData['schedule']) == 'evening' ? 'selected' : ''); ?>>مسائية فقط</option>
                                    </select>
                                </div>
                            </div>
                            
                            <?php if($isSelected): ?>
                            <div class="mt-2 p-2 rounded" style="background: rgba(0,0,0,0.2);">
                                <div class="d-flex justify-content-between small">
                                    <span class="text-muted">الإشغال:</span>
                                    <span>
                                        <?php echo e($centerData['current_students']); ?> / <?php echo e($centerData['capacity']); ?>

                                        (<?php echo e($centerData['capacity'] > 0 ? round(($centerData['current_students'] / $centerData['capacity']) * 100) : 0); ?>%)
                                    </span>
                                </div>
                                <div class="progress mt-1" style="height: 5px;">
                                    <?php
                                        $percent = $centerData['capacity'] > 0 ? ($centerData['current_students'] / $centerData['capacity']) * 100 : 0;
                                        $color = $percent >= 90 ? 'danger' : ($percent >= 70 ? 'warning' : 'success');
                                    ?>
                                    <div class="progress-bar bg-<?php echo e($color); ?>" style="width: <?php echo e($percent); ?>%"></div>
                                </div>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>

            <!-- السائق والملاحظات -->
            <div class="content-card mb-4">
                <h5 class="text-warning mb-4">
                    <i class="fas fa-cogs me-2"></i>
                    إعدادات إضافية
                </h5>
                
                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="driver_id" class="form-label">السائق</label>
                        <select class="form-select <?php $__errorArgs = ['driver_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                id="driver_id" 
                                name="driver_id">
                            <option value="">-- بدون سائق --</option>
                            <?php $__currentLoopData = $drivers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $driver): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($driver->id); ?>" 
                                        <?php echo e(old('driver_id', $bus->driver_id) == $driver->id ? 'selected' : ''); ?>>
                                    <?php echo e($driver->name); ?> - <?php echo e($driver->mobile); ?>

                                    <?php if($driver->id == $bus->driver_id): ?> (الحالي) <?php endif; ?>
                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <?php $__errorArgs = ['driver_id'];
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
                    
                    <div class="col-12">
                        <label for="notes" class="form-label">ملاحظات</label>
                        <textarea class="form-control <?php $__errorArgs = ['notes'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                  id="notes" 
                                  name="notes" 
                                  rows="3"><?php echo e(old('notes', $bus->notes)); ?></textarea>
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
                </div>
            </div>

            <!-- أزرار التحكم -->
            <div class="content-card">
                <div class="d-flex justify-content-between align-items-center">
                    <button type="submit" class="btn btn-warning">
                        <i class="fas fa-save me-2"></i>
                        حفظ التعديلات
                    </button>
                    <a href="<?php echo e(route('admin.buses.index')); ?>" class="btn btn-outline-light">
                        <i class="fas fa-times me-2"></i>
                        إلغاء
                    </a>
                </div>
            </div>
        </form>
    </div>

    <!-- الشريط الجانبي -->
    <div class="col-lg-4">
        <!-- ملخص الباص -->
        <div class="content-card mb-4">
            <h6 class="text-primary mb-3">
                <i class="fas fa-chart-pie me-2"></i>
                ملخص الإشغال
            </h6>
            
            <?php
                $totalCapacity = 0;
                $totalStudents = 0;
                foreach ($selectedCenters as $cid => $data) {
                    $totalCapacity += $data['capacity'];
                    $totalStudents += $data['current_students'];
                }
            ?>
            
            <div class="text-center mb-3">
                <h3 class="mb-0"><?php echo e($totalStudents); ?> / <?php echo e($totalCapacity); ?></h3>
                <small class="text-muted">إجمالي الطالبات / إجمالي السعة</small>
            </div>
            
            <div class="row text-center">
                <div class="col-4">
                    <h5 class="text-info mb-0"><?php echo e(count($selectedCenters)); ?></h5>
                    <small class="text-muted">جهة</small>
                </div>
                <div class="col-4">
                    <h5 class="text-success mb-0"><?php echo e($totalCapacity - $totalStudents); ?></h5>
                    <small class="text-muted">متاح</small>
                </div>
                <div class="col-4">
                    <h5 class="text-warning mb-0"><?php echo e($totalCapacity > 0 ? round(($totalStudents / $totalCapacity) * 100) : 0); ?>%</h5>
                    <small class="text-muted">نسبة</small>
                </div>
            </div>
        </div>

        <!-- تفاصيل كل جهة -->
        <div class="content-card mb-4">
            <h6 class="text-info mb-3">
                <i class="fas fa-list me-2"></i>
                تفاصيل الجهات
            </h6>
            
            <?php $__empty_1 = true; $__currentLoopData = $bus->centers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $center): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="d-flex justify-content-between align-items-center py-2 border-bottom border-secondary">
                <div>
                    <strong class="text-light"><?php echo e($center->center_name); ?></strong>
                    <br>
                    <small class="text-muted">
                        <?php echo e($center->pivot->schedule == 'both' ? 'صباحي ومسائي' : ($center->pivot->schedule == 'morning' ? 'صباحي' : 'مسائي')); ?>

                    </small>
                </div>
                <div class="text-end">
                    <span class="badge bg-<?php echo e($center->pivot->current_students >= $center->pivot->capacity ? 'danger' : 'success'); ?>">
                        <?php echo e($center->pivot->current_students); ?>/<?php echo e($center->pivot->capacity); ?>

                    </span>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <p class="text-muted text-center mb-0">لا توجد جهات</p>
            <?php endif; ?>
        </div>

        <!-- روابط سريعة -->
        <div class="content-card">
            <h6 class="text-secondary mb-3">
                <i class="fas fa-link me-2"></i>
                روابط سريعة
            </h6>
            <div class="d-grid gap-2">
                <a href="<?php echo e(route('admin.buses.show', $bus)); ?>" class="btn btn-outline-light btn-sm">
                    <i class="fas fa-users me-2"></i>
                    عرض الطالبات
                </a>
                <?php if($bus->driver): ?>
                <a href="<?php echo e(route('admin.drivers.show', $bus->driver)); ?>" class="btn btn-outline-light btn-sm">
                    <i class="fas fa-user me-2"></i>
                    ملف السائق
                </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
<style>
.center-card {
    background: rgba(255,255,255,0.05);
    padding: 1rem;
    border-radius: 10px;
    border: 1px solid rgba(255,255,255,0.1);
    transition: all 0.3s ease;
}

.center-card:hover {
    border-color: rgba(13, 202, 240, 0.3);
}

.center-card.selected {
    background: rgba(13, 202, 240, 0.1);
    border-color: rgba(13, 202, 240, 0.5);
}

.center-details {
    background: rgba(0,0,0,0.2);
    padding: 1rem;
    border-radius: 8px;
}
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const checkboxes = document.querySelectorAll('.center-checkbox');
    
    checkboxes.forEach(function(checkbox) {
        checkbox.addEventListener('change', function() {
            const centerId = this.dataset.centerId;
            const details = document.getElementById('centerDetails_' + centerId);
            const card = document.getElementById('centerCard_' + centerId);
            
            if (this.checked) {
                details.style.display = 'block';
                card.classList.add('selected');
            } else {
                // تحقق من وجود طالبات
                const minStudents = details.querySelector('.capacity-input')?.dataset.minStudents || 0;
                if (parseInt(minStudents) > 0) {
                    alert('لا يمكن إزالة هذه الجهة لوجود طالبات مسجلات');
                    this.checked = true;
                    return;
                }
                details.style.display = 'none';
                card.classList.remove('selected');
            }
        });
    });
    
    // التحقق من السعة
    document.querySelectorAll('.capacity-input').forEach(function(input) {
        input.addEventListener('change', function() {
            const min = parseInt(this.dataset.minStudents) || 0;
            if (parseInt(this.value) < min) {
                alert('لا يمكن تقليل السعة لأقل من عدد الطالبات الحاليات (' + min + ')');
                this.value = min;
            }
        });
    });
});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/rasedbus/project-bus/resources/views/admin/buses/edit.blade.php ENDPATH**/ ?>