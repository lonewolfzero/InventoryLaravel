<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailBarangKeluarTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_barang_keluar', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_barang_keluar');
            $table->foreign('id_barang_keluar')->references('id')->on('barang_keluar');
            
            $table->integer('tahun_anggaran');
            $table->double('harga')->nullable()->default(NULL);
            $table->integer('jumlah')->nullable()->default(NULL);
            $table->string('keterangan')->nullable()->default(NULL);
            
            $table->unsignedBigInteger('id_barang');
            $table->foreign('id_barang')->references('id')->on('barang');
            
            $table->unique(['id_barang_keluar', 'id_barang', 'tahun_anggaran', 'harga'], 'unique_detail_barang_keluar');
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
        Schema::dropIfExists('detail_barang_keluar');
    }
}
