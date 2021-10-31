<?php

namespace App\Http\Controllers;

use App\BarangMasuk;
use App\BarangKeluar;
use App\StockAkhir;
use App\HistoryKeluarMasuk;
use App\Gudang;
use DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function stock(Request $request)
    {
        if ( request()->ajax() ){
            $data = new StockAkhir;

            // if ( !empty($request->startDate) && !empty($request->endDate) ){
            //     $from = $request->startDate;
            //     $to = $request->endDate;
            //     $data = $data->whereBetween('tanggal', [$from, $to])->with(['gudang', 'barang'])->get();
            // }else {
            //     $data = $data->whereDate('tanggal', '>', Carbon::now()->subDays(30))->with(['gudang', 'barang'])->get();
            // }
            
            if ( !in_array(auth()->user()->role->id, [1, 1]) && ( auth()->user()->id_gudang != 0 || auth()->user()->id_gudang != null ) ){
                if ( !empty($request->id_gudang) ){
                    $data = $data->where('id_gudang', auth()->user()->id_gudang)->where('id_gudang', $request->id_gudang)->with(['gudang', 'barang'])->get();
                }else {
                    $data = $data->where('id_gudang', auth()->user()->id_gudang)->with(['gudang', 'barang'])->get();
                }
            }else {
                if ( !empty($request->id_gudang) ){
                    $data = $data->where('id_gudang', $request->id_gudang)->with(['gudang', 'barang'])->get();
                }else {
                    $data = $data->with(['gudang', 'barang'])->get();
                }
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
        if ( !in_array(auth()->user()->role->id, [1, 1]) && ( auth()->user()->id_gudang != 0 || auth()->user()->id_gudang != null ) ){
            $gudang = Gudang::where('id', auth()->user()->id_gudang)->where('active', 1)->get();
        }else {
            $gudang = Gudang::where('active', 1)->get();
        }
        return view('report.stock', compact('title', 'gudang'));
    }

    public function laporan_bulanan(Request $request)
    {
        if ( request()->ajax() ){
            if ( !in_array(auth()->user()->role->id, [1, 1]) && ( auth()->user()->id_gudang != 0 || auth()->user()->id_gudang != null ) ){
                $id_gudang = auth()->user()->id_gudang;
            }else {
                if ( empty($request->id_gudang) ){
                    $id_gudang = Gudang::first()->id;
                }else {
                    $id_gudang = $request->id_gudang;
                }
            }

            if ( empty($request->tahun) || empty($request->bulan) ){
                $tahun = Carbon::now()->subMonths(16)->year;
                $bulan = Carbon::now()->subMonths(16)->month;
            }else {
                $tahun = $request->tahun;
                $bulan = $request->bulan;
            }
            
            $data = DB::select('call p_lapbul(?, ?, ?)', array($id_gudang, $tahun, $bulan));

            return datatables()->of($data)
            ->addIndexColumn()
            ->make(true);

            // $data = new HistoryKeluarMasuk;

            // if ( !empty($request->startDate) && !empty($request->endDate) ){
            //     $from = $request->startDate;
            //     $to = $request->endDate;
            //     $data = $data->whereBetween('tanggal', [$from, $to])->with(['gudang', 'barang'])->get();
            // }else {
            //     $data = $data->whereDate('tanggal', '>', Carbon::now()->subDays(3000))->with(['gudang', 'barang'])->get();
            // }
            
            // if ( !empty($request->id_gudang) ){
            //     $data = $data->where('id_gudang', $request->id_gudang);
            // }
            
            // return datatables()->of($data)
                // ->addColumn('gudang', function($data){
                //     return $data->gudang->nama;
                // })
                // ->addColumn('barang', function($data){
                //     return $data->barang->nama;
                // })
                // ->editColumn('harga', function($data){
                //     return number_format($data->harga,2,',','.');
                // })
                // ->editColumn('biaya', function($data){
                //     return number_format($data->biaya,2,',','.');
                // })
                // ->addIndexColumn()
                // ->make(true);

        }
        $title = "Laporan Bulanan";
        if ( !in_array(auth()->user()->role->id, [1, 1]) && ( auth()->user()->id_gudang != 0 || auth()->user()->id_gudang != null ) ){
            $gudang = Gudang::where('id', auth()->user()->id_gudang)->where('active', 1)->get();
        }else {
            $gudang = Gudang::where('active', 1)->get();
        }
        return view('report.laporan_bulanan', compact('title', 'gudang'));
    }

    public function nota_dinas(Request $request)
    {
        if ( request()->ajax() ){
            // $data = BarangKeluar::where('active', 1)->where('nomor_surat', '')->where('nomor_nota_dinas', '!=', '');
            $data = BarangKeluar::where('active', 1);

            if ( !empty($request->startDate) && !empty($request->endDate) ){
                $from = $request->startDate;
                $to = $request->endDate;
                $data->whereBetween('tanggal_input', [$from, $to]);
            }else {
                $data->whereDate('tanggal_input', '>', Carbon::now()->subDays(30));
            }
            
            if ( !in_array(auth()->user()->role->id, [1, 1]) && ( auth()->user()->id_gudang != 0 || auth()->user()->id_gudang != null ) ){
                $data->where('id_gudang', auth()->user()->id_gudang);
            }else {
                if ( !empty($request->id_gudang) ){
                    $data->where('id_gudang', $request->id_gudang);
                }
            }

            $data = $data->with(['gudang', 'satuan_pemakai'])->get();
            return datatables()->of($data->where('nota_dinas', true))
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
        if ( !in_array(auth()->user()->role->id, [1, 1]) && ( auth()->user()->id_gudang != 0 || auth()->user()->id_gudang != null ) ){
            $gudang = Gudang::where('id', auth()->user()->id_gudang)->where('active', 1)->get();
        }else {
            $gudang = Gudang::where('active', 1)->get();
        }
        return view('report.nota_dinas', compact('title', 'gudang'));
    }

    public function detail_nota_dinas(Request $request, $id)
    {
        $data = BarangKeluar::where('active', 1)->where('id', $id)->count();
        if ( $data ){
            $data = BarangKeluar::find($id);
            $title = 'Detail Nota Dinas';
            return view('report.detail_nota_dinas', compact('data', 'title'));
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
                $data->whereBetween('tanggal_input', [$from, $to]);
            }else {
                $data->whereDate('tanggal_input', '>', Carbon::now()->subDays(30));
            }
            
            if ( !in_array(auth()->user()->role->id, [1, 1]) && ( auth()->user()->id_gudang != 0 || auth()->user()->id_gudang != null ) ){
                $data->where('id_gudang', auth()->user()->id_gudang);
            }else {
                if ( !empty($request->id_gudang) ){
                    $data->where('id_gudang', $request->id_gudang);
                }
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
        if ( !in_array(auth()->user()->role->id, [1, 1]) && ( auth()->user()->id_gudang != 0 || auth()->user()->id_gudang != null ) ){
            $gudang = Gudang::where('id', auth()->user()->id_gudang)->where('active', 1)->get();
        }else {
            $gudang = Gudang::where('active', 1)->get();
        }
        return view('report.barang_masuk', compact('title', 'gudang'));
    }

    public function detail_barang_masuk(Request $request, $id)
    {
        $data = BarangMasuk::where('active', 1)->where('id', $id)->count();
        if ( $data ){
            $data = BarangMasuk::find($id);
            $title = 'Detail Barang Masuk';
            return view('report.detail_barang_masuk', compact('data', 'title'));
        }else {
            return response()->abort(401);
        }

    }

    public function barang_keluar(Request $request)
    {
        if ( request()->ajax() ){
            // $data = BarangKeluar::where('active', 1)->where('nomor_surat', '!=', '');
            $data = BarangKeluar::where('active', 1);
            if ( !empty($request->startDate) && !empty($request->endDate) ){
                $from = $request->startDate;
                $to = $request->endDate;
                $data->whereBetween('tanggal_input', [$from, $to]);
            }else {
                $data->whereDate('tanggal_input', '>', Carbon::now()->subDays(30));
            }
            
            if ( !in_array(auth()->user()->role->id, [1, 1]) && ( auth()->user()->id_gudang != 0 || auth()->user()->id_gudang != null ) ){
                $data->where('id_gudang', auth()->user()->id_gudang);
            }else {
                if ( !empty($request->id_gudang) ){
                    $data->where('id_gudang', $request->id_gudang);
                }
            }

            $data = $data->with(['gudang', 'satuan_pemakai'])->get();
            return datatables()->of($data->where('nota_dinas', false))
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
        if ( !in_array(auth()->user()->role->id, [1, 1]) && ( auth()->user()->id_gudang != 0 || auth()->user()->id_gudang != null ) ){
            $gudang = Gudang::where('id', auth()->user()->id_gudang)->where('active', 1)->get();
        }else {
            $gudang = Gudang::where('active', 1)->get();
        }
        return view('report.barang_keluar', compact('title', 'gudang'));
    }

    public function detail_barang_keluar(Request $request, $id)
    {
        $data = BarangKeluar::where('active', 1)->where('id', $id)->count();
        if ( $data ){
            $data = BarangKeluar::find($id);
            $title = 'Detail Barang Keluar';
            return view('report.detail_barang_keluar', compact('data', 'title'));
        }else {
            return response()->abort(401);
        }

    }
}
