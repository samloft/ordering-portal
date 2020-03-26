@extends('layouts.master')

@section('title', 'Home links')
@section('sub-title', 'Advert & Category images + links')

@section('content')
    <div class="px-6 pt-4 pb-6 xl:px-10 xl:pt-6 xl:pb-8 bg-white rounded-lg shadow">
        <div class="flex">
            <div class="w-1/4 mr-6">
                <h5 class="font-medium text-lg mb-2">Category Links</h5>
                <p class="text-gray-600 text-sm">
                    Category links that will link users directly to the given category level(s)
                </p>
            </div>
            <div class="w-3/4">
                <home-links :topLevel="{{ json_encode($category_top_level, true) }}" :list="{{ json_encode($categories->jsonSerialize(), true) }}" :type="'Category Home Link'"></home-links>
            </div>
        </div>

        <hr class="mt-3 mb-3">

        <div class="flex">
            <div class="w-1/4 mr-6">
                <h5 class="font-medium text-lg mb-2">Advertisements</h5>
                <p class="text-gray-600 text-sm">
                    Advertisements are the images that are displayed down the left had side of the category home links on the home page.
                </p>
            </div>
            <div class="w-3/4">
                <home-links :list="{{ json_encode($adverts, true) }}" :topLevel="[]" :type="'Advertisement'"></home-links>
            </div>
        </div>
    </div>
@endsection
