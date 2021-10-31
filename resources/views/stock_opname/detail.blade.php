<div class="container">
    <div class="table-responsive">
        <table class="table" id="detail_stock_opname-table">
            <thead>
                <tr>
                    <th>{{ __('Nama Bekal') }}</th>   
                    <th>{{ __('Tahun Anggaran') }}</th> 
                    <th>{{ __('Harga (IDR)') }}</th> 
                    <th>{{ __('Stock Sebelumnya') }}</th> 
                    <th>{{ __('Jumlah Bekal') }}</th> 
                    <th>{{ __('Implikasi Quantitif') }}</th> 
                    <th>{{ __('Keterangan') }}</th> 
                </tr>
            </thead>
            <tbody>
                @if ( empty($data) || count($data) < 1 )
                    <tr>
                        <td colspan="4" class="text-center">Tidak ada data</td>
                    </tr>
                @endif
                @foreach ($data as $detail)
                    <tr>
                        <td>{{ $detail->barang->nama ?? '-' }}</td>
                        <td>{{ $detail->tahun_anggaran ?? '-' }}</td>
                        <td>{{ number_format($detail->harga,2,',','.') ?? '-' }}</td>
                        <td>{{ $detail->stock_sebelumnya ?? '-' }}</td>
                        <td>{{ $detail->jumlah ?? '-' }}</td>
                        <td>{{ $detail->implikasi_quantitif ?? '-' }}</td>
                        <td>{{ $detail->keterangan ?? '-' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>