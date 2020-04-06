<?php

namespace App\Http\Controllers\Cms;

use App\Http\Controllers\Controller;
use App\Models\Customer;

class PromotionController extends Controller
{
    /**
     * Display a list of all promotions that have not expired.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $buying_groups = Customer::buyingGroups();
        $price_lists = Customer::priceLists();
        $discount_codes = Customer::discountCodes();

        return view('promotions.index', compact('buying_groups', 'price_lists', 'discount_codes'));
    }
}
