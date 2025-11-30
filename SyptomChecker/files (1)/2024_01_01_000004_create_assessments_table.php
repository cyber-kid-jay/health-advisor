<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration for assessments table
 * 
 * This table stores user health assessments including:
 * - Vital signs (heart rate, blood pressure, temperature, oxygen saturation)
 * - Medical context (chronic conditions, medications, allergies)
 * - Lifestyle factors (smoking, exercise)
 * - Additional notes
 */
return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assessments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            // Vital Signs
            $table->integer('heart_rate')->nullable()->comment('Heart rate in bpm');
            $table->integer('blood_pressure_systolic')->nullable()->comment('Systolic BP in mmHg');
            $table->integer('blood_pressure_diastolic')->nullable()->comment('Diastolic BP in mmHg');
            $table->decimal('temperature', 4, 2)->nullable()->comment('Body temperature in Celsius');
            $table->integer('oxygen_saturation')->nullable()->comment('Oxygen saturation percentage');
            
            // Medical History Context
            $table->json('chronic_conditions')->nullable()->comment('Array of chronic condition IDs');
            $table->text('current_medications')->nullable()->comment('List of current medications');
            $table->text('allergies')->nullable()->comment('Known allergies');
            
            // Lifestyle Factors
            $table->enum('smoking_status', ['no', 'yes', 'former'])->nullable();
            $table->enum('exercise_frequency', ['daily', '3-5', '1-2', 'rarely', 'never'])->nullable();
            
            // Additional Information
            $table->text('notes')->nullable()->comment('Additional information provided by user');
            
            // Timestamps
            $table->timestamp('assessment_date')->useCurrent()->comment('When assessment was taken');
            $table->timestamps();
            $table->softDeletes();
            
            // Indexes for better query performance
            $table->index('user_id');
            $table->index('assessment_date');
            $table->index(['user_id', 'assessment_date']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('assessments');
    }
};
