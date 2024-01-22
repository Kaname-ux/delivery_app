<?php

namespace App\Http\Controllers;

use App\Signaling;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\MessageBag;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use DateTime;

use Illuminate\Database\Eloquent\Builder;

class SignalingsController extends Controller
{

  

 public function signal(Request $request)
{
  
  $request->validate([
        'reasons' => 'required|string',
        'liv_id' => 'required',
        'fact_date' => 'required', 

        ]);
        

        $reasons = $request->reasons;
        $liv_id = $request->liv_id;
        $fact_date = $request->fact_date;
        $comment = $request->comment;
        
        $client_id = Auth::user()->client_id;
        $signaling = New Signaling;
         
         $signaling->reasons = $reasons;
         $signaling->livreur_id = $liv_id;
         $signaling->client_id = $client_id;
         $signaling->fact_date = $fact_date;
         $signaling->comment = $comment;



        
         
        


        

        $signaling->save();

         return redirect()->back()
            ->with('status','Signalement enregistré.');
}

  
}






