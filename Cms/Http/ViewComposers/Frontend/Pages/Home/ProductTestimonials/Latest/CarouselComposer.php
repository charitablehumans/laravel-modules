<?php

namespace Modules\Cms\Http\ViewComposers\Frontend\Pages\Home\ProductTestimonials\Latest;

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
        $data['frontendPagesHomeProductsTestimonialsLatestCarousel'] = ProductTestimonials::with('author', 'postTestimonial')->search(['status' => 'publish'])->latest()->limit(6)->get();

        $view->with($data);
    }
}
