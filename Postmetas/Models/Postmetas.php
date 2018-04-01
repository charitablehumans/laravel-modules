<?php

namespace Modules\Postmetas\Models;

use Illuminate\Database\Eloquent\Model;

class Postmetas extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'post_id', 'key', 'value',
    ];

    protected $table = 'postmetas';

    public function scopeSearch($query, $params)
    {
        isset($params['post_id']) ? $query->where('post_id', $params['post_id']) : '';

        return $query;
    }

    public function sync($metas = [], $postId)
    {
        $ids = [];

        if ($metas) {
            foreach ($metas as $key => $value) {
                $value = is_array($value) ? json_encode(array_filter($value)) : $value;

                if ($meta = self::where('post_id', $postId)->where('key', $key)->first()) {
                    $meta->fill(['value' => $value])->save(); // update
                } else {
                    $meta = self::create(['post_id' => $postId, 'key' => $key, 'value' => $value]); // insert
                }

                $ids[] = $meta->id;
            }
        }

        // self::whereNotIn('id', $ids)->where('post_id', $postId)->delete();
    }
}
