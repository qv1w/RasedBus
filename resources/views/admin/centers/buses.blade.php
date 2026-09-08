@extends('layouts.admin')

@section('title', 'باصات ' . $center->center_name)

@section('header')
<div class="d-flex justify-content-between align-items-center w-100">
    <div>
        <h2 class="mb-1">
            <i class="fas fa-bus text-warning me-2"></i>
            باصات {{ $center->center_name }}
        </h2>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('admin.centers.index') }}">المراكز</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.centers.show', $center) }}">{{ $center->center_name }}</a></li>
                <li class="breadcrumb-item active">الباصات</li>
            </ol>
        </nav>
    </div>
    <a href="{{ route('admin.centers.show', $center) }}" class="btn btn-outline-light">
        <i class="fas fa-arrow-right me-1"></i>
        العودة
    </a>
</div>
@endsection

@section('content')
<div class="content-card">
    @if($buses->count() > 0)
        <div class="table-responsive">
            <table class="table table-dark table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>رقم الباص</th>
                        <th>اللوحة</th>
                        <th>السائق</th>
                        <th>الإشغال</th>
                        <th>الحالة</th>
                        <th>إجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($buses as $bus)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td><strong class="text-primary">{{ $bus->number }}</strong></td>
                        <td>{{ $bus->plate_number }}</td>
                        <td>
                            @if($bus->driver)
                                {{ $bus->driver->name }}
                            @else
                                <span class="text-muted">غير مخصص</span>
                            @endif
                        </td>
                        <td>
                            @php
                                $count = $bus->students->count();
                                $percentage = $bus->capacity > 0 ? ($count / $bus->capacity * 100) : 0;
                                $color = $percentage > 80 ? 'danger' : ($percentage > 50 ? 'warning' : 'success');
                            @endphp
                            <div class="d-flex align-items-center gap-2">
                                <div class="progress flex-grow-1" style="height: 8px; width: 80px;">
                                    <div class="progress-bar bg-{{ $color }}" style="width: {{ $percentage }}%"></div>
                                </div>
                                <small>{{ $count }}/{{ $bus->capacity }}</small>
                            </div>
                        </td>
                        <td>
                            @php
                                $statusColors = ['active' => 'success', 'inactive' => 'danger', 'maintenance' => 'warning'];
                                $statusTexts = ['active' => 'نشط', 'inactive' => 'غير نشط', 'maintenance' => 'صيانة'];
                            @endphp
                            <span class="badge bg-{{ $statusColors[$bus->status] ?? 'secondary' }}">
                                {{ $statusTexts[$bus->status] ?? $bus->status }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('admin.buses.show', $bus) }}" class="btn btn-sm btn-info">
                                <i class="fas fa-eye"></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="text-center py-5">
            <i class="fas fa-bus fa-3x text-muted mb-3"></i>
            <p class="text-muted">لا توجد باصات مخصصة لهذا المركز</p>
            <a href="{{ route('admin.buses.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-1"></i>
                إضافة باص
            </a>
        </div>
    @endif
</div>
@endsection