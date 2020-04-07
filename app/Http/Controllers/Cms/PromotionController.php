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
        $promotions = Promotion::notExpired();
        $buying_groups = Customer::buyingGroups();
        $price_lists = Customer::priceLists();
        $discount_codes = Customer::discountCodes();

        return view('promotions.index', compact('promotions', 'buying_groups', 'price_lists', 'discount_codes'));
    }

    /**
     * Create a new promotion.
     *
     * @return bool
     */
    public function store(): bool
    {
        $this->validation();

        $promotion = new Promotion(request()->all());

        return $promotion->save();
    }

    /**
     * Update a promotion by the passed ID.
     *
     * @param $id
     *
     * @return bool
     */
    public function edit($id): bool
    {
        $this->validation();

        $promotion = Promotion::findOrFail($id);

        return $promotion->update(request()->all());
    }

    /**
     * Delete a promotion with the passed ID.
     *
     * @param $id
     * @return bool|null
     *
     * @throws \Exception
     */
    public function destroy($id): ?bool
    {
        $promotion = Promotion::findOrFail($id);

        return $promotion->delete();
    }

    /**
     * Validate all the data passed for a promotion.
     *
     * @return array|bool|null
     */
    public function validation()
    {
        return request()->validate([
            'product' => 'required|exists:products,code',
            'product_qty' => 'required|integer',
            'promotion_product' => 'required|exists:products,code',
            'promotion_qty' => 'required|integer',
            'max_claims' => 'integer|nullable',
            'claim_type' => 'required',
            'buying_groups' => Rule::requiredIf(request('restrictions') === 'buying_group'),
            'start_date' => 'required|date',
        ]);
    }
}
