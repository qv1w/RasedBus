@extends('layouts.admin')

@section('title', 'تفاصيل الطالبة - ' . $student->name)

@section('header')
<div class="d-flex justify-content-between align-items-center w-100">
    <div>
        <h2 class="mb-1">
            <i class="fas fa-user-graduate text-info me-2"></i>
            {{ $student->name }}
        </h2>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">لوحة التحكم</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.students.index') }}">الطالبات</a></li>
                <li class="breadcrumb-item active">{{ $student->name }}</li>
            </ol>
        </nav>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.students.edit', $student) }}" class="btn btn-warning">
            <i class="fas fa-edit me-1"></i>
            تعديل
        </a>
        <a href="{{ route('admin.students.index') }}" class="btn btn-outline-light">
            <i class="fas fa-arrow-right me-1"></i>
            العودة
        </a>
    </div>
</div>
@endsection

@section('content')
@php
    $assignedBus = null;
    if ($student->assigned_bus_id) {
        $assignedBus = \App\Models\Bus::with('driver')->find($student->assigned_bus_id);
    }
    
    // جلب اسم المركز من العلاقة
    $centerName = $student->centerRelation ? $student->centerRelation->center_name : 'غير محدد';
@endphp

<div class="row">
    <!-- العمود الأيمن - البطاقة الرئيسية -->
    <div class="col-lg-4 mb-4">
        <!-- بطاقة الطالبة -->
        <div class="content-card text-center mb-4">
            <div class="student-avatar mb-3">
                <i class="fas fa-user-graduate"></i>
            </div>
            <h4 class="mb-1">{{ $student->name }}</h4>
            <p class="text-muted mb-3">{{ $student->student_id }}</p>
            
            <span class="badge bg-{{ $student->status_color }} fs-6 px-3 py-2 mb-3">
                {{ $student->status_text }}
            </span>
            
            <div class="info-list mt-3">
                <div class="info-item">
                    <i class="fas fa-phone text-success"></i>
                    <span class="label">الجوال</span>
                    <span class="value">
                        <a href="tel:{{ $student->mobile }}" class="text-info">{{ $student->mobile }}</a>
                    </span>
                </div>
                <div class="info-item">
                    <i class="fas fa-envelope text-primary"></i>
                    <span class="label">البريد</span>
                    <span class="value">{{ $student->email }}</span>
                </div>
                <div class="info-item">
                    <i class="fas fa-building text-warning"></i>
                    <span class="label">المركز</span>
                    <span class="value">
                        <span class="badge bg-info">{{ $centerName }}</span>
                    </span>
                </div>
                <div class="info-item">
                    <i class="fas fa-clock text-info"></i>
                    <span class="label">الفترة</span>
                    <span class="value">{{ $student->preferred_schedule }}</span>
                </div>
                <div class="info-item">
                    <i class="fas fa-calendar text-success"></i>
                    <span class="label">تاريخ التسجيل</span>
                    <span class="value">{{ $student->created_at->format('Y/m/d') }}</span>
                </div>
            </div>
        </div>
        
        <!-- بطاقة الباص -->
        <div class="content-card">
            <h5 class="mb-3">
                <i class="fas fa-bus text-warning me-2"></i>
                معلومات الباص
            </h5>
            
            @if($assignedBus)
                <div class="text-center mb-3">
                    <div class="bus-icon-large mb-2">
                        <i class="fas fa-bus"></i>
                    </div>
                    <h5 class="mb-1">{{ $assignedBus->number }}</h5>
                    <small class="text-muted">{{ $assignedBus->plate_number }}</small>
                </div>
                
                <div class="info-list">
                    <div class="info-item">
                        <i class="fas fa-car text-primary"></i>
                        <span class="label">الموديل</span>
                        <span class="value">{{ $assignedBus->model ?? '-' }}</span>
                    </div>
                    @if($assignedBus->driver)
                    <div class="info-item">
                        <i class="fas fa-user text-success"></i>
                        <span class="label">السائق</span>
                        <span class="value">{{ $assignedBus->driver->name }}</span>
                    </div>
                    <div class="info-item">
                        <i class="fas fa-phone text-info"></i>
                        <span class="label">جوال السائق</span>
                        <span class="value">
                            <a href="tel:{{ $assignedBus->driver->mobile }}" class="text-info">
                                {{ $assignedBus->driver->mobile ?? '-' }}
                            </a>
                        </span>
                    </div>
                    @endif
                    @if($student->pickup_point)
                    <div class="info-item">
                        <i class="fas fa-map-marker-alt text-danger"></i>
                        <span class="label">نقطة الالتقاء</span>
                        <span class="value">{{ $student->pickup_point }}</span>
                    </div>
                    @endif
                    @if($student->pickup_time)
                    <div class="info-item">
                        <i class="fas fa-clock text-warning"></i>
                        <span class="label">وقت الالتقاء</span>
                        <span class="value">{{ $student->pickup_time }}</span>
                    </div>
                    @endif
                </div>
                
                <a href="{{ route('admin.buses.show', $assignedBus) }}" class="btn btn-outline-info w-100 mt-3">
                    <i class="fas fa-eye me-1"></i>
                    عرض تفاصيل الباص
                </a>
                
                <form action="{{ route('admin.students.unassign.bus', $student) }}" method="POST" class="mt-2">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger w-100" onclick="return confirm('هل تريد إلغاء تخصيص الباص؟')">
                        <i class="fas fa-times me-1"></i>
                        إلغاء تخصيص الباص
                    </button>
                </form>
            @else
                <div class="text-center py-3">
                    <i class="fas fa-bus fa-3x text-muted opacity-50 mb-3"></i>
                    <p class="text-muted mb-3">لم يتم تخصيص باص بعد</p>
                </div>
                
                @if($student->status == 'approved')
                <div class="bus-assignment-form">
                    <h6 class="text-info mb-3">
                        <i class="fas fa-plus-circle me-1"></i>
                        تخصيص باص للطالبة
                    </h6>
                    
                    <form action="{{ route('admin.students.assign.bus', $student) }}" method="POST">
                        @csrf
                        
                        <div class="mb-3">
                            <label class="form-label">اختر الباص <span class="text-danger">*</span></label>
                            <select name="bus_id" class="form-select" required>
                                <option value="">-- اختر الباص --</option>
                                @if(isset($availableBuses) && $availableBuses->count() > 0)
                                    @foreach($availableBuses as $bus)
                                        <option value="{{ $bus->id }}">
                                            {{ $bus->number }} - {{ $bus->plate_number }} 
                                            ({{ $bus->students_count }}/{{ $bus->capacity }})
                                        </option>
                                    @endforeach
                                @else
                                    @php
                                        $buses = \App\Models\Bus::where('status', 'active')
                                            ->where('center_id', $student->center_id)
                                            ->withCount('students')
                                            ->get()
                                            ->filter(function($bus) {
                                                return $bus->students_count < $bus->capacity;
                                            });
                                    @endphp
                                    @foreach($buses as $bus)
                                        <option value="{{ $bus->id }}">
                                            {{ $bus->number }} - {{ $bus->plate_number }} 
                                            ({{ $bus->students_count }}/{{ $bus->capacity }})
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                            <small class="text-muted">الباصات المتاحة في مركز: {{ $centerName }}</small>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">نقطة الالتقاء</label>
                            <input type="text" name="pickup_point" class="form-control" 
                                   placeholder="مثال: أمام المسجد الكبير">
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">وقت الالتقاء</label>
                            <input type="time" name="pickup_time" class="form-control">
                        </div>
                        
                        <button type="submit" class="btn btn-success w-100">
                            <i class="fas fa-check me-1"></i>
                            تخصيص الباص
                        </button>
                    </form>
                </div>
                @endif
            @endif
        </div>
    </div>

    <!-- العمود الأيسر - التفاصيل -->
    <div class="col-lg-8">
        <!-- معلومات ولي الأمر -->
        <div class="content-card mb-4">
            <h5 class="mb-3">
                <i class="fas fa-user-shield text-warning me-2"></i>
                معلومات ولي الأمر
            </h5>
            <div class="row">
                <div class="col-md-4 mb-3">
                    <div class="detail-item">
                        <span class="detail-label">اسم ولي الأمر</span>
                        <span class="detail-value">{{ $student->guardian_name ?: '-' }}</span>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="detail-item">
                        <span class="detail-label">جوال ولي الأمر</span>
                        <span class="detail-value">
                            @if($student->guardian_mobile)
                                <a href="tel:{{ $student->guardian_mobile }}" class="text-info">{{ $student->guardian_mobile }}</a>
                            @else
                                -
                            @endif
                        </span>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="detail-item">
                        <span class="detail-label">صلة القرابة</span>
                        <span class="detail-value">{{ $student->guardian_relation ?: '-' }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- العنوان والموقع -->
        <div class="content-card mb-4">
            <h5 class="mb-3">
                <i class="fas fa-map-marker-alt text-danger me-2"></i>
                الموقع والعنوان
            </h5>
            
            @if($student->address)
            <div class="mb-3">
                <span class="detail-label">العنوان:</span>
                <span class="detail-value">{{ $student->address }}</span>
            </div>
            @endif
            
            @if($student->latitude && $student->longitude)
            <div id="studentMap" style="height: 300px; border-radius: 10px;"></div>
            <div class="mt-2 text-center">
                <a href="https://www.google.com/maps?q={{ $student->latitude }},{{ $student->longitude }}" 
                   target="_blank" class="btn btn-sm btn-outline-info">
                    <i class="fas fa-external-link-alt me-1"></i>
                    فتح في Google Maps
                </a>
            </div>
            @else
            <div class="text-center py-3">
                <i class="fas fa-map-marker-alt fa-2x text-muted opacity-50 mb-2"></i>
                <p class="text-muted mb-0">لم يتم تحديد الموقع</p>
            </div>
            @endif
        </div>

        <!-- ملاحظات وإجراءات -->
        <div class="content-card">
            <h5 class="mb-3">
                <i class="fas fa-cog text-info me-2"></i>
                الإجراءات
            </h5>
            
            @if($student->notes)
            <div class="alert alert-info mb-3">
                <i class="fas fa-sticky-note me-2"></i>
                <strong>ملاحظات:</strong> {{ $student->notes }}
            </div>
            @endif
            
            @if($student->status == 'rejected' && $student->rejection_reason)
            <div class="alert alert-danger mb-3">
                <i class="fas fa-times-circle me-2"></i>
                <strong>سبب الرفض:</strong> {{ $student->rejection_reason }}
            </div>
            @endif
            
            <div class="d-flex flex-wrap gap-2">
                @if($student->status == 'pending')
                <form action="{{ route('admin.students.approve', $student) }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-check me-1"></i>
                        قبول
                    </button>
                </form>
                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#rejectModal">
                    <i class="fas fa-times me-1"></i>
                    رفض
                </button>
                @elseif($student->status == 'approved')
                <form action="{{ route('admin.students.suspend', $student) }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-secondary" onclick="return confirm('هل تريد تعليق هذه الطالبة؟')">
                        <i class="fas fa-pause me-1"></i>
                        تعليق
                    </button>
                </form>
                @elseif($student->status == 'suspended')
                <form action="{{ route('admin.students.unsuspend', $student) }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-play me-1"></i>
                        إلغاء التعليق
                    </button>
                </form>
                @endif
                
                <form action="{{ route('admin.students.destroy', $student) }}" method="POST" class="d-inline"
                      onsubmit="return confirm('هل أنت متأكد من حذف هذه الطالبة؟')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-outline-danger">
                        <i class="fas fa-trash me-1"></i>
                        حذف
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal الرفض -->
<div class="modal fade" id="rejectModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content bg-dark">
            <div class="modal-header border-secondary">
                <h5 class="modal-title">رفض الطالبة</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.students.reject', $student) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">سبب الرفض <span class="text-danger">*</span></label>
                        <textarea name="rejection_reason" class="form-control" rows="3" required
                                  placeholder="اكتب سبب الرفض هنا..."></textarea>
                    </div>
                </div>
                <div class="modal-footer border-secondary">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                    <button type="submit" class="btn btn-danger">تأكيد الرفض</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<style>
    .student-avatar {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        background: linear-gradient(135deg, #667eea, #764ba2);
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto;
    }
    
    .student-avatar i {
        font-size: 3rem;
        color: white;
    }
    
    .bus-icon-large {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background: linear-gradient(135deg, #ffc107, #fd7e14);
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto;
    }
    
    .bus-icon-large i {
        font-size: 2.5rem;
        color: white;
    }
    
    .info-list {
        border-top: 1px solid rgba(255,255,255,0.1);
        padding-top: 1rem;
    }
    
    .info-item {
        display: flex;
        align-items: center;
        padding: 0.75rem 0;
        border-bottom: 1px solid rgba(255,255,255,0.05);
    }
    
    .info-item:last-child {
        border-bottom: none;
    }
    
    .info-item i {
        width: 30px;
        text-align: center;
    }
    
    .info-item .label {
        color: rgba(255,255,255,0.6);
        margin-left: 0.5rem;
        min-width: 80px;
    }
    
    .info-item .value {
        margin-right: auto;
        color: #fff;
    }
    
    .detail-item {
        background: rgba(255,255,255,0.05);
        border-radius: 8px;
        padding: 1rem;
    }
    
    .detail-label {
        display: block;
        color: rgba(255,255,255,0.6);
        font-size: 0.85rem;
        margin-bottom: 0.25rem;
    }
    
    .detail-value {
        color: #fff;
        font-weight: 500;
    }
    
    .detail-value a {
        color: #17a2b8;
        text-decoration: none;
    }
    
    .detail-value a:hover {
        text-decoration: underline;
    }
    
    .content-card {
        background: rgba(255,255,255,0.05);
        backdrop-filter: blur(10px);
        border-radius: 15px;
        padding: 1.5rem;
        border: 1px solid rgba(255,255,255,0.1);
    }
    
    .bus-assignment-form {
        background: rgba(0,0,0,0.2);
        border-radius: 10px;
        padding: 1rem;
        margin-top: 1rem;
    }
    
    .form-control, .form-select {
        background: rgba(255,255,255,0.1);
        border-color: rgba(255,255,255,0.2);
        color: #fff;
    }
    
    .form-control:focus, .form-select:focus {
        background: rgba(255,255,255,0.15);
        border-color: #17a2b8;
        color: #fff;
        box-shadow: 0 0 0 0.2rem rgba(23, 162, 184, 0.25);
    }
    
    .form-select option {
        background: #1a1a2e;
        color: #fff;
    }
</style>
@endpush

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    @if($student->latitude && $student->longitude)
    var map = L.map('studentMap').setView([{{ $student->latitude }}, {{ $student->longitude }}], 15);
    
    L.tileLayer('https://mt1.google.com/vt/lyrs=y&x={x}&y={y}&z={z}', {
        maxZoom: 20,
        attribution: '© Google Maps'
    }).addTo(map);
    
    L.marker([{{ $student->latitude }}, {{ $student->longitude }}])
        .addTo(map)
        .bindPopup('<strong>{{ $student->name }}</strong><br>{{ $centerName }}')
        .openPopup();
    @endif
});
</script>
@endpush
