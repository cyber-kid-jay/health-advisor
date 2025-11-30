<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HealthVital extends Model
{
    use HasFactory;

    protected $fillable = [
        'consultation_id',
        'blood_pressure_systolic',
        'blood_pressure_diastolic',
        'heart_rate',
        'temperature',
    ];

    /**
     * Get the consultation that owns this health vital.
     */
    public function consultation()
    {
        return $this->belongsTo(Consultation::class);
    }

    /**
     * Check if blood pressure is high.
     * High BP is typically >= 140/90 mmHg (Stage 2 Hypertension)
     * Elevated is 120-129/<80 mmHg
     */
    public function isBloodPressureHigh(): bool
    {
        if (is_null($this->blood_pressure_systolic) || is_null($this->blood_pressure_diastolic)) {
            return false;
        }

        return $this->blood_pressure_systolic >= 140 || $this->blood_pressure_diastolic >= 90;
    }

    /**
     * Check if blood pressure is elevated.
     */
    public function isBloodPressureElevated(): bool
    {
        if (is_null($this->blood_pressure_systolic) || is_null($this->blood_pressure_diastolic)) {
            return false;
        }

        return ($this->blood_pressure_systolic >= 120 && $this->blood_pressure_systolic < 140) 
            || ($this->blood_pressure_diastolic >= 80 && $this->blood_pressure_diastolic < 90);
    }

    /**
     * Check if heart rate is abnormal.
     * Normal resting heart rate: 60-100 BPM
     */
    public function isHeartRateAbnormal(): bool
    {
        if (is_null($this->heart_rate)) {
            return false;
        }

        return $this->heart_rate < 60 || $this->heart_rate > 100;
    }

    /**
     * Check if temperature is elevated (fever).
     * Normal: 36.5-37.5°C, Fever: >= 38°C
     */
    public function hasElevatedTemperature(): bool
    {
        if (is_null($this->temperature)) {
            return false;
        }

        return $this->temperature >= 38.0;
    }

    /**
     * Get blood pressure status as string
     */
    public function getBloodPressureStatus(): string
    {
        if ($this->isBloodPressureHigh()) {
            return 'High';
        }

        if ($this->isBloodPressureElevated()) {
            return 'Elevated';
        }

        return 'Normal';
    }

    /**
     * Get heart rate status as string
     */
    public function getHeartRateStatus(): string
    {
        if (is_null($this->heart_rate)) {
            return 'Unknown';
        }

        if ($this->heart_rate < 60) {
            return 'Low';
        }

        if ($this->heart_rate > 100) {
            return 'High';
        }

        return 'Normal';
    }
}
