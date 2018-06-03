<?php

namespace Modules\Posts\Traits;

use Modules\Categories\Models\Categories;
use Modules\PostTestimonials\Models\PostTestimonials;
use Modules\Products\Models\Products;
use Modules\Users\Models\Users;

trait AttributesTrait
{
    public function getAuthor()
    {
        return \Cache::remember('users-'.$this->author_id, 1440, function () {
            return $this->author ? $this->author : new Users;
        });
    }

    public function getAuthorId()
    {
        $authorId = 0;
        $authorId = \Auth::check() ? \Auth::user()->id : $authorId;
        $authorId = $this->id ? $this->author_id : $authorId;
        return \Request::old('author_id', $authorId);
    }

    public function getAuthorIdOptions()
    {
        $options = self::search(['sort' => 'author_name:asc'])->get()->pluck('author_name', 'author_id')->toArray();
        return $options;
    }

    public function getAuthorIdNameOptions()
    {
        return (new Users)->getIdNameOptions();
    }

    public function getCategoriesTree()
    {
        return (new Categories)->getTermsTree();
    }

    public function getCategoryIdOptions()
    {
        return (new Categories)->getParentOptions();
    }

    public function getContent2()
    {
        $content = null;
        $content = $this->id ? $this->content_2 : $content;
        return \Request::old('content_2', $content);
    }

    public function getContent3()
    {
        $content = null;
        $content = $this->id ? $this->content_3 : $content;
        return \Request::old('content_3', $content);
    }

    public function getIdContentOptions()
    {
        return self::select([self::getTable().'.id', 'content'])->search(['sort' => 'content:asc'])->get()->pluck('content', 'id')->toArray();
    }

    public function getIdTitleOptions()
    {
        return self::select([self::getTable().'.id', 'title'])->search(['sort' => 'title:asc'])->get()->pluck('title', 'id')->toArray();
    }

    public function getParent()
    {
        return \Cache::remember('posts-'.$this->parent_id, 1440, function () {
            return $this->parent ? $this->parent : new self;
        });
    }

    public function getParentId()
    {
        $parentId = 0;
        $parentId = \Request::query('parent_id', $parentId);
        return \Request::old('parent_id', $parentId);
    }

    public function getParentIdTitleOptions()
    {
        $parentIds = self::select(['parent_id'])->distinct()->get()->pluck('parent_id', 'parent_id')->toArray();
        return Products::select([self::getTable().'.id', 'title'])->search(['id_in' => $parentIds, 'sort' => 'title:asc'])->get()->pluck('title', 'id')->toArray();
    }

    // DEPRECATED, and will be REMOVED soon
    public function getPostIdOptions()
    {
        $options = self::search(['sort' => 'title:asc'])->select([self::getTable().'.id', 'title'])->get()->pluck('title', 'id')->toArray();
        return $options;
    }

    public function getPostTestimonial()
    {
        return \Cache::remember('posts-post_testimonials.post_id-'.$this->id, 1440, function () {
            return $this->postTestimonial ? $this->postTestimonial : new PostTestimonials;
        });
    }

    public function getStatus()
    {
        $status = 'publish';
        $status = $this->id ? $status : 'publish';
        return \Request::old('status', $status);
    }

    public function getStatusOptions()
    {
        return [
            'draft' => trans('cms::cms.draft'),
            'publish' => trans('cms::cms.publish'),
            'trash' => trans('cms::cms.trash'),
        ];
    }

    // DEPRECATED, and will be REMOVED soon
    public function getStatusOptionsAttribute()
    {
        $statusOptions = $this->getStatusOptions();
        $options = self::pluck('status', 'status')->toArray();
        $options = array_intersect_key($statusOptions, $options);
        return $options;
    }

    // DEPRECATED, and will be REMOVED soon
    public function getTagIdOptions()
    {
        return (new \Modules\Tags\Models\Tags)->getIdNameOptions();
    }

    public function getTitle()
    {
        $title = null;
        $title = $this->id ? $this->title : $title;
        return \Request::old('title', $title);
    }
}
