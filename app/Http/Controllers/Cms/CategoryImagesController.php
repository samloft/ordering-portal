<?php

namespace App\Http\Controllers\Cms;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\CategoryImage;
use Illuminate\Http\Request;

class CategoryImagesController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $images = CategoryImage::orderBy('level_1')->orderBy('level_2')->orderBy('level_3')->get();
        $category_top_level = Category::show(1);

        return view('category-images.index', compact('images', 'category_top_level'));
    }
}
