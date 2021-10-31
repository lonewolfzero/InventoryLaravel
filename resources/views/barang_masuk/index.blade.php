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
                            @can('barang_masuk.create')
                                <a href="{{ route('barang_masuk.create') }}"> <button class="btn btn-success btn-round btn-sm mb-2"><i class="ti-plus"></i>{{ __('Tambah') }}</button> </a>
                            @endcan
                            <table class="table w-100" id="barang_masuk-table">
                                <thead>
                                    <tr>
                                        <th>{{ __('No') }}</th> 
                                        <th>{{ __('Nomor BA') }}</th> 
                                        <th>{{ __('Nomor Kontrak') }}</th> 
                                        <th>{{ __('Nomor KPH') }}</th> 
                                        <th>{{ __('Nomor Surat') }}</th> 
                                        <th>{{ __('Tahun Anggaran') }}</th> 
                                        <th>{{ __('Tanggal Input') }}</th> 
                                        <th>{{ __('Keterangan') }}</th>
                                        <th>{{ __('Gudang') }}</th> 
                                        <th>{{ __('Mitra') }}</th>
                                        @php $permission = false; @endphp
                                        @if ( auth()->user()->hasPermission('barang_masuk.detail') || auth()->user()->hasPermission('barang_masuk.update') || auth()->user()->hasPermission('barang_masuk.delete') )
                                            @php $permission = true; @endphp
                                            <th width="30%">{{ __('Action') }}</th>
                                        @endif
                                    </tr>
                                </thead>
                            </table>
                            <div class="pull-right">
                            </div>

                            @can('barang_masuk.detail')
                                <div class="modal fade" id="detail-barang_masuk" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">{{ __('Bekal Masuk') }}</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body" id="modal-body">
                                              
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('Close') }}</button>
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

        var barangMasukTable = $('#barang_masuk-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ url('barang_masuk') }}",
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex' },
                { data: 'nomor_ba', name: 'nomor_ba' },
                { data: 'nomor_kontrak', name: 'nomor_kontrak' },
                { data: 'nomor_kph', name: 'nomor_kph' },
                { data: 'nomor_surat', name: 'nomor_surat' },
                { data: 'tahun_anggaran', name: 'tahun_anggaran' },
                { data: 'tanggal_input', name: 'tanggal_input' },
                { data: 'keterangan', name: 'keterang' },
                { data: 'gudang', name: 'gudang' },
                { data: 'rekanan', name: 'rekanan' },
                { data: 'actions', name: 'actions', orderable:false, searching:false, visible:permission  }
            ],
            "createdRow": function(row, data){
                $(row).find(' button.detail-barang_masuk').click(function(e){
                    console.log($(this));
                    $.ajax({
                        url: "{{ url('barang_masuk/detail') }}/" + $(this).data('id'),
                        type: 'get',
                        dataType: 'html',
                        success: function(data){
                            $('.modal#detail-barang_masuk #modal-body').html(data);
                        }
                    });
                    $('.modal#detail-barang_masuk').modal('toggle');
                });
                console.log('created');
            }
        });

        barangMasukTable.on('error', function () { 
            console.log('DataTables - Ajax Barang Masuk Error ' );
            barangMasukTable.ajax.reload();
        });
    });
</script>
@endpush 