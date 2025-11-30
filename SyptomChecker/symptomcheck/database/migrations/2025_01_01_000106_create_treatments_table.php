<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('treatments', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->text('description');
            $table->text('instructions'); // Detailed step-by-step instructions
            $table->enum('category', ['diet', 'exercise', 'lifestyle', 'medication', 'general']);
            $table->string('duration')->nullable(); // e.g., "2-3 weeks", "ongoing"
            $table->string('frequency')->nullable(); // e.g., "daily", "3 times per day"
            $table->timestamps();

            $table->index('category');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('treatments');
    }
};
