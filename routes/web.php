<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

Route::get('/', 'Auth\LoginController@showLoginForm');



// Route::get('/debug', function () {
//     $title = 'Locked';
//     return view('auth/locked', compact('title'));
// });

Route::get('lockscreen', 'LockAccountController@lockscreen')->name('lock');
Route::post('lockscreen', 'LockAccountController@unlock')->name('unlock');

Route::group(['prefix' => 'reportmobile'], function () {
	
Route::get('stock/', 'ReportMobileController@stock')->name('reportmobile.stock');
	
Route::get('barang_masuk/', 'ReportMobileController@barang_masuk')->name('reportmobile.barang_masuk');
Route::get('barang_masuk/{id}', 'ReportMobileController@detail_barang_masuk')->name('reportmobile.detail_barang_masuk');

Route::get('barang_keluar/', 'ReportMobileController@barang_keluar')->name('reportmobile.barang_keluar');
Route::get('barang_keluar/{id}', 'ReportMobileController@detail_barang_keluar')->name('reportmobile.detail_barang_keluar');

});

Route::group(['middleware' => ['auth', 'roles', 'lock']], function () {
    Route::get('/dashboard', 'DashboardController@index')->name('dashboard');

    // User Profile
    Route::get('/profile', 'UserController@profile')->name('profile');
    Route::post('/profile/update', 'UserController@updateProfile')->name('profile.update');
    Route::post('/profile/change-password', 'UserController@changePasswordProfile')->name('profile.change_password');
    
    Route::group(['middleware' => ['roles:master', 'roles:admin']], function () {
        // User
        Route::group(['prefix' => 'users', 'middleware' => ['can:users.index']], function () {
            Route::get('', 'UserController@index')->name('user.index');
            Route::post('/create', 'UserController@store')->name('user.store');
            Route::post('/edit', 'UserController@update')->name('user.update');
            Route::post('/destroy/{id}', 'UserController@destroy')->name('user.destroy');
        });
    
        // Role
        Route::group(['prefix' => 'roles', 'middleware' => ['can:roles.index']], function () {
            Route::get('', 'RoleController@index')->name('role.index');
            Route::post('/create', 'RoleController@store')->name('role.store');
            Route::post('/edit', 'RoleController@update')->name('role.update');
            Route::post('/destroy/{id}', 'RoleController@destroy')->name('role.destroy');
            Route::get('/permissions/{id}', 'RoleController@permissions')->name('role.permisions')->middleware('can:roles.give_permission');
            Route::post('/permissions/{id}', 'RoleController@givePermissions')->name('role.give_permissions');
        });
    
        // Business Settings
        route::group(['prefix' => 'business'], function() {
            Route::group(['middleware' => 'can:business.profile'], function () {
                Route::get('profile', 'BusinessController@index')->name('business.profile');
                Route::post('update-profile', 'BusinessController@updateBusiness')->name('business.update_profile');
            });

            // Route::group(['prefix' => 'locations'], function () {
            //     Route::get('', 'BusinessController@locations')->name('business.locations')->middleware('can:business.profile');
            //     Route::get('/create', 'BusinessController@createLocation')->name('business.create_location')->middleware('can:business.create_location');
            //     Route::post('/store', 'BusinessController@storeLocation')->name('business.store_location');
            //     Route::get('/edit/{id}', 'BusinessController@editLocation')->name('business.edit_location')->middleware('can:business.update_location');
            //     Route::post('/update', 'BusinessController@updateLocation')->name('business.update_location');
            //     Route::post('/destroy/{id}', 'BusinessController@deleteLocation')->name('business.delete_location');
            // });
        });

    });
    
    Route::group(['prefix' => 'barang', 'middleware' => ['can:barang.index']], function () {
        Route::get('', 'BarangController@index')->name('barang.index');
        Route::post('/create', 'BarangController@store')->name('barang.store');
        Route::post('/edit', 'BarangController@update')->name('barang.update');
        Route::post('/destroy/{id}', 'BarangController@destroy')->name('barang.destroy');
    });

    Route::group(['prefix' => 'kategori', 'middleware' => ['can:kategori.index']], function () {
        Route::get('', 'KategoriController@index')->name('kategori.index');
        Route::post('/create', 'KategoriController@store')->name('kategori.store');
        Route::post('/edit', 'KategoriController@update')->name('kategori.update');
        Route::post('/destroy/{id}', 'KategoriController@destroy')->name('kategori.destroy');
    });

    Route::group(['prefix' => 'satuan', 'middleware' => ['can:satuan.index']], function () {
        Route::get('', 'SatuanController@index')->name('satuan.index');
        Route::post('/create', 'SatuanController@store')->name('satuan.store');
        Route::post('/edit', 'SatuanController@update')->name('satuan.update');
        Route::post('/destroy/{id}', 'SatuanController@destroy')->name('satuan.destroy');
    });

    Route::group(['prefix' => 'gudang', 'middleware' => ['can:gudang.index']], function () {
        Route::get('', 'GudangController@index')->name('gudang.index');
        Route::post('/create', 'GudangController@store')->name('gudang.store');
        Route::post('/edit', 'GudangController@update')->name('gudang.update');
        Route::post('/destroy/{id}', 'GudangController@destroy')->name('gudang.destroy');
    });

    Route::group(['prefix' => 'rak', 'middleware' => ['can:rak.index']], function () {
        Route::get('', 'RakController@index')->name('rak.index');
        Route::post('/create', 'RakController@store')->name('rak.store');
        Route::post('/edit', 'RakController@update')->name('rak.update');
        Route::post('/destroy/{id}', 'RakController@destroy')->name('rak.destroy');
    });

    Route::group(['prefix' => 'penyimpanan', 'middleware' => ['can:penyimpanan.index']], function () {
        Route::get('', 'PenyimpananController@index')->name('penyimpanan.index');
        Route::post('/create', 'PenyimpananController@store')->name('penyimpanan.store');
        Route::post('/edit', 'PenyimpananController@update')->name('penyimpanan.update');
        Route::post('/destroy/{id}', 'PenyimpananController@destroy')->name('penyimpanan.destroy');
    });

    Route::group(['prefix' => 'rekanan', 'middleware' => ['can:rekanan.index']], function () {
        Route::get('', 'RekananController@index')->name('rekanan.index');
        Route::post('/create', 'RekananController@store')->name('rekanan.store');
        Route::post('/edit', 'RekananController@update')->name('rekanan.update');
        Route::post('/destroy/{id}', 'RekananController@destroy')->name('rekanan.destroy');
    });

    Route::group(['prefix' => 'satuan_pemakai', 'middleware' => ['can:satuan_pemakai.index']], function () {
        Route::get('', 'SatuanPemakaiController@index')->name('satuan_pemakai.index');
        Route::post('/create', 'SatuanPemakaiController@store')->name('satuan_pemakai.store');
        Route::post('/edit', 'SatuanPemakaiController@update')->name('satuan_pemakai.update');
        Route::post('/destroy/{id}', 'SatuanPemakaiController@destroy')->name('satuan_pemakai.destroy');
    });

    Route::group(['prefix' => 'barang_masuk', 'middleware' => ['can:barang_masuk.index']], function () {
        Route::get('', 'BarangMasukController@index')->name('barang_masuk.index');
        Route::get('/detail/{id}', 'BarangMasukController@show')->name('barang_masuk.detail')->middleware('can:barang_masuk.detail');
        Route::get('/create', 'BarangMasukController@create')->name('barang_masuk.create')->middleware('can:barang_masuk.create');
        Route::post('/create', 'BarangMasukController@store')->name('barang_masuk.store')->middleware('can:barang_masuk.create');
        Route::get('/edit/{id}', 'BarangMasukController@edit')->name('barang_masuk.edit')->middleware('can:barang_masuk.update');
        Route::post('/edit/{id}', 'BarangMasukController@update')->name('barang_masuk.update')->middleware('can:barang_masuk.update');
        Route::post('/destroy/{id}', 'BarangMasukController@destroy')->name('barang_masuk.destroy');
    });

    Route::group(['prefix' => 'barang_keluar', 'middleware' => ['can:barang_keluar.index']], function () {
        Route::get('', 'BarangKeluarController@index')->name('barang_keluar.index');
        Route::get('/detail/{id}', 'BarangKeluarController@show')->name('barang_keluar.detail')->middleware('can:barang_keluar.detail');
        Route::get('/create', 'BarangKeluarController@create')->name('barang_keluar.create')->middleware('can:barang_keluar.create');
        Route::post('/create', 'BarangKeluarController@store')->name('barang_keluar.store')->middleware('can:barang_keluar.create');
        Route::get('/edit/{id}', 'BarangKeluarController@edit')->name('barang_keluar.edit')->middleware('can:barang_keluar.update');
        Route::post('/edit/{id}', 'BarangKeluarController@update')->name('barang_keluar.update')->middleware('can:barang_keluar.update');
        Route::post('/destroy/{id}', 'BarangKeluarController@destroy')->name('barang_keluar.destroy');
    });

    Route::group(['prefix' => 'stock_opname', 'middleware' => ['can:stock_opname.index']], function () {
        Route::get('', 'StockOpnameController@index')->name('stock_opname.index');
        Route::get('/detail/{id}', 'StockOpnameController@show')->name('stock_opname.detail')->middleware('can:stock_opname.detail');
        Route::get('/create', 'StockOpnameController@create')->name('stock_opname.create')->middleware('can:stock_opname.create');
        Route::post('/create', 'StockOpnameController@store')->name('stock_opname.store')->middleware('can:stock_opname.create');
        Route::get('/edit/{id}', 'StockOpnameController@edit')->name('stock_opname.edit')->middleware('can:stock_opname.update');
        Route::post('/edit/{id}', 'StockOpnameController@update')->name('stock_opname.update')->middleware('can:stock_opname.update');
        Route::post('/destroy/{id}', 'StockOpnameController@destroy')->name('stock_opname.destroy');
    });

    Route::group(['prefix' => 'report'], function () {
        Route::group(['middleware' => ['can:report.stock']], function () {
            Route::get('stock/', 'ReportController@stock')->name('report.stock');
        });
        Route::group(['middleware' => ['can:report.laporan_bulanan']], function () {
            Route::get('laporan_bulanan/', 'ReportController@laporan_bulanan')->name('report.laporan_bulanan');
        });
        Route::group(['middleware' => ['can:report.nota_dinas']], function () {
            Route::get('nota_dinas/', 'ReportController@nota_dinas')->name('report.nota_dinas');
            Route::get('nota_dinas/{id}', 'ReportController@detail_nota_dinas')->name('report.detail_nota_dinas');
        });
        Route::group(['middleware' => ['can:report.barang_masuk']], function () {
            Route::get('barang_masuk/', 'ReportController@barang_masuk')->name('report.barang_masuk');
            Route::get('barang_masuk/{id}', 'ReportController@detail_barang_masuk')->name('report.detail_barang_masuk');
        });
        Route::group(['middleware' => ['can:report.barang_keluar']], function () {
            Route::get('barang_keluar/', 'ReportController@barang_keluar')->name('report.barang_keluar');
            Route::get('barang_keluar/{id}', 'ReportController@detail_barang_keluar')->name('report.detail_barang_keluar');
        });
    });
	

});
