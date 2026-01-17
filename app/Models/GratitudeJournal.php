<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GratitudeJournal extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'positive_thing_1',
        'positive_thing_2',
        'positive_thing_3',
        'journal_date',
    ];

    protected $casts = [
        'journal_date' => 'date',
    ];

    /**
     * Relation avec l'utilisateur
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
