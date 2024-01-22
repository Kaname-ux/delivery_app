<?php

namespace App\Http\Controllers;
use App\Certification;
use App\Livreur;
use App\User;
use App\Client;
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


class CertificationController extends Controller
{
   
    public function certifications()
    {
      $certifications = Certification::orderBy("status", "desc")->paginate(50);

      return view("certifications")->with("certifications", $certifications);
    }


     public function certify(Request $request)
    {
       
        $request->validate([
        'liv_name' => 'bail|required| string| max:255',
        'liv_phone' => 'required| string| max:10| min:10',
        'liv_wphone' => 'required| string| max:10| min:10',
        'pieces'=>'required',
        'liv_id'=>'required',
         'user_id'=>'required'
            
    ]); 
        $name = $request->liv_name;
        $phone = $request->liv_phone;
        $wphone = $request->wphone;
        $liv_id = $request->liv_id;
        $user_id = $request->user_id;
        $pieces = $request->pieces;
        $cert_id = $request->cert_id;

        $livreur = Livreur::findOrFail($liv_id);
        $user = User::findOrFail($user_id);
        $certification = Certification::findOrFail($cert_id);
        $photo_link = $certification->photo_ref;
        $piece_link = $certification->piece_ref;

        $certified_at = date("Y-m-d"); 

        $livreur->photo = $photo_link;
        $livreur->piece_link = $piece_link;
        $livreur->nom = $name;
        $livreur->phone = $phone;
        $livreur->wme = "225".$wphone;
        $livreur->pieces = $pieces;
        $livreur->certified_at = $certified_at;

        $user->name = $name;
        $user->phone = $phone;
        
        $user->certified_at = $certified_at;

        $certification->status = "accepted";

        $certification->update();
        $livreur->update();
        $user->update();
        return redirect()->back()->with("status", "livreur certifié");

    }



        public function refused(Request $request)
    {
       
        $request->validate([
        'reasons' => 'required| string| max:500',
        
            
    ]); 
        
        $reasons = $request->reasons;
        $refused_id = $request->refused_id;

       
        $certification = Certification::findOrFail($refused_id);
        $livreur_id = $certification->livreur_id;
        $livreur = Livreur::findOrFail($livreur_id);

        $livreur->certified_at = NULL;
        $user_id = $livreur->user_id;
        $user = User::findOrFail($user_id);
        $user->certified_at = NULL;



        

        $certification->status = "refused";
        $certification->comment = $reasons;
        
        $certification->certifier_id = Auth()->user()->id;

        $certification->update();
        $livreur->update();
        $user->update();
        return redirect()->back()->with("status", "Certification réfusée");

    }


    public function setcertifier(Request $request)
{

    $id = $request->client_id;
    $client = Client::findOrFail($id);

    $client->is_certifier = "yes";
    $client->update();

    return redirect()->back()->with("status", "Client defini comme certificateur");
}


 public function unsetcertifier(Request $request)
{

    $id = $request->client_id;
    $client = Client::findOrFail($id);

    $client->is_certifier = NULL;
    $client->update();

    return redirect()->back()->with("status", "Client n'est plus certificateur");
}

}
