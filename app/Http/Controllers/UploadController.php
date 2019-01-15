<?php

namespace App\Http\Controllers;

use App\Models\Basket;
use App\Models\OrderImport;
use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UploadController extends Controller
{
    /**
     * Display the CSV upload page.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('upload.index');
    }

    /**
     * Take a CSV file and validate each line, validating products and qty and merging duplicated products. Then looping over the new array
     * and check the merged lines for order multiple quantity and increasing as needed.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     * @throws \Exception
     */
    public function validation(Request $request)
    {
        OrderImport::clearDown();

        $request->validate([
            'input_file' => 'required|mimes:csv,txt'
        ]);

        $order_lines = array_map('str_getcsv', file($request->file('input_file')));

        $order = [];
        $upload = [];
        $errors = 0;
        $warnings = 0;

        foreach ($order_lines as $key => $value) {
            $product_code = $value[0];
            $product_qty = (int) str_replace([',', '.'], '', $value[1]);
            $error_message = null;
            $warning_message = null;

            if ($product_code && $product_qty > 0) {
                $product = Products::show($value[0]);

                if (!$product || $product->not_sold == 'Y') {
                    $errors++;
                    $error_message = 'Product not found';
                }

                $order[] = [
                    'product' => $product_code,
                    'quantity' => $product_qty,
                    'old_quantity' => $product_qty,
                    'multiples' => isset($product->order_multiples) ? $product->order_multiples : 1,
                    'validation' => [
                        'error' => $error_message,
                        'warning' => $warning_message
                    ]
                ];
            }
        }

        if (!$order) {
            return back()->with('error', 'No products found, please check your file is formatted correctly...');
        }

        $merged = [];

        foreach ($order as $product) {
            $key = $product['product'];
            if (!array_key_exists($key, $merged)) {
                $merged[$key] = $product;
            } else {
                $merged[$key]['quantity'] += (int)$product['quantity'];
                $merged[$key]['old_quantity'] += (int)$product['quantity'];
            }
        }

        $product_lines = [];

        foreach ($merged as $product) {
            if ($product['quantity'] % $product['multiples'] !== 0) {
                $quantity = (int)ceil((int)$product['quantity'] / $product['multiples']) * $product['multiples'];
                $warning = 'Quantity not in multiples of ' . $product['multiples'] . '. Increased from ' . $product['quantity'] . ' to ' . $quantity;
                $warnings++;
            } else {
                $quantity = $product['quantity'];
                $warning = null;
            }

            $product_lines[] = [
                'product' => $product['product'],
                'quantity' => $quantity,
                'old_quantity' => $product['old_quantity'],
                'multiples' => $product['multiples'],
                'validation' => [
                    'error' => $product['validation']['error'],
                    'warning' => $warning
                ]
            ];

            if (!$product['validation']['error']) {
                $upload[] = [
                    'user_id' => Auth::user()->id,
                    'customer_code' => Auth::user()->customer_code,
                    'product' => $product['product'],
                    'quantity' => $quantity,
                ];
            }
        }

        $order = $product_lines;

        if (!OrderImport::store($upload)) {
            return back()->with('error', 'An unknown error occurred, please try uploading again.');
        }

        $order['errors'] = $errors;
        $order['warnings'] = $warnings;

        return view('upload.validated', compact('order'));
    }

    /**
     * When the user clicks "Add to basket" after validation has finished, copy the temp lines in the upload table to the users basket.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     * @throws \Exception
     */
    public function store()
    {
        $order_lines = OrderImport::show();
        $added_to_basket = Basket::store($order_lines);

        if ($added_to_basket) {
            OrderImport::clearDown();

            return view('upload.completed');
        }

        return back()->with('error', 'An error occurred when adding your order to the basket, please try again');
    }
}
