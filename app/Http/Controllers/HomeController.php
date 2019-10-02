<?php

namespace App\Http\Controllers;

use App\Models\HomeLinks;
use Illuminate\Http\Response;

class HomeController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
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
