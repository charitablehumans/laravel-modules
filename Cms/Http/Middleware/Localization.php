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
        $locale = false;
        $locales = array_keys(config('app.languages'));

        if ($request->expectsJson()) {
            $locale = $request->header('Accept-Language') ? $request->header('Accept-Language') : $locale;
        } else {
            $locale = $request->session()->get('locale') ? $request->session()->get('locale') : $locale;
        }

        if (in_array($locale, $locales)) {
            app()->setLocale($locale);
        }

        return $next($request);
    }
}
