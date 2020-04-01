<?php

namespace App\Http\Controllers\Cms;

use App\Http\Controllers\Controller;
use App\Models\Price;
use App\Models\Product;
use File;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Storage;

class ProductImageController extends Controller
{
    /**
     * Display the product images page.
     *
     * @return Factory|View
     */
    public function index()
    {
        return view('product-images.index');
    }

    /**
     * Return all products that appear on a price list with missing images.
     *
     * @return array
     */
    public function missingImages(): array
    {
        $product_list = Price::products();
        $missing_images = [];

        foreach ($product_list as $product) {
            $image = Product::checkImage(encodeUrl($product->product));

            if (! $image['found']) {
                $missing_images[] = [
                    'product' => $product->product,
                    'file_name' => str_replace('%2B', ' ', encodeUrl($product->product)).'.png',
                ];
            }
        }

        return $missing_images;
    }

    /**
     * Upload product images.
     *
     * @return JsonResponse
     *
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function store(): JsonResponse
    {
        $image = request()->file('file');

        $name = $image->getClientOriginalName();

        $upload = Storage::disk('s3')->put($name, File::get($image));

        if ($upload) {
            return response()->json('success');
        }

        return response()->json('Failed to upload '.$name, 400);
    }
}
