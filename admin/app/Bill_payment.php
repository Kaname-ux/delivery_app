<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bill_payment extends Model
{
   public function period(){
   	return $this->belongsTo("App\Offer");
   }

  
}
