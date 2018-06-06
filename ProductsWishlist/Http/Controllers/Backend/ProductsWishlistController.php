<?php

namespace Modules\ProductsWishlist\Http\Controllers\Backend;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class ProductsWishlistController extends Controller
{
    protected $model;

    public function __construct()
    {
        $this->model = new \Modules\ProductsWishlist\Models\ProductsWishlist;
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $request->query('locale') ?: $request->query->set('locale', config('app.locale'));
        $request->query('sort') ?: $request->query->set('sort', 'updated_at:desc');
        $request->query('limit') ?: $request->query->set('limit', 10);

        $data['model'] = $this->model;
        $data['posts'] = $this->model::search($request->query())->paginate($request->query('limit'));

        if ($request->query('action')) { $this->model->action($request->query()); return redirect()->back(); }

        return view('productswishlist::backend/products_wishlist/index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['model'] = $this->model;
        return view('productswishlist::backend/products_wishlist/create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(\Modules\ProductsWishlist\Http\Requests\Backend\ProductsWishlist\StoreRequest $request)
    {
        $this->model->fill($request->input())->save();
        flash(trans('cms::cms.data_has_been_created'))->success()->important();
        return redirect()->back();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, Request $request)
    {
        $data['model'] = $this->model::findOrFail($id);
        return view('productswishlist::backend/products_wishlist/edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(\Modules\ProductsWishlist\Http\Requests\Backend\ProductsWishlist\StoreRequest $request, $id)
    {
        $model = $this->model::findOrFail($id);
        $model->fill($request->input())->save();
        flash(trans('cms::cms.data_has_been_updated'))->success()->important();
        return redirect()->back();
    }
}
