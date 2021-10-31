<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSodBUTrigger extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared("DROP TRIGGER IF EXISTS `sod_b_u`;
        CREATE TRIGGER sod_b_u
        BEFORE UPDATE
        ON detail_stock_opname FOR EACH ROW
        begin 
            DECLARE ada INT;
            DECLARE idgudang INT;
            DECLARE namabarang VARCHAR(255);
            DECLARE namagudang VARCHAR(255);
            DECLARE peringatan VARCHAR(355);
            select distinct so.id_gudang into idgudang 
                from 
                    stock_opname so
                where 
                    so.id = new.id_stock_opname;
            select count(bmd.id ) into ada
                from 
                    detail_barang_masuk bmd , barang_masuk bm 
                where 
                    bm.id = bmd.id_barang_masuk
                        and
                    bmd.id_barang = new.id_barang
                        and 
                    bmd.harga = new.harga
                        and 
                    bm.id_gudang = idgudang
                        and
                    bm.tahun_anggaran = new.tahun_anggaran;
            if ada < 1 then
                select b.nama into namabarang from barang b where b.id = new.id_barang;
                select g.nama into namagudang from gudang g where g.id = idgudang;
                set peringatan = concat_ws('', 'Update gagal : Tidak ada barang masuk untuk ', namabarang, ' dengan harga ', new.harga, 
                    ' untuk tahun anggaran ', new.tahun_anggaran, ' di gudang ', namagudang);
                SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = peringatan;
            end if;
        end");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP TRIGGER IF EXISTS `sod_b_u`;');
    }
}
