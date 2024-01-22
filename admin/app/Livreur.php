<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Livreur extends Model
{
    public function commands()
    {
        return $this->hasMany('App\Command');
    }


    public function notes()
    {
        return $this->hasMany('App\Note');
    }

    public function lesroutes()
    {
        return $this->hasMany('App\Lesroute');
    }

   public function user()
    {
    return $this->hasOne('App\User');
   }


   public function payment()
    {
    return $this->hasOne('App\Payment');
   }

   public function payments()
    {
    return $this->hasMany('App\Payment');
   }


   public function subscriptions()
    {
        return $this->belongsToMany('App\Subscription');
    }
}  

