@extends('layouts.admin')

@section('title', 'أرشيف التقارير')

@section('header')
<div class="d-flex justify-content-between align-items-center w-100">
    <div>
        <h2 class="mb-1">
            <i class="fas fa-archive me-2"></i>
            أرشيف التقارير
        </h2>
        <p class="text-light opacity-75 mb-0">جميع التقارير المحفوظة</p>
    </div>
    <a href="{{ route('admin.reports') }}" class="btn btn-primary">
        <i class="fas fa-chart-bar me-1"></i>
        تقرير جديد
    </a>
</div>
@endsection

@section('content')
<div class="content-card">
    <!-- فلاتر البحث -->
    <form method="GET" class="mb-4">
        <div class="row g-3">
            <div class="col-md-4">
                <label class="form-label">بحث</label>
                <input type="text" name="search" class="form-control" 
                       placeholder="رقم التقرير أو العنوان..." 
                       value="{{ request('search') }}">
            </div>
            <div class="col-md-3">
                <label class="form-label">من تاريخ</label>
                <input type="date" name="date_from" class="form-control" value="{{ request('date_from') }}">
            </div>
            <div class="col-md-3">
                <label class="form-label">إلى تاريخ</label>
                <input type="date" name="date_to" class="form-control" value="{{ request('date_to') }}">
            </div>
            <div class="col-md-2 d-flex align-items-end">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="fas fa-search me-1"></i> بحث
                </button>
            </div>
        </div>
    </form>

    <!-- جدول التقارير -->
    @if($reports->count() > 0)
    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>#</th>
                    <th>رقم التقرير</th>
                    <th>العنوان</th>
                    <th>الملاحظات</th>
                    <th>أنشئ بواسطة</th>
                    <th>تاريخ الإنشاء</th>
                    <th>الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                @foreach($reports as $index => $report)
                <tr>
                    <td>{{ $reports->firstItem() + $index }}</td>
                    <td>
                        <span class="badge bg-primary">{{ $report->report_number }}</span>
                    </td>
                    <td>{{ $report->title }}</td>
                    <td>{{ Str::limit($report->notes, 50) ?? '-' }}</td>
                    <td>{{ $report->creator->name ?? 'غير معروف' }}</td>
                    <td>{{ $report->created_at->format('Y-m-d H:i') }}</td>
                    <td>
                        <div class="btn-group btn-group-sm">
                            <a href="{{ route('admin.reports.show', $report) }}" 
                               class="btn btn-outline-info" title="عرض">
                                <i class="fas fa-eye"></i>
                            </a>
                            <form action="{{ route('admin.reports.destroy', $report) }}" 
                                  method="POST" class="d-inline"
                                  onsubmit="return confirm('هل أنت متأكد من حذف هذا التقرير؟')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger" title="حذف">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- الترقيم -->
    <div class="d-flex justify-content-center mt-4">
        {{ $reports->withQueryString()->links() }}
    </div>
    @else
    <div class="text-center py-5">
        <i class="fas fa-folder-open fa-4x text-muted mb-3"></i>
        <h5>لا توجد تقارير محفوظة</h5>
        <p class="text-muted">قم بإنشاء تقرير جديد وحفظه في الأرشيف</p>
        <a href="{{ route('admin.reports') }}" class="btn btn-primary">
            <i class="fas fa-plus me-1"></i> إنشاء تقرير
        </a>
    </div>
    @endif
</div>
@endsection
