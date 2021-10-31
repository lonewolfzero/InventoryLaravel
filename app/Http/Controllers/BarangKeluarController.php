<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use App\BarangKeluar;
use App\DetailBarangKeluar;
use App\SatuanPemakai;
use App\Barang;
use App\Gudang;
use App\Rekanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Database\Eloquent\Builder;

class BarangKeluarController extends Controller
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
                
                if ( !in_array(auth()->user()->role->id, [1, 1]) && ( auth()->user()->id_gudang != 0 || auth()->user()->id_gudang != null ) ){
                    $data = Barang::where('active', 1)->where('nama', 'LIKE', '%' . $cari . '%')->whereHas('penyimpanan.rak', function (Builder $query) {
                        $query->where('id_gudang', auth()->user()->id_gudang);
                    })->get(['id', 'nama as text', 'id_kategori', 'id_satuan']);
                }else {
                    $data = DB::table('barang')->where('active', 1)->where('nama', 'LIKE', '%' . $cari . '%')->get(['id', 'nama as text']);
                }

                return response()->json($data);
            }

            if ( !in_array(auth()->user()->role->id, [1, 1]) && ( auth()->user()->id_gudang != 0 || auth()->user()->id_gudang != null ) ){
                $data = BarangKeluar::where('id_gudang', auth()->user()->id_gudang)->where('active', 1)->with(['gudang', 'satuan_pemakai'])->orderBy('id', 'DESC')->get();
            }else {
                $data = BarangKeluar::where('active', 1)->with(['gudang', 'satuan_pemakai'])->orderBy('id', 'DESC')->get();
            }


            if ( request()->has('nota_dinas') ){
                $data = $data->where('nota_dinas', true);
            }else {
                $data = $data->where('nota_dinas', false);
            }

            return datatables()->of($data)
                ->addColumn('gudang', function($data){
                    return $data->gudang->nama;
                })
                ->addColumn('satuan_pemakai', function($data){
                    return $data->satuan_pemakai->nama;
                })

                ->addColumn('actions', function($data){
                    if ( Gate::allows('barang_keluar.detail') || Gate::allows('barang_keluar.update') || Gate::allows('barang_keluar.delete') ){

                        $html = "";
                        if ( Gate::allows('barang_keluar.update') ){
                            $btnUpdate = '<a href="' . route('barang_keluar.edit', ['id' => $data->id]) . '"><button type="button" class="btn btn-warning btn-round btn-sm mb-1" data-toggle="modal" data-target="#edit-barang" data-id="' . $data->id . '"><i class="ti-pencil-alt"></i>' . __('Edit') . '</button> </a>';
                        }else {
                            $btnUpdate = '';
                        }

                        if ( Gate::allows('barang_keluar.detail') ){
                            $btnDetail = '<button type="button" class="btn btn-primary btn-round btn-sm mb-1 detail-barang_keluar" data-toggle="modal" data-target="#detail-barang" data-id="' . $data->id . '"><i class="ti-info-alt"></i>' . __('Detail') . '</button>';
                        }else {
                            $btnDetail = '';
                        }

                        if ( Gate::allows('barang_keluar.delete') != false ){
                                $html = '<form action="' . route('barang_keluar.destroy', ['id' => $data->id]) . '" method="POST">' . csrf_field() . $btnDetail . $btnUpdate .'
            
                                <button class="btn btn-danger btn-round btn-sm mb-1 destroy" data-barang="' . $data->nama . '" type="submit"><i class="ti-trash"></i>' . __('Delete') . '</button>
                            </form>';
                        }else {
                            if ( isset($btnDetail) ){
                                $html .= $btnDetail;
                            }
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
        $title = "Barang Keluar";
        return view('barang_keluar.index', compact('title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = "Tambah - Barang Keluar";
        $barang = Barang::where('active', 1)->orderBy('id', 'DESC')->get();
        if ( !in_array(auth()->user()->role->id, [1, 1]) && ( auth()->user()->id_gudang != 0 || auth()->user()->id_gudang != null ) ){
            $gudang = Gudang::where('id', auth()->user()->id_gudang)->where('active', 1)->with(['rak'])->orderBy('id', 'DESC')->get();
        }else {
            $gudang = Gudang::where('active', 1)->with(['rak'])->orderBy('id', 'DESC')->get();
        }
        $satuan_pemakai = SatuanPemakai::where('active', 1)->orderBy('id', 'DESC')->get();
        return view('barang_keluar.create', compact('title', 'barang', 'gudang', 'satuan_pemakai'));
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
            
            $barang_keluar = new BarangKeluar;
    
            $barang_keluar->nomor_surat = $request->nomor_surat ?? NULL;
            $barang_keluar->nomor_nota_dinas = $request->nomor_nota_dinas ?? NULL;
            $barang_keluar->nomor_ba = $request->nomor_ba ?? NULL;
            $barang_keluar->nomor_sa = $request->nomor_sa ?? '';
            $barang_keluar->tanggal_input = $request->tanggal_input ?? NULL;
            $barang_keluar->active = 1;
            $barang_keluar->keterangan = $request->keterangan ?? '';
            $barang_keluar->id_gudang = $request->id_gudang;
            $barang_keluar->id_satuan_pemakai = $request->id_satuan_pemakai;
            $barang_keluar->updated_by = Auth::user()->id;
            $barang_keluar->save();

            foreach ( $request->id_barang as $key => $id_barang ){
                $detail_barang_keluar = new DetailBarangKeluar;
    
                $detail_barang_keluar->id_barang_keluar = $barang_keluar->id;
                $detail_barang_keluar->tahun_anggaran = $request->tahun_anggaran[$key];
                $detail_barang_keluar->harga = ($request->harga[$key]) ? (double) str_replace(',', '', $request->harga[$key]) : NULL;
                $detail_barang_keluar->jumlah = ($request->jumlah[$key]) ? (double) str_replace(',', '', $request->jumlah[$key]) : NULL;
                $detail_barang_keluar->keterangan = $request->keterangan_detail[$key] ?? '';
                $detail_barang_keluar->id_barang = $request->id_barang[$key];
                $detail_barang_keluar->save();
            }

            DB::commit();
            toastr()->success('Barang Keluar telah ditambahkan.');
            return redirect()->route('barang_keluar.index');
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
    public function show(BarangKeluar $barang_keluar, $id)
    {
        $data = BarangKeluar::find($id);
        $html = view('barang_keluar.detail', compact('data'))->render();
        return $html;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\barang  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(BarangKeluar $barang_keluar, $id)
    {
        if ( count(BarangKeluar::where(['id' => $id, 'active' => 1])->get()) > 0 ){
            $title = "Ubah - Barang Keluar";
            $barang = Barang::get();
            if ( !in_array(auth()->user()->role->id, [1, 1]) && ( auth()->user()->id_gudang != 0 || auth()->user()->id_gudang != null ) ){
                $gudang = Gudang::where('id', auth()->user()->id_gudang)->where('active', 1)->with(['rak'])->orderBy('id', 'DESC')->get();
            }else {
                $gudang = Gudang::where('active', 1)->with(['rak'])->orderBy('id', 'DESC')->get();
            }
            $satuan_pemakai = SatuanPemakai::get();
            $barang_keluar = BarangKeluar::where('id', $id)->where('active', 1)->with(['details', 'details.barang', 'gudang', 'satuan_pemakai', 'updated_by'])->first();
            return view('barang_keluar.update', compact('title', 'barang_keluar', 'barang', 'gudang', 'satuan_pemakai'));
        }else {
            toastr()->error('Barang Keluar tidak ditemukan.');
            return redirect()->route('barang_keluar.index');
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Barang  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if ( count(BarangKeluar::where(['id' => $id, 'active' => 1])->get()) > 0 ){
            try {
                DB::beginTransaction();

                $barang_keluar = BarangKeluar::find($id);
        
                $barang_keluar->nomor_surat = $request->nomor_surat ?? NULL;
                $barang_keluar->nomor_nota_dinas = $request->nomor_nota_dinas ?? NULL;
                $barang_keluar->nomor_ba = $request->nomor_ba ?? NULL;
                $barang_keluar->nomor_sa = $request->nomor_sa ?? '';
                $barang_keluar->tanggal_input = $request->tanggal_input ?? NULL;
                $barang_keluar->active = 1;
                $barang_keluar->keterangan = $request->keterangan ?? '';
                $barang_keluar->id_gudang = $request->id_gudang;
                $barang_keluar->id_satuan_pemakai = $request->id_satuan_pemakai;
                $barang_keluar->updated_by = Auth::user()->id;
                $barang_keluar->save();
        
                foreach ( $barang_keluar->details as $keyz => $detail ){
                    if ( !in_array($detail->id, $request->id_detail) ){
                        DetailBarangKeluar::find($detail->id)->delete();
                    }
                }

                foreach ( $request->id_barang as $key => $id_barang ){
                    if ( $request->id_detail[$key] != 0 ){
                        $detail_barang_keluar = DetailBarangKeluar::find($request->id_detail[$key]);
            
                        $detail_barang_keluar->id_barang_keluar = $barang_keluar->id;
                        $detail_barang_keluar->tahun_anggaran = $request->tahun_anggaran[$key];
                        $detail_barang_keluar->harga = ($request->harga[$key]) ? (double) str_replace(',', '', $request->harga[$key]) : NULL;
                        $detail_barang_keluar->jumlah = ($request->jumlah[$key]) ? (double) str_replace(',', '', $request->jumlah[$key]) : NULL;
                        $detail_barang_keluar->keterangan = $request->keterangan_detail[$key] ?? '';
                        $detail_barang_keluar->id_barang = $request->id_barang[$key];
                        $detail_barang_keluar->save();
                    }else {
                        $detail_barang_keluar = new DetailBarangKeluar;
            
                        $detail_barang_keluar->id_barang_keluar = $barang_keluar->id;
                        $detail_barang_keluar->tahun_anggaran = $request->tahun_anggaran[$key];
                        $detail_barang_keluar->harga = ($request->harga[$key]) ? (double) str_replace(',', '', $request->harga[$key]) : NULL;
                        $detail_barang_keluar->jumlah = ($request->jumlah[$key]) ? (double) str_replace(',', '', $request->jumlah[$key]) : NULL;
                        $detail_barang_keluar->keterangan = $request->keterangan_detail[$key] ?? '';
                        $detail_barang_keluar->id_barang = $request->id_barang[$key];
                        $detail_barang_keluar->save();
                    }
                }
                DB::commit();
                toastr()->success('Barang Keluar telah diubah.');
                return redirect()->route('barang_keluar.index');
            } catch (\Exception $e) {
                DB::rollBack();
                toastr()->error("Somethings wrong...");
                toastr()->error($e->getMessage());
                return redirect()->back();
            }
        }else {
            toastr()->error('Barang Keluar tidak ditemukan.');
            return redirect()->route('barang_keluar.index');
        }
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Barang  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if ( count(BarangKeluar::where(['id' => $id, 'active' => 1])->get()) > 0 ){
            $barang_keluar = BarangKeluar::find($id);

            foreach ( $barang_keluar->details as $keyz => $detail ){
                DetailBarangKeluar::find($detail->id)->delete();
            }

            if ( $barang_keluar->delete() ){
                toastr()->success('Barang Keluar telah dihapus.');
                return redirect()->route('barang_keluar.index');
            }
        }else {
            toastr()->error('Barang Keluar tidak ditemukan.');
            return redirect()->route('barang_keluar.index');
        }
    }

}