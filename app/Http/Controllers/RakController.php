<?php

namespace App\Http\Controllers;

use Auth;
use App\User;
use App\Role;
use App\Gudang;
use App\Rak;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Gate;

class RakController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if ( request()->ajax() ){
            if ( !in_array(auth()->user()->role->id, [1, 1]) && ( auth()->user()->id_gudang != 0 || auth()->user()->id_gudang != null ) ){
                $data = Rak::where('active' ,1)->where('id_gudang', auth()->user()->id_gudang)->with(['gudang'])->orderBy('id', 'DESC')->get();
            }else {
                $data = Rak::where('active' ,1)->with(['gudang'])->orderBy('id', 'DESC')->get();
            }

            return datatables()->of($data)
                ->addColumn('nama_gudang', function($data){
                    return $data->gudang->nama;
                })

                ->addColumn('actions', function($data){
                    if ( Gate::allows('rak.update') || Gate::allows('rak.delete') ){

                        $html = "";
                        if ( Gate::allows('rak.update') ){
                            $btnUpdate = '<button type="button" class="btn btn-warning btn-round btn-sm mb-1" data-toggle="modal" data-target="#edit-rak" data-id="' . $data->id . '" data-id_gudang="' .  $data->id_gudang . '" data-nama="' .  $data->nama . '" data-keterangan="' . $data->keterangan . '" ><i class="ti-pencil-alt"></i>' . __('Edit') . '</button>';
                        }

                        if ( Gate::allows('rak.delete') != false ){
                            if ( isset($btnUpdate) ){
                                $html = '<form action="' . route('rak.destroy', ['id' => $data->id]) . '" method="POST">' . csrf_field() . $btnUpdate .'
            
                                <button class="btn btn-danger btn-round btn-sm mb-1 destroy" data-rak="' . $data->nama . '" type="submit"><i class="ti-trash"></i>' . __('Delete') . '</button>
                            </form>';
                            
                            }else {
                                $html = '<form action="' . route('rak.destroy', ['id' => $data->id]) . '" method="POST">' . csrf_field() . '
            
                                <button class="btn btn-danger btn-round btn-sm mb-1 destroy" data-rak="' . $data->nama . '" type="submit" ><i class="ti-trash"></i>' . __('Delete') . '</button>
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
        $title = "Rak";
        if ( !in_array(auth()->user()->role->id, [1, 1]) && ( auth()->user()->id_gudang != 0 || auth()->user()->id_gudang != null ) ){
            $gudang = Gudang::where('id', auth()->user()->id_gudang)->where('active', 1)->get();
        }else {
            $gudang = Gudang::where('active', 1)->get();
        }
        return view('rak.index', compact('title', 'gudang'));
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
        $rak = new Rak;

        $rak->nama = $request->nama;
        $rak->id_gudang = $request->id_gudang;
        $rak->active = 1;
        $rak->keterangan = $request->keterangan;
        $rak->updated_by = Auth::user()->id;
        $rak->save();

        if ( !empty($rak->id) ){
            toastr()->success('Rak berhasil di tambahkan.');
            return redirect()->route('rak.index');
        }else {
            toastr()->error('Somethings wrong....');
            return redirect()->route('rak.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(Rak $rak)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\rak  $user
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
     * @param  \App\Gudang  $gudang
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Rak $rak)
    {
        $rak = Rak::find($request->id);
        $rak->nama = $request->nama;
        $rak->id_gudang = $request->id_gudang;
        $rak->active = 1;
        $rak->keterangan = $request->keterangan;
        $rak->updated_by = Auth::user()->id;
        $rak->save();
        
        if ( $rak->save() ){
            toastr()->success('Rak berhasil di ubah.');
            return redirect()->route('rak.index');
        }else {
            toastr()->error('Somethings wrong....');
            return redirect()->route('rak.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Rak  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(Rak $rak ,$id)
    {
        $rak = Rak::where(['id' => $id, 'active' => 1])->orderBy('id', 'DESC')->get();
        if ( count($rak) > 0 ){
            $rak = Rak::find($id);
            $rak->active = 0;
            $rak->updated_by = Auth::user()->id;
            if ( $rak->save() ){
            toastr()->success('Rak berhasil di hapus.');
            return redirect()->route('rak.index');
        }else {
            toastr()->error('Somethings wrong....');
            return redirect()->route('rak.index');
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
