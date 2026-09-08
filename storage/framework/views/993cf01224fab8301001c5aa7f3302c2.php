<?php $__env->startSection('title', 'طلاب بدون دفعات'); ?>

<?php $__env->startSection('header'); ?>
<div class="d-flex justify-content-between align-items-center w-100">
    <div>
        <h2 class="mb-1">
            <i class="fas fa-user-clock text-warning me-2"></i>
            طلاب بدون دفعات
        </h2>
        <p class="text-light mb-0 opacity-75">
            طلاب مقبولين لم يتم إنشاء دفعات لهم في السنة الحالية (<?php echo e(date('Y')); ?>)
        </p>
    </div>
    <div class="d-flex gap-2">
        <a href="<?php echo e(route('admin.payments.settings')); ?>" class="btn btn-outline-light">
            <i class="fas fa-cog me-1"></i>
            الإعدادات
        </a>
        <a href="<?php echo e(route('admin.payments.index')); ?>" class="btn btn-outline-light">
            <i class="fas fa-arrow-right me-1"></i>
            العودة
        </a>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<?php if(session('success')): ?>
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <i class="fas fa-check-circle me-2"></i>
    <?php echo e(session('success')); ?>

    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
<?php endif; ?>

<?php if(session('error')): ?>
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <i class="fas fa-exclamation-circle me-2"></i>
    <?php echo e(session('error')); ?>

    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
<?php endif; ?>

<!-- إحصائيات سريعة -->
<div class="row mb-4">
    <div class="col-md-4 mb-3">
        <div class="stats-card text-center">
            <i class="fas fa-users fa-2x text-warning mb-2"></i>
            <h3 class="text-warning mb-0"><?php echo e($students->count()); ?></h3>
            <small class="text-muted">طالب بدون دفعة</small>
        </div>
    </div>
    <div class="col-md-4 mb-3">
        <div class="stats-card text-center">
            <i class="fas fa-money-bill fa-2x text-info mb-2"></i>
            <h3 class="text-info mb-0"><?php echo e(number_format($settings['amount'])); ?></h3>
            <small class="text-muted">المبلغ الافتراضي (ريال)</small>
        </div>
    </div>
    <div class="col-md-4 mb-3">
        <div class="stats-card text-center">
            <i class="fas fa-calculator fa-2x text-success mb-2"></i>
            <h3 class="text-success mb-0"><?php echo e(number_format($students->count() * $settings['amount'])); ?></h3>
            <small class="text-muted">الإجمالي المتوقع (ريال)</small>
        </div>
    </div>
</div>

