<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'title',
        'description',
        'event_date',
        'location',
        'price',
        'current_participants',
        'status',
    ];

    /**
     * Galerie d'images (relation polymorphique)
     */
    public function media()
    {
        return $this->morphMany(Media::class, 'mediable');
    }
}
