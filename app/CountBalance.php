<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CountBalance extends Model
{
    protected $table = 'count_balance';

    public function gudang(){
        return $this->hasOne('App\Gudang', 'id', 'id_gudang');
    }

    public function barang(){
        return $this->hasOne('App\Barang', 'id', 'id_barang');
    }

}
