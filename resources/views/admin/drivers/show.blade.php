@extends('layouts.admin')

@section('title', 'تفاصيل السائق - ' . $driver->name)

@php
    // تحميل العلاقة إذا لم تكن محملة
    $buses = $driver->buses ?? collect([]);
    
    // حساب الإحصائيات داخلياً
    $stats = [
        'total_buses' => $buses->count(),
        'active_buses' => $buses->where('status', 'active')->count(),
        'has_active_bus' => $buses->where('status', 'active')->count() > 0,
        'years_of_service' => $driver->hire_date ? now()->diffInYears($driver->hire_date) : null
    ];
@endphp

@section('header')
<div class="d-flex justify-content-between align-items-center w-100">
    <div>
        <h2 class="mb-1">
            <i class="fas fa-id-card text-warning me-2"></i>
            تفاصيل السائق
        </h2>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">لوحة التحكم</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.drivers.index') }}">السائقين</a></li>
                <li class="breadcrumb-item active">{{ $driver->name }}</li>
            </ol>
        </nav>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.drivers.edit', $driver) }}" class="btn btn-warning">
            <i class="fas fa-edit me-1"></i>
            تعديل
        </a>
        <a href="{{ route('admin.drivers.index') }}" class="btn btn-outline-light">
            <i class="fas fa-arrow-right me-1"></i>
            العودة
        </a>
    </div>
</div>
@endsection

