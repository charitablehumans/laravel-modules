<?php

namespace Modules\PostTranslations\Models;

use Illuminate\Database\Eloquent\Model;

class PostTranslations extends Model
{
    use \Cviebrock\EloquentSluggable\Sluggable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'post_id',
        'title',
        'name',
        'excerpt',
        'content',
        'content_2',
        'content_3',
        'content_4',
        'content_5'
    ];

    protected $table = 'post_translations';

    public function sluggable()
    {
        return [
            'name' => ['source' => 'title'],
        ];
    }
}
