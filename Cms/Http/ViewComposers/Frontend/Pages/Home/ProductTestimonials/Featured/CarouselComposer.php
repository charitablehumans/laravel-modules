<?php

namespace Modules\Cms\Http\ViewComposers\Frontend\Pages\Home\ProductTestimonials\Featured;

use Illuminate\View\View;
use Modules\Menus\Models\Menus;

class CarouselComposer
{
    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $data['frontendPagesHomeProductsTestimonialsCarousel'] = false;

        if ($menu = Menus::search(['slug' => 'frontend-home-product-testimonials-featured'])->first()) {
            if ($nestable = $menu->getTermmetaNestable()) {
                $data['frontendPagesHomeProductsTestimonialsCarousel'] = (new Menus)->generateAsArray($nestable);
            }
        }

        $view->with($data);
    }
}
