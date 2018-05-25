<?php

namespace Modules\Posts\Traits;

use redzjovi\php\JsonHelper;
use Modules\Postmetas\Models\Postmetas;

trait PostmetasTrait
{
    public function getPostmetaByKey($key)
    {
        return $this->getPostmetas()->firstWhere('key', $key) ? $this->getPostmetas()->firstWhere('key', $key) : new Postmetas;
    }

    public function getPostmetas()
    {
        return \Cache::remember('posts-postmetas-'.$this->id, 1440, function () {
            return $this->postmetas;
        });
    }

    public function getPostmetaValue($key, $default = false)
    {
        // 1. From database
        $values = $this->getPostmetaValues($key);

        // 2. Collect first value
        $value = collect($values)->first();

        // 3. Check default
        if (empty($value) && $default) {
            if (in_array($key, ['attached_file', 'attached_file_thumbnail'])) {
                $value = 'images/posts/default.png';
            }
        }

        return $value;
    }

    public function getPostmetaValues($key)
    {
        $values = [];

        // 1. From database
        if ($this->id) {
            if ($this->getPostmetaByKey($key)->value) {
                $values = $this->getPostmetaByKey($key)->value;
                $values = JsonHelper::isValidJson($values) ? json_decode($values, true) : $values;
            }
        }

        // 2. From request old
        $values = is_array(request()->old('postmetas.'.$key)) ? request()->old('postmetas.'.$key) : $values;

        return $values;
    }

    // DEPRECATED, and will be REMOVED soon
    public function getPostmetaAttachedFile()
    {
        // $attachedFile = $this->id && isset($this->postmetas->where('key', 'attached_file')->first()->value) ? $this->postmetas->where('key', 'attached_file')->first()->value : '';
        return $this->getPostmetaValue('attached_file');
    }

    // DEPRECATED, and will be REMOVED soon
    public function getPostmetaAttachedFileThumbnail()
    {
        // $attachedFile = $this->id && isset($this->postmetas->where('key', 'attached_file_thumbnail')->first()->value) ? $this->postmetas->where('key', 'attached_file_thumbnail')->first()->value : '';
        return $this->getPostmetaValue('attached_file_thumbnail');
    }

    // DEPRECATED, and will be REMOVED soon
    public function getPostmetaAttachmentMetadata()
    {
        // $attachmentMetadata = $this->id && isset($this->postmetas->where('key', 'attachment_metadata')->first()->value) ? json_decode($this->postmetas->where('key', 'attachment_metadata')->first()->value, true) : [];
        return $this->getPostmetaValues('attachment_metadata');
    }

    // DEPRECATED, and will be REMOVED soon
    public function getPostmetaCategoriesId()
    {
        // $categoriesId = [];
        // $categoriesId = $this->id && isset($this->postmetas->where('key', 'categories')->first()->value) ? json_decode($this->postmetas->where('key', 'categories')->first()->value, true) : $categoriesId;
        // $categoriesId = is_array(request()->old('postmetas.categories')) ? request()->old('postmetas.categories') : $categoriesId;
        return $this->getPostmetaValues('categories');
    }

    // DEPRECATED, and will be REMOVED soon
    public function getPostmetaImageId()
    {
        // $imagesId = $this->getPostmetaImagesId();
        // $imageId = collect($imagesId)->count() > 0 ? collect($imagesId)->first() : false;
        return $this->getPostmetaValue('images');
    }

    // DEPRECATED, and will be REMOVED soon
    public function getPostmetaImagesId()
    {
        // $imagesId = [];
        // $imagesId = $this->id && isset($this->postmetas->where('key', 'images')->first()->value) ? json_decode($this->postmetas->where('key', 'images')->first()->value, true) : $imagesId;
        // $imagesId = is_array(request()->old('postmetas.images')) ? request()->old('postmetas.images') : $imagesId;
        return $this->getPostmetaValues('images');
    }

    // DEPRECATED, and will be REMOVED soon
    public function getPostmetaImageThumbnailUrl()
    {
        // $imageUrl = asset('images/posts/default.png');
        //
        // if ($imageId = $this->getPostmetaImageId()) {
        //     $medium = \Cache::remember('posts-'.$imageId, 1440, function () use ($imageId) {
        //         return Media::find($imageId);
        //     });
        //
        //     if ($medium) {
        //         $imageUrl = $medium->getPostmetaAttachedFileThumbnail();
        //         $imageUrl = \Storage::url($imageUrl);
        //     }
        // }
        //
        // return $imageUrl;
        return \Storage::url($this->getPostmetaByKey('images')->getMedium()->getPostmetaValue('attached_file_thumbnail', true));
    }

    // DEPRECATED, and will be REMOVED soon
    public function getPostmetaImageUrl()
    {
        // $imageUrl = asset('images/posts/default.png');
        //
        // if ($imageId = $this->getPostmetaImageId()) {
        //     $medium = \Cache::remember('posts-'.$imageId, 1440, function () use ($imageId) {
        //         return Media::find($imageId);
        //     });
        //
        //     if ($medium) {
        //         $imageUrl = $medium->getPostmetaAttachedFile();
        //         $imageUrl = \Storage::url($imageUrl);
        //     }
        // }
        //
        // return $imageUrl;
        return \Storage::url($this->getPostmetaByKey('images')->getMedium()->getPostmetaValue('attached_file', true));
    }

    // DEPRECATED, and will be REMOVED soon
    public function getPostmetaTagsId()
    {
        // $tagsId = [];
        // $tagsId = $this->id && isset($this->postmetas->where('key', 'tags')->first()->value) ? json_decode($this->postmetas->where('key', 'tags')->first()->value, true) : $tagsId;
        // $tagsId = is_array(request()->old('postmetas.tags')) ? request()->old('postmetas.tags') : $tagsId;
        return $this->getPostmetaValues('tags');
    }

    public function getPostmetaTemplate()
    {
        $postmetaTemplate = null;
        $postmetaTemplate = $this->id ? $this->getPostmetaValue('template') : $postmetaTemplate;
        return \Request::old('postmeta.template', $postmetaTemplate);
    }
}
