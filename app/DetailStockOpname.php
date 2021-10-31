<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetailStockOpname extends Model
{
    protected $table = 'detail_stock_opname';

    protected $fillable = [
        'id_stock_opname', 'id_barang', 'tahun_anggaran', 'harga', 'jumlah' , 'keterangan'
    ];

    public function stockOpname(){
        return $this->hasOne('App\StockOpname', 'id', 'id_stock_opname');
    }

    public function barang(){
        return $this->hasOne('App\Barang', 'id', 'id_barang');
    }
}
