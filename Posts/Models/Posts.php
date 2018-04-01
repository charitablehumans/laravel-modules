<?php

namespace Modules\Posts\Models;

use App\Http\Models\Postmetas;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Modules\Categories\Models\Categories;
use Modules\Tags\Models\Tags;
use Modules\Users\Models\Users;

class Posts extends Model
{
    use \Dimsav\Translatable\Translatable;

    protected $attributes = [
        'type' => 'post',
        'status' => 'publish',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'author_id', 'type', 'mime_type', 'status', 'comment_status', 'comment_count',
    ];

    protected $table = 'posts';

    protected $with = ['translations'];

    public $translatedAttributes = ['title', 'name', 'excerpt', 'content'];
    public $translationForeignKey = 'post_id';
    public $translationModel = 'App\Http\Models\PostTranslations';

    protected static function boot()
    {
        parent::boot();

        self::deleting(function ($model) {
            $model->postmetas->each(function ($postmeta) { $postmeta->delete(); });
            $model->translations->each(function ($translation) { $translation->delete(); });
            \Storage::deleteDirectory('media/original/'.$model->id);
            \Storage::deleteDirectory('media/thumbnail/'.$model->id);
        });

        static::addGlobalScope('type', function (Builder $builder) { $builder->where('type', 'post'); });
        static::addGlobalScope('status_deleted', function (Builder $builder) { \Auth::check() && \Auth::user()->can('backend posts trash') ?: $builder->where('status', '<>', 'trash'); });
    }

    public function author()
    {
        return $this->hasOne('\Modules\Users\Models\Users', 'id', 'author_id');
    }

    public function getAuthorIdOptions()
    {
        $options = self::search(['sort' => 'author_name,ASC'])->get()->pluck('author_name', 'author_id')->toArray();
        return $options;
    }

    public function getCategoriesTree()
    {
        $tree = (new Categories)->getTermsTree();
        return $tree;
    }

    public function getCategoryIdOptions()
    {
        $options = (new Categories)->getParentOptions();
        return $options;
    }

    public function getPostIdOptions()
    {
        $options = self::search(['sort' => 'title,ASC'])->select([self::getTable().'.id', 'title'])->get()->pluck('title', 'id')->toArray();
        return $options;
    }

    public function getPostmetaAttachedFile()
    {
        $attachedFile = $this->id && isset($this->postmetas->where('key', 'attached_file')->first()->value) ? $this->postmetas->where('key', 'attached_file')->first()->value : '';
        return $attachedFile;
    }

    public function getPostmetaAttachedFileThumbnail()
    {
        $attachedFile = $this->id && isset($this->postmetas->where('key', 'attached_file_thumbnail')->first()->value) ? $this->postmetas->where('key', 'attached_file_thumbnail')->first()->value : '';
        return $attachedFile;
    }

    public function getPostmetaAttachmentMetadata()
    {
        $attachmentMetadata = $this->id && isset($this->postmetas->where('key', 'attachment_metadata')->first()->value) ? json_decode($this->postmetas->where('key', 'attachment_metadata')->first()->value, true) : [];
        return $attachmentMetadata;
    }

    public function getPostmetaCategoriesId()
    {
        $categoriesId = [];
        $categoriesId = $this->id && isset($this->postmetas->where('key', 'categories')->first()->value) ? json_decode($this->postmetas->where('key', 'categories')->first()->value, true) : $categoriesId;
        $categoriesId = is_array(request()->old('postmetas.categories')) ? request()->old('postmetas.categories') : $categoriesId;
        return $categoriesId;
    }

    public function getPostmetaImageId()
    {
        $imagesId = $this->getPostmetaImagesId();
        $imageId = collect($imagesId)->count() > 0 ? collect($imagesId)->first() : false;
        return $imageId;
    }

    public function getPostmetaImagesId()
    {
        $imagesId = [];
        $imagesId = $this->id && isset($this->postmetas->where('key', 'images')->first()->value) ? json_decode($this->postmetas->where('key', 'images')->first()->value, true) : $imagesId;
        $imagesId = is_array(request()->old('postmetas.images')) ? request()->old('postmetas.images') : $imagesId;
        return $imagesId;
    }

