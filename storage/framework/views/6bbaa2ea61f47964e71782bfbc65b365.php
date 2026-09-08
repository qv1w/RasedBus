


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
<div class="row justify-content-center">
    <div class="col-lg-8">
        <form method="POST" action="<?php echo e(route('admin.buses.update', $bus)); ?>" id="busEditForm">
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
                            <i class="fas fa-hashtag me-1"></i>
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
                               placeholder="مثال: BUS001" 
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
                        <div class="form-text text-light opacity-75">
                            رقم فريد للباص (حروف وأرقام)
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <label for="plate_number" class="form-label">
                            <i class="fas fa-id-card me-1"></i>
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
                               placeholder="مثال: ر س س 1234" 
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
                        <div class="form-text text-light opacity-75">
                            رقم لوحة الباص حسب المرور السعودي
                        </div>
                    </div>
                </div>
                
                <div class="row g-3 mt-2">
                    <div class="col-md-6">
                        <label for="model" class="form-label">
                            <i class="fas fa-cog me-1"></i>
                            الموديل والنوع <span class="text-danger">*</span>
                        </label>
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
                               value="<?php echo e(old('model', $bus->model)); ?>" 
                               placeholder="مثال: هيونداي - كاونتي 2023" 
                               required>
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
                    
                    <div class="col-md-6">
                        <label for="capacity" class="form-label">
                            <i class="fas fa-users me-1"></i>
                            السعة (عدد المقاعد) <span class="text-danger">*</span>
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
                               id="capacity" 
                               name="capacity" 
                               value="<?php echo e(old('capacity', $bus->capacity)); ?>" 
                               min="<?php echo e($bus->current_students); ?>" 
                               max="50" 
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
                        <div class="form-text text-light opacity-75">
                            الحد الأدنى: <?php echo e($bus->current_students); ?> (الطالبات الحاليات)
                        </div>
                    </div>
                </div>
            </div>

            <!-- التخصيص والإدارة -->
            <div class="content-card mb-4">
                <h5 class="text-info mb-4">
                    <i class="fas fa-cogs me-2"></i>
                    التخصيص والإدارة
                </h5>
                
                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="center_id" class="form-label">
                            <i class="fas fa-school me-1"></i>
                            المركز المخصص <span class="text-danger">*</span>
                        </label>
                        <select class="form-select <?php $__errorArgs = ['center_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                id="center_id" 
                                name="center_id" 
                                required>
                            <option value="">-- اختر المركز --</option>
                            <?php $__currentLoopData = $centers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $center): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($center->id); ?>"
                                    <?php echo e(old('center_id', $bus->center_id) == $center->id ? 'selected' : ''); ?>>
                                    <?php echo e($center->center_name); ?>

                                    <span class="text-muted">(<?php echo e($center->address); ?>)</span>
                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <?php $__errorArgs = ['center_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        <?php if($bus->current_students > 0): ?>
                        <div class="form-text text-warning opacity-75">
                            <i class="fas fa-exclamation-triangle me-1"></i>
                            تغيير المركز قد يؤثر على الطالبات المخصصات (<?php echo e($bus->current_students); ?> طالبة)
                        </div>
                        <?php endif; ?>
                    </div>
                    
                    <div class="col-md-6">
                        <label for="driver_id" class="form-label">
                            <i class="fas fa-user me-1"></i>
                            السائق المخصص
                        </label>
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
                            <option value="">-- غير محدد --</option>
                            <?php $__currentLoopData = $drivers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $driver): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($driver->id); ?>" 
                                        <?php echo e(old('driver_id', $bus->driver_id) == $driver->id ? 'selected' : ''); ?>>
                                    <?php echo e($driver->name); ?> - <?php echo e($driver->phone); ?>

                                    <?php if($driver->license_number): ?>
                                        (<?php echo e($driver->license_number); ?>)
                                    <?php endif; ?>
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
                        <div class="form-text text-light opacity-75">
                            السائقون المتاحون أو الحالي فقط
                        </div>
                    </div>
                </div>
                
                <div class="row g-3 mt-2">
                    <div class="col-md-6">
                        <label for="status" class="form-label">
                            <i class="fas fa-toggle-on me-1"></i>
                            حالة الباص <span class="text-danger">*</span>
                        </label>
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
                                نشط - جاهز للخدمة
                            </option>
                            <option value="inactive" <?php echo e(old('status', $bus->status) == 'inactive' ? 'selected' : ''); ?>>
                                غير نشط - في الانتظار
                            </option>
                            <option value="maintenance" <?php echo e(old('status', $bus->status) == 'maintenance' ? 'selected' : ''); ?>>
                                تحت الصيانة
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
                        <?php if($bus->current_students > 0 && $bus->status == 'active'): ?>
                        <div class="form-text text-warning opacity-75">
                            <i class="fas fa-exclamation-triangle me-1"></i>
                            تغيير الحالة من نشط قد يؤثر على خدمة الطالبات
                        </div>
                        <?php endif; ?>
                    </div>
                    
                    <div class="col-md-6">
                        <label class="form-label">إعدادات إضافية</label>
                        <div class="d-flex flex-column gap-2">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="maintenance_mode" 
                                       name="maintenance_mode" <?php echo e($bus->status == 'maintenance' ? 'checked' : ''); ?>>
                                <label class="form-check-label text-light" for="maintenance_mode">
                                    <i class="fas fa-tools me-1"></i>
                                    وضع الصيانة
                                </label>
                            </div>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="emergency_contact" name="emergency_contact">
                                <label class="form-check-label text-light" for="emergency_contact">
                                    <i class="fas fa-phone me-1"></i>
                                    إشعار الطوارئ
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- حالة الطالبات والتنبيهات -->
            <?php if($bus->current_students > 0): ?>
            <div class="content-card mb-4">
                <h5 class="text-warning mb-4">
                    <i class="fas fa-users me-2"></i>
                    تأثير التعديلات على الطالبات
                </h5>
                
                <div class="alert alert-warning">
                    <div class="d-flex align-items-center mb-2">
                        <i class="fas fa-exclamation-triangle fa-2x me-3"></i>
                        <div>
                            <h6 class="alert-heading mb-0">انتبه!</h6>
                            <p class="mb-0">يوجد <?php echo e($bus->current_students); ?> طالبة مخصصة لهذا الباص</p>
                        </div>
                    </div>
                    
                    <hr>
                    
                    <div class="row g-3">
                        <div class="col-md-6">
                            <strong>عند تغيير المركز:</strong>
                            <ul class="mb-0">
                                <li>قد تحتاج إعادة تقييم مسارات الطالبات</li>
                                <li>التأكد من ملائمة الفترات الدراسية</li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <strong>عند تقليل السعة:</strong>
                            <ul class="mb-0">
                                <li>يجب ألا تقل عن <?php echo e($bus->current_students); ?></li>
                                <li>إعادة تخصيص الطالبات الزائدات</li>
                            </ul>
                        </div>
                    </div>
                    
                    <div class="mt-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="confirm_changes" name="confirm_changes" required>
                            <label class="form-check-label" for="confirm_changes">
                                أؤكد فهمي للتأثيرات المحتملة وأريد المتابعة
                            </label>
                        </div>
                    </div>
                </div>

                <!-- قائمة الطالبات المتأثرات -->
                <div class="mt-4">
                    <h6 class="text-info mb-3">الطالبات المخصصات حالياً:</h6>
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>الطالبة</th>
                                    <th>الجوال</th>
                                    <th>نقطة الالتقاء</th>
                                    <th>الإجراء</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $bus->students->take(5); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td>
                                        <div><?php echo e($student->name); ?></div>
                                        <small class="text-muted"><?php echo e($student->student_id); ?></small>
                                    </td>
                                    <td><?php echo e($student->mobile); ?></td>
                                    <td><?php echo e($student->pickup_point ?: 'غير محدد'); ?></td>
                                    <td>
                                        <a href="<?php echo e(route('admin.students.show', $student)); ?>" 
                                           class="btn btn-sm btn-outline-light">
                                            عرض
                                        </a>
                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php if($bus->students->count() > 5): ?>
                                <tr>
                                    <td colspan="4" class="text-center text-muted">
                                        و <?php echo e($bus->students->count() - 5); ?> طالبة أخرى...
                                        <a href="<?php echo e(route('admin.buses.show', $bus)); ?>" class="text-decoration-none">
                                            عرض الكل
                                        </a>
                                    </td>
                                </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <?php endif; ?>

            <!-- ملاحظات وتفاصيل إضافية -->
            <div class="content-card mb-4">
                <h5 class="text-secondary mb-4">
                    <i class="fas fa-sticky-note me-2"></i>
                    معلومات إضافية
                </h5>
                
                <div class="row g-3">
                    <div class="col-12">
                        <label for="notes" class="form-label">
                            <i class="fas fa-comment me-1"></i>
                            ملاحظات إضافية
                        </label>
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
                                  rows="4" 
                                  placeholder="أي ملاحظات إضافية حول الباص..."><?php echo e(old('notes', $bus->notes)); ?></textarea>
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
                
                <!-- تاريخ آخر تحديث -->
                <div class="row g-3 mt-3">
                    <div class="col-md-6">
                        <label class="form-label text-light opacity-75">تاريخ الإنشاء</label>
                        <div class="text-light"><?php echo e($bus->created_at->format('Y/m/d H:i')); ?></div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-light opacity-75">آخر تحديث</label>
                        <div class="text-light"><?php echo e($bus->updated_at->format('Y/m/d H:i')); ?></div>
                    </div>
                </div>
            </div>

            <!-- أزرار التحكم -->
            <div class="content-card">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-warning" id="updateBtn">
                            <i class="fas fa-save me-2"></i>
                            حفظ التعديلات
                        </button>
                        <button type="button" class="btn btn-info" onclick="previewChanges()">
                            <i class="fas fa-eye me-2"></i>
                            معاينة التغييرات
                        </button>
                    </div>
                    <div class="d-flex gap-2">
                        <button type="button" class="btn btn-outline-warning" onclick="resetToOriginal()">
                            <i class="fas fa-undo me-2"></i>
                            استعادة الأصل
                        </button>
                        <a href="<?php echo e(route('admin.buses.show', $bus)); ?>" class="btn btn-outline-light">
                            <i class="fas fa-times me-2"></i>
                            إلغاء
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- الشريط الجانبي - معلومات مساعدة -->
    <div class="col-lg-4">
        <!-- معلومات الباص الحالية -->
        <div class="content-card mb-4">
            <h6 class="text-primary mb-3">
                <i class="fas fa-info-circle me-2"></i>
                معلومات الباص الحالية
            </h6>
            <div class="small text-light">
                <div class="d-flex justify-content-between mb-2">
                    <span class="opacity-75">الرقم:</span>
                    <span class="fw-bold"><?php echo e($bus->number); ?></span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span class="opacity-75">الحالة:</span>
                    <span class="badge bg-<?php echo e($bus->status_color); ?>"><?php echo e($bus->status_text); ?></span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span class="opacity-75">الإشغال:</span>
                    <span class="fw-bold"><?php echo e($bus->current_students); ?>/<?php echo e($bus->capacity); ?></span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span class="opacity-75">المركز:</span>
                    <span class="fw-bold">
                    <?php echo e($bus->center?->center_name ?? 'غير محدد'); ?>

                    </span>
                </div>
                <div class="d-flex justify-content-between">
                    <span class="opacity-75">السائق:</span>
                    <span class="fw-bold"><?php echo e($bus->driver ? $bus->driver->name : 'غير محدد'); ?></span>
                </div>
            </div>
        </div>

        <!-- تحذيرات وملاحظات -->
        <div class="content-card mb-4">
            <h6 class="text-warning mb-3">
                <i class="fas fa-exclamation-triangle me-2"></i>
                تحذيرات مهمة
            </h6>
            <div class="small text-light opacity-75">
                <div class="mb-3">
                    <i class="fas fa-users text-danger me-2"></i>
                    لا يمكن تقليل السعة أقل من عدد الطالبات الحاليات
                </div>
                <div class="mb-3">
                    <i class="fas fa-school text-warning me-2"></i>
                    تغيير المركز قد يحتاج إعادة ترتيب المسارات
                </div>
                <div class="mb-3">
                    <i class="fas fa-user-tie text-info me-2"></i>
                    السائق المخصص لباص آخر لن يظهر في القائمة
                </div>
                <div>
                    <i class="fas fa-save text-success me-2"></i>
                    جميع التغييرات قابلة للتراجع
                </div>
            </div>
        </div>

        <!-- روابط مفيدة -->
        <div class="content-card mb-4">
            <h6 class="text-info mb-3">
                <i class="fas fa-link me-2"></i>
                روابط مفيدة
            </h6>
            <div class="d-grid gap-2">
                <a href="<?php echo e(route('admin.buses.show', $bus)); ?>" class="btn btn-outline-light btn-sm">
                    <i class="fas fa-users me-2"></i>
                    إدارة طالبات الباص
                </a>
                <?php if($bus->driver): ?>
                <a href="<?php echo e(route('admin.drivers.show', $bus->driver)); ?>" class="btn btn-outline-light btn-sm">
                    <i class="fas fa-user me-2"></i>
                    ملف السائق
                </a>
                <?php endif; ?>
                <?php if($bus->center_id): ?>
                <a href="<?php echo e(route('admin.centers.show', $bus->center_id)); ?>">
                    <i class="fas fa-school me-2"></i>
                    تفاصيل المركز
                </a>
                <?php endif; ?>
                <a href="<?php echo e(route('admin.buses.show', $bus)); ?>" class="btn btn-outline-light btn-sm">
                    <i class="fas fa-eye me-2"></i>
                    عرض تفاصيل الباص
                </a>
            </div>
        </div>

        <!-- سجل التغييرات -->
        <div class="content-card">
            <h6 class="text-secondary mb-3">
                <i class="fas fa-history me-2"></i>
                سجل التعديلات
            </h6>
            <div class="small text-light opacity-75">
                <div class="mb-2">
                    <strong>الإنشاء:</strong> <?php echo e($bus->created_at->format('Y/m/d')); ?>

                </div>
                <div class="mb-2">
                    <strong>آخر تحديث:</strong> <?php echo e($bus->updated_at->format('Y/m/d H:i')); ?>

                </div>
                <div>
                    <strong>عدد التعديلات:</strong> 
                    <?php echo e($bus->updated_at->diffInDays($bus->created_at) > 0 ? 'متعدد' : 'جديد'); ?>

                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal معاينة التغييرات -->
