<?php

namespace Modules\ProductTestimonials\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Modules\PostTestimonials\Models\PostTestimonials;
use Modules\Users\Models\Users;

class ProductTestimonials extends \Modules\Posts\Models\Posts
{
    protected $attributes = [
        'type' => 'product_testimonial',
    ];

    protected static function boot()
    {
        parent::boot();

        self::saved(function ($model) {
            \Cache::forget('posts-post_testimonials-post_id-'.$model->id);
        });

        self::deleting(function ($model) {
            \Cache::forget('posts-post_testimonials-post_id-'.$model->id);
            $model->postTestimonial()->delete();
        });

        static::addGlobalScope('type', function (Builder $builder) { $builder->where('type', 'product_testimonial'); });
        static::addGlobalScope('status_deleted', function (Builder $builder) { \Auth::check() && \Auth::user()->can('backend product testimonials trash') ?: $builder->where('status', '<>', 'trash'); });
    }

    public function parent()
    {
        return $this->belongsTo('\Modules\Products\Models\Products', 'parent_id');
    }

    public function scopeSearch($query, $params)
    {
        $query = parent::scopeSearch($query, $params);

        if (isset($params['sort']) && $sort = explode(':', $params['sort'])) {
            if (in_array($sort[0], ['post_testimonial_rating'])) {
                $query->join((new PostTestimonials)->getTable().' AS post_testimonial', function ($join) {
                    $join->on('post_testimonial.post_id', '=', self::getTable().'.id');
                })
                ->groupBy(self::getTable().'.id')
                ->orderBy($sort[0], $sort[1])
                ->select([
                    self::getTable().'.*',
                    'post_testimonial.status AS post_testimonial_rating',
                ]);
            }
        }

        return $query;
    }

    public function setRatingAverageRecalculate($id)
    {
        $postTestimonial = PostTestimonials::firstOrCreate(['post_id' => $id]);
        $postTestimonial->rating_total = PostTestimonials::search(['product_testimonial_parent_id' => $id])->sum('rating');
        $postTestimonial->rating_count = PostTestimonials::search(['product_testimonial_parent_id' => $id])->count();
        $postTestimonial->rating_average = $postTestimonial->rating_total > 0 ? $postTestimonial->rating_total / $postTestimonial->rating_count : 0;
        $postTestimonial->save();
        return $postTestimonial;
    }
}
