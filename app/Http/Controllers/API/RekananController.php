<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Rekanan;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Validator;
use Auth;

class RekananController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rekanan = Rekanan::where('active', 1)->orderBy('id', 'DESC')->get();
        return response()->json($rekanan, 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function paginate()
    {
        $rekanan = Rekanan::where('active', 1)->paginate();
        return response()->json($rekanan, 200);
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

        $rekanan = new Rekanan;
        $rekanan->nama = $request->nama;
        $rekanan->pic = $request->pic ?? '';
        $rekanan->contact_person = $request->contact_person ?? '';
        $rekanan->active = 1;
        $rekanan->keterangan = $request->keterangan ?? '';
        $rekanan->updated_by = Auth::user()->id;
        $rekanan->save();

        return response()->json($rekanan, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Rekanan  $rekanan
     * @return \Illuminate\Http\Response
     */
    public function show(Rekanan $rekanan, $id)
    {
        $rekanan = Rekanan::where('id', $id)->where('active', 1)->with(['updated_by'])->first();
        if ( $rekanan ){
            return response()->json($rekanan, 200);
        }else {
            return response()->json(['Message' => 'Mitra tidak ditemukan.'], 404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Rekanan  $rekanan
     * @return \Illuminate\Http\Response
     */
    public function edit(Rekanan $rekanan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Rekanan  $rekanan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $rekanan = Rekanan::find($id);
        if ( $rekanan ){
            $validator = Validator::make($request->all(), [
                'nama' => 'required',
            ]);
    
            if ($validator->fails()) {
                return response()->json(['error'=>$validator->errors()], 401);            
            }
    
            $rekanan->nama = $request->nama;
            $rekanan->pic = $request->pic ?? '';
            $rekanan->contact_person = $request->contact_person ?? '';
            $rekanan->active = 1;
            $rekanan->keterangan = $request->keterangan ?? '';
            $rekanan->updated_by = Auth::user()->id;
                $rekanan->save();

            return response()->json($rekanan, 200);
        }else {
            return response()->json(['Message' => 'Mitra Tidak ditemukan.'], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Rekanan  $rekanan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Rekanan $rekanan, $id)
    {
        $rekanan = Rekanan::where(['id' => $id, 'active' => 1])->orderBy('id', 'DESC')->get();
        if ( count($rekanan) > 0 ){
            $rekanan = Rekanan::find($id);
            $rekanan->active = 0;
            $rekanan->save();
            return response()->json(['Message' => 'Mitra berhasil dihapus.'], 200);
        }else {
            return response()->json(['Message' => 'Mitra Tidak ditemukan.'], 404);
        }
    }
}
