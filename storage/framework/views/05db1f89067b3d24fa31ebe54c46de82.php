<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>الدفعات - <?php echo e($student->name); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
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

        .page-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(15px);
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            overflow: hidden;
        }

        .page-header {
            background: rgba(0, 0, 0, 0.2);
            padding: 1.5rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .page-header h2 {
            margin: 0;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .page-header h2 i { color: var(--accent); }

        .page-body { padding: 2rem; }

        .summary-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .summary-card {
            background: rgba(0, 0, 0, 0.2);
            border-radius: 15px;
            padding: 1.5rem;
            text-align: center;
        }

        .summary-card .icon {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            font-size: 1.5rem;
        }

        .summary-card .amount {
            font-size: 2rem;
            font-weight: bold;
            display: block;
        }

        .summary-card .label {
            color: rgba(255,255,255,0.7);
            font-size: 0.9rem;
        }

        .summary-card.total .icon { background: rgba(23, 162, 184, 0.3); color: #17a2b8; }
        .summary-card.total .amount { color: #17a2b8; }

        .summary-card.paid .icon { background: rgba(40, 167, 69, 0.3); color: #28a745; }
        .summary-card.paid .amount { color: #28a745; }

        .summary-card.remaining .icon { background: rgba(255, 193, 7, 0.3); color: #ffc107; }
        .summary-card.remaining .amount { color: #ffc107; }

        .payment-item {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 15px;
            padding: 1.5rem;
            margin-bottom: 1rem;
            border: 1px solid rgba(255, 255, 255, 0.1);
            transition: all 0.3s;
        }

        .payment-item:hover {
            background: rgba(255, 255, 255, 0.08);
            border-color: rgba(127, 176, 105, 0.3);
        }

        .payment-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
            flex-wrap: wrap;
            gap: 0.5rem;
        }

        .payment-amount {
            font-size: 1.5rem;
            font-weight: bold;
            color: var(--accent);
        }

        .payment-amount small {
            font-size: 0.9rem;
            color: rgba(255,255,255,0.6);
            font-weight: normal;
        }

        .payment-status {
            padding: 0.4rem 1rem;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
        }

        .status-approved { background: rgba(40, 167, 69, 0.2); color: #90EE90; }
        .status-pending { background: rgba(255, 193, 7, 0.2); color: #ffc107; }
        .status-awaiting { background: rgba(220, 53, 69, 0.2); color: #ffb3b3; }
        .status-rejected { background: rgba(220, 53, 69, 0.2); color: #ff6b6b; }

        .payment-details {
            display: flex;
            gap: 2rem;
            flex-wrap: wrap;
            color: rgba(255,255,255,0.7);
            font-size: 0.9rem;
            margin-bottom: 1rem;
        }

        .payment-details i { color: var(--accent); margin-left: 0.5rem; }

        .upload-section {
            background: rgba(0, 0, 0, 0.2);
            border-radius: 12px;
            padding: 1rem;
            margin-top: 1rem;
        }

        .upload-section h6 {
            color: var(--accent);
            margin-bottom: 1rem;
            font-weight: 600;
        }

        .upload-form {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
            align-items: center;
        }

        .upload-form .form-control {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: #fff;
            flex: 1;
            min-width: 200px;
        }

        .upload-form .form-control::file-selector-button {
            background: var(--accent);
            color: var(--primary-dark);
            border: none;
            padding: 0.5rem 1rem;
            margin-left: 1rem;
        }

        .btn-upload {
            background: linear-gradient(45deg, var(--accent), #90c695);
            border: none;
            color: var(--primary-dark);
            padding: 0.6rem 1.5rem;
            border-radius: 10px;
            font-weight: 600;
        }

        .btn-upload:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(127, 176, 105, 0.4);
            color: var(--primary-dark);
        }

        .receipt-preview {
            margin-top: 1rem;
        }

        .receipt-preview a {
            color: var(--accent);
            text-decoration: none;
        }

        .btn-back {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.3);
            color: #fff;
            padding: 0.6rem 1.5rem;
            border-radius: 10px;
            transition: all 0.3s;
        }

        .btn-back:hover {
            background: rgba(255, 255, 255, 0.2);
            color: #fff;
        }

        .alert-custom {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: #fff;
            border-radius: 15px;
        }

        .alert-custom.alert-success { border-color: rgba(40, 167, 69, 0.4); background: rgba(40, 167, 69, 0.15); }
        .alert-custom.alert-danger { border-color: rgba(220, 53, 69, 0.4); background: rgba(220, 53, 69, 0.15); }

        .empty-state {
            text-align: center;
            padding: 3rem;
            color: rgba(255,255,255,0.6);
        }

        .empty-state i {
            font-size: 4rem;
            margin-bottom: 1rem;
            opacity: 0.5;
        }

        @media (max-width: 768px) {
            .summary-cards { grid-template-columns: 1fr; }
            .payment-header { flex-direction: column; align-items: flex-start; }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <?php if(session('success')): ?>
                <div class="alert alert-custom alert-success alert-dismissible fade show mb-3" role="alert">
                    <i class="fas fa-check-circle me-2"></i><?php echo e(session('success')); ?>

                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"></button>
                </div>
                <?php endif; ?>

                <?php if(session('error')): ?>
                <div class="alert alert-custom alert-danger alert-dismissible fade show mb-3" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i><?php echo e(session('error')); ?>

                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"></button>
                </div>
                <?php endif; ?>

                <div class="page-card">
                    <div class="page-header">
                        <h2>
                            <i class="fas fa-credit-card"></i>
                            الدفعات والرسوم
                        </h2>
                        <a href="<?php echo e(route('student.dashboard')); ?>" class="btn btn-back">
                            <i class="fas fa-arrow-right me-1"></i>
                            العودة
                        </a>
                    </div>

                    <div class="page-body">
                        <div class="summary-cards">
                            <div class="summary-card total">
                                <div class="icon"><i class="fas fa-money-bill-wave"></i></div>
                                <span class="amount"><?php echo e(number_format($totalFees)); ?></span>
                                <span class="label">المطلوب (ريال)</span>
                            </div>
                            <div class="summary-card paid">
                                <div class="icon"><i class="fas fa-check-circle"></i></div>
                                <span class="amount"><?php echo e(number_format($paidAmount)); ?></span>
                                <span class="label">المدفوع (ريال)</span>
                            </div>
                            <div class="summary-card remaining">
                                <div class="icon"><i class="fas fa-clock"></i></div>
                                <span class="amount"><?php echo e(number_format($remainingAmount)); ?></span>
                                <span class="label">المتبقي (ريال)</span>
                            </div>
                        </div>

                        <?php if($payments->count() > 0): ?>
                            <?php $__currentLoopData = $payments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="payment-item">
                                <div class="payment-header">
                                    <div class="payment-amount">
                                        <?php echo e(number_format($payment->amount)); ?>

                                        <small>ريال</small>
                                    </div>
                                    <?php
                                        $statusClass = [
                                            'approved' => 'approved',
                                            'pending' => 'pending',
                                            'awaiting_receipt' => 'awaiting',
                                            'rejected' => 'rejected'
                                        ][$payment->status] ?? 'pending';
                                        
                                        $statusText = [
                                            'approved' => 'تم الدفع',
                                            'pending' => 'قيد المراجعة',
                                            'awaiting_receipt' => 'بانتظار الإيصال',
                                            'rejected' => 'مرفوض'
                                        ][$payment->status] ?? $payment->status;
                                    ?>
                                    <span class="payment-status status-<?php echo e($statusClass); ?>">
                                        <i class="fas fa-<?php echo e($statusClass == 'approved' ? 'check' : ($statusClass == 'pending' ? 'hourglass-half' : ($statusClass == 'awaiting' ? 'upload' : 'times'))); ?> me-1"></i>
                                        <?php echo e($statusText); ?>

                                    </span>
                                </div>

                                <div class="payment-details">
                                    <?php if($payment->description): ?>
                                    <span><i class="fas fa-info-circle"></i><?php echo e($payment->description); ?></span>
                                    <?php endif; ?>
                                    <span><i class="fas fa-calendar"></i><?php echo e($payment->created_at->format('Y/m/d')); ?></span>
                                    <?php if($payment->due_date): ?>
                                    <span><i class="fas fa-calendar-check"></i>الاستحقاق: <?php echo e(\Carbon\Carbon::parse($payment->due_date)->format('Y/m/d')); ?></span>
                                    <?php endif; ?>
                                </div>

                                <?php if($payment->receipt_image): ?>
                                <div class="receipt-preview">
                                    <a href="<?php echo e(asset('storage/' . $payment->receipt_image)); ?>" target="_blank">
                                        <i class="fas fa-file-image me-1"></i>
                                        عرض الإيصال المرفوع
                                    </a>
                                </div>
                                <?php endif; ?>

                                <?php if(in_array($payment->status, ['awaiting_receipt', 'rejected'])): ?>
                                <div class="upload-section">
                                    <h6>
                                        <i class="fas fa-upload me-1"></i>
                                        <?php if($payment->status == 'rejected'): ?>
                                            إعادة رفع الإيصال
                                        <?php else: ?>
                                            رفع إيصال الدفع
                                        <?php endif; ?>
                                    </h6>
                                    
                                    <?php if($payment->rejection_reason): ?>
                                    <div class="alert alert-custom alert-danger py-2 mb-3">
                                        <small><i class="fas fa-exclamation-triangle me-1"></i>سبب الرفض: <?php echo e($payment->rejection_reason); ?></small>
                                    </div>
                                    <?php endif; ?>
                                    
                                    
                                    <form action="<?php echo e(url('/student/payment/' . $payment->id . '/upload-receipt')); ?>" method="POST" enctype="multipart/form-data" class="upload-form">
                                        <?php echo csrf_field(); ?>
                                        <input type="file" name="receipt_image" class="form-control" accept="image/*,.pdf" required>
                                        <button type="submit" class="btn btn-upload">
                                            <i class="fas fa-upload me-1"></i>
                                            رفع
                                        </button>
                                    </form>
                                </div>
                                <?php endif; ?>
                            </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php else: ?>
                        <div class="empty-state">
                            <i class="fas fa-receipt"></i>
                            <h4>لا توجد دفعات</h4>
                            <p>لم يتم تسجيل أي دفعات حتى الآن</p>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\project-bus\resources\views/student/payments.blade.php ENDPATH**/ ?>