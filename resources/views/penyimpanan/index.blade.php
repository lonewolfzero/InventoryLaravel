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
                            @can('penyimpanan.create')
                                <button class="btn btn-success btn-round btn-sm mb-2" data-toggle="modal" data-target="#create-penyimpanan"><i class="ti-plus"></i>{{ __('Tambah') }}</button>
                            @endcan
                            <table class="table w-100" id="penyimpanan-table">
                                <thead>
                                    <tr>
                                        <th>{{ __('No') }}</th>
                                        <th>{{ __('Bekal') }}</th>   
                                        <th>{{ __('Rak') }}</th>
                                        <th>{{ __('Gudang') }}</th>
                                        @php $permission = false; @endphp
                                        @if ( auth()->user()->hasPermission('penyimpanan.update') || auth()->user()->hasPermission('penyimpanan.delete') )
                                            @php $permission = true; @endphp
                                            <th width="30%">{{ __('Action') }}</th>
                                        @endif
                                    </tr>
                                </thead>
                            </table>
                            <div class="pull-right">
                            </div>

                            @can('penyimpanan.create')
                                <div class="modal fade" id="create-penyimpanan" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">{{ __('Tambah Penyimpanan') }}</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form method="POST"   onsubmit="return checkBeforeSubmit()" action="{{ route('penyimpanan.store') }}">
                                                    @csrf
                                                    <div class="form-group row">
                                                        <label for="id_barang" class="col-sm-3 col-form-label">{{ __('Bekal') }} :</label>
                                                        <div class="col-sm-8">
                                                            <select class="custom-select js-example-basic-single form-control"  name="id_barang" id="id_barang">
                                                                <option></option>
                                                                @foreach ($barang as $B)
                                                                    <option value="{{ $B->id }}">{{ $B->nama }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="id_gudang" class="col-sm-3 col-form-label">{{ __('Gudang') }} :</label>
                                                        <div class="col-sm-8">
                                                            <select class="custom-select js-example-basic-single form-control"  name="id_gudang" id="id_gudang">
                                                                <option></option>
                                                                @foreach ($gudang ?? [] as $G)
                                                                    <option value="{{ $G->id }}">{{ $G->nama }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="id_rak" class="col-sm-3 col-form-label">{{ __('Rak') }} :</label>
                                                        <div class="col-sm-8">
                                                            <select class="custom-select js-example-basic-single form-control"  name="id_rak" id="id_rak">
                                                                <option></option>
                                                                {{-- @foreach ($rak as $R)
                                                                    <option value="{{ $R->id }}">{{ $R->nama }}</option>
                                                                @endforeach --}}
                                                            </select>
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
                                {{-- End Modal Create Penyimpanan --}}
                            @endcan

                            @can('penyimpanan.update')
                                {{-- Modal Edit Penyimpanan --}}
                                <div class="modal fade" id="edit-penyimpanan" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">{{ __('Edit Penyimpanan') }}</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form method="POST"   onsubmit="return checkBeforeSubmit()" action="{{ route('penyimpanan.update') }}">
                                                    @csrf
                                                    <input type="hidden" name="id" id="id" value="">
                                                    <div class="form-group row">
                                                        <label for="edit-id_barang" class="col-sm-3 col-form-label">{{ __('Bekal') }} :</label>
                                                        <div class="col-sm-9">
                                                            <select class="custom-select js-example-basic-single form-control"  name="id_barang" id="edit-id_barang">
                                                                <option></option>
                                                                @foreach ($barang as $B)
                                                                    <option value="{{ $B->id }}">{{ $B->nama }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="edit-id_gudang" class="col-sm-3 col-form-label">{{ __('Gudang') }} :</label>
                                                        <div class="col-sm-9">
                                                            <select class="custom-select js-example-basic-single form-control"  name="edit-id_gudang" id="edit-id_gudang">
                                                                <option></option>
                                                                @foreach ($gudang ?? [] as $G)
                                                                    <option value="{{ $G->id }}">{{ $G->nama }}</option>
                                                                    @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="edit-id_rak" class="col-sm-3 col-form-label">{{ __('Rak') }} :</label>
                                                        <div class="col-sm-9">
                                                            <select class="custom-select js-example-basic-single form-control"  name="id_rak" id="edit-id_rak">
                                                                <option></option>
                                                                {{-- @foreach ($rak as $R)
                                                                <option value="{{ $R->id }}">{{ $R->nama }}</option>
                                                                @endforeach --}}
                                                            </select>
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
                                {{-- End Modal Create Penyimpanan --}}
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
        var penyimpananTable = $('#penyimpanan-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ url('penyimpanan') }}",
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex' },
                { data: 'nama_barang', name: 'nama_barang' },
                { data: 'nama_rak', name: 'nama_rak' },
                { data: 'nama_gudang', name: 'nama_gudang' },
                { data: 'actions', name: 'actions', orderable:false, searching:false, visible:permission  }
            ],
        });

        penyimpananTable.on('error', function () { 
            console.log('DataTables - Ajax Penyimpanan Error ' );
            penyimpananTable.ajax.reload();
        });

        $('#id_barang').select2({
            placeholder: "{{ __('Choose Bekal...') }}",
            dropdownParent: $('#create-penyimpanan'),
            dataType: 'json',
            ajax: {
                url: "{{ url('penyimpanan') }}",
                data: function (params) {
                    var queryParameters = {
                        q: params.term
                    }
                    return queryParameters;
                },
                processResults: function (data) {
                    return {
                        results: data
                    };
                },
            }
        });
        $('#edit-id_barang').select2({
            placeholder: "{{ __('Choose barang...') }}",
            dropdownParent: $('#edit-penyimpanan'),
            dataType: 'json',
            ajax: {
                url: "{{ url('penyimpanan') }}",
                data: function (params) {
                    var queryParameters = {
                        q: params.term
                    }
                    return queryParameters;
                },
                processResults: function (data) {
                    return {
                        results: data
                    };
                },
            }
        });
       
        $('#id_gudang').select2({
            placeholder: "{{ __('Choose Gudang...') }}",
            dropdownParent: $('#create-penyimpanan'),
            dataType: 'json',
            ajax: {
                url: "{{ url('penyimpanan') }}",
                data: function (params) {
                    var queryParameters = {
                        x: params.term
                    }
                    return queryParameters;
                },
                processResults: function (data) {
                    return {
                        results: data
                    };
                },
            }
        });
        $('#edit-id_gudang').select2({
            placeholder: "{{ __('Choose Gudang...') }}",
            dropdownParent: $('#edit-penyimpanan'),
            dataType: 'json',
            ajax: {
                url: "{{ url('penyimpanan') }}",
                data: function (params) {
                    var queryParameters = {
                        x: params.term
                    }
                    return queryParameters;
                },
                processResults: function (data) {
                    return {
                        results: data
                    };
                },
            }
        });

        $('#id_gudang').on('change', function(e){
            var id_gudang = $(this).val()
            $('#id_rak').select2({
                placeholder: "{{ __('Choose Rak...') }}",
                dropdownParent: $('#create-penyimpanan'),
                dataType: 'json',
                ajax: {
                    url: "{{ url('penyimpanan') }}",
                    data: function (params) {
                        var queryParameters = {
                            z: params.term,
                            zz: id_gudang
                        }
                        return queryParameters;
                    },
                    processResults: function (data) {
                        return {
                            results: data
                        };
                    },
                }
            });
        })

        $('#id_gudang').on('change', function(e){
            var id_gudang = $(this).val();
            $('#edit-id_rak').select2({
                placeholder: "{{ __('Choose Rak...') }}",
                dropdownParent: $('#edit-penyimpanan'),
                dataType: 'json',
                ajax: {
                    url: "{{ url('penyimpanan') }}",
                    data: function (params) {
                        var queryParameters = {
                            z: params.term,
                            zz: id_gudang
                        }
                        return queryParameters;
                    },
                    processResults: function (data) {
                        return {
                            results: data
                        };
                    },
                }
            });
        })

        $('#id_rak').select2({
            placeholder: "{{ __('Choose Rak...') }}",
            dropdownParent: $('#create-penyimpanan'),
        });
        $('#edit-id_rak').select2({
            placeholder: "{{ __('Choose Rak...') }}",
            dropdownParent: $('#edit-penyimpanan'),
        });

        $('#edit-penyimpanan').on('show.bs.modal', function (event) {
            var modal = $(this);
            
            var button = $(event.relatedTarget);
            var id = button.data('id');

            var id_barang = button.data('id_barang');
            var nama_barang = button.data('nama_barang');

            var nama_gudang = button.data('nama_gudang');
            var id_gudang = button.data('id_gudang');

            var nama_rak = button.data('nama_rak');
            var id_rak = button.data('id_rak');
            
            modal.find('input[name="id"]').val(id);

            $('input#id').val(id);
            $('select#edit-id_barang').append(`<option value="${id_barang}" selected>${nama_barang}</select>`);
            $('select#edit-id_gudang').append(`<option value="${id_gudang}" selected>${nama_gudang}</select>`);
            $('select#edit-id_rak').append(`<option value="${id_rak}" selected>${nama_rak}</select>`);
        });

    });
</script>
@endpush 