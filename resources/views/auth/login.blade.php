@extends('layout.master')

@section('page.title', 'Login')

@section('content')
    <iframe id="iframe-content" class="external-content" scrolling="no" src="{{ route('login.content') }}" onload="resizeIframe(this)"></iframe>

    {{--{!! \App\Models\Pages::show('login')->contents !!}--}}
@endsection

@section('scripts')
    <script>
        function resizeIframe(iframe) {
            $(iframe).css('height', iframe.contentWindow.document.body.scrollHeight + 'px');
        }
    </script>
@endsection
