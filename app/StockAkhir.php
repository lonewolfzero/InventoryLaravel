<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StockAkhir extends Model
{
    protected $table = 'stock_akhir_g_b_ta_h';

    public function gudang(){
        return $this->hasOne('App\Gudang', 'id', 'id_gudang');
    }

    public function barang(){
        return $this->hasOne('App\Barang', 'id', 'id_barang');
    }
}
