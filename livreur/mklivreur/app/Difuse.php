<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Difuse extends Model
{
    //

    public function livreurs()
    {
        return $this->belongsToMany('App\Livreur')->withPivot('longitude', 'latitude')->withTimestamps();;
    }

    public function client(){
        return $this->belongsTo('App\Client');
    }
}
