<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تسجيل الدخول - جمعية القرآن الكريم للزلفي</title>
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

        .login-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(15px);
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            padding: 3rem;
            max-width: 450px;
            width: 100%;
        }

        .login-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .login-header .logo {
            width: 100px;
            height: 100px;
            background: linear-gradient(45deg, var(--accent), var(--accent-light));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
        }

        .login-header .logo i {
            font-size: 2.5rem;
            color: var(--primary-dark);
        }

        .login-header h2 {
            color: #fff;
            font-size: 1.5rem;
            margin-bottom: 0.5rem;
        }

        .login-header p {
            color: rgba(255, 255, 255, 0.7);
            font-size: 0.95rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            color: var(--accent-light);
            font-weight: 600;
            margin-bottom: 0.5rem;
            display: block;
        }

        .form-control {
            background: rgba(255, 255, 255, 0.15);
            border: 2px solid rgba(127, 176, 105, 0.3);
            border-radius: 10px;
            padding: 0.9rem 1rem;
            color: white;
            font-size: 1.1rem;
            text-align: center;
            letter-spacing: 2px;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            background: rgba(255, 255, 255, 0.2);
            border-color: var(--accent);
            color: white;
            box-shadow: 0 0 0 0.2rem rgba(127, 176, 105, 0.25);
        }

        .form-control::placeholder {
            color: rgba(255, 255, 255, 0.5);
            letter-spacing: normal;
        }

        .btn-login {
            background: linear-gradient(45deg, var(--accent), var(--accent-light));
            border: none;
            padding: 0.9rem 2rem;
            border-radius: 10px;
            color: var(--primary-dark);
            font-weight: bold;
            font-size: 1.1rem;
            width: 100%;
            transition: all 0.3s ease;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(127, 176, 105, 0.4);
            color: var(--primary-dark);
        }

        .alert {
            border-radius: 10px;
            backdrop-filter: blur(10px);
        }

        .alert-danger {
            background: rgba(220, 53, 69, 0.2);
            border: 1px solid rgba(220, 53, 69, 0.3);
            color: #ffb3b3;
        }

        .alert-success {
            background: rgba(40, 167, 69, 0.2);
            border: 1px solid rgba(40, 167, 69, 0.3);
            color: #90EE90;
        }

        .register-link {
            text-align: center;
            margin-top: 2rem;
            padding-top: 1.5rem;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }

        .register-link p {
            color: rgba(255, 255, 255, 0.7);
            margin-bottom: 0.5rem;
        }

        .register-link a {
            color: var(--accent);
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s;
        }

        .register-link a:hover {
            color: var(--accent-light);
            text-decoration: underline;
        }

        .back-link {
            display: block;
            text-align: center;
            margin-top: 1.5rem;
            color: rgba(255, 255, 255, 0.6);
            text-decoration: none;
            font-size: 0.9rem;
            transition: color 0.3s;
        }

        .back-link:hover {
            color: var(--accent);
        }

        .input-icon {
            position: relative;
        }

        .input-icon i {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--accent);
            font-size: 1.2rem;
        }

        .input-icon .form-control {
            padding-left: 3rem;
        }

        .help-text {
            font-size: 0.85rem;
            color: rgba(255, 255, 255, 0.6);
            margin-top: 0.5rem;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="login-card">
        <div class="login-header">
            <div class="logo">
                <i class="fas fa-quran"></i>
            </div>
            <h2>تسجيل الدخول</h2>
            <p>جمعية القرآن الكريم للزلفي - خدمة النقل</p>
        </div>

        <?php if(session('success')): ?>
            <div class="alert alert-success mb-4">
                <i class="fas fa-check-circle me-2"></i>
                <?php echo e(session('success')); ?>

            </div>
        <?php endif; ?>

        <?php if($errors->any()): ?>
            <div class="alert alert-danger mb-4">
                <i class="fas fa-exclamation-circle me-2"></i>
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php echo e($error); ?>

                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="<?php echo e(route('student.login.submit')); ?>">
            <?php echo csrf_field(); ?>

            <div class="form-group">
                <label for="national_id" class="form-label">
                    <i class="fas fa-id-card me-1"></i>
                    رقم الهوية
                </label>
                <div class="input-icon">
                    <input type="text" class="form-control" id="national_id" name="national_id" 
                           value="<?php echo e(old('national_id')); ?>" required autofocus maxlength="10"
                           placeholder="أدخل رقم الهوية" inputmode="numeric">
                    <i class="fas fa-id-card"></i>
                </div>
                <div class="help-text">
                    <i class="fas fa-info-circle me-1"></i>
                    أدخل رقم الهوية المكون من 10 أرقام
                </div>
            </div>

            <button type="submit" class="btn btn-login">
                <i class="fas fa-sign-in-alt me-2"></i>
                تسجيل الدخول
            </button>
        </form>

        <div class="register-link">
            <p>ليس لديك حساب؟</p>
            <a href="<?php echo e(route('student.register')); ?>">
                <i class="fas fa-user-plus me-1"></i>
                سجل الآن
            </a>
        </div>

        <a href="<?php echo e(route('home')); ?>" class="back-link">
            <i class="fas fa-arrow-right me-1"></i>
            العودة للصفحة الرئيسية
        </a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // السماح بالأرقام فقط في حقل الهوية
        document.getElementById('national_id').addEventListener('input', function() {
            this.value = this.value.replace(/\D/g, '').slice(0, 10);
        });
    </script>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\project-bus\resources\views/student/login.blade.php ENDPATH**/ ?>