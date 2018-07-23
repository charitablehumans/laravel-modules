<?php

namespace Modules\Options\Http\Controllers\Api\V1\Options;

use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Options\Models\Options;

class NameController extends Controller
{
    /**
     * Show the specified resource.
     * @return Response
     */
    public function show($name)
    {
        $option = Options::firstByName($name);
        return response()->json($option);
    }
}
