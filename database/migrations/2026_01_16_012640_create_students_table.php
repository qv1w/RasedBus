<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('student_id')->unique(); 
            $table->string('name');
            
           
            $table->enum('gender', ['ذكر', 'أنثى'])->default('أنثى');
           
            
            $table->string('national_id', 10)->unique();
            $table->date('birthdate')->nullable();
            $table->string('email')->unique();
            $table->string('password')->nullable(); 
            $table->string('mobile', 20);
            
            // معلومات ولي الأمر
            $table->string('guardian_name')->nullable();
            $table->string('guardian_mobile', 20)->nullable();
            $table->string('guardian_relation', 100)->nullable();
            
            // العنوان والموقع
            $table->string('address', 500)->nullable();
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            
            // المركز والفترة
            $table->foreignId('center_id')->nullable()->constrained('centers')->onDelete('set null');
            $table->string('preferred_schedule')->default('صباحية');
            
            // الحالة
            $table->enum('status', ['pending', 'approved', 'rejected', 'suspended'])->default('pending');
            $table->text('rejection_reason')->nullable();
            $table->text('notes')->nullable();
            
            // الباص
            $table->foreignId('assigned_bus_id')->nullable()->constrained('buses')->onDelete('set null');
            $table->string('pickup_point')->nullable();
            $table->string('pickup_time')->nullable();
            $table->timestamp('bus_assigned_at')->nullable();
            
            // الدفعات
            $table->decimal('total_paid', 10, 2)->default(0);
            $table->decimal('total_required', 10, 2)->default(0);
            
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
