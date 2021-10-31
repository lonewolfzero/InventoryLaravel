<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use App\StockOpname;
use App\VStockOpnameDetail;
use App\DetailStockOpname;
use App\Barang;
use App\Gudang;
use App\Rekanan;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class StockOpnameController extends Controller
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

            if ( !in_array(auth()->user()->role->id, [1, 1]) && ( auth()->user()->id_gudang != 0 || auth()->user()->id_gudang != null ) ){
                $data = StockOpname::with(['gudang'])->where('id_gudang', auth()->user()->id_gudang)->orderBy('id', 'DESC')->get();
            }else {
                $data = StockOpname::with(['gudang'])->orderBy('id', 'DESC')->get();
            }

            // $data = StockOpname::with(['gudang'])->orderBy('id', 'DESC')->get();
            return datatables()->of($data)
                ->addColumn('gudang', function($data){
                    return $data->gudang->nama;
                })
                ->addColumn('actions', function($data){
                    if ( Gate::allows('stock_opname.update') || Gate::allows('stock_opname.update') || Gate::allows('stock_opname.delete') ){

                        $html = "";
                        if ( Gate::allows('stock_opname.update') ){
                            $btnUpdate = '<a href="' . route('stock_opname.edit', ['id' => $data->id]) . '"><button type="button" class="btn btn-warning btn-round btn-sm mb-1" data-toggle="modal" data-target="#edit-barang" data-id="' . $data->id . '"><i class="ti-pencil-alt"></i>' . __('Edit') . '</button> </a>';
                        }else {
                            $btnUpdate = '';
                        }

                        if ( Gate::allows('stock_opname.detail') ){
                            $btnDetail = '<button type="button" class="btn btn-primary btn-round btn-sm mb-1 detail-stock_opname" data-toggle="modal" data-target="#detail-barang" data-id="' . $data->id . '"><i class="ti-info-alt"></i>' . __('Detail') . '</button>';
                        }else {
                            $btnDetail = '';
                        }


                        if ( Gate::allows('stock_opname.delete') != false ){
                                $html = '<form action="' . route('stock_opname.destroy', ['id' => $data->id]) . '" method="POST">' . csrf_field() . $btnDetail . $btnUpdate .'
            
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
        $title = "Stock Opname";
        return view('stock_opname.index', compact('title'));
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
        $rekanan = Rekanan::where('active', 1)->orderBy('id', 'DESC')->get();
        return view('stock_opname.create', compact('title', 'barang', 'gudang', 'rekanan'));    
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dump((double) str_replace(',', '', $request->harga[0]));
        // dd($request->all());
        try {
            $validator = Validator::make($request->all(), [
                'nomor_stock_opname' => 'required|unique:stock_opname,nomor_stock_opname',
                'tahun_anggaran' => 'required_without:tahun_anggaran[]',
                'tahun_anggaran[]' => 'required_without:tahun_anggaran',
                'id_gudang' => 'required',
            ]);
    
            if ($validator->fails()) {
                foreach ( $validator->errors()->all() as $error ){
                    toastr()->error($error);
                }
                return redirect()->back();
            }
    
            DB::beginTransaction();
            $stock_opname = new StockOpname;
    
            $stock_opname->nomor_stock_opname = $request->nomor_stock_opname;
            $stock_opname->tanggal_pelaksanaan = $request->tanggal_pelaksanaan ?? NULL;
            $stock_opname->active = 1;
            $stock_opname->id_gudang = $request->id_gudang;
            $stock_opname->updated_by = Auth::user()->id;
            $stock_opname->save();

            foreach ( $request->id_barang as $key => $id_barang ){
                $detail_stock_opname = new DetailStockOpname;
    
                $detail_stock_opname->id_stock_opname = $stock_opname->id;
                $detail_stock_opname->id_barang = $request->id_barang[$key];
                $detail_stock_opname->tahun_anggaran = $request->tahun_anggaran[$key];
                $detail_stock_opname->harga = ($request->harga[$key]) ? (double) str_replace(',', '', $request->harga[$key]) : NULL;
                $detail_stock_opname->jumlah = ($request->jumlah[$key]) ? (double) str_replace(',', '', $request->jumlah[$key]) : NULL;
                $detail_stock_opname->keterangan = $request->keterangan_detail[$key] ?? NULL;
                $detail_stock_opname->save();
            }

            DB::commit();
            toastr()->success('Stock Opname telah ditambahkan.');
            return redirect()->route('stock_opname.index');
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
     * @param  \App\StockOpname  $stockOpname
     * @return \Illuminate\Http\Response
     */
    public function show(StockOpname $stockOpname, $id)
    {
        $data = VStockOpnameDetail::where('id_stock_opname', $id)->with(['barang'])->get();
        $html = view('stock_opname.detail', compact('data'))->render();
        return $html;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\StockOpname  $stockOpname
     * @return \Illuminate\Http\Response
     */
    public function edit(StockOpname $stockOpname, $id)
    {
        if ( count(StockOpname::where(['id' => $id, 'active' => 1])->get()) > 0 ){
            $title = "Ubah - Stock Opname";
            $barang = Barang::where('active', 1)->orderBy('id', 'DESC')->get();
            if ( !in_array(auth()->user()->role->id, [1, 1]) && ( auth()->user()->id_gudang != 0 || auth()->user()->id_gudang != null ) ){
                $gudang = Gudang::where('id', auth()->user()->id_gudang)->where('active', 1)->with(['rak'])->orderBy('id', 'DESC')->get();
            }else {
                $gudang = Gudang::where('active', 1)->with(['rak'])->orderBy('id', 'DESC')->get();
            }
            $stock_opname = StockOpname::where('id', $id)->where('active', 1)->with(['details', 'details.barang', 'gudang', 'updated_by'])->first();
            return view('stock_opname.update', compact('title', 'stock_opname', 'barang', 'gudang'));
        }else {
            toastr()->error('Stock Opname tidak ditemukan.');
            return redirect()->route('stock_opname.index');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\StockOpname  $stockOpname
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                // 'nomor_stock_opname' => 'required|unique:stock_opname,nomor_stock_opname',
                'tahun_anggaran' => 'required_without:tahun_anggaran[]',
                'tahun_anggaran[]' => 'required_without:tahun_anggaran',
                'id_gudang' => 'required',
            ]);
    
            if ($validator->fails()) {
                foreach ( $validator->errors()->all() as $error ){
                    toastr()->error($error);
                }
                return redirect()->back();
            }
    
            DB::beginTransaction();
            $stock_opname = StockOpname::find($id);
    
            $stock_opname->nomor_stock_opname = $request->nomor_stock_opname;
            $stock_opname->tanggal_pelaksanaan = ($request->tanggal_pelaksanaan) ?? NULL;
            $stock_opname->active = 1;
            $stock_opname->id_gudang = $request->id_gudang;
            $stock_opname->updated_by = Auth::user()->id;
            $stock_opname->save();

            foreach ( $stock_opname->details as $keyz => $detail ){
                if ( !in_array($detail->id, $request->id_detail) ){
                    DetailStockOpname::find($detail->id)->delete();
                }
            }

            foreach ( $request->id_barang as $key => $id_barang ){
                if ( $request->id_detail[$key] != 0 ){
                    $detail_stock_opname = DetailStockOpname::find($request->id_detail[$key]);
        
                    $detail_stock_opname->id_stock_opname = $stock_opname->id;
                    $detail_stock_opname->id_barang = $request->id_barang[$key];
                    $detail_stock_opname->tahun_anggaran = $request->tahun_anggaran[$key];
                    $detail_stock_opname->harga = ($request->harga[$key]) ? (double) str_replace(',', '', $request->harga[$key]) : NULL;
                    $detail_stock_opname->jumlah = ($request->jumlah[$key]) ? (double) str_replace(',', '', $request->jumlah[$key]) : NULL;
                    $detail_stock_opname->keterangan = $request->keterangan_detail[$key] ?? NULL;
                    $detail_stock_opname->save();
                }else {
                    $detail_stock_opname = new DetailStockOpname;
        
                    $detail_stock_opname->id_stock_opname = $stock_opname->id;
                    $detail_stock_opname->id_barang = $request->id_barang[$key];
                    $detail_stock_opname->tahun_anggaran = $request->tahun_anggaran[$key];
                    $detail_stock_opname->harga = ($request->harga[$key]) ? (double) str_replace(',', '', $request->harga[$key]) : NULL;
                    $detail_stock_opname->jumlah = ($request->jumlah[$key]) ? (double) str_replace(',', '', $request->jumlah[$key]) : NULL;
                    $detail_stock_opname->keterangan = $request->keterangan_detail[$key] ?? NULL;
                    $detail_stock_opname->save();
                }
            }
            
            DB::commit();
            toastr()->success('Stock Opname telah Diubah.');
            return redirect()->route('stock_opname.index');
        } catch (\Exception $e) {
            DB::rollback();
            toastr()->error("Somethings wrong...");
            toastr()->error($e->getMessage());
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\StockOpname  $stockOpname
     * @return \Illuminate\Http\Response
     */
    public function destroy(StockOpname $stockOpname, $id)
    {
        if ( count(StockOpname::where(['id' => $id, 'active' => 1])->get()) > 0 ){
            $stock_opname = StockOpname::find($id);

            foreach ( $stock_opname->details as $keyz => $detail ){
                DetailStockOpname::find($detail->id)->delete();
            }

            if ( $stock_opname->delete() ){
                toastr()->success('Stock Opname telah dihapus.');
                return redirect()->route('stock_opname.index');
            }
        }else {
            toastr()->error('Stock Opname tidak ditemukan.');
            return redirect()->route('stock_opname.index');
        }
    }
}
