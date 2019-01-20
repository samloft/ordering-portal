<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use App\Models\Products;
use Illuminate\Support\Facades\Input;

class ProductController extends Controller
{
    /**
     * @param string $category_one
     * @param string $category_two
     * @param string $category_three
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index($category_one = null, $category_two = null, $category_three = null)
    {
        $categories = [
            'level_1' => urldecode($category_one),
            'level_2' => urldecode($category_two),
            'level_3' => urldecode($category_three)
        ];

        if ($category_one) {
            $category_list = [];
            $products = Products::list($categories);

            if (count($products) == 0) {
                if ($categories['level_1'] <> '' && $categories['level_2'] == '') {
                    $category_list = Categories::showLevel1($categories['level_1']);
                } elseif ($categories['level_1'] <> '' && $categories['level_2'] <> '' && $categories['level_3'] == '') {
                    $category_list = Categories::showLevel2($categories['level_2']);
                }
            }

            return view('products.products', compact('categories', 'products', 'category_list'));
        }

        return view('products.index', compact('categories'));
    }

    /**
     * Product details page.
     *
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
     * Product search based on code, name, description.
     *
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
