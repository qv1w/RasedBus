<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $fillable = [
        'report_number',
        'title',
        'type',
        'data',
        'notes',
        'created_by',
    ];

    protected $casts = [
        'data' => 'array',
    ];

    /**
     * العلاقة مع المشرف
     */
    public function creator()
    {
        return $this->belongsTo(Admin::class, 'created_by');
    }

    /**
     * توليد رقم تقرير فريد
     */
    public static function generateReportNumber()
    {
        $year = date('Y');
        $month = date('m');
        $lastReport = self::whereYear('created_at', $year)
                         ->whereMonth('created_at', $month)
                         ->orderBy('id', 'desc')
                         ->first();
        
        $sequence = $lastReport ? (intval(substr($lastReport->report_number, -4)) + 1) : 1;
        
        return 'RPT-' . $year . $month . '-' . str_pad($sequence, 4, '0', STR_PAD_LEFT);
    }

    /**
     * Scope: حسب النوع
     */
    public function scopeOfType($query, $type)
    {
        return $query->where('type', $type);
    }

    /**
     * Scope: البحث
     */
    public function scopeSearch($query, $term)
    {
        return $query->where(function($q) use ($term) {
            $q->where('report_number', 'like', "%{$term}%")
              ->orWhere('title', 'like', "%{$term}%")
              ->orWhere('notes', 'like', "%{$term}%");
        });
    }
}
