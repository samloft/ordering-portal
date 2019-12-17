<?php

namespace App\Http\Controllers\Cms;

use App\Models\User;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
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
        $search = request('search');
        $site_users = User::listAll($search);

        return view('site-users.index', compact('site_users'));
    }

    /**
     * Create/Update a user.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        //$user_details = $request->toArray();
        //$user_details['api_token'] = Str::random(60);

        $user = User::store($request->toArray());

        if ($request->id) {
            return $user ? back()->with('success', 'User has been updated') : back()->with('error', 'Unable to update user, please try again later');
        }

        return $user ? back()->with('success', 'New user has been created') : back()->with('error', 'Unable to create user, please try again later');
    }

    /**
     * Delete a user.
     *
     * @param $id
     * @return RedirectResponse
     */
    public function destroy($id): RedirectResponse
    {
        $deleted = User::destroy($id);

        return $deleted ? back()->with('success', 'User has been deleted.') : back()->with('error', 'Unable to delete user, please try again later');
    }

    /**
     * Validate user details before passing to be stored.
     *
     * @param Request $request
     * @return mixed
     */
    public function validation(Request $request)
    {
        $id = $request->id;

        if ($id) {
            return $request->validate([
                'first_name' => 'required',
                'last_name' => 'required',
                'username' => 'required|unique:users,username,' . $id,
                'email' => 'required|unique:users,email,' . $id,
                'customer_code' => 'required|exists:customers,customer_code'
            ]);
        }

        return $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'username' => 'required|unique:users,username',
            'password' => 'required',
            'email' => 'required|unique:users,email',
            'customer_code' => 'required|exists:customers,customer_code'
        ]);
    }
}
