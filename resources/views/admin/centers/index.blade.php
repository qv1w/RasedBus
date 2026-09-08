@extends('layouts.admin')

@section('title', 'إدارة الجهات')

@section('header')
<div class="d-flex justify-content-between align-items-center w-100">
    <div>
        @php
            $type = request('type');
            $titles = [
                'دار' => ['title' => 'إدارة دور التحفيظ', 'icon' => 'mosque', 'desc' => 'دور تحفيظ القرآن الكريم', 'color' => 'dar'],
                'مركز' => ['title' => 'مركز إعداد المعلمات', 'icon' => 'graduation-cap', 'desc' => 'مركز الشيخ فوزان الفهد رحمه الله', 'color' => 'markaz'],
                'برنامج' => ['title' => 'برامج الرياحين', 'icon' => 'seedling', 'desc' => 'برامج الأطفال التعليمية', 'color' => 'program'],
            ];
            $info = $titles[$type] ?? ['title' => 'إدارة الجهات التعليمية', 'icon' => 'school', 'desc' => 'جميع الجهات التعليمية', 'color' => 'info'];
            
            // صلاحيات الأدمن - المطور والمدير العام فقط
            $adminRole = session('admin_role', 'viewer');
            $canManage = in_array($adminRole, ['developer', 'super_admin']);
            
            $canAdd = $canManage;
            $canEdit = $canManage;
            $canDelete = $canManage;
        @endphp
        <h2 class="mb-1">
            <i class="fas fa-{{ $info['icon'] }} icon-color-{{ $info['color'] }} me-2"></i>
            {{ $info['title'] }}
        </h2>
        <p class="text-light mb-0 opacity-75">{{ $info['desc'] }}</p>
    </div>
    
    <!-- زر إضافة جهة جديدة - developer و super_admin فقط -->
    @if($canAdd)
    <div class="dropdown">
        <button class="btn btn-success dropdown-toggle" type="button" data-bs-toggle="dropdown">
            <i class="fas fa-plus me-1"></i>
            إضافة جهة جديدة
        </button>
        <ul class="dropdown-menu dropdown-menu-dark dropdown-menu-end">
            <li>
                <a class="dropdown-item" href="{{ url('admin/centers/create') }}?type=دار">
                    <i class="fas fa-mosque icon-color-dar me-2"></i>
                    إضافة دار تحفيظ
                </a>
            </li>
            <li>
                <a class="dropdown-item" href="{{ url('admin/centers/create') }}?type=مركز">
                    <i class="fas fa-graduation-cap icon-color-markaz me-2"></i>
                    إضافة مركز
                </a>
            </li>
            <li>
                <a class="dropdown-item" href="{{ url('admin/centers/create') }}?type=برنامج">
                    <i class="fas fa-seedling icon-color-program me-2"></i>
                    إضافة برنامج رياحين
                </a>
            </li>
        </ul>
    </div>
    @else
    <span class="badge bg-secondary py-2 px-3">
        <i class="fas fa-eye me-1"></i>
        عرض فقط
    </span>
    @endif
</div>
@endsection

@section('content')
<!-- شريط الصلاحيات -->
<div class="alert alert-{{ $canManage ? 'success' : 'warning' }} py-2 mb-4">
    <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
        <div>
            <i class="fas fa-{{ $canManage ? ($adminRole == 'developer' ? 'code' : 'crown') : 'eye' }} me-2"></i>
            <strong>صلاحياتك:</strong>
            @if($adminRole == 'developer')
                مطور النظام (جميع الصلاحيات)
            @elseif($adminRole == 'super_admin')
                مدير عام (جميع الصلاحيات)
            @else
                {{ $adminRole == 'admin' ? 'مشرف' : 'مشاهد' }} (عرض فقط)
            @endif
        </div>
        <div class="d-flex flex-wrap gap-1">
            @if($canManage)
                <span class="badge bg-success"><i class="fas fa-plus"></i> إضافة</span>
                <span class="badge bg-warning text-dark"><i class="fas fa-edit"></i> تعديل</span>
                <span class="badge bg-danger"><i class="fas fa-trash"></i> حذف</span>
            @else
                <span class="badge bg-secondary"><i class="fas fa-eye"></i> عرض فقط</span>
            @endif
        </div>
    </div>
</div>

