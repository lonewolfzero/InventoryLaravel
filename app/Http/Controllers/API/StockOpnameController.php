<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\StockOpname;
use App\DetailStockOpname;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Validator;
use Auth;
use DB;


class StockOpnameController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if ( !in_array(auth()->user()->role->id, [1, 1]) && ( auth()->user()->id_gudang != 0 || auth()->user()->id_gudang != null ) ){
            $stock_opname = StockOpname::where('active', 1)->where('id_gudang', auth()->user()->id_gudang)->orderBy('id', 'DESC')->get();
        }else {
            $stock_opname = StockOpname::where('active', 1)->orderBy('id', 'DESC')->get();
        }

        // $stock_opname = StockOpname::where('active', 1)->orderBy('id', 'DESC')->get();
        return response()->json($stock_opname, 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function paginate()
    {
        if ( !in_array(auth()->user()->role->id, [1, 1]) && ( auth()->user()->id_gudang != 0 || auth()->user()->id_gudang != null ) ){
            $stock_opname = StockOpname::where('active', 1)->where('id_gudang', auth()->user()->id_gudang)->paginate();
        }else {
            $stock_opname = StockOpname::where('active', 1)->paginate();
        }

        // $stock_opname = StockOpname::where('active', 1)->paginate();
        return response()->json($stock_opname, 200);
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
            'nomor_stock_opname' => 'required|unique:stock_opname,nomor_stock_opname',
            'tahun_anggaran[]' => 'required',
            'id_gudang' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 401);            
        }

        try {
            DB::beginTransaction();
            $stock_opname = new StockOpname;
            $stock_opname->nomor_stock_opname = $request->nomor_stock_opname;
            $stock_opname->tanggal_pelaksanaan = $request->tanggal_pelaksanaan ?? NULL;
            $stock_opname->active = 1;
            $stock_opname->id_gudang = $request->id_gudang;
            $stock_opname->updated_by = Auth::user()->id;
            $stock_opname->save();
    
            foreach ( $request->id_barang as $key => $id_barang ){
                $detail_stock_opname = new DetailStockOpname;
    
                $detail_stock_opname->id_stock_opname = $stock_opname->id;
                $detail_stock_opname->id_barang = $request->id_barang[$key];
                $detail_stock_opname->tahun_anggaran = $request->tahun_anggaran[$key];
                $detail_stock_opname->harga = ($request->harga[$key]) ? (double) str_replace(',', '', $request->harga[$key]) : NULL;
                $detail_stock_opname->jumlah = ($request->jumlah[$key]) ? (double) str_replace(',', '', $request->jumlah[$key]) : NULL;
                $detail_stock_opname->keterangan = $request->keterangan_detail[$key] ?? NULL;
                $detail_stock_opname->save();
            }
            
            DB::commit();
            $stock_opname = StockOpname::with(['gudang', 'details', 'details.barang'])->where('id', $stock_opname->id)->first();
            return response()->json($stock_opname, 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['Message' => $e->getMessage()], 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\StockOpname  $stockOpname
     * @return \Illuminate\Http\Response
     */
    public function show(StockOpname $stockOpname, $id)
    {
        
        if ( !in_array(auth()->user()->role->id, [1, 1]) && ( auth()->user()->id_gudang != 0 || auth()->user()->id_gudang != null ) ){
            $stock_opname = StockOpname::where('id', $id)->where('active', 1)->where('id_gudang', auth()->user()->id_gudang)->with(['details', 'details.barang', 'gudang', 'updated_by'])->first();
        }else {
            $stock_opname = StockOpname::where('id', $id)->where('active', 1)->with(['details', 'details.barang', 'gudang', 'updated_by'])->first();
        }

        $stock_opname = StockOpname::where('id', $id)->where('active', 1)->with(['details', 'details.barang', 'gudang', 'updated_by'])->first();
        if ( $stock_opname ){
            return response()->json($stock_opname, 200);
        }else {
            return response()->json(['Message' => 'Stock Opname tidak ditemukan.'], 404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\StockOpname  $stockOpname
     * @return \Illuminate\Http\Response
     */
    public function edit(StockOpname $stockOpname)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\StockOpname  $stockOpname
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if ( !in_array(auth()->user()->role->id, [1, 1]) && ( auth()->user()->id_gudang != 0 || auth()->user()->id_gudang != null ) ){
            $stock_opname = StockOpname::where('id', $id)->where('active', 1)->where('id_gudang', auth()->user()->id_gudang)->get();
        }else {
            $stock_opname = StockOpname::where('id', $id)->where('active', 1)->get();
        }

        $stock_opname = StockOpname::find($id);
        try {
            if ( $stock_opname ){
                $validator = Validator::make($request->all(), [
                    'nomor_stock_opname' => 'required',
                    'tahun_anggaran' => 'required',
                    'id_gudang' => 'required',
                ]);
        
                if ($validator->fails()) {
                    return response()->json(['error'=>$validator->errors()], 401);            
                }
        
                DB::beginTransaction();
                $stock_opname->nomor_stock_opname = $request->nomor_stock_opname;
                $stock_opname->tanggal_pelaksanaan = $request->tanggal_pelaksanaan ?? NULL;
                $stock_opname->active = 1;
                $stock_opname->id_gudang = $request->id_gudang;
                $stock_opname->updated_by = Auth::user()->id;
                $stock_opname->save();
    
                foreach ( $stock_opname->details as $keyz => $detail ){
                    if ( !in_array($detail->id, $request->id_detail_stock_opname) ){
                        DetailStockOpname::find($detail->id)->delete();
                    }
                }
    
                foreach ( $request->id_barang as $key => $id_barang ){
                    if ( $request->id_detail_stock_opname[$key] != 0 ){
                        $detail_stock_opname = DetailStockOpname::find($request->id_detail_stock_opname[$key]);
            
                        $detail_stock_opname->id_stock_opname = $stock_opname->id;
                        $detail_stock_opname->id_barang = $request->id_barang[$key];
                        $detail_stock_opname->tahun_anggaran = $request->tahun_anggaran[$key] ?? NULL;
                        $detail_stock_opname->harga = ($request->harga[$key]) ? (double) str_replace(',', '', $request->harga[$key]) : NULL;
                        $detail_stock_opname->jumlah = ($request->jumlah[$key]) ? (double) str_replace(',', '', $request->jumlah[$key]) : NULL;
                        $detail_stock_opname->keterangan = $request->keterangan_detail[$key] ?? NULL;
                        $detail_stock_opname->save();
                    }else {
                        $detail_stock_opname = new DetailStockOpname;
            
                        $detail_stock_opname->id_stock_opname = $stock_opname->id;
                        $detail_stock_opname->id_barang = $request->id_barang[$key];
                        $detail_stock_opname->tahun_anggaran = $request->tahun_anggaran[$key] ?? NULL;
                        $detail_stock_opname->harga = ($request->harga[$key]) ? (double) str_replace(',', '', $request->harga[$key]) : NULL;
                        $detail_stock_opname->jumlah = ($request->jumlah[$key]) ? (double) str_replace(',', '', $request->jumlah[$key]) : NULL;
                        $detail_stock_opname->keterangan = $request->keterangan_detail[$key] ?? NULL;
                        $detail_stock_opname->save();
                    }
                }
                
                DB::commit();
                $data = StockOpname::where('id', $stock_opname->id)->where('active', 1)->with(['details', 'details.barang', 'gudang', 'updated_by'])->first();
                return response()->json($data, 200);
            }else {
                return response()->json(['Message' => 'Stock Opname Tidak ditemukan.'], 404);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['Message' => $e->getMessage()], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\StockOpname  $stockOpname
     * @return \Illuminate\Http\Response
     */
    public function destroy(StockOpname $stockOpname, $id)
    {
        if ( !in_array(auth()->user()->role->id, [1, 1]) && ( auth()->user()->id_gudang != 0 || auth()->user()->id_gudang != null ) ){
            $stock_opname = StockOpname::where('id', $id)->where('active', 1)->where('id_gudang', auth()->user()->id_gudang)->get();
        }else {
            $stock_opname = StockOpname::where('id', $id)->where('active', 1)->get();
        }
        
        // $stock_opname = StockOpname::where(['id' => $id, 'active' => 1])->orderBy('id', 'DESC')->get();
        if ( count($stock_opname) > 0 ){
            $stock_opname = StockOpname::find($id);
            $stock_opname->active = 0;
            $stock_opname->save();
            return response()->json(['Message' => 'Stock Opname berhasil dihapus.'], 200);
        }else {
            return response()->json(['Message' => 'Stock Opname Tidak ditemukan.'], 404);
        }
    }
}
