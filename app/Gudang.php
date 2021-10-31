<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Gudang extends Model
{
    protected $table = 'gudang';

    protected $fillable = [
        'nama', 'nomor', 'active', 'keterangan', 'updated_by'
    ];

    public function barangMasuk(){
        return $this->hasMany('App\BarangMasuk', 'id_gudang');
    }

    public function penyimpanan(){
        return $this->hasMany('App\Penyimpanan', 'id_gudang');
    }

    public function rak(){
        return $this->hasMany('App\Rak', 'id_gudang');
    }

    public function updated_by(){
        return $this->hasOne('App\User', 'id', 'updated_by');
    }
}
