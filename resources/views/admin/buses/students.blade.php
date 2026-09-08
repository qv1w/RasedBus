@extends('layouts.admin')

@section('title', 'طلاب الباص ' . $bus->number)

@section('header')
    <div class="d-flex justify-content-between align-items-center w-100">
        <div>
            <h2 class="mb-1">
                <i class="fas fa-users text-primary me-2"></i>
                طلاب الباص {{ $bus->number }}
            </h2>
            <p class="text-light mb-0 opacity-75">
                إدارة وتنظيم الطلاب المخصصين للباص
            </p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.buses.show', $bus) }}" class="btn btn-outline-light">
                <i class="fas fa-eye me-2"></i>
                تفاصيل الباص
            </a>
            <a href="{{ route('admin.buses.index') }}" class="btn btn-outline-light">
                <i class="fas fa-arrow-right me-2"></i>
                العودة للقائمة
            </a>
        </div>
    </div>
@endsection
 
@section('content')
<!-- مؤشر السعة -->
<div class="content-card mb-4">
    <div class="row align-items-center">
        <div class="col-md-8">
            <h5 class="mb-2">
                <i class="fas fa-chart-bar text-info me-2"></i>
                حالة الإشغال
            </h5>
            @php
                $currentStudents = $bus->students ? $bus->students->count() : 0;
                $capacity = $bus->capacity ?? 0;
                $occupancyPercentage = $capacity > 0 ? round(($currentStudents / $capacity) * 100, 1) : 0;
                $availableSeats = max(0, $capacity - $currentStudents);
            @endphp
            <div class="d-flex justify-content-between mb-2">
                <span>{{ $currentStudents }}/{{ $capacity }} طالب</span>
                <span>{{ $occupancyPercentage }}%</span>
            </div>
            <div class="progress" style="height: 12px;">
                @php
                    $capacityClass = $occupancyPercentage >= 80 ? 'bg-danger' : 
                                   ($occupancyPercentage >= 50 ? 'bg-warning' : 'bg-success');
                @endphp
                <div class="progress-bar {{ $capacityClass }}" 
                     style="width: {{ $occupancyPercentage }}%"></div>
            </div>
        </div>
        <div class="col-md-4 text-center">
            @if($availableSeats > 0)
                <div class="text-success">
                    <i class="fas fa-check-circle fa-2x mb-2"></i>
                    <h6>{{ $availableSeats }} مقعد متاح</h6>
                </div>
            @else
                <div class="text-danger">
                    <i class="fas fa-times-circle fa-2x mb-2"></i>
                    <h6>الباص ممتلئ</h6>
                </div>
            @endif
        </div>
    </div>
</div>

