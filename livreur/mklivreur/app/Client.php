<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    //

      public function command()
    {
        return $this->hasMany('App\Command');
    }


     public function payment()
    {
        return $this->hasMany('App\Payment');
    }
}
