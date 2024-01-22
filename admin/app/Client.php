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

     public function subscriptions()
    {
        return $this->hasMany('App\Subscription');
    }
    
     public function commands()
    {
        return $this->hasMany('App\Command');
    }

     public function departments()
    {
        return $this->hasMany('App\Department');
    }


     public function payment()
    {
        return $this->hasMany('App\Payment');
    }


    public function user()
    {
    return $this->hasOne('App\User');
   }


   public function scopeManager($query)
{
    
    return $this->where("is_manager", 1);
  
}


  public function scopeSalesmen($query)
{
    
    return $this->where("is_manager", null);
  
}
   
}
