<?php

namespace App\Http\Controllers\Cms;

use App\Http\Controllers\Controller;
use App\Models\GlobalSettings;
use Hyn\Tenancy\Environment;
use Illuminate\Http\RedirectResponse;

class SiteSettingsController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $data = [
            //'maintenance' => json_decode(GlobalSettings::key('maintenance'), true)['enabled'],
            'maintenance' => app(Environment::class)->hostname()->under_maintenance_since,
            'announcement' => GlobalSettings::siteAnnouncement(),
            'checkout_notice' => GlobalSettings::checkoutNotice(),
            'countries' => json_decode(GlobalSettings::countries(), true),
            'default_country' => GlobalSettings::defaultCountry(),
            'google_analytics' => GlobalSettings::googleAnalyticsUrl(),
            'google_maps' => GlobalSettings::googleMapsUrl(),
            'v1_docid' => GlobalSettings::versionOneDocId(),
        ];

        return view('site-settings.index', compact('data'));
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(): RedirectResponse
    {
        GlobalSettings::storeSiteSettings();

        return back()->with('success', 'Site settings have been updated');
    }
}
