<?php

namespace App\Http\Controllers\Cms;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Promotion;
use Illuminate\Validation\Rule;

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

    /**
     * @return bool
     */
    public function store(): bool
    {
        $this->validation();

        $promotion = new Promotion(request()->all());

        return $promotion->save();
    }

    /**
     * @return array|bool|null
     */
    public function validation()
    {
        return request()->validate([
            'product' => 'required|exists:products,code',
            'product_qty' => 'required|integer',
            'promotion_product' => 'required|exists:products,code',
            'promotion_qty' => 'required|integer',
            'claim_type' => 'required',
            'buying_groups' => Rule::requiredIf(request('restrictions') === 'buying_group'),
            'start_date' => 'required|date',
        ]);
    }
}
