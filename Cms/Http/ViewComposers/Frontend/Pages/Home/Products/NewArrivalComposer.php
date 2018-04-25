<?php

namespace Modules\Cms\Http\ViewComposers\Frontend\Pages\Home\Products;

use Illuminate\View\View;
use Modules\Products\Models\Products;

class NewArrivalComposer
{
    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $data['frontendPagesHomeProductsNewArrival'] = Products::search(['status' => 'publish'])->latest()->limit(6)->get();

        $view->with($data);
    }
}
