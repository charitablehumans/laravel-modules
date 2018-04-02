<?php

namespace Modules\Locations\Models;

use Illuminate\Database\Eloquent\Model;

class PostLocations extends Model
{
    use \Malhal\Geographical\Geographical;

    protected $fillable = [
        'post_id', 'address', 'latitude', 'longitude',
    ];

    protected $table = 'post_locations';

    protected static $kilometers = true;

    public function location()
    {
        return $this->belongsTo('\Modules\Locations\Models\Locations', 'post_id', 'id');
    }

    public function scopeSearch($query, $params)
    {
        isset($params['address']) ? $query->where('id', 'like', '%'.$params['id'].'%') : '';
        isset($params['latitude']) && isset($params['longitude']) ? $query->distance($params['latitude'], $params['longitude']) : '';

        // post
        isset($params['location_status']) ? $query->whereHas('location', function ($query) use ($params) { $query->where('status', $params['location_status']); }) : '';

        if (isset($params['sort']) && $sort = explode(':', $params['sort'])) {
            count($sort) == 2 ? $query->orderBy($sort[0], $sort[1]) : '';
        }

        return $query;
    }

    public function sync($data, $postId)
    {
        $postLocation = self::firstOrCreate(['post_id' => $postId]);
        $postLocation->fill($data);
        $postLocation->save();
    }
}
