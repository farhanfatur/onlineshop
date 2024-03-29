<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $guarded = [];


    public function orderitem()
    {
        return $this->hasMany("App\Model\OrderItem");
    }

    public function buyer()
    {
    	return $this->belongsTo('App\Model\Buyer');
    }

    public function status()
    {
        return $this->belongsTo('App\Model\Status');
    }

    public function province()
    {
        return $this->belongsTo('App\Model\Province');
    }

    public function city()
    {
        return $this->belongsTo('App\Model\City');
    }

}