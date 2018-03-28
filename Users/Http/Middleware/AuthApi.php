<?php

namespace Modules\Users\Http\Middleware;

use Closure;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Modules\Users\Models\Users;

class AuthApi
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($user = Users::where('access_token', $request->header('Access-Token'))->first()) {
            Auth::login($user);
        } else {
            return response()->json(['message' => trans('auth.failed')], Response::HTTP_UNAUTHORIZED);
        }

        return $next($request);
    }
}
