<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    //
    protected $dates = ['created_at'];

     public function command()
   {
   	return $this->belongsTo('App\Command');
   }


   public function livreur()
   {
    return $this->belongsTo('App\Livreur');
   }
}
