<?php

namespace Modules\TransactionBillingAddress\Models;

use Illuminate\Database\Eloquent\Model;

class TransactionBillingAddress extends Model
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
    ];

    protected $table = 'transaction_billing_address';

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
