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
        $user->name = $socialite->getName();
        $user->save();

        $usersSocialite = self::firstOrCreate(['user_id' => $user->id, 'client_id' => $socialite->id]);
        $usersSocialite->provider = $provider;
        $usersSocialite->client_id = $socialite->id;
        $usersSocialite->provider = $provider;
        $usersSocialite->email = $socialite->email;
        $usersSocialite->data = json_encode($socialite->user);
        $usersSocialite->save();

        return $user;
    }
}
