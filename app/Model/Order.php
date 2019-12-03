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

}