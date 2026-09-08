@extends('layouts.admin')

@section('title', 'تفاصيل المركز - ' . $center->center_name)

@section('header')
<div class="d-flex justify-content-between align-items-center w-100">
    <div>
        <h2 class="mb-1">
            <i class="fas fa-school text-info me-2"></i>
            {{ $center->center_name }}
        </h2>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">لوحة التحكم</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.centers.index') }}">المراكز</a></li>
                <li class="breadcrumb-item active">{{ $center->center_name }}</li>
            </ol>
        </nav>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.centers.edit', $center) }}" class="btn btn-warning">
            <i class="fas fa-edit me-1"></i>
            تعديل
        </a>
        <a href="{{ route('admin.centers.index') }}" class="btn btn-outline-light">
            <i class="fas fa-arrow-right me-1"></i>
            العودة
        </a>
    </div>
</div>
@endsection

@section('content')
@php
    $studentsCount = \App\Models\Student::where('center_id', $center->id)->count();
    $busesCount = \App\Models\Bus::where('center_id', $center->id)->count();
    $driversCount = \App\Models\Driver::where('center_id', $center->id)->count();
    
    // فك تشفير مناطق التغطية
    $morningCoverage = is_string($center->morning_coverage_area) 
        ? json_decode($center->morning_coverage_area, true) 
        : $center->morning_coverage_area;
    $eveningCoverage = is_string($center->evening_coverage_area) 
        ? json_decode($center->evening_coverage_area, true) 
        : $center->evening_coverage_area;
@endphp

