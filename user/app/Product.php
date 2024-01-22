<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    
   public function client()
   {
    return $this->belongsTo('App\Client');
   }


   public function moovings()
   {
    return $this->hasMany('App\Mooving');
   }

   public function images()
   {
    return $this->hasMany('App\Product_image');
   }

  public function variants()
   {
    return $this->hasMany('App\Product_variant');
   }


    public function command()
   {
    return $this->belongsToMany('App\Command')->withPivot('qty');
   }
}
