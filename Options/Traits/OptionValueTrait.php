<?php

namespace Modules\Options\Traits;

trait OptionValueTrait
{
    public function getPosts()
    {
        return \Modules\Posts\Models\Posts::search(['status' => 'publish', 'sort' => 'title:asc'])->get();
    }
}
