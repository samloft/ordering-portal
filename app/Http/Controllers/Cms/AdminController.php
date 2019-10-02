<?php

namespace App\Http\Controllers\Cms;

use App\Models\Admin;
use Illuminate\Contracts\View\Factory;
use App\Http\Controllers\Controller;
use Illuminate\View\View;

class AdminController extends Controller
{
    /**
     * @return Factory|View
     */
    public function index()
    {
        $users = Admin::show(10);

        return view('cms.admin.index', compact('users'));
    }
}
