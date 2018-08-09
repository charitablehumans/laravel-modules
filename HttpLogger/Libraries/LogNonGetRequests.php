<?php

namespace Modules\HttpLogger\Libraries;

use Illuminate\Http\Request;

class LogNonGetRequests implements \Spatie\HttpLogger\LogProfile
{
    public function shouldLogRequest(Request $request): bool
    {
        return in_array(strtolower($request->method()), ['get', 'post', 'put', 'patch', 'delete']);
    }
}
