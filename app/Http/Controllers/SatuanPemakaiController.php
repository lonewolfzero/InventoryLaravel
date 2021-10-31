<?php

namespace App\Http\Controllers;

use Auth;
use App\User;
use App\Role;
use App\SatuanPemakai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Gate;

class SatuanPemakaiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if ( request()->ajax() ){
            $data = SatuanPemakai::where('active' ,1)->get();
            return datatables()->of($data)
                ->addColumn('actions', function($data){
                    return $data->id;
                })
                    ->addColumn('actions', function($data){
                        if ( Gate::allows('satuan_pemakai.update') || Gate::allows('satuan_pemakai.delete') ){
                            // if ( $data->role_id <= auth()->user()->role_id ) {
                            //     return "";
                            // }
    
                            $html = "";
                            if ( Gate::allows('satuan_pemakai.update') ){
                                $btnUpdate = '<button type="button" class="btn btn-warning btn-round btn-sm mb-1" data-toggle="modal" data-target="#edit-satuan_pemakai" data-id="' . $data->id . '" data-nama="' .  $data->nama . '" data-pic="' . $data->pic . '"data-nomor_telephone="' . $data->nomor_telephone . '" data-contact_person="' . $data->contact_person . '" data-keterangan="' . $data->keterangan . '" ><i class="ti-pencil-alt"></i>' . __('Edit') . '</button>';
                            }
    
                            if ( Gate::allows('satuan_pemakai.delete') != false ){
                                if ( isset($btnUpdate) ){
                                    $html = '<form action="' . route('satuan_pemakai.destroy', ['id' => $data->id]) . '" method="POST">' . csrf_field() . $btnUpdate .'
                
                                    <button class="btn btn-danger btn-round btn-sm mb-1 destroy" data-satuan_pemakai="' . $data->nama . '" type="submit"><i class="ti-trash"></i>' . __('Delete') . '</button>
                                </form>';
                                
                                }else {
                                    $html = '<form action="' . route('satuan_pemakai.destroy', ['id' => $data->id]) . '" method="POST">' . csrf_field() . '
                
                                    <button class="btn btn-danger btn-round btn-sm mb-1 destroy" data-satuan_pemakai="' . $data->nama . '" type="submit" ><i class="ti-trash"></i>' . __('Delete') . '</button>
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
        $title = "Satuan Pemakai";
        // $roles = Role::get();
        return view('satuan_pemakai.index', compact(['title']));
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
        $satuan_pemakai = new SatuanPemakai;

        $satuan_pemakai->nama = $request->nama;
        $satuan_pemakai->pic = $request->pic;
        $satuan_pemakai->nomor_telephone = $request->nomor_telephone;
        $satuan_pemakai->contact_person = $request->contact_person;
        $satuan_pemakai->active = 1;
        $satuan_pemakai->keterangan = $request->keterangan;
        $satuan_pemakai->updated_by = Auth::user()->id;
                
        $satuan_pemakai->save();

        if ( !empty($satuan_pemakai->id) ){
            toastr()->success('Satuan Pemakai berhasil di tambahkan.');
            return redirect()->route('satuan_pemakai.index');
        }else {
            toastr()->error('Somethings wrong....');
            return redirect()->route('satuan_pemakai.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user\
     * @param  \App\SatuanPemakai  $rekanan\
     * @return \Illuminate\Http\Response
     */
    public function show(SatuanPemakai $satuan_pemakai)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user\
     * @param  \App\SatuanPemakai  $rekanan\
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
     * @param  \App\User  $user\
     * @param  \App\SatuanPemakai  $rekanan\
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SatuanPemakai $satuan_pemakai)
    {
        $satuan_pemakai = SatuanPemakai::find($request->id);

        $satuan_pemakai->nama = $request->nama;
        $satuan_pemakai->pic = $request->pic;
        $satuan_pemakai->nomor_telephone = $request->nomor_telephone;
        $satuan_pemakai->contact_person = $request->contact_person;
        $satuan_pemakai->active = 1;
        $satuan_pemakai->keterangan = $request->keterangan;
        $satuan_pemakai->updated_by = Auth::user()->id;
        
        if ( $satuan_pemakai->save() ){
            toastr()->success('Satuan Pemakai berhasil di ubah.');
            return redirect()->route('satuan_pemakai.index');
        }else {
            toastr()->error('Somethings wrong....');
            return redirect()->route('satuan_pemakai.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user\
     * @param   \App\SatuanPemakai $rekanan
     * @return \Illuminate\Http\Response
     */
    public function destroy(SatuanPemakai $satuan_pemakai ,$id)
    {
        $satuan_pemakai = SatuanPemakai::where(['id' => $id, 'active' => 1])->orderBy('id', 'DESC')->get();
        if ( count($satuan_pemakai) > 0 ){
            $satuan_pemakai = SatuanPemakai::find($id);
            $satuan_pemakai->active = 0;
            $satuan_pemakai->updated_by = Auth::user()->id;
            if ( $satuan_pemakai->save() ){
            toastr()->success('Satuan Pemakai berhasil di hapus.');
            return redirect()->route('satuan_pemakai.index');
        }else {
            toastr()->error('Somethings wrong....');
            return redirect()->route('satuan_pemakai.index');
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
