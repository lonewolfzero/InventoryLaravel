<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\SatuanPemakai;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Validator;
use Auth;

class SatuanPemakaiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $satuan_pemakai = SatuanPemakai::where('active', 1)->orderBy('id', 'DESC')->get();
        return response()->json($satuan_pemakai, 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function paginate()
    {
        $satuan_pemakai = SatuanPemakai::where('active', 1)->paginate();
        return response()->json($satuan_pemakai, 200);
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

        $satuan_pemakai = new SatuanPemakai;
        $satuan_pemakai->nama = $request->nama;
        $satuan_pemakai->pic = $request->pic ?? '';
        $satuan_pemakai->nomor_telephone = $request->nomor_telephone ?? '';
        $satuan_pemakai->contact_person = $request->contact_person ?? '';
        $satuan_pemakai->active = 1;
        $satuan_pemakai->keterangan = $request->keterangan ?? '';
        $satuan_pemakai->updated_by = Auth::user()->id;
        $satuan_pemakai->save();

        return response()->json($satuan_pemakai, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Satuan Pemakai  $satuan_pemakai
     * @return \Illuminate\Http\Response
     */
    public function show(SatuanPemakai $satuan_pemakai, $id)
    {
        $satuan_pemakai = SatuanPemakai::where('id', $id)->where('active', 1)->with(['updated_by'])->first();
        if ( $satuan_pemakai ){
            return response()->json($satuan_pemakai, 200);
        }else {
            return response()->json(['Message' => 'Satuan Pemakai tidak ditemukan.'], 404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Satuan Pemakai  $satuan_pemakai
     * @return \Illuminate\Http\Response
     */
    public function edit(SatuanPemakai $satuan_pemakai)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Satuan Pemakai  $satuan_pemakai
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $satuan_pemakai = SatuanPemakai::find($id);
        if ( $satuan_pemakai ){
            $validator = Validator::make($request->all(), [
                'nama' => 'required',
            ]);
    
            if ($validator->fails()) {
                return response()->json(['error'=>$validator->errors()], 401);            
            }
    
            $satuan_pemakai->nama = $request->nama;
            $satuan_pemakai->pic = $request->pic ?? '';
            $satuan_pemakai->nomor_telephone = $request->nomor_telephone ?? '';
            $satuan_pemakai->contact_person = $request->contact_person ?? '';
            $satuan_pemakai->active = 1;
            $satuan_pemakai->keterangan = $request->keterangan ?? '';
            $satuan_pemakai->updated_by = Auth::user()->id;
                $satuan_pemakai->save();

            return response()->json($satuan_pemakai, 200);
        }else {
            return response()->json(['Message' => 'Satuan Pemakai Tidak ditemukan.'], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Satuan Pemakai  $satuan_pemakai
     * @return \Illuminate\Http\Response
     */
    public function destroy(SatuanPemakai $satuan_pemakai, $id)
    {
        $satuan_pemakai = SatuanPemakai::where(['id' => $id, 'active' => 1])->orderBy('id', 'DESC')->get();
        if ( count($satuan_pemakai) > 0 ){
            $satuan_pemakai = SatuanPemakai::find($id);
            $satuan_pemakai->active = 0;
            $satuan_pemakai->save();
            return response()->json(['Message' => 'Satuan Pemakai berhasil dihapus.'], 200);
        }else {
            return response()->json(['Message' => 'Satuan Pemakai Tidak ditemukan.'], 404);
        }
    }
}