<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SavedBasketController extends Controller
{
    public function index()
    {
        return view('saved-baskets.index');
    }
}
