<?php

namespace App\Http\Controllers\Cms;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\CategoryImage;
use File;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;
use Storage;

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

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(): JsonResponse
    {
        request()->validate([
            'level_1' => 'required',
            'file' => 'required',
        ]);

        $image = request()->file('file');

        $name = $image->getClientOriginalName();

        $category_image = new CategoryImage;

        $category_image->level_1 = request('level_1');
        $category_image->level_2 = request('level_2');
        $category_image->level_3 = request('level_3');
        $category_image->image = $name;

        Storage::disk('public')->put('category_images/'.$name, File::get($image));

        $category_image->save();

        Cache::forget('cat-image:'.request('level_1'));
        Cache::forget('cat-image:'.request('level_2'));
        Cache::forget('cat-image:'.request('level_3'));

        return response()->json([
            'created' => true,
        ]);
    }

    /**
     * @param $id
     *
     * @return bool|null
     *
     * @throws \Exception
     */
    public function destroy($id): ?bool
    {
        $category_image = CategoryImage::findOrFail($id);

        Storage::disk('public')->delete('category_images/'.$category_image->image);

        $deleted = $category_image->delete();

        Cache::forget('cat-image:'.$category_image->level_1);
        Cache::forget('cat-image:'.$category_image->level_2);
        Cache::forget('cat-image:'.$category_image->level_3);

        return $deleted;
    }
}
