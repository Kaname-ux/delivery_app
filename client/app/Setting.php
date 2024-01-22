<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{

   protected $fillable = [
        'switch', 'message'
    ];
   

   public function clients()
    {
        return $this->belongsToMany('App\Client')->withPivot('text');
    }
}
