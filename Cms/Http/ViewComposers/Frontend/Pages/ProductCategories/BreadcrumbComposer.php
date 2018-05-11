<?php

namespace Modules\Cms\Http\ViewComposers\Frontend\Pages\ProductCategories;

use Illuminate\View\View;
use Modules\ProductCategories\Models\ProductCategories;

class BreadcrumbComposer
{
    /**
     * Bind data to the view.
     * pages/product_categories/breadcrumb
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $data['pages']['product_categories']['breadcrumb'] = [];

        if (\Route::currentRouteName() == 'frontend.product-categories.index')
        {
            if ($productCategoriesSlugs = explode('/', \Request::route()->parameter('productCategories')))
            {
                if ($productCategories = ProductCategories::search(['slug_in' => $productCategoriesSlugs])->get())
                {
                    foreach ($productCategories as $i => $productCategory)
                    {
                        $data['pages']['product_categories']['breadcrumb'][$i]['href'] = route('frontend.product-categories.index', $productCategory->slug);
                        $data['pages']['product_categories']['breadcrumb'][$i]['name'] = $productCategory->name;
                    }
                }
            }
        }

        $view->with($data);
    }
}
