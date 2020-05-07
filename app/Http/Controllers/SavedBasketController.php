<?php

namespace App\Http\Controllers;

use App\Models\Basket;
use App\Models\SavedBasket;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\View\View;

class SavedBasketController extends Controller
{
    /**
     * Display all saved baskets for the current user, if
     * search parameters are passed, display results that match the search.
     *
     * @return Factory|View
     */
    public function index()
    {
        $search = request()->all() ? true : false;

        $saved_baskets = SavedBasket::list($search, request()->all());

        return view('saved-baskets.index', compact('saved_baskets', 'search'));
    }

    /**
     * Display items for the given reference.
     *
     * @return mixed
     */
    public function show()
    {
        $saved_basket = SavedBasket::show(request('reference'));

        if (count($saved_basket) > 0) {
            return view('saved-baskets.show', compact('saved_basket'));
        }

        return abort(404);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(): JsonResponse
    {
        $exists = SavedBasket::where('customer_code', auth()->user()->customer->code)->where('user_id', auth()->id())
            ->where('reference', request('reference'))->first();

        if ($exists) {
            return response()->json('A saved basket already exists for that reference, please use a unique name', 422);
        }

        $current_basket = Basket::show();
        $basket_details = [];

        foreach ($current_basket['lines'] as $item) {
            $basket_details[] = [
                'customer_code' => auth()->user()->customer->code,
                'user_id' => auth()->id(),
                'reference' => request('reference'),
                'product' => trim($item['product']),
                'quantity' => $item['quantity'],
                'created_at' => date('Y-m-d'),
            ];
        }

        $basket_saved = SavedBasket::store($basket_details);

        return $basket_saved ? response()->json('success') : response()->json('error', 400);
    }

    /**
     * Delete a given saved basket.
     *
     * @return RedirectResponse
     */
    public function destroy(): RedirectResponse
    {
        if (request('reference')) {
            $deleted = SavedBasket::destroy(request('reference'));
        } else {
            $deleted = false;
        }

        return $deleted ? redirect(route('saved-baskets'))->with('success', 'Saved basket has been deleted.') : redirect(route('saved-baskets'))->with('error', 'Unable to delete saved basket, please try again.');
    }

    /**
     * Take a saved basket, and copy it into the actual basket.
     *
     * @param $reference
     *
     * @return RedirectResponse|Redirector
     */
    public function copyToBasket($reference)
    {
        $saved_basket = SavedBasket::show($reference);
        $products = [];

        foreach ($saved_basket as $line) {
            if ($line->price) {
                $products[] = [
                    'product' => $line->product,
                    'quantity' => $line->quantity,
                ];
            }
        }

        $copied = Basket::store($products);

        return $copied ? redirect(route('basket'))->with('success', 'Saved basket has been copied') : back()->with('error', 'Unable to copy products to basket, please try again');
    }
}
