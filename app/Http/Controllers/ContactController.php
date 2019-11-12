<?php

namespace App\Http\Controllers;

use App\Mail\Contact;
use App\Models\Contacts;
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
        $contacts = Contacts::show();

        return view('contact.index', compact('contacts'));
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
            'to' => 'required',
            'name' => 'required',
            'email' => 'required',
            'message' => 'required|min:5'
        ]);

        Mail::to(request('to'))->send(new Contact(request()));

        if(Mail::failures()) {
            return back()->with('error', 'Unable to your message, please try again');
        }

        return back()->with('success', 'Thank you for your message, we will get back to you shortly');
    }
}
