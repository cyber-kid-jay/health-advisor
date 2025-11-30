<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Symptom extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'body_part',
        'severity',
        'category',
    ];

    public function conditions()
    {
        return $this->belongsToMany(Condition::class)
            ->withPivot('weight')
            ->withTimestamps();
    }
}
