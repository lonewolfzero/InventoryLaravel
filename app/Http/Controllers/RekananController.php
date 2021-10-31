<?php

namespace App\Http\Controllers;

use Auth;
use App\User;
use App\Role;
use App\Rekanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Gate;

class RekananController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if ( request()->ajax() ){
            $data = Rekanan::where('active' ,1)->get();
            return datatables()->of($data)
                ->addColumn('actions', function($data){
                    return $data->id;
                })
                    ->addColumn('actions', function($data){
                        if ( Gate::allows('rekanan.update') || Gate::allows('rekanan.delete') ){
                            // if ( $data->role_id <= auth()->user()->role_id ) {
                            //     return "";
                            // }
    
                            $html = "";
                            if ( Gate::allows('rekanan.update') ){
                                $btnUpdate = '<button type="button" class="btn btn-warning btn-round btn-sm mb-1" data-toggle="modal" data-target="#edit-rekanan" data-id="' . $data->id . '" data-nama="' .  $data->nama . '" data-pic="' . $data->pic . '" data-contact_person="' . $data->contact_person . '" data-keterangan="' . $data->keterangan . '" ><i class="ti-pencil-alt"></i>' . __('Edit') . '</button>';
                            }
    
                            if ( Gate::allows('rekanan.delete') != false ){
                                if ( isset($btnUpdate) ){
                                    $html = '<form action="' . route('rekanan.destroy', ['id' => $data->id]) . '" method="POST">' . csrf_field() . $btnUpdate .'
                
                                    <button class="btn btn-danger btn-round btn-sm mb-1 destroy" data-rekanan="' . $data->nama . '" type="submit"><i class="ti-trash"></i>' . __('Delete') . '</button>
                                </form>';
                                
                                }else {
                                    $html = '<form action="' . route('rekanan.destroy', ['id' => $data->id]) . '" method="POST">' . csrf_field() . '
                
                                    <button class="btn btn-danger btn-round btn-sm mb-1 destroy" data-rekanan="' . $data->nama . '" type="submit" ><i class="ti-trash"></i>' . __('Delete') . '</button>
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
        $title = "Rekanan";
        // $roles = Role::get();
        return view('rekanan.index', compact(['title']));
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
        $rekanan = new Rekanan;

        $rekanan->nama = $request->nama;
        $rekanan->pic = $request->pic;
        $rekanan->contact_person = $request->contact_person;
        $rekanan->active = 1;
        $rekanan->keterangan = $request->keterangan;
        $rekanan->updated_by = Auth::user()->id;
                
        $rekanan->save();

        if ( !empty($rekanan->id) ){
            toastr()->success('Mitra berhasil di buat.');
            return redirect()->route('rekanan.index');
        }else {
            toastr()->error('Maaf terjadi error mohon di ulangi lagi.');
            return redirect()->route('rekanan.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user\
     * @param  \App\Rekanan  $rekanan\
     * @return \Illuminate\Http\Response
     */
    public function show(Rekanan $rekanan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user\
     * @param  \App\Rekanan  $rekanan\
     * @return \Illuminate\Http\Response
     */
    public function edit(rekanan $rekanan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user\
     * @param  \App\Rekanan  $rekanan\
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Rekanan $rekanan)
    {
        $rekanan = Rekanan::find($request->id);

        $rekanan->nama = $request->nama;
        $rekanan->pic = $request->pic;
        $rekanan->contact_person = $request->contact_person;
        $rekanan->active = 1;
        $rekanan->keterangan = $request->keterangan;
        $rekanan->updated_by = Auth::user()->id;
        
        if ( $rekanan->save() ){
            toastr()->success('Mitra berhasil di ubah.');
            return redirect()->route('rekanan.index');
        }else {
            toastr()->error('Somethings wrong....');
            return redirect()->route('rekanan.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user\
     * @param   \App\Rekanan $rekanan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Rekanan $rekanan ,$id)
    {
        $rekanan = Rekanan::where(['id' => $id, 'active' => 1])->orderBy('id', 'DESC')->get();
        if ( count($rekanan) > 0 ){
            $rekanan = Rekanan::find($id);
            $rekanan->active = 0;
            $rekanan->updated_by = Auth::user()->id;
            if ( $rekanan->save() ){
            toastr()->success('Mitra berhasil di hapus.');
            return redirect()->route('rekanan.index');
        }else {
            toastr()->error('Somethings wrong....');
            return redirect()->route('rekanan.index');
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
