

<?php $__env->startSection('title', 'إدارة الطلاب'); ?>

<?php $__env->startSection('header'); ?>
<div class="d-flex justify-content-between align-items-center w-100">
    <div>
        <h2 class="mb-1">
            <i class="fas fa-user-graduate text-info me-2"></i>
            إدارة الطلاب والطالبات
        </h2>
        <p class="text-light mb-0 opacity-75">إدارة تسجيلات وبيانات الطلاب والطالبات</p>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<!-- الإحصائيات -->
<div class="row mb-4">
    <div class="col-md-3 mb-3">
        <div class="stats-card">
            <div class="d-flex align-items-center">
                <div class="stats-icon bg-primary-light me-3">
                    <i class="fas fa-users text-primary"></i>
                </div>
                <div>
                    <h3 class="mb-0 text-white"><?php echo e($stats['total'] ?? 0); ?></h3>
                    <small class="text-muted">إجمالي المسجلين</small>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="stats-card">
            <div class="d-flex align-items-center">
                <div class="stats-icon bg-warning-light me-3">
                    <i class="fas fa-clock text-warning"></i>
                </div>
                <div>
                    <h3 class="mb-0 text-white"><?php echo e($stats['pending'] ?? 0); ?></h3>
                    <small class="text-muted">قيد المراجعة</small>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="stats-card">
            <div class="d-flex align-items-center">
                <div class="stats-icon bg-success-light me-3">
                    <i class="fas fa-check-circle text-success"></i>
                </div>
                <div>
                    <h3 class="mb-0 text-white"><?php echo e($stats['approved'] ?? 0); ?></h3>
                    <small class="text-muted">مقبول</small>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="stats-card">
            <div class="d-flex align-items-center">
                <div class="stats-icon bg-danger-light me-3">
                    <i class="fas fa-times-circle text-danger"></i>
                </div>
                <div>
                    <h3 class="mb-0 text-white"><?php echo e($stats['rejected'] ?? 0); ?></h3>
                    <small class="text-muted">مرفوض</small>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- زر حذف الكل - للمشرف العام فقط -->
<?php if(in_array(session('admin_role'), ['developer', 'super_admin'])): ?>
<div class="content-card mb-4 border-danger-subtle">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h6 class="text-danger mb-1">
                <i class="fas fa-exclamation-triangle me-2"></i>
اعاده تعيين التسجيل 
            </h6>
            <small class="text-muted">هذه العمليه لا يمكن التراجع عنها </small>
        </div>
        <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteAllStudentsModal" <?php echo e(($stats['total'] ?? 0) == 0 ? 'disabled' : ''); ?>>
            <i class="fas fa-trash-alt me-1"></i>
            حذف جميع الطلاب (<?php echo e($stats['total'] ?? 0); ?>)
        </button>
    </div>
</div>

