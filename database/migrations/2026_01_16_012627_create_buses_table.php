<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('buses', function (Blueprint $table) {
            $table->id();

            $table->string('number')->unique();
            $table->string('plate_number')->unique();
            $table->string('model')->nullable();

            $table->unsignedInteger('capacity');
            $table->unsignedInteger('current_students')->default(0);

            $table->enum('status', ['active', 'inactive', 'maintenance'])->default('active');

            $table->foreignId('center_id')
                  ->constrained('centers')
                  ->cascadeOnDelete();

            $table->foreignId('driver_id')
                  ->nullable()
                  ->constrained('drivers')
                  ->nullOnDelete();

            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('buses');
    }
};

