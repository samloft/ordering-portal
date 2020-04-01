<?php

namespace App\Http\Controllers\Cms;

use App\Http\Controllers\Controller;

class PromotionController extends Controller
{
    /**
     * Display a list of all promotions that have not expired.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('promotions.index');
    }
}
