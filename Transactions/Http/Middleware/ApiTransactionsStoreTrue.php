<?php

namespace Modules\Transactions\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Options\Models\Options;

class ApiTransactionsStoreTrue
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
        if ($option = Options::firstByName('Modules/Transactions/Http/Controllers/Api/TransactionsController@store')) {
            if ($option->value == '0') {
                $errors = ['message' => trans('cms::cms.under_maintenance')];

                if ($request->expectsJson()) {
                    return response()->json($errors, Response::HTTP_UNAUTHORIZED);
                }
            }
        }

        return $next($request);
    }
}
