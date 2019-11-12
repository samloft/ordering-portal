@component('mail::layout')
    @slot('header')
        @component('mail::header', ['url' => config('app.url')])
            {{ config('app.name') }} - Contact
        @endcomponent
    @endslot

    New contact form submitted.

    Name: {{ $message->name }}
    Email: {{ $message->email }}

    Subject: {{ $message->subject }}
    Message: {{ $message->message }}

    @isset($subcopy)
        @slot('subcopy')
            @component('mail::subcopy')
                {{ $subcopy }}
            @endcomponent
        @endslot
    @endisset

    @slot('footer')
        @component('mail::footer')
            © {{ date('Y') }} {{ config('app.name') }}.
        @endcomponent
    @endslot
@endcomponent
