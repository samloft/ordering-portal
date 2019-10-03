@if ($errors->any() || session('error'))
    <div class="alert alert-danger" role="alert">
        <div class="alert-body">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="icon">
                <circle cx="12" cy="12" r="10" class="primary"></circle>
                <path class="secondary"
                      d="M13.41 12l2.83 2.83a1 1 0 0 1-1.41 1.41L12 13.41l-2.83 2.83a1 1 0 1 1-1.41-1.41L10.59 12 7.76 9.17a1 1 0 0 1 1.41-1.41L12 10.59l2.83-2.83a1 1 0 0 1 1.41 1.41L13.41 12z"></path>
            </svg>
            <div>
                <p class="alert-title">Error!</p>
                <p class="alert-text">{!! $errors->first() ?: session('error') !!}</p>
            </div>
        </div>
    </div>
@endif

@if (session('status') || session('success'))
    <div class="alert alert-success" role="alert">
        <div class="alert-body">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="icon">
                <circle cx="12" cy="12" r="10" class="primary"></circle>
                <path class="secondary"
                      d="M10 14.59l6.3-6.3a1 1 0 0 1 1.4 1.42l-7 7a1 1 0 0 1-1.4 0l-3-3a1 1 0 0 1 1.4-1.42l2.3 2.3z"></path>
            </svg>
            <div>
                <p class="alert-title">Success!</p>
                <p class="alert-text">{!! session('status') ?: session('success') !!}</p>
            </div>
        </div>
    </div>
@endif
