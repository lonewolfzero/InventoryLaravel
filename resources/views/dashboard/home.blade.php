@extends('layouts.app')

@section('content')
<div class="main-body">
    <div class="page-wrapper">
    
        {{-- <!-- Page-header start -->
        <div class="page-header card">
            <div class="card-block">
                <h5 class="m-b-10">User Page</h5>
                <p class="text-muted m-b-10">lorem ipsum dolor sit amet, consectetur adipisicing elit</p>
                <ul class="breadcrumb-title b-t-default p-t-10">
                    <li class="breadcrumb-item">
                        <a href="index.html"> <i class="fa fa-home"></i> </a>
                    </li>
                        <li class="breadcrumb-item"><a href="#!">Pages</a>
                            </li>
                            <li class="breadcrumb-item"><a href="#!">Sample page</a>
                            </li>
                </ul>
            </div>
        </div>
        <!-- Page-header end -->
         --}}

        <div class="page-body">
            <div class="row">
                
                @can('dashboard.nota_dinas')
                    @include('dashboard.nota_dinas_keluar_belum_bersurat')
                @endcan

                @can('dashboard.transaksi_masuk')
                    @include('dashboard.transaksi_masuk')
                @endcan

                @can('dashboard.transaksi_masuk_tanpa_ba')
                    @include('dashboard.transaksi_masuk_tanpa_ba')
                @endcan
                
                @can('dashboard.transaksi_keluar')
                    @include('dashboard.transaksi_keluar')
                @endcan

                @can('dashboard.transaksi_keluar_tanpa_ba')
                    @include('dashboard.transaksi_keluar_tanpa_ba')
                @endcan
              
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
@include('partials.functions')
<script>
    // $(document).ready(function(){
        function loadDashboard(key){
            $.ajax({
                url: "{{ url('dashboard') }}/",
                type: 'get',
                data: { _q: key },
                dataType: 'json',
                success: function(data){
                    console.log(data);
                    $('#'+key+' h6').text(data.judul);
                    $('#'+key+' h2 span').text(data.jumlah);
                    $('#'+key+' h2 i').addClass(data.icon);
                }
            });
        }
    // });/
</script>
@endpush
