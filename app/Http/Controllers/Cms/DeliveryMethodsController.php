<?php

namespace App\Http\Controllers\Cms;

use App\Http\Controllers\Controller;
use App\Models\DeliveryMethod;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DeliveryMethodsController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $delivery_methods = DeliveryMethod::get();

        return view('delivery-methods.index', compact('delivery_methods'));
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(): JsonResponse
    {
        request()->validate([
            'code' => 'required',
            'title' => 'required',
            'identifier' => 'required|max:40',
            'price_low' => 'required|numeric',
            'price' => 'required|numeric',
        ]);

        if (request('id')) {
            return response()->json(DeliveryMethod::edit(request()));
        }

        return response()->json(DeliveryMethod::store(request()));
    }

    /**
     * @param \App\Models\DeliveryMethod $deliveryMethod
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @throws \Exception
     */
    public function destroy(DeliveryMethod $deliveryMethod): JsonResponse
    {
        return response()->json($deliveryMethod->delete());
    }
}
