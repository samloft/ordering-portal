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
            'countries' => json_decode(GlobalSettings::countries(), true),
            'default_country' => GlobalSettings::key('default-country'),
        ];

        return view('site-settings.index', compact('data'));
    }
}
