<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $guarded = [];

	public function order()
    {
    	return $this->belongsTo('App\Model\Order');
    }    

    public function buyer()
    {
    	return $this->belongsTo('App\Model\Buyer');
    }

    public function product()
    {
    	return $this->belongsTo('App\Model\Product');
    }

    public function bank()
    {
    	return $this->belongsTo('App\Model\Bank');
    }
}
