

<?php $__env->startSection('title', 'تخصيص طلاب للباص - ' . $bus->number); ?>

<?php
    // تحميل العلاقات بشكل آمن
    $busStudents = $bus->students ?? collect([]);
    $currentCount = $busStudents->count();
    $capacity = $bus->capacity ?? 30;
    $available = $capacity - $currentCount;
    
    // جلب الطلاب المتاحين إذا لم يتم تمريرهم
    if (!isset($students) || $students->isEmpty()) {
        $students = \App\Models\Student::where('status', 'approved')
            ->where('center_id', $bus->center_id)
            ->whereNull('assigned_bus_id')
            ->get();
    }
?>

<?php $__env->startSection('header'); ?>
<div class="d-flex justify-content-between align-items-center w-100">
    <div>
        <h2 class="mb-1">
            <i class="fas fa-user-plus text-success me-2"></i>
            تخصيص طلاب للباص
        </h2>
        <p class="text-light mb-0 opacity-75">
            الباص: <strong class="text-info"><?php echo e($bus->number); ?></strong> | 
            المركز: <strong><?php echo e($bus->center->center_name ?? 'غير مرتبط بمركز'); ?></strong> |
            المقاعد المتاحة: <strong class="text-success"><?php echo e($available); ?></strong>
        </p>
    </div>
    <a href="<?php echo e(route('admin.buses.show', $bus)); ?>" class="btn btn-outline-light">
        <i class="fas fa-arrow-right me-1"></i>
        العودة للباص
    </a>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <!-- معلومات الباص -->
    <div class="col-lg-4">
        <div class="content-card mb-4 sticky-top" style="top: 100px;">
            <div class="text-center mb-4">
                <div class="bus-icon mx-auto mb-3">
                    <i class="fas fa-bus"></i>
                </div>
                <h4 class="text-primary"><?php echo e($bus->number); ?></h4>
                <p class="text-muted mb-0"><?php echo e($bus->plate_number); ?></p>
            </div>

            <hr class="border-secondary">

            <!-- إحصائيات -->
            <?php
                $percentage = $capacity > 0 ? round(($currentCount / $capacity) * 100) : 0;
            ?>

            <div class="row text-center mb-4">
                <div class="col-4">
                    <h3 class="text-info mb-0"><?php echo e($currentCount); ?></h3>
                    <small class="text-muted">الحالي</small>
                </div>
                <div class="col-4">
                    <h3 class="text-success mb-0" id="availableCount"><?php echo e($available); ?></h3>
                    <small class="text-muted">المتاح</small>
                </div>
                <div class="col-4">
                    <h3 class="text-light mb-0"><?php echo e($capacity); ?></h3>
                    <small class="text-muted">الكلي</small>
                </div>
            </div>

            <div class="progress mb-3" style="height: 10px;">
                <div class="progress-bar bg-info" id="progressBar" style="width: <?php echo e($percentage); ?>%"></div>
            </div>

            <!-- السائق -->
            <?php if($bus->driver): ?>
                <div class="driver-info mt-4 p-3 bg-dark rounded">
                    <div class="d-flex align-items-center">
                        <div class="driver-avatar me-3">
                            <i class="fas fa-user"></i>
                        </div>
                        <div>
                            <h6 class="mb-0 text-white"><?php echo e($bus->driver->name); ?></h6>
                            <small class="text-muted"><?php echo e($bus->driver->mobile ?? $bus->driver->phone); ?></small>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <!-- الطلاب المحددين -->
            <div class="selected-students mt-4">
                <h6 class="text-success mb-3">
                    <i class="fas fa-check-circle me-2"></i>
                    الطلاب المحددين: <span id="selectedCount">0</span>
                </h6>
                <div id="selectedList" class="selected-list">
                    <p class="text-muted small mb-0">لم يتم تحديد أي طالب</p>
                </div>
            </div>

            <!-- زر الحفظ -->
            <button type="button" class="btn btn-success w-100 mt-4" id="saveBtn" disabled onclick="submitForm()">
                <i class="fas fa-save me-2"></i>
                حفظ التخصيص
            </button>
        </div>
    </div>

    <!-- قائمة الطلاب المتاحين -->
    <div class="col-lg-8">
        <div class="content-card">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="mb-0">
                    <i class="fas fa-users text-info me-2"></i>
                    الطلاب المتاحين
                    <span class="badge bg-secondary ms-2"><?php echo e($students->count()); ?></span>
                </h5>
                
                <!-- البحث -->
                <div class="search-box">
                    <input type="text" id="searchInput" class="form-control" placeholder="بحث بالاسم أو الرقم...">
                </div>
            </div>

            <?php if($students->count() > 0): ?>
                <form id="assignForm" action="<?php echo e(route('admin.buses.store-students', $bus)); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    
                    <!-- تحديد الكل -->
                    <div class="d-flex justify-content-between align-items-center mb-3 p-2 bg-dark rounded">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="selectAll">
                            <label class="form-check-label text-white" for="selectAll">
                                تحديد الكل (بحد أقصى <?php echo e($available); ?>)
                            </label>
                        </div>
                        <span class="badge bg-info" id="filteredCount"><?php echo e($students->count()); ?> طالب/ة</span>
                    </div>

                    <div class="students-grid" id="studentsGrid">
                        <?php $__currentLoopData = $students; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="student-card" data-name="<?php echo e($student->name); ?>" data-id="<?php echo e($student->student_id); ?>">
                                <div class="form-check">
                                    <input type="checkbox" 
                                           class="form-check-input student-checkbox" 
                                           name="student_ids[]" 
                                           value="<?php echo e($student->id); ?>"
                                           id="student_<?php echo e($student->id); ?>"
                                           data-name="<?php echo e($student->name); ?>">
                                    <label class="form-check-label w-100" for="student_<?php echo e($student->id); ?>">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div>
                                                <div class="d-flex align-items-center mb-1">
                                                    <span class="student-gender-icon <?php echo e($student->gender == 'ذكر' ? 'male' : 'female'); ?> me-2">
                                                        <i class="fas fa-<?php echo e($student->gender == 'ذكر' ? 'male' : 'female'); ?>"></i>
                                                    </span>
                                                    <h6 class="mb-0 text-white"><?php echo e($student->name); ?></h6>
                                                </div>
                                                <small class="text-muted d-block"><?php echo e($student->student_id); ?></small>
                                                <small class="text-info">
                                                    <i class="fas fa-phone me-1"></i>
                                                    <?php echo e($student->mobile); ?>

                                                </small>
                                            </div>
                                            <div class="text-end">
                                                <span class="badge <?php echo e($student->preferred_schedule == 'صباحية' ? 'bg-warning' : 'bg-info'); ?>">
                                                    <i class="fas fa-<?php echo e($student->preferred_schedule == 'صباحية' ? 'sun' : 'moon'); ?> me-1"></i>
                                                    <?php echo e($student->preferred_schedule); ?>

                                                </span>
                                                <?php if($student->latitude && $student->longitude): ?>
                                                    <br>
                                                    <a href="https://www.google.com/maps?q=<?php echo e($student->latitude); ?>,<?php echo e($student->longitude); ?>" 
                                                       target="_blank" 
                                                       class="btn btn-sm btn-outline-info mt-1"
                                                       onclick="event.stopPropagation();">
                                                        <i class="fas fa-map-marker-alt"></i>
                                                    </a>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </label>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </form>
            <?php else: ?>
                <div class="text-center py-5">
                    <i class="fas fa-user-slash fa-4x text-muted opacity-50 mb-3"></i>
                    <h5 class="text-muted">لا يوجد طلاب متاحين</h5>
                    <p class="text-muted">
                        <?php if($bus->center_id): ?>
                            جميع طلاب "<?php echo e($bus->center->center_name ?? 'المركز'); ?>" تم تخصيصهم لباصات أخرى أو لا يوجد طلاب مقبولين.
                        <?php else: ?>
                            يرجى تخصيص جهة تعليمية للباص أولاً.
                        <?php endif; ?>
                    </p>
                    
                    <div class="d-flex justify-content-center gap-2 mt-4">
                        <a href="<?php echo e(route('admin.buses.show', $bus)); ?>" class="btn btn-outline-light">
                            <i class="fas fa-arrow-right me-1"></i>
                            العودة للباص
                        </a>
                        <a href="<?php echo e(route('admin.students.index', ['center_id' => $bus->center_id, 'status' => 'approved'])); ?>" class="btn btn-info">
                            <i class="fas fa-users me-1"></i>
                            عرض طلاب الجهة
                        </a>
                    </div>
                </div>
            <?php endif; ?>
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
    padding: 1.5rem;
    border: 1px solid rgba(255,255,255,0.1);
}

