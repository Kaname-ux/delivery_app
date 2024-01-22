<?php

namespace App\Http\Controllers;
use App\User;
use App\Livreur;
use App\Difuse;

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

class DifusionsController extends Controller
{

  public function difusions(Request $request)
{
  $today = date("Y-m-d");
  $livreur = Livreur::findOrFail(Auth::user()->livreur_id);
  $today = date("Y-m-d");
  $difusions = Difuse::where("status", "encours")->orderBy("created_at", "desc")->where("delivery_date", ">=", $today);

  if($request->departs){
    $departs = $request->departs;
    $arrivees = $request->arrivees;

    if(!empty($departs)){
     $difusions = $difusions->whereIn('ram_adress', $departs);
      
      
    }



    if(!empty($arrivees)){

      for($y=0; $y<=count($arrivees)-1; $y++){

        if($y==0){
          $difusions = $difusions->where('destinations', 'LIKE', '%'.$arrivees[$y].'%');
        }else{
          $difusions = $difusions->orWhere('destinations', 'LIKE', '%'.$arrivees[$y].'%');
        }
      }
      
    }
  }

  $difusions = $difusions->paginate(20);

  return view("difusions")->with("difusions", $difusions)->with("livreur", $livreur);
}

public function postule(Request $request)
 {
  $id = $request->id;
  $livreur_id = Auth::user()->livreur_id;
  $lat = $request->lat;
  $long = $request->long;
  $post = $request->post;

  $difusion = Difuse::findOrFail($id);
  if($post == "postule")
{
   if(!$difusion->livreurs->contains($livreur_id))
   { 
    $difusion->livreurs()->attach($livreur_id);
    $difusion->livreurs()->sync([$livreur_id => ['longitude' => $long, 'latitude'=>$lat]]);
     

     return response()->json(['status'=>1]);

   }else{
    return response()->json(['status'=>2]);
   }
 }
if($post == "cancel")
 {
  $difusion->livreurs()->detach($livreur_id);
  return response()->json(['status'=>1]);
 }
 }
  
}






