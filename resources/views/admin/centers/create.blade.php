@extends('layouts.admin')

@php
    $type = request('type', 'دار');
    $typeInfo = [
        'دار' => ['title' => 'إضافة دار تحفيظ جديدة', 'icon' => 'mosque', 'color' => 'dar'],
        'مركز' => ['title' => 'إضافة مركز جديد', 'icon' => 'graduation-cap', 'color' => 'markaz'],
        'برنامج' => ['title' => 'إضافة برنامج رياحين جديد', 'icon' => 'seedling', 'color' => 'program'],
    ];
    $info = $typeInfo[$type] ?? $typeInfo['دار'];
@endphp

@section('title', $info['title'])

@section('header')
<div class="d-flex justify-content-between align-items-center w-100">
    <div>
        <h2 class="mb-1">
            <i class="fas fa-{{ $info['icon'] }} icon-color-{{ $info['color'] }} me-2"></i>
            {{ $info['title'] }}
        </h2>
        <p class="text-light mb-0 opacity-75">أدخل بيانات الجهة الجديدة</p>
    </div>
    <a href="{{ url('admin/centers') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-right me-1"></i>
        العودة للقائمة
    </a>
</div>
@endsection

@section('content')
<form action="{{ url('admin/centers') }}" method="POST" id="createCenterForm">
    @csrf
    <input type="hidden" name="type" value="{{ $type }}">
    
    <div class="row">
        <!-- العمود الأيمن - البيانات الأساسية -->
        <div class="col-lg-6">
            <!-- معلومات الجهة الأساسية -->
            <div class="content-card mb-4">
                <h5 class="section-title">
                    <i class="fas fa-info-circle icon-color-{{ $info['color'] }} me-2"></i>
                    المعلومات الأساسية
                </h5>
                
                <div class="mb-3">
                    <label class="form-label">اسم الجهة <span class="text-danger">*</span></label>
                    <input type="text" name="center_name" class="form-control @error('center_name') is-invalid @enderror"
                           value="{{ old('center_name') }}" required
                           placeholder="مثال: دار الفرقان لتحفيظ القرآن">
                    @error('center_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">الجنس <span class="text-danger">*</span></label>
                        <select name="gender" class="form-select @error('gender') is-invalid @enderror" required>
                            <option value="">-- اختر --</option>
                            <option value="بنات" {{ old('gender') == 'بنات' ? 'selected' : '' }}>بنات</option>
                            <option value="بنين" {{ old('gender') == 'بنين' ? 'selected' : '' }}>بنين</option>
                        </select>
                        @error('gender')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label class="form-label">الحالة</label>
                        <select name="status" class="form-select">
                            <option value="active" {{ old('status', 'active') == 'active' ? 'selected' : '' }}>نشط</option>
                            <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>غير نشط</option>
                        </select>
                    </div>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">العنوان</label>
                    <textarea name="address" class="form-control" rows="2"
                              placeholder="العنوان التفصيلي للجهة">{{ old('address') }}</textarea>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">رسوم النقل (ريال)</label>
                    <input type="number" name="transport_fee" class="form-control"
                           value="{{ old('transport_fee', 0) }}" min="0" step="0.01">
                </div>
            </div>
            
            <!-- إعدادات الفترات -->
            <div class="content-card mb-4">
                <h5 class="section-title">
                    <i class="fas fa-clock text-info me-2"></i>
                    إعدادات الفترات
                </h5>
                
                <!-- الفترة الصباحية -->
                <div class="period-card morning mb-3">
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" id="morning_available" 
                               name="morning_available" value="1" 
                               {{ old('morning_available') ? 'checked' : '' }}>
                        <label class="form-check-label" for="morning_available">
                            <i class="fas fa-sun text-warning me-1"></i>
                            <strong>الفترة الصباحية</strong>
                        </label>
                    </div>
                    <div class="row period-times" id="morningTimes">
                        <div class="col-6">
                            <label class="form-label small">من</label>
                            <input type="time" name="morning_start" class="form-control form-control-sm"
                                   value="{{ old('morning_start', '07:00') }}">
                        </div>
                        <div class="col-6">
                            <label class="form-label small">إلى</label>
                            <input type="time" name="morning_end" class="form-control form-control-sm"
                                   value="{{ old('morning_end', '12:00') }}">
                        </div>
                    </div>
                </div>
                
                <!-- الفترة المسائية -->
                <div class="period-card evening">
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" id="evening_available" 
                               name="evening_available" value="1"
                               {{ old('evening_available') ? 'checked' : '' }}>
                        <label class="form-check-label" for="evening_available">
                            <i class="fas fa-moon text-primary me-1"></i>
                            <strong>الفترة المسائية</strong>
                        </label>
                    </div>
                    <div class="row period-times" id="eveningTimes">
                        <div class="col-6">
                            <label class="form-label small">من</label>
                            <input type="time" name="evening_start" class="form-control form-control-sm"
                                   value="{{ old('evening_start', '16:00') }}">
                        </div>
                        <div class="col-6">
                            <label class="form-label small">إلى</label>
                            <input type="time" name="evening_end" class="form-control form-control-sm"
                                   value="{{ old('evening_end', '20:00') }}">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- العمود الأيسر - الخريطة والنطاق -->
        <div class="col-lg-6">
            <!-- الموقع الجغرافي -->
            <div class="content-card mb-4">
                <h5 class="section-title">
                    <i class="fas fa-map-marker-alt text-danger me-2"></i>
                    موقع الجهة
                </h5>
                
                <div class="row mb-3">
                    <div class="col-6">
                        <label class="form-label">خط العرض</label>
                        <input type="number" step="any" name="latitude" id="latitude" 
                               class="form-control" value="{{ old('latitude', '26.307') }}">
                    </div>
                    <div class="col-6">
                        <label class="form-label">خط الطول</label>
                        <input type="number" step="any" name="longitude" id="longitude" 
                               class="form-control" value="{{ old('longitude', '44.815') }}">
                    </div>
                </div>
                
                <div class="alert alert-info py-2 small">
                    <i class="fas fa-info-circle me-1"></i>
                    انقر على الخريطة لتحديد موقع الجهة
                </div>
            </div>
            
            <!-- النطاق الجغرافي -->
            <div class="content-card mb-4">
                <h5 class="section-title">
                    <i class="fas fa-draw-polygon text-success me-2"></i>
                    النطاق الجغرافي للخدمة
                </h5>
                
                <div class="mb-3">
                    <div class="btn-group w-100 mb-2">
                        <button type="button" class="btn btn-outline-info" onclick="toggleMapLayer()">
                            <i class="fas fa-layer-group me-1"></i>
                            تبديل الخريطة
                        </button>
                        <button type="button" class="btn btn-outline-success" onclick="startDrawing()">
                            <i class="fas fa-draw-polygon me-1"></i>
                            رسم النطاق
                        </button>
                        <button type="button" class="btn btn-outline-danger" onclick="clearPolygon()">
                            <i class="fas fa-trash me-1"></i>
                            مسح
                        </button>
                    </div>
                </div>
                
                <div id="map" style="height: 350px; border-radius: 10px;"></div>
                
                <input type="hidden" name="coverage_area" id="coverage_area">
                <input type="hidden" name="morning_coverage_area" id="morning_coverage_area">
                <input type="hidden" name="evening_coverage_area" id="evening_coverage_area">
                
                <div class="mt-3">
                    <small class="text-muted">
                        <i class="fas fa-info-circle me-1"></i>
                        انقر على النقاط لرسم نطاق الخدمة، ثم انقر على النقطة الأولى لإغلاق الشكل
                    </small>
                </div>
                
                <div id="polygonInfo" class="alert alert-success py-2 mt-2 d-none">
                    <i class="fas fa-check-circle me-1"></i>
                    تم تحديد النطاق الجغرافي (<span id="pointsCount">0</span> نقطة)
                </div>
            </div>
            
            <!-- ملاحظات -->
            <div class="content-card mb-4">
                <h5 class="section-title">
                    <i class="fas fa-sticky-note text-warning me-2"></i>
                    ملاحظات
                </h5>
                <textarea name="notes" class="form-control" rows="3"
                          placeholder="أي ملاحظات إضافية...">{{ old('notes') }}</textarea>
            </div>
        </div>
    </div>
    
    <!-- أزرار الحفظ -->
    <div class="content-card">
        <div class="d-flex justify-content-between">
            <a href="{{ url('admin/centers') }}" class="btn btn-secondary">
                <i class="fas fa-times me-1"></i>
                إلغاء
            </a>
            <button type="submit" class="btn btn-success btn-lg">
                <i class="fas fa-save me-1"></i>
                حفظ الجهة
            </button>
        </div>
    </div>
</form>
@endsection

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<style>
    .section-title {
        color: #7fb069;
        font-weight: bold;
        margin-bottom: 1.5rem;
        padding-bottom: 0.5rem;
        border-bottom: 2px solid rgba(127, 176, 105, 0.3);
    }
    
    .period-card {
        background: rgba(255, 255, 255, 0.05);
        border-radius: 10px;
        padding: 1rem;
        backdrop-filter: blur(10px);
    }
    
    .period-card.morning {
        border-right: 4px solid #ff9800;
    }
    
    .period-card.evening {
        border-right: 4px solid #2196f3;
    }
    
    #map {
        border: 2px solid rgba(127, 176, 105, 0.3);
    }
    
    .leaflet-container {
        background: #1a1a2e;
    }
    
    /* ألوان الأنواع */
    .icon-color-dar { color: #c86868 !important; }
    .icon-color-markaz { color: #ffb74d !important; }
    .icon-color-program { color: #81c784 !important; }
</style>
@endpush

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    let map;
    let marker;
    let polygon;
    let polygonPoints = [];
    let tempMarkers = [];
    let isDrawing = false;
    let currentLayer = 'street';
    let streetLayer, satelliteLayer;

    document.addEventListener('DOMContentLoaded', function() {
        initMap();
        setupEventListeners();
    });

    function initMap() {
        map = L.map('map').setView([26.307, 44.815], 13);

        streetLayer = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap'
        });

        satelliteLayer = L.tileLayer('https://mt1.google.com/vt/lyrs=s&x={x}&y={y}&z={z}', {
            attribution: '© Google'
        });

        streetLayer.addTo(map);

        map.on('click', function(e) {
            if (isDrawing) {
                addPolygonPoint(e.latlng);
            } else {
                setMarkerLocation(e.latlng.lat, e.latlng.lng);
            }
        });
    }

    function toggleMapLayer() {
        if (currentLayer === 'street') {
            map.removeLayer(streetLayer);
            satelliteLayer.addTo(map);
            currentLayer = 'satellite';
        } else {
            map.removeLayer(satelliteLayer);
            streetLayer.addTo(map);
            currentLayer = 'street';
        }
    }

    function setMarkerLocation(lat, lng) {
        document.getElementById('latitude').value = lat.toFixed(6);
        document.getElementById('longitude').value = lng.toFixed(6);

        if (marker) {
            map.removeLayer(marker);
        }

        marker = L.marker([lat, lng], {
            icon: L.divIcon({
                className: 'custom-marker',
                html: '<div style="background:#dc3545;width:20px;height:20px;border-radius:50%;border:3px solid white;box-shadow:0 2px 5px rgba(0,0,0,0.3);"></div>',
                iconSize: [20, 20],
                iconAnchor: [10, 10]
            })
        }).addTo(map);
    }

    function startDrawing() {
        isDrawing = true;
        clearPolygon();
        alert('انقر على الخريطة لإضافة نقاط النطاق.\nانقر على النقطة الأولى لإغلاق الشكل.');
    }

    function addPolygonPoint(latlng) {
        polygonPoints.push(latlng);

        const tempMarker = L.circleMarker(latlng, {
            radius: 6,
            color: '#7fb069',
            fillColor: '#7fb069',
            fillOpacity: 1
        }).addTo(map);
        tempMarkers.push(tempMarker);

        if (polygonPoints.length > 1) {
            if (polygon) {
                map.removeLayer(polygon);
            }
            polygon = L.polyline(polygonPoints, {
                color: '#7fb069',
                weight: 2,
                dashArray: '5, 5'
            }).addTo(map);
        }

        if (polygonPoints.length > 2) {
            const firstPoint = polygonPoints[0];
            const distance = map.distance(latlng, firstPoint);
            
            if (distance < 100) {
                closePolygon();
            }
        }

        updateCoverageInput();
    }

    function closePolygon() {
        isDrawing = false;
        
        if (polygon) {
            map.removeLayer(polygon);
        }

        polygon = L.polygon(polygonPoints, {
            color: '#7fb069',
            fillColor: '#7fb069',
            fillOpacity: 0.3,
            weight: 3
        }).addTo(map);

        document.getElementById('polygonInfo').classList.remove('d-none');
        document.getElementById('pointsCount').textContent = polygonPoints.length;

        updateCoverageInput();
    }

    function clearPolygon() {
        polygonPoints = [];
        
        if (polygon) {
            map.removeLayer(polygon);
            polygon = null;
        }

        tempMarkers.forEach(m => map.removeLayer(m));
        tempMarkers = [];

        document.getElementById('polygonInfo').classList.add('d-none');
        document.getElementById('coverage_area').value = '';
        document.getElementById('morning_coverage_area').value = '';
        document.getElementById('evening_coverage_area').value = '';
    }

    function updateCoverageInput() {
        const coverageData = polygonPoints.map(p => ({
            lat: p.lat,
            lng: p.lng
        }));
        
        const jsonData = JSON.stringify(coverageData);
        document.getElementById('coverage_area').value = jsonData;
        
        if (document.getElementById('morning_available').checked) {
            document.getElementById('morning_coverage_area').value = jsonData;
        }
        if (document.getElementById('evening_available').checked) {
            document.getElementById('evening_coverage_area').value = jsonData;
        }
    }

    function setupEventListeners() {
        document.getElementById('morning_available').addEventListener('change', function() {
            const times = document.getElementById('morningTimes');
            times.style.opacity = this.checked ? '1' : '0.5';
            updateCoverageInput();
        });

        document.getElementById('evening_available').addEventListener('change', function() {
            const times = document.getElementById('eveningTimes');
            times.style.opacity = this.checked ? '1' : '0.5';
            updateCoverageInput();
        });

        const morningAvailable = document.getElementById('morning_available').checked;
        const eveningAvailable = document.getElementById('evening_available').checked;
        
        document.getElementById('morningTimes').style.opacity = morningAvailable ? '1' : '0.5';
        document.getElementById('eveningTimes').style.opacity = eveningAvailable ? '1' : '0.5';
    }
</script>
@endpush
