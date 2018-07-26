<?php

namespace Modules\UserGameTokenHistories\Models;

use Illuminate\Database\Eloquent\Model;

class UserGameTokenHistories extends Model
{
    protected $fillable = [
        'user_id',
        'type',
        'reference_id',
        'game_token_start',

        'game_token',
        'game_token_end',
        'notes',
    ];

    public function getTypeOptions()
    {
        return self::distinct('type')->orderBy('type')->get()->pluck('type', 'type')->toArray();
    }

    public function scopeSearch($query, $params)
    {
        isset($params['id']) ? $query->where('id', $params['id']) : '';
        isset($params['user_id']) ? $query->where('user_id', $params['user_id']) : '';
        isset($params['type']) ? $query->where('type', $params['type']) : '';
        isset($params['reference_id']) ? $query->where('reference_id', $params['reference_id']) : '';
        if (isset($params['game_token_start'])) {
            if (isset($params['game_token_start_operator'])) {
                $query->where('game_token_start', $params['game_token_start_operator'], $params['game_token_start']);
            } else {
                $query->where('game_token_start', $params['game_token_start']);
            }
        }
        if (isset($params['game_token'])) {
            if (isset($params['game_token_operator'])) {
                $query->where('game_token', $params['game_token_operator'], $params['game_token']);
            } else {
                $query->where('game_token', $params['game_token']);
            }
        }
        if (isset($params['game_token_end'])) {
            if (isset($params['game_token_end_operator'])) {
                $query->where('game_token_end', $params['game_token_end_operator'], $params['game_token_end']);
            } else {
                $query->where('game_token_end', $params['game_token_end']);
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
}
