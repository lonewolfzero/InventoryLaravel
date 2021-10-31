<?php

namespace App\Http\Controllers\API;

use App\Gudang;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Validator;
use Auth;

class GudangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if ( !in_array(auth()->user()->role->id, [1, 1]) && ( auth()->user()->id_gudang != 0 || auth()->user()->id_gudang != null ) ){
            $gudang = Gudang::where('id', auth()->user()->id_gudang)->where('active', 1)->orderBy('id', 'DESC')->get();
        }else {
            $gudang = Gudang::where('active', 1)->orderBy('id', 'DESC')->get();
        }

        return response()->json($gudang, 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function paginate()
    {

        if ( !in_array(auth()->user()->role->id, [1, 1]) && ( auth()->user()->id_gudang != 0 || auth()->user()->id_gudang != null ) ){
            $gudang = Gudang::where('id', auth()->user()->id_gudang)->where('active', 1)->paginate();
        }else {
            $gudang = Gudang::where('active', 1)->paginate();
        }
        
        return response()->json($gudang, 200);
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
            'nomor' => 'required|unique:gudang,nomor',
        ]);

        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 401);            
        }

        $gudang = new Gudang;
        $gudang->nama = $request->nama;
        $gudang->nomor = $request->nomor;
        $gudang->active = 1;
        $gudang->keterangan = $request->keterangan ?? '';
        $gudang->updated_by = Auth::user()->id;
        $gudang->save();

        return response()->json($gudang, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Gudang  $gudang
     * @return \Illuminate\Http\Response
     */
    public function show(Gudang $gudang, $id)
    {
        $gudang = Gudang::where('id', $id)->where('active', 1)->with(['rak', 'updated_by'])->first();
        if ( $gudang ){
            return response()->json($gudang, 200);
        }else {
            return response()->json(['Message' => 'Gudang tidak ditemukan.'], 404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Gudang  $gudang
     * @return \Illuminate\Http\Response
     */
    public function edit(Gudang $gudang)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Gudang  $gudang
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $gudang = Gudang::find($id);
        if ( $gudang ){
            $validator = Validator::make($request->all(), [
                'nama' => 'required',
                'nomor' => 'required|unique:gudang,nomor',
            ]);
    
            if ($validator->fails()) {
                return response()->json(['error'=>$validator->errors()], 401);            
            }
    
            $gudang->nama = $request->nama;
            $gudang->nomor = $request->nomor;
            $gudang->active = 1;
            $gudang->keterangan = $request->keterangan ?? '';
            $gudang->updated_by = Auth::user()->id;
            $gudang->save();

            return response()->json($gudang, 200);
        }else {
            return response()->json(['Message' => 'Gudang Tidak ditemukan.'], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Gudang  $gudang
     * @return \Illuminate\Http\Response
     */
    public function destroy(Gudang $gudang, $id)
    {
        $gudang = Gudang::where(['id' => $id, 'active' => 1])->orderBy('id', 'DESC')->get();
        if ( count($gudang) > 0 ){
            $gudang = Gudang::find($id);
            $gudang->active = 0;
            $gudang->save();
            return response()->json(['Message' => 'Gudang berhasil dihapus.'], 200);
        }else {
            return response()->json(['Message' => 'Gudang Tidak ditemukan.'], 404);
        }
    }
}
