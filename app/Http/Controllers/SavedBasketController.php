<?php

namespace App\Http\Controllers;

use App\Models\Basket;
use App\Models\SavedBasket;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Auth;
use Illuminate\Support\Str;
use Illuminate\View\View;

class SavedBasketController extends Controller
{
    /**
     * Display all saved baskets for the current user, if
     * search parameters are passed, display results that match the search.
     *
     * @param Request $request
     * @return Factory|View
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

        if (count($saved_basket) > 0) {
            return view('saved-baskets.show', compact('saved_basket'));
        }

        return abort(404);
    }

    /**
     * @param Request $request
     * @return ResponseFactory|Response
     */
    public function store(Request $request)
    {
        $current_basket = Basket::show();
        $basket_details = [];
        $id = (string)Str::Uuid();

        foreach ($current_basket['lines'] as $item) {
            $basket_details[] = [
                'id' => $id,
                'customer_code' => Auth::user()->customer->customer_code,
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
     * @return RedirectResponse
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

    /**
     * Take a saved basket, and copy it into the actual basket.
     *
     * @param $id
     * @return RedirectResponse|Redirector
     */
    public function copyToBasket($id)
    {
        $saved_basket = SavedBasket::show($id);
        $products = [];

        foreach ($saved_basket as $line) {
            if ($line->price) {
                $products[] = [
                    'product' => $line->product,
                    'quantity' => $line->quantity
                ];
            }
        }

        $copied = Basket::store($products);

        return $copied ? redirect(route('basket'))->with('success', 'Saved basket has been copied') :
            back()->with('error', 'Unable to copy products to basket, please try again');
    }
}
