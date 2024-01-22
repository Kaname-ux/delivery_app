<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Billing_period extends Model
{
   public function offer(){
   	return $this->belongsTo("App\Offer");
   }

   public function payments(){
      return $this->hasMany("App\Bill_payment");
   }
}
