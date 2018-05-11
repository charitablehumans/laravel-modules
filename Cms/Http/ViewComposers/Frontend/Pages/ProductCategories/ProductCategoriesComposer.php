<?php

namespace Modules\Cms\Http\ViewComposers\Frontend\Pages\ProductCategories;

use Illuminate\View\View;
use Modules\Menus\Models\Menus;

class ProductCategoriesComposer
{
    /**
     * Bind data to the view.
     * pages/product_categories/product_categories
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $data['pages']['product_categories']['product_categories'] = [];

        if ($menu = Menus::search(['slug' => 'frontend-product-categories-product-categories-left'])->first()) {
            if ($nestable = $menu->getTermmetaNestable()) {
                $nestable = (new Menus)->generateAsArray($nestable);
                $data['pages']['product_categories']['product_categories']['html'] = $this->generateHtml($nestable);
            }
        }

        $view->with($data);
    }

    public function generateHtml($nestable)
    {
        $html = '';

        foreach ($nestable as $item) {
            $data = $item;
            $data['composer'] = $this;
            $html .= \View::make('cms::frontend/default/pages/product_categories/product_categories_template', $data)->render();
        }

        return $html;
    }
}
