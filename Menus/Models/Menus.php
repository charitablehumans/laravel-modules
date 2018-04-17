<?php

namespace Modules\Menus\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Categories\Models\Categories;
use Modules\CustomLinks\Models\CustomLinks;
use Modules\DokuMyshortcart\Models\DokuMyshortcartPaymentMethods;
use Modules\Pages\Models\Pages;
use Modules\Posts\Models\Posts;
use Modules\Products\Models\Products;
use Modules\Tags\Models\Tags;
use Modules\Terms\Models\Terms;
use redzjovi\php\UrlHelper;

class Menus extends Terms
{
    protected $attributes = [
        'taxonomy' => 'menu',
    ];

    // custom attribute menu
    public $post, $icon, $title, $type, $url, $permission;
    public $content, $excerpt, $image_thumbnail_url, $image_url, $metas, $others, $template;

    protected static function boot()
    {
        parent::boot();

        $table = (new Terms)->getTable();
        static::addGlobalScope('taxonomy', function (Builder $builder) use ($table) { $builder->where($table.'.taxonomy', 'menu'); });
    }

    public function generateAsArray($nestable)
    {
        $data = [];

        foreach ($nestable as $i => $item) {
            $this->attributes = $item;
            $this->getPost();

            $data[$i] = [
                'content' => $this->getContent(),
                'excerpt' => $this->getExcerpt(),
                'icon' => $this->getIcon(),
                'id' => $this->id,
                'image_thumbnail_url' => $this->getImageThumbnailUrl(),
                'image_url' => $this->getImageUrl(),
                'metas' => collect($this->getMetas())->pluck('value', 'key'),
                'others' => $this->getOthers(),
                'template' => $this->getTemplate(),
                'title' => $this->getTitle(),
                'type' => $this->getType(),
                'url' => $this->getUrl(),
                'permission' => $this->getPermission(),

                'item' => $item,
            ];

            if (isset($item['children']) && is_array($item['children'])) {
                $data[$i]['children'] = $this->generateAsArray($item['children']);
            }
        }

        return $data;
    }

    public function generateAsHtml($nestable, $template = 'backend_menu_form')
    {
        switch ($template) {
            case 'backend-master' :
                $html = $this->generateAsHtmlBackendMaster($nestable);
                break;
            case 'frontend-default-top' :
                $html = $this->generateAsHtmlFrontendDefaultTop($nestable);
                break;
            default :
                $html = $this->generateAsHtmlBackendMenuForm($nestable);
        }

        return $html;
    }

    public function generateAsHtmlBackendMaster($nestable)
    {
        $html = '';

        foreach ($nestable as $item) {
            $this->attributes = $item;
            $this->getPost();

            $data['data_icon'] = $this->getIcon();
            $data['data_id'] = $this->id;
            $data['data_title'] = $this->getTitle();
            $data['data_type'] = $this->getType();
            $data['data_url'] = $this->getUrl();
            $data['data_permission'] = $this->getPermission();

            $data['item'] = $item;
            $data['menu'] = $this;
            $html .= \Illuminate\Support\Facades\View::make('menus::backend/_templates/backend_master', $data)->render();
        }

        return $html;
    }

    public function generateAsHtmlBackendMenuForm($nestable)
    {
        $html = '';

        foreach ($nestable as $item) {
            $this->attributes = $item;
            $this->getPost();

            $data['data_icon'] = $this->getIcon();
            $data['data_id'] = $this->id;
            $data['data_title'] = $this->getTitle();
            $data['data_type'] = $this->getType();
            $data['data_url'] = $this->getUrl();
            $data['data_permission'] = $this->getPermission();

            $data['item'] = $item;
            $data['menu'] = $this;
            $html .= \Illuminate\Support\Facades\View::make('menus::backend/_nestable_template', $data)->render();
        }

        return $html;
    }

