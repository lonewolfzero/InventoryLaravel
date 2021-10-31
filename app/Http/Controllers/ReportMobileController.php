<?php

namespace App\Http\Controllers;

use App\BarangMasuk;
use App\BarangKeluar;
use App\StockAkhir;
use App\HistoryKeluarMasuk;
use App\Gudang;
use DB;
use Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;

class ReportMobileController extends Controller2
{
    public function stock(Request $request)
    {
        if ( request()->ajax() )
		{
            $data = new StockAkhir;

            // if ( !empty($request->startDate) && !empty($request->endDate) ){
            //     $from = $request->startDate;
            //     $to = $request->endDate;
            //     $data = $data->whereBetween('tanggal', [$from, $to])->with(['gudang', 'barang'])->get();
            // }else {
            //     $data = $data->whereDate('tanggal', '>', Carbon::now()->subDays(30))->with(['gudang', 'barang'])->get();
            // }
            
          
			if ( !empty($request->id_gudang) ){
				$data = $data->where('id_gudang', $request->id_gudang)->with(['gudang', 'barang'])->get();
			}else {
				$data = $data->with(['gudang', 'barang'])->get();
			}
            
    
            return datatables()->of($data)
                ->addColumn('gudang', function($data){
                    return $data->gudang->nama ?? '';
                })
                ->addColumn('barang', function($data){
                    return $data->barang->nama ?? '';
                })
                ->editColumn('harga', function($data){
                    return number_format($data->harga,2,',','.');
                })
                ->addIndexColumn()
                ->make(true);
        }
        
		$title = "Laporan Stock";
		
        $gudang = Gudang::where('active', 1)->get();
        
        return view('reportmobile.stock', compact('title', 'gudang'));
    }
	
	public function nota_dinas(Request $request)
    {
        if ( request()->ajax() ){
            $data = BarangKeluar::where('active', 1)->where('nomor_surat', '')->where('nomor_nota_dinas', '!=', '');

            if ( !empty($request->startDate) && !empty($request->endDate) ){
                $from = $request->startDate;
                $to = $request->endDate;
                $data->whereBetween('created_at', [$from, $to]);
            }else {
                $data->whereDate('created_at', '>', Carbon::now()->subDays(30));
            }
            
            if ( !empty($request->id_gudang) ){
                $data->where('id_gudang', $request->id_gudang);
            }

            $data->with(['gudang', 'satuan_pemakai'])->get();
            return datatables()->of($data)
                ->addColumn('gudang', function($data){
                    return $data->gudang->nama;
                })
                ->addColumn('satuan_pemakai', function($data){
                    return $data->satuan_pemakai->nama;
                })

                ->addColumn('actions', function($data){
                    if ( Gate::allows('report.detail_nota_dinas') ){

                        $btnPrint = '<a href="' . route('report.detail_nota_dinas', ['id' => $data->id]) . '" target="_blank"><button type="button" class="btn btn-success btn-round btn-sm mb-1 print-detail_nota_dinas" data-id="' . $data->id . '"><i class="ti-printer"></i>' . __('Print') . '</button> </a>';

                        $html = $btnPrint;
                    }else {
                        $html = '';
                    }
                        return $html;
                    })
                ->rawColumns(['actions'])
                ->addIndexColumn()
                ->make(true);
        }
        $title = "Laporan Nota Dinas";
        $gudang = Gudang::where('active', 1)->get();
        return view('reportmobile.nota_dinas', compact('title', 'gudang'));
    }

    public function detail_nota_dinas(Request $request, $id)
    {
        $data = BarangKeluar::where('active', 1)->where('id', $id)->count();
        if ( $data ){
            $data = BarangKeluar::find($id);
            $title = 'Detail Nota Dinas';
            return view('reportmobile.detail_nota_dinas', compact('data', 'title'));
        }else {
            return response()->abort(401);
        }

    }


