<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVStockOpnameDetailView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("
        create or replace
        view `v_stock_opname_detail` as
        select
            `sod`.`id_stock_opname` as `id_stock_opname`,
            `sod`.`id_detail_stock_opname` as `id_detail_stock_opname`,
            `sod`.`id_barang` as `id_barang`,
            `b2`.`nama` as `nama_barang`,
            `sod`.`tahun_anggaran` as `tahun_anggaran`,
            `sod`.`harga` as `harga`,
            `cb`.`stock_sb` as `stock_sebelumnya`,
            `sod`.`jumlah` as `jumlah`,
            `cb`.`balance` as `implikasi_quantitif`,
            `sod`.`keterangan` as `keterangan`
        from
            ((`v_detail_stock_opname` `sod`
        join `count_balance` `cb`)
        join `barang` `b2`)
        where
            `cb`.`detail_id` = `sod`.`id_detail_stock_opname`
            and `cb`.`prioritas` = 3
            and `b2`.`id` = `sod`.`id_barang`
            ");    
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('v_stock_opname_detail_view');
    }
}
