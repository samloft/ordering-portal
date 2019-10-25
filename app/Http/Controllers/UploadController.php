<?php

namespace App\Http\Controllers;

use App\Models\Basket;
use App\Models\OrderImport;
use App\Models\Product;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class UploadController extends Controller
{
    /**
     * Display the CSV upload page.
     *
     * @return Factory|View
     */
    public function index()
    {
        return view('upload.index');
    }

    /**
     * Take a CSV file and validate each line, validating products and qty and merging duplicated products. Then looping over the new array
     * and check the merged lines for order multiple quantity and increasing as needed.
     *
     * @return Factory|RedirectResponse|View
     * @throws Exception
     */
    public function validation()
    {
        OrderImport::clearDown();

        request()->validate([
            'csv_file' => 'required|mimes:csv,txt',
        ]);

        $upload = [];
        $errors = 0;
        $warnings = 0;
        $prices_passed = false;

        foreach (array_map('str_getcsv', file(request()->file('csv_file'))) as $key => $value) {
            $product_code = $value[0];
            $product_qty = (int) str_replace([',', '.'], '', $value[1]);
            $product_price = $value[2] ?? null;
            $error_message = null;
            $warning_message = null;

            if ($product_code && $product_qty > 0) {
                $product = Product::show($product_code);

                if (! $product || $product->not_sold === 'Y') {
                    $errors++;
                    $error_message = 'Product not found';
                }

                if ($product_price) {
                    $prices_passed = true;
                    $price_match = ($product_price !== $product->price);
                } else {
                    $price_match = null;
                }

                $order[] = [
                    'product' => $product_code,
                    'quantity' => $product_qty,
                    'old_quantity' => $product_qty,
                    'passed_price' => $product_price,
                    'price' => $product->price ?? null,
                    'price_match_error' => $price_match,
                    'multiples' => $product->order_multiples ?? 1,
                    'validation' => [
                        'error' => $error_message,
                        'warning' => $warning_message,
                    ],
                ];
            }
        }

        if (! isset($order)) {
            return back()->with('error', 'No products found, please check your file is formatted correctly...');
        }

        $merged = [];

        foreach ($order as $product) {
            $key = $product['product'];
            if (! array_key_exists($key, $merged)) {
                $merged[$key] = $product;
            } else {
                $merged[$key]['quantity'] += (int) $product['quantity'];
                $merged[$key]['old_quantity'] += (int) $product['quantity'];
            }
        }

        $product_lines = [];

        foreach ($merged as $product) {
            if ($product['quantity'] % $product['multiples'] !== 0) {
                $quantity = (int) ceil((int) $product['quantity'] / $product['multiples']) * $product['multiples'];
                $warning = 'Quantity not in multiples of '.$product['multiples'].'. Increased from '.$product['quantity'].' to '.$quantity;
                $warnings++;
            } else {
                $quantity = $product['quantity'];
                $warning = null;
            }

            $product_lines[] = [
                'product' => $product['product'],
                'quantity' => $quantity,
                'price' => $product['price'],
                'price_match_error' => $product['price_match_error'],
                'passed_price' => $product['passed_price'],
                'old_quantity' => $product['old_quantity'],
                'multiples' => $product['multiples'],
                'validation' => [
                    'error' => $product['validation']['error'],
                    'warning' => $warning,
                ],
            ];

            if (! $product['validation']['error']) {
                $upload[] = [
                    'user_id' => auth()->user()->id,
                    'customer_code' => auth()->user()->customer->code,
                    'product' => $product['product'],
                    'quantity' => $quantity,
                ];
            }
        }

        if (! OrderImport::store($upload)) {
            return back()->with('error', 'An unknown error occurred, please try uploading again.');
        }

        $product_lines['prices_passed'] = $prices_passed;
        $product_lines['errors'] = $errors;
        $product_lines['warnings'] = $warnings;

        return view('upload.validated', compact('product_lines'));
    }

    /**
     * When the user clicks "Add to basket" after validation has finished, copy the temp lines in the upload table to the users basket.
     *
     * @return Factory|RedirectResponse|View
     * @throws Exception
     */
    public function store()
    {
        if (Basket::store(OrderImport::show())) {
            return view('upload.completed');
        }

        return back()->with('error', 'An error occurred when adding your order to the basket, please try again');
    }
}
