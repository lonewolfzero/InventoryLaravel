<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Penyimpanan extends Model
{
    protected $table = 'penyimpanan';

    protected $fillable = [
        'id_barang', 'id_rak', 'active', 'updated_by'
    ];

    public function barang(){
        return $this->hasOne('App\Barang', 'id', 'id_barang');
    }

    public function rak(){
        return $this->hasOne('App\Rak', 'id', 'id_rak');
    }
    
    public function updated_by(){
        return $this->hasOne('App\User', 'id', 'updated_by');
    }
}
