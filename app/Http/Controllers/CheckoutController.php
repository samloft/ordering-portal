<?php

namespace App\Http\Controllers;

use App\Models\Addresses;
use App\Models\Basket;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CheckoutController extends Controller
{
    /**
     * Show the checkout page so a user can complete the order.
     *
     * @return Factory|View
     */
    public function index()
    {
        $basket = Basket::show();

        if ($basket['line_count'] == 0) {
            return redirect(route('basket'))->with('error', 'You have not items in your basket to checkout with.');
        }

        $default_address = Addresses::getDefault();

        return view('checkout.index', compact('default_address'));
    }
}
