<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تفاصيل الدفعة #{{ $payment->id }} - جمعية القرآن</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: linear-gradient(135deg, #1a4b3a 0%, #2d6b4f 25%, #1a4b3a 50%, #0f2e1e 75%, #1a4b3a 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #ffffff;
        }

        .sidebar {
            background: rgba(0, 0, 0, 0.3);
            backdrop-filter: blur(20px);
            border-left: 2px solid rgba(127, 176, 105, 0.3);
            height: 100vh;
            position: fixed;
            right: 0;
            top: 0;
            width: 280px;
            z-index: 1000;
            overflow-y: auto;
        }

        .main-content {
            margin-right: 280px;
            padding: 2rem;
        }

        .content-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            padding: 2rem;
            margin-bottom: 2rem;
            border: 1px solid rgba(127, 176, 105, 0.2);
        }

        .info-section {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 15px;
            padding: 1.5rem;
            margin-bottom: 2rem;
        }

        .section-title {
            color: #7fb069;
            font-weight: bold;
            margin-bottom: 1rem;
            border-bottom: 2px solid rgba(127, 176, 105, 0.3);
            padding-bottom: 0.5rem;
        }

        .info-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.75rem 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .info-item:last-child {
            border-bottom: none;
        }

        .info-label {
            font-weight: bold;
            color: rgba(255, 255, 255, 0.8);
            min-width: 150px;
        }

        .info-value {
            color: #ffffff;
            text-align: left;
            flex: 1;
        }

        .status-badge {
            padding: 0.5rem 1.2rem;
            border-radius: 10px;
            font-size: 1rem;
            font-weight: bold;
        }

        .status-pending {
            background: rgba(255, 193, 7, 0.2);
            color: #ffc107;
            border: 1px solid rgba(255, 193, 7, 0.5);
        }

        .status-approved {
            background: rgba(40, 167, 69, 0.2);
            color: #28a745;
            border: 1px solid rgba(40, 167, 69, 0.5);
        }

        .status-rejected {
            background: rgba(220, 53, 69, 0.2);
            color: #dc3545;
            border: 1px solid rgba(220, 53, 69, 0.5);
        }

        .amount-highlight {
            font-size: 2.5rem;
            font-weight: bold;
            color: #7fb069;
            text-shadow: 0 0 10px rgba(127, 176, 105, 0.3);
            text-align: center;
            margin: 1rem 0;
        }

        .btn-primary {
            background: linear-gradient(45deg, #7fb069, #9bc284);
            border: none;
            border-radius: 10px;
            padding: 0.7rem 1.5rem;
            font-weight: bold;
            transition: all 0.3s ease;
        }

        .btn-secondary {
            background: rgba(108, 117, 125, 0.8);
            border: none;
            border-radius: 10px;
            padding: 0.7rem 1.5rem;
            transition: all 0.3s ease;
        }

        .btn-success {
            background: rgba(40, 167, 69, 0.8);
            border: none;
            border-radius: 10px;
            padding: 0.7rem 1.5rem;
            transition: all 0.3s ease;
        }

        .btn-danger {
            background: rgba(220, 53, 69, 0.8);
            border: none;
            border-radius: 10px;
            padding: 0.7rem 1.5rem;
            transition: all 0.3s ease;
        }

        .receipt-preview {
            background: rgba(255, 255, 255, 0.05);
            border: 2px dashed rgba(127, 176, 105, 0.3);
            border-radius: 10px;
            padding: 2rem;
            text-align: center;
            min-height: 200px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .receipt-image {
            max-width: 100%;
            max-height: 300px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
        }

        .empty-state {
            text-align: center;
            padding: 3rem;
            color: rgba(255, 255, 255, 0.7);
        }

        .notes-section {
            background: rgba(255, 255, 255, 0.03);
            border-radius: 10px;
            padding: 1rem;
            border-left: 4px solid #7fb069;
        }

        .rejection-reason {
            background: rgba(220, 53, 69, 0.1);
            border: 1px solid rgba(220, 53, 69, 0.3);
            border-radius: 10px;
            padding: 1rem;
            color: #ff6b7a;
        }

        .action-buttons {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 15px;
            padding: 1.5rem;
            text-align: center;
        }

        .search-input {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(127, 176, 105, 0.3);
            border-radius: 10px;
            color: #ffffff;
        }

        .search-input:focus {
            background: rgba(255, 255, 255, 0.15);
            border-color: #7fb069;
            color: #ffffff;
            box-shadow: 0 0 0 0.2rem rgba(127, 176, 105, 0.25);
        }

        .search-input::placeholder {
            color: rgba(255, 255, 255, 0.7);
        }

        @media (max-width: 768px) {
            .sidebar {
                display: none;
            }
            .main-content {
                margin-right: 0;
                padding: 1rem;
            }
            .amount-highlight {
                font-size: 2rem;
            }
        }
    </style>
</head>
<body>
    <!-- الشريط الجانبي -->
    <div class="sidebar">
        <div style="padding: 2rem 1.5rem; border-bottom: 1px solid rgba(127, 176, 105, 0.2); text-align: center;">
            <div style="font-size: 1.3rem; font-weight: bold; color: #7fb069;">
                <i class="fas fa-mosque"></i>
                لوحة الإدارة
            </div>
        </div>

        <nav style="padding: 1rem 0;">
            <a href="{{ route('admin.dashboard') }}" style="display: block; padding: 1rem 1.5rem; color: #e8f5e8; text-decoration: none; transition: all 0.3s ease; border-bottom: 1px solid rgba(255, 255, 255, 0.1);">
                <i class="fas fa-tachometer-alt" style="width: 20px; margin-left: 10px;"></i>
                الرئيسية
            </a>
            <a href="{{ route('admin.students.index') }}" style="display: block; padding: 1rem 1.5rem; color: #e8f5e8; text-decoration: none; transition: all 0.3s ease; border-bottom: 1px solid rgba(255, 255, 255, 0.1);">
                <i class="fas fa-users" style="width: 20px; margin-left: 10px;"></i>
                إدارة الطلاب
            </a>
            <a href="{{ route('admin.buses.index') }}" style="display: block; padding: 1rem 1.5rem; color: #e8f5e8; text-decoration: none; transition: all 0.3s ease; border-bottom: 1px solid rgba(255, 255, 255, 0.1);">
                <i class="fas fa-bus" style="width: 20px; margin-left: 10px;"></i>
                إدارة الباصات
            </a>
            <a href="{{ route('admin.drivers.index') }}" style="display: block; padding: 1rem 1.5rem; color: #e8f5e8; text-decoration: none; transition: all 0.3s ease; border-bottom: 1px solid rgba(255, 255, 255, 0.1);">
                <i class="fas fa-id-card" style="width: 20px; margin-left: 10px;"></i>
                إدارة السائقين
            </a>
            <a href="{{ route('admin.payments.index') }}" style="display: block; padding: 1rem 1.5rem; color: #ffffff; text-decoration: none; transition: all 0.3s ease; border-bottom: 1px solid rgba(255, 255, 255, 0.1); background: rgba(127, 176, 105, 0.3); border-right: 4px solid #7fb069;">
                <i class="fas fa-credit-card" style="width: 20px; margin-left: 10px;"></i>
                إدارة المدفوعات
            </a>
            <a href="{{ route('admin.centers.index') }}" style="display: block; padding: 1rem 1.5rem; color: #e8f5e8; text-decoration: none; transition: all 0.3s ease; border-bottom: 1px solid rgba(255, 255, 255, 0.1);">
                <i class="fas fa-school" style="width: 20px; margin-left: 10px;"></i>
                إدارة المراكز
            </a>
        </nav>
    </div>

    <!-- المحتوى الرئيسي -->
    <div class="main-content">
        <!-- رأس الصفحة -->
        <div class="content-card">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2>
                        <i class="fas fa-receipt text-primary"></i>
                        تفاصيل الدفعة #{{ $payment->id ?? '001' }}
                    </h2>
                    <p class="mb-0 text-light">عرض تفصيلي للدفعة والمعلومات ذات الصلة</p>
                </div>
                <div>
                    <a href="{{ route('admin.payments.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-right"></i>
                        العودة للقائمة
                    </a>
                </div>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle"></i>
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <!-- معلومات الدفعة الأساسية -->
            <div class="row">
                <div class="col-md-8">
                    <div class="info-section">
                        <h4 class="section-title">
                            <i class="fas fa-info-circle"></i>
                            معلومات الدفعة
                        </h4>
                        
                        <div class="info-item">
                            <span class="info-label">رقم الدفعة:</span>
                            <span class="info-value"><strong>#{{ $payment->id ?? '001' }}</strong></span>
                        </div>

                        @if(isset($payment->reference_number) && $payment->reference_number)
                        <div class="info-item">
                            <span class="info-label">رقم المرجع:</span>
                            <span class="info-value">{{ $payment->reference_number }}</span>
                        </div>
                        @endif

                        <div class="info-item">
                            <span class="info-label">المبلغ:</span>
                            <span class="info-value">
                                <div class="amount-highlight">{{ number_format($payment->amount ?? 500, 2) }} ريال</div>
                            </span>
                        </div>

                        <div class="info-item">
                            <span class="info-label">طريقة الدفع:</span>
                            <span class="info-value">
                                @if(($payment->payment_method ?? 'cash') == 'cash')
                                    <span class="badge bg-success"><i class="fas fa-money-bill"></i> نقداً</span>
                                @elseif($payment->payment_method == 'bank_transfer')
                                    <span class="badge bg-info"><i class="fas fa-university"></i> حوالة بنكية</span>
                                @elseif($payment->payment_method == 'online')
                                    <span class="badge bg-primary"><i class="fas fa-credit-card"></i> دفع إلكتروني</span>
                                @else
                                    <span class="badge bg-secondary">{{ $payment->payment_method ?? 'غير محدد' }}</span>
                                @endif
                            </span>
                        </div>

                        <div class="info-item">
                            <span class="info-label">تاريخ الدفع:</span>
                            <span class="info-value">{{ isset($payment->payment_date) ? $payment->payment_date->format('Y-m-d H:i') : date('Y-m-d H:i') }}</span>
                        </div>

                        <div class="info-item">
                            <span class="info-label">تاريخ الإنشاء:</span>
                            <span class="info-value">{{ isset($payment->created_at) ? $payment->created_at->format('Y-m-d H:i') : date('Y-m-d H:i') }}</span>
                        </div>

                        <div class="info-item">
                            <span class="info-label">آخر تحديث:</span>
                            <span class="info-value">{{ isset($payment->updated_at) ? $payment->updated_at->format('Y-m-d H:i') : date('Y-m-d H:i') }}</span>
                        </div>
                    </div>

                    <!-- معلومات الطالب -->
                    <div class="info-section">
                        <h4 class="section-title">
                            <i class="fas fa-user-graduate"></i>
                            معلومات الطالب
                        </h4>
                        
                        <div class="info-item">
                            <span class="info-label">اسم الطالب:</span>
                            <span class="info-value"><strong>{{ $payment->student->name ?? 'أحمد محمد علي' }}</strong></span>
                        </div>

                        @if(isset($payment->student->student_id) && $payment->student->student_id)
                        <div class="info-item">
                            <span class="info-label">رقم الطالب:</span>
                            <span class="info-value">{{ $payment->student->student_id }}</span>
                        </div>
                        @endif

                        <div class="info-item">
                            <span class="info-label">رقم الهاتف:</span>
                            <span class="info-value">{{ $payment->student->phone ?? '05XXXXXXXX' }}</span>
                        </div>

                        <div class="info-item">
                            <span class="info-label">البريد الإلكتروني:</span>
                            <span class="info-value">{{ $payment->student->email ?? 'student@example.com' }}</span>
                        </div>

                        @if(isset($payment->student->center) && $payment->student->center)
                        <div class="info-item">
                            <span class="info-label">المركز:</span>
                            <span class="info-value">{{ $payment->student->center->name ?? 'المركز الرئيسي' }}</span>
                        </div>
                        @endif
                    </div>

                    @if(isset($payment->notes) && $payment->notes)
                    <!-- ملاحظات إضافية -->
                    <div class="info-section">
                        <h4 class="section-title">
                            <i class="fas fa-sticky-note"></i>
                            ملاحظات
                        </h4>
                        <div class="notes-section">
                            <p class="mb-0">{{ $payment->notes }}</p>
                        </div>
                    </div>
                    @endif

                    @if(isset($payment->rejection_reason) && $payment->rejection_reason)
                    <!-- سبب الرفض -->
                    <div class="info-section">
                        <h4 class="section-title text-danger">
                            <i class="fas fa-exclamation-triangle"></i>
                            سبب الرفض
                        </h4>
                        <div class="rejection-reason">
                            <p class="mb-0">{{ $payment->rejection_reason }}</p>
                        </div>
                    </div>
                    @endif
                </div>

                <div class="col-md-4">
                    <!-- حالة الدفعة -->
                    <div class="info-section text-center">
                        <h4 class="section-title">
                            <i class="fas fa-flag"></i>
                            حالة الدفعة
                        </h4>
                        @if(($payment->status ?? 'pending') == 'pending')
                            <span class="status-badge status-pending">
                                <i class="fas fa-clock"></i>
                                قيد المراجعة
                            </span>
                        @elseif($payment->status == 'approved')
                            <span class="status-badge status-approved">
                                <i class="fas fa-check-circle"></i>
                                موافق عليها
                            </span>
                        @elseif($payment->status == 'rejected')
                            <span class="status-badge status-rejected">
                                <i class="fas fa-times-circle"></i>
                                مرفوضة
                            </span>
                        @endif
                    </div>

                    <!-- إيصال الدفع -->
                    <div class="info-section">
                        <h4 class="section-title">
                            <i class="fas fa-file-image"></i>
                            إيصال الدفع
                        </h4>
                        
                        @if(isset($payment->receipt_image) && $payment->receipt_image)
                            <div class="receipt-preview">
                                <img src="{{ Storage::url($payment->receipt_image) }}" alt="إيصال الدفع" class="receipt-image">
                                <div class="mt-2">
                                    <a href="{{ Storage::url($payment->receipt_image) }}" target="_blank" class="btn btn-sm btn-primary">
                                        <i class="fas fa-external-link-alt"></i>
                                        عرض بحجم أكبر
                                    </a>
                                </div>
                            </div>
                        @else
                            <div class="receipt-preview">
                                <div class="empty-state">
                                    <i class="fas fa-image fa-3x text-muted mb-3"></i>
                                    <h5 class="text-muted">لا يوجد إيصال</h5>
                                    <p class="text-muted mb-0">لم يتم رفع إيصال لهذه الدفعة</p>
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- الإجراءات -->
                    @if(($payment->status ?? 'pending') == 'pending')
                    <div class="action-buttons">
                        <h4 class="section-title">
                            <i class="fas fa-tools"></i>
                            الإجراءات المتاحة
                        </h4>
                        
                        <div class="d-grid gap-2">
                            <button onclick="approvePayment({{ $payment->id ?? 1 }})" class="btn btn-success">
                                <i class="fas fa-check"></i>
                                الموافقة على الدفعة
                            </button>
                            
                            <button onclick="rejectPayment({{ $payment->id ?? 1 }})" class="btn btn-danger">
                                <i class="fas fa-times"></i>
                                رفض الدفعة
                            </button>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Modal لرفض الدفعة -->
    <div class="modal fade" id="rejectModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content" style="background: rgba(26, 75, 58, 0.95); backdrop-filter: blur(20px); border: 1px solid rgba(127, 176, 105, 0.3);">
                <div class="modal-header">
                    <h5 class="modal-title text-light">
                        <i class="fas fa-times-circle"></i>
                        رفض الدفعة
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="rejection_reason" class="form-label text-light">سبب الرفض</label>
                        <textarea class="form-control search-input" id="rejection_reason" rows="4" 
                                  placeholder="اذكر سبب رفض هذه الدفعة بالتفصيل..." required></textarea>
                    </div>
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle"></i>
                        <strong>تنبيه:</strong> سيتم إشعار الطالب برفض الدفعة مع السبب المذكور
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                    <button type="button" onclick="confirmRejectPayment()" class="btn btn-danger">
                        <i class="fas fa-times"></i>
                        تأكيد الرفض
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal للموافقة على الدفعة -->
    <div class="modal fade" id="approveModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content" style="background: rgba(26, 75, 58, 0.95); backdrop-filter: blur(20px); border: 1px solid rgba(127, 176, 105, 0.3);">
                <div class="modal-header">
                    <h5 class="modal-title text-light">
                        <i class="fas fa-check-circle"></i>
                        الموافقة على الدفعة
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i>
                        هل أنت متأكد من الموافقة على هذه الدفعة؟
                    </div>
                    <div class="text-center">
                        <h4>المبلغ: <span class="text-success">{{ number_format($payment->amount ?? 500, 2) }} ريال</span></h4>
                        <p>الطالب: <strong>{{ $payment->student->name ?? 'أحمد محمد علي' }}</strong></p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                    <button type="button" onclick="confirmApprovePayment()" class="btn btn-success">
                        <i class="fas fa-check"></i>
                        تأكيد الموافقة
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        let currentPaymentId = {{ $payment->id ?? 1 }};

        function approvePayment(paymentId) {
            currentPaymentId = paymentId;
            const modal = new bootstrap.Modal(document.getElementById('approveModal'));
            modal.show();
        }

        function confirmApprovePayment() {
            fetch(`/admin/payments/${currentPaymentId}/approve`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const modal = bootstrap.Modal.getInstance(document.getElementById('approveModal'));
                    modal.hide();
                    
                    showAlert('تم الموافقة على الدفعة بنجاح', 'success');
                    
                    setTimeout(() => {
                        location.reload();
                    }, 2000);
                } else {
                    showAlert('خطأ: ' + (data.message || 'فشل في الموافقة على الدفعة'), 'danger');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showAlert('حدث خطأ في الاتصال', 'danger');
            });
        }

        function showAlert(message, type) {
            // إنشاء تنبيه ديناميكي
            const alertDiv = document.createElement('div');
            alertDiv.className = `alert alert-${type} alert-dismissible fade show`;
            alertDiv.style.position = 'fixed';
            alertDiv.style.top = '20px';
            alertDiv.style.right = '20px';
            alertDiv.style.zIndex = '9999';
            alertDiv.style.minWidth = '300px';
            
            let iconClass = 'fas fa-info-circle';
            if (type === 'success') iconClass = 'fas fa-check-circle';
            else if (type === 'danger') iconClass = 'fas fa-exclamation-circle';
            else if (type === 'warning') iconClass = 'fas fa-exclamation-triangle';
            
            alertDiv.innerHTML = `
                <i class="${iconClass}"></i>
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            `;
            
            document.body.appendChild(alertDiv);
            
            // إزالة التنبيه تلقائياً بعد 5 ثوانٍ
            setTimeout(() => {
                if (alertDiv.parentNode) {
                    alertDiv.remove();
                }
            }, 5000);
        }

        // تحسين عرض الصور
        document.addEventListener('DOMContentLoaded', function() {
            const receiptImage = document.querySelector('.receipt-image');
            if (receiptImage) {
                receiptImage.addEventListener('click', function() {
                    window.open(this.src, '_blank');
                });
                
                receiptImage.style.cursor = 'pointer';
                receiptImage.title = 'اضغط لعرض الصورة بحجم أكبر';
            }
        });

        // تحسين إمكانية الوصول
        document.addEventListener('keydown', function(event) {
            // ESC لإغلاق النوافذ المنبثقة
            if (event.key === 'Escape') {
                const modals = document.querySelectorAll('.modal.show');
                modals.forEach(modal => {
                    const bsModal = bootstrap.Modal.getInstance(modal);
                    if (bsModal) {
                        bsModal.hide();
                    }
                });
            }
        });
    </script>
</body>
</html>