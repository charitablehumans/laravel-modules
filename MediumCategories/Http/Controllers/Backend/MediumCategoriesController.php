<?php

namespace Modules\MediumCategories\Http\Controllers\Backend;

use Illuminate\Http\Request;
use Modules\MediumCategories\Models\MediumCategories;
use Modules\Termmetas\Models\Termmetas;
use Modules\Terms\Http\Controllers\Backend\TermsController;

class MediumCategoriesController extends TermsController
{
    protected $model;

    public function __construct()
    {
        $this->model = new MediumCategories;
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

        $data['terms'] = $this->model::search($request->query())->paginate($request->query('limit'));
        $data['model'] = $this->model;

        if ($request->query('action')) { $this->model->action($request->query()); return redirect()->back(); }

        return view('mediumcategories::backend/index', $data);
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
        return view('mediumcategories::backend/create', $data);
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
        return view('mediumcategories::backend/edit', $data);
    }
}