<div class="row">
    <!-- الطلاب الحاليين -->
    <div class="col-md-6">
        <div class="content-card h-100">
            <h4 class="text-primary mb-4">
                <i class="fas fa-users me-2"></i>
                الطلاب الحاليين ({{ $currentStudents }})
            </h4>

            @if($currentStudents > 0)
                <div class="mb-3">
                    <input type="text" id="currentStudentsSearch" class="form-control" 
                           placeholder="البحث في الطلاب الحاليين...">
                </div>

                <div id="currentStudentsList" style="max-height: 600px; overflow-y: auto;">
                    @foreach($bus->students as $student)
                        <div class="student-card mb-3 p-3 rounded border border-light border-opacity-25" 
                             data-student-name="{{ strtolower($student->name ?? '') }}" 
                             data-student-id="{{ $student->student_id ?? '' }}">
                            <div class="d-flex justify-content-between align-items-start">
                                <div class="flex-grow-1">
                                    <h6 class="text-light mb-1">
                                        <strong>{{ $student->name ?? 'غير محدد' }}</strong>
                                        @if($student->student_id)
                                            <small class="text-muted">({{ $student->student_id }})</small>
                                        @endif
                                    </h6>
                                    <div class="small text-muted mb-2">
                                        <i class="fas fa-phone me-1"></i> {{ $student->mobile ?? 'غير محدد' }}
                                        @if($student->neighborhood)
                                            | <i class="fas fa-map-marker-alt me-1"></i> {{ $student->neighborhood }}
                                        @endif
                                    </div>
                                    @if($student->pickup_point)
                                        <div class="small text-info">
                                            <i class="fas fa-map-pin me-1"></i> {{ $student->pickup_point }}
                                            @if($student->pickup_time)
                                                - {{ $student->pickup_time }}
                                            @endif
                                        </div>
                                    @endif
                                </div>
                                <div class="d-flex gap-1">
                                    <a href="{{ route('admin.students.show', $student->id) }}" 
                                       class="btn btn-outline-light btn-sm" title="عرض التفاصيل">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <button onclick="removeStudentFromBus({{ $student->id }})" 
                                            class="btn btn-outline-danger btn-sm" title="إزالة من الباص">
                                        <i class="fas fa-user-minus"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-users-slash fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">لا يوجد طلاب مخصصين</h5>
                    <p class="text-muted">لم يتم تخصيص أي طلاب لهذا الباص بعد</p>
                </div>
            @endif
        </div>
    </div>

    <!-- الطلاب المتاحين للإضافة -->
    <div class="col-md-6">
        <div class="content-card h-100">
            <h4 class="text-success mb-4">
                <i class="fas fa-user-plus me-2"></i>
                الطلاب المتاحين للإضافة ({{ $availableStudents->count() }})
            </h4>

            @if($availableStudents->count() > 0)
                @if($availableSeats > 0)
                    <div class="mb-3">
                        <input type="text" id="availableStudentsSearch" class="form-control" 
                               placeholder="البحث في الطلاب المتاحين...">
                    </div>

                    <div id="availableStudentsList" style="max-height: 600px; overflow-y: auto;">
                        @foreach($availableStudents as $student)
                            <div class="student-card mb-3 p-3 rounded border border-success border-opacity-25" 
                                 data-student-name="{{ strtolower($student->name ?? '') }}" 
                                 data-student-id="{{ $student->student_id ?? '' }}">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div class="flex-grow-1">
                                        <h6 class="text-light mb-1">
                                            <strong>{{ $student->name ?? 'غير محدد' }}</strong>
                                            @if($student->student_id)
                                                <small class="text-muted">({{ $student->student_id }})</small>
                                            @endif
                                        </h6>
                                        <div class="small text-muted mb-2">
                                            <i class="fas fa-phone me-1"></i> {{ $student->mobile ?? 'غير محدد' }}
                                            @if($student->neighborhood)
                                                | <i class="fas fa-map-marker-alt me-1"></i> {{ $student->neighborhood }}
                                            @endif
                                        </div>
                                        @if($student->address)
                                            <div class="small text-muted">
                                                <i class="fas fa-home me-1"></i> {{ Str::limit($student->address, 50) }}
                                            </div>
                                        @endif
                                    </div>
                                    <div class="d-flex gap-1">
                                        <a href="{{ route('admin.students.show', $student->id) }}" 
                                           class="btn btn-outline-light btn-sm" title="عرض التفاصيل">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <button onclick="addStudentToBus({{ $student->id }})" 
                                                class="btn btn-outline-success btn-sm" title="إضافة للباص">
                                            <i class="fas fa-user-plus"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        الباص ممتلئ بالكامل. لا يمكن إضافة مزيد من الطلاب.
                    </div>
                    <div class="text-center py-3">
                        <p class="text-muted">
                            السعة الحالية: {{ $currentStudents }}/{{ $capacity }}
                        </p>
                    </div>
                @endif
            @else
                <div class="text-center py-5">
                    <i class="fas fa-user-check fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">لا يوجد طلاب متاحين</h5>
                    <p class="text-muted">
                        @if($bus->center)
                            جميع الطلاب في مركز {{ $bus->center->center_name }} مخصصين بالفعل
                        @else
                            لا يوجد طلاب متاحين للإضافة حالياً
                        @endif
                    </p> 
                </div>
            @endif
        </div>
    </div>
</div>
 
<!-- إجراءات سريعة -->
@if($availableSeats > 0 && $availableStudents->count() > 0)
    <div class="content-card mt-4">
        <h4 class="text-warning mb-4">
            <i class="fas fa-magic me-2"></i>
            إجراءات سريعة
        </h4>
        
        <div class="row g-3">
            <div class="col-md-6">
                <button onclick="showBulkAssignModal()" class="btn btn-primary w-100">
                    <i class="fas fa-users-plus me-2"></i>
                    إضافة متعددة للطلاب
                </button>
            </div>
            
            <div class="col-md-6">
                <button onclick="autoAssignStudents()" class="btn btn-info w-100">
                    <i class="fas fa-magic me-2"></i>
                    تخصيص تلقائي ({{ min($availableSeats, $availableStudents->count()) }} طلاب)
                </button>
            </div>
        </div>
        
        <div class="row g-3 mt-2">
            <div class="col-md-6">
                <a href="{{ route('admin.students.index', [
        'center_id' => $bus->center?->id,
        'status' => 'approved',
        'bus' => 'null'
    ]) }}"
   class="btn btn-outline-light w-100">
                    <i class="fas fa-external-link-alt me-2"></i>
                    عرض جميع الطلاب المتاحين
                </a>
            </div>
             
            <div class="col-md-6">
                <button onclick="exportStudentsList()" class="btn btn-outline-secondary w-100">
                    <i class="fas fa-download me-2"></i>
                    تصدير قائمة الطلاب
                </button>
            </div>
        </div>
    </div>
