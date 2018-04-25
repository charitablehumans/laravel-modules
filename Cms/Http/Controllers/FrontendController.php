<?php

namespace Modules\Cms\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Options\Models\Options;
use Modules\Pages\Models\Pages;

class FrontendController extends Controller
{
    public function index()
    {
        $data['frontendHomePage'] = $frontendHomePage = Options::getOptionByName('frontend_home_page');
        $data['post'] = $page = Pages::getPostById($frontendHomePage->value);

        return view()->first(
            [
                'frontend/default/pages/templates/'.$page->getPostmetaValue('template'),
                'cms::frontend/default/pages/templates/'.$page->getPostmetaValue('template'),
                'cms::frontend/default/pages/templates/home',
            ],
            $data
        );
    }
}
