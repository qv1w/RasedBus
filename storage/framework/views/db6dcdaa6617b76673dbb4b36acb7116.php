<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo e($pageTitle ?? 'تسجيل جديد'); ?> - جمعية القرآن الكريم للزلفي</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <style>
        :root {
            --primary-dark: #1a4b3a;
            --primary-light: #2d6b4f;
            --accent: #7fb069;
            --accent-light: #90c695;
        }

        body {
            background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary-light) 50%, var(--primary-dark) 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #ffffff;
        }

        .container {
            max-width: 900px;
            margin: 2rem auto;
            padding: 1rem;
        }

        .card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 20px;
            padding: 2rem;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.3);
        }

        .form-title {
            text-align: center;
            color: var(--accent);
            font-size: 1.6rem;
            margin-bottom: 0.5rem;
            font-weight: bold;
        }

        .form-subtitle {
            text-align: center;
            color: rgba(255,255,255,0.7);
            margin-bottom: 2rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            color: #e8f5e8;
            font-weight: 600;
            margin-bottom: 0.5rem;
            display: block;
        }

        .form-control, .form-select {
            background: rgba(255, 255, 255, 0.15);
            border: 2px solid rgba(127, 176, 105, 0.3);
            border-radius: 10px;
            padding: 0.8rem 1rem;
            color: white;
            transition: all 0.3s ease;
        }

        .form-control:focus, .form-select:focus {
            background: rgba(255, 255, 255, 0.2);
            border-color: var(--accent);
            color: white;
            box-shadow: 0 0 0 0.2rem rgba(127, 176, 105, 0.25);
        }

        .form-control::placeholder {
            color: rgba(255, 255, 255, 0.6);
        }

        .form-select option {
            background: var(--primary-dark);
            color: white;
        }

        .btn-success {
            background: linear-gradient(45deg, var(--accent), var(--accent-light));
            border: none;
            padding: 0.8rem 2rem;
            border-radius: 10px;
            color: var(--primary-dark);
            font-weight: bold;
            transition: all 0.3s ease;
        }

        .btn-success:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(127, 176, 105, 0.4);
            color: var(--primary-dark);
        }

        #map {
            height: 400px;
            border-radius: 10px;
            border: 2px solid rgba(127, 176, 105, 0.3);
        }

        .alert {
            border-radius: 10px;
            backdrop-filter: blur(10px);
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

        .section-title {
            color: var(--accent);
            font-size: 1.2rem;
            margin: 2rem 0 1rem;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid rgba(127, 176, 105, 0.3);
        }

        .back-link {
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            margin-bottom: 1rem;
            transition: color 0.3s;
        }

        .back-link:hover {
            color: var(--accent);
        }

        .info-badge {
            display: inline-block;
            padding: 0.5rem 1rem;
            border-radius: 10px;
            font-size: 0.9rem;
            margin-bottom: 1rem;
        }

        .info-badge.female {
            background: rgba(255, 105, 180, 0.2);
            border: 1px solid rgba(255, 105, 180, 0.4);
            color: #ffb6c1;
        }

        .info-badge.male {
            background: rgba(100, 149, 237, 0.2);
            border: 1px solid rgba(100, 149, 237, 0.4);
            color: #87cefa;
        }

        .fee-info {
            background: rgba(127, 176, 105, 0.2);
            border: 1px solid rgba(127, 176, 105, 0.4);
            border-radius: 10px;
            padding: 1rem;
            text-align: center;
            margin-bottom: 1.5rem;
        }

        .fee-info .amount {
            font-size: 1.5rem;
            font-weight: bold;
            color: var(--accent);
        }

        /* Fullscreen map */
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
    </style>
</head>
<body>
    <div class="container">
        <a href="<?php echo e(route('student.register')); ?>" class="back-link">
            <i class="fas fa-arrow-right me-2"></i>
            العودة لاختيار نوع التسجيل
        </a>

        <div class="card">
            <h2 class="form-title">
                <i class="fas fa-user-plus me-2"></i>
                <?php echo e($pageTitle ?? 'تسجيل جديد'); ?>

            </h2>
            
            <?php if($gender ?? false): ?>
            <div class="text-center">
                <span class="info-badge <?php echo e($gender == 'بنات' ? 'female' : 'male'); ?>">
                    <i class="fas fa-<?php echo e($gender == 'بنات' ? 'female' : 'male'); ?> me-1"></i>
                    <?php echo e($gender); ?>

                </span>
            </div>
            <?php endif; ?>

            <?php if(session('success')): ?>
                <div class="alert alert-success">
                    <i class="fas fa-check-circle me-2"></i>
                    <?php echo e(session('success')); ?>

                </div>
            <?php endif; ?>

            <?php if($errors->any()): ?>
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <strong>يرجى تصحيح الأخطاء التالية:</strong>
                    <ul class="mb-0 mt-2">
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><?php echo e($error); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form method="POST" action="<?php echo e(route('student.register.submit')); ?>" id="studentForm">
                <?php echo csrf_field(); ?>

                <!-- حقول مخفية -->
                <input type="hidden" name="gender" value="<?php echo e($gender == 'بنين' ? 'ذكر' : 'أنثى'); ?>">
                <input type="hidden" name="latitude" id="latitude" value="<?php echo e(old('latitude')); ?>">
                <input type="hidden" name="longitude" id="longitude" value="<?php echo e(old('longitude')); ?>">

                <!-- البيانات الشخصية -->
                <h5 class="section-title">
                    <i class="fas fa-user me-2"></i>
                    البيانات الشخصية
                </h5>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name" class="form-label">
                                <i class="fas fa-user text-success me-1"></i>
                                الاسم الكامل <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control" id="name" name="name" 
                                   value="<?php echo e(old('name')); ?>" required 
                                   placeholder="الاسم الرباعي">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="national_id" class="form-label">
                                <i class="fas fa-id-card text-success me-1"></i>
                                رقم الهوية <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control" id="national_id" name="national_id" 
                                   value="<?php echo e(old('national_id')); ?>" required maxlength="10"
                                   placeholder="10 أرقام" inputmode="numeric">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="birthdate" class="form-label">
                                <i class="fas fa-calendar text-success me-1"></i>
                                تاريخ الميلاد <span class="text-danger">*</span>
                            </label>
                            <input type="date" class="form-control" id="birthdate" name="birthdate" 
                                   value="<?php echo e(old('birthdate')); ?>" required>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="email" class="form-label">
                                <i class="fas fa-envelope text-success me-1"></i>
                                البريد الإلكتروني <small class="text-muted">(اختياري)</small>
                            </label>
                            <input type="email" class="form-control" id="email" name="email" 
                                   value="<?php echo e(old('email')); ?>"
                                   placeholder="example@email.com">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="mobile" class="form-label">
                                <i class="fas fa-mobile-alt text-success me-1"></i>
                                رقم الجوال <span class="text-danger">*</span>
                            </label>
                            <input type="tel" class="form-control" id="mobile" name="mobile" 
                                   value="<?php echo e(old('mobile')); ?>" required maxlength="10"
                                   placeholder="05XXXXXXXX" inputmode="numeric">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="address" class="form-label">
                                <i class="fas fa-home text-success me-1"></i>
                                العنوان
                            </label>
                            <input type="text" class="form-control" id="address" name="address" 
                                   value="<?php echo e(old('address')); ?>"
                                   placeholder="الحي - الشارع">
                        </div>
                    </div>
                </div>

                <!-- بيانات ولي الأمر -->
                <h5 class="section-title">
                    <i class="fas fa-users me-2"></i>
                    بيانات ولي الأمر
                </h5>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="guardian_name" class="form-label">
                                <i class="fas fa-user-shield text-success me-1"></i>
                                اسم ولي الأمر <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control" id="guardian_name" name="guardian_name" 
                                   value="<?php echo e(old('guardian_name')); ?>" required
                                   placeholder="الاسم الكامل">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="guardian_mobile" class="form-label">
                                <i class="fas fa-phone text-success me-1"></i>
                                جوال ولي الأمر <span class="text-danger">*</span>
                            </label>
                            <input type="tel" class="form-control" id="guardian_mobile" name="guardian_mobile" 
                                   value="<?php echo e(old('guardian_mobile')); ?>" required maxlength="10"
                                   placeholder="05XXXXXXXX" inputmode="numeric">
                        </div>
                    </div>
                </div>

                <!-- اختيار الجهة والفترة -->
                <h5 class="section-title">
                    <i class="fas fa-school me-2"></i>
                    <?php if($type == 'برنامج'): ?>
                        اختيار الحي
                    <?php else: ?>
                        اختيار الجهة والفترة
                    <?php endif; ?>
                </h5>

                <div class="row">
                    <?php if($type == 'مركز'): ?>
                        
                        <input type="hidden" name="preferred_schedule" value="صباحية">
                        <div class="col-md-12 mb-3">
                            <div class="alert alert-info">
                                <i class="fas fa-sun me-2"></i>
                                <strong>الفترة:</strong> صباحية فقط
                            </div>
                        </div>
                    <?php elseif($type == 'برنامج'): ?>
                        
                        <input type="hidden" name="preferred_schedule" value="مسائية">
                        <div class="col-md-12 mb-3">
                            <div class="alert alert-info">
                                <i class="fas fa-moon me-2"></i>
                                <strong>الفترة:</strong> مسائية فقط
                            </div>
                        </div>
                    <?php else: ?>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="preferred_schedule" class="form-label">
                                    <i class="fas fa-clock text-success me-1"></i>
                                    الفترة المفضلة <span class="text-danger">*</span>
                                </label>
                                <select class="form-select" id="preferred_schedule" name="preferred_schedule" required>
                                    <option value="">-- اختر الفترة --</option>
                                    <option value="صباحية" <?php echo e(old('preferred_schedule') == 'صباحية' ? 'selected' : ''); ?>>صباحية</option>
                                    <option value="مسائية" <?php echo e(old('preferred_schedule') == 'مسائية' ? 'selected' : ''); ?>>مسائية</option>
                                </select>
                            </div>
                        </div>
                    <?php endif; ?>

                    <div class="col-md-<?php echo e($type == 'دار' ? '6' : '12'); ?>">
                        <div class="form-group">
                            <label for="center_id" class="form-label">
                                <i class="fas fa-building text-success me-1"></i>
                                <?php if($type == 'دار'): ?>
                                    الدار
                                <?php elseif($type == 'مركز'): ?>
                                    المركز
                                <?php elseif($type == 'برنامج'): ?>
                                    الحي
                                <?php else: ?>
                                    الجهة
                                <?php endif; ?>
                                <span class="text-danger">*</span>
                            </label>
                            <select class="form-select" id="center_id" name="center_id" required>
                                <option value="">-- اختر --</option>
                                <?php if($type == 'مركز' || $type == 'برنامج'): ?>
                                    <?php $__currentLoopData = $centers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $center): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($center->id); ?>" <?php echo e(old('center_id') == $center->id ? 'selected' : ''); ?>>
                                            <?php if($type == 'برنامج'): ?>
                                                <?php echo e(str_contains($center->center_name, 'السيح') ? 'حي السيح' : 'حي الملك سلمان'); ?>

                                            <?php else: ?>
                                                <?php echo e($center->center_name); ?>

                                            <?php endif; ?>
                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- الخريطة -->
                <h5 class="section-title">
                    <i class="fas fa-map-marker-alt me-2"></i>
                    تحديد الموقع
                </h5>

                <div class="mb-3">
                    <div class="d-flex gap-2 mb-2 flex-wrap">
                        <button type="button" class="btn btn-outline-light btn-sm" id="layerBtn" onclick="toggleMapLayer()">
                            <i class="fas fa-satellite me-1"></i>
                            قمر صناعي
                        </button>
                        <button type="button" class="btn btn-outline-light btn-sm" onclick="toggleFullscreen()">
                            <i class="fas fa-expand me-1"></i>
                            تكبير الخريطة
                        </button>
                    </div>
                    <div id="map"></div>
                    <small class="text-light opacity-75 d-block mt-2">
                        <i class="fas fa-info-circle me-1"></i>
                        انقر على الخريطة لتحديد موقع السكن
                    </small>
                </div>

                <div id="location-info" style="display: none;">
                    <div id="location-status" class="alert">
                        <span id="location-message"></span>
                    </div>
                </div>

                <!-- ملاحظات -->
                <div class="form-group">
                    <label for="notes" class="form-label">
                        <i class="fas fa-sticky-note text-success me-1"></i>
                        ملاحظات إضافية
                    </label>
                    <textarea class="form-control" id="notes" name="notes" rows="3"
                              placeholder="أي ملاحظات تود إضافتها..."><?php echo e(old('notes')); ?></textarea>
                </div>

                <!-- زر الإرسال -->
                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-success btn-lg" id="submitBtn">
                        <i class="fas fa-paper-plane me-2"></i>
                        إرسال طلب التسجيل
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        let map, userMarker, currentPolygon;
        let userLocation = null;
        let isFullscreen = false;

        // بيانات المراكز من Laravel
        const centersData = <?php echo json_encode($centers, 15, 512) ?>;
        
        console.log('Centers Data:', centersData); // للتصحيح
        
        // تجميع المراكز حسب الفترة
        const centersBySchedule = {
            'صباحية': [],
            'مسائية': []
        };

        centersData.forEach(center => {
            console.log('Processing center:', center.center_name, 'morning:', center.morning_available, 'evening:', center.evening_available);
            
            const centerObj = {
                id: center.id,
                name: center.center_name,
                address: center.address || '',
                lat: parseFloat(center.latitude) || 26.307,
                lng: parseFloat(center.longitude) || 44.815,
                coverage: null,
                coverageType: center.coverage_type
            };

            // التحقق من الفترة الصباحية (قد تكون 1 أو true أو "1")
            const hasMorning = center.morning_available == 1 || center.morning_available === true || center.morning_available === '1';
            const hasEvening = center.evening_available == 1 || center.evening_available === true || center.evening_available === '1';

            if (hasMorning) {
                const morningCenter = {...centerObj};
                if (center.morning_coverage_area) {
                    try {
                        morningCenter.coverage = typeof center.morning_coverage_area === 'string' 
                            ? JSON.parse(center.morning_coverage_area) 
                            : center.morning_coverage_area;
                    } catch(e) {
                        morningCenter.coverage = [];
                    }
                } else if (center.coverage_area) {
                    try {
                        morningCenter.coverage = typeof center.coverage_area === 'string' 
                            ? JSON.parse(center.coverage_area) 
                            : center.coverage_area;
                    } catch(e) {
                        morningCenter.coverage = [];
                    }
                }
                centersBySchedule['صباحية'].push(morningCenter);
                console.log('Added to morning:', morningCenter.name);
            }

            if (hasEvening) {
                const eveningCenter = {...centerObj};
                if (center.evening_coverage_area) {
                    try {
                        eveningCenter.coverage = typeof center.evening_coverage_area === 'string' 
                            ? JSON.parse(center.evening_coverage_area) 
                            : center.evening_coverage_area;
                    } catch(e) {
                        eveningCenter.coverage = [];
                    }
                } else if (center.coverage_area) {
                    try {
                        eveningCenter.coverage = typeof center.coverage_area === 'string' 
                            ? JSON.parse(center.coverage_area) 
                            : center.coverage_area;
                    } catch(e) {
                        eveningCenter.coverage = [];
                    }
                }
                centersBySchedule['مسائية'].push(eveningCenter);
                console.log('Added to evening:', eveningCenter.name);
            }
        });
        
        console.log('Centers by Schedule:', centersBySchedule);

        document.addEventListener('DOMContentLoaded', function() {
            initMap();
            setupEventListeners();
            
            // للمركز والبرنامج - تحميل الجهات مباشرة
            const entityType = '<?php echo e($type ?? ""); ?>';
            if (entityType === 'مركز' || entityType === 'برنامج') {
                // الجهات محملة بالفعل في HTML
            }
        });

        let currentLayer = 'street';
        let streetLayer, satelliteLayer;

        function initMap() {
            map = L.map('map').setView([26.307, 44.815], 13);

            // طبقة الخريطة العادية
            streetLayer = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap'
            });

            // طبقة القمر الصناعي (Google)
            satelliteLayer = L.tileLayer('https://mt1.google.com/vt/lyrs=s&x={x}&y={y}&z={z}', {
                attribution: '© Google'
            });

            // البدء بالخريطة العادية
            streetLayer.addTo(map);

            map.on('click', function(e) {
                setUserLocation(e.latlng.lat, e.latlng.lng);
            });
        }

        function toggleMapLayer() {
            if (currentLayer === 'street') {
                map.removeLayer(streetLayer);
                satelliteLayer.addTo(map);
                currentLayer = 'satellite';
                document.getElementById('layerBtn').innerHTML = '<i class="fas fa-map me-1"></i> خريطة عادية';
            } else {
                map.removeLayer(satelliteLayer);
                streetLayer.addTo(map);
                currentLayer = 'street';
                document.getElementById('layerBtn').innerHTML = '<i class="fas fa-satellite me-1"></i> قمر صناعي';
            }
        }

        function setUserLocation(lat, lng) {
            userLocation = { lat, lng };
            
            document.getElementById('latitude').value = lat;
            document.getElementById('longitude').value = lng;

            if (userMarker) {
                map.removeLayer(userMarker);
            }

            userMarker = L.marker([lat, lng], {
                icon: L.divIcon({
                    className: 'custom-marker',
                    html: '<div style="background:#dc3545;width:20px;height:20px;border-radius:50%;border:3px solid white;box-shadow:0 2px 5px rgba(0,0,0,0.3);"></div>',
                    iconSize: [20, 20],
                    iconAnchor: [10, 10]
                })
            }).addTo(map);

            checkLocationValidity();
        }

        function getCurrentLocation() {
            if (!navigator.geolocation) {
                alert('متصفحك لا يدعم تحديد الموقع');
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
                    alert('تعذر تحديد موقعك. يرجى النقر على الخريطة يدوياً.');
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
            
            centerSelect.innerHTML = '<option value="">-- اختر --</option>';
            
            if (!schedule || !centersBySchedule[schedule]) return;

            centersBySchedule[schedule].forEach(center => {
                const option = document.createElement('option');
                option.value = center.id;
                option.textContent = center.name;
                if (center.address) {
                    option.textContent += ` - ${center.address}`;
                }
                centerSelect.appendChild(option);
            });
        }

        function showCenterCoverage() {
            const scheduleEl = document.getElementById('preferred_schedule');
            const entityType = '<?php echo e($type ?? ""); ?>';
            
            // تحديد الفترة
            let schedule;
            if (scheduleEl) {
                schedule = scheduleEl.value;
            } else if (entityType === 'مركز') {
                schedule = 'صباحية';
            } else if (entityType === 'برنامج') {
                schedule = 'مسائية';
            }
            
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
                    .bindPopup(`<strong>${selectedCenter.name}</strong>`);

                map.fitBounds(currentPolygon.getBounds());

                if (userLocation) {
                    checkLocationValidity();
                }
            } else if (selectedCenter && selectedCenter.coverageType === 'city_wide') {
                // المركز متاح لكل الزلفي
                document.getElementById('location-info').style.display = 'block';
                document.getElementById('location-status').className = 'alert alert-success';
                document.getElementById('location-message').innerHTML = `
                    <i class="fas fa-check-circle me-2"></i>
                    <strong>ممتاز!</strong> ${selectedCenter.name} متاح لجميع أحياء الزلفي
                `;
            }
        }

        function checkLocationValidity() {
            const scheduleEl = document.getElementById('preferred_schedule');
            const entityType = '<?php echo e($type ?? ""); ?>';
            
            // تحديد الفترة
            let schedule;
            if (scheduleEl) {
                schedule = scheduleEl.value;
            } else if (entityType === 'مركز') {
                schedule = 'صباحية';
            } else if (entityType === 'برنامج') {
                schedule = 'مسائية';
            }
            
            const selectedCenterId = document.getElementById('center_id').value;
            const locationInfo = document.getElementById('location-info');
            const locationStatus = document.getElementById('location-status');
            const locationMessage = document.getElementById('location-message');

            if (!userLocation || !schedule || !selectedCenterId) {
                locationInfo.style.display = 'none';
                return;
            }

            const selectedCenter = centersBySchedule[schedule].find(c => c.id == selectedCenterId);
            
            // إذا كان المركز متاح لكل الزلفي
            if (selectedCenter && selectedCenter.coverageType === 'city_wide') {
                locationStatus.className = 'alert alert-success';
                locationMessage.innerHTML = `
                    <i class="fas fa-check-circle me-2"></i>
                    <strong>ممتاز!</strong> ${selectedCenter.name} متاح لجميع أحياء الزلفي
                `;
                locationInfo.style.display = 'block';
                return;
            }

            if (selectedCenter && isPointInPolygon(userLocation.lat, userLocation.lng, selectedCenter.coverage)) {
                locationStatus.className = 'alert alert-success';
                locationMessage.innerHTML = `
                    <i class="fas fa-check-circle me-2"></i>
                    <strong>ممتاز!</strong> موقعك داخل نطاق خدمة ${selectedCenter.name}
                `;
            } else {
                locationStatus.className = 'alert alert-danger';
                locationMessage.innerHTML = `
                    <i class="fas fa-times-circle me-2"></i>
                    <strong>تنبيه:</strong> موقعك خارج نطاق الخدمة. يرجى اختيار موقع داخل المنطقة الخضراء.
                `;
            }
            
            locationInfo.style.display = 'block';
        }

        function isPointInPolygon(lat, lng, polygon) {
            if (!polygon || polygon.length < 3) return true; // إذا لم يكن هناك نطاق محدد، اقبل أي موقع

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
            const scheduleSelect = document.getElementById('preferred_schedule');
            const centerSelect = document.getElementById('center_id');
            const entityType = '<?php echo e($type ?? ""); ?>';

            // لو فيه اختيار فترة (للدور فقط)
            if (scheduleSelect) {
                scheduleSelect.addEventListener('change', function() {
                    updateCenterOptions();
                    centerSelect.value = '';
                    if (currentPolygon) {
                        map.removeLayer(currentPolygon);
                        currentPolygon = null;
                    }
                    document.getElementById('location-info').style.display = 'none';
                });
            }

            // استخدام showCenterCoverage للكل
            centerSelect.addEventListener('change', showCenterCoverage);

            ['mobile', 'guardian_mobile', 'national_id'].forEach(id => {
                const el = document.getElementById(id);
                if (el) {
                    el.addEventListener('input', function() {
                        this.value = this.value.replace(/\D/g, '').slice(0, 10);
                    });
                }
            });

            document.getElementById('studentForm').addEventListener('submit', function(e) {
                const selectedCenterId = centerSelect.value;

                if (!userLocation) {
                    e.preventDefault();
                    alert('يرجى تحديد موقعك على الخريطة');
                    return;
                }

                if (!selectedCenterId) {
                    e.preventDefault();
                    alert('يرجى اختيار الجهة');
                    return;
                }
            });
        }

            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && isFullscreen) {
                    toggleFullscreen();
                }
            });
    </script>
</body>
</html><?php /**PATH /home/rasedbus/project-bus/resources/views/student/create.blade.php ENDPATH**/ ?>