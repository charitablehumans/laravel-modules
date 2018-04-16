<?php

namespace Modules\DokuMyshortcart\Http\Middleware;

use Closure;
use Illuminate\Http\Response;
use Illuminate\Http\Request;

class CheckIpAddressDokuMyshortcart
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
        if (\Config::get('dokumyshortcart.production')) {
            if ($_SERVER['REMOTE_ADDR'] != \Config::get('dokumyshortcart.ip_address')) {
                return response()->json(['message' => trans('cms::cms.invalid_ip_address')], Response::HTTP_UNAUTHORIZED);
            }
        }

        return $next($request);
    }
}
