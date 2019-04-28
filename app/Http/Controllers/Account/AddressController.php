<?php

namespace App\Http\Controllers\Account;

use App\Models\Addresses;
use App\Models\Countries;
use Auth;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Input;

class AddressController extends Controller
{
    /**
     * Display a listing of the addresses.
     *
     * @return Response
     */
    public function index()
    {
        if (session('address')) {
            session()->forget('address');
        }

        $addresses = Addresses::show();
        $checkout = Input::get('checkout') ? true : false;

        return view('account.addresses.index', compact('addresses', 'checkout'));
    }

    /**
     * Show the form for creating a new addresses.
     *
     * @return Response
     */
    public function create()
    {
        $checkout = Input::get('checkout');
        $countries = Countries::show();

        return view('account.addresses.show', compact('countries', 'checkout'));
    }

    /**
     * Store a newly created address in storage.
     *
     * @return Response
     */
    public function store()
    {
        $checkout = request('checkout');
        $address = $this->validation();

        $address['customer_code'] = Auth::user()->customer->customer_code;
        $address['default'] = request('default') ? 1 : 0;

        $create = Addresses::store($address);

        if ($checkout) {
            $address = Addresses::details($create);
            $this->tempAddress($address);

            return $create ? redirect(route('checkout')) : back()->with('error', 'Unable to create new address, please try again');
        }

        return $create ? back()->with('success', 'New address has been created') : back()->with('error', 'Unable to create new address, please try again');
    }

    /**
     * Show the form for editing the specified address.
     *
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        $countries = Countries::show();
        $address = Addresses::details($id);

        return $address ? view('account.addresses.show', compact('countries', 'address')) : abort(404);
    }

    /**
     * Update the specified address in storage.
     *
     * @param $id
     * @return Response
     */
    public function update($id)
    {
        $address = $this->validation();

        $address['default'] = request('default') ? 1 : 0;

        $create = Addresses::edit($id, $address);

        return $create ? back()->with('success', 'Address has been updated') : back()->with('error', 'Unable to update address, please try again');
    }

    /**
     * Remove the specified address from storage.
     *
     * @param int $id
     * @return Response
     * @throws Exception
     */
    public function destroy($id)
    {
        $permission = Addresses::canEdit($id);

        if (!$permission) {
            return back()->with('error', 'You do not have permission to delete this address');
        }

        $deleted = Addresses::destroy($id);

        return $deleted ? redirect(route('account.addresses'))->with('success', 'Address has been deleted') : back()->with('error', 'Unable to delete address, please try again later');
    }

    /**
     * Set the address as the default for the customer
     *
     * @return RedirectResponse
     */
    public function default()
    {
        $permission = Addresses::canEdit(request('id'));

        if (!$permission) {
            return back()->with('error', 'You do not have permission to edit this address');
        }

        return Addresses::setDefault(request('id')) ? redirect(route('account.addresses'))->with('success', 'New address set as default') : back()->with('error', 'Unable to set new address to default, please try again');
    }

    /**
     * Selects a none default address for checkout.
     *
     * @return RedirectResponse|Redirector
     */
    public function select()
    {
        $address_id = Input::get('id');
        $address = Addresses::details($address_id);

        if (!$address) {
            return redirect(route('account.addresses'))->with('error', 'Address not found, please try again');
        }

        $this->tempAddress($address);

        return redirect(route('checkout'));
    }

    /**
     * Stores the given temporary address in a session for use
     * on checkout.
     *
     * @param $address
     */
    public function tempAddress($address)
    {
        session([
            'address' => [
                'address_id' => $address->id,
                'address_details' => [
                    'company_name' => $address->company_name,
                    'address_2' => $address->address_line_2,
                    'address_3' => $address->address_line_3,
                    'address_4' => $address->address_line_4,
                    'address_5' => $address->address_line_5,
                    'postcode' => $address->post_code
                ]
            ]
        ]);
    }

    /**
     * Perform validation on the address
     *
     * @return mixed
     */
    public function validation()
    {
        return request()->validate([
            'company_name' => 'required|min:2',
            'address_line_2' => 'required|min:2',
            'address_line_3' => 'required|min:2',
            'address_line_4' => 'nullable',
            'address_line_5' => 'nullable',
            'country_id' => 'required|exists:countries,id',
            'post_code' => 'required|min:3',
        ]);
    }
}
