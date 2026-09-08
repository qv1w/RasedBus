@extends('layouts.admin')

@section('title', 'إنشاء دفعات جماعية')

@section('header')
<div class="d-flex justify-content-between align-items-center w-100">
    <div>
        <h2 class="mb-1">
            <i class="fas fa-layer-group text-primary me-2"></i>
            إنشاء دفعات جماعية
        </h2>
        <p class="text-light mb-0 opacity-75">
            إنشاء دفعات لجميع طلاب الجهات التعليمية المحددة
        </p>
    </div>
    <a href="{{ url('admin/payments') }}" class="btn btn-outline-light">
        <i class="fas fa-arrow-right me-1"></i>
        العودة للدفعات
    </a>
</div>
@endsection

@section('content')
@php
    $centers = \App\Models\Center::where('status', 'active')
                                 ->withCount(['students' => function($q) {
                                     $q->where('status', 'approved');
                                 }])
                                 ->orderBy('type')
                                 ->orderBy('center_name')
                                 ->get();
    
    $darCenters = $centers->where('type', 'دار');
    $markazCenters = $centers->where('type', 'مركز');
    $programCenters = $centers->where('type', 'برنامج');
@endphp

<form action="{{ url('admin/payments/bulk-store') }}" method="POST" id="bulkPaymentForm">
    @csrf
    
    <div class="row">
        <!-- اختيار الجهات -->
        <div class="col-lg-7 mb-4">
            <div class="content-card">
                <h5 class="mb-4">
                    <i class="fas fa-school me-2"></i>
                    اختر الجهات التعليمية
                </h5>
                
                <!-- أزرار التحديد السريع -->
                <div class="d-flex flex-wrap gap-2 mb-4">
                    <button type="button" class="btn btn-sm btn-outline-light" onclick="selectAll()">
                        <i class="fas fa-check-double me-1"></i>
                        تحديد الكل
                    </button>
                    <button type="button" class="btn btn-sm btn-outline-light" onclick="deselectAll()">
                        <i class="fas fa-times me-1"></i>
                        إلغاء الكل
                    </button>
                    <button type="button" class="btn btn-sm btn-outline-dar" onclick="selectType('دار')">
                        <i class="fas fa-mosque me-1"></i>
                        كل الدور
                    </button>
                    <button type="button" class="btn btn-sm btn-outline-markaz" onclick="selectType('مركز')">
                        <i class="fas fa-graduation-cap me-1"></i>
                        كل المراكز
                    </button>
                    <button type="button" class="btn btn-sm btn-outline-program" onclick="selectType('برنامج')">
                        <i class="fas fa-seedling me-1"></i>
                        كل البرامج
                    </button>
                </div>
                
                <!-- دور التحفيظ -->
                @if($darCenters->count() > 0)
                <div class="center-group mb-4">
                    <div class="group-header bg-dar-light mb-3">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <i class="fas fa-mosque text-dar me-2"></i>
                                <strong class="text-dar">دور التحفيظ</strong>
                                <span class="badge bg-dar ms-2">{{ $darCenters->count() }}</span>
                            </div>
                            <small class="text-muted">{{ $darCenters->sum('students_count') }} طالب</small>
                        </div>
                    </div>
                    
                    <div class="row">
                        @foreach($darCenters as $center)
                        <div class="col-md-6 mb-2">
                            <label class="center-checkbox-card" data-type="دار">
                                <input type="checkbox" name="center_ids[]" value="{{ $center->id }}" 
                                       class="center-checkbox" data-students="{{ $center->students_count }}">
                                <div class="card-content">
                                    <div class="d-flex align-items-center">
                                        <div class="center-icon icon-type-dar me-3">
                                            <i class="fas fa-mosque"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <div class="fw-bold">{{ $center->center_name }}</div>
                                            <small class="text-muted">
                                                <i class="fas fa-users me-1"></i>
                                                {{ $center->students_count }} طالب
                                            </small>
                                        </div>
                                        <div class="check-indicator">
                                            <i class="fas fa-check"></i>
                                        </div>
                                    </div>
                                </div>
                            </label>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
                
                <!-- مركز إعداد المعلمات -->
                @if($markazCenters->count() > 0)
                <div class="center-group mb-4">
                    <div class="group-header bg-markaz-light mb-3">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <i class="fas fa-graduation-cap text-markaz me-2"></i>
                                <strong class="text-markaz">مركز إعداد المعلمات</strong>
                                <span class="badge bg-markaz ms-2">{{ $markazCenters->count() }}</span>
                            </div>
                            <small class="text-muted">{{ $markazCenters->sum('students_count') }} طالب</small>
                        </div>
                    </div>
                    
                    <div class="row">
                        @foreach($markazCenters as $center)
                        <div class="col-md-6 mb-2">
                            <label class="center-checkbox-card" data-type="مركز">
                                <input type="checkbox" name="center_ids[]" value="{{ $center->id }}" 
                                       class="center-checkbox" data-students="{{ $center->students_count }}">
                                <div class="card-content">
                                    <div class="d-flex align-items-center">
                                        <div class="center-icon icon-type-markaz me-3">
                                            <i class="fas fa-graduation-cap"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <div class="fw-bold">{{ $center->center_name }}</div>
                                            <small class="text-muted">
                                                <i class="fas fa-users me-1"></i>
                                                {{ $center->students_count }} طالب
                                            </small>
                                        </div>
                                        <div class="check-indicator">
                                            <i class="fas fa-check"></i>
                                        </div>
                                    </div>
                                </div>
                            </label>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
                
                <!-- برامج الرياحين -->
                @if($programCenters->count() > 0)
                <div class="center-group mb-4">
                    <div class="group-header bg-program-light mb-3">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <i class="fas fa-seedling text-program me-2"></i>
                                <strong class="text-program">برامج الرياحين</strong>
                                <span class="badge bg-program ms-2">{{ $programCenters->count() }}</span>
                            </div>
                            <small class="text-muted">{{ $programCenters->sum('students_count') }} طالب</small>
                        </div>
                    </div>
                    
                    <div class="row">
                        @foreach($programCenters as $center)
                        <div class="col-md-6 mb-2">
                            <label class="center-checkbox-card" data-type="برنامج">
                                <input type="checkbox" name="center_ids[]" value="{{ $center->id }}" 
                                       class="center-checkbox" data-students="{{ $center->students_count }}">
                                <div class="card-content">
                                    <div class="d-flex align-items-center">
                                        <div class="center-icon icon-type-program me-3">
                                            <i class="fas fa-seedling"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <div class="fw-bold">{{ $center->center_name }}</div>
                                            <small class="text-muted">
                                                <i class="fas fa-users me-1"></i>
                                                {{ $center->students_count }} طالب
                                            </small>
                                        </div>
                                        <div class="check-indicator">
                                            <i class="fas fa-check"></i>
                                        </div>
                                    </div>
                                </div>
                            </label>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
                
                @if($centers->count() == 0)
                <div class="text-center py-5">
                    <i class="fas fa-school fa-3x text-muted opacity-50 mb-3"></i>
                    <h5 class="text-muted">لا توجد جهات تعليمية نشطة</h5>
                    <a href="{{ url('admin/centers/create') }}" class="btn btn-success mt-3">
                        <i class="fas fa-plus me-1"></i>
                        إضافة جهة جديدة
                    </a>
                </div>
                @endif
            </div>
        </div>
        
        <!-- تفاصيل الدفعة -->
        <div class="col-lg-5 mb-4">
            <div class="content-card sticky-top" style="top: 20px;">
                <h5 class="mb-4">
                    <i class="fas fa-file-invoice-dollar me-2"></i>
                    تفاصيل الدفعة
                </h5>
                
                <!-- ملخص الاختيار -->
                <div class="summary-box mb-4">
                    <div class="row text-center">
                        <div class="col-6">
                            <div class="summary-item">
                                <i class="fas fa-school fa-2x text-info mb-2"></i>
                                <h3 class="mb-0 text-info" id="selectedCentersCount">0</h3>
                                <small class="text-muted">جهة محددة</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="summary-item">
                                <i class="fas fa-users fa-2x text-success mb-2"></i>
                                <h3 class="mb-0 text-success" id="selectedStudentsCount">0</h3>
                                <small class="text-muted">طالب سيستلم الدفعة</small>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- المبلغ -->
                <div class="mb-4">
                    <label class="form-label">
                        المبلغ لكل طالب <span class="text-danger">*</span>
                    </label>
                    <div class="input-group input-group-lg">
                        <input type="number" name="amount" class="form-control" 
                               value="{{ old('amount') }}" step="0.01" min="1" required
                               placeholder="0.00" id="amountInput">
                        <span class="input-group-text">ريال</span>
                    </div>
                    @error('amount')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>
                
                <!-- الإجمالي المتوقع -->
                <div class="total-box mb-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <span>الإجمالي المتوقع:</span>
                        <span class="h4 mb-0 text-success" id="totalAmount">0.00 ريال</span>
                    </div>
                </div>
                
                <!-- تاريخ الاستحقاق -->
                <div class="mb-4">
                    <label class="form-label">تاريخ الاستحقاق</label>
                    <input type="date" name="due_date" class="form-control" 
                           value="{{ old('due_date') }}">
                    <small class="text-muted">اختياري - آخر موعد للسداد</small>
                </div>
                
                <!-- الوصف -->
                <div class="mb-4">
                    <label class="form-label">وصف الدفعة</label>
                    <input type="text" name="description" class="form-control" 
                           value="{{ old('description', 'رسوم النقل - ' . date('Y')) }}"
                           placeholder="مثال: رسوم الفصل الأول">
                    <small class="text-muted">سيظهر للطالب عند عرض الدفعة</small>
                </div>
                
                <!-- ملاحظات -->
                <div class="mb-4">
                    <label class="form-label">ملاحظات إضافية</label>
                    <textarea name="notes" class="form-control" rows="2" 
                              placeholder="ملاحظات داخلية...">{{ old('notes') }}</textarea>
                </div>
                
                <hr class="border-secondary">
                
                <!-- زر الإنشاء -->
                <button type="submit" class="btn btn-success btn-lg w-100" id="submitBtn" disabled>
                    <i class="fas fa-paper-plane me-2"></i>
                    إنشاء <span id="submitCount">0</span> دفعة
                </button>
                
                <div class="alert alert-warning mt-3 mb-0" id="noSelectionAlert">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    يرجى اختيار جهة تعليمية واحدة على الأقل
                </div>
            </div>
        </div>
    </div>
