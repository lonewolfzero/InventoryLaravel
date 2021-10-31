<?php

namespace App\Http\Controllers;

use Auth;
use App\User;
use App\Role;
use App\Gudang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Gate;

class GudangController extends Controller
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
                $data = Gudang::where('id', auth()->user()->id_gudang)->where('active', 1)->get();
            }else {
                $data = Gudang::where('active', 1)->get();
            }

            return datatables()->of($data)
                ->addColumn('actions', function($data){
                    return $data->id;
                })
                    ->addColumn('actions', function($data){
                        if ( Gate::allows('gudang.update') || Gate::allows('gudang.delete') ){
                            // if ( $data->role_id <= auth()->user()->role_id ) {
                            //     return "";
                            // }
    
                            $html = "";
                            if ( Gate::allows('gudang.update') && ( ( !in_array(auth()->user()->role->id, [1, 1]) && ( auth()->user()->id_gudang != 0 || auth()->user()->id_gudang != null ) ) ) ){
                                $btnUpdate = '<button type="button" class="btn btn-warning btn-round btn-sm mb-1" data-toggle="modal" data-target="#edit-gudang" data-id="' . $data->id . '" data-nama="' .  $data->nama . '" data-nomor="' . $data->nomor . '" data-keterangan="' . $data->keterangan . '"><i class="ti-pencil-alt"></i>' . __('Edit') . '</button>';
                            }
    
                            if ( Gate::allows('gudang.delete') != false && ( ( !in_array(auth()->user()->role->id, [1, 1]) && ( auth()->user()->id_gudang != 0 || auth()->user()->id_gudang != null ) ) ) ){
                                if ( isset($btnUpdate) ){
                                    $html = '<form action="' . route('gudang.destroy', ['id' => $data->id]) . '" method="POST">' . csrf_field() . $btnUpdate .'
                
                                    <button class="btn btn-danger btn-round btn-sm mb-1 destroy" data-gudang="' . $data->nama . '" type="submit"><i class="ti-trash"></i>' . __('Delete') . '</button>
                                </form>';
                                
                                }else {
                                    $html = '<form action="' . route('gudang.destroy', ['id' => $data->id]) . '" method="POST">' . csrf_field() . '
                
                                    <button class="btn btn-danger btn-round btn-sm mb-1 destroy" data-gudang="' . $data->nama . '" type="submit" ><i class="ti-trash"></i>' . __('Delete') . '</button>
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
        $title = "Gudang";
        // $roles = Role::get();
        return view('gudang.index', compact('title'));
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
        $gudang = new Gudang;

        $gudang->nama = $request->nama;
        $gudang->nomor = $request->nomor;
        $gudang->active = 1;
        $gudang->keterangan = $request->keterangan;
        $gudang->updated_by = Auth::user()->id;
                
        $gudang->save();

        if ( !empty($gudang->id) ){
            toastr()->success('Gudang berhasil di tambahkan.');
            return redirect()->route('gudang.index');
        }else {
            toastr()->error('Somethings wrong....');
            return redirect()->route('gudang.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user\
     * @param  \App\Gudang  $kategori\
     * @return \Illuminate\Http\Response
     */
    public function show(Gudang $gudang)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user\
     * @param  \App\Gudang  $kategori\
     * @return \Illuminate\Http\Response
     */
    public function edit(gudang $gudang)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user\
     * @param  \App\Gudang  $kategori\
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Gudang $gudang)
    {
        $gudang = Gudang::find($request->id);
        $gudang->nama = $request->nama;
        $gudang->nomor = $request->nomor;
        $gudang->active = 1;
        $gudang->keterangan = $request->keterangan;
        $gudang->updated_by = Auth::user()->id;
        
        if ( $gudang->save() ){
            toastr()->success('Gudang berhasil di ubah.');
            return redirect()->route('gudang.index');
        }else {
            toastr()->error('Somethings wrong....');
            return redirect()->route('gudang.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user\
     * @param   \App\Gudang $kategori
     * @return \Illuminate\Http\Response
     */
    public function destroy(Gudang $gudang ,$id)
    {
        $gudang = Gudang::where(['id' => $id, 'active' => 1])->orderBy('id', 'DESC')->get();
        if ( count($gudang) > 0 ){
            $gudang = Gudang::find($id);
            $gudang->active = 0;
            $gudang->updated_by = Auth::user()->id;
            if ( $gudang->save() ){
            toastr()->success('Gudang berhasil di hapus.');
            return redirect()->route('gudang.index');
        }else {
            toastr()->error('Somethings wrong....');
            return redirect()->route('gudang.index');
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
