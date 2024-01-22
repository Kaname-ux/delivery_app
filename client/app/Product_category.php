<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product_category extends Model
{
    
    public function client()
   {
    return $this->belongsTo('App\Client');
   }

   
   
}
