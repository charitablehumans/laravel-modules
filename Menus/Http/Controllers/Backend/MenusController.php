<?php

namespace Modules\Menus\Http\Controllers\Backend;

use Illuminate\Http\Request;
use Modules\Categories\Models\Categories;
use Modules\Menus\Models\Menus;
use Modules\Posts\Models\Posts;
use Modules\Termmetas\Models\Termmetas;

class MenusController extends \Modules\Terms\Http\Controllers\Backend\TermsController
{
    protected $model;

    public function __construct()
    {
        $this->model = new Menus;
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
        $request->query('limit') ?: $request->query->set('limit', config('cms.database.eloquent.model.per_page'));

        $data['model'] = $this->model;
        $data['terms'] = $this->model::search($request->query())->paginate($request->query('limit'));

        if ($request->query('action')) { $this->model->action($request->query()); return redirect()->back(); }

        return view('menus::backend/index', $data);
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
        return view('menus::backend/create', $data);
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
        return view('menus::backend/edit', $data);
    }
}
