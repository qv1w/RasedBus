<?php $__env->startSection('title', 'لوحة التحكم الرئيسية'); ?>

<?php $__env->startSection('header'); ?>
<div class="d-flex justify-content-between align-items-center flex-wrap">
    <div>
        <h1 class="h2 mb-1">
            <i class="fas fa-tachometer-alt me-2"></i>
            لوحة التحكم الرئيسية
        </h1>
        <p class="mb-0 opacity-75">
            <i class="fas fa-user me-1"></i>
            مرحباً بك <?php echo e(session('admin_name', 'المدير')); ?> - 
            <span id="clock"></span>
        </p>
    </div>
    <div class="d-flex gap-2">
        <button class="btn btn-outline-light btn-sm" onclick="refreshData()">
            <i class="fas fa-sync-alt me-1"></i>
            تحديث البيانات
        </button>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<?php
    // إحصائيات الطلاب
    $totalStudents = \App\Models\Student::count();
    $pendingStudents = \App\Models\Student::where('status', 'pending')->count();
    $approvedStudents = \App\Models\Student::where('status', 'approved')->count();
    $rejectedStudents = \App\Models\Student::where('status', 'rejected')->count();
    
    // إحصائيات الجهات حسب النوع
    $allCenters = \App\Models\Center::all();
    $darCenters = $allCenters->where('type', 'دار');
    $markazCenters = $allCenters->where('type', 'مركز');
    $programCenters = $allCenters->where('type', 'برنامج');
    
    // إحصائيات الباصات
    $totalBuses = \App\Models\Bus::count();
    $activeBuses = \App\Models\Bus::where('status', 'active')->count();
    
    // إحصائيات السائقين
    $totalDrivers = \App\Models\Driver::count();
    $availableDrivers = \App\Models\Driver::where('status', 'available')->count();
    
    // الدفعات
    $pendingPayments = \App\Models\Payment::where('status', 'pending')->count();
    $totalPayments = \App\Models\Payment::where('status', 'approved')->sum('amount');
    
    // آخر الطلاب
    $recentStudents = \App\Models\Student::with('center')->latest()->take(10)->get();
?>

