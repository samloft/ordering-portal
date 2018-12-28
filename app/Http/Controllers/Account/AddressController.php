<?php

namespace App\Http\Controllers\Account;

use App\Models\Addresses;
use App\Models\Countries;
use Auth;
use App\Http\Controllers\Controller;

class AddressController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $addresses = Addresses::show();

        return view('account.addresses.index', compact('addresses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $countries = Countries::show();

        return view('account.addresses.show', compact('countries'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        $address = $this->validation();

        $address['customer_code'] = Auth::user()->customer_code;
        $address['default'] = request('default') ? 1 : 0;

        $create = Addresses::store($address);

        return $create ? back()->with('success', 'New address has been created') : back()->with('error', 'Unable to create new address, please try again');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $countries = Countries::show();
        $address = Addresses::details($id);

        return $address ? view('account.addresses.show', compact('countries', 'address')) : abort(404);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function update($id)
    {
        $address = $this->validation();

        $address['default'] = request('default') ? 1 : 0;

        $create = Addresses::edit($id, $address);

        return $create ? back()->with('success', 'Address has been updated') : back()->with('error', 'Unable to update address, please try again');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
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
     * @return \Illuminate\Http\RedirectResponse
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
     * Perform validation on the resource
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
