@extends('layouts.admin')

@section('title', 'إضافة باص جديد')

@section('header')
<div class="d-flex justify-content-between align-items-center w-100">
    <div>
        <h2 class="mb-1">
            <i class="fas fa-plus-circle text-success me-2"></i>
            إضافة باص جديد
        </h2>
        <p class="text-light mb-0 opacity-75">
            أضف باص جديد لنظام النقل
        </p>
    </div>
    <a href="{{ route('admin.buses.index') }}" class="btn btn-outline-light">
        <i class="fas fa-arrow-right me-1"></i>
        العودة
    </a>
</div>
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="content-card">
            <form action="{{ route('admin.buses.store') }}" method="POST" id="busForm">
                @csrf
                
                <div class="row">
                    <!-- معلومات الباص الأساسية -->
                    <div class="col-12 mb-4">
                        <h5 class="border-bottom border-secondary pb-2 mb-3">
                            <i class="fas fa-bus text-info me-2"></i>
                            معلومات الباص
                        </h5>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">رقم الباص <span class="text-danger">*</span></label>
                        <input type="text" 
                               name="number" 
                               class="form-control @error('number') is-invalid @enderror"
                               value="{{ old('number') }}"
                               placeholder="مثال: 31"
                               required>
                        @error('number')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">رقم اللوحة <span class="text-danger">*</span></label>
                        <input type="text" 
                               name="plate_number" 
                               class="form-control @error('plate_number') is-invalid @enderror"
                               value="{{ old('plate_number') }}"
                               placeholder="مثال: ب ص ن 1439"
                               required>
                        @error('plate_number')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">الموديل</label>
                        <input type="text" 
                               name="model" 
                               class="form-control @error('model') is-invalid @enderror"
                               value="{{ old('model') }}"
                               placeholder="مثال: 2023">
                        @error('model')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">السعة الافتراضية <span class="text-danger">*</span></label>
                        <input type="number" 
                               name="capacity" 
                               id="defaultCapacity"
                               class="form-control @error('capacity') is-invalid @enderror"
                               value="{{ old('capacity', 25) }}"
                               min="1"
                               max="100"
                               required>
                        @error('capacity')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">السعة الافتراضية لكل جهة</small>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">السائق</label>
                        <select name="driver_id" class="form-select @error('driver_id') is-invalid @enderror">
                            <option value="">بدون سائق</option>
                            @foreach($drivers as $driver)
                                <option value="{{ $driver->id }}" {{ old('driver_id') == $driver->id ? 'selected' : '' }}>
                                    {{ $driver->name }} - {{ $driver->mobile }}
                                </option>
                            @endforeach
                        </select>
                        @error('driver_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- الجهات التعليمية -->
                    <div class="col-12 mb-4 mt-3">
                        <h5 class="border-bottom border-secondary pb-2 mb-3">
                            <i class="fas fa-school text-warning me-2"></i>
                            الجهات التعليمية
                            <small class="text-muted fs-6">(اختر جهة أو أكثر مع تحديد السعة لكل منها)</small>
                        </h5>
                    </div>

                    <div class="col-12 mb-3">
                        @error('center_ids')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                        
                        <div class="centers-container">
                            @foreach($centers as $center)
                            <div class="center-card mb-3" id="centerCard_{{ $center->id }}">
                                <div class="form-check">
                                    <input class="form-check-input center-checkbox" 
                                           type="checkbox" 
                                           name="center_ids[]" 
                                           value="{{ $center->id }}" 
                                           id="center_{{ $center->id }}"
                                           data-center-id="{{ $center->id }}"
                                           {{ in_array($center->id, old('center_ids', [])) ? 'checked' : '' }}>
                                    <label class="form-check-label fw-bold" for="center_{{ $center->id }}">
                                        <i class="fas fa-school text-info me-1"></i>
                                        {{ $center->center_name }}
                                    </label>
                                </div>
                                
                                <div class="center-details mt-3" id="centerDetails_{{ $center->id }}" 
                                     style="{{ in_array($center->id, old('center_ids', [])) ? '' : 'display: none;' }}">
                                    <div class="row">
                                        <div class="col-md-6 mb-2">
                                            <label class="form-label small">السعة لهذه الجهة</label>
                                            <input type="number" 
                                                   name="capacities[{{ $center->id }}]" 
                                                   class="form-control form-control-sm capacity-input"
                                                   value="{{ old('capacities.'.$center->id, 25) }}"
                                                   min="1" max="100">
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <label class="form-label small">الفترة</label>
                                            <select name="schedules[{{ $center->id }}]" class="form-select form-select-sm">
                                                <option value="both" {{ old('schedules.'.$center->id) == 'both' ? 'selected' : '' }}>صباحية ومسائية</option>
                                                <option value="morning" {{ old('schedules.'.$center->id) == 'morning' ? 'selected' : '' }}>صباحية فقط</option>
                                                <option value="evening" {{ old('schedules.'.$center->id) == 'evening' ? 'selected' : '' }}>مسائية فقط</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- الحالة والملاحظات -->
                    <div class="col-12 mb-4 mt-3">
                        <h5 class="border-bottom border-secondary pb-2 mb-3">
                            <i class="fas fa-cog text-secondary me-2"></i>
                            إعدادات إضافية
                        </h5>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">الحالة <span class="text-danger">*</span></label>
                        <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                            <option value="active" {{ old('status', 'active') == 'active' ? 'selected' : '' }}>نشط</option>
                            <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>غير نشط</option>
                            <option value="maintenance" {{ old('status') == 'maintenance' ? 'selected' : '' }}>صيانة</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12 mb-3">
                        <label class="form-label">ملاحظات</label>
                        <textarea name="notes" 
                                  class="form-control @error('notes') is-invalid @enderror"
                                  rows="3"
                                  placeholder="أي ملاحظات إضافية...">{{ old('notes') }}</textarea>
                        @error('notes')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <hr class="border-secondary my-4">

                <div class="d-flex justify-content-between">
                    <a href="{{ route('admin.buses.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-times me-1"></i>
                        إلغاء
                    </a>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save me-2"></i>
                        حفظ الباص
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.center-card {
    background: rgba(255,255,255,0.05);
    padding: 1rem;
    border-radius: 10px;
    border: 1px solid rgba(255,255,255,0.1);
    transition: all 0.3s ease;
}

.center-card:hover {
    border-color: rgba(13, 202, 240, 0.3);
}

.center-card.selected {
    background: rgba(13, 202, 240, 0.1);
    border-color: rgba(13, 202, 240, 0.5);
}

.center-details {
    background: rgba(0,0,0,0.2);
    padding: 1rem;
    border-radius: 8px;
    margin-top: 0.5rem;
}
</style>
@endpush

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const defaultCapacity = document.getElementById('defaultCapacity');
    const checkboxes = document.querySelectorAll('.center-checkbox');
    
    // إظهار/إخفاء تفاصيل الجهة عند التحديد
    checkboxes.forEach(function(checkbox) {
        checkbox.addEventListener('change', function() {
            const centerId = this.dataset.centerId;
            const details = document.getElementById('centerDetails_' + centerId);
            const card = document.getElementById('centerCard_' + centerId);
            
            if (this.checked) {
                details.style.display = 'block';
                card.classList.add('selected');
                
                // تعيين السعة الافتراضية
                const capacityInput = details.querySelector('.capacity-input');
                if (capacityInput && !capacityInput.value) {
                    capacityInput.value = defaultCapacity.value;
                }
            } else {
                details.style.display = 'none';
                card.classList.remove('selected');
            }
        });
        
        // تطبيق الحالة الأولية
        if (checkbox.checked) {
            document.getElementById('centerCard_' + checkbox.dataset.centerId).classList.add('selected');
        }
    });
    
    // تحديث السعة الافتراضية عند تغييرها
    defaultCapacity.addEventListener('change', function() {
        const uncheckedCapacities = document.querySelectorAll('.center-checkbox:not(:checked)');
        uncheckedCapacities.forEach(function(cb) {
            const details = document.getElementById('centerDetails_' + cb.dataset.centerId);
            const capacityInput = details.querySelector('.capacity-input');
            capacityInput.value = defaultCapacity.value;
        });
    });
});
</script>
@endsection