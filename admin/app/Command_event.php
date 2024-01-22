<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Command_event extends Model
{
    //
    protected $dates = ['created_at'];

     public function command()
   {
   	return $this->belongsTo('App\Command');
   }

   public function user()
   {
    return $this->belongsTo('App\User');
   }
}
