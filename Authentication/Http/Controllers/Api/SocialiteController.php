<?php

namespace Modules\Authentication\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

class SocialiteController extends Controller
{
    public function registerStore(\Modules\Authentication\Http\Requests\Api\Socialite\RegisterStoreRequest $request)
    {
        $provider = $request->input('provider');
        $socialite = (object) $request->input();

        if ($user = (new \Modules\UserSocialites\Models\UserSocialites)->findOrCreate($socialite, $provider)) {
            $user->access_token = \Hash::make(time());
            $user->verified = 1;
            $user->save();

            if ($roleDefault = \Config::get('cms.users.role_default')) {
                $user->syncRoles($roleDefault);
            }

            $data['access_token'] = $user->access_token;
            return response()->json($data);
        }
    }
}
