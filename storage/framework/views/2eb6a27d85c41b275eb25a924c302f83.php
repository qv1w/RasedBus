

<?php
    use App\Models\Admin;
    $currentAdmin = Admin::find(session('admin_id'));
?>

<?php $__env->startSection('title', 'إدارة الموظفين'); ?>

<?php $__env->startSection('header'); ?>
<div class="d-flex justify-content-between align-items-center w-100">
    <div>
        <h2 class="mb-1">
            <i class="fas fa-users-cog me-2"></i>
            إدارة الموظفين
        </h2>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="<?php echo e(route('admin.dashboard')); ?>">لوحة التحكم</a></li>
                <li class="breadcrumb-item active">الموظفين</li>
            </ol>
        </nav>
    </div>
    <?php if($currentAdmin && in_array($currentAdmin->role, ['developer', 'super_admin'])): ?>
    <a href="<?php echo e(route('admin.admins.create')); ?>" class="btn btn-primary">
        <i class="fas fa-plus me-1"></i>
        إضافة موظف
    </a>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<!-- إحصائيات سريعة -->
<div class="row g-4 mb-4">
    <div class="col-md-4">
        <div class="stats-card">
            <div class="d-flex align-items-center">
                <div class="stats-icon bg-primary">
                    <i class="fas fa-users text-white"></i>
                </div>
                <div class="me-3">
                    <div class="stats-number"><?php echo e($stats['total'] ?? 0); ?></div>
                    <div class="text-muted">إجمالي الموظفين</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stats-card">
            <div class="d-flex align-items-center">
                <div class="stats-icon bg-success">
                    <i class="fas fa-user-check text-white"></i>
                </div>
                <div class="me-3">
                    <div class="stats-number"><?php echo e($stats['active'] ?? 0); ?></div>
                    <div class="text-muted">موظف نشط</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stats-card">
            <div class="d-flex align-items-center">
                <div class="stats-icon bg-danger">
                    <i class="fas fa-crown text-white"></i>
                </div>
                <div class="me-3">
                    <div class="stats-number"><?php echo e($stats['super_admins'] ?? 0); ?></div>
                    <div class="text-muted">مدير عام</div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- فلاتر البحث -->
<div class="content-card mb-4">
    <form action="<?php echo e(route('admin.admins.index')); ?>" method="GET">
        <div class="row g-3 align-items-end">
            <div class="col-md-4">
                <label class="form-label">البحث</label>
                <input type="text" name="search" class="form-control" 
                       placeholder="ابحث بالاسم أو البريد أو الجوال..."
                       value="<?php echo e(request('search')); ?>">
            </div>
            <div class="col-md-3">
                <label class="form-label">الرتبة</label>
                <select name="role" class="form-select">
                    <option value="">الكل</option>
                    <option value="developer" <?php echo e(request('role') == 'developer' ? 'selected' : ''); ?>>مطور النظام</option>
                    <option value="super_admin" <?php echo e(request('role') == 'super_admin' ? 'selected' : ''); ?>>مدير عام</option>
                    <option value="admin" <?php echo e(request('role') == 'admin' ? 'selected' : ''); ?>>مشرف</option>
                    <option value="data_entry" <?php echo e(request('role') == 'data_entry' ? 'selected' : ''); ?>>مدخل بيانات</option>
                    <option value="accountant" <?php echo e(request('role') == 'accountant' ? 'selected' : ''); ?>>محاسب</option>
                    <option value="supervisor" <?php echo e(request('role') == 'supervisor' ? 'selected' : ''); ?>>مراقب</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">الحالة</label>
                <select name="status" class="form-select">
                    <option value="">الكل</option>
                    <option value="active" <?php echo e(request('status') == 'active' ? 'selected' : ''); ?>>نشط</option>
                    <option value="inactive" <?php echo e(request('status') == 'inactive' ? 'selected' : ''); ?>>غير نشط</option>
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="fas fa-search me-1"></i>
                    بحث
                </button>
            </div>
        </div>
    </form>
</div>

