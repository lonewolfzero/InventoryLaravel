@extends('layouts.app')

@section('content')
<div class="main-body">
    <div class="page-wrapper">

        <div class="page-body">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-header-right">
                                <ul class="list-unstyled card-option">
                                    <li><i class="fa fa-chevron-left"></i></li>
                                    <li><i class="fa fa-window-maximize full-card"></i></li>
                                    <li><i class="fa fa-minus minimize-card"></i></li>
                                    <li><i class="fa fa-refresh reload-card"></i></li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-block table-border-style">
                            @can('users.create')
                                <button class="btn btn-success btn-round btn-sm mb-2" data-toggle="modal" data-target="#create-user"><i class="ti-plus"></i>{{ __('Tambah') }}</button>
                            @endcan
                            <table class="table w-100" id="users-table">
                                <thead>
                                    <tr>
                                        <th>{{ __('No') }}</th>
                                        <th>{{ __('Name') }}</th>
                                        <th>{{ __('Email') }}</th>
                                        <th>{{ __('Role') }}</th>
                                        <th>{{ __('Gudang') }}</th>
                                        {{-- <th>{{ __('Scope') }}</th> --}}
                                        @php $permission = false; @endphp
                                        @if ( auth()->user()->hasPermission('users.update') || auth()->user()->hasPermission('users.delete') )
                                            @php $permission = true; @endphp
                                            <th width="30%">{{ __('Action') }}</th>
                                        @endif
                                    </tr>
                                </thead>
                            </table>
                            <div class="pull-right">
                            </div>

                            @can('users.create')
                                Modal Create User
                                <div class="modal fade" id="create-user" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">{{ __('Tambah User') }}</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form method="POST"   onsubmit="return checkBeforeSubmit()" action="{{ route('user.store') }}">
                                                    @csrf
                                                    <div class="form-group row">
                                                        <label for="name" class="col-sm-4 col-form-label">{{ __('Name') }} :</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control form-control-sm" name="name" id="name" required>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="email" class="col-sm-4 col-form-label">{{ __('Email') }} :</label>
                                                        <div class="col-sm-8">
                                                            <input type="email" class="form-control form-control-sm" name="email" id="email" required>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="role" class="col-sm-4 col-form-label">{{ __('Role') }} :</label>
                                                        <div class="col-sm-8">
                                                            <select class="custom-select js-example-basic-single form-control"  name="role" required id="role">
                                                                <option></option>
                                                                @foreach ($roles as $role)
                                                                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="id_gudang" class="col-sm-4 col-form-label">{{ __('Gudang') }} :</label>
                                                        <div class="col-sm-8">
                                                            <select class="custom-select js-example-basic-single form-control" name="id_gudang" id="id_gudang" required>
                                                                <option value="">-</option>
                                                                <option value=0>{{ __('Semua Gudang') }}</option>
                                                                @foreach ($gudang as $g)
                                                                    <option value="{{ $g->id }}">{{ $g->nama }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    {{-- <div class="form-group row">
                                                        <label for="scope" class="col-sm-2 col-form-label">{{ __('Scope') }} :</label>
                                                        <div class="col-sm-10">
                                                            <select class="custom-select js-example-basic-single form-control" name="scope" id="scope" required>
                                                                <option>-</option>
                                                                <option value="0">{{ __('Mobile') }}</option>
                                                                <option value="1">{{ __('Web') }}</option>
                                                                <option value="2">{{ __('Mobile & Web') }}</option>
                                                            </select>
                                                        </div>
                                                    </div> --}}
                                                    {{-- <div class="form-group row">
                                                        <label for="location" class="col-sm-2 col-form-label">{{ __('Location') }} :</label>
                                                        <div class="col-sm-10">
                                                            <select class="custom-select js-example-basic-single form-control" name="location" id="location">
                                                                <option></option>
                                                                @foreach (config('business')->locations as $location)
                                                                    <option value="{{ $location->id }}">{{  config('business.name') . ' - ' . $location->name . "( $location->location_id )" }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div> --}}
                                                    <hr>
                                                    <div class="form-group row">
                                                        <label for="password" class="col-sm-4 col-form-label">{{ __('Password') }} :</label>
                                                        <div class="col-sm-8 input-group">
                                                            <input type="password" class="form-control form-control-sm" name="password" id="password" required>
                                                            <div class="input-group-prepend">
                                                                <div class="input-group-text" id="button-see-password"><i id="pass-eye-icon" class="fa fa-eye-slash"></i></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="password2" class="col-sm-4 col-form-label">{{ __('Confirm Password') }} :</label>
                                                        <div class="col-sm-8">
                                                            <input type="password" class="form-control form-control-sm" name="password2" id="password2" required>
                                                            <small class="text-danger pl-2" role="alert">
                                                                <strong id="invalid-password"></strong>
                                                            </small>
                                                        </div>
                                                    </div>

                                                </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('Close') }}</button>
                                                <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{-- End Modal Create User --}}
                            @endcan

                            @can('users.update')
                                {{-- Modal Edit User --}}
                                <div class="modal fade" id="edit-user" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">{{ __('Edit User') }}</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form method="POST"   onsubmit="return checkBeforeSubmit()" action="{{ route('user.update') }}">
                                                    @csrf
                                                    <div class="form-group row">
                                                        <input type="hidden" class="form-control" name="id" required>
                                                        <label for="edit-name" class="col-sm-4 col-form-label">{{ __('Name') }} :</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control form-control-sm" name="name" id="edit-name" required>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="edit-email" class="col-sm-4 col-form-label">{{ __('Email') }} :</label>
                                                        <div class="col-sm-8">
                                                            <input type="email" class="form-control form-control-sm" name="email"id="edit-email" required>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="edit-role" class="col-sm-4 col-form-label">{{ __('Role') }} :</label>
                                                        <div class="col-sm-8">
                                                            <select class="custom-select js-example-basic-single form-control" name="role" required id="edit-role">
                                                                <option></option>
                                                                @foreach ($roles as $role)
                                                                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="edit-id_gudang" class="col-sm-4 col-form-label">{{ __('Gudang') }} :</label>
                                                        <div class="col-sm-8">
                                                            <select class="custom-select js-example-basic-single form-control" name="id_gudang" id="edit-id_gudang" required>
                                                                <option value="">-</option>
                                                                <option value=0>{{ __('Semua Gudang') }}</option>
                                                                @foreach ($gudang as $g)
                                                                    <option value="{{ $g->id }}">{{ $g->nama }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    {{-- <div class="form-group row">
                                                        <label for="scope" class="col-sm-2 col-form-label">{{ __('Scope') }} :</label>
                                                        <div class="col-sm-10">
                                                            <select class="custom-select js-example-basic-single form-control" name="scope" id="scope" required>
                                                                <option>-</option>
                                                                <option value="0">{{ __('Mobile') }}</option>
                                                                <option value="1">{{ __('Web') }}</option>
                                                                <option value="2">{{ __('Mobile & Web') }}</option>
                                                            </select>
                                                        </div>
                                                    </div> --}}
                                                    {{-- <div class="form-group row">
                                                        <label for="edit-location" class="col-sm-2 col-form-label">{{ __('Location') }} :</label>
                                                        <div class="col-sm-10">
                                                            <select class="custom-select js-example-basic-single form-control" name="location" id="edit-location">
                                                                <option></option>
                                                                @foreach (config('business')->locations as $location)
                                                                    <option value="{{ $location->id }}">{{  config('business.name') . ' - ' . $location->name . "( $location->location_id )" }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div> --}}
                                                    <hr>
                                                    <center>
                                                        <small class="text-center" role="alert">
                                                            <strong>
                                                                {{ __("Skip it if you don't want to change your password") }}
                                                            </strong>
                                                        </small>
                                                    </center>
                                                    <div class="form-group row">
                                                        <label for="password" class="col-sm-4 col-form-label">{{ __('Password') }} :</label>
                                                        <div class="col-sm-8 input-group">
                                                            <input type="password" class="form-control form-control-sm" name="password" id="password">
                                                            <div class="input-group-prepend">
                                                                <div class="input-group-text" id="button-see-password2"><i id="pass-eye-icon2" class="fa fa-eye-slash"></i></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="password2" class="col-sm-4 col-form-label">{{ __('Confirm Password') }} :</label>
                                                        <div class="col-sm-8">
                                                            <input type="password" class="form-control form-control-sm" name="password2" id="password2">
                                                            <small class="text-danger d-none pl-2" role="alert">
                                                                <strong id="invalid-password"></strong>
                                                            </small>
                                                        </div>
                                                    </div>
                                                </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('Close') }}</button>
                                                <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{-- End Modal Create User --}}
                            @endcan

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
@include('partials.datatables')
<script>
    var permission = "{{$permission}}";
    $(document).ready(function(){
        $('#edit-user').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var id = button.data('id');
            var name = button.data('name');
            var email = button.data('email');
            var role = button.data('roleid');
            var scope = button.data('scope');
            var idgudang = button.data('idgudang');
            var location = button.data('locationid');
            var modal = $(this);
            
            modal.find('input[name="id"]').val(id);
            modal.find('input[name="name"]').val(name);
            modal.find('input[name="email"]').val(email);
            modal.find('select[name="role"]').val(role);
            modal.find('select[name="role"]').change();
            modal.find('select[name="id_gudang"]').val(idgudang);
            modal.find('select[name="id_gudang"]').change();
            // modal.find('select[name="scope"]').val(scope);
            // modal.find('select[name="scope"]').change();
            // modal.find('select[name="location"]').val(location);
            // modal.find('select[name="location"]').change();
        });

        var userTable = $('#users-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ url('users') }}",
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex' },
                { data: 'name', name: 'name' },
                { data: 'email', name: 'email' },
                { data: 'role.name', name: 'role.name' },
                { data: 'nama_gudang', name: 'nama_gudang' },
                // { data: 'scope', name: 'scope' },
                { data: 'actions', name: 'actions', orderable:false, searching:false, visible:permission  }
            ],
        });

        userTable.on('error', function () { 
            console.log('DataTables - Ajax User Table Error ' );
            userTable.ajax.reload();
        });

        $('#create-user form, #edit-user form').submit(function(e){
            var password = $(this).find('input[name="password"]').val();
            var password2 = $(this).find('input[name="password2"]').val();
            if ( password.length < 8 && password.length > 0 ){
                $(this).find('#invalid-password').removeClass('d-none');
                $(this).find('#invalid-password').html("The password must be at least 8 characters.");
                return false;
            }

            if ( password != password2 ){
                $(this).find('input[name="password"]').val('');
                $(this).find('input[name="password2"]').val('');
                $(this).find('#invalid-password').removeClass('d-none');
                $(this).find('#invalid-password').html("The password confirmation does not match.");
                return false;
            }else {
                $(this).find('#invalid-password').addClass('d-none');
                $(this).find('#invalid-password').html("");
                return true;
            }
        });

        $('#role').select2({
            placeholder: "{{ __('Choose Role...') }}",
            dropdownParent: $('#create-user')
        });
        $('#edit-role').select2({
            placeholder: "{{ __('Choose Role...') }}",
            dropdownParent: $('#edit-user')
        });
        
        $('#id_gudang').select2({
            placeholder: "{{ __('Choose Gudang...') }}",
            dropdownParent: $('#create-user')
        });
        $('#edit-id_gudang').select2({
            placeholder: "{{ __('Choose Gudang...') }}",
            dropdownParent: $('#edit-user')
        });
       
        $('#location').select2({
            placeholder: "{{ __('Choose Location...') }}",
            dropdownParent: $('#create-user')
        });
        $('#edit-location').select2({
            placeholder: "{{ __('Choose Location...') }}",
            dropdownParent: $('#edit-user')
        });

    });
</script>
@endpush 