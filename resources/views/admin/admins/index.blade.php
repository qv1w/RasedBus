@extends('layouts.admin')

@php
    use App\Models\Admin;
    $currentAdmin = Admin::find(session('admin_id'));
@endphp

@section('title', 'إدارة الموظفين')

@section('header')
<div class="d-flex justify-content-between align-items-center w-100">
    <div>
        <h2 class="mb-1">
            <i class="fas fa-users-cog me-2"></i>
            إدارة الموظفين
        </h2>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">لوحة التحكم</a></li>
                <li class="breadcrumb-item active">الموظفين</li>
            </ol>
        </nav>
    </div>
    @if($currentAdmin && in_array($currentAdmin->role, ['developer', 'super_admin']))
    <a href="{{ route('admin.admins.create') }}" class="btn btn-primary">
        <i class="fas fa-plus me-1"></i>
        إضافة موظف
    </a>
    @endif
</div>
@endsection

@section('content')
<!-- إحصائيات سريعة -->
<div class="row g-4 mb-4">
    <div class="col-md-4">
        <div class="stats-card">
            <div class="d-flex align-items-center">
                <div class="stats-icon bg-primary">
                    <i class="fas fa-users text-white"></i>
                </div>
                <div class="me-3">
                    <div class="stats-number">{{ $stats['total'] ?? 0 }}</div>
                    <div class="text-muted">إجمالي الموظفين</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stats-card">
            <div class="d-flex align-items-center">
                <div class="stats-icon bg-success">
                    <i class="fas fa-user-check text-white"></i>
                </div>
                <div class="me-3">
                    <div class="stats-number">{{ $stats['active'] ?? 0 }}</div>
                    <div class="text-muted">موظف نشط</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stats-card">
            <div class="d-flex align-items-center">
                <div class="stats-icon bg-danger">
                    <i class="fas fa-crown text-white"></i>
                </div>
                <div class="me-3">
                    <div class="stats-number">{{ $stats['super_admins'] ?? 0 }}</div>
                    <div class="text-muted">مدير عام</div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- فلاتر البحث -->
<div class="content-card mb-4">
    <form action="{{ route('admin.admins.index') }}" method="GET">
        <div class="row g-3 align-items-end">
            <div class="col-md-4">
                <label class="form-label">البحث</label>
                <input type="text" name="search" class="form-control" 
                       placeholder="ابحث بالاسم أو البريد أو الجوال..."
                       value="{{ request('search') }}">
            </div>
            <div class="col-md-3">
                <label class="form-label">الرتبة</label>
                <select name="role" class="form-select">
                    <option value="">الكل</option>
                    <option value="developer" {{ request('role') == 'developer' ? 'selected' : '' }}>مطور النظام</option>
                    <option value="super_admin" {{ request('role') == 'super_admin' ? 'selected' : '' }}>مدير عام</option>
                    <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>مشرف</option>
                    <option value="data_entry" {{ request('role') == 'data_entry' ? 'selected' : '' }}>مدخل بيانات</option>
                    <option value="accountant" {{ request('role') == 'accountant' ? 'selected' : '' }}>محاسب</option>
                    <option value="supervisor" {{ request('role') == 'supervisor' ? 'selected' : '' }}>مراقب</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">الحالة</label>
                <select name="status" class="form-select">
                    <option value="">الكل</option>
                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>نشط</option>
                    <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>غير نشط</option>
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="fas fa-search me-1"></i>
                    بحث
                </button>
            </div>
        </div>
    </form>
</div>

