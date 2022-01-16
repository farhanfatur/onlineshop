<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    protected $guarded = [];

    public function city()
    {
        return $this->hasMany("App\Model\City");
    }

    public function order()
    {
        return $this->hasOne("App\Model\Order");
    }
}
