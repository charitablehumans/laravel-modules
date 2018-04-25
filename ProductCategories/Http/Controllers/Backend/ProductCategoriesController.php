<?php

namespace Modules\ProductCategories\Http\Controllers\Backend;

use Illuminate\Http\Request;
use Modules\ProductCategories\Models\ProductCategories;
use Modules\Termmetas\Models\Termmetas;

class ProductCategoriesController extends \Modules\Terms\Http\Controllers\Backend\TermsController
{
    protected $model;

    public function __construct()
    {
        $this->model = new ProductCategories;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $request->query('locale') ?: $request->query->set('locale', config('app.locale'));
        $request->query('sort') ?: $request->query->set('sort', 'name:asc');
        $request->query('limit') ?: $request->query->set('limit', 10);

        $data['model'] = $this->model;
        $data['terms'] = $this->model::search($request->query())->paginate($request->query('limit'));

        if ($request->query('action')) { $this->model->action($request->query()); return redirect()->back(); }

        return view('productcategories::backend/product_categories/index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['term'] = $this->model;
        $data['term_translation'] = $this->model;
        return view('productcategories::backend/product_categories/create', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, Request $request)
    {
        $data['term'] = $term = $this->model::findOrFail($id);
        $data['term_translation'] = $term->translateOrNew($request->query('locale'));
        return view('productcategories::backend/product_categories/edit', $data);
    }
}
