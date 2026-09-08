<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();

            $table->string('payment_number')->unique();
            $table->foreignId('student_id')->constrained()->cascadeOnDelete();

            $table->decimal('amount', 10, 2);
            $table->string('payment_method')->default('bank_transfer');

            // بيانات التحويل البنكي
            $table->string('bank_name')->nullable();
            $table->string('transfer_number')->nullable();
            $table->date('transfer_date')->nullable();

            // التواريخ
            $table->date('payment_date')->nullable();
            $table->date('due_date')->nullable();

            // الإيصال
            $table->string('receipt_image')->nullable();

            // الحالة
            $table->string('status')->default('awaiting_receipt'); // awaiting_receipt, pending, approved, rejected
            $table->text('rejection_reason')->nullable();

            // معلومات إضافية
            $table->string('academic_year')->nullable();
            $table->string('semester')->nullable();
            $table->text('notes')->nullable();

            // المعالجة
            $table->foreignId('processed_by')->nullable()->constrained('admins')->nullOnDelete();
            $table->timestamp('processed_at')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};