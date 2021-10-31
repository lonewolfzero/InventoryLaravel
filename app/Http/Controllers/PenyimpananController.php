<?php

namespace App\Http\Controllers;

use Auth;
use DB;
use App\User;
use App\Role;
use App\Barang;
use App\Gudang;
use App\Rak;
use App\Penyimpanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Gate;
use Illuminate\Database\Eloquent\Builder;

class PenyimpananController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ( request()->ajax() ){
            if ($request->has('q')) {
                $cari = $request->q;
                $data = DB::table('barang')->where('nama', 'LIKE', '%' . $cari . '%')->get(['id', 'nama as text']);
                return response()->json($data);
            }
            if ($request->has('x')) {
                $cari = $request->x;
                if ( !in_array(auth()->user()->role->id, [1, 1]) && ( auth()->user()->id_gudang != 0 || auth()->user()->id_gudang != null ) ){
                    $data = DB::table('gudang')->where('nama', 'LIKE', '%' . $cari . '%')->where('id', auth()->user()->id_gudang)->get(['id', 'nama as text']);
                }else {
                     $data = DB::table('gudang')->where('nama', 'LIKE', '%' . $cari . '%')->get(['id', 'nama as text']);
                }
                return response()->json($data);
            }
            if ($request->has('z')) {
                $cari = $request->z;
                $data = DB::table('rak')->where('id_gudang', $request->zz)->where('nama', 'LIKE', '%' . $cari . '%')->get(['id', 'nama as text']);
                return response()->json($data);
            }

            if ( !in_array(auth()->user()->role->id, [1, 1]) && ( auth()->user()->id_gudang != 0 || auth()->user()->id_gudang != null ) ){
                $data = Penyimpanan::where('active' ,1)->whereHas('rak', function (Builder $query) {
                    $query->where('id_gudang', auth()->user()->id_gudang);
                })->with(['barang', 'rak'])->orderBy('id', 'DESC')->get();
            }else {
                $data = Penyimpanan::where('active' ,1)->with(['barang', 'rak'])->orderBy('id', 'DESC')->get();
            }

            return datatables()->of($data)
                ->addColumn('nama_barang', function($data){
                    return $data->barang->nama ?? '-';
                })
                ->addColumn('nama_rak', function($data){
                    return $data->rak->nama ?? '-';
                })
                
                ->addColumn('nama_gudang', function($data){
                    return $data->rak->gudang->nama ?? '-';
                })

                ->addColumn('actions', function($data){
                    if ( Gate::allows('penyimpanan.update') || Gate::allows('penyimpanan.delete') ){

                        $html = "";
                        if ( Gate::allows('penyimpanan.update') ){
                            $btnUpdate = '<button type="button" class="btn btn-warning btn-round btn-sm mb-1" data-toggle="modal" data-target="#edit-penyimpanan" data-id="' . $data->id . '" data-id_barang="' .  $data->id_barang . '" data-nama_barang="' .  $data->barang->nama . '" data-id_gudang="' .  $data->rak->id_gudang . '"data-nama_gudang="' .  $data->rak->gudang->nama . '" data-id_rak="' .  $data->id_rak . '"data-nama_rak="' .  $data->rak->nama . '" ><i class="ti-pencil-alt"></i>' . __('Edit') . '</button>';
                        }

                        if ( Gate::allows('penyimpanan.delete') != false ){
                            if ( isset($btnUpdate) ){
                                $html = '<form action="' . route('penyimpanan.destroy', ['id' => $data->id]) . '" method="POST">' . csrf_field() . $btnUpdate .'
            
                                <button class="btn btn-danger btn-round btn-sm mb-1 destroy" data-penyimpanan="' . $data->nama . '" type="submit"><i class="ti-trash"></i>' . __('Delete') . '</button>
                            </form>';
                            
                            }else {
                                $html = '<form action="' . route('penyimpanan.destroy', ['id' => $data->id]) . '" method="POST">' . csrf_field() . '
            
                                <button class="btn btn-danger btn-round btn-sm mb-1 destroy" data-penyimpanan="' . $data->nama . '" type="submit" ><i class="ti-trash"></i>' . __('Delete') . '</button>
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
        $title = "Penyimpanan";
        $barang = Barang::where('active', 1)->orderBy('id', 'DESC')->get();
        $rak = Rak::where('active', 1)->orderBy('id', 'DESC')->get();
        // $gudang = Gudang::where('active', 1)->orderBy('id', 'DESC')->get();
        return view('penyimpanan.index', compact('title', 'barang', 'rak'));
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
        try {
            DB::beginTransaction();
            $penyimpanan = new Penyimpanan;

            $penyimpanan->id_barang = $request->id_barang;
            $penyimpanan->id_rak = $request->id_rak;
            $penyimpanan->active = 1;
            $penyimpanan->updated_by = Auth::user()->id;
            $penyimpanan->save();
    
            DB::commit();
            if ( !empty($penyimpanan->id) ){
                toastr()->success('Penyimpanan berhasil di tambahkan.');
                return redirect()->route('penyimpanan.index');
            }else {
                toastr()->error('Somethings wrong....');
                return redirect()->route('penyimpanan.index');
            }
        } catch (\Exception $e) {
            DB::rollBack();
            toastr()->error("Somethings wrong...");
            toastr()->error($e->getMessage());
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(Penyimpanan $penyimpanan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\penyimpanan  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(Penyimpanan $penyimpanan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Penyimpanan  $penyimpanan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Penyimpanan $penyimpanan)
    {
        try {
            DB::beginTransaction();

            if ( Penyimpanan::where(['id_barang' => $id_barang]) > 0 ){
                return response()->json(['error' => 'Duplikat nilai id_barang-id_rak unique : ' . $id_barang . '-' . $id_rak], 400);
            }

            $penyimpanan = Penyimpanan::find($request->id);
            $penyimpanan->id_barang = $request->id_barang;
            $penyimpanan->id_rak = $request->id_rak;
            $penyimpanan->active = 1;
            $penyimpanan->updated_by = Auth::user()->id;
            $penyimpanan->save();
            
            DB::commit();
            if ( $penyimpanan->save() ){
                toastr()->success('Penyimpanan berhasil di ubah.');
                return redirect()->route('penyimpanan.index');
            }else {
                toastr()->error('Somethings wrong....');
                return redirect()->route('penyimpanan.index');
            }
        } catch (\Exception $e) {
            DB::rollBack();
            toastr()->error("Somethings wrong...");
            toastr()->error($e->getMessage());
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Penyimpanan  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(Penyimpanan $penyimpanan ,$id)
    {
        $penyimpanan = Penyimpanan::where(['id' => $id, 'active' => 1])->orderBy('id', 'DESC')->get();
        if ( count($penyimpanan) > 0 ){
            $penyimpanan = Penyimpanan::find($id);
            $penyimpanan->active = 0;
            $penyimpanan->updated_by = Auth::user()->id;
            if ( $penyimpanan->save() ){
            toastr()->success('Penyimpanan berhasil di hapus.');
            return redirect()->route('penyimpanan.index');
        }else {
            toastr()->error('Somethings wrong....');
            return redirect()->route('penyimpanan.index');
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
