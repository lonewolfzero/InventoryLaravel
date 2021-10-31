<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StockOpname extends Model
{
    protected $table = 'stock_opname';

    protected $fillable = [
        'nomor_stock_opname', 'tanggal_pelaksanaan', 'active', 'id_gudang', 'updated_by'
    ];

    public function getTanggalPelaksanaanAttribute()
    {
        return \Carbon\Carbon::parse($this->attributes['tanggal_pelaksanaan'])->format('Y-m-d');
    }

    public function details(){
        return $this->hasMany('App\DetailStockOpname', 'id_stock_opname');
    }

    public function gudang(){
        return $this->hasOne('App\Gudang', 'id', 'id_gudang');
    }

    public function updated_by(){
        return $this->hasOne('App\User', 'id', 'updated_by');
    }
}
