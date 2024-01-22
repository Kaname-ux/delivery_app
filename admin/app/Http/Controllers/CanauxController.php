<?php

namespace App\Http\Controllers;
use App\Source;
use App\Client;

use Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
class CanauxController extends Controller
{
   public function canaux(){

    $client = Client::findOrFail(Auth::user()->client_id);
    $canaux = Source::get();
     
    return view("canaux")->with("canaux", $canaux->toJson())->with("client", $client);

   }

   public function create(Request $request){
     $validated = $request->validate([
        'antity' => 'required',
        'type' => 'required',

    ]);
 
    $source = new Source;
    $source->antity = $request->antity;
    $source->type = $request->type;
    $source->client_id = Auth::user()->client_id;

    $source->description = $request->description;


     
   
     $source->save();

     

     return redirect()->back()->with("status", "Canal enregistre");

  }


  public function edit(Request $request){
     $validated = $request->validate([
        'antity' => 'required',
        'type' => 'required',

    ]);
 
    $source = source::findOrFail($request->id);
    $source->antity = $request->antity;
    $source->type = $request->type;
    $source->client_id = Auth::user()->client_id;

    $source->description = $request->description;


     
   
     $source->save();

     

     return redirect()->back()->with("status", "Canal modifie");

  }



   public function delete(Request $request){
     $source = source::findOrFail($request->id)->delete();
     
     return redirect()->back()->with("status", "Canal supprime");

  }

  
}
