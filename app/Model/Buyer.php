<?php

namespace App\Model;

use Illuminate\Notifications\Notifiable;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
class Buyer extends Authenticatable
{
	use Notifiable;
    protected $guarded = [];

    public function order()
    {
        return $this->hasMany('App\Model\Order');
    }
}