<div class="modal fade" id="previewModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">معاينة التغييرات</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="previewContent">
                <!-- سيتم ملء المحتوى بالجافاسكربت -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إغلاق</button>
                <button type="button" class="btn btn-warning" onclick="confirmAndSave()">
                    <i class="fas fa-save me-2"></i>
                    تأكيد وحفظ
                </button>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
// البيانات الأصلية للباص
const originalData = {
    number: '<?php echo e($bus->number); ?>',
    plate_number: '<?php echo e($bus->plate_number); ?>',
    model: '<?php echo e($bus->model); ?>',
    capacity: <?php echo e($bus->capacity); ?>,
    center_id: '<?php echo e($bus->center_id); ?>',
    driver_id: '<?php echo e($bus->driver_id ?: ""); ?>',
    status: '<?php echo e($bus->status); ?>',
    notes: '<?php echo e(addslashes($bus->notes ?: "")); ?>'
};

document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('busEditForm');
    const updateBtn = document.getElementById('updateBtn');
    
    // مراقبة التغييرات
    const inputs = form.querySelectorAll('input, select, textarea');
    inputs.forEach(input => {
        input.addEventListener('change', function() {
            updateBtn.classList.add('btn-warning');
            updateBtn.innerHTML = '<i class="fas fa-save me-2"></i>حفظ التعديلات *';
        });
    });
    
    // التحقق من صحة النموذج
    form.addEventListener('submit', function(e) {
        if (!validateForm()) {
            e.preventDefault();
            return;
        }
        
        // تأثير التحميل
        updateBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>جاري الحفظ...';
        updateBtn.disabled = true;
    });
    
    // التحقق من تفرد البيانات عند التغيير
    const numberInput = document.getElementById('number');
    const plateInput = document.getElementById('plate_number');
    
    numberInput.addEventListener('blur', function() {
        if (this.value !== originalData.number) {
            checkUniqueness('number', this.value, this);
        }
    });
    
    plateInput.addEventListener('blur', function() {
        if (this.value !== originalData.plate_number) {
            checkUniqueness('plate_number', this.value, this);
        }
    });
    
    // مراقبة تغيير السعة
    const capacityInput = document.getElementById('capacity');
    capacityInput.addEventListener('input', function() {
        validateCapacity(this.value);
    });
    
    // مراقبة تغيير المركز
    const centerSelect = document.getElementById('center_id');
    centerSelect.addEventListener('change', function() {
        if (this.value !== originalData.center_id && <?php echo e($bus->current_students); ?>) {
            showCenterChangeWarning();
        }
        updateAvailableDrivers(this.value);
    });
});

