<?php

namespace Modules\ProductCategories\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Terms\Models\Terms;

class ProductCategories extends Terms
{
    protected $attributes = ['taxonomy' => 'product_category'];

    protected static function boot()
    {
        parent::boot();

        $table = (new Terms)->getTable();
        static::addGlobalScope('taxonomy', function (Builder $builder) use ($table) { $builder->where($table.'.taxonomy', 'product_category'); });
    }

    public function getTemplateOptions()
    {
        $templateOptions['default'] = trans('cms::cms.default');
        if ($additionalTemplateOptions = \Config::get('cms.product_categories.postmetas.template_options')) {
            foreach ($additionalTemplateOptions as $template => $enable) {
                $templateOptions[$template] = trans('cms::cms.'.$template);
            }
        }
        return $templateOptions;
    }
}
