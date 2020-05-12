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

        $current_level = 0;

        foreach ($categories as $level) {
            if ($level) {
                $current_level++;
            }
        }

        if ($categories['level_1'] !== null) {
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
        $previous_categories = str_replace(url('/'), '', url()->previous());

        if (isset($previous_categories[0]) === 'products') {
            $category_array = array_values(array_filter(explode('/', $previous_categories)));
        } else {
            $category_array = [];
        }

        $product = Product::show(decodeUrl($product_code));

        $categories = [
            'level_1' => isset($category_array[1]) ? decodeUrl($category_array[1]) : '',
            'level_2' => isset($category_array[2]) ? decodeUrl($category_array[2]) : '',
            'level_3' => isset($category_array[3]) ? decodeUrl($category_array[3]) : '',
            'level_4' => isset($category_array[4]) ? decodeUrl($category_array[4]) : '',
            'level_5' => isset($category_array[5]) ? decodeUrl($category_array[5]) : '',
        ];

        if (isset($categories['level_1']) && strpos($categories['level_1'], 'search') === 0) {
            $categories = [
                'level_1' => 'search',
                'query' => substr(decodeUrl($categories['level_1']), 13),
            ];
        }

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
