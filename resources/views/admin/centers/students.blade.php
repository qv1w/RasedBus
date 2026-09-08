@extends('layouts.admin')

@section('title', 'طالبات ' . $center->center_name)

@section('header')
<div class="d-flex justify-content-between align-items-center w-100">
    <div>
        <h2 class="mb-1">
            <i class="fas fa-users text-info me-2"></i>
            طالبات {{ $center->center_name }}
        </h2>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('admin.centers.index') }}">المراكز</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.centers.show', $center) }}">{{ $center->center_name }}</a></li>
                <li class="breadcrumb-item active">الطالبات</li>
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
    @if($students->count() > 0)
        <div class="table-responsive">
            <table class="table table-dark table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>الاسم</th>
                        <th>رقم الطالبة</th>
                        <th>الجوال</th>
                        <th>الفترة</th>
                        <th>الحالة</th>
                        <th>الباص</th>
                        <th>إجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($students as $student)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $student->name }}</td>
                        <td><code>{{ $student->student_id }}</code></td>
                        <td>{{ $student->mobile }}</td>
                        <td>
                            <span class="badge bg-{{ $student->preferred_schedule == 'صباحية' ? 'warning' : 'info' }}">
                                {{ $student->preferred_schedule }}
                            </span>
                        </td>
                        <td>
                            @php
                                $statusColors = ['approved' => 'success', 'pending' => 'warning', 'rejected' => 'danger'];
                                $statusTexts = ['approved' => 'مقبولة', 'pending' => 'قيد المراجعة', 'rejected' => 'مرفوضة'];
                            @endphp
                            <span class="badge bg-{{ $statusColors[$student->status] ?? 'secondary' }}">
                                {{ $statusTexts[$student->status] ?? $student->status }}
                            </span>
                        </td>
                        <td>
                            @if($student->assigned_bus_id)
                                <span class="badge bg-primary">{{ $student->bus->number ?? 'N/A' }}</span>
                            @else
                                <span class="text-muted">غير مخصص</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.students.show', $student) }}" class="btn btn-sm btn-info">
                                <i class="fas fa-eye"></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <div class="mt-3">
            {{ $students->links() }}
        </div>
    @else
        <div class="text-center py-5">
            <i class="fas fa-users fa-3x text-muted mb-3"></i>
            <p class="text-muted">لا توجد طالبات مسجلات في هذا المركز</p>
        </div>
    @endif
</div>
@endsection