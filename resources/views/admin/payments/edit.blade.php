@extends('layouts.admin')

@section('title', 'تعديل الدفعة - ' . $payment->payment_number)

@section('header')
<div class="d-flex justify-content-between align-items-center w-100">
    <div>
        <h2 class="mb-1">
            <i class="fas fa-edit text-warning me-2"></i>
            تعديل الدفعة
        </h2>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">لوحة التحكم</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.payments.index') }}">الدفعات</a></li>
                <li class="breadcrumb-item active">{{ $payment->payment_number }}</li>
            </ol>
        </nav>
    </div>
    <a href="{{ route('admin.payments.index') }}" class="btn btn-outline-light">
        <i class="fas fa-arrow-right me-1"></i>
        العودة
    </a>
</div>
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="content-card">
            <!-- معلومات الطالبة -->
            <div class="alert alert-info mb-4">
                <i class="fas fa-user-graduate me-2"></i>
                <strong>الطالبة:</strong> 
                @if($payment->student)
                    {{ $payment->student->name }} ({{ $payment->student->student_id }})
                @else
                    غير محدد
                @endif
            </div>

            <form action="{{ route('admin.payments.update', $payment) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6 mb-4">
                        <label class="form-label">رقم الدفعة</label>
                        <input type="text" class="form-control" value="{{ $payment->payment_number }}" readonly disabled>
                    </div>

                    <div class="col-md-6 mb-4">
                        <label class="form-label">الحالة</label>
                        <select name="status" class="form-select @error('status') is-invalid @enderror">
                            <option value="awaiting_receipt" {{ $payment->status == 'awaiting_receipt' ? 'selected' : '' }}>بانتظار الإيصال</option>
                            <option value="pending" {{ $payment->status == 'pending' ? 'selected' : '' }}>قيد المراجعة</option>
                            <option value="approved" {{ $payment->status == 'approved' ? 'selected' : '' }}>مقبولة</option>
                            <option value="rejected" {{ $payment->status == 'rejected' ? 'selected' : '' }}>مرفوضة</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-4">
                        <label class="form-label">المبلغ المطلوب <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="number" name="amount" class="form-control @error('amount') is-invalid @enderror"
                                   value="{{ old('amount', $payment->amount) }}" step="0.01" min="1" required>
                            <span class="input-group-text">ريال</span>
                        </div>
                        @error('amount')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-4">
                        <label class="form-label">تاريخ الاستحقاق</label>
                        <input type="date" name="due_date" class="form-control @error('due_date') is-invalid @enderror"
                               value="{{ old('due_date', $payment->due_date ? $payment->due_date->format('Y-m-d') : '') }}">
                        @error('due_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label">ملاحظات للطالبة</label>
                    <textarea name="notes" class="form-control @error('notes') is-invalid @enderror" 
                              rows="3">{{ old('notes', $payment->notes) }}</textarea>
                    @error('notes')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- معلومات الإيصال إن وجد -->
                @if($payment->receipt_image)
                <div class="mb-4">
                    <label class="form-label">الإيصال المرفق</label>
                    <div class="d-flex align-items-center gap-3">
                        <a href="{{ asset('storage/' . $payment->receipt_image) }}" target="_blank" class="btn btn-outline-info">
                            <i class="fas fa-eye me-1"></i>
                            عرض الإيصال
                        </a>
                        <span class="text-muted">تم رفعه من الطالبة</span>
                    </div>
                </div>
                @endif

                <hr class="border-secondary my-4">

                <div class="d-flex justify-content-between">
                    <a href="{{ route('admin.payments.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-times me-1"></i>
                        إلغاء
                    </a>
                    <div class="d-flex gap-2">
                        @if($payment->status == 'pending' && $payment->receipt_image)
                        <form action="{{ route('admin.payments.approve', $payment) }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-check me-1"></i>
                                قبول الدفعة
                            </button>
                        </form>
                        @endif
                        
                        <button type="submit" class="btn btn-warning">
                            <i class="fas fa-save me-1"></i>
                            حفظ التغييرات
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .content-card {
        background: rgba(255, 255, 255, 0.05);
        border-radius: 15px;
        padding: 2rem;
        border: 1px solid rgba(127, 176, 105, 0.2);
    }
    .form-control, .form-select {
        background: rgba(255,255,255,0.05);
        border-color: rgba(255,255,255,0.2);
        color: #fff;
    }
    .form-control:focus, .form-select:focus {
        background: rgba(255,255,255,0.1);
        border-color: #ffc107;
        color: #fff;
        box-shadow: 0 0 0 0.2rem rgba(255, 193, 7, 0.25);
    }
    .form-control:disabled {
        background: rgba(255,255,255,0.02);
        color: rgba(255,255,255,0.5);
    }
    .input-group-text {
        background: rgba(255, 193, 7, 0.2);
        border-color: rgba(255,255,255,0.2);
        color: #ffc107;
    }
</style>
@endpush
