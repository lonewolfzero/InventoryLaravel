<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBrgmskBITrigger extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared("DROP TRIGGER IF EXISTS `brgmsk_b_i`;
        CREATE TRIGGER brgmsk_b_i
        BEFORE INSERT
        ON barang_masuk FOR EACH ROW
        begin
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
        DB::unprepared('DROP TRIGGER IF EXISTS `brgmsk_b_i`;');
    }
}