<!-- فلاتر التصنيف -->
<div class="content-card mb-4">
    <div class="d-flex flex-wrap gap-2 align-items-center">
        <span class="text-muted me-2"><i class="fas fa-filter me-1"></i> تصنيف:</span>
        
        <a href="{{ url('admin/centers') }}" 
           class="btn btn-sm {{ !request('type') ? 'btn-primary' : 'btn-outline-secondary' }}">
            <i class="fas fa-th-large me-1"></i> الكل
        </a>
        
        <a href="{{ url('admin/centers') }}?type=دار" 
           class="btn btn-sm {{ request('type') == 'دار' ? 'btn-dar' : 'btn-outline-dar' }}">
            <i class="fas fa-mosque me-1"></i> دور التحفيظ
        </a>
        
        <a href="{{ url('admin/centers') }}?type=مركز" 
           class="btn btn-sm {{ request('type') == 'مركز' ? 'btn-markaz' : 'btn-outline-markaz' }}">
            <i class="fas fa-graduation-cap me-1"></i> مركز إعداد المعلمات
        </a>
        
        <a href="{{ url('admin/centers') }}?type=برنامج" 
           class="btn btn-sm {{ request('type') == 'برنامج' ? 'btn-program' : 'btn-outline-program' }}">
            <i class="fas fa-seedling me-1"></i> برامج الرياحين
        </a>
    </div>
</div>

<!-- إحصائيات سريعة -->
<div class="row mb-4">
    @php
        $statsQuery = \App\Models\Center::query();
        if($type) {
            $statsQuery->where('type', $type);
        }
        $totalCenters = (clone $statsQuery)->count();
        $activeCenters = (clone $statsQuery)->where('status', 'active')->count();
        
        $studentsQuery = \App\Models\Student::query();
        if($type) {
            $studentsQuery->whereHas('center', fn($q) => $q->where('type', $type));
        }
        $totalStudents = $studentsQuery->count();
        
        $busesQuery = \App\Models\Bus::query();
        if($type) {
            $busesQuery->whereHas('center', fn($q) => $q->where('type', $type));
        }
        $totalBuses = $busesQuery->count();
    @endphp
    
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="stats-card">
            <div class="d-flex align-items-center">
                <div class="stats-icon icon-type-{{ $info['color'] }} me-3">
                    <i class="fas fa-{{ $info['icon'] }} fa-lg"></i>
                </div>
                <div>
                    <h3 class="icon-color-{{ $info['color'] }} mb-0">{{ $totalCenters }}</h3>
                    <p class="text-muted mb-0">إجمالي الجهات</p>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="stats-card">
            <div class="d-flex align-items-center">
                <div class="stats-icon icon-stats-success me-3">
                    <i class="fas fa-check-circle fa-lg"></i>
                </div>
                <div>
                    <h3 class="text-success mb-0">{{ $activeCenters }}</h3>
                    <p class="text-muted mb-0">النشطة</p>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="stats-card">
            <div class="d-flex align-items-center">
                <div class="stats-icon icon-stats-primary me-3">
                    <i class="fas fa-user-graduate fa-lg"></i>
                </div>
                <div>
                    <h3 class="text-primary mb-0">{{ $totalStudents }}</h3>
                    <p class="text-muted mb-0">الطلاب</p>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="stats-card">
            <div class="d-flex align-items-center">
                <div class="stats-icon icon-stats-warning me-3">
                    <i class="fas fa-bus fa-lg"></i>
                </div>
                <div>
                    <h3 class="text-warning mb-0">{{ $totalBuses }}</h3>
                    <p class="text-muted mb-0">الباصات</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- جدول الجهات -->
