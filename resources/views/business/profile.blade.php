@extends('layouts.app')

@section('content')
<div class="main-body">
    <div class="page-wrapper">
    
        <div class="page-body">
            <div class="row">
                <div class="col-sm-12">

                    <div class="card">
                        <div class="card-header">
                        </div>
                        <div class="card-block">
                            
                            <form action="{{ route('business.update_profile') }}" method="post"   onsubmit="return checkBeforeSubmit()" enctype="multipart/form-data">

                                @csrf
                                <input type="hidden" name="id" value="{{ $business->id }}">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="name" class="font-weight-bolder">{{ __('Business Name *') }}</label>
                                            <input type="text" class="form-control form-control-md" name="name" id="name" placeholder="{{ __('Business Name') }}" value="{{ $business->name }}" required>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="desc_name" class="font-weight-bolder">{{ __('Business Description Name') }}</label>
                                            <input type="text" class="form-control form-control-md" name="desc_name" id="desc_name" placeholder="{{ __('Business Description Name') }}" value="{{ $business->desc_name }}">
                                        </div>
                                    </div>
                                    {{-- <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="currency" class="font-weight-bolder">{{ __('Currency *') }}</label>
                                            <select class="form-control form-control-md" name="currency_id" id="currency">
                                                <option value="">--{{ __('Select Currency') }}--</option>
                                                @foreach ($currencies as $currency)
                                                    <option value="{{ $currency->id }}" {{ ( $currency->id == $business->currency_id ) ? 'selected' : '' }}>
                                                        {{ $currency->currency . " - " . $currency->code . "(" . $currency->symbol . ")"  }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div> --}}
                                    {{-- <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="start_date" class="font-weight-bolder">{{ __('Start Date *') }}</label>
                                            <input type="date" class="form-control form-control-md" name="start_date" id="start_date" value="{{ $business->start_date }}"required {{ ( $business->start_date != '' ) ? 'readonly' : '' }}>
                                        </div>
                                    </div> --}}
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="icon" class="font-weight-bolder"> {{ __('Icon ') }} </label>
                                            <i class="fa fa-info-circle text-info hover-q no-print" data-toggle="popover" data-content="{{ __('If you upload a icon here, the old icon will be replaced') }}" data-trigger="hover"></i>
                                            <input type="file" class="form-control-file" name="icon" id="icon">
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="logo" class="font-weight-bolder"> {{ __('Logo ') }} </label>
                                            <i class="fa fa-info-circle text-info hover-q no-print" data-toggle="popover" data-content="{{ __('If you upload a logo here, the old logo will be replaced') }}" data-trigger="hover"></i>
                                            <input type="file" class="form-control-file" name="logo" id="logo">
                                        </div>
                                    </div>
                                    {{-- <div class="col-sm-4 py-3">
                                        <div class="custom-control custom-switch">
                                            <input class="custom-control-input custom-control-input-md" type="checkbox" name="check_tax" id="check-tax" data-target="tax-form-group" {{ ( $business->tax != '' ) ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="check-tax"> {{ __('Tax') }} </label>
                                        </div>
                                        <div class="custom-control custom-switch">
                                            <input class="custom-control-input custom-control-input-md" type="checkbox" name="check_discount" id="check_discount" data-target="discount-form-group" {{ ( $business->discount_value != '' ) ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="check_discount"> {{ __('Discount') }} </label>
                                        </div>
                                    </div>
 --}}
                                    @php
                                        if ( $business->tax != '' ){
                                            if ( strpos($business->tax, '%') !== false ){
                                                $tax = str_replace('%', '', $business->tax);
                                                $tax_percentage = true;
                                                $tax_fixed = false;
                                            }else {
                                                $tax = $business->tax;
                                                $tax_percentage = false;
                                                $tax_fixed = true;
                                            }
                                        }else{
                                            $tax = null;
                                            $tax_percentage = false;
                                            $tax_fixed = false;
                                        }

                                        if ( $business->discount_value != '' ){
                                            if ( strpos($business->discount_value, '%') !== false ){
                                                $discount = str_replace('%', '', $business->discount_value);
                                                $discount_percentage = true;
                                                $discount_fixed = false;
                                            }else {
                                                $discount = $business->discount_value;
                                                $discount_percentage = false;
                                                $discount_fixed = true;
                                            }
                                        }else {
                                            $discount = null;
                                            $discount_percentage = false;
                                            $discount_fixed = false;
                                        }
                                    @endphp
                                    <div class="col-sm-12 {{ ( $business->tax != '' ) ? '' : 'd-none' }}" id="tax-form-group">
                                        <div class="row">
                                            <div class="form-group col-sm-6">
                                                <label for="tax_type" class="font-weight-bolder">{{ __('Tax Type ') }}</label>
                                                <select  class="form-control" id="tax_type" name="tax_type">
                                                    <option value="">--{{ __('Select Tax Type') }}--</option>
                                                    <option value="percentage" {{ ( $tax_percentage ) ? 'selected' : '' }}>{{ __('Percentage') }}</option>
                                                    <option value="fixed" {{ ( $tax_fixed ) ? 'selected' : '' }}>{{ __('Fixed') }}</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-sm-6">
                                                <label for="tax" class="font-weight-bolder">{{ __('Tax ') }}</label>
                                                <input type="number" class="form-control form-control-md" name="tax" id="tax" value="{{ $tax }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 {{ ( $business->discount_value != '' ) ? '' : 'd-none' }}" id="discount-form-group">
                                        <div class="row">
                                            <div class="form-group col-sm-4">
                                                <label for="discount_name" class="font-weight-bolder">{{ __('Discount Name ') }}</label>
                                                <input type="text" class="form-control form-control-md" name="discount_name" id="discount_name" value="{{ $business->discount_name }}">
                                            </div>
                                            <div class="form-group col-sm-4">
                                                <label for="discount_type" class="font-weight-bolder">{{ __('Discount Type ') }}</label>
                                                <select  class="form-control" id="discount_type" name="discount_type">
                                                    <option value="">--{{ __('Select Discount Type') }}--</option>
                                                    <option value="percentage" {{ ( $discount_percentage ) ? 'selected' : '' }}>{{ __('Percentage') }}</option>
                                                    <option value="fixed" {{ ( $discount_fixed ) ? 'selected' : '' }}>{{ __('Fixed') }}</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-sm-4">
                                                <label for="discount" class="font-weight-bolder">{{ __('Discount ') }}</label>
                                                <input type="number" class="form-control form-control-md" name="discount" id="discount" value="{{ $discount }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12" id="tax-form-group">
                                        <button type="submit" class="btn btn-sm btn-danger pull-right">{{ __('Update Settings') }}</button>
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