

<?php $__env->startSection('title', 'التقارير الشاملة'); ?>

<?php $__env->startSection('header'); ?>
<div class="d-flex justify-content-between align-items-center w-100">
    <div>
        <h2 class="mb-1">
            <i class="fas fa-chart-bar me-2"></i>
            التقارير والإحصائيات الشاملة
        </h2>
        <p class="text-light opacity-75 mb-0">تقرير شامل عن جميع بيانات النظام</p>
    </div>
    <div class="d-flex gap-2 no-print">
        <button onclick="window.print()" class="btn btn-outline-info">
            <i class="fas fa-print me-1"></i>
            طباعة PDF
        </button>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div id="printable-report">
    <!-- عنوان للطباعة -->
    <div class="print-header">
        <div class="text-center mb-4">
            <h2 class="mb-1">نظام النقل التعليمي</h2>
            <h4 class="mb-1">جمعية تحفيظ القرآن الكريم - الزلفي</h4>
            <p class="text-muted mb-2">التقرير الشامل</p>
            <p class="text-muted small">تاريخ التقرير: <?php echo e(now()->format('Y-m-d')); ?> | الوقت: <?php echo e(now()->format('H:i')); ?></p>
        </div>
        <hr>
    </div>

    <!-- ==================== الإحصائيات الرئيسية ==================== -->
    <div class="row mb-4">
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="stats-card primary">
                <div class="d-flex align-items-center">
                    <div class="stats-icon">
                        <i class="fas fa-user-graduate fa-2x"></i>
                    </div>
                    <div class="me-3">
                        <h3 class="mb-0"><?php echo e(number_format($studentStats['total'])); ?></h3>
                        <small>إجمالي الطلاب</small>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="stats-card warning">
                <div class="d-flex align-items-center">
                    <div class="stats-icon">
                        <i class="fas fa-bus fa-2x"></i>
                    </div>
                    <div class="me-3">
                        <h3 class="mb-0"><?php echo e(number_format($busStats['total'])); ?></h3>
                        <small>إجمالي الباصات</small>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="stats-card info">
                <div class="d-flex align-items-center">
                    <div class="stats-icon">
                        <i class="fas fa-id-card fa-2x"></i>
                    </div>
                    <div class="me-3">
                        <h3 class="mb-0"><?php echo e(number_format($driverStats['total'])); ?></h3>
                        <small>إجمالي السائقين</small>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="stats-card success">
                <div class="d-flex align-items-center">
                    <div class="stats-icon">
                        <i class="fas fa-money-bill-wave fa-2x"></i>
                    </div>
                    <div class="me-3">
                        <h3 class="mb-0"><?php echo e(number_format($paymentStats['total_paid'])); ?></h3>
                        <small>إجمالي المحصّل (ر.س)</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ==================== قسم الطلاب ==================== -->
    <div class="content-card mb-4">
        <h4 class="section-title">
            <i class="fas fa-user-graduate text-primary me-2"></i>
            إحصائيات الطلاب
        </h4>
        
        <div class="row">
            <!-- حسب الحالة -->
            <div class="col-lg-4 mb-4">
                <h6 class="sub-title"><i class="fas fa-clipboard-check me-1"></i> حسب الحالة</h6>
                <div class="table-responsive">
                    <table class="table table-sm">
                        <tbody>
                            <tr>
                                <td><span class="badge bg-success">مقبول</span></td>
                                <td class="text-end fw-bold"><?php echo e(number_format($studentStats['approved'])); ?></td>
                                <td class="text-end text-muted"><?php echo e($studentStats['total'] > 0 ? round($studentStats['approved'] / $studentStats['total'] * 100, 1) : 0); ?>%</td>
                            </tr>
                            <tr>
                                <td><span class="badge bg-warning">قيد المراجعة</span></td>
                                <td class="text-end fw-bold"><?php echo e(number_format($studentStats['pending'])); ?></td>
                                <td class="text-end text-muted"><?php echo e($studentStats['total'] > 0 ? round($studentStats['pending'] / $studentStats['total'] * 100, 1) : 0); ?>%</td>
                            </tr>
                            <tr>
                                <td><span class="badge bg-danger">مرفوض</span></td>
                                <td class="text-end fw-bold"><?php echo e(number_format($studentStats['rejected'])); ?></td>
                                <td class="text-end text-muted"><?php echo e($studentStats['total'] > 0 ? round($studentStats['rejected'] / $studentStats['total'] * 100, 1) : 0); ?>%</td>
                            </tr>
                            <tr>
                                <td><span class="badge bg-secondary">معلق</span></td>
                                <td class="text-end fw-bold"><?php echo e(number_format($studentStats['suspended'])); ?></td>
                                <td class="text-end text-muted"><?php echo e($studentStats['total'] > 0 ? round($studentStats['suspended'] / $studentStats['total'] * 100, 1) : 0); ?>%</td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr class="table-dark">
                                <td><strong>الإجمالي</strong></td>
                                <td class="text-end fw-bold"><?php echo e(number_format($studentStats['total'])); ?></td>
                                <td class="text-end">100%</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            <!-- حسب الجنس والفترة -->
            <div class="col-lg-4 mb-4">
                <h6 class="sub-title"><i class="fas fa-venus-mars me-1"></i> حسب الجنس</h6>
                <div class="row text-center mb-3">
                    <div class="col-6">
                        <div class="p-3 rounded stat-box male">
                            <i class="fas fa-male fa-2x mb-2"></i>
                            <h4 class="mb-0"><?php echo e(number_format($studentStats['male'])); ?></h4>
                            <small>ذكور</small>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="p-3 rounded stat-box female">
                            <i class="fas fa-female fa-2x mb-2"></i>
                            <h4 class="mb-0"><?php echo e(number_format($studentStats['female'])); ?></h4>
                            <small>إناث</small>
                        </div>
                    </div>
                </div>

                <h6 class="sub-title"><i class="fas fa-clock me-1"></i> حسب الفترة</h6>
                <div class="row text-center">
                    <div class="col-6">
                        <div class="p-3 rounded stat-box morning">
                            <i class="fas fa-sun fa-2x mb-2"></i>
                            <h4 class="mb-0"><?php echo e(number_format($studentStats['morning'])); ?></h4>
                            <small>صباحية</small>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="p-3 rounded stat-box evening">
                            <i class="fas fa-moon fa-2x mb-2"></i>
                            <h4 class="mb-0"><?php echo e(number_format($studentStats['evening'])); ?></h4>
                            <small>مسائية</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- حسب نوع الجهة -->
            <div class="col-lg-4 mb-4">
                <h6 class="sub-title"><i class="fas fa-layer-group me-1"></i> حسب نوع الجهة</h6>
                <div class="row text-center">
                    <div class="col-4">
                        <div class="p-3 rounded stat-box dour">
                            <i class="fas fa-mosque fa-2x mb-2"></i>
                            <h4 class="mb-0"><?php echo e(number_format($studentStats['dour'])); ?></h4>
                            <small>الدور</small>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="p-3 rounded stat-box markaz">
                            <i class="fas fa-graduation-cap fa-2x mb-2"></i>
                            <h4 class="mb-0"><?php echo e(number_format($studentStats['markaz'])); ?></h4>
                            <small>المركز</small>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="p-3 rounded stat-box riyaheen">
                            <i class="fas fa-seedling fa-2x mb-2"></i>
                            <h4 class="mb-0"><?php echo e(number_format($studentStats['riyaheen'])); ?></h4>
                            <small>الرياحين</small>
                        </div>
                    </div>
                </div>

                <h6 class="sub-title mt-3"><i class="fas fa-bus me-1"></i> تخصيص الباصات</h6>
                <div class="row text-center">
                    <div class="col-6">
                        <div class="p-3 rounded stat-box success-light">
                            <h4 class="mb-0"><?php echo e(number_format($studentStats['with_bus'])); ?></h4>
                            <small>لديهم باص</small>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="p-3 rounded stat-box danger-light">
                            <h4 class="mb-0"><?php echo e(number_format($studentStats['without_bus'])); ?></h4>
                            <small>بدون باص</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ==================== قسم الباصات ==================== -->
    <div class="content-card mb-4">
        <h4 class="section-title">
            <i class="fas fa-bus text-warning me-2"></i>
            إحصائيات الباصات
        </h4>
        
        <div class="row">
            <!-- حالة الباصات -->
            <div class="col-lg-4 mb-4">
                <h6 class="sub-title"><i class="fas fa-toggle-on me-1"></i> حسب الحالة</h6>
                <div class="row text-center">
                    <div class="col-4">
                        <div class="p-3 rounded stat-box success-light">
                            <h4 class="mb-0 text-success"><?php echo e($busStats['active']); ?></h4>
                            <small>نشط</small>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="p-3 rounded stat-box warning-light">
                            <h4 class="mb-0 text-warning"><?php echo e($busStats['maintenance']); ?></h4>
                            <small>صيانة</small>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="p-3 rounded stat-box danger-light">
                            <h4 class="mb-0 text-danger"><?php echo e($busStats['inactive']); ?></h4>
                            <small>متوقف</small>
                        </div>
                    </div>
                </div>

                <h6 class="sub-title mt-3"><i class="fas fa-user-tie me-1"></i> السائقين</h6>
                <div class="row text-center">
                    <div class="col-6">
                        <div class="p-3 rounded stat-box success-light">
                            <h4 class="mb-0"><?php echo e($busStats['with_driver']); ?></h4>
                            <small>مع سائق</small>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="p-3 rounded stat-box danger-light">
                            <h4 class="mb-0"><?php echo e($busStats['without_driver']); ?></h4>
                            <small>بدون سائق</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- السعة والإشغال -->
            <div class="col-lg-4 mb-4">
                <h6 class="sub-title"><i class="fas fa-chair me-1"></i> السعة والإشغال</h6>
                <div class="capacity-stats">
                    <div class="d-flex justify-content-between mb-2">
                        <span>إجمالي المقاعد:</span>
                        <strong><?php echo e(number_format($busStats['total_capacity'])); ?></strong>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>المقاعد المشغولة:</span>
                        <strong class="text-success"><?php echo e(number_format($busStats['occupied_seats'])); ?></strong>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>المقاعد المتاحة:</span>
                        <strong class="text-info"><?php echo e(number_format($busStats['available_seats'])); ?></strong>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between mb-2">
                        <span>نسبة الإشغال:</span>
                        <strong class="text-warning"><?php echo e($busStats['occupancy_rate']); ?>%</strong>
                    </div>
                    <div class="progress" style="height: 20px;">
                        <div class="progress-bar bg-<?php echo e($busStats['occupancy_rate'] >= 90 ? 'danger' : ($busStats['occupancy_rate'] >= 70 ? 'warning' : 'success')); ?>" 
                             style="width: <?php echo e($busStats['occupancy_rate']); ?>%">
                            <?php echo e($busStats['occupancy_rate']); ?>%
                        </div>
                    </div>
                </div>
            </div>

            <!-- تفاصيل الباصات -->
            <div class="col-lg-4 mb-4">
                <h6 class="sub-title"><i class="fas fa-list me-1"></i> ملخص سريع</h6>
                <div class="quick-stats">
                    <div class="quick-stat-item">
                        <span>متوسط السعة للباص:</span>
                        <strong><?php echo e($busStats['total'] > 0 ? round($busStats['total_capacity'] / $busStats['total']) : 0); ?> راكب</strong>
                    </div>
                    <div class="quick-stat-item">
                        <span>متوسط الركاب للباص:</span>
                        <strong><?php echo e($busStats['total'] > 0 ? round($busStats['occupied_seats'] / $busStats['total']) : 0); ?> راكب</strong>
                    </div>
                    <div class="quick-stat-item">
                        <span>باصات ممتلئة (90%+):</span>
                        <strong><?php echo e($busesDetails->where('occupancy_rate', '>=', 90)->count()); ?></strong>
                    </div>
                    <div class="quick-stat-item">
                        <span>باصات فارغة (0%):</span>
                        <strong><?php echo e($busesDetails->where('current_students', 0)->count()); ?></strong>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ==================== قسم السائقين ==================== -->
    <div class="content-card mb-4">
        <h4 class="section-title">
            <i class="fas fa-id-card text-info me-2"></i>
            إحصائيات السائقين
        </h4>
        
        <div class="row">
            <div class="col-lg-4 mb-4">
                <h6 class="sub-title"><i class="fas fa-toggle-on me-1"></i> حسب الحالة</h6>
                <div class="row text-center">
                    <div class="col-4">
                        <div class="p-3 rounded stat-box success-light">
                            <h4 class="mb-0 text-success"><?php echo e($driverStats['active']); ?></h4>
                            <small>نشط</small>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="p-3 rounded stat-box warning-light">
                            <h4 class="mb-0 text-warning"><?php echo e($driverStats['on_leave']); ?></h4>
                            <small>إجازة</small>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="p-3 rounded stat-box danger-light">
                            <h4 class="mb-0 text-danger"><?php echo e($driverStats['inactive']); ?></h4>
                            <small>غير نشط</small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 mb-4">
                <h6 class="sub-title"><i class="fas fa-bus me-1"></i> التخصيص</h6>
                <div class="row text-center">
                    <div class="col-6">
                        <div class="p-3 rounded stat-box success-light">
                            <h4 class="mb-0"><?php echo e($driverStats['with_bus']); ?></h4>
                            <small>مخصص لباص</small>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="p-3 rounded stat-box info-light">
                            <h4 class="mb-0"><?php echo e($driverStats['without_bus']); ?></h4>
                            <small>متاح</small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 mb-4">
                <h6 class="sub-title"><i class="fas fa-calculator me-1"></i> المالية والخبرة</h6>
                <div class="quick-stats">
                    <div class="quick-stat-item">
                        <span>إجمالي الرواتب:</span>
                        <strong><?php echo e(number_format($driverStats['total_salary'])); ?> ر.س</strong>
                    </div>
                    <div class="quick-stat-item">
                        <span>متوسط الخبرة:</span>
                        <strong><?php echo e($driverStats['avg_experience']); ?> سنة</strong>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ==================== قسم المدفوعات ==================== -->
    <div class="content-card mb-4">
        <h4 class="section-title">
            <i class="fas fa-money-bill-wave text-success me-2"></i>
            إحصائيات المدفوعات
        </h4>
        
        <div class="row">
            <!-- ملخص المبالغ -->
            <div class="col-lg-6 mb-4">
                <h6 class="sub-title"><i class="fas fa-coins me-1"></i> ملخص المبالغ</h6>
                <div class="payment-summary">
                    <div class="payment-item total">
                        <div class="d-flex justify-content-between">
                            <span>إجمالي المبالغ المطلوبة:</span>
                            <strong><?php echo e(number_format($paymentStats['total_required'], 2)); ?> ر.س</strong>
                        </div>
                    </div>
                    <div class="payment-item paid">
                        <div class="d-flex justify-content-between">
                            <span>إجمالي المبالغ المحصّلة:</span>
                            <strong class="text-success"><?php echo e(number_format($paymentStats['total_paid'], 2)); ?> ر.س</strong>
                        </div>
                    </div>
                    <div class="payment-item pending-amount">
                        <div class="d-flex justify-content-between">
                            <span>مبالغ قيد المراجعة:</span>
                            <strong class="text-warning"><?php echo e(number_format($paymentStats['total_pending'], 2)); ?> ر.س</strong>
                        </div>
                    </div>
                    <div class="payment-item remaining">
                        <div class="d-flex justify-content-between">
                            <span>المبالغ المتبقية:</span>
                            <strong class="text-danger"><?php echo e(number_format($paymentStats['total_remaining'], 2)); ?> ر.س</strong>
                        </div>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between mb-2">
                        <span>نسبة التحصيل:</span>
                        <strong class="text-primary"><?php echo e($paymentStats['collection_rate']); ?>%</strong>
                    </div>
                    <div class="progress" style="height: 25px;">
                        <div class="progress-bar bg-success" style="width: <?php echo e($paymentStats['collection_rate']); ?>%">
                            <?php echo e($paymentStats['collection_rate']); ?>% محصّل
                        </div>
                        <div class="progress-bar bg-danger" style="width: <?php echo e(100 - $paymentStats['collection_rate']); ?>%">
                            <?php echo e(round(100 - $paymentStats['collection_rate'], 1)); ?>% متبقي
                        </div>
                    </div>
                </div>
            </div>

            <!-- عدد الدفعات -->
            <div class="col-lg-6 mb-4">
                <h6 class="sub-title"><i class="fas fa-receipt me-1"></i> عدد الدفعات</h6>
                <div class="table-responsive">
                    <table class="table table-sm">
                        <tbody>
                            <tr>
                                <td><span class="badge bg-success">مقبولة</span></td>
                                <td class="text-end fw-bold"><?php echo e(number_format($paymentStats['approved_payments'])); ?></td>
                            </tr>
                            <tr>
                                <td><span class="badge bg-warning">قيد المراجعة</span></td>
                                <td class="text-end fw-bold"><?php echo e(number_format($paymentStats['pending_payments'])); ?></td>
                            </tr>
                            <tr>
                                <td><span class="badge bg-primary">بانتظار الإيصال</span></td>
                                <td class="text-end fw-bold"><?php echo e(number_format($paymentStats['awaiting_receipt'])); ?></td>
                            </tr>
                            <tr>
                                <td><span class="badge bg-danger">مرفوضة</span></td>
                                <td class="text-end fw-bold"><?php echo e(number_format($paymentStats['rejected_payments'])); ?></td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr class="table-dark">
                                <td><strong>إجمالي الدفعات</strong></td>
                                <td class="text-end fw-bold"><?php echo e(number_format($paymentStats['total_payments'])); ?></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- ==================== قسم الجهات ==================== -->
    <div class="content-card mb-4">
        <h4 class="section-title">
            <i class="fas fa-school text-purple me-2"></i>
            إحصائيات الجهات
        </h4>
        
        <div class="row mb-4">
            <div class="col-lg-3 col-md-6 mb-3">
                <div class="text-center p-3 rounded stat-box dour">
                    <i class="fas fa-mosque fa-2x mb-2"></i>
                    <h4 class="mb-0"><?php echo e($centerStats['dour']); ?></h4>
                    <small>دور التحفيظ</small>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-3">
                <div class="text-center p-3 rounded stat-box markaz">
                    <i class="fas fa-graduation-cap fa-2x mb-2"></i>
                    <h4 class="mb-0"><?php echo e($centerStats['markaz']); ?></h4>
                    <small>المراكز</small>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-3">
                <div class="text-center p-3 rounded stat-box riyaheen">
                    <i class="fas fa-seedling fa-2x mb-2"></i>
                    <h4 class="mb-0"><?php echo e($centerStats['riyaheen']); ?></h4>
                    <small>الرياحين</small>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-3">
                <div class="text-center p-3 rounded stat-box info-light">
                    <i class="fas fa-building fa-2x mb-2"></i>
                    <h4 class="mb-0"><?php echo e($centerStats['total']); ?></h4>
                    <small>إجمالي الجهات</small>
                </div>
            </div>
        </div>

        <!-- جدول تفاصيل الجهات -->
        <h6 class="sub-title"><i class="fas fa-table me-1"></i> تفاصيل الجهات</h6>
        <div class="table-responsive">
            <table class="table table-sm table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>الجهة</th>
                        <th>النوع</th>
                        <th>الجنس</th>
                        <th>الطلاب</th>
                        <th>مقبول</th>
                        <th>معلق</th>
                        <th>صباحي</th>
                        <th>مسائي</th>
                        <th>الباصات</th>
                        <th>الإشغال</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $centersDetails; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $center): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><strong><?php echo e($center['name']); ?></strong></td>
                        <td>
                            <?php
                                $typeClass = match($center['type']) {
                                    'دار' => 'danger',
                                    'مركز' => 'warning',
                                    'برنامج' => 'success',
                                    default => 'secondary'
                                };
                            ?>
                            <span class="badge bg-<?php echo e($typeClass); ?>"><?php echo e($center['type']); ?></span>
                        </td>
                        <td><?php echo e($center['gender']); ?></td>
                        <td><strong><?php echo e($center['students_count']); ?></strong></td>
                        <td class="text-success"><?php echo e($center['approved_students']); ?></td>
                        <td class="text-warning"><?php echo e($center['pending_students']); ?></td>
                        <td><?php echo e($center['morning_students']); ?></td>
                        <td><?php echo e($center['evening_students']); ?></td>
                        <td><?php echo e($center['buses_count']); ?></td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="progress flex-grow-1 me-2" style="height: 8px; width: 60px;">
                                    <div class="progress-bar bg-<?php echo e($center['occupancy_rate'] >= 90 ? 'danger' : ($center['occupancy_rate'] >= 70 ? 'warning' : 'success')); ?>" 
                                         style="width: <?php echo e($center['occupancy_rate']); ?>%"></div>
                                </div>
                                <small><?php echo e($center['occupancy_rate']); ?>%</small>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- ==================== المدفوعات حسب الجهة ==================== -->
    <div class="content-card mb-4">
        <h4 class="section-title">
            <i class="fas fa-file-invoice-dollar text-success me-2"></i>
            المدفوعات حسب الجهة
        </h4>
        
        <div class="table-responsive">
            <table class="table table-sm table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>الجهة</th>
                        <th>النوع</th>
                        <th>عدد الطلاب</th>
                        <th>المطلوب</th>
                        <th>المحصّل</th>
                        <th>المتبقي</th>
                        <th>نسبة التحصيل</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $paymentsByCenter; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $center): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><strong><?php echo e($center['name']); ?></strong></td>
                        <td>
                            <?php
                                $typeClass = match($center['type']) {
                                    'دار' => 'danger',
                                    'مركز' => 'warning',
                                    'برنامج' => 'success',
                                    default => 'secondary'
                                };
                            ?>
                            <span class="badge bg-<?php echo e($typeClass); ?>"><?php echo e($center['type']); ?></span>
                        </td>
                        <td><?php echo e($center['students_count']); ?></td>
                        <td><?php echo e(number_format($center['total_required'], 2)); ?></td>
                        <td class="text-success"><?php echo e(number_format($center['total_paid'], 2)); ?></td>
                        <td class="text-danger"><?php echo e(number_format($center['total_remaining'], 2)); ?></td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="progress flex-grow-1 me-2" style="height: 8px; width: 80px;">
                                    <div class="progress-bar bg-success" style="width: <?php echo e($center['collection_rate']); ?>%"></div>
                                </div>
                                <small><?php echo e($center['collection_rate']); ?>%</small>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
                <tfoot class="table-secondary">
                    <tr>
                        <td colspan="2"><strong>الإجمالي</strong></td>
                        <td><strong><?php echo e($paymentsByCenter->sum('students_count')); ?></strong></td>
                        <td><strong><?php echo e(number_format($paymentsByCenter->sum('total_required'), 2)); ?></strong></td>
                        <td class="text-success"><strong><?php echo e(number_format($paymentsByCenter->sum('total_paid'), 2)); ?></strong></td>
                        <td class="text-danger"><strong><?php echo e(number_format($paymentsByCenter->sum('total_remaining'), 2)); ?></strong></td>
                        <td><strong><?php echo e($paymentStats['collection_rate']); ?>%</strong></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    <!-- ==================== جدول الباصات ==================== -->
    <div class="content-card mb-4">
        <h4 class="section-title">
            <i class="fas fa-bus text-warning me-2"></i>
            تفاصيل الباصات
        </h4>
        
        <div class="table-responsive">
            <table class="table table-sm table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>رقم الباص</th>
                        <th>اللوحة</th>
                        <th>الموديل</th>
                        <th>السائق</th>
                        <th>الجهة</th>
                        <th>السعة</th>
                        <th>الركاب</th>
                        <th>متاح</th>
                        <th>الإشغال</th>
                        <th>الحالة</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $busesDetails; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bus): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><strong><?php echo e($bus['number']); ?></strong></td>
                        <td><?php echo e($bus['plate_number']); ?></td>
                        <td><?php echo e($bus['model'] ?? '-'); ?></td>
                        <td><?php echo e($bus['driver_name']); ?></td>
                        <td><?php echo e($bus['center_name']); ?></td>
                        <td><?php echo e($bus['capacity']); ?></td>
                        <td class="text-success"><?php echo e($bus['current_students']); ?></td>
                        <td class="text-info"><?php echo e($bus['available_seats']); ?></td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="progress flex-grow-1 me-2" style="height: 8px; width: 50px;">
                                    <div class="progress-bar bg-<?php echo e($bus['occupancy_rate'] >= 90 ? 'danger' : ($bus['occupancy_rate'] >= 70 ? 'warning' : 'success')); ?>" 
                                         style="width: <?php echo e($bus['occupancy_rate']); ?>%"></div>
                                </div>
                                <small><?php echo e($bus['occupancy_rate']); ?>%</small>
                            </div>
                        </td>
                        <td>
                            <?php
                                $statusClass = match($bus['status']) {
                                    'active' => 'success',
                                    'maintenance' => 'warning',
                                    'inactive' => 'danger',
                                    default => 'secondary'
                                };
                            ?>
                            <span class="badge bg-<?php echo e($statusClass); ?>"><?php echo e($bus['status_text']); ?></span>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- ==================== جدول السائقين ==================== -->
    <div class="content-card mb-4">
        <h4 class="section-title">
            <i class="fas fa-id-card text-info me-2"></i>
            تفاصيل السائقين
        </h4>
        
        <div class="table-responsive">
            <table class="table table-sm table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>الرقم</th>
                        <th>الاسم</th>
                        <th>الجوال</th>
                        <th>رقم الرخصة</th>
                        <th>الخبرة</th>
                        <th>الجهة</th>
                        <th>الباص</th>
                        <th>الراتب</th>
                        <th>الحالة</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $driversDetails; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $driver): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><small><?php echo e($driver['driver_id']); ?></small></td>
                        <td><strong><?php echo e($driver['name']); ?></strong></td>
                        <td dir="ltr"><?php echo e($driver['mobile']); ?></td>
                        <td><?php echo e($driver['license_number']); ?></td>
                        <td><?php echo e($driver['experience_years']); ?> سنة</td>
                        <td><?php echo e($driver['center_name']); ?></td>
                        <td><?php echo e($driver['bus_number']); ?></td>
                        <td><?php echo e(number_format($driver['salary'])); ?></td>
                        <td>
                            <?php
                                $statusClass = match($driver['status']) {
                                    'active' => 'success',
                                    'on_leave' => 'warning',
                                    'inactive' => 'danger',
                                    default => 'secondary'
                                };
                            ?>
                            <span class="badge bg-<?php echo e($statusClass); ?>"><?php echo e($driver['status_name']); ?></span>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- ==================== قسم المشرفين ==================== -->
    <div class="content-card mb-4">
        <h4 class="section-title">
            <i class="fas fa-user-shield text-danger me-2"></i>
            إحصائيات المشرفين
        </h4>
        
        <div class="row">
            <div class="col-lg-6">
                <h6 class="sub-title"><i class="fas fa-users-cog me-1"></i> حسب الصلاحية</h6>
                <div class="table-responsive">
                    <table class="table table-sm">
                        <tbody>
                            <tr>
                                <td><span class="badge bg-danger"><i class="fas fa-crown me-1"></i> مدير عام</span></td>
                                <td class="text-end fw-bold"><?php echo e($adminStats['super_admin']); ?></td>
                            </tr>
                            <tr>
                                <td><span class="badge bg-primary"><i class="fas fa-user-shield me-1"></i> مشرف</span></td>
                                <td class="text-end fw-bold"><?php echo e($adminStats['admin']); ?></td>
                            </tr>
                            <tr>
                                <td><span class="badge bg-success"><i class="fas fa-calculator me-1"></i> محاسب</span></td>
                                <td class="text-end fw-bold"><?php echo e($adminStats['accountant']); ?></td>
                            </tr>
                            <tr>
                                <td><span class="badge bg-info"><i class="fas fa-eye me-1"></i> مراقب</span></td>
                                <td class="text-end fw-bold"><?php echo e($adminStats['supervisor']); ?></td>
                            </tr>
                            <tr>
                                <td><span class="badge bg-secondary"><i class="fas fa-keyboard me-1"></i> مدخل بيانات</span></td>
                                <td class="text-end fw-bold"><?php echo e($adminStats['data_entry']); ?></td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr class="table-dark">
                                <td><strong>الإجمالي</strong></td>
                                <td class="text-end fw-bold"><?php echo e($adminStats['total']); ?></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            <div class="col-lg-6">
                <h6 class="sub-title"><i class="fas fa-history me-1"></i> النشاط</h6>
                <div class="quick-stats">
                    <div class="quick-stat-item">
                        <span>إجمالي الأنشطة:</span>
                        <strong><?php echo e(number_format($adminStats['total_activities'])); ?></strong>
                    </div>
                    <div class="quick-stat-item">
                        <span>أنشطة اليوم:</span>
                        <strong><?php echo e(number_format($adminStats['today_activities'])); ?></strong>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ==================== آخر التسجيلات ==================== -->
    <div class="row">
        <div class="col-lg-6 mb-4">
            <div class="content-card h-100">
                <h5 class="section-title">
                    <i class="fas fa-user-plus text-primary me-2"></i>
                    آخر 10 تسجيلات
                </h5>
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>الاسم</th>
                                <th>الجهة</th>
                                <th>الحالة</th>
                                <th>التاريخ</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $recentStudents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e(Str::limit($student->name, 20)); ?></td>
                                <td><?php echo e($student->center->center_name ?? '-'); ?></td>
                                <td>
                                    <span class="badge bg-<?php echo e($student->status_color); ?>"><?php echo e($student->status_name); ?></span>
                                </td>
                                <td><small><?php echo e($student->created_at->format('m/d')); ?></small></td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-lg-6 mb-4">
            <div class="content-card h-100">
                <h5 class="section-title">
                    <i class="fas fa-money-check text-success me-2"></i>
                    آخر 10 دفعات
                </h5>
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>الرقم</th>
                                <th>الطالب</th>
                                <th>المبلغ</th>
                                <th>الحالة</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $recentPayments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><small><?php echo e($payment->payment_number); ?></small></td>
                                <td><?php echo e(Str::limit($payment->student->name ?? '-', 15)); ?></td>
                                <td><?php echo e(number_format($payment->amount)); ?></td>
                                <td>
                                    <span class="badge bg-<?php echo e($payment->status_color); ?>"><?php echo e($payment->status_text); ?></span>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- ==================== ذيل التقرير ==================== -->
    <div class="print-footer">
        <hr>
        <div class="row text-center text-muted small">
            <div class="col-4">
                <p class="mb-0">تم إنشاء هذا التقرير آلياً</p>
            </div>
            <div class="col-4">
                <p class="mb-0"><?php echo e(now()->format('Y-m-d H:i:s')); ?></p>
            </div>
            <div class="col-4">
                <p class="mb-0">نظام النقل التعليمي - الزلفي</p>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
