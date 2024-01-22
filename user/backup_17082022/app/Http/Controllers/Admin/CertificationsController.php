<?php

namespace App\Http\Controllers;
use App\User;
use App\Livreur;
use App\Certification;

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

class CertificationsController extends Controller
{

  public function certification()
{
  
  $livreur = Livreur::findOrFail(Auth::user()->livreur_id);
  $current = Certification::where('livreur_id',$livreur->id)->where("status", "pending")->latest()->first();

  return view("certification")->with("livreur", $livreur)->with("current", $current);
}


 public function send(Request $request)
{
  
  $request->validate([
        'file' => 'required|mimes:jpeg,png|max:2048',
        'piece_photo' => 'required|mimes:jpeg,png|max:2048',
        'name' => 'required|string|max:250',
        'phone'=>'required|min:10',
        'wphone'=>'required|min:10' 

        ]);
     $id = Auth::user()->livreur_id;
      $check_pendind = Certification::where("status", "pending")->where("livreur_id", $id)->first();

      if($check_pendind)  
      {
        return redirect()->back()
            ->with('status','Vous avez dejà une demande de certification en attente.');
      }
        $name = $request->name;
        $phone = $request->phone;
        $wphone = $request->wphone;

        
        $user_id = Auth::user()->id;
        $verif = New Certification;

        $verif->name = $name;
        $verif->phone = $phone;
        $verif->wphone = $wphone;
        $verif->livreur_id = $id;
        $verif->user_id = $user_id;
        $verif->status = "pending"; 
        if($request->file()) { 
            
            $path = Storage::disk('s3')->put('image',$request->file, 'public');
            
            
            $verif->photo_ref = $path;
           
            $piece_path = Storage::disk('s3')->put('piece',$request->piece_photo, 'public');
            
            
            $verif->piece_ref = $piece_path;
           
        }


        

        $verif->save();

         return redirect()->back()
            ->with('status','Demandes de certification envoyée.');
}

  
}






