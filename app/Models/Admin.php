<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Admin extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'phone',
        'job_title',
        'bio',
        'status',
        'role',
        'permissions',
        'allowed_schedules',
        'login_count',
        'last_login',
        'email_notifications',
        'sms_notifications',
        'two_factor',
        'language',
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'last_login' => 'datetime',
        'email_notifications' => 'boolean',
        'sms_notifications' => 'boolean',
        'two_factor' => 'boolean',
        'permissions' => 'array',
        'allowed_schedules' => 'array',
    ];

    /**
     * =====================================================
     * تعريف الرتب
     * =====================================================
     */

    const ROLE_NAMES = [
        'developer'   => 'مطور النظام',
        'super_admin' => 'مدير عام',
        'admin'       => 'مشرف',
        'data_entry'  => 'مدخل بيانات',
        'accountant'  => 'محاسب',
        'supervisor'  => 'مراقب',
    ];

    const ROLE_COLORS = [
        'developer'   => 'dark',
        'super_admin' => 'danger',
        'admin'       => 'primary',
        'data_entry'  => 'info',
        'accountant'  => 'success',
        'supervisor'  => 'secondary',
    ];

    const ROLE_ICONS = [
        'developer'   => 'fa-code',
        'super_admin' => 'fa-crown',
        'admin'       => 'fa-user-shield',
        'data_entry'  => 'fa-keyboard',
        'accountant'  => 'fa-calculator',
        'supervisor'  => 'fa-eye',
    ];

    const ROLE_HIERARCHY = [
        'developer'   => 100,
        'super_admin' => 90,
        'admin'       => 70,
        'data_entry'  => 40,
        'accountant'  => 40,
        'supervisor'  => 10,
    ];

    /**
     * =====================================================
     * العلاقات
     * =====================================================
     */

    public function centers(): BelongsToMany
    {
        return $this->belongsToMany(Center::class, 'admin_center');
    }

    public function activities()
    {
        return $this->hasMany(AdminActivity::class);
    }

    /**
     * =====================================================
     * دوال التحقق من الرتبة
     * =====================================================
     */

    public function isDeveloper(): bool
    {
        return $this->role === 'developer';
    }

    public function isSuperAdmin(): bool
    {
        return $this->role === 'super_admin';
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isDataEntry(): bool
    {
        return $this->role === 'data_entry';
    }

    public function isAccountant(): bool
    {
        return $this->role === 'accountant';
    }

    public function isSupervisor(): bool
    {
        return $this->role === 'supervisor';
    }

    public function isSuper(): bool
    {
        return in_array($this->role, ['developer', 'super_admin']);
    }

    /**
     * =====================================================
     * دوال التحقق من الصلاحيات
     * =====================================================
     */

    public function hasPermission(string $permission): bool
    {
        if ($this->isSuper()) {
            return true;
        }

        $permissions = $this->permissions ?? [];
        
        if (!is_array($permissions)) {
            return false;
        }

        if (in_array('all', $permissions) || in_array('*', $permissions)) {
            return true;
        }

        return in_array($permission, $permissions);
    }

    public function canView(string $section): bool
    {
        return $this->hasPermission($section . '.view');
    }

    public function canCreate(string $section): bool
    {
        return $this->hasPermission($section . '.create');
    }

    public function canEdit(string $section): bool
    {
        return $this->hasPermission($section . '.edit');
    }

    public function canDelete(string $section): bool
    {
        return $this->hasPermission($section . '.delete');
    }

    public function canApprove(string $section): bool
    {
        return $this->hasPermission($section . '.approve');
    }

    public function canDeleteAllStudents(): bool
    {
        return in_array($this->role, ['developer', 'super_admin']);
    }

    /**
     * =====================================================
     * دوال التحقق من الجهات
     * =====================================================
     */

    public function hasAccessToCenter(int $centerId): bool
    {
        if ($this->isSuper()) {
            return true;
        }

        if ($this->centers()->count() === 0) {
            return true;
        }

        return $this->centers()->where('centers.id', $centerId)->exists();
    }

    public function getAllowedCenterIds(): array
    {
        if ($this->isSuper()) {
            return Center::pluck('id')->toArray();
        }

        $centerIds = $this->centers()->pluck('centers.id')->toArray();
        
        if (empty($centerIds)) {
            return Center::pluck('id')->toArray();
        }

        return $centerIds;
    }

    public function hasAccessToAllCenters(): bool
    {
        if ($this->isSuper()) {
            return true;
        }

        return $this->centers()->count() === 0;
    }

    public function getAllowedCentersNames(): string
    {
        if ($this->hasAccessToAllCenters()) {
            return 'جميع الجهات';
        }

        return $this->centers->pluck('center_name')->implode('، ');
    }

    /**
     * =====================================================
     * دوال التحقق من الفترات (صباحية/مسائية)
     * =====================================================
     */

    public function hasAccessToSchedule(string $schedule): bool
    {
        if ($this->isSuper()) {
            return true;
        }

        $allowedSchedules = $this->allowed_schedules ?? [];
        
        if (!is_array($allowedSchedules)) {
            return true;
        }

        if (empty($allowedSchedules)) {
            return true;
        }

        return in_array($schedule, $allowedSchedules);
    }

    public function getAllowedSchedules(): array
    {
        if ($this->isSuper()) {
            return ['صباحية', 'مسائية'];
        }

        $allowedSchedules = $this->allowed_schedules ?? [];
        
        if (!is_array($allowedSchedules) || empty($allowedSchedules)) {
            return ['صباحية', 'مسائية'];
        }

        return $allowedSchedules;
    }

    public function hasAccessToAllSchedules(): bool
    {
        if ($this->isSuper()) {
            return true;
        }

        $allowedSchedules = $this->allowed_schedules ?? [];
        
        if (!is_array($allowedSchedules) || empty($allowedSchedules)) {
            return true;
        }

        return count($allowedSchedules) >= 2;
    }

    public function getAllowedSchedulesNames(): string
    {
        if ($this->hasAccessToAllSchedules()) {
            return 'جميع الفترات';
        }

        return implode('، ', $this->getAllowedSchedules());
    }

    /**
     * =====================================================
     * دوال إدارة الموظفين
     * =====================================================
     */

    public function canEditAdmin(Admin $target): bool
    {
        if ($target->isDeveloper()) {
            return false;
        }

        if ($this->isDeveloper()) {
            return true;
        }

        if ($this->isSuperAdmin()) {
            return true;
        }

        return false;
    }

    public function canDeleteAdmin(Admin $target): bool
    {
        if ($target->isDeveloper()) {
            return false;
        }

        if ($this->id === $target->id) {
            return false;
        }

        if ($this->isDeveloper()) {
            return true;
        }

        if ($this->isSuperAdmin()) {
            return $target->role !== 'super_admin';
        }

        return false;
    }

    public function getCreatableRoles(): array
    {
        $roles = [];

        if ($this->isDeveloper()) {
            $roles = [
                'super_admin' => 'مدير عام',
                'admin'       => 'مشرف',
                'data_entry'  => 'مدخل بيانات',
                'accountant'  => 'محاسب',
                'supervisor'  => 'مراقب',
            ];
        }
        elseif ($this->isSuperAdmin()) {
            $roles = [
                'admin'       => 'مشرف',
                'data_entry'  => 'مدخل بيانات',
                'accountant'  => 'محاسب',
                'supervisor'  => 'مراقب',
            ];
        }

        return $roles;
    }

    public function isProtected(): bool
    {
        return $this->isDeveloper();
    }

    public function canManageAdmin(Admin $admin): bool
    {
        if ($this->isDeveloper()) {
            return true;
        }

        if ($this->isSuperAdmin()) {
            return $admin->role !== 'developer';
        }

        return false;
    }

    /**
     * =====================================================
     * Accessors
     * =====================================================
     */

    public function getRoleNameAttribute(): string
    {
        return self::ROLE_NAMES[$this->role] ?? 'غير محدد';
    }

    public function getRoleColorAttribute(): string
    {
        return self::ROLE_COLORS[$this->role] ?? 'secondary';
    }

    public function getRoleIconAttribute(): string
    {
        return self::ROLE_ICONS[$this->role] ?? 'fa-user';
    }

    public function getStatusNameAttribute(): string
    {
        return match ($this->status) {
            'active' => 'نشط',
            'inactive' => 'غير نشط',
            default => $this->status ?? 'غير محدد',
        };
    }

    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            'active' => 'success',
            'inactive' => 'danger',
            default => 'secondary',
        };
    }

    /**
     * =====================================================
     * قائمة كل الصلاحيات المتاحة
     * =====================================================
     */
    public static function allPermissions(): array
    {
        return [
            'students' => [
                'students.view' => 'عرض الطالبات',
                'students.create' => 'إضافة طالبات',
                'students.edit' => 'تعديل الطالبات',
                'students.delete' => 'حذف الطالبات',
                'students.approve' => 'قبول/رفض الطالبات',
                'students.assign_bus' => 'تخصيص باصات للطالبات',
            ],
            'buses' => [
                'buses.view' => 'عرض الباصات',
                'buses.create' => 'إضافة باصات',
                'buses.edit' => 'تعديل الباصات',
                'buses.delete' => 'حذف الباصات',
                'buses.assign_students' => 'تخصيص طالبات للباصات',
            ],
            'drivers' => [
                'drivers.view' => 'عرض السائقين',
                'drivers.create' => 'إضافة سائقين',
                'drivers.edit' => 'تعديل السائقين',
                'drivers.delete' => 'حذف السائقين',
            ],
            'payments' => [
                'payments.view' => 'عرض الدفعات',
                'payments.create' => 'إضافة دفعات',
                'payments.edit' => 'تعديل الدفعات',
                'payments.delete' => 'حذف الدفعات',
                'payments.approve' => 'اعتماد الدفعات',
            ],
            'centers' => [
                'centers.view' => 'عرض الجهات',
                'centers.edit' => 'تعديل الجهات',
            ],
            'reports' => [
                'reports.view' => 'عرض التقارير',
                'reports.create' => 'إنشاء التقارير',
            ],
            'admins' => [
                'admins.view' => 'عرض الموظفين',
                'admins.create' => 'إضافة موظفين',
                'admins.edit' => 'تعديل الموظفين',
                'admins.delete' => 'حذف الموظفين',
            ],
        ];
    }

    /**
     * =====================================================
     * دوال مساعدة
     * =====================================================
     */

    public function recordLogin(): void
    {
        $this->increment('login_count');
        $this->update(['last_login' => now()]);
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
}