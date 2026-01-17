<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserObjective extends Model
{
    protected $fillable = [
        'user_id',
        'objective_id',
    ];

    /**
     * Relation avec l'utilisateur
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relation avec l'objectif
     */
    public function objective()
    {
        return $this->belongsTo(Objective::class);
    }
}
