@extends('layouts.admin')

@php
    $typeInfo = [
        'دار' => ['title' => 'تعديل دار التحفيظ', 'icon' => 'mosque', 'color' => 'dar'],
        'مركز' => ['title' => 'تعديل المركز', 'icon' => 'graduation-cap', 'color' => 'markaz'],
        'برنامج' => ['title' => 'تعديل برنامج الرياحين', 'icon' => 'seedling', 'color' => 'program'],
    ];
    $info = $typeInfo[$center->type] ?? ['title' => 'تعديل الجهة', 'icon' => 'school', 'color' => 'info'];
@endphp

@section('title', $info['title'] . ' - ' . $center->center_name)

@section('header')
<div class="d-flex justify-content-between align-items-center w-100">
    <div>
        <h2 class="mb-1">
            <i class="fas fa-{{ $info['icon'] }} icon-color-{{ $info['color'] }} me-2"></i>
            {{ $info['title'] }}
        </h2>
        <p class="text-light mb-0 opacity-75">{{ $center->center_name }}</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ url('admin/centers/' . $center->id) }}" class="btn btn-outline-info">
            <i class="fas fa-eye me-1"></i>
            عرض
        </a>
        <a href="{{ url('admin/centers') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-right me-1"></i>
            العودة
        </a>
    </div>
</div>
@endsection

