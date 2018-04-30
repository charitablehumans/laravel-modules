<?php

namespace Modules\ProductTestimonials\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\ProductTestimonials\Models\ProductTestimonials;

class ProductTestimonialsController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return view('producttestimonials::index');
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show($id)
    {
        $data['post'] = $post = ProductTestimonials::getPostById($id);

        return view()->first(
            [
                'frontend/default/pages/templates/'.$post->getPostmetaValue('template'),
                'cms::frontend/default/pages/templates/'.$post->getPostmetaValue('template'),
                'cms::frontend/default/pages/templates/default',
            ],
            $data
        );
    }
}
