@extends('layouts.admin')

@section('title', 'تعديل السائق - ' . $driver->name)

@section('header')
<div class="d-flex justify-content-between align-items-center w-100">
    <div>
        <h2 class="mb-1">
            <i class="fas fa-user-edit text-warning me-2"></i>
            تعديل بيانات السائق
        </h2>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">لوحة التحكم</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.drivers.index') }}">السائقين</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.drivers.show', $driver) }}">{{ $driver->name }}</a></li>
                <li class="breadcrumb-item active">تعديل</li>
            </ol>
        </nav>
    </div>
    <a href="{{ route('admin.drivers.show', $driver) }}" class="btn btn-outline-light">
        <i class="fas fa-arrow-right me-1"></i>
        العودة
    </a>
</div>
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <!-- تحذير للباصات المرتبطة -->
        @if($driver->buses && $driver->buses->count() > 0)
        <div class="alert alert-warning mb-4">
            <i class="fas fa-exclamation-triangle me-2"></i>
            <strong>تنبيه:</strong> هذا السائق مخصص لـ {{ $driver->buses->count() }} باص.
            @if($driver->activeBus)
            <a href="{{ route('admin.buses.show', $driver->activeBus) }}" class="btn btn-sm btn-outline-warning mt-2">
                <i class="fas fa-bus me-1"></i>
                عرض الباص النشط
            </a>
            @endif
        </div>
        @endif
        
        <div class="content-card">
            <form action="{{ route('admin.drivers.update', $driver) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="row">
                    <!-- البيانات الشخصية -->
                    <div class="col-12 mb-4">
                        <h5 class="border-bottom border-secondary pb-2 mb-3">
                            <i class="fas fa-user text-info me-2"></i>
                            البيانات الشخصية
                        </h5>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">الاسم الكامل <span class="text-danger">*</span></label>
                        <input type="text" 
                               name="name" 
                               class="form-control @error('name') is-invalid @enderror"
                               value="{{ old('name', $driver->name) }}"
                               required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">رقم الجوال <span class="text-danger">*</span></label>
                        <input type="tel" 
                               name="mobile" 
                               class="form-control @error('mobile') is-invalid @enderror"
                               value="{{ old('mobile', $driver->mobile) }}"
                               pattern="05[0-9]{8}"
                               required>
                        @error('mobile')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">البريد الإلكتروني</label>
                        <input type="email" 
                               name="email" 
                               class="form-control @error('email') is-invalid @enderror"
                               value="{{ old('email', $driver->email) }}">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">العنوان</label>
                        <input type="text" 
                               name="address" 
                               class="form-control @error('address') is-invalid @enderror"
                               value="{{ old('address', $driver->address) }}">
                        @error('address')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- معلومات الرخصة -->
                    <div class="col-12 mb-4 mt-3">
                        <h5 class="border-bottom border-secondary pb-2 mb-3">
                            <i class="fas fa-id-card text-warning me-2"></i>
                            معلومات الرخصة
                        </h5>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">رقم الرخصة <small class="text-muted">(اختياري)</small></label>
                        <input type="text" 
                               name="license_number" 
                               class="form-control @error('license_number') is-invalid @enderror"
                               value="{{ old('license_number', $driver->license_number) }}">
                        @error('license_number')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">نوع الرخصة</label>
                        <select name="license_type" class="form-select @error('license_type') is-invalid @enderror">
                            <option value="عام" {{ old('license_type', $driver->license_type) == 'عام' ? 'selected' : '' }}>عام</option>
                            <option value="خاص" {{ old('license_type', $driver->license_type) == 'خاص' ? 'selected' : '' }}>خاص</option>
                            <option value="نقل ثقيل" {{ old('license_type', $driver->license_type) == 'نقل ثقيل' ? 'selected' : '' }}>نقل ثقيل</option>
                        </select>
                        @error('license_type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">سنوات الخبرة</label>
                        <input type="number" 
                               name="experience_years" 
                               class="form-control @error('experience_years') is-invalid @enderror"
                               value="{{ old('experience_years', $driver->experience_years) }}"
                               min="0"
                               max="50">
                        @error('experience_years')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">تاريخ التوظيف</label>
                        <input type="date" 
                               name="hire_date" 
                               class="form-control @error('hire_date') is-invalid @enderror"
                               value="{{ old('hire_date', $driver->hire_date?->format('Y-m-d')) }}">
                        @error('hire_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- معلومات العمل -->
                    <div class="col-12 mb-4 mt-3">
                        <h5 class="border-bottom border-secondary pb-2 mb-3">
                            <i class="fas fa-briefcase text-success me-2"></i>
                            معلومات العمل
                        </h5>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">المركز المخصص</label>
                        <select name="center_id" class="form-select @error('center_id') is-invalid @enderror">
                            <option value="">-- غير مخصص --</option>
                            @if(isset($centers) && count($centers) > 0)
                                @foreach($centers as $key => $name)
                                    <option value="{{ $key }}" {{ old('center_id', $driver->center_id) == $key ? 'selected' : '' }}>
                                        {{ $name }}
                                    </option>
                                @endforeach
                            @endif
                        </select>
                        @error('center_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">الحالة <span class="text-danger">*</span></label>
                        <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                            <option value="active" {{ old('status', $driver->status) == 'active' ? 'selected' : '' }}>نشط</option>
                            <option value="inactive" {{ old('status', $driver->status) == 'inactive' ? 'selected' : '' }}>غير نشط</option>
                            <option value="on_leave" {{ old('status', $driver->status) == 'on_leave' ? 'selected' : '' }}>في إجازة</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">الراتب (ريال)</label>
                        <input type="number" 
                               name="salary" 
                               class="form-control @error('salary') is-invalid @enderror"
                               value="{{ old('salary', $driver->salary) }}"
                               min="0"
                               step="100">
                        @error('salary')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- جهة اتصال الطوارئ -->
                    <div class="col-12 mb-4 mt-3">
                        <h5 class="border-bottom border-secondary pb-2 mb-3">
                            <i class="fas fa-phone-alt text-danger me-2"></i>
                            جهة اتصال الطوارئ
                        </h5>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">اسم جهة الاتصال</label>
                        <input type="text" 
                               name="emergency_contact" 
                               class="form-control @error('emergency_contact') is-invalid @enderror"
                               value="{{ old('emergency_contact', $driver->emergency_contact) }}">
                        @error('emergency_contact')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">رقم الطوارئ</label>
                        <input type="tel" 
                               name="emergency_phone" 
                               class="form-control @error('emergency_phone') is-invalid @enderror"
                               value="{{ old('emergency_phone', $driver->emergency_phone) }}">
                        @error('emergency_phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- ملاحظات -->
                    <div class="col-12 mb-3">
                        <label class="form-label">ملاحظات</label>
                        <textarea name="notes" 
                                  class="form-control @error('notes') is-invalid @enderror"
                                  rows="3">{{ old('notes', $driver->notes) }}</textarea>
                        @error('notes')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <hr class="border-secondary my-4">

                <div class="d-flex justify-content-between">
                    <div>
                        <a href="{{ route('admin.drivers.show', $driver) }}" class="btn btn-outline-secondary">
                            <i class="fas fa-times me-1"></i>
                            إلغاء
                        </a>
                    </div>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-warning">
                            <i class="fas fa-save me-2"></i>
                            حفظ التغييرات
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.content-card {
    background: rgba(255,255,255,0.05);
    backdrop-filter: blur(10px);
    border-radius: 15px;
    padding: 2rem;
    border: 1px solid rgba(255,255,255,0.1);
}

.form-control, .form-select {
    background: rgba(255,255,255,0.05);
    border-color: rgba(255,255,255,0.2);
    color: #fff;
}

.form-control:focus, .form-select:focus {
    background: rgba(255,255,255,0.1);
    border-color: #ffc107;
    color: #fff;
    box-shadow: 0 0 0 0.2rem rgba(255, 193, 7, 0.25);
}

.form-control::placeholder {
    color: rgba(255,255,255,0.4);
}

.form-select option {
    background: #1a1a2e;
    color: #fff;
}
</style>
@endpush