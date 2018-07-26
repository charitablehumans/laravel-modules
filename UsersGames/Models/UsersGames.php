<?php

namespace Modules\UsersGames\Models;

use Illuminate\Database\Eloquent\Model;

class UsersGames extends Model
{
    protected $fillable = [
        'user_id',
        'token',
        'finished',
        'balance',
    ];

    protected $table = 'users_games';

    public function scopeSearch($query, $params)
    {
        isset($params['id']) ? $query->where('id', $params['id']) : '';
        isset($params['user_id']) ? $query->where('user_id', $params['user_id']) : '';
        if (isset($params['token_start'])) {
            if (isset($params['token_operator'])) {
                $query->where('token', $params['token_operator'], $params['token']);
            } else {
                $query->where('token', $params['token']);
            }
        }
        if (isset($params['finished'])) {
            if (isset($params['finished_operator'])) {
                $query->where('finished', $params['finished_operator'], $params['finished']);
            } else {
                $query->where('finished', $params['finished']);
            }
        }
        if (isset($params['balance'])) {
            if (isset($params['balance_operator'])) {
                $query->where('balance', $params['balance_operator'], $params['balance']);
            } else {
                $query->where('balance', $params['balance']);
            }
        }
        isset($params['created_at_date']) ? $query->whereDate(self::getTable().'.created_at', '=', $params['created_at_date']) : '';
        isset($params['updated_at_date']) ? $query->whereDate(self::getTable().'.updated_at', '=', $params['updated_at_date']) : '';

        if (isset($params['sort']) && $sort = explode(':', $params['sort'])) {
            $query->orderBy(
                $sort[0],
                isset($sort[1]) ? $sort[1] : null
            );
        }

        return $query;
    }

    public function user()
    {
        return $this->belongsTo(\Users\Modules\Models\Users::class, 'user_id');
    }
}
