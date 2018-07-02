<?php

namespace Modules\Geocodes\Observers;

use Modules\Geocodes\Models\Geocodes;

class GeocodeObserver
{
    public function saved(Geocodes $model)
    {
        \Cache::forget($model->getTable().'-'.$model->id);
    }

    public function deleted(Geocodes $model)
    {
        \Cache::forget($model->getTable().'-'.$model->id);
    }
}
