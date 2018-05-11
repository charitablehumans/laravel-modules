<?php

namespace Modules\Cms\Http\ViewComposers\Frontend\Pages\ProductCategories;

use Illuminate\View\View;
use Modules\Products\Models\Products;

class ProductsComposer
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
        \Request::query('limit') ?: \Request::instance()->query->set('limit', 12);

        $productCategoriesSlugs = \Request::route()->parameter('productCategories') ? explode('/', \Request::route()->parameter('productCategories')) : [];
        $search = \Request::query();
        $search['category_slug'] = collect($productCategoriesSlugs)->last();
        $search['status'] = 'publish';

        if ($products = Products::select((new Products)->getTable().'.*')->search($search)->paginate(\Request::query('limit')))
        {
            $data['pages']['product_categories']['products']['lists'] = [];

            foreach ($products as $i => $product)
            {
                $data['pages']['product_categories']['products']['lists'][$i]['id'] = $product->id;
                $data['pages']['product_categories']['products']['lists'][$i]['href'] = route('frontend.products.show', $product->name);
                $data['pages']['product_categories']['products']['lists'][$i]['rating_average'] = (integer) $product->getPostTestimonial()->rating_average;
                $data['pages']['product_categories']['products']['lists'][$i]['rating_count'] = (integer) $product->getPostTestimonial()->rating_count;

                for ($j = 1; $j <= max($product->getPostTestimonial()->getRatingOptions()); $j++)
                {
                    $data['pages']['product_categories']['products']['lists'][$i]['ratings'][$j] = $j;
                }

                $data['pages']['product_categories']['products']['lists'][$i]['sell_price_text'] = \Config::get('cms.currency.symbol.left.default').number_format($product->getPostProductSellPrice());
                $data['pages']['product_categories']['products']['lists'][$i]['title'] = $product->title;
                $data['pages']['product_categories']['products']['lists'][$i]['thumbnail']['img']['alt'] = $product->getPostmetaByKey('images')->getMedium()->title;
                $data['pages']['product_categories']['products']['lists'][$i]['thumbnail']['img']['src'] = \Storage::url($product->getPostmetaByKey('images')->getMedium()->getPostmetaValue('attached_file_thumbnail', true));
            }

            $data['pages']['product_categories']['products']['pagination'] = $products->appends(\Request::query())->links('cms::vendor/pagination/default');

        }

        $data['pages']['product_categories']['slugs'] = explode('/', \Request::route()->parameter('productCategories'));

        $view->with($data);
    }
}
