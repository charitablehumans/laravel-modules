<?php

namespace Modules\Ipay88\Http\Middleware;

use Closure;
use Illuminate\Http\Response;
use Illuminate\Http\Request;

class CheckIpAddressIpay88
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
        if (\Config::get('ipay88.mode') == 'production') {
            if ($_SERVER['REMOTE_ADDR'] != \Config::get('ipay88.ip_address')) {
                return response()->json(['message' => trans('cms::cms.invalid_ip_address')], Response::HTTP_UNAUTHORIZED);
            }
        }

        return $next($request);
    }
}
