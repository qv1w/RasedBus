<?php $__env->startSection('title', 'التقارير'); ?>

<?php $__env->startSection('header'); ?>
<div class="d-flex justify-content-between align-items-center w-100">
    <div>
        <h2 class="mb-1">
            <i class="fas fa-chart-bar me-2"></i>
            التقارير والإحصائيات
        </h2>
        <p class="text-light opacity-75 mb-0">تقارير شاملة عن النظام</p>
    </div>
    <div class="d-flex gap-2">
        <button onclick="printReport()" class="btn btn-outline-info">
            <i class="fas fa-print me-1"></i>
            طباعة
        </button>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div id="printable-report">
    <!-- عنوان للطباعة -->
    <div class="print-header d-none">
        <h2 class="text-center mb-1">نظام النقل التعليمي</h2>
        <h4 class="text-center mb-1">جمعية تحفيظ القرآن الكريم - الزلفي</h4>
        <p class="text-center text-muted">تقرير الإحصائيات - <?php echo e(now()->format('Y-m-d')); ?></p>
        <hr>
    </div>

    <!-- إحصائيات عامة -->
    <div class="row mb-4">
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="stats-card">
                <div class="d-flex align-items-center">
                    <div class="stats-icon bg-primary bg-opacity-20 me-3">
                        <i class="fas fa-user-graduate fa-lg text-primary"></i>
                    </div>
                    <div>
                        <h3 class="mb-0 text-white"><?php echo e($stats['total_students'] ?? 0); ?></h3>
                        <small class="text-muted">إجمالي الطلاب</small>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="stats-card">
                <div class="d-flex align-items-center">
                    <div class="stats-icon bg-success bg-opacity-20 me-3">
                        <i class="fas fa-check-circle fa-lg text-success"></i>
                    </div>
                    <div>
                        <h3 class="mb-0 text-white"><?php echo e($stats['approved_students'] ?? 0); ?></h3>
                        <small class="text-muted">مقبولين</small>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="stats-card">
                <div class="d-flex align-items-center">
                    <div class="stats-icon bg-warning bg-opacity-20 me-3">
                        <i class="fas fa-bus fa-lg text-warning"></i>
                    </div>
                    <div>
                        <h3 class="mb-0 text-white"><?php echo e($stats['total_buses'] ?? 0); ?></h3>
                        <small class="text-muted">إجمالي الباصات</small>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="stats-card">
                <div class="d-flex align-items-center">
                    <div class="stats-icon bg-info bg-opacity-20 me-3">
                        <i class="fas fa-school fa-lg text-info"></i>
                    </div>
                    <div>
                        <h3 class="mb-0 text-white"><?php echo e($stats['total_centers'] ?? 0); ?></h3>
                        <small class="text-muted">الجهات النشطة</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- الطلاب حسب النوع -->
        <div class="col-lg-6 mb-4">
            <div class="content-card h-100">
                <h5 class="section-title">
                    <i class="fas fa-layer-group text-success me-2"></i>
                    الطلاب حسب نوع الجهة
                </h5>
                
                <div class="row text-center mt-4">
                    <?php
                        $dourStudents = \App\Models\Student::whereHas('center', fn($q) => $q->where('type', 'دار'))->count();
                        $markazStudents = \App\Models\Student::whereHas('center', fn($q) => $q->where('type', 'مركز'))->count();
                        $riyaheenStudents = \App\Models\Student::whereHas('center', fn($q) => $q->where('type', 'برنامج'))->count();
                    ?>
                    <div class="col-4">
                        <div class="p-3 rounded type-card dour">
                            <i class="fas fa-mosque fa-2x mb-2"></i>
                            <h4 class="mb-1"><?php echo e($dourStudents); ?></h4>
                            <small>دور التحفيظ</small>
                        </div>
                    </div> 
                    <div class="col-4">
                        <div class="p-3 rounded type-card markaz">
                            <i class="fas fa-graduation-cap fa-2x mb-2"></i>
                            <h4 class="mb-1"><?php echo e($markazStudents); ?></h4>
                            <small>المركز</small>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="p-3 rounded type-card riyaheen">
                            <i class="fas fa-seedling fa-2x mb-2"></i>
                            <h4 class="mb-1"><?php echo e($riyaheenStudents); ?></h4>
                            <small>الرياحين</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- الطلاب حسب الفترة -->
        <div class="col-lg-6 mb-4">
            <div class="content-card h-100">
                <h5 class="section-title">
                    <i class="fas fa-clock text-info me-2"></i>
                    الطلاب حسب الفترة
                </h5>
                
                <div class="row text-center mt-4">
                    <div class="col-6">
                        
                        <div class="p-4 rounded schedule-card morning">
                            <i class="fas fa-sun fa-2x mb-2"></i>
                            <h3 class="mb-1"><?php echo e($stats['morning_students'] ?? 0); ?></h3>
                            <small>الفترة الصباحية</small>
                        </div>
                    </div>
                    <div class="col-6">
                        
                        <div class="p-4 rounded schedule-card evening">
                            <i class="fas fa-moon fa-2x mb-2"></i>
                            <h3 class="mb-1"><?php echo e($stats['evening_students'] ?? 0); ?></h3>
                            <small>الفترة المسائية</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- الطلاب حسب الحالة -->
        <div class="col-lg-6 mb-4">
            <div class="content-card h-100">
                <h5 class="section-title">
                    <i class="fas fa-users text-primary me-2"></i>
                    الطلاب حسب الحالة
                </h5>
                
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>الحالة</th>
                                <th>العدد</th>
                                <th>النسبة</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $total = $stats['total_students'] ?: 1;
                                $statuses = [
                                    ['name' => 'مقبول', 'count' => $stats['approved_students'] ?? 0, 'color' => 'success'],
                                    ['name' => 'قيد المراجعة', 'count' => $stats['pending_students'] ?? 0, 'color' => 'warning'],
                                    ['name' => 'مرفوض', 'count' => $stats['rejected_students'] ?? 0, 'color' => 'danger'],
                                ];
                            ?>
                            <?php $__currentLoopData = $statuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td>
                                    <span class="badge bg-<?php echo e($status['color']); ?>"><?php echo e($status['name']); ?></span>
                                </td>
                                <td><strong class="text-white"><?php echo e($status['count']); ?></strong></td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="progress flex-grow-1 me-2" style="height: 6px; width: 100px;">
                                            <div class="progress-bar bg-<?php echo e($status['color']); ?>" 
                                                 style="width: <?php echo e($total > 0 ? ($status['count'] / $total * 100) : 0); ?>%"></div>
                                        </div>
                                        <small class="text-white"><?php echo e($total > 0 ? round($status['count'] / $total * 100) : 0); ?>%</small>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- حالة الباصات -->
        <div class="col-lg-6 mb-4">
            <div class="content-card h-100">
                <h5 class="section-title">
                    <i class="fas fa-bus text-warning me-2"></i>
                    حالة الباصات
                </h5>
                
                <div class="row text-center mb-4">
                    <div class="col-4">
                        <div class="p-3 rounded" style="background: rgba(40, 167, 69, 0.1);">
                            <h4 class="mb-1 text-success"><?php echo e($stats['active_buses'] ?? 0); ?></h4>
                            <small class="text-muted">نشط</small>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="p-3 rounded" style="background: rgba(255, 193, 7, 0.1);">
                            <h4 class="mb-1 text-warning"><?php echo e($stats['maintenance_buses'] ?? 0); ?></h4>
                            <small class="text-muted">صيانة</small>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="p-3 rounded" style="background: rgba(220, 53, 69, 0.1);">
                            <h4 class="mb-1 text-danger"><?php echo e($stats['inactive_buses'] ?? 0); ?></h4>
                            <small class="text-muted">متوقف</small>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-white">نسبة الإشغال</span>
                        <span class="text-white"><?php echo e($stats['occupancy_rate'] ?? 0); ?>%</span>
                    </div>
                    <div class="progress" style="height: 10px;">
                        <div class="progress-bar bg-primary" style="width: <?php echo e($stats['occupancy_rate'] ?? 0); ?>%"></div>
                    </div>
                </div>

                <div class="text-center text-muted">
                    <small>
                        <i class="fas fa-chair me-1"></i>
                        <?php echo e($stats['occupied_seats'] ?? 0); ?> / <?php echo e($stats['total_capacity'] ?? 0); ?> مقعد مشغول
                    </small>
                </div>
            </div>
        </div>

        <!-- الطلاب حسب الجهة -->
        <div class="col-lg-12 mb-4">
            <div class="content-card">
                <h5 class="section-title">
                    <i class="fas fa-school text-success me-2"></i>
                    الطلاب حسب الجهة
                </h5>
                
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>الجهة</th>
                                <th>النوع</th>
                                <th>الطلاب</th>
                                <th>الباصات</th>
                                <th>نسبة الإشغال</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $centerStats ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $center): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <?php
                                $typeIcons = ['دار' => 'mosque', 'مركز' => 'graduation-cap', 'برنامج' => 'seedling'];
                                $typeColors = ['دار' => 'purple', 'مركز' => 'warning', 'برنامج' => 'success'];
                            ?>
                            <tr>
                                <td>
                                    <i class="fas fa-<?php echo e($typeIcons[$center->type] ?? 'building'); ?> text-<?php echo e($typeColors[$center->type] ?? 'info'); ?> me-2"></i>
                                    <span class="text-white"><?php echo e($center->center_name); ?></span>
                                </td>
                                <td>
                                    <span class="badge bg-<?php echo e($typeColors[$center->type] ?? 'secondary'); ?>">
                                        <?php echo e($center->type); ?>

                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-primary"><?php echo e($center->students_count); ?></span>
                                </td>
                                <td>
                                    <span class="badge bg-warning"><?php echo e($center->buses_count); ?></span>
                                </td>
                                <td>
                                    <?php
                                        $capacity = $center->buses->sum('capacity') ?: 1;
                                        $occupied = $center->students_count;
                                        $percentage = min(100, round($occupied / $capacity * 100));
                                    ?>
                                    <div class="d-flex align-items-center">
                                        <div class="progress flex-grow-1 me-2" style="height: 6px; width: 80px;">
                                            <div class="progress-bar bg-<?php echo e($percentage >= 90 ? 'danger' : ($percentage >= 70 ? 'warning' : 'success')); ?>" 
                                                 style="width: <?php echo e($percentage); ?>%"></div>
                                        </div>
                                        <small class="text-white"><?php echo e($percentage); ?>%</small>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="5" class="text-center text-muted">لا توجد بيانات</td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="print-summary d-none">
        <hr>
        <p class="text-center text-muted small">
            تم إنشاء هذا التقرير بتاريخ <?php echo e(now()->format('Y-m-d H:i')); ?>

        </p>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
