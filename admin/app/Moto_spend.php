<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Moto_spend extends Model
{
    //

   public function moto()
    {
        return $this->belongsTo('App\Moto');
    } 

    
}
