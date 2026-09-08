@extends('layouts.admin')

@section('title', 'إضافة طالبة جديدة')

@section('header')
<div class="d-flex justify-content-between align-items-center w-100">
    <div>
        <h2 class="mb-1">
            <i class="fas fa-user-plus text-success me-2"></i>
            إضافة طالبة جديدة
        </h2>
        <p class="text-light mb-0 opacity-75">تسجيل طالبة جديدة في النظام</p>
    </div>
    <a href="{{ route('admin.students.index') }}" class="btn btn-outline-light">
        <i class="fas fa-arrow-right me-2"></i>
        رجوع للقائمة
    </a>
</div>
@endsection

@section('content')
<div class="content-card">
    <form action="{{ route('admin.students.store') }}" method="POST" id="studentForm">
        @csrf
        
        @if($errors->any())
        <div class="alert alert-danger">
            <i class="fas fa-exclamation-triangle me-2"></i>
            <strong>يرجى تصحيح الأخطاء التالية:</strong>
            <ul class="mb-0 mt-2">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        
        <!-- البيانات الشخصية -->
        <div class="section-title mb-4">
            <i class="fas fa-user me-2"></i>
            البيانات الشخصية
        </div>
        
        <div class="row g-3 mb-4">
            <div class="col-md-6">
                <label class="form-label">
                    <i class="fas fa-user text-success me-1"></i>
                    الاسم الكامل <span class="text-danger">*</span>
                </label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                       value="{{ old('name') }}" placeholder="أدخل الاسم الكامل" required>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="col-md-6">
                <label class="form-label">
                    <i class="fas fa-id-card text-success me-1"></i>
                    رقم الهوية الوطنية <span class="text-danger">*</span>
                </label>
                <input type="text" name="national_id" class="form-control @error('national_id') is-invalid @enderror" 
                       value="{{ old('national_id') }}" placeholder="1234567890" 
                       maxlength="10" pattern="[0-9]{10}" required>
                @error('national_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="col-md-6">
                <label class="form-label">
                    <i class="fas fa-calendar text-success me-1"></i>
                    تاريخ الميلاد <span class="text-danger">*</span>
                </label>
                <input type="date" name="birthdate" class="form-control @error('birthdate') is-invalid @enderror" 
                       value="{{ old('birthdate') }}" required>
                @error('birthdate')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="col-md-6">
                <label class="form-label">
                    <i class="fas fa-envelope text-success me-1"></i>
                    البريد الإلكتروني <span class="text-danger">*</span>
                </label>
                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" 
                       value="{{ old('email') }}" placeholder="example@email.com" required>
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="col-md-6">
                <label class="form-label">
                    <i class="fas fa-mobile text-success me-1"></i>
                    رقم الجوال <span class="text-danger">*</span>
                </label>
                <input type="tel" name="mobile" class="form-control @error('mobile') is-invalid @enderror" 
                       value="{{ old('mobile') }}" placeholder="05XXXXXXXX" 
                       pattern="05[0-9]{8}" maxlength="10" required>
                @error('mobile')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="col-md-6">
                <label class="form-label">
                    <i class="fas fa-home text-success me-1"></i>
                    العنوان التفصيلي
                </label>
                <input type="text" name="address" class="form-control @error('address') is-invalid @enderror" 
                       value="{{ old('address') }}" placeholder="الحي، الشارع">
                @error('address')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
        
        <!-- بيانات ولي الأمر -->
        <div class="section-title mb-4">
            <i class="fas fa-user-tie me-2"></i>
            بيانات ولي الأمر
        </div>
        
        <div class="row g-3 mb-4">
            <div class="col-md-6">
                <label class="form-label">
                    <i class="fas fa-user-tie text-success me-1"></i>
                    اسم ولي الأمر <span class="text-danger">*</span>
                </label>
                <input type="text" name="guardian_name" class="form-control @error('guardian_name') is-invalid @enderror" 
                       value="{{ old('guardian_name') }}" placeholder="اسم ولي الأمر" required>
                @error('guardian_name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="col-md-6">
                <label class="form-label">
                    <i class="fas fa-phone text-success me-1"></i>
                    جوال ولي الأمر <span class="text-danger">*</span>
                </label>
                <input type="tel" name="guardian_mobile" class="form-control @error('guardian_mobile') is-invalid @enderror" 
                       value="{{ old('guardian_mobile') }}" placeholder="05XXXXXXXX" 
                       pattern="05[0-9]{8}" maxlength="10" required>
                @error('guardian_mobile')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
        
        <!-- بيانات التسجيل -->
        <div class="section-title mb-4">
            <i class="fas fa-school me-2"></i>
            بيانات التسجيل
        </div>
        
        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <label class="form-label">
                    <i class="fas fa-clock text-success me-1"></i>
                    الفترة المفضلة <span class="text-danger">*</span>
                </label>
                <select name="preferred_schedule" id="preferred_schedule" class="form-select @error('preferred_schedule') is-invalid @enderror" required>
                    <option value="">-- اختر الفترة --</option>
                    <option value="صباحية" {{ old('preferred_schedule') == 'صباحية' ? 'selected' : '' }}>الفترة الصباحية</option>
                    <option value="مسائية" {{ old('preferred_schedule') == 'مسائية' ? 'selected' : '' }}>الفترة المسائية</option>
                </select>
                @error('preferred_schedule')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="col-md-4">
                <label class="form-label">
                    <i class="fas fa-school text-success me-1"></i>
                    المركز <span class="text-danger">*</span>
                </label>
                <select name="center_id" id="center_id" class="form-select @error('center_id') is-invalid @enderror" required>
                    <option value="">-- اختر الفترة أولاً --</option>
                </select>
                @error('center_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="col-md-4">
                <label class="form-label">
                    <i class="fas fa-info-circle text-success me-1"></i>
                    الحالة <span class="text-danger">*</span>
                </label>
                <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                    <option value="pending" {{ old('status', 'pending') == 'pending' ? 'selected' : '' }}>قيد المراجعة</option>
                    <option value="approved" {{ old('status') == 'approved' ? 'selected' : '' }}>مقبولة</option>
                    <option value="rejected" {{ old('status') == 'rejected' ? 'selected' : '' }}>مرفوضة</option>
                    <option value="suspended" {{ old('status') == 'suspended' ? 'selected' : '' }}>معلقة</option>
                </select>
                @error('status')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
        
        <!-- تحديد الموقع -->
        <div class="section-title mb-4">
            <i class="fas fa-map-marker-alt me-2"></i>
            تحديد الموقع
        </div>
        
        <div class="row g-3 mb-4">
            <div class="col-12">
                <p class="text-light mb-3">
                    <i class="fas fa-info-circle me-1"></i>
                    اختر الفترة والمركز أولاً، ثم انقر داخل المنطقة الخضراء لتحديد موقع الطالبة
                </p>
                
                <div class="d-flex gap-2 mb-3">
                    <button type="button" class="btn btn-success btn-sm" onclick="getCurrentLocation()">
                        <i class="fas fa-location-arrow me-1"></i>
                        تحديد الموقع الحالي
                    </button>
                    <button type="button" class="btn btn-outline-light btn-sm" onclick="toggleFullscreen()">
                        <i class="fas fa-expand me-1"></i>
                        ملء الشاشة
                    </button>
                </div>
                
                <div id="map"></div>
                
                <div id="location-info" class="mt-3" style="display: none;">
                    <div class="alert" id="location-status">
                        <span id="location-message"></span>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6">
                <label class="form-label">خط العرض (Latitude)</label>
                <input type="text" name="latitude" id="latitude" class="form-control" 
                       value="{{ old('latitude') }}" readonly>
            </div>
            
            <div class="col-md-6">
                <label class="form-label">خط الطول (Longitude)</label>
                <input type="text" name="longitude" id="longitude" class="form-control" 
                       value="{{ old('longitude') }}" readonly>
            </div>
        </div>
        
        <!-- ملاحظات -->
        <div class="section-title mb-4">
            <i class="fas fa-sticky-note me-2"></i>
            ملاحظات
        </div>
        
        <div class="row g-3 mb-4">
            <div class="col-12">
                <label class="form-label">ملاحظات إضافية</label>
                <textarea name="notes" class="form-control @error('notes') is-invalid @enderror" 
                          rows="3" placeholder="أي ملاحظات إضافية...">{{ old('notes') }}</textarea>
                @error('notes')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
        
        <!-- أزرار الإجراءات -->
        <div class="d-flex gap-3 justify-content-end pt-3 border-top border-secondary">
            <a href="{{ route('admin.students.index') }}" class="btn btn-outline-secondary px-4">
                <i class="fas fa-times me-2"></i>
                إلغاء
            </a>
            <button type="submit" class="btn btn-success px-4" id="submitBtn">
                <i class="fas fa-save me-2"></i>
                حفظ الطالبة
            </button>
        </div>
    </form>
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
    font-size: 1.1rem;
    font-weight: 600;
    color: #7fb069;
    padding-bottom: 0.5rem;
    border-bottom: 2px solid rgba(127, 176, 105, 0.3);
}

.form-control, .form-select {
    background: rgba(255,255,255,0.05);
    border-color: rgba(255,255,255,0.2);
    color: #fff;
}

.form-control:focus, .form-select:focus {
    background: rgba(255,255,255,0.1);
    border-color: #7fb069;
    color: #fff;
    box-shadow: 0 0 0 0.2rem rgba(127, 176, 105, 0.25);
}

.form-control::placeholder {
    color: rgba(255,255,255,0.4);
}

.form-control:read-only {
    background: rgba(255,255,255,0.02);
    color: rgba(255,255,255,0.7);
}

.form-select option {
    background: #1a4b3a;
    color: #fff;
}

.form-label {
    color: rgba(255,255,255,0.8);
    font-weight: 500;
}

.btn-success {
    background: linear-gradient(45deg, #7fb069, #90c695);
    border: none;
    color: #1a4b3a;
    font-weight: 600;
}

.btn-success:hover {
    background: linear-gradient(45deg, #90c695, #7fb069);
    color: #1a4b3a;
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(127, 176, 105, 0.4);
}

#map {
    height: 400px;
    border-radius: 10px;
    border: 2px solid rgba(127, 176, 105, 0.3);
}

.map-fullscreen {
    position: fixed !important;
    top: 0 !important;
    left: 0 !important;
    width: 100% !important;
    height: 100% !important;
    z-index: 9999 !important;
    border-radius: 0 !important;
}

body.map-fullscreen-active {
    overflow: hidden !important;
}

.fullscreen-close {
    position: fixed !important;
    top: 15px !important;
    right: 15px !important;
    z-index: 10001 !important;
    background: #dc3545 !important;
    color: white !important;
    border: none !important;
    padding: 10px 15px !important;
    border-radius: 25px !important;
    cursor: pointer !important;
}

.alert-success {
    background: rgba(40, 167, 69, 0.2);
    border-color: rgba(40, 167, 69, 0.3);
    color: #90EE90;
}

.alert-danger {
    background: rgba(220, 53, 69, 0.2);
    border-color: rgba(220, 53, 69, 0.3);
    color: #ffb3b3;
}
</style>
@endpush

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
let map;
let userMarker;
let currentPolygon = null;
let userLocation = null;
let isFullscreen = false;

// بيانات المراكز
const centersData = @json($centers ?? []);

// تنظيم المراكز حسب الفترة
const centersBySchedule = {
    "صباحية": [],
    "مسائية": []
};

centersData.forEach(center => {
    if (center.status !== 'active') return;
    
    const centerInfo = {
        id: center.id,
        name: center.center_name,
        lat: parseFloat(center.latitude),
        lng: parseFloat(center.longitude),
        address: center.address || 'الزلفي'
    };
    
    // الفترة الصباحية
    if (center.morning_available && center.morning_coverage_area) {
        try {
            const coverage = typeof center.morning_coverage_area === 'string' 
                ? JSON.parse(center.morning_coverage_area) 
                : center.morning_coverage_area;
            if (coverage && coverage.length > 0) {
                centersBySchedule["صباحية"].push({...centerInfo, coverage});
            }
        } catch (e) {
            console.warn('خطأ في نطاق صباحي:', center.center_name);
        }
    }
    
    // الفترة المسائية
    if (center.evening_available && center.evening_coverage_area) {
        try {
            const coverage = typeof center.evening_coverage_area === 'string' 
                ? JSON.parse(center.evening_coverage_area) 
                : center.evening_coverage_area;
            if (coverage && coverage.length > 0) {
                centersBySchedule["مسائية"].push({...centerInfo, coverage});
            }
        } catch (e) {
            console.warn('خطأ في نطاق مسائي:', center.center_name);
        }
    }
});

document.addEventListener('DOMContentLoaded', function() {
    initMap();
    setupEventListeners();
    
    // إذا كان هناك قيم سابقة
    const oldSchedule = "{{ old('preferred_schedule') }}";
    const oldCenterId = "{{ old('center_id') }}";
    const oldLat = "{{ old('latitude') }}";
    const oldLng = "{{ old('longitude') }}";
    
    if (oldSchedule) {
        document.getElementById('preferred_schedule').value = oldSchedule;
        updateCenterOptions();
        
        if (oldCenterId) {
            document.getElementById('center_id').value = oldCenterId;
            showCenterCoverage();
        }
    }
    
    if (oldLat && oldLng) {
        setUserLocation(parseFloat(oldLat), parseFloat(oldLng));
    }
});

function initMap() {
    const zulfiCoords = [26.3025, 44.8152];
    
    map = L.map('map').setView(zulfiCoords, 12);
    
    L.tileLayer('https://mt1.google.com/vt/lyrs=y&x={x}&y={y}&z={z}', {
        maxZoom: 20
    }).addTo(map);
    
    map.on('click', function(e) {
        setUserLocation(e.latlng.lat, e.latlng.lng);
    });
}

function setUserLocation(lat, lng) {
    userLocation = { lat, lng };
    
    if (userMarker) {
        map.removeLayer(userMarker);
    }

    const redIcon = L.icon({
        iconUrl: 'data:image/svg+xml;charset=UTF-8,' + encodeURIComponent(`
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#dc3545">
                <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/>
            </svg>
        `),
        iconSize: [35, 45],
        iconAnchor: [17, 45]
    });

    userMarker = L.marker([lat, lng], { icon: redIcon, draggable: true }).addTo(map);

    userMarker.on('dragend', function(e) {
        const newPos = e.target.getLatLng();
        userLocation = { lat: newPos.lat, lng: newPos.lng };
        document.getElementById('latitude').value = newPos.lat;
        document.getElementById('longitude').value = newPos.lng;
        checkLocationValidity();
    });

    document.getElementById('latitude').value = lat;
    document.getElementById('longitude').value = lng;

    checkLocationValidity();
}

function getCurrentLocation() {
    if (!navigator.geolocation) {
        alert('المتصفح لا يدعم تحديد الموقع');
        return;
    }

    const btn = event.target;
    const originalText = btn.innerHTML;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i> جاري التحديد...';
    btn.disabled = true;
    
    navigator.geolocation.getCurrentPosition(
        function(position) {
            setUserLocation(position.coords.latitude, position.coords.longitude);
            map.setView([position.coords.latitude, position.coords.longitude], 16);
            btn.innerHTML = originalText;
            btn.disabled = false;
        },
        function(error) {
            alert('تعذر تحديد الموقع. يرجى النقر على الخريطة يدوياً.');
            btn.innerHTML = originalText;
            btn.disabled = false;
        },
        { enableHighAccuracy: true, timeout: 10000 }
    );
}

function toggleFullscreen() {
    const mapElement = document.getElementById('map');
    
    if (isFullscreen) {
        mapElement.classList.remove('map-fullscreen');
        document.body.classList.remove('map-fullscreen-active');
        document.getElementById('closeFullscreenBtn')?.remove();
        isFullscreen = false;
    } else {
        mapElement.classList.add('map-fullscreen');
        document.body.classList.add('map-fullscreen-active');
        
        const closeBtn = document.createElement('button');
        closeBtn.id = 'closeFullscreenBtn';
        closeBtn.className = 'fullscreen-close';
        closeBtn.innerHTML = '<i class="fas fa-times me-1"></i> إغلاق';
        closeBtn.onclick = toggleFullscreen;
        document.body.appendChild(closeBtn);
        
        isFullscreen = true;
    }
    
    setTimeout(() => map.invalidateSize(), 100);
}

function updateCenterOptions() {
    const schedule = document.getElementById('preferred_schedule').value;
    const centerSelect = document.getElementById('center_id');
    
    centerSelect.innerHTML = '<option value="">-- اختر المركز --</option>';
    
    if (!schedule || !centersBySchedule[schedule]) return;

    centersBySchedule[schedule].forEach(center => {
        const option = document.createElement('option');
        option.value = center.id;
        option.textContent = `${center.name} - ${center.address}`;
        centerSelect.appendChild(option);
    });
}

function showCenterCoverage() {
    const schedule = document.getElementById('preferred_schedule').value;
    const selectedCenterId = document.getElementById('center_id').value;
    
    if (currentPolygon) {
        map.removeLayer(currentPolygon);
        currentPolygon = null;
    }

    if (!schedule || !selectedCenterId) {
        document.getElementById('location-info').style.display = 'none';
        return;
    }

    const selectedCenter = centersBySchedule[schedule].find(c => c.id == selectedCenterId);
    
    if (selectedCenter && selectedCenter.coverage && selectedCenter.coverage.length > 0) {
        currentPolygon = L.polygon(
            selectedCenter.coverage.map(p => [p.lat, p.lng]),
            {
                color: '#7fb069',
                fillColor: '#7fb069',
                fillOpacity: 0.25,
                weight: 3
            }
        ).addTo(map);

        L.marker([selectedCenter.lat, selectedCenter.lng]).addTo(map)
            .bindPopup(`<strong>${selectedCenter.name}</strong><br>${selectedCenter.address}`);

        map.fitBounds(currentPolygon.getBounds());

        if (userLocation) {
            checkLocationValidity();
        }
    }
}

function checkLocationValidity() {
    const schedule = document.getElementById('preferred_schedule').value;
    const selectedCenterId = document.getElementById('center_id').value;
    const locationInfo = document.getElementById('location-info');
    const locationStatus = document.getElementById('location-status');
    const locationMessage = document.getElementById('location-message');

    if (!userLocation || !schedule || !selectedCenterId) {
        locationInfo.style.display = 'none';
        return;
    }

    const selectedCenter = centersBySchedule[schedule].find(c => c.id == selectedCenterId);
    
    if (selectedCenter && isPointInPolygon(userLocation.lat, userLocation.lng, selectedCenter.coverage)) {
        locationStatus.className = 'alert alert-success';
        locationMessage.innerHTML = `
            <i class="fas fa-check-circle me-2"></i>
            <strong>ممتاز!</strong> الموقع داخل نطاق خدمة ${selectedCenter.name}
        `;
    } else {
        locationStatus.className = 'alert alert-danger';
        locationMessage.innerHTML = `
            <i class="fas fa-times-circle me-2"></i>
            <strong>تنبيه:</strong> الموقع خارج نطاق الخدمة
        `;
    }
    
    locationInfo.style.display = 'block';
}

function isPointInPolygon(lat, lng, polygon) {
    if (!polygon || polygon.length < 3) return false;

    let inside = false;
    for (let i = 0, j = polygon.length - 1; i < polygon.length; j = i++) {
        const xi = polygon[i].lat, yi = polygon[i].lng;
        const xj = polygon[j].lat, yj = polygon[j].lng;
        
        const intersect = ((yi > lng) !== (yj > lng))
            && (lat < (xj - xi) * (lng - yi) / (yj - yi) + xi);
        if (intersect) inside = !inside;
    }
    return inside;
}

function setupEventListeners() {
    document.getElementById('preferred_schedule').addEventListener('change', function() {
        updateCenterOptions();
        document.getElementById('center_id').value = '';
        if (currentPolygon) {
            map.removeLayer(currentPolygon);
            currentPolygon = null;
        }
        document.getElementById('location-info').style.display = 'none';
    });

    document.getElementById('center_id').addEventListener('change', showCenterCoverage);

    ['mobile', 'guardian_mobile', 'national_id'].forEach(id => {
        const el = document.getElementById(id);
        if (el) {
            el.addEventListener('input', function() {
                this.value = this.value.replace(/\D/g, '').slice(0, 10);
            });
        }
    });

    document.getElementById('studentForm').addEventListener('submit', function(e) {
        const lat = document.getElementById('latitude').value;
        const lng = document.getElementById('longitude').value;
        
        if (!lat || !lng) {
            e.preventDefault();
            alert('يرجى تحديد موقع الطالبة على الخريطة');
            return false;
        }

        document.getElementById('submitBtn').innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> جاري الحفظ...';
        document.getElementById('submitBtn').disabled = true;
    });

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && isFullscreen) {
            toggleFullscreen();
        }
    });
}
</script>
@endpush