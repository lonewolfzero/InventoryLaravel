<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use App\Dashboard;
use Auth;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }
    
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $title = 'Dashboard';

        if ( $request->ajax() ){
            try {
                $q = $request->_q;
                $check = true;
                $data = Dashboard::all()->toArray();
    
                if ( $q == 'nota_dinas_keluar_belum_bersurat' && Gate::allows('dashboard.nota_dinas') ){
                    $key = 0;
                    $icon = 'ti-email';
                }elseif ( $q == 'transaksi_masuk' && Gate::allows('dashboard.transaksi_masuk') ){
                    $key = 1;
                    $icon = 'ti-home';
                }elseif ( $q == 'transaksi_keluar' && Gate::allows('dashboard.transaksi_keluar') ){
                    $key = 2;
                    $icon = 'ti-shopping-cart';
                }elseif ( $q == 'transaksi_masuk_tanpa_ba' && Gate::allows('dashboard.transaksi_masuk_tanpa_ba') ){
                    $key = 3;
                    $icon = 'ti-email';
                }elseif ( $q == 'transaksi_keluar_tanpa_ba' && Gate::allows('dashboard.transaksi_keluar_tanpa_ba') ){
                    $key = 4;
                    $icon = 'ti-email';
                }else {
                    $check = false;
                }
    
                if ( !$check && Gate::any(['dashboard.nota_dinas', 'dashboard.transaksi_masuk', 'dashboard.transaksi_masuk_tanpa_ba', 'dashboard.transaksi_keluar', 'dashboard.transaksi_keluar_tanpa_ba']) ){
                    return response()->json(['error' => 'Unathorized Access'], 401);
                }elseif ( !$check ){
                    return response()->json(['error' => 'Data Dashboard tidak tidak ditemukan'], 404);
                }
                
                $data[$key]['icon'] = $icon;
                return response()->json($data[$key]);
            } catch (\Exception $e) {
                DB::rollBack();
                return response()->json(['error' => $e->getMessage()], 500);
            }
        }

        return view('dashboard.home', compact("title"));
    }
}
