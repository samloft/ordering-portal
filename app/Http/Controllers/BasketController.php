<?php

namespace App\Http\Controllers;

use App\Models\Basket;

class BasketController extends Controller
{
    /**
     * Display the users basket
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $basket = Basket::show();

        return view('basket.index', compact('basket'));
    }
}
