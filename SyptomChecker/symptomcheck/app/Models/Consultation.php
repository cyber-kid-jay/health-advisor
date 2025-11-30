<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consultation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'age',
        'gender',
        'notes',
        'symptom_ids',
        'severity_data',
        'result_summary',
    ];

    protected $casts = [
        'symptom_ids' => 'array',
        'severity_data' => 'array',
        'result_summary' => 'array',
    ];

    public function symptoms()
    {
        return $this->belongsToMany(Symptom::class)
            ->withTimestamps();
    }

    /**
     * Get the health vital associated with this consultation.
     */
    public function healthVital()
    {
        return $this->hasOne(HealthVital::class);
    }

    /**
     * The user who created this consultation.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
