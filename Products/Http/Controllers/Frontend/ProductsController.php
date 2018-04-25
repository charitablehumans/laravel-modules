<?php

namespace Modules\Products\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Products\Models\Products;

class Frontend/ProductsController extends Controller
{
    public function show($name)
    {
        $data['product'] = Products::search(['name' => $name])->firstOrFail();
        return view()->first(
            [
                'frontend/default/products/show',
                'cms::frontend/default/products/show',
            ],
            $data
        );
    }
}
