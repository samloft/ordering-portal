<footer>
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="footer-links">
                    <a href="{{ route('support.contact') }}">{{ __('Contact Us') }}</a>
                    @if (Auth::user())
                        | <a href="">{{ __('Accessibility Policy') }}</a>
                        | <a href="">{{ __('Data Protection') }}</a>
                        | <a href="">{{ __('Terms And Conditions') }}</a>
                    @endif
                </div>

                <div class="footer-address">
                    <strong>Scolmore International Limited</strong> Scolmore Park, Landsberg, Lichfield Road Ind. Est., Tamworth B79 7XB.<br/>
                    Tel: 01827 63454 | Fax: 01827 63362 | Email: <a href="MAILTO:sales@scolmore.com">sales@scolmore.com</a>
                </div>
            </div>
            <div class="col">
                Social
            </div>
            <div class="col">
                App Stuff
            </div>
        </div>
    </div>
</footer>