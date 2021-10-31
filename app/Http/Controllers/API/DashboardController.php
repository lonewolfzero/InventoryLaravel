<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Dashboard;

class DashboardController extends Controller
{
    public function index(Request $request, $id)
    {
        try {
            $data = Dashboard::all()->toArray();
    
            if ( $id == 'nota_dinas_keluar_belum_bersurat'){
                $key = 0;
                $icon = 'ti-email';
            }elseif ( $id == 'transaksi_masuk' ){
                $key = 1;
                $icon = 'ti-home';
            }elseif ( $id == 'transaksi_keluar' ){
                $key = 2;
                $icon = 'ti-shopping-cart';
            }elseif ( $id == 'transaksi_masuk_tanpa_ba' ){
                $key = 3;
                $icon = 'ti-email';
            }elseif ( $id == 'transaksi_keluar_tanpa_ba' ){
                $key = 4;
                $icon = 'ti-email';
            }else {
                return response()->json(['error' => 'Data Dashboard tidak tidak ditemukan'], 404);
            }
            
            return response()->json($data[$key], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 404);
        }
    }
}
