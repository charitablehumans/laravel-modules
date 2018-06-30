<?php

namespace Modules\Theme\Http\Controllers\Backend;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

class ThemeController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return view()->first([
            'theme::backend/theme/index/'.config('cms.theme.frontend'),
            'theme::backend/theme/index/default',
        ]);
    }
}
