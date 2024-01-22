<?php

namespace App\Http\Controllers;

use App\User;
use App\Moto;
use App\Moto_spend;
use App\Livreur;

use App\Sms_mooving;
use App\Setting;
use App\Affect_history;

use App\Helpers\Sms;


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

class MotosController extends Controller
{
   public function motos(){

    $motos = Moto::with("affectations")->with("spends")->get();
    $livreurs = Livreur::where("id", "!=", 11)->get();
    return view("motos")->with("motos", $motos)->with("vmotos", $motos->toJson())->with("livreurs", $livreurs);
   }

   public function create(Request $request){
    $validated = $request->validate([
        'mark' => 'required|max:50',
        'modele' => 'required|max:50',
        'cost' => 'required|Numeric',
        'chassi' => 'required',
        'immatriculation' => 'required',
        'buy_date' => 'required',

    ]);

    $moto = new Moto;

    $moto->name = $request->name;
    $moto->mark = $request->mark;
    $moto->modele = $request->modele;
    $moto->color = $request->color;
    $moto->cost = $request->cost;

    if(is_numeric($request->cost_vign))
    {$moto->cost_vign = $request->cost_vign;}

   if(is_numeric($request->cost_ass))
    {$moto->cost_ass = $request->cost_ass;}

  if(is_numeric($request->cost_vis))
    {$moto->cost_vis = $request->cost_vis;}



  $moto->chassi = $request->chassi;
  $moto->imm = $request->immatriculation;
  $moto->buy_date = $request->buy_date;
  $moto->first_day = $request->start_date;
  $moto->ass_exp = $request->ass_exp;
  $moto->visit_exp = $request->visit_exp;
  



 
  if($request->file())
         {
                $file = $request->file;
                $name = time().'.'.$file->extension();
                $file->move(base_path() . '/storage/app/motos', $name);
               
           $moto->photo = $name; 
         }

  $moto->save();


  if(is_numeric($request->livreur_id)){
    $livreur = Livreur::find($request->livreur_id);
    if($livreur)
    {
      $moto->livreur_id = $livreur->id;
      $moto->livreur_nom = $livreur->nom;
      $moto->update();
      
      $affectation = new Affect_history;


      $affectation->description = $livreur->nom. "_". $livreur->phone;
      $affectation->moto_id = $moto->id;
      $affectation->save();
      
    }

  }

  return redirect()->back()->with("status", "Véhicule engistré");



 
   
   }





     public function edit(Request $request){
    $validated = $request->validate([
        'mark' => 'required|max:50',
        'modele' => 'required|max:50',
        'cost' => 'required|Numeric',
        'chassi' => 'required',
        'immatriculation' => 'required',
        'buy_date' => 'required',

    ]);

    $moto = Moto::findOrFail($request->id);

    $moto->name = $request->name;
    $moto->mark = $request->mark;
    $moto->modele = $request->modele;
    $moto->color = $request->color;
    $moto->cost = $request->cost;

    if(is_numeric($request->cost_vign))
    {$moto->cost_vign = $request->cost_vign;}

   if(is_numeric($request->cost_ass))
    {$moto->cost_ass = $request->cost_ass;}

  if(is_numeric($request->cost_vis))
    {$moto->cost_vis = $request->cost_vis;}



  $moto->chassi = $request->chassi;
  $moto->imm = $request->immatriculation;
  $moto->buy_date = $request->buy_date;
  $moto->first_day = $request->start_date;
  $moto->ass_exp = $request->ass_exp;
  $moto->visit_exp = $request->visit_exp;
  



 
  if($request->file())
         {
                $file = $request->file;
                $name = time().'.'.$file->extension();
                $file->move(base_path() . '/storage/app/motos', $name);
               
           $moto->photo = $name; 
         }

  $moto->update();


  if(is_numeric($request->livreur_id)){
    $livreur = Livreur::find($request->livreur_id);
    if($livreur)
    {
       if($moto->livreur_id != $request->livreur_id) 
      {$moto->livreur_id = $livreur->id;
            $moto->livreur_nom = $livreur->nom;
            $moto->update();
            
           
            $affectation = new Affect_history;
      
      
            $affectation->description = $livreur->nom. "_". $livreur->phone;
            $affectation->moto_id = $moto->id;
            $affectation->save();
        }
      
    }

  }

  return redirect()->back()->with("status", "Modifications effectuées");

   }
   

   public function deletemoto(Request $request){
    $moto = Moto::findOrFail($request->id);

    if($moto->spends->count() > 0)
    {$moto->spends->delete();}
    $moto->delete();

    return redirect()->back()->with("status", "Véhicule supprimé");
   }
   

   public function addspend(Request $request){
    $id = $request->id;

     $validated = $request->validate([
        'amount' => 'required|Numeric',
        'spenddate' => 'required',
        'nature' => 'required|max:100',
        'description' => 'max:500',
        
        'file' => 'mimes:jpg,png,jpeg|max:10240',
        'id' => 'exists:motos'
        

    ]);

   $spend = new Moto_spend;

   $spend->montant = $request->amount;
   $spend->spend_date = $request->spenddate;
   $spend->nature = $request->nature;
   $spend->description = $request->description;
   $spend->moto_id = $id;
   $spend->moto_description = $request->motodescription;
   $spend->moto_chassi = $request->chassi;


   if($request->file())
         {
                $file = $request->file;
                $name = time().'.'.$file->extension();
                $file->move(base_path() . '/storage/app/spendpieces', $name);
               
           $spend->piece = $name; 
         }

    $spend->save();
    return redirect()->back()->with("status", "dépense ajoutée");
   }



    public function editspend(Request $request){
    $id = $request->id;

     $validated = $request->validate([
        'amount' => 'required|Numeric',
        'spenddate' => 'required',
        'nature' => 'required|max:100',
        'description' => 'max:500',
        
        'file' => 'mimes:jpg,png,jpeg|max:10240',
        'id' => 'exists:moto_spends'
        

    ]);

   $spend = Moto_spend::findOrFail($id);

   $spend->montant = $request->amount;
   $spend->spend_date = $request->spenddate;
   $spend->nature = $request->nature;
   $spend->description = $request->description;
   $spend->moto_id = $request->moto_id;


   


   if($request->file())
         {
                $file = $request->file;
                $name = time().'.'.$file->extension();
                $file->move(base_path() . '/storage/app/spendpieces', $name);
               
           $spend->piece = $name; 
         }
    $description = "";
   $moto = Moto::findOrFail($request->moto_id);
    if($moto->name){
            $description .= $moto->name . "_";
         }

         $description .= $moto->mark . "_" . $moto->modele . "_" . $moto->color;

     $spend->moto_description = $description;
   $spend->moto_chassi = $moto->chassi;         

    $spend->update();
    return redirect()->back()->with("status", "dépense modifiée");
   }



public function affectmoto(Request $request){

    $moto = Moto::findOrFail($request->id);
     if(is_numeric($request->livreur_id)){
    $livreur = Livreur::find($request->livreur_id);
    if($livreur)
    {
      $moto->livreur_id = $livreur->id;
      $moto->livreur_nom = $livreur->nom;
      $moto->update();
      
      $affectation = new Affect_history;


      $affectation->description = $livreur->nom. "_". $livreur->phone;
      $affectation->moto_id = $moto->id;
      $affectation->save();
      
    }

  }

   return redirect()->back()->with("status", "Affectation effectuée");
}


public function deletespend(Request $request){
    $spend = Moto_spend::findOrFail($request->id);

    $spend->delete();
  

    return redirect()->back()->with("status", "Dépense supprimée");
   }

}






