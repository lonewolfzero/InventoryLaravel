<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Penyimpanan;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Validator;
use Auth;
use DB;

class PenyimpananController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $penyimpanan = Penyimpanan::where('active', 1)->orderBy('id', 'DESC')->with(['barang', 'rak.gudang', 'updated_by'])->get();
        return response()->json($penyimpanan, 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function paginate()
    {
        $penyimpanan = Penyimpanan::where('active', 1)->with(['barang', 'rak.gudang', 'updated_by'])->paginate();
        return response()->json($penyimpanan, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $id_barang = $request->id_barang;
            $id_rak = $request->id_rak;  
    
            $validator = Validator::make($request->all(), [
                'id_barang' => 'required',
                'id_rak' => 'required',
                ]);
                
                if ($validator->fails()) {
                    return response()->json(['error'=>$validator->errors()], 401);            
                }
            
                if ( Penyimpanan::where(['id_barang' => $id_barang, 'id_rak' => $id_rak])->count() > 0 ){
                    return response()->json(['error' => 'Duplikat nilai id_barang-id_rak unique : ' . $id_barang . '-' . $id_rak], 400);
                }
                
                $penyimpanan = new Penyimpanan;
                $penyimpanan->id_barang = $request->id_barang;
                $penyimpanan->id_rak = $request->id_rak;
                $penyimpanan->active = 1;
                $penyimpanan->updated_by = Auth::user()->id;
                $penyimpanan->save();
                
                $penyimpanan = Penyimpanan::where('id', $penyimpanan->id)->with(['barang', 'rak.gudang'])->orderBy('id', 'DESC')->get();
                
                DB::commit();
            return response()->json($penyimpanan, 200);
        } catch (\Exception $e) {
            DB::rollBack();
            toastr()->error("Somethings wrong...");
            toastr()->error($e->getMessage());
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Penyimpanan  $penyimpanan
     * @return \Illuminate\Http\Response
     */
    public function show(Penyimpanan $penyimpanan, $id)
    {
        $penyimpanan = Penyimpanan::where('id', $id)->where('active', 1)->with(['barang', 'rak.gudang', 'updated_by'])->first();
        if ( $penyimpanan ){
            return response()->json($penyimpanan, 200);
        }else {
            return response()->json(['Message' => 'Penyimpanan tidak ditemukan.'], 404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Penyimpanan  $penyimpanan
     * @return \Illuminate\Http\Response
     */
    public function edit(Penyimpanan $penyimpanan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Penyimpanan  $penyimpanan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            $penyimpanan = Penyimpanan::find($id);
            if ( $penyimpanan ){
                $id_barang = $request->id_barang;
                $id_rak = $request->id_rak;  
    
                $validator = Validator::make($request->all(), [
                    'id_barang' => 'required',
                    'id_rak' => 'required',
                ]);
    
                if ($validator->fails()) {
                    return response()->json(['error'=>$validator->errors()], 401);            
                }
    
                if ( Penyimpanan::where(['id_barang' => $id_barang, 'id_rak' => $id_rak])->count() > 0 ){
                    return response()->json(['error' => 'Duplikat nilai id_barang-id_rak unique : ' . $id_barang . '-' . $id_rak], 400);
                }
                
                
                $penyimpanan->id_barang = $request->id_barang;
                $penyimpanan->id_rak = $request->id_rak;
                $penyimpanan->active = 1;
                $penyimpanan->updated_by = Auth::user()->id;
                $penyimpanan->save();
    
                $penyimpanan = Penyimpanan::where('id', $penyimpanan->id)->with(['barang', 'rak.gudang'])->orderBy('id', 'DESC')->get();
                DB::commit();
    
                return response()->json($penyimpanan, 200);
            }else {
                return response()->json(['Message' => 'Penyimpanan Tidak ditemukan.'], 404);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            toastr()->error("Somethings wrong...");
            toastr()->error($e->getMessage());
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Penyimpanan  $penyimpanan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Penyimpanan $penyimpanan, $id)
    {
        $penyimpanan = Penyimpanan::where(['id' => $id, 'active' => 1])->orderBy('id', 'DESC')->get();
        if ( count($penyimpanan) > 0 ){
            $penyimpanan = Penyimpanan::find($id);
            $penyimpanan->active = 0;
            $penyimpanan->save();
            return response()->json(['Message' => 'Penyimpanan berhasil dihapus.'], 200);
        }else {
            return response()->json(['Message' => 'Penyimpanan Tidak ditemukan.'], 404);
        }
    }
}
