<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('centers', function (Blueprint $table) {
            $table->id();
            $table->string('center_name')->unique();
            
            // === الحقول الجديدة ===
            $table->enum('type', ['دار', 'مركز', 'برنامج'])->default('دار');
            $table->enum('gender', ['بنات', 'بنين'])->default('بنات');
            $table->decimal('transport_fee', 8, 2)->default(500);
            $table->enum('coverage_type', ['neighborhood', 'city_wide'])->default('neighborhood');
            // =======================
            
            $table->string('address')->nullable();

            $table->decimal('latitude', 12, 8)->nullable();
            $table->decimal('longitude', 12, 8)->nullable();

            $table->enum('status', ['active', 'inactive'])->default('active');

            $table->boolean('morning_available')->default(false);
            $table->time('morning_start')->nullable();
            $table->time('morning_end')->nullable();

            $table->boolean('evening_available')->default(false);
            $table->time('evening_start')->nullable();
            $table->time('evening_end')->nullable();

            $table->json('coverage_area')->nullable();
            $table->json('morning_coverage_area')->nullable();
            $table->json('evening_coverage_area')->nullable();

            $table->unsignedInteger('current_students')->default(0);
            $table->unsignedInteger('bus_count')->default(0);
            $table->unsignedInteger('capacity')->nullable();

            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('centers');
    }
};
