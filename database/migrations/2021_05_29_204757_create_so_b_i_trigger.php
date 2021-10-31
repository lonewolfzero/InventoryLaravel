<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSoBITrigger extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared("DROP TRIGGER IF EXISTS `so_b_i`;
        CREATE TRIGGER so_b_i
        BEFORE INSERT
        ON stock_opname FOR EACH ROW
        begin
            DECLARE ada INT;
            DECLARE peringatan VARCHAR(255);
            DECLARE namagudang VARCHAR(255);
            DECLARE namabulan VARCHAR(355);
            if new.tanggal_pelaksanaan > now() then
                SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Insert gagal : Tanggal input tidak boleh lebih besar dari saat ini';
            end if;
            if extract(day from new.tanggal_pelaksanaan) <> extract(day from last_day(new.tanggal_pelaksanaan)) then
                SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Insert gagal : Tanggal pelaksanaan harus di akhir bulan';
            end if;
            set new.tanggal_pelaksanaan = concat(extract(year from new.tanggal_pelaksanaan),'-',
                case when extract(month from new.tanggal_pelaksanaan) < 10 then concat('0', extract(month from new.tanggal_pelaksanaan)) else
                extract(month from new.tanggal_pelaksanaan) end
                ,'-', 
                extract(day from new.tanggal_pelaksanaan), ' 23:59:59');
            select count(so.id) into ada from stock_opname so 
            where 
                extract(month from so.tanggal_pelaksanaan) = extract(month from new.tanggal_pelaksanaan) and 
                extract(year from so.tanggal_pelaksanaan) = extract(year from new.tanggal_pelaksanaan) and 
                so.id_gudang = new.id_gudang;
            if ada > 0 then
                select g2.nama into namagudang from gudang g2 where g2.id = new.id_gudang;
                select date_format(new.tanggal_pelaksanaan, '%M %Y', 'id_ID') into namabulan from dual;
                set peringatan = concat_ws('', 'Insert gagal : ', namagudang, ' pada bulan ', namabulan, ' sudah dilakukan stock opname');
                SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = peringatan;
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
        DB::unprepared('DROP TRIGGER IF EXISTS `so_b_i`;');
    }
}
