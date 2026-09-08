

<?php
    use App\Models\Admin;
    $currentAdmin = Admin::find(session('admin_id'));
    $adminPermissions = $admin->permissions ?? [];
    if (!is_array($adminPermissions)) $adminPermissions = [];
    $adminSchedules = $admin->allowed_schedules ?? [];
    if (!is_array($adminSchedules)) $adminSchedules = [];
?>

<?php $__env->startSection('title', 'تعديل موظف - ' . $admin->name); ?>

<?php $__env->startSection('header'); ?>
<div class="d-flex justify-content-between align-items-center w-100">
    <div>
        <h2 class="mb-1">
            <i class="fas fa-user-edit me-2"></i>
            تعديل بيانات الموظف
        </h2>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="<?php echo e(route('admin.dashboard')); ?>">لوحة التحكم</a></li>
                <li class="breadcrumb-item"><a href="<?php echo e(route('admin.admins.index')); ?>">الموظفين</a></li>
                <li class="breadcrumb-item active"><?php echo e($admin->name); ?></li>
            </ol>
        </nav>
    </div>
    <a href="<?php echo e(route('admin.admins.index')); ?>" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-right me-1"></i>
        رجوع للقائمة
    </a>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<form action="<?php echo e(route('admin.admins.update', $admin)); ?>" method="POST">
    <?php echo csrf_field(); ?>
    <?php echo method_field('PUT'); ?>
    
    <div class="row">
        <!-- البيانات الأساسية -->
        <div class="col-lg-8">
            <div class="content-card mb-4">
                <h5 class="mb-4">
                    <i class="fas fa-user me-2" style="color: var(--primary-color);"></i>
                    البيانات الأساسية
                </h5>
                
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">الاسم الكامل <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                               value="<?php echo e(old('name', $admin->name)); ?>" required>
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

                    <div class="col-md-6">
                        <label class="form-label">اسم المستخدم <span class="text-danger">*</span></label>
                        <input type="text" name="username" class="form-control <?php $__errorArgs = ['username'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                               value="<?php echo e(old('username', $admin->username)); ?>" required
                               <?php echo e($admin->isDeveloper() ? 'readonly' : ''); ?>>
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

                    <div class="col-md-6">
                        <label class="form-label">البريد الإلكتروني</label>
                        <input type="email" name="email" class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                               value="<?php echo e(old('email', $admin->email)); ?>">
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

                    <div class="col-md-6">
                        <label class="form-label">رقم الجوال</label>
                        <input type="text" name="phone" class="form-control <?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                               value="<?php echo e(old('phone', $admin->phone)); ?>">
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

                    <div class="col-md-6">
                        <label class="form-label">كلمة المرور الجديدة</label>
                        <input type="password" name="password" class="form-control <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                               placeholder="اتركه فارغاً إذا لم ترد التغيير">
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
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">تأكيد كلمة المرور</label>
                        <input type="password" name="password_confirmation" class="form-control">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">المسمى الوظيفي</label>
                        <input type="text" name="job_title" class="form-control <?php $__errorArgs = ['job_title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                               value="<?php echo e(old('job_title', $admin->job_title)); ?>">
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

                    <div class="col-md-6">
                        <label class="form-label">الحالة <span class="text-danger">*</span></label>
                        <select name="status" class="form-select <?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required
                                <?php echo e($admin->isDeveloper() ? 'disabled' : ''); ?>>
                            <option value="active" <?php echo e(old('status', $admin->status) == 'active' ? 'selected' : ''); ?>>نشط</option>
                            <option value="inactive" <?php echo e(old('status', $admin->status) == 'inactive' ? 'selected' : ''); ?>>غير نشط</option>
                        </select>
                        <?php if($admin->isDeveloper()): ?>
                            <input type="hidden" name="status" value="active">
                        <?php endif; ?>
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

            <!-- الصلاحيات المخصصة -->
            <div class="content-card mb-4">
                <h5 class="mb-4">
                    <i class="fas fa-key me-2" style="color: var(--primary-color);"></i>
                    صلاحيات الموظف
                    <?php if($admin->isDeveloper()): ?>
                        <span class="badge bg-warning ms-2">المطور لديه جميع الصلاحيات</span>
                    <?php endif; ?>
                </h5>
                
                <?php if($admin->isDeveloper()): ?>
                    <div class="alert alert-info">
                        <i class="fas fa-crown me-2"></i>
                        المطور لديه جميع الصلاحيات تلقائياً ولا يمكن تعديلها
                    </div>
                <?php else: ?>
                <div class="row">
                    <!-- الطالبات -->
                    <div class="col-md-6 col-lg-4 mb-3">
                        <div class="permission-card">
                            <div class="permission-header">
                                <i class="fas fa-user-graduate me-2"></i>الطالبات
                            </div>
                            <div class="permission-body">
                                <div class="form-check">
                                    <input type="checkbox" name="permissions[]" value="students.view" 
                                           class="form-check-input" id="perm_students_view"
                                           <?php echo e(in_array('students.view', old('permissions', $adminPermissions)) ? 'checked' : ''); ?>>
                                    <label class="form-check-label" for="perm_students_view">عرض الطالبات</label>
                                </div>
                                <div class="form-check">
                                    <input type="checkbox" name="permissions[]" value="students.create" 
                                           class="form-check-input" id="perm_students_create"
                                           <?php echo e(in_array('students.create', old('permissions', $adminPermissions)) ? 'checked' : ''); ?>>
                                    <label class="form-check-label" for="perm_students_create">إضافة طالبات</label>
                                </div>
                                <div class="form-check">
                                    <input type="checkbox" name="permissions[]" value="students.edit" 
                                           class="form-check-input" id="perm_students_edit"
                                           <?php echo e(in_array('students.edit', old('permissions', $adminPermissions)) ? 'checked' : ''); ?>>
                                    <label class="form-check-label" for="perm_students_edit">تعديل الطالبات</label>
                                </div>
                                <div class="form-check">
                                    <input type="checkbox" name="permissions[]" value="students.delete" 
                                           class="form-check-input" id="perm_students_delete"
                                           <?php echo e(in_array('students.delete', old('permissions', $adminPermissions)) ? 'checked' : ''); ?>>
                                    <label class="form-check-label" for="perm_students_delete">حذف الطالبات</label>
                                </div>
                                <div class="form-check">
                                    <input type="checkbox" name="permissions[]" value="students.approve" 
                                           class="form-check-input" id="perm_students_approve"
                                           <?php echo e(in_array('students.approve', old('permissions', $adminPermissions)) ? 'checked' : ''); ?>>
                                    <label class="form-check-label" for="perm_students_approve">قبول/رفض الطالبات</label>
                                </div>
                                <div class="form-check">
                                    <input type="checkbox" name="permissions[]" value="students.assign_bus" 
                                           class="form-check-input" id="perm_students_assign_bus"
                                           <?php echo e(in_array('students.assign_bus', old('permissions', $adminPermissions)) ? 'checked' : ''); ?>>
                                    <label class="form-check-label" for="perm_students_assign_bus">تخصيص باصات</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- الباصات -->
                    <div class="col-md-6 col-lg-4 mb-3">
                        <div class="permission-card">
                            <div class="permission-header">
                                <i class="fas fa-bus me-2"></i>الباصات
                            </div>
                            <div class="permission-body">
                                <div class="form-check">
                                    <input type="checkbox" name="permissions[]" value="buses.view" 
                                           class="form-check-input" id="perm_buses_view"
                                           <?php echo e(in_array('buses.view', old('permissions', $adminPermissions)) ? 'checked' : ''); ?>>
                                    <label class="form-check-label" for="perm_buses_view">عرض الباصات</label>
                                </div>
                                <div class="form-check">
                                    <input type="checkbox" name="permissions[]" value="buses.create" 
                                           class="form-check-input" id="perm_buses_create"
                                           <?php echo e(in_array('buses.create', old('permissions', $adminPermissions)) ? 'checked' : ''); ?>>
                                    <label class="form-check-label" for="perm_buses_create">إضافة باصات</label>
                                </div>
                                <div class="form-check">
                                    <input type="checkbox" name="permissions[]" value="buses.edit" 
                                           class="form-check-input" id="perm_buses_edit"
                                           <?php echo e(in_array('buses.edit', old('permissions', $adminPermissions)) ? 'checked' : ''); ?>>
                                    <label class="form-check-label" for="perm_buses_edit">تعديل الباصات</label>
                                </div>
                                <div class="form-check">
                                    <input type="checkbox" name="permissions[]" value="buses.delete" 
                                           class="form-check-input" id="perm_buses_delete"
                                           <?php echo e(in_array('buses.delete', old('permissions', $adminPermissions)) ? 'checked' : ''); ?>>
                                    <label class="form-check-label" for="perm_buses_delete">حذف الباصات</label>
                                </div>
                                <div class="form-check">
                                    <input type="checkbox" name="permissions[]" value="buses.assign_students" 
                                           class="form-check-input" id="perm_buses_assign"
                                           <?php echo e(in_array('buses.assign_students', old('permissions', $adminPermissions)) ? 'checked' : ''); ?>>
                                    <label class="form-check-label" for="perm_buses_assign">تخصيص طالبات للباصات</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- السائقين -->
                    <div class="col-md-6 col-lg-4 mb-3">
                        <div class="permission-card">
                            <div class="permission-header">
                                <i class="fas fa-id-card me-2"></i>السائقين
                            </div>
                            <div class="permission-body">
                                <div class="form-check">
                                    <input type="checkbox" name="permissions[]" value="drivers.view" 
                                           class="form-check-input" id="perm_drivers_view"
                                           <?php echo e(in_array('drivers.view', old('permissions', $adminPermissions)) ? 'checked' : ''); ?>>
                                    <label class="form-check-label" for="perm_drivers_view">عرض السائقين</label>
                                </div>
                                <div class="form-check">
                                    <input type="checkbox" name="permissions[]" value="drivers.create" 
                                           class="form-check-input" id="perm_drivers_create"
                                           <?php echo e(in_array('drivers.create', old('permissions', $adminPermissions)) ? 'checked' : ''); ?>>
                                    <label class="form-check-label" for="perm_drivers_create">إضافة سائقين</label>
                                </div>
                                <div class="form-check">
                                    <input type="checkbox" name="permissions[]" value="drivers.edit" 
                                           class="form-check-input" id="perm_drivers_edit"
                                           <?php echo e(in_array('drivers.edit', old('permissions', $adminPermissions)) ? 'checked' : ''); ?>>
                                    <label class="form-check-label" for="perm_drivers_edit">تعديل السائقين</label>
                                </div>
                                <div class="form-check">
                                    <input type="checkbox" name="permissions[]" value="drivers.delete" 
                                           class="form-check-input" id="perm_drivers_delete"
                                           <?php echo e(in_array('drivers.delete', old('permissions', $adminPermissions)) ? 'checked' : ''); ?>>
                                    <label class="form-check-label" for="perm_drivers_delete">حذف السائقين</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- الدفعات -->
                    <div class="col-md-6 col-lg-4 mb-3">
                        <div class="permission-card">
                            <div class="permission-header">
                                <i class="fas fa-money-bill-wave me-2"></i>الدفعات
                            </div>
                            <div class="permission-body">
                                <div class="form-check">
                                    <input type="checkbox" name="permissions[]" value="payments.view" 
                                           class="form-check-input" id="perm_payments_view"
                                           <?php echo e(in_array('payments.view', old('permissions', $adminPermissions)) ? 'checked' : ''); ?>>
                                    <label class="form-check-label" for="perm_payments_view">عرض الدفعات</label>
                                </div>
                                <div class="form-check">
                                    <input type="checkbox" name="permissions[]" value="payments.create" 
                                           class="form-check-input" id="perm_payments_create"
                                           <?php echo e(in_array('payments.create', old('permissions', $adminPermissions)) ? 'checked' : ''); ?>>
                                    <label class="form-check-label" for="perm_payments_create">إضافة دفعات</label>
                                </div>
                                <div class="form-check">
                                    <input type="checkbox" name="permissions[]" value="payments.edit" 
                                           class="form-check-input" id="perm_payments_edit"
                                           <?php echo e(in_array('payments.edit', old('permissions', $adminPermissions)) ? 'checked' : ''); ?>>
                                    <label class="form-check-label" for="perm_payments_edit">تعديل الدفعات</label>
                                </div>
                                <div class="form-check">
                                    <input type="checkbox" name="permissions[]" value="payments.delete" 
                                           class="form-check-input" id="perm_payments_delete"
                                           <?php echo e(in_array('payments.delete', old('permissions', $adminPermissions)) ? 'checked' : ''); ?>>
                                    <label class="form-check-label" for="perm_payments_delete">حذف الدفعات</label>
                                </div>
                                <div class="form-check">
                                    <input type="checkbox" name="permissions[]" value="payments.approve" 
                                           class="form-check-input" id="perm_payments_approve"
                                           <?php echo e(in_array('payments.approve', old('permissions', $adminPermissions)) ? 'checked' : ''); ?>>
                                    <label class="form-check-label" for="perm_payments_approve">اعتماد الدفعات</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- الجهات -->
                    <div class="col-md-6 col-lg-4 mb-3">
                        <div class="permission-card">
                            <div class="permission-header">
                                <i class="fas fa-building me-2"></i>الجهات
                            </div>
                            <div class="permission-body">
                                <div class="form-check">
                                    <input type="checkbox" name="permissions[]" value="centers.view" 
                                           class="form-check-input" id="perm_centers_view"
                                           <?php echo e(in_array('centers.view', old('permissions', $adminPermissions)) ? 'checked' : ''); ?>>
                                    <label class="form-check-label" for="perm_centers_view">عرض الجهات</label>
                                </div>
                                <div class="form-check">
                                    <input type="checkbox" name="permissions[]" value="centers.edit" 
                                           class="form-check-input" id="perm_centers_edit"
                                           <?php echo e(in_array('centers.edit', old('permissions', $adminPermissions)) ? 'checked' : ''); ?>>
                                    <label class="form-check-label" for="perm_centers_edit">تعديل الجهات</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- التقارير والموظفين -->
                    <div class="col-md-6 col-lg-4 mb-3">
                        <div class="permission-card">
                            <div class="permission-header">
                                <i class="fas fa-cog me-2"></i>أخرى
                            </div>
                            <div class="permission-body">
                                <div class="form-check">
                                    <input type="checkbox" name="permissions[]" value="reports.view" 
                                           class="form-check-input" id="perm_reports_view"
                                           <?php echo e(in_array('reports.view', old('permissions', $adminPermissions)) ? 'checked' : ''); ?>>
                                    <label class="form-check-label" for="perm_reports_view">عرض التقارير</label>
                                </div>
                                <div class="form-check">
                                    <input type="checkbox" name="permissions[]" value="reports.create" 
                                           class="form-check-input" id="perm_reports_create"
                                           <?php echo e(in_array('reports.create', old('permissions', $adminPermissions)) ? 'checked' : ''); ?>>
                                    <label class="form-check-label" for="perm_reports_create">إنشاء التقارير</label>
                                </div>
                                <div class="form-check">
                                    <input type="checkbox" name="permissions[]" value="admins.view" 
                                           class="form-check-input" id="perm_admins_view"
                                           <?php echo e(in_array('admins.view', old('permissions', $adminPermissions)) ? 'checked' : ''); ?>>
                                    <label class="form-check-label" for="perm_admins_view">عرض الموظفين</label>
                                </div>
                                <div class="form-check">
                                    <input type="checkbox" name="permissions[]" value="admins.create" 
                                           class="form-check-input" id="perm_admins_create"
                                           <?php echo e(in_array('admins.create', old('permissions', $adminPermissions)) ? 'checked' : ''); ?>>
                                    <label class="form-check-label" for="perm_admins_create">إضافة موظفين</label>
                                </div>
                                <div class="form-check">
                                    <input type="checkbox" name="permissions[]" value="admins.edit" 
                                           class="form-check-input" id="perm_admins_edit"
                                           <?php echo e(in_array('admins.edit', old('permissions', $adminPermissions)) ? 'checked' : ''); ?>>
                                    <label class="form-check-label" for="perm_admins_edit">تعديل الموظفين</label>
                                </div>
                                <div class="form-check">
                                    <input type="checkbox" name="permissions[]" value="admins.delete" 
                                           class="form-check-input" id="perm_admins_delete"
                                           <?php echo e(in_array('admins.delete', old('permissions', $adminPermissions)) ? 'checked' : ''); ?>>
                                    <label class="form-check-label" for="perm_admins_delete">حذف الموظفين</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- الشريط الجانبي -->
        <div class="col-lg-4">
            <!-- معلومات الموظف -->
            <div class="content-card mb-4">
                <div class="text-center mb-3">
                    <div class="rounded-circle d-inline-flex align-items-center justify-content-center mb-3" 
                         style="width: 80px; height: 80px; background: rgba(127, 176, 105, 0.2);">
                        <i class="fas <?php echo e($admin->role_icon ?? 'fa-user'); ?> fa-2x" style="color: var(--primary-color);"></i>
                    </div>
                    <h5 class="mb-1"><?php echo e($admin->name); ?></h5>
                    <span class="badge badge-role-<?php echo e($admin->role); ?>">
                        <i class="fas <?php echo e($admin->role_icon ?? 'fa-user'); ?> me-1"></i>
                        <?php echo e($admin->role_name); ?>

                    </span>
                </div>
                
                <hr>
                
                <div class="small text-muted">
                    <div class="d-flex justify-content-between mb-2">
                        <span><i class="fas fa-calendar me-2"></i>تاريخ الإنشاء</span>
                        <span><?php echo e($admin->created_at?->format('Y/m/d') ?? '-'); ?></span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span><i class="fas fa-clock me-2"></i>آخر دخول</span>
                        <span><?php echo e($admin->last_login?->diffForHumans() ?? 'لم يسجل'); ?></span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span><i class="fas fa-sign-in-alt me-2"></i>عدد الدخول</span>
                        <span><?php echo e($admin->login_count ?? 0); ?> مرة</span>
                    </div>
                </div>
            </div>

            <!-- الرتبة -->
            <div class="content-card mb-4">
                <h5 class="mb-4">
                    <i class="fas fa-user-tag me-2" style="color: var(--primary-color);"></i>
                    الرتبة
                </h5>
                
                <select name="role" class="form-select <?php $__errorArgs = ['role'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required
                        <?php echo e($admin->isDeveloper() ? 'disabled' : ''); ?>>
                    <?php if($currentAdmin && $currentAdmin->role == 'developer'): ?>
                        <option value="super_admin" <?php echo e(old('role', $admin->role) == 'super_admin' ? 'selected' : ''); ?>>مدير عام</option>
                    <?php endif; ?>
                    <option value="admin" <?php echo e(old('role', $admin->role) == 'admin' ? 'selected' : ''); ?>>مشرف</option>
                    <option value="data_entry" <?php echo e(old('role', $admin->role) == 'data_entry' ? 'selected' : ''); ?>>مدخل بيانات</option>
                    <option value="accountant" <?php echo e(old('role', $admin->role) == 'accountant' ? 'selected' : ''); ?>>محاسب</option>
                    <option value="supervisor" <?php echo e(old('role', $admin->role) == 'supervisor' ? 'selected' : ''); ?>>مراقب</option>
                </select>
                <?php if($admin->isDeveloper()): ?>
                    <input type="hidden" name="role" value="developer">
                <?php endif; ?>
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

            <!-- الفترات المسموح بها -->
            <div class="content-card mb-4">
                <h5 class="mb-3">
                    <i class="fas fa-clock me-2" style="color: var(--primary-color);"></i>
                    الفترات المسموح بها
                </h5>
                
                <?php if($admin->isSuper()): ?>
                    <div class="alert alert-info py-2 mb-0">
                        <i class="fas fa-globe me-2"></i>
                        هذه الرتبة لها وصول لكل الفترات تلقائياً
                    </div>
                <?php else: ?>
                    <div class="alert alert-info py-2 mb-3">
                        <small><i class="fas fa-info-circle me-1"></i>إذا لم تختر أي فترة، سيكون له وصول لكل الفترات</small>
                    </div>
                    
                    <div class="form-check mb-2">
                        <input type="checkbox" name="allowed_schedules[]" value="صباحية" 
                               class="form-check-input" id="schedule_morning"
                               <?php echo e(in_array('صباحية', old('allowed_schedules', $adminSchedules)) ? 'checked' : ''); ?>>
                        <label class="form-check-label" for="schedule_morning">
                            <i class="fas fa-sun text-warning me-1"></i>
                            الفترة الصباحية
                        </label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" name="allowed_schedules[]" value="مسائية" 
                               class="form-check-input" id="schedule_evening"
                               <?php echo e(in_array('مسائية', old('allowed_schedules', $adminSchedules)) ? 'checked' : ''); ?>>
                        <label class="form-check-label" for="schedule_evening">
                            <i class="fas fa-moon text-primary me-1"></i>
                            الفترة المسائية
                        </label>
                    </div>
                <?php endif; ?>
            </div>

            <!-- الجهات المسؤول عنها -->
            <div class="content-card mb-4">
                <h5 class="mb-3">
                    <i class="fas fa-building me-2" style="color: var(--primary-color);"></i>
                    الجهات المسؤول عنها
                </h5>
                
                <?php if($admin->isSuper()): ?>
                    <div class="alert alert-info py-2 mb-0">
                        <i class="fas fa-globe me-2"></i>
                        هذه الرتبة لها وصول لجميع الجهات تلقائياً
                    </div>
                <?php else: ?>
                    <div class="alert alert-warning py-2 mb-3">
                        <small><i class="fas fa-exclamation-triangle me-1"></i>إذا لم تختر أي جهة، سيكون مسؤولاً عن جميع الجهات</small>
                    </div>
                    
                    <div class="form-check mb-2">
                        <input type="checkbox" class="form-check-input" id="selectAllCenters">
                        <label class="form-check-label fw-bold" for="selectAllCenters">تحديد الكل</label>
                    </div>
                    
                    <hr class="my-2">
                    
                    <?php
                        $selectedCenterIds = old('center_ids', $admin->centers->pluck('id')->toArray());
                    ?>
                    
                    <?php $__currentLoopData = $centers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $center): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="form-check">
                            <input type="checkbox" name="center_ids[]" value="<?php echo e($center->id); ?>" 
                                   class="form-check-input center-checkbox" id="center_<?php echo e($center->id); ?>"
                                   <?php echo e(in_array($center->id, $selectedCenterIds) ? 'checked' : ''); ?>>
                            <label class="form-check-label" for="center_<?php echo e($center->id); ?>">
                                <?php echo e($center->center_name); ?>

                            </label>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>
            </div>

            <!-- أزرار الحفظ -->
            <div class="content-card">
                <button type="submit" class="btn btn-primary w-100 mb-2">
                    <i class="fas fa-save me-2"></i>حفظ التعديلات
                </button>
                <a href="<?php echo e(route('admin.admins.index')); ?>" class="btn btn-outline-secondary w-100">
                    <i class="fas fa-times me-2"></i>إلغاء
                </a>
            </div>
        </div>
    </div>
