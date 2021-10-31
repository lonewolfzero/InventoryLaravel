<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBarangKeluarTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('barang_keluar', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_surat')->nullable();
            $table->string('nomor_nota_dinas')->nullable();
            $table->string('nomor_ba')->nullable();
            $table->string('nomor_sa')->nullable();
            $table->date('tanggal_input')->nullable()->default(NULL);
            $table->integer('active');
            $table->string('keterangan')->nullable();
            
            $table->unsignedBigInteger('id_gudang');
            $table->foreign('id_gudang')->references('id')->on('gudang');

            $table->unsignedBigInteger('id_satuan_pemakai');
            $table->foreign('id_satuan_pemakai')->references('id')->on('satuan_pemakai');

            $table->unsignedBigInteger('updated_by');
            $table->foreign('updated_by')->references('id')->on('users');
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
        Schema::dropIfExists('barang_keluar');
    }
}
