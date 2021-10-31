@extends('layouts.app')

@section('content')
<div class="main-body">
    <div class="page-wrapper">
    
        <div class="page-body">
            <div class="row">
                <div class="col-sm-12">

                    <div class="card">
                        <div class="card-header">
                            <h4>Create - Bekal Masuk</h4>
                        </div>
                        <div class="card-block">
                            
                            <form action="{{ route('barang_masuk.store') }}" method="post"   onsubmit="return checkBeforeSubmit()">

                                @csrf
                                {{-- <input type="hidden" name="id" value="{{ $business->id }}"> --}}
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="nomor_ba" class="font-weight-bolder">{{ __('Nomor BA') }}</label>
                                            <input type="text" class="form-control form-control-md" name="nomor_ba" id="nomor_ba" placeholder="{{ __('Nomor BA') }}">
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="nomor_kontrak" class="font-weight-bolder">{{ __('Nomor Kontrak') }}</label>
                                            <input type="text" class="form-control form-control-md" name="nomor_kontrak" id="nomor_kontrak" placeholder="{{ __('Nomor Kontrak') }}">
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="nomor_kph" class="font-weight-bolder">{{ __('Nomor KPH') }}</label>
                                            <input type="text" class="form-control form-control-md" name="nomor_kph" id="nomor_kph" placeholder="{{ __('Nomor KPH') }}">
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="nomor_surat" class="font-weight-bolder">{{ __('Nomor Surat') }}</label>
                                            <input type="text" class="form-control form-control-md" name="nomor_surat" id="nomor_surat" placeholder="{{ __('Nomor Surat') }}">
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="tahun_anggaran" class="font-weight-bolder">{{ __('Tahun Anggaran') }}</label>
                                            <input type="number" class="form-control form-control-md" name="tahun_anggaran" id="tahun_anggaran" placeholder="{{ __('Tahun Anggaran') }}">
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="tanggal_input" class="font-weight-bolder">{{ __('Tanggal Input') }}</label>
                                            <input type="date" class="form-control form-control-md" name="tanggal_input" id="tanggal_input" placeholder="{{ __('Tanggal Input') }}">
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="id_gudang" class="font-weight-bolder">{{ __('Gudang *') }}</label>
                                            <select class="form-control form-control-md" name="id_gudang" id="id_gudang" required>
                                                <option value="">--{{ __('Pilih Gudang') }}--</option>
                                                @foreach ($gudang as $g)
                                                    <option value="{{ $g->id }}"> {{ $g->nama }} </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="id_rekanan" class="font-weight-bolder">{{ __('Mitra *') }}</label>
                                            <select class="form-control form-control-md" name="id_rekanan" id="id_rekanan" required>
                                                <option value="">--{{ __('Pilih Mitra') }}--</option>
                                                @foreach ($rekanan as $r)
                                                    <option value="{{ $r->id }}"> {{ $r->nama }} </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="keterangan" class="font-weight-bolder">{{ __('Keterangan') }}</label>
                                            <input type="text" class="form-control form-control-md" name="keterangan" id="keterangan" placeholder="{{ __('Keterangan') }}">
                                        </div>
                                    </div>

                                    <hr style=" border: 1px dashed #000; width: 100%; margin: auto; margin-top: 5%; margin-bottom: 1%">
                                    <div class="col-sm-12" id="form-detail">
                                        <h5 class="mb-4 text-center">Detail Bekal Masuk</h5>
                                        <div class="row border-bottom border-primary p-2 my-2 rounded-top" id="row-1">
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
                                            <div class="col-sm-5">
                                                <div class="form-group">
                                                    <label for="keterangan_detail" class="font-weight-bolder">{{ __('Keterangan') }}</label>
                                                    <input type="text" class="form-control form-control-md" name="keterangan_detail[]" placeholder="{{ __('Keterangan') }}">
                                                </div>
                                            </div>
                                            <div class="col-sm-2">
                                                <div class="form-group text-center">
                                                    <button type="button" disabled class="btn btn-sm btn-danger delete-row" data-row="1">-</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12" orm-group">
                                        <button type="button" class="btn btn-sm btn-primary mx-1" id="add-row">+</button>
                                    </div>

                                    <div class="col-sm-12" id="tax-form-group">
                                        <button type="submit" class="btn btn-sm btn-success mx-1 pull-right">{{ __('Save') }}</button>

                                        <a href="{{ route('barang_masuk.index') }}"> <button type="button" class="btn btn-sm btn-secondary mx-1 pull-right">{{ __('Cancel') }}</button> </a>
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
            $('#form-detail').append(`<div class="row border-bottom border-primary p-2 my-4 rounded-top" id="row-${row}">
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
                                            <div class="col-sm-5">
                                                <div class="form-group">
                                                    <label for="keterangan_detail" class="font-weight-bolder">{{ __('Keterangan') }}</label>
                                                    <input type="text" class="form-control form-control-md" name="keterangan_detail[]" placeholder="{{ __('Keterangan') }}">
                                                </div>
                                            </div>
                                            <div class="col-sm-2">
                                                <div class="form-group text-center">
                                                    <button type="button" class="btn btn-sm btn-danger delete-row" data-row="${row}">-</button>
                                                </div>
                                            </div>
                                        </div>`);

            $('.delete-row').click(function(e){
                var row = $(this).data('row');
                console.log(row);
                $('#form-detail .row#row-'+row).remove();
            });

            $('select[name="id_barang[]"]').select2({
                placeholder: "{{ __('Choose Bekal...') }}",
                dataType: 'json',
                ajax: {
                    url: "{{ url('barang_masuk') }}",
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

        $('select[name="id_rekanan"]').select2({
            placeholder: "{{ __('Pilih Mitra...') }}",
        });

        $('select[name="id_barang[]"]').select2({
            placeholder: "{{ __('Pilih Bekal...') }}",
            dataType: 'json',
            ajax: {
                url: "{{ url('barang_masuk') }}",
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
@endpush 