<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lesroute extends Model
{
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
        'action_date'
    ];

    public function livreur(){
        return $this->belongsTo("App\Livreur"); 
    }
}
