<?php

namespace Modules\UserBalanceHistories\Models;

use Illuminate\Database\Eloquent\Model;

class UserBalanceHistories extends Model
{
    protected $fillable = [
        // 'id',
        'user_id',
        'type',
        'reference_id',
        'balance_start',

        'balance',
        'balance_end',
        'notes',
    ];

    protected $table = 'user_balance_histories';

    public function getTypeOptions()
    {
        return self::distinct('type')->orderBy('type')->get()->pluck('type', 'type')->toArray();
    }

    public function scopeSearch($query, $params)
    {
        isset($params['id']) ? $query->where('id', $params['id']) : '';
        isset($params['id_in']) ? $query->whereIn('id', $params['id_in']) : '';
        isset($params['user_id']) ? $query->where('user_id', $params['user_id']) : '';
        isset($params['type']) ? $query->where('type', $params['type']) : '';
        isset($params['type_like']) ? $query->where('type', 'like', '%'.$params['type_like'].'%') : '';
        isset($params['reference_id']) ? $query->where('reference_id', $params['reference_id']) : '';
        isset($params['reference_id_like']) ? $query->where('reference_id', 'like', '%'.$params['reference_id_like'].'%') : '';
        if (isset($params['balance_start'])) {
            if (isset($params['balance_start_operator'])) {
                $query->where('balance_start', $params['balance_start_operator'], $params['balance_start']);
            } else {
                $query->where('balance_start', $params['balance_start']);
            }
        }
        if (isset($params['balance'])) {
            if (isset($params['balance_operator'])) {
                $query->where('balance', $params['balance_operator'], $params['balance']);
            } else {
                $query->where('balance', $params['balance']);
            }
        }
        if (isset($params['balance_end'])) {
            if (isset($params['balance_end_operator'])) {
                $query->where('balance_end', $params['balance_end_operator'], $params['balance_end']);
            } else {
                $query->where('balance_end', $params['balance_end']);
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
