<?php

namespace App\Http\Controllers\Cms;

use App\Models\User;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\View\View;

class UserController extends Controller
{
    /**
     * Displays a list of all the website users.
     *
     * @return Factory|View
     */
    public function index()
    {
        $search = Input::get('search');
        $site_users = User::listAll($search);

        return view('cms.users.index', compact('site_users'));
    }
}