<?php if($students->count() > 0): ?>
<form action="<?php echo e(route('admin.payments.create-missing')); ?>" method="POST" id="createPaymentsForm">
    <?php echo csrf_field(); ?>
    
    <div class="row">
        <!-- قائمة الطلاب -->
        <div class="col-lg-8 mb-4">
            <div class="content-card">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="mb-0">
                        <i class="fas fa-list me-2"></i>
                        قائمة الطلاب (<?php echo e($students->count()); ?>)
                    </h5>
                    <div class="d-flex gap-2">
                        <button type="button" class="btn btn-sm btn-outline-success" onclick="selectAll()">
                            <i class="fas fa-check-double me-1"></i>
                            تحديد الكل
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-secondary" onclick="deselectAll()">
                            <i class="fas fa-times me-1"></i>
                            إلغاء الكل
                        </button>
                    </div>
                </div>

                <!-- فلتر بالجهة -->
                <div class="mb-4">
                    <select class="form-select" id="centerFilter" onchange="filterByCenter()">
                        <option value="">كل الجهات</option>
                        <?php $__currentLoopData = $centers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $center): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($center->id); ?>">
                                <?php echo e($center->center_name); ?> (<?php echo e($center->type); ?>)
                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover align-middle" id="studentsTable">
                        <thead>
                            <tr>
                                <th width="40">
                                    <input type="checkbox" class="form-check-input" id="selectAllCheckbox" onchange="toggleAll()">
                                </th>
                                <th>الطالب/ة</th>
                                <th>الجهة التعليمية</th>
                                <th>تاريخ القبول</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $students; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                                $center = $student->center;
                                $typeClass = $center ? (['دار' => 'dar', 'مركز' => 'markaz', 'برنامج' => 'program'][$center->type] ?? 'secondary') : 'secondary';
                                $typeIcon = $center ? (['دار' => 'mosque', 'مركز' => 'graduation-cap', 'برنامج' => 'seedling'][$center->type] ?? 'school') : 'school';
                            ?>
                            <tr data-center-id="<?php echo e($center->id ?? ''); ?>">
                                <td>
                                    <input type="checkbox" name="student_ids[]" value="<?php echo e($student->id); ?>" 
                                           class="form-check-input student-checkbox">
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="student-avatar me-2" style="background: rgba(<?php echo e($student->gender == 'أنثى' ? '233, 30, 99' : '33, 150, 243'); ?>, 0.15);">
                                            <i class="fas fa-<?php echo e($student->gender == 'أنثى' ? 'female' : 'male'); ?>" 
                                               style="color: <?php echo e($student->gender == 'أنثى' ? '#f48fb1' : '#64b5f6'); ?>;"></i>
                                        </div>
                                        <div>
                                            <strong class="text-white"><?php echo e($student->name); ?></strong>
                                            <br>
                                            <small class="text-muted"><?php echo e($student->student_id ?? $student->phone); ?></small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <?php if($center): ?>
                                    <span class="badge badge-type-<?php echo e($typeClass); ?>">
                                        <i class="fas fa-<?php echo e($typeIcon); ?> me-1"></i>
                                        <?php echo e($center->center_name); ?>

                                    </span>
                                    <?php else: ?>
                                    <span class="text-muted">-</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <small class="text-muted">
                                        <?php echo e($student->updated_at ? $student->updated_at->format('Y/m/d') : '-'); ?>

                                    </small>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- تفاصيل الدفعة -->
        <div class="col-lg-4 mb-4">
            <div class="content-card sticky-top" style="top: 20px;">
                <h5 class="mb-4">
                    <i class="fas fa-file-invoice-dollar me-2"></i>
                    تفاصيل الدفعة
                </h5>

                <!-- ملخص -->
                <div class="summary-box mb-4">
                    <div class="text-center">
                        <i class="fas fa-users fa-2x text-info mb-2"></i>
                        <h3 class="mb-0 text-info" id="selectedCount">0</h3>
                        <small class="text-muted">طالب محدد</small>
                    </div>
                </div>

                <!-- المبلغ -->
                <div class="mb-4">
                    <label class="form-label">المبلغ لكل طالب <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <input type="number" name="amount" class="form-control" 
                               value="<?php echo e($settings['amount']); ?>" step="0.01" min="1" required
                               id="amountInput" onchange="updateTotal()">
                        <span class="input-group-text">ريال</span>
                    </div>
                </div>

                <!-- الإجمالي -->
                <div class="total-box mb-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <span>الإجمالي:</span>
                        <span class="h4 mb-0 text-success" id="totalAmount">0 ريال</span>
                    </div>
                </div>

                <!-- الوصف -->
                <div class="mb-4">
                    <label class="form-label">وصف الدفعة</label>
                    <input type="text" name="description" class="form-control" 
                           value="<?php echo e($settings['description']); ?>" placeholder="وصف الدفعة">
                </div>

                <hr class="border-secondary">

                <button type="submit" class="btn btn-success btn-lg w-100" id="submitBtn" disabled>
                    <i class="fas fa-plus-circle me-2"></i>
                    إنشاء الدفعات
                </button>

                <div class="alert alert-warning mt-3 mb-0" id="noSelectionAlert">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    يرجى اختيار طالب واحد على الأقل
                </div>
            </div>
        </div>
    </div>
</form>

<?php else: ?>
<div class="content-card text-center py-5">
    <i class="fas fa-check-circle fa-4x text-success mb-3"></i>
    <h4 class="text-success">جميع الطلاب لديهم دفعات</h4>
    <p class="text-muted">لا يوجد طلاب بدون دفعات في السنة الحالية</p>
    <a href="<?php echo e(route('admin.payments.index')); ?>" class="btn btn-primary mt-3">
        <i class="fas fa-arrow-right me-1"></i>
        العودة للدفعات
    </a>
