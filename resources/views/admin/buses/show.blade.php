@extends('layouts.admin')

@section('title', 'تفاصيل الباص - ' . $bus->number)

@section('header')
<div class="d-flex justify-content-between align-items-center w-100">
    <div>
        <h2 class="mb-1">
            <i class="fas fa-bus text-info me-2"></i>
            تفاصيل الباص: {{ $bus->number }}
        </h2>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">لوحة التحكم</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.buses.index') }}">الباصات</a></li>
                <li class="breadcrumb-item active">{{ $bus->number }}</li>
            </ol>
        </nav>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.buses.edit', $bus) }}" class="btn btn-warning">
            <i class="fas fa-edit me-1"></i>
            تعديل
        </a>
        <a href="{{ route('admin.buses.index') }}" class="btn btn-outline-light">
            <i class="fas fa-arrow-right me-1"></i>
            العودة
        </a>
    </div>
</div>
@endsection

@section('content')
<div class="row">
    <!-- معلومات الباص الأساسية -->
    <div class="col-lg-4">
        <!-- بطاقة الباص -->
        <div class="content-card mb-4">
            <div class="text-center mb-4">
                <div class="bus-icon-large mx-auto mb-3">
                    <i class="fas fa-bus"></i>
                </div>
                <h3 class="text-primary mb-1">{{ $bus->number }}</h3>
                <p class="text-light opacity-75 mb-2">{{ $bus->plate_number }}</p>
                
                @php
                    $statusConfig = [
                        'active' => ['class' => 'success', 'icon' => 'check-circle', 'text' => 'نشط'],
                        'inactive' => ['class' => 'danger', 'icon' => 'times-circle', 'text' => 'غير نشط'],
                        'maintenance' => ['class' => 'warning', 'icon' => 'tools', 'text' => 'صيانة']
                    ];
                    $config = $statusConfig[$bus->status] ?? ['class' => 'secondary', 'icon' => 'question', 'text' => $bus->status];
                @endphp
                <span class="badge bg-{{ $config['class'] }} px-3 py-2">
                    <i class="fas fa-{{ $config['icon'] }} me-1"></i>
                    {{ $config['text'] }}
                </span>
            </div>

            <hr class="border-secondary">

            <div class="info-list">
                <div class="info-item">
                    <span class="info-label"><i class="fas fa-car me-2"></i>الموديل</span>
                    <span class="info-value">{{ $bus->model ?? 'غير محدد' }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label"><i class="fas fa-school me-2"></i>عدد الجهات</span>
                    <span class="info-value">{{ $bus->centers->count() }} جهة</span>
                </div>
                <div class="info-item">
                    <span class="info-label"><i class="fas fa-calendar me-2"></i>تاريخ الإضافة</span>
                    <span class="info-value">{{ $bus->created_at->format('Y/m/d') }}</span>
                </div>
                @if($bus->notes)
                <div class="info-item">
                    <span class="info-label"><i class="fas fa-sticky-note me-2"></i>ملاحظات</span>
                    <span class="info-value">{{ $bus->notes }}</span>
                </div>
                @endif
            </div>
        </div>

        <!-- بطاقة السائق -->
        <div class="content-card mb-4">
            <h5 class="mb-3">
                <i class="fas fa-user-tie text-warning me-2"></i>
                السائق
            </h5>
            
            @if($bus->driver)
                <div class="driver-card">
                    <div class="d-flex align-items-center mb-3">
                        <div class="driver-avatar me-3">
                            <i class="fas fa-user"></i>
                        </div>
                        <div>
                            <h6 class="mb-0 text-light">{{ $bus->driver->name }}</h6>
                            <small class="text-muted">{{ $bus->driver->driver_id ?? '' }}</small>
                        </div>
                        <span class="badge bg-{{ $bus->driver->status == 'active' ? 'success' : 'secondary' }} ms-auto">
                            {{ $bus->driver->status == 'active' ? 'نشط' : 'غير نشط' }}
                        </span>
                    </div>
                    
                    <div class="info-list small">
                        <div class="info-item">
                            <span class="info-label"><i class="fas fa-phone me-2"></i>الجوال</span>
                            <span class="info-value">
                                <a href="tel:{{ $bus->driver->mobile }}" class="text-info">
                                    {{ $bus->driver->mobile }}
                                </a>
                            </span>
                        </div>
                    </div>
                    
                    <a href="{{ route('admin.drivers.show', $bus->driver) }}" class="btn btn-sm btn-outline-info w-100 mt-3">
                        <i class="fas fa-eye me-1"></i>
                        عرض تفاصيل السائق
                    </a>
                </div>
            @else
                <div class="text-center py-4">
                    <i class="fas fa-user-slash fa-3x text-muted opacity-50 mb-3"></i>
                    <p class="text-muted mb-3">لا يوجد سائق مخصص</p>
                    <a href="{{ route('admin.buses.edit', $bus) }}" class="btn btn-sm btn-outline-warning">
                        <i class="fas fa-plus me-1"></i>
                        تخصيص سائق
                    </a>
                </div>
            @endif
        </div>

        <!-- الجهات التعليمية -->
        <div class="content-card">
            <h5 class="mb-3">
                <i class="fas fa-school text-info me-2"></i>
                الجهات التعليمية
                <span class="badge bg-info ms-2">{{ $bus->centers->count() }}</span>
            </h5>
            
            @if($bus->centers->count() > 0)
                @foreach($bus->centers as $center)
                @php
                    $capacity = $center->pivot->capacity;
                    $current = $center->pivot->current_students;
                    $available = $capacity - $current;
                    $percentage = $capacity > 0 ? round(($current / $capacity) * 100) : 0;
                    $progressColor = $percentage >= 90 ? 'danger' : ($percentage >= 70 ? 'warning' : 'success');
                @endphp
                <div class="center-info-card mb-3">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <div>
                            <strong class="text-light">{{ $center->center_name }}</strong>
                            <br>
                            <small class="text-muted">
                                <i class="fas fa-clock me-1"></i>
                                {{ $center->pivot->schedule == 'both' ? 'صباحي ومسائي' : ($center->pivot->schedule == 'morning' ? 'صباحي' : 'مسائي') }}
                            </small>
                        </div>
                        <span class="badge bg-{{ $progressColor }}">{{ $percentage }}%</span>
                    </div>
                    
                    <div class="progress mb-2" style="height: 8px;">
                        <div class="progress-bar bg-{{ $progressColor }}" style="width: {{ $percentage }}%"></div>
                    </div>
                    
                    <div class="d-flex justify-content-between small">
                        <span class="text-success">
                            <i class="fas fa-chair me-1"></i>
                            متاح: {{ $available }}
                        </span>
                        <span class="text-info">
                            <i class="fas fa-users me-1"></i>
                            {{ $current }}/{{ $capacity }}
                        </span>
                    </div>
                </div>
                @endforeach
            @else
                <div class="text-center py-3">
                    <p class="text-muted mb-0">لا توجد جهات مرتبطة</p>
                </div>
            @endif
        </div>
    </div>

    <!-- قائمة الطالبات -->
    <div class="col-lg-8">
        <!-- إضافة طالبات -->
        @if($bus->status === 'active' && $bus->centers->sum('pivot.capacity') > $bus->centers->sum('pivot.current_students'))
        <div class="content-card mb-4">
            <a href="{{ route('admin.buses.assign-students', $bus) }}" class="btn btn-success">
                <i class="fas fa-plus me-2"></i>
                إضافة طالبات للباص
            </a>
        </div>
        @endif

        <!-- الطالبات مجمعة حسب الجهة -->
        @foreach($bus->centers as $center)
        @php
            $centerStudents = $bus->students->where('center_id', $center->id);
            $capacity = $center->pivot->capacity;
            $current = $centerStudents->count();
            $available = $capacity - $current;
            $percentage = $capacity > 0 ? round(($current / $capacity) * 100) : 0;
            $progressColor = $percentage >= 90 ? 'danger' : ($percentage >= 70 ? 'warning' : 'success');
        @endphp
        <div class="content-card mb-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h5 class="mb-1">
                        <i class="fas fa-school text-info me-2"></i>
                        {{ $center->center_name }}
                    </h5>
                    <div class="d-flex align-items-center gap-3">
                        <small class="text-muted">
                            <i class="fas fa-clock me-1"></i>
                            {{ $center->pivot->schedule == 'both' ? 'صباحي ومسائي' : ($center->pivot->schedule == 'morning' ? 'صباحي' : 'مسائي') }}
                        </small>
                        <span class="badge bg-{{ $progressColor }}">
                            {{ $current }}/{{ $capacity }} طالبة
                        </span>
                        @if($available > 0)
                        <span class="badge bg-success">
                            {{ $available }} متاح
                        </span>
                        @endif
                    </div>
                </div>
            </div>

            @if($centerStudents->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr>
                                <th width="5%">#</th>
                                <th width="30%">الطالبة</th>
                                <th width="20%">الجوال</th>
                                <th width="25%">نقطة الالتقاء</th>
                                <th width="20%">إجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($centerStudents as $index => $student)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>
                                        <div>
                                            <strong>{{ $student->name }}</strong>
                                            <br>
                                            <small class="text-muted">{{ $student->student_id }}</small>
                                        </div>
                                    </td>
                                    <td>
                                        <a href="tel:{{ $student->mobile }}" class="text-info">
                                            {{ $student->mobile }}
                                        </a>
                                    </td>
                                    <td>
                                        @if($student->pickup_point)
                                            <span class="text-light">{{ $student->pickup_point }}</span>
                                            @if($student->pickup_time)
                                            <br><small class="text-muted">{{ $student->pickup_time }}</small>
                                            @endif
                                        @else
                                            <span class="text-muted">غير محدد</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{ route('admin.students.show', $student) }}" 
                                               class="btn btn-outline-info" title="عرض">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <button type="button" 
                                                    class="btn btn-outline-warning"
                                                    onclick="editPickup({{ $student->id }}, '{{ $student->pickup_point }}', '{{ $student->pickup_time }}')"
                                                    title="تعديل نقطة الالتقاء">
                                                <i class="fas fa-map-marker-alt"></i>
                                            </button>
                                            <form action="{{ route('admin.buses.remove-student', [$bus, $student]) }}" 
                                                  method="POST" class="d-inline"
                                                  onsubmit="return confirm('هل أنت متأكد من إزالة {{ $student->name }} من الباص؟')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-outline-danger" title="إزالة">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-4">
                    <i class="fas fa-users fa-3x text-muted opacity-50 mb-3"></i>
                    <p class="text-muted mb-0">لا توجد طالبات لهذه الجهة</p>
                    <small class="text-muted">المقاعد المتاحة: {{ $available }}</small>
                </div>
            @endif
        </div>
        @endforeach

        @if($bus->centers->count() == 0)
        <div class="content-card">
            <div class="text-center py-5">
                <i class="fas fa-school fa-4x text-muted opacity-50 mb-3"></i>
                <h5 class="text-muted">لا توجد جهات مرتبطة</h5>
                <p class="text-muted mb-4">يرجى إضافة جهات تعليمية للباص أولاً</p>
                <a href="{{ route('admin.buses.edit', $bus) }}" class="btn btn-primary">
                    <i class="fas fa-edit me-2"></i>
                    تعديل الباص
                </a>
            </div>
        </div>
        @endif

        <!-- إزالة جميع الطالبات -->
        @if($bus->students->count() > 0)
        <div class="content-card">
            <div class="d-flex justify-content-between align-items-center">
                <spa