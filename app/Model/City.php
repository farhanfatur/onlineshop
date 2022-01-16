<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $guarded = [];

    public function province()
    {
        return $this->belongsTo("App\Model\Province");
    }

    public function order()
    {
        return $this->hasOne("App\Model\Order");
    }
}
