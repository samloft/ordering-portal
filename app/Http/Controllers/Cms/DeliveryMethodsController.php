<?php

namespace App\Http\Controllers\Cms;

use App\Http\Controllers\Controller;
use App\Models\DeliveryMethod;
use App\Models\GlobalSettings;
use Cache;
use Illuminate\Http\JsonResponse;

class DeliveryMethodsController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $delivery_methods = DeliveryMethod::get();
        $collection_messages = GlobalSettings::collectionMessages();

        return view('delivery-methods.index', compact('delivery_methods', 'collection_messages'));
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
     * @throws \Exception
     */
    public function destroy(DeliveryMethod $deliveryMethod): JsonResponse
    {
        return response()->json($deliveryMethod->delete());
    }

    /**
     * @return int
     */
    public function storeCollectionMessage(): int
    {
        Cache::forget('collection-messages');

        $times = [];

        foreach (request('times') as $timed_message) {
            $times[] = [
                'start' => $timed_message['start'],
                'end' => $timed_message['end'],
                'message' => $timed_message['message'],
                'identifier' => $timed_message['identifier'],
            ];
        }

        $collection_messages = [
            'default' => request('default'),
            'times' => $times,
        ];

        return GlobalSettings::where('key', 'collection-messages')
            ->update(['value' => json_encode($collection_messages, true)]);
    }
}
