<?php

namespace Modules\ProductsWishlist\Http\Controllers\Api\ProductsWishlist\User;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\ProductsWishlist\Http\Requests\Api\ProductsWishlist\User\StoreRequest;
use Modules\ProductsWishlist\Models\ProductsWishlist;

class ExistsController extends Controller
{
    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(StoreRequest $request)
    {
        $data['exists'] = (integer) ProductsWishlist::search(['user_id' => \Auth::user()->id, 'post_id' => $request->input('product_id')])->exists();
        return response()->json($data);
    }
}