</div>
<?php endif; ?>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
<style>
    .stats-card, .content-card {
        background: rgba(255, 255, 255, 0.05);
        border-radius: 15px;
        padding: 1.5rem;
        border: 1px solid rgba(127, 176, 105, 0.2);
    }
    .summary-box {
        background: rgba(255, 255, 255, 0.03);
        border-radius: 15px;
        padding: 1.5rem;
        border: 1px solid rgba(255, 255, 255, 0.1);
    }
    .total-box {
        background: rgba(40, 167, 69, 0.1);
        border-radius: 10px;
        padding: 1rem;
        border: 1px solid rgba(40, 167, 69, 0.3);
    }
    .student-avatar {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.1rem;
    }
    .form-control, .form-select {
        background: rgba(255,255,255,0.05);
        border-color: rgba(255,255,255,0.2);
        color: #fff;
    }
    .form-control:focus, .form-select:focus {
        background: rgba(255,255,255,0.1);
        border-color: #28a745;
        color: #fff;
    }
    .input-group-text {
        background: rgba(40, 167, 69, 0.2);
        border-color: rgba(255,255,255,0.2);
        color: #90EE90;
    }
    
    /* ألوان الأنواع */
    .badge-type-dar { background: rgba(176, 39, 39, 0.15) !important; color: #c86868 !important; border: 1px solid rgba(176, 39, 39, 0.3) !important; }
    .badge-type-markaz { background: rgba(255, 152, 0, 0.15) !important; color: #ffb74d !important; border: 1px solid rgba(255, 152, 0, 0.3) !important; }
    .badge-type-program { background: rgba(76, 175, 80, 0.15) !important; color: #81c784 !important; border: 1px solid rgba(76, 175, 80, 0.3) !important; }
    
    tr.hidden { display: none; }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
const checkboxes = document.querySelectorAll('.student-checkbox');
const amountInput = document.getElementById('amountInput');
const submitBtn = document.getElementById('submitBtn');
const noSelectionAlert = document.getElementById('noSelectionAlert');

function updateStats() {
    let count = 0;
    checkboxes.forEach(cb => {
        if (cb.checked && !cb.closest('tr').classList.contains('hidden')) {
            count++;
        }
    });
    
    document.getElementById('selectedCount').textContent = count;
    
    const amount = parseFloat(amountInput.value) || 0;
    const total = (amount * count).toLocaleString('ar-SA');
    document.getElementById('totalAmount').textContent = total + ' ريال';
    
    submitBtn.disabled = count === 0;
    noSelectionAlert.style.display = count > 0 ? 'none' : 'block';
}

function updateTotal() {
    updateStats();
}

function selectAll() {
    checkboxes.forEach(cb => {
        if (!cb.closest('tr').classList.contains('hidden')) {
            cb.checked = true;
        }
    });
    document.getElementById('selectAllCheckbox').checked = true;
    updateStats();
}

function deselectAll() {
    checkboxes.forEach(cb => cb.checked = false);
    document.getElementById('selectAllCheckbox').checked = false;
    updateStats();
}

function toggleAll() {
    const selectAll = document.getElementById('selectAllCheckbox').checked;
    checkboxes.forEach(cb => {
        if (!cb.closest('tr').classList.contains('hidden')) {
            cb.checked = selectAll;
        }
    });
    updateStats();
}

function filterByCenter() {
    const centerId = document.getElementById('centerFilter').value;
    const rows = document.querySelectorAll('#studentsTable tbody tr');
    
    rows.forEach(row => {
        if (!centerId || row.dataset.centerId === centerId) {
            row.classList.remove('hidden');
        } else {
            row.classList.add('hidden');
            row.querySelector('.student-checkbox').checked = false;
        }
    });
    
    updateStats();
}

checkboxes.forEach(cb => cb.addEventListener('change', updateStats));
updateStats();
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/rasedbus/project-bus/resources/views/admin/payments/missing-students.blade.php ENDPATH**/ ?>