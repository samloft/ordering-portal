<?php

namespace App\Http\Controllers\Cms;

use App\Models\Admin;
use App\Notifications\WelcomeAdminNotification;
use Illuminate\Contracts\View\Factory;
use App\Http\Controllers\Controller;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Illuminate\View\View;

class AdminController extends Controller
{
    Use Notifiable;
    /**
     * Displays a paginated list of all admin CMS users.
     *
     * @return Factory|View
     */
    public function index()
    {
        $users = Admin::show(request('search'));

        return view('admin-users.index', compact('users'));
    }

    /**
     * Create a new admin CMS user.
     *
     * @return \App\Models\Admin|\Illuminate\Database\Eloquent\Model
     */
    public function store()
    {
        $this->validation();

        request()->merge([
            'password' => bcrypt(Str::random(20))
        ]);

        $admin = Admin::create(request()->all());

        if ($admin) {
            $admin->notify(new WelcomeAdminNotification($admin));
        }

        return $admin;
    }

    /**
     * Validate admin details before passing to be stored.
     *
     * @return mixed
     */
    public function validation()
    {
        return request()->validate([
            'name' => 'required',
            'email' => 'required|unique:cms_users,email',
        ]);
    }
}
