<?php

namespace Modules\Menus\Traits;

use Modules\Categories\Models\Categories;
use Modules\CustomLinks\Models\CustomLinks;
use Modules\DokuMyshortcart\Models\DokuMyshortcartPaymentMethods;
use Modules\Pages\Models\Pages;
use Modules\Posts\Models\Posts;
use Modules\ProductCategories\Models\ProductCategories;
use Modules\ProductTestimonials\Models\ProductTestimonials;
use Modules\Products\Models\Products;
use Modules\Tags\Models\Tags;
use redzjovi\php\UrlHelper;

trait AttributesTrait
{
    public function getCategoriesTree()
    {
        return (new Categories)->getTermsTree();
    }

    public function getContent()
    {
        return $this->attributes['content'];
    }

    public function getCustomLinkIdOptions()
    {
        return (new CustomLinks)->getPostIdOptions();
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

    public function getImagesUrl()
    {
        return $this->attributes['images_url'];
    }

    public function getImagesThumbnailUrl()
    {
        return $this->attributes['images_thumbnail_url'];
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
        return (new \Modules\Permissions\Models\Permission)->getPermissionIdOptions();
    }

    public function getPost()
    {
        switch ($this->getType()) {
            case 'category' :
                $term = Categories::getTermById($this->id);
                $this->setContent($term->description);
                $this->setExcerpt('');
                $this->setImageThumbnailUrl($term->getTermmetaImageThumbnailUrl());
                $this->setImageUrl($term->getTermmetaImageUrl());
                $this->setImagesThumbnailUrl($term->getTermmetaValues('images')->getMediaUrlFullByKey('attached_file_thumbnail', true));
                $this->setImagesUrl($term->getTermmetaValues('images')->getMediaUrlFullByKey('attached_file', true));
                $this->setMetas($term->getTermmetas());
                $this->setOthers('');
                $this->setPost($term);
                $this->setTemplate($term->getTermmetaValue('template'));
                $this->setTitle($term->name);
                $this->setUrl(url('categories/'.$term->slug));
                break;
            case 'custom_link' :
                $post = CustomLinks::getPostById($this->id);
                $this->setContent($post->content);
                $this->setExcerpt($post->excerpt);
                $this->setImageThumbnailUrl(
                    \Storage::url($post->getPostmetaByKey('images')->getMedium()->getPostmetaValue('attached_file_thumbnail', true))
                );
                $this->setImageUrl(
                    \Storage::url($post->getPostmetaByKey('images')->getMedium()->getPostmetaValue('attached_file', true))
                );
                $this->setImagesThumbnailUrl($post->getPostmetaByKey('images')->getMediaUrlFullByKey('attached_file_thumbnail', true));
                $this->setImagesUrl($post->getPostmetaByKey('images')->getMediaUrlFullByKey('attached_file', true));
                $this->setMetas($post->getPostmetas());
                $this->setOthers('');
                $this->setPost($post);
                $this->setTemplate($post->getPostmetaValue('template'));
                $this->setTitle($post->title);
                $this->setUrl($this->getUrl());
                break;
            case 'doku_myshortcart_payment_method' :
                $post = DokuMyshortcartPaymentMethods::getPostById($this->id);
                $this->setContent($post->content);
                $this->setExcerpt($post->excerpt);
                $this->setImageThumbnailUrl(
                    \Storage::url($post->getPostmetaByKey('images')->getMedium()->getPostmetaValue('attached_file_thumbnail', true))
                );
                $this->setImageUrl(
                    \Storage::url($post->getPostmetaByKey('images')->getMedium()->getPostmetaValue('attached_file', true))
                );
                $this->setImagesThumbnailUrl($post->getPostmetaByKey('images')->getMediaUrlFullByKey('attached_file_thumbnail', true));
                $this->setImagesUrl($post->getPostmetaByKey('images')->getMediaUrlFullByKey('attached_file', true));
                $this->setMetas($post->getPostmetas());
                $this->setOthers('');
                $this->setPost($post);
                $this->setTemplate($post->getPostmetaValue('template'));
                $this->setTitle($post->title);
                $this->setUrl($this->getUrl());
                break;
            case 'page' :
                $post = Pages::getPostById($this->id);
                $this->setContent($post->content);
                $this->setExcerpt($post->excerpt);
                $this->setImageThumbnailUrl(
                    \Storage::url($post->getPostmetaByKey('images')->getMedium()->getPostmetaValue('attached_file_thumbnail', true))
                );
                $this->setImageUrl(
                    \Storage::url($post->getPostmetaByKey('images')->getMedium()->getPostmetaValue('attached_file', true))
                );
                $this->setImagesThumbnailUrl($post->getPostmetaByKey('images')->getMediaUrlFullByKey('attached_file_thumbnail', true));
                $this->setImagesUrl($post->getPostmetaByKey('images')->getMediaUrlFullByKey('attached_file', true));
                $this->setMetas($post->getPostmetas());
                $this->setOthers('');
                $this->setPost($post);
                $this->setTemplate($post->getPostmetaValue('template'));
                $this->setTitle($post->title);
                $this->setUrl(url('pages/'.$post->name));
                break;
            case 'post' :
                $post = Posts::getPostById($this->id);
                $this->setContent($post->content);
                $this->setExcerpt($post->excerpt);
                $this->setImageThumbnailUrl(
                    \Storage::url($post->getPostmetaByKey('images')->getMedium()->getPostmetaValue('attached_file_thumbnail', true))
                );
                $this->setImageUrl(
                    \Storage::url($post->getPostmetaByKey('images')->getMedium()->getPostmetaValue('attached_file', true))
                );
                $this->setImagesThumbnailUrl($post->getPostmetaByKey('images')->getMediaUrlFullByKey('attached_file_thumbnail', true));
                $this->setImagesUrl($post->getPostmetaByKey('images')->getMediaUrlFullByKey('attached_file', true));
                $this->setMetas($post->getPostmetas());
                $this->setOthers('');
                $this->setPost($post);
                $this->setTemplate($post->getPostmetaValue('template'));
                $this->setTitle($post->title);
                $this->setUrl(url('posts/'.$post->name));
                break;
            case 'product' :
                $post = Products::getPostById($this->id);
                $this->setContent($post->content);
                $this->setExcerpt($post->excerpt);
                $this->setImageThumbnailUrl(
                    \Storage::url($post->getPostmetaByKey('images')->getMedium()->getPostmetaValue('attached_file_thumbnail', true))
                );
                $this->setImageUrl(
                    \Storage::url($post->getPostmetaByKey('images')->getMedium()->getPostmetaValue('attached_file', true))
                );
                $this->setImagesThumbnailUrl($post->getPostmetaByKey('images')->getMediaUrlFullByKey('attached_file_thumbnail', true));
                $this->setImagesUrl($post->getPostmetaByKey('images')->getMediaUrlFullByKey('attached_file', true));
                $this->setMetas($post->getPostmetas());
                $this->setOthers(['product' => $post->postProduct]);
                $this->setPost($post);
                $this->setTemplate($post->getPostmetaValue('template'));
                $this->setTitle($post->title);
                $this->setUrl(url('posts/'.$post->name));
                break;
            case 'product_category' :
                $term = ProductCategories::getTermById($this->id);
                $this->setContent($term->description);
                $this->setExcerpt('');
                $this->setMetas($term->getTermmetas());
                $this->setImageThumbnailUrl($term->getTermmetaImageThumbnailUrl());
                $this->setImageUrl($term->getTermmetaImageUrl());
                $this->setImagesThumbnailUrl($term->getPostmetaByKey('images')->getMediaUrlFullByKey('attached_file_thumbnail', true));
                $this->setImagesUrl($term->getPostmetaByKey('images')->getMediaUrlFullByKey('attached_file', true));
                $this->setOthers('');
                $this->setPost($term);
                $this->setTemplate($term->getTermmetaValue('template'));
                $this->setTitle($term->name);
                $this->setUrl(url('product-categories/'.$term->name));
                break;
            case 'product_testimonial' :
                $post = ProductTestimonials::getPostById($this->id);
                $this->setContent($post->content);
                $this->setExcerpt($post->excerpt);
                $this->setImageThumbnailUrl(
                    \Storage::url($post->getPostmetaByKey('images')->getMedium()->getPostmetaValue('attached_file_thumbnail', true))
                );
                $this->setImageUrl(
                    \Storage::url($post->getPostmetaByKey('images')->getMedium()->getPostmetaValue('attached_file', true))
                );
                $this->setImagesThumbnailUrl($post->getPostmetaByKey('images')->getMediaUrlFullByKey('attached_file_thumbnail', true));
                $this->setImagesUrl($post->getPostmetaByKey('images')->getMediaUrlFullByKey('attached_file', true));
                $this->setMetas($post->getPostmetas());
                $this->setOthers([
                    'postTestimonial' => $post->getPostTestimonial(),
                ]);
                $this->setPost($post);
                $this->setTemplate($post->getPostmetaValue('template'));
                $this->setTitle(strip_tags($post->content));
                $this->setUrl(route('frontend.product-testimonials.show', $post->id));
                break;
            case 'tag' :
                $term = Tags::getTermById($this->id);
                $this->setContent($term->description);
                $this->setExcerpt('');
                $this->setMetas($term->getTermmetas());
                $this->setImageThumbnailUrl($term->getTermmetaImageThumbnailUrl());
                $this->setImageUrl($term->getTermmetaImageUrl());
                $this->setImagesThumbnailUrl($term->getPostmetaByKey('images')->getMediaUrlFullByKey('attached_file_thumbnail', true));
                $this->setImagesUrl($term->getPostmetaByKey('images')->getMediaUrlFullByKey('attached_file', true));
                $this->setOthers('');
                $this->setPost($term);
                $this->setTemplate($term->getTermmetaValue('template'));
                $this->setTitle($term->name);
                $this->setUrl(url('tags/'.$term->name));
                break;
            default :
                $this->setContent('');
                $this->setExcerpt('');
                $this->setImageThumbnailUrl('');
                $this->setImageUrl('');
                $this->setImagesThumbnailUrl('');
                $this->setImagesUrl('');
                $this->setMetas('');
                $this->setOthers('');
                $this->setPost('');
                $this->setTemplate('');
                $this->setTitle('');
                $this->setUrl('');
                break;
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

    public function getProductCategoriesTree()
    {
        return (new ProductCategories)->getTermsTree();
    }

    public function getProductIdOptions()
    {
        $options = (new Products)->getPostIdOptions();
        return $options;
    }

    public function getProductTestimonialIdContentOptions()
    {
        return (new ProductTestimonials)->getIdContentOptions();
    }

    public function getTagIdNameOptions()
    {
        return (new Tags)->getIdNameOptions();
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

    public function setImagesThumbnailUrl($value)
    {
        $this->attributes['images_thumbnail_url'] = $value;
    }

    public function setImagesUrl($value)
    {
        $this->attributes['images_url'] = $value;
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