    public function barang_masuk(Request $request)
    {
         if ( request()->ajax() ){
            $data = BarangMasuk::where('active', 1);

            if ( !empty($request->startDate) && !empty($request->endDate) ){
                $from = $request->startDate;
                $to = $request->endDate;
                $data->whereBetween('created_at', [$from, $to]);
            }else {
                $data->whereDate('created_at', '>', Carbon::now()->subDays(30));
            }
            
            if ( !empty($request->id_gudang) ){
                $data->where('id_gudang', $request->id_gudang);
            }

            $data->with(['gudang', 'rekanan'])->get();
            return datatables()->of($data)
                ->addColumn('gudang', function($data){
                    return $data->gudang->nama;
                })
                ->addColumn('rekanan', function($data){
                    return $data->rekanan->nama;
                })

                ->addColumn('actions', function($data){
                    if ( Gate::allows('report.detail_barang_masuk') ){

                        $btnPrint = '<a href="' . route('report.detail_barang_masuk', ['id' => $data->id]) . '" target="_blank"><button type="button" class="btn btn-success btn-round btn-sm mb-1 print-detail_barang_masuk" data-id="' . $data->id . '"><i class="ti-printer"></i>' . __('Print') . '</button> </a>';

                        $html = $btnPrint;
                    }else {
                        $html = '';
                    }
                        return $html;
                    })
                ->rawColumns(['actions'])
                ->addIndexColumn()
                ->make(true);
        }
        $title = "Laporan Barang Masuk";
        $gudang = Gudang::where('active', 1)->get();
        return view('reportmobile.barang_masuk', compact('title', 'gudang'));
    }

    public function detail_barang_masuk(Request $request, $id)
    {
        $data = BarangMasuk::where('active', 1)->where('id', $id)->count();
        if ( $data ){
            $data = BarangMasuk::find($id);
            $title = 'Detail Barang Masuk';
            return view('reportmobile.detail_barang_masuk', compact('data', 'title'));
        }else {
            return response()->abort(401);
        }

    }

    public function barang_keluar(Request $request)
    {
        if ( request()->ajax() ){
            $data = BarangKeluar::where('active', 1)->where('nomor_surat', '!=', '');

            if ( !empty($request->startDate) && !empty($request->endDate) ){
                $from = $request->startDate;
                $to = $request->endDate;
                $data->whereBetween('created_at', [$from, $to]);
            }else {
                $data->whereDate('created_at', '>', Carbon::now()->subDays(30));
            }
            
            if ( !empty($request->id_gudang) ){
                $data->where('id_gudang', $request->id_gudang);
            }

            $data->with(['gudang', 'satuan_pemakai'])->get();
            return datatables()->of($data)
                ->addColumn('gudang', function($data){
                    return $data->gudang->nama;
                })
                ->addColumn('satuan_pemakai', function($data){
                    return $data->satuan_pemakai->nama;
                })

                ->addColumn('actions', function($data){
                    if ( Gate::allows('report.detail_barang_keluar') ){

                        $btnPrint = '<a href="' . route('report.detail_barang_keluar', ['id' => $data->id]) . '" target="_blank"><button type="button" class="btn btn-success btn-round btn-sm mb-1 print-detail_barang_keluar" data-id="' . $data->id . '"><i class="ti-printer"></i>' . __('Print') . '</button> </a>';

                        $html = $btnPrint;
                    }else {
                        $html = '';
                    }
                        return $html;
                    })
                ->rawColumns(['actions'])
                ->addIndexColumn()
                ->make(true);
        }
		
        $title = "Laporan Barang Keluar";
        $gudang = Gudang::where('active', 1)->get();
        return view('reportmobile.barang_keluar', compact('title', 'gudang'));
    }

    public function detail_barang_keluar(Request $request, $id)
    {
        $data = BarangKeluar::where('active', 1)->where('id', $id)->count();
        if ( $data ){
            $data = BarangKeluar::find($id);
            $title = 'Detail Barang Keluar';
            return view('reportmobile.detail_barang_keluar', compact('data', 'title'));
        }else {
            return response()->abort(401);
        }

    }
}
