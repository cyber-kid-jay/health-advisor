<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('health_vitals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('consultation_id')->constrained()->cascadeOnDelete();
            $table->unsignedSmallInteger('blood_pressure_systolic')->nullable(); // e.g., 120
            $table->unsignedSmallInteger('blood_pressure_diastolic')->nullable(); // e.g., 80
            $table->unsignedSmallInteger('heart_rate')->nullable(); // BPM
            $table->decimal('temperature', 5, 2)->nullable(); // Celsius, e.g., 37.5
            $table->timestamps();

            $table->index('consultation_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('health_vitals');
    }
};
