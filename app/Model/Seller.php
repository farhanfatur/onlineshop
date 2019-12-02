<?php

namespace App\Model;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
class Seller extends Authenticatable
{
	 use Notifiable;
    protected $guarded = [];

  	public function product()
  	{
  		return $this->hasMany('App\Model\Product');
  	}

  	public function bank()
  	{
  		return $this->hasMany('App\Model\Bank');
  	}
}