@endif

<!-- Modal للإضافة المتعددة -->
<div class="modal fade" id="bulkAssignModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-light">
                    <i class="fas fa-users-plus me-2"></i>
                    إضافة طلاب متعددين للباص
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i>
                    المقاعد المتاحة: <strong>{{ $availableSeats }}</strong> من أصل {{ $capacity }}
                </div>
                
                <div class="mb-3">
                    <input type="text" id="bulkSearchInput" class="form-control" 
                           placeholder="البحث في الطلاب...">
                </div>
                
                <div class="row" id="bulkStudentsList">
                    @foreach($availableStudents->take(20) as $student)
                        <div class="col-md-6 mb-2">
                            <div class="form-check">
                                <input class="form-check-input bulk-student-checkbox" 
                                       type="checkbox" 
                                       value="{{ $student->id }}" 
                                       id="bulkStudent{{ $student->id }}">
                                <label class="form-check-label text-light" for="bulkStudent{{ $student->id }}">
                                    {{ $student->name ?? 'غير محدد' }}
                                    @if($student->student_id)
                                        <small class="text-muted">({{ $student->student_id }})</small>
                                    @endif
                                </label>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                @if($availableStudents->count() > 20)
                    <div class="text-center mt-3">
                        <small class="text-muted">
                            عرض أول 20 طالب. استخدم البحث للعثور على طلاب محددين.
                        </small>
                    </div>
                @endif
            </div>
            <div class="modal-footer">
                <div class="d-flex justify-content-between w-100">
                    <div>
                        <button type="button" class="btn btn-outline-light" onclick="selectAllVisible()">
                            تحديد الكل
                        </button>
                        <button type="button" class="btn btn-outline-secondary" onclick="clearSelection()">
                            مسح التحديد
                        </button>
                    </div>
                    <div>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                        <button type="button" onclick="assignSelectedStudents()" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i>
                            إضافة المحددين
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
.student-card {
    transition: all 0.3s ease;
    background: rgba(255, 255, 255, 0.05);
}

.student-card:hover {
    background: rgba(255, 255, 255, 0.1);
    transform: translateY(-2px);
}

.border-success {
    border-color: rgba(25, 135, 84, 0.5) !important;
}

.border-success.border-opacity-25:hover {
    border-color: rgba(25, 135, 84, 0.8) !important;
}

#currentStudentsList::-webkit-scrollbar,
#availableStudentsList::-webkit-scrollbar {
    width: 6px;
}

#currentStudentsList::-webkit-scrollbar-track,
#availableStudentsList::-webkit-scrollbar-track {
    background: rgba(255, 255, 255, 0.1);
    border-radius: 3px;
}

#currentStudentsList::-webkit-scrollbar-thumb,
#availableStudentsList::-webkit-scrollbar-thumb {
    background: rgba(127, 176, 105, 0.5);
    border-radius: 3px;
}

#currentStudentsList::-webkit-scrollbar-thumb:hover,
#availableStudentsList::-webkit-scrollbar-thumb:hover {
    background: rgba(127, 176, 105, 0.8);
}
</style>
@endsection

@section('scripts')
<script>
// البحث في الطلاب الحاليين
document.getElementById('currentStudentsSearch')?.addEventListener('input', function(e) {
    filterStudents('currentStudentsList', e.target.value);
});

// البحث في الطلاب المتاحين
document.getElementById('availableStudentsSearch')?.addEventListener('input', function(e) {
    filterStudents('availableStudentsList', e.target.value);
});

// البحث في modal الإضافة المتعددة
document.getElementById('bulkSearchInput')?.addEventListener('input', function(e) {
    filterBulkStudents(e.target.value);
});

// فلترة الطلاب
function filterStudents(listId, searchTerm) {
    const list = document.getElementById(listId);
    if (!list) return;
    
    const students = list.querySelectorAll('.student-card');
    const term = searchTerm.toLowerCase();

    students.forEach(student => {
        const name = student.dataset.studentName || '';
        const id = student.dataset.studentId || '';
        
        if (name.includes(term) || id.includes(term)) {
            student.style.display = '';
        } else {
            student.style.display = 'none';
        }
    });
}

