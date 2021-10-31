<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group(['prefix' => 'v1'], function(){
    Route::post('login', 'API\UserController@login');
    Route::post('register', 'API\UserController@register');
    
    Route::group(['middleware' => ['auth:api']], function(){
        Route::get('user/detail', 'API\UserController@details');
        Route::post('logout', 'API\UserController@logout');
        
        Route::group(['prefix' => 'satuan'], function(){
            Route::get('', 'API\SatuanController@index');
            Route::get('paginate', 'API\SatuanController@paginate');
            Route::get('{id}', 'API\SatuanController@show');
            Route::post('', 'API\SatuanController@store');
            Route::patch('{id}', 'API\SatuanController@update');
            Route::delete('{id}', 'API\SatuanController@destroy');
        });
        
        Route::group(['prefix' => 'kategori'], function(){
            Route::get('', 'API\KategoriController@index');
            Route::get('paginate', 'API\KategoriController@paginate');
            Route::get('{id}', 'API\KategoriController@show');
            Route::post('', 'API\KategoriController@store');
            Route::patch('{id}', 'API\KategoriController@update');
            Route::delete('{id}', 'API\KategoriController@destroy');
        });

        Route::group(['prefix' => 'barang'], function(){
            Route::get('', 'API\BarangController@index');
            Route::get('paginate', 'API\BarangController@paginate');
            Route::get('{id}', 'API\BarangController@show');
            Route::post('', 'API\BarangController@store');
            Route::patch('{id}', 'API\BarangController@update');
            Route::delete('{id}', 'API\BarangController@destroy');
        });

        Route::group(['prefix' => 'gudang'], function(){
            Route::get('', 'API\GudangController@index');
            Route::get('paginate', 'API\GudangController@paginate');
            Route::get('{id}', 'API\GudangController@show');
            Route::post('', 'API\GudangController@store');
            Route::patch('{id}', 'API\GudangController@update');
            Route::delete('{id}', 'API\GudangController@destroy');
        });

        Route::group(['prefix' => 'rak'], function(){
            Route::get('', 'API\RakController@index');
            Route::get('paginate', 'API\RakController@paginate');
            Route::get('{id}', 'API\RakController@show');
            Route::post('', 'API\RakController@store');
            Route::patch('{id}', 'API\RakController@update');
            Route::delete('{id}', 'API\RakController@destroy');
        });

        Route::group(['prefix' => 'penyimpanan'], function(){
            Route::get('', 'API\PenyimpananController@index');
            Route::get('paginate', 'API\PenyimpananController@paginate');
            Route::get('{id}', 'API\PenyimpananController@show');
            Route::post('', 'API\PenyimpananController@store');
            Route::patch('{id}', 'API\PenyimpananController@update');
            Route::delete('{id}', 'API\PenyimpananController@destroy');
        });

        Route::group(['prefix' => 'rekanan'], function(){
            Route::get('', 'API\RekananController@index');
            Route::get('paginate', 'API\RekananController@paginate');
            Route::get('{id}', 'API\RekananController@show');
            Route::post('', 'API\RekananController@store');
            Route::patch('{id}', 'API\RekananController@update');
            Route::delete('{id}', 'API\RekananController@destroy');
        });

        Route::group(['prefix' => 'satuan_pemakai'], function(){
            Route::get('', 'API\SatuanPemakaiController@index');
            Route::get('paginate', 'API\SatuanPemakaiController@paginate');
            Route::get('{id}', 'API\SatuanPemakaiController@show');
            Route::post('', 'API\SatuanPemakaiController@store');
            Route::patch('{id}', 'API\SatuanPemakaiController@update');
            Route::delete('{id}', 'API\SatuanPemakaiController@destroy');
        });

        Route::group(['prefix' => 'barang_masuk'], function(){
            Route::get('', 'API\BarangMasukController@index');
            Route::get('paginate', 'API\BarangMasukController@paginate');
            Route::get('{id}', 'API\BarangMasukController@show');
            Route::post('', 'API\BarangMasukController@store');
            Route::patch('{id}', 'API\BarangMasukController@update');
            Route::delete('{id}', 'API\BarangMasukController@destroy');
        });

        Route::group(['prefix' => 'barang_keluar'], function(){
            Route::get('', 'API\BarangKeluarController@index');
            Route::get('paginate', 'API\BarangKeluarController@paginate');
            Route::get('{id}', 'API\BarangKeluarController@show');
            Route::post('', 'API\BarangKeluarController@store');
            Route::patch('{id}', 'API\BarangKeluarController@update');
            Route::delete('{id}', 'API\BarangKeluarController@destroy');
        });

        Route::group(['prefix' => 'stock_opname'], function(){
            Route::get('', 'API\StockOpnameController@index');
            Route::get('paginate', 'API\StockOpnameController@paginate');
            Route::get('{id}', 'API\StockOpnameController@show');
            Route::post('', 'API\StockOpnameController@store');
            Route::patch('{id}', 'API\StockOpnameController@update');
            Route::delete('{id}', 'API\StockOpnameController@destroy');
        });

        Route::group(['prefix' => 'report'], function(){
            Route::get('stock/', 'API\ReportController@stock');

            Route::get('nota_dinas/', 'API\ReportController@nota_dinas');
            Route::get('nota_dinas/{id}', 'API\ReportController@detail_nota_dinas');

            Route::get('barang_masuk/', 'API\ReportController@barang_masuk');
            Route::get('barang_masuk/{id}', 'API\ReportController@detail_barang_masuk');

            Route::get('barang_keluar/', 'API\ReportController@barang_keluar');
            Route::get('barang_keluar/{id}', 'API\ReportController@detail_barang_keluar');
        });

        Route::get('dashboard/{id}', 'API\DashboardController@index');

    });
}); 