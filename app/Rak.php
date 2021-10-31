<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rak extends Model
{
    protected $table = 'rak';

    protected $fillable = [
        'id_gudang', 'nama', 'active', 'keterangan', 'updated_by'
    ];

    public function gudang(){
        return $this->hasOne('App\Gudang', 'id', 'id_gudang');
    }

    public function penyimpanan(){
        return $this->hasMany('App\Penyimpanan', 'id_rak');
    }

    public function updated_by(){
        return $this->hasOne('App\User', 'id', 'updated_by');
    }
}
