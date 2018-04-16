<?php

namespace Modules\Transactions\Http\Controllers\Api\Transactions\Sales;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Transactions\Models\Transactions\Sales;

class StatusController extends Controller
{
    public function index()
    {
        return (new Sales)->getStatusOptions();
    }
}
