<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mooving extends Model
{
    //
    protected $dates = ['created_at'];

     public function product()
   {
   	return $this->belongsTo('App\Product');
   }
}
