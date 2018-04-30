<?php

namespace Modules\ProductTestimonials\Http\Controllers\Backend;

use Illuminate\Http\Request;
use Modules\Postmetas\Models\Postmetas;
use Modules\PostTestimonials\Models\PostTestimonials;
use Modules\Products\Models\Products;
use Modules\ProductTestimonials\Models\ProductTestimonials;

class ProductTestimonialsController extends \App\Http\Controllers\Controller
{
    protected $model;

    public function __construct()
    {
        $this->model = new ProductTestimonials;
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
        $request->query('limit') ?: $request->query->set('limit', 10);
        $request->query->set('testimonial_ownership', true);

        $data['model'] = $model = $this->model;
        $data['posts'] = $this->model::with(['author', 'parent', 'postmetas', 'postTestimonial'])->select($this->model->getTable().'.*')->search($request->query())->paginate($request->query('limit'));

        if ($request->query('action')) { $this->model->action($request->query()); return redirect()->back(); }

        return view('producttestimonials::backend/product_testimonials/index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['parent'] = new Products;
        $data['post'] = $this->model;
        $data['post_translation'] = $this->model;
        return view('producttestimonials::backend/product_testimonials/create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(\Modules\ProductTestimonials\Http\Requests\Backend\ProductTestimonials\StoreRequest $request)
    {
        $post = $this->model;
        $attributes = collect($request->input())->only($post->getFillable())->toArray();
        foreach (config('app.languages') as $languageCode => $languageName) {
            $attributes[$languageCode] = $request->input();
        }
        $post->fill($attributes)->save();
        (new Postmetas)->sync($request->input('postmetas'), $post->id);
        PostTestimonials::firstOrCreate(['post_id' => $post->id])->fill($request->input())->save();
        (new ProductTestimonials)->setRatingAverageRecalculate($request->input('parent_id'));
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
        $data['parent'] = new Products;
        $data['post'] = $post = $this->model::search(['id' => $id, 'testimonial_ownership' => true])->firstOrFail();
        $data['post_translation'] = $post->translateOrNew($request->query('locale'));
        return view('producttestimonials::backend/product_testimonials/edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(\Modules\ProductTestimonials\Http\Requests\Backend\ProductTestimonials\StoreRequest $request, $id)
    {
        $post = $this->model::findOrFail($id);
        $attributes = collect($request->input())->only($post->getFillable())->toArray();
        $attributes['author_id'] = $post->getAuthorId();
        $attributes[$request->input('locale')] = $request->input();
        $post->fill($attributes)->save();
        (new Postmetas)->sync($request->input('postmetas'), $post->id);
        PostTestimonials::firstOrCreate(['post_id' => $post->id])->fill($request->input())->save();
        (new ProductTestimonials)->setRatingAverageRecalculate($request->input('parent_id'));
        flash(trans('cms::cms.data_has_been_updated'))->success()->important();
        if ($post->status == 'trash' && ! auth()->user()->can('backend product testimonials trash')) { return redirect()->route('backend.product-testimonials.index'); }
        return redirect()->back();
    }

    public function delete($id)
    {
        $post = $this->model::search(['id' => $id])->firstOrFail();
        $post->delete();
        (new ProductTestimonials)->setRatingAverageRecalculate($post->parent_id);
        flash(trans('cms::cms.data_has_been_deleted'))->success()->important();
        return redirect()->back();
    }

    public function trash($id)
    {
        $post = $this->model::search(['id' => $id])->firstOrFail();
        $post->fill(['status' => 'trash'])->save();
        flash(trans('cms::cms.data_has_been_deleted'))->success()->important();
        return redirect()->back();
    }
}
