

<?php $__env->startSection('title', 'إضافة باص جديد'); ?>

<?php $__env->startSection('header'); ?>
<div class="d-flex justify-content-between align-items-center w-100">
    <div>
        <h2 class="mb-1">
            <i class="fas fa-plus-circle text-success me-2"></i>
            إضافة باص جديد
        </h2>
        <p class="text-light mb-0 opacity-75">
            أضف باص جديد لنظام النقل
        </p>
    </div>
    <a href="<?php echo e(route('admin.buses.index')); ?>" class="btn btn-outline-light">
        <i class="fas fa-arrow-right me-1"></i>
        العودة
    </a>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="content-card">
            <form action="<?php echo e(route('admin.buses.store')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                
                <div class="row">
                    <!-- معلومات الباص الأساسية -->
                    <div class="col-12 mb-4">
                        <h5 class="border-bottom border-secondary pb-2 mb-3">
                            <i class="fas fa-bus text-info me-2"></i>
                            معلومات الباص
                        </h5>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">رقم الباص <span class="text-danger">*</span></label>
                        <input type="text" 
                               name="number" 
                               class="form-control <?php $__errorArgs = ['number'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                               value="<?php echo e(old('number')); ?>"
                               placeholder="مثال: 31"
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

                    <div class="col-md-6 mb-3">
                        <label class="form-label">رقم اللوحة <span class="text-danger">*</span></label>
                        <input type="text" 
                               name="plate_number" 
                               class="form-control <?php $__errorArgs = ['plate_number'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                               value="<?php echo e(old('plate_number')); ?>"
                               placeholder="مثال: ب ص ن 1439"
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

                    <div class="col-md-6 mb-3">
                        <label class="form-label">الموديل</label>
                        <input type="text" 
                               name="model" 
                               class="form-control <?php $__errorArgs = ['model'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                               value="<?php echo e(old('model')); ?>"
                               placeholder="مثال: 2023">
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

                    <div class="col-md-6 mb-3">
                        <label class="form-label">السعة (عدد المقاعد) <span class="text-danger">*</span></label>
                        <input type="number" 
                               name="capacity" 
                               class="form-control <?php $__errorArgs = ['capacity'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                               value="<?php echo e(old('capacity', 25)); ?>"
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

                    <!-- التخصيص -->
                    <div class="col-12 mb-4 mt-3">
                        <h5 class="border-bottom border-secondary pb-2 mb-3">
                            <i class="fas fa-link text-warning me-2"></i>
                            الجهات والتخصيص
                        </h5>
                    </div>

                    <div class="col-12 mb-3">
                        <label class="form-label">الجهات التعليمية <span class="text-danger">*</span></label>
                        <p class="text-muted small mb-2">اختر جهة واحدة أو أكثر يخدمها هذا الباص</p>
                        
                        <div class="row">
                            <?php $__currentLoopData = $centers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $center): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="col-md-6 mb-2">
                                <div class="form-check center-check">
                                    <input class="form-check-input" 
                                           type="checkbox" 
                                           name="center_ids[]" 
                                           value="<?php echo e($center->id); ?>" 
                                           id="center_<?php echo e($center->id); ?>"
                                           <?php echo e(in_array($center->id, old('center_ids', [])) ? 'checked' : ''); ?>>
                                    <label class="form-check-label" for="center_<?php echo e($center->id); ?>">
                                        <i class="fas fa-school text-info me-1"></i>
                                        <?php echo e($center->center_name); ?>

                                    </label>
                                </div>
                            </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                        <?php $__errorArgs = ['center_ids'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="text-danger small mt-1"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">الفترة <span class="text-danger">*</span></label>
                        <select name="schedule" class="form-select <?php $__errorArgs = ['schedule'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                            <option value="both" <?php echo e(old('schedule', 'both') == 'both' ? 'selected' : ''); ?>>صباحية ومسائية</option>
                            <option value="morning" <?php echo e(old('schedule') == 'morning' ? 'selected' : ''); ?>>صباحية فقط</option>
                            <option value="evening" <?php echo e(old('schedule') == 'evening' ? 'selected' : ''); ?>>مسائية فقط</option>
                        </select>
                        <?php $__errorArgs = ['schedule'];
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

                    <div class="col-md-6 mb-3">
                        <label class="form-label">السائق</label>
                        <select name="driver_id" class="form-select <?php $__errorArgs = ['driver_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                            <option value="">بدون سائق</option>
                            <?php $__currentLoopData = $drivers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $driver): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($driver->id); ?>" <?php echo e(old('driver_id') == $driver->id ? 'selected' : ''); ?>>
                                    <?php echo e($driver->name); ?> - <?php echo e($driver->mobile); ?>

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
                        <small class="text-muted">يمكنك تخصيص سائق لاحقاً</small>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">الحالة <span class="text-danger">*</span></label>
                        <select name="status" class="form-select <?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                            <option value="active" <?php echo e(old('status', 'active') == 'active' ? 'selected' : ''); ?>>نشط</option>
                            <option value="inactive" <?php echo e(old('status') == 'inactive' ? 'selected' : ''); ?>>غير نشط</option>
                            <option value="maintenance" <?php echo e(old('status') == 'maintenance' ? 'selected' : ''); ?>>صيانة</option>
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

                    <div class="col-12 mb-3">
                        <label class="form-label">ملاحظات</label>
                        <textarea name="notes" 
                                  class="form-control <?php $__errorArgs = ['notes'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                  rows="3"
                                  placeholder="أي ملاحظات إضافية..."><?php echo e(old('notes')); ?></textarea>
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

                <hr class="border-secondary my-4">

                <div class="d-flex justify-content-between">
                    <a href="<?php echo e(route('admin.buses.index')); ?>" class="btn btn-outline-secondary">
                        <i class="fas fa-times me-1"></i>
                        إلغاء
                    </a>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save me-2"></i>
                        حفظ الباص
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
    background: rgba(255,255,255,0.05);
    backdrop-filter: blur(10px);
    border-radius: 15px;
    padding: 2rem;
    border: 1px solid rgba(255,255,255,0.1);
}

.form-control, .form-select {
    background: rgba(255,255,255,0.05);
    border-color: rgba(255,255,255,0.2);
    color: #fff;
}

.form-control:focus, .form-select:focus {
    background: rgba(255,255,255,0.1);
    border-color: #0dcaf0;
    color: #fff;
    box-shadow: 0 0 0 0.2rem rgba(13, 202, 240, 0.25);
}

.form-control::placeholder {
    color: rgba(255,255,255,0.4);
}

.form-select option {
    background: #1a1a2e;
    color: #fff;
}

.center-check {
    background: rgba(255,255,255,0.05);
    padding: 0.75rem 1rem;
    border-radius: 8px;
    border: 1px solid rgba(255,255,255,0.1);
    transition: all 0.2s;
}

.center-check:hover {
    background: rgba(255,255,255,0.1);
    border-color: rgba(13, 202, 240, 0.3);
}

.center-check .form-check-input:checked ~ .form-check-label {
    color: #0dcaf0;
}
</style>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/rasedbus/project-bus/resources/views/admin/buses/create.blade.php ENDPATH**/ ?>