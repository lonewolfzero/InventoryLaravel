<?php

namespace App\Http\Controllers;

use Auth;
use Validator;
use App\User;
use App\Role;
use App\Kategori;
use App\Satuan;
use App\Barang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Gate;

class BarangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if ( request()->ajax() ){
            $data = Barang::where ('active',1)->with(['kategori', 'satuan'])->orderBy('id', 'DESC')->get();
            return datatables()->of($data)
                ->addColumn('nama_kategori', function($data){
                    return $data->kategori->nama;
                })
                ->addColumn('nama_satuan', function($data){
                    return $data->satuan->nama;
                })

                ->addColumn('actions', function($data){
                    if ( Gate::allows('barang.update') || Gate::allows('barang.delete') ){

                        $html = "";
                        if ( Gate::allows('barang.update') ){
                            $btnUpdate = '<button type="button" class="btn btn-warning btn-round btn-sm mb-1" data-toggle="modal" data-target="#edit-barang" data-id="' . $data->id . '" data-kode_barang="' .  $data->kode_barang . '" data-nama="' .  $data->nama . '" data-kode_barcode="' . $data->kode_barcode . '" data-keterangan="' . $data->keterangan . '" data-id_kategori="' . $data->id_kategori . '" data-id_satuan="' .$data->id_satuan . '"><i class="ti-pencil-alt"></i>' . __('Edit') . '</button>';
                        }

                        if ( Gate::allows('barang.delete') != false ){
                            if ( isset($btnUpdate) ){
                                $html = '<form action="' . route('barang.destroy', ['id' => $data->id]) . '" method="POST">' . csrf_field() . $btnUpdate .'
            
                                <button class="btn btn-danger btn-round btn-sm mb-1 destroy" data-barang="' . $data->nama . '" type="submit"><i class="ti-trash"></i>' . __('Delete') . '</button>
                            </form>';
                            
                            }else {
                                $html = '<form action="' . route('barang.destroy', ['id' => $data->id]) . '" method="POST">' . csrf_field() . '
            
                                <button class="btn btn-danger btn-round btn-sm mb-1 destroy" data-barang="' . $data->nama . '" type="submit" ><i class="ti-trash"></i>' . __('Delete') . '</button>
                            </form>';

                            }
                        }else {
                            if ( isset($btnUpdate) ){
                                $html .= $btnUpdate;
                            }
                        }
                        


                    }else {
                        $html = '';
                    }
                        return $html;
                    })
                ->rawColumns(['actions'])
                ->addIndexColumn()
                ->make(true);
        }
        $title = "Barang";
        $kategori = Kategori::where('active', 1)->orderBy('id', 'DESC')->get();
        $satuan = Satuan::where('active', 1)->orderBy('id', 'DESC')->get();
      return view('barang.index', compact('title', 'kategori', 'satuan'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $barang = new Barang;

        $barang->kode_barang = $request->kode_barang;
        $barang->nama = $request->nama;
        $barang->kode_barcode = $request->kode_barcode;
        $barang->active = 1;
        $barang->keterangan = $request->keterangan;
        $barang->id_kategori = $request->id_kategori;
        $barang->id_satuan = $request->id_satuan;
        $barang->updated_by = Auth::user()->id;
        $barang->save();

        if ( !empty($barang->id) ){
            toastr()->success('Barang berhasil di tambahkan.');
            return redirect()->route('barang.index');
        }else {
            toastr()->error('Somethings wrong....');
            return redirect()->route('barang.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(Barang $barang)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\barang  $user
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
     * @param  \App\Barang  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Barang $barang)
    {
        $barang = Barang::find($request->id);
        $barang->kode_barang = $request->kode_barang;
        $barang->nama = $request->nama;
        $barang->kode_barcode = $request->kode_barcode;
        $barang->active = 1;
        $barang->keterangan = $request->keterangan;
        $barang->id_kategori = $request->id_kategori;
        $barang->id_satuan = $request->id_satuan;
        $barang->updated_by = Auth::user()->id;
        
        if ( $barang->save() ){
            toastr()->success('Barang berhasil di ubah.');
            return redirect()->route('barang.index');
        }else {
            toastr()->error('Somethings wrong....');
            return redirect()->route('barang.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Barang  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(Barang $barang ,$id)
    {
        $barang = Barang::where(['id' => $id, 'active' => 1])->orderBy('id', 'DESC')->get();
        if ( count($barang) > 0 ){
            $barang = Barang::find($id);
            $barang->active = 0;
            $barang->updated_by = Auth::user()->id;
            if ( $barang->save() ){
            toastr()->success('Barang berhasil di hapus.');
            return redirect()->route('barang.index');
        }else {
            toastr()->error('Somethings wrong....');
            return redirect()->route('barang.index');
        }
    }
    }

    public function profile()
    {
        $profile = User::find(auth()->user()->id);
        $title = "My Profile";
        return view('user.profile', compact('title', 'profile'));
    }

   
}
