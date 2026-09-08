<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('drivers', function (Blueprint $table) {
            $table->id();

            $table->string('driver_id')->unique();
            $table->string('name');
            $table->string('mobile');
            $table->string('email')->nullable();
            $table->string('address')->nullable();

            $table->string('license_number');
            $table->string('license_type')->nullable();

            $table->enum('status', ['active', 'inactive', 'suspended'])->default('active');
            $table->unsignedInteger('experience_years')->default(0);

            $table->string('emergency_contact')->nullable();
            $table->string('emergency_phone')->nullable();

            $table->date('hire_date')->nullable();
            $table->decimal('salary', 8, 2)->nullable();

            $table->foreignId('center_id')
                  ->nullable()
                  ->constrained('centers')
                  ->nullOnDelete();

            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('drivers');
    }
};

