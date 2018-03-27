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

    public function primaryUpdate($id)
    {
        $userAddress = self::findOrFail($id);

        self::where('user_id', $userAddress->user_id)->update(['primary' => '0']);

        $userAddress = self::findOrFail($id);
        $userAddress->primary = '1';
        $userAddress->save();

        return $userAddress;
    }

    public function user()
    {
        return $this->belongsTo('\App\Http\Models\Users', 'user_id');
    }
}
