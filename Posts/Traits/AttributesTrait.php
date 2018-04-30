<?php

namespace Modules\Posts\Traits;

use Modules\Categories\Models\Categories;
use Modules\PostTestimonials\Models\PostTestimonials;
use Modules\Products\Models\Products;
use Modules\Users\Models\Users;

trait AttributesTrait
{
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

    // DEPRECATED, and will be REMOVED soon
    public function getCategoriesTree()
    {
        $tree = (new Categories)->getTermsTree();
        return $tree;
    }

    // DEPRECATED, and will be REMOVED soon
    public function getCategoryIdOptions()
    {
        $options = (new Categories)->getParentOptions();
        return $options;
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
        $this->parent_id = \Request::query('parent_id', $this->parent_id);
        return \Request::old('parent_id', $this->parent_id);
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
        $this->status = $this->id ? $this->status : 'publish';
        return \Request::old('status', $this->status);
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
        $options = (new \Modules\Tags\Models\Tags)->getTagIdOptions();
        return $options;
    }
}
