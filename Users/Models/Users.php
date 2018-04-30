<?php

namespace Modules\Users\Models;

class Users extends \App\User
{
    use \Modules\Users\Traits\AttributesTrait;
    use \Spatie\Permission\Traits\HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'phone_number',
        'password',
        'access_token',
        'verified',
        'verification_code',
        'date_of_birth',
        'address',
        'store_id',
        'balance',
        'game_token',
    ];

    protected $guard_name = 'web';

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected static function boot()
    {
        parent::boot();

        self::deleted(function ($model) {
            $model->userAddresses->each(function ($userAddress) { $userAddress->delete(); });
            $model->userSocialites->each(function ($userSocialite) { $userSocialite->delete(); });
        });
    }

    public function getProfileCompleted()
    {
        $completed = 1;

        $completed = empty($this->name) ? 0 : $completed;
        $completed = empty($this->email) ? 0 : $completed;
        $completed = empty($this->phone_number) ? 0 : $completed;
        $completed = empty($this->date_of_birth) ? 0 : $completed;
        $completed = empty($this->address) ? 0 : $completed;

        return $completed;
    }

    public function getStoreIdOptions()
    {
        $options = self::search(['role_name' => 'store', 'sort' => 'name:asc'])->get()->pluck('name', 'id');
        return $options;
    }

    public function getVerifiedOptions()
    {
        $options = [
            '0' => trans('cms::cms.no'),
            '1' => trans('cms::cms.yes'),
        ];
        return $options;
    }

    public function getVerifiedName()
    {
        $options = $this->getVerifiedOptions();
        return $options[$this->verified];
    }

    public function scopeAction($query, $params)
    {
        if ($params['action'] == 'delete' && isset($params['action_id'])) {
            if ($users = self::whereIn('id', $params['action_id'])->get()) {
                $users->each(function ($user) { $user->delete(); });
            }
            flash(trans('cms::cms.data_has_been_deleted').' ('.$users->count().')')->success()->important();
        }
        return $query;
    }

    public function scopeSearch($query, $params)
    {
        isset($params['id']) ? $query->where('id', $params['id']) : '';
        isset($params['id_in']) ? $query->whereIn('id', $params['id_in']) : '';
        isset($params['name']) ? $query->where('name', 'like', '%'.$params['name'].'%') : '';
        isset($params['email']) ? $query->where('email', 'like', '%'.$params['email'].'%') : '';
        isset($params['verified']) ? $query->where('verified', $params['verified']) : '';
        isset($params['store_id']) ? $query->where('store_id', $params['store_id']) : '';
        if (isset($params['balance'])) {
            if (isset($params['balance_operator'])) {
                $query->where('balance', $params['balance_operator'], $params['balance']);
            } else {
                $query->where('balance', $params['balance']);
            }
        }
        if (isset($params['game_token'])) {
            if (isset($params['game_token_operator'])) {
                $query->where('game_token', $params['game_token_operator'], $params['game_token']);
            } else {
                $query->where('game_token', $params['game_token']);
            }
        }

        // roles
        isset($params['role_id']) ? $query->whereHas('roles', function ($query) use ($params) { $query->where('id', $params['role_id']); }) : '';
        isset($params['role_name']) ? $query->whereHas('roles', function ($query) use ($params) { $query->where('name', $params['role_name']); }) : '';
        if (isset($params['sort']) && $sort = explode(':', $params['sort'])) {
            $query->orderBy(
                $sort[0],
                isset($sort[1]) ? $sort[1] : null
            );
        }

        return $query;
    }

    public function store()
    {
        return $this->belongsTo('\Modules\Users\Models\Users', 'store_id');
    }

    public function syncPermissions(...$permissions)
    {
        $this->permissions()->detach();
        if ($permissions = array_filter($permissions)) {
            return $this->givePermissionTo($permissions);
        }
        return $this;
    }

    public function syncRoles(...$roles)
    {
        $this->roles()->detach();
        if ($roles = array_filter($roles)) {
            return $this->assignRole($roles);
        }
        return $this;
    }

    public function userAddresses()
    {
        return $this->hasMany('\Modules\UserAddresses\Models\UserAddresses', 'user_id')->orderBy('primary', 'desc')->latest();
    }

    public function userBalanceHistories()
    {
        return $this->hasMany('\Modules\UserBalanceHistories\Models\UserBalanceHistories', 'user_id')->orderBy('created_at', 'desc')->latest();
    }

    public function userBalanceHistoryCreate($data = [])
    {
        if ($this->getOriginal('balance') != $this->balance) {
            $data['balance_start'] = $this->getOriginal('balance');
            $data['balance'] = $this->balance - $this->getOriginal('balance');
            $data['balance_end'] = $this->balance;
            $this->userBalanceHistories()->save(new \Modules\UserBalanceHistories\Models\UserBalanceHistories($data));
        }

        return $this;
    }

    public function userGames()
    {
        return $this->hasMany('\App\Http\Models\Cnr\UsersGames', 'user_id', 'id');
    }

    public function userSocialites()
    {
        return $this->hasMany('\Modules\UserSocialites\Models\UserSocialites', 'user_id')->orderBy('provider');
    }
}
