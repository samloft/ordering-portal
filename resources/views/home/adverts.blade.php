<div class="col-sm-3 home-sidebar">
    <div class="d-flex flex-wrap">
        @foreach($links['adverts'] as $advert)
            <div class="row">
                <div class="col">
                    <a href="{{ $advert->link }}" target="_blank">
                        <img class="img-fluid" src="{{ $advert->image }}" alt="{{ $advert->name }}">
                    </a>
                </div>
            </div>
        @endforeach
    </div>
</div>