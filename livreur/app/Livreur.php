<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Livreur extends Model
{
    public function command()
    {
        return $this->hasMany('App\Command');
    }
}
