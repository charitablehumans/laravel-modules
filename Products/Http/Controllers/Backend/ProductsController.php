<?php

namespace Modules\Products\Http\Controllers\Backend;

use Illuminate\Http\Request;
use Modules\Postmetas\Models\Postmetas;
use Modules\PostProducts\Models\PostProducts;

class ProductsController extends \Modules\Posts\Http\Controllers\Backend\PostsController
{
    protected $model;

    public function __construct()
    {
        $this->model = new \Modules\Products\Models\Products;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $request->query('locale') ?: $request->query->set('locale', config('app.locale'));
        $request->query('sort') ?: $request->query->set('sort', 'updated_at:desc');
        $request->query('limit') ?: $request->query->set('limit', config('cms.database.eloquent.model.per_page'));
        $request->query->set('product_ownership', true);

        $data['model'] = $this->model;
        $data['posts'] = $this->model::with(['author', 'postmetas', 'postProduct'])->select($this->model->getTable().'.*')->search($request->query())->paginate($request->query('limit'));

        if ($request->query('action')) { $this->model->action($request->query()); return redirect()->back(); }

        return view('products::backend/index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['post'] = $this->model;
        $data['post_translation'] = $this->model;
        return view('products::backend/create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(\Modules\Posts\Http\Requests\Backend\StoreRequest $request)
    {
        $post = $this->model;
        $attributes = collect($request->input())->only($post->getFillable())->toArray();
        $attributes['author_id'] = $post->getAuthorId();
        foreach (config('app.languages') as $languageCode => $languageName) {
            $attributes[$languageCode] = $request->input();
        }
        $post->fill($attributes)->save();
        (new Postmetas)->sync($request->input('postmetas'), $post->id);
        (new PostProducts)->sync($request->input('post_products'), $post->id);
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
        $data['post'] = $post = $this->model::search(['id' => $id, 'product_ownership' => true])->firstOrFail();
        $data['post_translation'] = $post->translateOrNew($request->query('locale'));
        return view('products::backend/edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(\Modules\Posts\Http\Requests\Backend\UpdateRequest $request, $id)
    {
        $post = $this->model::findOrFail($id);
        $attributes = collect($request->input())->only($post->getFillable())->toArray();
        $attributes['author_id'] = $post->getAuthorId();
        $attributes[$request->input('locale')] = $request->input();
        $post->fill($attributes)->save();
        (new Postmetas)->sync($request->input('postmetas'), $post->id);
        (new PostProducts)->sync($request->input('post_products'), $post->id);
        flash(trans('cms::cms.data_has_been_updated'))->success()->important();
        if ($post->status == 'trash' && ! auth()->user()->can('backend products trash')) { return redirect()->route('backend.products.index'); }
        return redirect()->back();
    }
}
