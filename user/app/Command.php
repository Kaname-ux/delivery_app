<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Command extends Model
{
    
    protected $dates = [
        'created_at',
        'updated_at',
        'delivery_date'
    ];
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
   	return $this->belongsTo('App\Fee')->orderBy('zone');
   }

   public function payment()
    {
        return $this->hasOne('App\Payment');
    }

    public function note()
   {
      return $this->hasMany('App\Note');
   }

   public function events()
   {
      return $this->hasMany('App\Command_event');
   }

    public function products()
   {
      return $this->belongsToMany('App\Product')->withPivot(["price", "qty"]);
   }


  
}