function validateForm() {
    let isValid = true;
    const requiredFields = ['number', 'plate_number', 'model', 'capacity', 'center_id', 'status'];
    
    requiredFields.forEach(fieldId => {
        const field = document.getElementById(fieldId);
        if (!field.value.trim()) {
            field.classList.add('is-invalid');
            isValid = false;
        } else {
            field.classList.remove('is-invalid');
        }
    });
    
    // التحقق من السعة
    const capacity = document.getElementById('capacity').value;
    if (capacity < <?php echo e($bus->current_students); ?>) {
        document.getElementById('capacity').classList.add('is-invalid');
        isValid = false;
    }
    
    return isValid;
}

function validateCapacity(newCapacity) {
    const currentStudents = <?php echo e($bus->current_students); ?>;
    const capacityInput = document.getElementById('capacity');
    
    if (newCapacity < currentStudents) {
        capacityInput.classList.add('is-invalid');
        showAlert('danger', `لا يمكن تقليل السعة إلى ${newCapacity} - يوجد ${currentStudents} طالبة محجوزة`);
    } else {
        capacityInput.classList.remove('is-invalid');
    }
}

function checkUniqueness(field, value, input) {
    if (!value.trim()) return;
    
    fetch(`/admin/buses/check-uniqueness`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({
            field: field,
            value: value,
            exclude_id: <?php echo e($bus->id); ?>

        })
    })
    .then(response => response.json())
    .then(data => {
        if (!data.unique) {
            input.classList.add('is-invalid');
            showFieldError(input, data.message);
        } else {
            input.classList.remove('is-invalid');
            hideFieldError(input);
        }
    })
    .catch(error => {
        console.error('Error checking uniqueness:', error);
    });
}

