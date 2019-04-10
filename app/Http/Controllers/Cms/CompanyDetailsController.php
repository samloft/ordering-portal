<?php

namespace App\Http\Controllers\Cms;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CompanyDetailsController extends Controller
{
    public function index()
    {
        return view('cms.company-information.index');
    }

    /**
     * Update the customer information in the .env file.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request)
    {
        $env_path = base_path('.env');

        $keys = [
            // Address Details
            'ADDRESS_LINE_1' => $request->address_line_1,
            'ADDRESS_LINE_2' => $request->address_line_2,
            'ADDRESS_LINE_3' => $request->address_line_3,
            'ADDRESS_LINE_4' => $request->address_line_4,
            'ADDRESS_LINE_5' => $request->address_line_5,
            'ADDRESS_POSTCODE' => $request->postcode,
            'ADDRESS_TELEPHONE' => $request->telephone,
            'ADDRESS_FAX' => $request->fax,
            'ADDRESS_EMAIL' => $request->email,

            // Social Details
            'SOCIAL_FACEBOOK' => $request->facebook,
            'SOCIAL_LINKEDIN' => $request->linkedin,
            'SOCIAL_TWITTER' => $request->twitter,
            'SOCIAL_INSTAGRAM' => $request->instagram,

            // App Details
            'APP_APPLE' => $request->apple,
            'APP_ANDROID' => $request->android,
        ];

        foreach ($keys as $key => $value) {
            file_put_contents($env_path, str_replace(
                $key . '="' . env($key) . '"', $key . '="' . $value . '"', file_get_contents($env_path)
            ));
        }

        return back()->with('success', 'Company details have been updated');
    }
}