@section('content')
<form action="{{ url('admin/centers/' . $center->id) }}" method="POST" id="editCenterForm">
    @csrf
    @method('PUT')
    
    <div class="row">
        <!-- العمود الأيمن -->
        <div class="col-lg-6">
            <div class="content-card mb-4">
                <h5 class="section-title">
                    <i class="fas fa-info-circle icon-color-{{ $info['color'] }} me-2"></i>
                    المعلومات الأساسية
                </h5>
                
                <div class="mb-3">
                    <label class="form-label">اسم الجهة <span class="text-danger">*</span></label>
                    <input type="text" name="center_name" class="form-control @error('center_name') is-invalid @enderror"
                           value="{{ old('center_name', $center->center_name) }}" required>
                    @error('center_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">النوع</label>
                        <select name="type" class="form-select">
                            <option value="دار" {{ old('type', $center->type) == 'دار' ? 'selected' : '' }}>دار تحفيظ</option>
                            <option value="مركز" {{ old('type', $center->type) == 'مركز' ? 'selected' : '' }}>مركز</option>
                            <option value="برنامج" {{ old('type', $center->type) == 'برنامج' ? 'selected' : '' }}>برنامج رياحين</option>
                        </select>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label class="form-label">الجنس <span class="text-danger">*</span></label>
                        <select name="gender" class="form-select" required>
                            <option value="بنات" {{ old('gender', $center->gender) == 'بنات' ? 'selected' : '' }}>بنات</option>
                            <option value="بنين" {{ old('gender', $center->gender) == 'بنين' ? 'selected' : '' }}>بنين</option>
                        </select>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">الحالة</label>
                        <select name="status" class="form-select">
                            <option value="active" {{ old('status', $center->status) == 'active' ? 'selected' : '' }}>نشط</option>
                            <option value="inactive" {{ old('status', $center->status) == 'inactive' ? 'selected' : '' }}>غير نشط</option>
                        </select>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label class="form-label">رسوم النقل (ريال)</label>
                        <input type="number" name="transport_fee" class="form-control"
                               value="{{ old('transport_fee', $center->transport_fee ?? 0) }}" min="0" step="0.01">
                    </div>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">العنوان</label>
                    <textarea name="address" class="form-control" rows="2">{{ old('address', $center->address) }}</textarea>
                </div>
            </div>
            
            <!-- إعدادات الفترات -->
            <div class="content-card mb-4">
                <h5 class="section-title">
                    <i class="fas fa-clock text-info me-2"></i>
                    إعدادات الفترات
                </h5>
                
                <div class="period-card morning mb-3">
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" id="morning_available" 
                               name="morning_available" value="1" 
                               {{ old('morning_available', $center->morning_available) ? 'checked' : '' }}>
                        <label class="form-check-label" for="morning_available">
                            <i class="fas fa-sun text-warning me-1"></i>
                            <strong>الفترة الصباحية</strong>
                        </label>
                    </div>
                    <div class="row period-times" id="morningTimes">
                        <div class="col-6">
                            <label class="form-label small">من</label>
                            <input type="time" name="morning_start" class="form-control form-control-sm"
                                   value="{{ old('morning_start', $center->morning_start) }}">
                        </div>
                        <div class="col-6">
                            <label class="form-label small">إلى</label>
                            <input type="time" name="morning_end" class="form-control form-control-sm"
                                   value="{{ old('morning_end', $center->morning_end) }}">
                        </div>
                    </div>
                </div>
                
                <div class="period-card evening">
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" id="evening_available" 
                               name="evening_available" value="1"
                               {{ old('evening_available', $center->evening_available) ? 'checked' : '' }}>
                        <label class="form-check-label" for="evening_available">
                            <i class="fas fa-moon text-primary me-1"></i>
                            <strong>الفترة المسائية</strong>
                        </label>
                    </div>
                    <div class="row period-times" id="eveningTimes">
                        <div class="col-6">
                            <label class="form-label small">من</label>
                            <input type="time" name="evening_start" class="form-control form-control-sm"
                                   value="{{ old('evening_start', $center->evening_start) }}">
                        </div>
                        <div class="col-6">
                            <label class="form-label small">إلى</label>
                            <input type="time" name="evening_end" class="form-control form-control-sm"
                                   value="{{ old('evening_end', $center->evening_end) }}">
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="content-card mb-4">
                <h5 class="section-title">
                    <i class="fas fa-sticky-note text-warning me-2"></i>
                    ملاحظات
                </h5>
                <textarea name="notes" class="form-control" rows="3">{{ old('notes', $center->notes) }}</textarea>
            </div>
        </div>
        
        <!-- العمود الأيسر - الخريطة -->
        <div class="col-lg-6">
            <div class="content-card mb-4">
                <h5 class="section-title">
                    <i class="fas fa-map-marker-alt text-danger me-2"></i>
                    موقع الجهة
                </h5>
                
                <div class="row mb-3">
                    <div class="col-6">
                        <label class="form-label">خط العرض</label>
                        <input type="number" step="any" name="latitude" id="latitude" 
                               class="form-control" value="{{ old('latitude', $center->latitude ?? '26.307') }}">
                    </div>
                    <div class="col-6">
                        <label class="form-label">خط الطول</label>
                        <input type="number" step="any" name="longitude" id="longitude" 
                               class="form-control" value="{{ old('longitude', $center->longitude ?? '44.815') }}">
                    </div>
                </div>
            </div>
            
            <div class="content-card mb-4">
                <h5 class="section-title">
                    <i class="fas fa-draw-polygon text-success me-2"></i>
                    النطاق الجغرافي للخدمة
                    <span class="badge bg-success ms-2">قابل للتعديل</span>
                </h5>
                
                <div class="mb-3">
                    <div class="btn-group w-100 mb-2">
                        <button type="button" class="btn btn-outline-info" onclick="toggleMapLayer()">
                            <i class="fas fa-layer-group me-1"></i>
                            تبديل الخريطة
                        </button>
                        <button type="button" class="btn btn-outline-success" onclick="startDrawing()">
                            <i class="fas fa-draw-polygon me-1"></i>
                            رسم نطاق جديد
                        </button>
                        <button type="button" class="btn btn-outline-danger" onclick="clearPolygon()">
                            <i class="fas fa-trash me-1"></i>
                            مسح
                        </button>
                    </div>
                </div>
                
                <div id="map" style="height: 400px; border-radius: 10px;"></div>
                
                <input type="hidden" name="coverage_area" id="coverage_area" value="{{ old('coverage_area', json_encode($center->coverage_area)) }}">
                <input type="hidden" name="morning_coverage_area" id="morning_coverage_area" value="{{ old('morning_coverage_area', json_encode($center->morning_coverage_area)) }}">
                <input type="hidden" name="evening_coverage_area" id="evening_coverage_area" value="{{ old('evening_coverage_area', json_encode($center->evening_coverage_area)) }}">
                
                @php
                    $hasCoverage = !empty($center->coverage_area) || !empty($center->morning_coverage_area) || !empty($center->evening_coverage_area);
                @endphp
                
                <div id="polygonInfo" class="alert {{ $hasCoverage ? 'alert-success' : 'alert-warning' }} py-2 mt-2">
                    @if($hasCoverage)
                        <i class="fas fa-check-circle me-1"></i>
                        النطاق محدد (<span id="pointsCount">{{ count($center->coverage_area ?? $center->morning_coverage_area ?? []) }}</span> نقطة)
                    @else
                        <i class="fas fa-exclamation-triangle me-1"></i>
                        لم يتم تحديد نطاق جغرافي
                    @endif
                </div>
            </div>
        </div>
    </div>
    
    <div class="content-card">
        <div class="d-flex justify-content-between">
            <a href="{{ url('admin/centers') }}" class="btn btn-secondary">
                <i class="fas fa-times me-1"></i>
                إلغاء
            </a>
            <button type="submit" class="btn btn-success btn-lg">
                <i class="fas fa-save me-1"></i>
                حفظ التغييرات
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
    
    .period-card.morning { border-right: 4px solid #ff9800; }
    .period-card.evening { border-right: 4px solid #2196f3; }
    
    #map { border: 2px solid rgba(127, 176, 105, 0.3); }
    .leaflet-container { background: #1a1a2e; }
    
    .icon-color-dar { color: #c86868 !important; }
    .icon-color-markaz { color: #ffb74d !important; }
    .icon-color-program { color: #81c784 !important; }
</style>
@endpush

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    let map, marker, polygon;
    let polygonPoints = [];
    let tempMarkers = [];
    let isDrawing = false;
    let currentLayer = 'street';
    let streetLayer, satelliteLayer;

    const existingCoverage = @json($center->coverage_area ?? $center->morning_coverage_area ?? []);
    const centerLat = {{ $center->latitude ?? 26.307 }};
    const centerLng = {{ $center->longitude ?? 44.815 }};

    document.addEventListener('DOMContentLoaded', function() {
        initMap();
        loadExistingData();
        setupEventListeners();
    });

    function initMap() {
        map = L.map('map').setView([centerLat, centerLng], 14);

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

    function loadExistingData() {
        if (centerLat && centerLng) {
            setMarkerLocation(centerLat, centerLng);
        }

        if (existingCoverage && existingCoverage.length > 0) {
            polygonPoints = existingCoverage.map(p => L.latLng(p.lat, p.lng));
            
            polygon = L.polygon(polygonPoints, {
                color: '#7fb069',
                fillColor: '#7fb069',
                fillOpacity: 0.3,
                weight: 3
            }).addTo(map);

            document.getElementById('pointsCount').textContent = polygonPoints.length;
            map.fitBounds(polygon.getBounds());
        }
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

        if (marker) map.removeLayer(marker);

        marker = L.marker([lat, lng], {
            icon: L.divIcon({
                className: 'custom-marker',
                html: '<div style="background:#dc3545;width:20px;height:20px;border-radius:50%;border:3px solid white;"></div>',
                iconSize: [20, 20],
                iconAnchor: [10, 10]
            })
        }).addTo(map);
    }

    function startDrawing() {
        isDrawing = true;
        clearPolygon();
        alert('انقر على الخريطة لإضافة نقاط النطاق.');
    }

    function addPolygonPoint(latlng) {
        polygonPoints.push(latlng);

        const tempMarker = L.circleMarker(latlng, {
            radius: 6, color: '#7fb069', fillColor: '#7fb069', fillOpacity: 1
        }).addTo(map);
        tempMarkers.push(tempMarker);

        if (polygonPoints.length > 1) {
            if (polygon) map.removeLayer(polygon);
            polygon = L.polyline(polygonPoints, {
                color: '#7fb069', weight: 2, dashArray: '5, 5'
            }).addTo(map);
        }

        if (polygonPoints.length > 2) {
            const distance = map.distance(latlng, polygonPoints[0]);
            if (distance < 100) closePolygon();
        }

        updateCoverageInput();
    }

    function closePolygon() {
        isDrawing = false;
        tempMarkers.forEach(m => map.removeLayer(m));
        tempMarkers = [];
        
        if (polygon) map.removeLayer(polygon);

        polygon = L.polygon(polygonPoints, {
            color: '#7fb069', fillColor: '#7fb069', fillOpacity: 0.3, weight: 3
        }).addTo(map);

        const infoDiv = document.getElementById('polygonInfo');
        infoDiv.className = 'alert alert-success py-2 mt-2';
        infoDiv.innerHTML = '<i class="fas fa-check-circle me-1"></i> تم تحديد النطاق (<span id="pointsCount">' + polygonPoints.length + '</span> نقطة)';

        updateCoverageInput();
    }

    function clearPolygon() {
        polygonPoints = [];
        if (polygon) { map.removeLayer(polygon); polygon = null; }
        tempMarkers.forEach(m => map.removeLayer(m));
        tempMarkers = [];

        const infoDiv = document.getElementById('polygonInfo');
        infoDiv.className = 'alert alert-warning py-2 mt-2';
        infoDiv.innerHTML = '<i class="fas fa-exclamation-triangle me-1"></i> لم يتم تحديد نطاق';

        document.getElementById('coverage_area').value = '';
        document.getElementById('morning_coverage_area').value = '';
        document.getElementById('evening_coverage_area').value = '';
    }

    function updateCoverageInput() {
        const coverageData = polygonPoints.map(p => ({ lat: p.lat, lng: p.lng }));
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
            document.getElementById('morningTimes').style.opacity = this.checked ? '1' : '0.5';
            updateCoverageInput();
        });

        document.getElementById('evening_available').addEventListener('change', function() {
            document.getElementById('eveningTimes').style.opacity = this.checked ? '1' : '0.5';
            updateCoverageInput();
        });

        document.getElementById('morningTimes').style.opacity = document.getElementById('morning_available').checked ? '1' : '0.5';
        document.getElementById('eveningTimes').style.opacity = document.getElementById('evening_available').checked ? '1' : '0.5';
    }
</script>
@endpush