    public function getPostmetaImageThumbnailUrl()
    {
        $imageId = $this->getPostmetaImageId();

        if ($imageId) {
            $imageUrl = \App\Http\Models\Media::find($imageId)->getPostmetaAttachedFileThumbnail();
            $imageUrl = \Storage::url($imageUrl);
        } else {
            $imageUrl = asset('images/posts/default.png');
        }

        return $imageUrl;
    }

    public function getPostmetaImageUrl()
    {
        $imageId = $this->getPostmetaImageId();

        if ($imageId) {
            $imageUrl = \App\Http\Models\Media::find($imageId)->getPostmetaAttachedFile();
            $imageUrl = \Storage::url($imageUrl);
        } else {
            $imageUrl = asset('images/posts/default.png');
        }

        return $imageUrl;
    }

    public function getPostmetaTagsId()
    {
        $tagsId = [];
        $tagsId = $this->id && isset($this->postmetas->where('key', 'tags')->first()->value) ? json_decode($this->postmetas->where('key', 'tags')->first()->value, true) : $tagsId;
        $tagsId = is_array(request()->old('postmetas.tags')) ? request()->old('postmetas.tags') : $tagsId;
        return $tagsId;
    }

    public function getPostmetaTemplate()
    {
        $template = isset($this->postmetas->where('key', 'template')->first()->value) ? $this->postmetas->where('key', 'template')->first()->value : '';
        return $template;
    }

    public function getStatusOptions()
    {
        $options = [
            'draft' => trans('cms::cms.draft'),
            'publish' => trans('cms::cms.publish'),
            'trash' => trans('cms::cms.trash'),
        ];

        return $options;
    }

    public function getStatusOptionsAttribute()
    {
        $statusOptions = $this->getStatusOptions();
        $options = self::pluck('status', 'status')->toArray();
        $options = array_intersect_key($statusOptions, $options);
        return $options;
    }

    public function getTagIdOptions()
    {
        $options = (new Tags)->getTagIdOptions();
        return $options;
    }

    public function getTemplateOptions()
    {
        $options = [
            'default' => trans('cms::cms.default'),
        ];
        return $options;
    }

    public function postmetas()
    {
        return $this->hasMany('App\Http\Models\Postmetas', 'post_id', 'id');
    }

    public function scopeAction($query, $params)
    {
        if (isset($params['action_id'])) {
            if (array_key_exists($params['action'], $this->getStatusOptions())) {
                $this->search(['id_in' => $params['action_id']])->update(['status' => $params['action']]);
                flash(trans('cms::cms.data_has_been_updated'))->success()->important();
            } else if ($params['action'] == 'delete' ) {
                if ($posts = self::whereIn('id', $params['action_id'])->get()) {
                    $posts->each(function ($post) { $post->delete(); });
                }
                flash(trans('cms::cms.data_has_been_deleted').' ('.$posts->count().')')->success()->important();
            }
        }
        return $query;
    }

