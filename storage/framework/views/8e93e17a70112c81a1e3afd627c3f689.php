<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ملفي الشخصي - <?php echo e($student->name); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <style>
        :root {
            --primary-dark: #1a4b3a;
            --primary: #2d6b4f;
            --accent: #7fb069;
        }

        body {
            background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary) 50%, var(--primary-dark) 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, sans-serif;
            padding: 2rem 0;
            color: #fff;
        }

        .profile-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(15px);
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            overflow: hidden;
        }

        .profile-header {
            background: rgba(0, 0, 0, 0.2);
            padding: 2.5rem 2rem;
            text-align: center;
        }

        .profile-avatar {
            width: 100px;
            height: 100px;
            background: linear-gradient(45deg, var(--accent), #90c695);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            font-size: 2.5rem;
            color: var(--primary-dark);
            box-shadow: 0 10px 30px rgba(127, 176, 105, 0.3);
        }

        .profile-header h2 { color: #fff; margin-bottom: 0.5rem; font-weight: bold; }
        .profile-header .student-id { color: var(--accent); font-size: 0.95rem; }

        .status-badge {
            display: inline-block;
            padding: 0.5rem 1.2rem;
            border-radius: 25px;
            font-weight: 600;
            font-size: 0.9rem;
            margin-top: 1rem;
        }

        .status-pending { background: rgba(255, 193, 7, 0.2); color: #ffc107; border: 1px solid rgba(255, 193, 7, 0.4); }
        .status-approved { background: rgba(40, 167, 69, 0.2); color: #90EE90; border: 1px solid rgba(40, 167, 69, 0.4); }
        .status-rejected { background: rgba(220, 53, 69, 0.2); color: #ffb3b3; border: 1px solid rgba(220, 53, 69, 0.4); }

        .profile-body { padding: 2rem; }

        .info-card {
            background: rgba(255, 255, 255, 0.08);
            border-radius: 15px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            border: 1px solid rgba(127, 176, 105, 0.2);
            height: 100%;
        }

        .info-card h5 {
            color: var(--accent);
            margin-bottom: 1rem;
            font-weight: bold;
            padding-bottom: 0.75rem;
            border-bottom: 2px solid rgba(127, 176, 105, 0.3);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .info-item {
            display: flex;
            justify-content: space-between;
            padding: 0.6rem 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .info-item:last-child { border-bottom: none; }
        .info-label { color: rgba(255, 255, 255, 0.7); font-weight: 500; }
        .info-value { color: #fff; font-weight: 500; }
        .info-value a { color: var(--accent); text-decoration: none; }

        /* Payment Section */
        .payment-summary {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1rem;
            margin-bottom: 1rem;
        }

        .payment-box {
            text-align: center;
            padding: 1rem;
            border-radius: 12px;
            background: rgba(0, 0, 0, 0.2);
        }

        .payment-box .amount {
            font-size: 1.5rem;
            font-weight: bold;
            display: block;
        }

        .payment-box .label { font-size: 0.85rem; color: rgba(255,255,255,0.7); }
        .payment-box.total .amount { color: #17a2b8; }
        .payment-box.paid .amount { color: #28a745; }
        .payment-box.remaining .amount { color: #ffc107; }

        .pending-payments {
            background: rgba(255, 193, 7, 0.15);
            border: 1px solid rgba(255, 193, 7, 0.3);
            border-radius: 10px;
            padding: 1rem;
            text-align: center;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.75rem;
        }

        .pending-payments .count {
            background: #ffc107;
            color: #333;
            width: 35px;
            height: 35px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
        }

        /* Bus Info */
        .bus-info {
            background: rgba(0, 0, 0, 0.2);
            border-radius: 15px;
            padding: 1.5rem;
            text-align: center;
            margin-bottom: 1rem;
        }

        .bus-icon {
            width: 60px;
            height: 60px;
            background: linear-gradient(45deg, #17a2b8, #20c997);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 0.5rem;
            font-size: 1.5rem;
            color: white;
        }

        .bus-number { font-size: 1.5rem; font-weight: bold; color: #17a2b8; }

        /* Map */
        #studentMap {
            height: 200px;
            border-radius: 12px;
            margin-bottom: 1rem;
        }

        /* Buttons */
        .btn-payments {
            background: linear-gradient(45deg, #17a2b8, #20c997);
            border: none;
            color: white;
            padding: 0.8rem 1.5rem;
            border-radius: 10px;
            font-weight: 600;
            transition: all 0.3s;
        }

        .btn-payments:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(23, 162, 184, 0.4);
            color: white;
        }

        .btn-home {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.3);
            color: white;
            padding: 0.8rem 1.5rem;
            border-radius: 10px;
            font-weight: 600;
            transition: all 0.3s;
        }

        .btn-home:hover { background: rgba(255, 255, 255, 0.2); color: white; }

        .btn-logout {
            background: linear-gradient(45deg, #dc3545, #e74c3c);
            border: none;
            color: white;
            padding: 0.8rem 1.5rem;
            border-radius: 10px;
            font-weight: 600;
            transition: all 0.3s;
        }

        .btn-logout:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(220, 53, 69, 0.4);
        }

        .contact-info {
            text-align: center;
            margin-top: 2rem;
            color: rgba(255,255,255,0.6);
        }

        .contact-info a { color: var(--accent); text-decoration: none; }

        .alert-custom {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: #fff;
            border-radius: 10px;
        }

        .alert-custom.alert-info { border-color: rgba(23, 162, 184, 0.4); }
        .alert-custom.alert-warning { border-color: rgba(255, 193, 7, 0.4); }

        @media (max-width: 768px) {
            .payment-summary { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="profile-card">
                    <div class="profile-header">
                        <div class="profile-avatar">
                            <i class="fas fa-<?php echo e($student->gender == 'ذكر' ? 'male' : 'female'); ?>"></i>
                        </div>
                        <h2><?php echo e($student->name); ?></h2>
                        <div class="student-id">
                            <i class="fas fa-id-card me-1"></i>
                            <?php echo e($student->student_id); ?>

                        </div>
                        
                        <?php
                            $statusClass = [
                                'pending' => 'pending',
                                'approved' => 'approved',
                                'rejected' => 'rejected',
                                'suspended' => 'rejected'
                            ][$student->status] ?? 'pending';
                            
                            $statusText = [
                                'pending' => 'قيد المراجعة',
                                'approved' => 'مقبول',
                                'rejected' => 'مرفوض',
                                'suspended' => 'موقوف'
                            ][$student->status] ?? $student->status;
                        ?>
                        
                        <div class="status-badge status-<?php echo e($statusClass); ?>">
                            <i class="fas fa-<?php echo e($statusClass == 'approved' ? 'check-circle' : ($statusClass == 'pending' ? 'clock' : 'times-circle')); ?> me-1"></i>
                            <?php echo e($statusText); ?>

                        </div>
                    </div>

                    <div class="profile-body">
                        <div class="row">
                            <!-- البيانات الشخصية -->
                            <div class="col-md-6 mb-3">
                                <div class="info-card">
                                    <h5><i class="fas fa-user"></i> البيانات الشخصية</h5>
                                    <div class="info-item">
                                        <span class="info-label">رقم الهوية</span>
                                        <span class="info-value"><?php echo e($student->national_id); ?></span>
                                    </div>
                                    <div class="info-item">
                                        <span class="info-label">الجوال</span>
                                        <span class="info-value"><a href="tel:<?php echo e($student->mobile); ?>"><?php echo e($student->mobile); ?></a></span>
                                    </div>
                                    <div class="info-item">
                                        <span class="info-label">ولي الأمر</span>
                                        <span class="info-value"><?php echo e($student->guardian_name); ?></span>
                                    </div>
                                    <div class="info-item">
                                        <span class="info-label">جوال ولي الأمر</span>
                                        <span class="info-value"><a href="tel:<?php echo e($student->guardian_mobile); ?>"><?php echo e($student->guardian_mobile); ?></a></span>
                                    </div>
                                </div>
                            </div>

                            <!-- معلومات الدراسة -->
                            <div class="col-md-6 mb-3">
                                <div class="info-card">
                                    <h5><i class="fas fa-school"></i> معلومات الدراسة</h5>
                                    <div class="info-item">
                                        <span class="info-label">الجهة</span>
                                        <span class="info-value">
                                            <?php if($student->center): ?>
                                                <span class="badge bg-info"><?php echo e($student->center->center_name); ?></span>
                                            <?php else: ?>
                                                غير محدد
                                            <?php endif; ?>
                                        </span>
                                    </div>
                                    <div class="info-item">
                                        <span class="info-label">النوع</span>
                                        <span class="info-value">
                                            <?php if($student->center): ?>
                                                <?php echo e($student->center->type); ?>

                                            <?php else: ?>
                                                -
                                            <?php endif; ?>
                                        </span>
                                    </div>
                                    <div class="info-item">
                                        <span class="info-label">الفترة</span>
                                        <span class="info-value">
                                            <span class="badge bg-<?php echo e($student->preferred_schedule == 'صباحية' ? 'warning text-dark' : 'secondary'); ?>">
                                                <i class="fas fa-<?php echo e($student->preferred_schedule == 'صباحية' ? 'sun' : 'moon'); ?> me-1"></i>
                                                <?php echo e($student->preferred_schedule); ?>

                                            </span>
                                        </span>
                                    </div>
                                    <div class="info-item">
                                        <span class="info-label">تاريخ التسجيل</span>
                                        <span class="info-value"><?php echo e($student->created_at->format('Y/m/d')); ?></span>
                                    </div>
                                </div>
                            </div>

                            <?php if($student->status === 'approved'): ?>
                            <!-- معلومات النقل -->
                            <div class="col-md-6 mb-3">
                                <div class="info-card">
                                    <h5><i class="fas fa-bus"></i> النقل</h5>
                                    <?php
                                        $bus = $student->assigned_bus_id ? \App\Models\Bus::with('driver')->find($student->assigned_bus_id) : null;
                                    ?>
                                    
                                    <?php if($bus): ?>
                                    <div class="bus-info">
                                        <div class="bus-icon"><i class="fas fa-bus"></i></div>
                                        <div class="bus-number"><?php echo e($bus->number); ?></div>
                                    </div>
                                    <?php if($bus->driver): ?>
                                    <div class="info-item">
                                        <span class="info-label">السائق</span>
                                        <span class="info-value"><?php echo e($bus->driver->name); ?></span>
                                    </div>
                                    <div class="info-item">
                                        <span class="info-label">جوال السائق</span>
                                        <span class="info-value"><a href="tel:<?php echo e($bus->driver->mobile); ?>"><?php echo e($bus->driver->mobile); ?></a></span>
                                    </div>
                                    <?php endif; ?>
                                    <?php if($student->pickup_time): ?>
                                    <div class="info-item">
                                        <span class="info-label">وقت الالتقاء</span>
                                        <span class="info-value"><?php echo e($student->pickup_time); ?></span>
                                    </div>
                                    <?php endif; ?>
                                    <?php else: ?>
                                    <div class="alert alert-custom alert-info mb-0">
                                        <i class="fas fa-info-circle me-2"></i>
                                        سيتم تخصيص الباص قريباً
                                    </div>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <!-- الدفعات -->
                            <div class="col-md-6 mb-3">
                                <div class="info-card">
                                    <h5><i class="fas fa-credit-card"></i> الرسوم والدفعات</h5>
                                    <?php
                                        $payments = \App\Models\Payment::where('student_id', $student->id)->get();
                                        $totalFees = $payments->sum('amount');
                                        $paidAmount = $payments->where('status', 'approved')->sum('amount');
                                        $remainingAmount = $totalFees - $paidAmount;
                                        $pendingCount = $payments->whereIn('status', ['awaiting_receipt', 'rejected'])->count();
                                    ?>
                                    
                                    <?php if($totalFees > 0): ?>
                                    <div class="payment-summary">
                                        <div class="payment-box total">
                                            <span class="amount"><?php echo e(number_format($totalFees)); ?></span>
                                            <span class="label">المطلوب</span>
                                        </div>
                                        <div class="payment-box paid">
                                            <span class="amount"><?php echo e(number_format($paidAmount)); ?></span>
                                            <span class="label">المدفوع</span>
                                        </div>
                                        <div class="payment-box remaining">
                                            <span class="amount"><?php echo e(number_format($remainingAmount)); ?></span>
                                            <span class="label">المتبقي</span>
                                        </div>
                                    </div>
                                    
                                    <?php if($pendingCount > 0): ?>
                                    <div class="pending-payments">
                                        <div class="count"><?php echo e($pendingCount); ?></div>
                                        <span>دفعة بانتظار رفع الإيصال</span>
                                    </div>
                                    <?php endif; ?>
                                    <?php else: ?>
                                    <div class="alert alert-custom alert-info mb-0">
                                        <i class="fas fa-info-circle me-2"></i>
                                        لا توجد دفعات مطلوبة حالياً
                                    </div>
                                    <?php endif; ?>
                                    
                                    <a href="<?php echo e(route('student.payments')); ?>" class="btn btn-payments w-100 mt-3">
                                        <i class="fas fa-credit-card me-2"></i>
                                        إدارة الدفعات
                                    </a>
                                </div>
                            </div>
                            <?php endif; ?>

                            <!-- الموقع -->
                            <?php if($student->latitude && $student->longitude): ?>
                            <div class="col-md-6 mb-3">
                                <div class="info-card">
                                    <h5><i class="fas fa-map-marker-alt"></i> موقعي</h5>
                                    <div id="studentMap"></div>
                                    <a href="https://www.google.com/maps?q=<?php echo e($student->latitude); ?>,<?php echo e($student->longitude); ?>" 
                                       target="_blank" class="btn btn-outline-light btn-sm w-100">
                                        <i class="fas fa-external-link-alt me-1"></i>
                                        فتح في Google Maps
                                    </a>
                                </div>
                            </div>
                            <?php endif; ?>
                        </div>

                        <!-- الأزرار -->
                        <div class="text-center mt-4">
                            <div class="d-flex justify-content-center gap-3 flex-wrap">
                                <?php if($student->status === 'approved'): ?>
                                <a href="<?php echo e(route('student.payments')); ?>" class="btn btn-payments">
                                    <i class="fas fa-credit-card me-2"></i>
                                    الدفعات
                                </a>
                                <?php endif; ?>
                                <a href="<?php echo e(route('home')); ?>" class="btn btn-home">
                                    <i class="fas fa-home me-2"></i>
                                    الرئيسية
                                </a>
                                <form method="POST" action="<?php echo e(route('student.logout')); ?>" class="d-inline">
                                    <?php echo csrf_field(); ?>
                                    <button type="submit" class="btn btn-logout">
                                        <i class="fas fa-sign-out-alt me-2"></i>
                                        خروج
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="contact-info">
                    <p><i class="fas fa-phone me-2"></i>للاستفسار: <a href="tel:0500511556">0500511556</a></p>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            <?php if($student->latitude && $student->longitude): ?>
            const map = L.map('studentMap').setView([<?php echo e($student->latitude); ?>, <?php echo e($student->longitude); ?>], 16);
            L.tileLayer('https://mt1.google.com/vt/lyrs=y&x={x}&y={y}&z={z}', {
                maxZoom: 20,
                attribution: '© Google'
            }).addTo(map);
            
            L.marker([<?php echo e($student->latitude); ?>, <?php echo e($student->longitude); ?>]).addTo(map)
                .bindPopup('<strong>موقعي</strong>').openPopup();
            <?php endif; ?>
        });
    </script>
</body>
</html>
<?php /**PATH /home/rasedbus/project-bus/resources/views/student/dashboard.blade.php ENDPATH**/ ?>