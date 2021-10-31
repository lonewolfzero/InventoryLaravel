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
                            @can('barang.create')
                                <button class="btn btn-success btn-round btn-sm mb-2" data-toggle="modal" data-target="#create-barang"><i class="ti-plus"></i>{{ __('Tambah') }}</button>
                            @endcan
                            <table class="table w-100" id="barang-table">
                                <thead>
                                    <tr>
                                        <th>{{ __('No') }}</th>
                                        <th>{{ __('Kode Bekal') }}</th> 
                                        <th>{{ __('Nama') }}</th>   
                                        <th>{{ __('Kode Barcode') }}</th>
                                        <th>{{ __('Keterangan') }}</th>
                                        <th>{{ __('Kategori') }}</th>
                                        <th>{{ __('Satuan') }}</th>
                                        @php $permission = false; @endphp
                                        @if ( auth()->user()->hasPermission('barang.update') || auth()->user()->hasPermission('barang.delete') )
                                            @php $permission = true; @endphp
                                            <th width="30%">{{ __('Action') }}</th>
                                        @endif
                                    </tr>
                                </thead>
                            </table>
                            <div class="pull-right">
                            </div>

                            @can('barang.create')
                                <div class="modal fade" id="create-barang" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">{{ __('Tambah Bekal') }}</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form method="POST"   onsubmit="return checkBeforeSubmit()" action="{{ route('barang.store') }}">
                                                    @csrf
                                                    <div class="form-group row">
                                                        <label for="kode_barang" class="col-sm-4 col-form-label">{{ __('Kode Bekal') }} :</label>
                                                        <div class="col-sm-7">
                                                            <input type="text" class="form-control form-control-sm" name="kode_barang" id="kode_barang" required >
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="nama" class="col-sm-4 col-form-label">{{ __('Nama') }} :</label>
                                                        <div class="col-sm-7">
                                                            <input type="text" class="form-control form-control-sm" name="nama" id="nama" required>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="kode_barcode" class="col-sm-4 col-form-label">{{ __('Kode Barcode') }} :</label>
                                                        <div class="col-sm-7">
                                                            <input type="text" class="form-control form-control-sm" name="kode_barcode" id="kode_barcode" required>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="keterangan" class="col-sm-4 col-form-label">{{ __('Keterangan') }} :</label>
                                                        <div class="col-sm-7">
                                                            <input type="text" class="form-control form-control-sm" name="keterangan" id="keterangan">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="id_kategori" class="col-sm-3 col-form-label">{{ __('Kategori') }} :</label>
                                                        <div class="col-sm-8">
                                                            <select class="custom-select js-example-basic-single form-control"  name="id_kategori" id="id_kategori">
                                                                <option></option>
                                                                @foreach ($kategori as $k)
                                                                    <option value="{{ $k->id }}">{{ $k->nama }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="id_satuan" class="col-sm-3 col-form-label">{{ __('Satuan') }} :</label>
                                                        <div class="col-sm-8">
                                                            <select class="custom-select js-example-basic-single form-control"  name="id_satuan" id="id_satuan">
                                                                <option></option>
                                                                @foreach ($satuan as $s)
                                                                    <option value="{{ $s->id }}">{{ $s->nama }}</option>
                                                                @endforeach
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
                                {{-- End Modal Create Bekal --}}
                            @endcan

                            @can('barang.update')
                                {{-- Modal Edit Bekal --}}
                                <div class="modal fade" id="edit-barang" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">{{ __('Edit Bekal') }}</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form method="POST"   onsubmit="return checkBeforeSubmit()" action="{{ route('barang.update') }}">
                                                    @csrf
                                                    <div class="form-group row">
                                                        <label for="kode_barang" class="col-sm-4 col-form-label">{{ __('Kode Bekal') }} :</label>
                                                        <div class="col-sm-7">
                                                            <input type="text" class="form-control form-control-sm" name="kode_barang" id="kode_barang" required>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <input type="hidden" class="form-control" name="id" required>
                                                        <label for="edit-nama" class="col-sm-4 col-form-label">{{ __('Nama') }} :</label>
                                                        <div class="col-sm-7">
                                                            <input type="text" class="form-control form-control-sm" name="nama" id="edit-nama" required>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="edit-kode_barcode" class="col-sm-4 col-form-label">{{ __('Kode_Barcode') }} :</label>
                                                        <div class="col-sm-7">
                                                            <input type="text" class="form-control form-control-sm" name="kode_barcode"id="edit-kode_barcode" required>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="edit-keterangan" class="col-sm-4 col-form-label">{{ __('Keterangan') }} :</label>
                                                        <div class="col-sm-7">
                                                            <input type="text" class="form-control form-control-sm" name="keterangan" id="edit-keterangan" >
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="edit-id_kategori" class="col-sm-3 col-form-label">{{ __('Kategori') }} :</label>
                                                        <div class="col-sm-8">
                                                            <select class="custom-select js-example-basic-single form-control" name="id_kategori" id="edit-id_kategori">
                                                                <option></option>
                                                                @foreach ($kategori as $k)
                                                                    <option value="{{ $k->id }}">{{ $k->nama }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="edit-id_satuan" class="col-sm-3 col-form-label">{{ __('Satuan') }} :</label>
                                                        <div class="col-sm-8">
                                                            <select class="custom-select js-example-basic-single form-control" name="id_satuan" id="edit-id_satuan">
                                                                <option></option>
                                                                @foreach ($satuan as $s)
                                                                    <option value="{{ $s->id }}">{{ $s->nama }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <!-- <div class="form-group row">
                                                        <label for="edit-location" class="col-sm-2 col-form-label">{{ __('Location') }} :</label>
                                                        <div class="col-sm-10">
                                                            <select class="custom-select js-example-basic-single form-control" name="location" id="edit-location">
                                                                <option></option>
                                                                @foreach (config('business')->locations as $location)
                                                                    <option value="{{ $location->id }}">{{  config('business.name') . ' - ' . $location->nama . "( $location->location_id )" }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div> -->
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
                                {{-- End Modal Create Bekal --}}
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
        $('#edit-barang').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var id = button.data('id');
            var kode_barang = button.data('kode_barang');
            var nama = button.data('nama');
            var kode_barcode = button.data('kode_barcode');
            var keterangan = button.data('keterangan');
            var id_kategori = button.data('id_kategori');
            var id_satuan = button.data('id_satuan');
            var modal = $(this);
            
            modal.find('input[name="id"]').val(id);
            modal.find('input[name="kode_barang"]').val(kode_barang);
            modal.find('input[name="nama"]').val(nama);
            modal.find('input[name="kode_barcode"]').val(kode_barcode);
            modal.find('input[name="keterangan"]').val(keterangan);
            modal.find('select[name="id_kategori"]').val(id_kategori);
            modal.find('select[name="id_kategori"]').change();
            modal.find('select[name="id_satuan"]').val(id_satuan);
            modal.find('select[name="id_satuan"]').change();
        });

        var barangTable = $('#barang-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ url('barang') }}",
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex' },
                { data: 'kode_barang', name: 'kode_barang' },
                { data: 'nama', name: 'nama' },
                { data: 'kode_barcode', name: 'kode_barcode' },
                { data: 'keterangan', name: 'keterang' },
                { data: 'nama_kategori', name: 'nama_kategori' },
                { data: 'nama_satuan', name: 'nama_satuan' },
                { data: 'actions', name: 'actions', orderable:false, searching:false, visible:permission  }
            ],
        });

        barangTable.on('error', function () { 
            console.log('DataTables - Ajax Barang Error ' );
            barangTable.ajax.reload();
        });

        $('#id_kategori').select2({
            placeholder: "{{ __('Choose Kategori...') }}",
            dropdownParent: $('#create-barang')
        });
        $('#edit-id_kategori').select2({
            placeholder: "{{ __('Choose Kategori...') }}",
            dropdownParent: $('#edit-barang')
        });
       
        $('#id_satuan').select2({
            placeholder: "{{ __('Choose Satuan...') }}",
            dropdownParent: $('#create-barang')
        });
        $('#edit-id_satuan').select2({
            placeholder: "{{ __('Choose Satuan...') }}",
            dropdownParent: $('#edit-barang')
        });

    });
</script>
@endpush