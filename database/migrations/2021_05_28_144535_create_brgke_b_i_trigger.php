<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBrgkeBITrigger extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared("DROP TRIGGER IF EXISTS `brgke_b_i`;
        CREATE TRIGGER brgke_b_i
        BEFORE INSERT
        ON barang_keluar FOR EACH ROW
        begin
            if NEW.nomor_surat is null OR NEW.nomor_surat = '' AND NEW.nomor_nota_dinas is null OR NEW.nomor_nota_dinas = '' then
                SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Insert gagal : nomor surat atau nota dinas harus diisi';
            end if;
            if new.tanggal_input > now() then
                SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Insert gagal : Tanggal input tidak boleh lebih besar dari saat ini';
            end if;
            set new.updated_at = now();
        end");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP TRIGGER IF EXISTS `brgke_b_i`;');
    }
}
