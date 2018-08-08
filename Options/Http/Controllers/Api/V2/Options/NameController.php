<?php

namespace Modules\Options\Http\Controllers\Api\V2\Options;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Options\Models\Options;

class NameController extends Controller
{
    /**
     * Show the specified resource.
     * @return Response
     */
    public function show(Request $request)
    {
        $option = Options::firstByName($request->query('name'));
        return response()->json($option);
    }
}
