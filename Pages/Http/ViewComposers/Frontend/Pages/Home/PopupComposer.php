<?php

namespace Modules\Pages\Http\ViewComposers\Frontend\Pages\Home;

use Illuminate\View\View;
use Modules\Options\Models\Options;
use Modules\Pages\Models\Pages;

class PopupComposer
{
    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $data['frontendHomePopup'] = new Pages;
        if ($option = Options::getOptionByName('frontend_home_popup')) {
            if ($page = Pages::getPostById($option->value)) {
                $data['frontendHomePopup'] = $page;
            }
        }

        $data['frontendHomePopupButtonText'] = new Pages;
        if ($option = Options::getOptionByName('frontend_home_popup_button_text')) {
            if ($page = Pages::getPostById($option->value)) {
                $data['frontendHomePopupButtonText'] = $page->title;
            }
        }

        $data['frontendHomePopupButtonUrl'] = new Pages;
        if ($option = Options::getOptionByName('frontend_home_popup_button_url')) {
            if ($page = Pages::getPostById($option->value)) {
                $data['frontendHomePopupButtonUrl'] = route('frontend.pages.show', $page->name);
            }
        }

        $view->with($data);
    }
}
