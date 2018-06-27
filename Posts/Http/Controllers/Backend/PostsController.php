<?php

namespace Modules\Posts\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Postmetas\Models\Postmetas;

class PostsController extends Controller
{
    protected $model;

    public function __construct()
    {
        $this->model = new \Modules\Posts\Models\Posts;
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

        $data['model'] = $this->model;
        $data['posts'] = $this->model::with(['author', 'postmetas'])->select($this->model->getTable().'.*')->search($request->query())->paginate($request->query('limit'));

        if ($request->query('action')) { $this->model->action($request->query()); return redirect()->back(); }

        return view('posts::backend/index', $data);
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
        return view('posts::backend/create', $data);
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
        $attributes['author_id'] = auth()->user()->id;
        foreach (config('app.languages') as $languageCode => $languageName) {
            $attributes[$languageCode] = $request->input();
        }
        $post->fill($attributes)->save();
        (new Postmetas)->sync($request->input('postmetas'), $post->id);
        flash(trans('cms::cms.data_has_been_created'))->success()->important();
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, Request $request)
    {
        $data['post'] = $post = $this->model::findOrFail($id);
        $data['post_translation'] = $post->translateOrNew($request->query('locale'));
        return view('posts::backend/edit', $data);
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
        $attributes['author_id'] = auth()->user()->id;
        $attributes[$request->input('locale')] = $request->input();
        $post->fill($attributes)->save();
        (new Postmetas)->sync($request->input('postmetas'), $post->id);
        flash(trans('cms::cms.data_has_been_updated'))->success()->important();
        if ($post->status == 'trash' && ! auth()->user()->can('backend posts trash')) { return redirect()->route('backend.posts.index'); }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function delete($id)
    {
        $post = $this->model::search(['id' => $id])->firstOrFail();
        $post->delete();
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
