@extends('layouts.app')

@section('content')
<div class="main-body">
    <div class="page-wrapper">
    
        <div class="page-body">
            <div class="row">
                <div class="col-sm-12">

                    <div class="card">
                        <div class="card-header">
                            <h4>Create - Stock Opname</h4>
                        </div>
                        <div class="card-block">
                            
                            <form action="{{ route('stock_opname.store') }}" method="post"   onsubmit="return checkBeforeSubmit()">

                                @csrf
                                {{-- <input type="hidden" name="id" value="{{ $business->id }}"> --}}
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="nomor_stock_opname" class="font-weight-bolder">{{ __('Nomor Stock Opname *') }}</label>
                                            <input type="text" class="form-control form-control-md" name="nomor_stock_opname" id="nomor_stock_opname" placeholder="{{ __('Nomor Stock Opname') }}" required>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="tanggal_pelaksanaan" class="font-weight-bolder">{{ __('Tanggal Pelaksanan') }}</label>
                                            <input type="date" class="form-control form-control-md" name="tanggal_pelaksanaan" id="tanggal_pelaksanaan" placeholder="{{ __('Tanggal Pelaksanaan') }}">
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

                                    <hr style=" border: 1px dashed #000; width: 100%; margin: auto; margin-top: 5%; margin-bottom: 1%">
                                    <div class="col-sm-12" id="form-detail">
                                        <h5 class="mb-4 text-center">Detail Stock Opname</h5>
                                        <div class="row border-bottom border-primary p-2 my-4 rounded-top" id="row-1">
                                            <div class="col-sm-5">
                                                <div class="form-group">
                                                    <label for="id_barang[]" class="font-weight-bolder">{{ __('Bekal *') }}</label>
                                                    <select class="form-control form-control-md" name="id_barang[]" required>
                                                        <option value="">--{{ __('Pilih Mitra') }}--</option>
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
                                                    <input type="text" class="form-control form-control-md" name="harga[]" placeholder="{{ __('Harga (IDR)') }}">
                                                </div>
                                            </div>
                                            <div class="col-sm-5">
                                                <div class="form-group">
                                                    <label for="jumlah[]" class="font-weight-bolder">{{ __('Jumlah Bekal') }}</label>
                                                    <input type="text" class="form-control form-control-md" name="jumlah[]" placeholder="{{ __('Jumlah Bekal') }}">
                                                </div>
                                            </div>
                                            <div class="col-sm-2 pt-4 mt-2">
                                                <div class="form-group text-center">
                                                    <button type="button" disabled class="btn btn-sm btn-danger delete-row" data-row="1">-</button>
                                                </div>
                                            </div>
                                            <div class="col-sm-10">
                                                <div class="form-group">
                                                    <label for="keterangan_detail" class="font-weight-bolder">{{ __('Keterangan') }}</label>
                                                    <input type="text" class="form-control form-control-md" name="keterangan_detail[]" placeholder="{{ __('Keterangan') }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12" orm-group">
                                        <button type="button" class="btn btn-sm btn-primary mx-1" id="add-row">+</button>
                                    </div>

                                    <div class="col-sm-12" id="tax-form-group">
                                        <button type="submit" class="btn btn-sm btn-success mx-1 pull-right">{{ __('Save') }}</button>

                                        <a href="{{ route('stock_opname.index') }}"> <button type="button" class="btn btn-sm btn-secondary mx-1 pull-right">{{ __('Cancel') }}</button> </a>
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
                                            <div class="col-sm-2 pt-4 mt-2">
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
                var row = $(this).data('row');
                console.log(row);
                $('#form-detail .row#row-'+row).remove();
            });

            $('select[name="id_barang[]"]').select2({
                placeholder: "{{ __('Pilih Bekal...') }}",
                dataType: 'json',
                ajax: {
                    url: "{{ url('stock_opname') }}",
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

        $('select[name="id_barang[]"]').select2({
            placeholder: "{{ __('Pilih Bekal...') }}",
            dataType: 'json',
            ajax: {
                url: "{{ url('stock_opname') }}",
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