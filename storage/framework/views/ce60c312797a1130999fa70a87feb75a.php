<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>دخول الإدارة - جمعية القرآن الكريم</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #1a4b3a 0%, #2d6b4f 50%, #1a4b3a 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .login-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(15px);
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.3);
            overflow: hidden;
        }
        .login-header {
            background: rgba(0, 0, 0, 0.2);
            padding: 2rem;
            text-align: center;
        }
        .login-header i { font-size: 3rem; color: #7fb069; margin-bottom: 1rem; }
        .login-header h4 { color: #fff; margin: 0; }
        .login-header p { color: rgba(255,255,255,0.7); margin: 0.5rem 0 0; }
        .login-body { padding: 2rem; }
        .form-control {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: white;
            border-radius: 10px;
            padding: 0.8rem 1rem;
        }
        .form-control:focus {
            background: rgba(255, 255, 255, 0.15);
            border-color: #7fb069;
            color: white;
            box-shadow: 0 0 0 0.2rem rgba(127, 176, 105, 0.25);
        }
        .form-control::placeholder { color: rgba(255,255,255,0.5); }
        .form-label { color: rgba(255,255,255,0.9); }
        .input-group-text {
            background: rgba(127, 176, 105, 0.3);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: #7fb069;
        }
        .btn-login {
            background: linear-gradient(45deg, #7fb069, #90c695);
            border: none;
            padding: 0.8rem;
            border-radius: 10px;
            color: #1a4b3a;
            font-weight: bold;
            transition: all 0.3s;
        }
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(127, 176, 105, 0.4);
            color: #1a4b3a;
        }
        .alert { border-radius: 10px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="login-card">
                    <div class="login-header">
                        <i class="fas fa-user-shield"></i>
                        <h4>لوحة تحكم الإدارة</h4>
                        <p>جمعية القرآن الكريم للزلفي</p>
                    </div>
                    
                    <div class="login-body">
                        <?php if(session('success')): ?>
                            <div class="alert alert-success"><?php echo session('success'); ?></div>
                        <?php endif; ?>
                        
                        <?php if(session('error')): ?>
                            <div class="alert alert-danger"><?php echo e(session('error')); ?></div>
                        <?php endif; ?>
                        
                        <?php if($errors->has('login_error')): ?>
                            <div class="alert alert-danger"><?php echo e($errors->first('login_error')); ?></div>
                        <?php endif; ?>
                        
                        <form method="POST" action="<?php echo e(route('admin.login.submit')); ?>">
                            <?php echo csrf_field(); ?>
                            
                            <div class="mb-3">
                                <label class="form-label">اسم المستخدم</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                                    <input type="text" class="form-control" name="username" 
                                           value="<?php echo e(old('username')); ?>" placeholder="admin" required>
                                </div>
                            </div>
                            
                            <div class="mb-4">
                                <label class="form-label">كلمة المرور</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                    <input type="password" class="form-control" name="password" 
                                           placeholder="••••••" required>
                                </div>
                            </div>
                            
                            <div class="d-grid">
                                <button type="submit" class="btn btn-login">
                                    <i class="fas fa-sign-in-alt me-2"></i>
                                    تسجيل الدخول
                                </button>
                            </div>
                        </form>
                        
                        <div class="text-center mt-4">
                            <a href="<?php echo e(url('/')); ?>" class="text-light text-decoration-none">
                                <i class="fas fa-home me-1"></i>
                                العودة للرئيسية
                            </a>
                        </div>
                    </div>
                </div>
                
        
            </div>
        </div>
    </div>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\project-bus\resources\views/admin/login.blade.php ENDPATH**/ ?>