<!-- الإحصائيات الرئيسية -->
<div class="row mb-4">
    <!-- إجمالي الطالبات -->
    <div class="col-xl-3 col-lg-6 col-md-6 mb-3">
        <div class="stats-card h-100">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <h3 class="text-light mb-1"><?php echo e(number_format($totalStudents)); ?></h3>
                    <p class="mb-0 opacity-75">إجمالي الطلاب</p>
                    <div class="mt-2">
                        <small class="text-success">
                            <i class="fas fa-user-check me-1"></i>
                            <?php echo e($approvedStudents); ?> مقبول
                        </small>
                        <?php if($pendingStudents > 0): ?>
                        <span class="mx-1">|</span>
                        <small class="text-warning">
                            <i class="fas fa-clock me-1"></i>
                            <?php echo e($pendingStudents); ?> معلق
                        </small>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="stats-icon icon-stats-info">
                    <i class="fas fa-user-graduate fa-lg"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- الجهات التعليمية -->
    <div class="col-xl-3 col-lg-6 col-md-6 mb-3">
        <div class="stats-card h-100">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <h3 class="text-light mb-1"><?php echo e($allCenters->count()); ?></h3>
                    <p class="mb-0 opacity-75">الجهات التعليمية</p>
                    <div class="mt-2 d-flex flex-wrap gap-1">
                        <span class="badge badge-type-dar">
                            <i class="fas fa-mosque me-1"></i><?php echo e($darCenters->count()); ?>

                        </span>
                        <span class="badge badge-type-markaz">
                            <i class="fas fa-graduation-cap me-1"></i><?php echo e($markazCenters->count()); ?>

                        </span>
                        <span class="badge badge-type-program">
                            <i class="fas fa-seedling me-1"></i><?php echo e($programCenters->count()); ?>

                        </span>
                    </div>
                </div>
                <div class="stats-icon icon-stats-success">
                    <i class="fas fa-school fa-lg"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- الباصات -->
    <div class="col-xl-3 col-lg-6 col-md-6 mb-3">
        <div class="stats-card h-100">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <h3 class="text-light mb-1"><?php echo e($activeBuses); ?></h3>
                    <p class="mb-0 opacity-75">الباصات النشطة</p>
                    <div class="mt-2">
                        <small class="text-info">
                            <i class="fas fa-bus me-1"></i>
                            من أصل <?php echo e($totalBuses); ?> باص
                        </small>
                        <?php if(($totalBuses - $activeBuses) > 0): ?>
                        <br>
                        <small class="text-warning">
                            <i class="fas fa-tools me-1"></i>
                            <?php echo e($totalBuses - $activeBuses); ?> غير نشط
                        </small>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="stats-icon icon-stats-primary">
                    <i class="fas fa-bus fa-lg"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- الدفعات والسائقين -->
    <div class="col-xl-3 col-lg-6 col-md-6 mb-3">
        <div class="stats-card h-100">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <h3 class="text-light mb-1"><?php echo e($pendingPayments); ?></h3>
                    <p class="mb-0 opacity-75">دفعات معلقة</p>
                    <div class="mt-2">
                        <small class="text-success">
                            <i class="fas fa-money-bill me-1"></i>
                            <?php echo e(number_format($totalPayments)); ?> ريال
                        </small>
                        <br>
                        <small class="text-info">
                            <i class="fas fa-id-card me-1"></i>
                            <?php echo e($availableDrivers); ?>/<?php echo e($totalDrivers); ?> سائق متاح
                        </small>
                    </div>
                </div>
                <div class="stats-icon icon-stats-warning">
                    <i class="fas fa-credit-card fa-lg"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ملخص الجهات التعليمية -->
