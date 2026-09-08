<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Bus extends Model
{
    use HasFactory;

    protected $fillable = [
        'number',
        'plate_number',
        'model',
        'capacity',
        'current_students',
        'status',
        'center_id',
        'driver_id',
        'notes',
    ];

    protected $casts = [
        'capacity' => 'integer',
        'current_students' => 'integer',
    ];

    protected $attributes = [
        'current_students' => 0,
        'status' => 'active',
    ];

    // ==================== العلاقات ====================

    public function driver(): BelongsTo
    {
        return $this->belongsTo(Driver::class);
    }

    // العلاقة القديمة (للتوافق)
    public function center(): BelongsTo
    {
        return $this->belongsTo(Center::class);
    }

    // العلاقة الجديدة - متعدد لمتعدد مع السعة المنفصلة
    public function centers(): BelongsToMany
    {
        return $this->belongsToMany(Center::class, 'bus_center')
                    ->withPivot('schedule', 'capacity', 'current_students', 'notes')
                    ->withTimestamps();
    }

    public function students(): HasMany
    {
        return $this->hasMany(Student::class, 'assigned_bus_id');
    }

    // ==================== Accessors ====================

    public function getStatusTextAttribute(): string
    {
        return match ($this->status) {
            'active' => 'نشط',
            'inactive' => 'غير نشط',
            'maintenance' => 'صيانة',
            default => 'غير معروف',
        };
    }

    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            'active' => 'success',
            'inactive' => 'danger',
            'maintenance' => 'warning',
            default => 'secondary',
        };
    }

    // إجمالي السعة لجميع الجهات
    public function getTotalCapacityAttribute(): int
    {
        return $this->centers->sum('pivot.capacity');
    }

    // إجمالي الطالبات لجميع الجهات
    public function getTotalStudentsAttribute(): int
    {
        return $this->centers->sum('pivot.current_students');
    }

    // ==================== Scopes ====================

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeSearch($query, $term)
    {
        return $query->where(function ($q) use ($term) {
            $q->where('number', 'like', "%{$term}%")
              ->orWhere('plate_number', 'like', "%{$term}%")
              ->orWhere('model', 'like', "%{$term}%");
        });
    }

    // ==================== Methods ====================

    // الحصول على سعة الباص لجهة معينة
    public function getCapacityForCenter(int $centerId): int
    {
        $center = $this->centers()->where('centers.id', $centerId)->first();
        return $center ? $center->pivot->capacity : 0;
    }

    // الحصول على عدد الطالبات لجهة معينة
    public function getStudentsCountForCenter(int $centerId): int
    {
        $center = $this->centers()->where('centers.id', $centerId)->first();
        return $center ? $center->pivot->current_students : 0;
    }

    // المقاعد المتاحة لجهة معينة
    public function getAvailableSeatsForCenter(int $centerId): int
    {
        $capacity = $this->getCapacityForCenter($centerId);
        $current = $this->getStudentsCountForCenter($centerId);
        return max(0, $capacity - $current);
    }

    // هل الباص ممتلئ لجهة معينة؟
    public function isFullForCenter(int $centerId): bool
    {
        return $this->getAvailableSeatsForCenter($centerId) <= 0;
    }

    // تحقق إذا الباص يخدم جهة معينة
    public function servesCenter(int $centerId): bool
    {
        return $this->centers()->where('centers.id', $centerId)->exists();
    }

    // هل يمكن إضافة طالبة؟
    public function canAddStudent(?Student $student = null): bool
    {
        if ($this->status !== 'active') {
            return false;
        }

        if (!$student) {
            return true;
        }

        // تحقق من أن الباص يخدم جهة الطالبة
        if (!$this->servesCenter($student->center_id)) {
            return false;
        }

        // تحقق من توفر مقاعد لهذه الجهة
        if ($this->isFullForCenter($student->center_id)) {
            return false;
        }

        return true;
    }

    // إضافة طالبة
    public function addStudent(Student $student): bool
    {
        if (!$this->canAddStudent($student)) {
            return false;
        }

        $student->update([
            'assigned_bus_id' => $this->id,
            'bus_assigned_at' => now(),
        ]);

        $this->updateStudentCountForCenter($student->center_id);

        return true;
    }

    // إزالة طالبة
    public function removeStudent(Student $student): bool
    {
        if ($student->assigned_bus_id !== $this->id) {
            return false;
        }

        $centerId = $student->center_id;

        $student->update([
            'assigned_bus_id' => null,
            'pickup_point' => null,
            'pickup_time' => null,
            'bus_assigned_at' => null,
        ]);

        $this->updateStudentCountForCenter($centerId);

        return true;
    }

    // تحديث عدد الطالبات لجهة معينة
    public function updateStudentCountForCenter(int $centerId): void
    {
        $count = Student::where('assigned_bus_id', $this->id)
                        ->where('center_id', $centerId)
                        ->count();

        $this->centers()->updateExistingPivot($centerId, [
            'current_students' => $count
        ]);
    }

    // تحديث عدد الطالبات لجميع الجهات
    public function updateAllStudentCounts(): void
    {
        foreach ($this->centers as $center) {
            $this->updateStudentCountForCenter($center->id);
        }
    }

    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    public function hasDriver(): bool
    {
        return !is_null($this->driver_id);
    }
}