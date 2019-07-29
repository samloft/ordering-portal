<?php

namespace App\Http\Controllers\Support;

use App\Models\Contacts;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\View\View;

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

        return view('support.contact', compact('contacts'));
    }
}
