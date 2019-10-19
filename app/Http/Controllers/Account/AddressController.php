<?php

namespace App\Http\Controllers\Account;

use App\Models\Address;
use App\Models\Countries;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Input;

class AddressController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        if (session('address')) {
            session()->forget('address');
        }

        $addresses = Address::show();
        $checkout = request('checkout') ? true : false;

        return view('account.addresses.index', compact('addresses', 'checkout'));
    }

    /**
     * Show the form for creating a new addresses.
     *
     * @return Response
     */
    public function create(): Response
    {
        $checkout = request('checkout');
        $countries = Countries::show();

        return view('account.addresses.show', compact('countries', 'checkout'));
    }

    /**
     * Store a newly created address in storage.
     *
     * @return Response
     */
    public function store(): Response
    {
        $checkout = request('checkout');
        $address = $this->validation();

        $address['customer_code'] = auth()->user()->customer->code;
        $address['default'] = request('default') ? 1 : 0;

        $create = Address::store($address);

        if ($checkout) {
            $address = Address::details($create);
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
    public function edit($id): Response
    {
        $countries = Countries::show();
        $address = Address::details($id);

        return $address ? view('account.addresses.show', compact('countries', 'address')) : abort(404);
    }

    /**
     * Update the specified address in storage.
     *
     * @param $id
     * @return Response
     */
    public function update($id): Response
    {
        $address = $this->validation();

        $address['default'] = request('default') ? 1 : 0;

        $create = Address::edit($id, $address);

        return $create ? back()->with('success', 'Address has been updated') : back()->with('error', 'Unable to update address, please try again');
    }

    /**
     * Remove the specified address from storage.
     *
     * @param int $id
     * @return Response
     * @throws Exception
     */
    public function destroy($id): Response
    {
        $permission = Address::canEdit($id);

        if (!$permission) {
            return back()->with('error', 'You do not have permission to delete this address');
        }

        $deleted = Address::destroy($id);

        return $deleted ? redirect(route('account.addresses'))->with('success', 'Address has been deleted') : back()->with('error', 'Unable to delete address, please try again later');
    }

    /**
     * Set the address as the default for the customer
     *
     * @return RedirectResponse
     */
    public function default(): RedirectResponse
    {
        $permission = Address::canEdit(request('id'));

        if (!$permission) {
            return back()->with('error', 'You do not have permission to edit this address');
        }

        return Address::setDefault(request('id')) ? redirect(route('account.addresses'))->with('success', 'New address set as default') : back()->with('error', 'Unable to set new address to default, please try again');
    }

    /**
     * Selects a none default address for checkout.
     *
     * @return RedirectResponse|Redirector
     */
    public function select()
    {
        $address_id = request('id');
        $address = Address::details($address_id);

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
    public function tempAddress($address): void
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
