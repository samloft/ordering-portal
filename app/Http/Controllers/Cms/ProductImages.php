<?php

namespace App\Http\Controllers\Cms;

use App\Models\Prices;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductImages extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $product_list = Prices::productList();
        $products = [];

        foreach ($product_list as $product) {
            $products[] = trim($product->product);
        }

        return view('cms.product-images.index', compact('products'));
    }
}