function updateAvailableDrivers(centerId) {
    const driverSelect = document.getElementById('driver_id');
    const currentDriverId = '<?php echo e($bus->driver_id); ?>';
    
    fetch(`/admin/drivers/available-for-center/${centerId}?current=${currentDriverId}`)
    .then(response => response.json())
    .then(data => {
        const selectedValue = driverSelect.value;
        driverSelect.innerHTML = '<option value="">-- غير محدد --</option>';
        
        data.drivers.forEach(driver => {
            const option = document.createElement('option');
            option.value = driver.id;
            option.textContent = `${driver.name} - ${driver.phone}`;
            if (driver.license_number) {
                option.textContent += ` (${driver.license_number})`;
            }
            if (driver.id == currentDriverId) {
                option.textContent += ' (حالي)';
            }
            driverSelect.appendChild(option);
        });
        
        // استعادة القيمة المحددة
        if (selectedValue) {
            driverSelect.value = selectedValue;
        }
    })
    .catch(error => {
        console.error('Error loading drivers:', error);
    });
}

function showCenterChangeWarning() {
    const alert = `
        <div class="alert alert-warning alert-dismissible fade show mt-3" role="alert">
            <i class="fas fa-exclamation-triangle me-2"></i>
            <strong>تحذير:</strong> تغيير المركز سيؤثر على الطالبات المخصصات حالياً.
            تأكد من أن المركز الجديد مناسب للطالبات الحاليات.
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    `;
    
    const centerGroup = document.getElementById('center_id').closest('.col-md-6');
    centerGroup.insertAdjacentHTML('afterend', alert);
}

