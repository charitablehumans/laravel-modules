<?php

namespace Modules\UserSocialites\Http\Controllers\Backend;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

class UserSocialitesController extends Controller
{
    public function delete($id)
    {
        $userSocialite = \Modules\UserSocialites\Models\UserSocialites::findOrFail($id);
        $userSocialite->delete();
        flash(trans('cms::cms.data_has_been_deleted'))->success()->important();
        return redirect()->back();
    }
}
