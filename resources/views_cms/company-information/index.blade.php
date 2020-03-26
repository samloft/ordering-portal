@extends('layouts.master')

@section('title', 'Company Information')
@section('sub-title', 'Update information about the company')

@section('content')
    <div class="px-6 pt-4 pb-6 xl:px-10 xl:pt-6 xl:pb-8 bg-white rounded-lg shadow">
        <form action="{{ route('cms.company-information.store') }}" method="post">

            @include('layout.alerts')

            <div class="flex">
                <div class="w-1/4 mr-6">
                    <h5 class="font-medium text-lg mb-2">Address Details</h5>
                    <p class="text-gray-600 text-sm">
                        Company address details to be displayed on the sites footer & PDF documents.
                    </p>
                </div>
                <div class="w-3/4">
                    <div class="mb-4">
                        <label class="text-sm font-medium">Company Name</label>
                        <input class="bg-gray-100 mt-1" value="{{ $company_details['line_1'] }}"
                               name="line_1"
                               placeholder="Company Name">
                    </div>

                    <div class="mb-4">
                        <label class="text-sm font-medium">Street Address</label>
                        <input class="bg-gray-100 mt-1" value="{{ $company_details['line_2'] }}"
                               name="line_2"
                               placeholder="Street Address">
                    </div>

                    <div class="mb-4">
                        <label class="text-sm font-medium">Street Address 2</label>
                        <input class="bg-gray-100 mt-1" value="{{ $company_details['line_3'] }}"
                               name="line_3"
                               placeholder="Street Address 2">
                    </div>

                    <div class="mb-4">
                        <label class="text-sm font-medium">Street Address 3</label>
                        <input class="bg-gray-100 mt-1" value="{{ $company_details['line_4'] }}"
                               name="line_4"
                               placeholder="Street Address 3">
                    </div>

                    <div class="mb-4">
                        <label class="text-sm font-medium">City</label>
                        <input class="bg-gray-100 mt-1" value="{{ $company_details['line_5'] }}"
                               name="line_5"
                               placeholder="City">
                    </div>

                    <div class="mb-4">
                        <label class="text-sm font-medium">Postcode</label>
                        <input class="bg-gray-100 mt-1" value="{{ $company_details['postcode'] }}"
                               name="postcode"
                               placeholder="Postcode">
                    </div>

                    <div class="mb-4">
                        <label class="text-sm font-medium">Telephone</label>
                        <input class="bg-gray-100 mt-1" value="{{ $company_details['telephone'] }}"
                               name="telephone"
                               placeholder="Telephone">
                    </div>

                    <div class="mb-4">
                        <label class="text-sm font-medium">Email</label>
                        <input type="email" class="bg-gray-100 mt-1" value="{{ $company_details['email'] }}"
                               name="email"
                               placeholder="Email">
                    </div>
                </div>
            </div>

            <hr class="border border-gray-300 my-5">

            <div class="flex">
                <div class="w-1/4 mr-6">
                    <h5 class="font-medium text-lg mb-2">Social Media</h5>
                    <p class="text-gray-600 text-sm">
                        Links pointing to various social media websites, leaving these blank will remove the icons.
                    </p>
                </div>
                <div class="w-3/4">
                    <div class="mb-4">
                        <label class="text-sm font-medium">Facebook</label>
                        <input class="bg-gray-100 mt-1" value="{{ $company_details['social']['facebook'] }}"
                               name="facebook"
                               placeholder="Facebook URL">
                    </div>

                    <div class="mb-4">
                        <label class="text-sm font-medium">Twitter</label>
                        <input class="bg-gray-100 mt-1" value="{{ $company_details['social']['twitter'] }}"
                               name="twitter"
                               placeholder="Twitter URL">
                    </div>

                    <div class="mb-4">
                        <label class="text-sm font-medium">LinkedIn</label>
                        <input class="bg-gray-100 mt-1" value="{{ $company_details['social']['linkedin'] }}"
                               name="linkedin"
                               placeholder="LinkedIn URL">
                    </div>

                    <div class="mb-4">
                        <label class="text-sm font-medium">Instagram</label>
                        <input class="bg-gray-100 mt-1" value="{{ $company_details['social']['instagram'] }}"
                               name="instagram"
                               placeholder="Instagram URL">
                    </div>

                    <div class="mb-4">
                        <label class="text-sm font-medium">Youtube</label>
                        <input class="bg-gray-100 mt-1" value="{{ $company_details['social']['youtube'] }}"
                               name="youtube"
                               placeholder="Youtube URL">
                    </div>
                </div>
            </div>

            <hr class="border border-gray-300 my-5">

            <div class="flex">
                <div class="w-1/4 mr-6">
                    <h5 class="font-medium text-lg mb-2">Applications</h5>
                    <p class="text-gray-600 text-sm">
                        Mobile application links to the respective app stores.
                    </p>
                </div>
                <div class="w-3/4">
                    <div class="mb-4">
                        <label class="text-sm font-medium">Apple App Store</label>
                        <input class="bg-gray-100 mt-1" value="{{ $company_details['apps']['apple'] }}"
                               name="apple"
                               placeholder="Apple App Store URL">
                    </div>

                    <div class="mb-4">
                        <label class="text-sm font-medium">Android Play Store</label>
                        <input class="bg-gray-100 mt-1" value="{{ $company_details['apps']['android'] }}"
                               name="android"
                               placeholder="Android Playstore URL">
                    </div>
                </div>
            </div>

            <div class="text-right mt-5">
                <button class="button bg-gray-800 text-white">Update'</button>
            </div>

        </form>
    </div>
@endsection
