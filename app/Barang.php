<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    protected $table = 'barang';

    protected $fillable = [
        'kode_barang','nama', 'kode_barcode', 'active', 'keterangan', 'id_kategori', 'id_satuan', 'updated_by'
    ];

    public function kategori(){
        return $this->hasOne('App\Kategori', 'id', 'id_kategori');
    }

    public function satuan(){
        return $this->hasOne('App\Satuan', 'id', 'id_satuan');
    }

    public function penyimpanan(){
        return $this->hasMany('App\Penyimpanan', 'id_barang');
    }
	
	public function stockakhir(){
        return $this->hasMany('App\StockAkhir', 'id_barang');
    }

    public function updated_by(){
        return $this->hasOne('App\User', 'id', 'updated_by');
    }
}
