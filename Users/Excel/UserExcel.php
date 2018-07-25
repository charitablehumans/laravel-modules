<?php

namespace Modules\Users\Excel;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class UserExcel implements FromView
{
    protected $users;

    public function __construct($users)
    {
        $this->users = $users;
    }

    public function view(): View
    {
        $data['users'] = $this->users;
        return view('users::excel/users', $data);
    }
}
