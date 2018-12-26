<?php

namespace App\Http\Controllers;

use App\Models\Addresses;
use App\Models\Countries;
use App\User;
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
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $store_account = User::store($request);

        return $store_account ? back()->with('success', 'User account has been updated') : back()->with('error', 'Unable to update account, please try again');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function password()
    {
        return view('account.password');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storePassword(Request $request)
    {
        if (!Hash::check($request->current_password, Auth::user()->getAuthPassword())) {
            return back()->with('error', 'Current password is not correct, please try again');
        }

        if ($request->new_password <> $request->confirm_new_password) {
            return back()->with('error', 'New password and confirm must match');
        }

        $password_updated = User::changePassword($request->new_password);

        return $password_updated ? back()->with('success', 'New password has been updated') : back()->with('error', 'Unable to update password, please try again');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function addresses()
    {
        $addresses = Addresses::show();

        return view('account.addresses.index', compact('addresses'));
    }

    /**
     * @param null $address_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showAddress($address_id = null)
    {
        $countries = Countries::show();
        $address_id ? $address_details = Addresses::details($address_id) : $address_details = null;

        return view('account.addresses.show', compact('countries', 'address_details'));
    }

    public function storeAddress(Request $request)
    {
        if ($request->id) {
            $permission = Addresses::canEdit($request->id);

            if (!$permission) {
                return back()->with('error', 'You do not have permission to edit this address');
            }

            $address = Addresses::store($request);

            return $address ? back()->with('success', 'Address has been updated') : back()->with('error', 'Unable to update address, please try again');
        }

        $request->validate([
            'company_name' => 'required',
            'address_line_2' => 'required',
            'address_line_3' => 'required',
            'country_id' => 'required',
            'postcode' => 'required'
        ]);

        $address = Addresses::store($request);

        return $address ? redirect(route('account.address.show', [$address]))->with('success', 'New Address Created') : back()->with('error', 'Unable to create new address, please try again');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function setDefault(Request $request)
    {
        $permission = Addresses::canEdit($request->id);

        if (!$permission) {
            return back()->with('error', 'You do not have permission to edit this address');
        }

        return Addresses::setDefault($request->id) ? redirect(route('account.addresses'))->with('success', 'New address set as default') : back()->with('error', 'Unable to set new address to default, please try again');
    }

    /**
     * @param $address_id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteAddress($address_id)
    {
        $permission = Addresses::canEdit($address_id);

        if (!$permission) {
            return back()->with('error', 'You do not have permission to delete this address');
        }

        $deleted = Addresses::destroy($address_id);

        return $deleted ? redirect(route('account.addresses'))->with('success', 'Address has been deleted') : back()->with('error', 'Unable to delete address, please try again later');
    }
}
