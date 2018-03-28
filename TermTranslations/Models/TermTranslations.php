<?php

namespace Modules\TermTranslations\Models;

use Illuminate\Database\Eloquent\Model;

class TermTranslations extends Model
{
    use \Cviebrock\EloquentSluggable\Sluggable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['term_id', 'name', 'slug', 'description'];

    protected $table = 'term_translations';

    public function sluggable()
    {
        return [
            'slug' => ['source' => 'name'],
        ];
    }
}
