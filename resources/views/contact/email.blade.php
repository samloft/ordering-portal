@component('mail::layout')
    @slot('header')
        @component('mail::header', ['url' => config('app.url')])
            {{ config('app.name') }} - Contact
        @endcomponent
    @endslot

New contact form submitted.

Name: {{ $message->name }}

Email: {{ $message->email }}

Customer: {{ auth()->user()->customer->name }} ({{ auth()->user()->customer->code }})


Message:

    {{ $message->message }}

    @isset($subcopy)
        @slot('subcopy')
            @component('mail::subcopy')
                {{ $subcopy }}
            @endcomponent
        @endslot
    @endisset

    @slot('footer')
        @component('mail::footer')
            © {{ date('Y') }} {{ ucfirst(config('app.name')) }}.
        @endcomponent
    @endslot
@endcomponent
