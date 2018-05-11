<?php

namespace Modules\ProductCategories\Providers;

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
                'frontend/default/pages/product_categories/breadcrumb',
                'cms::frontend/default/pages/product_categories/breadcrumb',
            ],
            '\Modules\Cms\Http\ViewComposers\Frontend\Pages\ProductCategories\BreadcrumbComposer'
        );

        View::composer(
            [
                'frontend/default/pages/product_categories/left_product_categories',
                'cms::frontend/default/pages/product_categories/left_product_categories',
            ],
            '\Modules\Cms\Http\ViewComposers\Frontend\Pages\ProductCategories\LeftProductCategoriesComposer'
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