<div class="row mb-4">
    <!-- دور التحفيظ -->
    <div class="col-lg-4 mb-3">
        <div class="content-card h-100 border-dar">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="mb-0 text-dar">
                    <i class="fas fa-mosque me-2"></i>
                    دور التحفيظ
                </h5>
                <span class="badge bg-dar"><?php echo e($darCenters->count()); ?></span>
            </div>
            
            <?php if($darCenters->count() > 0): ?>
                <div class="centers-list">
                    <?php $__currentLoopData = $darCenters->take(4); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $center): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="center-item mb-2">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                <div class="center-mini-icon icon-type-dar me-2">
                                    <i class="fas fa-mosque"></i>
                                </div>
                                <div>
                                    <span class="fw-bold"><?php echo e($center->center_name); ?></span>
                                    <br>
                                    <small class="text-muted">
                                        <i class="fas fa-<?php echo e($center->gender == 'بنات' ? 'female' : 'male'); ?> me-1"></i>
                                        <?php echo e($center->gender); ?>

                                    </small>
                                </div>
                            </div>
                            <div class="text-end">
                                <span class="badge bg-<?php echo e($center->status == 'active' ? 'success' : 'danger'); ?>">
                                    <?php echo e($center->status == 'active' ? 'نشط' : 'متوقف'); ?>

                                </span>
                                <br>
                                <small class="text-muted"><?php echo e($center->students()->count()); ?> طالب</small>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                <?php if($darCenters->count() > 4): ?>
                <div class="text-center mt-3">
                    <a href="<?php echo e(url('admin/centers')); ?>?type=دار" class="btn btn-sm btn-outline-dar">
                        عرض الكل (<?php echo e($darCenters->count()); ?>)
                    </a>
                </div>
                <?php endif; ?>
            <?php else: ?>
                <div class="text-center py-4 opacity-50">
                    <i class="fas fa-mosque fa-2x mb-2"></i>
                    <p class="mb-0">لا توجد دور تحفيظ</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
    
    <!-- مركز إعداد المعلمات -->
    <div class="col-lg-4 mb-3">
        <div class="content-card h-100 border-markaz">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="mb-0 text-markaz">
                    <i class="fas fa-graduation-cap me-2"></i>
                    مركز إعداد المعلمات
                </h5>
                <span class="badge bg-markaz"><?php echo e($markazCenters->count()); ?></span>
            </div>
            
            <?php if($markazCenters->count() > 0): ?>
                <div class="centers-list">
                    <?php $__currentLoopData = $markazCenters->take(4); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $center): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="center-item mb-2">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                <div class="center-mini-icon icon-type-markaz me-2">
                                    <i class="fas fa-graduation-cap"></i>
                                </div>
                                <div>
                                    <span class="fw-bold"><?php echo e($center->center_name); ?></span>
                                    <br>
                                    <small class="text-muted">
                                        <i class="fas fa-<?php echo e($center->gender == 'بنات' ? 'female' : 'male'); ?> me-1"></i>
                                        <?php echo e($center->gender); ?>

                                    </small>
                                </div>
                            </div>
                            <div class="text-end">
                                <span class="badge bg-<?php echo e($center->status == 'active' ? 'success' : 'danger'); ?>">
                                    <?php echo e($center->status == 'active' ? 'نشط' : 'متوقف'); ?>

                                </span>
                                <br>
                                <small class="text-muted"><?php echo e($center->students()->count()); ?> طالب</small>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                <?php if($markazCenters->count() > 4): ?>
                <div class="text-center mt-3">
                    <a href="<?php echo e(url('admin/centers')); ?>?type=مركز" class="btn btn-sm btn-outline-markaz">
                        عرض الكل (<?php echo e($markazCenters->count()); ?>)
                    </a>
                </div>
                <?php endif; ?>
            <?php else: ?>
                <div class="text-center py-4 opacity-50">
                    <i class="fas fa-graduation-cap fa-2x mb-2"></i>
                    <p class="mb-0">لا توجد مراكز</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
    
    <!-- برامج الرياحين -->
    <div class="col-lg-4 mb-3">
        <div class="content-card h-100 border-program">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="mb-0 text-program">
                    <i class="fas fa-seedling me-2"></i>
                    برامج الرياحين
                </h5>
                <span class="badge bg-program"><?php echo e($programCenters->count()); ?></span>
            </div>
            
            <?php if($programCenters->count() > 0): ?>
                <div class="centers-list">
                    <?php $__currentLoopData = $programCenters->take(4); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $center): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="center-item mb-2">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                <div class="center-mini-icon icon-type-program me-2">
                                    <i class="fas fa-seedling"></i>
                                </div>
                                <div>
                                    <span class="fw-bold"><?php echo e($center->center_name); ?></span>
                                    <br>
                                    <small class="text-muted">
                                        <i class="fas fa-<?php echo e($center->gender == 'بنات' ? 'female' : 'male'); ?> me-1"></i>
                                        <?php echo e($center->gender); ?>

                                    </small>
                                </div>
                            </div>
                            <div class="text-end">
                                <span class="badge bg-<?php echo e($center->status == 'active' ? 'success' : 'danger'); ?>">
                                    <?php echo e($center->status == 'active' ? 'نشط' : 'متوقف'); ?>

                                </span>
                                <br>
                                <small class="text-muted"><?php echo e($center->students()->count()); ?> طالب</small>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                <?php if($programCenters->count() > 4): ?>
                <div class="text-center mt-3">
                    <a href="<?php echo e(url('admin/centers')); ?>?type=برنامج" class="btn btn-sm btn-outline-program">
                        عرض الكل (<?php echo e($programCenters->count()); ?>)
                    </a>
                </div>
                <?php endif; ?>
            <?php else: ?>
                <div class="text-center py-4 opacity-50">
                    <i class="fas fa-seedling fa-2x mb-2"></i>
                    <p class="mb-0">لا توجد برامج</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- الطلبات الحديثة -->
