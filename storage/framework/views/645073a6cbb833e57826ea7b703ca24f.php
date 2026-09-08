<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <link rel="icon" type="image/png" href="/favicon.png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <title>جمعية القرآن الكريم بالزلفي - نظام المواصلات</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Amiri:wght@400;700&family=Cairo:wght@300;400;600;700;900&family=Tajawal:wght@400;500;700;800;900&display=swap" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <style>
        :root {
            --primary-green: #0f3c1f;
            --secondary-green: #1a5c30; 
            --light-green: #2d7a45;
            --accent-gold: #c9a96e;
            --light-gold: #e6d7a3;
            --warm-white: #f8f9fa;
            --text-dark: #1a1a1a;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html, body {
            overflow-x: hidden;
            width: 100%;
            max-width: 100%;
        }

        body {
            font-family: 'Cairo', sans-serif;
            background: #ffffff;
            color: var(--text-dark);
            line-height: 1.8;
            position: relative;
        }

        /* ===== ANIMATIONS ===== */
        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-15px); }
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes spin {
            100% { transform: rotate(360deg); }
        }

        /* ===== NAVBAR ===== */
        .navbar {
            background: rgba(255, 255, 255, 0.97) !important;
            backdrop-filter: blur(20px);
            box-shadow: 0 4px 30px rgba(0,0,0,0.1);
            padding: 0.75rem 0;
            transition: all 0.4s ease;
        }

        .navbar.scrolled {
            box-shadow: 0 8px 40px rgba(0,0,0,0.15);
            padding: 0.5rem 0;
        }

        .navbar-brand {
            font-family: 'Tajawal', sans-serif;
            font-weight: 800;
            font-size: 1.1rem;
            color: var(--primary-green) !important;
            display: flex;
            align-items: center;
            gap: 10px;
            transition: all 0.3s;
        }

        .navbar-logo {
            width: 42px;
            height: 42px;
            flex-shrink: 0;
            transition: all 0.4s;
        }

        .navbar.scrolled .navbar-logo {
            width: 36px;
            height: 36px;
        }

        /* Mobile menu */
        .navbar-toggler {
            border: 2px solid var(--primary-green);
            border-radius: 10px;
            padding: 6px 10px;
            color: var(--primary-green);
        }

        .navbar-toggler:focus { box-shadow: none; }

        .navbar-toggler-icon {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='%230f3c1f' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
        }

        /* Mobile dropdown */
        @media (max-width: 991px) {
            .navbar-collapse {
                background: white;
                border-radius: 16px;
                padding: 1rem;
                margin-top: 0.75rem;
                box-shadow: 0 10px 40px rgba(0,0,0,0.12);
                border: 1px solid rgba(0,0,0,0.05);
                /* Prevent overflow from parent */
                width: 100%;
                max-width: 100%;
            }

            .navbar-nav .nav-link {
                padding: 0.75rem 1rem !important;
                border-radius: 10px;
                margin-bottom: 4px;
            }

            .navbar-nav .nav-link:hover {
                background: rgba(15,60,31,0.06);
            }

            /* CTA buttons row in mobile */
            .navbar-cta {
                display: flex !important;
                flex-direction: column !important;
                gap: 8px;
                margin-top: 8px;
                padding-top: 12px;
                border-top: 1px solid rgba(0,0,0,0.08);
            }

            .nav-link.btn-admin {
                background: rgba(15,60,31,0.08);
                color: var(--primary-green) !important;
                border-radius: 12px;
                text-align: center;
                padding: 0.7rem 1rem !important;
                font-weight: 700;
            }

            .nav-link.btn-register {
                text-align: center;
            }
        }

        .nav-link {
            font-weight: 600;
            font-size: 1rem;
            color: var(--text-dark) !important;
            padding: 0.6rem 1.2rem !important;
            border-radius: 10px;
            transition: all 0.3s;
            position: relative;
        }

        @media (min-width: 992px) {
            .nav-link::before {
                content: '';
                position: absolute;
                bottom: 0;
                left: 50%;
                width: 0;
                height: 3px;
                background: var(--accent-gold);
                transition: all 0.3s;
                transform: translateX(-50%);
                border-radius: 3px;
            }

            .nav-link:hover::before { width: 80%; }

            .nav-link:hover {
                color: var(--primary-green) !important;
                background: rgba(15, 60, 31, 0.05);
            }
        }

        .nav-link.btn-register {
            background: linear-gradient(135deg, var(--primary-green), var(--secondary-green));
            color: white !important;
            border-radius: 25px;
            padding: 0.6rem 1.5rem !important;
        }

        .nav-link.btn-register:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(15, 60, 31, 0.3);
        }

        /* ===== HERO SECTION ===== */
        .hero-section {
            background: linear-gradient(160deg, var(--primary-green) 0%, var(--secondary-green) 50%, var(--light-green) 100%);
            color: white;
            padding: 130px 0 100px;
            position: relative;
            overflow: hidden;
            width: 100%;
            max-width: 100%;
        }

        .hero-section::before {
            content: '';
            position: absolute;
            inset: 0;
            background: 
                radial-gradient(circle at 20% 80%, rgba(201, 169, 110, 0.15) 0%, transparent 40%),
                radial-gradient(circle at 80% 20%, rgba(255, 255, 255, 0.08) 0%, transparent 40%);
        }

        .hero-section::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            right: 0;
            height: 80px;
            background: white;
            clip-path: ellipse(70% 100% at 50% 100%);
        }

        .hero-particles {
            position: absolute;
            inset: 0;
            overflow: hidden;
            pointer-events: none;
        }

        .particle {
            position: absolute;
            width: 8px;
            height: 8px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            animation: float 6s ease-in-out infinite;
        }

        .particle:nth-child(1) { top: 20%; left: 10%; animation-delay: 0s; }
        .particle:nth-child(2) { top: 60%; left: 20%; animation-delay: 1s; width: 12px; height: 12px; }
        .particle:nth-child(3) { top: 30%; left: 70%; animation-delay: 2s; }
        .particle:nth-child(4) { top: 70%; left: 80%; animation-delay: 3s; width: 6px; height: 6px; }
        .particle:nth-child(5) { top: 40%; left: 90%; animation-delay: 4s; }

        .hero-content {
            position: relative;
            z-index: 2;
        }

        .hero-logo {
            width: 130px;
            height: 130px;
            margin-bottom: 2rem;
            filter: drop-shadow(0 10px 30px rgba(0,0,0,0.35));
            animation: float 5s ease-in-out infinite;
        }

        .hero-title {
            font-family: 'Amiri', serif;
            font-size: 3rem;
            font-weight: 700;
            margin-bottom: 1rem;
            text-shadow: 2px 2px 10px rgba(0,0,0,0.35);
            color: #ffffff;
        }

        .hero-subtitle {
            font-family: 'Tajawal', sans-serif;
            font-size: 1.3rem;
            font-weight: 500;
            opacity: 0.95;
            margin-bottom: 1.2rem;
        }

        .hero-desc {
            font-size: 1.05rem;
            max-width: 700px;
            margin: 0 auto 2.5rem;
            opacity: 0.9;
            line-height: 2;
        }

        .hero-buttons {
            display: flex;
            justify-content: center;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .btn-hero {
            padding: 16px 40px;
            font-size: 1.05rem;
            font-weight: 700;
            border-radius: 50px;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            border: none;
            position: relative;
            overflow: hidden;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .btn-hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.25), transparent);
            transition: left 0.5s;
        }

        .btn-hero:hover::before { left: 100%; }

        .btn-hero-primary {
            background: linear-gradient(135deg, #ffffff, #f8f9fa);
            color: var(--primary-green);
            box-shadow: 0 8px 25px rgba(0,0,0,0.2);
        }

        .btn-hero-primary:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(0,0,0,0.3);
            color: var(--primary-green);
        }

        .btn-hero-outline {
            background: transparent;
            color: white;
            border: 2px solid rgba(255,255,255,0.6);
            backdrop-filter: blur(10px);
        }

        .btn-hero-outline:hover {
            background: white;
            color: var(--primary-green);
            border-color: white;
            transform: translateY(-5px);
        }

        /* ===== SECTION BASE ===== */
        .programs-section {
            padding: 90px 0;
            background: linear-gradient(180deg, #ffffff 0%, var(--warm-white) 100%);
        }

        .features-section {
            padding: 90px 0;
            background: var(--warm-white);
        }

        .about-section {
            padding: 90px 0;
            background: var(--warm-white);
        }

        .section-header {
            text-align: center;
            margin-bottom: 3.5rem;
        }

        .section-badge {
            display: inline-block;
            background: linear-gradient(135deg, var(--primary-green), var(--secondary-green));
            color: white;
            padding: 7px 22px;
            border-radius: 50px;
            font-size: 0.9rem;
            font-weight: 600;
            margin-bottom: 1.2rem;
            box-shadow: 0 5px 20px rgba(15, 60, 31, 0.2);
        }

        .section-title {
            font-family: 'Tajawal', sans-serif;
            font-size: 2.5rem;
            font-weight: 900;
            color: var(--primary-green);
            margin-bottom: 0.75rem;
        }

        .section-title::after {
            content: '';
            display: block;
            width: 70px;
            height: 4px;
            background: linear-gradient(90deg, var(--accent-gold), var(--light-gold));
            margin: 0.8rem auto 0;
            border-radius: 2px;
        }

        .section-subtitle {
            font-size: 1.1rem;
            color: #666;
            max-width: 560px;
            margin: 0 auto;
        }

        /* ===== PROGRAM CARDS ===== */
        .program-card {
            background: white;
            border-radius: 22px;
            padding: 2.5rem 1.75rem;
            text-align: center;
            box-shadow: 0 10px 40px rgba(0,0,0,0.07);
            border: 1px solid rgba(0,0,0,0.05);
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            height: 100%;
            position: relative;
            overflow: hidden;
            text-decoration: none;
            display: block;
        }

        .program-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--primary-green), var(--accent-gold), var(--light-green));
            transform: scaleX(0);
            transition: transform 0.4s;
        }

        .program-card:hover::before { transform: scaleX(1); }

        .program-card:hover {
            transform: translateY(-12px);
            box-shadow: 0 25px 60px rgba(15, 60, 31, 0.14);
            border-color: var(--accent-gold);
        }

        .program-icon {
            width: 85px;
            height: 85px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.75rem;
            font-size: 2.2rem;
            color: white;
            position: relative;
            transition: all 0.4s;
        }

        .program-icon::after {
            content: '';
            position: absolute;
            inset: -5px;
            border-radius: 50%;
            border: 2px dashed var(--accent-gold);
            opacity: 0;
            transition: all 0.4s;
            animation: spin 10s linear infinite paused;
        }

        .program-card:hover .program-icon::after {
            opacity: 1;
            animation-play-state: running;
        }

        .program-card:hover .program-icon { transform: scale(1.08) rotate(5deg); }

        .program-card h5 {
            font-family: 'Tajawal', sans-serif;
            font-weight: 800;
            font-size: 1.3rem;
            margin-bottom: 0.85rem;
            color: var(--text-dark);
        }

        .program-card p {
            color: #666;
            line-height: 1.85;
            margin: 0;
            font-size: 1rem;
        }

        .program-badges {
            margin-top: 1.25rem;
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 0.5rem;
        }

        .program-badge {
            padding: 0.35rem 0.9rem;
            border-radius: 20px;
            font-size: 0.82rem;
            font-weight: 600;
        }

        .badge-female { background: rgba(233, 30, 99, 0.1); color: #e91e63; }
        .badge-male { background: rgba(33, 150, 243, 0.1); color: #2196f3; }
        .badge-morning { background: rgba(255, 193, 7, 0.15); color: #f57c00; }
        .badge-evening { background: rgba(103, 58, 183, 0.1); color: #673ab7; }

        .bg-gradient-dour { background: linear-gradient(135deg, #667eea, #764ba2); }
        .bg-gradient-markaz { background: linear-gradient(135deg, #f093fb, #f5576c); }
        .bg-gradient-riyaheen-boys { background: linear-gradient(135deg, #4facfe, #00f2fe); }
        .bg-gradient-riyaheen-girls { background: linear-gradient(135deg, #43e97b, #38f9d7); }

        /* ===== FEATURE CARDS ===== */
        .feature-card {
            background: white;
            border-radius: 22px;
            padding: 2.5rem 1.75rem;
            text-align: center;
            box-shadow: 0 10px 40px rgba(0,0,0,0.07);
            border: 1px solid rgba(0,0,0,0.05);
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            height: 100%;
            position: relative;
            overflow: hidden;
        }

        .feature-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--primary-green), var(--accent-gold), var(--light-green));
            transform: scaleX(0);
            transition: transform 0.4s;
        }

        .feature-card:hover::before { transform: scaleX(1); }

        .feature-card:hover {
            transform: translateY(-12px);
            box-shadow: 0 25px 60px rgba(15, 60, 31, 0.14);
            border-color: var(--accent-gold);
        }

        .feature-icon {
            width: 85px;
            height: 85px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.75rem;
            font-size: 2.2rem;
            color: white;
            position: relative;
            transition: all 0.4s;
        }

        .feature-icon::after {
            content: '';
            position: absolute;
            inset: -5px;
            border-radius: 50%;
            border: 2px dashed var(--accent-gold);
            opacity: 0;
            transition: all 0.4s;
            animation: spin 10s linear infinite paused;
        }

        .feature-card:hover .feature-icon::after {
            opacity: 1;
            animation-play-state: running;
        }

        .feature-card:hover .feature-icon { transform: scale(1.08) rotate(5deg); }

        .feature-card h5 {
            font-family: 'Tajawal', sans-serif;
            font-weight: 800;
            font-size: 1.3rem;
            margin-bottom: 0.85rem;
            color: var(--text-dark);
        }

        .feature-card p {
            color: #666;
            line-height: 1.85;
            margin: 0;
            font-size: 1rem;
        }

        .bg-gradient-1 { background: linear-gradient(135deg, #0f3c1f, #1a5c30); }
        .bg-gradient-2 { background: linear-gradient(135deg, #1a5c30, #2d7a45); }
        .bg-gradient-3 { background: linear-gradient(135deg, #2d7a45, #3d9956); }
        .bg-gradient-4 { background: linear-gradient(135deg, #c9a96e, #b8956a); }
        .bg-gradient-5 { background: linear-gradient(135deg, #e74c3c, #c0392b); }
        .bg-gradient-6 { background: linear-gradient(135deg, #34495e, #2c3e50); }

        /* ===== STATS SECTION ===== */
        .stats-section {
            background: linear-gradient(160deg, var(--primary-green) 0%, var(--secondary-green) 100%);
            padding: 100px 0;
            position: relative;
            overflow: hidden;
        }

        .stats-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 80px;
            background: var(--warm-white);
            clip-path: ellipse(75% 100% at 50% 0%);
        }

        .stats-section::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 80px;
            background: var(--warm-white);
            clip-path: ellipse(75% 100% at 50% 100%);
        }

        .stats-bg-pattern {
            position: absolute;
            inset: 0;
            background-image: 
                radial-gradient(circle at 10% 20%, rgba(201, 169, 110, 0.1) 0%, transparent 30%),
                radial-gradient(circle at 90% 80%, rgba(201, 169, 110, 0.1) 0%, transparent 30%);
        }

        .stat-box {
            text-align: center;
            padding: 2rem 1.5rem;
            position: relative;
            z-index: 2;
        }

        .stat-icon {
            font-size: 2.2rem;
            color: var(--accent-gold);
            margin-bottom: 0.75rem;
            opacity: 0.8;
        }

        .stat-number {
            font-family: 'Cairo', sans-serif;
            font-size: 4rem;
            font-weight: 900;
            background: linear-gradient(180deg, var(--accent-gold), var(--light-gold));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            line-height: 1;
            margin-bottom: 0.5rem;
        }

        .stat-label {
            font-size: 1.1rem;
            font-weight: 700;
            color: white;
        }

        /* ===== ABOUT SECTION ===== */
        .about-content p {
            font-size: 1.1rem;
            color: #555;
            line-height: 2.1;
            margin-bottom: 1.75rem;
        }

        .about-list {
            list-style: none;
            padding: 0;
        }

        .about-list li {
            padding: 0.85rem 0;
            padding-right: 2.5rem;
            position: relative;
            font-size: 1.05rem;
            color: #444;
            border-bottom: 1px solid rgba(0,0,0,0.05);
            transition: all 0.3s;
        }

        .about-list li:hover {
            padding-right: 3rem;
            color: var(--primary-green);
        }

        .about-list li::before {
            content: '\f00c';
            font-family: 'Font Awesome 6 Free';
            font-weight: 900;
            position: absolute;
            right: 0;
            color: var(--accent-gold);
            font-size: 1.1rem;
        }

        .about-card {
            background: linear-gradient(160deg, var(--primary-green), var(--secondary-green));
            border-radius: 28px;
            padding: 3rem 2.5rem;
            text-align: center;
            color: white;
            position: relative;
            overflow: hidden;
            box-shadow: 0 20px 50px rgba(15, 60, 31, 0.3);
        }

        .about-card::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 100%;
            height: 100%;
            background: radial-gradient(circle, rgba(201, 169, 110, 0.2) 0%, transparent 60%);
            animation: pulse 4s ease-in-out infinite;
        }

        .about-card-logo {
            width: 90px;
            height: 90px;
            margin-bottom: 1.75rem;
            filter: brightness(0) invert(1);
            position: relative;
            z-index: 2;
        }

        .about-card h4 {
            font-family: 'Tajawal', sans-serif;
            font-weight: 800;
            font-size: 1.6rem;
            margin-bottom: 0.85rem;
            position: relative;
            z-index: 2;
        }

        .about-card p { position: relative; z-index: 2; }

        .about-card .values {
            color: var(--accent-gold);
            font-weight: 700;
            font-size: 1.1rem;
        }

        /* ===== FOOTER ===== */
        .footer-section {
            background: linear-gradient(160deg, #0a1f12, var(--primary-green));
            color: white;
            padding: 80px 0 40px;
            position: relative;
        }

        .footer-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, var(--primary-green), var(--accent-gold), var(--primary-green));
        }

        .footer-logo {
            width: 70px;
            height: 70px;
            margin-bottom: 1.25rem;
            filter: brightness(0) invert(1);
        }

        .footer-title {
            font-family: 'Tajawal', sans-serif;
            font-weight: 800;
            font-size: 1.3rem;
            margin-bottom: 1.25rem;
            color: var(--accent-gold);
        }

        .footer-section p {
            opacity: 0.85;
            line-height: 1.9;
            font-size: 1rem;
        }

        .footer-links {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .footer-links li { margin-bottom: 0.85rem; }

        .footer-links a {
            color: rgba(255,255,255,0.85);
            text-decoration: none;
            transition: all 0.3s;
            display: inline-flex;
            align-items: center;
            gap: 12px;
            font-size: 1rem;
            padding: 6px 0;
        }

        .footer-links a:hover {
            color: var(--accent-gold);
            transform: translateX(-8px);
        }

        .footer-links a i {
            width: 34px;
            height: 34px;
            background: rgba(201, 169, 110, 0.1);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--accent-gold);
            transition: all 0.3s;
            flex-shrink: 0;
        }

        .footer-links a:hover i {
            background: var(--accent-gold);
            color: var(--primary-green);
        }

        .social-links {
            display: flex;
            gap: 12px;
            margin-top: 1.75rem;
            flex-wrap: wrap;
        }

        .social-links a {
            width: 48px;
            height: 48px;
            background: rgba(201, 169, 110, 0.1);
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--accent-gold);
            font-size: 1.2rem;
            transition: all 0.4s;
            border: 1px solid rgba(201, 169, 110, 0.2);
        }

        .social-links a:hover {
            background: var(--accent-gold);
            color: var(--primary-green);
            transform: translateY(-6px);
        }

        .footer-bottom {
            border-top: 1px solid rgba(255,255,255,0.1);
            margin-top: 3.5rem;
            padding-top: 1.75rem;
            text-align: center;
        }

        .footer-bottom p {
            margin-bottom: 0.5rem;
            opacity: 0.7;
        }

        /* ===== SCROLL TOP ===== */
        .scroll-top {
            position: fixed;
            bottom: 24px;
            left: 24px;
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, var(--primary-green), var(--secondary-green));
            border: none;
            border-radius: 50%;
            color: white;
            font-size: 1.2rem;
            cursor: pointer;
            opacity: 0;
            visibility: hidden;
            transition: all 0.4s;
            box-shadow: 0 6px 20px rgba(15, 60, 31, 0.3);
            z-index: 1000;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .scroll-top.visible {
            opacity: 1;
            visibility: visible;
        }

        .scroll-top:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 30px rgba(15, 60, 31, 0.4);
        }

        /* ===== RESPONSIVE - TABLET ===== */
        @media (max-width: 992px) {
            .hero-title { font-size: 2.4rem; }
            .hero-subtitle { font-size: 1.2rem; }
            .hero-logo { width: 110px; height: 110px; }
            .stat-number { font-size: 3rem; }
            .section-title { font-size: 2.2rem; }
        }

        /* ===== RESPONSIVE - MOBILE ===== */
        @media (max-width: 768px) {

            /* ---- Critical fix: prevent any horizontal overflow ---- */
            .hero-section,
            .programs-section,
            .features-section,
            .stats-section,
            .about-section,
            .footer-section {
                width: 100% !important;
                max-width: 100% !important;
                overflow-x: hidden !important;
            }

            /* ---- Navbar ---- */
            .navbar-brand { font-size: 1rem; gap: 8px; }
            .navbar-logo { width: 38px; height: 38px; }

            /* ---- Hero ---- */
            .hero-section {
                padding: 100px 0 75px;
            }

            .hero-section::after {
                height: 50px;
                clip-path: ellipse(60% 100% at 50% 100%);
            }

            .hero-content {
                padding: 0 8px;
            }

            .hero-logo {
                width: 95px;
                height: 95px;
                margin-bottom: 1.25rem;
                animation: none; /* prevent jitter */
            }

            .hero-title {
                font-size: 1.75rem;
                letter-spacing: 0;
                margin-bottom: 0.6rem;
                padding: 0 4px;
            }

            .hero-subtitle {
                font-size: 1rem;
                margin-bottom: 1rem;
            }

            .hero-desc {
                font-size: 0.92rem;
                margin-bottom: 1.75rem;
                line-height: 1.85;
                padding: 0 4px;
            }

            .hero-buttons {
                flex-direction: column;
                align-items: center;
                gap: 0.75rem;
            }

            .btn-hero {
                width: 90%;
                max-width: 300px;
                padding: 14px 28px;
                font-size: 0.98rem;
            }

            /* ---- Sections ---- */
            .programs-section,
            .features-section,
            .stats-section,
            .about-section { padding: 60px 0; }

            .section-title { font-size: 1.75rem; }
            .section-header { margin-bottom: 2.25rem; }
            .section-subtitle { font-size: 1rem; }

            /* ---- Cards ---- */
            .program-card,
            .feature-card {
                padding: 1.75rem 1.4rem;
                border-radius: 18px;
            }

            .program-icon,
            .feature-icon {
                width: 72px;
                height: 72px;
                font-size: 1.75rem;
                margin-bottom: 1.25rem;
            }

            .program-card h5,
            .feature-card h5 { font-size: 1.15rem; }

            .program-card p,
            .feature-card p { font-size: 0.93rem; }

            /* ---- Stats ---- */
            .stat-number { font-size: 2.6rem; }
            .stat-label { font-size: 0.95rem; }
            .stat-box { padding: 1.5rem 0.75rem; }
            .stat-icon { font-size: 1.9rem; }

            /* ---- About ---- */
            .about-content p { font-size: 1rem; }
            .about-list li { font-size: 0.97rem; padding-right: 2.2rem; }

            .about-card {
                margin-top: 2rem;
                padding: 2rem 1.5rem;
                border-radius: 20px;
            }

            .about-card-logo { width: 72px; height: 72px; }
            .about-card h4 { font-size: 1.35rem; }
            .about-card .values { font-size: 1rem; }

            /* ---- Footer ---- */
            .footer-section { padding: 55px 0 30px; }
            .footer-title { font-size: 1.15rem; }
            .footer-links a { font-size: 0.95rem; }

            /* ---- Scroll top ---- */
            .scroll-top { bottom: 18px; left: 18px; width: 46px; height: 46px; font-size: 1.1rem; }
        }

        /* ===== RESPONSIVE - SMALL MOBILE (≤480px) ===== */
        @media (max-width: 480px) {
            .hero-title { font-size: 1.55rem; }
            .hero-subtitle { font-size: 0.95rem; }
            .section-title { font-size: 1.55rem; }
            .section-badge { font-size: 0.8rem; padding: 6px 16px; }
            .stat-number { font-size: 2.2rem; }
            .social-links a { width: 42px; height: 42px; font-size: 1.05rem; }
        }

        /* ===== CRITICAL: RTL + Bootstrap mobile overflow fix ===== */
        @media (max-width: 768px) {
            .container {
                padding-right: 16px !important;
                padding-left: 16px !important;
                max-width: 100% !important;
                width: 100% !important;
            }

            section {
                width: 100% !important;
                max-width: 100vw !important;
                overflow-x: hidden !important;
            }

            /* RTL text overflow fix */
            .hero-title,
            .hero-subtitle,
            .hero-desc {
                width: 100%;
                max-width: 100%;
                word-break: break-word;
                overflow-wrap: break-word;
                white-space: normal;
            }

            /* Navbar brand truncate on tiny screens */
            .navbar-brand {
                max-width: calc(100vw - 90px);
                white-space: nowrap;
                overflow: hidden;
            }
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container">
            <a class="navbar-brand" href="#">
                <img src="<?php echo e(asset('images/logo.png')); ?>" alt="الشعار" class="navbar-logo">
                جمعية القرآن الكريم بالزلفي
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="القائمة">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#programs">برامجنا</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#services">خدماتنا</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#about">عن الجمعية</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#contact">تواصل معنا</a>
                    </li>
                </ul>
                
                <div class="navbar-nav navbar-cta gap-2">
                    <a class="nav-link btn-admin" href="<?php echo e(route('student.login')); ?>">
                        <i class="fas fa-sign-in-alt me-1"></i> دخول
                    </a>
                    <a class="nav-link btn-admin" href="<?php echo e(route('admin.login')); ?>">
                        <i class="fas fa-user-shield me-1"></i> الإدارة
                    </a>
                    <a class="nav-link btn-register" href="<?php echo e(route('student.register')); ?>">
                        <i class="fas fa-user-plus me-1"></i> سجّل الآن
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section text-center">
        <div class="hero-particles">
            <div class="particle"></div>
            <div class="particle"></div>
            <div class="particle"></div>
            <div class="particle"></div>
            <div class="particle"></div>
        </div>
        
        <div class="container">
            <div class="hero-content">
                <img src="<?php echo e(asset('images/logo.png')); ?>" alt="شعار الجمعية" class="hero-logo" data-aos="zoom-in" data-aos-duration="900">
                
                <h1 class="hero-title" data-aos="fade-up" data-aos-delay="200">جمعية القرآن الكريم بالزلفي</h1>
                
                <p class="hero-subtitle" data-aos="fade-up" data-aos-delay="350">نظام إدارة النقل التعليمي</p>
                
                <p class="hero-desc" data-aos="fade-up" data-aos-delay="500">
                    نوفر خدمة نقل آمنة ومريحة لطلاب وطالبات دور تحفيظ القرآن الكريم
                    ومركز إعداد المعلمات وبرامج الرياحين
                    مع نظام إداري متطور لتسهيل عملية التسجيل والمتابعة
                </p>
                
                <div class="hero-buttons" data-aos="fade-up" data-aos-delay="650">
                    <a href="<?php echo e(route('student.register')); ?>" class="btn btn-hero btn-hero-primary">
                        <i class="fas fa-user-plus"></i> تسجيل جديد
                    </a>
                    <a href="<?php echo e(route('student.login')); ?>" class="btn btn-hero btn-hero-outline">
                        <i class="fas fa-sign-in-alt"></i> دخول
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Programs Section -->
    <section id="programs" class="programs-section">
        <div class="container">
            <div class="section-header" data-aos="fade-up">
                <span class="section-badge">اختر برنامجك</span>
                <h2 class="section-title">برامجنا التعليمية</h2>
                <p class="section-subtitle">نقدم خدمات النقل لمختلف البرامج التعليمية في الجمعية</p>
            </div>
            
            <?php
                $activeDour = \App\Models\Center::where('type', 'دار')->where('status', 'active')->count();
                $activeMarkaz = \App\Models\Center::where('type', 'مركز')->where('status', 'active')->count();
                $activeRiyaheenBoys = \App\Models\Center::where('type', 'برنامج')->where('gender', 'بنين')->where('status', 'active')->count();
                $activeRiyaheenGirls = \App\Models\Center::where('type', 'برنامج')->where('gender', 'بنات')->where('status', 'active')->count();
            ?>
            
            <div class="row g-4">
                <?php if($activeDour > 0): ?>
                <div class="col-sm-6 col-lg-6" data-aos="fade-up" data-aos-delay="100">
                    <a href="<?php echo e(route('student.register.form', ['type' => 'دار', 'gender' => 'بنات'])); ?>" class="program-card">
                        <div class="program-icon bg-gradient-dour">
                            <i class="fas fa-mosque"></i>
                        </div>
                        <h5>دور تحفيظ القرآن الكريم</h5>
                        <p>حفظ كتاب الله وتعلم التلاوة الصحيحة في بيئة إيمانية متميزة مع معلمات متخصصات - <?php echo e($activeDour); ?> دار متاحة</p>
                        <div class="program-badges">
                            <span class="program-badge badge-female"><i class="fas fa-female me-1"></i> بنات</span>
                            <span class="program-badge badge-morning"><i class="fas fa-sun me-1"></i> صباحية</span>
                            <span class="program-badge badge-evening"><i class="fas fa-moon me-1"></i> مسائية</span>
                        </div>
                    </a>
                </div>
                <?php endif; ?>

                <?php if($activeMarkaz > 0): ?>
                <div class="col-sm-6 col-lg-6" data-aos="fade-up" data-aos-delay="200">
                    <a href="<?php echo e(route('student.register.form', ['type' => 'مركز', 'gender' => 'بنات'])); ?>" class="program-card">
                        <div class="program-icon bg-gradient-markaz">
                            <i class="fas fa-graduation-cap"></i>
                        </div>
                        <h5>مركز إعداد المعلمات</h5>
                        <p>برنامج متخصص لإعداد معلمات القرآن الكريم المؤهلات - مركز الشيخ فوزان الفهد رحمه الله</p>
                        <div class="program-badges">
                            <span class="program-badge badge-female"><i class="fas fa-female me-1"></i> بنات</span>
                            <span class="program-badge badge-morning"><i class="fas fa-sun me-1"></i> صباحية فقط</span>
                        </div>
                    </a>
                </div>
                <?php endif; ?>

                <?php if($activeRiyaheenBoys > 0): ?>
                <div class="col-sm-6 col-lg-6" data-aos="fade-up" data-aos-delay="300">
                    <a href="<?php echo e(route('student.register.form', ['type' => 'برنامج', 'gender' => 'بنين'])); ?>" class="program-card">
                        <div class="program-icon bg-gradient-riyaheen-boys">
                            <i class="fas fa-child"></i>
                        </div>
                        <h5>برنامج الرياحين - بنين</h5>
                        <p>برنامج تربوي وتعليمي للأطفال لغرس حب القرآن الكريم في نفوسهم منذ الصغر - <?php echo e($activeRiyaheenBoys); ?> برنامج متاح</p>
                        <div class="program-badges">
                            <span class="program-badge badge-male"><i class="fas fa-male me-1"></i> بنين</span>
                            <span class="program-badge badge-evening"><i class="fas fa-moon me-1"></i> مسائية فقط</span>
                        </div>
                    </a>
                </div>
                <?php endif; ?>

                <?php if($activeRiyaheenGirls > 0): ?>
                <div class="col-sm-6 col-lg-6" data-aos="fade-up" data-aos-delay="400">
                    <a href="<?php echo e(route('student.register.form', ['type' => 'برنامج', 'gender' => 'بنات'])); ?>" class="program-card">
                        <div class="program-icon bg-gradient-riyaheen-girls">
                            <i class="fas fa-child"></i>
                        </div>
                        <h5>برنامج الرياحين - بنات</h5>
                        <p>برنامج تربوي وتعليمي للطفلات لغرس حب القرآن الكريم في نفوسهن منذ الصغر - <?php echo e($activeRiyaheenGirls); ?> برنامج متاح</p>
                        <div class="program-badges">
                            <span class="program-badge badge-female"><i class="fas fa-female me-1"></i> بنات</span>
                            <span class="program-badge badge-evening"><i class="fas fa-moon me-1"></i> مسائية فقط</span>
                        </div>
                    </a>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="services" class="features-section">
        <div class="container">
            <div class="section-header" data-aos="fade-up">
                <span class="section-badge">ماذا نقدم</span>
                <h2 class="section-title">خدماتنا</h2>
                <p class="section-subtitle">نقدم خدمات شاملة ومتطورة لإدارة النقل التعليمي</p>
            </div>
            
            <div class="row g-4">
                <div class="col-sm-6 col-lg-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="feature-card">
                        <div class="feature-icon bg-gradient-1">
                            <i class="fas fa-user-graduate"></i>
                        </div>
                        <h5>تسجيل إلكتروني</h5>
                        <p>نظام تسجيل إلكتروني سهل وسريع مع إمكانية متابعة حالة الطلب</p>
                    </div>
                </div>
                
                <div class="col-sm-6 col-lg-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="feature-card">
                        <div class="feature-icon bg-gradient-2">
                            <i class="fas fa-bus"></i>
                        </div>
                        <h5>إدارة المواصلات</h5>
                        <p>تخصيص الباصات المناسبة وتحديد نقاط الالتقاء وأوقات المواصلات</p>
                    </div>
                </div>
                
                <div class="col-sm-6 col-lg-4" data-aos="fade-up" data-aos-delay="300">
                    <div class="feature-card">
                        <div class="feature-icon bg-gradient-3">
                            <i class="fas fa-map-marked-alt"></i>
                        </div>
                        <h5>تحديد الموقع</h5>
                        <p>اختيار الجهة المناسبة بناءً على الموقع الجغرافي والفترة المفضلة</p>
                    </div>
                </div>
                
                <div class="col-sm-6 col-lg-4" data-aos="fade-up" data-aos-delay="400">
                    <div class="feature-card">
                        <div class="feature-icon bg-gradient-4">
                            <i class="fas fa-money-bill-wave"></i>
                        </div>
                        <h5>إدارة الدفعات</h5>
                        <p>نظام دفعات إلكتروني آمن مع إمكانية متابعة المدفوعات والإيصالات</p>
                    </div>
                </div>
                
                <div class="col-sm-6 col-lg-4" data-aos="fade-up" data-aos-delay="500">
                    <div class="feature-card">
                        <div class="feature-icon bg-gradient-5">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <h5>الأمان والسلامة</h5>
                        <p>باصات آمنة ومجهزة مع سائقين مؤهلين ومدربين على أعلى مستوى</p>
                    </div>
                </div>
                
                <div class="col-sm-6 col-lg-4" data-aos="fade-up" data-aos-delay="600">
                    <div class="feature-card">
                        <div class="feature-icon bg-gradient-6">
                            <i class="fas fa-headset"></i>
                        </div>
                        <h5>الدعم الفني</h5>
                        <p>فريق دعم متخصص للمساعدة في حل أي استفسارات أو مشاكل تقنية</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="stats-section">
        <div class="stats-bg-pattern"></div>
        <div class="container">
            <?php
                $stats = [
                    'centers_count' => \App\Models\Center::where('status', 'active')->count(),
                    'students_count' => \App\Models\Student::where('status', 'approved')->count(),
                    'buses_count' => \App\Models\Bus::where('status', 'active')->count(),
                    'drivers_count' => \App\Models\Driver::where('status', 'active')->count(),
                ];
            ?>
            <div class="row">
                <div class="col-6 col-lg-3" data-aos="zoom-in" data-aos-delay="100">
                    <div class="stat-box">
                        <div class="stat-icon"><i class="fas fa-school"></i></div>
                        <div class="stat-number" data-target="<?php echo e($stats['centers_count']); ?>"><?php echo e($stats['centers_count']); ?></div>
                        <div class="stat-label">جهة تعليمية</div>
                    </div>
                </div>
                <div class="col-6 col-lg-3" data-aos="zoom-in" data-aos-delay="200">
                    <div class="stat-box">
                        <div class="stat-icon"><i class="fas fa-user-graduate"></i></div>
                        <div class="stat-number" data-target="<?php echo e($stats['students_count']); ?>"><?php echo e($stats['students_count']); ?></div>
                        <div class="stat-label">طالب وطالبة</div>
                    </div>
                </div>
                <div class="col-6 col-lg-3" data-aos="zoom-in" data-aos-delay="300">
                    <div class="stat-box">
                        <div class="stat-icon"><i class="fas fa-bus"></i></div>
                        <div class="stat-number" data-target="<?php echo e($stats['buses_count']); ?>"><?php echo e($stats['buses_count']); ?></div>
                        <div class="stat-label">حافلة نقل</div>
                    </div>
                </div>
                <div class="col-6 col-lg-3" data-aos="zoom-in" data-aos-delay="400">
                    <div class="stat-box">
                        <div class="stat-icon"><i class="fas fa-id-card"></i></div>
                        <div class="stat-number" data-target="<?php echo e($stats['drivers_count']); ?>"><?php echo e($stats['drivers_count']); ?></div>
                        <div class="stat-label">سائق مؤهل</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="about-section">
        <div class="container">
            <div class="section-header" data-aos="fade-up">
                <span class="section-badge">تعرف علينا</span>
                <h2 class="section-title">عن الجمعية</h2>
            </div>
            
            <div class="row align-items-center">
                <div class="col-lg-6" data-aos="fade-left" data-aos-delay="200">
                    <div class="about-content">
                        <p>
                            مؤسسة خيرية رائدة تهدف إلى خدمة كتاب الله الكريم
                            من خلال تعليم وتحفيظ القرآن للطلاب والطالبات في مدينة الزلفي ونواحيها.
                        </p>
                        
                        <h5 style="color: var(--primary-green); font-weight: 800; margin-bottom: 1.25rem; font-size: 1.2rem;">
                            <i class="fas fa-bullseye me-2" style="color: var(--accent-gold);"></i>
                            أهدافنا
                        </h5>
                        <ul class="about-list">
                            <li>تحفيظ القرآن الكريم وتعليم التلاوة الصحيحة</li>
                            <li>إعداد معلمات مؤهلات لتدريس القرآن الكريم</li>
                            <li>تأسيس الأطفال على حب القرآن من الصغر</li>
                            <li>توفير نقل آمن ومريح لجميع الطلاب والطالبات</li>
                            <li>خدمة المجتمع وأهالي الزلفي بأعلى مستويات الجودة</li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-6" data-aos="fade-right" data-aos-delay="400">
                    <div class="about-card">
                        <img src="<?php echo e(asset('images/logo.png')); ?>" alt="الشعار" class="about-card-logo">
                        <h4>رسالتنا</h4>
                        <p style="font-size: 1.1rem; margin-bottom: 1.75rem; line-height: 2;">
                            الريادة في تعليم القرآن الكريم والجودة في العمل المؤسسي
                        </p>
                        <h5 style="color: var(--accent-gold); margin-bottom: 0.85rem; font-size: 1.1rem;">قيمنا</h5>
                        <p class="values">الأمانة • القدوة • الشفافية • الإبداع • الاحترافية</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <section id="contact" class="footer-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 mb-4" data-aos="fade-up" data-aos-delay="100">
                    <img src="<?php echo e(asset('images/logo.png')); ?>" alt="الشعار" class="footer-logo">
                    <h5 class="footer-title">جمعية القرآن الكريم بالزلفي</h5>
                    <p>نوفر خدمات متكاملة لطلاب وطالبات برامج القرآن الكريم مع نظام مواصلات آمن ومنظم</p>
                    <div class="social-links">
                        <a href="https://x.com/quranzulfi?lang=ar" aria-label="تويتر"><i class="fab fa-twitter"></i></a>
                        <a href="https://www.instagram.com/quranzulfi/?hl=ar" aria-label="إنستغرام"><i class="fab fa-instagram"></i></a>
                        <a href="https://wa.me/966500511556" aria-label="واتساب"><i class="fab fa-whatsapp"></i></a>
                        <a href="https://www.snapchat.com/@quranzulfi" aria-label="سناب شات"><i class="fab fa-snapchat"></i></a>
                    </div>
                </div>
                
                <div class="col-lg-4 mb-4" data-aos="fade-up" data-aos-delay="200">
                    <h5 class="footer-title">روابط سريعة</h5>
                    <ul class="footer-links">
                        <li>
                            <a href="<?php echo e(route('student.register')); ?>">
                                <i class="fas fa-user-plus"></i>
                                <span>تسجيل جديد</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo e(route('student.login')); ?>">
                                <i class="fas fa-sign-in-alt"></i>
                                <span>دخول الطلاب</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo e(route('admin.login')); ?>">
                                <i class="fas fa-user-shield"></i>
                                <span>دخول الإدارة</span>
                            </a>
                        </li>
                    </ul>
                </div>
                
                <div class="col-lg-4 mb-4" data-aos="fade-up" data-aos-delay="300">
                    <h5 class="footer-title">تواصل معنا</h5>
                    <ul class="footer-links">
                        <li>
                            <a href="#">
                                <i class="fas fa-map-marker-alt"></i>
                                <span>محافظة الزلفي، منطقة الرياض</span>
                            </a>
                        </li>
                        <li>
                            <a href="tel:0500511556">
                                <i class="fas fa-phone"></i>
                                <span>0500511556</span>
                            </a>
                        </li>
                        <li>
                            <a href="/cdn-cgi/l/email-protection#a3ced4c2d1c7e3d2d98dccd1c48dd0c2">
                                <i class="fas fa-envelope"></i>
                                <span><span class="__cf_email__" data-cfemail="224f554350466253580c4d50450c5143">[email&#160;protected]</span></span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            
            <div class="footer-bottom">
                <p>© <?php echo e(date('Y')); ?> جمعية القرآن الكريم بالزلفي - جميع الحقوق محفوظة</p>
                <p class="mb-0">تم التطوير بواسطة جارالله الجارالله و محمد الطواله <i class="fas fa-heart" style="color: var(--accent-gold);"></i> لخدمة القرآن الكريم</p>
            </div>
        </div>
    </section>

    <!-- Scroll to Top Button -->
    <button class="scroll-top" id="scrollTop" aria-label="العودة للأعلى">
        <i class="fas fa-chevron-up"></i>
    </button>

    <script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    
    <script>
        // Initialize AOS
        AOS.init({
            duration: 750,
            easing: 'ease-out-cubic',
            once: true,
            offset: 40,
            // disable on mobile for performance
            disable: window.innerWidth < 480 ? 'mobile' : false
        });

        // Navbar scroll effect
        const navbar = document.querySelector('.navbar');
        window.addEventListener('scroll', () => {
            navbar.classList.toggle('scrolled', window.scrollY > 80);
        }, { passive: true });

        // Scroll to top button
        const scrollTopBtn = document.getElementById('scrollTop');
        window.addEventListener('scroll', () => {
            scrollTopBtn.classList.toggle('visible', window.scrollY > 400);
        }, { passive: true });

        scrollTopBtn.addEventListener('click', () => {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });

        // Smooth scroll for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                const href = this.getAttribute('href');
                if (href === '#') return;
                e.preventDefault();
                const target = document.querySelector(href);
                if (target) {
                    const offset = 75;
                    const targetPosition = target.getBoundingClientRect().top + window.pageYOffset - offset;
                    window.scrollTo({ top: targetPosition, behavior: 'smooth' });
                }
                // Close mobile menu
                const collapse = document.querySelector('.navbar-collapse');
                if (collapse && collapse.classList.contains('show')) {
                    const bsCollapse = bootstrap.Collapse.getInstance(collapse);
                    if (bsCollapse) bsCollapse.hide();
                }
            });
        });

        // Counter animation
        const counterObserver = new IntersectionObserver(entries => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const counter = entry.target;
                    const target = parseInt(counter.dataset.target);
                    if (!target) return;
                    const duration = 1800;
                    const step = target / (duration / 16);
                    let current = 0;
                    const updateCounter = () => {
                        current += step;
                        if (current < target) {
                            counter.textContent = Math.floor(current);
                            requestAnimationFrame(updateCounter);
                        } else {
                            counter.textContent = target;
                        }
                    };
                    updateCounter();
                    counterObserver.unobserve(counter);
                }
            });
        }, { threshold: 0.4 });

        document.querySelectorAll('.stat-number').forEach(el => counterObserver.observe(el));
    </script>
</body>
</html><?php /**PATH C:\xampp\htdocs\project-bus\resources\views/welcome.blade.php ENDPATH**/ ?>