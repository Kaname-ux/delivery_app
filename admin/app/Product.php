<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    
   public function client()
   {
    return $this->belongsTo('App\Client');
   }

    public function supplier()
   {
    return $this->belongsTo('App\Supplier');
   }


   public function shop()
   {
    return $this->belongsTo('App\Shop');
   }


   public function moovings()
   {
    return $this->hasMany('App\Mooving');
   }


    public function command()
   {
    return $this->belongsToMany('App\Command')->withPivot('qty');
   }
}
