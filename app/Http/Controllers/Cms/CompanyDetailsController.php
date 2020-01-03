<?php

namespace App\Http\Controllers\Cms;

use App\Http\Controllers\Controller;
use App\Models\GlobalSettings;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class CompanyDetailsController extends Controller
{
    /**
     * Display the company details form.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $company_details = json_decode(GlobalSettings::where('key', 'company-details')->first()->value, true);

        return view('company-information.index', compact('company_details'));
    }

    /**
     * Update the company details information.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(): RedirectResponse
    {
        $company_details = json_encode([
            'line_1'    => request('line_1'),
            'line_2'    => request('line_2'),
            'line_3'    => request('line_3'),
            'line_4'    => request('line_4'),
            'line_5'    => request('line_5'),
            'postcode'  => request('postcode'),
            'telephone' => request('telephone'),
            'email'     => request('email'),
            'social'    => [
                'facebook'  => request('facebook'),
                'twitter'   => request('twitter'),
                'linkedin'  => request('linkedin'),
                'instagram' => request('instagram'),
                'youtube'   => request('youtube'),
            ],
            'apps' => [
                'apple'   => request('apple'),
                'android' => request('android'),
            ],
        ], true);

        GlobalSettings::where('key', 'company-details')->update(['value' => $company_details]);
        Cache::forget('company_details');

        return back()->with('success', 'Company details have been updated');
    }
}
