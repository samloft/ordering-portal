<?php

namespace App\Http\Controllers;

use App\Models\Addresses;
use App\Models\Countries;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;
use Hash;

class AccountController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $default_address = Addresses::getDefault();

        return view('account.index', compact('default_address'));
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store()
    {
        $user = $this->validation();

        $store_account = User::store($user);

        return $store_account ? back()->with('success', 'User account has been updated') : back()->with('error', 'Unable to update account, please try again');
    }

    public function validation()
    {
        return request()->validate([
            'first_name' => 'required|min:2',
            'last_name' => 'required|min:2',
            'telephone' => 'nullable',
            'evening_telephone' => 'nullable',
            'fax' => 'nullable',
            'mobile' => 'nullable',
        ]);
    }
}
