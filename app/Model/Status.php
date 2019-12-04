<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Status extends model
{
	 protected $guarded = [];

   public function order()
   {
      return $this->belongsTo('App\Model\Order');
   }
}
