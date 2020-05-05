<?php

namespace App\Http\Controllers\Cms;

use App\Http\Controllers\Controller;
use App\Models\GlobalSettings;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Cache;

class ProductDataController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $settings = GlobalSettings::productData();

        return view('product-data-settings.index', compact('settings'));
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \JsonException
     */
    public function store(): RedirectResponse
    {
        $product_data = GlobalSettings::where('key', 'product-data')->firstOrFail();

        $product_data->value = json_encode([
            'data' => request('product_data') ? true : false,
            'prices' => request('product_prices') ? true : false,
        ], JSON_THROW_ON_ERROR | true);

        $product_data->save();

        Cache::forget('product-data');

        return back()->with('success', 'Product data settings have been updated');
    }
}
