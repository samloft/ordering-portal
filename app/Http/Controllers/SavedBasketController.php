<?php

namespace App\Http\Controllers;

use App\Models\Basket;
use App\Models\SavedBasket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class SavedBasketController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $search = $request ? true : false;

        $saved_baskets = SavedBasket::list($search, $request);

        return view('saved-baskets.index', compact('saved_baskets'));
    }

    /**
     * Display items for the given reference.
     *
     * @param Request $request
     * @return mixed
     */
    public function show(Request $request)
    {
        $saved_basket = SavedBasket::show($request->id);

        if ($saved_basket) {
            return view('saved-baskets.show', compact('saved_basket'));
        }

        return abort(404);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $current_basket = Basket::show();
        $basket_details = [];
        $id = (string)Str::Uuid();

        foreach ($current_basket['lines'] as $item) {
            $basket_details[] = [
                'id' => $id,
                'customer_code' => Auth::user()->customer_code,
                'user_id' => Auth::user()->id,
                'reference' => $request->reference,
                'product' => trim($item['product']),
                'quantity' => $item['quantity'],
                'created_at' => date('Y-m-d')
            ];
        }

        $basket_saved = SavedBasket::store($basket_details);

        return $basket_saved ? response(200) : response(500);
    }

    /**
     * Delete a given saved basket.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        if ($request->id) {
            $deleted = SavedBasket::destroy($request->id);
        } else {
            $deleted = false;
        }

        return $deleted ?
            redirect(route('saved-baskets'))
                ->with('success', 'Saved basket has been deleted.') :
            redirect(route('saved-baskets'))
                ->with('error', 'Unable to delete saved basket, please try again.');
    }
}