<!-- جدول الموظفين -->
<div class="content-card">
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>الموظف</th>
                    <th>الرتبة</th>
                    <th>الجهات</th>
                    <th>الفترات</th>
                    <th>الحالة</th>
                    <th>آخر دخول</th>
                    <th>الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $admins; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $admin): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td><?php echo e($admin->id); ?></td>
                    <td>
                        <div class="d-flex align-items-center">
                            <div class="rounded-circle d-flex align-items-center justify-content-center me-2" 
                                 style="width: 40px; height: 40px; background: rgba(127, 176, 105, 0.2);">
                                <i class="fas <?php echo e($admin->role_icon ?? 'fa-user'); ?>" style="color: var(--primary-color);"></i>
                            </div>
                            <div>
                                <div class="fw-bold">
                                    <?php echo e($admin->name); ?>

                                    <?php if($admin->id == session('admin_id')): ?>
                                        <span class="badge bg-warning ms-1">أنت</span>
                                    <?php endif; ?>
                                    <?php if($admin->role == 'developer'): ?>
                                        <span class="badge badge-protected ms-1">
                                            <i class="fas fa-shield-alt me-1"></i>محمي
                                        </span>
                                    <?php endif; ?>
                                </div>
                                <small class="text-muted"><?php echo e($admin->username); ?></small>
                            </div>
                        </div>
                    </td>
                    <td>
                        <?php
                            $roleNames = [
                                'developer' => 'مطور النظام',
                                'super_admin' => 'مدير عام',
                                'admin' => 'مشرف',
                                'data_entry' => 'مدخل بيانات',
                                'accountant' => 'محاسب',
                                'supervisor' => 'مراقب',
                            ];
                            $roleIcons = [
                                'developer' => 'fa-code',
                                'super_admin' => 'fa-crown',
                                'admin' => 'fa-user-shield',
                                'data_entry' => 'fa-keyboard',
                                'accountant' => 'fa-calculator',
                                'supervisor' => 'fa-eye',
                            ];
                        ?>
                        <span class="badge badge-role-<?php echo e($admin->role); ?>">
                            <i class="fas <?php echo e($roleIcons[$admin->role] ?? 'fa-user'); ?> me-1"></i>
                            <?php echo e($roleNames[$admin->role] ?? 'غير محدد'); ?>

                        </span>
                    </td>
                    <td>
                        <?php if(in_array($admin->role, ['developer', 'super_admin'])): ?>
                            <span class="text-success small">
                                <i class="fas fa-globe me-1"></i>جميع الجهات
                            </span>
                        <?php elseif($admin->centers->isEmpty()): ?>
                            <span class="text-muted small">
                                <i class="fas fa-globe me-1"></i>جميع الجهات
                            </span>
                        <?php else: ?>
                            <?php $__currentLoopData = $admin->centers->take(2); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $center): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <span class="badge bg-light text-dark mb-1"><?php echo e($center->center_name); ?></span>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php if($admin->centers->count() > 2): ?>
                                <span class="badge bg-secondary">+<?php echo e($admin->centers->count() - 2); ?></span>
                            <?php endif; ?>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if(in_array($admin->role, ['developer', 'super_admin'])): ?>
                            <span class="text-success small">
                                <i class="fas fa-clock me-1"></i>الكل
                            </span>
                        <?php else: ?>
                            <?php
                                $schedules = $admin->allowed_schedules ?? [];
                                if (!is_array($schedules)) $schedules = [];
                            ?>
                            <?php if(empty($schedules)): ?>
                                <span class="text-muted small">
                                    <i class="fas fa-clock me-1"></i>الكل
                                </span>
                            <?php else: ?>
                                <?php if(in_array('صباحية', $schedules)): ?>
                                    <span class="badge bg-warning text-dark mb-1">
                                        <i class="fas fa-sun me-1"></i>صباحية
                                    </span>
                                <?php endif; ?>
                                <?php if(in_array('مسائية', $schedules)): ?>
                                    <span class="badge bg-primary mb-1">
                                        <i class="fas fa-moon me-1"></i>مسائية
                                    </span>
                                <?php endif; ?>
                            <?php endif; ?>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if($admin->status == 'active'): ?>
                            <span class="badge bg-success">نشط</span>
                        <?php else: ?>
                            <span class="badge bg-danger">غير نشط</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if($admin->last_login): ?>
                            <small><?php echo e(\Carbon\Carbon::parse($admin->last_login)->diffForHumans()); ?></small>
                        <?php else: ?>
                            <small class="text-muted">لم يدخل بعد</small>
                        <?php endif; ?>
                    </td>
                    <td>
                        <div class="btn-group" role="group">
                            <?php if($currentAdmin && $admin->role != 'developer'): ?>
                                <?php if($currentAdmin->role == 'developer' || ($currentAdmin->role == 'super_admin' && $admin->role != 'super_admin')): ?>
                                <a href="<?php echo e(route('admin.admins.edit', $admin)); ?>" 
                                   class="btn btn-sm btn-outline-warning" title="تعديل">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <?php endif; ?>
                            <?php endif; ?>
                            
                            <?php if($currentAdmin && $admin->id != session('admin_id') && $admin->role != 'developer'): ?>
                                <?php if($currentAdmin->role == 'developer' || ($currentAdmin->role == 'super_admin' && $admin->role != 'super_admin')): ?>
                                <form action="<?php echo e(route('admin.admins.toggle-status', $admin)); ?>" 
                                      method="POST" class="d-inline">
                                    <?php echo csrf_field(); ?>
                                    <button type="submit" 
                                            class="btn btn-sm btn-outline-<?php echo e($admin->status == 'active' ? 'secondary' : 'success'); ?>"
                                            title="<?php echo e($admin->status == 'active' ? 'تعطيل' : 'تفعيل'); ?>">
                                        <i class="fas fa-<?php echo e($admin->status == 'active' ? 'ban' : 'check'); ?>"></i>
                                    </button>
                                </form>
                                <?php endif; ?>
                                
                                <?php if($currentAdmin->role == 'developer' || ($currentAdmin->role == 'super_admin' && !in_array($admin->role, ['developer', 'super_admin']))): ?>
                                <button type="button" class="btn btn-sm btn-outline-danger" 
                                        onclick="confirmDelete(<?php echo e($admin->id); ?>, '<?php echo e($admin->name); ?>')"
                                        title="حذف">
                                    <i class="fas fa-trash"></i>
                                </button>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="8" class="text-center py-4">
                        <i class="fas fa-users fa-3x mb-3 text-muted"></i>
                        <p class="text-muted">لا يوجد موظفين</p>
                    </td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    
    <?php if($admins->hasPages()): ?>
    <div class="d-flex justify-content-center mt-4">
        <?php echo e($admins->links()); ?>

    </div>
    <?php endif; ?>
