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


    public function command()
   {
    return $this->belongsToMany('App\Command')->withPivot('qty');
   }
}
