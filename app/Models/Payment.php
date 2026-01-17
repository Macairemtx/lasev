<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'retreat_plan_id',
        'user_id',
        'amount',
        'currency',
        'status',
        'payment_method',
        'transaction_id',
        'paid_at',
    ];

    protected $casts = [
        'paid_at' => 'datetime',
    ];

    public function retreatPlan()
    {
        return $this->belongsTo(RetreatPlan::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
