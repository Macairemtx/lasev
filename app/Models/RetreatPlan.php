<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RetreatPlan extends Model
{
    protected $fillable = [
        'title',
        'description',
        'duration_days',
        'cover_image',
        'features',
        'tags',
        'services',
        'status',
        'price',
    ];

    protected $casts = [
        'features' => 'array',
        'tags' => 'array',
        'services' => 'array',
    ];
}
