<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Charge extends Model
{
    //

    protected $dates = ['charge_date'];

    public function moto()
   {
   	return $this->belongsTo('App\Moto');
   }
}
