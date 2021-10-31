<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BusinessLocation extends Model
{
    protected $fillable = [
        'location_id', 'business_id', 'name', 'country', 'state', 'city', 'zip_code', 'address', 'mobile', 'alternate_number', 'email', 'printer_id', 'is_active'
    ];

    public function business(){
        return $this->belongsTo('App\Business');
    }
}