<div class="content-card">
    @if($centers->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>الاسم</th>
                        @if(!$type)
                        <th>النوع</th>
                        @endif
                        <th>الجنس</th>
                        <th>الفترات</th>
                        <th>النطاق</th>
                        <th>الباصات</th>
                        <th>الطلاب</th>
                        <th>الحالة</th>
                        <th>العمليات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($centers as $center)
                    @php
                        $typeIcons = ['دار' => 'mosque', 'مركز' => 'graduation-cap', 'برنامج' => 'seedling'];
                        $typeClasses = ['دار' => 'dar', 'مركز' => 'markaz', 'برنامج' => 'program'];
                    @endphp
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="me-3">
                                    <div class="center-icon icon-type-{{ $typeClasses[$center->type] ?? 'info' }}">
                                        <i class="fas fa-{{ $typeIcons[$center->type] ?? 'school' }}"></i>
                                    </div>
                                </div>
                                <div>
                                    <div class="fw-bold text-white">{{ $center->center_name }}</div>
                                    @if($center->address)
                                        <small class="text-muted">{{ Str::limit($center->address, 30) }}</small>
                                    @endif
                                </div>
                            </div>
                        </td>
                        
                        @if(!$type)
                        <td>
                            <span class="badge badge-type-{{ $typeClasses[$center->type] ?? 'secondary' }}">
                                <i class="fas fa-{{ $typeIcons[$center->type] ?? 'building' }} me-1"></i>
                                {{ $center->type }}
                            </span>
                        </td>
                        @endif
                        
                        <td>
                            <span class="badge {{ $center->gender == 'بنات' ? 'badge-gender-female' : 'badge-gender-male' }}">
                                <i class="fas fa-{{ $center->gender == 'بنات' ? 'female' : 'male' }} me-1"></i>
                                {{ $center->gender }}
                            </span>
                        </td>
                        
                        <td>
                            <div class="d-flex flex-column gap-1">
                                @if($center->morning_available)
                                    <span class="badge badge-period-morning">
                                        <i class="fas fa-sun me-1"></i>صباحية
                                    </span>
                                @endif
                                @if($center->evening_available)
                                    <span class="badge badge-period-evening">
                                        <i class="fas fa-moon me-1"></i>مسائية
                                    </span>
                                @endif
                            </div>
                        </td>
                        
                        <td>
                            @php
                                $hasCoverage = !empty($center->coverage_area) || !empty($center->morning_coverage_area) || !empty($center->evening_coverage_area);
                            @endphp
                            @if($hasCoverage)
                                <span class="badge bg-success">
                                    <i class="fas fa-map-marked-alt me-1"></i>محدد
                                </span>
                            @else
                                <span class="badge bg-secondary">
                                    <i class="fas fa-map me-1"></i>غير محدد
                                </span>
                            @endif
                        </td>
                        
                        <td>
                            <span class="badge bg-warning fs-6">{{ $center->buses()->count() }}</span>
                        </td>

                        <td>
                            <span class="badge bg-success fs-6">{{ $center->students()->count() }}</span>
                        </td>
                         
                        <td>
                            @php
                                $statusColors = ['active' => 'success', 'inactive' => 'danger'];
                                $statusTexts = ['active' => 'نشط', 'inactive' => 'موقوف'];
                            @endphp
                            <span class="badge bg-{{ $statusColors[$center->status] ?? 'secondary' }}">
                                {{ $statusTexts[$center->status] ?? $center->status }}
                            </span>
                        </td>
                        
                        <td>
                            <div class="btn-group">
                                <!-- عرض - للجميع -->
                                <a href="{{ url('admin/centers/' . $center->id) }}" 
                                   class="btn btn-sm btn-outline-info" title="عرض">
                                    <i class="fas fa-eye"></i>
                                </a>
                                
                                <!-- تعديل - developer و super_admin فقط -->
                                @if($canEdit)
                                <a href="{{ url('admin/centers/' . $center->id . '/edit') }}" 
                                   class="btn btn-sm btn-outline-warning" title="تعديل">
                                    <i class="fas fa-edit"></i>
                                </a>
                                
                                <!-- تبديل الحالة -->
                                @if($center->status == 'active')
                                <form action="{{ url('admin/centers/' . $center->id . '/toggle-status') }}" 
                                      method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-outline-light" 
                                            title="إيقاف"
                                            onclick="return confirm('هل تريد إيقاف هذه الجهة؟')">
                                        <i class="fas fa-pause"></i>
                                    </button>
                                </form>
                                @else
                                <form action="{{ url('admin/centers/' . $center->id . '/toggle-status') }}" 
                                      method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-outline-success" 
                                            title="تفعيل">
                                        <i class="fas fa-play"></i>
                                    </button>
                                </form>
                                @endif
                                @endif
                                
                                <!-- حذف - developer و super_admin فقط -->
                                @if($canDelete)
                                <button type="button" class="btn btn-sm btn-outline-danger" 
                                        title="حذف"
                                        onclick="showDeleteModal({{ $center->id }}, '{{ $center->center_name }}', {{ $center->students()->count() }}, {{ $center->buses()->count() }})">
                                    <i class="fas fa-trash"></i>
                                </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        @if($centers->hasPages())
        <div class="d-flex justify-content-center mt-4">
            {{ $centers->withQueryString()->links() }}
        </div>
        @endif
    @else
        <div class="text-center py-5">
            <i class="fas fa-{{ $info['icon'] }} fa-4x text-muted opacity-50 mb-3"></i>
            <h4 class="text-light mb-3">لا توجد جهات</h4>
            <p class="text-light opacity-75 mb-4">لم يتم إنشاء أي جهات بعد</p>
            @if($canAdd)
            <div class="dropdown d-inline-block">
                <button class="btn btn-success dropdown-toggle" type="button" data-bs-toggle="dropdown">
                    <i class="fas fa-plus me-1"></i>
                    إضافة جهة جديدة
                </button>
                <ul class="dropdown-menu dropdown-menu-dark">
                    <li>
                        <a class="dropdown-item" href="{{ url('admin/centers/create') }}?type=دار">
                            <i class="fas fa-mosque icon-color-dar me-2"></i>
                            إضافة دار تحفيظ
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="{{ url('admin/centers/create') }}?type=مركز">
                            <i class="fas fa-graduation-cap icon-color-markaz me-2"></i>
                            إضافة مركز
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="{{ url('admin/centers/create') }}?type=برنامج">
                            <i class="fas fa-seedling icon-color-program me-2"></i>
                            إضافة برنامج رياحين
                        </a>
                    </li>
                </ul>
            </div>
            @endif
        </div>
    @endif
</div>

<!-- Modal الحذف الآمن -->
@if($canDelete)
<div class="modal fade" id="deleteModal" tabindex="-1" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-dark text-white">
            <div class="modal-header border-danger">
                <h5 class="modal-title text-danger">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    تحذير: حذف جهة تعليمية
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <!-- المرحلة 1: التحذير -->
                <div id="deleteStep1">
                    <div class="alert alert-danger">
                        <h6 class="alert-heading">
                            <i class="fas fa-skull-crossbones me-2"></i>
                            عملية لا يمكن التراجع عنها!
                        </h6>
                        <hr>
                        <p class="mb-0">أنت على وشك حذف:</p>
                    </div>
                    
                    <div class="card bg-secondary mb-3">
                        <div class="card-body text-center">
                            <h4 id="deleteCenterName" class="text-danger mb-3"></h4>
                            <div class="row">
                                <div class="col-6">
                                    <div class="h3 text-warning" id="deleteStudentsCount">0</div>
                                    <small>طالب/ة مسجل</small>
                                </div>
                                <div class="col-6">
                                    <div class="h3 text-info" id="deleteBusesCount">0</div>
                                    <small>باص مرتبط</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="alert alert-warning" id="deleteWarning" style="display: none;">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        <strong>تنبيه:</strong> يوجد طلاب أو باصات مرتبطة! لن تتمكن من الحذف.
                    </div>
                    
                    <button type="button" class="btn btn-outline-danger w-100" id="proceedBtn" onclick="goToStep2()">
                        <i class="fas fa-arrow-left me-2"></i>
                        أفهم المخاطر، متابعة
                    </button>
                </div>
                
                <!-- المرحلة 2: التأكيد بكتابة الاسم -->
                <div id="deleteStep2" style="display: none;">
                    <div class="alert alert-info">
                        <i class="fas fa-keyboard me-2"></i>
                        للتأكيد، اكتب اسم الجهة بالضبط:
                    </div>
                    
                    <div class="text-center mb-3">
                        <code class="fs-5 text-danger" id="confirmNameDisplay"></code>
                    </div>
                    
                    <input type="text" id="confirmNameInput" class="form-control form-control-lg mb-3" 
                           placeholder="اكتب اسم الجهة هنا..." autocomplete="off" dir="rtl">
                    
                    <div class="alert alert-danger py-2" id="nameMatchError" style="display: none;">
                        <i class="fas fa-times-circle me-2"></i>
                        الاسم غير مطابق!
                    </div>
                    
                    <form id="deleteForm" method="POST">
                        @csrf
                        @method('DELETE')
                        <div class="d-flex gap-2">
                            <button type="button" class="btn btn-secondary flex-fill" onclick="goToStep1()">
                                <i class="fas fa-arrow-right me-1"></i>
                                رجوع
                            </button>
                            <button type="submit" class="btn btn-danger flex-fill" id="confirmDeleteBtn" disabled>
                                <i class="fas fa-trash me-1"></i>
                                حذف نهائي
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endif
@endsection

@push('styles')
<style>
    /* ==========================================
       🎨 ألوان الأنواع
       ========================================== */
    
    /* دور التحفيظ - أحمر */
    .icon-type-dar, .center-icon.icon-type-dar {
        background: rgba(176, 39, 39, 0.15) !important;
        color: #c86868 !important;
        border: 1px solid rgba(176, 39, 39, 0.3) !important;
    }
    .icon-color-dar { color: #c86868 !important; }
    .badge-type-dar, .bg-dar {
        background: rgba(176, 39, 39, 0.15) !important;
        color: #c86868 !important;
        border: 1px solid rgba(176, 39, 39, 0.3) !important;
    }
    .btn-dar {
        background: rgba(176, 39, 39, 0.2) !important;
        color: #c86868 !important;
        border: 1px solid rgba(176, 39, 39, 0.4) !important;
    }
    .btn-outline-dar {
        background: transparent !important;
        color: #c86868 !important;
        border: 1px solid rgba(176, 39, 39, 0.3) !important;
    }
    .btn-outline-dar:hover, .btn-dar:hover {
        background: rgba(176, 39, 39, 0.25) !important;
        border-color: rgba(176, 39, 39, 0.5) !important;
    }
    
    /* مركز - برتقالي */
    .icon-type-markaz, .center-icon.icon-type-markaz {
        background: rgba(255, 152, 0, 0.15) !important;
        color: #ffb74d !important;
        border: 1px solid rgba(255, 152, 0, 0.3) !important;
    }
    .icon-color-markaz { color: #ffb74d !important; }
    .badge-type-markaz, .bg-markaz {
        background: rgba(255, 152, 0, 0.15) !important;
        color: #ffb74d !important;
        border: 1px solid rgba(255, 152, 0, 0.3) !important;
    }
    .btn-markaz {
        background: rgba(255, 152, 0, 0.2) !important;
        color: #ffb74d !important;
        border: 1px solid rgba(255, 152, 0, 0.4) !important;
    }
    .btn-outline-markaz {
        background: transparent !important;
        color: #ffb74d !important;
        border: 1px solid rgba(255, 152, 0, 0.3) !important;
    }
    .btn-outline-markaz:hover, .btn-markaz:hover {
        background: rgba(255, 152, 0, 0.25) !important;
        border-color: rgba(255, 152, 0, 0.5) !important;
    }
    
    /* برامج - أخضر */
    .icon-type-program, .center-icon.icon-type-program {
        background: rgba(76, 175, 80, 0.15) !important;
        color: #81c784 !important;
        border: 1px solid rgba(76, 175, 80, 0.3) !important;
    }
    .icon-color-program { color: #81c784 !important; }
    .badge-type-program, .bg-program {
        background: rgba(76, 175, 80, 0.15) !important;
        color: #81c784 !important;
        border: 1px solid rgba(76, 175, 80, 0.3) !important;
    }
    .btn-program {
        background: rgba(76, 175, 80, 0.2) !important;
        color: #81c784 !important;
        border: 1px solid rgba(76, 175, 80, 0.4) !important;
    }
    .btn-outline-program {
        background: transparent !important;
        color: #81c784 !important;
        border: 1px solid rgba(76, 175, 80, 0.3) !important;
    }
    .btn-outline-program:hover, .btn-program:hover {
        background: rgba(76, 175, 80, 0.25) !important;
        border-color: rgba(76, 175, 80, 0.5) !important;
    }
    
    /* الجنس والفترات */
    .badge-gender-female {
        background: rgba(233, 30, 99, 0.15) !important;
        color: #f48fb1 !important;
        border: 1px solid rgba(233, 30, 99, 0.3) !important;
    }
    .badge-gender-male {
        background: rgba(33, 150, 243, 0.15) !important;
        color: #64b5f6 !important;
        border: 1px solid rgba(33, 150, 243, 0.3) !important;
    }
    .badge-period-morning {
        background: rgba(255, 152, 0, 0.15) !important;
        color: #ffb74d !important;
        border: 1px solid rgba(255, 152, 0, 0.3) !important;
    }
    .badge-period-evening {
        background: rgba(25, 118, 210, 0.15) !important;
        color: #42a5f5 !important;
        border: 1px solid rgba(25, 118, 210, 0.3) !important;
    }
    
    /* العناصر العامة */
    .stats-card {
        background: rgba(255, 255, 255, 0.05);
        border-radius: 15px;
        padding: 1.5rem;
        border: 1px solid rgba(127, 176, 105, 0.2);
        backdrop-filter: blur(10px);
    }
    .stats-icon {
        width: 50px;
        height: 50px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        backdrop-filter: blur(10px);
    }
    .center-icon {
        width: 45px;
        height: 45px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        backdrop-filter: blur(10px);
    }
    .icon-stats-success {
        background: rgba(40, 167, 69, 0.15) !important;
        color: #5dd879 !important;
        border: 1px solid rgba(40, 167, 69, 0.3) !important;
    }
    .icon-stats-primary {
        background: rgba(127, 176, 105, 0.15) !important;
        color: #90c695 !important;
        border: 1px solid rgba(127, 176, 105, 0.3) !important;
    }
    .icon-stats-warning {
        background: rgba(255, 193, 7, 0.15) !important;
        color: #ffd454 !important;
        border: 1px solid rgba(255, 193, 7, 0.3) !important;
    }
    
    .dropdown-menu-dark {
        background: #1a1a2e;
        border: 1px solid rgba(255,255,255,0.1);
    }
    .dropdown-menu-dark .dropdown-item { color: #fff; }
    .dropdown-menu-dark .dropdown-item:hover { background: rgba(127, 176, 105, 0.2); }
    .dropdown-menu-dark .dropdown-item.disabled { opacity: 0.5; cursor: not-allowed; }
    
    .modal-content.bg-dark { border: 1px solid rgba(220, 53, 69, 0.5); }
    .border-danger { border-color: rgba(220, 53, 69, 0.5) !important; }
</style>
@endpush

@push('scripts')
<script>
let currentCenterId = null;
let currentCenterName = '';
let hasRelatedData = false;

function showDeleteModal(id, name, students, buses) {
    currentCenterId = id;
    currentCenterName = name;
    hasRelatedData = (students > 0 || buses > 0);
    
    document.getElementById('deleteCenterName').textContent = name;
    document.getElementById('deleteStudentsCount').textContent = students;
    document.getElementById('deleteBusesCount').textContent = buses;
    document.getElementById('confirmNameDisplay').textContent = name;
    document.getElementById('deleteForm').action = '{{ url("admin/centers") }}/' + id;
    
    if (hasRelatedData) {
        document.getElementById('deleteWarning').style.display = 'block';
        document.getElementById('proceedBtn').disabled = true;
        document.getElementById('proceedBtn').classList.add('disabled');
    } else {
        document.getElementById('deleteWarning').style.display = 'none';
        document.getElementById('proceedBtn').disabled = false;
        document.getElementById('proceedBtn').classList.remove('disabled');
    }
    
    goToStep1();
    document.getElementById('confirmNameInput').value = '';
    document.getElementById('confirmDeleteBtn').disabled = true;
    
    new bootstrap.Modal(document.getElementById('deleteModal')).show();
}

function goToStep1() {
    document.getElementById('deleteStep1').style.display = 'block';
    document.getElementById('deleteStep2').style.display = 'none';
}

function goToStep2() {
    if (hasRelatedData) return;
    document.getElementById('deleteStep1').style.display = 'none';
    document.getElementById('deleteStep2').style.display = 'block';
    document.getElementById('confirmNameInput').focus();
}

document.getElementById('confirmNameInput')?.addEventListener('input', function() {
    const input = this.value.trim();
    const isMatch = input === currentCenterName;
    
    document.getElementById('confirmDeleteBtn').disabled = !isMatch;
    document.getElementById('nameMatchError').style.display = (input.length > 0 && !isMatch) ? 'block' : 'none';
    
    if (isMatch) {
        this.classList.add('is-valid');
        this.classList.remove('is-invalid');
    } else if (input.length > 0) {
        this.classList.add('is-invalid');
        this.classList.remove('is-valid');
    } else {
        this.classList.remove('is-valid', 'is-invalid');
    }
});
</script>
@endpush