<?php

namespace Modules\Products\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function boot()
    {
        View::composer(
            [
                'frontend/default/pages/home/products/new_arrival',
                'cms::frontend/default/pages/home/products/new_arrival',
            ],
            '\Modules\Cms\Http\ViewComposers\Frontend\Pages\Home\Products\NewArrivalComposer'
        );

        View::composer(
            [
                'frontend/default/pages/product_categories/products',
                'cms::frontend/default/pages/product_categories/products',
            ],
            '\Modules\Cms\Http\ViewComposers\Frontend\Pages\ProductCategories\ProductsComposer'
        );
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }
}
