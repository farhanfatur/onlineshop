<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $guarded = [];

   	public function product()
   	{
   		return $this->hasMany('App\Model\Product');
   	}

	public function productNotDelete()
	{
		return $this->hasMany('App\Model\Product')->where('is_delete', '0');
	}
}
