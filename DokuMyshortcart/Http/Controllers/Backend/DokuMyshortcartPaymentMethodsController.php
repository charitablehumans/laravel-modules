<?php

namespace Modules\DokuMyshortcart\Http\Controllers\Backend;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\DokuMyshortcart\Models\DokuMyshortcartPaymentMethods;

class DokuMyshortcartPaymentMethodsController extends \Modules\Posts\Http\Controllers\Backend\PostsController
{
    protected $model;

    public function __construct()
    {
        $this->model = new DokuMyshortcartPaymentMethods;
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request)
    {
        $request->query('locale') ?: $request->query->set('locale', config('app.locale'));
        $request->query('sort') ?: $request->query->set('sort', 'title:asc');
        $request->query('limit') ?: $request->query->set('limit', config('cms.database.eloquent.model.per_page'));

        $data['model'] = $this->model;
        $data['posts'] = $this->model::select($this->model->getTable().'.*')->search($request->query())->paginate($request->query('limit'));

        if ($request->query('action')) { $this->model->action($request->query()); return redirect()->back(); }

        return view('dokumyshortcart::backend/doku_myshortcart_payment_methods/index', $data);
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        $data['post'] = $this->model;
        $data['post_translation'] = $this->model;
        return view('dokumyshortcart::backend/doku_myshortcart_payment_methods/create', $data);
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit($id, Request $request)
    {
        $data['post'] = $post = $this->model::findOrFail($id);
        $data['post_translation'] = $post->translateOrNew($request->query('locale'));
        return view('dokumyshortcart::backend/doku_myshortcart_payment_methods/edit', $data);
    }
}
