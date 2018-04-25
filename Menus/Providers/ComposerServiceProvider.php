<?php

namespace Modules\Menus\Providers;

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
                'frontend/default/pages/home/carousel',
                'cms::frontend/default/pages/home/carousel',
            ],
            '\Modules\Cms\Http\ViewComposers\Frontend\Pages\Home\CarouselComposer'
        );

        View::composer(
            [
                'frontend/default/pages/home/services',
                'cms::frontend/default/pages/home/services',
            ],
            '\Modules\Cms\Http\ViewComposers\Frontend\Pages\Home\ServicesComposer'
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
