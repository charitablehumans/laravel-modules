<?php

namespace Modules\Ravintola\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Options\Models\Options;
use Modules\Users\Models\Users;

class RavintolaUserVouchers extends Model
{
    protected $attributes = [
        'status' => 'new',
    ];

    protected $fillable = [
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
        'transaction_deductible',

        'transaction_remaining_amount',
        'data',
    ];

    protected $table = 'ravintola_user_vouchers';

    public function getValueMaxOption()
    {
        $valueMaxOption = 0;

        if ($option = Options::firstByName('Modules/Ravintola/Http/Controllers/Api/V1/Voucher/QueryVoucherController/ValueMax')) {
            $valueMaxOption = $option->value;
        }

        return $valueMaxOption;
    }

    public function user()
    {
        return $this->belongsTo(Users::class, 'user_id');
    }
}
