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
     *
     * @return bool|null
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
            'type' => 'required',
            'minimum_value' => Rule::requiredIf(request('type') === 'value').'|numeric|nullable',
            'value_reward' => Rule::requiredIf(request('type') === 'value'),
            'value_percent' => Rule::requiredIf(request('type') === 'value' && request('value_reward') === 'percent').'|integer|nullable',
            'product' => Rule::requiredIf(request('type') === 'product').'|exists:products,code|nullable',
            'product_qty' => Rule::requiredIf(request('type') === 'product').'|integer|nullable',
            'promotion_product' => Rule::requiredIf(request('type') === 'product' || request('value_reward') === 'product').'|exists:products,code|nullable',
            'promotion_qty' => Rule::requiredIf(request('type') === 'product' || request('value_reward') === 'product').'|integer|nullable',
            'max_claims' => 'integer|nullable',
            'claim_type' => 'required',
            'buying_groups' => Rule::requiredIf(request('restrictions') === 'buying_group'),
            'start_date' => 'required|date',
        ]);
    }
}