<div class="row">
    <!-- العمود الأيمن - معلومات المركز -->
    <div class="col-lg-4 mb-4">
        <div class="content-card text-center mb-4">
            <div class="center-avatar mb-3">
                <i class="fas fa-school"></i>
            </div>
            <h4 class="mb-1">{{ $center->center_name }}</h4>
            <p class="text-muted mb-3">{{ $center->address ?: 'العنوان غير محدد' }}</p>
            
            <span class="badge bg-{{ $center->status == 'active' ? 'success' : 'secondary' }} fs-6 px-3 py-2">
                {{ $center->status == 'active' ? 'نشط' : 'غير نشط' }}
            </span>
        </div>

        <!-- الإحصائيات -->
        <div class="content-card">
            <h5 class="mb-3">
                <i class="fas fa-chart-bar text-info me-2"></i>
                إحصائيات المركز
            </h5>
            <div class="row text-center">
                <div class="col-4 mb-3">
                    <h3 class="text-primary mb-0">{{ $studentsCount }}</h3>
                    <small class="text-muted">طالبة</small>
                </div>
                <div class="col-4 mb-3">
                    <h3 class="text-warning mb-0">{{ $busesCount }}</h3>
                    <small class="text-muted">باص</small>
                </div>
                <div class="col-4 mb-3">
                    <h3 class="text-success mb-0">{{ $driversCount }}</h3>
                    <small class="text-muted">سائق</small>
                </div>
            </div>
        </div>
    </div>

    <!-- العمود الأيسر - التفاصيل -->
    <div class="col-lg-8">
        <!-- أوقات العمل -->
        <div class="content-card mb-4">
            <h5 class="mb-3">
                <i class="fas fa-clock text-warning me-2"></i>
                أوقات العمل
            </h5>
            
            <div class="row">
                <!-- الفترة الصباحية -->
                <div class="col-md-6 mb-3">
                    <div class="schedule-card {{ $center->morning_available ? 'active' : 'inactive' }}">
                        <div class="schedule-header">
                            <i class="fas fa-sun text-warning me-2"></i>
                            <strong>الفترة الصباحية</strong>
                            @if($center->morning_available)
                                <span class="badge bg-success ms-auto">متاح</span>
                            @else
                                <span class="badge bg-secondary ms-auto">غير متاح</span>
                            @endif
                        </div>
                        @if($center->morning_available)
                        <div class="schedule-body">
                            <div class="time-range">
                                <span class="time-label">من</span>
                                <span class="time-value">{{ $center->morning_start ?? '08:00' }}</span>
                                <span class="time-label">إلى</span>
                                <span class="time-value">{{ $center->morning_end ?? '12:00' }}</span>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- الفترة المسائية -->
                <div class="col-md-6 mb-3">
                    <div class="schedule-card {{ $center->evening_available ? 'active' : 'inactive' }}">
                        <div class="schedule-header">
                            <i class="fas fa-moon text-info me-2"></i>
                            <strong>الفترة المسائية</strong>
                            @if($center->evening_available)
                                <span class="badge bg-success ms-auto">متاح</span>
                            @else
                                <span class="badge bg-secondary ms-auto">غير متاح</span>
                            @endif
                        </div>
                        @if($center->evening_available)
                        <div class="schedule-body">
                            <div class="time-range">
                                <span class="time-label">من</span>
                                <span class="time-value">{{ $center->evening_start ?? '16:00' }}</span>
                                <span class="time-label">إلى</span>
                                <span class="time-value">{{ $center->evening_end ?? '20:00' }}</span>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- نطاقات التغطية -->
        <div class="content-card mb-4">
            <h5 class="mb-3">
                <i class="fas fa-map-marked-alt text-success me-2"></i>
                نطاقات التغطية الجغرافية
            </h5>
            
            <div class="row">
                <!-- نطاق التغطية الصباحي -->
                <div class="col-md-6 mb-3">
                    <div class="coverage-card morning">
                        <h6 class="coverage-title">
                            <i class="fas fa-sun text-warning me-2"></i>
                            نطاق التغطية الصباحي
                        </h6>
                        @if($morningCoverage && count($morningCoverage) > 0)
                            <div class="coverage-info">
                                <span class="badge bg-success mb-2">
                                    <i class="fas fa-check me-1"></i>
                                    محدد ({{ count($morningCoverage) }} نقطة)
                                </span>
                                <div id="morningCoverageMap" class="coverage-map"></div>
                            </div>
                        @else
                            <div class="no-coverage">
                                <i class="fas fa-map-marker-slash text-muted"></i>
                                <p class="text-muted mb-0">لم يتم تحديد نطاق التغطية</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- نطاق التغطية المسائي -->
                <div class="col-md-6 mb-3">
                    <div class="coverage-card evening">
                        <h6 class="coverage-title">
                            <i class="fas fa-moon text-info me-2"></i>
                            نطاق التغطية المسائي
                        </h6>
                        @if($eveningCoverage && count($eveningCoverage) > 0)
                            <div class="coverage-info">
                                <span class="badge bg-success mb-2">
                                    <i class="fas fa-check me-1"></i>
                                    محدد ({{ count($eveningCoverage) }} نقطة)
                                </span>
                                <div id="eveningCoverageMap" class="coverage-map"></div>
                            </div>
                        @else
                            <div class="no-coverage">
                                <i class="fas fa-map-marker-slash text-muted"></i>
                                <p class="text-muted mb-0">لم يتم تحديد نطاق التغطية</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- خريطة شاملة -->
            @if(($morningCoverage && count($morningCoverage) > 0) || ($eveningCoverage && count($eveningCoverage) > 0))
            <div class="mt-4">
                <h6 class="mb-3">
                    <i class="fas fa-map text-primary me-2"></i>
                    الخريطة الشاملة
                </h6>
                <div id="fullCoverageMap" style="height: 400px; border-radius: 10px;"></div>
                <div class="map-legend mt-2">
                    <span class="legend-item">
                        <span class="legend-color" style="background: rgba(255, 193, 7, 0.3); border: 2px solid #ffc107;"></span>
                        نطاق صباحي
                    </span>
                    <span class="legend-item">
                        <span class="legend-color" style="background: rgba(23, 162, 184, 0.3); border: 2px solid #17a2b8;"></span>
                        نطاق مسائي
                    </span>
                </div>
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
                <div class="col-md-6 mb-3">
                    <div class="detail-item">
                        <span class="detail-label">تاريخ الإنشاء</span>
                        <span class="detail-value">{{ $center->created_at->format('Y/m/d H:i') }}</span>
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <div class="detail-item">
                        <span class="detail-label">آخر تحديث</span>
                        <span class="detail-value">{{ $center->updated_at->format('Y/m/d H:i') }}</span>
                    </div>
                </div>
                @if($center->notes)
                <div class="col-12">
                    <div class="detail-item">
                        <span class="detail-label">ملاحظات</span>
                        <span class="detail-value">{{ $center->notes }}</span>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<style>
.content-card {
    background: rgba(255,255,255,0.05);
    backdrop-filter: blur(10px);
    border-radius: 15px;
    padding: 1.5rem;
    border: 1px solid rgba(255,255,255,0.1);
}

