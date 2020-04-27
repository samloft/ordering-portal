<?php

namespace App\Http\Controllers\Cms;

use App\Http\Controllers\Controller;
use App\Models\GlobalSettings;
use Illuminate\Support\Facades\Cache;

class SmallOrderChargeController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $small_order_rules = json_decode(GlobalSettings::smallOrderCharge(), true);

        return view('small-order.index', compact('small_order_rules'));
    }

    public function update()
    {
        request()->validate([
            'threshold' => 'required_with:charge|integer|min:1|max:500',
            'charge' => 'required_with:threshold|integer|min:1|max:500',
            'exclude_delivery_charges' => 'required|boolean',
            'exclude_collection' => 'required|boolean',
        ]);

        Cache::forget('small-order-charge');

        GlobalSettings::where('key', 'small-order-charge')->update([
            'value' => json_encode([
                'threshold' => request('threshold'),
                'charge' => request('charge'),
                'exclude_on_charge_delivery' => request('exclude_delivery_charges'),
                'exclude_on_collection' => request('exclude_collection'),
            ], true),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        return back()->with('success', 'Small order charge rules have been updated');
    }
}
