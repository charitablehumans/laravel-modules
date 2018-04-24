<?php

namespace Modules\Options\Traits;

trait OptionValueTrait
{
    public function getPages()
    {
        return \Modules\Pages\Models\Pages::search(['status' => 'publish', 'sort' => 'title:asc'])->get();
    }

    public function getPosts()
    {
        return \Modules\Posts\Models\Posts::search(['status' => 'publish', 'sort' => 'title:asc'])->get();
    }
}
