<?php

namespace Modules\UserGameTokenHistories\Http\Controllers\Backend\UserGameTokenHistories;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\UserGameTokenHistories\Models\UserGameTokenHistories;
use Modules\Users\Models\Users;

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

        $data['model'] = new UserGameTokenHistories;
        $data['user'] = Users::findOrFail($userId);
        $data['userGameTokenHistories'] = UserGameTokenHistories::where('user_id', $userId)->search($request->query())->paginate($request->query('limit'));
        return view('usergametokenhistories::backend/user_game_token_histories/user_id/show', $data);
    }
}
