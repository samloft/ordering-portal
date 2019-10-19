<?php

namespace App\Http\Controllers;

use App\Models\Addresses;
use App\Models\Customer;
use App\Models\User;
use App\Models\UserCustomer;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
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
        $default_address = Addresses::getDefault();

        return view('account.index', compact('default_address'));
    }

    /**
     * Update user details from the contact page.
     *
     * @return RedirectResponse
     */
    public function store(): RedirectResponse
    {
        $user = $this->validation();

        $store_account = User::store($user);

        return $store_account ? back()->with('success', 'User account has been updated') : back()->with('error', 'Unable to update account, please try again');
    }

    /**
     * Validation for the inputs before the user details are saved.
     *
     * @return mixed
     */
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

    /**
     * Change the customer the user is currently using.
     *
     * @param Request $request
     * @return RedirectResponse|void
     */
    public function changeCustomer(Request $request)
    {
        if ($request->customer === auth()->user()->customer_code) {
            return $this->revertChangeCustomer();
        }

        if (auth()->user()->admin !== 1) {
            $user_can_access = UserCustomer::check($request->customer);

            if (! $user_can_access) {
                return abort(401);
            }
        }

        $customer = Customer::show($request->customer);

        if (! $customer) {
            return back()->with('error', 'Customer code '.$request->customer.' does not exist');
        }

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
        Session::put('temp_customer');

        return back();
    }
}
