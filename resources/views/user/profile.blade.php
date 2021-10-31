@extends('layouts.app')

@section('content')
<div class="main-body">
    <div class="page-wrapper">
    
        <div class="page-body">
            <div class="row">
                <div class="col-sm-12">

                    <div class="card">
                        <div class="card-header">
                            <h4>{{ __('Change Password') }}</h3>
                        </div>
                        <div class="card-block">
                            
                            <form action="{{ route('profile.change_password') }}" method="post"   onsubmit="return checkBeforeSubmit()" id="change-password">

                                @csrf
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="current_password" class="font-weight-bolder">{{ __('Current Password') }}</label>
                                            <input type="password" class="form-control form-control-md" name="current_password" id="current_password" placeholder="{{ __('Current Password') }}" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="password" class="font-weight-bolder">{{ __('New Password') }}</label>
                                            <input type="password" class="form-control form-control-md" name="password" id="password" placeholder="{{ __('New Password') }}" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="password2" class="font-weight-bolder">{{ __('Confirm New Password') }}</label>
                                            <input type="password" class="form-control form-control-md" name="password2" id="password2" placeholder="{{ __('Confirm New Password') }}" required>
                                            <small class="text-danger pl-2" role="alert">
                                                <strong id="invalid-password"></strong>
                                            </small>
                                        </div>
                                    </div>
                                    <div class="col-sm-12" id="tax-form-group">
                                        <button type="submit" class="btn btn-sm btn-danger pull-right">{{ __('Change Password') }}</button>
                                    </div>
                                </div>

                            </form>

                        </div>
                    </div>

                </div>

                <div class="col-sm-12">

                    <div class="card">
                        <div class="card-header">
                            <h4>{{ __('Edit Profile') }}</h3>
                        </div>
                        <div class="card-block">
                            
                            <form action="{{ route('profile.update') }}" method="post"   onsubmit="return checkBeforeSubmit()" enctype="multipart/form-data">

                                @csrf
                                {{-- <input type="hidden" name="id" value="{{ $business->id }}"> --}}
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="name" class="font-weight-bolder">{{ __('Name *') }}</label>
                                            <input type="text" class="form-control form-control-md" name="name" id="name" placeholder="{{ __('Business Name') }}" value="{{ $profile->name }}" required>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="email" class="font-weight-bolder">{{ __('Name *') }}</label>
                                            <input type="email" class="form-control form-control-md" name="email" id="email" placeholder="{{ __('Email') }}" value="{{ $profile->email }}" required>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="date_of_birth" class="font-weight-bolder">{{ __('Date of Birth ') }}</label>
                                            <input type="date" class="form-control form-control-md" name="date_of_birth" id="date_of_birth" value="{{ $profile->date_of_birth }}">
                                        </div>
                                    </div>
                                    <div class="form-group col-sm-4">
                                        <label for="gender" class="font-weight-bolder">{{ __('Gender ') }}</label>
                                        <select  class="form-control" id="gender" name="gender">
                                            <option value="">--{{ __('Select Gender...') }}--</option>
                                            <option value="male" {{ ( $profile->gender == 'male' ) ? 'selected' : '' }}>{{ __('Male') }}</option>
                                            <option value="female" {{ ( $profile->gender == 'female' ) ? 'selected' : '' }}>{{ __('Female') }}</option>
                                            <option value="other" {{ ( $profile->gender == 'other' ) ? 'selected' : '' }}>{{ __('Other') }}</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-sm-4">
                                        <label for="marital_status" class="font-weight-bolder">{{ __('Marital Status ') }}</label>
                                        <select  class="form-control" id="marital_status" name="marital_status">
                                            <option value="">--{{ __('Select Marital Status...') }}--</option>
                                            <option value="married" {{ ( $profile->marital_status == 'married' ) ? 'selected' : '' }}>{{ __('Married') }}</option>
                                            <option value="unmarried" {{ ( $profile->marital_status == 'unmarried' ) ? 'selected' : '' }}>{{ __('Unmarried') }}</option>
                                            <option value="divorced" {{ ( $profile->marital_status == 'divorced' ) ? 'selected' : '' }}>{{ __('Divorced') }}</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="blood_group" class="font-weight-bolder">{{ __('Blood Group') }}</label>
                                            <input type="text" class="form-control form-control-md" name="blood_group" id="blood_group" placeholder="{{ __('Blood Group') }}" value="{{ $profile->blood_group }}" >
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="contact_number" class="font-weight-bolder">{{ __('Contact Number') }}</label>
                                            <input type="text" class="form-control form-control-md" name="contact_number" id="contact_number" placeholder="{{ __('Contact Number') }}" value="{{ $profile->contact_number }}" >
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="profile_photo" class="font-weight-bolder"> {{ __('Profile Photo ') }} </label>
                                            <i class="fa fa-info-circle text-info hover-q no-print" data-toggle="popover" data-content="{{ __('If you upload a profile photo here, the old profile photo will be replaced') }}" data-trigger="hover"></i>
                                            <input type="file" class="form-control-file" name="profile_photo" id="profile_photo">
                                        </div>
                                    </div>
                                    </div>
                                    <div class="col-sm-12" id="tax-form-group">
                                        <button type="submit" class="btn btn-sm btn-danger pull-right">{{ __('Update Profile') }}</button>
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
        $('form#change-password').submit(function(e){
            var password = $(this).find('input[name="password"]').val();
            var password2 = $(this).find('input[name="password2"]').val();
            if ( password.length < 8 && password.length > 0 ){
                $(this).find('#invalid-password').html("The password must be at least 8 characters.");
                return false;
            }

            if ( password != password2 ){
                $(this).find('input[name="password"]').val('');
                $(this).find('input[name="password2"]').val('');
                $(this).find('#invalid-password').html("The password confirmation does not match.");
                return false;
            }else {
                $(this).find('#invalid-password').html("");
                return true;
            }
        });

    });
</script>
@endpush 