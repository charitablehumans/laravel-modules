<?php

namespace Modules\PostTestimonials\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Posts\Models\Posts;

class PostTestimonials extends Model
{
    use \Modules\PostTestimonials\Traits\AttributesTrait;

    protected $fillable = [
        // 'id',
        'post_id',
        'rating',
        'rating_total',
        'rating_count',

        'rating_average',
    ];

    protected $table = 'post_testimonials';

    public function post()
    {
        return $this->belongsTo('\Modules\Posts\Models\Posts', 'post_id');
    }

    public function product()
    {
        return $this->belongsTo('\Modules\Products\Models\Products', 'post_id');
    }

    public function productTestimonial()
    {
        return $this->belongsTo('\Modules\ProductTestimonials\Models\ProductTestimonials', 'post_id');
    }

    public function scopeSearch($query, $params)
    {
        isset($params['id']) ? $query->where('id', $params['id']) : '';
        isset($params['post_id']) ? $query->where('post_id', $params['post_id']) : '';
        isset($params['created_at']) ? $query->where(self::getTable().'.created_at', 'like', '%'.$params['created_at'].'%') : '';
        isset($params['updated_at']) ? $query->where(self::getTable().'.updated_at', 'like', '%'.$params['updated_at'].'%') : '';
        isset($params['created_at_date']) ? $query->whereDate(self::getTable().'.created_at', '=', $params['created_at_date']) : '';
        isset($params['updated_at_date']) ? $query->whereDate(self::getTable().'.updated_at', '=', $params['updated_at_date']) : '';

        // posts
        isset($params['post_parent_id']) ? $query->whereHas('post', function ($post) use ($params) {
            $post->where('parent_id', $params['post_parent_id']);
        }) : '';

        // product_testimonials
        isset($params['product_testimonial_parent_id']) ? $query->whereHas('productTestimonial', function ($productTestimonial) use ($params) {
            $productTestimonial->where('parent_id', $params['product_testimonial_parent_id']);
        }) : '';

        if (isset($params['sort']) && $sort = explode(':', $params['sort'])) {
            if (in_array($sort[0], ['created_at', 'updated_at'])) {
                $query->orderBy(self::getTable().'.'.$sort[0], $sort[1]);
            } else {
                count($sort) == 2 ? $query->orderBy($sort[0], $sort[1]) : '';
            }
        }

        return $query;
    }

}
