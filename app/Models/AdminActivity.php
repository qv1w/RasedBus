<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminActivity extends Model
{
    protected $fillable = [
        'admin_id',
        'action',
        'description',
        'model_type',
        'model_id',
        'ip_address',
    ];

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }

    // دالة مساعدة لتسجيل النشاط
    public static function log($action, $description = null, $model = null)
    {
        $adminId = session('admin_id');
        
        if (!$adminId) {
            return null;
        }

        return self::create([
            'admin_id' => $adminId,
            'action' => $action,
            'description' => $description,
            'model_type' => $model ? get_class($model) : null,
            'model_id' => $model ? $model->id : null,
            'ip_address' => request()->ip(),
        ]);
    }

    // الحصول على وصف النشاط بالعربي
    public function getActionLabelAttribute()
    {
        $labels = [
            'login' => 'تسجيل دخول',
            'logout' => 'تسجيل خروج',
            'approve_student' => 'قبول طالبة',
            'reject_student' => 'رفض طالبة',
            'add_student' => 'إضافة طالبة',
            'edit_student' => 'تعديل طالبة',
            'delete_student' => 'حذف طالبة',
            'add_bus' => 'إضافة باص',
            'edit_bus' => 'تعديل باص',
            'delete_bus' => 'حذف باص',
            'add_driver' => 'إضافة سائق',
            'edit_driver' => 'تعديل سائق',
            'delete_driver' => 'حذف سائق',
            'add_center' => 'إضافة مركز',
            'edit_center' => 'تعديل مركز',
            'assign_bus' => 'تخصيص باص',
            'update_profile' => 'تحديث الملف الشخصي',
            'change_password' => 'تغيير كلمة المرور',
        ];

        return $labels[$this->action] ?? $this->action;
    }

    // أيقونة النشاط
    public function getActionIconAttribute()
    {
        $icons = [
            'login' => 'sign-in-alt',
            'logout' => 'sign-out-alt',
            'approve_student' => 'check-circle',
            'reject_student' => 'times-circle',
            'add_student' => 'user-plus',
            'edit_student' => 'user-edit',
            'delete_student' => 'user-minus',
            'add_bus' => 'bus',
            'edit_bus' => 'bus',
            'delete_bus' => 'bus',
            'add_driver' => 'id-card',
            'edit_driver' => 'id-card',
            'assign_bus' => 'exchange-alt',
            'update_profile' => 'user-cog',
            'change_password' => 'key',
        ];

        return $icons[$this->action] ?? 'circle';
    }

    // لون النشاط
    public function getActionColorAttribute()
    {
        $colors = [
            'login' => 'success',
            'logout' => 'secondary',
            'approve_student' => 'success',
            'reject_student' => 'danger',
            'add_student' => 'primary',
            'edit_student' => 'warning',
            'delete_student' => 'danger',
            'add_bus' => 'info',
            'edit_bus' => 'warning',
            'delete_bus' => 'danger',
            'add_driver' => 'info',
            'assign_bus' => 'primary',
        ];

        return $colors[$this->action] ?? 'secondary';
    }
}