<?php

namespace Modules\Cms\Http\ViewComposers\Frontend\Pages\ProductCategories;

use Illuminate\View\View;
use Modules\Products\Models\Products;

class LeftProductCategoriesComposer
{
    /**
     * Bind data to the view.
     * pages/product_categories/left_product_categories
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $data['pages']['product_categories']['left_product_categories'] = [];

        if ($productCategories = (new Products)->getCategoriesTree())
        {
            foreach ($productCategories as $i => $productCategory)
            {
                $data['pages']['product_categories']['left_product_categories'][$i]['href'] = route('frontend.product-categories.index', $productCategory['slug']);
                $data['pages']['product_categories']['left_product_categories'][$i]['name'] = $productCategory['name'];
                $data['pages']['product_categories']['left_product_categories'][$i]['tree_prefix'] = $productCategory['tree_prefix'];
            }
        }

        $view->with($data);
    }
}
