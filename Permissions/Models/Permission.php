<?php

namespace Modules\Permissions\Models;

class Permission extends \Spatie\Permission\Models\Permission
{
    protected $attributes = [
        'guard_name' => 'web',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'guard_name',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];

    public function getPermissionIdOptions()
    {
        $options = self::select(['id', 'name'])->orderBy('name')->get()->pluck('name', 'id')->toArray();
        return $options;
    }

    public function scopeAction($query, $params)
    {
        if ($params['action'] == 'delete' && isset($params['action_id'])) {
            $this->search(['id_in' => $params['action_id']])->delete();
            flash(trans('cms::cms.data_has_been_deleted'))->success()->important();
        }
        return $query;
    }

    public function scopeSearch($query, $params)
    {
        isset($params['id']) ? $query->where('id', $params['id']) : '';
        isset($params['id_in']) ? $query->whereIn('id', $params['id_in']) : '';
        isset($params['name']) ? $query->where('name', 'like', '%'.$params['name'].'%') : '';
        isset($params['guard_name']) ? $query->where('guard_name', 'like', '%'.$params['guard_name'].'%') : '';
        if (isset($params['sort']) && $sort = explode(':', $params['sort'])) {
            $query->orderBy(
                $sort[0],
                isset($sort[1]) ? $sort[1] : null
            );
        }

        return $query;
    }
}
