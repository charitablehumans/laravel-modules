<?php

namespace Modules\Usermetas\Models;

use Illuminate\Database\Eloquent\Model;

class Usermetas extends Model
{
    use \Modules\Postmetas\Traits\RelationshipsTrait;

    protected $fillable = [
        // 'id',
        'user_id',
        'key',
        'value',
    ];

    protected $table = 'usermetas';

    public function sync($metas = [], $userId)
    {
        $ids = [];

        if ($metas) {
            foreach ($metas as $key => $value) {
                $value = is_array($value) ? json_encode(array_values(array_filter($value))) : $value;

                $meta = self::firstOrCreate(['user_id' => $userId, 'key' => $key]);
                $meta->fill(['value' => $value])->save();

                $ids[] = $meta->id;
            }
        }

        // self::whereNotIn('id', $ids)->where('post_id', $userId)->delete();
    }
}
