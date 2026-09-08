<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'لوحة التحكم') - نظام النقل</title>
    
    <!-- Bootstrap RTL -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <!-- Google Fonts - Tajawal -->
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700&display=swap" rel="stylesheet">
    
    <style>
        /* ==========================================
           🎨 المتغيرات الأساسية
           ========================================== */
        :root {
            --primary-color: #7fb069;
            --primary-dark: #5a8a4a;
            --primary-light: rgba(127, 176, 105, 0.2);
            --bg-gradient: linear-gradient(135deg, #1a4b3a 0%, #2d6b4f 50%, #1a4b3a 100%);
            --bg-card: rgba(255, 255, 255, 0.05);
            --text-white: #ffffff;
            --text-light: #e0e0e0;
            --text-muted: rgba(255, 255, 255, 0.6);
            --border-color: rgba(127, 176, 105, 0.2);
            --sidebar-width: 280px;
        }

        /* ==========================================
           🎨 الإعدادات العامة
           ========================================== */
        * {
            font-family: 'Tajawal', sans-serif;
        }

        body {
            background: var(--bg-gradient);
            min-height: 100vh;
            color: var(--text-light);
        }

        /* ==========================================
           📱 الشريط الجانبي
           ========================================== */
        .sidebar {
            position: fixed;
            top: 0;
            right: 0;
            width: var(--sidebar-width);
            height: 100vh;
            background: rgba(0, 0, 0, 0.3);
            backdrop-filter: blur(10px);
            border-left: 1px solid var(--border-color);
            z-index: 1000;
            overflow-y: auto;
            transition: all 0.3s ease;
        }

        .sidebar-header {
            padding: 1.5rem;
            text-align: center;
            border-bottom: 1px solid var(--border-color);
        }

        .sidebar-logo {
            width: 60px;
            height: 60px;
            background: var(--primary-light);
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
        }

        .sidebar-logo i {
            font-size: 1.8rem;
            color: var(--primary-color);
        }

        .sidebar-title {
            color: var(--text-white);
            font-weight: 700;
            font-size: 1.1rem;
            margin-bottom: 0.25rem;
        }

        .sidebar-subtitle {
            color: var(--text-muted);
            font-size: 0.8rem;
        }

        /* قائمة التنقل */
        .nav-menu {
            padding: 1rem 0;
        }

        .nav-section {
            padding: 0.5rem 1.5rem;
            color: var(--text-muted);
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-top: 1rem;
        }

        .nav-item {
            padding: 0 1rem;
            margin-bottom: 0.25rem;
        }

        .nav-link {
            display: flex;
            align-items: center;
            padding: 0.8rem 1rem;
            color: var(--text-light) !important;
            border-radius: 10px;
            transition: all 0.3s ease;
            text-decoration: none;
        }

        .nav-link:hover {
            background: var(--primary-light);
            color: var(--text-white) !important;
        }

        .nav-link.active {
            background: var(--primary-color);
            color: var(--text-white) !important;
        }

        .nav-link i {
            width: 24px;
            margin-left: 0.75rem;
            font-size: 1.1rem;
        }

        .nav-badge {
            margin-right: auto;
            background: rgba(220, 53, 69, 0.8);
            color: white;
            padding: 0.2rem 0.5rem;
            border-radius: 10px;
            font-size: 0.7rem;
        }

        /* ==========================================
           📄 المحتوى الرئيسي
           ========================================== */
        .main-content {
            margin-right: var(--sidebar-width);
            min-height: 100vh;
            padding: 0;
        }

        /* الهيدر */
        .main-header {
            background: rgba(0, 0, 0, 0.2);
            padding: 1.5rem 2rem;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 2rem;
        }

        .header-title {
            flex: 1;
        }

        .header-title h1, .header-title h2 {
            color: var(--text-white) !important;
            margin-bottom: 0.25rem;
        }

        .header-actions {
            display: flex;
            gap: 0.75rem;
            flex-shrink: 0;
        }

        /* منطقة المحتوى */
        .content-area {
            padding: 2rem;
        }

        /* ==========================================
           🎴 البطاقات
           ========================================== */
        .content-card {
            background: var(--bg-card);
            border-radius: 15px;
            padding: 1.5rem;
            border: 1px solid var(--border-color);
            backdrop-filter: blur(10px);
            margin-bottom: 1.5rem;
        }

        .stats-card {
            background: var(--bg-card);
            border-radius: 15px;
            padding: 1.5rem;
            border: 1px solid var(--border-color);
            transition: all 0.3s ease;
            height: 100%;
        }

        .stats-card:hover {
            transform: translateY(-5px);
            border-color: var(--primary-color);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }

        .stats-icon {
            width: 60px;
            height: 60px;
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }

        .stats-number {
            font-size: 2rem;
            font-weight: 700;
            color: var(--text-white);
        }

        /* ==========================================
           📊 الجداول
           ========================================== */
        .table {
            color: var(--text-light) !important;
            background: transparent !important;
            margin-bottom: 0;
        }

        .table thead {
            background: var(--primary-light) !important;
        }

        .table thead th {
            color: var(--primary-color) !important;
            font-weight: 600 !important;
            border-bottom: 2px solid rgba(127, 176, 105, 0.3) !important;
            padding: 1rem 0.75rem !important;
            white-space: nowrap;
            background: transparent !important;
        }

        .table tbody tr {
            background: rgba(255, 255, 255, 0.02) !important;
            transition: all 0.3s ease;
        }

        .table tbody tr:nth-child(even) {
            background: rgba(255, 255, 255, 0.04) !important;
        }

        .table tbody tr:hover {
            background: rgba(127, 176, 105, 0.1) !important;
        }

        .table tbody td {
            color: var(--text-light) !important;
            border-color: rgba(255, 255, 255, 0.05) !important;
            padding: 1rem 0.75rem !important;
            vertical-align: middle !important;
            background: transparent !important;
        }

        .table-dark,
        .table-dark thead,
        .table-dark tbody,
        .table-dark tr,
        .table-dark td,
        .table-dark th {
            background: transparent !important;
            --bs-table-bg: transparent !important;
            --bs-table-color: var(--text-light) !important;
            color: var(--text-light) !important;
        }

        .table td .fw-bold,
        .table td strong,
        .table td a:not(.btn) {
            color: var(--primary-color) !important;
        }

        .table td .text-muted,
        .table td small {
            color: var(--text-muted) !important;
        }

        /* ==========================================
           🏷️ الشارات
           ========================================== */
        .badge {
            font-weight: 500 !important;
            padding: 0.5em 0.8em !important;
        }

        .badge.bg-success {
            background: rgba(40, 167, 69, 0.2) !important;
            color: #5dd879 !important;
            border: 1px solid rgba(40, 167, 69, 0.3);
        }

        .badge.bg-danger {
            background: rgba(220, 53, 69, 0.2) !important;
            color: #ff6b7a !important;
            border: 1px solid rgba(220, 53, 69, 0.3);
        }

        .badge.bg-warning {
            background: rgba(255, 193, 7, 0.2) !important;
            color: #ffd454 !important;
            border: 1px solid rgba(255, 193, 7, 0.3);
        }

        .badge.bg-info {
            background: rgba(23, 162, 184, 0.2) !important;
            color: #5dd3e8 !important;
            border: 1px solid rgba(23, 162, 184, 0.3);
        }

        .badge.bg-primary {
            background: rgba(127, 176, 105, 0.2) !important;
            color: #7fb069 !important;
            border: 1px solid rgba(127, 176, 105, 0.3);
        }

        .badge.bg-secondary {
            background: rgba(108, 117, 125, 0.2) !important;
            color: #adb5bd !important;
            border: 1px solid rgba(108, 117, 125, 0.3);
        }

        /* ==========================================
           🔘 الأزرار
           ========================================== */
        .btn-primary {
            background: var(--primary-color) !important;
            border-color: var(--primary-color) !important;
        }

        .btn-primary:hover {
            background: var(--primary-dark) !important;
            border-color: var(--primary-dark) !important;
        }

        .btn-outline-info {
            color: #5dd3e8 !important;
            border-color: rgba(23, 162, 184, 0.5) !important;
            background: rgba(23, 162, 184, 0.1) !important;
        }

        .btn-outline-info:hover {
            background: rgba(23, 162, 184, 0.3) !important;
            color: #fff !important;
        }

        .btn-outline-warning {
            color: #ffd454 !important;
            border-color: rgba(255, 193, 7, 0.5) !important;
            background: rgba(255, 193, 7, 0.1) !important;
        }

        .btn-outline-warning:hover {
            background: rgba(255, 193, 7, 0.3) !important;
            color: #fff !important;
        }

        .btn-outline-danger {
            color: #ff6b7a !important;
            border-color: rgba(220, 53, 69, 0.5) !important;
            background: rgba(220, 53, 69, 0.1) !important;
        }

        .btn-outline-danger:hover {
            background: rgba(220, 53, 69, 0.3) !important;
            color: #fff !important;
        }

        .btn-outline-success {
            color: #5dd879 !important;
            border-color: rgba(40, 167, 69, 0.5) !important;
            background: rgba(40, 167, 69, 0.1) !important;
        }

        .btn-outline-success:hover {
            background: rgba(40, 167, 69, 0.3) !important;
            color: #fff !important;
        }

        .btn-group .btn {
            border-radius: 8px !important;
            margin: 0 2px;
        }

        /* ==========================================
           📝 الحقول
           ========================================== */
        .form-control, .form-select {
            background: rgba(255, 255, 255, 0.08) !important;
            border: 1px solid var(--border-color) !important;
            color: var(--text-white) !important;
        }

        .form-control:focus, .form-select:focus {
            background: rgba(255, 255, 255, 0.12) !important;
            border-color: var(--primary-color) !important;
            box-shadow: 0 0 0 0.2rem rgba(127, 176, 105, 0.25) !important;
            color: var(--text-white) !important;
        }

        .form-control::placeholder {
            color: var(--text-muted) !important;
        }

        .form-label {
            color: var(--text-light) !important;
            font-weight: 500;
        }

        .form-select option {
            background: #1a4b3a;
            color: var(--text-white);
        }

        /* ==========================================
           📋 القوائم المنسدلة
           ========================================== */
        .dropdown-menu {
            background: rgba(30, 60, 45, 0.98) !important;
            border: 1px solid var(--border-color) !important;
            backdrop-filter: blur(10px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        }

        .dropdown-item {
            color: var(--text-light) !important;
            transition: all 0.2s ease;
            padding: 0.6rem 1rem;
        }

        .dropdown-item:hover {
            background: var(--primary-light) !important;
            color: var(--text-white) !important;
        }

        .dropdown-divider {
            border-color: rgba(255, 255, 255, 0.1) !important;
        }

        /* ==========================================
           ⚠️ التنبيهات
           ========================================== */
        .alert {
            border-radius: 10px;
            border: none;
        }

        .alert-success {
            background: rgba(40, 167, 69, 0.15) !important;
            color: #5dd879 !important;
            border: 1px solid rgba(40, 167, 69, 0.3) !important;
        }

        .alert-danger {
            background: rgba(220, 53, 69, 0.15) !important;
            color: #ff6b7a !important;
            border: 1px solid rgba(220, 53, 69, 0.3) !important;
        }

        .alert-warning {
            background: rgba(255, 193, 7, 0.15) !important;
            color: #ffd454 !important;
            border: 1px solid rgba(255, 193, 7, 0.3) !important;
        }

        .alert-info {
            background: rgba(23, 162, 184, 0.15) !important;
            color: #5dd3e8 !important;
            border: 1px solid rgba(23, 162, 184, 0.3) !important;
        }

        /* ==========================================
           📊 شريط التقدم
           ========================================== */
        .progress {
            background: rgba(255, 255, 255, 0.1) !important;
            border-radius: 10px;
            height: 8px;
            overflow: hidden;
        }

        .progress-bar {
            border-radius: 10px;
        }

        /* ==========================================
           📄 الصفحات
           ========================================== */
        .pagination .page-link {
            background: var(--bg-card) !important;
            border-color: var(--border-color) !important;
            color: var(--text-light) !important;
        }

        .pagination .page-link:hover {
            background: var(--primary-light) !important;
            color: var(--text-white) !important;
        }

        .pagination .page-item.active .page-link {
            background: var(--primary-color) !important;
            border-color: var(--primary-color) !important;
            color: var(--text-white) !important;
        }

        /* ==========================================
           🔗 النصوص والروابط
           ========================================== */
        .text-muted { color: var(--text-muted) !important; }
        .text-light { color: var(--text-light) !important; }
        .text-white { color: var(--text-white) !important; }
        .text-primary { color: var(--primary-color) !important; }
        .text-success { color: #5dd879 !important; }
        .text-danger { color: #ff6b7a !important; }
        .text-warning { color: #ffd454 !important; }
        .text-info { color: #5dd3e8 !important; }

        h1, h2, h3, h4, h5, h6 { color: var(--text-white) !important; }
        .fw-bold, strong, b { color: var(--text-white) !important; }

        a:not(.btn):not(.nav-link):not(.dropdown-item) {
            color: var(--primary-color);
            text-decoration: none;
        }

        a:not(.btn):not(.nav-link):not(.dropdown-item):hover {
            color: #90c695;
        }

        /* ==========================================
           🪟 Modal
           ========================================== */
        .modal-content {
            background: linear-gradient(135deg, #1a4b3a 0%, #2d6b4f 100%) !important;
            border: 1px solid var(--border-color) !important;
            color: var(--text-light);
        }

        .modal-header { border-bottom-color: rgba(255, 255, 255, 0.1) !important; }
        .modal-footer { border-top-color: rgba(255, 255, 255, 0.1) !important; }
        .modal-title { color: var(--text-white) !important; }
        .btn-close { filter: invert(1); }

        /* ==========================================
           📏 الحدود والفواصل
           ========================================== */
        .border, .border-top, .border-bottom, .border-start, .border-end,
        .border-secondary {
            border-color: rgba(255, 255, 255, 0.1) !important;
        }

        hr {
            border-color: rgba(255, 255, 255, 0.1) !important;
            opacity: 1;
        }

        /* ==========================================
           🧭 Breadcrumb
           ========================================== */
        .breadcrumb { background: transparent; }
        .breadcrumb-item a { color: var(--primary-color) !important; }
        .breadcrumb-item.active { color: var(--text-muted) !important; }
        .breadcrumb-item + .breadcrumb-item::before { color: var(--text-muted) !important; }

        /* ==========================================
           📱 التجاوب
           ========================================== */
        @media (max-width: 992px) {
            .sidebar {
                transform: translateX(100%);
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .main-content {
                margin-right: 0;
            }

            .mobile-toggle {
                display: block !important;
            }
        }

        .mobile-toggle {
            display: none;
            background: var(--primary-color);
            border: none;
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 8px;
        }

        /* ==========================================
           🎭 Section Title
           ========================================== */
        .section-title {
            color: var(--primary-color) !important;
            font-weight: bold;
            margin-bottom: 1rem;
            border-bottom: 2px solid rgba(127, 176, 105, 0.3);
            padding-bottom: 0.5rem;
        }

        .info-label { color: var(--text-muted) !important; font-size: 0.85rem; }
        .info-value { color: var(--text-white) !important; font-weight: 500; }

        /* Scrollbar */
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: rgba(0, 0, 0, 0.2); }
        ::-webkit-scrollbar-thumb { background: var(--primary-color); border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: var(--primary-dark); }
    </style>
    
    @stack('styles')
</head>
<body>
    <!-- الشريط الجانبي -->
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <div class="sidebar-logo">
                <i class="fas fa-bus"></i>
            </div>
            <div class="sidebar-title">نظام النقل </div>
            <div class="sidebar-subtitle">جمعية تحفيظ القرآن - الزلفي</div>
        </div>

        <nav class="nav-menu">
            <div class="nav-section">الرئيسية</div>
            <div class="nav-item">
                <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-home"></i>
                    <span>لوحة التحكم</span>
                </a>
            </div>

            <div class="nav-section">الإدارة</div>
            <div class="nav-item">
                <a href="{{ route('admin.students.index') }}" class="nav-link {{ request()->routeIs('admin.students.*') ? 'active' : '' }}">
                    <i class="fas fa-user-graduate"></i>
                    <span>الطالبات</span>
                    @php
                        $pendingCount = \App\Models\Student::where('status', 'pending')->count();
                    @endphp
                    @if($pendingCount > 0)
                        <span class="nav-badge">{{ $pendingCount }}</span>
                    @endif
                </a>
            </div>
            <div class="nav-item">
                <a href="{{ route('admin.buses.index') }}" class="nav-link {{ request()->routeIs('admin.buses.*') ? 'active' : '' }}">
                    <i class="fas fa-bus"></i>
                    <span>الباصات</span>
                </a>
            </div>
            <div class="nav-item">
                <a href="{{ route('admin.drivers.index') }}" class="nav-link {{ request()->routeIs('admin.drivers.*') ? 'active' : '' }}">
                    <i class="fas fa-id-card"></i>
                    <span>السائقون</span>
                </a>
            </div>
            <div class="nav-item">
                <a href="{{ route('admin.centers.index') }}" class="nav-link {{ request()->routeIs('admin.centers.*') ? 'active' : '' }}">
                    <i class="fas fa-school"></i>
                    <span> الجهات التعليمية</span>
                </a>
            </div>

            <div class="nav-section">المالية</div>
            <div class="nav-item">
                <a href="{{ route('admin.payments.index') }}" class="nav-link {{ request()->routeIs('admin.payments.*') ? 'active' : '' }}">
                    <i class="fas fa-money-bill-wave"></i>
                    <span>الدفعات</span>
                </a>
            </div>

            <div class="nav-section">النظام</div>
            <div class="nav-item">
    <a href="{{ route('admin.reports') }}" class="nav-link {{ request()->routeIs('admin.reports') ? 'active' : '' }}">
        <i class="fas fa-chart-bar"></i>
        <span>التقارير</span>
    </a>
</div>

{{-- إدارة الموظفين - للمطور والمدير العام فقط --}}
@php
    $currentAdmin = \App\Models\Admin::find(session('admin_id'));
@endphp
@if($currentAdmin && in_array($currentAdmin->role, ['developer', 'super_admin']))
<div class="nav-item">
    <a href="{{ route('admin.admins.index') }}" class="nav-link {{ request()->routeIs('admin.admins.*') ? 'active' : '' }}">
        <i class="fas fa-users-cog"></i>
        <span>إدارة الموظفين</span>
    </a>
</div>
@endif

<div class="nav-item">
    <a href="{{ route('admin.profile') }}" class="nav-link {{ request()->routeIs('admin.profile') ? 'active' : '' }}">
                    <i class="fas fa-user-cog"></i>
                    <span>الملف الشخصي</span>
                </a>
            </div>
            <div class="nav-item">
                <form action="{{ route('admin.logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="nav-link w-100 border-0 text-start" style="background: transparent;">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>تسجيل الخروج</span>
                    </button>
                </form>
            </div>
        </nav>
    </aside>

    <!-- المحتوى الرئيسي -->
    <main class="main-content">
        <!-- الهيدر -->
        <header class="main-header">
            <div class="header-title">
                @yield('header')
            </div>
            <div class="d-flex align-items-center gap-3">
                <button class="mobile-toggle" onclick="toggleSidebar()">
                    <i class="fas fa-bars"></i>
                </button>
            </div>
        </header>

        <!-- منطقة المحتوى -->
        <div class="content-area">
            <!-- رسائل النجاح والخطأ -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @yield('content')
        </div>
    </main>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('show');
        }

        // إغلاق الشريط الجانبي عند النقر خارجه في الجوال
        document.addEventListener('click', function(e) {
            const sidebar = document.getElementById('sidebar');
            const toggleBtn = document.querySelector('.mobile-toggle');
            
            if (window.innerWidth <= 992) {
                if (!sidebar.contains(e.target) && !toggleBtn.contains(e.target)) {
                    sidebar.classList.remove('show');
                }
            }
        });
    </script>
    
    @stack('scripts')
</body>
</html>