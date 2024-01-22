<?php

namespace App\Http\Controllers\Client;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ClientController extends Controller
{
   public function commandregister(Request $request)
    {
       
       $model = new Command;
      
       
       
       $model->description = $request->input('descript');
       $model->montant = $request->input('montant');
       $model->delivery_date = $request->input('deliv_date');
       $model->adresse = $command_adress;
       
       $model->client_id = $request->input('client');
       $model->phone = $request->input('phone');
       $model->fee_id = $request->input('fee');
       $model->etat = "encours";
       $model->user_id = Auth::user()->user_id;

       
       $model->observation = $request->input('observation');

       $model->save();


       return redirect('/dashboard')->with('status', "Commande Ajoutée");

    }


    public function commandlist()
    {
    	$user_id = Auth::user()->user_id;
        if(request()->has('status'))
        {
           $commands = Command::where('user_id', $user_id)->where('etat', request('status'))->paginate(100)
           ->appends('status', request('status'));
        }

        else
    	{$commands = where('user_id', $user_id)->paginate(100);}
    	
    	$etats = array('encours', 'annule', 'termine');
        
        return view('clientcommand')->with('commands', $commands)->with('etats', $etats);

    }

     public function commandform()
    {
    	
    	
    	$fees = Fee::all();
    	

        return view('clientcommandregister')->with('fees', $fees);

    }

     
     public function commandedit($id)
    {
       $command = Command::findOrFail($id);
       
    	$fees = Fee::all();
    	$etats = array('encours', 'annule', 'termine');

       return view('clientcommandedit')->with('fees', $fees)->with('command', $command);
    }


    public function commandupdate(Request $request, $id)
    {
        
        $model = Command::findOrFail($id);
        $model->description = $request->input('descript');
       $model->montant = $request->input('montant');
       $model->delivery_date = $request->input('deliv_date');
       $model->adresse = $command_adress;
       
       $model->client_id = $request->input('client');
       $model->phone = $request->input('phone');
       $model->fee_id = $request->input('fee');
       $model->etat = "encours";
       

       
       $model->observation = $request->input('observation');

       $model->save();


       return redirect('/clientcommand')->with('status', "Commande modifiée");
    }



}
