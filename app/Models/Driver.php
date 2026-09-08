<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Driver extends Model
{
    use HasFactory;

    protected $fillable = [
        'driver_id',
        'name',
        'mobile',
        'email',
        'address',
        'license_number',
        'license_type',
        'status',
        'notes',
        'experience_years',
        'emergency_contact',
        'emergency_phone',
        'center_id',
        'hire_date',
        'salary'
    ];

    protected $casts = [
        'hire_date' => 'date',
        'salary' => 'decimal:2',
        'experience_years' => 'integer',
        'center_id' => 'integer'
    ];

    // ==================== Boot ====================
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($driver) {
            if (empty($driver->driver_id)) {
                $driver->driver_id = self::generateDriverId();
            }
        });
    }

    // توليد رقم سائق فريد
    public static function generateDriverId(): string
    {
        do {
            $id = 'DRV-' . date('Y') . '-' . Str::upper(Str::random(4));
        } while (self::where('driver_id', $id)->exists());

        return $id;
    }

    // ==================== العلاقات ====================

    public function buses(): HasMany
    {
        return $this->hasMany(Bus::class, 'driver_id');
    }

    public function activeBus(): HasOne
    {
        return $this->hasOne(Bus::class, 'driver_id')->where('status', 'active');
    }


    public function center()
    {
         return $this->belongsTo(Center::class);
    }
    // ==================== Accessors ====================

    public function getStatusNameAttribute(): string
    {
        return match ($this->status) {
            'active' => 'نشط',
            'inactive' => 'غير نشط',
            'on_leave' => 'في إجازة',
            default => $this->status
        };
    }

    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            'active' => 'success',
            'inactive' => 'danger',
            'on_leave' => 'warning',
            default => 'secondary'
        };
    }

    public function getFormattedMobileAttribute(): string
    {
        $mobile = $this->mobile;
        if (strlen($mobile) === 10 && substr($mobile, 0, 2) === '05') {
            return substr($mobile, 0, 3) . ' ' . substr($mobile, 3, 3) . ' ' . substr($mobile, 6);
        }
        return $mobile;
    }

    public function getCenterNameAttribute(): ?string
    {
        return $this->center?->center_name;
    }

    // ==================== دوال مساعدة ====================

    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    public function isAvailable(): bool
    {
        return $this->isActive() && !$this->hasActiveBus();
    }

    public function hasActiveBus(): bool
    {
        return $this->buses()->where('status', 'active')->exists();
    }

    // ==================== Scopes ====================

    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
              ->orWhere('mobile', 'like', "%{$search}%")
              ->orWhere('license_number', 'like', "%{$search}%")
              ->orWhere('email', 'like', "%{$search}%")
              ->orWhere('driver_id', 'like', "%{$search}%");
        });
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeAvailable($query)
    {
        return $query->where('status', 'active')
            ->whereDoesntHave('buses', function ($q) {
                $q->where('status', 'active');
            });
    }

    public function scopeInCenter($query, $centerId)
    {
        return $query->where('center_id', $centerId);
    }
}