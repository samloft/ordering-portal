@component('mail::layout')

@slot('header')
    @component('mail::header', ['url' => config('app.url')])
        Welcome to {{ ucfirst(config('app.name')) }} Ordering Portal
    @endcomponent
@endslot

Dear {{ $user->name }},

Your online portal account has now been activated for {{ config('app.url') }}

@component('mail::button', ['url' => config('app.url') . '/password/reset/' . $token . '?email=' . $user->email])
    Create your password
@endcomponent

Please note, this link will expire in the next 60 minutes, after you will need to use "forgotten password" at {{ config('app.url') }}



@slot('subcopy')
    If you’re having trouble clicking the "Create your password" button, copy and paste the URL below into your web browser: {{ config('app.url') . '/password/reset/' . $token . '?email=' . $user->email }}
@endslot

@slot('footer')
    @component('mail::footer')
        © {{ date('Y') }} {{ ucfirst(config('app.name')) . ' Ordering Portal' }}.
    @endcomponent
@endslot
@endcomponent
