<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    //

      public function commands()
    {
        return $this->hasMany('App\Command');
    }


    public function subscriptions()
   {
   	return $this->hasMany('App\Subscription');
   }

    public function products()
   {
    return $this->hasMany('App\Product');
   }

   public function categories()
   {
    return $this->hasMany('App\Product_category');
   }

   public function sources()
   {
    return $this->hasMany('App\Source');
   }

    public function payment()
   {
   	return $this->hasMany('App\Payment');
   }

 public function fast_commands()
   {
   	return $this->hasMany('App\Fast_command');
   }

   public function livreurs()
   {
   	  return $this->belongsToMany('App\Livreur');
   }

   public function settings()
   {
      return $this->belongsToMany('App\Setting')->withPivot('text');
   }


public function manager()
   {
   	  return $this->belongsTo('App\Manager');
   }


}
