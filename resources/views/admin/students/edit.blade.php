@extends('layouts.admin')

@section('title', 'تعديل بيانات - ' . $student->name)

@section('header')
<div class="d-flex justify-content-between align-items-center w-100">
    <div>
        <h2 class="mb-1">
            <i class="fas fa-user-edit text-warning me-2"></i>
            تعديل بيانات الطالب/ة
        </h2>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">لوحة التحكم</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.students.index') }}">الطلاب</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.students.show', $student) }}">{{ $student->name }}</a></li>
                <li class="breadcrumb-item active">تعديل</li>
            </ol>
        </nav>
    </div>
    <a href="{{ route('admin.students.show', $student) }}" class="btn btn-outline-light">
        <i class="fas fa-arrow-right me-1"></i>
        العودة
    </a>
</div>
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="content-card">
            <form action="{{ route('admin.students.update', $student) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="row">
                    <!-- البيانات الشخصية -->
                    <div class="col-12 mb-4">
                        <h5 class="section-title">
                            <i class="fas fa-user text-info me-2"></i>
                            البيانات الشخصية
                        </h5>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">الاسم الكامل <span class="text-danger">*</span></label>
                        <input type="text" 
                               name="name" 
                               class="form-control @error('name') is-invalid @enderror"
                               value="{{ old('name', $student->name) }}"
                               required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">الجنس <span class="text-danger">*</span></label>
                        <select name="gender" class="form-select @error('gender') is-invalid @enderror" required>
                            <option value="">-- اختر --</option>
                            <option value="ذكر" {{ old('gender', $student->gender) == 'ذكر' ? 'selected' : '' }}>ذكر</option>
                            <option value="أنثى" {{ old('gender', $student->gender) == 'أنثى' ? 'selected' : '' }}>أنثى</option>
                        </select>
                        @error('gender')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">رقم الهوية <span class="text-danger">*</span></label>
                        <input type="text" 
                               name="national_id" 
                               class="form-control @error('national_id') is-invalid @enderror"
                               value="{{ old('national_id', $student->national_id) }}"
                               maxlength="10"
                               pattern="[0-9]{10}"
                               required>
                        @error('national_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">10 أرقام</small>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">تاريخ الميلاد</label>
                        <input type="date" 
                               name="birthdate" 
                               class="form-control @error('birthdate') is-invalid @enderror"
                               value="{{ old('birthdate', $student->birthdate ? \Carbon\Carbon::parse($student->birthdate)->format('Y-m-d') : '') }}">
                        @error('birthdate')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">رقم الجوال <span class="text-danger">*</span></label>
                        <input type="tel" 
                               name="mobile" 
                               class="form-control @error('mobile') is-invalid @enderror"
                               value="{{ old('mobile', $student->mobile) }}"
                               pattern="05[0-9]{8}"
                               placeholder="05XXXXXXXX"
                               required>
                        @error('mobile')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">البريد الإلكتروني <small class="text-muted">(اختياري)</small></label>
                        <input type="email" 
                               name="email" 
                               class="form-control @error('email') is-invalid @enderror"
                               value="{{ old('email', $student->email) }}">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12 mb-3">
                        <label class="form-label">العنوان</label>
                        <input type="text" 
                               name="address" 
                               class="form-control @error('address') is-invalid @enderror"
                               value="{{ old('address', $student->address) }}"
                               placeholder="الحي، الشارع، المدينة">
                        @error('address')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- معلومات ولي الأمر -->
                    <div class="col-12 mb-4 mt-3">
                        <h5 class="section-title">
                            <i class="fas fa-user-shield text-warning me-2"></i>
                            معلومات ولي الأمر
                        </h5>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">اسم ولي الأمر <span class="text-danger">*</span></label>
                        <input type="text" 
                               name="guardian_name" 
                               class="form-control @error('guardian_name') is-invalid @enderror"
                               value="{{ old('guardian_name', $student->guardian_name) }}"
                               required>
                        @error('guardian_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">جوال ولي الأمر <span class="text-danger">*</span></label>
                        <input type="tel" 
                               name="guardian_mobile" 
                               class="form-control @error('guardian_mobile') is-invalid @enderror"
                               value="{{ old('guardian_mobile', $student->guardian_mobile) }}"
                               pattern="05[0-9]{8}"
                               placeholder="05XXXXXXXX"
                               required>
                        @error('guardian_mobile')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- معلومات الدراسة -->
                    <div class="col-12 mb-4 mt-3">
                        <h5 class="section-title">
                            <i class="fas fa-school text-success me-2"></i>
                            معلومات الدراسة والنقل
                        </h5>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">الجهة التعليمية <span class="text-danger">*</span></label>
                        <select name="center_id" class="form-select @error('center_id') is-invalid @enderror" required>
                            <option value="">-- اختر الجهة --</option>
                            @foreach($centers as $id => $name)
                                <option value="{{ $id }}" {{ old('center_id', $student->center_id) == $id ? 'selected' : '' }}>
                                    {{ $name }}
                                </option>
                            @endforeach
                        </select>
                        @error('center_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">الفترة <span class="text-danger">*</span></label>
                        <select name="preferred_schedule" class="form-select @error('preferred_schedule') is-invalid @enderror" required>
                            <option value="">-- اختر الفترة --</option>
                            @foreach($schedules as $key => $value)
                                <option value="{{ $key }}" {{ old('preferred_schedule', $student->preferred_schedule) == $key ? 'selected' : '' }}>
                                    {{ $value }}
                                </option>
                            @endforeach
                        </select>
                        @error('preferred_schedule')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">الحالة <span class="text-danger">*</span></label>
                        <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                            @foreach($statuses as $key => $value)
                                <option value="{{ $key }}" {{ old('status', $student->status) == $key ? 'selected' : '' }}>
                                    {{ $value }}
                                </option>
                            @endforeach
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- معلومات النقل -->
                    @if($student->assigned_bus_id)
                    <div class="col-md-6 mb-3">
                        <label class="form-label">نقطة الالتقاء</label>
                        <input type="text" 
                               name="pickup_point" 
                               class="form-control @error('pickup_point') is-invalid @enderror"
                               value="{{ old('pickup_point', $student->pickup_point) }}"
                               placeholder="مثال: أمام المسجد الكبير">
                        @error('pickup_point')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">وقت الالتقاء</label>
                        <input type="time" 
                               name="pickup_time" 
                               class="form-control @error('pickup_time') is-invalid @enderror"
                               value="{{ old('pickup_time', $student->pickup_time) }}">
                        @error('pickup_time')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    @endif

                    <!-- الإحداثيات -->
                    <div class="col-12 mb-4 mt-3">
                        <h5 class="section-title">
                            <i class="fas fa-map-marker-alt text-danger me-2"></i>
                            الموقع الجغرافي
                        </h5>
                    </div>

                    <div class="col-12 mb-3">
                        <div id="locationMap" style="height: 300px; border-radius: 10px; border: 1px solid rgba(255,255,255,0.2);"></div>
                        <small class="text-muted">انقر على الخريطة لتحديد الموقع</small>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">خط العرض (Latitude)</label>
                        <input type="number" 
                               step="any"
                               id="latitude"
                               name="latitude" 
                               class="form-control @error('latitude') is-invalid @enderror"
                               value="{{ old('latitude', $student->latitude) }}">
                        @error('latitude')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">خط الطول (Longitude)</label>
                        <input type="number" 
                               step="any"
                               id="longitude"
                               name="longitude" 
                               class="form-control @error('longitude') is-invalid @enderror"
                               value="{{ old('longitude', $student->longitude) }}">
                        @error('longitude')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- ملاحظات -->
                    <div class="col-12 mb-3">
                        <label class="form-label">ملاحظات</label>
                        <textarea name="notes" 
                                  class="form-control @error('notes') is-invalid @enderror"
                                  rows="3"
                                  placeholder="أي ملاحظات إضافية...">{{ old('notes', $student->notes) }}</textarea>
                        @error('notes')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <hr class="border-secondary my-4">

                <div class="d-flex justify-content-between">
                    <a href="{{ route('admin.students.show', $student) }}" class="btn btn-outline-secondary">
                        <i class="fas fa-times me-1"></i>
                        إلغاء
                    </a>
                    <button type="submit" class="btn btn-warning btn-lg">
                        <i class="fas fa-save me-2"></i>
                        حفظ التغييرات
                    </button>
                </div>
            </form>
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
    padding: 2rem;
    border: 1px solid rgba(255,255,255,0.1);
}

.section-title {
    color: var(--primary-color, #7fb069) !important;
    font-weight: bold;
    margin-bottom: 1rem;
    border-bottom: 2px solid rgba(127, 176, 105, 0.3);
    padding-bottom: 0.5rem;
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

.form-control::placeholder {
    color: rgba(255,255,255,0.4);
}

.form-select option {
    background: #1a4b3a;
    color: #fff;
}

.form-control:disabled, .form-control[readonly] {
    background: rgba(255,255,255,0.02);
    color: rgba(255,255,255,0.5);
}
</style>
@endpush

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // إعداد الخريطة
    const defaultLat = {{ $student->latitude ?? 26.3073 }};
    const defaultLng = {{ $student->longitude ?? 44.8091 }};
    
    const map = L.map('locationMap').setView([defaultLat, defaultLng], 14);
    
    L.tileLayer('https://mt1.google.com/vt/lyrs=y&x={x}&y={y}&z={z}', {
        maxZoom: 20,
        attribution: '© Google Maps'
    }).addTo(map);
    
    let marker = null;
    
    @if($student->latitude && $student->longitude)
    marker = L.marker([{{ $student->latitude }}, {{ $student->longitude }}]).addTo(map);
    @endif
    
    // النقر على الخريطة
    map.on('click', function(e) {
        const lat = e.latlng.lat.toFixed(6);
        const lng = e.latlng.lng.toFixed(6);
        
        document.getElementById('latitude').value = lat;
        document.getElementById('longitude').value = lng;
        
        if (marker) {
            marker.setLatLng(e.latlng);
        } else {
            marker = L.marker(e.latlng).addTo(map);
        }
    });
    
    // تحديث الخريطة عند تغيير الإحداثيات يدوياً
    document.getElementById('latitude').addEventListener('change', updateMarker);
    document.getElementById('longitude').addEventListener('change', updateMarker);
    
    function updateMarker() {
        const lat = parseFloat(document.getElementById('latitude').value);
        const lng = parseFloat(document.getElementById('longitude').value);
        
        if (lat && lng) {
            if (marker) {
                marker.setLatLng([lat, lng]);
            } else {
                marker = L.marker([lat, lng]).addTo(map);
            }
            map.setView([lat, lng], 15);
        }
    }
});
</script>
@endpush