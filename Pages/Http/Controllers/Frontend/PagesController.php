<?php

namespace Modules\Pages\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Pages\Models\Pages;

class PagesController extends Controller
{
    public function show($name)
    {
        $data['post'] = $post = Pages::getPostByName($name);

        return view()->first(
            [
                'frontend/default/pages/templates/'.$post->getPostmetaValue('template'),
                'cms::frontend/default/pages/templates/'.$post->getPostmetaValue('template'),
                'cms::frontend/default/pages/templates/default',
            ],
            $data
        );
    }
}
