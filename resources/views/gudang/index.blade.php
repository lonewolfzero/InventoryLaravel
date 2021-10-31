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
                            @can('gudang.create')
                                @if (in_array(auth()->user()->role->id, [1, 1]) && ( auth()->user()->id_gudang == 0 || auth()->user()->id_gudang == null))
                                    <button class="btn btn-success btn-round btn-sm mb-2" data-toggle="modal" data-target="#create-gudang"><i class="ti-plus"></i>{{ __('Tambah') }}</button>
                                @endif
                            @endcan
                            <table class="table w-100" id="gudang-table">
                                <thead>
                                    <tr>
                                        <th>{{ __('No') }}</th>
                                        <th>{{ __('Nama') }}</th>
                                        <th>{{ __('Nomor') }}</th>
                                        <th>{{ __('Keterangan') }}</th>
                                        @php $permission = false; @endphp
                                        @if ( auth()->user()->hasPermission('gudang.update') || auth()->user()->hasPermission('gudang.delete') )
                                            @php $permission = true; @endphp
                                            <th width="30%">{{ __('Action') }}</th>
                                        @endif
                                    </tr>
                                </thead>
                            </table>
                            <div class="pull-right">
                            </div>

                            @can('gudang.create')
                                
                                <div class="modal fade" id="create-gudang" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">{{ __('Tambah Gudang') }}</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form method="POST"   onsubmit="return checkBeforeSubmit()" action="{{ route('gudang.store') }}">
                                                    @csrf
                                                    <div class="form-group row">
                                                        <label for="nama" class="col-sm-3 col-form-label">{{ __('Nama') }} :</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control form-control-sm" name="nama" id="nama" required>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="nomor" class="col-sm-3 col-form-label">{{ __('Nomor') }} :</label>
                                                        <div class="col-sm-8">
                                                            <input type="number" class="form-control form-control-sm" name="nomor" id="nomor" required>
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
                                {{-- End Modal Create Gudang --}}
                            @endcan

                            @can('gudang.update')
                                {{-- Modal Edit Gudang --}}
                                <div class="modal fade" id="edit-gudang" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">{{ __('Edit Gudang') }}</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form method="POST"   onsubmit="return checkBeforeSubmit()" action="{{ route('gudang.update') }}">
                                                    @csrf
                                                    <div class="form-group row">
                                                        <input type="hidden" class="form-control" name="id" required>
                                                        <label for="edit-nama" class="col-sm-3 col-form-label">{{ __('Nama') }} :</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control form-control-sm" name="nama" id="edit-nama" required>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="edit-nomor" class="col-sm-3 col-form-label">{{ __('Nomor') }} :</label>
                                                        <div class="col-sm-8">
                                                            <input type="number" class="form-control form-control-sm" name="nomor"id="edit-nomor" required>
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
                                {{-- End Modal Create Gudang --}}
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
        $('#edit-gudang').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var id = button.data('id');
            var nama = button.data('nama');
            var nomor = button.data('nomor');
            var keterangan = button.data('keterangan');
            var modal = $(this);
            
            modal.find('input[name="id"]').val(id);
            modal.find('input[name="nama"]').val(nama);
            modal.find('input[name="nomor"]').val(nomor);
            modal.find('input[name="keterangan"]').val(keterangan);
            
        });

        var permission = "{{$permission}}";
        var gudangTable = $('#gudang-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ url('gudang') }}",
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex' },
                { data: 'nama', name: 'nama' },
                { data: 'nomor', name: 'nomor' },
                { data: 'keterangan', name: 'keterangan' },
                { data: 'actions', name: 'actions', orderable:false, searching:false, visible:permission }
            ],
        });

       
    });
</script>
@endpush 