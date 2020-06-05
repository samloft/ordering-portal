<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\HomeLink;
use App\Models\Product;
use Illuminate\Contracts\View\Factory;
use Illuminate\View\View;

class ProductController extends Controller
{
    /**
     * Product index, if categories are given, gets the sub categories.
     * If no sub categories for that level, display the products.
     *
     * @return Factory|View
     */
    public function index()
    {
        $categories = [
            'level_1' => decodeUrl(request('cat1')),
            'level_2' => decodeUrl(request('cat2')),
            'level_3' => decodeUrl(request('cat3')),
            'level_4' => null,
            'level_5' => null,
        ];

        if ($categories['level_1'] !== null) {
            $current_level = count(array_filter($categories));

            $products = Product::list($categories);
            $sub_category_list['list'] = Category::subCategories($current_level, $categories['level_1'], $categories['level_'.$current_level]);
            $sub_category_list['current'] = $categories;

            return view('products.products', compact('categories', 'sub_category_list', 'products'));
        }

        $links['categories'] = HomeLink::categories();

        return view('products.index', compact('links', 'categories'));
    }

    /**
     * Product details page.
     *
     * @param $product_code
     *
     * @return Factory|View
     */
    public function show($product_code)
    {
        $product = Product::show(decodeUrl($product_code));

        $categories = [
            'level_1' => $product && $product->categories ? decodeUrl($product->categories->level_1) : '',
            'level_2' => $product && $product->categories ? decodeUrl($product->categories->level_2) : '',
            'level_3' => $product && $product->categories ? decodeUrl($product->categories->level_3) : '',
            'level_4' => $product && $product->categories ? decodeUrl($product->categories->level_4) : '',
            'level_5' => $product && $product->categories ? decodeUrl($product->categories->level_5) : '',
        ];

        return view('products.show', compact('categories', 'product'));
    }

    /**
     * Product search based on code, name, description.
     *
     * @return Factory|View
     */
    public function search()
    {
        $search_term = urldecode(request('query'));

        $products = Product::search($search_term);
        $sub_category_list = [];

        $categories = [
            'level_1' => 'search',
            'query' => $search_term,
        ];

        return view('products.products', compact('products', 'categories', 'sub_category_list'));
    }
}
