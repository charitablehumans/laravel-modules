<?php

namespace Modules\Terms\Models;

use Illuminate\Database\Eloquent\Model;
use redzjovi\php\ArrayHelper;

class Terms extends Model
{
    use \Dimsav\Translatable\Translatable;
    use \Modules\Terms\Traits\AttributesTrait;
    use \Modules\Terms\Traits\HelperTrait;
    use \Modules\Terms\Traits\TermmetasTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['taxonomy', 'parent_id', 'count'];

    protected $table = 'terms';

    protected $parent = 'parent_id';

    protected $with = ['translations'];

    public $translatedAttributes = ['locale', 'name', 'slug', 'description'];
    public $translationForeignKey = 'term_id';
    public $translationModel = '\Modules\TermTranslations\Models\TermTranslations';

    protected static function boot()
    {
        parent::boot();

        self::saved(function ($model) {
            \Cache::forget('terms-'.$model->id);
            \Cache::forget('terms-slug-'.$model->slug);
            \Cache::forget('terms-termmetas-'.$model->id);
        });

        self::deleted(function ($model) {
            $model->termmetas->each(function ($termmeta) { $termmeta->delete(); });
            $model->deleteTranslations();
            \Cache::forget('terms-'.$model->id);
            \Cache::forget('terms-slug-'.$model->slug);
            \Cache::forget('terms-termmetas-'.$model->id);
        });
    }

    public function getParentOptions()
    {
        $search = [];
        request()->query('locale') ? $search['locale'] = request()->query('locale') : '';
        $parents = self::search($search)->get()->sortBy(function ($row, $key) { return $row['name']; })->toArray();
        $parents = ArrayHelper::copyKeyName($parents, 'parent_id', 'parent');
        $tree = ArrayHelper::buildTree($parents);
        $tree = ArrayHelper::printTree($tree);
        $options = collect($tree)->pluck('tree_name', 'id')->toArray();

        return $options;
    }

    public function getTemplateOptions()
    {
        $options = [
            'default' => trans('cms::cms.default'),
        ];
        return $options;
    }

    public function getTermsTree()
    {
        $tree = self::all()->sortBy(function ($row, $key) { return $row['name']; })->toArray();
        $tree = ArrayHelper::copyKeyName($tree, 'parent_id', 'parent');
        $tree = ArrayHelper::buildTree($tree);
        $tree = ArrayHelper::printTree($tree, '&nbsp;&nbsp;&nbsp;');

        return $tree;
    }

    public function parent()
    {
        return $this->belongsTo('\Modules\Terms\Models\Terms', 'parent_id');
    }

    public function scopeAction($query, $params)
    {
        if ($params['action'] == 'delete' && isset($params['action_id'])) {
            $this->search(['id_in' => $params['action_id']])->each(function ($term) { $term->delete(); });
            flash(trans('cms::cms.data_has_been_deleted'))->success()->important();
        }
        return $query;
    }

    public function scopeSearch($query, $params)
    {
        isset($params['id']) ? $query->where('id', $params['id']) : '';
        isset($params['id_in']) ? $query->whereIn(self::getTable().'.id', $params['id_in']) : '';
        isset($params['parent_id']) ? $query->where('parent_id', $params['parent_id']) : '';

        // term_translations
        isset($params['locale']) ? $query->whereTranslation('locale', $params['locale']) : '';
        isset($params['name']) ? $query->whereTranslation('name', $params['name']) : '';
        isset($params['name_like']) ? $query->whereTranslationLike('name', '%'.$params['name_like'].'%') : '';
        isset($params['slug']) ? $query->whereTranslation('slug', $params['slug']) : '';
        if (isset($params['slug_in']) && is_array($params['slug_in'])) {
            $slugIn = $params['slug_in'];
            $query = $query->where(function($query) use ($slugIn) {
                foreach ($slugIn as $slug) {
                    $query->orWhereTranslation('slug', $slug);
                }
            });
        }
        isset($params['slug_like']) ? $query->whereTranslationLike('slug', '%'.$params['slug_like'].'%') : '';
        isset($params['description']) ? $query->whereTranslation('description', $params['description']) : '';
        isset($params['description_like']) ? $query->whereTranslationLike('description', '%'.$params['description_like'].'%') : '';

        if (isset($params['count'])) {
            if (isset($params['count_operator'])) {
                $query->where('count', $params['count_operator'], $params['count']);
            } else {
                $query->where('count', $params['count']);
            }
        }
        if (isset($params['sort']) && $sort = explode(':', $params['sort'])) {
            if (in_array($sort[0], ['name', 'slug', 'description'])) {
                $query->join($this->getTranslationsTable().' AS translation', function ($join) {
                    $join->on('translation.term_id', '=', self::getTable().'.id');
                    isset($params['locale']) ? $query->where('translation.locale', $params['locale']) : '';
                })
                ->groupBy(self::getTable().'.id')
                ->orderBy('translation.'.$sort[0], $sort[1])
                ->select(self::getTable().'.*');
            } else if (in_array($sort[0], ['parent_name'])) {
                $query->leftJoin(self::getTable().' AS parent', function ($join) {
                    $join->on('parent.id', '=', self::getTable().'.parent_id');
                })
                ->leftJoin($this->getTranslationsTable().' AS parent_translation', function ($join) {
                    $join->on('parent_translation.term_id', '=', self::getTable().'.parent_id');
                    isset($params['locale']) ? $query->where('parent_translation.locale', $params['locale']) : '';
                })
                ->groupBy(self::getTable().'.id')
                ->orderBy($sort[0], $sort[1])
                ->select([
                    $this->getTable().'.*',
                    'parent_translation.name AS parent_name',
                ]);
            }
        }

        return $query;
    }

    public function termmetas()
    {
        return $this->hasMany('\Modules\Termmetas\Models\Termmetas', 'term_id', 'id');
    }
}