<style>
    .section-title {
        color: #7fb069;
        padding-bottom: 0.75rem;
        border-bottom: 2px solid rgba(127, 176, 105, 0.3);
        margin-bottom: 1.5rem;
    }
    
    .stats-icon {
        width: 50px;
        height: 50px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    /* كروت الفترات */
    .schedule-card.morning {
        background: linear-gradient(135deg, rgba(255, 152, 0, 0.2), rgba(255, 183, 77, 0.1));
        color: #ffb74d;
    }
    
    .schedule-card.evening {
        background: linear-gradient(135deg, rgba(33, 150, 243, 0.2), rgba(100, 181, 246, 0.1));
        color: #64b5f6;
    }
    
    /* كروت الأنواع */
    .type-card.dour {
        background: linear-gradient(135deg, rgba(220, 53, 69, 0.2), rgba(220, 53, 69, 0.1));
        color: #dc3545;
    }
    
    .type-card.markaz {
        background: linear-gradient(135deg, rgba(255, 193, 7, 0.2), rgba(255, 213, 79, 0.1));
        color: #ffd54f;
    }
    
    .type-card.riyaheen {
        background: linear-gradient(135deg, rgba(76, 175, 80, 0.2), rgba(129, 199, 132, 0.1));
        color: #81c784;
    }
    
    /* لون بنفسجي */
    .bg-purple {
        background: linear-gradient(135deg, #b02727, #c86868) !important;
    }

    /* أنماط الطباعة */
    @media print {
        body {
            background: white !important;
            color: black !important;
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }
        
        .sidebar, .main-header, .no-print {
            display: none !important;
        }
        
        .main-content {
            margin: 0 !important;
            padding: 20px !important;
        }
        
        .content-card, .stats-card {
            background: white !important;
            border: 1px solid #ddd !important;
            color: black !important;
            page-break-inside: avoid;
        }
        
        .table {
            color: black !important;
        }
        
        .table th, .table td {
            color: black !important;
            border-color: #ddd !important;
        }
        
        .badge {
            border: 1px solid #333 !important;
        }
        
        .print-header, .print-summary {
            display: block !important;
        }
        
        h3, h4, h5, .text-white {
            color: black !important;
        }
        
        .text-muted {
            color: #666 !important;
        }
        
        .section-title {
            color: #333 !important;
            border-bottom-color: #333 !important;
        }
        
        .progress {
            background: #eee !important;
        }
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
function printReport() {
    window.print();
}
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\project-bus\resources\views/admin/reports.blade.php ENDPATH**/ ?>