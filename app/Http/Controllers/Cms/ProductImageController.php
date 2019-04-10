<?php

namespace App\Http\Controllers\Cms;

use App\Models\Prices;
use App\Models\Products;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use File;
use Storage;
use Illuminate\View\View;

class ProductImageController extends Controller
{
    /**
     * Display the product images page.
     *
     * @return Factory|View
     */
    public function index()
    {
        return view('cms.product-images.index');
    }

    /**
     * Return all products that appear on a price list with missing images.
     *
     * @return array
     */
    public function missingImages()
    {
        $product_list = Prices::productList();
        $missing_images = [];

        foreach ($product_list as $product) {
            $image = Products::checkImage(encodeUrl($product->product));

            if (!$image['found']) {
                $missing_images[] = [
                    'product' => $product->product,
                    'file_name' => str_replace('%2B', ' ', encodeUrl($product->product)) . '.png'
                ];
            }
        }

        return $missing_images;
    }

    /**
     * Upload product images.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $image = $request->file('file');
        $name = $image->getClientOriginalName();
        $extension = $image->getClientOriginalExtension();

        if ($extension != 'png') {
            return response()->json($name . ' must be a png', 400);
        }

        $upload = Storage::disk('public')->put('product_images/' . $name, File::get($image));

        if ($upload) {
            return response()->json('success', 200);
        }

        return response()->json('Failed to upload ' . $name, 400);
    }
}
