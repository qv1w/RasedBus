<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('username')->unique();
            $table->string('email')->unique();
            $table->string('password');

            // حقول إضافية
            $table->string('phone')->nullable();
            $table->string('job_title')->nullable();
            $table->text('bio')->nullable();

            // الحالة والرتبة
            $table->enum('status', ['active', 'inactive', 'suspended'])->default('active');
            $table->string('role')->default('data_entry'); 

            // إحصائيات الدخول
            $table->unsignedInteger('login_count')->default(0);
            $table->timestamp('last_login')->nullable();

            // إعدادات
            $table->boolean('email_notifications')->default(true);
            $table->boolean('sms_notifications')->default(false);
            $table->boolean('two_factor')->default(false);
            $table->string('language')->default('ar');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('admins');
    }
};
