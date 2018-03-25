<?php

namespace Modules\Authentication\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Modules\Users\Models\Users;

class AuthenticationController extends Controller
{
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

        if (Auth::attempt($request->only('email', 'password'), $request->has('remember'))) {
            return redirect()->intended(route('frontend'));
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
        Auth::logout();

        $request->session()->invalidate();

        return redirect('/');
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

    public function passwordResetStore(\Modules\Authentication\Http\Requests\Api\PasswordResetStoreRequest $request)
    {
        $user = Users::where('email', $request->input('email'))->where('verification_code', $request->input('verification_code'))->firstOrFail();
        $user->password = Hash::make($request->input('password'));
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
        $user->password = Hash::make($user->password);
        $user->verified = 0;
        $user->verification_code = rand(111111, 999999);
        $user->save();
        Auth::login($user);
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
