<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BarangKeluar extends Model
{
    protected $table = 'barang_keluar';

    protected $fillable = [
        'nomor_surat', 'nomor_nota_dinas', 'nomor_ba', 'nomor_sa', 'tahun_anggaran', 'tanggal_input', 'active', 'keterangan', 'id_gudang', 'id_satuan_pemakai', 'updated_by'
    ];

    protected $appends = array('nama_satuan_pemakai', 'nama_gudang', 'nota_dinas');

    public function getNamaSatuanPemakaiAttribute()
    {
        return $this->satuan_pemakai->nama;  
    }

    public function getNamaGudangAttribute()
    {
        return $this->gudang->nama;  
    }

    public function getNotaDinasAttribute()
    {
        if ( ($this->nomor_nota_dinas != '' || $this->nomor_nota_dinas != null)  && ($this->nomor_surat == '' || $this->nomor_surat == null) ){
            return true;
        }else {
            return false;
        }
    }

    public function details(){
        return $this->hasMany('App\DetailBarangKeluar', 'id_barang_keluar');
    }

    public function gudang(){
        return $this->hasOne('App\Gudang', 'id', 'id_gudang');
    }

    public function satuan_pemakai(){
        return $this->hasOne('App\SatuanPemakai', 'id', 'id_satuan_pemakai');
    }

    public function updated_by(){
        return $this->hasOne('App\User', 'id', 'updated_by');
    }
}
