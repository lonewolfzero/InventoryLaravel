<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Satuan;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Validator;
use Auth;

class SatuanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $satuan = Satuan::where('active', 1)->orderBy('id', 'DESC')->get();
        return response()->json($satuan, 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function paginate()
    {
        $satuan = Satuan::where('active', 1)->paginate();
        return response()->json($satuan, 200);
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
        ]);

        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 401);            
        }

        $satuan = new Satuan;
        $satuan->nama = $request->nama;
        $satuan->active = 1;
        $satuan->keterangan = $request->keterangan ?? '';
        $satuan->updated_by = Auth::user()->id;
        $satuan->save();

        return response()->json($satuan, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Satuan  $satuan
     * @return \Illuminate\Http\Response
     */
    public function show(Satuan $satuan, $id)
    {
        $satuan = Satuan::where('id', $id)->where('active', 1)->first();
        if ( $satuan ){
            return response()->json($satuan, 200);
        }else {
            return response()->json(['Message' => 'Satuan tidak ditemukan.'], 404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Satuan  $satuan
     * @return \Illuminate\Http\Response
     */
    public function edit(Satuan $satuan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Satuan  $satuan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $satuan = Satuan::find($id);
        if ( $satuan ){
            $validator = Validator::make($request->all(), [
                'nama' => 'required',
            ]);
    
            if ($validator->fails()) {
                return response()->json(['error'=>$validator->errors()], 401);            
            }
    
            $satuan->nama = $request->nama;
            $satuan->active = 1;
            $satuan->keterangan = $request->keterangan ?? '';
            $satuan->updated_by = Auth::user()->id;
            $satuan->save();

            return response()->json($satuan, 200);
        }else {
            return response()->json(['Message' => 'Satuan Tidak ditemukan.'], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Satuan  $satuan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Satuan $satuan, $id)
    {
        $satuan = Satuan::where(['id' => $id, 'active' => 1])->orderBy('id', 'DESC')->get();
        if ( count($satuan) > 0 ){
            $satuan = Satuan::find($id);
            $satuan->active = 0;
            $satuan->save();
            return response()->json(['Message' => 'Satuan berhasil dihapus.'], 200);
        }else {
            return response()->json(['Message' => 'Satuan Tidak ditemukan.'], 404);
        }
    }
}

