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
                    <strong>Scolmore International Limited</strong> Scolmore Park, Landsberg, Lichfield Road Ind. Est.,
                    Tamworth B79 7XB.<br/>
                    Tel: 01827 63454 | Fax: 01827 63362 | Email: <a
                            href="MAILTO:sales@scolmore.com">sales@scolmore.com</a>
                </div>
            </div>
            <div class="col">
                <div class="row">
                    <div class="col footer-links">
                        Social
                    </div>
                    <div class="col footer-links">
                        Download our app
                        <div class="d-inline-block">
                            <img src="{{ asset('images/appstore.png') }}">
                            <img src="{{ asset('images/googleplay.png') }}">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
