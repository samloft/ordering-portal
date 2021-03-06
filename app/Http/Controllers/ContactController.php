<?php

namespace App\Http\Controllers;

use App\Mail\Contact;
use App\Models\Contact as ContactData;
use App\Models\GlobalSettings;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Mail;

class ContactController extends Controller
{
    /**
     * Display the contact page with google map and company address.
     *
     * @return Factory|View
     */
    public function index()
    {
        $contacts = ContactData::get();
        $map = GlobalSettings::googleMapsUrl();

        return view('contact.index', compact('contacts', 'map'));
    }

    /**
     * Submit the contact form, sending to the department selected by
     * the user.
     *
     * @return RedirectResponse
     */
    public function store(): RedirectResponse
    {
        request()->validate([
            'to' => 'required|exists:contacts,email',
            'name' => 'required',
            'email' => 'required',
            'message' => 'required|min:5',
        ]);

        Mail::to(request('to'))->send(new Contact(request()));

        return back()->with('success', 'Thank you for your message, we will get back to you shortly');
    }
}
