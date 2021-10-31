@extends('layouts.app')

@section('content')
<div class="main-body">
    <div class="page-wrapper">
    
        <div class="page-body">
            <div class="row">
                <div class="col-sm-12">

                    <div class="card">
                        <div class="card-header">
                            <h4>Update - Bekal Keluar</h4>
                        </div>
                        <div class="card-block">
                            
                            <form action="{{ route('barang_keluar.update', ['id' => $barang_keluar->id]) }}" method="post"   onsubmit="return checkBeforeSubmit()">

                                @csrf
                                {{-- <input type="hidden" name="id" value="{{ $business->id }}"> --}}
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="nomor_surat" class="font-weight-bolder">{{ __('Nomor Surat') }}</label>
                                            <input type="text" class="form-control form-control-md" name="nomor_surat" id="nomor_surat" placeholder="{{ __('Nomor Surat') }}"  value="{{ $barang_keluar->nomor_surat }}"">
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="nomor_nota_dinas" class="font-weight-bolder">{{ __('Nomor Nota Dinas') }}</label>
                                            <input type="text" class="form-control form-control-md" name="nomor_nota_dinas" id="nomor_nota_dinas" placeholder="{{ __('Nomor Nota Dinas') }}"  value="{{ $barang_keluar->nomor_nota_dinas }}"">
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="nomor_ba" class="font-weight-bolder">{{ __('Nomor BA') }}</label>
                                            <input type="text" class="form-control form-control-md" name="nomor_ba" id="nomor_ba" placeholder="{{ __('Nomor BA') }}" value="{{ $barang_keluar->nomor_ba }}">
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="nomor_sa" class="font-weight-bolder">{{ __('Nomor SA') }}</label>
                                            <input type="text" class="form-control form-control-md" name="nomor_sa" id="nomor_sa" placeholder="{{ __('Nomor BA') }}" value="{{ $barang_keluar->nomor_sa }}">
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="tanggal_input" class="font-weight-bolder">{{ __('Tanggal Input') }}</label>
                                            <input type="date" class="form-control form-control-md" name="tanggal_input" id="tanggal_input" placeholder="{{ __('Tanggal Input') }}" value="{{ $barang_keluar->tanggal_input }}">
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="id_gudang" class="font-weight-bolder">{{ __('Gudang *') }}</label>
                                            <select class="form-control form-control-md" name="id_gudang" id="id_gudang" required>
                                                <option value="">--{{ __('Pilih Gudang') }}--</option>
                                                @foreach ($gudang as $g)
                                                    @if ( $g->id == $barang_keluar->id_gudang )
                                                        <option value="{{ $g->id }}" selected> {{ $g->nama }} </option>
                                                    @else
                                                        <option value="{{ $g->id }}" selected> {{ $g->nama }} </option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="id_satuan_pemakai" class="font-weight-bolder">{{ __('Satuan Pemakai *') }}</label>
                                            <select class="form-control form-control-md" name="id_satuan_pemakai" id="id_satuan_pemakai" required>
                                                <option value="">--{{ __('Pilih Satuan Pemakai') }}--</option>
                                                @foreach ($satuan_pemakai as $s)
                                                    @if ( $s->id == $barang_keluar->id_satuan_pemakai )
                                                        <option value="{{ $s->id }}" selected> {{ $s->nama }} </option>
                                                    @else
                                                        <option value="{{ $s->id }}"> {{ $s->nama }} </option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="keterangan" class="font-weight-bolder">{{ __('Keterangan') }}</label>
                                            <input type="text" class="form-control form-control-md" name="keterangan" id="keterangan" placeholder="{{ __('Keterangan') }}" value="{{ $barang_keluar->keterangan }}">
                                        </div>
                                    </div>

                                    <hr style=" border: 1px dashed #000; width: 100%; margin: auto; margin-top: 5%; margin-bottom: 1%">
                                    <div class="col-sm-12" id="form-detail">
                                        <h5 class="mb-4 text-center">Detail Bekal Keluar</h5>
                                        @foreach ($barang_keluar->details as $x => $det)
                                            <div class="row border-bottom border-primary p-2 my-4 rounded-top" id="row-{{ $x + 1 }}">
                                                <input type="hidden" name="id_detail[]" value="{{ $det->id }}">
                                                <div class="col-sm-5">
                                                    <div class="form-group">
                                                        <label for="id_barang[]" class="font-weight-bolder">{{ __('Bekal *') }}</label>
                                                        <select class="form-control form-control-md" name="id_barang[]" required>
                                                            <option value="">--{{ __('Pilih Bekal') }}--</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-sm-5">
                                                    <div class="form-group">
                                                        <label for="tahun_anggaran[]" class="font-weight-bolder">{{ __('Tahun Anggaran *') }}</label>
                                                        <input type="number" class="form-control form-control-md" name="tahun_anggaran[]" id="tahun_anggaran[]" placeholder="{{ __('Tahun Anggaran') }}"  value="{{ $det->tahun_anggaran }}" required>
                                                    </div>
                                                </div>
                                                <div class="col-sm-5">
                                                    <div class="form-group">
                                                        <label for="harga[]" class="font-weight-bolder">{{ __('Harga (IDR)') }}</label>
                                                        <input type="text" class="form-control form-control-md" name="harga[]" placeholder="{{ __('Harga (IDR)') }}" value="{{ $det->harga }}">
                                                    </div>
                                                </div>
                                                <div class="col-sm-5">
                                                    <div class="form-group">
                                                        <label for="jumlah[]" class="font-weight-bolder">{{ __('Jumlah Bekal') }}</label>
                                                        <input type="text" class="form-control form-control-md" name="jumlah[]" placeholder="{{ __('Jumlah Bekal') }}" value="{{ $det->jumlah }}">
                                                    </div>
                                                </div>
                                                <div class="col-sm-2">
                                                    <div class="form-group text-center">
                                                        <button type="button" class="btn btn-sm btn-danger delete-row" onclick=deleteRow(event) data-row="{{ $x + 1 }}">-</button>
                                                    </div>
                                                </div>
                                                <div class="col-sm-10">
                                                    <div class="form-group">
                                                        <label for="keterangan_detail" class="font-weight-bolder">{{ __('Keterangan') }}</label>
                                                        <input type="text" class="form-control form-control-md" name="keterangan_detail[]" placeholder="{{ __('Keterangan') }}" value="{{ $det->keterangan }}">
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="col-sm-12" orm-group">
                                        <button type="button" class="btn btn-sm btn-primary mx-1" id="add-row">+</button>
                                    </div>

                                    <div class="col-sm-12" id="tax-form-group">
                                        <button type="submit" class="btn btn-sm btn-success mx-1 pull-right">{{ __('Save') }}</button>

                                        <a href="{{ route('barang_keluar.index') }}"> <button type="button" class="btn btn-sm btn-secondary mx-1 pull-right">{{ __('Cancel') }}</button> </a>
                                    </div>
                                </div>

                            </form>

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
<script>
    $(document).ready(function(){

        $('#add-row').click(function(e){
            var row = $('#form-detail').find('.row').length;
            row++;
            if ( $('#form-detail #row-'+row).length > 0 ){
                var row_id = $('#form-detail').find('.row').last()[0].id;
                console.log(row_id);
                row = row_id.split('-')[1] * 1 + 1;
            }
            $('#form-detail').append(`<div class="row border-bottom border-primary p-2 my-4 rounded-top" id="row-${row}">
                                            <input type="hidden" name="id_detail[]" value="0">
                                            <div class="col-sm-5">
                                                <div class="form-group">
                                                    <label for="id_barang[]" class="font-weight-bolder">{{ __('Bekal *') }}</label>
                                                    <select class="form-control form-control-md" name="id_barang[]" required>
                                                        <option value="">--{{ __('Pilih Bekal') }}--</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-5">
                                                <div class="form-group">
                                                    <label for="tahun_anggaran[]" class="font-weight-bolder">{{ __('Tahun Anggaran *') }}</label>
                                                    <input type="number" class="form-control form-control-md" name="tahun_anggaran[]" id="tahun_anggaran[]" placeholder="{{ __('Tahun Anggaran') }}" required>
                                                </div>
                                            </div>
                                            <div class="col-sm-5">
                                                <div class="form-group">
                                                    <label for="harga[]" class="font-weight-bolder">{{ __('Harga (IDR)') }}</label>
                                                    <input type="text" class="form-control form-control-md" name="harga[]" placeholder="{{ __('Harga') }}">
                                                </div>
                                            </div>
                                            <div class="col-sm-5">
                                                <div class="form-group">
                                                    <label for="jumlah[]" class="font-weight-bolder">{{ __('Jumlah Bekal') }}</label>
                                                    <input type="text" class="form-control form-control-md" name="jumlah[]" placeholder="{{ __('Jumlah Bekal') }}">
                                                </div>
                                            </div>
                                            <div class="col-sm-2">
                                                <div class="form-group text-center">
                                                    <button type="button" class="btn btn-sm btn-danger delete-row" data-row="${row}">-</button>
                                                </div>
                                            </div>
                                            <div class="col-sm-10">
                                                <div class="form-group">
                                                    <label for="keterangan_detail" class="font-weight-bolder">{{ __('Keterangan') }}</label>
                                                    <input type="text" class="form-control form-control-md" name="keterangan_detail[]" placeholder="{{ __('Keterangan') }}">
                                                </div>
                                            </div>
                                        </div>`);

            $('.delete-row').click(function(e){
                let rows = $('#form-detail').find('.row').length;
                if ( rows > 1 ){
                    var row = $(this).data('row');
                    console.log(row);
                    $('#form-detail .row#row-'+row).remove();
                }
            });

            $('select[name="id_barang[]"]').select2({
                placeholder: "{{ __('Pilih Bekal...') }}",
                dataType: 'json',
                ajax: {
                    url: "{{ url('barang_keluar') }}",
                    data: function (params) {
                        var queryParameters = {
                            q: params.term
                        }
                        return queryParameters;
                    },
                    processResults: function (data) {
                        return {
                            results: data
                        };
                    },
                }
            });

        });

        $('select[name="id_gudang"]').select2({
            placeholder: "{{ __('Pilih Gudang...') }}",
        });

        $('select[name="id_satuan_pemakai"]').select2({
            placeholder: "{{ __('Pilih Satuan Pemakai...') }}",
        });

        $('select[name="id_barang[]"]').select2({
            placeholder: "{{ __('Pilih Bekal...') }}",
            dataType: 'json',
            ajax: {
                url: "{{ url('barang_keluar') }}",
                data: function (params) {
                    var queryParameters = {
                        q: params.term
                    }
                    return queryParameters;
                },
                processResults: function (data) {
                    return {
                        results: data
                    };
                },
            }
        });

    })
</script>
@foreach ($barang_keluar->details as $i => $detail)
    <script>
        var row = '{{ $i }}';
        row = row * 1 + 1;
        console.log(row);
        var id_barang = '{{ $detail->id_barang }}';
        var nama_barang = '{{ $detail->barang->nama }}';
        $('#row-' + row + ' select[name="id_barang[]"]').append(`<option value="${id_barang}" selected>${nama_barang}</select>`);

        $('#form-detail #row-' + row + ' .delete-row').click(function(e){
            let rows = $('#form-detail').find('.row').length;
            if ( rows > 1 ){
                var row = $(this).data('row');
                console.log(row);
                $('#form-detail .row#row-'+row).remove();
            }
        });


    </script>
@endforeach
@endpush  