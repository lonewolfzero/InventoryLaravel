<?php

namespace App\Http\Controllers\API;

use App\BarangMasuk;
use App\BarangKeluar;
use App\StockAkhir;
use App\HistoryKeluarMasuk;
use App\Gudang;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function stock(Request $request)
    {
        $data = new StockAkhir;

        if ( !empty($request->id_gudang) ){
            $data = $data->where('id_gudang', $request->id_gudang)->with(['gudang', 'barang'])->get();
        }else {
            $data = $data->with(['gudang', 'barang'])->get();
        }
        
        return response()->json($data, 200);

    }

    public function nota_dinas(Request $request)
    {
        $data = BarangKeluar::where('active', 1)->where('nomor_surat', '')->where('nomor_nota_dinas', '!=', '');

        if ( !empty($request->startDate) && !empty($request->endDate) ){
            $from = $request->startDate;
            $to = $request->endDate;
            $data->whereBetween('created_at', [$from, $to]);
        }else {
            $data->whereDate('created_at', '>', Carbon::now()->subDays(30));
        }
        
        if ( !empty($request->id_gudang) ){
            $data->where('id_gudang', $request->id_gudang);
        }

        $data = $data->with(['gudang', 'satuan_pemakai'])->paginate();
        return response()->json($data, 200);
    }

    public function detail_nota_dinas(Request $request, $id)
    {
        $nota_dinas = BarangKeluar::where('id', $id)->where('active', 1)->where('nomor_surat', '')->where('nomor_nota_dinas', '!=', '')->count();
        if ( $nota_dinas ){
            $nota_dinas = BarangKeluar::where('id', $id)->with(['gudang', 'satuan_pemakai', 'updated_by', 'details', 'details.barang'])->first();
            return response()->json($nota_dinas, 200);
        }else {
            return response()->json(['Message' => 'Nota Dinas tidak ditemukan.'], 404);
        }
    }

    public function barang_masuk(Request $request)
    {
        $data = BarangMasuk::where('active', 1);

        if ( !empty($request->startDate) && !empty($request->endDate) ){
            $from = $request->startDate;
            $to = $request->endDate;
            $data->whereBetween('created_at', [$from, $to]);
        }else {
            $data->whereDate('created_at', '>', Carbon::now()->subDays(30));
        }
        
        if ( !empty($request->id_gudang) ){
            $data->where('id_gudang', $request->id_gudang);
        }

        $data = $data->with(['gudang', 'rekanan'])->paginate();
        return response()->json($data, 200);
    }

    public function detail_barang_masuk(Request $request, $id)
    {
        $data = BarangMasuk::where('active', 1)->where('id', $id)->count();
        if ( $data ){
            $data = BarangMasuk::where('id', $id)->with(['gudang', 'rekanan', 'updated_by', 'details', 'details.barang'])->first();
            return response()->json($data, 200);
        }else {
            return response()->json(['Message' => 'Barang Masuk tidak ditemukan.'], 404);
        }

    }

    public function barang_keluar(Request $request)
    {
        // $data = BarangKeluar::where('active', 1)->where('nomor_surat', '!=', '');
        $data = BarangKeluar::where('active', 1);

        if ( !empty($request->startDate) && !empty($request->endDate) ){
            $from = $request->startDate;
            $to = $request->endDate;
            $data->whereBetween('created_at', [$from, $to]);
        }else {
            $data->whereDate('created_at', '>', Carbon::now()->subDays(30));
        }
        
        if ( !empty($request->id_gudang) ){
            $data->where('id_gudang', $request->id_gudang);
        }

        $data = $data->with(['gudang', 'satuan_pemakai'])->paginate();
        return response()->json($data, 200);
    }

    public function detail_barang_keluar(Request $request, $id)
    {
        // $barang_keluar = BarangKeluar::where('id', $id)->where('active', 1)->where('nomor_surat', '!=', '')->count();
        $barang_keluar = BarangKeluar::where('id', $id)->where('active', 1)->count();
        if ( $barang_keluar ){
            $barang_keluar = BarangKeluar::where('id', $id)->with(['gudang', 'satuan_pemakai', 'updated_by', 'details', 'details.barang'])->first();
            return response()->json($barang_keluar, 200);
        }else {
            return response()->json(['Message' => 'Barang Keluar tidak ditemukan.'], 404);
        }
    }
}
