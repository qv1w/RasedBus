<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentSetting extends Model
{
    protected $fillable = [
        'key',
        'value',
        'description',
    ];

    /**
     * الحصول على قيمة إعداد
     */
    public static function get($key, $default = null)
    {
        $setting = static::where('key', $key)->first();
        return $setting ? $setting->value : $default;
    }

    /**
     * تعيين قيمة إعداد
     */
    public static function set($key, $value, $description = null)
    {
        return static::updateOrCreate(
            ['key' => $key],
            ['value' => $value, 'description' => $description]
        );
    }

    /**
     * الحصول على المبلغ الافتراضي للدفعة
     */
    public static function getDefaultAmount()
    {
        return (float) static::get('default_payment_amount', 500);
    }

    /**
     * هل الدفعة التلقائية مفعلة؟
     */
    public static function isAutoPaymentEnabled()
    {
        return static::get('auto_payment_enabled', 'yes') === 'yes';
    }

    /**
     * الحصول على وصف الدفعة الافتراضي
     */
    public static function getDefaultDescription()
    {
        return static::get('default_payment_description', 'رسوم النقل - ' . date('Y'));
    }
}