function previewChanges() {
    const currentData = getFormData();
    const changes = getChanges(originalData, currentData);
    
    let content = '<div class="table-responsive"><table class="table table-bordered">';
    content += '<thead><tr><th>الحقل</th><th>القيمة الحالية</th><th>القيمة الجديدة</th></tr></thead><tbody>';
    
    if (Object.keys(changes).length === 0) {
        content += '<tr><td colspan="3" class="text-center text-muted">لا توجد تغييرات</td></tr>';
    } else {
        Object.keys(changes).forEach(key => {
            const fieldNames = {
                'number': 'رقم الباص',
                'plate_number': 'رقم اللوحة',
                'model': 'الموديل',
                'capacity': 'السعة',
                'center_id': 'المركز',
                'driver_id': 'السائق',
                'status': 'الحالة',
                'notes': 'الملاحظات'
            };
            
            content += `<tr>
                <td><strong>${fieldNames[key] || key}</strong></td>
                <td>${originalData[key] || 'غير محدد'}</td>
                <td class="text-primary"><strong>${changes[key] || 'غير محدد'}</strong></td>
            </tr>`;
        });
    }
    
    content += '</tbody></table></div>';
    
    document.getElementById('previewContent').innerHTML = content;
    const modal = new bootstrap.Modal(document.getElementById('previewModal'));
    modal.show();
}