// فلترة طلاب الإضافة المتعددة
function filterBulkStudents(searchTerm) {
    const checkboxes = document.querySelectorAll('.bulk-student-checkbox');
    const term = searchTerm.toLowerCase();

    checkboxes.forEach(checkbox => {
        const label = checkbox.nextElementSibling;
        const text = label.textContent.toLowerCase();
        const container = checkbox.closest('.col-md-6');
        
        if (text.includes(term)) {
            container.style.display = '';
        } else {
            container.style.display = 'none';
        }
    });
}

// إضافة طالب للباص
function addStudentToBus(studentId) {
    if (!confirm('هل تريد إضافة هذا الطالب للباص؟')) return;

    // التحقق من توفر مقاعد
    const availableSeats = {{ $availableSeats }};
    if (availableSeats <= 0) {
        alert('الباص ممتلئ - لا توجد مقاعد متاحة');
        return;
    }

    fetch(`/admin/buses/{{ $bus->id }}/add-student`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        },
        body: JSON.stringify({ student_id: studentId })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showAlert('success', 'تم إضافة الطالب للباص بنجاح');
            setTimeout(() => location.reload(), 1500);
        } else {
            showAlert('error', 'خطأ: ' + (data.message || 'فشل في إضافة الطالب'));
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showAlert('error', 'حدث خطأ في الاتصال');
    });
}

