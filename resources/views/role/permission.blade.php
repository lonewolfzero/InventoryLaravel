@extends('layouts.app')

@section('content')
<div class="main-body">
    <div class="page-wrapper">
    
        <div class="page-body">
            <div class="row">
                <div class="col-sm-12">
                    <div id="accordion">
                        <form action="{{ route('role.give_permissions', ['id' => request()->segment(3)]) }}" method="post"   onsubmit="return checkBeforeSubmit()">
                        @csrf
                        @foreach ($modul as $permissions)
                            @php
                                $key = array_keys($modul)[$loop->index]
                            @endphp
                            <div class="card">
                                <div class="card-header p-1" id="headingThree">
                                    <h4 class="float-left m-3">{{ ucwords(str_replace('_', ' ', $key)) }}</h4>
                                    <button class="btn collapsed float-right" data-toggle="collapse" data-target="#{{ $key . $loop->index }}" aria-expanded="false" aria-controls="{{ $key . $loop->index }}">
                                        <i class="ti-angle-down"></i>
                                    </button>
                                </div>
                                <div id="{{ $key . $loop->index }}" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
                                    <div class="card-body px-3 py-1">
                                        <div class="container">
                                            <hr>
                                            <div class="row">
                                                @foreach ($permissions as $permission)
                                                    @if ( !in_array($permission['name'], ['business.locations', 'business.create_location',  'business.update_location',  'business.delete_location']) )
                                                        <div class="custom-control form-control-lg custom-checkbox col-md-5">
                                                            <input type="checkbox" class="custom-control-input" id="{{ "checkbox" . $key . $loop->index }}" name="permissions[]" value="{{ $permission['id'] }}" {{ ( count($role_has_permissions->permissions()->where(['permission_id' => $permission['id'], 'role_id' => request()->segment(3)])->get()) > 0 ) ? 'checked' : '' }}>
                                                            <label class="custom-control-label" for="{{ "checkbox" . $key . $loop->index }}">
                                                                {{-- {{ ucwords(str_replace('.', ' ', $permission['name'])) }} --}}
                                                                @php
                                                                    if (strpos($permission['name'], "_") != null) {
                                                                        $perm = str_replace("$key.", '', $permission['name']);
                                                                        echo ucwords(str_replace('_', ' ', $perm));
                                                                    }else {
                                                                        echo ucwords(str_replace('.', ' ', $permission['name']));
                                                                    }
                                                                @endphp
                                                            </label>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            <div class="pull-right">
                                <a href="{{ route('role.index') }}">
                                    <button class="btn btn-danger" type="button">{{ __('cancel') }}</button>
                                </a>
                                <button class="btn btn-success" type="submit">{{ __('Save Changes') }}</button>

                            </div>
                        </form>
                    </div>
                   
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
@include('partials.functions')
@endpush 