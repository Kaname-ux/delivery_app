<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client_fee extends Model
{
    
    protected $dates = [
        'created_at',
        'updated_at',
        
    ];
   protected $integers = ['price'];


   public function client()
   {
   	return $this->belongsTo('App\Client');
   }
   
   public function user()
   {
   	return $this->belongsTo('App\User');
   }



  
}