    public function generateAsHtmlFrontendDefaultTop($nestable)
    {
        $html = '';

        foreach ($nestable as $item) {
            $this->attributes = $item;
            $this->getPost();

            $data['data_icon'] = $this->getIcon();
            $data['data_id'] = $this->id;
            $data['data_title'] = $this->getTitle();
            $data['data_type'] = $this->getType();
            $data['data_url'] = $this->getUrl();
            $data['data_permission'] = $this->getPermission();

            $data['item'] = $item;
            $data['menu'] = $this;
            $html .= \Illuminate\Support\Facades\View::make('menus::frontend/default/menus/_templates/_frontend_top', $data)->render();
        }

        return $html;
    }

    public function getCategoriesTree()
    {
        $tree = (new Categories)->getTermsTree();
        return $tree;
    }

    public function getContent()
    {
        return $this->attributes['content'];
    }

    public function getCustomLinkIdOptions()
    {
        $tree = (new CustomLinks)->getPostIdOptions();
        return $tree;
    }

    public function getDokuMyshortcartPaymentMethodIdOptions()
    {
        return (new DokuMyshortcartPaymentMethods)->getPostIdOptions();
    }

    public function getExcerpt()
    {
        return $this->attributes['excerpt'];
    }

    public function getIcon()
    {
        return $this->attributes['icon'];
    }

    public function getImageUrl()
    {
        return $this->attributes['image_url'];
    }

    public function getImageThumbnailUrl()
    {
        return $this->attributes['image_thumbnail_url'];
    }

    public function getMetas()
    {
        return $this->attributes['metas'];
    }

    public function getOthers()
    {
        return $this->attributes['others'];
    }

    public function getPermission()
    {
        return $this->attributes['permission'];
    }

    public function getPermissionIdOptions()
    {
        $options = (new \Modules\Permissions\Models\Permission)->getPermissionIdOptions();
        return $options;
    }

    public function getPost()
    {
        switch ($this->getType()) {
            case 'category' :
                $term = \Cache::remember('terms-'.$this->id, 1440, function () {
                    return Categories::findOrFail($this->id);
                });
                $this->setContent($term->description);
                $this->setExcerpt('');
                $this->setImageThumbnailUrl($term->getTermmetaImageThumbnailUrl());
                $this->setImageUrl($term->getTermmetaImageUrl());
                $this->setMetas($term->termmetas);
                $this->setOthers('');
                $this->setPost($term);
                $this->setTemplate($term->getTermmetaTemplate());
                $this->setTitle($term->name);
                $this->setUrl(url('categories/'.$term->slug));
                break;
            case 'custom_link' :
                $post = \Cache::remember('posts-'.$this->id, 1440, function () {
                    return CustomLinks::findOrFail($this->id);
                });
                $this->setContent($post->content);
                $this->setExcerpt($post->excerpt);
                $this->setImageThumbnailUrl($post->getPostmetaImageThumbnailUrl());
                $this->setImageUrl($post->getPostmetaImageUrl());
                $this->setMetas($post->postmetas);
                $this->setOthers('');
                $this->setPost($post);
                $this->setTemplate($post->getPostmetaTemplate());
                $this->setTitle($post->title);
                $this->setUrl($this->getUrl());
                break;
            case 'doku_myshortcart_payment_method' :
                $post = \Cache::remember('posts-'.$this->id, 1440, function () {
                    return DokuMyshortcartPaymentMethods::findOrFail($this->id);
                });
                $this->setContent($post->content);
                $this->setExcerpt($post->excerpt);
                $this->setImageThumbnailUrl($post->getPostmetaImageThumbnailUrl());
                $this->setImageUrl($post->getPostmetaImageUrl());
                $this->setMetas($post->postmetas);
                $this->setOthers('');
                $this->setPost($post);
                $this->setTemplate($post->getPostmetaTemplate());
                $this->setTitle($post->title);
                $this->setUrl($this->getUrl());
                break;
            case 'page' :
                $post = \Cache::remember('posts-'.$this->id, 1440, function () {
                    return Pages::findOrFail($this->id);
                });
                $this->setContent($post->content);
                $this->setExcerpt($post->excerpt);
                $this->setImageThumbnailUrl($post->getPostmetaImageThumbnailUrl());
                $this->setImageUrl($post->getPostmetaImageUrl());
                $this->setMetas($post->postmetas);
                $this->setOthers('');
                $this->setPost($post);
                $this->setTemplate($post->getPostmetaTemplate());
                $this->setTitle($post->title);
                $this->setUrl(url('pages/'.$post->name));
                break;
            case 'post' :
                $post = \Cache::remember('posts-'.$this->id, 1440, function () {
                    return Posts::findOrFail($this->id);
                });
                $this->setContent($post->content);
                $this->setExcerpt($post->excerpt);
                $this->setImageThumbnailUrl($post->getPostmetaImageThumbnailUrl());
                $this->setImageUrl($post->getPostmetaImageUrl());
                $this->setMetas($post->postmetas);
                $this->setOthers('');
                $this->setPost($post);
                $this->setTemplate($post->getPostmetaTemplate());
                $this->setTitle($post->title);
                $this->setUrl(url('posts/'.$post->name));
                break;
            case 'product' :
                $post = \Cache::remember('posts-'.$this->id, 1440, function () {
                    return Products::findOrFail($this->id);
                });
                $this->setContent($post->content);
                $this->setExcerpt($post->excerpt);
                $this->setImageThumbnailUrl($post->getPostmetaImageThumbnailUrl());
                $this->setImageUrl($post->getPostmetaImageUrl());
                $this->setMetas($post->postmetas);
                $this->setOthers(['product' => $post->postProduct]);
                $this->setPost($post);
                $this->setTemplate($post->getPostmetaTemplate());
                $this->setTitle($post->title);
                $this->setUrl(url('posts/'.$post->name));
                break;
            case 'tag' :
                $term = \Cache::remember('terms-'.$this->id, 1440, function () {
                    return Tags::findOrFail($this->id);
                });
                $this->setContent($post->description);
                $this->setExcerpt('');
                $this->setImageThumbnailUrl($term->getTermmetaImageThumbnailUrl());
                $this->setImageUrl($term->getTermmetaImageUrl());
                $this->setMetas($term->termmetas);
                $this->setOthers('');
                $this->setPost($term);
                $this->setTemplate($term->getTermmetaTemplate());
                $this->setTitle($term->name);
                $this->setUrl(url('tags/'.$term->name));
                break;
            default :
                $this->setContent('');
                $this->setExcerpt('');
                $this->setImageThumbnailUrl('');
                $this->setImageUrl('');
                $this->setMetas('');
                $this->setOthers('');
                $this->setPost('');
                $this->setTemplate('');
                $this->setTitle('');
                $this->setUrl('');
        }

        return $this->attributes['post'];
    }

