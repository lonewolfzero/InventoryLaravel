<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCountBalanceView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Jika error run statement langsung lewat query di DBMS
        DB::statement("create or replace
        view `count_balance` AS
        select
            `sbbb`.`main_id` as `main_id`,
            `sbbb`.`detail_id` as `detail_id`,
            `sbbb`.`id_gudang` as `id_gudang`,
            `sbbb`.`id_barang` as `id_barang`,
            `sbbb`.`tahun_anggaran` as `tahun_anggaran`,
            `sbbb`.`harga` as `harga`,
            `sbbb`.`tanggal` as `tanggal`,
            `sbbb`.`prioritas` as `prioritas`,
            `sbbb`.`jum` as `jum`,
            `sbbb`.`stock` as `stock`,
            `sbbb`.`stock_sb` as `stock_sb`,
            case
                `sbbb`.`prioritas`
                when 3 then `sbbb`.`stock` - `sbbb`.`stock_sb`
                else `sbbb`.`jum` end as `balance`
            from
                (
                select
                    `sbb`.`main_id` as `main_id`,
                    `sbb`.`detail_id` as `detail_id`,
                    `sbb`.`id_gudang` as `id_gudang`,
                    `sbb`.`id_barang` as `id_barang`,
                    `sbb`.`tahun_anggaran` as `tahun_anggaran`,
                    `sbb`.`harga` as `harga`,
                    `sbb`.`tanggal` as `tanggal`,
                    `sbb`.`prioritas` as `prioritas`,
                    `sbb`.`balance` as `jum`,
                    `sbb`.`stock` as `stock`,
                    lag(`sbb`.`stock`,
                    1) over (
                order by
                    `sbb`.`id_gudang`,
                    `sbb`.`id_barang`,
                    `sbb`.`tahun_anggaran`,
                    `sbb`.`harga`,
                    `sbb`.`tanggal`,
                    `sbb`.`prioritas`) as `stock_sb`
                from
                    (
                    select
                        `sb`.`main_id` as `main_id`,
                        `sb`.`detail_id` as `detail_id`,
                        `sb`.`id_gudang` as `id_gudang`,
                        `sb`.`id_barang` as `id_barang`,
                        `sb`.`tahun_anggaran` as `tahun_anggaran`,
                        `sb`.`harga` as `harga`,
                        `sb`.`tanggal` as `tanggal`,
                        `sb`.`prioritas` as `prioritas`,
                        `sb`.`balance` as `balance`,
                        sum(`sb`.`balance`) over ( partition by `sb`.`id_gudang`,
                        `sb`.`id_barang`,
                        `sb`.`tahun_anggaran`,
                        `sb`.`harga`,
                        `sb`.`nomor_stock_opname`
                    order by
                        `sb`.`tanggal`,
                        `sb`.`prioritas` rows between unbounded preceding and current row ) as `stock`
                    from
                        (
                        select
                            `vbm`.`id_barang_masuk` as `main_id`,
                            `vbm`.`id_detail_barang_masuk` as `detail_id`,
                            `vbm`.`id_gudang` as `id_gudang`,
                            `vbm`.`id_barang` as `id_barang`,
                            `vbm`.`tahun_anggaran` as `tahun_anggaran`,
                            `vbm`.`harga` as `harga`,
                            `vbm`.`tanggal_input` as `tanggal`,
                            `vbm`.`nomor_surat` as `nomor_bukti`,
                            `vbm`.`jumlah` as `masuk`,
                            0 as `keluar`,
                            0 as `stock_opname`,
                            `dsos`.`nomor_stock_opname` as `nomor_stock_opname`,
                            `vbm`.`jumlah` as `balance`,
                            `vbm`.`biaya` as `biaya`,
                            1 as `prioritas`
                        from
                            (`v_detail_stock_opname` `dsos`
                        join `v_barang_masuk` `vbm`)
                        where
                            `dsos`.`tanggal_pelaksanaan` = `vbm`.`tgl_so`
                            and `dsos`.`id_gudang` = `vbm`.`id_gudang`
                            and `dsos`.`id_barang` = `vbm`.`id_barang`
                            and `dsos`.`tahun_anggaran` = `vbm`.`tahun_anggaran`
                            and `dsos`.`harga` = `vbm`.`harga`
                    union
                        select
                            `vbm`.`id_barang_masuk` as `main_id`,
                            `vbm`.`id_detail_barang_masuk` as `detail_id`,
                            `vbm`.`id_gudang` as `id_gudang`,
                            `vbm`.`id_barang` as `id_barang`,
                            `vbm`.`tahun_anggaran` as `tahun_anggaran`,
                            `vbm`.`harga` as `harga`,
                            `vbm`.`tanggal_input` as `tanggal_input`,
                            `vbm`.`nomor_surat` as `nomor_bukti`,
                            `vbm`.`jumlah` as `jumlah`,
                            0 as `0`,
                            0 as `0`,
                            null as `NULL`,
                            `vbm`.`jumlah` as `balance`,
                            `vbm`.`biaya` as `biaya`,
                            1 as `1`
                        from
                            `v_barang_masuk` `vbm`
                        where
                            `vbm`.`tgl_so` is null
                    union
                        select
                            `vbk`.`id_barang_keluar` as `main_id`,
                            `vbk`.`id_barang_keluar_detail` as `detail_id`,
                            `vbk`.`id_gudang` as `id_gudang`,
                            `vbk`.`id_barang` as `id_barang`,
                            `vbk`.`tahun_anggaran` as `tahun_anggaran`,
                            `vbk`.`harga` as `harga`,
                            `vbk`.`tanggal_input` as `tanggal_input`,
                            `vbk`.`nomor_surat` as `nomor_surat`,
                            0 as `0`,
                            `vbk`.`jumlah` as `jumlah`,
                            0 as `0`,
                            `dsos`.`nomor_stock_opname` as `nomor_stock_opname`,
                            `vbk`.`jumlah` * -1 as `(vbk.jumlah * -1)`,
                            `vbk`.`biaya` as `biaya`,
                            2 as `2`
                        from
                            (`v_detail_stock_opname` `dsos`
                        join `v_barang_keluar` `vbk`)
                        where
                            `dsos`.`tanggal_pelaksanaan` = `vbk`.`tgl_so`
                            and `dsos`.`id_gudang` = `vbk`.`id_gudang`
                            and `dsos`.`id_barang` = `vbk`.`id_barang`
                            and `dsos`.`tahun_anggaran` = `vbk`.`tahun_anggaran`
                            and `dsos`.`harga` = `vbk`.`harga`
                    union
                        select
                            `vbk`.`id_barang_keluar` as `main_id`,
                            `vbk`.`id_barang_keluar_detail` as `detail_id`,
                            `vbk`.`id_gudang` as `id_gudang`,
                            `vbk`.`id_barang` as `id_barang`,
                            `vbk`.`tahun_anggaran` as `tahun_anggaran`,
                            `vbk`.`harga` as `harga`,
                            `vbk`.`tanggal_input` as `tanggal_input`,
                            `vbk`.`nomor_surat` as `nomor_bukti`,
                            0 as `0`,
                            `vbk`.`jumlah` as `jumlah`,
                            0 as `0`,
                            null as `NULL`,
                            `vbk`.`jumlah` * -1 as `(vbk.jumlah * -1)`,
                            `vbk`.`biaya` as `biaya`,
                            2 as `2`
                        from
                            `v_barang_keluar` `vbk`
                        where
                            `vbk`.`tgl_so` is null
                    union
                        select
                            `dso`.`id_stock_opname` as `main_id`,
                            `dso`.`id_detail_stock_opname` as `detail_id`,
                            `dso`.`id_gudang` as `id_gudang`,
                            `dso`.`id_barang` as `id_barang`,
                            `dso`.`tahun_anggaran` as `tahun_anggaran`,
                            `dso`.`harga` as `harga`,
                            `dso`.`tanggal_pelaksanaan` as `tanggal_pelaksanaan`,
                            `dso`.`nomor_stock_opname` as `nomor_stock_opname`,
                            0 as `0`,
                            0 as `0`,
                            `dso`.`jumlah` as `jumlah`,
                            `dso`.`nomor_stock_opname` as `nomor_stock_opname`,
                            `dso`.`jumlah` as `jumlah`,
                            0 as `biaya`,
                            3 as `3`
                        from
                            `v_detail_stock_opname` `dso`) `sb`) `sbb`) `sbbb`");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('DROP VIEW IF EXISTS count_balance');
    }
}