.bus-icon {
    width: 80px;
    height: 80px;
    background: linear-gradient(135deg, #0dcaf0 0%, #0aa2c0 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2rem;
    color: white;
}

.driver-avatar {
    width: 40px;
    height: 40px;
    background: linear-gradient(135deg, #ffc107 0%, #cc9a06 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #000;
}

.search-box {
    width: 250px;
}

.students-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 1rem;
    max-height: 60vh;
    overflow-y: auto;
    padding: 0.5rem;
}

.student-card {
    background: rgba(255,255,255,0.05);
    border: 2px solid transparent;
    border-radius: 10px;
    padding: 1rem;
    transition: all 0.3s ease;
    cursor: pointer;
}

.student-card:hover {
    background: rgba(255,255,255,0.08);
    border-color: rgba(13, 202, 240, 0.3);
}

.student-card.selected {
    background: rgba(25, 135, 84, 0.15);
    border-color: #198754;
}

.student-card.hidden {
    display: none;
}

.student-gender-icon {
    width: 24px;
    height: 24px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.75rem;
}

.student-gender-icon.female {
    background: rgba(233, 30, 99, 0.2);
    color: #f48fb1;
}

.student-gender-icon.male {
    background: rgba(33, 150, 243, 0.2);
    color: #64b5f6;
}

.form-check-input {
    width: 1.25rem;
    height: 1.25rem;
}

.selected-list {
    max-height: 200px;
    overflow-y: auto;
}

.selected-item {
    display: flex;
    align-items: center;
    padding: 0.5rem;
    background: rgba(25, 135, 84, 0.1);
    border-radius: 5px;
    margin-bottom: 0.5rem;
    font-size: 0.85rem;
}

.selected-item .remove-btn {
    margin-right: auto;
    cursor: pointer;
    color: #dc3545;
}

/* سكرول مخصص */
.students-grid::-webkit-scrollbar,
.selected-list::-webkit-scrollbar {
    width: 6px;
}

.students-grid::-webkit-scrollbar-track,
.selected-list::-webkit-scrollbar-track {
    background: rgba(255,255,255,0.05);
    border-radius: 3px;
}

.students-grid::-webkit-scrollbar-thumb,
.selected-list::-webkit-scrollbar-thumb {
    background: rgba(255,255,255,0.2);
    border-radius: 3px;
}

.form-control {
    background: rgba(255,255,255,0.05);
    border-color: rgba(255,255,255,0.2);
    color: #fff;
}

.form-control:focus {
    background: rgba(255,255,255,0.1);
    border-color: #0dcaf0;
    color: #fff;
    box-shadow: 0 0 0 0.2rem rgba(13, 202, 240, 0.25);
}

.form-control::placeholder {
    color: rgba(255,255,255,0.4);
}
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
const maxStudents = <?php echo e($available); ?>;
let selectedStudents = [];

document.addEventListener('DOMContentLoaded', function() {
    const checkboxes = document.querySelectorAll('.student-checkbox');
    const selectAllCheckbox = document.getElementById('selectAll');
    const searchInput = document.getElementById('searchInput');
    const saveBtn = document.getElementById('saveBtn');

    // تحديد/إلغاء تحديد طالب
    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const card = this.closest('.student-card');
            
            if (this.checked) {
                if (selectedStudents.length >= maxStudents) {
                    this.checked = false;
                    showAlert('لا يمكن تحديد أكثر من ' + maxStudents + ' طالب (المقاعد المتاحة)', 'warning');
                    return;
                }
                card.classList.add('selected');
                selectedStudents.push({
                    id: this.value,
                    name: this.dataset.name
                });
            } else {
                card.classList.remove('selected');
                selectedStudents = selectedStudents.filter(s => s.id !== this.value);
            }
            
            updateUI();
        });

        // النقر على البطاقة
        checkbox.closest('.student-card').addEventListener('click', function(e) {
            if (e.target.tagName !== 'INPUT' && e.target.tagName !== 'A' && !e.target.closest('a')) {
                checkbox.click();
            }
        });
    });

    // تحديد الكل
    if (selectAllCheckbox) {
        selectAllCheckbox.addEventListener('change', function() {
            const visibleCheckboxes = document.querySelectorAll('.student-card:not(.hidden) .student-checkbox');
            let count = 0;
            
            if (this.checked) {
                visibleCheckboxes.forEach(checkbox => {
                    if (count < maxStudents && !checkbox.checked) {
                        checkbox.checked = true;
                        checkbox.closest('.student-card').classList.add('selected');
                        selectedStudents.push({
                            id: checkbox.value,
                            name: checkbox.dataset.name
                        });
                        count++;
                    }
                });
            } else {
                visibleCheckboxes.forEach(checkbox => {
                    if (checkbox.checked) {
                        checkbox.checked = false;
                        checkbox.closest('.student-card').classList.remove('selected');
                    }
                });
                selectedStudents = [];
            }
            
            updateUI();
        });
    }

    // البحث
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            let visibleCount = 0;
            
            document.querySelectorAll('.student-card').forEach(card => {
                const name = card.dataset.name.toLowerCase();
                const id = card.dataset.id.toLowerCase();
                
                if (name.includes(searchTerm) || id.includes(searchTerm)) {
                    card.classList.remove('hidden');
                    visibleCount++;
                } else {
                    card.classList.add('hidden');
                }
            });
            
            document.getElementById('filteredCount').textContent = visibleCount + ' طالب/ة';
        });
    }
});

