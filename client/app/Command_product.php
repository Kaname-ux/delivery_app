<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
class Command_product extends Model
{
    protected $table = 'command_product';

   public function product()
   {
    return $this->belongsTo('App\Product');
   }
}
