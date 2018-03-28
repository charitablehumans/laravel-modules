<?php

namespace Modules\Termmetas\Models;

use Illuminate\Database\Eloquent\Model;

class Termmetas extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'term_id', 'key', 'value',
    ];

    protected $table = 'termmetas';

    public function sync($metas = [], $postId)
    {
        $ids = [];

        if ($metas) {
            foreach ($metas as $key => $value) {
                $value = is_array($value) ? json_encode(array_filter($value)) : $value;

                if ($meta = self::where('term_id', $postId)->where('key', $key)->first()) {
                    $meta->fill(['value' => $value])->save(); // update
                } else {
                    $meta = self::create(['term_id' => $postId, 'key' => $key, 'value' => $value]); // insert
                }

                $ids[] = $meta->id;
            }
        }

        // self::whereNotIn('id', $ids)->where('term_id', $postId)->delete();
    }
}
