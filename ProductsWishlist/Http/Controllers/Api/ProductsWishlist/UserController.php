<?php

namespace Modules\ProductsWishlist\Http\Controllers\Api\ProductsWishlist;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\ProductsWishlist\Http\Requests\Api\ProductsWishlist\User\StoreRequest;
use Modules\ProductsWishlist\Http\Resources\ProductWishlistResource;
use Modules\ProductsWishlist\Models\ProductsWishlist;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request)
    {
        $request->query('per_page') ?: $request->query->set('per_page', 10);

        $search = $request->query();
        $search['user_id'] = \Auth::user()->id;
        $productsWishlist = ProductsWishlist::search($search)->paginate($request->query('per_page'));
        return ProductWishlistResource::collection($productsWishlist);
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(StoreRequest $request)
    {
        $productWishlist = ProductsWishlist::firstOrCreate(['user_id' => \Auth::user()->id, 'post_id' => $request->input('product_id')]);
        return new ProductWishlistResource($productWishlist);
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy(StoreRequest $request)
    {
        $productWishlist = ProductsWishlist::search(['user_id' => \Auth::user()->id, 'post_id' => $request->input('product_id')])->firstOrFail();
        $productWishlist->delete();
        return new ProductWishlistResource($productWishlist);
    }
}
