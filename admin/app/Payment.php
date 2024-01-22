<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    //

    protected $dates = ["payment_date"];

    public function client()
   {
   	return $this->belongsTo('App\Client');
   }


    public function user()
   {
   	return $this->belongsTo('App\User');
   }


    public function livreur()
   {
    return $this->belongsTo('App\Livreur');
   }


   public function command()
   {
    return $this->belongsTo('App\Command');
   }
}
