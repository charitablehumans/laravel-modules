<?php

namespace Modules\Authentication\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Options\Models\Options;
use Modules\Users\Models\Users;

class AuthenticationController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest')->except('logoutStore');
    }

    public function login()
    {
        return view('authentication::frontend/login');
    }

    public function loginStore(\Modules\Authentication\Http\Requests\Api\LoginStoreRequest $request)
    {
        $request->validate([
            'email' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        if (\Auth::attempt($request->only('email', 'password'), $request->has('remember'))) {

            return redirect()->back();
        } else {
            return redirect()->back()->withErrors(['email' => [trans('auth.failed')]]);
        }
    }

    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logoutStore(Request $request)
    {
        \Auth::logout();

        $request->session()->invalidate();

        return redirect()->back();
    }

    public function passwordForgot()
    {
        return view('authentication::frontend/password/forgot');
    }

    public function passwordForgotStore(\Modules\Authentication\Http\Requests\Api\PasswordForgotStoreRequest $request)
    {
        $user = Users::where('email', $request->input('email'))->firstOrFail();
        $user->verification_code = rand(111111, 999999);
        $user->save();

        $user->notify(new \Modules\Authentication\Notifications\PasswordResetLink($user));

        flash(trans('passwords.sent'))->success()->important();
        return view('authentication::frontend/password/forgot');
    }

    public function passwordReset(Request $request)
    {
        $data['user'] = Users::where('email', $request->query('email'))->where('verification_code', $request->query('verification_code'))->firstOrFail();
        return view('authentication::frontend/password/reset', $data);
    }

    public function passwordResetUpdate(\Modules\Authentication\Http\Requests\Api\PasswordResetUpdateRequest $request)
    {
        $user = Users::where('email', $request->input('email'))->where('verification_code', $request->input('verification_code'))->firstOrFail();
        $user->password = \Hash::make($request->input('password'));
        $user->save();
        flash(trans('passwords.reset'))->success()->important();
        return redirect()->route('frontend.authentication.login');
    }

    public function register()
    {
        return view('authentication::frontend/register');
    }

    public function registerStore(\Modules\Authentication\Http\Requests\Api\RegisterStoreRequest $request)
    {
        $user = new Users();
        $user->fill($request->input());
        $user->password = \Hash::make($user->password);
        $user->verified = 0;
        $user->verification_code = rand(111111, 999999);
        $user->balance = Options::getByName('cms.users.balance_default') ? Options::getByName('cms.users.balance_default')->value : \Config::get('cms.users.balance_default');
        $user->game_token = \Config::get('cms.users.game_token_default');
        $user->save();

        if ($roleDefault = \Config::get('cms.users.role_default')) {
            $user->assignRole($roleDefault);
        }

        \Auth::login($user);
        return redirect()->route('frontend');
    }

    public function verify(Request $request)
    {
        $data['user'] = Users::where('email', $request->query('email'))->firstOrFail();
        return view('authentication::frontend/verify', $data);
    }

    public function verifyStore(\Modules\Authentication\Http\Requests\Api\VerifyStoreRequest $request)
    {
        $user = Users::where('email', $request->input('email'))->firstOrFail();
        $user->verified = 1;
        $user->save();
        flash(trans('cms::cms.verification_success'))->success()->important();
        return redirect()->route('frontend');
    }
}
