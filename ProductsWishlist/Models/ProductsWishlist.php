<?php

namespace Modules\ProductsWishlist\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Products\Models\Products;
use Modules\Users\Models\Users;

class ProductsWishlist extends \Modules\PostsUsers\Models\PostsUsers
{
    protected $attributes = ['type' => 'product_wishlist'];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new \Modules\Cms\Scopes\TypeScope);
    }

    public function getPostIdTitleOptions()
    {
        return Products::select(['id', 'title'])->search(['sort' => 'title:asc'])->get()->pluck('title', 'id')->toArray();
    }

    public function product()
    {
        return $this->belongsTo('\Modules\Products\Models\Products', 'post_id');
    }
}
