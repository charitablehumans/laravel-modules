<?php

namespace Modules\Cms\Http\ViewComposers\Frontend\Pages\Home\ProductTestimonials;

use Illuminate\View\View;
use Modules\ProductTestimonials\Models\ProductTestimonials;

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
        $data['frontendPagesHomeProductsTestimonialsCarousel'] = ProductTestimonials::with('postTestimonial')->search(['status' => 'publish'])->latest()->limit(6)->get();

        $view->with($data);
    }
}
