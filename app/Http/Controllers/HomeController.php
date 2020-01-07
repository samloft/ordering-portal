<?php

namespace App\Http\Controllers;

use App\Models\OrderTrackingLine;

class HomeController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $popular_products = OrderTrackingLine::popular();

        return view('home.index', compact('popular_products'));
    }
}
