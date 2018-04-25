<?php

namespace Modules\Cms\Http\ViewComposers\Frontend\Pages\Home;

use Illuminate\View\View;
use Modules\Menus\Models\Menus;

class ServicesComposer
{
    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $data['frontendPagesHomeServices'] = false;

        if ($menu = Menus::search(['slug' => 'frontend-home-services'])->first()) {
            if ($nestable = $menu->getTermmetaNestable()) {
                $frontendPagesHomeServices = (new Menus)->generateAsArray($nestable);
                $data['frontendPagesHomeServices'] = array_slice($frontendPagesHomeServices, 0, 4);
            }
        }

        $view->with($data);
    }
}
