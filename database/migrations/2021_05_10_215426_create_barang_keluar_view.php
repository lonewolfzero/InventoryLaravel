<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBarangKeluarView extends Migration
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
        view `v_barang_keluar` as
        select
            `bk`.`id` as `id_barang_keluar`,
            `bkd`.`id` as `id_barang_keluar_detail`,
            `bk`.`nomor_surat` as `nomor_surat`,
            `bk`.`nomor_nota_dinas` as `nomor_nota_dinas`,
            `bk`.`nomor_ba` as `nomor_ba`,
            `bk`.`nomor_sa` as `nomor_sa`,
            `bk`.`updated_by` as `update_by`,
            `bk`.`updated_at` as `update_date`,
            `bk`.`active` as `active`,
            `bk`.`keterangan` as `keterangan`,
            `bk`.`id_gudang` as `id_gudang`,
            `bkd`.`id_barang` as `id_barang`,
            `bkd`.`tahun_anggaran` as `tahun_anggaran`,
            `bkd`.`harga` as `harga`,
            `bk`.`tanggal_input` as `tanggal_input`,
            `bkd`.`jumlah` as `jumlah`,
            `bkd`.`jumlah` * `bkd`.`harga` as `biaya`,
            (
            select
                max(`so`.`tanggal_pelaksanaan`)
            from
                `detail_stock_opname` `dso`,
                `stock_opname` `so`
            where
                `so`.`id_gudang` = `bk`.`id_gudang`
                and `dso`.`id_barang` = `bkd`.`id_barang`
                and `dso`.`tahun_anggaran` = `bkd`.`tahun_anggaran`
                and `dso`.`harga` = `bkd`.`harga`
                and `so`.`tanggal_pelaksanaan` < `bk`.`tanggal_input`) as `tgl_so`
        from
            (`detail_barang_keluar` `bkd`
        join `barang_keluar` `bk`)
        where
            `bkd`.`id_barang_keluar` = `bk`.`id`
            ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('DROP VIEW IF EXISTS v_barang_keluar');
    }
}
