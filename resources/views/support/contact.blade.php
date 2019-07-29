@extends('layout.master')

@section('page.title', 'Contact Us')

@section('content')
    <div class="map">
        <iframe width="100%" height="300" id="gmap_canvas"
                src="https://maps.google.com/maps?q=Scolmore%20international&t=&z=15&ie=UTF8&iwloc=&output=embed" frameborder="0">
        </iframe>
    </div>

    <div class="row mt-4">
        <div class="col-lg-4">
            <div class="card card-body">
                <div class="address">
                    <span>{{ env('ADDRESS_LINE_1') }}</span>
                    <span>{{ env('ADDRESS_LINE_2') }}</span>
                    <span>{{ env('ADDRESS_LINE_3') }}</span>
                    <span>{{ env('ADDRESS_LINE_4') }}</span>
                    <span>{{ env('ADDRESS_LINE_5') }}</span>
                    <span>{{ env('ADDRESS_POSTCODE') }}</span>

                    <br>

                    <span>{{ env('ADDRESS_TELEPHONE') ? 'Tel: ' . env('ADDRESS_TELEPHONE') : '' }}</span>
                    <span>{{ env('ADDRESS_FAX') ? 'Fax: ' . env('ADDRESS_FAX') : '' }}</span>
                </div>
            </div>
        </div>
        <div class="col-lg-8">
            <div class="card card-body">
                <form action="">
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">To:</label>
                        <div class="col-sm-10">
                            <select class="form-control">
                                @foreach($contacts as $contact)
                                    <option value="{{ $contact->email }}">{{ $contact->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Name:</label>
                        <div class="col-sm-10">
                            <input class="form-control"
                                   value="{{ Auth::user() ? Auth::user()->first_name . ' ' . Auth::user()->last_name : '' }}">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Email:</label>
                        <div class="col-sm-10">
                            <input class="form-control" value="{{ Auth::user() ? Auth::user()->email : '' }}">
                        </div>
                    </div>

                    <div class="form-group row mb-0">
                        <label class="col-sm-2 col-form-label">Message:</label>
                        <div class="col-sm-10">
                            <textarea class="form-control" rows="5"></textarea>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
