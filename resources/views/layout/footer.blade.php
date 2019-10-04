<footer>
    <div class="container mx-auto px-4">
        <div class="md:flex justify-between text-sm">
            <div class="text-center md:text-left py-3 md:py-4 border-b md:border-b-0 text-base">
                <a href="#" class="no-underline text-grey-dark mr-4 hover:underline">{{ __('Contact Us') }}</a>
                <a href="#" class="no-underline text-grey-dark mr-4 hover:underline">{{ __('Accessibility Policy') }}</a>
                <a href="#" class="no-underline text-grey-dark mr-4 hover:underline">{{ __('Data Protection') }}</a>
                <a href="#" class="no-underline text-grey-dark mr-4 hover:underline">{{ __('Terms & Conditions') }}</a>

                <div class="address text-xs mt-3">
                    <span class="block"><span class="font-semibold">Scolmore International Limited</span> <span
                            class="font-thin">Scolmore Park, Landsberg<span class="block">Lichfield Road Ind. Est. Tamworth B79 7XB.</span></span></span>
                    <span class="block"><span class="font-thin">Telephone:</span> 01827 63454 <span class="font-thin">Email:</span> sales@scolmore.com </span>
                </div>
            </div>
            <div class="md:flex items-center py-4">
                <div class="text-grey text-center md:mr-8">
                    <span class="font-thin">{{ __('Social Media') }}</span>
                    <div class="flex justify-center mt-2 mb-2">
                        <a href="#">
                            <img class="h-8 mr-1 ml-1 hover:opacity-75" alt="facebook"
                                 src="https://scolmoreonline.com/assets/images/scolmore/facebook.png">
                        </a>

                        <a href="#">
                            <img class="h-8 mr-1 ml-1 hover:opacity-75" alt="twitter"
                                 src="https://scolmoreonline.com/assets/images/scolmore/twitter.png">
                        </a>

                        <a href="#">
                            <img class="h-8 mr-1 ml-1 hover:opacity-75" alt="linkedin"
                                 src="https://scolmoreonline.com/assets/images/scolmore/linkedin.png">
                        </a>

                        <a href="#">
                            <img class="h-8 mr-1 ml-1 hover:opacity-75" alt="instagram"
                                 src="https://scolmoreonline.com/assets/images/scolmore/instagram.png">
                        </a>

                        <a href="#">
                            <img class="h-8 mr-1 ml-1 hover:opacity-75" alt="youtube"
                                 src="https://scolmoreonline.com/assets/images/scolmore/youtube.png">
                        </a>
                    </div>
                </div>

                <div class="text-grey text-center md:ml-4">
                    <span class="font-thin">{{ __('Download Our App') }}</span>
                    <div class="flex justify-center mt-2 mb-2">
                        <a href="#">
                            <img class="mr-1 ml-1 hover:opacity-75" alt="app store"
                                 src="https://scolmoreonline.com/assets/images/appstore.png">
                        </a>

                        <a href="#">
                            <img class="mr-1 ml-1 hover:opacity-75" alt="play store"
                                 src="https://scolmoreonline.com/assets/images/googleplay.png">
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>

{{--<footer>--}}
{{--    <div class="container">--}}
{{--        <div class="row">--}}
{{--            <div class="col-lg-7">--}}
{{--                <div class="footer-links">--}}
{{--                    <a href="{{ route('support.contact') }}">{{ __('Contact Us') }}</a>--}}
{{--                    @if (Auth::user())--}}
{{--                        | <a href="{{ route('support.accessibility') }}">{{ __('Accessibility Policy') }}</a>--}}
{{--                        | <a href="{{ route('support.data') }}">{{ __('Data Protection') }}</a>--}}
{{--                        | <a href="{{ route('support.terms') }}">{{ __('Terms And Conditions') }}</a>--}}
{{--                    @endif--}}
{{--                </div>--}}

{{--                <div class="footer-address">--}}
{{--                    <strong>{{ env('ADDRESS_LINE_1') }}</strong> {{ env('ADDRESS_LINE_2') }}--}}
{{--                    , {{ env('ADDRESS_LINE_3') }}, {{ env('ADDRESS_LINE_4') }},--}}
{{--                    {{ env('ADDRESS_LINE_5') }} {{ env('ADDRESS_POSTCODE') }}.<br/>--}}
{{--                    {{ env('ADDRESS_TELEPHONE') ? 'Tel: ' . env('ADDRESS_TELEPHONE') : '' }} {{ env('ADDRESS_FAX') ? '| Fax: ' . env('ADDRESS_FAX') : '' }}--}}
{{--                    {!! env('ADDRESS_EMAIL') ? '| Email: <a href="MAILTO:' . env('ADDRESS_EMAIL') . '">' . env('ADDRESS_EMAIL') . '</a>' : '' !!}--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            <div class="col">--}}
{{--                <div class="row">--}}
{{--                    <div class="col footer-links">--}}
{{--                        {{ __('Social') }}--}}
{{--                    </div>--}}
{{--                    @if (env('APP_ANDROID') || env('APP_APPLE'))--}}
{{--                        <div class="col footer-links">--}}
{{--                            Download our app--}}
{{--                            <div class="d-inline-block">--}}
{{--                                @if (env('APP_APPLE'))--}}
{{--                                    <a href="{{ env('APP_APPLE') }}">--}}
{{--                                        <img src="{{ asset('images/appstore.png') }}" alt="Apple APP">--}}
{{--                                    </a>--}}
{{--                                @endif--}}

{{--                                @if (env('APP_ANDROID'))--}}
{{--                                    <a href="{{ env('APP_ANDROID') }}">--}}
{{--                                        <img src="{{ asset('images/googleplay.png') }}" alt="Android APP">--}}
{{--                                    </a>--}}
{{--                                @endif--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    @endif--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</footer>--}}
