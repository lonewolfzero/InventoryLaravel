<?php

namespace App\Http\Controllers\API;

use App\BarangKeluar;
use App\DetailBarangKeluar;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Validator;
use Auth;
use DB;

class BarangKeluarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if ( !in_array(auth()->user()->role->id, [1, 1]) && ( auth()->user()->id_gudang != 0 || auth()->user()->id_gudang != null ) ){
            $barang_keluar = BarangKeluar::where('active', 1)->where('id_gudang', auth()->user()->id_gudang)->orderBy('id', 'DESC')->get();
        }else {
            $barang_keluar = BarangKeluar::where('active', 1)->orderBy('id', 'DESC')->get();
        }

        // $barang_keluar = BarangKeluar::where('active', 1)->orderBy('id', 'DESC')->get();
        return response()->json($barang_keluar, 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function paginate()
    {
        if ( !in_array(auth()->user()->role->id, [1, 1]) && ( auth()->user()->id_gudang != 0 || auth()->user()->id_gudang != null ) ){
            $barang_keluar = BarangKeluar::where('active', 1)->where('id_gudang', auth()->user()->id_gudang)->paginate();
        }else {
            $barang_keluar = BarangKeluar::where('active', 1)->paginate();
        }

        // $barang_keluar = BarangKeluar::where('active', 1)->paginate();
        return response()->json($barang_keluar, 200);
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
            'nomor_surat' => 'required_without:nomor_nota_dinas',
            'nomor_nota_dinas' => 'required_without:nomor_surat',
            'id_gudang' => 'required',
            'id_satuan_pemakai' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 401);            
        }

        try {
            DB::beginTransaction();

            $barang_keluar = new BarangKeluar;
            $barang_keluar->nomor_surat = $request->nomor_surat ?? NULL;
            $barang_keluar->nomor_nota_dinas = $request->nomor_nota_dinas ?? NULL;
            $barang_keluar->nomor_ba = $request->nomor_ba ?? NULL;
            $barang_keluar->nomor_sa = $request->nomor_sa ?? '';
            $barang_keluar->tanggal_input = $request->tanggal_input ?? NULL;
            $barang_keluar->active = 1;
            $barang_keluar->keterangan = $request->keterangan ?? '';
            $barang_keluar->id_gudang = $request->id_gudang;
            $barang_keluar->id_satuan_pemakai = $request->id_satuan_pemakai;
            $barang_keluar->updated_by = Auth::user()->id;
            $barang_keluar->save();
    
            foreach ( $request->id_barang as $key => $id_barang ){
                $detail_barang_keluar = new DetailBarangKeluar;
    
                $detail_barang_keluar->id_barang_keluar = $barang_keluar->id;
                $detail_barang_keluar->tahun_anggaran = $request->tahun_anggaran[$key];
                $detail_barang_keluar->harga = ($request->harga[$key]) ? (double) str_replace(',', '', $request->harga[$key]) : NULL;
                $detail_barang_keluar->jumlah = ($request->jumlah[$key]) ? (double) str_replace(',', '', $request->jumlah[$key]) : NULL;
                $detail_barang_keluar->keterangan = $request->keterangan_detail[$key] ?? '';
                $detail_barang_keluar->id_barang = $request->id_barang[$key];
                $detail_barang_keluar->save();
            }
    
            DB::commit();
            $barang_keluar = BarangKeluar::with(['gudang', 'satuan_pemakai', 'details', 'details.barang'])->where('id', $barang_keluar->id)->first();
            return response()->json($barang_keluar, 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['Message' => $e->getMessage()], 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Barang  $barang_keluar
     * @return \Illuminate\Http\Response
     */
    public function show(BarangKeluar $barang_keluar, $id)
    {
        if ( !in_array(auth()->user()->role->id, [1, 1]) && ( auth()->user()->id_gudang != 0 || auth()->user()->id_gudang != null ) ){
            $barang_keluar = BarangKeluar::where('id', $id)->where('active', 1)->where('id_gudang', auth()->user()->id_gudang)->with(['details', 'details.barang', 'gudang', 'satuan_pemakai', 'updated_by'])->first();
        }else {
            $barang_keluar = BarangKeluar::where('id', $id)->where('active', 1)->with(['details', 'details.barang', 'gudang', 'satuan_pemakai', 'updated_by'])->first();
        }

        // $barang_keluar = BarangKeluar::where('id', $id)->where('active', 1)->with(['details', 'details.barang', 'gudang', 'satuan_pemakai', 'updated_by'])->first();
        if ( $barang_keluar ){
            return response()->json($barang_keluar, 200);
        }else {
            return response()->json(['Message' => 'Barang Keluar tidak ditemukan.'], 404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Barang  $barang_keluar
     * @return \Illuminate\Http\Response
     */
    public function edit(BarangKeluar $barang_keluar)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Barang  $barang_keluar
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if ( !in_array(auth()->user()->role->id, [1, 1]) && ( auth()->user()->id_gudang != 0 || auth()->user()->id_gudang != null ) ){
            $barang_keluar = BarangKeluar::where('id', $id)->where('active', 1)->where('id_gudang', auth()->user()->id_gudang)->first();
            $barang_keluar = BarangKeluar::where('id', $id)->where('active', 1)->first();
        }else {
            $barang_keluar = BarangKeluar::where('id', $id)->where('active', 1)->first();
        }

        $barang_keluar = BarangKeluar::find($id);
        try {
            if ( $barang_keluar ){
                $validator = Validator::make($request->all(), [
                    'nama' => 'required',
                    'nomor_surat' => 'required_without:nomor_nota_dinas',
                    'nomor_nota_dinas' => 'required_without:nomor_surat',
                    'id_gudang' => 'required',
                    'id_satuan_pemakai' => 'required',
                ]);
        
                if ($validator->fails()) {
                    return response()->json(['error'=>$validator->errors()], 401);            
                }
        
                DB::beginTransaction();
                $barang_keluar = BarangKeluar::find($id);
                $barang_keluar->nomor_surat = $request->nomor_surat ?? NULL;
                $barang_keluar->nomor_nota_dinas = $request->nomor_nota_dinas ?? NULL;
                $barang_keluar->nomor_ba = $request->nomor_ba ?? NULL;
                $barang_keluar->nomor_sa = $request->nomor_sa ?? '';
                $barang_keluar->tahun_anggaran = $request->tahun_anggaran ?? NULL;
                $barang_keluar->tanggal_input = $request->tanggal_input ?? NULL;
                $barang_keluar->active = 1;
                $barang_keluar->keterangan = $request->keterangan ?? '';
                $barang_keluar->id_gudang = $request->id_gudang;
                $barang_keluar->id_satuan_pemakai = $request->id_satuan_pemakai;
                $barang_keluar->updated_by = Auth::user()->id;
                $barang_keluar->save();
        
                foreach ( $barang_keluar->details as $keyz => $detail ){
                    if ( !in_array($detail->id, $request->id_detail_barang_keluar) ){
                        DetailBarangKeluar::find($detail->id)->delete();
                    }
                }
    
                foreach ( $request->id_barang as $key => $id_barang ){
                    if ( $request->id_detail_barang_keluar[$key] != 0 ){
                        $detail_barang_keluar = DetailBarangKeluar::find($request->id_detail_barang_keluar[$key]);
            
                        $detail_barang_keluar->id_barang_keluar = $barang_keluar->id;
                        $detail_barang_keluar->tahun_anggaran = $request->tahun_anggaran[$key];
                        $detail_barang_keluar->harga = ($request->harga[$key]) ? (double) str_replace(',', '', $request->harga[$key]) : NULL;
                        $detail_barang_keluar->jumlah = ($request->jumlah[$key]) ? (double) str_replace(',', '', $request->jumlah[$key]) : NULL;
                        $detail_barang_keluar->keterangan = $request->keterangan_detail[$key] ?? '';
                        $detail_barang_keluar->id_barang = $request->id_barang[$key];
                        $detail_barang_keluar->save();
                    }else {
                        $detail_barang_keluar = new DetailBarangKeluar;
            
                        $detail_barang_keluar->id_barang_keluar = $barang_keluar->id;
                        $detail_barang_keluar->tahun_anggaran = $request->tahun_anggaran[$key];
                        $detail_barang_keluar->harga = ($request->harga[$key]) ? (double) str_replace(',', '', $request->harga[$key]) : NULL;
                        $detail_barang_keluar->jumlah = ($request->jumlah[$key]) ? (double) str_replace(',', '', $request->jumlah[$key]) : NULL;
                        $detail_barang_keluar->keterangan = $request->keterangan_detail[$key] ?? '';
                        $detail_barang_keluar->id_barang = $request->id_barang[$key];
                        $detail_barang_keluar->save();
                    }
                }
                
                DB::commit();
                return response()->json($barang_keluar, 200);
            }else {
                return response()->json(['Message' => 'Barang Keluar Tidak ditemukan.'], 404);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['Message' => $e->getMessage()], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Barang  $barang_keluar
     * @return \Illuminate\Http\Response
     */
    public function destroy(BarangKeluar $barang_keluar, $id)
    {
        if ( !in_array(auth()->user()->role->id, [1, 1]) && ( auth()->user()->id_gudang != 0 || auth()->user()->id_gudang != null ) ){
            $barang_keluar = BarangKeluar::where('id', $id)->where('active', 1)->where('id_gudang', auth()->user()->id_gudang)->get();
        }else {
            $barang_keluar = BarangKeluar::where('id', $id)->where('active', 1)->get();
        }
        
        // $barang_keluar = BarangKeluar::where(['id' => $id, 'active' => 1])->orderBy('id', 'DESC')->get();
        if ( count($barang_keluar) > 0 ){
            $barang_keluar = BarangKeluar::find($id);
            $barang_keluar->active = 0;
            $barang_keluar->save();
            return response()->json(['Message' => 'Barang Keluar berhasil dihapus.'], 200);
        }else {
            return response()->json(['Message' => 'Barang Keluar Tidak ditemukan.'], 404);
        }
    }
}