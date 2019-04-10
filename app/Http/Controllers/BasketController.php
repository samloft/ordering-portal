<?php

namespace App\Http\Controllers;

use App\Models\Basket;
use App\Models\Products;
use Exception;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Auth;
use Illuminate\View\View;

class BasketController extends Controller
{
    /**
     * Display the users basket
     *
     * @return Factory|View
     */
    public function index()
    {
        $basket = Basket::show();

        return view('basket.index', compact('basket'));
    }

    /**
     * Remove all items from customers basket.
     *
     * @return RedirectResponse
     * @throws Exception
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
     * @return JsonResponse
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

        if (!(int)$quantity || !$quantity > 0) {
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
            'customer_code' => Auth::user()->customer->customer_code,
            'product' => $product_details->product,
            'quantity' => $quantity
        ];

        $store_basket = Basket::store($details);

        if ($store_basket) {
            return response()->json([
                'error' => false,
                'message' => isset($warning) ? $warning : null,
                'basket' => $store_basket['basket_updated'],
                'product' => [
                    'image' => 'https://scolmoreonline.com/product_images/' . $product_details->product . '.png',
                    'product' => $product_details->product,
                    'net_price' => currency(discount($product_details->price)),
                    'quantity' => $quantity,
                    'price' => currency(discount($product_details->price) * $quantity, 2),
                    'name' => $product_details->name,
                    'unit' => $product_details->uom,
                    'stock' => $product_details->quantity,
                    'link' => '/products/view/' . decodeUrl($product_details->product),
                ]
            ], 200);
        }

        return response()->json([
            'error' => true,
            'message' => 'An error occurred while adding the product to your basket, please try again'
        ], 500);
    }

    /**
     * Remove a product line from the basket by product code.
     *
     * @param Request $request
     * @return ResponseFactory|Response
     */
    public function removeProduct(Request $request)
    {
        $removed = Basket::destroyLine($request->product);

        return $removed ? response(200) : response(500);
    }

    /**
     * Update the basket quantity for the given product.
     *
     * @param Request $request
     * @return ResponseFactory|Response
     */
    public function updateProductQuantity(Request $request)
    {
        $updated = Basket::updateLine($request->product, $request->qty);

        return $updated ? response(200) : response(500);
    }
}
