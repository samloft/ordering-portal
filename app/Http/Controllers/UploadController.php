<?php

namespace App\Http\Controllers;

use App\Models\Basket;
use App\Models\GlobalSettings;
use App\Models\OrderImport;
use App\Models\Product;
use Illuminate\Contracts\View\Factory as FactoryAlias;
use Illuminate\Http\RedirectResponse as RedirectResponseAlias;
use Illuminate\View\View as ViewAlias;

class UploadController extends Controller
{
    /**
     * Display the CSV upload page.
     *
     * @return FactoryAlias|ViewAlias
     */
    public function index()
    {
        $config = GlobalSettings::uploadConfig();

        return view('upload.index', compact('config'));
    }

    /**
     * Take a CSV file and validate each line, validating products and qty and merging duplicated products. Then looping over the new array
     * and check the merged lines for order multiple quantity and increasing as needed.
     *
     * @return FactoryAlias|RedirectResponseAlias|ViewAlias
     */
    public function validation()
    {
        OrderImport::clearDown();

        request()->validate([
            'csv_file' => 'required|mimes:csv,txt',
        ]);

        $upload = [];
        $tolerance = request('tolerance');
        $packs = request('packs');

        $order = $this->readCSV($tolerance, $packs);

        if (! isset($order)) {
            return back()->with('error', 'No products found, please check your file is formatted correctly...');
        }

        $merged = $this->mergeProductLines($order['lines']);

        $product_lines['lines'] = [];

        foreach ($merged as $product) {
            if ($product['quantity'] % $product['multiples'] !== 0) {
                $quantity = (int) ceil((int) $product['quantity'] / $product['multiples']) * $product['multiples'];
                $warning = 'Quantity not in multiples of '.$product['multiples'].'. Increased from '.$product['quantity'].' to '.$quantity;
                $order['stats']['warnings']++;
            } else {
                $quantity = $product['quantity'];
                $warning = null;
            }

            $product_lines['lines'][] = [
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

        if (! OrderImport::insert($upload)) {
            return back()->with('error', 'An unknown error occurred, please try uploading again.');
        }

        $product_lines['prices_passed'] = $order['stats']['price_passed'];
        $product_lines['errors'] = $order['stats']['errors'];
        $product_lines['warnings'] = $order['stats']['warnings'];

        return view('upload.validated', compact('product_lines'));
    }

    /**
     * When the user clicks "Add to basket" after validation has finished, copy the temp lines in the upload table to the users basket.
     *
     * @return FactoryAlias|RedirectResponseAlias|ViewAlias
     */
    public function store()
    {
        if (Basket::store(OrderImport::show())) {
            return view('upload.completed');
        }

        return back()->with('error', 'An error occurred when adding your order to the basket, please try again');
    }

    /**
     * @param $tolerance
     * @param $packs
     *
     * @return array
     */
    public function readCSV($tolerance, $packs): array
    {
        $errors = 0;
        $order = [];
        $prices_passed = false;

        $config = GlobalSettings::uploadConfig();

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
                    $price_match = false;
                } elseif ($product_price && $config['prices']) {
                    $prices_passed = true;

                    if ($tolerance) {
                        if ($product_price >= ($product->prices->price * 2)) {
                            $price_match = abs(number_format($product_price, 4) - number_format(discount($product->prices->price) * $product_qty, 4)) > $tolerance;
                        } else {
                            $price_match = abs(number_format($product_price, 4) - number_format(discount($product->prices->price), 4)) > $tolerance;
                        }
                    } else {
                        $price_match = (number_format($product_price, 4) !== number_format(discount($product->prices->price), 4));
                    }
                } else {
                    $price_match = false;
                }

                if ($packs) {
                    $pack_qty = ($product_qty / $product->packaging);

                    if ($pack_qty >= 1) {
                        $product_qty /= $product->packaging;
                    }
                }

                $order['lines'][] = [
                    'product' => $product_code,
                    'quantity' => $product_qty,
                    'old_quantity' => $product_qty,
                    'passed_price' => $product_price,
                    'price' => $product ? discount($product->prices->price) : null,
                    'price_match_error' => $price_match,
                    'multiples' => $product->order_multiples ?? 1,
                    'validation' => [
                        'error' => $error_message,
                        'warning' => $warning_message,
                    ],
                ];
            }
        }

        $order['stats'] = [
            'errors' => $errors,
            'warnings' => 0,
            'price_passed' => $prices_passed,
        ];

        return $order;
    }

    /**
     * Merge all duplicate product lines and increment the quantities.
     *
     * @param $lines
     *
     * @return array
     */
    public function mergeProductLines($lines): array
    {
        $merged = [];

        foreach ($lines as $product) {
            $key = $product['product'];
            if (! array_key_exists($key, $merged)) {
                $merged[$key] = $product;
            } else {
                $merged[$key]['quantity'] += (int) $product['quantity'];
                $merged[$key]['old_quantity'] += (int) $product['quantity'];
            }
        }

        return $merged;
    }
}
