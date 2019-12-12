<?php

namespace App\Http\Controllers;

use App\Models\HomeLink;
use Illuminate\Http\Response;

class HomeController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        //$links = [
        //    'categories' => HomeLink::categories(),
        //    'adverts' => HomeLink::adverts(),
        //];

        return view('home.index');
    }
}
