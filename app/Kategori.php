<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    protected $table = 'kategori';

    protected $fillable = [
        'nama', 'active', 'keterangan', 'updated_by'
    ];

    public function barang(){
        return $this->hasMany('App\Barang', 'id_kategori');
    }

    public function user(){
        return $this->hasOne('App\User', 'id', 'updated_by');
    }
}
