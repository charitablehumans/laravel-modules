<?php

namespace Modules\UserAddresses\Models;

use Illuminate\Database\Eloquent\Model;

class UserAddresses extends Model
{
    protected $fillable = [
        'user_id', 'name', 'phone_number', 'province_id', 'regency_id',
        'district_id', 'postal_code', 'address', 'primary',
    ];

    protected $table = 'user_addresses';

    public function getRegencyIdOptions()
    {
        $provinceId = $this->id ? $this->province_id : null;
        return (new \Modules\Geocodes\Models\Geocodes\Regencies)->getIdOptions($provinceId);
    }

    public function getProvinceIdOptions()
    {
        return (new \Modules\Geocodes\Models\Geocodes\Provinces)->getIdOptions();
    }

    public function primaryUpdate($id)
    {
        $userAddress = self::findOrFail($id);

        self::where('user_id', $userAddress->user_id)->update(['primary' => '0']);

        $userAddress = self::findOrFail($id);
        $userAddress->primary = '1';
        $userAddress->save();

        return $userAddress;
    }

    public function province()
    {
        return $this->belongsTo('\Modules\Geocodes\Models\Geocodes\Provinces', 'province_id');
    }

    public function regency()
    {
        return $this->belongsTo('\Modules\Geocodes\Models\Geocodes\Regencies', 'regency_id');
    }

    public function user()
    {
        return $this->belongsTo('\Modules\Users\Models\Users', 'user_id');
    }
}
