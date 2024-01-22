<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User_type extends Model
{
   public function roles(){
   	return $this->hasMany("App\Role");
   }
}
