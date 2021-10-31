<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBarangMasukTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('barang_masuk', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_ba')->nullable();
            $table->string('nomor_kontrak')->nullable();
            $table->string('nomor_kph')->nullable();
            $table->string('nomor_surat')->nullable();
            $table->integer('tahun_anggaran')->nullable()->default(NULL);
            $table->date('tanggal_input')->nullable()->default(NULL);
            $table->integer('active');
            $table->string('keterangan')->nullable();
            
            $table->unsignedBigInteger('id_gudang');
            $table->foreign('id_gudang')->references('id')->on('gudang');

            $table->unsignedBigInteger('id_rekanan');
            $table->foreign('id_rekanan')->references('id')->on('rekanan');

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
        Schema::dropIfExists('barang_masuk');
    }
}