    public function scopeSearch($query, $params)
    {
        isset($params['id']) ? $query->where('id', $params['id']) : '';
        isset($params['id_in']) ? $query->whereIn('id', $params['id_in']) : '';
        isset($params['author_id']) ? $query->where('author_id', $params['author_id']) : '';
        isset($params['type']) ? $query->where('type', $params['type']) : '';
        isset($params['mime_type']) ? $query->where('mime_type', $params['mime_type']) : '';
        isset($params['mime_type_like']) ? $query->where('mime_type', 'like', '%'.$params['mime_type_like'].'%') : '';
        if (isset($params['mime_type_like_in'])) {
            $mimeTypeLikes = explode(',', $params['mime_type_like_in']);
            $query->where(function ($query) use ($mimeTypeLikes) {
                foreach ($mimeTypeLikes as $mimeTypeLike) {
                    $query->orWhere('mime_type', 'like', '%'.$mimeTypeLike.'%');
                }
            });
        }
        isset($params['status']) ? $query->where('status', $params['status']) : '';
        isset($params['created_at']) ? $query->where(self::getTable().'created_at', 'like', '%'.$params['created_at'].'%') : '';
        isset($params['created_at_date']) ? $query->whereDate(self::getTable().'created_at', '=', $params['created_at_date']) : '';
        isset($params['updated_at_date']) ? $query->whereDate(self::getTable().'.updated_at', '=', $params['updated_at_date']) : '';

        // postmetas
        isset($params['category_id']) ? $query->join((new Postmetas)->getTable().' AS postmetas_category_id', 'postmetas_category_id.post_id', '=', self::getTable().'.id')->where('postmetas_category_id.key', 'categories')->where('postmetas_category_id.value', 'LIKE', '%"'.$params['category_id'].'"%') : ('');
        if (isset($params['product_price'])) {
            $query->join((new Postmetas)->getTable().' AS postmetas_product_price', 'postmetas_product_price.post_id', '=', self::getTable().'.id')->where('postmetas_product_price.key', 'product_price');
            if (isset($params['product_price_operator'])) {
                $query->where('postmetas_product_price.value', $params['product_price_operator'], $params['product_price']);
            } else {
                $query->where('postmetas_product_price.value', $params['product_price']);
            }
        }
        if (isset($params['product_stock'])) {
            $query->join((new Postmetas)->getTable().' AS postmetas_product_stock', 'postmetas_product_stock.post_id', '=', self::getTable().'.id')->where('postmetas_product_stock.key', 'product_stock');
            if (isset($params['product_stock_operator'])) {
                $query->where('postmetas_product_stock.value', $params['product_stock_operator'], $params['product_stock']);
            } else {
                $query->where('postmetas_product_stock.value', $params['product_stock']);
            }
        }

        // post_translations
        isset($params['locale']) ? $query->whereTranslation('locale', $params['locale']) : '';
        isset($params['title']) ? $query->whereTranslation('title', $params['title']) : '';
        isset($params['title_like']) ? $query->whereTranslationLike('title', '%'.$params['title_like'].'%') : '';
        isset($params['name']) ? $query->whereTranslation('name', $params['name']) : '';
        isset($params['name_like']) ? $query->whereTranslationLike('name', '%'.$params['name_like'].'%') : '';
        isset($params['excerpt']) ? $query->whereTranslationLike('excerpt', '%'.$params['excerpt'].'%') : '';
        isset($params['content']) ? $query->whereTranslationLike('content', '%'.$params['content'].'%') : '';

        if (isset($params['sort']) && $sort = explode(':', $params['sort'])) {
            if (in_array($sort[0], ['created_at', 'updated_at'])) {
                $query->orderBy(self::getTable().'.'.$sort[0], $sort[1]);
            } else if (in_array($sort[0], ['title', 'name', 'excerpt', 'content'])) {
                $query->join($this->getTranslationsTable().' AS translation', function ($join) {
                    $join->on('translation.post_id', '=', self::getTable().'.id');
                    isset($params['locale']) ? $query->where('translation.locale', $params['locale']) : '';
                })
                ->groupBy(self::getTable().'.id')
                ->orderBy('translation.'.$sort[0], $sort[1])
                ->select(self::getTable().'.*');
            } else if (in_array($sort[0], ['author_name'])) {
                $query->join((new Users)->getTable().' AS author', function ($join) {
                    $join->on('author.id', '=', self::getTable().'.author_id');
                })
                ->orderBy($sort[0], $sort[1])
                ->select([
                    self::getTable().'.*',
                    'author.name AS author_name',
                ]);
            } else if (str_contains($sort[0], 'postmetas.')) {
                $key = explode('.', $sort[0]);
                $key = $key[1];
                $query->join((new Postmetas)->getTable().' AS postmetas', function ($join) use ($key) {
                    $join->on('postmetas.post_id', '=', self::getTable().'.'.self::getKeyName());
                    $join->where('postmetas.key', '=', $key);
                })
                ->orderBy('postmetas.value', $sort[1]);
            } else {
                count($sort) == 2 ? $query->orderBy($sort[0], $sort[1]) : '';
            }
        }

        return $query;
    }
}