<!-- Modal تأكيد حذف جميع الطلاب -->
<div class="modal fade" id="deleteAllStudentsModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-dark border-danger">
            <div class="modal-header border-danger">
                <h5 class="modal-title text-danger">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    تحذير! حذف جميع الطلاب
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger">
                    <i class="fas fa-skull-crossbones me-2"></i>
                    <strong>هذا الإجراء لا يمكن التراجع عنه!</strong>
                </div>
                <p class="mb-3">سيتم حذف:</p>
                <ul class="text-danger">
                    <li><strong><?php echo e($stats['total'] ?? 0); ?></strong> طالب/ة نهائياً</li>
                    <li>جميع المدفوعات المرتبطة بالطلاب</li>
                </ul>
                <hr class="border-secondary">
                <p class="mb-2">للتأكيد، اكتب: <code class="text-danger fs-5">حذف الكل</code></p>
                <input type="text" id="confirmDeleteText" class="form-control bg-dark text-white border-secondary" 
                       placeholder="اكتب هنا: حذف الكل" autocomplete="off">
            </div>
            <div class="modal-footer border-secondary">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i> إلغاء
                </button>
                <form action="<?php echo e(route('admin.students.deleteAll')); ?>" method="POST" id="deleteAllForm">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('DELETE'); ?>
                    <button type="submit" class="btn btn-danger" id="confirmDeleteBtn" disabled>
                        <i class="fas fa-trash-alt me-1"></i>
                        حذف الكل نهائياً
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<!-- فلاتر سريعة - تصنيفات -->
<div class="content-card mb-4">
    <div class="d-flex flex-wrap gap-2 align-items-center">
        <span class="text-muted me-2"><i class="fas fa-filter me-1"></i> تصنيف:</span>
        
        <!-- الكل -->
        <a href="<?php echo e(route('admin.students.index')); ?>" 
           class="btn btn-sm <?php echo e(!request('gender') && !request('type') && !request('status') ? 'btn-primary' : 'btn-outline-secondary'); ?>">
            <i class="fas fa-users me-1"></i> الكل
        </a>
        
        <span class="border-start border-secondary mx-2" style="height: 20px;"></span>
        
        <!-- تصنيف الجنس -->
        <span class="text-muted small">الجنس:</span>
        <a href="<?php echo e(route('admin.students.index', array_merge(request()->except('gender'), ['gender' => 'أنثى']))); ?>" 
           class="btn btn-sm <?php echo e(request('gender') == 'أنثى' ? 'btn-pink' : 'btn-outline-pink'); ?>">
            <i class="fas fa-female me-1"></i> بنات
        </a>
        <a href="<?php echo e(route('admin.students.index', array_merge(request()->except('gender'), ['gender' => 'ذكر']))); ?>" 
           class="btn btn-sm <?php echo e(request('gender') == 'ذكر' ? 'btn-info' : 'btn-outline-info'); ?>">
            <i class="fas fa-male me-1"></i> بنين
        </a>
        
        <span class="border-start border-secondary mx-2" style="height: 20px;"></span>
        
        <!-- تصنيف النوع -->
        <span class="text-muted small">النوع:</span>
        <a href="<?php echo e(route('admin.students.index', array_merge(request()->except('type'), ['type' => 'دار']))); ?>" 
           class="btn btn-sm <?php echo e(request('type') == 'دار' ? 'btn-dar' : 'btn-outline-dar'); ?>">
            <i class="fas fa-mosque me-1"></i> دور التحفيظ
        </a>
        <a href="<?php echo e(route('admin.students.index', array_merge(request()->except('type'), ['type' => 'مركز']))); ?>" 
           class="btn btn-sm <?php echo e(request('type') == 'مركز' ? 'btn-markaz' : 'btn-outline-markaz'); ?>">
            <i class="fas fa-graduation-cap me-1"></i> المركز
        </a>
        <a href="<?php echo e(route('admin.students.index', array_merge(request()->except('type'), ['type' => 'برنامج']))); ?>" 
           class="btn btn-sm <?php echo e(request('type') == 'برنامج' ? 'btn-program' : 'btn-outline-program'); ?>">
            <i class="fas fa-seedling me-1"></i> الرياحين
        </a>
    </div>
</div>

<!-- فلاتر البحث المتقدم -->
<div class="content-card mb-4">
    <form action="<?php echo e(route('admin.students.index')); ?>" method="GET" class="row g-3">
        <?php if(request('gender')): ?>
            <input type="hidden" name="gender" value="<?php echo e(request('gender')); ?>">
        <?php endif; ?>
        <?php if(request('type')): ?>
            <input type="hidden" name="type" value="<?php echo e(request('type')); ?>">
        <?php endif; ?>
        
        <div class="col-md-3">
            <label class="form-label">بحث</label>
            <input type="text" name="search" class="form-control" 
                   placeholder="اسم، رقم هوية، جوال..." 
                   value="<?php echo e(request('search')); ?>">
        </div>
        <div class="col-md-2">
            <label class="form-label">الحالة</label>
            <select name="status" class="form-select">
                <option value="">الكل</option>
                <?php $__currentLoopData = $statuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($key); ?>" <?php echo e(request('status') == $key ? 'selected' : ''); ?>>
                        <?php echo e($value); ?>

                    </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
        <div class="col-md-3">
            <label class="form-label">الجهة</label>
            <select name="center_id" class="form-select">
                <option value="">الكل</option>
                <?php $__currentLoopData = $centers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $name): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($id); ?>" <?php echo e(request('center_id') == $id ? 'selected' : ''); ?>>
                        <?php echo e($name); ?>

                    </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
        <div class="col-md-2">
            <label class="form-label">الفترة</label>
            <select name="schedule" class="form-select">
                <option value="">الكل</option>
                <?php $__currentLoopData = $schedules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($key); ?>" <?php echo e(request('schedule') == $key ? 'selected' : ''); ?>>
                        <?php echo e($value); ?>

                    </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
        <div class="col-md-2 d-flex align-items-end gap-2">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-search me-1"></i>
                بحث
            </button>
            <a href="<?php echo e(route('admin.students.index')); ?>" class="btn btn-outline-secondary">
                <i class="fas fa-redo"></i>
            </a>
        </div>
    </form>
