<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePenyimpananTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('penyimpanan', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_barang');
            $table->foreign('id_barang')->references('id')->on('barang');
            // $table->bigInteger('id_gudang');
            $table->unsignedBigInteger('id_rak');
            $table->foreign('id_rak')->references('id')->on('rak');
            $table->integer('active');
            
            $table->unsignedBigInteger('updated_by');
            $table->foreign('updated_by')->references('id')->on('users');
            // $table->primary(['id_barang', 'id_rak']);
            // $table->unique(['id_barang', 'id_rak']);
            $table->unique(['id_barang', 'id_rak']);
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
        Schema::dropIfExists('penyimpanan');
    }
}
