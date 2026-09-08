<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payment_settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->string('description')->nullable();
            $table->timestamps();
        });

        // إضافة الإعدادات الافتراضية
        DB::table('payment_settings')->insert([
            [
                'key' => 'default_payment_amount',
                'value' => '500',
                'description' => 'المبلغ الافتراضي للدفعة (ريال)',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'auto_payment_enabled',
                'value' => 'yes',
                'description' => 'تفعيل إنشاء دفعة تلقائياً عند قبول طالب جديد',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'default_payment_description',
                'value' => 'رسوم النقل',
                'description' => 'وصف الدفعة الافتراضي',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('payment_settings');
    }
};
