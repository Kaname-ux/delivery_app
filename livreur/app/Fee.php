<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fee extends Model
{
   
      public function command()
    {
        return $this->hasMany('App\Command');
    }
}
