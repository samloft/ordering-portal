<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\GlobalSettings;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

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

        return view('addresses.index', compact('addresses', 'checkout'));
    }

    /**
     * Show the form for creating a new addresses.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $checkout = request('checkout');
        $country_list = json_decode(GlobalSettings::countries(), true);
        $default_country = GlobalSettings::key('default-country');

        $countries = [];

        foreach ($country_list as $country) {
            $countries[] = [
                'name' => $country['name'],
                'default' => $country['name'] === $default_country,
            ];
        }

        return view('addresses.show', compact('countries', 'checkout'));
    }

    /**
     * Store a newly created address in storage.
     *
     * @return RedirectResponse
     */
    public function store(): RedirectResponse
    {
        $checkout = request('checkout');
        $address = $this->validation();

        $address['customer_code'] = auth()->user()->customer->code;

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
     *
     * @return mixed
     */
    public function edit($id)
    {
        $checkout = request('checkout');
        $country_list = json_decode(GlobalSettings::countries(), true);
        $address = Address::details($id);
        $default_country = GlobalSettings::key('default-country');

        $countries = [];

        foreach ($country_list as $country) {
            $countries[] = [
                'name' => $country['name'],
                'default' => $country['name'] === $default_country,
            ];
        }

        return $address ? view('addresses.show', compact('countries', 'address', 'checkout')) : abort(404);
    }

    /**
     * Update the specified address in storage.
     *
     * @param $id
     *
     * @return RedirectResponse
     */
    public function update($id): RedirectResponse
    {
        $address = $this->validation();

        $create = Address::edit($id, $address);

        return $create ? back()->with('success', 'Address has been updated') : back()->with('error', 'Unable to update address, please try again');
    }

    /**
     * Remove the specified address from storage.
     *
     * @param $id
     *
     * @return RedirectResponse
     * @throws \Exception
     */
    public function destroy($id): RedirectResponse
    {
        $permission = Address::canEdit($id);

        if (! $permission) {
            return back()->with('error', 'You do not have permission to delete this address');
        }

        $deleted = Address::destroy($id);

        return $deleted ? redirect(route('account.addresses'))->with('success', 'Address has been deleted') : back()->with('error', 'Unable to delete address, please try again later');
    }

    /**
     * Selects a none default address for checkout.
     *
     * @param $address_id
     *
     * @return RedirectResponse|Redirector
     */
    public function select($address_id)
    {
        $address = Address::details($address_id);

        if (! $address) {
            return redirect(route('account.addresses'))->with('error', 'Address not found, please try again');
        }

        $this->tempAddress($address);

        return redirect(route('checkout', ['account' => true]));
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
                'company_name' => $address->company_name,
                'address_line_2' => $address->address_line_2,
                'address_line_3' => $address->address_line_3,
                'address_line_4' => $address->address_line_4,
                'address_line_5' => $address->address_line_5,
                'post_code' => $address->post_code,
            ],
        ]);
    }

    /**
     * Lookup a postcode to get address details.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function lookup(): JsonResponse
    {
        request()->validate([
            'postcode' => 'required|min:3',
        ]);

        $postcode = strtoupper(str_replace(' ', '', request('postcode')));

        $addresses = Cache::get('addresses-'.$postcode);

        if (! $addresses) {
            $addresses = Http::get('https://api.getAddress.io/find/'.$postcode, [
                'api-key' => env('POSTCODE_API_KEY'),
                'expanded' => true,
            ]);

            Cache::put('addresses-'.$postcode, $addresses->json(), 60 * 24);

            return response()->json($addresses->json(), $addresses->status());
        }

        return response()->json($addresses, $addresses ? 200 : 404);
    }

    /**
     * Perform validation on the address.
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
            'country' => 'required',
            'post_code' => 'required|min:3',
        ]);
    }
}
