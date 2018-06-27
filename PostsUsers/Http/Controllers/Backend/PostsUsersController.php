<?php

namespace Modules\PostsUsers\Http\Controllers\Backend;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class PostsUsersController extends Controller
{
    protected $model;

    public function __construct()
    {
        $this->model = new \Modules\PostsUsers\Models\PostsUsers;
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
        $request->query('limit') ?: $request->query->set('limit', config('cms.database.eloquent.model.per_page'));

        $data['model'] = $this->model;
        $data['posts'] = $this->model::search($request->query())->paginate($request->query('limit'));

        if ($request->query('action')) { $this->model->action($request->query()); return redirect()->back(); }

        return view('postsusers::backend/posts_users/index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['model'] = $this->model;
        return view('postsusers::backend/posts_users/create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(\Modules\PostsUsers\Http\Requests\Backend\PostsUsers\StoreRequest $request)
    {
        $this->model->fill($request->input())->save();
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
        $data['model'] = $this->model::findOrFail($id);
        return view('postsusers::backend/posts_users/edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(\Modules\PostsUsers\Http\Requests\Backend\PostsUsers\StoreRequest $request, $id)
    {
        $model = $this->model::findOrFail($id);
        $model->fill($request->input())->save();
        flash(trans('cms::cms.data_has_been_updated'))->success()->important();
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
}
