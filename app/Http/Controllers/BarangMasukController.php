<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use App\BarangMasuk;
use App\DetailBarangMasuk;
use App\Barang;
use App\Gudang;
use App\Rekanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Database\Eloquent\Builder;

class BarangMasukController extends Controller
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

            // if ( !in_array(auth()->user()->role->id, [1, 1]) && ( auth()->user()->id_gudang != 0 || auth()->user()->id_gudang != null ) ){
            //     $data = BarangMasuk::where('active', 1)->where('id_gudang', auth()->user()->id_gudang)->with(['gudang', 'rekanan'])->orderBy('id', 'DESC')->get();
            // }else {
            //      $data = BarangMasuk::where('active', 1)->with(['gudang', 'rekanan'])->orderBy('id', 'DESC')->get();
            // }

            if ( !in_array(auth()->user()->role->id, [1, 1]) && ( auth()->user()->id_gudang != 0 || auth()->user()->id_gudang != null ) ){
                $data = BarangMasuk::where('active', 1)->where('id_gudang', auth()->user()->id_gudang)->with(['gudang', 'rekanan'])->orderBy('id', 'DESC')->get();
            }else {
                $data = BarangMasuk::where('active', 1)->with(['gudang', 'rekanan'])->orderBy('id', 'DESC')->get();
            }
            
            return datatables()->of($data)
                ->addColumn('gudang', function($data){
                    return $data->gudang->nama;
                })
                ->addColumn('rekanan', function($data){
                    return $data->rekanan->nama;
                })

                ->addColumn('actions', function($data){
                    if ( Gate::allows('barang_masuk.detail') || Gate::allows('barang_masuk.update') || Gate::allows('barang_masuk.delete') ){

                        $html = "";
                        if ( Gate::allows('barang_masuk.update') ){
                            $btnUpdate = '<a href="' . route('barang_masuk.edit', ['id' => $data->id]) . '"><button type="button" class="btn btn-warning btn-round btn-sm mb-1" data-toggle="modal" data-target="#edit-barang" data-id="' . $data->id . '"><i class="ti-pencil-alt"></i>' . __('Edit') . '</button> </a>';
                        }else {
                            $btnUpdate = '';
                        }

                        if ( Gate::allows('barang_masuk.detail') ){
                            $btnDetail = '<button type="button" class="btn btn-primary btn-round btn-sm mb-1 detail-barang_masuk" data-toggle="modal" data-target="#detail-barang" data-id="' . $data->id . '"><i class="ti-info-alt"></i>' . __('Detail') . '</button>';
                        }else {
                            $btnDetail = '';
                        }


                        if ( Gate::allows('barang_masuk.delete') != false ){
                                $html = '<form action="' . route('barang_masuk.destroy', ['id' => $data->id]) . '" method="POST">' . csrf_field() . $btnDetail . $btnUpdate .'
            
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
        $title = "Barang Masuk";
        return view('barang_masuk.index', compact('title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = "Tambah - Barang Masuk";
        $barang = Barang::where('active', 1)->orderBy('id', 'DESC')->get();
        if ( !in_array(auth()->user()->role->id, [1, 1]) && ( auth()->user()->id_gudang != 0 || auth()->user()->id_gudang != null ) ){
            $gudang = Gudang::where('id', auth()->user()->id_gudang)->where('active', 1)->with(['rak'])->orderBy('id', 'DESC')->get();
        }else {
            $gudang = Gudang::where('active', 1)->with(['rak'])->orderBy('id', 'DESC')->get();
        }
        $rekanan = rekanan::where('active', 1)->orderBy('id', 'DESC')->get();
        return view('barang_masuk.create', compact('title', 'barang', 'gudang', 'rekanan'));
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
            $barang_masuk = new BarangMasuk;
    
            $barang_masuk->nomor_ba = $request->nomor_ba ?? NULL;
            $barang_masuk->nomor_kontrak = $request->nomor_kontrak ?? '';
            $barang_masuk->nomor_kph = $request->nomor_kph ?? '';
            $barang_masuk->nomor_surat = $request->nomor_surat ?? NULL;
            $barang_masuk->tahun_anggaran = $request->tahun_anggaran ?? NULL;
            $barang_masuk->tanggal_input = $request->tanggal_input ?? NULL;
            $barang_masuk->active = 1;
            $barang_masuk->keterangan = $request->keterangan ?? '';
            $barang_masuk->id_gudang = $request->id_gudang;
            $barang_masuk->id_rekanan = $request->id_rekanan;
            $barang_masuk->updated_by = Auth::user()->id;
            $barang_masuk->save();

            foreach ( $request->id_barang as $key => $id_barang ){
                $detail_barang_masuk = new DetailBarangMasuk;
    
                $detail_barang_masuk->id_barang_masuk = $barang_masuk->id;
                $detail_barang_masuk->harga = ($request->harga[$key]) ? (double) str_replace(',', '', $request->harga[$key]) : NULL;
                $detail_barang_masuk->jumlah = ($request->jumlah[$key]) ? (double) str_replace(',', '', $request->jumlah[$key]) : NULL;
                $detail_barang_masuk->keterangan = $request->keterangan_detail[$key] ?? '';
                $detail_barang_masuk->id_barang = $request->id_barang[$key];
                $detail_barang_masuk->save();
            }

            DB::commit();
            toastr()->success('Barang Masuk telah ditambahkan.');
            return redirect()->route('barang_masuk.index');
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
    public function show(Barang $barang, $id)
    {
        $data = BarangMasuk::find($id);
        $html = view('barang_masuk.detail', compact('data'))->render();
        return $html;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\barang  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(Barang $barang, $id)
    {
        if ( count(BarangMasuk::where(['id' => $id, 'active' => 1])->get()) > 0 ){
            $title = "Ubah - Barang Masuk";
            $barang = Barang::where('active', 1)->orderBy('id', 'DESC')->get();
            if ( !in_array(auth()->user()->role->id, [1, 1]) && ( auth()->user()->id_gudang != 0 || auth()->user()->id_gudang != null ) ){
                $gudang = Gudang::where('id', auth()->user()->id_gudang)->where('active', 1)->with(['rak'])->orderBy('id', 'DESC')->get();
            }else {
                $gudang = Gudang::where('active', 1)->with(['rak'])->orderBy('id', 'DESC')->get();
            }
            $rekanan = rekanan::where('active', 1)->orderBy('id', 'DESC')->get();
            $barang_masuk = BarangMasuk::where('id', $id)->where('active', 1)->with(['details', 'details.barang', 'gudang', 'rekanan', 'updated_by'])->first();
            return view('barang_masuk.update', compact('title', 'barang_masuk', 'barang', 'gudang', 'rekanan'));
        }else {
            toastr()->error('Barang Masuk tidak ditemukan.');
            return redirect()->route('barang_masuk.index');
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
        if ( count(BarangMasuk::where(['id' => $id, 'active' => 1])->get()) > 0 ){
            try {
                $barang_masuk = BarangMasuk::find($id);
        
                $barang_masuk->nomor_ba = $request->nomor_ba ?? NULL;
                $barang_masuk->nomor_kontrak = $request->nomor_kontrak ?? '';
                $barang_masuk->nomor_kph = $request->nomor_kph ?? '';
                $barang_masuk->nomor_surat = $request->nomor_surat ?? NULL;
                $barang_masuk->tahun_anggaran = $request->tahun_anggaran ?? NULL;
                $barang_masuk->tanggal_input = $request->tanggal_input ?? NULL;
                $barang_masuk->active = 1;
                $barang_masuk->keterangan = $request->keterangan ?? '';
                $barang_masuk->id_gudang = $request->id_gudang;
                $barang_masuk->id_rekanan = $request->id_rekanan;
                $barang_masuk->updated_by = Auth::user()->id;
                $barang_masuk->save();
    
                foreach ( $barang_masuk->details as $keyz => $detail ){
                    if ( !in_array($detail->id, $request->id_detail) ){
                        DetailBarangMasuk::find($detail->id)->delete();
                    }
                }

                foreach ( $request->id_barang as $key => $id_barang ){
                    if ( $request->id_detail[$key] != 0 ){
                        $detail_barang_masuk = DetailBarangMasuk::find($request->id_detail[$key]);
            
                        $detail_barang_masuk->id_barang_masuk = $barang_masuk->id;
                        $detail_barang_masuk->harga = ($request->harga[$key]) ? (double) str_replace(',', '', $request->harga[$key]) : NULL;
                        $detail_barang_masuk->jumlah = ($request->jumlah[$key]) ? (double) str_replace(',', '', $request->jumlah[$key]) : NULL;
                        $detail_barang_masuk->keterangan = $request->keterangan_detail[$key] ?? '';
                        $detail_barang_masuk->id_barang = $request->id_barang[$key];
                        $detail_barang_masuk->save();
                    }else {
                        $detail_barang_masuk = new DetailBarangMasuk;
            
                        $detail_barang_masuk->id_barang_masuk = $barang_masuk->id;
                        $detail_barang_masuk->harga = ($request->harga[$key]) ? (double) str_replace(',', '', $request->harga[$key]) : NULL;
                        $detail_barang_masuk->jumlah = ($request->jumlah[$key]) ? (double) str_replace(',', '', $request->jumlah[$key]) : NULL;
                        $detail_barang_masuk->keterangan = $request->keterangan_detail[$key] ?? '';
                        $detail_barang_masuk->id_barang = $request->id_barang[$key];
                        $detail_barang_masuk->save();
                    }
                }
                toastr()->success('Barang Masuk telah diubah.');
                return redirect()->route('barang_masuk.index');
            } catch (\Exception $e) {
                toastr()->error("Somethings wrong...");
                toastr()->error($e->getMessage());
                return redirect()->back();
            }
        }else {
            toastr()->error('Barang Masuk tidak ditemukan.');
            return redirect()->route('barang_masuk.index');
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
        if ( count(BarangMasuk::where(['id' => $id, 'active' => 1])->get()) > 0 ){
            $barang_masuk = BarangMasuk::find($id);

            foreach ( $barang_masuk->details as $keyz => $detail ){
                DetailBarangMasuk::find($detail->id)->delete();
            }

            if ( $barang_masuk->delete() ){
                toastr()->success('Barang Masuk telah dihapus.');
                return redirect()->route('barang_masuk.index');
            }
        }else {
            toastr()->error('Barang Masuk tidak ditemukan.');
            return redirect()->route('barang_masuk.index');
        }
    }

}
