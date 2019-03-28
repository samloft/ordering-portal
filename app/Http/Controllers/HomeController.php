<?php

namespace App\Http\Controllers;

use App\Models\HomeLinks;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the home page.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $links = [
            'categories' => HomeLinks::categories(),
            'adverts' => HomeLinks::adverts(),
        ];

        return view('home.index', compact('links'));
    }
}
