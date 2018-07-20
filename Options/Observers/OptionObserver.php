<?php

namespace Modules\Options\Observers;

use Modules\Options\Models\Options;

class OptionObserver
{
    public function saved(Options $model)
    {
        \Cache::forget($model->getTable().'-name-'.$model->name);
    }

    public function deleted(Options $model)
    {
        \Cache::forget($model->getTable().'-name-'.$model->name);
    }
}
