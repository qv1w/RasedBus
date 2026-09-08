@extends('layouts.admin')

@section('title', 'عرض التقرير - ' . $report->report_number)

@section('header')
<div class="d-flex justify-content-between align-items-center w-100 no-print">
    <div>
        <h2 class="mb-1">
            <i class="fas fa-file-alt me-2"></i>
            {{ $report->title }}
        </h2>
        <p class="text-light opacity-75 mb-0">
            رقم التقرير: {{ $report->report_number }} | 
            تاريخ الإنشاء: {{ $report->created_at->format('Y-m-d H:i') }}
        </p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.reports.archive') }}" class="btn btn-outline-light">
            <i class="fas fa-arrow-right me-1"></i> الأرشيف
        </a>
        <button onclick="window.print()" class="btn btn-light">
            <i class="fas fa-print me-1"></i> طباعة
        </button>
    </div>
</div>
@endsection

@section('content')
<div id="report-container">

    <!-- معلومات التقرير المؤرشف -->
    <div class="alert alert-info no-print mb-4">
        <div class="d-flex align-items-center">
            <i class="fas fa-info-circle fa-2x me-3"></i>
            <div>
                <strong>تقرير مؤرشف</strong><br>
                <small>
                    تم إنشاء هذا التقرير بتاريخ <strong>{{ $generatedAt }}</strong>
                    @if($report->notes)
                    | ملاحظات: {{ $report->notes }}
                    @endif
                </small>
            </div>
        </div>
    </div>

    <!-- ===== رأس التقرير للطباعة ===== -->
    <div class="print-header-section">
        <h1>نظام النقل التعليمي</h1>
        <h2>جمعية تحفيظ القرآن الكريم بالزلفي</h2>
        <div class="print-date">
            <span>{{ $report->title }}</span>
            <span>رقم: {{ $report->report_number }}</span>
            <span>تاريخ الإنشاء: {{ $generatedAt }}</span>
        </div>
    </div>

    <!-- ===== البطاقات الرئيسية ===== -->
    <div class="main-stats-grid">
        <div class="main-stat-card blue">
            <div class="stat-icon"><i class="fas fa-user-graduate"></i></div>
            <div class="stat-info">
                <span class="stat-number">{{ number_format($studentStats['total']) }}</span>
                <span class="stat-label">إجمالي الطلاب</span>
            </div>
        </div>
        <div class="main-stat-card orange">
            <div class="stat-icon"><i class="fas fa-bus"></i></div>
            <div class="stat-info">
                <span class="stat-number">{{ number_format($busStats['total']) }}</span>
                <span class="stat-label">إجمالي الباصات</span>
            </div>
        </div>
        <div class="main-stat-card purple">
            <div class="stat-icon"><i class="fas fa-id-card"></i></div>
            <div class="stat-info">
                <span class="stat-number">{{ number_format($driverStats['total']) }}</span>
                <span class="stat-label">إجمالي السائقين</span>
            </div>
        </div>
        <div class="main-stat-card green">
            <div class="stat-icon"><i class="fas fa-money-bill-wave"></i></div>
            <div class="stat-info">
                <span class="stat-number">{{ number_format($paymentStats['total_paid']) }}</span>
                <span class="stat-label">المحصّل (ر.س)</span>
            </div>
        </div>
    </div>

    <!-- ===== قسم الطلاب ===== -->
    <div class="report-card">
        <div class="card-header blue">
            <i class="fas fa-user-graduate"></i>
            <span>إحصائيات الطلاب</span>
        </div>
        <div class="card-body">
            <div class="stats-grid-3">
                <div class="stat-group">
                    <h4><i class="fas fa-clipboard-list"></i> حسب الحالة</h4>
                    <table class="data-table">
                        <tbody>
                            <tr>
                                <td><span class="badge green">مقبول</span></td>
                                <td class="number">{{ number_format($studentStats['approved']) }}</td>
                                <td class="percent">{{ $studentStats['total'] > 0 ? round($studentStats['approved'] / $studentStats['total'] * 100) : 0 }}%</td>
                            </tr>
                            <tr>
                                <td><span class="badge yellow">قيد المراجعة</span></td>
                                <td class="number">{{ number_format($studentStats['pending']) }}</td>
                                <td class="percent">{{ $studentStats['total'] > 0 ? round($studentStats['pending'] / $studentStats['total'] * 100) : 0 }}%</td>
                            </tr>
                            <tr>
                                <td><span class="badge red">مرفوض</span></td>
                                <td class="number">{{ number_format($studentStats['rejected']) }}</td>
                                <td class="percent">{{ $studentStats['total'] > 0 ? round($studentStats['rejected'] / $studentStats['total'] * 100) : 0 }}%</td>
                            </tr>
                            <tr>
                                <td><span class="badge gray">معلق</span></td>
                                <td class="number">{{ number_format($studentStats['suspended']) }}</td>
                                <td class="percent">{{ $studentStats['total'] > 0 ? round($studentStats['suspended'] / $studentStats['total'] * 100) : 0 }}%</td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td><strong>الإجمالي</strong></td>
                                <td class="number"><strong>{{ number_format($studentStats['total']) }}</strong></td>
                                <td class="percent"><strong>100%</strong></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <div class="stat-group">
                    <h4><i class="fas fa-venus-mars"></i> حسب الجنس</h4>
                    <table class="data-table">
                        <tbody>
                            <tr>
                                <td><i class="fas fa-male" style="color:#2196F3"></i> ذكور</td>
                                <td class="number">{{ number_format($studentStats['male']) }}</td>
                            </tr>
                            <tr>
                                <td><i class="fas fa-female" style="color:#E91E63"></i> إناث</td>
                                <td class="number">{{ number_format($studentStats['female']) }}</td>
                            </tr>
                        </tbody>
                    </table>

                    <h4 style="margin-top:20px"><i class="fas fa-clock"></i> حسب الفترة</h4>
                    <table class="data-table">
                        <tbody>
                            <tr>
                                <td><i class="fas fa-sun" style="color:#FF9800"></i> صباحية</td>
                                <td class="number">{{ number_format($studentStats['morning']) }}</td>
                            </tr>
                            <tr>
                                <td><i class="fas fa-moon" style="color:#3F51B5"></i> مسائية</td>
                                <td class="number">{{ number_format($studentStats['evening']) }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="stat-group">
                    <h4><i class="fas fa-building"></i> حسب نوع الجهة</h4>
                    <table class="data-table">
                        <tbody>
                            <tr>
                                <td><i class="fas fa-mosque" style="color:#C62828"></i> الدور</td>
                                <td class="number">{{ number_format($studentStats['dour']) }}</td>
                            </tr>
                            <tr>
                                <td><i class="fas fa-graduation-cap" style="color:#F9A825"></i> المركز</td>
                                <td class="number">{{ number_format($studentStats['markaz']) }}</td>
                            </tr>
                            <tr>
                                <td><i class="fas fa-seedling" style="color:#2E7D32"></i> الرياحين</td>
                                <td class="number">{{ number_format($studentStats['riyaheen']) }}</td>
                            </tr>
                        </tbody>
                    </table>

                    <h4 style="margin-top:20px"><i class="fas fa-bus"></i> تخصيص الباص</h4>
                    <table class="data-table">
                        <tbody>
                            <tr>
                                <td class="text-success">✓ لديهم باص</td>
                                <td class="number">{{ number_format($studentStats['with_bus']) }}</td>
                            </tr>
                            <tr>
                                <td class="text-danger">✗ بدون باص</td>
                                <td class="number">{{ number_format($studentStats['without_bus']) }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- ===== قسم الباصات ===== -->
    <div class="report-card">
        <div class="card-header orange">
            <i class="fas fa-bus"></i>
            <span>إحصائيات الباصات</span>
        </div>
        <div class="card-body">
            <div class="stats-grid-3">
                <div class="stat-group">
                    <h4><i class="fas fa-toggle-on"></i> حسب الحالة</h4>
                    <table class="data-table">
                        <tbody>
                            <tr>
                                <td><span class="badge green">نشط</span></td>
                                <td class="number">{{ $busStats['active'] }}</td>
                            </tr>
                            <tr>
                                <td><span class="badge yellow">صيانة</span></td>
                                <td class="number">{{ $busStats['maintenance'] }}</td>
                            </tr>
                            <tr>
                                <td><span class="badge red">متوقف</span></td>
                                <td class="number">{{ $busStats['inactive'] }}</td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td><strong>الإجمالي</strong></td>
                                <td class="number"><strong>{{ $busStats['total'] }}</strong></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <div class="stat-group">
                    <h4><i class="fas fa-chair"></i> السعة والإشغال</h4>
                    <table class="data-table">
                        <tbody>
                            <tr>
                                <td>إجمالي المقاعد</td>
                                <td class="number">{{ number_format($busStats['total_capacity']) }}</td>
                            </tr>
                            <tr>
                                <td>المقاعد المشغولة</td>
                                <td class="number text-success">{{ number_format($busStats['occupied_seats']) }}</td>
                            </tr>
                            <tr>
                                <td>المقاعد المتاحة</td>
                                <td class="number text-info">{{ number_format($busStats['available_seats']) }}</td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td><strong>نسبة الإشغال</strong></td>
                                <td class="number"><strong>{{ $busStats['occupancy_rate'] }}%</strong></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <div class="stat-group">
                    <h4><i class="fas fa-user-tie"></i> السائقين</h4>
                    <table class="data-table">
                        <tbody>
                            <tr>
                                <td class="text-success">✓ مع سائق</td>
                                <td class="number">{{ $busStats['with_driver'] }}</td>
                            </tr>
                            <tr>
                                <td class="text-danger">✗ بدون سائق</td>
                                <td class="number">{{ $busStats['without_driver'] }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- ===== قسم السائقين ===== -->
    <div class="report-card">
        <div class="card-header purple">
            <i class="fas fa-id-card"></i>
            <span>إحصائيات السائقين</span>
        </div>
        <div class="card-body">
            <div class="stats-grid-3">
                <div class="stat-group">
                    <h4><i class="fas fa-toggle-on"></i> حسب الحالة</h4>
                    <table class="data-table">
                        <tbody>
                            <tr>
                                <td><span class="badge green">نشط</span></td>
                                <td class="number">{{ $driverStats['active'] }}</td>
                            </tr>
                            <tr>
                                <td><span class="badge yellow">إجازة</span></td>
                                <td class="number">{{ $driverStats['on_leave'] }}</td>
                            </tr>
                            <tr>
                                <td><span class="badge red">غير نشط</span></td>
                                <td class="number">{{ $driverStats['inactive'] }}</td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td><strong>الإجمالي</strong></td>
                                <td class="number"><strong>{{ $driverStats['total'] }}</strong></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <div class="stat-group">
                    <h4><i class="fas fa-tasks"></i> التخصيص</h4>
                    <table class="data-table">
                        <tbody>
                            <tr>
                                <td class="text-success">✓ مخصص لباص</td>
                                <td class="number">{{ $driverStats['with_bus'] }}</td>
                            </tr>
                            <tr>
                                <td class="text-info">○ متاح</td>
                                <td class="number">{{ $driverStats['without_bus'] }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="stat-group">
                    <h4><i class="fas fa-calculator"></i> المالية والخبرة</h4>
                    <table class="data-table">
                        <tbody>
                            <tr>
                                <td>إجمالي الرواتب</td>
                                <td class="number">{{ number_format($driverStats['total_salary']) }} ر.س</td>
                            </tr>
                            <tr>
                                <td>متوسط الخبرة</td>
                                <td class="number">{{ $driverStats['avg_experience'] }} سنة</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- ===== قسم المدفوعات ===== -->
    <div class="report-card">
        <div class="card-header green">
            <i class="fas fa-money-bill-wave"></i>
            <span>إحصائيات المدفوعات</span>
        </div>
        <div class="card-body">
            <div class="stats-grid-2">
                <div class="stat-group">
                    <h4><i class="fas fa-coins"></i> ملخص المبالغ</h4>
                    <table class="data-table highlight">
                        <tbody>
                            <tr>
                                <td>إجمالي المبالغ المطلوبة</td>
                                <td class="number"><strong>{{ number_format($paymentStats['total_required'], 2) }}</strong> ر.س</td>
                            </tr>
                            <tr class="row-success">
                                <td>إجمالي المبالغ المحصّلة</td>
                                <td class="number"><strong>{{ number_format($paymentStats['total_paid'], 2) }}</strong> ر.س</td>
                            </tr>
                            <tr class="row-warning">
                                <td>مبالغ قيد المراجعة</td>
                                <td class="number"><strong>{{ number_format($paymentStats['total_pending'], 2) }}</strong> ر.س</td>
                            </tr>
                            <tr class="row-danger">
                                <td>المبالغ المتبقية</td>
                                <td class="number"><strong>{{ number_format($paymentStats['total_remaining'], 2) }}</strong> ر.س</td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td><strong>نسبة التحصيل</strong></td>
                                <td class="number"><strong class="text-success">{{ $paymentStats['collection_rate'] }}%</strong></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <div class="stat-group">
                    <h4><i class="fas fa-receipt"></i> عدد الدفعات</h4>
                    <table class="data-table">
                        <tbody>
                            <tr>
                                <td><span class="badge green">مقبولة</span></td>
                                <td class="number">{{ number_format($paymentStats['approved_payments']) }}</td>
                            </tr>
                            <tr>
                                <td><span class="badge yellow">قيد المراجعة</span></td>
                                <td class="number">{{ number_format($paymentStats['pending_payments']) }}</td>
                            </tr>
                            <tr>
                                <td><span class="badge blue">بانتظار الإيصال</span></td>
                                <td class="number">{{ number_format($paymentStats['awaiting_receipt']) }}</td>
                            </tr>
                            <tr>
                                <td><span class="badge red">مرفوضة</span></td>
                                <td class="number">{{ number_format($paymentStats['rejected_payments']) }}</td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td><strong>إجمالي الدفعات</strong></td>
                                <td class="number"><strong>{{ number_format($paymentStats['total_payments']) }}</strong></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- ===== تفاصيل الجهات ===== -->
    <div class="report-card">
        <div class="card-header teal">
            <i class="fas fa-school"></i>
            <span>تفاصيل الجهات</span>
        </div>
        <div class="card-body">
            <table class="full-table">
                <thead>
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
                    </tr>
                </thead>
                <tbody>
                    @foreach($centersDetails as $center)
                    <tr>
                        <td class="name">{{ $center['name'] }}</td>
                        <td>
                            @if($center['type'] == 'دار')
                                <span class="badge red">دار</span>
                            @elseif($center['type'] == 'مركز')
                                <span class="badge yellow">مركز</span>
                            @else
                                <span class="badge green">برنامج</span>
                            @endif
                        </td>
                        <td>{{ $center['gender'] }}</td>
                        <td class="number"><strong>{{ $center['students_count'] }}</strong></td>
                        <td class="number text-success">{{ $center['approved_students'] }}</td>
                        <td class="number text-warning">{{ $center['pending_students'] }}</td>
                        <td class="number">{{ $center['morning_students'] }}</td>
                        <td class="number">{{ $center['evening_students'] }}</td>
                        <td class="number">{{ $center['buses_count'] }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- ===== المدفوعات حسب الجهة ===== -->
    <div class="report-card page-break">
        <div class="card-header green">
            <i class="fas fa-file-invoice-dollar"></i>
            <span>المدفوعات حسب الجهة</span>
        </div>
        <div class="card-body">
            <table class="full-table">
                <thead>
                    <tr>
                        <th>الجهة</th>
                        <th>النوع</th>
                        <th>الطلاب</th>
                        <th>المطلوب</th>
                        <th>المحصّل</th>
                        <th>المتبقي</th>
                        <th>نسبة التحصيل</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($paymentsByCenter as $center)
                    <tr>
                        <td class="name">{{ $center['name'] }}</td>
                        <td>
                            @if($center['type'] == 'دار')
                                <span class="badge red">دار</span>
                            @elseif($center['type'] == 'مركز')
                                <span class="badge yellow">مركز</span>
                            @else
                                <span class="badge green">برنامج</span>
                            @endif
                        </td>
                        <td class="number">{{ $center['students_count'] }}</td>
                        <td class="number">{{ number_format($center['total_required'], 2) }}</td>
                        <td class="number text-success">{{ number_format($center['total_paid'], 2) }}</td>
                        <td class="number text-danger">{{ number_format($center['total_remaining'], 2) }}</td>
                        <td class="number"><strong>{{ $center['collection_rate'] }}%</strong></td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="2"><strong>الإجمالي</strong></td>
                        <td class="number"><strong>{{ $paymentsByCenter->sum('students_count') }}</strong></td>
                        <td class="number"><strong>{{ number_format($paymentsByCenter->sum('total_required'), 2) }}</strong></td>
                        <td class="number text-success"><strong>{{ number_format($paymentsByCenter->sum('total_paid'), 2) }}</strong></td>
                        <td class="number text-danger"><strong>{{ number_format($paymentsByCenter->sum('total_remaining'), 2) }}</strong></td>
                        <td class="number"><strong>{{ $paymentStats['collection_rate'] }}%</strong></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    <!-- ===== تفاصيل الباصات ===== -->
    <div class="report-card">
        <div class="card-header orange">
            <i class="fas fa-bus"></i>
            <span>تفاصيل الباصات</span>
        </div>
        <div class="card-body">
            <table class="full-table compact">
                <thead>
                    <tr>
                        <th>الرقم</th>
                        <th>اللوحة</th>
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
                    @foreach($busesDetails as $bus)
                    <tr>
                        <td><strong>{{ $bus['number'] }}</strong></td>
                        <td>{{ $bus['plate_number'] }}</td>
                        <td>{{ $bus['driver_name'] }}</td>
                        <td>{{ $bus['center_name'] }}</td>
                        <td class="number">{{ $bus['capacity'] }}</td>
                        <td class="number text-success">{{ $bus['current_students'] }}</td>
                        <td class="number text-info">{{ $bus['available_seats'] }}</td>
                        <td class="number">{{ $bus['occupancy_rate'] }}%</td>
                        <td>
                            @if($bus['status'] == 'active')
                                <span class="badge green">نشط</span>
                            @elseif($bus['status'] == 'maintenance')
                                <span class="badge yellow">صيانة</span>
                            @else
                                <span class="badge red">متوقف</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- ===== تفاصيل السائقين ===== -->
    <div class="report-card">
        <div class="card-header purple">
            <i class="fas fa-id-card"></i>
            <span>تفاصيل السائقين</span>
        </div>
        <div class="card-body">
            <table class="full-table compact">
                <thead>
                    <tr>
                        <th>الاسم</th>
                        <th>الجوال</th>
                        <th>الرخصة</th>
                        <th>الخبرة</th>
                        <th>الجهة</th>
                        <th>الباص</th>
                        <th>الراتب</th>
                        <th>الحالة</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($driversDetails as $driver)
                    <tr>
                        <td class="name">{{ $driver['name'] }}</td>
                        <td>{{ $driver['mobile'] }}</td>
                        <td>{{ $driver['license_number'] }}</td>
                        <td class="number">{{ $driver['experience_years'] }} سنة</td>
                        <td>{{ $driver['center_name'] }}</td>
                        <td>{{ $driver['bus_number'] }}</td>
                        <td class="number">{{ number_format($driver['salary']) }}</td>
                        <td>
                            @if($driver['status'] == 'active')
                                <span class="badge green">نشط</span>
                            @elseif($driver['status'] == 'on_leave')
                                <span class="badge yellow">إجازة</span>
                            @else
                                <span class="badge red">غير نشط</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- ===== المشرفين ===== -->
    <div class="report-card">
        <div class="card-header red">
            <i class="fas fa-user-shield"></i>
            <span>إحصائيات المشرفين</span>
        </div>
        <div class="card-body">
            <div class="stats-grid-2">
                <div class="stat-group">
                    <h4><i class="fas fa-users-cog"></i> حسب الصلاحية</h4>
                    <table class="data-table">
                        <tbody>
                            <tr>
                                <td><i class="fas fa-crown" style="color:#FFD700"></i> مدير عام</td>
                                <td class="number">{{ $adminStats['super_admin'] }}</td>
                            </tr>
                            <tr>
                                <td><i class="fas fa-user-shield" style="color:#2196F3"></i> مشرف</td>
                                <td class="number">{{ $adminStats['admin'] }}</td>
                            </tr>
                            <tr>
                                <td><i class="fas fa-calculator" style="color:#4CAF50"></i> محاسب</td>
                                <td class="number">{{ $adminStats['accountant'] }}</td>
                            </tr>
                            <tr>
                                <td><i class="fas fa-eye" style="color:#00BCD4"></i> مراقب</td>
                                <td class="number">{{ $adminStats['supervisor'] }}</td>
                            </tr>
                            <tr>
                                <td><i class="fas fa-keyboard" style="color:#9E9E9E"></i> مدخل بيانات</td>
                                <td class="number">{{ $adminStats['data_entry'] }}</td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td><strong>الإجمالي</strong></td>
                                <td class="number"><strong>{{ $adminStats['total'] }}</strong></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <div class="stat-group">
                    <h4><i class="fas fa-history"></i> النشاط (وقت إنشاء التقرير)</h4>
                    <table class="data-table">
                        <tbody>
                            <tr>
                                <td>إجمالي الأنشطة</td>
                                <td class="number">{{ number_format($adminStats['total_activities']) }}</td>
                            </tr>
                            <tr>
                                <td>أنشطة ذلك اليوم</td>
                                <td class="number">{{ number_format($adminStats['today_activities']) }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- ===== آخر التسجيلات ===== -->
    <div class="report-card">
        <div class="card-header blue">
            <i class="fas fa-user-plus"></i>
            <span>آخر 10 تسجيلات (وقت إنشاء التقرير)</span>
        </div>
        <div class="card-body">
            <table class="full-table compact">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>رقم الطالب</th>
                        <th>الاسم</th>
                        <th>الجنس</th>
                        <th>الجهة</th>
                        <th>الحالة</th>
                        <th>تاريخ التسجيل</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recentStudents as $index => $student)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $student['student_id'] }}</td>
                        <td class="name">{{ $student['name'] }}</td>
                        <td>{{ $student['gender'] }}</td>
                        <td>{{ $student['center_name'] }}</td>
                        <td>
                            @if($student['status'] == 'approved')
                                <span class="badge green">مقبول</span>
                            @elseif($student['status'] == 'pending')
                                <span class="badge yellow">معلق</span>
                            @elseif($student['status'] == 'rejected')
                                <span class="badge red">مرفوض</span>
                            @else
                                <span class="badge gray">موقوف</span>
                            @endif
                        </td>
                        <td>{{ $student['created_at'] }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- ===== آخر الدفعات ===== -->
    <div class="report-card">
        <div class="card-header green">
            <i class="fas fa-money-check"></i>
            <span>آخر 10 دفعات (وقت إنشاء التقرير)</span>
        </div>
        <div class="card-body">
            <table class="full-table compact">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>رقم الدفعة</th>
                        <th>الطالب</th>
                        <th>المبلغ</th>
                        <th>طريقة الدفع</th>
                        <th>الحالة</th>
                        <th>التاريخ</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recentPayments as $index => $payment)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $payment['payment_number'] }}</td>
                        <td class="name">{{ $payment['student_name'] }}</td>
                        <td class="number">{{ number_format($payment['amount'], 2) }} ر.س</td>
                        <td>{{ $payment['payment_method'] }}</td>
                        <td>
                            @if($payment['status'] == 'approved')
                                <span class="badge green">مقبول</span>
                            @elseif($payment['status'] == 'pending')
                                <span class="badge yellow">معلق</span>
                            @elseif($payment['status'] == 'awaiting_receipt')
                                <span class="badge blue">بانتظار</span>
                            @else
                                <span class="badge red">مرفوض</span>
                            @endif
                        </td>
                        <td>{{ $payment['created_at'] }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- ===== ذيل التقرير ===== -->
    <div class="report-footer">
        <p>تقرير مؤرشف رقم: <strong>{{ $report->report_number }}</strong></p>
        <p>تاريخ البيانات: <strong>{{ $generatedAt }}</strong></p>
        <p>نظام النقل التعليمي - جمعية تحفيظ القرآن الكريم بالزلفي</p>
    </div>

</div>
@endsection

@push('styles')
@include('admin.reports.partials.styles')
@endpush
