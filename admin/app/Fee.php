<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fee extends Model
{
     public function tarifs()
   {
      return $this->hasMany('App\Tarif');
   }
     public function command()
    {
        return $this->hasMany('App\Command');
    }

    public function commands()
    {
        return $this->hasMany('App\Command');
    }
}