// إزالة طالب من الباص
function removeStudentFromBus(studentId) {
    if (!confirm('هل تريد إزالة هذا الطالب من الباص؟')) return;

    fetch(`/admin/buses/{{ $bus->id }}/remove-student/${studentId}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showAlert('success', 'تم إزالة الطالب من الباص بنجاح');
            setTimeout(() => location.reload(), 1500);
        } else {
            showAlert('error', 'خطأ: ' + (data.message || 'فشل في إزالة الطالب'));
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showAlert('error', 'حدث خطأ في الاتصال');
    });
}

// إظهار modal الإضافة المتعددة
function showBulkAssignModal() {
    const modal = new bootstrap.Modal(document.getElementById('bulkAssignModal'));
    modal.show();
}

// تحديد جميع الطلاب المرئيين
function selectAllVisible() {
    const checkboxes = document.querySelectorAll('.bulk-student-checkbox');
    checkboxes.forEach(checkbox => {
        const container = checkbox.closest('.col-md-6');
        if (container.style.display !== 'none') {
            checkbox.checked = true;
        }
    });
}

// مسح التحديد
function clearSelection() {
    const checkboxes = document.querySelectorAll('.bulk-student-checkbox');
    checkboxes.forEach(checkbox => {
        checkbox.checked = false;
    });
}

// إضافة الطلاب المحددين
function assignSelectedStudents() {
    const checkboxes = document.querySelectorAll('.bulk-student-checkbox:checked');
    const studentIds = Array.from(checkboxes).map(cb => cb.value);

    if (studentIds.length === 0) {
        alert('يرجى تحديد طالب واحد على الأقل');
        return;
    }

    const availableSeats = {{ $availableSeats }};
    if (studentIds.length > availableSeats) {
        alert(`لا يمكن إضافة ${studentIds.length} طلاب. المقاعد المتاحة: ${availableSeats}`);
        return;
    }

    if (!confirm(`هل تريد إضافة ${studentIds.length} طلاب للباص؟`)) return;

    // إضافة الطلاب واحد تلو الآخر
    let completed = 0;
    let errors = 0;
    const total = studentIds.length;

    studentIds.forEach(studentId => {
        fetch(`/admin/buses/{{ $bus->id }}/add-student`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify({ student_id: studentId })
        })
        .then(response => response.json())
        .then(data => {
            completed++;
            if (!data.success) errors++;
            
            if (completed === total) {
                const successCount = completed - errors;
                if (errors === 0) {
                    showAlert('success', `تم إضافة جميع الطلاب بنجاح (${successCount})`);
                } else {
                    showAlert('warning', `تم إضافة ${successCount} من ${total} طلاب. حدث ${errors} خطأ.`);
                }
                
                // إغلاق الـ modal وإعادة تحميل الصفحة
                bootstrap.Modal.getInstance(document.getElementById('bulkAssignModal')).hide();
                setTimeout(() => location.reload(), 2000);
            }
        })
        .catch(error => {
            completed++;
            errors++;
            console.error('Error:', error);
            
            if (completed === total) {
                const successCount = completed - errors;
                showAlert('error', `تم إضافة ${successCount} من ${total} طلاب. حدث ${errors} خطأ.`);
                setTimeout(() => location.reload(), 2000);
            }
        });
    });
}

// التخصيص التلقائي
function autoAssignStudents() {
    const availableSeats = {{ $availableSeats }};
    const availableStudentsCount = {{ $availableStudents->count() }};
    const assignCount = Math.min(availableSeats, availableStudentsCount);

    if (assignCount === 0) {
        alert('لا توجد مقاعد متاحة أو طلاب للتخصيص');
        return;
    }

    if (!confirm(`هل تريد التخصيص التلقائي لأول ${assignCount} طلاب متاحين؟`)) return;

    // جلب أول عدد من الطلاب المتاحين
    const availableStudents = @json($availableStudents->pluck('id')->toArray());
    const studentsToAssign = availableStudents.slice(0, assignCount);

    assignBulkStudents(studentsToAssign);
}

// إضافة مجموعة من الطلاب
function assignBulkStudents(studentIds) {
    let completed = 0;
    let errors = 0;
    const total = studentIds.length;

    studentIds.forEach(studentId => {
        fetch(`/admin/buses/{{ $bus->id }}/add-student`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify({ student_id: studentId })
        })
        .then(response => response.json())
        .then(data => {
            completed++;
            if (!data.success) errors++;
            
            if (completed === total) {
                const successCount = completed - errors;
                if (errors === 0) {
                    showAlert('success', `تم التخصيص التلقائي بنجاح (${successCount} طلاب)`);
                } else {
                    showAlert('warning', `تم تخصيص ${successCount} من ${total} طلاب. حدث ${errors} خطأ.`);
                }
                setTimeout(() => location.reload(), 2000);
            }
        })
        .catch(error => {
            completed++;
            errors++;
            console.error('Error:', error);
            
            if (completed === total) {
                const successCount = completed - errors;
                showAlert('error', `تم تخصيص ${successCount} من ${total} طلاب. حدث ${errors} خطأ.`);
                setTimeout(() => location.reload(), 2000);
            }
        });
    });
}

// تصدير قائمة الطلاب
function exportStudentsList() {
    // إنشاء CSV للطلاب الحاليين
    const students = @json($bus->students ?? []);
    
    if (students.length === 0) {
        alert('لا توجد طلاب لتصديرها');
        return;
    }

    let csvContent = "الاسم,رقم الطالب,الجوال,نقطة الالتقاء,وقت الالتقاء\n";
    
    students.forEach(student => {
        csvContent += `"${student.name || ''}","${student.student_id || ''}","${student.mobile || ''}","${student.pickup_point || ''}","${student.pickup_time || ''}"\n`;
    });

    // إنشاء وتحميل الملف
    const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
    const link = document.createElement('a');
    const url = URL.createObjectURL(blob);
    link.setAttribute('href', url);
    link.setAttribute('download', `طلاب_الباص_{{ $bus->number }}_${new Date().toLocaleDateString('ar-SA')}.csv`);
    link.style.visibility = 'hidden';
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
}

// دالة إظهار التنبيهات
function showAlert(type, message) {
    const alertClass = {
        'success': 'alert-success',
        'error': 'alert-danger', 
        'warning': 'alert-warning',
        'info': 'alert-info'
    };

    const alertDiv = document.createElement('div');
    alertDiv.className = `alert ${alertClass[type]} alert-dismissible fade show position-fixed`;
    alertDiv.style.cssText = 'top: 20px; left: 20px; right: 20px; z-index: 9999;';
    alertDiv.innerHTML = `
        <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'error' ? 'exclamation-triangle' : 'info-circle'} me-2"></i>
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    
    document.body.appendChild(alertDiv);
    
    setTimeout(() => {
        if (alertDiv.parentNode) {
            alertDiv.remove();
        }
    }, 5000);
}

// تهيئة الصفحة
document.addEventListener('DOMContentLoaded', function() {
    // تحديث عداد المحددين في modal
    const checkboxes = document.querySelectorAll('.bulk-student-checkbox');
    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const checkedCount = document.querySelectorAll('.bulk-student-checkbox:checked').length;
            const availableSeats = {{ $availableSeats }};
            
            if (checkedCount > availableSeats) {
                this.checked = false;
                alert(`لا يمكن تحديد أكثر من ${availableSeats} طلاب`);
            }
        });
    });
});
</script>
@endsection