<?php

namespace Modules\UserSocialites\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Users\Models\Users;

class UserSocialites extends Model
{
    protected $fillable = [
        'user_id',
        'provider',
        'client_id',
        'code',
        'email',
        'username',
        'data',
    ];

    protected $table = 'user_socialites';

    /**
     * Return user if exists; create and return if doesn't
     *
     * @param $socialite
     * @param $provider
     * @return $user
     */
    public function findOrCreate($socialite, $provider)
    {
        $user = Users::firstOrCreate(['email' => $socialite->email]);
        $user->name = $socialite->name;
        $user->save();

        $userSocialite = self::firstOrCreate(['user_id' => $user->id, 'provider' => $provider, 'client_id' => $socialite->id]);
        $userSocialite->email = $socialite->email;
        $userSocialite->data = json_encode($socialite->user);
        $userSocialite->save();

        return $user;
    }
}
