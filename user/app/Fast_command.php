<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fast_command extends Model
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

 public function fee()
   {
    return $this->belongsTo('App\Fee');
   }
  
}
