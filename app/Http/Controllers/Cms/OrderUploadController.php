<?php

namespace App\Http\Controllers\Cms;

use App\Http\Controllers\Controller;
use App\Models\GlobalSettings;
use Cache;
use Illuminate\Http\RedirectResponse;

class OrderUploadController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $settings = GlobalSettings::uploadConfig();

        return view('order-upload.index', compact('settings'));
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     * @throws \JsonException
     */
    public function store(): RedirectResponse
    {
        Cache::forget('upload-config');

        $config = json_encode([
            'prices' => request('prices') ? true : false,
            'packs' => request('packs') ? true : false,
        ], JSON_THROW_ON_ERROR | true);

        GlobalSettings::where('key', 'upload-config')->update([
            'value' => $config,
        ]);

        return back()->with('success', 'Order upload config has been updated');
    }
}
