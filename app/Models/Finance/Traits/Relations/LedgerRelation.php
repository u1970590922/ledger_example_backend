<?php

namespace App\Models\Finance\Traits\Relations;

use App\Models\Auth\User;

trait LedgerRelation
{
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}