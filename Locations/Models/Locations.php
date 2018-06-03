<?php

namespace Modules\Locations\Models;

use Illuminate\Database\Eloquent\Builder;

class Locations extends \Modules\Posts\Models\Posts
{
    protected $attributes = [
        'type' => 'location',
        'status' => 'publish'
    ];

    protected $with = [
        'postLocation',
        'translations'
    ];

    protected static function boot()
    {
        parent::boot();

        self::deleting(function ($model) {
            $model->postLocation()->delete();
        });

        static::addGlobalScope('status_deleted', function (Builder $builder) { \Auth::check() && \Auth::user()->can('backend locations trash') ?: $builder->where('status', '<>', 'trash'); });
    }

    public function getAddress()
    {
        $address = '';
        $address = $this->postLocation ? $this->postLocation->address : $address;
        $address = is_array(request()->old('post_locations.address')) ? request()->old('post_locations.address') : $address;
        return $address;
    }

    public function getLatitude()
    {
        $latitude = '';
        $latitude = $this->postLocation ? $this->postLocation->latitude : $latitude;
        $latitude = is_array(request()->old('post_locations.latitude')) ? request()->old('post_locations.latitude') : $latitude;
        return $latitude;
    }

    public function getLongitude()
    {
        $longitude = '';
        $longitude = $this->postLocation ? $this->postLocation->longitude : $longitude;
        $longitude = is_array(request()->old('post_locations.longitude')) ? request()->old('post_locations.longitude') : $longitude;
        return $longitude;
    }

    public function postLocation()
    {
        return $this->hasOne('\Modules\Locations\Models\PostLocations', 'post_id', 'id');
    }
}
