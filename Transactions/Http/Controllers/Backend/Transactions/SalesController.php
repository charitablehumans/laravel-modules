<?php

namespace Modules\Transactions\Http\Controllers\Backend\Transactions;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

class SalesController extends Controller
{
    protected $model;

    public function __construct()
    {
        $this->model = new \Modules\Transactions\Models\Transactions\Sales;
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request)
    {
        $request->query->set('sales_ownership', true);
        $request->query('sort') ?: $request->query->set('sort', 'created_at:desc');
        $request->query('limit') ?: $request->query->set('limit', 10);

        $data['model'] = $this->model;
        $data['transactions'] = $this->model::select($this->model->getTable().'.*')->search($request->query())->paginate($request->query('limit'));

        if ($request->query('action')) { $this->model->action($request->query()); return redirect()->back(); }

        return view('transactions::backend/sales/index', $data);
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('transactions::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show()
    {
        return view('transactions::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit()
    {
        return view('transactions::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(Request $request)
    {
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy()
    {
    }

    public function reject($id)
    {
        (new $this->model)->reject($id);
        flash(trans('cms::cms.data_has_been_returned'))->success()->important();
        return redirect()->back();
    }
}
