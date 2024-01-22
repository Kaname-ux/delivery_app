<?php

namespace App\Http\Controllers;
use App\Product;
use App\Client;
use App\Fee;
use App\Mooving;
use App\Command;
use App\Costumer;
use App\Livreur;
use App\Product_category;
use App\Helpers\Roles;
use Illuminate\Validation\Rule;
use Illuminate\Support\MessageBag;
use Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
class CostumersController extends Controller
{
    public function costumers(Request $request)
    {
           
        
          $costumers_from_commands = Command::selectRaw('SUM(montant) montant, (phone) phone, (adresse) adresse, (nom_client) nom_client, (fee_id) fee_id')

    ->groupBy(['phone', 'adresse', 'nom_client', 'fee_id'])
    ->get(); 

    foreach($costumers_from_commands as $cfc){
        
        if(Costumer::where("contact", $cfc->phone)->count() == 0 ){
            $new_costumer = new Costumer;

            $new_costumer->name = $cfc->nom_client;
         $new_costumer->contact = preg_replace('/[^0-9]/', '', $cfc->phone);
         
         if($cfc->fee)
         {$new_costumer->locality = $cfc->fee->destination;
                  $new_costumer->adress = str_replace($cfc->fee->destination.':', '',$cfc->adresse);}
                  else{
                    $new_costumer->locality = $cfc->adresse;
                  $new_costumer->adress = $cfc->adresse;
                  }

            $new_costumer->save();
        }
    }


       
         $filter = "";
         $search_result = "";
         $clients = Costumer::orderBy("created_at", "desc");
         if(!empty($request->fees)){
      
      $filter .=  "<div>Filtre Ville/commune: ";
      $clients = $clients->whereIn('locality', $request->fees);
      
      
      foreach($request->fees as $fee){
        

        $filter .= "<strong class='text-dark'>". $fee. "</strong>. ";  
      }
      $filter .=  "</div>";
    }


     if(!empty($request->sexes)){
      
      $filter .=  "<div>Filtre Sexe: ";
      $clients = $clients->whereIn('sexe', $request->sexes);
      
      
      foreach($request->sexes as $sexe){
        

        $filter .= "<strong class='text-dark'>". $sexe. "</strong>. ";  
      }
      $filter .=  "</div>";
    }

    if($request->montant){
        $commands = Command::selectRaw('SUM(montant) montant, (phone) phone')
       ->where('montant', '>=', $request->montant)
       ->groupBy('phone')
       ->toArray();

       $clients = $clients->whereIn("phone", $commands["phone"]);
    }

     if($request->search_term){
        if($request->search_term != ""){
            if($request->search_type == "contact"){
                $clients = $clients->where("contact", preg_replace('/[^0-9]/', '', $request->search_term));
            }

            if($request->search_type == "whatsapp"){
                $clients = $clients->where("whatsapp", preg_replace('/[^0-9]/', '', $request->search_term));
            }

            if($request->search_type == "email"){
                $clients = $clients->where("email",  $request->search_term);
            }

            if($request->search_type == "name"){
               $clients = $clients->where("name", 'like', '%' . $request->search_term . '%' );
            }
        }

      $search_result = "Resultat de recherche pour: ".$request->search_type. " ". $request->search_term;

     }
       
       $clients = $clients->paginate(100); 

        
          
       $fees = Fee::get();
         
        
        return view('clients')->with('clients', $clients)->with("fees", $fees)->with("costumers", $clients->toJson())->with("filter", $filter)->with("search_result", $search_result);

    }

    public function create(Request $request){
         $validatedData = $request->validate([
            'name' => 'bail| string| max:255',
            'locality' => 'required|string| max:255',
            'contact' => 'required| string| max:10| min:10|unique:costumers',
            'whatsapp' => 'string| max:10| min:10|unique:costumers',
            'email' => 'string| email| max:255, unique:costumers',
            
    ]);

         $costumer = new Costumer;
         $costumer->name = $request->name;
         $costumer->contact = preg_replace('/[^0-9]/', '', $request->contact);
         $costumer->whatsapp = preg_replace('/[^0-9]/', '', $request->whats);
         $costumer->locality = $request->locality;
         $costumer->adress = $request->adress;
         $costumer->sexe = $request->sexe;
         $costumer->email = $request->email;

         $costumer->save();

         return redirect()->back()->with("status", "Client enregistre");
    }


    public function edit(Request $request){
         $validatedData = $request->validate([
            'name' => 'bail| string| max:255',
            'locality' => 'required|string| max:255',
            'email' => [
       
        Rule::unique('costumers')->ignore($request->id),
         ],

         'contact' => [
        'required',
        Rule::unique('costumers')->ignore($request->id),
         ],

         'whatsapp' => [
        
        Rule::unique('costumers')->ignore($request->id),
         ],
            
            
    ]);

         $costumer = Costumer::findOrFail($request->id);
         $costumer->name = $request->name;
         $costumer->contact = $request->contact;
         $costumer->whatsapp = $request->whatsapp;
         $costumer->locality = $request->locality;
         $costumer->adress = $request->adress;
         $costumer->sexe = $request->sexe;
         $costumer->email = $request->email;

         $costumer->update();


         return redirect()->back()->with("status", "Client modifie");
    }
}
