<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tarif extends Model
{
    

   public function fee()
   {
    return $this->belongsTo('App\Fee');
   }
}
