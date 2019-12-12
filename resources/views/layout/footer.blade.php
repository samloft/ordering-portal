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
                        <span class="font-semibold">{{ $company_details['line_1'] }}</span>
                        <span>{{ $company_details['line_2'] }}</span>
                        <span
                            class="block">{{ $company_details['line_3'] . ' ' . $company_details['line_4'] . ' ' . $company_details['postcode']}}</span>
                    </span>

                    <span class="block">
                        <span class="font-thin">{{ __('Telephone: ') }}</span><a
                            href="{{ 'TEL:'.$company_details['telephone'] }}"
                            class="hover:underline">{{ $company_details['telephone'] }}</a>
                        <span class="font-thin">{{ __('Email: ') }}</span>
                        <a href="{{ 'MAILTO:'.$company_details['email'] }}"
                           class="hover:underline">{{ $company_details['email'] }}</a>
                    </span>
                </div>
            </div>
            <div class="md:flex items-center py-4">

                @if(array_filter($company_details['social']))
                    <div class="text-grey text-center md:mr-8">
                        <span class="font-thin">{{ __('Social Media') }}</span>

                        <div class="flex justify-center mt-2 mb-2">

                            @foreach($company_details['social'] AS $name => $url)
                                @if ($url)
                                    <a href="{{ $url }}">
                                        <img class="h-8 mr-1 ml-1 hover:opacity-75" alt="{{ $name }}"
                                             src="{{ asset('images/'.config('app.name').'/'.$name.'.png') }}">
                                    </a>
                                @endif
                            @endforeach

                        </div>
                    </div>
                @endif

                @if(array_filter($company_details['apps']))
                    <div class="text-grey text-center md:ml-4">
                        <span class="font-thin">{{ __('Download Our App') }}</span>
                        <div class="flex justify-center mt-2 mb-2">

                            @foreach($company_details['apps'] AS $name => $url)
                                @if($url)
                                    <a href="{{ $url }}">
                                        <img class="mr-1 ml-1 hover:opacity-75" alt="{{ $name }}"
                                             src="{{ asset('images/'.config('app.name').'/'.$name.'.png') }}">
                                    </a>
                                @endif
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</footer>
