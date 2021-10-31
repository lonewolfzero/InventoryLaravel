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
                            @can('stock_opname.create')
                                <a href="{{ route('stock_opname.create') }}"> <button class="btn btn-success btn-round btn-sm mb-2"><i class="ti-plus"></i>{{ __('Tambah') }}</button> </a>
                            @endcan
                            <table class="table w-100" id="stock_opname-table">
                                <thead>
                                    <tr>
                                        <th>{{ __('No') }}</th>   
                                        <th>{{ __('Nomor Stock Opname') }}</th>   
                                        <th>{{ __('Tanggal Pelaksanaan') }}</th> 
                                        <th>{{ __('Gudang') }}</th> 
                                        @php $permission = false; @endphp
                                        @if ( auth()->user()->hasPermission('stock_opname.detail') || auth()->user()->hasPermission('stock_opname.update') || auth()->user()->hasPermission('stock_opname.delete') )
                                            @php $permission = true; @endphp
                                            <th width="30%">{{ __('Action') }}</th>
                                        @endif
                                    </tr>
                                </thead>
                            </table>
                            <div class="pull-right">
                            </div>

                            @can('stock_opname.detail')
                                <div class="modal fade" id="detail-stock_opname" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">{{ __('Stock Opname') }}</h5>
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

        var stockOpnameTable = $('#stock_opname-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ url('stock_opname') }}",
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex' },
                { data: 'nomor_stock_opname', name: 'nomor_stock_opname' },
                { data: 'tanggal_pelaksanaan', name: 'tanggal_pelaksanaan' },
                { data: 'gudang', name: 'gudang' },
                { data: 'actions', name: 'actions', orderable:false, searching:false, visible:permission  }
            ],
            "createdRow": function(row, data){
                $(row).find(' button.detail-stock_opname').click(function(e){
                    $.ajax({
                        url: "{{ url('stock_opname/detail') }}/" + $(this).data('id'),
                        type: 'get',
                        dataType: 'html',
                        success: function(data){
                            $('.modal#detail-stock_opname #modal-body').html(data);
                        }
                    });
                    $('.modal#detail-stock_opname').modal('toggle');
                });
            }
        });

        StockOpanme.on('error', function () { 
            console.log('DataTables - Ajax Stock Opname Error ' );
            StockOpanme.ajax.reload();
        });

    });
</script>
@endpush 