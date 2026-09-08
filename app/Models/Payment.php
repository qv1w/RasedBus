<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'payment_number',
        'student_id',
        'amount',
        'payment_method',
        'bank_name',
        'transfer_number',
        'transfer_date',
        'payment_date',
        'due_date',
        'receipt_image',
        'notes',
        'status',
        'rejection_reason',
        'academic_year',
        'semester',
        'processed_by',
        'processed_at',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'transfer_date' => 'date',
        'payment_date' => 'date',
        'due_date' => 'date',
        'processed_at' => 'datetime',
    ];

    // العلاقات
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function processedBy()
    {
        return $this->belongsTo(Admin::class, 'processed_by');
    }

    // Accessors
    public function getStatusTextAttribute()
    {
        $statuses = [
            'awaiting_receipt' => 'بانتظار الإيصال',
            'pending' => 'قيد المراجعة',
            'approved' => 'مقبولة',
            'rejected' => 'مرفوضة',
        ];

        return $statuses[$this->status] ?? $this->status;
    }

    public function getStatusColorAttribute()
    {
        $colors = [
            'awaiting_receipt' => 'primary',
            'pending' => 'warning',
            'approved' => 'success',
            'rejected' => 'danger',
        ];

        return $colors[$this->status] ?? 'secondary';
    }

    // Scopes
    public function scopeAwaitingReceipt($query)
    {
        return $query->where('status', 'awaiting_receipt');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }

    public function scopeForStudent($query, $studentId)
    {
        return $query->where('student_id', $studentId);
    }

    // توليد رقم دفعة فريد
    public static function generatePaymentNumber()
    {
        $year = date('Y');
        $month = date('m');
        $lastPayment = self::whereYear('created_at', $year)
                          ->whereMonth('created_at', $month)
                          ->orderBy('id', 'desc')
                          ->first();
        
        $sequence = $lastPayment ? (intval(substr($lastPayment->payment_number, -4)) + 1) : 1;
        
        return 'PAY-' . $year . $month . '-' . str_pad($sequence, 4, '0', STR_PAD_LEFT);
    }

    // دوال مساعدة
    public function isAwaitingReceipt()
    {
        return $this->status === 'awaiting_receipt';
    }

    public function isPending()
    {
        return $this->status === 'pending';
    }

    public function isApproved()
    {
        return $this->status === 'approved';
    }

    public function isRejected()
    {
        return $this->status === 'rejected';
    }

    public function hasReceipt()
    {
        return !empty($this->receipt_image);
    }

    public function canUploadReceipt()
    {
        return in_array($this->status, ['awaiting_receipt', 'rejected']);
    }
}