<?php

namespace Modules\Cms\Http\Middleware;

use Closure;

class Localization
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
        if ($request->expectsJson() && $locale = $request->header('Accept-Language')) {
            app()->setLocale($locale);
        } else if ($locale = $request->session()->get('locale')) {
            app()->setLocale($locale);
        }

        return $next($request);
    }
}
