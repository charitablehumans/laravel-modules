<?php

namespace Modules\DokuMyshortcart\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Transactions\Models\Transactions;

class DokuMyshortcartController extends Controller
{
    public function redirect(Request $request)
    {
        // $data['transaction'] = Transactions::where('id', $request->query('id'))->where('receiver_id', \Auth::user()->id)->firstOrFail();
        $data['transaction'] = Transactions::where('id', $request->query('id'))->firstOrFail();
        return view('dokumyshortcart::frontend/redirect', $data);
    }
}
