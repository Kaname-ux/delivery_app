<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Manager extends Model
{

   public function livreurs()
    {
    	return $this->belongsToMany('App\Livreur');
    }
   
   

    public function fast_commands()
    {
        return $this->hasMany('App\Fast_command');
    }


      public function command()
    {
        return $this->hasMany('App\Command');
    }


     public function payment()
    {
        return $this->hasMany('App\Payment');
    }


     public function client()
    {
        return $this->hasMany('App\Client');
    }


}
