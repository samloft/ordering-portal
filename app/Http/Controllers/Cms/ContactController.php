<?php

namespace App\Http\Controllers\Cms;

use App\Models\Contacts;
use Illuminate\Contracts\View\Factory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\RedirectResponse;
use App\Http\Controllers\Controller;
use Illuminate\View\View;

class ContactController extends Controller
{
    /**
     * @return Factory|View
     */
    public function index()
    {
        $contacts = Contacts::show();

        return view('cms.contacts.index', compact('contacts'));
    }

    /**
     * @param $id
     * @return Contacts|Contacts[]|Collection|Model
     */
    public function show($id)
    {
        return Contacts::findOrFail($id);
    }

    /**
     * @return RedirectResponse
     */
    public function store(): RedirectResponse
    {
        $contact = [
            'name' => request()->name,
            'email' => request()->email
        ];

        if (request()->id) {
            $id = request()->id;

            $updated = Contacts::edit($id, $contact);

            return $updated ? back()->with('success', 'Contact has been updated') : back()->with('error', 'Unable to update contact, please try again');
        }

        $store = Contacts::store($contact);

        return $store ? back()->with('success', 'New contact has been created') : back()->with('error', 'Unable to create new contact, please try again');
    }

    /**
     * @param $id
     * @return RedirectResponse
     */
    public function destroy($id): RedirectResponse
    {
        $deleted = Contacts::destroy($id);

        return $deleted ? back()->with('success', 'Contact has been deleted') : back()->with('error', 'Unable to delete contact, please try again');
    }
}
