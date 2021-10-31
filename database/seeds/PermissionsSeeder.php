<?php

use Illuminate\Database\Seeder;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('permissions')->insert([
            // User
            ['name' => 'users.index'], // 1  
            ['name' => 'users.create'], // 2 
            ['name' => 'users.update'], // 3 
            ['name' => 'users.delete'], // 4 

            // Role
            ['name' => 'roles.index'], // 5
            ['name' => 'roles.create'], // 6
            ['name' => 'roles.update'], // 7
            ['name' => 'roles.delete'], // 8
            ['name' => 'roles.give_permission'], // 9

            //Business
            ['name' => 'business.profile'], // 10
            ['name' => 'business.locations'], // 11
            ['name' => 'business.create_location'], // 12
            ['name' => 'business.update_location'], // 13
            ['name' => 'business.delete_location'], // 14
            
            // Master Data
            ['name' => 'barang.index'], // 15
            ['name' => 'barang.create'], // 16 
            ['name' => 'barang.update'], // 17 
            ['name' => 'barang.delete'], // 18

            ['name' => 'kategori.index'], // 19
            ['name' => 'kategori.create'], // 20 
            ['name' => 'kategori.update'], // 21
            ['name' => 'kategori.delete'], // 22

            ['name' => 'satuan.index'], // 23
            ['name' => 'satuan.create'], // 24 
            ['name' => 'satuan.update'], // 25
            ['name' => 'satuan.delete'], // 26

            ['name' => 'gudang.index'], // 27
            ['name' => 'gudang.create'], // 28 
            ['name' => 'gudang.update'], // 29 
            ['name' => 'gudang.delete'], // 30

            ['name' => 'rak.index'], // 31
            ['name' => 'rak.create'], // 32 
            ['name' => 'rak.update'], // 33
            ['name' => 'rak.delete'], // 34

            ['name' => 'penyimpanan.index'], // 35
            ['name' => 'penyimpanan.create'], // 36 
            ['name' => 'penyimpanan.update'], // 37
            ['name' => 'penyimpanan.delete'], // 38

            ['name' => 'rekanan.index'], // 39
            ['name' => 'rekanan.create'], // 40 
            ['name' => 'rekanan.update'], // 41
            ['name' => 'rekanan.delete'], // 42

            ['name' => 'satuan_pemakai.index'], // 43
            ['name' => 'satuan_pemakai.create'], // 44
            ['name' => 'satuan_pemakai.update'], // 45
            ['name' => 'satuan_pemakai.delete'], // 46

            // Core
            ['name' => 'barang_masuk.index'], // 47
            ['name' => 'barang_masuk.detail'], // 48
            ['name' => 'barang_masuk.create'], // 49
            ['name' => 'barang_masuk.update'], // 50
            ['name' => 'barang_masuk.delete'], // 51

            ['name' => 'barang_keluar.index'], // 52
            ['name' => 'barang_keluar.detail'], // 53
            ['name' => 'barang_keluar.create'], // 54
            ['name' => 'barang_keluar.update'], // 55
            ['name' => 'barang_keluar.delete'], // 56

            ['name' => 'stock_opname.index'], // 57
            ['name' => 'stock_opname.detail'], // 58
            ['name' => 'stock_opname.create'], // 59
            ['name' => 'stock_opname.update'], // 60
            ['name' => 'stock_opname.delete'], // 61

            // Report
            ['name' => 'report.stock'], // 62
            ['name' => 'report.laporan_bulanan'], // 63
            ['name' => 'report.nota_dinas'], // 64
            ['name' => 'report.detail_nota_dinas'], // 65
            ['name' => 'report.barang_masuk'], // 66
            ['name' => 'report.detail_barang_masuk'], // 67
            ['name' => 'report.barang_keluar'], // 68
            ['name' => 'report.detail_barang_keluar'], // 69
            
            // Dashboard
            ['name' => 'dashboard.nota_dinas'], // 70
            ['name' => 'dashboard.transaksi_masuk'], // 71
            ['name' => 'dashboard.transaksi_masuk_tanpa_ba'], // 72
            ['name' => 'dashboard.transaksi_keluar'], // 73
            ['name' => 'dashboard.transaksi_keluar_tanpa_ba'], // 74

        ]);

        $master = App\Role::where('name', 'master')->first();
        $master->permissions()->attach([1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25 ,26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 46, 47, 48, 49, 50, 51, 52, 53, 54, 55, 56, 57, 58, 59, 60, 61, 62, 63, 64, 65, 66, 67, 68, 69, 70, 71, 72, 73, 74]);
    }
}
