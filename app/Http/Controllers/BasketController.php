<?php

namespace App\Http\Controllers;

use App\Models\Basket;
use App\Models\Product;
use Exception;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class BasketController extends Controller
{
    /**
     * Display the users basket.
     *
     * @return Factory|View
     */
    public function index()
    {
        Cache::forget('basket-'.auth()->user()->customer->code.'-'.auth()->id());

        $basket = Basket::show();

        return view('basket.index', compact('basket'));
    }

    /**
     * Remove all items from customers basket.
     *
     * @return RedirectResponse
     * @throws Exception
     */
    public function clear(): RedirectResponse
    {
        $cleared = Basket::clear();

        return $cleared ? back() : back()->with('error', 'Unable to clear basket, please try again');
    }

    /**
     * Add a product to the basket.
     *
     * @return JsonResponse
     */
    public function addProduct(): JsonResponse
    {
        $product = trim(request('product'));
        $quantity = trim(request('quantity'));
        $update = request('update');

        $product_details = Product::show($product);

        if (! $product_details || $product_details->not_sold) {
            return response()->json([
                'error' => true,
                'message' => 'The product you have entered does not exist.',
            ], 422);
        }

        if (! (int) $quantity || (! $quantity) > 0) {
            return response()->json([
                'error' => true,
                'message' => $quantity.' is not a valid quantity, please enter numeric values or more than 0 only.',
            ], 422);
        }

        if ($quantity % $product_details->order_multiples !== 0) {
            $old_quantity = $quantity;
            $quantity = (int) ceil((int) $quantity / $product_details->order_multiples) * $product_details->order_multiples;
            $warning = 'Quantity not in multiples of '.$product_details->order_multiples.'. Increased from '.$old_quantity.' to '.$quantity.'.';
        } elseif ($product_details->obsolete && $quantity > $product_details->stock) {
            $old_quantity = $quantity;
            $quantity = $product_details->stock;
            $warning = 'This product is obsolete, will not be reordered and we only have '.$product_details->stock.' left. Your quantity has been reduced from '.$old_quantity.' to '.$quantity;
        }

        $details[] = [
            'user_id' => auth()->user()->id,
            'customer_code' => auth()->user()->customer->code,
            'product' => $product_details->code,
            'quantity' => $quantity,
        ];

        $store_basket = Basket::store($details, $update);

        if ($store_basket) {
            $image = Product::checkImage($product_details->code)['image'];

            return response()->json([
                'error' => false,
                'message' => $warning ?? null,
                'basket' => $store_basket['basket_updated'],
                'product' => [
                    'image' => $image,
                    'code' => $product_details->code,
                    'net_price' => currency(discount($product_details->prices->price)),
                    'quantity' => $quantity,
                    'price' => currency(discount($product_details->prices->price) * $quantity, 2),
                    'name' => $product_details->name,
                    'unit' => $product_details->uom,
                    'stock' => $product_details->stock,
                    'link' => '/products/view/'.decodeUrl($product_details->product),
                ],
                'basket_details' => Basket::show(),
            ]);
        }

        return response()->json([
            'error' => true,
            'message' => 'An error occurred while adding the product to your basket, please try again',
        ], 500);
    }

    /**
     * Remove a product line from the basket by product code.
     *
     * @return ResponseFactory|Response
     */
    public function removeProduct()
    {
        $removed = Basket::destroyLine(request('product'));

        return $removed ? response(200) : response(500);
    }
}