<div class="content-card">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h5 class="mb-0">
            <i class="fas fa-clock me-2"></i>
            آخر الطلبات (<?php echo e($recentStudents->count()); ?>)
        </h5>
        <a href="<?php echo e(url('admin/students')); ?>" class="btn btn-outline-light btn-sm">
            <i class="fas fa-list me-1"></i>
            عرض جميع الطلبات
        </a>
    </div>
    
    <?php if($recentStudents->isNotEmpty()): ?>
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>الطالب/ة</th>
                        <th>الجهة التعليمية</th>
                        <th>الفترة</th>
                        <th>الحالة</th>
                        <th>التاريخ</th>
                        <th>الإجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $recentStudents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                        $genderClass = ($student->gender ?? 'أنثى') == 'أنثى' ? 'female' : 'male';
                        $genderIcon = $genderClass == 'female' ? 'female' : 'male';
                        $genderColor = $genderClass == 'female' ? '#f48fb1' : '#64b5f6';
                        
                        // الجهة
                        $centerName = $student->center ? $student->center->center_name : ($student->center_name ?? 'غير محدد');
                        $centerType = $student->center ? $student->center->type : null;
                        $typeClass = ['دار' => 'dar', 'مركز' => 'markaz', 'برنامج' => 'program'][$centerType] ?? 'secondary';
                        $typeIcon = ['دار' => 'mosque', 'مركز' => 'graduation-cap', 'برنامج' => 'seedling'][$centerType] ?? 'school';
                    ?>
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="student-avatar me-2" style="background: rgba(<?php echo e($genderClass == 'female' ? '233, 30, 99' : '33, 150, 243'); ?>, 0.15); color: <?php echo e($genderColor); ?>;">
                                    <i class="fas fa-<?php echo e($genderIcon); ?>"></i>
                                </div>
                                <div>
                                    <strong class="text-white"><?php echo e($student->name); ?></strong>
                                    <br>
                                    <small class="text-muted">
                                        <?php echo e($student->student_id ?? $student->phone ?? 'بدون رقم'); ?>

                                    </small>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <?php if($centerType): ?>
                                <span class="badge badge-type-<?php echo e($typeClass); ?> me-2">
                                    <i class="fas fa-<?php echo e($typeIcon); ?>"></i>
                                </span>
                                <?php endif; ?>
                                <span><?php echo e($centerName); ?></span>
                            </div>
                        </td>
                        <td>
                            <?php
                                $schedule = $student->preferred_schedule ?? $student->schedule ?? 'غير محدد';
                                $isMorning = $schedule == 'صباحية';
                            ?>
                            <span class="badge <?php echo e($isMorning ? 'badge-period-morning' : 'badge-period-evening'); ?>">
                                <i class="fas fa-<?php echo e($isMorning ? 'sun' : 'moon'); ?> me-1"></i>
                                <?php echo e($schedule); ?>

                            </span>
                        </td>
                        <td>
                            <?php
                                $statusColors = [
                                    'pending' => 'warning',
                                    'approved' => 'success',
                                    'rejected' => 'danger',
                                    'suspended' => 'secondary'
                                ];
                                $statusTexts = [
                                    'pending' => 'قيد المراجعة',
                                    'approved' => 'مقبول',
                                    'rejected' => 'مرفوض',
                                    'suspended' => 'معلق'
                                ];
                                $status = $student->status ?? 'pending';
                            ?>
                            <span class="badge bg-<?php echo e($statusColors[$status] ?? 'secondary'); ?>">
                                <?php echo e($statusTexts[$status] ?? $status); ?>

                            </span>
                        </td>
                        <td>
                            <small class="text-muted">
                                <?php echo e($student->created_at ? $student->created_at->format('Y/m/d') : 'غير محدد'); ?>

                                <br>
                                <span class="opacity-75">
                                    <?php echo e($student->created_at ? $student->created_at->diffForHumans() : ''); ?>

                                </span>
                            </small>
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="<?php echo e(url('admin/students/' . $student->id)); ?>" 
                                   class="btn btn-outline-info" title="عرض التفاصيل">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <?php if($student->status === 'pending'): ?>
                                <form action="<?php echo e(url('admin/students/' . $student->id . '/approve')); ?>" method="POST" class="d-inline">
                                    <?php echo csrf_field(); ?>
                                    <button type="submit" class="btn btn-outline-success" title="قبول"
                                            onclick="return confirm('هل تريد قبول هذا الطالب؟')">
                                        <i class="fas fa-check"></i>
                                    </button>
                                </form>
                                <form action="<?php echo e(url('admin/students/' . $student->id . '/reject')); ?>" method="POST" class="d-inline">
                                    <?php echo csrf_field(); ?>
                                    <button type="submit" class="btn btn-outline-danger" title="رفض"
                                            onclick="return confirm('هل تريد رفض هذا الطالب؟')">
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
    <?php else: ?>
        <div class="text-center py-5">
            <i class="fas fa-inbox opacity-50" style="font-size: 4rem;"></i>
            <h6 class="mt-3 opacity-75">لا توجد طلبات جديدة</h6>
            <p class="opacity-50">ستظهر الطلبات الجديدة هنا عند وصولها</p>
        </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