</div>

<!-- جدول الطلاب -->
<div class="content-card">
    <?php if($students->count() > 0): ?>
    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead>
                <tr>
                    <th>الطالب/ة</th>
                    <th>الجهة</th>
                    <th>النوع</th>
                    <th>الفترة</th>
                    <th>الجوال</th>
                    <th>الحالة</th>
                    <th>التسجيل</th>
                    <th>إجراءات</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $students; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td>
                        <div class="d-flex align-items-center">
                            <div class="student-avatar <?php echo e($student->gender == 'ذكر' ? 'male' : 'female'); ?> me-2">
                                <i class="fas fa-<?php echo e($student->gender == 'ذكر' ? 'male' : 'female'); ?>"></i>
                            </div>
                            <div>
                                <strong class="text-white"><?php echo e($student->name); ?></strong>
                                <br>
                                <small class="text-muted"><?php echo e($student->student_id); ?></small>
                            </div>
                        </div>
                    </td>
                    <td>
                        <?php if($student->center): ?>
                            <span class="badge bg-secondary">
                                <?php echo e($student->center->center_name); ?>

                            </span>
                        <?php else: ?>
                            <span class="badge bg-secondary">غير محدد</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if($student->center): ?>
                            <?php
                                $badgeClass = ['دار' => 'badge-type-dar', 'مركز' => 'badge-type-markaz', 'برنامج' => 'badge-type-program'][$student->center->type] ?? 'bg-secondary';
                                $badgeIcon = ['دار' => 'mosque', 'مركز' => 'graduation-cap', 'برنامج' => 'seedling'][$student->center->type] ?? 'building';
                            ?>
                            <span class="badge <?php echo e($badgeClass); ?>">
                                <i class="fas fa-<?php echo e($badgeIcon); ?> me-1"></i>
                                <?php echo e($student->center->type); ?>

                            </span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <span class="badge <?php echo e($student->preferred_schedule == 'صباحية' ? 'badge-period-morning' : 'badge-period-evening'); ?>">
                            <i class="fas fa-<?php echo e($student->preferred_schedule == 'صباحية' ? 'sun' : 'moon'); ?> me-1"></i>
                            <?php echo e($student->preferred_schedule); ?>

                        </span>
                    </td>
                    <td>
                        <a href="tel:<?php echo e($student->mobile); ?>" class="text-info text-decoration-none">
                            <?php echo e($student->mobile); ?>

                        </a>
                    </td>
                    <td>
                        <?php
                            $statusColors = ['pending' => 'warning', 'approved' => 'success', 'rejected' => 'danger', 'suspended' => 'secondary'];
                            $statusTexts = ['pending' => 'قيد المراجعة', 'approved' => 'مقبول', 'rejected' => 'مرفوض', 'suspended' => 'موقوف'];
                        ?>
                        <span class="badge bg-<?php echo e($statusColors[$student->status] ?? 'secondary'); ?>">
                            <?php echo e($statusTexts[$student->status] ?? $student->status); ?>

                        </span>
                    </td>
                    <td>
                        <small class="text-muted"><?php echo e($student->created_at->format('Y/m/d')); ?></small>
                    </td>
                    <td>
                        <div class="btn-group btn-group-sm">
                            <a href="<?php echo e(route('admin.students.show', $student)); ?>" 
                               class="btn btn-outline-info" title="عرض">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="<?php echo e(route('admin.students.edit', $student)); ?>" 
                               class="btn btn-outline-warning" title="تعديل">
                                <i class="fas fa-edit"></i>
                            </a>
                            <?php if($student->status == 'pending'): ?>
                            <form action="<?php echo e(route('admin.students.approve', $student)); ?>" method="POST" class="d-inline">
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="btn btn-outline-success" title="قبول"
                                        onclick="return confirm('هل تريد قبول هذا الطلب؟')">
                                    <i class="fas fa-check"></i>
                                </button>
                            </form>
                            <form action="<?php echo e(route('admin.students.reject', $student)); ?>" method="POST" class="d-inline">
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="btn btn-outline-danger" title="رفض"
                                        onclick="return confirm('هل تريد رفض هذا الطلب؟')">
                                    <i class="fas fa-times"></i>
                                </button>
                            </form>
                            <?php endif; ?>
                        </div>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>
    
    <div class="d-flex justify-content-center mt-4">
        <?php echo e($students->withQueryString()->links()); ?>

    </div>
    <?php else: ?>
    <div class="text-center py-5">
        <i class="fas fa-user-graduate fa-4x text-muted opacity-50 mb-3"></i>
        <h4 class="text-muted">لا توجد نتائج</h4>
        <p class="text-muted">لم يتم العثور على أي طلاب مطابقين للبحث</p>
    </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
