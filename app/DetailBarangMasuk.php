<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetailBarangMasuk extends Model
{
    protected $table = 'detail_barang_masuk';

    protected $fillable = [
        'id_barang_masuk', 'harga', 'jumlah', 'keterangan', 'id_barang'
    ];

    public function barangMasuk(){
        return $this->hasOne('App\BarangMasuk', 'id', 'id_barang_masuk');
    }

    public function barang(){
        return $this->hasOne('App\Barang', 'id', 'id_barang');
    }
}
