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
                            @can('roles.create')
                                <button class="btn btn-success btn-round btn-sm mb-2" data-toggle="modal" data-target="#create-role"><i class="ti-plus"></i>{{ __('Tambah') }}</button>
                            @endcan
                            <table class="table w-100" id="role-table">
                                <thead>
                                    <tr>
                                        <th>{{ __('No') }}</th>
                                        <th>{{ __('Name') }}</th>
                                        @php $permission = false; @endphp
                                        @canany(['roles.update', 'roles.delete', 'roles.give_permission'])
                                            @php $permission = true; @endphp
                                            <th class="act">{{ __('Action') }}</th>
                                        @endcanany
                                    </tr>
                                </thead>
                            </table>
                            <div class="pull-right">
                            </div>

                            @can('roles.create')
                                {{-- Modal Create User --}}
                                <div class="modal fade" id="create-role" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">{{ __('Tambah Role') }}</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form method="POST"   onsubmit="return checkBeforeSubmit()" action="{{ route('role.store') }}">
                                                    @csrf
                                                    <div class="form-group row">
                                                        <label for="name" class="col-sm-2 col-form-label">{{ __('Name') }} :</label>
                                                        <div class="col-sm-10">
                                                            <input type="text" class="form-control form-control-sm" name="name" id="name" required>
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

                            @can('roles.update')
                                {{-- Modal Edit User --}}
                                <div class="modal fade" id="edit-role" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">{{ __('Edit Role') }}</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form method="POST"   onsubmit="return checkBeforeSubmit()" action="{{ route('role.update') }}">
                                                    @csrf
                                                    <div class="form-group row">
                                                        <input type="hidden" class="form-control" name="id" required>
                                                        <label for="edit-name" class="col-sm-2 col-form-label">{{ __('Name') }} :</label>
                                                        <div class="col-sm-10">
                                                            <input type="text" class="form-control form-control-sm" name="name" id="edit-name" required>
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
    var permissions = "{{$permission}}";
    $(document).ready(function(){
        $('#edit-role').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var id = button.data('id');
            var name = button.data('name');
            var modal = $(this);
            
            modal.find('input[name="id"]').val(id);
            modal.find('input[name="name"]').val(name);
        });

        var roleTable = $('#role-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ url('roles') }}",
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex' },
                { data: 'name', name: 'name' },
                { data: 'actions', name: 'actions', orderable:false, searchable:false, visible: permissions }
            ],
        });

        roleTable.on('error', function () { 
            console.log('DataTables - Ajax Role Error ' );
            roleTable.ajax.reload();
        });

    });
</script>
@can(['roles.update', 'roles.delete'])
    <script>
        roleTable.column(1).visible(false);
    </script>
@endcan
@endpush 