</form>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
<style>
    .permission-card {
        background: rgba(255,255,255,0.03);
        border: 1px solid rgba(255,255,255,0.1);
        border-radius: 10px;
        overflow: hidden;
        height: 100%;
    }
    .permission-header {
        background: rgba(127, 176, 105, 0.15);
        padding: 10px 15px;
        font-weight: 600;
        color: var(--primary-color);
        border-bottom: 1px solid rgba(255,255,255,0.1);
    }
    .permission-body {
        padding: 15px;
    }
    .permission-body .form-check {
        margin-bottom: 8px;
    }
    .permission-body .form-check:last-child {
        margin-bottom: 0;
    }
    .badge-role-developer { background: rgba(255, 193, 7, 0.2) !important; color: #f39c12 !important; }
    .badge-role-super_admin { background: rgba(220, 53, 69, 0.15) !important; color: #ff6b7a !important; }
    .badge-role-admin { background: rgba(127, 176, 105, 0.15) !important; color: #7fb069 !important; }
    .badge-role-data_entry { background: rgba(23, 162, 184, 0.15) !important; color: #5dd3e8 !important; }
    .badge-role-accountant { background: rgba(40, 167, 69, 0.15) !important; color: #5dd879 !important; }
    .badge-role-supervisor { background: rgba(108, 117, 125, 0.15) !important; color: #adb5bd !important; }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    const selectAll = document.getElementById('selectAllCenters');
    if (selectAll) {
        selectAll.addEventListener('change', function() {
            document.querySelectorAll('.center-checkbox').forEach(cb => cb.checked = this.checked);
        });
    }
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/rasedbus/project-bus/resources/views/admin/admins/edit.blade.php ENDPATH**/ ?>