<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSatuanPemakaiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('satuan_pemakai', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('pic')->nullable();
            $table->string('nomor_telephone')->nullable();
            $table->string('contact_person')->nullable();
            $table->integer('active');
            $table->string('keterangan')->nullable();
            
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
        Schema::dropIfExists('satuan_pemakai');
    }
}
