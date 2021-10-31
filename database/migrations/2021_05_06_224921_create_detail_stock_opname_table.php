<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailStockOpnameTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_stock_opname', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_stock_opname');
            $table->foreign('id_stock_opname')->references('id')->on('stock_opname');
            
            $table->unsignedBigInteger('id_barang');
            $table->foreign('id_barang')->references('id')->on('barang');

            $table->integer('tahun_anggaran');
            $table->double('harga')->nullable()->dafault(NULL);
            $table->integer('jumlah')->nullable()->dafault(NULL);
            $table->string('keterangan')->nullable()->dafault(NULL);
            $table->unique(['id_stock_opname', 'id_barang', 'tahun_anggaran', 'harga'], 'unique_stock_opname');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detail_stock_opname');
    }
}
