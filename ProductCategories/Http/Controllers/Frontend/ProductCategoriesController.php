<?php

namespace Modules\ProductCategories\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

class ProductCategoriesController extends Controller
{
    public function index()
    {
        return \View::make('cms::frontend/default/pages/templates/product_categories');
    }
}
