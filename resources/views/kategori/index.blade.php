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
                            @can('kategori.create')
                                <button class="btn btn-success btn-round btn-sm mb-2" data-toggle="modal" data-target="#create-kategori"><i class="ti-plus"></i>{{ __('Tambah') }}</button>
                            @endcan
                            <table class="table w-100" id="kategori-table">
                                <thead>
                                    <tr>
                                        <th>{{ __('No') }}</th>
                                        <th>{{ __('Nama') }}</th>
                                        <th>{{ __('Keterangan') }}</th>
                                        @php $permission = false; @endphp
                                        @if ( auth()->user()->hasPermission('kategori.update') || auth()->user()->hasPermission('kategori.delete') )
                                            @php $permission = true; @endphp
                                            <th width="30%">{{ __('Action') }}</th>
                                        @endif
                                    </tr>
                                </thead>
                            </table>
                            <div class="pull-right">
                            </div>

                            @can('kategori.create')
                                
                                <div class="modal fade" id="create-kategori" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">{{ __('Tambah Kategori') }}</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form method="POST"   onsubmit="return checkBeforeSubmit()" action="{{ route('kategori.store') }}">
                                                    @csrf
                                                    <div class="form-group row">
                                                        <label for="nama" class="col-sm-3 col-form-label">{{ __('Nama') }} :</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control form-control-sm" name="nama" id="nama" required>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="keterangan" class="col-sm-3 col-form-label">{{ __('Keterangan') }} :</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control form-control-sm" name="keterangan" id="keterangan">
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
                                {{-- End Modal Create Kategori --}}
                            @endcan

                            @can('kategori.update')
                                {{-- Modal Edit Kategori --}}
                                <div class="modal fade" id="edit-kategori" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">{{ __('Edit Kategori') }}</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form method="POST"   onsubmit="return checkBeforeSubmit()" action="{{ route('kategori.update') }}">
                                                    @csrf
                                                    <div class="form-group row">
                                                        <input type="hidden" class="form-control" name="id" required>
                                                        <label for="edit-nama" class="col-sm-3 col-form-label">{{ __('Nama') }} :</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control form-control-sm" name="nama" id="edit-nama" required>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="edit-keterangan" class="col-sm-3 col-form-label">{{ __('Keterangan') }} :</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control form-control-sm" name="keterangan" id="edit-keterangan" >
                                                        </div>
                                                    </div>
                                                    <hr>
                                                    
                                                </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('Close') }}</button>
                                                <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{-- End Modal Create Kategori --}}
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
    $(document).ready(function(){
        $('#edit-kategori').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var id = button.data('id');
            var nama = button.data('nama');
            var keterangan = button.data('keterangan');
            var modal = $(this);
            
            modal.find('input[name="id"]').val(id);
            modal.find('input[name="nama"]').val(nama);
            modal.find('input[name="keterangan"]').val(keterangan);
            
        });

        var permission = "{{$permission}}";
        var kategoriTable = $('#kategori-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ url('kategori') }}",
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex' },
                { data: 'nama', name: 'nama' },
                { data: 'keterangan', name: 'keterangan' },
                { data: 'actions', name: 'actions', orderable:false, searching:false, visible: permission }
            ],
        });

        kategoriTable.on('error', function () { 
            console.log('DataTables - Ajax Kategori Error ' );
            kategoriTable.ajax.reload();
        });
    });
</script>
@endpush 