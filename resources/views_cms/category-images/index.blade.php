@extends('layouts.master')

@section('title', 'Category Images')
@section('sub-title', 'Override automated images for categories')

@section('content')
    <div class="px-6 pt-4 pb-6 xl:px-10 xl:pt-6 xl:pb-8 bg-white rounded-lg shadow">
        <div class="flex">
            <div class="w-1/4 mr-6">
                <h5 class="font-medium text-lg mb-2">Category Images</h5>
                <p class="text-gray-600 text-sm">
                    Category images are automated based on product images that belong to that category. Here you can override that automation and set a specific image for a category.
                </p>
            </div>
            <div class="w-3/4">
                <category-images company="{{ config('app.name') }}" s3="{{ config('app.s3_url') }}" :top_categories="{{ json_encode($category_top_level, true) }}" :category_images="{{ json_encode($images, true) }}"></category-images>
            </div>
        </div>
    </div>
@endsection
