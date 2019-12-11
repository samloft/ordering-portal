<footer>
    <div class="container mx-auto px-4">
        <div class="md:flex justify-between text-sm">
            <div class="text-center md:text-left py-3 md:py-4 border-b md:border-b-0 text-base">
                <a href="{{ route('contact') }}" class="no-underline text-grey-dark mr-4 hover:underline">
                    {{ __('Contact Us') }}
                </a>
                <a href="{{ route('support.accessibility') }}" class="no-underline text-grey-dark mr-4 hover:underline">
                    {{ __('Accessibility Policy') }}
                </a>
                <a href="{{ route('support.data') }}" class="no-underline text-grey-dark mr-4 hover:underline">
                    {{ __('Data Protection') }}
                </a>
                <a href="{{ route('support.terms') }}" class="no-underline text-grey-dark mr-4 hover:underline">
                    {{ __('Terms & Conditions') }}
                </a>

                <div class="address text-xs mt-3">
                    <span class="block font-thin">
                        <span class="font-semibold">Scolmore International Limited</span>
                        <span>Scolmore Park, Landsberg</span>
                        <span class="block">Lichfield Road Ind. Est. Tamworth B79 7XB.</span>
                    </span>

                    <span class="block">
                        <span class="font-thin">Telephone:</span> <a href="TEL:01827 63454" class="hover:underline">01827 63454</a>
                        <span class="font-thin">Email:</span>
                        <a href="MAILTO:sales@scolmore.com" class="hover:underline">sales@scolmore.com</a>
                    </span>
                </div>
            </div>
            <div class="md:flex items-center py-4">
                <div class="text-grey text-center md:mr-8">
                    <span class="font-thin">{{ __('Social Media') }}</span>
                    <div class="flex justify-center mt-2 mb-2">
                        @if(env('SOCIAL_FACEBOOK'))
                            <a href="{{ env('SOCIAL_FACEBOOK') }}">
                                <img class="h-8 mr-1 ml-1 hover:opacity-75" alt="facebook"
                                     src="https://scolmoreonline.com/assets/images/scolmore/facebook.png">
                            </a>
                        @endif

                        @if(env('SOCIAL_TWITTER'))
                            <a href="{{ env('SOCIAL_TWITTER') }}">
                                <img class="h-8 mr-1 ml-1 hover:opacity-75" alt="twitter"
                                     src="https://scolmoreonline.com/assets/images/scolmore/twitter.png">
                            </a>
                        @endif

                        @if(env('SOCIAL_LINKEDIN'))
                            <a href="{{ env('SOCIAL_LINKEDIN') }}">
                                <img class="h-8 mr-1 ml-1 hover:opacity-75" alt="linkedin"
                                     src="https://scolmoreonline.com/assets/images/scolmore/linkedin.png">
                            </a>
                        @endif

                        @if(env('SOCIAL_INSTAGRAM'))
                            <a href="{{ env('SOCIAL_INSTAGRAM') }}">
                                <img class="h-8 mr-1 ml-1 hover:opacity-75" alt="instagram"
                                     src="https://scolmoreonline.com/assets/images/scolmore/instagram.png">
                            </a>
                        @endif

                        @if(env('SOCIAL_YOUTUBE'))
                            <a href="{{ env('SOCIAL_YOUTUBE') }}">
                                <img class="h-8 mr-1 ml-1 hover:opacity-75" alt="youtube"
                                     src="https://scolmoreonline.com/assets/images/scolmore/youtube.png">
                            </a>
                        @endif
                    </div>
                </div>

                @if(env('APP_APPLE') || env('APP_ANDROID'))
                    <div class="text-grey text-center md:ml-4">
                        <span class="font-thin">{{ __('Download Our App') }}</span>
                        <div class="flex justify-center mt-2 mb-2">
                            @if(env('APP_APPLE'))
                                <a href="{{ env('APP_APPLE') }}">
                                    <img class="mr-1 ml-1 hover:opacity-75" alt="app store"
                                         src="https://scolmoreonline.com/assets/images/appstore.png">
                                </a>
                            @endif

                            @if(env('APP_ANDROID'))
                                <a href="{{ env('APP_ANDROID') }}">
                                    <img class="mr-1 ml-1 hover:opacity-75" alt="play store"
                                         src="https://scolmoreonline.com/assets/images/googleplay.png">
                                </a>
                            @endif
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</footer>
