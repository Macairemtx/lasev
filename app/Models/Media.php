<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'media_type',
        'file_path',
        'duration',
    ];

    /**
     * Relation polymorphique inverse
     */
    public function mediable()
    {
        return $this->morphTo();
    }
}
