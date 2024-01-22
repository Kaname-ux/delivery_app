<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Affect_history extends Model
{
    //


    public function moto()
    {
        return $this->belongsTo('App\Moto');
    } 
}
