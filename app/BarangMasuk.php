<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BarangMasuk extends Model
{
    protected $table = 'barang_masuk';

    protected $fillable = [
        'nama', 'nomor_ba', 'nomor_kontrak', 'nomor_kph', 'nomor_surat', 'tahun_anggaran', 'tanggal_input', 'active', 'keterangan', 'id_gudang', 'id_rekanan', 'updated_by'
    ];

    protected $appends = array('nama_rekanan');

    public function getNamaRekananAttribute()
    {
        return $this->rekanan->nama;  
    }

    public function details(){
        return $this->hasMany('App\DetailBarangMasuk', 'id_barang_masuk');
    }

    public function gudang(){
        return $this->hasOne('App\Gudang', 'id', 'id_gudang');
    }

    public function rekanan(){
        return $this->hasOne('App\Rekanan', 'id', 'id_rekanan');
    }

    public function updated_by(){
        return $this->hasOne('App\User', 'id', 'updated_by');
    }
}
