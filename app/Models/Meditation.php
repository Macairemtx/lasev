<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Meditation extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'description',
        'duration',
    ];

    /**
     * Relation polymorphique : une méditation a un media (audio)
     */
    public function media()
    {
        return $this->morphOne(Media::class, 'mediable');
    }
}