<!-- جدول الموظفين -->
<div class="content-card">
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>الموظف</th>
                    <th>الرتبة</th>
                    <th>الجهات</th>
                    <th>الفترات</th>
                    <th>الحالة</th>
                    <th>آخر دخول</th>
                    <th>الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                @forelse($admins as $admin)
                <tr>
                    <td>{{ $admin->id }}</td>
                    <td>
                        <div class="d-flex align-items-center">
                            <div class="rounded-circle d-flex align-items-center justify-content-center me-2" 
                                 style="width: 40px; height: 40px; background: rgba(127, 176, 105, 0.2);">
                                <i class="fas {{ $admin->role_icon ?? 'fa-user' }}" style="color: var(--primary-color);"></i>
                            </div>
                            <div>
                                <div class="fw-bold">
                                    {{ $admin->name }}
                                    @if($admin->id == session('admin_id'))
                                        <span class="badge bg-warning ms-1">أنت</span>
                                    @endif
                                    @if($admin->role == 'developer')
                                        <span class="badge badge-protected ms-1">
                                            <i class="fas fa-shield-alt me-1"></i>محمي
                                        </span>
                                    @endif
                                </div>
                                <small class="text-muted">{{ $admin->username }}</small>
                            </div>
                        </div>
                    </td>
                    <td>
                        @php
                            $roleNames = [
                                'developer' => 'مطور النظام',
                                'super_admin' => 'مدير عام',
                                'admin' => 'مشرف',
                                'data_entry' => 'مدخل بيانات',
                                'accountant' => 'محاسب',
                                'supervisor' => 'مراقب',
                            ];
                            $roleIcons = [
                                'developer' => 'fa-code',
                                'super_admin' => 'fa-crown',
                                'admin' => 'fa-user-shield',
                                'data_entry' => 'fa-keyboard',
                                'accountant' => 'fa-calculator',
                                'supervisor' => 'fa-eye',
                            ];
                        @endphp
                        <span class="badge badge-role-{{ $admin->role }}">
                            <i class="fas {{ $roleIcons[$admin->role] ?? 'fa-user' }} me-1"></i>
                            {{ $roleNames[$admin->role] ?? 'غير محدد' }}
                        </span>
                    </td>
                    <td>
                        @if(in_array($admin->role, ['developer', 'super_admin']))
                            <span class="text-success small">
                                <i class="fas fa-globe me-1"></i>جميع الجهات
                            </span>
                        @elseif($admin->centers->isEmpty())
                            <span class="text-muted small">
                                <i class="fas fa-globe me-1"></i>جميع الجهات
                            </span>
                        @else
                            @foreach($admin->centers->take(2) as $center)
                                <span class="badge bg-light text-dark mb-1">{{ $center->center_name }}</span>
                            @endforeach
                            @if($admin->centers->count() > 2)
                                <span class="badge bg-secondary">+{{ $admin->centers->count() - 2 }}</span>
                            @endif
                        @endif
                    </td>
                    <td>
                        @if(in_array($admin->role, ['developer', 'super_admin']))
                            <span class="text-success small">
                                <i class="fas fa-clock me-1"></i>الكل
                            </span>
                        @else
                            @php
                                $schedules = $admin->allowed_schedules ?? [];
                                if (!is_array($schedules)) $schedules = [];
                            @endphp
                            @if(empty($schedules))
                                <span class="text-muted small">
                                    <i class="fas fa-clock me-1"></i>الكل
                                </span>
                            @else
                                @if(in_array('صباحية', $schedules))
                                    <span class="badge bg-warning text-dark mb-1">
                                        <i class="fas fa-sun me-1"></i>صباحية
                                    </span>
                                @endif
                                @if(in_array('مسائية', $schedules))
                                    <span class="badge bg-primary mb-1">
                                        <i class="fas fa-moon me-1"></i>مسائية
                                    </span>
                                @endif
                            @endif
                        @endif
                    </td>
                    <td>
                        @if($admin->status == 'active')
                            <span class="badge bg-success">نشط</span>
                        @else
                            <span class="badge bg-danger">غير نشط</span>
                        @endif
                    </td>
                    <td>
                        @if($admin->last_login)
                            <small>{{ \Carbon\Carbon::parse($admin->last_login)->diffForHumans() }}</small>
                        @else
                            <small class="text-muted">لم يدخل بعد</small>
                        @endif
                    </td>
                    <td>
                        <div class="btn-group" role="group">
                            @if($currentAdmin && $admin->role != 'developer')
                                @if($currentAdmin->role == 'developer' || ($currentAdmin->role == 'super_admin' && $admin->role != 'super_admin'))
                                <a href="{{ route('admin.admins.edit', $admin) }}" 
                                   class="btn btn-sm btn-outline-warning" title="تعديل">
                                    <i class="fas fa-edit"></i>
                                </a>
                                @endif
                            @endif
                            
                            @if($currentAdmin && $admin->id != session('admin_id') && $admin->role != 'developer')
                                @if($currentAdmin->role == 'developer' || ($currentAdmin->role == 'super_admin' && $admin->role != 'super_admin'))
                                <form action="{{ route('admin.admins.toggle-status', $admin) }}" 
                                      method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" 
                                            class="btn btn-sm btn-outline-{{ $admin->status == 'active' ? 'secondary' : 'success' }}"
                                            title="{{ $admin->status == 'active' ? 'تعطيل' : 'تفعيل' }}">
                                        <i class="fas fa-{{ $admin->status == 'active' ? 'ban' : 'check' }}"></i>
                                    </button>
                                </form>
                                @endif
                                
                                @if($currentAdmin->role == 'developer' || ($currentAdmin->role == 'super_admin' && !in_array($admin->role, ['developer', 'super_admin'])))
                                <button type="button" class="btn btn-sm btn-outline-danger" 
                                        onclick="confirmDelete({{ $admin->id }}, '{{ $admin->name }}')"
                                        title="حذف">
                                    <i class="fas fa-trash"></i>
                                </button>
                                @endif
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center py-4">
                        <i class="fas fa-users fa-3x mb-3 text-muted"></i>
                        <p class="text-muted">لا يوجد موظفين</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($admins->hasPages())
    <div class="d-flex justify-content-center mt-4">
        {{ $admins->links() }}
    </div>
    @endif
</div>

<!-- Modal تأكيد الحذف -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    تأكيد الحذف
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center py-4">
                <i class="fas fa-user-times fa-4x text-danger mb-3"></i>
                <p class="mb-0">هل أنت متأكد من حذف الموظف:</p>
                <h5 id="adminNameToDelete" class="text-danger mt-2"></h5>
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                <form id="deleteForm" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash me-1"></i>حذف
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .badge-role-developer { background: rgba(255, 193, 7, 0.2) !important; color: #f39c12 !important; }
    .badge-role-super_admin { background: rgba(220, 53, 69, 0.15) !important; color: #ff6b7a !important; }
    .badge-role-admin { background: rgba(127, 176, 105, 0.15) !important; color: #7fb069 !important; }
    .badge-role-data_entry { background: rgba(23, 162, 184, 0.15) !important; color: #5dd3e8 !important; }
    .badge-role-accountant { background: rgba(40, 167, 69, 0.15) !important; color: #5dd879 !important; }
    .badge-role-supervisor { background: rgba(108, 117, 125, 0.15) !important; color: #adb5bd !important; }
    .badge-protected { background: rgba(108, 117, 125, 0.15) !important; color: #adb5bd !important; }
</style>
@endpush

@push('scripts')
<script>
function confirmDelete(adminId, adminName) {
    document.getElementById('adminNameToDelete').textContent = adminName;
    document.getElementById('deleteForm').action = '/admin/admins/' + adminId;
    new bootstrap.Modal(document.getElementById('deleteModal')).show();
}
</script>
@endpush