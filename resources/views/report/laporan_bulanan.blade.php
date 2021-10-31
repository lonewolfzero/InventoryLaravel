@extends('layouts.app')

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
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="text-secondary" for="">Gudang</label>
                                                <select class="form-control form-control-md" name="id_gudang" id="id_gudang">
                                                    <option value="">--{{ __('Pilih Gudang') }}--</option>
                                                    @foreach ($gudang as $g)
                                                        @if( $loop->first )
                                                            <option value="{{ $g->id }}" selected> {{ $g->nama }} </option>
                                                        @else
                                                            <option value="{{ $g->id }}"> {{ $g->nama }} </option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="text-secondary" for="">Bulan dan Tahun</label>
                                                <input class="form-control form-control-md" type="month" name="tahun_bulan" id="tahun_bulan" value="{{ date("Y-m") }}">
                                            </div>
                                        </div>
                                        <div class="col-md-4 text-center align-self-md-center">
                                            <button type="button" id="filtering-report" class="btn btn-sm btn-primary m-1"><i class="ti-filter"></i> Filter</button>
                                            <button type="reset" id="reset-filtering" class="btn btn-sm btn-secondary m-1"><i class="ti-reload"></i> Reset</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <div class="container my-4">
                                <form class="border-bottom border-primary p-2 rounded-top">
                                    <small>{{ __('* Isi ini jika ingin print data dengan Nama serta Jabatan Pen-Tanda Tangan.') }}</small>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="text-secondary" for="">{{ __('Nama Tanda Tangan Kiri') }}</label>
                                                <input class="form-control form-control-md" type="text" id="nama-tanda-tangan-1">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="text-secondary" for="">{{ __('Jabatan Tanda Tangan Kiri') }}</label>
                                                <input class="form-control form-control-md" type="text" id="jabatan-tanda-tangan-1">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="text-secondary" for="">{{ __('Nama Tanda Tangan Kanan') }}</label>
                                                <input class="form-control form-control-md" type="text" id="nama-tanda-tangan-2">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="text-secondary" for="">{{ __('Jabatan Tanda Tangan Kanan') }}</label>
                                                <input class="form-control form-control-md" type="text" id="jabatan-tanda-tangan-2">
                                            </div>
                                        </div>
                                        {{-- <div class="col-md-4 text-center align-self-md-center">
                                            <button type="button" id="set-value-signature" class="btn btn-sm btn-primary m-1"><i class="ti-filter"></i> Filter</button>
                                            <button type="reset" id="reset-value-signature" class="btn btn-sm btn-secondary m-1"><i class="ti-reload"></i> Reset</button>
                                        </div> --}}
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="card-block table-border-style">
                                <table class="table w-100" id="laporan_bulanan-table">
                                    <thead>
                                        <tr>
                                            <th>{{ __('No') }}</th>   
                                            <th>{{ __('Nama Bekal') }}</th>   
                                            <th>{{ __('Satuan') }}</th> 
                                            <th>{{ __('TH PA') }}</th> 
                                            <th>{{ __('Tgl P`Awal') }}</th> 
                                            <th>{{ __('Jumlah P`Awal') }}</th> 
                                            <th>{{ __('No Bukti (M)') }}</th> 
                                            <th>{{ __('Jumlah (M)') }}</th> 
                                            <th>{{ __('No Bukti (K)') }}</th> 
                                            <th>{{ __('Jumlah (K)') }}</th> 
                                            {{-- <th>{{ __('Nomor Bukti Stock Opname') }}</th> 
                                            <th>{{ __('Jumlah Stock Opname') }}</th>  --}}
                                            {{-- <th>{{ __('Jumlah') }}</th>  --}}
                                            <th>{{ __('Jumlah P`Akhir') }}</th> 
                                            <th>{{ __('Harga (Rp)') }}</th> 
                                            <th>{{ __('Jumlah Harga (Rp)') }}</th> 
                                            <th>{{ __('Keterangan') }}</th> 
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

        $.fn.dataTable.ext.errMode = 'throw';

        let id_gudang = $('select[name="id_gudang"]').val();
        let tahun_bulan = $('input[name="tahun_bulan"]').val();
        let tahun = tahun_bulan.split("-")[0];
        let bulan = tahun_bulan.split("-")[1];

        var LaporanBulananTable = $('#laporan_bulanan-table').DataTable({
            processing: true,
            serverSide: true,
            order: [[ 0, "asc" ]],
            ajax: {
            //     // data : [
            //     //     {id_gudang: 0},
            //     //     {start: 0},
            //     //     {end: 0},
            //     // ],
            //     data : [
            //         {id_gudang: id_gudang},
            //         {tahun: tahun},
            //         {bulna: bulan},
            //     ],
                url :"{{ url('report/laporan_bulanan') }}?id_gudang=" + id_gudang + "&tahun=" + tahun + "&bulan=" + bulan,
            },
            buttons:[
                { extend: 'print',
                title: '',
                messageTop: function(){
                    if ( $('select#id_gudang').val() != '' ){
                        id_gudang = $('#id_gudang').val();
                        gudang = $('#id_gudang option[value="' + id_gudang + '"]').html();
                        html_gudang = `<tr> <td>Gudang</td> <td>: ${gudang}</td></tr>`;

                    }else {
                        html_gudang = ``;
                    }
                    
                    if ( $('input[name="tahun_bulan"]').length > 0 ){
                        var months = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
                        let tahun_bulan = $('input[name="tahun_bulan"]').val();
                        let tahun = tahun_bulan.split("-")[0];
                        let bulan = months[tahun_bulan.split("-")[1] * 1 - 1];

                        html_tahun_bulan = `<tr> <td>Bulan dan Tahun </td> <td>: ${bulan}, ${tahun}</td></tr>`;
                    }else {
                        html_tahun_bulan = ``;
                    }

                    title = document.title.split(' | ')[1];

                    return `<div><h4>PUSAT PEMBEKALAN ANGKUTAN TNI AD <br> GUDANG PUSAT PEMBEKALAN ANGKUTAN - 1 </h4></div>
                    <div style="position: relative;">
                        <div style="position: relative; margin-left:40%;">
                            <br>
                            <h5>${title}</h5>
                            <table>
                                ${html_gudang}
                                ${html_tahun_bulan}
                            </table>
                            <br>
                        </div>
                    </div>`;
                },
                messageBottom: function(){
                    return `<div><br> Tanggal Print : ${dateTime}</div>
                    <div>
                        <div style="float:left; width:400px; text-align:center;">
                            <br><br><br><br><br>
                            ${$('input#jabatan-tanda-tangan-1').val()}
                            <br><br><br><br><br><br>
                            ${$('input#nama-tanda-tangan-1').val()}
                        </div>
                        <div style="float:right; width:400px; text-align:center;">
                            <br><br><br><br><br>
                            ${$('input#jabatan-tanda-tangan-2').val()}
                            <br><br><br><br><br><br>
                            ${$('input#nama-tanda-tangan-2').val()}
                        </div>
                    </div>`;
                },
                // exportOptions:
                //     { columns: [':visible :not(:last-child)'] },
                customize: function(win)
                {
    
                    var last = null;
                    var current = null;
                    var bod = [];
    
                    var css = '@page { size: landscape;} body{ zoom: 50%;}',
                        head = win.document.head || win.document.getElementsByTagName('head')[0],
                        style = win.document.createElement('style');
    
                    style.type = 'text/css';
                    style.media = 'print';
    
                    if (style.styleSheet)
                    {
                    style.styleSheet.cssText = css;
                    }
                    else
                    {
                    style.appendChild(win.document.createTextNode(css));
                    }
    
                    head.appendChild(style);
                }            
            },
            { extend: 'excel', 
                messageBottom: function(){
                    return 'Tanggal Print : ' + dateTime;
                },
                exportOptions:
                    { columns: [':visible :not(:last-child)'] }
            },
            { extend: 'csv', 
                messageBottom: function(){
                    return 'Tanggal Print : ' + dateTime;
                },
                exportOptions:
                { columns: [':visible :not(:last-child)'] }
            },
            { extend: 'copy',
                messageBottom: function(){
                    return 'Tanggal Print : ' + dateTime;
                },
                exportOptions:
                { columns: [':visible :not(:last-child)'] }
            },            ],
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex' },
                { data: 'nama_barang', name: 'nama_barang' },
                { data: 'satuan', name: 'satuan' },
                { data: 'tahun_anggaran', name: 'tahun_anggaran' },
                { data: 'tanggal', name: 'tanggal' },
                { data: 'jumlah_stock_awal', name: 'jumlah_stock_awal' },
                { data: 'nomor_bukti_penerimaan', name: 'nomor_bukti_penerimaan' },
                { data: 'jumlah_penerimaan', name: 'jumlah_penerimaan' },
                { data: 'nomor_bukti_pengeluaran', name: 'nomor_bukti_pengeluaran' },
                { data: 'jumlah_pengeluaran', name: 'jumlah_pengeluaran' },
                { data: 'jumlah', name: 'jumlah' },
                // { data: 'persediaan_akhir_bulan', name: 'persediaan_akhir_bulan' },
                { data: 'harga_satuan', name: 'harga_satuan' },
                { data: 'jumlah_harga', name: 'jumlah_harga' },
                { data: 'keterangan', name: 'keterangan' },
            ],
            "createdRow": function(row, data){
                // console.log('created');
            }
        });

        $('#filtering-report').on('click', function(e){
            if ( $('select[name="id_gudang"]').val() == '' || $('input[name="tahun_bulan"]').val() == '' ){
                return false;
            }

            let id_gudang = $('select[name="id_gudang"]').val();
            let tahun_bulan = $('input[name="tahun_bulan"]').val();
            let tahun = tahun_bulan.split("-")[0];
            let bulan = tahun_bulan.split("-")[1];

            // console.log("{{ url('report/laporan_bulanan') }}?id_gudang=" + id_gudang + "&tahun=" + tahun + "&bulan=" + bulan);
            LaporanBulananTable.ajax.url("{{ url('report/laporan_bulanan') }}?id_gudang=" + id_gudang + "&tahun=" + tahun + "&bulan=" + bulan).load();
        });
        
        $('#reset-filtering').on('click', function(e){
            this.form.reset();

            let id_gudang = $('select[name="id_gudang"]').val();
            let tahun_bulan = $('input[name="tahun_bulan"]').val();
            let tahun = tahun_bulan.split("-")[0];
            let bulan = tahun_bulan.split("-")[1];

            // console.log("{{ url('report/laporan_bulanan') }}?id_gudang=" + id_gudang + "&tahun=" + tahun + "&bulan=" + bulan);
            LaporanBulananTable.ajax.url("{{ url('report/laporan_bulanan') }}?id_gudang=" + id_gudang + "&tahun=" + tahun + "&bulan=" + bulan).load();

            // return false;
        });

        LaporanBulananTable.on('error', function () { 
            console.log('DataTables - Ajax Laporan Bulanan Error ' );
            LaporanBulananTable.ajax.reload();
        });
    });
</script>
@endpush 