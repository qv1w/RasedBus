@extends('layouts.admin')

@section('title', 'إدارة السائقين')

@section('header')
<div class="d-flex justify-content-between align-items-center">
    <div>
        <h1 class="h2 mb-1">
            <i class="fas fa-id-card me-2"></i>
            إدارة السائقين
        </h1>
        <p class="mb-0 opacity-75">
            إجمالي السائقين: {{ $drivers->total() }}
        </p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.drivers.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-1"></i>
            إضافة سائق جديد
        </a>
    </div>
</div>
@endsection

@section('content')
<!-- البحث والفلترة -->
<div class="content-card mb-4">
    <form method="GET" action="{{ route('admin.drivers.index') }}">
        <div class="row g-3">
            <div class="col-md-4">
                <label for="search" class="form-label">البحث</label>
                <input type="text" name="search" id="search" class="form-control" 
                       placeholder="البحث بالاسم أو الجوال أو رقم الرخصة" 
                       value="{{ request('search') }}">
            </div>
            <div class="col-md-3">
                <label for="status" class="form-label">الحالة</label>
                <select name="status" id="status" class="form-select">
                    <option value="">جميع الحالات</option>
                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>نشط</option>
                    <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>غير نشط</option>
                    <option value="on_leave" {{ request('status') == 'on_leave' ? 'selected' : '' }}>في إجازة</option>
                </select>
            </div>
            <div class="col-md-5 d-flex align-items-end">
                <button type="submit" class="btn btn-outline-light me-2">
                    <i class="fas fa-search me-1"></i>
                    بحث
                </button>
                <a href="{{ route('admin.drivers.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-times me-1"></i>
                    مسح
                </a>
            </div>
        </div>
    </form>
</div>

<!-- جدول السائقين -->
<div class="content-card">
    @if($drivers->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>الاسم</th>
                        <th>الجوال</th>
                        <th>البريد الإلكتروني</th>
                        <th>رقم الرخصة</th>
                        <th>الحالة</th>
                        <th>تاريخ التسجيل</th>
                        <th>الإجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($drivers as $driver)
                    <tr>
                        <td>{{ $driver->id }}</td>
                        <td>
                            <div>
                                <strong>{{ $driver->name }}</strong>
                                @if($driver->address)
                                <br><small class="opacity-75">{{ Str::limit($driver->address, 30) }}</small>
                                @endif
                            </div>
                        </td>
                        <td>{{ $driver->mobile }}</td>
                        <td>{{ $driver->email ?? 'غير محدد' }}</td>
                        <td><code class="text-warning">{{ $driver->license_number }}</code></td>
                        <td>
                            <span class="badge bg-{{ $driver->status_color }}">
                                {{ $driver->status_name }}
                            </span>
                        </td>
                        <td>
                            {{ $driver->created_at->format('Y/m/d') }}
                            <br><small class="opacity-75">{{ $driver->created_at->format('H:i') }}</small>
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('admin.drivers.show', $driver) }}" 
                                   class="btn btn-outline-info" title="عرض التفاصيل">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.drivers.edit', $driver) }}" 
                                   class="btn btn-outline-warning" title="تعديل">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button class="btn btn-outline-danger" 
                                        onclick="deleteDriver({{ $driver->id }})" title="حذف">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- التصفح -->
        <div class="d-flex justify-content-center mt-4">
            {{ $drivers->links() }}
        </div>
    @else
        <div class="text-center py-5">
            <i class="fas fa-users opacity-50" style="font-size: 4rem;"></i>
            <h4 class="mt-3 opacity-75">لا يوجد سائقين</h4>
            <p class="opacity-50">
                @if(request('search') || request('status'))
                    لم يتم العثور على سائقين يطابقون معايير البحث
                @else
                    لم يتم إضافة أي سائقين بعد
                @endif
            </p>
            <a href="{{ route('admin.drivers.create') }}" class="btn btn-primary mt-3">
                <i class="fas fa-plus me-1"></i>
                إضافة أول سائق
            </a>
        </div>
    @endif
</div>
@endsection

@section('scripts')
<script>
    // حذف سائق
    function deleteDriver(driverId) {
        if (confirm('هل أنت متأكد من حذف هذا السائق؟\nهذا الإجراء لا يمكن التراجع عنه.')) {
            showLoading();
            
            fetch(`/admin/drivers/${driverId}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                hideLoading();
                if (data.success) {
                    location.reload();
                } else {
                    alert('حدث خطأ أثناء حذف السائق: ' + (data.message || ''));
                }
            })
            .catch(error => {
                hideLoading();
                console.error('Error:', error);
                alert('حدث خطأ أثناء حذف السائق');
            });
        }
    }

    // تحديث الجدول عند تغيير الفلترة
    document.getElementById('status').addEventListener('change', function() {
        document.querySelector('form').submit();
    });

    // البحث السريع
    let searchTimeout;
    document.getElementById('search').addEventListener('input', function() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
            if (this.value.length >= 3 || this.value.length === 0) {
                document.querySelector('form').submit();
            }
        }, 500);
    });

    // تحديد الصفوف
    document.querySelectorAll('tbody tr').forEach(row => {
        row.addEventListener('click', function(e) {
            if (!e.target.closest('.btn-group')) {
                const showLink = this.querySelector('.btn-outline-info');
                if (showLink) {
                    window.location.href = showLink.href;
                }
            }
        });
        
        row.style.cursor = 'pointer';
    });
</script>
@endsection