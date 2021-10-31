<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Business extends Model
{
    //
    protected $table = 'business';

    protected $fillable = [
        'name', 'desc_name', 'currency_id', 'start_date', 'tax', 'discount_name', 'discount_value', 'logo', 'icon'
    ];

    public function currency(){
        return $this->belongsTo('App\Currency');
    }

    public function locations(){
        return $this->hasMany('App\BusinessLocation', 'business_id');
    }

}
