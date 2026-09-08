<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>التسجيل - جمعية القرآن الكريم للزلفي</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
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
            color: #ffffff;
            padding: 2rem 1rem;
        }

        .container {
            max-width: 1000px;
        }

        .page-title {
            text-align: center;
            margin-bottom: 3rem;
        }

        .page-title h1 {
            color: var(--accent);
            font-size: 2.2rem;
            margin-bottom: 0.5rem;
        }

        .page-title p {
            color: rgba(255,255,255,0.8);
            font-size: 1.1rem;
        }

        .registration-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(15px);
            border: 2px solid rgba(255, 255, 255, 0.2);
            border-radius: 20px;
            padding: 2rem;
            text-align: center;
            transition: all 0.3s ease;
            height: 100%;
            cursor: pointer;
            text-decoration: none;
            display: block;
        }

        .registration-card:hover {
            transform: translateY(-10px);
            border-color: var(--accent);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
        }

        .registration-card .icon {
            width: 100px;
            height: 100px;
            background: linear-gradient(45deg, var(--accent), var(--accent-light));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
        }

        .registration-card .icon i {
            font-size: 2.5rem;
            color: var(--primary-dark);
        }

        .registration-card h3 {
            color: #fff;
            font-size: 1.4rem;
            margin-bottom: 1rem;
        }

        .registration-card p {
            color: rgba(255,255,255,0.7);
            font-size: 0.95rem;
            margin-bottom: 1rem;
        }

        .registration-card .badge-gender {
            display: inline-block;
            padding: 0.4rem 1rem;
            border-radius: 20px;
            font-size: 0.85rem;
            margin: 0.25rem;
        }

        .badge-female {
            background: rgba(255, 105, 180, 0.3);
            color: #ffb6c1;
            border: 1px solid rgba(255, 105, 180, 0.5);
        }

        .badge-male {
            background: rgba(100, 149, 237, 0.3);
            color: #87cefa;
            border: 1px solid rgba(100, 149, 237, 0.5);
        }

        .schedule-badge {
            display: inline-block;
            padding: 0.3rem 0.8rem;
            border-radius: 15px;
            font-size: 0.8rem;
            margin-top: 0.5rem;
        }

        .badge-morning {
            background: rgba(255, 193, 7, 0.3);
            color: #ffd54f;
            border: 1px solid rgba(255, 193, 7, 0.5);
        }

        .badge-evening {
            background: rgba(63, 81, 181, 0.3);
            color: #9fa8da;
            border: 1px solid rgba(63, 81, 181, 0.5);
        }

        .back-link {
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            margin-bottom: 2rem;
            transition: color 0.3s;
        }

        .back-link:hover {
            color: var(--accent);
        }

        .section-title {
            color: var(--accent);
            font-size: 1.3rem;
            margin: 2rem 0 1.5rem;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid rgba(127, 176, 105, 0.3);
        }

        /* برامج الرياحين - تصميم خاص */
        .riyaheen-section {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 20px;
            padding: 2rem;
            margin-top: 2rem;
        }

        .riyaheen-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 1.5rem;
        }

        .riyaheen-card {
            background: rgba(255, 255, 255, 0.08);
            border: 2px solid rgba(255, 255, 255, 0.15);
            border-radius: 20px;
            padding: 2rem;
            text-align: center;
            transition: all 0.3s ease;
            text-decoration: none;
        }

        .riyaheen-card:hover {
            transform: translateY(-8px);
            border-color: var(--accent);
            background: rgba(255, 255, 255, 0.12);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.3);
        }

        .riyaheen-card .icon {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
        }

        .riyaheen-card.male .icon {
            background: linear-gradient(45deg, #6495ed, #87cefa);
        }

        .riyaheen-card.female .icon {
            background: linear-gradient(45deg, #ff69b4, #ffb6c1);
        }

        .riyaheen-card .icon i {
            font-size: 2rem;
            color: #fff;
        }

        .riyaheen-card h4 {
            color: #fff;
            font-size: 1.2rem;
            margin-bottom: 0.5rem;
        }

        .riyaheen-card .description {
            color: rgba(255,255,255,0.6);
            font-size: 0.9rem;
            margin-bottom: 1rem;
        }
    </style>
</head>
<body>
    <div class="container">
        <a href="<?php echo e(route('home')); ?>" class="back-link">
            <i class="fas fa-arrow-right me-2"></i>
            العودة للرئيسية
        </a>

        <div class="page-title">
            <h1>
                <i class="fas fa-user-plus me-2"></i>
                التسجيل في خدمة النقل
            </h1>
            <p>اختر نوع التسجيل المناسب لك</p>
        </div>

        <!-- الدور والمركز -->
        <div class="row g-4">
            <!-- دور التحفيظ -->
            <div class="col-md-6">
                <a href="<?php echo e(route('student.register.form', ['type' => 'دار', 'gender' => 'بنات'])); ?>" class="registration-card">
                    <div class="icon">
                        <i class="fas fa-mosque"></i>
                    </div>
                    <h3>دور تحفيظ القرآن الكريم</h3>
                    <p>التسجيل في إحدى دور تحفيظ القرآن الكريم النسائية</p>
                    <span class="badge-gender badge-female">
                        <i class="fas fa-female me-1"></i>
                        بنات فقط
                    </span>
                    <div>
                        <span class="schedule-badge badge-morning">
                            <i class="fas fa-sun me-1"></i>
                            صباحية
                        </span>
                        <span class="schedule-badge badge-evening">
                            <i class="fas fa-moon me-1"></i>
                            مسائية
                        </span>
                    </div>
                </a>
            </div>

            <!-- مركز إعداد المعلمات -->
            <div class="col-md-6">
                <a href="<?php echo e(route('student.register.form', ['type' => 'مركز', 'gender' => 'بنات'])); ?>" class="registration-card">
                    <div class="icon">
                        <i class="fas fa-graduation-cap"></i>
                    </div>
                    <h3>مركز الشيخ فوزان الفهد رحمه الله</h3>
                    <p>مركز إعداد المعلمات - متاح لجميع أحياء الزلفي</p>
                    <span class="badge-gender badge-female">
                        <i class="fas fa-female me-1"></i>
                        بنات فقط
                    </span>
                    <div>
                        <span class="schedule-badge badge-morning">
                            <i class="fas fa-sun me-1"></i>
                            صباحية فقط
                        </span>
                    </div>
                </a>
            </div>
        </div>

        <!-- برامج الرياحين -->
        <div class="riyaheen-section">
            <h5 class="section-title">
                <i class="fas fa-seedling me-2"></i>
                برامج الرياحين
            </h5>
            <p class="text-light opacity-75 mb-4">برامج تعليمية للأطفال - بنين وبنات (فترة مسائية فقط)</p>

            <div class="riyaheen-cards">
                <!-- برنامج الرياحين بنين -->
                <a href="<?php echo e(route('student.register.form', ['type' => 'برنامج', 'gender' => 'بنين'])); ?>" class="riyaheen-card male">
                    <div class="icon">
                        <i class="fas fa-child"></i>
                    </div>
                    <h4>برنامج الرياحين بنين</h4>
                    <p class="description">برنامج تعليمي للأولاد</p>
                    <span class="badge-gender badge-male">
                        <i class="fas fa-male me-1"></i>
                        بنين
                    </span>
                    <div>
                        <span class="schedule-badge badge-evening">
                            <i class="fas fa-moon me-1"></i>
                            مسائي فقط
                        </span>
                    </div>
                </a>

                <!-- برنامج الرياحين بنات -->
                <a href="<?php echo e(route('student.register.form', ['type' => 'برنامج', 'gender' => 'بنات'])); ?>" class="riyaheen-card female">
                    <div class="icon">
                        <i class="fas fa-child"></i>
                    </div>
                    <h4>برنامج الرياحين بنات</h4>
                    <p class="description">برنامج تعليمي للبنات</p>
                    <span class="badge-gender badge-female">
                        <i class="fas fa-female me-1"></i>
                        بنات
                    </span>
                    <div>
                        <span class="schedule-badge badge-evening">
                            <i class="fas fa-moon me-1"></i>
                            مسائي فقط
                        </span>
                    </div>
                </a>
            </div>
        </div>

        <!-- معلومات إضافية -->
        <div class="text-center mt-5">
            <p class="text-light opacity-75">
                <i class="fas fa-info-circle me-2"></i>
                للاستفسار: <a href="tel:0500511556" class="text-white">0500511556</a>
            </p>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php /**PATH /home/rasedbus/project-bus/resources/views/student/select-type.blade.php ENDPATH**/ ?>