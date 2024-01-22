<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Signaling extends Model
{
    
  

    protected $dates = [
        'created_at',
        'updated_at',
        
    ];
   


   public function clients()
   {
   	return $this->belongsTo('App\Client');
   }

   public function livreurs()
   {
   	return $this->belongsTo('App\Livreur');
   }

   

  
}
