@extends('layouts.admin')

@section('title', 'إضافة دفعة جديدة')

@section('header')
<div class="d-flex justify-content-between align-items-center w-100">
    <div>
        <h2 class="mb-1">
            <i class="fas fa-plus-circle text-success me-2"></i>
            إضافة دفعة جديدة
        </h2>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">لوحة التحكم</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.payments.index') }}">الدفعات</a></li>
                <li class="breadcrumb-item active">إضافة دفعة</li>
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
            <div class="alert alert-info mb-4">
                <i class="fas fa-info-circle me-2"></i>
                <strong>ملاحظة:</strong>  مايحتاج الا تحط الطالبه و المبلغ اما التاريخ اختياري
            </div>

            <form action="{{ route('admin.payments.store') }}" method="POST">
                @csrf

                <div class="mb-4">
                    <label class="form-label">الطالبة <span class="text-danger">*</span></label>
                    <select name="student_id" class="form-select @error('student_id') is-invalid @enderror" required>
                        <option value="">-- اختر الطالبة --</option>
                        @foreach($students as $student)
                            <option value="{{ $student->id }}" 
                                    {{ (old('student_id') == $student->id || ($selectedStudent && $selectedStudent->id == $student->id)) ? 'selected' : '' }}>
                                {{ $student->name }} - {{ $student->student_id }} ({{ $student->center->center_name }})
                            </option>
                        @endforeach
                    </select>
                    @error('student_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-md-6 mb-4">
                        <label class="form-label">المبلغ المطلوب <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="number" name="amount" class="form-control @error('amount') is-invalid @enderror"
                                   value="{{ old('amount') }}" step="0.01" min="1" required placeholder="0.00">
                            <span class="input-group-text">ريال</span>
                        </div>
                        @error('amount')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-4">
                        <label class="form-label">تاريخ الاستحقاق</label>
                        <input type="date" name="due_date" class="form-control @error('due_date') is-invalid @enderror"
                               value="{{ old('due_date') }}">
                        @error('due_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">اختياري - تاريخ آخر موعد للسداد</small>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label">ملاحظات للطالبة</label>
                    <textarea name="notes" class="form-control @error('notes') is-invalid @enderror" 
                              rows="3" placeholder="مثال: رسوم الفصل الدراسي الأول...">{{ old('notes') }}</textarea>
                    @error('notes')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="text-muted">ستظهر هذه الملاحظات للطالبة</small>
                </div>

                <hr class="border-secondary my-4">

                <div class="d-flex justify-content-between">
                    <a href="{{ route('admin.payments.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-times me-1"></i>
                        إلغاء
                    </a>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-plus me-1"></i>
                        إضافة الدفعة
                    </button>
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
        border-color: #28a745;
        color: #fff;
        box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.25);
    }
    .form-select option {
        background: #1a1a2e;
        color: #fff;
    }
    .input-group-text {
        background: rgba(40, 167, 69, 0.2);
        border-color: rgba(255,255,255,0.2);
        color: #90EE90;
    }
</style>
@endpush