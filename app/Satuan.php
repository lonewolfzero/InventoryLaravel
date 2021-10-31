<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Satuan extends Model
{
    protected $table = 'satuan';

    protected $fillable = [
        'nama', 'active', 'keterangan', 'updated_by'
    ];

    public function user(){
        return $this->hasOne('App\User', 'id', 'updated_by');
    }
}
