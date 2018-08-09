<?php

namespace Modules\HttpLogger\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Modules\HttpLogger\Models\HttpLoggerRequest;
use Modules\HttpLogger\Models\HttpLoggerResponse;

class HttpLogger
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
        return $next($request);
    }

    public function terminate($request, $response)
    {
        $httpLoggerRequest = new HttpLoggerRequest;
        $httpLoggerRequest->createRequest($request);

        $httpLoggerResponse = new HttpLoggerResponse;
        $httpLoggerResponse->createResponse($response, $httpLoggerRequest->uuid);
    }
}
