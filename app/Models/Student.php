<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Student extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'name',
        'gender',          // ذكر / أنثى
        'national_id',
        'birthdate',
        'email',
        'password',
        'mobile',
        'guardian_name',
        'guardian_mobile',
        'guardian_relation',
        'address',
        'latitude',
        'longitude',
        'center_id',
        'preferred_schedule',
        'status',
        'rejection_reason',
        'notes',
        'assigned_bus_id',
        'pickup_point',
        'pickup_time',
        'bus_assigned_at',
        'total_paid',
        'total_required',
    ];

    protected $casts = [
        'birthdate' => 'date',
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
        'total_paid' => 'decimal:2',
        'total_required' => 'decimal:2',
        'bus_assigned_at' => 'datetime',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * العلاقة مع المركز/الدار
     */
    public function center()
    {
        return $this->belongsTo(Center::class);
    }

    /**
     * العلاقة مع الباص المخصص
     */
    public function assignedBus()
    {
        return $this->belongsTo(Bus::class, 'assigned_bus_id');
    }

    /**
     * العلاقة مع المدفوعات
     */
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    /**
     * الحصول على حالة الطالب بالعربي
     */
    public function getStatusNameAttribute()
    {
        $statuses = [
            'pending' => 'قيد المراجعة',
            'approved' => 'مقبول/ة',
            'rejected' => 'مرفوض/ة',
            'suspended' => 'معلق/ة',
        ];

        return $statuses[$this->status] ?? $this->status;
    }

    /**
     * الحصول على لون الحالة
     */
    public function getStatusColorAttribute()
    {
        $colors = [
            'pending' => 'warning',
            'approved' => 'success',
            'rejected' => 'danger',
            'suspended' => 'secondary',
        ];

        return $colors[$this->status] ?? 'secondary';
    }

    /**
     * الحصول على الجنس بالعربي
     */
    public function getGenderNameAttribute()
    {
        return $this->gender;
    }

    /**
     * حساب المبلغ المتبقي
     */
    public function getRemainingAmountAttribute()
    {
        return $this->total_required - $this->total_paid;
    }

    /**
     * التحقق من اكتمال الدفع
     */
    public function isFullyPaid()
    {
        return $this->total_paid >= $this->total_required;
    }

    /**
     * التحقق من تخصيص باص
     */
    public function hasBusAssigned()
    {
        return !is_null($this->assigned_bus_id);
    }

    /**
     * Scope: الطلاب المقبولين
     */
    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    /**
     * Scope: الطلاب قيد المراجعة
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope: حسب الجنس
     */
    public function scopeGender($query, $gender)
    {
        return $query->where('gender', $gender);
    }

    /**
     * Scope: حسب الفترة
     */
    public function scopeSchedule($query, $schedule)
    {
        return $query->where('preferred_schedule', $schedule);
    }

    /**
     * Scope: بدون باص
     */
    public function scopeWithoutBus($query)
    {
        return $query->whereNull('assigned_bus_id');
    }
}
