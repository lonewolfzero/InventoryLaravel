<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VStockOpnameDetail extends Model
{
    protected $table = 'v_stock_opname_detail';

    public function stockOpname(){
        return $this->hasOne('App\StockOpname', 'id', 'id_stock_opname');
    }

    public function detail(){
        return $this->hasOne('App\DetailStockOpname', 'id', 'id_stock_opname_detail');
    }

    public function barang(){
        return $this->hasOne('App\Barang', 'id', 'id_barang');
    }
}