function getFormData() {
    return {
        number: document.getElementById('number').value,
        plate_number: document.getElementById('plate_number').value,
        model: document.getElementById('model').value,
        capacity: parseInt(document.getElementById('capacity').value),
        center_id: document.getElementById('center_id').value,
        driver_id: document.getElementById('driver_id').value,
        status: document.getElementById('status').value,
        notes: document.getElementById('notes').value
    };
}

function getChanges(original, current) {
    const changes = {};
    Object.keys(original).forEach(key => {
        if (original[key] != current[key]) {
            changes[key] = current[key];
        }
    });
    return changes;
}

function resetToOriginal() {
    if (confirm('هل تريد استعادة جميع القيم الأصلية؟')) {
        Object.keys(originalData).forEach(key => {
            const element = document.getElementById(key);
            if (element) {
                element.value = originalData[key];
                element.classList.remove('is-invalid');
            }
        });
        
        // إعادة تعيين زر الحفظ
        const updateBtn = document.getElementById('updateBtn');
        updateBtn.classList.remove('btn-warning');
        updateBtn.innerHTML = '<i class="fas fa-save me-2"></i>حفظ التعديلات';
    }
}

function confirmAndSave() {
    bootstrap.Modal.getInstance(document.getElementById('previewModal')).hide();
    document.getElementById('busEditForm').submit();
}

function showAlert(type, message) {
    const alertDiv = document.createElement('div');
    alertDiv.className = `alert alert-${type} alert-dismissible fade show position-fixed`;
    alertDiv.style.cssText = 'top: 20px; left: 20px; right: 20px; z-index: 9999;';
    alertDiv.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    
    document.body.appendChild(alertDiv);
    
    setTimeout(() => {
        if (alertDiv.parentNode) {
            alertDiv.remove();
        }
    }, 5000);
}

function showFieldError(input, message) {
    let errorDiv = input.parentNode.querySelector('.invalid-feedback');
    if (!errorDiv) {
        errorDiv = document.createElement('div');
        errorDiv.className = 'invalid-feedback';
        input.parentNode.appendChild(errorDiv);
    }
    errorDiv.textContent = message;
}

function hideFieldError(input) {
    const errorDiv = input.parentNode.querySelector('.invalid-feedback');
    if (errorDiv) {
        errorDiv.remove();
    }
}


// حفظ التقدم محلياً
function saveDraft() {
    const formData = getFormData();
    localStorage.setItem('busEditDraft_<?php echo e($bus->id); ?>', JSON.stringify(formData));
}

function loadDraft() {
    const savedData = localStorage.getItem('busEditDraft_<?php echo e($bus->id); ?>');
    if (savedData) {
        const data = JSON.parse(savedData);
        if (confirm('تم العثور على نسخة محفوظة من التعديلات. هل تريد استعادتها؟')) {
            Object.keys(data).forEach(key => {
                const element = document.getElementById(key);
                if (element && data[key] !== null) {
                    element.value = data[key];
                }
            });
        }
        localStorage.removeItem('busEditDraft_<?php echo e($bus->id); ?>');
    }
}

// حفظ المسودة عند التغيير
document.querySelectorAll('input, select, textarea').forEach(input => {
    input.addEventListener('change', saveDraft);
});

// تحميل المسودة عند التحميل
window.addEventListener('load', loadDraft);

// مسح المسودة عند الإرسال الناجح
document.getElementById('busEditForm').addEventListener('submit', function() {
    setTimeout(() => {
        localStorage.removeItem('busEditDraft_<?php echo e($bus->id); ?>');
    }, 1000);
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\project-bus\resources\views/admin/buses/edit.blade.php ENDPATH**/ ?>