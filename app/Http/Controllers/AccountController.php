<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Customer;
use App\Models\User;
use App\Models\UserCustomer;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;
use Session;

class AccountController extends Controller
{
    /**
     * Displays the account page.
     *
     * @return Factory|View
     */
    public function index()
    {
        $default_address = Address::getDefault();

        return view('account.index', compact('default_address'));
    }

    /**
     * Update user details from the contact page.
     *
     * @return RedirectResponse
     */
    public function store(): RedirectResponse
    {
        $user = request()->validate([
            'name' => 'required|min:2',
            'telephone' => 'nullable',
            'mobile' => 'nullable',
            'password' => 'sometimes|nullable|confirmed|min:6',
        ]);

        if ($user['password']) {
            $user['password'] = bcrypt($user['password']);
        } else {
            unset($user['password']);
        }

        $store_account = User::where('id', auth()->user()->id)->update($user);

        return $store_account ? back()->with('success', 'User account has been updated') : back()->with('error', 'Unable to update account, please try again');
    }

    /**
     * Change the customer the user is currently using.
     *
     * @return RedirectResponse|void
     */
    public function changeCustomer()
    {
        if (strtoupper(request('customer')) === strtoupper(auth()->user()->customer_code)) {
            return $this->revertChangeCustomer();
        }

        if (auth()->user()->admin !== 1) {
            $user_can_access = UserCustomer::check(request('customer'));

            if (! $user_can_access) {
                return abort(401);
            }
        }

        $customer = Customer::show(request('customer'));

        if (! $customer) {
            return back()->with('error', 'Customer code '.request('customer').' does not exist');
        }

        Cache::forget('customer-'.$customer->code);

        Session::put('temp_customer', $customer->code);

        return back();
    }

    /**
     * Revert a changed customer to the users default customer.
     *
     * @return RedirectResponse
     */
    public function revertChangeCustomer(): RedirectResponse
    {
        Cache::forget('customer-'.auth()->user()->customer->code);

        Session::put('temp_customer');

        return redirect(route('home'));
    }
}
