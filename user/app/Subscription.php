<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    //

     public function livreurs()
   {
      return $this->belongsToMany('App\Livreur');
   }

   public function commands(){
      return $this->hasMany("App\Command");
   }

   public function periods(){
      return $this->hasMany("App\Billing_period");
   }
}
