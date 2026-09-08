@extends('layouts.admin')

@php
    use App\Models\Admin;
    $currentAdmin = Admin::find(session('admin_id'));
@endphp

@section('title', 'إضافة موظف جديد')

@section('header')
<div class="d-flex justify-content-between align-items-center w-100">
    <div>
        <h2 class="mb-1">
            <i class="fas fa-user-plus me-2"></i>
            إضافة موظف جديد
        </h2>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">لوحة التحكم</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.admins.index') }}">الموظفين</a></li>
                <li class="breadcrumb-item active">إضافة موظف</li>
            </ol>
        </nav>
    </div>
    <a href="{{ route('admin.admins.index') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-right me-1"></i>
        رجوع للقائمة
    </a>
</div>
@endsection

@section('content')
<form action="{{ route('admin.admins.store') }}" method="POST">
    @csrf
    
    <div class="row">
        <!-- البيانات الأساسية -->
        <div class="col-lg-8">
            <div class="content-card mb-4">
                <h5 class="mb-4">
                    <i class="fas fa-user me-2" style="color: var(--primary-color);"></i>
                    البيانات الأساسية
                </h5>
                
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">الاسم الكامل <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                               value="{{ old('name') }}" required placeholder="أدخل الاسم الكامل">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">اسم المستخدم <span class="text-danger">*</span></label>
                        <input type="text" name="username" class="form-control @error('username') is-invalid @enderror" 
                               value="{{ old('username') }}" required placeholder="اسم الدخول للنظام">
                        @error('username')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">البريد الإلكتروني</label>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" 
                               value="{{ old('email') }}" placeholder="example@email.com">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">رقم الجوال</label>
                        <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" 
                               value="{{ old('phone') }}" placeholder="05xxxxxxxx">
                        @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">كلمة المرور <span class="text-danger">*</span></label>
                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" 
                               required placeholder="6 أحرف على الأقل">
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">تأكيد كلمة المرور <span class="text-danger">*</span></label>
                        <input type="password" name="password_confirmation" class="form-control" 
                               required placeholder="أعد كتابة كلمة المرور">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">المسمى الوظيفي</label>
                        <input type="text" name="job_title" class="form-control @error('job_title') is-invalid @enderror" 
                               value="{{ old('job_title') }}" placeholder="مثال: مسؤول القبول">
                        @error('job_title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">الحالة <span class="text-danger">*</span></label>
                        <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                            <option value="active" {{ old('status', 'active') == 'active' ? 'selected' : '' }}>نشط</option>
                            <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>غير نشط</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- الصلاحيات المخصصة -->
            <div class="content-card mb-4">
                <h5 class="mb-4">
                    <i class="fas fa-key me-2" style="color: var(--primary-color);"></i>
                    صلاحيات الموظف
                    <small class="text-muted fw-normal me-2">- اختر الصلاحيات المناسبة</small>
                </h5>
                
                <div class="row">
                    <!-- الطالبات -->
                    <div class="col-md-6 col-lg-4 mb-3">
                        <div class="permission-card">
                            <div class="permission-header">
                                <i class="fas fa-user-graduate me-2"></i>الطالبات
                            </div>
                            <div class="permission-body">
                                <div class="form-check">
                                    <input type="checkbox" name="permissions[]" value="students.view" 
                                           class="form-check-input" id="perm_students_view"
                                           {{ in_array('students.view', old('permissions', [])) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="perm_students_view">عرض الطالبات</label>
                                </div>
                                <div class="form-check">
                                    <input type="checkbox" name="permissions[]" value="students.create" 
                                           class="form-check-input" id="perm_students_create"
                                           {{ in_array('students.create', old('permissions', [])) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="perm_students_create">إضافة طالبات</label>
                                </div>
                                <div class="form-check">
                                    <input type="checkbox" name="permissions[]" value="students.edit" 
                                           class="form-check-input" id="perm_students_edit"
                                           {{ in_array('students.edit', old('permissions', [])) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="perm_students_edit">تعديل الطالبات</label>
                                </div>
                                <div class="form-check">
                                    <input type="checkbox" name="permissions[]" value="students.delete" 
                                           class="form-check-input" id="perm_students_delete"
                                           {{ in_array('students.delete', old('permissions', [])) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="perm_students_delete">حذف الطالبات</label>
                                </div>
                                <div class="form-check">
                                    <input type="checkbox" name="permissions[]" value="students.approve" 
                                           class="form-check-input" id="perm_students_approve"
                                           {{ in_array('students.approve', old('permissions', [])) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="perm_students_approve">قبول/رفض الطالبات</label>
                                </div>
                                <div class="form-check">
                                    <input type="checkbox" name="permissions[]" value="students.assign_bus" 
                                           class="form-check-input" id="perm_students_assign_bus"
                                           {{ in_array('students.assign_bus', old('permissions', [])) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="perm_students_assign_bus">تخصيص باصات</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- الباصات -->
                    <div class="col-md-6 col-lg-4 mb-3">
                        <div class="permission-card">
                            <div class="permission-header">
                                <i class="fas fa-bus me-2"></i>الباصات
                            </div>
                            <div class="permission-body">
                                <div class="form-check">
                                    <input type="checkbox" name="permissions[]" value="buses.view" 
                                           class="form-check-input" id="perm_buses_view"
                                           {{ in_array('buses.view', old('permissions', [])) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="perm_buses_view">عرض الباصات</label>
                                </div>
                                <div class="form-check">
                                    <input type="checkbox" name="permissions[]" value="buses.create" 
                                           class="form-check-input" id="perm_buses_create"
                                           {{ in_array('buses.create', old('permissions', [])) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="perm_buses_create">إضافة باصات</label>
                                </div>
                                <div class="form-check">
                                    <input type="checkbox" name="permissions[]" value="buses.edit" 
                                           class="form-check-input" id="perm_buses_edit"
                                           {{ in_array('buses.edit', old('permissions', [])) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="perm_buses_edit">تعديل الباصات</label>
                                </div>
                                <div class="form-check">
                                    <input type="checkbox" name="permissions[]" value="buses.delete" 
                                           class="form-check-input" id="perm_buses_delete"
                                           {{ in_array('buses.delete', old('permissions', [])) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="perm_buses_delete">حذف الباصات</label>
                                </div>
                                <div class="form-check">
                                    <input type="checkbox" name="permissions[]" value="buses.assign_students" 
                                           class="form-check-input" id="perm_buses_assign"
                                           {{ in_array('buses.assign_students', old('permissions', [])) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="perm_buses_assign">تخصيص طالبات للباصات</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- السائقين -->
                    <div class="col-md-6 col-lg-4 mb-3">
                        <div class="permission-card">
                            <div class="permission-header">
                                <i class="fas fa-id-card me-2"></i>السائقين
                            </div>
                            <div class="permission-body">
                                <div class="form-check">
                                    <input type="checkbox" name="permissions[]" value="drivers.view" 
                                           class="form-check-input" id="perm_drivers_view"
                                           {{ in_array('drivers.view', old('permissions', [])) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="perm_drivers_view">عرض السائقين</label>
                                </div>
                                <div class="form-check">
                                    <input type="checkbox" name="permissions[]" value="drivers.create" 
                                           class="form-check-input" id="perm_drivers_create"
                                           {{ in_array('drivers.create', old('permissions', [])) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="perm_drivers_create">إضافة سائقين</label>
                                </div>
                                <div class="form-check">
                                    <input type="checkbox" name="permissions[]" value="drivers.edit" 
                                           class="form-check-input" id="perm_drivers_edit"
                                           {{ in_array('drivers.edit', old('permissions', [])) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="perm_drivers_edit">تعديل السائقين</label>
                                </div>
                                <div class="form-check">
                                    <input type="checkbox" name="permissions[]" value="drivers.delete" 
                                           class="form-check-input" id="perm_drivers_delete"
                                           {{ in_array('drivers.delete', old('permissions', [])) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="perm_drivers_delete">حذف السائقين</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- الدفعات -->
                    <div class="col-md-6 col-lg-4 mb-3">
                        <div class="permission-card">
                            <div class="permission-header">
                                <i class="fas fa-money-bill-wave me-2"></i>الدفعات
                            </div>
                            <div class="permission-body">
                                <div class="form-check">
                                    <input type="checkbox" name="permissions[]" value="payments.view" 
                                           class="form-check-input" id="perm_payments_view"
                                           {{ in_array('payments.view', old('permissions', [])) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="perm_payments_view">عرض الدفعات</label>
                                </div>
                                <div class="form-check">
                                    <input type="checkbox" name="permissions[]" value="payments.create" 
                                           class="form-check-input" id="perm_payments_create"
                                           {{ in_array('payments.create', old('permissions', [])) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="perm_payments_create">إضافة دفعات</label>
                                </div>
                                <div class="form-check">
                                    <input type="checkbox" name="permissions[]" value="payments.edit" 
                                           class="form-check-input" id="perm_payments_edit"
                                           {{ in_array('payments.edit', old('permissions', [])) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="perm_payments_edit">تعديل الدفعات</label>
                                </div>
                                <div class="form-check">
                                    <input type="checkbox" name="permissions[]" value="payments.delete" 
                                           class="form-check-input" id="perm_payments_delete"
                                           {{ in_array('payments.delete', old('permissions', [])) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="perm_payments_delete">حذف الدفعات</label>
                                </div>
                                <div class="form-check">
                                    <input type="checkbox" name="permissions[]" value="payments.approve" 
                                           class="form-check-input" id="perm_payments_approve"
                                           {{ in_array('payments.approve', old('permissions', [])) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="perm_payments_approve">اعتماد الدفعات</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- الجهات -->
                    <div class="col-md-6 col-lg-4 mb-3">
                        <div class="permission-card">
                            <div class="permission-header">
                                <i class="fas fa-building me-2"></i>الجهات
                            </div>
                            <div class="permission-body">
                                <div class="form-check">
                                    <input type="checkbox" name="permissions[]" value="centers.view" 
                                           class="form-check-input" id="perm_centers_view"
                                           {{ in_array('centers.view', old('permissions', [])) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="perm_centers_view">عرض الجهات</label>
                                </div>
                                <div class="form-check">
                                    <input type="checkbox" name="permissions[]" value="centers.edit" 
                                           class="form-check-input" id="perm_centers_edit"
                                           {{ in_array('centers.edit', old('permissions', [])) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="perm_centers_edit">تعديل الجهات</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- التقارير والموظفين -->
                    <div class="col-md-6 col-lg-4 mb-3">
                        <div class="permission-card">
                            <div class="permission-header">
                                <i class="fas fa-cog me-2"></i>أخرى
                            </div>
                            <div class="permission-body">
                                <div class="form-check">
                                    <input type="checkbox" name="permissions[]" value="reports.view" 
                                           class="form-check-input" id="perm_reports_view"
                                           {{ in_array('reports.view', old('permissions', [])) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="perm_reports_view">عرض التقارير</label>
                                </div>
                                <div class="form-check">
                                    <input type="checkbox" name="permissions[]" value="reports.create" 
                                           class="form-check-input" id="perm_reports_create"
                                           {{ in_array('reports.create', old('permissions', [])) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="perm_reports_create">إنشاء التقارير</label>
                                </div>
                                <div class="form-check">
                                    <input type="checkbox" name="permissions[]" value="admins.view" 
                                           class="form-check-input" id="perm_admins_view"
                                           {{ in_array('admins.view', old('permissions', [])) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="perm_admins_view">عرض الموظفين</label>
                                </div>
                                <div class="form-check">
                                    <input type="checkbox" name="permissions[]" value="admins.create" 
                                           class="form-check-input" id="perm_admins_create"
                                           {{ in_array('admins.create', old('permissions', [])) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="perm_admins_create">إضافة موظفين</label>
                                </div>
                                <div class="form-check">
                                    <input type="checkbox" name="permissions[]" value="admins.edit" 
                                           class="form-check-input" id="perm_admins_edit"
                                           {{ in_array('admins.edit', old('permissions', [])) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="perm_admins_edit">تعديل الموظفين</label>
                                </div>
                                <div class="form-check">
                                    <input type="checkbox" name="permissions[]" value="admins.delete" 
                                           class="form-check-input" id="perm_admins_delete"
                                           {{ in_array('admins.delete', old('permissions', [])) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="perm_admins_delete">حذف الموظفين</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- الشريط الجانبي -->
        <div class="col-lg-4">
            <!-- الرتبة -->
            <div class="content-card mb-4">
                <h5 class="mb-4">
                    <i class="fas fa-user-tag me-2" style="color: var(--primary-color);"></i>
                    الرتبة
                </h5>
                
                <select name="role" class="form-select @error('role') is-invalid @enderror" required>
                    <option value="">-- اختر الرتبة --</option>
                    @if($currentAdmin && $currentAdmin->role == 'developer')
                        <option value="super_admin" {{ old('role') == 'super_admin' ? 'selected' : '' }}>مدير عام</option>
                    @endif
                    <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>مشرف</option>
                    <option value="data_entry" {{ old('role') == 'data_entry' ? 'selected' : '' }}>مدخل بيانات</option>
                    <option value="accountant" {{ old('role') == 'accountant' ? 'selected' : '' }}>محاسب</option>
                    <option value="supervisor" {{ old('role') == 'supervisor' ? 'selected' : '' }}>مراقب</option>
                </select>
                @error('role')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                
                <small class="text-muted d-block mt-2">
                    <i class="fas fa-info-circle me-1"></i>
                    الرتبة تحدد مستوى الموظف فقط، الصلاحيات تُحدد أعلاه
                </small>
            </div>

            <!-- الفترات المسموح بها -->
            <div class="content-card mb-4">
                <h5 class="mb-3">
                    <i class="fas fa-clock me-2" style="color: var(--primary-color);"></i>
                    الفترات المسموح بها
                </h5>
                
                <div class="alert alert-info py-2 mb-3">
                    <small><i class="fas fa-info-circle me-1"></i>إذا لم تختر أي فترة، سيكون له وصول لكل الفترات</small>
                </div>
                
                <div class="form-check mb-2">
                    <input type="checkbox" name="allowed_schedules[]" value="صباحية" 
                           class="form-check-input" id="schedule_morning"
                           {{ in_array('صباحية', old('allowed_schedules', [])) ? 'checked' : '' }}>
                    <label class="form-check-label" for="schedule_morning">
                        <i class="fas fa-sun text-warning me-1"></i>
                        الفترة الصباحية
                    </label>
                </div>
                <div class="form-check">
                    <input type="checkbox" name="allowed_schedules[]" value="مسائية" 
                           class="form-check-input" id="schedule_evening"
                           {{ in_array('مسائية', old('allowed_schedules', [])) ? 'checked' : '' }}>
                    <label class="form-check-label" for="schedule_evening">
                        <i class="fas fa-moon text-primary me-1"></i>
                        الفترة المسائية
                    </label>
                </div>
            </div>

            <!-- الجهات المسؤول عنها -->
            <div class="content-card mb-4">
                <h5 class="mb-3">
                    <i class="fas fa-building me-2" style="color: var(--primary-color);"></i>
                    الجهات المسؤول عنها
                </h5>
                
                <div class="alert alert-warning py-2 mb-3">
                    <small><i class="fas fa-exclamation-triangle me-1"></i>إذا لم تختر أي جهة، سيكون مسؤولاً عن جميع الجهات</small>
                </div>
                
                <div class="form-check mb-2">
                    <input type="checkbox" class="form-check-input" id="selectAllCenters">
                    <label class="form-check-label fw-bold" for="selectAllCenters">تحديد الكل</label>
                </div>
                
                <hr class="my-2">
                
                @foreach($centers as $center)
                    <div class="form-check">
                        <input type="checkbox" name="center_ids[]" value="{{ $center->id }}" 
                               class="form-check-input center-checkbox" id="center_{{ $center->id }}"
                               {{ in_array($center->id, old('center_ids', [])) ? 'checked' : '' }}>
                        <label class="form-check-label" for="center_{{ $center->id }}">
                            {{ $center->center_name }}
                        </label>
                    </div>
                @endforeach
            </div>

            <!-- أزرار الحفظ -->
            <div class="content-card">
                <button type="submit" class="btn btn-primary w-100 mb-2">
                    <i class="fas fa-save me-2"></i>حفظ الموظف
                </button>
                <a href="{{ route('admin.admins.index') }}" class="btn btn-outline-secondary w-100">
                    <i class="fas fa-times me-2"></i>إلغاء
                </a>
            </div>
        </div>
    </div>
</form>
@endsection

@push('styles')
<style>
    .permission-card {
        background: rgba(255,255,255,0.03);
        border: 1px solid rgba(255,255,255,0.1);
        border-radius: 10px;
        overflow: hidden;
        height: 100%;
    }
    .permission-header {
        background: rgba(127, 176, 105, 0.15);
        padding: 10px 15px;
        font-weight: 600;
        color: var(--primary-color);
        border-bottom: 1px solid rgba(255,255,255,0.1);
    }
    .permission-body {
        padding: 15px;
    }
    .permission-body .form-check {
        margin-bottom: 8px;
    }
    .permission-body .form-check:last-child {
        margin-bottom: 0;
    }
</style>
@endpush

@push('scripts')
<script>
    document.getElementById('selectAllCenters').addEventListener('change', function() {
        document.querySelectorAll('.center-checkbox').forEach(cb => cb.checked = this.checked);
    });
</script>
@endpush