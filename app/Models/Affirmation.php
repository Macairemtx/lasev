<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Affirmation extends Model
{
    protected $fillable = [
        'category_id',
        'title',
        'body',
    ];

    /**
     * Relation avec la catégorie
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(AffirmationCategory::class, 'category_id');
    }
}
