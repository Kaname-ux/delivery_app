<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Moto extends Model
{
    //

   public function spends()
    {
        return $this->hasMany('App\Moto_spend');
    } 

    public function affectations()
    {
        return $this->hasMany('App\Affect_history');
    } 

    public function charge()
    {
        return $this->hasMany('App\Charge');
    }

    public function livreur()
    {
        return $this->belongsTo('App\Livreur');
    } 
}