</form>

<!-- Modal التأكيد -->
<div class="modal fade" id="confirmModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-dark">
            <div class="modal-header border-success">
                <h5 class="modal-title text-success">
                    <i class="fas fa-check-circle me-2"></i>
                    تأكيد إنشاء الدفعات
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center">
                <i class="fas fa-file-invoice-dollar fa-4x text-success mb-3"></i>
                <h4>هل تريد إنشاء الدفعات؟</h4>
                <p class="text-muted mb-4">
                    سيتم إنشاء <strong id="confirmCount" class="text-success">0</strong> دفعة 
                    بمبلغ <strong id="confirmAmount" class="text-success">0</strong> ريال لكل طالب
                </p>
                <div class="alert alert-info text-start">
                    <i class="fas fa-info-circle me-2"></i>
                    <strong>ملاحظة:</strong> سيتم إرسال إشعار لكل طالب بالدفعة المستحقة
                </div>
            </div>
            <div class="modal-footer border-secondary">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                <button type="button" class="btn btn-success" id="confirmSubmitBtn">
                    <i class="fas fa-check me-1"></i>
                    تأكيد الإنشاء
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .content-card {
        background: rgba(255, 255, 255, 0.05);
        border-radius: 15px;
        padding: 1.5rem;
        border: 1px solid rgba(127, 176, 105, 0.2);
    }
    
    /* ألوان الأنواع */
    .text-dar { color: #c86868 !important; }
    .text-markaz { color: #ffb74d !important; }
    .text-program { color: #81c784 !important; }
    
    .bg-dar { background: rgba(176, 39, 39, 0.8) !important; }
    .bg-markaz { background: rgba(255, 152, 0, 0.8) !important; }
    .bg-program { background: rgba(76, 175, 80, 0.8) !important; }
    
    .bg-dar-light { background: rgba(176, 39, 39, 0.1); border-radius: 10px; padding: 0.75rem 1rem; }
    .bg-markaz-light { background: rgba(255, 152, 0, 0.1); border-radius: 10px; padding: 0.75rem 1rem; }
    .bg-program-light { background: rgba(76, 175, 80, 0.1); border-radius: 10px; padding: 0.75rem 1rem; }
    
    .btn-outline-dar { color: #c86868; border-color: #c86868; }
    .btn-outline-dar:hover { background: rgba(176, 39, 39, 0.2); color: #c86868; }
    .btn-outline-markaz { color: #ffb74d; border-color: #ffb74d; }
    .btn-outline-markaz:hover { background: rgba(255, 152, 0, 0.2); color: #ffb74d; }
    .btn-outline-program { color: #81c784; border-color: #81c784; }
    .btn-outline-program:hover { background: rgba(76, 175, 80, 0.2); color: #81c784; }
    
    .icon-type-dar {
        background: rgba(176, 39, 39, 0.15);
        color: #c86868;
        border: 1px solid rgba(176, 39, 39, 0.3);
        width: 40px;
        height: 40px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .icon-type-markaz {
        background: rgba(255, 152, 0, 0.15);
        color: #ffb74d;
        border: 1px solid rgba(255, 152, 0, 0.3);
        width: 40px;
        height: 40px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .icon-type-program {
        background: rgba(76, 175, 80, 0.15);
        color: #81c784;
        border: 1px solid rgba(76, 175, 80, 0.3);
        width: 40px;
        height: 40px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    /* بطاقات الاختيار */
    .center-checkbox-card {
        display: block;
        cursor: pointer;
    }
    .center-checkbox-card input {
        display: none;
    }
    .center-checkbox-card .card-content {
        background: rgba(255, 255, 255, 0.03);
        border: 2px solid rgba(255, 255, 255, 0.1);
        border-radius: 12px;
        padding: 1rem;
        transition: all 0.3s ease;
    }
    .center-checkbox-card:hover .card-content {
        background: rgba(255, 255, 255, 0.08);
        border-color: rgba(255, 255, 255, 0.2);
    }
    .center-checkbox-card input:checked + .card-content {
        background: rgba(40, 167, 69, 0.15);
        border-color: #28a745;
    }
    .center-checkbox-card .check-indicator {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.1);
        display: flex;
        align-items: center;
        justify-content: center;
        color: transparent;
        transition: all 0.3s ease;
    }
    .center-checkbox-card input:checked + .card-content .check-indicator {
        background: #28a745;
        color: white;
    }
    
    /* الملخص */
    .summary-box {
        background: rgba(255, 255, 255, 0.03);
        border-radius: 15px;
        padding: 1.5rem;
        border: 1px solid rgba(255, 255, 255, 0.1);
    }
    .summary-item {
        padding: 0.5rem;
    }
    
    /* الإجمالي */
    .total-box {
        background: rgba(40, 167, 69, 0.1);
        border-radius: 10px;
        padding: 1rem;
        border: 1px solid rgba(40, 167, 69, 0.3);
    }
    
    /* الفورم */
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
    .input-group-text {
        background: rgba(40, 167, 69, 0.2);
        border-color: rgba(255,255,255,0.2);
        color: #90EE90;
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const checkboxes = document.querySelectorAll('.center-checkbox');
    const amountInput = document.getElementById('amountInput');
    const submitBtn = document.getElementById('submitBtn');
    const noSelectionAlert = document.getElementById('noSelectionAlert');
    
    // تحديث الإحصائيات عند تغيير الاختيارات
    function updateStats() {
        let centersCount = 0;
        let studentsCount = 0;
        
        checkboxes.forEach(cb => {
            if (cb.checked) {
                centersCount++;
                studentsCount += parseInt(cb.dataset.students) || 0;
            }
        });
        
        document.getElementById('selectedCentersCount').textContent = centersCount;
        document.getElementById('selectedStudentsCount').textContent = studentsCount;
        document.getElementById('submitCount').textContent = studentsCount;
        
        // حساب الإجمالي
        const amount = parseFloat(amountInput.value) || 0;
        const total = (amount * studentsCount).toFixed(2);
        document.getElementById('totalAmount').textContent = number_format(total) + ' ريال';
        
        // تفعيل/تعطيل زر الإرسال
        const isValid = centersCount > 0 && studentsCount > 0 && amount > 0;
        submitBtn.disabled = !isValid;
        noSelectionAlert.style.display = centersCount > 0 ? 'none' : 'block';
    }
    
    // إضافة مستمعين للأحداث
    checkboxes.forEach(cb => {
        cb.addEventListener('change', updateStats);
    });
    
    amountInput.addEventListener('input', updateStats);
    
    // تحديث أولي
    updateStats();
    
    // تأكيد قبل الإرسال
    document.getElementById('bulkPaymentForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const studentsCount = document.getElementById('selectedStudentsCount').textContent;
        const amount = amountInput.value;
        
        document.getElementById('confirmCount').textContent = studentsCount;
        document.getElementById('confirmAmount').textContent = number_format(amount);
        
        const modal = new bootstrap.Modal(document.getElementById('confirmModal'));
        modal.show();
    });
    
    document.getElementById('confirmSubmitBtn').addEventListener('click', function() {
        document.getElementById('bulkPaymentForm').submit();
    });
});

// دوال التحديد
function selectAll() {
    document.querySelectorAll('.center-checkbox').forEach(cb => {
        cb.checked = true;
    });
    document.querySelector('.center-checkbox').dispatchEvent(new Event('change'));
}

function deselectAll() {
    document.querySelectorAll('.center-checkbox').forEach(cb => {
        cb.checked = false;
    });
    document.querySelector('.center-checkbox').dispatchEvent(new Event('change'));
}

function selectType(type) {
    document.querySelectorAll('.center-checkbox').forEach(cb => {
        cb.checked = false;
    });
    document.querySelectorAll(`.center-checkbox-card[data-type="${type}"] .center-checkbox`).forEach(cb => {
        cb.checked = true;
    });
    document.querySelector('.center-checkbox').dispatchEvent(new Event('change'));
}

// تنسيق الأرقام
function number_format(number) {
    return parseFloat(number).toLocaleString('ar-SA', {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
    });
}
</script>
@endpush