@section('content')
<div class="row">
    <!-- بطاقة السائق -->
    <div class="col-lg-4">
        <div class="content-card mb-4">
            <div class="text-center mb-4">
                <div class="driver-avatar-large mx-auto mb-3">
                    <i class="fas fa-user"></i>
                </div>
                <h3 class="text-light mb-1">{{ $driver->name }}</h3>
                <p class="text-muted mb-2">{{ $driver->driver_id ?? 'DRV-' . str_pad($driver->id, 4, '0', STR_PAD_LEFT) }}</p>
                
                <span class="badge bg-{{ $driver->status_color }} px-3 py-2">
                    <i class="fas fa-{{ $driver->status === 'active' ? 'check-circle' : ($driver->status === 'on_leave' ? 'clock' : 'times-circle') }} me-1"></i>
                    {{ $driver->status_name }}
                </span>
            </div>

            <hr class="border-secondary">

            <div class="info-list">
                <div class="info-item">
                    <span class="info-label"><i class="fas fa-phone me-2"></i>الجوال</span>
                    <span class="info-value">
                        <a href="tel:{{ $driver->mobile }}" class="text-info">{{ $driver->mobile }}</a>
                    </span>
                </div>
                @if($driver->email)
                <div class="info-item">
                    <span class="info-label"><i class="fas fa-envelope me-2"></i>البريد</span>
                    <span class="info-value">
                        <a href="mailto:{{ $driver->email }}" class="text-info">{{ $driver->email }}</a>
                    </span>
                </div>
                @endif
                @if($driver->address)
                <div class="info-item">
                    <span class="info-label"><i class="fas fa-map-marker-alt me-2"></i>العنوان</span>
                    <span class="info-value">{{ $driver->address }}</span>
                </div>
                @endif
                <div class="info-item">
                    <span class="info-label"><i class="fas fa-id-card me-2"></i>رقم الرخصة</span>
                    <span class="info-value"><code class="text-warning">{{ $driver->license_number }}</code></span>
                </div>
                @if($driver->license_type)
                <div class="info-item">
                    <span class="info-label"><i class="fas fa-car me-2"></i>نوع الرخصة</span>
                    <span class="info-value">{{ $driver->license_type }}</span>
                </div>
                @endif
                @if($driver->experience_years)
                <div class="info-item">
                    <span class="info-label"><i class="fas fa-star me-2"></i>الخبرة</span>
                    <span class="info-value">{{ $driver->experience_years }} سنة</span>
                </div>
                @endif
                @if($driver->center_id)
                <div class="info-item">
                    <span class="info-label"><i class="fas fa-school me-2"></i>المركز</span>
                    <span class="info-value">
                        <span class="badge bg-info">{{ $driver->center_name }}</span>
                    </span>
                </div>
                @endif
            </div>
        </div>

        <!-- جهة اتصال الطوارئ -->
        @if($driver->emergency_contact || $driver->emergency_phone)
        <div class="content-card mb-4">
            <h5 class="mb-3">
                <i class="fas fa-phone-alt text-danger me-2"></i>
                جهة اتصال الطوارئ
            </h5>
            <div class="info-list">
                @if($driver->emergency_contact)
                <div class="info-item">
                    <span class="info-label">الاسم</span>
                    <span class="info-value">{{ $driver->emergency_contact }}</span>
                </div>
                @endif
                @if($driver->emergency_phone)
                <div class="info-item">
                    <span class="info-label">الرقم</span>
                    <span class="info-value">
                        <a href="tel:{{ $driver->emergency_phone }}" class="text-danger">
                            {{ $driver->emergency_phone }}
                        </a>
                    </span>
                </div>
                @endif
            </div>
        </div>
        @endif

        <!-- الإحصائيات -->
        <div class="content-card">
            <h5 class="mb-3">
                <i class="fas fa-chart-bar text-info me-2"></i>
                إحصائيات
            </h5>
            <div class="row text-center">
                <div class="col-6 mb-3">
                    <h3 class="text-primary mb-0">{{ $stats['total_buses'] }}</h3>
                    <small class="text-muted">إجمالي الباصات</small>
                </div>
                <div class="col-6 mb-3">
                    <h3 class="text-success mb-0">{{ $stats['active_buses'] }}</h3>
                    <small class="text-muted">الباصات النشطة</small>
                </div>
                @if($stats['years_of_service'])
                <div class="col-12">
                    <h3 class="text-info mb-0">{{ $stats['years_of_service'] }}</h3>
                    <small class="text-muted">سنوات الخدمة</small>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- الباصات -->
    <div class="col-lg-8">
        <div class="content-card mb-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="mb-0">
                    <i class="fas fa-bus text-info me-2"></i>
                    الباصات المخصصة
                    <span class="badge bg-info ms-2">{{ $buses->count() }}</span>
                </h5>
            </div>

            @if($buses->count() > 0)
                <div class="table-responsive">
                    <table class="table table-dark table-hover align-middle">
                        <thead>
                            <tr>
                                <th>رقم الباص</th>
                                <th>اللوحة</th>
                                <th>المركز</th>
                                <th>الإشغال</th>
                                <th>الحالة</th>
                                <th>إجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($buses as $bus)
                                <tr>
                                    <td>
                                        <strong class="text-primary">{{ $bus->number }}</strong>
                                    </td>
                                    <td>{{ $bus->plate_number }}</td>
                                    <td>
                                        <span class="badge bg-secondary">{{ $bus->center_id }}</span>
                                    </td>
                                    <td>
                                        @php
                                            $occupancy = $bus->capacity > 0 ? ($bus->current_students / $bus->capacity * 100) : 0;
                                            $color = $occupancy > 80 ? 'danger' : ($occupancy > 50 ? 'warning' : 'success');
                                        @endphp
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="progress flex-grow-1" style="height: 8px; width: 80px;">
                                                <div class="progress-bar bg-{{ $color }}" style="width: {{ $occupancy }}%"></div>
                                            </div>
                                            <small>{{ $bus->current_students }}/{{ $bus->capacity }}</small>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $bus->status_color }}">
                                            {{ $bus->status_text }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.buses.show', $bus) }}" class="btn btn-sm btn-outline-info">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-bus fa-3x text-muted opacity-50 mb-3"></i>
                    <p class="text-muted">لا توجد باصات مخصصة لهذا السائق</p>
                </div>
            @endif
        </div>

        <!-- معلومات إضافية -->
        <div class="content-card">
            <h5 class="mb-3">
                <i class="fas fa-info-circle text-info me-2"></i>
                معلومات إضافية
            </h5>
            
            <div class="row">
                @if($driver->hire_date)
                <div class="col-md-6 mb-3">
                    <label class="text-muted small">تاريخ التوظيف</label>
                    <p class="mb-0">{{ $driver->hire_date->format('Y/m/d') }}</p>
                </div>
                @endif
                
                @if($driver->salary)
                <div class="col-md-6 mb-3">
                    <label class="text-muted small">الراتب</label>
                    <p class="mb-0 text-success">{{ number_format($driver->salary, 2) }} ريال</p>
                </div>
                @endif
                
                <div class="col-md-6 mb-3">
                    <label class="text-muted small">تاريخ الإضافة</label>
                    <p class="mb-0">{{ $driver->created_at->format('Y/m/d H:i') }}</p>
                </div>
                
                <div class="col-md-6 mb-3">
                    <label class="text-muted small">آخر تحديث</label>
                    <p class="mb-0">{{ $driver->updated_at->format('Y/m/d H:i') }}</p>
                </div>

                @if($driver->notes)
                <div class="col-12">
                    <label class="text-muted small">ملاحظات</label>
                    <p class="mb-0">{{ $driver->notes }}</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.content-card {
    background: rgba(255,255,255,0.05);
    backdrop-filter: blur(10px);
    border-radius: 15px;
    padding: 1.5rem;
    border: 1px solid rgba(255,255,255,0.1);
}

.driver-avatar-large {
    width: 100px;
    height: 100px;
    background: linear-gradient(135deg, #ffc107 0%, #cc9a06 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2.5rem;
    color: #000;
    box-shadow: 0 10px 30px rgba(255, 193, 7, 0.3);
}

.info-list .info-item {
    display: flex;
    justify-content: space-between;
    padding: 0.75rem 0;
    border-bottom: 1px solid rgba(255,255,255,0.1);
}

.info-list .info-item:last-child {
    border-bottom: none;
}

.info-label {
    color: rgba(255,255,255,0.6);
}

.info-value {
    color: #fff;
    font-weight: 500;
}
</style>
@endpush