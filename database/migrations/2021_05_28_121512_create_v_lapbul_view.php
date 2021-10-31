<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVLapbulView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("create or replace
        view `v_lapbul` as
            select
            `sb`.`id_gudang` as `id_gudang`,
            `g`.`nama` as `nama_gudang`,
            `sb`.`id_barang` as `id_barang`,
            `b2`.`nama` as `nama_barang`,
            `s2`.`nama` as `satuan`,
            `sb`.`tanggal` as `tanggal`,
            null as `jumlah_stock_awal`,
            `sb`.`nomor_bukti_penerimaan` as `nomor_bukti_penerimaan`,
            `sb`.`jumlah_penerimaan` as `jumlah_penerimaan`,
            `sb`.`nomor_bukti_pengeluaran` as `nomor_bukti_pengeluaran`,
            `sb`.`jumlah_pengeluaran` as `jumlah_pengeluaran`,
            case
                `sb`.`prioritas`
                when 3 then `sb`.`nomor_stock_opname`
                else null end as `nomor_bukti_stock_opname`,
                `sb`.`jumlah_stock_opname` as `jumlah_stock_opname`,
                null as `persediaan_akhir_bulan`,
                `sb`.`harga` as `harga_satuan`,
                null as `jumlah_harga`,
                `sb`.`tahun_anggaran` as `tahun_anggaran`,
                `sb`.`keterangan` as `keterangan`,
                `sb`.`nomor_stock_opname` as `nomor_stock_opname`,
                `sb`.`prioritas` + 1 as `prioritas`,
                `sb`.`balance` as `balance`
            from
                ((((
                select
                    `vbm`.`id_gudang` as `id_gudang`,
                    `vbm`.`id_barang` as `id_barang`,
                    `vbm`.`tahun_anggaran` as `tahun_anggaran`,
                    `vbm`.`harga` as `harga`,
                    `vbm`.`tanggal_input` as `tanggal`,
                    `vbm`.`nomor_surat` as `nomor_bukti_penerimaan`,
                    `vbm`.`jumlah` as `jumlah_penerimaan`,
                    null as `nomor_bukti_pengeluaran`,
                    null as `jumlah_pengeluaran`,
                    null as `jumlah_stock_opname`,
                    `dsos`.`nomor_stock_opname` as `nomor_stock_opname`,
                    `vbm`.`jumlah` as `balance`,
                    `vbm`.`biaya` as `biaya`,
                    1 as `prioritas`,
                    `vbm`.`keterangan` as `keterangan`
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
                    `vbm`.`id_gudang` as `id_gudang`,
                    `vbm`.`id_barang` as `id_barang`,
                    `vbm`.`tahun_anggaran` as `tahun_anggaran`,
                    `vbm`.`harga` as `harga`,
                    `vbm`.`tanggal_input` as `tanggal_input`,
                    `vbm`.`nomor_surat` as `nomor_bukti_penerimaan`,
                    `vbm`.`jumlah` as `jumlah_penerimaan`,
                    null as `nomor_bukti_pengeluaran`,
                    null as `jumlah_pengeluaran`,
                    null as `0`,
                    null as `NULL`,
                    `vbm`.`jumlah` as `balance`,
                    `vbm`.`biaya` as `biaya`,
                    1 as `1`,
                    `vbm`.`keterangan` as `keterangan`
                from
                    `v_barang_masuk` `vbm`
                where
                    `vbm`.`tgl_so` is null
            union
                select
                    `vbk`.`id_gudang` as `id_gudang`,
                    `vbk`.`id_barang` as `id_barang`,
                    `vbk`.`tahun_anggaran` as `tahun_anggaran`,
                    `vbk`.`harga` as `harga`,
                    `vbk`.`tanggal_input` as `tanggal_input`,
                    null as `nomor_bukti_penerimaan`,
                    null as `0`,
                    `vbk`.`nomor_surat` as `nomor_bukti_pengeluaran`,
                    `vbk`.`jumlah` as `jumlah_pengeluaran`,
                    null as `0`,
                    `dsos`.`nomor_stock_opname` as `nomor_stock_opname`,
                    `vbk`.`jumlah` * -1 as `(vbk.jumlah * -1)`,
                    `vbk`.`biaya` as `biaya`,
                    2 as `2`,
                    `vbk`.`keterangan` as `keterangan`
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
                    `vbk`.`id_gudang` as `id_gudang`,
                    `vbk`.`id_barang` as `id_barang`,
                    `vbk`.`tahun_anggaran` as `tahun_anggaran`,
                    `vbk`.`harga` as `harga`,
                    `vbk`.`tanggal_input` as `tanggal_input`,
                    null as `nomor_bukti_penerimaan`,
                    null as `0`,
                    `vbk`.`nomor_surat` as `nomor_bukti_pengeluaran`,
                    `vbk`.`jumlah` as `jumlah_pengeluaran`,
                    null as `0`,
                    null as `NULL`,
                    `vbk`.`jumlah` * -1 as `(vbk.jumlah * -1)`,
                    `vbk`.`biaya` as `biaya`,
                    2 as `2`,
                    `vbk`.`keterangan` as `keterangan`
                from
                    `v_barang_keluar` `vbk`
                where
                    `vbk`.`tgl_so` is null
            union
                select
                    `dso`.`id_gudang` as `id_gudang`,
                    `dso`.`id_barang` as `id_barang`,
                    `dso`.`tahun_anggaran` as `tahun_anggaran`,
                    `dso`.`harga` as `harga`,
                    `dso`.`tanggal_pelaksanaan` as `tanggal_pelaksanaan`,
                    null as `nomor_bukti_penerimaan`,
                    null as `0`,
                    null as `nomor_bukti_pengeluaran`,
                    null as `jumlah_pengeluaran`,
                    `dso`.`jumlah` as `jumlah`,
                    `dso`.`nomor_stock_opname` as `nomor_stock_opname`,
                    `dso`.`jumlah` as `jumlah`,
                    0 as `biaya`,
                    3 as `3`,
                    `dso`.`keterangan` as `keterangan`
                from
                    `v_detail_stock_opname` `dso`) `sb`
            join `gudang` `g`)
            join `barang` `b2`)
            join `satuan` `s2`)
            where
                `g`.`id` = `sb`.`id_gudang`
                and `b2`.`id` = `sb`.`id_barang`
                and `s2`.`id` = `b2`.`id_satuan`
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('DROP VIEW IF EXISTS v_lapbul');
    }
}
