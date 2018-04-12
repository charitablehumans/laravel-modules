<?php

namespace Modules\Doku\Http\Middleware;

use Closure;
use Illuminate\Http\Response;
use Illuminate\Http\Request;

class CheckIpAddressDoku
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (\Config::get('doku.production')) {
            if ($_SERVER['REMOTE_ADDR'] != \Config::get('doku.ip_address')) {
                return response()->json(['message' => trans('cms::cms.invalid_ip_address')], Response::HTTP_UNAUTHORIZED);
            }
        }

        return $next($request);
    }
}
