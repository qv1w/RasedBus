<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Center extends Model
{
    use HasFactory;

    protected $fillable = [
        'center_name',
        'type',           // دار / مركز / برنامج
        'gender',         // بنات / بنين
        'transport_fee',  // رسوم النقل
        'coverage_type',  // neighborhood / city_wide
        'address',
        'latitude',
        'longitude',
        'status',
        'morning_available',
        'morning_start',
        'morning_end',
        'evening_available',
        'evening_start',
        'evening_end',
        'coverage_area',
        'morning_coverage_area',
        'evening_coverage_area',
        'current_students',
        'bus_count',
        'capacity',
        'notes',
    ];

    protected $casts = [
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
        'morning_available' => 'boolean',
        'evening_available' => 'boolean',
        'coverage_area' => 'array',
        'morning_coverage_area' => 'array',
        'evening_coverage_area' => 'array',
        'transport_fee' => 'decimal:2',
    ];

    /**
     * العلاقة مع الطلاب
     */
    public function students()
    {
        return $this->hasMany(Student::class);
    }

    /**
     * العلاقة مع الباصات
     */
    public function buses()
    {
        return $this->hasMany(Bus::class);
    }

    /**
     * تحديث الإحصائيات
     */
    public function updateCounts()
    {
        $this->current_students = $this->students()->count();
        $this->bus_count = $this->buses()->count();
        $this->save();
    }

    /**
     * الحصول على النوع بالعربي
     */
    public function getTypeNameAttribute()
    {
        return $this->type;
    }

    /**
     * التحقق إذا كان المركز متاح لكل الزلفي
     */
    public function isCityWide()
    {
        return $this->coverage_type === 'city_wide';
    }

    /**
     * الحصول على الطلاب المقبولين
     */
    public function approvedStudents()
    {
        return $this->students()->where('status', 'approved');
    }

    /**
     * الحصول على طلاب الفترة الصباحية
     */
    public function morningStudents()
    {
        return $this->students()->where('preferred_schedule', 'صباحية');
    }

    /**
     * الحصول على طلاب الفترة المسائية
     */
    public function eveningStudents()
    {
        return $this->students()->where('preferred_schedule', 'مسائية');
    }

    /**
     * Scope: الدور فقط
     */
    public function scopeDoors($query)
    {
        return $query->where('type', 'دار');
    }

    /**
     * Scope: المراكز فقط
     */
    public function scopeCenters($query)
    {
        return $query->where('type', 'مركز');
    }

    /**
     * Scope: البرامج فقط
     */
    public function scopePrograms($query)
    {
        return $query->where('type', 'برنامج');
    }

    /**
     * Scope: حسب الجنس
     */
    public function scopeForGender($query, $gender)
    {
        return $query->where('gender', $gender);
    }

    /**
     * Scope: النشطة فقط
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
}
