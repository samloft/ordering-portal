<?php

namespace App\Http\Controllers;

use App\Models\HomeLink;

class HomeController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $adverts = HomeLink::adverts();

        return view('home.index', compact('adverts'));
    }
}
