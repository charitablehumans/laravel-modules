<?php

namespace Modules\TransactionShippingAddress\Models;

use Illuminate\Database\Eloquent\Model;

class TransactionShippingAddress extends Model
{
    protected $fillable = [
        // 'id',
        'transaction_id',
        'name',
        'phone_number',
        'province_id',

        'regency_id',
        'district_id',
        'postal_code',
        'address',
    ];

    protected $table = 'transaction_shipping_address';

    public function province()
    {
        return $this->belongsTo('\Modules\Geocodes\Models\Geocodes\Provinces', 'province_id');
    }

    public function regency()
    {
        return $this->belongsTo('\Modules\Geocodes\Models\Geocodes\Regencies', 'regency_id');
    }

    public function transaction()
    {
        return $this->belongsTo('\Modules\Transactions\Models\Transactions', 'transaction_id');
    }
}