</div>

<!-- Modal تأكيد الحذف -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    تأكيد الحذف
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center py-4">
                <i class="fas fa-user-times fa-4x text-danger mb-3"></i>
                <p class="mb-0">هل أنت متأكد من حذف الموظف:</p>
                <h5 id="adminNameToDelete" class="text-danger mt-2"></h5>
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                <form id="deleteForm" method="POST" class="d-inline">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('DELETE'); ?>
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash me-1"></i>حذف
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
<style>
    .badge-role-developer { background: rgba(255, 193, 7, 0.2) !important; color: #f39c12 !important; }
    .badge-role-super_admin { background: rgba(220, 53, 69, 0.15) !important; color: #ff6b7a !important; }
    .badge-role-admin { background: rgba(127, 176, 105, 0.15) !important; color: #7fb069 !important; }
    .badge-role-data_entry { background: rgba(23, 162, 184, 0.15) !important; color: #5dd3e8 !important; }
    .badge-role-accountant { background: rgba(40, 167, 69, 0.15) !important; color: #5dd879 !important; }
    .badge-role-supervisor { background: rgba(108, 117, 125, 0.15) !important; color: #adb5bd !important; }
    .badge-protected { background: rgba(108, 117, 125, 0.15) !important; color: #adb5bd !important; }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
function confirmDelete(adminId, adminName) {
    document.getElementById('adminNameToDelete').textContent = adminName;
    document.getElementById('deleteForm').action = '/admin/admins/' + adminId;
    new bootstrap.Modal(document.getElementById('deleteModal')).show();
}
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/rasedbus/project-bus/resources/views/admin/admins/index.blade.php ENDPATH**/ ?>