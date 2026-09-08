

<?php $__env->startSection('title', 'إضافة طالب/ة جديد'); ?>

<?php $__env->startSection('header'); ?>
<div class="d-flex justify-content-between align-items-center w-100">
    <div>
        <h2 class="mb-1">
            <i class="fas fa-user-plus me-2"></i>
            إضافة طالب/ة جديد
        </h2>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="<?php echo e(route('admin.dashboard')); ?>">لوحة التحكم</a></li>
                <li class="breadcrumb-item"><a href="<?php echo e(route('admin.students.index')); ?>">الطلاب</a></li>
                <li class="breadcrumb-item active">إضافة جديد</li>
            </ol>
        </nav>
    </div>
    <a href="<?php echo e(route('admin.students.index')); ?>" class="btn btn-outline-light">
        <i class="fas fa-arrow-right me-1"></i>
        العودة
    </a>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="content-card">
            <form action="<?php echo e(route('admin.students.store')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                
                <!-- البيانات الشخصية -->
                <h5 class="section-title">
                    <i class="fas fa-user me-2"></i>
                    البيانات الشخصية
                </h5>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">الاسم الكامل <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                               value="<?php echo e(old('name')); ?>" required placeholder="أدخل الاسم الرباعي">
                        <?php $__errorArgs = ['name'];
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
                        <label class="form-label">الجنس <span class="text-danger">*</span></label>
                        <select name="gender" class="form-select <?php $__errorArgs = ['gender'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                            <option value="">-- اختر --</option>
                            <option value="ذكر" <?php echo e(old('gender') == 'ذكر' ? 'selected' : ''); ?>>ذكر</option>
                            <option value="أنثى" <?php echo e(old('gender') == 'أنثى' ? 'selected' : ''); ?>>أنثى</option>
                        </select>
                        <?php $__errorArgs = ['gender'];
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
                        <label class="form-label">رقم الهوية <span class="text-danger">*</span></label>
                        <input type="text" name="national_id" class="form-control <?php $__errorArgs = ['national_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                               value="<?php echo e(old('national_id')); ?>" required maxlength="10" pattern="[0-9]{10}"
                               placeholder="أدخل رقم الهوية (10 أرقام)">
                        <?php $__errorArgs = ['national_id'];
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
                        <label class="form-label">تاريخ الميلاد</label>
                        <input type="date" name="birthdate" class="form-control <?php $__errorArgs = ['birthdate'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                               value="<?php echo e(old('birthdate')); ?>">
                        <?php $__errorArgs = ['birthdate'];
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
                        <label class="form-label">رقم الجوال <span class="text-danger">*</span></label>
                        <input type="tel" name="mobile" class="form-control <?php $__errorArgs = ['mobile'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                               value="<?php echo e(old('mobile')); ?>" required pattern="05[0-9]{8}" placeholder="05XXXXXXXX">
                        <?php $__errorArgs = ['mobile'];
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
                        <label class="form-label">البريد الإلكتروني <span class="text-danger">*</span></label>
                        <input type="email" name="email" class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                               value="<?php echo e(old('email')); ?>" required placeholder="example@domain.com">
                        <?php $__errorArgs = ['email'];
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

                <!-- بيانات ولي الأمر -->
                <h5 class="section-title mt-4">
                    <i class="fas fa-user-tie me-2"></i>
                    بيانات ولي الأمر
                </h5>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">اسم ولي الأمر <span class="text-danger">*</span></label>
                        <input type="text" name="guardian_name" class="form-control <?php $__errorArgs = ['guardian_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                               value="<?php echo e(old('guardian_name')); ?>" required placeholder="أدخل اسم ولي الأمر">
                        <?php $__errorArgs = ['guardian_name'];
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
                        <label class="form-label">جوال ولي الأمر <span class="text-danger">*</span></label>
                        <input type="tel" name="guardian_mobile" class="form-control <?php $__errorArgs = ['guardian_mobile'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                               value="<?php echo e(old('guardian_mobile')); ?>" required pattern="05[0-9]{8}" placeholder="05XXXXXXXX">
                        <?php $__errorArgs = ['guardian_mobile'];
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
                        <label class="form-label">صلة القرابة</label>
                        <select name="guardian_relation" class="form-select <?php $__errorArgs = ['guardian_relation'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                            <option value="">-- اختر --</option>
                            <option value="أب" <?php echo e(old('guardian_relation') == 'أب' ? 'selected' : ''); ?>>أب</option>
                            <option value="أم" <?php echo e(old('guardian_relation') == 'أم' ? 'selected' : ''); ?>>أم</option>
                            <option value="أخ" <?php echo e(old('guardian_relation') == 'أخ' ? 'selected' : ''); ?>>أخ</option>
                            <option value="أخت" <?php echo e(old('guardian_relation') == 'أخت' ? 'selected' : ''); ?>>أخت</option>
                            <option value="عم" <?php echo e(old('guardian_relation') == 'عم' ? 'selected' : ''); ?>>عم</option>
                            <option value="خال" <?php echo e(old('guardian_relation') == 'خال' ? 'selected' : ''); ?>>خال</option>
                            <option value="جد" <?php echo e(old('guardian_relation') == 'جد' ? 'selected' : ''); ?>>جد</option>
                            <option value="أخرى" <?php echo e(old('guardian_relation') == 'أخرى' ? 'selected' : ''); ?>>أخرى</option>
                        </select>
                        <?php $__errorArgs = ['guardian_relation'];
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

                <!-- بيانات التسجيل -->
                <h5 class="section-title mt-4">
                    <i class="fas fa-school me-2"></i>
                    بيانات التسجيل
                </h5>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">الجهة التعليمية <span class="text-danger">*</span></label>
                        <select name="center_id" class="form-select <?php $__errorArgs = ['center_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                            <option value="">-- اختر الجهة --</option>
                            <?php $__currentLoopData = $centers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $center): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($center->id); ?>" <?php echo e(old('center_id') == $center->id ? 'selected' : ''); ?>>
                                    <?php echo e($center->center_name); ?>

                                    <?php if($center->neighborhood): ?>
                                        - <?php echo e($center->neighborhood); ?>

                                    <?php endif; ?>
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
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label class="form-label">الفترة المفضلة <span class="text-danger">*</span></label>
                        <select name="preferred_schedule" class="form-select <?php $__errorArgs = ['preferred_schedule'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                            <option value="">-- اختر الفترة --</option>
                            <option value="صباحية" <?php echo e(old('preferred_schedule') == 'صباحية' ? 'selected' : ''); ?>>صباحية</option>
                            <option value="مسائية" <?php echo e(old('preferred_schedule') == 'مسائية' ? 'selected' : ''); ?>>مسائية</option>
                        </select>
                        <?php $__errorArgs = ['preferred_schedule'];
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
                        <label class="form-label">الحالة <span class="text-danger">*</span></label>
                        <select name="status" class="form-select <?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                            <option value="pending" <?php echo e(old('status', 'pending') == 'pending' ? 'selected' : ''); ?>>قيد المراجعة</option>
                            <option value="approved" <?php echo e(old('status') == 'approved' ? 'selected' : ''); ?>>مقبول</option>
                            <option value="rejected" <?php echo e(old('status') == 'rejected' ? 'selected' : ''); ?>>مرفوض</option>
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

                <!-- العنوان والموقع -->
                <h5 class="section-title mt-4">
                    <i class="fas fa-map-marker-alt me-2"></i>
                    العنوان والموقع
                </h5>
                
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label class="form-label">العنوان</label>
                        <textarea name="address" class="form-control <?php $__errorArgs = ['address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                  rows="2" placeholder="أدخل العنوان التفصيلي"><?php echo e(old('address')); ?></textarea>
                        <?php $__errorArgs = ['address'];
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
                        <label class="form-label">خط العرض (Latitude)</label>
                        <input type="text" name="latitude" id="latitude" 
                               class="form-control <?php $__errorArgs = ['latitude'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                               value="<?php echo e(old('latitude')); ?>" placeholder="مثال: 26.3073">
                        <?php $__errorArgs = ['latitude'];
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
                        <label class="form-label">خط الطول (Longitude)</label>
                        <input type="text" name="longitude" id="longitude" 
                               class="form-control <?php $__errorArgs = ['longitude'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                               value="<?php echo e(old('longitude')); ?>" placeholder="مثال: 44.8003">
                        <?php $__errorArgs = ['longitude'];
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
                        <div id="map" style="height: 300px; border-radius: 10px; border: 1px solid var(--border-color);"></div>
                        <small class="text-muted">
                            <i class="fas fa-info-circle me-1"></i>
                            اضغط على الخريطة لتحديد الموقع
                        </small>
                    </div>
                </div>

                <!-- كلمة المرور -->
                <h5 class="section-title mt-4">
                    <i class="fas fa-lock me-2"></i>
                    كلمة المرور
                </h5>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">كلمة المرور <span class="text-danger">*</span></label>
                        <input type="password" name="password" class="form-control <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                               required placeholder="أدخل كلمة المرور">
                        <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        <small class="text-muted">6 أحرف على الأقل</small>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label class="form-label">تأكيد كلمة المرور <span class="text-danger">*</span></label>
                        <input type="password" name="password_confirmation" class="form-control"
                               required placeholder="أعد إدخال كلمة المرور">
                    </div>
                </div>

                <!-- ملاحظات -->
                <h5 class="section-title mt-4">
                    <i class="fas fa-sticky-note me-2"></i>
                    ملاحظات
                </h5>
                
                <div class="row">
                    <div class="col-12 mb-3">
                        <textarea name="notes" class="form-control <?php $__errorArgs = ['notes'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                  rows="3" placeholder="أضف أي ملاحظات إضافية..."><?php echo e(old('notes')); ?></textarea>
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

                <!-- أزرار الحفظ -->
                <div class="d-flex justify-content-end gap-2 mt-4 pt-3 border-top">
                    <a href="<?php echo e(route('admin.students.index')); ?>" class="btn btn-secondary">
                        <i class="fas fa-times me-1"></i>
                        إلغاء
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i>
                        حفظ الطالب
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<style>
    #map {
        z-index: 1;
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    // إعداد الخريطة
    var map = L.map('map').setView([26.3073, 44.8003], 13);
    
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap'
    }).addTo(map);
    
    var marker = null;
    
    // إذا كان هناك قيم سابقة
    var oldLat = "<?php echo e(old('latitude')); ?>";
    var oldLng = "<?php echo e(old('longitude')); ?>";
    
    if (oldLat && oldLng) {
        marker = L.marker([parseFloat(oldLat), parseFloat(oldLng)]).addTo(map);
        map.setView([parseFloat(oldLat), parseFloat(oldLng)], 15);
    }
    
    // عند النقر على الخريطة
    map.on('click', function(e) {
        var lat = e.latlng.lat.toFixed(6);
        var lng = e.latlng.lng.toFixed(6);
        
        document.getElementById('latitude').value = lat;
        document.getElementById('longitude').value = lng;
        
        if (marker) {
            map.removeLayer(marker);
        }
        
        marker = L.marker([lat, lng]).addTo(map);
    });
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\project-bus\resources\views/admin/students/create.blade.php ENDPATH**/ ?>