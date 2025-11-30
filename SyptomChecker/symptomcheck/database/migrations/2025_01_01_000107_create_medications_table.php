<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('medications', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('generic_name')->nullable();
            $table->string('dosage'); // e.g., "500mg", "10ml"
            $table->string('type'); // e.g., 'pain relief', 'fever reducer'
            $table->text('notes')->nullable();
            $table->enum('availability', ['over-the-counter', 'prescription'])->default('over-the-counter');
            $table->json('side_effects')->nullable(); // Array of side effects
            $table->timestamps();

            $table->index('type');
            $table->index('availability');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('medications');
    }
};
