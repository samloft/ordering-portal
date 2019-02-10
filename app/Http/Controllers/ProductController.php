<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use App\Models\ExpectedStock;
use App\Models\Products;
use Illuminate\Support\Facades\Input;
use PhpParser\Node\Expr\Cast\Object_;

class ProductController extends Controller
{
    /**
     * Products index, if categories are given, gets the sub categories.
     * If no sub categories for that level, display the products.
     *
     * @param string $category_one
     * @param string $category_two
     * @param string $category_three
     * @param string $category_four
     * @param string $category_five
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index($category_one = null, $category_two = null, $category_three = null, $category_four = null, $category_five = null)
    {
        $category_list = Categories::list();
        $sub_category_list = [];

        $categories = [
            'level_1' => urldecode($category_one),
            'level_2' => urldecode($category_two),
            'level_3' => urldecode($category_three),
            'level_4' => urldecode($category_four),
            'level_5' => urldecode($category_five),
        ];

        $current_level = 0;

        foreach ($categories as $level) {
            if ($level != null) {
                $current_level++;
            }
        }

        if ($categories['level_1'] <> null) {
            $sub_category_list = Categories::subCategories($current_level, $categories['level_1'], $categories['level_' . $current_level]);

            if (count($sub_category_list) == 0) {
                $products = Products::list($categories);

                return view('products.products', compact('categories', 'category_list', 'products'));
            }
        }

        return view('products.index', compact('categories', 'category_list', 'sub_category_list'));
    }

    /**
     * Product details page.
     *
     * @param $product_code
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($product_code)
    {
        $previous_categories = str_replace(url('/'), '', url()->previous());
        $category_array = array_values(array_filter(explode('/', $previous_categories)));

        $category_list = Categories::list();
        $product_code = trim(urldecode($product_code));
        $product = Products::show($product_code);
        $expected_stock = ExpectedStock::show($product_code);

        $categories = [
            'level_1' => isset($category_array[1]) ? trim(urldecode($category_array[1])) : '',
            'level_2' => isset($category_array[2]) ? trim(urldecode($category_array[2])) : '',
            'level_3' => isset($category_array[3]) ? trim(urldecode($category_array[3])) : ''
        ];

        if (isset($category_array[1]) && substr($category_array[1], 0, 6) == 'search') {
            $categories = [
                'level_1' => 'search',
                'level_2' => null,
                'level_3' => null,
                'query' => substr($category_array[1], 13)
            ];
        }

        return view('products.show', compact('categories', 'category_list', 'product', 'expected_stock'));
    }

    /**
     * Product search based on code, name, description.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function search()
    {
        $category_list = Categories::list();
        $search_term = Input::get('query');
        $products = Products::search($search_term);

        $categories = ['level_1' => 'search', 'level_2' => null, 'level_3' => null, 'query' => $search_term];

        return view('products.products', compact('products', 'categories', 'category_list'));
    }
}
