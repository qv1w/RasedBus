<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>نظام تسجيل الطلاب</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
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
            position: relative;
            overflow-x: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* خلفية إسلامية متحركة */
        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: 
                radial-gradient(circle at 25% 25%, rgba(255, 215, 0, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 75% 75%, rgba(255, 215, 0, 0.05) 0%, transparent 50%);
            z-index: -2;
        }


        body::after {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('data:image/svg+xml,<svg width="100" height="100" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg"><defs><pattern id="islamic" x="0" y="0" width="50" height="50" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="2" fill="%23ffd700" opacity="0.1"/><path d="M25,15 L30,20 L25,25 L20,20 Z" fill="%23ffd700" opacity="0.05"/></pattern></defs><rect width="100" height="100" fill="url(%23islamic)"/></svg>');
            animation: float 30s linear infinite;
            z-index: -1;
        }

        @keyframes float {
            0% { transform: translateY(0px) rotate(0deg); }
            100% { transform: translateY(-100px) rotate(360deg); }
        }

        .container {
            max-width: 900px;
            text-align: center;
            position: relative;
            z-index: 1;
        }

        /* البطاقة الرئيسية */
        .main-card {
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(25px);
            border-radius: 35px;
            padding: 4rem 3rem;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.4);
            border: 2px solid rgba(255, 215, 0, 0.2);
            position: relative;
            overflow: hidden;
            margin: 2rem;
        }

        .main-card::before {
            content: '';
            position: absolute;
            top: -2px;
            left: -2px;
            right: -2px;
            bottom: -2px;
            background: linear-gradient(45deg, #7fb069, transparent, #ffd700, transparent, #7fb069);
            border-radius: 35px;
            z-index: -1;
            animation: borderGlow 4s ease-in-out infinite;
        }

        @keyframes borderGlow {
            0%, 100% { opacity: 0.3; }
            50% { opacity: 0.8; }
        }

        /* شعار وعنوان */
        .logo-section {
            margin-bottom: 3rem;
        }

        .logo-icon {
            font-size: 4rem;
            color: #ffd700;
            margin-bottom: 1rem;
            text-shadow: 0 4px 15px rgba(255, 215, 0, 0.4);
            animation: pulse 2s ease-in-out infinite;
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }

        .logo-title {
            font-size: 2.5rem;
            font-weight: 700;
            background: linear-gradient(45deg, #ffd700, #ffed4a, #ffd700);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 1rem;
            line-height: 1.2;
            text-shadow: 0 2px 10px rgba(255, 215, 0, 0.3);
        }

        .subtitle {
            font-size: 1.3rem;
            color: rgba(255, 255, 255, 0.85);
            margin-bottom: 3rem;
            line-height: 1.4;
            font-weight: 300;
        }

        /* زر البداية الرئيسي */
        .start-btn {
            background: linear-gradient(45deg, #7fb069, #90c695);
            color: #1a4b3a;
            font-size: 1.4rem;
            font-weight: 700;
            padding: 1.8rem 4rem;
            border-radius: 25px;
            border: none;
            transition: all 0.4s ease;
            box-shadow: 0 15px 40px rgba(127, 176, 105, 0.4);
            position: relative;
            overflow: hidden;
            text-transform: uppercase;
            letter-spacing: 1px;
            text-decoration: none;
            display: inline-block;
        }

        .start-btn:hover {
            transform: translateY(-5px);
            box-shadow: 0 25px 60px rgba(127, 176, 105, 0.6);
            color: #1a4b3a;
        }

        .start-btn:active {
            transform: translateY(-2px);
        }

        .start-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.4), transparent);
            transition: left 0.6s;
        }

        .start-btn:hover::before {
            left: 100%;
        }

        .start-btn i {
            margin-left: 0.8rem;
            font-size: 1.2rem;
        }

        /* الأزرار الثانوية */
        .secondary-buttons {
            display: flex;
            justify-content: center;
            gap: 1.5rem;
            flex-wrap: wrap;
            margin-top: 2rem;
        }

        .secondary-btn {
            background: rgba(255, 255, 255, 0.1);
            border: 2px solid rgba(127, 176, 105, 0.4);
            color: #e8f5e8;
            padding: 1rem 2rem;
            border-radius: 20px;
            text-decoration: none;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .secondary-btn:hover {
            background: rgba(127, 176, 105, 0.2);
            border-color: #7fb069;
            color: #ffffff;
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(127, 176, 105, 0.3);
        }

        .secondary-btn i {
            font-size: 1.1rem;
        }

        /* إحصائيات سريعة */
        .stats-section {
            margin-top: 3rem;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 1.5rem;
        }

        .stat-card {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(127, 176, 105, 0.3);
            border-radius: 20px;
            padding: 1.5rem 1rem;
            text-align: center;
            backdrop-filter: blur(10px);
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            background: rgba(255, 255, 255, 0.1);
            border-color: #7fb069;
            transform: translateY(-3px);
        }

        .stat-number {
            font-size: 2rem;
            font-weight: bold;
            color: #ffd700;
            margin-bottom: 0.5rem;
        }

        .stat-label {
            font-size: 0.9rem;
            color: rgba(255, 255, 255, 0.8);
        }

        /* تحسينات للشاشات الصغيرة */
        @media (max-width: 768px) {
            .main-card {
                padding: 2.5rem 1.5rem;
                margin: 1rem;
            }

            .logo-title {
                font-size: 1.8rem;
            }

            .subtitle {
                font-size: 1.1rem;
            }

            .start-btn {
                font-size: 1.2rem;
                padding: 1.5rem 3rem;
            }

            .secondary-buttons {
                flex-direction: column;
                align-items: center;
            }

            .secondary-btn {
                width: 100%;
                max-width: 300px;
                justify-content: center;
            }

            .stats-section {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 480px) {
            .stats-section {
                grid-template-columns: 1fr;
            }
        }

        /* تأثيرات إضافية */
        .floating-particles {
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            pointer-events: none;
            z-index: -1;
        }

        .particle {
            position: absolute;
            background: rgba(255, 215, 0, 0.1);
            border-radius: 50%;
            animation: floatParticle 15s linear infinite;
        }

        @keyframes floatParticle {
            0% {
                transform: translateY(100vh) rotate(0deg);
                opacity: 0;
            }
            10% {
                opacity: 1;
            }
            90% {
                opacity: 1;
            }
            100% {
                transform: translateY(-100px) rotate(360deg);
                opacity: 0;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="main-card">
            <!-- الجزيئات المتحركة -->
            <div class="floating-particles">
                <div class="particle" style="left: 10%; width: 8px; height: 8px; animation-delay: 0s;"></div>
                <div class="particle" style="left: 20%; width: 6px; height: 6px; animation-delay: 2s;"></div>
                <div class="particle" style="left: 30%; width: 10px; height: 10px; animation-delay: 4s;"></div>
                <div class="particle" style="left: 40%; width: 7px; height: 7px; animation-delay: 6s;"></div>
                <div class="particle" style="left: 50%; width: 9px; height: 9px; animation-delay: 8s;"></div>
                <div class="particle" style="left: 60%; width: 5px; height: 5px; animation-delay: 10s;"></div>
                <div class="particle" style="left: 70%; width: 8px; height: 8px; animation-delay: 12s;"></div>
                <div class="particle" style="left: 80%; width: 6px; height: 6px; animation-delay: 14s;"></div>
                <div class="particle" style="left: 90%; width: 7px; height: 7px; animation-delay: 16s;"></div>
            </div>

            <div class="logo-section">
                <div class="logo-icon">
                    <i class="fas fa-mosque"></i>
                </div>
                <div class="logo-title">جمعية تحفيظ القرآن الكريم بمحافظة الزلفي</div>
                <div class="subtitle">نظام تسجيل الطلاب والخدمات التابعة</div>
            </div>

            <a href="{{ route('students.create') }}" class="start-btn">
                <i class="fas fa-user-plus"></i>
سجل الان            </a>
        </div>
    </div>
</body>
</html>