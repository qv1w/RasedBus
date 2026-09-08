

<?php $__env->startSection('title', 'إدارة السائقين'); ?>

<?php $__env->startSection('header'); ?>
<div class="d-flex justify-content-between align-items-center">
    <div>
        <h1 class="h2 mb-1">
            <i class="fas fa-id-card me-2"></i>
            إدارة السائقين
        </h1>
        <p class="mb-0 opacity-75">
            إجمالي السائقين: <?php echo e($drivers->total()); ?>

        </p>
    </div>
    <div class="d-flex gap-2">
        <a href="<?php echo e(route('admin.drivers.create')); ?>" class="btn btn-primary">
            <i class="fas fa-plus me-1"></i>
            إضافة سائق جديد
        </a>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<!-- البحث والفلترة -->
<div class="content-card mb-4">
    <form method="GET" action="<?php echo e(route('admin.drivers.index')); ?>">
        <div class="row g-3">
            <div class="col-md-4">
                <label for="search" class="form-label">البحث</label>
                <input type="text" name="search" id="search" class="form-control" 
                       placeholder="البحث بالاسم أو الجوال أو رقم الرخصة" 
                       value="<?php echo e(request('search')); ?>">
            </div>
            <div class="col-md-3">
                <label for="status" class="form-label">الحالة</label>
                <select name="status" id="status" class="form-select">
                    <option value="">جميع الحالات</option>
                    <option value="active" <?php echo e(request('status') == 'active' ? 'selected' : ''); ?>>نشط</option>
                    <option value="inactive" <?php echo e(request('status') == 'inactive' ? 'selected' : ''); ?>>غير نشط</option>
                    <option value="on_leave" <?php echo e(request('status') == 'on_leave' ? 'selected' : ''); ?>>في إجازة</option>
                </select>
            </div>
            <div class="col-md-5 d-flex align-items-end">
                <button type="submit" class="btn btn-outline-light me-2">
                    <i class="fas fa-search me-1"></i>
                    بحث
                </button>
                <a href="<?php echo e(route('admin.drivers.index')); ?>" class="btn btn-outline-secondary">
                    <i class="fas fa-times me-1"></i>
                    مسح
                </a>
            </div>
        </div>
    </form>
</div>

<!-- جدول السائقين -->
<div class="content-card">
    <?php if($drivers->count() > 0): ?>
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>الاسم</th>
                        <th>الجوال</th>
                        <th>البريد الإلكتروني</th>
                        <th>رقم الرخصة</th>
                        <th>الحالة</th>
                        <th>تاريخ التسجيل</th>
                        <th>الإجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $drivers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $driver): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($driver->id); ?></td>
                        <td>
                            <div>
                                <strong><?php echo e($driver->name); ?></strong>
                                <?php if($driver->address): ?>
                                <br><small class="opacity-75"><?php echo e(Str::limit($driver->address, 30)); ?></small>
                                <?php endif; ?>
                            </div>
                        </td>
                        <td><?php echo e($driver->mobile); ?></td>
                        <td><?php echo e($driver->email ?? 'غير محدد'); ?></td>
                        <td><code class="text-warning"><?php echo e($driver->license_number); ?></code></td>
                        <td>
                            <span class="badge bg-<?php echo e($driver->status_color); ?>">
                                <?php echo e($driver->status_name); ?>

                            </span>
                        </td>
                        <td>
                            <?php echo e($driver->created_at->format('Y/m/d')); ?>

                            <br><small class="opacity-75"><?php echo e($driver->created_at->format('H:i')); ?></small>
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="<?php echo e(route('admin.drivers.show', $driver)); ?>" 
                                   class="btn btn-outline-info" title="عرض التفاصيل">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="<?php echo e(route('admin.drivers.edit', $driver)); ?>" 
                                   class="btn btn-outline-warning" title="تعديل">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button class="btn btn-outline-danger" 
                                        onclick="deleteDriver(<?php echo e($driver->id); ?>)" title="حذف">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>

        <!-- التصفح -->
        <div class="d-flex justify-content-center mt-4">
            <?php echo e($drivers->links()); ?>

        </div>
    <?php else: ?>
        <div class="text-center py-5">
            <i class="fas fa-users opacity-50" style="font-size: 4rem;"></i>
            <h4 class="mt-3 opacity-75">لا يوجد سائقين</h4>
            <p class="opacity-50">
                <?php if(request('search') || request('status')): ?>
                    لم يتم العثور على سائقين يطابقون معايير البحث
                <?php else: ?>
                    لم يتم إضافة أي سائقين بعد
                <?php endif; ?>
            </p>
            <a href="<?php echo e(route('admin.drivers.create')); ?>" class="btn btn-primary mt-3">
                <i class="fas fa-plus me-1"></i>
                إضافة أول سائق
            </a>
        </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
    // حذف سائق
    function deleteDriver(driverId) {
        if (confirm('هل أنت متأكد من حذف هذا السائق؟\nهذا الإجراء لا يمكن التراجع عنه.')) {
            showLoading();
            
            fetch(`/admin/drivers/${driverId}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                hideLoading();
                if (data.success) {
                    location.reload();
                } else {
                    alert('حدث خطأ أثناء حذف السائق: ' + (data.message || ''));
                }
            })
            .catch(error => {
                hideLoading();
                console.error('Error:', error);
                alert('حدث خطأ أثناء حذف السائق');
            });
        }
    }

    // تحديث الجدول عند تغيير الفلترة
    document.getElementById('status').addEventListener('change', function() {
        document.querySelector('form').submit();
    });

    // البحث السريع
    let searchTimeout;
    document.getElementById('search').addEventListener('input', function() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
            if (this.value.length >= 3 || this.value.length === 0) {
                document.querySelector('form').submit();
            }
        }, 500);
    });

    // تحديد الصفوف
    document.querySelectorAll('tbody tr').forEach(row => {
        row.addEventListener('click', function(e) {
            if (!e.target.closest('.btn-group')) {
                const showLink = this.querySelector('.btn-outline-info');
                if (showLink) {
                    window.location.href = showLink.href;
                }
            }
        });
        
        row.style.cursor = 'pointer';
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\project-bus\resources\views/admin/drivers/index.blade.php ENDPATH**/ ?>