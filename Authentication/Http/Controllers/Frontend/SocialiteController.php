<?php

namespace Modules\Authentication\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\UserSocialites\Models\UserSocialites;

class SocialiteController extends Controller
{
    /**
     * Redirect the user to the GitHub authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToProvider($provider)
    {
        return \Socialite::driver($provider)->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback($provider)
    {
        $socialite = \Socialite::driver($provider)->user();

        if ($user = (new UserSocialites)->findOrCreate($socialite, $provider)) {
            if ($roleDefault = \Config::get('cms.users.role_default')) {
                $user->assignRole($roleDefault);
            }

            \Auth::login($user);
            return redirect()->route('frontend');
        }
    }
}
