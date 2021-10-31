<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rekanan extends Model
{
    protected $table = 'rekanan';

    protected $fillable = [
        'nama', 'pic', 'contact_person', 'active', 'keterangan', 'updated_by'
    ];

    public function updated_by(){
        return $this->hasOne('App\User', 'id', 'updated_by');
    }
}
