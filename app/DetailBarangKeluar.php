<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetailBarangKeluar extends Model
{
    protected $table = 'detail_barang_keluar';

    protected $fillable = [
        'id_barang_keluar', 'harga', 'jumlah', 'keterangan', 'id_barang'
    ];

    public function barangKeluar(){
        return $this->hasOne('App\BarangMasuk', 'id', 'id_barang_keluar');
    }

    public function barang(){
        return $this->hasOne('App\Barang', 'id', 'id_barang');
    }
}
