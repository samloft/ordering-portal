<?php

namespace App\Http\Controllers;

use App\Models\Basket;
use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BasketController extends Controller
{
    /**
     * Display the users basket
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $basket = Basket::show();

        return view('basket.index', compact('basket'));
    }

    /**
     * Remove all items from customers basket.
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function clear()
    {
        $cleared = Basket::clear();

        return $cleared ? back() : back()->with('error', 'Unable to clear basket, please try again');
    }

    /**
     * Add a product to the basket
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function addProduct(Request $request)
    {
        $product = trim($request->product);
        $quantity = trim($request->quantity);

        $product_details = Products::show($product);

        if (!$product_details) {
            return response()->json([
                'error' => true,
                'message' => 'The product you have entered does not exist.'
            ], 201);
        }

        if (!(int) $quantity || !$quantity > 0) {
            return response()->json([
                'error' => true,
                'message' => $quantity . ' is not a valid quantity, please enter numeric values or more than 0 only.'
            ], 201);
        }

        if ($quantity % $product_details->order_multiples !== 0) {
            $old_quantity = $quantity;
            $quantity = (int)ceil((int)$quantity / $product_details->order_multiples) * $product_details->order_multiples;
            $warning = 'Quantity not in multiples of ' . $product_details->order_multiples . '. Increased from ' . $old_quantity . ' to ' . $quantity . '.';
        }

        $details[] = [
            'user_id' => Auth::user()->id,
            'customer_code' => Auth::user()->customer_code,
            'product' => $product_details->product,
            'quantity' => $quantity
        ];

        $added_to_basket = Basket::store($details);

        if ($added_to_basket) {
            return response()->json([
                'error' => false,
                'message' => isset($warning) ? $warning : null,
                'product' => [
                    'image' => 'https://scolmoreonline.com/product_images/' . $product_details->product . '.png',
                    'product' => $product_details->product,
                    'quantity' => $quantity,
                    'price' => currency() . number_format($product_details->prices->price * $quantity, 4),
                    'name' => $product_details->name
                ]
            ]);
        }

        return response()->json([
            'error' => true,
            'message' => 'An error occurred while adding the product to your basket, please try again'
        ], 500);
    }
}