<style>
.stats-card {
    background: rgba(255,255,255,0.05);
    border-radius: 15px;
    padding: 1.25rem;
    border: 1px solid rgba(255,255,255,0.1);
    transition: all 0.3s ease;
}

.stats-card:hover {
    transform: translateY(-3px);
    border-color: rgba(127, 176, 105, 0.3);
}

.stats-icon {
    width: 50px;
    height: 50px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
}

.bg-primary-light { background: rgba(127, 176, 105, 0.15); }
.bg-warning-light { background: rgba(255, 193, 7, 0.15); }
.bg-success-light { background: rgba(40, 167, 69, 0.15); }
.bg-danger-light { background: rgba(220, 53, 69, 0.15); }

.student-avatar {
    width: 40px;
    height: 40px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1rem;
}

.student-avatar.female {
    background: rgba(233, 30, 99, 0.15);
    color: #f48fb1;
}

.student-avatar.male {
    background: rgba(33, 150, 243, 0.15);
    color: #64b5f6;
}

.badge-type-dar { background: rgba(176, 39, 39, 0.15) !important; color: #c86868 !important; border: 1px solid rgba(176, 39, 39, 0.3) !important; }
.badge-type-markaz { background: rgba(255, 152, 0, 0.15) !important; color: #ffb74d !important; border: 1px solid rgba(255, 152, 0, 0.3) !important; }
.badge-type-program { background: rgba(76, 175, 80, 0.15) !important; color: #81c784 !important; border: 1px solid rgba(76, 175, 80, 0.3) !important; }

.badge-period-morning { background: rgba(255, 193, 7, 0.15) !important; color: #ffd54f !important; border: 1px solid rgba(255, 193, 7, 0.3) !important; }
.badge-period-evening { background: rgba(63, 81, 181, 0.15) !important; color: #7986cb !important; border: 1px solid rgba(63, 81, 181, 0.3) !important; }

.btn-dar { background: rgba(176, 39, 39, 0.8); color: #fff; border: none; }
.btn-outline-dar { color: #c86868; border-color: rgba(176, 39, 39, 0.5); background: transparent; }
.btn-outline-dar:hover { background: rgba(176, 39, 39, 0.3); color: #fff; }

.btn-markaz { background: rgba(255, 152, 0, 0.8); color: #fff; border: none; }
.btn-outline-markaz { color: #ffb74d; border-color: rgba(255, 152, 0, 0.5); background: transparent; }
.btn-outline-markaz:hover { background: rgba(255, 152, 0, 0.3); color: #fff; }

.btn-program { background: rgba(76, 175, 80, 0.8); color: #fff; border: none; }
.btn-outline-program { color: #81c784; border-color: rgba(76, 175, 80, 0.5); background: transparent; }
.btn-outline-program:hover { background: rgba(76, 175, 80, 0.3); color: #fff; }

.btn-pink { background: rgba(233, 30, 99, 0.8); color: #fff; border: none; }
.btn-outline-pink { color: #f48fb1; border-color: rgba(233, 30, 99, 0.5); background: transparent; }
.btn-outline-pink:hover { background: rgba(233, 30, 99, 0.3); color: #fff; }

.border-danger-subtle {
    border: 1px solid rgba(220, 53, 69, 0.3) !important;
}
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const confirmInput = document.getElementById('confirmDeleteText');
    const confirmBtn = document.getElementById('confirmDeleteBtn');
    
    if (confirmInput && confirmBtn) {
        confirmInput.addEventListener('input', function() {
            confirmBtn.disabled = this.value.trim() !== 'حذف الكل';
        });
        
        const modal = document.getElementById('deleteAllStudentsModal');
        if (modal) {
            modal.addEventListener('hidden.bs.modal', function() {
                confirmInput.value = '';
                confirmBtn.disabled = true;
            });
        }
    }
});
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\project-bus\resources\views/admin/students/index.blade.php ENDPATH**/ ?>