<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Rak;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Validator;
use Auth;

class RakController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if ( !in_array(auth()->user()->role->id, [1, 1]) && ( auth()->user()->id_gudang != 0 || auth()->user()->id_gudang != null ) ){
            $rak = Rak::where('active' ,1)->where('id_gudang', auth()->user()->id_gudang)->with(['gudang'])->orderBy('id', 'DESC')->get();
        }else {
            $rak = Rak::where('active', 1)->orderBy('id', 'DESC')->get();
        }

        return response()->json($rak, 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function paginate()
    {
        if ( !in_array(auth()->user()->role->id, [1, 1]) && ( auth()->user()->id_gudang != 0 || auth()->user()->id_gudang != null ) ){
            $rak = Rak::where('active' ,1)->where('id_gudang', auth()->user()->id_gudang)->with(['gudang'])->paginate();
        }else {
            $rak = Rak::where('active', 1)->paginate();
        }
        
        return response()->json($rak, 200);
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
            'nama' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 401);            
        }

        $rak = new Rak;
        $rak->id_gudang = $request->id_gudang;
        $rak->nama = $request->nama;
        $rak->active = 1;
        $rak->keterangan = $request->keterangan ?? '';
        $rak->updated_by = Auth::user()->id;
        $rak->save();

        return response()->json($rak, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Rak  $rak
     * @return \Illuminate\Http\Response
     */
    public function show(Rak $rak, $id)
    {
        $rak = Rak::where('id', $id)->where('active', 1)->with(['gudang', 'updated_by'])->first();
        if ( $rak ){
            return response()->json($rak, 200);
        }else {
            return response()->json(['Message' => 'Rak tidak ditemukan.'], 404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Rak  $rak
     * @return \Illuminate\Http\Response
     */
    public function edit(Rak $rak)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Rak  $rak
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $rak = Rak::find($id);
        if ( $rak ){
            $validator = Validator::make($request->all(), [
                'id_gudang' => 'required',
                'nama' => 'required',
            ]);
    
            if ($validator->fails()) {
                return response()->json(['error'=>$validator->errors()], 401);            
            }
    
            $rak->id_gudang = $request->id_gudang;
            $rak->nama = $request->nama;
            $rak->active = 1;
            $rak->keterangan = $request->keterangan ?? '';
            $rak->updated_by = Auth::user()->id;
            $rak->save();
                $rak->save();

            return response()->json($rak, 200);
        }else {
            return response()->json(['Message' => 'Rak Tidak ditemukan.'], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Rak  $rak
     * @return \Illuminate\Http\Response
     */
    public function destroy(Rak $rak, $id)
    {
        $rak = Rak::where(['id' => $id, 'active' => 1])->orderBy('id', 'DESC')->get();
        if ( count($rak) > 0 ){
            $rak = Rak::find($id);
            $rak->active = 0;
            $rak->save();
            return response()->json(['Message' => 'Rak berhasil dihapus.'], 200);
        }else {
            return response()->json(['Message' => 'Rak Tidak ditemukan.'], 404);
        }
    }
}

