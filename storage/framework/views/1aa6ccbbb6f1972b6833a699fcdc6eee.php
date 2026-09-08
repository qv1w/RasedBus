<?php
    $roles = [
        'super_admin' => 'مدير عام',
        'admin' => 'مشرف',
        'accountant' => 'محاسب',
        'supervisor' => 'مراقب',
        'data_entry' => 'مدخل بيانات',
    ];
    
    $rolePermissions = [
        'super_admin' => 'جميع الصلاحيات - تحكم كامل بالنظام',
        'admin' => 'طلاب، باصات، سائقون، جهات، دفعات، تقارير',
        'accountant' => 'دفعات، تقارير مالية فقط',
        'supervisor' => 'عرض الطلاب والباصات والسائقون، تقارير',
        'data_entry' => 'إدخال بيانات الطلاب والباصات فقط',
    ];
?>

<?php $__env->startSection('title', 'إضافة موظف جديد'); ?>

<?php $__env->startSection('header'); ?>
<div class="d-flex justify-content-between align-items-center w-100">
    <div>
        <h2 class="mb-1">
            <i class="fas fa-user-plus me-2"></i>
            إضافة موظف جديد
        </h2>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="<?php echo e(route('admin.dashboard')); ?>">لوحة التحكم</a></li>
                <li class="breadcrumb-item"><a href="<?php echo e(route('admin.admins.index')); ?>">الموظفين</a></li>
                <li class="breadcrumb-item active">إضافة موظف</li>
            </ol>
        </nav>
    </div>
    <a href="<?php echo e(route('admin.admins.index')); ?>" class="btn btn-outline-light">
        <i class="fas fa-arrow-right me-1"></i>
        العودة
    </a>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="content-card">
            <form action="<?php echo e(route('admin.admins.store')); ?>" method="POST">
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
                               value="<?php echo e(old('name')); ?>" required placeholder="أدخل الاسم الكامل">
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
                        <label class="form-label">اسم المستخدم <span class="text-danger">*</span></label>
                        <input type="text" name="username" class="form-control <?php $__errorArgs = ['username'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                               value="<?php echo e(old('username')); ?>" required placeholder="أدخل اسم المستخدم">
                        <?php $__errorArgs = ['username'];
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
                    
                    <div class="col-md-6 mb-3">
                        <label class="form-label">رقم الجوال</label>
                        <input type="tel" name="phone" class="form-control <?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                               value="<?php echo e(old('phone')); ?>" placeholder="05XXXXXXXX">
                        <?php $__errorArgs = ['phone'];
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
                        <label class="form-label">المسمى الوظيفي</label>
                        <input type="text" name="job_title" class="form-control <?php $__errorArgs = ['job_title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                               value="<?php echo e(old('job_title')); ?>" placeholder="مثال: مدير النظام">
                        <?php $__errorArgs = ['job_title'];
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

                <!-- الرتبة والحالة -->
                <h5 class="section-title mt-4">
                    <i class="fas fa-shield-alt me-2"></i>
                    الرتبة والصلاحيات
                </h5>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">الرتبة <span class="text-danger">*</span></label>
                        <select name="role" class="form-select <?php $__errorArgs = ['role'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required id="roleSelect">
                            <option value="">-- اختر الرتبة --</option>
                            <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($key); ?>" <?php echo e(old('role') == $key ? 'selected' : ''); ?>>
                                    <?php echo e($value); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <?php $__errorArgs = ['role'];
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
                            <option value="active" <?php echo e(old('status', 'active') == 'active' ? 'selected' : ''); ?>>نشط</option>
                            <option value="inactive" <?php echo e(old('status') == 'inactive' ? 'selected' : ''); ?>>غير نشط</option>
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
                        <div class="alert alert-info" id="permissionsInfo" style="display: none;">
                            <i class="fas fa-info-circle me-2"></i>
                            <strong>صلاحيات هذه الرتبة:</strong>
                            <span id="permissionsText"></span>
                        </div>
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
                        <div class="input-group">
                            <input type="password" name="password" id="password"
                                   class="form-control <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                   required placeholder="أدخل كلمة المرور">
                            <button type="button" class="btn btn-outline-secondary" onclick="togglePassword('password')">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback d-block"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        <small class="text-muted">6 أحرف على الأقل</small>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label class="form-label">تأكيد كلمة المرور <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="password" name="password_confirmation" id="password_confirmation"
                                   class="form-control" required placeholder="أعد إدخال كلمة المرور">
                            <button type="button" class="btn btn-outline-secondary" onclick="togglePassword('password_confirmation')">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>
                    
                    <div class="col-12 mb-3">
                        <button type="button" class="btn btn-outline-info btn-sm" onclick="generatePassword()">
                            <i class="fas fa-random me-1"></i>
                            إنشاء كلمة مرور عشوائية
                        </button>
                    </div>
                </div>

                <!-- أزرار الحفظ -->
                <div class="d-flex justify-content-end gap-2 mt-4 pt-3 border-top">
                    <a href="<?php echo e(route('admin.admins.index')); ?>" class="btn btn-secondary">
                        <i class="fas fa-times me-1"></i>
                        إلغاء
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i>
                        حفظ الموظف
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    // إظهار/إخفاء كلمة المرور
    function togglePassword(fieldId) {
        const field = document.getElementById(fieldId);
        const icon = field.nextElementSibling.querySelector('i');
        if (field.type === 'password') {
            field.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            field.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    }
    
    // إنشاء كلمة مرور عشوائية
    function generatePassword() {
        const chars = 'ABCDEFGHJKMNPQRSTUVWXYZabcdefghjkmnpqrstuvwxyz23456789@#$';
        let password = 'Pass@';
        for (let i = 0; i < 6; i++) {
            password += chars.charAt(Math.floor(Math.random() * chars.length));
        }
        document.getElementById('password').value = password;
        document.getElementById('password_confirmation').value = password;
        document.getElementById('password').type = 'text';
        document.getElementById('password_confirmation').type = 'text';
        
        // نسخ للحافظة
        navigator.clipboard.writeText(password).then(() => {
            alert('تم إنشاء كلمة المرور ونسخها: ' + password);
        });
    }
    
    // عرض صلاحيات الرتبة
    const rolePermissions = {
        'super_admin': 'جميع الصلاحيات - تحكم كامل بالنظام',
        'admin': 'طلاب، باصات، سائقون، جهات، دفعات، تقارير',
        'accountant': 'دفعات، تقارير مالية فقط',
        'supervisor': 'عرض الطلاب والباصات والسائقون، تقارير',
        'data_entry': 'إدخال بيانات الطلاب والباصات فقط',
    };
    
    document.getElementById('roleSelect').addEventListener('change', function() {
        const infoDiv = document.getElementById('permissionsInfo');
        const textSpan = document.getElementById('permissionsText');
        
        if (this.value && rolePermissions[this.value]) {
            textSpan.textContent = rolePermissions[this.value];
            infoDiv.style.display = 'block';
        } else {
            infoDiv.style.display = 'none';
        }
    });
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\project-bus\resources\views/admin/admins/create.blade.php ENDPATH**/ ?>