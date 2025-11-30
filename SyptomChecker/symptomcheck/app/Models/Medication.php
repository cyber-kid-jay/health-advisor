<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medication extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'generic_name',
        'dosage',
        'type', // 'pain relief', 'fever reducer', 'antacid', 'allergy', etc.
        'notes',
        'availability', // 'over-the-counter', 'prescription'
        'side_effects',
    ];

    protected $casts = [
        'side_effects' => 'array',
    ];

    /**
     * Get the treatments that include this medication.
     */
    public function treatments()
    {
        return $this->belongsToMany(Treatment::class)
            ->withTimestamps();
    }
}
