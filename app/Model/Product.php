<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $guarded = [];

    public function seller()
    {
    	return $this->belongsTo('App\Model\Seller');
    }

    public function category()
   	{
   		return $this->belongsTo('App\Model\Category');
   	}

   	public function order()
   	{
   		return $this->hasMany('App\Model\Order');
   	}
}
