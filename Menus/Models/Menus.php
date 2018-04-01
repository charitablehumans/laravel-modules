<?php

namespace Modules\Menus\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Categories\Models\Categories;
use Modules\CustomLinks\Models\CustomLinks;
use Modules\Posts\Models\Posts;
use Modules\Tags\Models\Tags;
use Modules\Terms\Models\Terms;
use redzjovi\php\UrlHelper;

class Menus extends Terms
{
    protected $attributes = [
        'taxonomy' => 'menu',
    ];

    // custom attribute
    protected $post, $icon, $title, $type, $url, $permission;

    protected static function boot()
    {
        parent::boot();

        $table = (new Terms)->getTable();
        static::addGlobalScope('taxonomy', function (Builder $builder) use ($table) { $builder->where($table.'.taxonomy', 'menu'); });
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
            $html .= \Illuminate\Support\Facades\View::make('menus::frontend/default/_templates/_frontend_top', $data)->render();
        }

        return $html;
    }

    public function getCategoriesTree()
    {
        $tree = (new Categories)->getTermsTree();
        return $tree;
    }

    public function getCustomLinkIdOptions()
    {
        $tree = (new CustomLinks)->getPostIdOptions();
        return $tree;
    }

    public function getIcon()
    {
        return $this->attributes['icon'];
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
                $term = \Modules\Categories\Models\Categories::findOrFail($this->id);
                $this->setPost($term);
                $this->setTitle($term->name);
                $this->setUrl(url('categories/'.$term->slug));
                break;
            case 'custom_link' :
                $post = CustomLinks::findOrFail($this->id);
                $this->setPost($post);
                $this->setTitle($post->title);
                $this->setUrl($this->getUrl());
                break;
            case 'page' :
                $post = \App\Http\Models\Pages::findOrFail($this->id);
                $this->setPost($post);
                $this->setTitle($post->title);
                $this->setUrl(url('pages/'.$post->name));
                break;
            case 'post' :
                $post = Posts::findOrFail($this->id);
                $this->setPost($post);
                $this->setTitle($post->title);
                $this->setUrl(url('posts/'.$post->name));
                break;
            case 'tag' :
                $term = Tags::findOrFail($this->id);
                $this->setPost($term);
                $this->setTitle($term->name);
                $this->setUrl(url('tags/'.$term->name));
                break;
            default :
                $this->setPost('');
                $this->setTitle('');
                $this->setUrl('');
        }

        return $this->attributes['post'];
    }

    public function getPostIdOptions()
    {
        $options = (new Posts)->getPostIdOptions();
        return $options;
    }

    public function getTagIdOptions()
    {
        $options = (new Tags)->getTagIdOptions();
        return $options;
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

    public function setPost($value)
    {
        $this->attributes['post'] = $value;
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
