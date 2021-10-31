
<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('business.name', config('app.name')) }} | {{ $title ?? '' }}@yield('title')</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600" rel="stylesheet">
    
    <!-- Styles -->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/template.css') }}">
    <link  href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
    @toastr_css

    <script type="text/javascript" src="{{ asset('js/app.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/template.js') }}"></script>
    <script src="{{ asset('js/script.js') }}"></script>
    <script src="{{ asset('js/pcoded.min.js') }}"></script>
    <script src="{{ asset('js/vartical-demo.js') }}"></script>

    <!-- Favicon icon -->
    <link rel="icon" href="{{ asset('uploads/' . config('business')->icon   ) }}" type="image/x-icon">

</head>
<body>
    <div id="app">
        <div class="container">
            <div class="card">
                <div class="card-header">
                    <h3 class="text-center">Detail Bekal Keluar</h3>
                    <br><br><br>
                    <table class="pull-left">
                        <thead>
                            <tr>
                                <th>Nomor Surat </th>
                                <th> : {{ $data->nomor_surat ?? '-' }}</th>
                            </tr>
                            <tr>
                                <th>Nomor Nota Dinas </th>
                                <th> : {{ $data->nomor_nota_dinas ?? '-' }}</th>
                            </tr>
                            <tr>
                                <th>Nomor BA </th>
                                <th> : {{ $data->nomor_ba ?? '-' }}</th>
                            </tr>
                            <tr>
                                <th>Nomor SA </th>
                                <th> : {{ $data->nomor_sa ?? '-' }}</th>
                            </tr>
                        </thead>
                    </table>
                    <table class='pull-right'>
                        <thead>
                            <tr>
                                <th>Tahun Anggaran </th>
                                <th> : {{ $data->tahun_anggaran ?? '-' }}</th>
                            </tr>
                            <tr>
                                <th>Tanggal Input </th>
                                <th> : {{ $data->tanggal_input ?? '-' }}</th>
                            </tr>
                            <tr>
                                <th>Gudang </th>
                                <th> : {{ $data->gudang->nama ?? '-' }}</th>
                            </tr>
                            <tr>
                                <th>Satkai </th>
                                <th> : {{ $data->satuan_pemakai->nama ?? '-' }}</th>
                            </tr>
                        </thead>
                    </table>
                </div>
                <div class="card-block ">
                    <table class="table" id="barang_masuk-table">
                        <thead>
                            <tr>
                                <th>{{ __('Nama Bekal') }}</th>   
                                <th>{{ __('Harga (IDR)') }}</th> 
                                <th>{{ __('Tahun Anggaran') }}</th> 
                                <th>{{ __('Jumlah Bekal') }}</th> 
                                <th>{{ __('Keterangan') }}</th> 
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ( $data->details as $det )
                                <tr>
                                    <td>{{ $det->barang->nama }}</td>
                                    <td>{{ $det->harga }}</td>
                                    <td>{{ $det->tahun_anggaran }}</td>
                                    <td>{{ $det->jumlah }} {{  $det->barang->satuan->nama }}</td>
                                    <td>{{ $det->keterangan }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
            
    </div>
</body>
<script>
    $(document).ready(function(){
        window.print();  
    });
</script>