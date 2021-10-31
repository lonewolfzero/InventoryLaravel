<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailStockOpnameView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("create or replace
        view `v_detail_stock_opname` as
        select `sb`.`id_stock_opname` as `id_stock_opname`,
            `sb`.`id_detail_stock_opname` as `id_detail_stock_opname`,
            `sb`.`id_gudang` as `id_gudang`,
            `sb`.`id_barang` as `id_barang`,
            `sb`.`tahun_anggaran` as `tahun_anggaran`,
            `sb`.`harga` as `harga`,
            `sb`.`tanggal_pelaksanaan` as `tanggal_pelaksanaan`,
            coalesce(lead(`sb`.`tanggal_pelaksanaan`,
            1) over ( partition by `sb`.`id_gudang`,
            `sb`.`id_barang`,
            `sb`.`tahun_anggaran`,
            `sb`.`harga`
        order by
            `sb`.`tanggal_pelaksanaan`),
            current_timestamp()) as `next_date`,
            `sb`.`nomor_stock_opname` as `nomor_stock_opname`,
            `sb`.`jumlah` as `jumlah`,
            `sb`.`keterangan` as `keterangan`,
            min(`sb`.`tanggal_pelaksanaan`) over(partition by `sb`.`id_gudang`,
            `sb`.`id_barang`,
            `sb`.`tahun_anggaran`,
            `sb`.`harga`) first_date
        from
            (
            select
                `so`.`id` as `id_stock_opname`,
                `sod`.`id` as `id_detail_stock_opname`,
                `so`.`id_gudang` as `id_gudang`,
                `sod`.`id_barang` as `id_barang`,
                `sod`.`tahun_anggaran` as `tahun_anggaran`,
                `sod`.`harga` as `harga`,
                `so`.`tanggal_pelaksanaan` as `tanggal_pelaksanaan`,
                `so`.`nomor_stock_opname` as `nomor_stock_opname`,
                `sod`.`jumlah` as `jumlah`,
                `sod`.`keterangan` as `keterangan`
            from
                (`stock_opname` `so`
            join `detail_stock_opname` `sod`)
            where
                `so`.`id` = `sod`.`id_stock_opname`) `sb`");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('DROP VIEW IF EXISTS v_detail_stock_opname');
    }
}
