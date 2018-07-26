<?php

namespace Modules\UsersGames\Http\Controllers\Backend\UsersGames;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Users\Models\Users;
use Modules\UsersGames\Models\UsersGames;

class UserIdController extends Controller
{
    /**
     * Show the specified resource.
     * @return Response
     */
    public function show($userId, Request $request)
    {
        $request->query('sort') ?: $request->query->set('sort', 'created_at:desc');
        $request->query('limit') ?: $request->query->set('limit', config('cms.database.eloquent.model.per_page'));

        $data['user'] = Users::findOrFail($userId);
        $data['userGames'] = UsersGames::where('user_id', $userId)->search($request->query())->paginate($request->query('limit'));
        return view('usersgames::backend/users_games/user_id/show', $data);
    }
}
