<?php

namespace Modules\UserBalanceHistories\Models;

use Illuminate\Database\Eloquent\Model;

class UserBalanceHistories extends Model
{
    protected $fillable = [
        // 'id',
        'user_id',
        'type',
        'reference_id',
        'balance_start',

        'balance',
        'balance_end',
        'notes',
    ];

    protected $table = 'user_balance_histories';
}