function updateUI() {
    const count = selectedStudents.length;
    const currentCount = <?php echo e($currentCount); ?>;
    const capacity = <?php echo e($capacity); ?>;
    
    // تحديث العدادات
    document.getElementById('selectedCount').textContent = count;
    document.getElementById('availableCount').textContent = maxStudents - count;
    
    // تحديث شريط التقدم
    const newPercentage = ((currentCount + count) / capacity) * 100;
    document.getElementById('progressBar').style.width = newPercentage + '%';
    
    // تحديث زر الحفظ
    document.getElementById('saveBtn').disabled = count === 0;
    
    // تحديث قائمة المحددين
    const selectedList = document.getElementById('selectedList');
    if (count > 0) {
        selectedList.innerHTML = selectedStudents.map(s => `
            <div class="selected-item">
                <i class="fas fa-user-check text-success me-2"></i>
                <span class="text-white">${s.name}</span>
                <i class="fas fa-times remove-btn" onclick="removeStudent('${s.id}')"></i>
            </div>
        `).join('');
    } else {
        selectedList.innerHTML = '<p class="text-muted small mb-0">لم يتم تحديد أي طالب</p>';
    }
}

function removeStudent(id) {
    const checkbox = document.querySelector(`input[value="${id}"]`);
    if (checkbox) {
        checkbox.checked = false;
        checkbox.closest('.student-card').classList.remove('selected');
    }
    selectedStudents = selectedStudents.filter(s => s.id !== id);
    updateUI();
}

function submitForm() {
    if (selectedStudents.length === 0) {
        showAlert('يرجى تحديد طالب واحد على الأقل', 'warning');
        return;
    }
    
    if (confirm('هل أنت متأكد من تخصيص ' + selectedStudents.length + ' طالب/ة لهذا الباص؟')) {
        document.getElementById('assignForm').submit();
    }
}

function showAlert(message, type) {
    const alertDiv = document.createElement('div');
    alertDiv.className = `alert alert-${type} alert-dismissible fade show position-fixed`;
    alertDiv.style.cssText = 'top: 20px; left: 50%; transform: translateX(-50%); z-index: 9999; min-width: 300px;';
    alertDiv.innerHTML = `
        <i class="fas fa-exclamation-triangle me-2"></i>
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    
    document.body.appendChild(alertDiv);
    
    setTimeout(() => {
        if (alertDiv.parentNode) {
            alertDiv.remove();
        }
    }, 3000);
}
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\project-bus\resources\views/admin/buses/assign-students.blade.php ENDPATH**/ ?>