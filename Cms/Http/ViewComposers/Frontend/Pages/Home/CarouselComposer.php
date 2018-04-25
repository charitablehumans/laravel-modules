<?php

namespace Modules\Cms\Http\ViewComposers\Frontend\Pages\Home;

use Illuminate\View\View;
use Modules\Menus\Models\Menus;

class CarouselComposer
{
    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $data['frontendPagesHomeCarousel'] = false;

        if ($menu = Menus::search(['slug' => 'frontend-home-carousels'])->first()) {
            if ($nestable = $menu->getTermmetaNestable()) {
                $data['frontendPagesHomeCarousel'] = (new Menus)->generateAsArray($nestable);
            }
        }

        $view->with($data);
    }
}
