@if(count($links['categories']) > 0)
    <div class="d-flex flex-wrap">
        @foreach($links['categories'] as $category)
            <div class="w-20">
                <a href="{{ $category->link }}">
                    <img class="img-fluid" src="{{ $category->image }}" alt="{{ $category->name }}">
                </a>
            </div>
        @endforeach
    </div>
@else
    <h3 class="text-center">{{ __('No category images have been added.') }}</h3>
@endif