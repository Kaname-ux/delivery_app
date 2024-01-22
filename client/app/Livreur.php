<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use willvincent\Rateable\Rateable;
class Livreur extends Model
{  
	use Rateable;

    

    public function commands()
    {
        return $this->hasMany('App\Command')->orderBy('updated_at', 'desc');
    }

    public function payments()
    {
        return $this->hasMany('App\Payment');
    }

    public function clients()
    {
        return $this->belongsToMany('App\Client');
    }

    public function difuses()
    {
        return $this->belongsToMany('App\Difuse');
    }


    public function signalings()
    {
        return $this->hasMany('App\Signaling');
    }
}
