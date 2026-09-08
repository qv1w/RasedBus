@extends('layouts.admin')

@section('title', 'الدفعات قيد المراجعة')

@section('header')
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1 class="h3 mb-0">الدفعات قيد المراجعة</h1>
            <p class="text-muted mb-0">معالجة وموافقة على الدفعات المقدمة من الطالبات</p>
        </div>
        <div>
            <a href="{{ route('admin.payments.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-list ms-2"></i>
                جميع الدفعات
            </a>
            <button type="button" class="btn btn-success" onclick="bulkApprove()">
                <i class="fas fa-check-double ms-2"></i>
                موافقة جماعية
            </button>
        </div>
    </div>
@endsection

@section('content')
<!-- إحصائيات سريعة -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card bg-warning text-dark">
            <div class="card-body text-center">
                <h4 class="mb-0">{{ $payments->total() }}</h4>
                <small>دفعات قيد المراجعة</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-info text-white">
            <div class="card-body text-center">
                <h4 class="mb-0">{{ number_format($payments->sum('amount'), 0) }}</h4>
                <small>إجمالي المبلغ (ر.س)</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-primary text-white">
            <div class="card-body text-center">
                <h4 class="mb-0">{{ $payments->where('created_at', '>=', now()->subDays(7))->count() }}</h4>
                <small>دفعات الأسبوع الماضي</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-success text-white">
            <div class="card-body text-center">
                <h4 class="mb-0">{{ $payments->where('created_at', '>=', now()->today())->count() }}</h4>
                <small>دفعات اليوم</small>
            </div>
        </div>
    </div>
</div>

@if($payments->count() > 0)
<!-- بطاقات الدفعات -->
<div class="row">
    @foreach($payments as $payment)
    <div class="col-lg-6 col-xl-4 mb-4">
        <div class="card border-warning">
            <div class="card-header bg-warning text-dark d-flex justify-content-between align-items-center">
                <div>
                    <input type="checkbox" class="form-check-input payment-checkbox me-2" 
                           value="{{ $payment->id }}">
                    <strong>#{{ $payment->id }}</strong>
                </div>
                <small>{{ $payment->created_at->diffForHumans() }}</small>
            </div>
            <div class="card-body">
                <!-- معلومات الطالبة -->
                <div class="mb-3">
                    <h6 class="card-title mb-1">
                        <a href="{{ route('admin.students.show', $payment->student) }}" 
                           class="text-decoration-none">
                            {{ $payment->student->name }}
                        </a>
                    </h6>
                    <small class="text-muted">رقم الطالبة: {{ $payment->student_number }}</small>
                </div>

                <!-- تفاصيل الدفعة -->
                <div class="row mb-3">
                    <div class="col-6">
                        <span class="text-muted small">المبلغ:</span>
                        <div class="h5 text-success mb-0">{{ number_format($payment->amount, 2) }} ر.س</div>
                    </div>
                    <div class="col-6">
                        <span class="text-muted small">طريقة الدفع:</span>