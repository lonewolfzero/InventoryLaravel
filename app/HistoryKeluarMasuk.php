<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HistoryKeluarMasuk extends Model
{
    protected $table = 'history_keluar_masuk';

    protected $appends = array('nama_gudang', 'nama_barang');

    public function getNamaGudangAttribute()
    {
        return $this->gudang->nama;  
    }

    public function getNamaBarangAttribute()
    {
        return $this->barang->nama;
    }

    public function gudang(){
        return $this->hasOne('App\Gudang', 'id', 'id_gudang');
    }

    public function barang(){
        return $this->hasOne('App\Barang', 'id', 'id_barang');
    }

}
