<?php

namespace App\Http\Controllers\Cms;

use App\Http\Controllers\Controller;

class SiteSettingsController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('site-settings.index');
    }
}
