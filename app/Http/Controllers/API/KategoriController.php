<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Validator;
use Auth;

class KategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $kategori = Kategori::where('active', 1)->orderBy('id', 'DESC')->get();
        return response()->json($kategori, 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function paginate()
    {
        $kategori = Kategori::where('active', 1)->paginate();
        return response()->json($kategori, 200);
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

        $kategori = new Kategori;
        $kategori->nama = $request->nama;
        $kategori->active = 1;
        $kategori->keterangan = $request->keterangan ?? '';
        $kategori->updated_by = Auth::user()->id;
        $kategori->save();

        return response()->json($kategori, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Kategori  $kategori
     * @return \Illuminate\Http\Response
     */
    public function show(Kategori $kategori, $id)
    {
        $kategori = Kategori::where('id', $id)->where('active', 1)->first();
        if ( $kategori ){
            return response()->json($kategori, 200);
        }else {
            return response()->json(['Message' => 'Kategori tidak ditemukan.'], 404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Kategori  $kategori
     * @return \Illuminate\Http\Response
     */
    public function edit(Kategori $kategori)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Kategori  $kategori
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $kategori = Kategori::find($id);
        if ( $kategori ){
            $validator = Validator::make($request->all(), [
                'nama' => 'required',
            ]);
    
            if ($validator->fails()) {
                return response()->json(['error'=>$validator->errors()], 401);            
            }
    
            $kategori->nama = $request->nama;
            $kategori->active = 1;
            $kategori->keterangan = $request->keterangan ?? '';
            $kategori->updated_by = Auth::user()->id;
            $kategori->save();

            return response()->json($kategori, 200);
        }else {
            return response()->json(['Message' => 'Kategori Tidak ditemukan.'], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Kategori  $kategori
     * @return \Illuminate\Http\Response
     */
    public function destroy(Kategori $kategori, $id)
    {
        $kategori = Kategori::where(['id' => $id, 'active' => 1])->orderBy('id', 'DESC')->get();
        if ( count($kategori) > 0 ){
            $kategori = Kategori::find($id);
            $kategori->active = 0;
            $kategori->save();
            return response()->json(['Message' => 'Kategori berhasil dihapus.'], 200);
        }else {
            return response()->json(['Message' => 'Kategori Tidak ditemukan.'], 404);
        }
    }
}
