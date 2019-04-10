<?php

namespace App\Http\Controllers\Support;

use Illuminate\Contracts\View\Factory;
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
        return view('support.contact');
    }
}
