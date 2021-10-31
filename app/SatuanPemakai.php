<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SatuanPemakai extends Model
{
    protected $table = 'satuan_pemakai';

    protected $fillable = [
        'nama', 'pic', 'nomor_telephone', 'contact_person', 'active', 'keterangan', 'updated_by'
    ];

    public function updated_by(){
        return $this->hasOne('App\User', 'id', 'updated_by');
    }
}
