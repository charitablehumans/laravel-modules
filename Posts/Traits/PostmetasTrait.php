<?php

namespace Modules\Posts\Traits;

use redzjovi\php\JsonHelper;
use Modules\Media\Models\Media;

trait PostmetasTrait
{
    public function getPostmetas()
    {
        return \Cache::remember('posts-postmetas-'.$this->id, 1440, function () {
            return $this->postmetas;
        });
    }

    public function getPostmetaValue($key, $type = false)
    {
        // 1. From database
        $values = $this->getPostmetaValues($key, $type);

        // 2. Collect first value
        $value = collect($values)->count() > 0 ? collect($values)->first() : false;

        // 3. Transform based on type
        if (empty($value) && in_array($type, ['image_thumbnail_url', 'image_url'])) {
            $value = asset('images/posts/default.png');
        }

        return $value;
    }

    public function getPostmetaValues($key, $type = false)
    {
        $values = [];

        // 1. From database
        if ($this->id) {
            $postmetas = $this->getPostmetas();

            if (isset($postmetas->where('key', $key)->first()->value)) {
                $values = $postmetas->where('key', $key)->first()->value;
                $values = JsonHelper::isValidJson($values) ? json_decode($values, true) : $values;
            }
        }

        // 2. From request old
        $values = is_array(request()->old('postmetas.'.$key)) ? request()->old('postmetas.'.$key) : $values;

        // 3. Transform based on type
        if (is_array($values) && $type) {
            foreach ($values as $i => $value) {

                if ($type == 'image_thumbnail_url') {
                    $imageUrl = asset('images/posts/default.png');
                    $mediumId = $value;

                    $medium = \Cache::remember('posts-'.$mediumId, 1440, function () use ($mediumId) {
                        return Media::find($mediumId);
                    });

                    if ($medium) {
                        $imageUrl = $medium->getPostmetaValue('attached_file_thumbnail');
                        $imageUrl = \Storage::url($imageUrl);
                        $values[$i] = $imageUrl;
                    }
                } else if ($type == 'image_url') {
                    $imageUrl = asset('images/posts/default.png');
                    $mediumId = $value;

                    $medium = \Cache::remember('posts-'.$mediumId, 1440, function () use ($mediumId) {
                        return Media::find($mediumId);
                    });

                    if ($medium) {
                        $imageUrl = $medium->getPostmetaValue('attached_file');
                        $imageUrl = \Storage::url($imageUrl);
                        $values[$i] = $imageUrl;
                    }
                }

            }
        }

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
        return $this->getPostmetaValue('images', 'image_thumbnail_url');
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
        return $this->getPostmetaValue('images', 'image_url');
    }

    // DEPRECATED, and will be REMOVED soon
    public function getPostmetaTagsId()
    {
        // $tagsId = [];
        // $tagsId = $this->id && isset($this->postmetas->where('key', 'tags')->first()->value) ? json_decode($this->postmetas->where('key', 'tags')->first()->value, true) : $tagsId;
        // $tagsId = is_array(request()->old('postmetas.tags')) ? request()->old('postmetas.tags') : $tagsId;
        return $this->getPostmetaValues('tags');
    }

    // DEPRECATED, and will be REMOVED soon
    public function getPostmetaTemplate()
    {
        // $template = isset($this->postmetas->where('key', 'template')->first()->value) ? $this->postmetas->where('key', 'template')->first()->value : ''; 
        // return $template;
        return $this->getPostmetaValue('template');
    }
}