    public function getPageIdOptions()
    {
        return (new Pages)->getPostIdOptions();
    }

    public function getPostIdOptions()
    {
        $options = (new Posts)->getPostIdOptions();
        return $options;
    }

    public function getProductIdOptions()
    {
        $options = (new Products)->getPostIdOptions();
        return $options;
    }

    public function getTagIdOptions()
    {
        $options = (new Tags)->getTagIdOptions();
        return $options;
    }

    public function getTemplate()
    {
        return $this->attributes['template'];
    }

    public function getTitle()
    {
        return $this->attributes['title'];
    }

    public function getType()
    {
        return $this->attributes['type'];
    }

    public function getUrl()
    {
        return UrlHelper::isRelative($this->attributes['url']) ? url($this->attributes['url']) : $this->attributes['url'];
    }

    public function setContent($value)
    {
        $this->attributes['content'] = $value;
    }

    public function setExcerpt($value)
    {
        $this->attributes['excerpt'] = $value;
    }

    public function setImageThumbnailUrl($value)
    {
        $this->attributes['image_thumbnail_url'] = $value;
    }

    public function setImageUrl($value)
    {
        $this->attributes['image_url'] = $value;
    }

    public function setMetas($value)
    {
        $this->attributes['metas'] = $value;
    }

    public function setOthers($value)
    {
        $this->attributes['others'] = $value;
    }

    public function setPost($value)
    {
        $this->attributes['post'] = $value;
    }

    public function setTemplate($value)
    {
        $this->attributes['template'] = $value;
    }

    public function setTitle($value)
    {
        $this->attributes['title'] = $value;
    }

    public function setUrl($value)
    {
        $this->attributes['url'] = $value;
    }
}
