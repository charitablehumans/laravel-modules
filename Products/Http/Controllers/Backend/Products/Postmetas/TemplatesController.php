<?php

namespace Modules\Products\Http\Controllers\Backend\Products\Postmetas;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Products\Models\Products;

class TemplatesController extends Controller
{
    public function index(Request $request)
    {
        $data['post'] = new Products;

        return \View::first(
            [
                'products::backend/products/postmetas/templates/'.$request->query('template'),
                'products::backend/products/postmetas/templates/default',
            ],
            $data
        );
    }
}
