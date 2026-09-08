@extends('layouts.admin')

@section('title', 'تعديل الباص ' . $bus->number)

@section('header')
<div class="d-flex justify-content-between align-items-center w-100">
    <div>
        <h2 class="mb-1">
            <i class="fas fa-edit text-warning me-2"></i>
            تعديل الباص {{ $bus->number }}
        </h2>
        <p class="text-light mb-0 opacity-75">
            تعديل معلومات وإعدادات الباص
        </p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.buses.show', $bus) }}" class="btn btn-outline-light">
            <i class="fas fa-eye me-2"></i>
            عرض التفاصيل
        </a>
        <a href="{{ route('admin.buses.index') }}" class="btn btn-outline-light">
            <i class="fas fa-arrow-right me-2"></i>
            العودة للقائمة
        </a>
    </div>
</div>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-8">
        <form method="POST" action="{{ route('admin.buses.update', $bus) }}" id="busForm">
            @csrf
            @method('PUT')
            
            <!-- معلومات الباص الأساسية -->
            <div class="content-card mb-4">
                <h5 class="text-primary mb-4">
                    <i class="fas fa-bus me-2"></i>
                    معلومات الباص الأساسية
                </h5>
                
                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="number" class="form-label">
                            رقم الباص <span class="text-danger">*</span>
                        </label>
                        <input type="text" 
                               class="form-control @error('number') is-invalid @enderror" 
                               id="number" 
                               name="number" 
                               value="{{ old('number', $bus->number) }}" 
                               required>
                        @error('number')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-6">
                        <label for="plate_number" class="form-label">
                            رقم اللوحة <span class="text-danger">*</span>
                        </label>
                        <input type="text" 
                               class="form-control @error('plate_number') is-invalid @enderror" 
                               id="plate_number" 
                               name="plate_number" 
                               value="{{ old('plate_number', $bus->plate_number) }}" 
                               required>
                        @error('plate_number')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-4">
                        <label for="model" class="form-label">الموديل</label>
                        <input type="text" 
                               class="form-control @error('model') is-invalid @enderror" 
                               id="model" 
                               name="model" 
                               value="{{ old('model', $bus->model) }}">
                        @error('model')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-4">
                        <label for="capacity" class="form-label">
                            السعة الافتراضية <span class="text-danger">*</span>
                        </label>
                        <input type="number" 
                               class="form-control @error('capacity') is-invalid @enderror" 
                               id="defaultCapacity" 
                               name="capacity" 
                               value="{{ old('capacity', $bus->capacity) }}" 
                               min="1" 
                               max="100" 
                               required>
                        @error('capacity')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-4">
                        <label for="status" class="form-label">الحالة <span class="text-danger">*</span></label>
                        <select class="form-select @error('status') is-invalid @enderror" 
                                id="status" 
                                name="status" 
                                required>
                            <option value="active" {{ old('status', $bus->status) == 'active' ? 'selected' : '' }}>
                                نشط
                            </option>
                            <option value="inactive" {{ old('status', $bus->status) == 'inactive' ? 'selected' : '' }}>
                                غير نشط
                            </option>
                            <option value="maintenance" {{ old('status', $bus->status) == 'maintenance' ? 'selected' : '' }}>
                                صيانة
                            </option>
                        </select>
                        @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- الجهات التعليمية -->
            <div class="content-card mb-4">
                <h5 class="text-info mb-4">
                    <i class="fas fa-school me-2"></i>
                    الجهات التعليمية
                    <small class="text-muted fs-6">(كل جهة لها سعة منفصلة)</small>
                </h5>
                
                @error('center_ids')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
                @error('capacities')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
                
                <div class="centers-container">
                    @foreach($centers as $center)
                    @php
                        $isSelected = isset($selectedCenters[$center->id]);
                        $centerData = $selectedCenters[$center->id] ?? ['schedule' => 'both', 'capacity' => $bus->capacity, 'current_students' => 0];
                    @endphp
                    <div class="center-card mb-3 {{ $isSelected ? 'selected' : '' }}" id="centerCard_{{ $center->id }}">
                        <div class="d-flex justify-content-between align-items-start">
                            <div class="form-check">
                                <input class="form-check-input center-checkbox" 
                                       type="checkbox" 
                                       name="center_ids[]" 
                                       value="{{ $center->id }}" 
                                       id="center_{{ $center->id }}"
                                       data-center-id="{{ $center->id }}"
                                       {{ $isSelected ? 'checked' : '' }}>
                                <label class="form-check-label fw-bold" for="center_{{ $center->id }}">
                                    <i class="fas fa-school text-info me-1"></i>
                                    {{ $center->center_name }}
                                </label>
                            </div>
                            
                            @if($isSelected && $centerData['current_students'] > 0)
                            <span class="badge bg-warning">
                                <i class="fas fa-users me-1"></i>
                                {{ $centerData['current_students'] }} طالبة
                            </span>
                            @endif
                        </div>
                        
                        <div class="center-details mt-3" id="centerDetails_{{ $center->id }}" 
                             style="{{ $isSelected ? '' : 'display: none;' }}">
                            <div class="row">
                                <div class="col-md-6 mb-2">
                                    <label class="form-label small">السعة لهذه الجهة</label>
                                    <input type="number" 
                                           name="capacities[{{ $center->id }}]" 
                                           class="form-control form-control-sm capacity-input"
                                           value="{{ old('capacities.'.$center->id, $centerData['capacity']) }}"
                                           min="{{ $centerData['current_students'] }}"
                                           max="100"
                                           data-min-students="{{ $centerData['current_students'] }}">
                                    @if($centerData['current_students'] > 0)
                                    <small class="text-warning">
                                        <i class="fas fa-exclamation-triangle me-1"></i>
                                        الحد الأدنى: {{ $centerData['current_students'] }}
                                    </small>
                                    @endif
                                </div>
                                <div class="col-md-6 mb-2">
                                    <label class="form-label small">الفترة</label>
                                    <select name="schedules[{{ $center->id }}]" class="form-select form-select-sm">
                                        <option value="both" {{ old('schedules.'.$center->id, $centerData['schedule']) == 'both' ? 'selected' : '' }}>صباحية ومسائية</option>
                                        <option value="morning" {{ old('schedules.'.$center->id, $centerData['schedule']) == 'morning' ? 'selected' : '' }}>صباحية فقط</option>
                                        <option value="evening" {{ old('schedules.'.$center->id, $centerData['schedule']) == 'evening' ? 'selected' : '' }}>مسائية فقط</option>
                                    </select>
                                </div>
                            </div>
                            
                            @if($isSelected)
                            <div class="mt-2 p-2 rounded" style="background: rgba(0,0,0,0.2);">
                                <div class="d-flex justify-content-between small">
                                    <span class="text-muted">الإشغال:</span>
                                    <span>
                                        {{ $centerData['current_students'] }} / {{ $centerData['capacity'] }}
                                        ({{ $centerData['capacity'] > 0 ? round(($centerData['current_students'] / $centerData['capacity']) * 100) : 0 }}%)
                                    </span>
                                </div>
                                <div class="progress mt-1" style="height: 5px;">
                                    @php
                                        $percent = $centerData['capacity'] > 0 ? ($centerData['current_students'] / $centerData['capacity']) * 100 : 0;
                                        $color = $percent >= 90 ? 'danger' : ($percent >= 70 ? 'warning' : 'success');
                                    @endphp
                                    <div class="progress-bar bg-{{ $color }}" style="width: {{ $percent }}%"></div>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- السائق والملاحظات -->
            <div class="content-card mb-4">
                <h5 class="text-warning mb-4">
                    <i class="fas fa-cogs me-2"></i>
                    إعدادات إضافية
                </h5>
                
                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="driver_id" class="form-label">السائق</label>
                        <select class="form-select @error('driver_id') is-invalid @enderror" 
                                id="driver_id" 
                                name="driver_id">
                            <option value="">-- بدون سائق --</option>
                            @foreach($drivers as $driver)
                                <option value="{{ $driver->id }}" 
                                        {{ old('driver_id', $bus->driver_id) == $driver->id ? 'selected' : '' }}>
                                    {{ $driver->name }} - {{ $driver->mobile }}
                                    @if($driver->id == $bus->driver_id) (الحالي) @endif
                                </option>
                            @endforeach
                        </select>
                        @error('driver_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-12">
                        <label for="notes" class="form-label">ملاحظات</label>
                        <textarea class="form-control @error('notes') is-invalid @enderror" 
                                  id="notes" 
                                  name="notes" 
                                  rows="3">{{ old('notes', $bus->notes) }}</textarea>
                        @error('notes')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- أزرار التحكم -->
            <div class="content-card">
                <div class="d-flex justify-content-between align-items-center">
                    <button type="submit" class="btn btn-warning">
                        <i class="fas fa-save me-2"></i>
                        حفظ التعديلات
                    </button>
                    <a href="{{ route('admin.buses.index') }}" class="btn btn-outline-light">
                        <i class="fas fa-times me-2"></i>
                        إلغاء
                    </a>
                </div>
            </div>
        </form>
    </div>

    <!-- الشريط الجانبي -->
    <div class="col-lg-4">
        <!-- ملخص الباص -->
        <div class="content-card mb-4">
            <h6 class="text-primary mb-3">
                <i class="fas fa-chart-pie me-2"></i>
                ملخص الإشغال
            </h6>
            
            @php
                $totalCapacity = 0;
                $totalStudents = 0;
                foreach ($selectedCenters as $cid => $data) {
                    $totalCapacity += $data['capacity'];
                    $totalStudents += $data['current_students'];
                }
            @endphp
            
            <div class="text-center mb-3">
                <h3 class="mb-0">{{ $totalStudents }} / {{ $totalCapacity }}</h3>
                <small class="text-muted">إجمالي الطالبات / إجمالي السعة</small>
            </div>
            
            <div class="row text-center">
                <div class="col-4">
                    <h5 class="text-info mb-0">{{ count($selectedCenters) }}</h5>
                    <small class="text-muted">جهة</small>
                </div>
                <div class="col-4">
                    <h5 class="text-success mb-0">{{ $totalCapacity - $totalStudents }}</h5>
                    <small class="text-muted">متاح</small>
                </div>
                <div class="col-4">
                    <h5 class="text-warning mb-0">{{ $totalCapacity > 0 ? round(($totalStudents / $totalCapacity) * 100) : 0 }}%</h5>
                    <small class="text-muted">نسبة</small>
                </div>
            </div>
        </div>

        <!-- تفاصيل كل جهة -->
        <div class="content-card mb-4">
            <h6 class="text-info mb-3">
                <i class="fas fa-list me-2"></i>
                تفاصيل الجهات
            </h6>
            
            @forelse($bus->centers as $center)
            <div class="d-flex justify-content-between align-items-center py-2 border-bottom border-secondary">
                <div>
                    <strong class="text-light">{{ $center->center_name }}</strong>
                    <br>
                    <small class="text-muted">
                        {{ $center->pivot->schedule == 'both' ? 'صباحي ومسائي' : ($center->pivot->schedule == 'morning' ? 'صباحي' : 'مسائي') }}
                    </small>
                </div>
                <div class="text-end">
                    <span class="badge bg-{{ $center->pivot->current_students >= $center->pivot->capacity ? 'danger' : 'success' }}">
                        {{ $center->pivot->current_students }}/{{ $center->pivot->capacity }}
                    </span>
                </div>
            </div>
            @empty
            <p class="text-muted text-center mb-0">لا توجد جهات</p>
            @endforelse
        </div>

        <!-- روابط سريعة -->
        <div class="content-card">
            <h6 class="text-secondary mb-3">
                <i class="fas fa-link me-2"></i>
                روابط سريعة
            </h6>
            <div class="d-grid gap-2">
                <a href="{{ route('admin.buses.show', $bus) }}" class="btn btn-outline-light btn-sm">
                    <i class="fas fa-users me-2"></i>
                    عرض الطالبات
                </a>
                @if($bus->driver)
                <a href="{{ route('admin.drivers.show', $bus->driver) }}" class="btn btn-outline-light btn-sm">
                    <i class="fas fa-user me-2"></i>
                    ملف السائق
                </a>
                @endif
            </div>
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
}
</style>
@endpush

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const checkboxes = document.querySelectorAll('.center-checkbox');
    
    checkboxes.forEach(function(checkbox) {
        checkbox.addEventListener('change', function() {
            const centerId = this.dataset.centerId;
            const details = document.getElementById('centerDetails_' + centerId);
            const card = document.getElementById('centerCard_' + centerId);
            
            if (this.checked) {
                details.style.display = 'block';
                card.classList.add('selected');
            } else {
                // تحقق من وجود طالبات
                const minStudents = details.querySelector('.capacity-input')?.dataset.minStudents || 0;
                if (parseInt(minStudents) > 0) {
                    alert('لا يمكن إزالة هذه الجهة لوجود طالبات مسجلات');
                    this.checked = true;
                    return;
                }
                details.style.display = 'none';
                card.classList.remove('selected');
            }
        });
    });
    
    // التحقق من السعة
    document.querySelectorAll('.capacity-input').forEach(function(input) {
        input.addEventListener('change', function() {
            const min = parseInt(this.dataset.minStudents) || 0;
            if (parseInt(this.value) < min) {
                alert('لا يمكن تقليل السعة لأقل من عدد الطالبات الحاليات (' + min + ')');
                this.value = min;
            }
        });
    });
});
</script>
@endsection