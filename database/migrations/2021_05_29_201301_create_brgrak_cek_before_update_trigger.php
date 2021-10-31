<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBrgrakCekBeforeUpdateTrigger extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared("DROP TRIGGER IF EXISTS `brgrak_cek_before_update`;
        CREATE TRIGGER brgrak_cek_before_update
        BEFORE UPDATE
        ON penyimpanan FOR EACH ROW
        begin 
            DECLARE ada INT;
            DECLARE namabarang VARCHAR(255);
            DECLARE namagudang VARCHAR(255);
            DECLARE peringatan VARCHAR(355);
            select count(p.id) into ada from penyimpanan p 
                where 
                    p.id_barang = new.id_barang
                        and 
                    p.id_rak in ( select rr.id from rak rr where rr.id_gudang = (
                        select rrr.id_gudang from rak rrr where rrr.id = new.id_rak))
                        and 
                    p.id <> new.id;
            if ada > 0 then 
                select b.nama into namabarang from barang b where b.id = new.id_barang;
                select g.nama into namagudang from gudang g, rak r where g.id = r.id_gudang and r.id = new.id_rak;
                set peringatan = concat_ws('', 'Update gagal : rak untuk ', namabarang, ' sudah ada di ', namagudang);
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
        DB::unprepared('DROP TRIGGER IF EXISTS `brgrak_cek_before_update`;');
    }
}
