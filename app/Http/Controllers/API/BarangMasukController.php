<?php

namespace App\Http\Controllers\API;

use App\BarangMasuk;
use App\DetailBarangMasuk;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Validator;
use Auth;
use DB;

class BarangMasukController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if ( !in_array(auth()->user()->role->id, [1, 1]) && ( auth()->user()->id_gudang != 0 || auth()->user()->id_gudang != null ) ){
            $barang_masuk = BarangMasuk::where('active', 1)->where('id_gudang', auth()->user()->id_gudang)->orderBy('id', 'DESC')->get();
        }else {
            $barang_masuk = BarangMasuk::where('active', 1)->orderBy('id', 'DESC')->get();
        }

        // $barang_masuk = BarangMasuk::where('active', 1)->orderBy('id', 'DESC')->get();
        return response()->json($barang_masuk, 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function paginate()
    {
        if ( !in_array(auth()->user()->role->id, [1, 1]) && ( auth()->user()->id_gudang != 0 || auth()->user()->id_gudang != null ) ){
            $barang_masuk = BarangMasuk::where('active', 1)->where('id_gudang', auth()->user()->id_gudang)->paginate();
        }else {
            $barang_masuk = BarangMasuk::where('active', 1)->paginate();
        }

        // $barang_masuk = BarangMasuk::where('active', 1)->paginate();
        return response()->json($barang_masuk, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_gudang' => 'required',
            'id_rekanan' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 401);            
        }

        try {
            DB::beginTransaction();
            $barang_masuk = new BarangMasuk;
            $barang_masuk->nomor_ba = $request->nomor_ba ?? NULL;
            $barang_masuk->nomor_kontrak = $request->nomor_kontrak ?? '';
            $barang_masuk->nomor_kph = $request->nomor_kph ?? '';
            $barang_masuk->nomor_surat = $request->nomor_surat ?? NULL;
            $barang_masuk->tahun_anggaran = $request->tahun_anggaran ?? NULL;
            $barang_masuk->tanggal_input = $request->tanggal_input ?? NULL;
            $barang_masuk->active = 1;
            $barang_masuk->keterangan = $request->keterangan ?? '';
            $barang_masuk->id_gudang = $request->id_gudang;
            $barang_masuk->id_rekanan = $request->id_rekanan;
            $barang_masuk->updated_by = Auth::user()->id;
            $barang_masuk->save();
    
            foreach ( $request->id_barang as $key => $id_barang ){
                $detail_barang_masuk = new DetailBarangMasuk;
    
                $detail_barang_masuk->id_barang_masuk = $barang_masuk->id;
                $detail_barang_masuk->harga = ($request->harga[$key]) ? (double) str_replace(',', '', $request->harga[$key]) : NULL;
                $detail_barang_masuk->jumlah = ($request->jumlah[$key]) ? (double) str_replace(',', '', $request->jumlah[$key]) : NULL;
                $detail_barang_masuk->keterangan = $request->keterangan_detail[$key] ?? '';
                $detail_barang_masuk->id_barang = $request->id_barang[$key];
                $detail_barang_masuk->save();
            }
    
            DB::commit();
            $barang_masuk = BarangMasuk::with(['gudang', 'rekanan', 'details', 'details.barang'])->where('id', $barang_masuk->id)->first();
            return response()->json($barang_masuk, 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['Message' => $e->getMessage()], 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Barang  $barang_masuk
     * @return \Illuminate\Http\Response
     */
    public function show(BarangMasuk $barang_masuk, $id)
    {
        if ( !in_array(auth()->user()->role->id, [1, 1]) && ( auth()->user()->id_gudang != 0 || auth()->user()->id_gudang != null ) ){
            $barang_masuk = BarangMasuk::where('id', $id)->where('active', 1)->where('id_gudang', auth()->user()->id_gudang)->with(['details', 'details.barang', 'gudang', 'rekanan', 'updated_by'])->first();
        }else {
            $barang_masuk = BarangMasuk::where('id', $id)->where('active', 1)->with(['details', 'details.barang', 'gudang', 'rekanan', 'updated_by'])->first();
        }

        // $barang_masuk = BarangMasuk::where('id', $id)->where('active', 1)->with(['details', 'details.barang', 'gudang', 'rekanan', 'updated_by'])->first();
        if ( $barang_masuk ){
            return response()->json($barang_masuk, 200);
        }else {
            return response()->json(['Message' => 'Barang Masuk tidak ditemukan.'], 404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Barang  $barang_masuk
     * @return \Illuminate\Http\Response
     */
    public function edit(BarangMasuk $barang_masuk)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Barang  $barang_masuk
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if ( !in_array(auth()->user()->role->id, [1, 1]) && ( auth()->user()->id_gudang != 0 || auth()->user()->id_gudang != null ) ){
            $barang_masuk = BarangMasuk::where('id', $id)->where('active', 1)->where('id_gudang', auth()->user()->id_gudang)->first();
        }else {
            $barang_masuk = BarangMasuk::where('id', $id)->where('active', 1)->first();
        }
        // $barang_masuk = BarangMasuk::find($id);
        try {
            if ( $barang_masuk ){
                $validator = Validator::make($request->all(), [
                    'id_gudang' => 'required',
                    'id_rekanan' => 'required',
                ]);
        
                if ($validator->fails()) {
                    return response()->json(['error'=>$validator->errors()], 401);            
                }
        
                DB::beginTransaction();
                $barang_masuk->nomor_ba = $request->nomor_ba ?? NULL;
                $barang_masuk->nomor_kontrak = $request->nomor_kontrak ?? '';
                $barang_masuk->nomor_kph = $request->nomor_kph ?? '';
                $barang_masuk->nomor_surat = $request->nomor_surat ?? NULL;
                $barang_masuk->tahun_anggaran = $request->tahun_anggaran ?? NULL;
                $barang_masuk->tanggal_input = $request->tanggal_input ?? NULL;
                $barang_masuk->active = 1;
                $barang_masuk->keterangan = $request->keterangan ?? '';
                $barang_masuk->id_gudang = $request->id_gudang;
                $barang_masuk->id_rekanan = $request->id_rekanan;
                $barang_masuk->updated_by = Auth::user()->id;
                $barang_masuk->save();
    
                foreach ( $barang_masuk->details as $keyz => $detail ){
                    if ( !in_array($detail->id, $request->id_detail_barang_masuk) ){
                        DetailBarangMasuk::find($detail->id)->delete();
                    }
                }
    
                foreach ( $request->id_barang as $key => $id_barang ){
                    if ( $request->id_detail_barang_masuk[$key] != 0 ){
                        $detail_barang_keluar = DetailBarangMasuk::find($request->id_detail_barang_masuk[$key]);
            
                        $detail_barang_keluar->id_barang_masuk = $barang_masuk->id;
                        $detail_barang_keluar->harga = ($request->harga[$key]) ? (double) str_replace(',', '', $request->harga[$key]) : NULL;
                        $detail_barang_keluar->jumlah = ($request->jumlah[$key]) ? (double) str_replace(',', '', $request->jumlah[$key]) : NULL;
                        $detail_barang_keluar->keterangan = $request->keterangan_detail[$key] ?? '';
                        $detail_barang_keluar->id_barang = $request->id_barang[$key];
                        $detail_barang_keluar->save();
                    }else {
                        $detail_barang_keluar = new DetailBarangMasuk;
            
                        $detail_barang_keluar->id_barang_masuk = $barang_masuk->id;
                        $detail_barang_keluar->harga = ($request->harga[$key]) ? (double) str_replace(',', '', $request->harga[$key]) : NULL;
                        $detail_barang_keluar->jumlah = ($request->jumlah[$key]) ? (double) str_replace(',', '', $request->jumlah[$key]) : NULL;
                        $detail_barang_keluar->keterangan = $request->keterangan_detail[$key] ?? '';
                        $detail_barang_keluar->id_barang = $request->id_barang[$key];
                        $detail_barang_keluar->save();
                    }
                }
    
                DB::commit();
                $data = BarangMasuk::where('id', $barang_masuk->id)->where('active', 1)->with(['details', 'details.barang', 'gudang', 'rekanan', 'updated_by'])->first();
                return response()->json($data, 200);
            }else {
                return response()->json(['Message' => 'Barang Masuk Tidak ditemukan.'], 404);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['Message' => $e->getMessage()], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Barang  $barang_masuk
     * @return \Illuminate\Http\Response
     */
    public function destroy(BarangMasuk $barang_masuk, $id)
    {
        if ( !in_array(auth()->user()->role->id, [1, 1]) && ( auth()->user()->id_gudang != 0 || auth()->user()->id_gudang != null ) ){
            $barang_masuk = BarangMasuk::where('id', $id)->where('active', 1)->where('id_gudang', auth()->user()->id_gudang)->get();
        }else {
            $barang_masuk = BarangMasuk::where('id', $id)->where('active', 1)->get();
        }
        
        // $barang_masuk = BarangMasuk::where(['id' => $id, 'active' => 1])->orderBy('id', 'DESC')->get();
        if ( count($barang_masuk) > 0 ){
            $barang_masuk = BarangMasuk::find($id);
            $barang_masuk->active = 0;
            $barang_masuk->save();
            return response()->json(['Message' => 'Barang Masuk berhasil dihapus.'], 200);
        }else {
            return response()->json(['Message' => 'Barang Masuk Tidak ditemukan.'], 404);
        }
    }
}