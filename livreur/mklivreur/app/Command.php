<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Command extends Model
{
    
   protected $dates = ['delivery_date'];
   protected $integers = ['montant'];


   public function client()
   {
   	return $this->belongsTo('App\Client');
   }

   public function livreur()
   {
   	return $this->belongsTo('App\Livreur');
   }

   public function fee()
   {
   	return $this->belongsTo('App\Fee');
   }

   public function note()
   {
      return $this->hasMany('App\Note');

   }

   public function payment()
    {
        return $this->hasOne('App\Payment');
    }
  
}
