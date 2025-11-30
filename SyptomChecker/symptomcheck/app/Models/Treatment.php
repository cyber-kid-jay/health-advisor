<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Treatment extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'instructions',
        'category', // 'diet', 'exercise', 'lifestyle', 'medication', 'general'
        'duration',
        'frequency',
    ];

    /**
     * Get the conditions that have this treatment.
     */
    public function conditions()
    {
        return $this->belongsToMany(Condition::class)
            ->withTimestamps();
    }

    /**
     * Get the medications recommended with this treatment.
     */
    public function medications()
    {
        return $this->belongsToMany(Medication::class)
            ->withTimestamps();
    }
}
