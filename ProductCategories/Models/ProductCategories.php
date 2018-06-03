<?php

namespace Modules\ProductCategories\Models;

use Modules\Terms\Models\Terms;
use Modules\Terms\Scopes\TaxonomyScope;

class ProductCategories extends Terms
{
    protected $attributes = ['taxonomy' => 'product_category'];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new TaxonomyScope);
    }

    public function getTemplateOptions()
    {
        $templateOptions['default'] = trans('cms::cms.default');

        if ($additionalTemplateOptions = \Config::get('cms.product_categories.postmetas.template_options')) {
            foreach ($additionalTemplateOptions as $template => $enable) {
                $enable ? $templateOptions[$template] = trans('cms::cms.'.$template) : '';
            }
        }

        return $templateOptions;
    }
}
