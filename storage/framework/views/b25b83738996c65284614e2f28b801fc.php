

<?php $__env->startSection('title', 'الملف الشخصي'); ?>

<?php $__env->startSection('header'); ?>
<div>
    <h2 class="mb-1">
        <i class="fas fa-user-cog me-2"></i>
        الملف الشخصي
    </h2>
    <p class="text-light opacity-75 mb-0">إدارة معلوماتك الشخصية وإعدادات الحساب</p>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <!-- معلومات الملف الشخصي -->
    <div class="col-lg-4 mb-4">
        <div class="content-card text-center">
            <div class="mb-4">
                <div class="profile-avatar mx-auto">
                    <i class="fas fa-user"></i>
                </div>
            </div>
            
            <h4 class="mb-1"><?php echo e($admin->name ?? 'المدير'); ?></h4>
            <p class="text-muted mb-3"><?php echo e($admin->email ?? 'admin@example.com'); ?></p>
            
            <div class="d-flex justify-content-center gap-2 mb-4">
                <span class="badge bg-success">
                    <i class="fas fa-shield-alt me-1"></i>
                    <?php echo e($admin->role == 'super_admin' ? 'مدير عام' : 'مدير'); ?>

                </span>
                <span class="badge bg-info">
                    <i class="fas fa-check-circle me-1"></i>
                    نشط
                </span>
            </div>
            
            <!-- إحصائيات النشاط -->
            <div class="activity-stats">
                <div class="row text-center">
                    <div class="col-6 mb-3">
                        <div class="stat-box">
                            <i class="fas fa-sign-in-alt text-success"></i>
                            <h4 class="mb-0"><?php echo e($loginCount); ?></h4>
                            <small class="text-muted">مرات الدخول</small>
                        </div>
                    </div>
                    <div class="col-6 mb-3">
                        <div class="stat-box">
                            <i class="fas fa-clock text-info"></i>
                            <h4 class="mb-0"><?php echo e($activityHours); ?></h4>
                            <small class="text-muted">ساعات النشاط</small>
                        </div>
                    </div>
                    <div class="col-6 mb-3">
                        <div class="stat-box">
                            <i class="fas fa-check-circle text-success"></i>
                            <h4 class="mb-0"><?php echo e($approvedRequests); ?></h4>
                            <small class="text-muted">طلبات مقبولة</small>
                        </div>
                    </div>
                    <div class="col-6 mb-3">
                        <div class="stat-box">
                            <i class="fas fa-edit text-warning"></i>
                            <h4 class="mb-0"><?php echo e($modificationsCount); ?></h4>
                            <small class="text-muted">تعديلات</small>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="border-top pt-3 mt-3">
                <small class="text-muted">
                    <i class="fas fa-calendar me-1"></i>
                    آخر دخول: <?php echo e($lastLogin); ?>

                </small>
            </div>
        </div>

        <!-- سجل النشاط -->
        <?php if(isset($recentActivities) && $recentActivities->count() > 0): ?>
        <div class="content-card mt-4">
            <h5 class="mb-3">
                <i class="fas fa-history text-info me-2"></i>
                آخر الأنشطة
            </h5>
            
            <div class="activity-timeline">
                <?php $__currentLoopData = $recentActivities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $activity): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="activity-item">
                    <div class="activity-icon bg-<?php echo e($activity->action_color); ?>">
                        <i class="fas fa-<?php echo e($activity->action_icon); ?>"></i>
                    </div>
                    <div class="activity-content">
                        <p class="mb-0"><?php echo e($activity->action_label); ?></p>
                        <small class="text-muted"><?php echo e($activity->created_at->diffForHumans()); ?></small>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
        <?php endif; ?>
    </div>

    <!-- تحديث المعلومات الشخصية -->
    <div class="col-lg-8 mb-4">
        <div class="content-card mb-4">
            <h5 class="mb-4">
                <i class="fas fa-user-edit me-2 text-primary"></i>
                تحديث المعلومات الشخصية
            </h5>
            
            <form method="POST" action="<?php echo e(route('admin.profile.update')); ?>">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">الاسم الكامل *</label>
                        <input type="text" name="name" class="form-control" 
                               value="<?php echo e(old('name', $admin->name ?? '')); ?>" required>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label class="form-label">البريد الإلكتروني *</label>
                        <input type="email" name="email" class="form-control" 
                               value="<?php echo e(old('email', $admin->email ?? '')); ?>" required>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">رقم الجوال</label>
                        <input type="tel" name="phone" class="form-control" 
                               value="<?php echo e(old('phone', $admin->phone ?? '')); ?>" 
                               placeholder="05XXXXXXXX">
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label class="form-label">المسمى الوظيفي</label>
                        <input type="text" name="job_title" class="form-control" 
                               value="<?php echo e(old('job_title', $admin->job_title ?? '')); ?>" 
                               placeholder="مدير النظام">
                    </div>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">نبذة عنك</label>
                    <textarea name="bio" class="form-control" rows="3" 
                              placeholder="اكتب نبذة مختصرة عنك..."><?php echo e(old('bio', $admin->bio ?? '')); ?></textarea>
                </div>
                
                <div class="text-end">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i>
                        حفظ التغييرات
                    </button>
                </div>
            </form>
        </div>
        
        <!-- تغيير كلمة المرور -->
        <div class="content-card">
            <h5 class="mb-4">
                <i class="fas fa-lock me-2 text-warning"></i>
                تغيير كلمة المرور
            </h5>
            
            <form method="POST" action="<?php echo e(route('admin.password.change')); ?>">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>
                
                <div class="mb-3">
                    <label class="form-label">كلمة المرور الحالية *</label>
                    <input type="password" name="current_password" class="form-control" required>
                    <?php $__errorArgs = ['current_password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <small class="text-danger"><?php echo e($message); ?></small>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">كلمة المرور الجديدة *</label>
                        <input type="password" name="password" class="form-control" 
                               required minlength="6">
                        <small class="text-muted">6 أحرف على الأقل</small>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label class="form-label">تأكيد كلمة المرور *</label>
                        <input type="password" name="password_confirmation" class="form-control" required>
                    </div>
                </div>
                
                <div class="text-end">
                    <button type="submit" class="btn btn-warning">
                        <i class="fas fa-key me-1"></i>
                        تغيير كلمة المرور
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
<style>
    .profile-avatar {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        background: linear-gradient(135deg, #7fb069, #20c997);
        display: flex;
        align-items: center;
        justify-content: center;
        border: 4px solid rgba(127, 176, 105, 0.3);
    }
    
    .profile-avatar i {
        font-size: 4rem;
        color: white;
    }
    
    .activity-stats {
        background: rgba(0, 0, 0, 0.2);
        border-radius: 15px;
        padding: 1rem;
        margin-top: 1rem;
    }
    
    .stat-box {
        background: rgba(255, 255, 255, 0.05);
        border-radius: 10px;
        padding: 1rem 0.5rem;
    }
    
    .stat-box i {
        font-size: 1.5rem;
        margin-bottom: 0.5rem;
    }
    
    .stat-box h4 {
        font-size: 1.5rem;
        font-weight: 700;
    }
    
    .activity-timeline {
        position: relative;
    }
    
    .activity-item {
        display: flex;
        align-items: flex-start;
        padding: 0.75rem 0;
        border-bottom: 1px solid rgba(255, 255, 255, 0.05);
    }
    
    .activity-item:last-child {
        border-bottom: none;
    }
    
    .activity-icon {
        width: 35px;
        height: 35px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-left: 1rem;
        flex-shrink: 0;
    }
    
    .activity-icon i {
        font-size: 0.85rem;
        color: white;
    }
    
    .activity-content {
        flex: 1;
    }
    
    .activity-content p {
        font-size: 0.9rem;
    }
    
    .bg-success { background-color: rgba(40, 167, 69, 0.8) !important; }
    .bg-warning { background-color: rgba(255, 193, 7, 0.8) !important; }
    .bg-danger { background-color: rgba(220, 53, 69, 0.8) !important; }
    .bg-info { background-color: rgba(23, 162, 184, 0.8) !important; }
    .bg-primary { background-color: rgba(127, 176, 105, 0.8) !important; }
    .bg-secondary { background-color: rgba(108, 117, 125, 0.8) !important; }
</style>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/rasedbus/project-bus/resources/views/admin/profile.blade.php ENDPATH**/ ?>