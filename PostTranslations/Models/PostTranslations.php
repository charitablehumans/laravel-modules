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
    protected $fillable = ['post_id', 'title', 'name', 'excerpt', 'content'];

    protected $table = 'post_translations';

    public function sluggable()
    {
        return [
            'name' => ['source' => 'title'],
        ];
    }
}
