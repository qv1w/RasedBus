<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تم التسجيل بنجاح - جمعية القرآن الكريم</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-dark: #1a4b3a;
            --primary-light: #2d6b4f;
            --accent: #7fb069;
            --accent-light: #90c695;
        }

        body {
            background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary-light) 50%, var(--primary-dark) 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }

        .success-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(15px);
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            padding: 3rem;
            max-width: 600px;
            text-align: center;
        }

        .success-icon {
            width: 120px;
            height: 120px;
            background: linear-gradient(45deg, var(--accent), var(--accent-light));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 2rem;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); box-shadow: 0 0 0 0 rgba(127, 176, 105, 0.7); }
            50% { transform: scale(1.05); box-shadow: 0 0 0 20px rgba(127, 176, 105, 0); }
        }

        .success-icon i {
            font-size: 3.5rem;
            color: var(--primary-dark);
        }

        .success-title {
            color: #fff;
            font-size: 2rem;
            font-weight: bold;
            margin-bottom: 1rem;
        }

        .success-subtitle {
            color: var(--accent);
            font-size: 1.2rem;
            margin-bottom: 2rem;
        }

        .student-info {
            background: rgba(0, 0, 0, 0.2);
            border-radius: 15px;
            padding: 1.5rem;
            margin-bottom: 2rem;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            padding: 0.75rem 0;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }

        .info-row:last-child {
            border-bottom: none;
        }

        .info-label {
            color: rgba(255,255,255,0.7);
        }

        .info-value {
            color: var(--accent);
            font-weight: bold;
        }

        .info-note {
            color: rgba(255, 255, 255, 0.8);
            font-size: 0.95rem;
            margin-top: 1rem;
        }

        .info-note i {
            color: var(--accent);
        }

        .steps-container {
            text-align: right;
            margin-bottom: 2rem;
        }

        .steps-title {
            color: var(--accent);
            font-weight: bold;
            margin-bottom: 1rem;
            font-size: 1.1rem;
        }

        .step-item {
            display: flex;
            align-items: flex-start;
            gap: 1rem;
            margin-bottom: 0.75rem;
            color: rgba(255, 255, 255, 0.9);
        }

        .step-number {
            width: 28px;
            height: 28px;
            background: rgba(127, 176, 105, 0.3);
            border: 2px solid var(--accent);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.85rem;
            font-weight: bold;
            color: var(--accent);
            flex-shrink: 0;
        }

        .btn-home {
            background: linear-gradient(45deg, var(--accent), var(--accent-light));
            border: none;
            padding: 0.9rem 2.5rem;
            border-radius: 10px;
            color: var(--primary-dark);
            font-weight: bold;
            font-size: 1.1rem;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
            margin: 0.5rem;
        }

        .btn-home:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(127, 176, 105, 0.4);
            color: var(--primary-dark);
        }

        .btn-login {
            background: transparent;
            border: 2px solid var(--accent);
            padding: 0.9rem 2.5rem;
            border-radius: 10px;
            color: var(--accent);
            font-weight: bold;
            font-size: 1.1rem;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
            margin: 0.5rem;
        }

        .btn-login:hover {
            background: var(--accent);
            color: var(--primary-dark);
        }

        .contact-info {
            margin-top: 2rem;
            padding-top: 1.5rem;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }

        .contact-info p {
            color: rgba(255, 255, 255, 0.7);
            margin-bottom: 0.5rem;
            font-size: 0.9rem;
        }

        .contact-info a {
            color: var(--accent);
            text-decoration: none;
        }

        .contact-info a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="success-card">
        <div class="success-icon">
            <i class="fas fa-check"></i>
        </div>

        <h1 class="success-title">تم التسجيل بنجاح!</h1>
        <p class="success-subtitle">شكراً لك على التسجيل في جمعية القرآن الكريم للمواصلات</p>

        <div class="student-info">
            <div class="info-row">
                <span class="info-label">الاسم:</span>
                <span class="info-value"><?php echo e($student->name); ?></span>
            </div>
            <div class="info-row">
                <span class="info-label">البريد الإلكتروني:</span>
                <span class="info-value"><?php echo e($student->email); ?></span>
            </div>
            <div class="info-row">
                <span class="info-label">الجهة:</span>
                <span class="info-value"><?php echo e($student->center->center_name ?? 'غير محدد'); ?></span>
            </div>
            <div class="info-row">
                <span class="info-label">الفترة:</span>
                <span class="info-value"><?php echo e($student->preferred_schedule); ?></span>
            </div>
            <p class="info-note">
                <i class="fas fa-info-circle me-1"></i>
                استخدم البريد الإلكتروني ورقم الهوية لتسجيل الدخول
            </p>
        </div>

        <div class="steps-container">
            <h6 class="steps-title">
                <i class="fas fa-list-ol me-2"></i>
                الخطوات القادمة:
            </h6>
            <div class="step-item">
                <span class="step-number">1</span>
                <span>سيتم مراجعة طلبك من قبل الإدارة</span>
            </div>
            <div class="step-item">
                <span class="step-number">2</span>
                <span>ستتلقى إشعاراً عند قبول الطلب</span>
            </div>
            <div class="step-item">
                <span class="step-number">3</span>
                <span>سيتم تخصيص الباص ونقطة الالتقاء</span>
            </div>
            <div class="step-item">
                <span class="step-number">4</span>
                <span>يمكنك متابعة حالة الطلب من خلال تسجيل الدخول</span>
            </div>
        </div>

        <div class="d-flex justify-content-center flex-wrap">
            <a href="<?php echo e(route('home')); ?>" class="btn-home">
                <i class="fas fa-home me-2"></i>
                الصفحة الرئيسية
            </a>
            <a href="<?php echo e(route('student.login')); ?>" class="btn-login">
                <i class="fas fa-sign-in-alt me-2"></i>
                تسجيل الدخول
            </a>
        </div>

        <div class="contact-info">
            <p>
                <i class="fas fa-phone me-2"></i>
                للاستفسار: <a href="tel:0500511556">0500511556</a>
            </p>
            <p>
                <i class="fas fa-envelope me-2"></i>
                <a href="mailto:info@qz.org.sa">info@qz.org.sa</a>
            </p>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php /**PATH /home/rasedbus/project-bus/resources/views/student/success.blade.php ENDPATH**/ ?>