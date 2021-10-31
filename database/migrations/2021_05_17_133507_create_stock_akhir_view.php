<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStockAkhirView extends Migration
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
                view `stock_akhir_g_b_ta_h` as
                select
                    `cb`.`id_gudang` as `id_gudang`,
                    `cb`.`id_barang` as `id_barang`,
                    `cb`.`tahun_anggaran` as `tahun_anggaran`,
                    `cb`.`harga` as `harga`,
                    sum(`cb`.`balance`) as `stock_akhir`
                from
                    `count_balance` `cb`
                group by
                    `cb`.`id_gudang`,
                    `cb`.`id_barang`,
                    `cb`.`tahun_anggaran`,
                    `cb`.`harga`
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('DROP VIEW IF EXISTS stock_akhir_g_b_ta_h');
    }
}
