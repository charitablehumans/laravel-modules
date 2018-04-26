<?php

namespace Modules\Cms\Http\ViewComposers\Frontend\Pages\Home\ProductCategories;

use Illuminate\View\View;
use Modules\Menus\Models\Menus;

class FeaturedComposer
{
    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $data['frontendHomeProductCategoriesFeatured'] = false;

        if ($menu = Menus::search(['slug' => 'frontend-home-product-categories-featured'])->first()) {
            if ($nestable = $menu->getTermmetaValues('nestable')) {
                $data['frontendHomeProductCategoriesFeatured'] = (new Menus)->generateAsArray($nestable);
            }
        }

        $view->with($data);
    }
}
