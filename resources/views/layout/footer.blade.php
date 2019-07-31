<footer>
    <div class="container">
        <div class="row">
            <div class="col-lg-7">
                <div class="footer-links">
                    <a href="{{ route('support.contact') }}">{{ __('Contact Us') }}</a>
                    @if (Auth::user())
                        | <a href="{{ route('support.accessibility') }}">{{ __('Accessibility Policy') }}</a>
                        | <a href="{{ route('support.data') }}">{{ __('Data Protection') }}</a>
                        | <a href="{{ route('support.terms') }}">{{ __('Terms And Conditions') }}</a>
                    @endif
                </div>

                <div class="footer-address">
                    <strong>{{ env('ADDRESS_LINE_1') }}</strong> {{ env('ADDRESS_LINE_2') }}
                    , {{ env('ADDRESS_LINE_3') }}, {{ env('ADDRESS_LINE_4') }},
                    {{ env('ADDRESS_LINE_5') }} {{ env('ADDRESS_POSTCODE') }}.<br/>
                    {{ env('ADDRESS_TELEPHONE') ? 'Tel: ' . env('ADDRESS_TELEPHONE') : '' }} {{ env('ADDRESS_FAX') ? '| Fax: ' . env('ADDRESS_FAX') : '' }}
                    {!! env('ADDRESS_EMAIL') ? '| Email: <a href="MAILTO:' . env('ADDRESS_EMAIL') . '">' . env('ADDRESS_EMAIL') . '</a>' : '' !!}
                </div>
            </div>
            <div class="col">
                <div class="row">
                    <div class="col footer-links">
                        Social
                    </div>
                    @if (env('APP_ANDROID') || env('APP_APPLE'))
                        <div class="col footer-links">
                            Download our app
                            <div class="d-inline-block">
                                @if (env('APP_APPLE'))
                                    <a href="{{ env('APP_APPLE') }}">
                                        <img src="{{ asset('images/appstore.png') }}" alt="Apple APP">
                                    </a>
                                @endif

                                @if (env('APP_ANDROID'))
                                    <a href="{{ env('APP_ANDROID') }}">
                                        <img src="{{ asset('images/googleplay.png') }}" alt="Android APP">
                                    </a>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</footer>
