<?php

namespace Modules\Products\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Products\Models\PostProducts;

class Products extends \Modules\Posts\Models\Posts
{
    protected $attributes = [
        'type' => 'product',
    ];

    protected static function boot()
    {
        parent::boot();

        self::deleting(function ($model) {
            $model->postProduct()->delete();
            $model->postmetas->each(function ($postmeta) { $postmeta->delete(); });
            $model->translations->each(function ($translation) { $translation->delete(); });
            \Storage::deleteDirectory('media/original/'.$model->id);
            \Storage::deleteDirectory('media/thumbnail/'.$model->id);
        });

        static::addGlobalScope('type', function (Builder $builder) { $builder->where('type', 'product'); });
        static::addGlobalScope('status_deleted', function (Builder $builder) { \Auth::check() && \Auth::user()->can('backend products trash') ?: $builder->where('status', '<>', 'trash'); });
    }

    public function getAuthorId()
    {
        $authorId = 0;

        if ($this->id) {
            $authorId = $this->author_id;
        } else if (\Auth::check()) {
            $authorId = \Auth::user()->store ? \Auth::user()->store->id : 0;
        }

        return $authorId;
    }

    public function getPostProductDiscount()
    {
        return 0;
    }

    public function getPostProductSellPrice()
    {
        return $this->id ? $this->postProduct->getSellPrice() : (new PostProducts)->getSellPrice();
    }

    public function getPostProductStatus()
    {
        return $this->id ? $this->postProduct->getStatus() : (new PostProducts)->getStatus();
    }

    public function getPostProductStatusOptions()
    {
        return (new PostProducts)->getStatusOptions();
    }

    public function getPostProductStock()
    {
        return $this->id ? $this->postProduct->getStock() : (new PostProducts)->getStock();
    }

    public function getPostProductWeight()
    {
        return $this->id ? $this->postProduct->getWeight() : (new PostProducts)->getWeight();
    }

    public function postProduct()
    {
        return $this->hasOne('\Modules\Products\Models\PostProducts', 'post_id', 'id');
    }

    public function scopeSearch($query, $params)
    {
        $query = parent::scopeSearch($query, $params);

        if (isset($params['product_ownership']) && $params['product_ownership'] === true) {
            if (\Auth::check() && \Auth::user()->can('backend products all') === false) {
                $query->where('author_id', $this->getAuthorId());
            }
        }

        // post_products
        if (isset($params['post_product_stock'])) {
            $query = $query->whereHas('postProduct', function ($postProduct) use ($params) {
                if (isset($params['post_product_stock_operator'])) {
                    $postProduct->where('stock', $params['post_product_stock_operator'], $params['post_product_stock']);
                } else {
                    $postProduct->where('stock', $params['post_product_stock']);
                }
            });
        }
        if (isset($params['post_product_sell_price'])) {
            $query = $query->whereHas('postProduct', function ($postProduct) use ($params) {
                if (isset($params['post_product_sell_price_operator'])) {
                    $postProduct->where('sell_price', $params['post_product_sell_price_operator'], $params['post_product_sell_price']);
                } else {
                    $postProduct->where('sell_price', $params['post_product_sell_price']);
                }
            });
        }

        if (isset($params['sort']) && $sort = explode(':', $params['sort'])) {
            if (in_array($sort[0], ['post_product_stock', 'post_product_sell_price'])) {
                $query->join((new PostProducts)->getTable().' AS post_product', function ($join) {
                    $join->on('post_product.post_id', '=', self::getTable().'.id');
                })
                ->groupBy(self::getTable().'.id')
                ->orderBy($sort[0], $sort[1])
                ->select([
                    self::getTable().'.*',
                    'post_product.status AS post_product_status',
                    'post_product.stock AS post_product_stock',
                    'post_product.sell_price AS post_product_sell_price',
                ]);
            }
        }

        return $query;
    }
}
