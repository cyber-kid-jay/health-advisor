<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Assessment Model
 * 
 * Represents a user's health assessment including:
 * - Symptoms experienced
 * - Vital signs
 * - Medical history context
 * - Related diagnosis results
 */
class Assessment extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'assessments';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'heart_rate',
        'blood_pressure_systolic',
        'blood_pressure_diastolic',
        'temperature',
        'oxygen_saturation',
        'chronic_conditions',
        'current_medications',
        'allergies',
        'smoking_status',
        'exercise_frequency',
        'notes',
        'assessment_date',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'assessment_date' => 'datetime',
        'chronic_conditions' => 'array',
        'heart_rate' => 'integer',
        'blood_pressure_systolic' => 'integer',
        'blood_pressure_diastolic' => 'integer',
        'temperature' => 'decimal:1',
        'oxygen_saturation' => 'integer',
    ];

    /**
     * Get the user that owns the assessment.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the symptoms associated with this assessment.
     */
    public function symptoms()
    {
        return $this->belongsToMany(
            Symptom::class,
            'assessment_symptoms',
            'assessment_id',
            'symptom_id'
        )->withPivot('severity', 'duration_days')
          ->withTimestamps();
    }

    /**
     * Get the diagnosis results for this assessment.
     */
    public function diagnosisResults()
    {
        return $this->hasMany(DiagnosisResult::class)
            ->orderBy('confidence_score', 'desc');
    }

    /**
     * Get the primary diagnosis result (highest confidence).
     */
    public function primaryDiagnosis()
    {
        return $this->hasOne(DiagnosisResult::class)
            ->orderBy('confidence_score', 'desc');
    }

    /**
     * Check if vital signs indicate an emergency.
     * 
     * @return bool
     */
    public function hasEmergencyVitals()
    {
        // Dangerously high blood pressure
        if ($this->blood_pressure_systolic >= 180 || $this->blood_pressure_diastolic >= 120) {
            return true;
        }

        // Very high or very low heart rate
        if ($this->heart_rate !== null && ($this->heart_rate > 130 || $this->heart_rate < 40)) {
            return true;
        }

        // Very high temperature
        if ($this->temperature !== null && $this->temperature >= 40) {
            return true;
        }

        // Low oxygen saturation
        if ($this->oxygen_saturation !== null && $this->oxygen_saturation < 90) {
            return true;
        }

        return false;
    }

    /**
     * Check if vital signs indicate concerning levels.
     * 
     * @return bool
     */
    public function hasConcerningVitals()
    {
        // Elevated blood pressure
        if ($this->blood_pressure_systolic > 140 || $this->blood_pressure_diastolic > 90) {
            return true;
        }

        // Elevated heart rate
        if ($this->heart_rate !== null && ($this->heart_rate > 100 || $this->heart_rate < 60)) {
            return true;
        }

        // Fever
        if ($this->temperature !== null && $this->temperature > 38.5) {
            return true;
        }

        // Slightly low oxygen
        if ($this->oxygen_saturation !== null && $this->oxygen_saturation < 95) {
            return true;
        }

        return false;
    }

    /**
     * Get formatted blood pressure reading.
     * 
     * @return string|null
     */
    public function getBloodPressureAttribute()
    {
        if ($this->blood_pressure_systolic && $this->blood_pressure_diastolic) {
            return "{$this->blood_pressure_systolic}/{$this->blood_pressure_diastolic}";
        }
        return null;
    }

    /**
     * Get the urgency level based on diagnosis results.
     * 
     * @return string
     */
    public function getUrgencyLevel()
    {
        $primaryDiagnosis = $this->primaryDiagnosis;

        if ($primaryDiagnosis) {
            return $primaryDiagnosis->urgency;
        }

        return 'routine';
    }

    /**
     * Get the risk level based on diagnosis results.
     * 
     * @return string
     */
    public function getRiskLevel()
    {
        $primaryDiagnosis = $this->primaryDiagnosis;

        if ($primaryDiagnosis) {
            return $primaryDiagnosis->risk_level;
        }

        return 'low';
    }

    /**
     * Scope a query to only include assessments from the last X days.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int $days
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeRecent($query, $days = 30)
    {
        return $query->where('assessment_date', '>=', now()->subDays($days));
    }

    /**
     * Scope a query to only include emergency assessments.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeEmergency($query)
    {
        return $query->whereHas('diagnosisResults', function ($q) {
            $q->where('urgency', 'emergency');
        });
    }

    /**
     * Get a summary of the assessment for display.
     * 
     * @return array
     */
    public function getSummary()
    {
        return [
            'date' => $this->assessment_date->format('M d, Y'),
            'symptoms_count' => $this->symptoms->count(),
            'primary_condition' => $this->primaryDiagnosis->condition->name ?? 'Unknown',
            'urgency' => $this->getUrgencyLevel(),
            'risk_level' => $this->getRiskLevel(),
        ];
    }
}
