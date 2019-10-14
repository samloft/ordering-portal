<div class="card card-body">
    <div class="text-center">
        <img src="https://media1.tenor.com/images/f5b11c5564ee186d00a2b4ff6e027bd7/tenor.gif?itemid=7325938">
        <h1 class="mt-3">{{ __('404! Oh No! Oh Dear! Page not found.') }}</h1>
        <p>
            {{ __('It would seem you have navigated to a page that not longer or has ever existed.') }}
        </p>
        <a href="{{ route('home') }}">
            <button class="btn btn-primary">Return Home</button>
        </a>
    </div>
</div>
