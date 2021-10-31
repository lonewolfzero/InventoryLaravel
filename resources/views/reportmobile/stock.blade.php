@extends('layouts.appreport')

@section('content')
<div class="main-body">
    <div class="page-wrapper">

        <div class="page-body">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            {{-- <div class="card-header-right">
                                <ul class="list-unstyled card-option">
                                    <li><i class="fa fa-chevron-left"></i></li>
                                    <li><i class="fa fa-window-maximize full-card"></i></li>
                                    <li><i class="fa fa-minus minimize-card"></i></li>
                                    <li><i class="fa fa-refresh reload-card"></i></li>
                                </ul>
                            </div> --}}
                            <div class="container">
                                <form class="border-bottom border-primary p-2 rounded-top">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <div class="form-group">
                                                <label class="text-secondary" for="">Gudang</label>
                                                <select class="form-control form-control-md" name="id_gudang" id="id_gudang">
                                                    <option value="">--{{ __('Pilih Gudang') }}--</option>
                                                    @foreach ($gudang as $g)
                                                        <option value="{{ $g->id }}"> {{ $g->nama }} </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        {{-- <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="text-secondary" for="">Date Range</label>
                                                <div id="reportrange" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
                                                    <span class="text-secondary">Y-m-d - Y-M-d</span> 
                                                </div>
                                            </div>
                                        </div> --}}
                                        <div class="col-md-4 text-center align-self-md-center">
                                            <button type="button" id="filtering-report" class="btn btn-sm btn-primary m-1"><i class="ti-filter"></i> Filter</button>
                                            <button type="reset" id="reset-filtering" class="btn btn-sm btn-secondary m-1"><i class="ti-reload"></i> Reset</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="card-block table-border-style">
                            <table class="table w-100" id="stock-table">
                                <thead>
                                    <tr>
                                        <th>{{ __('Gudang') }}</th>   
                                        <th>{{ __('Bekal') }}</th> 
                                        <th>{{ __('Tahun Anggaran') }}</th> 
                                        <th>{{ __('Harga (IDR)') }}</th> 
                                        {{-- <th>{{ __('Tanggal') }}</th> 
                                        <th>{{ __('Jumlah Bekal') }}</th> 
                                        <th>{{ __('Stock') }}</th>
                                        <th>{{ __('Stock Sebelumnya') }}</th>
                                        <th>{{ __('Balance') }}</th> --}}
                                        <th>{{ __('Stock Akhir') }}</th>
                                    </tr>
                                </thead>
                            </table>
                            <div class="pull-right">
                            </div>

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

        var stockTable = $('#stock-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                data : [
                    {id_gudang: 0},
                    {start: 0},
                    {end: 0},
                ],
                url :"{{ url('reportmobile/stock') }}",
            },
            columns: [
                { data: 'gudang', name: 'gudang' },
                { data: 'barang', name: 'barang' },
                { data: 'tahun_anggaran', name: 'tahun_anggaran' },
                { data: 'harga', name: 'harga' },
                // { data: 'tanggal', name: 'tanggal' },
                // { data: 'jum', name: 'jum' },
                // { data: 'stock', name: 'stock' },
                // { data: 'stock_sb', name: 'stock_sb' },
                // { data: 'balance', name: 'balance' },
                { data: 'stock_akhir', name: 'stock_akhir' },
            ],
            "createdRow": function(row, data){
                // console.log('created');
            }
        });

        var start = moment().subtract(30, 'days');
        var end = moment();

        function cb(start, end) {
            $('#reportrange span').html(start.format('YYYY-MM-DD') + ' - ' + end.format('YYYY-MM-DD'));
        }

        $('#reportrange').daterangepicker({
            startDate: start,
            endDate: end,
            ranges: {
                'Today': [moment(), moment()],
                'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                'This Month': [moment().startOf('month'), moment().endOf('month')],
                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            }
        }, cb);

        $('#filtering-report').on('click', function(e){
            let startDate = $('#reportrange').data('daterangepicker').startDate.format('YYYY-M-D');
            let endDate = $('#reportrange').data('daterangepicker').endDate.format('YYYY-M-D');
            let id_gudang = $('select[name="id_gudang"]').val();

            if ( startDate == 'Invalid date' ){
                startDate = '';
            }
            if ( endDate == 'Invalid date' ){
                endDate = '';
            }

            stockTable.ajax.url("{{ url('reportmobile/stock') }}?startDate=" + startDate + "&endDate=" + endDate + "&id_gudang=" + id_gudang).load();
        });

        cb(start, end);

        $('#reset-filtering').on('click', function(e){
            cb(start, end);
            barangMasukTable.ajax.url("{{ url('reportmobile/nota_dinas') }}").load();
        });

    });
</script>
@endpush 