<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{

   protected $fillable = [
        'antity', 'client_type', 'action', 'switch', 'description'
    ];
   public function usertype(){
   	return $this->belongsTo("App\User_type");
   }
}