<style>
    /* ==========================================
       إحصائيات
       ========================================== */
    .stats-card {
        background: rgba(255, 255, 255, 0.05);
        border-radius: 15px;
        padding: 1.5rem;
        border: 1px solid rgba(127, 176, 105, 0.2);
        backdrop-filter: blur(10px);
        transition: all 0.3s ease;
    }
    .stats-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.2);
    }
    .stats-icon {
        width: 60px;
        height: 60px;
        border-radius: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        backdrop-filter: blur(10px);
    }
    .icon-stats-info {
        background: rgba(33, 150, 243, 0.15);
        color: #64b5f6;
        border: 1px solid rgba(33, 150, 243, 0.3);
    }
    .icon-stats-success {
        background: rgba(76, 175, 80, 0.15);
        color: #81c784;
        border: 1px solid rgba(76, 175, 80, 0.3);
    }
    .icon-stats-primary {
        background: rgba(127, 176, 105, 0.15);
        color: #90c695;
        border: 1px solid rgba(127, 176, 105, 0.3);
    }
    .icon-stats-warning {
        background: rgba(255, 193, 7, 0.15);
        color: #ffd454;
        border: 1px solid rgba(255, 193, 7, 0.3);
    }
    
    /* ==========================================
       ألوان الأنواع
       ========================================== */
    /* دور التحفيظ - أحمر */
    .text-dar { color: #c86868 !important; }
    .bg-dar { background: rgba(176, 39, 39, 0.8) !important; }
    .border-dar { border-right: 4px solid #c86868 !important; }
    .badge-type-dar {
        background: rgba(176, 39, 39, 0.15) !important;
        color: #c86868 !important;
        border: 1px solid rgba(176, 39, 39, 0.3) !important;
    }
    .icon-type-dar {
        background: rgba(176, 39, 39, 0.15);
        color: #c86868;
        border: 1px solid rgba(176, 39, 39, 0.3);
    }
    .btn-outline-dar {
        color: #c86868;
        border-color: rgba(176, 39, 39, 0.5);
    }
    .btn-outline-dar:hover {
        background: rgba(176, 39, 39, 0.2);
        color: #c86868;
    }
    
    /* مركز - برتقالي */
    .text-markaz { color: #ffb74d !important; }
    .bg-markaz { background: rgba(255, 152, 0, 0.8) !important; }
    .border-markaz { border-right: 4px solid #ffb74d !important; }
    .badge-type-markaz {
        background: rgba(255, 152, 0, 0.15) !important;
        color: #ffb74d !important;
        border: 1px solid rgba(255, 152, 0, 0.3) !important;
    }
    .icon-type-markaz {
        background: rgba(255, 152, 0, 0.15);
        color: #ffb74d;
        border: 1px solid rgba(255, 152, 0, 0.3);
    }
    .btn-outline-markaz {
        color: #ffb74d;
        border-color: rgba(255, 152, 0, 0.5);
    }
    .btn-outline-markaz:hover {
        background: rgba(255, 152, 0, 0.2);
        color: #ffb74d;
    }
    
    /* برامج - أخضر */
    .text-program { color: #81c784 !important; }
    .bg-program { background: rgba(76, 175, 80, 0.8) !important; }
    .border-program { border-right: 4px solid #81c784 !important; }
    .badge-type-program {
        background: rgba(76, 175, 80, 0.15) !important;
        color: #81c784 !important;
        border: 1px solid rgba(76, 175, 80, 0.3) !important;
    }
    .icon-type-program {
        background: rgba(76, 175, 80, 0.15);
        color: #81c784;
        border: 1px solid rgba(76, 175, 80, 0.3);
    }
    .btn-outline-program {
        color: #81c784;
        border-color: rgba(76, 175, 80, 0.5);
    }
    .btn-outline-program:hover {
        background: rgba(76, 175, 80, 0.2);
        color: #81c784;
    }
    
    /* ==========================================
       الفترات
       ========================================== */
    .badge-period-morning {
        background: rgba(255, 152, 0, 0.15) !important;
        color: #ffb74d !important;
        border: 1px solid rgba(255, 152, 0, 0.3) !important;
    }
    .badge-period-evening {
        background: rgba(25, 118, 210, 0.15) !important;
        color: #42a5f5 !important;
        border: 1px solid rgba(25, 118, 210, 0.3) !important;
    }
    
    /* ==========================================
       قوائم الجهات
       ========================================== */
    .centers-list {
        max-height: 300px;
        overflow-y: auto;
    }
    .center-item {
        background: rgba(255, 255, 255, 0.03);
        border-radius: 10px;
        padding: 0.75rem;
        transition: all 0.2s ease;
    }
    .center-item:hover {
        background: rgba(255, 255, 255, 0.08);
    }
    .center-mini-icon {
        width: 35px;
        height: 35px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.85rem;
    }
    
    /* ==========================================
       الطلاب
       ========================================== */
    .student-avatar {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.1rem;
    }
    
    /* ==========================================
       عام
       ========================================== */
    .content-card {
        background: rgba(255, 255, 255, 0.05);
        border-radius: 15px;
        padding: 1.5rem;
        border: 1px solid rgba(127, 176, 105, 0.2);
        backdrop-filter: blur(10px);
    }
    
    /* Scrollbar */
    .centers-list::-webkit-scrollbar {
        width: 5px;
    }
    .centers-list::-webkit-scrollbar-track {
        background: rgba(255,255,255,0.05);
        border-radius: 10px;
    }
    .centers-list::-webkit-scrollbar-thumb {
        background: rgba(127, 176, 105, 0.3);
        border-radius: 10px;
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
// تحديث الساعة
function updateClock() {
    const now = new Date();
    const options = {
        timeZone: 'Asia/Riyadh',
        hour12: true,
        hour: '2-digit',
        minute: '2-digit',
        second: '2-digit'
    };
    const timeString = now.toLocaleTimeString('ar-SA', options);
    const clockElement = document.getElementById('clock');
    if (clockElement) {
        clockElement.textContent = timeString;
    }
}

setInterval(updateClock, 1000);
updateClock();

// تحديث البيانات
function refreshData() {
    location.reload();
}
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/rasedbus/project-bus/resources/views/admin/dashboard.blade.php ENDPATH**/ ?>