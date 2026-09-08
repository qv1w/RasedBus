@extends('layouts.admin')

@section('title', 'إحصائيات ' . $center->center_name)

@section('header')
<div class="d-flex justify-content-between align-items-center w-100">
    <div>
        <h2 class="mb-1">
            <i class="fas fa-chart-bar text-info me-2"></i>
            إحصائيات {{ $center->center_name }}
        </h2>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('admin.centers.index') }}">المراكز</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.centers.show', $center) }}">{{ $center->center_name }}</a></li>
                <li class="breadcrumb-item active">الإحصائيات</li>
            </ol>
        </nav>
    </div>
    <a href="{{ route('admin.centers.show', $center) }}" class="btn btn-outline-light">
        <i class="fas fa-arrow-right me-1"></i>
        العودة
    </a>
</div>
@endsection

@section('content')
<!-- إحصائيات الطالبات -->
<div class="row mb-4">
    <div class="col-12">
        <h5 class="text-info mb-3">
            <i class="fas fa-users me-2"></i>
            إحصائيات الطالبات
        </h5>
    </div>
    
    <div class="col-md-3 mb-3">
        <div class="stats-card text-center">
            <i class="fas fa-users fa-2x text-primary mb-2"></i>
            <h3 class="mb-0">{{ $stats['total_students'] }}</h3>
            <small class="text-muted">إجمالي الطالبات</small>
        </div>
    </div>
    
    <div class="col-md-3 mb-3">
        <div class="stats-card text-center">
            <i class="fas fa-check-circle fa-2x text-success mb-2"></i>
            <h3 class="mb-0">{{ $stats['approved_students'] }}</h3>
            <small class="text-muted">المقبولات</small>
        </div>
    </div>
    
    <div class="col-md-3 mb-3">
        <div class="stats-card text-center">
            <i class="fas fa-clock fa-2x text-warning mb-2"></i>
            <h3 class="mb-0">{{ $stats['pending_students'] }}</h3>
            <small class="text-muted">قيد المراجعة</small>
        </div>
    </div>
    
    <div class="col-md-3 mb-3">
        <div class="stats-card text-center">
            <i class="fas fa-times-circle fa-2x text-danger mb-2"></i>
            <h3 class="mb-0">{{ $stats['rejected_students'] }}</h3>
            <small class="text-muted">المرفوضات</small>
        </div>
    </div>
</div>

<!-- إحصائيات الفترات -->
<div class="row mb-4">
    <div class="col-12">
        <h5 class="text-warning mb-3">
            <i class="fas fa-clock me-2"></i>
            توزيع الفترات
        </h5>
    </div>
    
    <div class="col-md-6 mb-3">
        <div class="stats-card">
            <div class="d-flex align-items-center">
                <div class="me-3">
                    <i class="fas fa-sun fa-3x text-warning"></i>
                </div>
                <div>
                    <h3 class="mb-0">{{ $stats['morning_students'] }}</h3>
                    <small class="text-muted">طالبات الفترة الصباحية</small>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-6 mb-3">
        <div class="stats-card">
            <div class="d-flex align-items-center">
                <div class="me-3">
                    <i class="fas fa-moon fa-3x text-info"></i>
                </div>
                <div>
                    <h3 class="mb-0">{{ $stats['evening_students'] }}</h3>
                    <small class="text-muted">طالبات الفترة المسائية</small>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- إحصائيات الباصات -->
<div class="row mb-4">
    <div class="col-12">
        <h5 class="text-success mb-3">
            <i class="fas fa-bus me-2"></i>
            إحصائيات النقل
        </h5>
    </div>
    
    <div class="col-md-3 mb-3">
        <div class="stats-card text-center">
            <i class="fas fa-bus fa-2x text-primary mb-2"></i>
            <h3 class="mb-0">{{ $stats['total_buses'] }}</h3>
            <small class="text-muted">إجمالي الباصات</small>
        </div>
    </div>
    
    <div class="col-md-3 mb-3">
        <div class="stats-card text-center">
            <i class="fas fa-check fa-2x text-success mb-2"></i>
            <h3 class="mb-0">{{ $stats['active_buses'] }}</h3>
            <small class="text-muted">الباصات النشطة</small>
        </div>
    </div>
    
    <div class="col-md-3 mb-3">
        <div class="stats-card text-center">
            <i class="fas fa-chair fa-2x text-info mb-2"></i>
            <h3 class="mb-0">{{ $stats['total_capacity'] }}</h3>
            <small class="text-muted">إجمالي المقاعد</small>
        </div>
    </div>
    
    <div class="col-md-3 mb-3">
        <div class="stats-card text-center">
            <i class="fas fa-user-check fa-2x text-warning mb-2"></i>
            <h3 class="mb-0">{{ $stats['occupied_seats'] }}</h3>
            <small class="text-muted">المقاعد المشغولة</small>
        </div>
    </div>
</div>

<!-- نسبة الإشغال -->
@if($stats['total_capacity'] > 0)
<div class="content-card">
    <h5 class="mb-3">نسبة إشغال الباصات</h5>
    @php
        $occupancyRate = round(($stats['occupied_seats'] / $stats['total_capacity']) * 100, 1);
        $color = $occupancyRate > 80 ? 'danger' : ($occupancyRate > 50 ? 'warning' : 'success');
    @endphp
    <div class="progress" style="height: 30px;">
        <div class="progress-bar bg-{{ $color }}" 
             role="progressbar" 
             style="width: {{ $occupancyRate }}%">
            {{ $occupancyRate }}%
        </div>
    </div>
    <div class="d-flex justify-content-between mt-2">
        <small class="text-muted">{{ $stats['occupied_seats'] }} مقعد مشغول</small>
        <small class="text-muted">{{ $stats['total_capacity'] - $stats['occupied_seats'] }} مقعد متاح</small>
    </div>
</div>
@endif
@endsection

@push('styles')
<style>
.stats-card {
    background: rgba(255,255,255,0.05);
    border-radius: 15px;
    padding: 1.5rem;
    border: 1px solid rgba(255,255,255,0.1);
}
</style>
@endpush