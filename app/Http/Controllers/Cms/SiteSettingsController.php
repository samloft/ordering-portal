<?php

namespace App\Http\Controllers\Cms;

use App\Http\Controllers\Controller;
use App\Models\GlobalSettings;
use Illuminate\Http\RedirectResponse;

class SiteSettingsController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $data = [
            'maintenance' => json_decode(GlobalSettings::key('maintenance'), true)['enabled'],
            'announcement' => GlobalSettings::siteAnnouncement(),
            'checkout_notice' => GlobalSettings::checkoutNotice(),
            'countries' => json_decode(GlobalSettings::countries(), true),
            'default_country' => GlobalSettings::defaultCountry(),
            'google_analytics' => GlobalSettings::googleAnalyticsUrl(),
            'google_maps' => GlobalSettings::googleMapsUrl(),
            'v1_docid' => GlobalSettings::versionOneDocId(),
            'last_order' => GlobalSettings::where('key', 'last-order')->first()->value,
        ];

        return view('site-settings.index', compact('data'));
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(): RedirectResponse
    {
        request()->validate([
            'last_order' => 'required|regex:/^[A-Z]{1}[0-9]{6}$/'
        ]);

        GlobalSettings::storeSiteSettings();

        return back()->with('success', 'Site settings have been updated');
    }
}
