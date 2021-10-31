<?php

namespace App\Http\Controllers;

use Auth;
use App\User;
use App\Role;
use App\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Gate;

class KategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if ( request()->ajax() ){
            $data = Kategori::where('active', 1)->orderBy('id', 'DESC')->get();
            // dd($data);
            return datatables()->of($data)
                ->addColumn('actions', function($data){
                    return $data->id;
                })
                ->addColumn('actions', function($data){
                    if ( Gate::allows('kategori.update') || Gate::allows('kategori.delete') ){
                        // if ( $data->role_id <= auth()->user()->role_id ) {
                        //     return "";
                        // }

                        $html = "";
                        if ( Gate::allows('kategori.update') ){
                            $btnUpdate = '<button type="button" class="btn btn-warning btn-round btn-sm mb-1" data-toggle="modal" data-target="#edit-kategori" data-id="' . $data->id . '" data-nama="' .  $data->nama . '" data-keterangan="' . $data->keterangan . '" ><i class="ti-pencil-alt"></i>' . __('Edit') . '</button>';
                        }

                        if ( Gate::allows('kategori.delete') != false ){
                            if ( isset($btnUpdate) ){
                                $html = '<form action="' . route('kategori.destroy', ['id' => $data->id]) . '" method="POST">' . csrf_field() . $btnUpdate .'
            
                                <button class="btn btn-danger btn-round btn-sm mb-1 destroy" data-kategori="' . $data->nama . '" type="submit"><i class="ti-trash"></i>' . __('Delete') . '</button>
                            </form>';
                            
                            }else {
                                $html = '<form action="' . route('kategori.destroy', ['id' => $data->id]) . '" method="POST">' . csrf_field() . '
            
                                <button class="btn btn-danger btn-round btn-sm mb-1 destroy" data-kategori="' . $data->nama . '" type="submit" ><i class="ti-trash"></i>' . __('Delete') . '</button>
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
                ->addIndexColumn()
                ->make(true);
        }
        $title = "Kategori";
        return view('kategori.index', compact('title'));
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
        $kategori = new Kategori;

        $kategori->nama = $request->nama;
        $kategori->active = 1;
        $kategori->keterangan = $request->keterangan;
        $kategori->updated_by = Auth::user()->id;
                
        $kategori->save();

        if ( !empty($kategori->id) ){
            toastr()->success('Kategori berhasil di tambahkan.');
            return redirect()->route('kategori.index');
        }else {
            toastr()->error('Somethings wrong....');
            return redirect()->route('kategori.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user\
     * @param  \App\Kategori  $kategori\
     * @return \Illuminate\Http\Response
     */
    public function show(Kategori $kategori)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user\
     * @param  \App\Kategori  $kategori\
     * @return \Illuminate\Http\Response
     */
    public function edit(kategori $kategori)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user\
     * @param  \App\Kategori  $kategori\
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Kategori $kategori)
    {
        $kategori = Kategori::find($request->id);

        $kategori->nama = $request->nama;
        $kategori->active = 1;
        $kategori->keterangan = $request->keterangan;
        $kategori->updated_by = Auth::user()->id;
        
        if ( $kategori->save() ){
            toastr()->success('Kategori berhasil di ubah.');
            return redirect()->route('kategori.index');
        }else {
            toastr()->error('Somethings wrong....');
            return redirect()->route('kategori.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user\
     * @param   \App\Kategori $kategori
     * @return \Illuminate\Http\Response
     */
    public function destroy(Kategori $kategori, $id)
    {
        $kategori = Kategori::where(['id' => $id, 'active' => 1])->orderBy('id', 'DESC')->get();
        if ( count($kategori) > 0 ){
            $kategori = Kategori::find($id);
            $kategori->active = 0;
            $kategori->updated_by = Auth::user()->id;
            if ( $kategori->save() ){
            toastr()->success('Kategori berhasil di hapus.');
            return redirect()->route('kategori.index');
        }else {
            toastr()->error('Somethings wrong....');
            return redirect()->route('kategori.index');
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
