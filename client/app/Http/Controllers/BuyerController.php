<?php

namespace App\Http\Controllers;

use App\User;
use App\Command;
use App\Client;
use App\Fee;
use App\Livreur;
use App\Friendship;
use App\Verify;
use App\Fast_command;
use App\Lesroute;
use App\Payment;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\MessageBag;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use DateTime;
use willvincent\Rateable\Rating;

class BuyerController extends Controller
{

  

public function setloc(Request $request){
  $cmd_id = $request->cmd_id;
  $lat = $request->lat;
  $long = $request->long;
  $order = Command::findOrFail($cmd_id);

  $order->longitude = $long;
  $order->latitude = $lat;

  $order->update();
  return view('tracking')->with('order',$order)->with('status', "Votre localisation a bien été envoyée! Merci!");
  
}


public function tracking($id)
{
   $order = Command::findOrFail($id);
   $status ="";
   return view('tracking')->with('order',$order)->with("status", $status); 
   
}





}