.center-avatar {
    width: 100px;
    height: 100px;
    border-radius: 50%;
    background: linear-gradient(135deg, #17a2b8, #20c997);
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto;
    font-size: 3rem;
    color: white;
}

.schedule-card {
    background: rgba(255,255,255,0.05);
    border-radius: 10px;
    overflow: hidden;
    border: 1px solid rgba(255,255,255,0.1);
}

.schedule-card.active {
    border-color: rgba(40, 167, 69, 0.3);
}

.schedule-card.inactive {
    opacity: 0.6;
}

.schedule-header {
    display: flex;
    align-items: center;
    padding: 1rem;
    background: rgba(0,0,0,0.2);
}

.schedule-body {
    padding: 1rem;
}

.time-range {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
}

.time-label {
    color: rgba(255,255,255,0.6);
    font-size: 0.9rem;
}

.time-value {
    background: rgba(255,255,255,0.1);
    padding: 0.5rem 1rem;
    border-radius: 8px;
    font-weight: bold;
    font-size: 1.1rem;
}

.coverage-card {
    background: rgba(255,255,255,0.05);
    border-radius: 10px;
    padding: 1rem;
    border: 1px solid rgba(255,255,255,0.1);
    min-height: 200px;
}

.coverage-card.morning {
    border-color: rgba(255, 193, 7, 0.3);
}

.coverage-card.evening {
    border-color: rgba(23, 162, 184, 0.3);
}

.coverage-title {
    margin-bottom: 1rem;
    padding-bottom: 0.5rem;
    border-bottom: 1px solid rgba(255,255,255,0.1);
}

.coverage-map {
    height: 150px;
    border-radius: 8px;
    overflow: hidden;
}

.no-coverage {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    height: 120px;
}

.no-coverage i {
    font-size: 2rem;
    margin-bottom: 0.5rem;
}

.detail-item {
    background: rgba(255,255,255,0.05);
    border-radius: 8px;
    padding: 1rem;
}

.detail-label {
    display: block;
    color: rgba(255,255,255,0.6);
    font-size: 0.85rem;
    margin-bottom: 0.25rem;
}

.detail-value {
    color: #fff;
    font-weight: 500;
}

.map-legend {
    display: flex;
    gap: 1.5rem;
    justify-content: center;
}

.legend-item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: rgba(255,255,255,0.7);
    font-size: 0.9rem;
}

.legend-color {
    width: 20px;
    height: 20px;
    border-radius: 4px;
}
</style>
@endpush

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // إحداثيات مركز الزلفي
    const zulfiCenter = [26.297, 44.800];
    
    // بيانات نطاقات التغطية
    const morningCoverage = @json($morningCoverage ?? []);
    const eveningCoverage = @json($eveningCoverage ?? []);
    
    // إنشاء خريطة صغيرة للنطاق الصباحي
    if (morningCoverage && morningCoverage.length > 0) {
        const morningMap = L.map('morningCoverageMap').setView(zulfiCenter, 12);
        L.tileLayer('https://mt1.google.com/vt/lyrs=y&x={x}&y={y}&z={z}', {
            maxZoom: 20,
            attribution: '© Google Maps'
        }).addTo(morningMap);
        
        const morningCoords = morningCoverage.map(p => [p.lat, p.lng]);
        L.polygon(morningCoords, {
            color: '#ffc107',
            fillColor: '#ffc107',
            fillOpacity: 0.3,
            weight: 2
        }).addTo(morningMap);
        
        morningMap.fitBounds(morningCoords);
    }
    
    // إنشاء خريطة صغيرة للنطاق المسائي
    if (eveningCoverage && eveningCoverage.length > 0) {
        const eveningMap = L.map('eveningCoverageMap').setView(zulfiCenter, 12);
        L.tileLayer('https://mt1.google.com/vt/lyrs=y&x={x}&y={y}&z={z}', {
            maxZoom: 20,
            attribution: '© Google Maps'
        }).addTo(eveningMap);
        
        const eveningCoords = eveningCoverage.map(p => [p.lat, p.lng]);
        L.polygon(eveningCoords, {
            color: '#17a2b8',
            fillColor: '#17a2b8',
            fillOpacity: 0.3,
            weight: 2
        }).addTo(eveningMap);
        
        eveningMap.fitBounds(eveningCoords);
    }
    
    // إنشاء الخريطة الشاملة
    if ((morningCoverage && morningCoverage.length > 0) || (eveningCoverage && eveningCoverage.length > 0)) {
        const fullMap = L.map('fullCoverageMap').setView(zulfiCenter, 12);
        L.tileLayer('https://mt1.google.com/vt/lyrs=y&x={x}&y={y}&z={z}', {
            maxZoom: 20,
            attribution: '© Google Maps'
        }).addTo(fullMap);
        
        const allBounds = [];
        
        // إضافة النطاق الصباحي
        if (morningCoverage && morningCoverage.length > 0) {
            const morningCoords = morningCoverage.map(p => [p.lat, p.lng]);
            L.polygon(morningCoords, {
                color: '#ffc107',
                fillColor: '#ffc107',
                fillOpacity: 0.3,
                weight: 2
            }).addTo(fullMap).bindPopup('<strong>النطاق الصباحي</strong>');
            allBounds.push(...morningCoords);
        }
        
        // إضافة النطاق المسائي
        if (eveningCoverage && eveningCoverage.length > 0) {
            const eveningCoords = eveningCoverage.map(p => [p.lat, p.lng]);
            L.polygon(eveningCoords, {
                color: '#17a2b8',
                fillColor: '#17a2b8',
                fillOpacity: 0.3,
                weight: 2
            }).addTo(fullMap).bindPopup('<strong>النطاق المسائي</strong>');
            allBounds.push(...eveningCoords);
        }
        
        // إضافة علامة موقع المركز
        L.marker(zulfiCenter).addTo(fullMap)
            .bindPopup('<strong>{{ $center->center_name }}</strong>')
            .openPopup();
        
        if (allBounds.length > 0) {
            fullMap.fitBounds(allBounds, { padding: [20, 20] });
        }
    }
});
</script>
@endpush
