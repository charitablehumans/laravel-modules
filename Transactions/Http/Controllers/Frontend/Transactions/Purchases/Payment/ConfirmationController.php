<?php

namespace Modules\Transactions\Http\Controllers\Frontend\Transactions\Purchases\Payment;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Pages\Models\Pages;
use Modules\Transactions\Models\Transactions\Sales;

class ConfirmationController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request)
    {
        $data['bankAccountsPage'] = Pages::select((new Pages)->getTable().'.*')->search(['template' => 'bank_accounts'])->firstOrFail();
        $data['transaction'] = Sales::findOrFail($request->query('id'));
        return view('transactions::frontend/transactions/purchases/payment/confirmation/index', $data);
    }
}
