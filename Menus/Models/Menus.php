<?php

namespace Modules\Menus\Models;

class Menus extends \Modules\Terms\Models\Terms
{
    use \Modules\Menus\Traits\AttributesTrait;

    protected $attributes = ['taxonomy' => 'menu'];

    // custom attribute menu
    public $post, $icon, $title, $type, $url, $permission;
    public $content, $excerpt, $image_thumbnail_url, $image_url, $images_thumbnail_url, $images_url, $metas, $others, $template;

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new \Modules\Terms\Scopes\TaxonomyScope);
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
                'images_thumbnail_url' => $this->getImagesThumbnailUrl(),
                'images_url' => $this->getImagesUrl(),
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
}
