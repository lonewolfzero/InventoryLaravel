<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailBarangMasukTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_barang_masuk', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_barang_masuk');
            $table->foreign('id_barang_masuk')->references('id')->on('barang_masuk');

            $table->double('harga')->nullable()->default(NULL);
            $table->integer('jumlah')->nullable()->default(NULL);
            $table->string('keterangan')->nullable();
            
            $table->unsignedBigInteger('id_barang');
            $table->foreign('id_barang')->references('id')->on('barang');
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
        Schema::dropIfExists('detail_barang_masuk');
    }
}
