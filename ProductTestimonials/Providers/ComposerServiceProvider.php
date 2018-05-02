<?php

namespace Modules\ProductTestimonials\Providers;

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
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        \View::composer(
            [
                'frontend/default/pages/home/product_testimonials/latest/carousel',
                'cms::frontend/default/pages/home/product_testimonials/latest/carousel',
            ],
            '\Modules\Cms\Http\ViewComposers\Frontend\Pages\Home\ProductTestimonials\Latest\CarouselComposer'
        );
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
