<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    protected $guarded = [];

    public function seller()
    {
    	return $this->belongsTo('App\Model\Seller');
    }

    public function order()
    {
    	return $this->hasMany('App\Model\Order');
    }
}
