<?php

namespace App\Http\Controllers\API;

use App\Barang;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Validator;
use Auth;

class BarangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $barang = Barang::where('active', 1)->orderBy('id', 'DESC')->with(['kategori', 'satuan', 'stockakhir', 'updated_by'])->get();
        return response()->json($barang, 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function paginate()
    {
        $barang = Barang::where('active', 1)->paginate();
        return response()->json($barang, 200);
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
            'nama' => 'required',
            'id_kategori' => 'required',
            'id_satuan' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 401);            
        }

        $barang = new Barang;
        $barang->kode_barang = $request->kode_barang;
        $barang->nama = $request->nama;
        $barang->kode_barcode = $request->kode_barcode;
        $barang->active = 1;
        $barang->keterangan = $request->keterangan ?? '';
        $barang->id_kategori = $request->id_kategori;
        $barang->id_satuan = $request->id_satuan;
        $barang->updated_by = Auth::user()->id;
        $barang->save();

        return response()->json($barang, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Barang  $barang
     * @return \Illuminate\Http\Response
     */
    public function show(Barang $barang, $id)
    {
        $barang = Barang::where('id', $id)->where('active', 1)->with(['kategori', 'satuan', 'stockakhir', 'updated_by'])->first();
        
        if ( $barang ){
            return response()->json($barang, 200);
        }else {
        $barang = Barang::where('kode_barcode', $id)->where('active', 1)->with(['kategori', 'satuan', 'stockakhir',  'updated_by'])->first();
            
            if ( $barang ){
                return response()->json($barang, 200);
            }else {
                return response()->json(['Message' => 'Barang tidak ditemukan.'], 404);
            }

            return response()->json(['Message' => 'Barang tidak ditemukan.'], 404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Barang  $barang
     * @return \Illuminate\Http\Response
     */
    public function edit(Barang $barang)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Barang  $barang
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $barang = Barang::find($id);
        if ( $barang ){
            $validator = Validator::make($request->all(), [
                'nama' => 'required',
                'id_kategori' => 'required',
                'id_satuan' => 'required',
            ]);
    
            if ($validator->fails()) {
                return response()->json(['error'=>$validator->errors()], 401);            
            }
    
            $barang->kode_barang = $request->kode_barang;
            $barang->nama = $request->nama;
            $barang->kode_barcode = $request->kode_barcode;
            $barang->active = 1;
            $barang->keterangan = $request->keterangan ?? '';
            $barang->id_kategori = $request->id_kategori;
            $barang->id_satuan = $request->id_satuan;
            $barang->updated_by = Auth::user()->id;
            $barang->save();

            return response()->json($barang, 200);
        }else {
            return response()->json(['Message' => 'Barang Tidak ditemukan.'], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Barang  $barang
     * @return \Illuminate\Http\Response
     */
    public function destroy(Barang $barang, $id)
    {
        $barang = Barang::where(['id' => $id, 'active' => 1])->orderBy('id', 'DESC')->get();
        if ( count($barang) > 0 ){
            $barang = Barang::find($id);
            $barang->active = 0;
            $barang->save();
            return response()->json(['Message' => 'Barang berhasil dihapus.'], 200);
        }else {
            return response()->json(['Message' => 'Barang Tidak ditemukan.'], 404);
        }
    }
}
