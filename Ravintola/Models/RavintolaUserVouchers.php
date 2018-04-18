<?php

namespace Modules\Ravintola\Models;

use Illuminate\Database\Eloquent\Model;

class RavintolaUserVouchers extends Model
{
    protected $attributes = [
        'status' => 'new',
    ];

    protected $fillable = [
        // 'id',
        'user_id',
        'uuid',
        'pos_id',
        'outlet_code',

        'verification_number',
        'phone_number',
        'transaction_amount',
        'signature',
        'expiry',

        'value',
        'used_time',
        'used_outlet',
        'status',
    ];

    protected $table = 'ravintola_user_vouchers';
}
