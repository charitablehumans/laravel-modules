<?php

namespace Modules\PostsUsers\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Posts\Models\Posts;
use Modules\PostTranslations\Models\PostTranslations;
use Modules\Users\Models\Users;

class PostsUsers extends Model
{
    protected $fillable = [
        'type',
        'post_id',
        'user_id'
    ];

    protected $table = 'posts_users';

    public function getPostIdTitleOptions()
    {
        return Posts::select(['id', 'title'])->search(['sort' => 'title:asc'])->get()->pluck('title', 'id')->toArray();
    }

    public function getTypeOptions()
    {
        return [];
    }

    public function getUserIdEmailFilterOptions()
    {
        $userIds = self::select(['user_id'])->distinct()->get()->pluck('user_id', 'user_id')->toArray();
        return Users::select(['id', 'email'])->search(['id_in' => $userIds, 'sort' => 'email:asc'])->get()->pluck('email', 'id')->toArray();
    }

    public function getUserIdEmailOptions()
    {
        return Users::select(['id', 'email'])->orderBy('email')->get()->pluck('email', 'id')->toArray();
    }

    public function post()
    {
        return $this->belongsTo('\Modules\Posts\Models\Posts', 'post_id');
    }

    public function scopeAction($query, $params)
    {
        if (isset($params['action_id'])) {
            if ($params['action'] == 'delete' ) {
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
        isset($params['type']) ? $query->where('type', $params['type']) : '';
        isset($params['post_id']) ? $query->where('post_id', $params['post_id']) : '';
        isset($params['user_id']) ? $query->where('user_id', $params['user_id']) : '';
        isset($params['created_at']) ? $query->where(self::getTable().'.created_at', 'like', '%'.$params['created_at'].'%') : '';
        isset($params['created_at_date']) ? $query->whereDate(self::getTable().'.created_at', '=', $params['created_at_date']) : '';
        isset($params['updated_at']) ? $query->where(self::getTable().'.updated_at', 'like', '%'.$params['updated_at'].'%') : '';
        isset($params['updated_at_date']) ? $query->whereDate(self::getTable().'.updated_at', '=', $params['updated_at_date']) : '';

        if (isset($params['sort']) && $sort = explode(':', $params['sort'])) {
            if (in_array($sort[0], ['type', 'post_id', 'user_id', 'created_at', 'updated_at'])) {
                $query->orderBy(self::getTable().'.'.$sort[0], $sort[1]);
            } else if (in_array($sort[0], ['post_title'])) {
                $query->join((new PostTranslations)->getTable().' AS translation', function ($join) {
                    $join->on('translation.post_id', '=', self::getTable().'.post_id');
                    isset($params['locale']) ? $query->where('translation.locale', $params['locale']) : '';
                })
                ->groupBy(self::getTable().'.id')
                ->orderBy($sort[0], $sort[1])
                ->select([
                    self::getTable().'.*',
                    'translation.title AS post_title',
                ]);
            } else if (in_array($sort[0], ['user_email'])) {
                $query->join((new Users)->getTable().' AS user', function ($join) {
                    $join->on('user.id', '=', self::getTable().'.user_id');
                })
                ->orderBy($sort[0], $sort[1])
                ->select([
                    self::getTable().'.*',
                    'user.name AS user_email',
                ]);
            } else {
                count($sort) == 2 ? $query->orderBy($sort[0], $sort[1]) : '';
            }
        }

        return $query;
    }

    public function user()
    {
        return $this->belongsTo('Modules\Users\Models\Users', 'user_id');
    }
}
