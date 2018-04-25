<?php

namespace Modules\Media\Models;

use Illuminate\Database\Eloquent\Builder;
use Intervention\Image\Facades\Image;
use Modules\MediumCategories\Models\MediumCategories;
use Modules\Users\Models\Users;

class Media extends \Modules\Posts\Models\Posts
{
    use \Modules\Media\Traits\HelperTrait;

    protected $attributes = [
        'type' => 'attachment',
    ];

    protected $guarded = ['attached_file', 'attached_file_thumbnail'];

    public $mimeTypeImages = ['image/gif', 'image/jpeg', 'image/jpg', 'image/png'];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('type', function (Builder $builder) { $builder->where('type', 'attachment'); });
        static::addGlobalScope('status_deleted', function (Builder $builder) { \Auth::check() && \Auth::user()->can('backend media trash') ?: $builder->where('status', '<>', 'trash'); });
    }

    public function getCategoriesTree()
    {
        $tree = (new MediumCategories)->getTermsTree();
        return $tree;
    }

    public function getCategoryIdOptions()
    {
        $options = (new MediumCategories)->getParentOptions();
        return $options;
    }

    public function getMimeTypeOptionsAttribute()
    {
        return self::orderBy('mime_type')->pluck('mime_type', 'mime_type')->toArray();
    }

    public function setAttachedFile($attachedFile)
    {
        $mimeType = \Storage::mimeType($attachedFile);

        if (in_array($mimeType, $this->mimeTypeImages)) {
            $image = Image::make($attachedFile)->trim();

            // $max = max($image->height(), $image->width());
            // $image->resizeCanvas($max, $max);

            $image->resize(\Config::get('image.large_size'), \Config::get('image.large_size'), function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });

            if (\Config::get('image.watermark')) {
                $watermark = Image::make(\Config::get('image.watermark_image'));
                $image->insert($watermark, 'center');
            }

            $image->save($attachedFile);
        }
    }

    public function setAttachedFileThumbnail($attachedFile, $attachedFileThumbnail)
    {
        $mimeType = \Storage::mimeType($attachedFile);

        if (in_array($mimeType, $this->mimeTypeImages)) {
            \Storage::exists($attachedFileThumbnail) ? \Storage::delete($attachedFileThumbnail) : '';
            \Storage::copy($attachedFile, $attachedFileThumbnail);

            $image = Image::make($attachedFile);

            $image->resize(\Config::get('image.thumbnail_size'), \Config::get('image.thumbnail_size'), function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });

            if (\Config::get('image.watermark')) {
                $watermark = Image::make(\Config::get('image.watermark_image_thumbnail'));
                $image->insert($watermark, 'center');
            }

            $image->save($attachedFileThumbnail);
        } else {
            $attachedFileThumbnail = 'images/media/text.png';
        }

        return $attachedFileThumbnail;
    }

    public function scopeSearch($query, $params)
    {
        $query = parent::scopeSearch($query, $params);

        if (\Auth::user()->can('backend media all')) {
            // all
        } else if (\Auth::user()->can('backend media role')) {
            $roles = \Auth::user()->getRoleNames();
            $authors = Users::role($roles)->get()->pluck('id', 'id');
            $query->whereIn('author_id', $authors); // group
        } else if (\Auth::user()->can('backend media')) {
            $query->where('author_id', \Auth::user()->id);  // self
        }

        return $query;
    }
}
