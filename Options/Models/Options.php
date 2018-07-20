<?php

namespace Modules\Options\Models;

use Illuminate\Database\Eloquent\Model;

class Options extends Model
{
    use \Modules\Options\Traits\HelperTrait;
    use \Modules\Options\Traits\OptionValueTrait;
    use \Modules\Options\Traits\RelationshipsTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        // 'id',
        'type',
        'name',
        'value',
    ];

    protected $table = 'options';

    public function getTypeOptions()
    {
        return self::orderBy('type')->get()->pluck('type', 'type')->toArray();
    }

    public function scopeAction($query, $params)
    {
        if ($params['action'] == 'delete' && isset($params['action_id'])) {
            $this->search(['id_in' => $params['action_id']])->delete();
            flash(trans('cms.data_has_been_deleted'))->success()->important();
        }
        return $query;
    }

    public function scopeSearch($query, $params)
    {
        isset($params['id']) ? $query->where('id', $params['id']) : '';
        isset($params['id_in']) ? $query->whereIn('id', $params['id_in']) : '';
        isset($params['type']) ? $query->where('type', $params['type']) : '';
        isset($params['type_like']) ? $query->where('type', 'like', '%'.$params['type_like'].'%') : '';
        isset($params['name']) ? $query->where('name', $params['name']) : '';
        isset($params['name_like']) ? $query->where('name', 'like', '%'.$params['name_like'].'%') : '';
        isset($params['value']) ? $query->where('value', $params['value']) : '';
        isset($params['value_like']) ? $query->where('value', 'like', '%'.$params['value_like'].'%') : '';
        if (isset($params['sort']) && $sort = explode(':', $params['sort'])) {
            count($sort) == 2 ? $query->orderBy($sort[0], $sort[1]) : '';
        }

        return $query;
    }
}
