<?php

namespace Modules\UserBalanceHistories\Http\Controllers\Backend;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\UserBalanceHistories\Models\UserBalanceHistories;
use Modules\Users\Models\Users;

class UserBalanceHistoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request)
    {
        $request->query('user_id') ?: $request->query('user_id');
        $request->query('locale') ?: $request->query->set('locale', config('app.locale'));
        $request->query('sort') ?: $request->query->set('sort', 'created_at:desc');
        $request->query('limit') ?: $request->query->set('limit', config('cms.database.eloquent.model.per_page'));

        $data['model'] = new UserBalanceHistories;
        $data['user'] = Users::findOrFail($request->query('user_id'));
        $data['userBalanceHistories'] = UserBalanceHistories::search($request->query())->paginate($request->query('limit'));
        return view('userbalancehistories::backend/index', $data);
    }
}
