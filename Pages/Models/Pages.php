<?php

namespace Modules\Pages\Models;

use Illuminate\Database\Eloquent\Builder;

class Pages extends \Modules\Posts\Models\Posts
{
    protected $attributes = [
        'type' => 'page',
        'status' => 'publish',
    ];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('type', function (Builder $builder) { $builder->where('type', 'page'); });
        static::addGlobalScope('status_deleted', function (Builder $builder) { \Auth::check() && \Auth::user()->can('backend pages trash') ?: $builder->where('status', '<>', 'trash'); });
    }

    public function getTemplateOptions()
    {
        $templateOptions['default'] = trans('cms::cms.default');

        if ($additionalTemplateOptions = \Config::get('cms.pages.postmetas.template_options')) {
            foreach ($additionalTemplateOptions as $template => $enable) {
                $enable ? $templateOptions[$template] = trans('cms::cms.'.$template) : '';
            }
        }

        return $templateOptions;
    }
}
