<?php

namespace Modules\Pages\Models;

use Illuminate\Database\Eloquent\Builder;

class Pages extends \Modules\Posts\Models\Posts
{
    protected $attributes = [
        'type' => 'page',
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
        \Config::get('cms.pages.postmetas.template_options.bank_accounts') ? $templateOptions['bank_accounts'] = trans('cms::cms.bank_accounts') : '';
        \Config::get('cms.pages.postmetas.template_options.cnr_cash') ? $templateOptions['cnr_cash'] = trans('cms::cms.cnr_cash') : '';
        \Config::get('cms.pages.postmetas.template_options.home') ? $templateOptions['home'] = trans('cms::cms.home') : '';
        \Config::get('cms.pages.postmetas.template_options.new_arrival') ? $templateOptions['new_arrival'] = trans('cms::cms.new_arrival') : '';
        return $templateOptions;
    }
}
