<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDashboardView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("create or replace
            view `v_dashboard` as
            select 'Jumlah nota dinas keluar belum bersurat' judul, count(bk.id) jumlah from barang_keluar bk 
                where bk.nomor_nota_dinas is not null and bk.nomor_surat is null
                union 
            select 'Transaksi masuk hari ini', count(bm.id) from barang_masuk bm 
                where extract(day from now()) = extract(day from bm.tanggal_input) and
                extract(month from now()) = extract(month from bm.tanggal_input) and
                extract(year from now()) = extract(year from bm.tanggal_input)
                union 
            select 'Transaksi keluar hari ini', count(bk.id) from barang_keluar bk 
                where extract(day from now()) = extract(day from bk.tanggal_input) and
                extract(month from now()) = extract(month from bk.tanggal_input) and
                extract(year from now()) = extract(year from bk.tanggal_input)
                union 
            select 'Transaksi masuk belum ada BA', count(bm.id) from barang_masuk bm where bm.nomor_ba is null
            union
            select 'Transaksi keluar belum ada BA', count(bk.id) from barang_keluar bk where bk.nomor_ba is null;"
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('DROP VIEW IF EXISTS v_dashboard');
    }
}
