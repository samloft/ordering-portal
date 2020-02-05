<?php

namespace App\Http\Controllers\Cms;

use App\Http\Controllers\Controller;
use App\Models\GlobalSettings;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Cache;

class DiscountsController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $global_discount = GlobalSettings::discount();

        return view('discounts.index', compact('global_discount'));
    }

    /**
     * Update the global discount rate for any customer that
     * does not have an override.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function globalStore(): RedirectResponse
    {
        request()->validate([
            'global_discount' => 'required|numeric|gt:-1|lt:10',
        ]);

        $updated = GlobalSettings::where('key', 'discount')->update([
            'value' => request('global_discount'),
        ]);

        Cache::forget('discount');

        if ($updated) {
            return back()->with('success', 'Global discount percentage has been updated');
        }

        return back()->with('error', 'Unable to update the global discount, please try again');
    }
}
