<div class="container">
    <div class="table-responsive">
        <table class="table" id="detail_barang_keluar-table">
            <thead>
                <tr>
                    <th>{{ __('Nama Bekal') }}</th>   
                    <th>{{ __('Tahun Anggaran') }}</th> 
                    <th>{{ __('Jumlah Bekal') }}</th> 
                    <th>{{ __('Harga (IDR)') }}</th> 
                    <th>{{ __('Keterangan') }}</th> 
                </tr>
            </thead>
            <tbody>
                @if ( empty($data->details) || count($data->details) < 1 )
                    <tr>
                        <td colspan="4" class="text-center">Tidak ada data</td>
                    </tr>
                @endif
                @foreach ($data->details as $detail)
                    <tr>
                        <td>{{ $detail->barang->nama ?? '-' }}</td>
                        <td>{{ $detail->tahun_anggaran ?? '-' }}</td>
                        <td>{{ $detail->jumlah ?? '-' }} {{ $detail->barang->satuan->nama ?? '-' }}</td>
                        <td>{{ number_format($detail->harga,2,',','.') ?? '-' }}</td>
                        <td>{{ $detail->keterangan ?? '-' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>