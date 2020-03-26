<div class="w-1/4 mr-5">
    @foreach($adverts as $advert)
        <div class="mb-5">
            <a href="{{ $advert->link }}" target="_blank">
                <img class="rounded shadow"
                     src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url('storage/images/advert/'.$advert->image) }}">
            </a>
        </div>
    @endforeach
</div>
