<?php

namespace App\Http\Controllers\Cms;

use App\Http\Controllers\Controller;
use App\Mail\Welcome;
use App\Models\User;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
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
        $site_users = User::list($search);

        return view('site-users.index', compact('site_users'));
    }

    /**
     * Create/Update a user.
     *
     * @return \App\Models\User|\Illuminate\Database\Eloquent\Model
     */
    public function store()
    {
        $this->validation();

        request()->merge([
            'password'  => bcrypt(Str::random(20)),
            'api_token' => Str::random(60),
        ]);

        $user = User::create(request()->all());

        if ($user) {
            Mail::send(new Welcome($user));
        }

        return $user;
    }

    /**
     * Update the given user.
     *
     * @return int
     */
    public function update(): int
    {
        return User::findOrFail(request('id'))->update(request()->except('customers'));
    }

    /**
     * Delete a user by ID.
     *
     * @param $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        $deleted = User::destroy($id);

        return response()->json(['deleted' => $deleted]);
    }

    /**
     * Send a password reset on behalf of the given user.
     *
     * @return mixed
     */
    public function passwordReset()
    {
        $user = User::where('email', request('email'))->firstOrFail();
        $token = Password::getRepository()->create($user);

        return $user->sendPasswordResetNotification($token);
    }

    /**
     * Validate user details before passing to be stored.
     *
     * @return mixed
     */
    public function validation()
    {
        return request()->validate([
            'name'          => 'required',
            'email'         => 'required|unique:users,email',
            'customer_code' => 'required|exists:customers,code',
        ]);
    }
}
