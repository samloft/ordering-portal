<?php

namespace App\Http\Controllers;

use App\Models\Products;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class UploadController extends Controller
{
    public function index()
    {
        return view('upload.index');
    }

    public function validation(Request $request)
    {
        $request->validate([
            'input_file' => 'required|mimes:xlsx,xls,csv,txt'
        ]);

        $order_lines = Excel::toArray(null, $request->file('input_file'));

        $order = [];
        $errors = 0;
        $warnings = 0;

        foreach ($order_lines[0] as $key => $value) {
            if ($value[0]) {
                $product = Products::show($value[0]);

                if (isset($value[1])) {
                    if (is_numeric($value[1])) {
                        $multiple = (int)$value[1] % $product->order_multiples != 0 ? false : true;

                        if ($multiple) {
                            $quantity = (int)$value[1];
                            $quantity_valid = true;
                            $quantity_message = null;
                        } else {
                            $quantity = (int)ceil($value[1] / $product->order_multiples) * $product->order_multiples;
                            $quantity_valid = true;
                            $quantity_message = 'Quantity not in multiples of ' . $product->order_multiples . '. Increased to ' . $quantity . ' <i class="fas fa-exclamation-triangle"></i>';
                        }
                    } else {
                        $quantity = $value[1];
                        $quantity_valid = false;
                        $quantity_message = 'Quantity is not valid <i class="fas fa-times-circle"></i>';
                    }
                } else {
                    $quantity = 'blank';
                    $quantity_valid = true;
                    $quantity_message = 'Quantity has not been set <i class="fas fa-times-circle"></i>';
                }

                if (!$product || !$quantity_valid) {
                    $validation = 'bg-danger';
                    $errors++;
                } else {
                    if ($quantity_message) {
                        $validation = 'bg-warning';
                        $warnings++;
                    } else {
                        $validation = '';
                    }
                }

                $order['products'][] = [
                    'validation' => $validation,
                    'product' => [
                        'code' => $value[0],
                        'valid' => $product ? true : false,
                        'message' => $product ? null : 'Product Not Found <i class="fas fa-times-circle"></i>'
                    ],
                    'quantity' => [
                        'amount' => $quantity,
                        'valid' => $quantity_valid,
                        'message' => $quantity_message
                    ]
                ];
            }
        }

        if (!$order) {
            return back()->with('error', 'No products found, please check your file is formatted correctly...');
        }

        $order['errors'] = $errors;
        $order['warnings'] = $warnings;

        return view('upload.validated', compact('order'));
    }
}
