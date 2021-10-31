<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBarangMasukView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("create or replace
        view `v_barang_masuk` as
        select
            `bm`.`id` as `id_barang_masuk`,
            `bmd`.`id` as `id_detail_barang_masuk`,
            `bm`.`nomor_surat` as `nomor_surat`,
            `bm`.`nomor_kph` as `nomor_kph`,
            `bm`.`nomor_ba` as `nomor_ba`,
            `bm`.`nomor_kontrak` as `nomor_kontrak`,
            `bm`.`updated_by` as `update_by`,
            `bm`.`updated_at` as `update_date`,
            `bm`.`active` as `active`,
            `bm`.`keterangan` as `keterangan`,
            `bm`.`id_gudang` as `id_gudang`,
            `bmd`.`id_barang` as `id_barang`,
            `bm`.`tahun_anggaran` as `tahun_anggaran`,
            `bmd`.`harga` as `harga`,
            `bm`.`tanggal_input` as `tanggal_input`,
            `bmd`.`jumlah` as `jumlah`,
            `bmd`.`jumlah` * `bmd`.`harga` as `biaya`,
            (
            select
                max(`so`.`tanggal_pelaksanaan`)
            from
                `detail_stock_opname` `dso`,
                `stock_opname` `so`
            where
                `so`.`id_gudang` = `bm`.`id_gudang`
                and `dso`.`id_barang` = `bmd`.`id_barang`
                and `dso`.`tahun_anggaran` = `bm`.`tahun_anggaran`
                and `dso`.`harga` = `bmd`.`harga`
                and `so`.`tanggal_pelaksanaan` < `bm`.`tanggal_input`) as `tgl_so`
        from
            (`barang_masuk` `bm`
        join `detail_barang_masuk` `bmd`)
        where
            `bmd`.`id_barang_masuk` = `bm`.`id`");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('DROP VIEW IF EXISTS v_barang_masuk');
    }
}
