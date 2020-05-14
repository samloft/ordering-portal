@if (count($links['banners']) > 0)
    <div class="flex flex-wrap">
        @foreach($links['banners'] as $banner)
            <div class="{{ $banner['style'] }} mb-3 {{ $banner['style'] === 'w-1/2' ? 'px-3' : '' }} flex justify-center">
                <a href="{{ $banner['file'] ? \Illuminate\Support\Facades\Storage::url(config('app.name').'/files/'.$banner['file']) : $banner['link'] }}">
                    <img class="shadow"
                         src="{{ \Illuminate\Support\Facades\Storage::url(config('app.name').'/banner/'.$banner['image']) }}"
                         alt="{{ $banner['name'] }}">
                </a>
            </div>
        @endforeach
    </div>
@endif

@if (count($links['categories']) > 0)
    <div class="flex flex-wrap">
        @foreach($links['categories'] as $category)
            <div class="w-1/2 md:w-1/4 lg:w-1/5 px-1 md:px-3 mb-5">
                <a href="{{ $category['link'] }}">
                    <img class="rounded shadow"
                         src="{{ \Illuminate\Support\Facades\Storage::url(config('app.name').'/category/'.$category['image']) }}"
                         alt="{{ $category['name'] }}"/>
                </a>
            </div>
        @endforeach
    </div>
@else
    <h3 class="text-center">No category images have been added.</h3>
@endif