<style>
    /* ==================== الأنماط العامة ==================== */
    .content-card {
        background: rgba(255,255,255,0.05);
        backdrop-filter: blur(10px);
        border-radius: 15px;
        padding: 1.5rem;
        border: 1px solid rgba(255,255,255,0.1);
    }

    .section-title {
        color: #7fb069;
        font-size: 1.1rem;
        padding-bottom: 0.75rem;
        border-bottom: 2px solid rgba(127, 176, 105, 0.3);
        margin-bottom: 1.5rem;
    }

    .sub-title {
        color: #adb5bd;
        font-size: 0.9rem;
        margin-bottom: 1rem;
    }

    /* ==================== كروت الإحصائيات الرئيسية ==================== */
    .stats-card {
        background: rgba(255,255,255,0.05);
        border-radius: 12px;
        padding: 1.25rem;
        border: 1px solid rgba(255,255,255,0.1);
    }

    .stats-card.primary { border-right: 4px solid #0d6efd; }
    .stats-card.success { border-right: 4px solid #198754; }
    .stats-card.warning { border-right: 4px solid #ffc107; }
    .stats-card.info { border-right: 4px solid #0dcaf0; }

    .stats-card .stats-icon {
        width: 60px;
        height: 60px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(255,255,255,0.1);
    }

    .stats-card h3 { font-size: 1.75rem; }

    /* ==================== صناديق الإحصائيات ==================== */
    .stat-box {
        border-radius: 10px;
        transition: transform 0.2s;
    }

    .stat-box.male { background: linear-gradient(135deg, rgba(33, 150, 243, 0.2), rgba(33, 150, 243, 0.1)); color: #64b5f6; }
    .stat-box.female { background: linear-gradient(135deg, rgba(233, 30, 99, 0.2), rgba(233, 30, 99, 0.1)); color: #f48fb1; }
    .stat-box.morning { background: linear-gradient(135deg, rgba(255, 152, 0, 0.2), rgba(255, 152, 0, 0.1)); color: #ffb74d; }
    .stat-box.evening { background: linear-gradient(135deg, rgba(63, 81, 181, 0.2), rgba(63, 81, 181, 0.1)); color: #7986cb; }
    .stat-box.dour { background: linear-gradient(135deg, rgba(220, 53, 69, 0.2), rgba(220, 53, 69, 0.1)); color: #e57373; }
    .stat-box.markaz { background: linear-gradient(135deg, rgba(255, 193, 7, 0.2), rgba(255, 193, 7, 0.1)); color: #ffd54f; }
    .stat-box.riyaheen { background: linear-gradient(135deg, rgba(76, 175, 80, 0.2), rgba(76, 175, 80, 0.1)); color: #81c784; }
    .stat-box.success-light { background: rgba(25, 135, 84, 0.15); }
    .stat-box.danger-light { background: rgba(220, 53, 69, 0.15); }
    .stat-box.warning-light { background: rgba(255, 193, 7, 0.15); }
    .stat-box.info-light { background: rgba(13, 202, 240, 0.15); }

    /* ==================== الإحصائيات السريعة ==================== */
    .quick-stats .quick-stat-item {
        display: flex;
        justify-content: space-between;
        padding: 0.5rem 0;
        border-bottom: 1px solid rgba(255,255,255,0.1);
    }

    .quick-stats .quick-stat-item:last-child {
        border-bottom: none;
    }

    /* ==================== ملخص المدفوعات ==================== */
    .payment-summary .payment-item {
        padding: 0.75rem;
        border-radius: 8px;
        margin-bottom: 0.5rem;
    }

    .payment-summary .payment-item.total { background: rgba(255,255,255,0.05); }
    .payment-summary .payment-item.paid { background: rgba(25, 135, 84, 0.1); }
    .payment-summary .payment-item.pending-amount { background: rgba(255, 193, 7, 0.1); }
    .payment-summary .payment-item.remaining { background: rgba(220, 53, 69, 0.1); }

    /* ==================== الجداول ==================== */
    .table {
        color: #e9ecef;
        font-size: 0.85rem;
    }

    .table thead th {
        border-bottom: 2px solid rgba(255,255,255,0.2);
        font-weight: 600;
        white-space: nowrap;
    }

    .table td {
        vertical-align: middle;
        border-color: rgba(255,255,255,0.1);
    }

    .capacity-stats {
        background: rgba(255,255,255,0.03);
        border-radius: 10px;
        padding: 1rem;
    }

    /* ==================== عنوان/ذيل الطباعة ==================== */
    .print-header,
    .print-footer {
        display: none;
    }

    /* ==================== أنماط الطباعة ==================== */
    @media print {
        * {
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
            color-adjust: exact !important;
        }

        body {
            background: white !important;
            color: #000 !important;
            font-size: 11px !important;
            line-height: 1.4 !important;
        }

        .sidebar,
        .main-header,
        .no-print,
        .breadcrumb {
            display: none !important;
        }

        .main-content {
            margin: 0 !important;
            padding: 10px !important;
            background: white !important;
        }

        .print-header,
        .print-footer {
            display: block !important;
        }

        .content-card,
        .stats-card {
            background: white !important;
            border: 1px solid #ddd !important;
            box-shadow: none !important;
            margin-bottom: 15px !important;
            padding: 10px !important;
            page-break-inside: avoid;
        }

        .section-title {
            color: #333 !important;
            border-bottom-color: #333 !important;
            font-size: 14px !important;
        }

        .sub-title {
            color: #666 !important;
        }

        .table {
            color: #000 !important;
            font-size: 10px !important;
        }

        .table th,
        .table td {
            color: #000 !important;
            border-color: #ccc !important;
            padding: 4px 6px !important;
        }

        .table-dark {
            background: #333 !important;
            color: white !important;
        }

        .table-dark th,
        .table-dark td {
            color: white !important;
        }

        h3, h4, h5, strong, .fw-bold {
            color: #000 !important;
        }

        .text-muted {
            color: #666 !important;
        }

        .text-success { color: #198754 !important; }
        .text-danger { color: #dc3545 !important; }
        .text-warning { color: #856404 !important; }
        .text-info { color: #0dcaf0 !important; }

        .badge {
            border: 1px solid #333 !important;
            padding: 2px 6px !important;
            font-size: 9px !important;
        }

        .progress {
            background: #eee !important;
            height: 6px !important;
        }

        .stat-box {
            border: 1px solid #ddd !important;
            background: #f8f9fa !important;
        }

        .stat-box h4 {
            color: #000 !important;
        }

        .stats-card h3 {
            color: #000 !important;
        }

        .row {
            display: flex !important;
            flex-wrap: wrap !important;
        }

        .col-lg-3 { width: 25% !important; }
        .col-lg-4 { width: 33.33% !important; }
        .col-lg-6 { width: 50% !important; }
        .col-lg-12 { width: 100% !important; }

        @page {
            size: A4;
            margin: 10mm;
        }

        .page-break {
            page-break-before: always;
        }
    }
</style>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/rasedbus/project-bus/resources/views/admin/reports.blade.php ENDPATH**/ ?>