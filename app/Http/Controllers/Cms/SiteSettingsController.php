<?php

namespace App\Http\Controllers\Cms;

use App\Http\Controllers\Controller;
use App\Models\GlobalSettings;

class SiteSettingsController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $data = [
            'maintenance' => json_decode(GlobalSettings::key('maintenance'), true)['enabled'],
        ];

        return view('site-settings.index', compact('data'));
    }
}
