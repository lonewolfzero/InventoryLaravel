<div class="col-md-6 col-xl-3" id="transaksi_masuk_tanpa_ba">
    <div class="card bg-c-green order-card text-white">
        <div class="card-block">
            <h6 class="m-b-20" style="min-height: 30px;"></h6>
            <h2 class="text-right"><span class="f-left"></span><i class="text-white"></i></h2>
            <a href="{{ route('barang_masuk.index') }}" class="text d-flex justify-content-center align-items-center text-white"><span>Info Lebih Lanjut</span><i class="ti-arrow-right" style="font-size: 10px;"></i></a>
        </div>
    </div>
</div>

@push('scripts')
@include('partials.functions')
<script>
    $(document).ready(function(){

        loadDashboard("transaksi_masuk_tanpa_ba");
        setInterval(function(){
            loadDashboard("transaksi_masuk_tanpa_ba");
        }, 300000);
    });
</script>
@endpush