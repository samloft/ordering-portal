<?php

namespace App\Http\Controllers\Cms;

use App\Http\Controllers\Controller;
use App\Models\CustomerDiscount;
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
        $customer_discounts = CustomerDiscount::show();

        return view('discounts.index', compact('global_discount', 'customer_discounts'));
    }

    /**
     * @return bool|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|object|void|null
     */
    public function store()
    {
        if (request('id')) {
            request()->validate([
                'percent' => 'required|numeric|gt:-1|lt:10',
            ]);
        } else {
            request()->validate([
                'customer_code' => 'unique:customer_discounts|exists:customers,code',
                'percent' => 'required|numeric|gt:-1|lt:10',
            ]);
        }

        return CustomerDiscount::store(request('customer_code'), request('percent'), request('id'));
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

        GlobalSettings::where('key', 'discount')->update([
            'value' => request('global_discount'),
        ]);

        Cache::forget('discount');

        return back()->with('success', 'Global discount percentage has been updated');
    }

    /**
     * @return mixed
     */
    public function destroy()
    {
        return CustomerDiscount::where('id', request('id'))->delete();
    }
}
