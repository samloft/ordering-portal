<?php

namespace App\Http\Controllers;

use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class ProductController extends Controller
{
    /**
     * @param string $category_one
     * @param string $category_two
     * @param string $category_three
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index($category_one = '', $category_two = '', $category_three = '')
    {
        $categories = [
            'level_1' => urldecode($category_one),
            'level_2' => urldecode($category_two),
            'level_3' => urldecode($category_three)
        ];

        if ($category_one) {
            $products = Products::list($categories);

            return view('products.products', compact('categories', 'products'));
        }

        return view('products.index', compact('categories'));
    }

    /**
     * @param $product_code
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($product_code)
    {
        $product_code = urldecode($product_code);
        $product = Products::show($product_code);

        $categories = [
            'level_1' => isset($product->categories) ? $product->categories->cat1_level1 : '',
            'level_2' => isset($product->categories) ? $product->categories->cat1_level2 : '',
            'level_3' => isset($product->categories) ? $product->categories->cat1_level3 : ''
        ];

        return view('products.show', compact('categories', 'product'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function search()
    {
        $search_term = Input::get('query');
        $products = Products::search($search_term);

        $categories = ['level_1' => 'search', 'level_2' => null, 'level_3' => null, 'query' => $search_term];

        return view('products.products', compact('products', 'categories'));
    }
}
