<?php

namespace App\Http\Controllers;

use Auth;
use App\User;
use App\Role;
use App\Satuan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Gate;

class SatuanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if ( request()->ajax() ){
            $data = Satuan::where('active', 1)->orderBy('id', 'DESC')->get();
            return datatables()->of($data)
                ->addColumn('actions', function($data){
                    return $data->id;
                })
                    ->addColumn('actions', function($data){
                        if ( Gate::allows('satuan.update') || Gate::allows('satuan.delete') ){
    
                            $html = "";
                            if ( Gate::allows('satuan.update') ){
                                $btnUpdate = '<button type="button" class="btn btn-warning btn-round btn-sm mb-1" data-toggle="modal" data-target="#edit-satuan" data-id="' . $data->id . '" data-nama="' .  $data->nama . '" data-keterangan="' . $data->keterangan . '" ><i class="ti-pencil-alt"></i>' . __('Edit') . '</button>';
                            }
    
                            if ( Gate::allows('satuan.delete') != false ){
                                if ( isset($btnUpdate) ){
                                    $html = '<form action="' . route('satuan.destroy', ['id' => $data->id]) . '" method="POST">' . csrf_field() . $btnUpdate .'
                
                                    <button class="btn btn-danger btn-round btn-sm mb-1 destroy" data-satuan="' . $data->nama . '" type="submit"><i class="ti-trash"></i>' . __('Delete') . '</button>
                                </form>';
                                
                                }else {
                                    $html = '<form action="' . route('satuan.destroy', ['id' => $data->id]) . '" method="POST">' . csrf_field() . '
                
                                    <button class="btn btn-danger btn-round btn-sm mb-1 destroy" data-satuan="' . $data->nama . '" type="submit" ><i class="ti-trash"></i>' . __('Delete') . '</button>
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
        $title = "Satuan";
        // $roles = Role::get();
        return view('satuan.index', compact('title'));
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
        $satuan = new Satuan;

        $satuan->nama = $request->nama;
        $satuan->active = 1;
        $satuan->keterangan = $request->keterangan;
        $satuan->updated_by = Auth::user()->id;
                
        $satuan->save();

        if ( !empty($satuan->id) ){
            toastr()->success('Satuan berhasil di tambahkan.');
            return redirect()->route('satuan.index');
        }else {
            toastr()->error('Somethings wrong....');
            return redirect()->route('satuan.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user\
     * @param  \App\Satuan  $kategori\
     * @return \Illuminate\Http\Response
     */
    public function show(Satuan $satuan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user\
     * @param  \App\Satuan  $kategori\
     * @return \Illuminate\Http\Response
     */
    public function edit(satuan $satuan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user\
     * @param  \App\Satuan  $kategori\
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Satuan $satuan)
    {
        $satuan = Satuan::find($request->id);

        $satuan->nama = $request->nama;
        $satuan->active = 1;
        $satuan->keterangan = $request->keterangan;
        $satuan->updated_by = Auth::user()->id;
        
        if ( $satuan->save() ){
            toastr()->success('Satuan berhasil di ubah.');
            return redirect()->route('satuan.index');
        }else {
            toastr()->error('Somethings wrong....');
            return redirect()->route('satuan.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user\
     * @param   \App\Satuan $kategori
     * @return \Illuminate\Http\Response
     */
    public function destroy(Satuan $satuan, $id)
    {
        $satuan = Satuan::where(['id' => $id, 'active' => 1])->orderBy('id', 'DESC')->get();
        if ( count($satuan) > 0 ){
            $satuan = Satuan::find($id);
            $satuan->active = 0;
            $satuan->updated_by = Auth::user()->id;
            if ( $satuan->save() ){
                toastr()->success('Satuan berhasil di hapus.');
                return redirect()->route('satuan.index');
            }else {
                toastr()->error('Somethings wrong....');
                return redirect()->route('satuan.index');
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
