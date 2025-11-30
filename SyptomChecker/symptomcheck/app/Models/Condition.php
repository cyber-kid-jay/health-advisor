<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Condition extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'advice',
        'urgency_level',
    ];

    public function symptoms()
    {
        return $this->belongsToMany(Symptom::class)
            ->withPivot('weight')
            ->withTimestamps();
    }

    /**
     * Get the treatments recommended for this condition.
     */
    public function treatments()
    {
        return $this->belongsToMany(Treatment::class)
            ->withTimestamps();
    }

    public function scopeWithSymptoms($query, array $symptomIds)
    {
        return $query->whereHas('symptoms', function ($q) use ($symptomIds) {
            $q->whereIn('symptom_id', $symptomIds);
        });
    }
}
