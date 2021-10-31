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
                            @can('satuan_pemakai.create')
                                <button class="btn btn-success btn-round btn-sm mb-2" data-toggle="modal" data-target="#create-satuan_pemakai"><i class="ti-plus"></i>{{ __('Tambah') }}</button>
                            @endcan
                            <table class="table w-100" id="satuan_pemakai-table">
                                <thead>
                                    <tr>
                                        <th>{{ __('No') }}</th>
                                        <th>{{ __('Nama') }}</th>
                                        <th>{{ __('Pic') }}</th>
                                        <th>{{ __('Nomor Telephone') }}</th>
                                        <th>{{ __('Contact person') }}</th>
                                        <th>{{ __('Keterangan') }}</th>
                                        @php $permission = false; @endphp
                                        @if ( auth()->user()->hasPermission('satuan_pemakai.update') || auth()->user()->hasPermission('satuanpemakai.delete') )
                                            @php $permission = true; @endphp
                                            <th width="30%">{{ __('Action') }}</th>
                                        @endif
                                    </tr>
                                </thead>
                            </table>
                            <div class="pull-right">
                            </div>

                            @can('satuan_pemakai.create')
                                
                                <div class="modal fade" id="create-satuan_pemakai" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">{{ __('Tambah Satuan Pemakai') }}</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form method="POST"   onsubmit="return checkBeforeSubmit()" action="{{ route('satuan_pemakai.store') }}">
                                                    @csrf
                                                    <div class="form-group row">
                                                        <label for="nama" class="col-sm-3 col-form-label">{{ __('Nama') }} :</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control form-control-sm" name="nama" id="nama" required>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="pic" class="col-sm-3 col-form-label">{{ __('Pic') }} :</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control form-control-sm" name="pic" id="pic" required>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="nomor_telephone" class="col-sm-4 col-form-label">{{ __('Nomor Telephone') }} :</label>
                                                        <div class="col-sm-7">
                                                            <input type="number" class="form-control form-control-sm" name="nomor_telephone" id="nomor_telephone" required>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="contact_person" class="col-sm-4 col-form-label">{{ __('Contact person') }} :</label>
                                                        <div class="col-sm-7">
                                                            <input type="number" class="form-control form-control-sm" name="contact_person" id="contact_person" required>
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
                                {{-- End Modal Create Satuan Pemakai --}}
                            @endcan

                            @can('satuan_pemakai.update')
                                {{-- Modal Edit Satuan Pemakai --}}
                                <div class="modal fade" id="edit-satuan_pemakai" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">{{ __('Edit Satuan Pemakai') }}</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form method="POST"   onsubmit="return checkBeforeSubmit()" action="{{ route('satuan_pemakai.update') }}">
                                                    @csrf
                                                    <div class="form-group row">
                                                        <input type="hidden" class="form-control" name="id" required>
                                                        <label for="edit-nama" class="col-sm-3 col-form-label">{{ __('Nama') }} :</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control form-control-sm" name="nama" id="edit-nama" required>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <input type="hidden" class="form-control" name="id" required>
                                                        <label for="edit-pic" class="col-sm-3 col-form-label">{{ __('Pic') }} :</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control form-control-sm" name="pic" id="edit-pic" required>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="nomor_telephone" class="col-sm-4 col-form-label">{{ __('Nomor Telephone') }} :</label>
                                                        <div class="col-sm-7">
                                                            <input type="number" class="form-control form-control-sm" name="nomor_telephone" id="nomor_telephone" required>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <input type="hidden" class="form-control" name="id" required>
                                                        <label for="edit-contact_person" class="col-sm-4 col-form-label">{{ __('Contact person') }} :</label>
                                                        <div class="col-sm-7">
                                                            <input type="number" class="form-control form-control-sm" name="contact_person" id="edit-contact_person" required>
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
                                {{-- End Modal Create Satuan Pemakai --}}
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
        $('#edit-satuan_pemakai').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var id = button.data('id');
            var nama = button.data('nama');
            var pic = button.data('pic');
            var nomor_telephone = button.data('nomor_telephone');
            var contact_person = button.data('contact_person');
            var keterangan = button.data('keterangan');
            var modal = $(this);
            
            modal.find('input[name="id"]').val(id);
            modal.find('input[name="nama"]').val(nama);
            modal.find('input[name="pic"]').val(pic);
            modal.find('input[name="nomor_telephone"]').val(nomor_telephone);
            modal.find('input[name="contact_person"]').val(contact_person);
            modal.find('input[name="keterangan"]').val(keterangan);
            
        });

        var permission = "{{$permission}}";
        var satuanpemakaiTable = $('#satuan_pemakai-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ url('satuan_pemakai') }}",
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex' },
                { data: 'nama', name: 'nama' },
                { data: 'pic', name: 'pic' },
                { data: 'nomor_telephone', name: 'nomor_telephone' },
                { data: 'contact_person', name: 'contact_person' },
                { data: 'keterangan', name: 'keterangan' },
                { data: 'actions', name: 'actions', orderable:false, searching:false, visible:permission }
            ],
        });

        satuanpemakaiTable.on('error', function () { 
            console.log('DataTables - Ajax Satuan Pemakai Error ' );
            satuanpemakaiTable.ajax.reload();
        });

       
    });
</script>
@endpush