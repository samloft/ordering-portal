<?php

namespace App\Http\Controllers;

use App\Models\Prices;
use App\models\ProductSpec;
use Illuminate\Http\Request;

class ProductDataController extends Controller
{
    public function index()
    {
        $prices = Prices::productPrices();
        $products = [];

        foreach ($prices as $price) {
            $products[] = [
                'product' => $price->product,
                'description' => $price->description,
                'trade_price' => $price->trade_price,
                'net_price' => $price->price,
            ];
        }


    }
}
