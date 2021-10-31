@extends('layouts.app')

@section('content')
<div class="main-body">
    <div class="page-wrapper">
    
        <!-- Page-header start -->
        <div class="page-header card">
            <div class="card-block">
                <h5 class="m-b-10">{{ __('Tambah Location') }} </h5>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="ti-home"></i> {{ __('Dashboard') }}</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('business.locations') }}"> {{ __('Business Locations') }}</a></li>
                        <li class="breadcrumb-item active"> {{ __('Tambah Locations') }}</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!-- Page-header end -->
        

        <div class="page-body">
            <div class="row">
                <div class="col-sm-12">

                    <div class="card">
                        <div class="card-header">
                        </div>
                        <div class="card-block">
                            
                            <form action="{{ route('business.store_location') }}" method="post"   onsubmit="return checkBeforeSubmit()">

                                @csrf
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="name" class="font-weight-bolder">{{ __('Location Name *') }}</label>
                                            <input type="text" class="form-control form-control-md" name="name" id="name" placeholder="{{ __('Location Name') }}" required>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="business_id" class="font-weight-bolder">{{ __('Business *') }}</label>
                                            <select class="form-control form-control-md" name="business_id" id="business_id" required>
                                                <option value="">--{{ __('Select Business') }}--</option>
                                                @foreach ($business as $busines)
                                                    <option value="{{ $busines->id }}">
                                                        {{ $busines->location_id  }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="country" class="font-weight-bolder">{{ __('Country *') }}</label>
                                            <input type="text" class="form-control form-control-md" name="country" id="country" placeholder="{{ __('Country') }}" required>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="state" class="font-weight-bolder">{{ __('State *') }}</label>
                                            <input type="text" class="form-control form-control-md" name="state" id="state" placeholder="{{ __('State') }}" required>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="city" class="font-weight-bolder">{{ __('City *') }}</label>
                                            <input type="text" class="form-control form-control-md" name="city" id="city" placeholder="{{ __('City') }}" required>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="zip_code" class="font-weight-bolder">{{ __('Zip Code *') }}</label>
                                            <input type="text" class="form-control form-control-md" name="zip_code" id="zip_code" placeholder="{{ __('Zip Code') }}" required>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="address" class="font-weight-bolder">{{ __('Address *') }}</label>
                                            <input type="text" class="form-control form-control-md" name="address" id="address" placeholder="{{ __('Address') }}" required>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="email" class="font-weight-bolder">{{ __('Email *') }}</label>
                                            <input type="email" class="form-control form-control-md" name="email" id="email" placeholder="{{ __('Email') }}" required>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="mobile" class="font-weight-bolder">{{ __('Phone *') }}</label>
                                            <input type="text" class="form-control form-control-md" name="mobile" id="email" placeholder="{{ __('Phone') }}" required>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="alternate_number" class="font-weight-bolder">{{ __('Alternate Number') }}</label>
                                            <input type="text" class="form-control form-control-md" name="alternate_number" id="email" placeholder="{{ __('Alternate Number') }}">
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="printer_id" class="font-weight-bolder">{{ __('Printer ID') }}</label>
                                            <input type="text" class="form-control form-control-md" name="printer_id" id="email" placeholder="{{ __('Printer ID') }}">
                                        </div>
                                    </div>
                                    <div class="col-sm-12" id="tax-form-group">
                                        <button type="submit" class="btn btn-sm btn-success pull-right m-2">{{ __('Save ') }}</button>
                                        <button type="reset" class="btn btn-sm btn-danger pull-right m-2">{{ __('Reset') }}</button>
                                    </div>
                                </div>

                            </form>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
@include('partials.functions')
<script>
    $(function () {
        $('[data-toggle="popover"]').popover();

        $('input[type="checkbox"]').change(function(e){
            var target = $(this).data('target');
            if ( target == 'tax-form-group' || target == 'discount-form-group' ){
                $('#'+target).toggleClass("d-none");
                if ( $('#'+target).find("input").prop('required') || $('#'+target).find("select").prop('required') ) {
                    $('#'+target).find("input").prop('required', false);
                    $('#'+target).find("select").prop('required', false);
                } else {
                    $('#'+target).find("input").prop('required', true);
                    $('#'+target).find("select").prop('required', true);
                }
            }
        });

    });
</script>
@endpush 