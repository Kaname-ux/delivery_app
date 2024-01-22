<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\Command;
use App\Client;
use App\Livreur;
use App\Fee;
use App\Moto;
use App\Payment;
use App\Charge;
use App\Lesroute;
use App\Fuel;
use App\Note;
use Auth;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function registered()
    {
    	$users = User::all();
    	return view('register')->with('users', $users);
    }

    public function registeredit(Request $request, $id)
    {
       $user = User::findOrFail($id);
       return view('registeredit')->with('user', $user);
    }

    public function registerupdate(Request $request, $id)
    {
       $user = User::find($id);
       $user->name = $request->input('username');
       $user->usertype = $request->input('usertype');
       $user->update();

       return redirect('/role-register')->with('status', "Modification enregistrée");

    }


    public function userform()
    {
        

        return view('userregister');

    }



    protected function adduser(Request $request)
    {
        

        $validatedData = $request->validate([
        'name' => 'bail|required| string| max:255',
            'phone' => 'required| string| max:8| min:8',
            'email' => 'required| string| email| max:255, unique:users',
            'password' => 'required| string| min:8| confirmed',
    ]);




      User::create([
            'name' => $request['name'],
            'phone' => $request['phone'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
        ]);

      return redirect('/role-register')->with('status', "Utilisateur Ajouté");
    

    }

  


    public function registerdelete($id)
    {
       $user = User::find($id);
       $user->delete();

       return redirect('/role-register')->with('status', "utilisateur supprimé");

    }


    public function commandregister(Request $request)
    {
       
       $model = new Command;
       $actual_fee = Fee::findOrFail($request->input('fee'));

       $command_adress = $actual_fee->destination . ":".$request->input('adresse');
       
       $model->description = $request->input('descript');
       $model->montant = $request->input('montant');
       $model->delivery_date = $request->input('deliv_date');
       $model->adresse = $command_adress;
       $model->livreur_id = $request->input('livreur');
       $model->client_id = $request->input('client');
       $model->phone = $request->input('phone');
       $model->fee_id = $request->input('fee');
       $model->etat = "encours";

       
       $model->observation = $request->input('observation');

       $model->save();

       $command_id = $model->id;

       
          
       
       return redirect()->back()->with('status', "Commande Ajoutée: $command_id");

    }


    public function commandlist(Request $request)
    {
    	 
        

       $fees = Fee::all();
       $livreurs = Livreur::all();
       $etats = array('encours', 'annule', 'termine', 'en chemin', 'recupere', 'en attente', 'annule retour');
       $clients = Client::orderBy('nom', 'desc')->get();

       $notes = array("Ne décroche pas", "Injoignable", "En déplacement", "Décommandé", "Reporté par le client", "Indisponible", "Promesse de rappeler", "Article réfusé", "Client déja livré");



       $incoming = $commands = Command::where('livreur_id', 11)->get();
       $command_by_status =  Command::selectRaw('COUNT(montant) nombre, (etat) etat')
     ->orderBy('Montant', 'desc')
    ->groupBy('etat')
    ->get();

   $command_by_fee =  Command::selectRaw('COUNT(montant) nombre, (fee_id) fee_id')
    
    ->groupBy('fee_id')
    ->get();

      $day = "Tout";
       $commands = Command::orderBy('delivery_date', 'desc')
                    ->paginate(100); 
       
      

        if(request()->has('status'))
        {
           

           $commands = Command::where('etat', request('status'))->get();


         

        }

        if(request()->has('today'))
        {
           $commands =  Command::where('delivery_date',today())

                  ->paginate(100);
            

            $command_by_fee =  Command::selectRaw('COUNT(montant) nombre, (fee_id) fee_id')
     
     ->where('delivery_date',today())
    ->groupBy('fee_id')
    ->get();

                   $command_by_status =  Command::selectRaw('COUNT(montant) nombre, (etat) etat')
    ->where('delivery_date',today())
    ->groupBy('etat')
    ->get();

    $day = "Aujourd'hui";
        
        }


        if(request()->has('tomorrow'))
        {
           $day = "Demain";

           $commands =  Command::where('delivery_date',date("Y-m-d", strtotime("tomorrow")))

                  ->paginate(100);
       

        $command_by_fee =  Command::selectRaw('COUNT(montant) nombre, (fee_id) fee_id')
     
     ->where('delivery_date',date("Y-m-d", strtotime("tomorrow")))
    ->groupBy('fee_id')
    ->get();


           $command_by_status =  Command::selectRaw('COUNT(montant) nombre, (etat) etat')
    ->where('delivery_date',date("Y-m-d", strtotime("tomorrow")))
    ->groupBy('etat')
    ->get();       
        
        }

        if(request()->has('cmd_day'))
        {

           $commands =  Command::where('delivery_date',$request->input('cmd_day'))
          ->paginate(100);
         

         $command_by_fee =  Command::selectRaw('COUNT(montant) nombre, (fee_id) fee_id')
    
     ->where('delivery_date',$request->input('cmd_day'))
    ->groupBy('fee_id')
    ->get();


            $day = $request->input('cmd_day');     


             $command_by_status =  Command::selectRaw('COUNT(montant) nombre, (etat) etat')
    ->where('delivery_date',$request->input('cmd_day'))
    ->groupBy('etat')
    ->get();   


        }

        
       
    	
    
        return view('dashboard')->with('commands', $commands)->with('etats', $etats)->with('incoming', $incoming)->with('command_by_status', $command_by_status)->with('day', $day)->with('fees', $fees)->with('livreurs', $livreurs)->with('etats', $etats)->with('clients', $clients)->with('notes', $notes)->with("command_by_fee", $command_by_fee);

    }


    public function commandfastregister(Request $request)
    {



      $model = new Command;
       $actual_fee = Fee::findOrFail($request->input('fee'));
       $client = Client::findOrFail($request->input('client'));
       $goods_type = $client->good_type;

       $command_adress = $actual_fee->destination . ":".$request->input('adresse');
       
       $model->description = $goods_type;
       $model->montant = $request->input('montant');
       $model->delivery_date = $request->input('delivery_date');
       $model->adresse = $command_adress;
       $model->livreur_id = $request->input('livreur');
       $model->client_id = $request->input('client');
       $model->phone = $request->input('phone');
       $model->fee_id = $request->input('fee');
       $model->etat = "encours";

       
       $model->observation = $request->input('observation');

       $model->save();

      

       
       return redirect()->back()->with('status', "Commande Ajoutée");
    }

     public function commandform()
    {
    	$clients = Client::orderBy('nom', 'asc')->get();
    	$livreurs = Livreur::all();

    	$fees = Fee::orderBy('destination', 'asc')->get();
    	$etats = array('encours', 'annule', 'termine', 'en chemin', 'recupere', 'en attente');

        return view('commandregister')->with('clients', $clients)->with('livreurs', $livreurs)->with('fees', $fees)->with('etats', $etats);

    }




     
     public function commandedit($id)
    {
       $command = Command::findOrFail($id);
       $clients = Client::all();
    	$livreurs = Livreur::all();
    	$fees = Fee::all();
    	$etats = array('encours', 'annule', 'termine', 'en chemin', 'recupere', 'en attente', 'annule retour');

       return view('commandedit')->with('clients', $clients)->with('livreurs', $livreurs)->with('fees', $fees)->with('command', $command)->with('etats', $etats);
    }


    public function commandupdate(Request $request, $id)
    {
        
        $model = Command::findOrFail($id);
        $actual_fee = Fee::findOrFail($request->input('fee'));

        $actual_livreur = $model->livreur_id;
        $actual_client = $model->client_id;

       $command_adress = $actual_fee->destination . ":".$request->input('adresse');

       $model->description = $request->input('type');
       $model->montant = $request->input('montant');
       $model->delivery_date = $request->input('deliv_date');
       $model->adresse =  $command_adress;
       $model->livreur_id = $request->input('livreur');
       $model->client_id = $request->input('client');
       $model->phone = $request->input('phone');
       $model->fee_id = $request->input('fee');

       if($request->input('etat') == 'annule retour')
       {$model->etat = 'annule';
         $model->loc = 'retour';}

         else{$model->etat = $request->input('etat');}

       
       $model->observation = $request->input('observation');


      //  if(!empty($request->input('coupable')))
      // {
      //   $coupable = New Reason;
      //   if($request->input('coupable')) == "Livreur")
      //    {
      //      $coupable->livreur_id == $actual_livreur;
      //    }
      //    if($request->input('coupable')) == "Fournisseur"))
      //     {
      //        $coupable->client_id == $actual_client;
      //     }

      //     $coupable->command_id = $id;
      // }

       $model->update();

       $cmd_id = $model->id;
       $command_adress = $model->adresse;
       $command_phone = $model->phone;
       $command_note = $model->observation;
       $command_montant = $model->montant;
       $actual_date = $model->delivery_date;
       $update = $request->input('deliv_date');
       $client_wme = $model->client->wme;
      $actual_etat = $model->etat;
      

     
      

       if($request->input('etat') == 'termine' )
       {
         //Update payement

           $check_model = Payment::where('command_id', $id)->get();

          if($check_model->count() == 0)
          {        $model2 = new Payment;
                    
                    $model2->etat = 'en attente';
                    $model2->montant = $model->montant;
                    $model2->client_id = $model->client_id;
                    $model2->command_id = $id;
                   
                    $model2->livreur_id = $model->livreur_id;
                    $model2->save();
          }
          else
          {
             
             $check_payed = Payment::where('command_id', $id)->limit(1)->get();
             foreach ($check_payed as $value) {
              $actual_pay_id = $value->id;
             }
             
              $actual_pay = Payment::findOrFail($actual_pay_id);

             $actual_pay->montant = $command_montant;

             $actual_pay->update();
                    
                    
                  
                    
                    
          }

       
         
        
                           

        
       
       }
 
        

      if($request->input('etat') == 'annule')
       {
          $model3 = Client::findOrFail($request->input('client'));
        $wme = $model3->wme;
         
       }


      

     

       


       //  if($request->input('deliv_date') != $actual_date && isset($client_wme))
       // {
       //     return redirect("https://wa.me/$client_wme?text=Jibia'T Votre commande numero $cmd_id. $command_phone $command_adress Prevu le $actual_date a été reportée le $update"); 
       // }

       
       return redirect()->back()->with('status', "Commande modifiée");
    }



    public function etatupdate($id)
    {
        
        $model = Command::findOrFail($id);
        $current_etat = $model->etat;
        
       

       $model->etat = "termine";
       


       $model->save();
      
      
       
        $check_model = Payment::where('command_id', $id)->get();

          if($check_model->count() == 0)
          {        $model2 = new Payment;
                    
                    $model2->etat = 'en attente';
                    $model2->montant = $model->montant;
                    $model2->command_id = $id;
                    $model2->client_id = $model->client_id;
                    $model2->livreur_id = $model->livreur_id;
                    $model2->save();
          }           
      
        
       
       

      
       return redirect()->back()->with('status', "Satus modifié");
    }








 public function bulkattente(request $request)
 {
  $ids = explode(",", $request->ids);
 
  

  foreach ($ids as $id) {
    $model = Command::findOrFail($id);

    $model->etat = "en attente";

    $model->save();

    
  

  }

  return response()->json(['status'=>"Status mofifiés."]);
}



public function bulkassign(request $request)
 {
  $ids = $request->input('commands');
 
  

  foreach ($ids as $id) {
    $model = Command::findOrFail($id);

    $model->livreur_id = $request->livreur;

    $model->update();

    
  

  }

  return redirect()->back()->with('status',"Commande assignée.");
}


public function bulkreport(request $request)
 {
  $ids = $request->input('commands');
 
  

  foreach ($ids as $id) {
    $model = Command::findOrFail($id);

    $model->delivery_date = $request->report_date;

    $model->update();

    
  

  }

  return redirect()->back()->with('status',"Date Modifiée.");
}



public function bulkstatus(request $request)
 {
  $ids = $request->input('commands');
 
  

  foreach ($ids as $id) {
    $model = Command::findOrFail($id);

    $model->etat = $request->etat;

    $model->update();
    
    if($model->etat == 'termine' && $model->montant >0)
    {
      if(!$model->payment)
      {
        $payment = New Payment;
        $payment->command_id = $model->id;
        $payment->montant = $model->montant;
        $payment->etat = "en attente";
        $payment->client_id = $model->client_id;

        $payment->save();
      }


    }


    if($model->etat == 'annule' && $model->payment)
    {
      
       $model->payment->delete();
      
    }
    
  

  }

  return redirect()->back()->with('status',"Satus modofé.");
}


public function bulkannule(request $request)
{
    $ids = explode(",", $request->ids);
 
  

  foreach ($ids as $id) {
    $model = Command::findOrFail($id);

    $model->etat = "annule";

    $model->save();

    

      $check_model = Payment::where('command_id', $id)->get();

          if($check_model->count() >0)
          {        $model2->delete();
                    
                  
          }         
    
  

  }

  return response()->json(['status'=>"Status mofifiés."]);
}



public function commandelete($id)
    {
       $command = Command::find($id);
       $command->delete();

       return redirect()->back()->with('status', "Commande supprimée")->with('id', $id);

    }




//clientcontrole


    public function clientregister(Request $request)
    {
       
       $model = new Client;
       
       $model->nom = $request->input('nom');
       $model->phone = $request->input('phone');
       $model->adresse = $request->input('adresse');
       $model->goods_type = $request->input('good_type');

       $model->save();


       return redirect('/client')->with('status', "Client Ajoutée");

    }


    public function clientlist()
    {
    	
       $clients = Client::paginate(100);
    	  $available_accounts = User::where('usertype', NULL)->get();
      

        $active_commands = Command::selectRaw('SUM(montant) montant, (client_id) client_id')
    ->where('delivery_date', today())
    ->where('etat', 'termine')
    ->groupBy('client_id')
    ->get(); 
       
         
        
        return view('client')->with('clients', $clients)->with('available_accounts', $available_accounts)->with('active_commands', $active_commands);

    }


    public function clientdetail(Request $request, $id)
    {  
      $commands = Command::where('client_id', $id)
                  ->whereDate('delivery_date', today())
                  ->orderBy('updated_at', 'desc')
                 ->paginate(100);

      $done =  Command::where('client_id', $id)
                        ->whereDate('delivery_date', today())
                        ->where('etat', 'termine')->count(); 

      $done_montant =  Command::where('client_id', $id)
                        ->whereDate('delivery_date', today())
                        ->where('etat', 'termine')->sum('montant');

     $done_livraisons =  Command::where('client_id', $id)
                        ->where('delivery_date', today())
                        ->where('etat', 'termine')->get();                    

                                         


      $cancel =  Command::where('client_id', $id)
                      ->whereDate('delivery_date', today())
                        ->where('etat', 'annule')->count();

      $day = "Aujourd'hui";                  

      if($request->input('route_day'))
      {

        $commands = Command::where('client_id', $id)
                  ->where('delivery_date', $request->input('route_day'))
                  ->orderBy('updated_at', 'desc')
                 ->paginate(100);

      $done =  Command::where('client_id', $id)
                        ->where('delivery_date', $request->input('route_day'))
                        ->where('etat', 'termine')->count();


      $done_livraisons =  Command::where('client_id', $id)
                        ->where('delivery_date', $request->input('route_day'))
                        ->where('etat', 'termine')->get();                  


     $done_montant =  Command::where('client_id', $id)
                        ->whereDate('delivery_date', $request->input('route_day'))
                        ->where('etat', 'termine')->sum('montant'); 


                      
                        


      $cancel =  Command::where('client_id', $id)
                      ->where('delivery_date', $request->input('route_day'))
                        ->where('etat', 'annule')->count();
      
      $day = $request->input('route_day');

      if($request->input('route_day') == today())
        {$day = "Aujourd'hui";}
      }
                                           
    if ($done_livraisons->count()> 0) {
      # code...
    
    foreach ($done_livraisons as $key => $value) {
      $done_fee[] = $value->fee->price;
    }

    $done_livraison = array_sum($done_fee);
}else{$done_livraison = 0; $done_fee = 0;}
      $client = Client::findOrFail($id);
      $livreurs = Livreur::all();  

              
      

      $etats = array('encours', 'annule', 'termine', 'en chemin', 'recupere');


      
      
      $fees = Fee::orderBy('destination', 'asc')->get();

     
     
        
        return view('clientdetails')->with('commands', $commands)->with('etats', $etats)->with('livreurs', $livreurs)->with('done', $done)->with('cancel', $cancel)->with('day', $day)->with('wme',$client->wme)->with('done_montant', $done_montant)->with('done_livraison',$done_livraison)->with('client', $client)->with('fees', $fees);
    }

     public function clientform()
    {
    

        return view('clientregister');

    }

     
     public function clientedit($id)
    {
       $client = Client::findOrFail($id);
       

       return view('clientedit')->with('client', $client);
    }


    public function clientupdate(Request $request, $id)
    {
        
        $model = Client::findOrFail($id);
       $model->nom = $request->input('nom');
       $model->phone = $request->input('phone');
       $model->adresse = $request->input('adresse');
       $model->goods_type = $request->input('good_type');
       


       $model->save();


       return redirect('/client')->with('status', "Client modifiée");
    }


public function clientdelete($id)
    {
       $client = Client::find($id);
       $client->delete();

       return redirect('/client')->with('status', "Client supprimée");

    }






    public function setclientaccout(request $request)
    {
       $model = User::findOrFail($request->input('user_id'));
       
       $model->usertype = 'client';
       $model->client_id = $request->input('client_id');

       $model->save();

       return redirect('/client')->with('status', "Compte associé");
       
    }



    public function unsetclientaccount($id)
    {
       $model = User::findOrFail($id);
       
       $model->usertype = NULL;
       $model->client_id = NULL;

       $model->save();

       return redirect('/client')->with('status', "Compte dissocié");
       
    } 

     public function laroutes(request $request, $id)
    {
      
        $notes = array("Ne décroche pas", "Injoignable", "En déplacement", "Décommandé", "Reporté par le client", "Indisponible", "Promesse de rappeler", "Article réfusé");


       $actions = Lesroute::where('livreur_id', $id)
                         ->whereDate('action_date', today())
                         ->orderBy('updated_at', 'desc')
                          ->paginate(100);

      $payments = Payment::where('livreur_id', $id)
                         ->where('montant', '>', 0)
                         ->where('etat', 'en attente')
                         ->orderBy('updated_at', 'desc')
                          ->paginate(100);

      $payment_sum = Payment::where('livreur_id', $id)
                         ->where('montant', '>', 0)
                         ->where('etat', 'en attente')
                          ->sum('montant');

      $payment_sum = Payment::where('livreur_id', $id)
                         ->where('montant', '>', 0)
                         ->where('etat', 'en attente')
                         ->sum('montant');                                                           

       $commands = Command::where('livreur_id', $id)
                  ->whereDate('delivery_date', today())
                  ->orderBy('updated_at', 'desc')
                 ->paginate(100);

      $done =  Command::where('livreur_id', $id)
                        ->whereDate('delivery_date', today())
                        ->where('etat', 'termine')->count(); 

      $done_montant =  Command::where('livreur_id', $id)
                        ->whereDate('delivery_date', today())
                        ->where('etat', 'termine')->sum('montant');

     $done_livraisons =  Command::where('livreur_id', $id)
                        ->where('delivery_date', today())
                        ->where('etat', 'termine')->get();                    

                                         


      $cancel =  Command::where('livreur_id', $id)
                      ->whereDate('delivery_date', today())
                        ->where('etat', 'annule')->count();

      $day = "Aujourd'hui";                  

      if($request->input('route_day'))
      {

       $actions = Lesroute::where('livreur_id', $id)
                         ->whereDate('action_date',$request->input('route_day'))
                         ->orderBy('updated_at', 'desc')
                          ->paginate(100); 


       

        $commands = Command::where('livreur_id', $id)
                  ->where('delivery_date', $request->input('route_day'))
                  ->orderBy('updated_at', 'desc')
                 ->paginate(100);

      $done =  Command::where('livreur_id', $id)
                        ->where('delivery_date', $request->input('route_day'))
                        ->where('etat', 'termine')->count();


      $done_livraisons =  Command::where('livreur_id', $id)
                        ->where('delivery_date', $request->input('route_day'))
                        ->where('etat', 'termine')->get();                  


     $done_montant =  Command::where('livreur_id', $id)
                        ->whereDate('delivery_date', $request->input('route_day'))
                        ->where('etat', 'termine')->sum('montant'); 


                      
                        


      $cancel =  Command::where('livreur_id', $id)
                      ->where('delivery_date', $request->input('route_day'))
                        ->where('etat', 'annule')->count();
      
      $day = $request->input('route_day');

      if($request->input('route_day') == today())
        {$day = "Aujourd'hui";}
      }
                                           
     
   if ($done_livraisons->count()> 0) {
      # code...
    
    foreach ($done_livraisons as $key => $value) {
      $done_fee[] = $value->fee->price;
    }

    $done_livraison = array_sum($done_fee);
}else{$done_livraison = 0; $done_fee = 0;}

      $livreur = Livreur::findOrFail($id);
      $livreurs = Livreur::whereNotIn('id', [$id])->get();  

      $last_action = Lesroute::where('livreur_id', $id)->orderBy('action_date','desc')->limit(1)->get();        
      

      $etats = array('encours', 'annule', 'termine', 'en chemin', 'recupere');


      $clients = Client::orderBy('nom', 'asc')->get();
      
      $fees = Fee::orderBy('destination', 'asc')->get();
     
        
        return view('laroutes')->with('commands', $commands)->with('etats', $etats)->with('livreurs', $livreurs)->with('livreur', $livreur)->with('done', $done)->with('cancel', $cancel)->with('day', $day)->with('wme',$livreur->wme)->with('done_montant', $done_montant)->with('done_livraison',$done_livraison)->with('last_action', $last_action)->with('clients', $clients)->with('fees', $fees)->with('actions', $actions)->with('payments', $payments)->with('payment_sum', $payment_sum)->with('notes', $notes);
    }






    public function laroutesbydate(request $request, $id)
    {
       

        $commands = Command::where('livreur_id', $id)
                  ->where('delivery_date', $request->input('route_day'))
                  ->orderBy('updated_at', 'desc')
                 ->paginate(100);

      $done =  Command::where('livreur_id', $id)
                        ->where('delivery_date', $request->input('route_day'))
                        ->where('etat', 'termine')->count(); 


      $cancel =  Command::where('livreur_id', $id)
                      ->where('delivery_date', $request->input('route_day'))
                        ->where('etat', 'annule')->count();
      
                                           


      $livreur = Livreur::findOrFail($id);
      $livreurs = Livreur::whereNotIn('id', [$id])->get();           
      

      $etats = array('encours', 'annule', 'termine', 'en chemin', 'recupere');
        
        return view('laroutes')->with('commands', $commands)->with('etats', $etats)->with('livreurs', $livreurs)->with('livreur', $livreur)->with('done', $done)->with('cancel', $cancel)->with('day',$request->input('route_day'));
    }


    public function larouteregister(Request $request)
    {
        $model = new Lesroute;
       $livreur_id = $request->input('livreur_id');
       $model->action = $request->input('action_type');
       $model->action_date = $request->input('action_date');
       $model->observation = $request->input('observation');
       $model->livreur_id = $livreur_id;

       $model->save();


       return redirect('/laroutes/'.$livreur_id)->with('status', "Action Ajoutée");
    }




    //feecontrole


    public function feeregister(Request $request)
    {
       
       $model = new Fee;
       
       $model->destination = $request->input('destination');
       $model->price = $request->input('price');
       

       $model->save();


       return redirect('/fee')->with('status', "Tarif Ajouté");

    }


    public function feelist()
    {
    	
       $fees = Fee::paginate(100);
    	
        
        return view('fee')->with('fees', $fees);

    }

     public function feeform()
    {
    

        return view('feeregister');

    }

     
     public function feeedit($id)
    {
       $fee = Fee::findOrFail($id);
       

       return view('feeedit')->with('fee', $fee);
    }


    public function feeupdate(Request $request, $id)
    {
        
        $model = Fee::findOrFail($id);
        $model->destination = $request->input('destination');
       $model->price = $request->input('price');
       


       $model->save();


       return redirect('/fee')->with('status', "Tarif modifiée");
    }


public function feedelete($id)
    {
       $fee = Fee::find($id);
       $fee->delete();

       return redirect('/fee')->with('status',"Tarif supprimée");

    }



    //livreurs

    


    public function livreurregister(Request $request)
    {
       
       $model = new Livreur;
       
       $model->nom = $request->input('nom');
       $model->phone = $request->input('phone');
       $model->adresse = $request->input('adresse');
       $model->pieces = $request->input('pieces');
       $model->card_number = $request->input('fuel');
       // $model->working_day = $request->input('working_day');

       $model->save();


       return redirect('/livreur')->with('status', "Livreur Ajoutée");

    }


    public function livreurlist()
    {
    	
       $livreurs = Livreur::paginate(100);
       $available_accounts = User::where('usertype', NULL)->get();

       $fees = Fee::all();
       
      //  $proximity = array();
      //  foreach ($fees as $fee) {
      //    $proximity[] = $fee->destination; 
      //  }


    	
      // $proximity_zones = implode(" ", $proximity);


      // $last_actions = Lesroute::groupBy('Livreur_id')
      //                          ->having('created_at', today())
      //                          ->get(); 


    //    Charge::selectRaw('SUM(montant) Montant, (type) Nature')
    // ->whereMonth('charge_date', $month)
    // ->groupBy('Nature')
    // ->get();                        

      $livreur_names = array();
      $livreur_commands = array();
      
      


   //    function last_action($id)
   // {
   //           $latest =     Lesroute::where('id', $id)
   //                ->where('delivery_date', today())
   //                ->oderBy('delivery_date', 'desc')
   //                ->limit(1);
     
   //   foreach($latest as $last)
   //   {
   //     $last_action = $last->action;
   //   }
   //   return $last_action;
   // }                        
        
        return view('livreur')->with('livreurs', $livreurs)->with('available_accounts', $available_accounts);

    }

     public function livreurform()
    {
    

        return view('livreurregister');

    }

     
     public function livreuredit($id)
    {
       $livreur = Livreur::findOrFail($id);
       

       return view('livreuredit')->with('livreur', $livreur);
    }


    public function livreurupdate(Request $request, $id)
    {
        
        $model = Livreur::findOrFail($id);
       
       $model->nom = $request->input('nom');
       $model->phone = $request->input('phone');
       $model->adresse = $request->input('adresse');
       $model->pieces = $request->input('pieces');
       $model->card_number = $request->input('fuel');
       // $model->working_day = $request->input('working_day');
       


       $model->save();


       return redirect('/livreur')->with('status', "Livreur modifiée");
    }


public function livreurdelete($id)
    {
       $livreur = Livreur::find($id);
       $livreur->delete();

       return redirect('/livreur')->with('status', "Livreur supprimée");

    }


    public function setlivreuraccout(request $request)
    {
       $model = User::findOrFail($request->input('user_id'));
       
       $model->usertype = 'livreur';
       $model->livreur_id = $request->input('livreur_id');

       $model->save();

       return redirect('/livreur')->with('status', "Compte associé");
       
    }



    public function unsetlivreuraccount($id)
    {
       $model = User::findOrFail($id);
       
       $model->usertype = NULL;
       $model->livreur_id = NULL;

       $model->save();

       return redirect('/livreur')->with('status', "Compte dissocié");
       
    }



     public function livreurstat(Request $request, $id)
    {  
      
       $livreur = Livreur::findOrFail($id);

       $months  = array('01' =>'Janvier' , '02' =>'Fevrier' , '03' =>'Mars' ,'04' =>'Avril' ,'05' =>'Mai' ,'06' =>'Juin' ,'07' =>'Juillet' ,'08' =>'Aout' ,'09' =>'Septembre' ,'10' =>'Octobre' ,'11' =>'Novemvre' ,'12' =>'Decembre' );

       $latest_year = Command::orderBy('delivery_date')->first();
       $objectif = 180;

       for ($i=2019; $i <= $latest_year->delivery_date->format('Y') ; $i++) { 
         $years[] = $i;
       }

       $cur_month = date('m');
       $cur_year = date('Y');
       $commands = Command::where('livreur_id', $id)->where('etat', 'termine')->whereMonth('delivery_date', $cur_month)->whereYear('delivery_date', $cur_year)->get();
       
      if(request()->has('year') )
      {
        
        $cur_year = date_create($request->input('year'))->format('Y');

        if($request->input('month') != 'all')
       { 
        $cur_month = $request->input('month');

        $commands = Command::where('livreur_id', $id)->where('etat', 'termine')->whereMonth('delivery_date', $cur_month)->whereYear('delivery_date', $cur_year)->get();


       }
       else
       {
        $cur_month = "Toute l'année";
         $commands = Command::where('livreur_id', $id)->where('etat', 'termine')->whereYear('delivery_date', $cur_year)->get();

         $objectif = 2160;
       }

         
      }

       return view('livreurstat')->with("commands", $commands)->with('months', $months)->with('years', $years)->with('objectif', $objectif)->with('livreur', $livreur)->with('cur_month', $cur_month)->with('cur_year', $cur_year);
       
    }





    //moto


     public function motoregister(Request $request)
    {
       
       $model = new Moto;
       
       $model->imm = $request->input('imm');
       $model->buy_date = $request->input('buy_date');
       $model->ass_exp = $request->input('ass_exp');
       

       $model->save();


       return redirect('/moto')->with('status', "Moto Ajoutée");

    }


    public function motolist()
    {
    	
       $motos = Moto::paginate(100);
    	
        
        return view('moto')->with('motos', $motos);

    }

     public function motoform()
    {
    

        return view('motoregister');

    }

     
     public function motoedit($id)
    {
       $moto = Moto::findOrFail($id);
       

       return view('motoedit')->with('moto', $moto);
    }


    public function motoupdate(Request $request, $id)
    {
        
        $model = Moto::findOrFail($id);
       $model->imm = $request->input('imm');
       $model->buy_date = $request->input('buy_date');
       $model->ass_exp = $request->input('ass_exp');
       


       $model->save();


       return redirect('/moto')->with('status', "Moto modifiée");
    }


public function motodelete($id)
    {
       $moto = Moto::find($id);
       $moto->delete();

       return redirect('/moto')->with('status', "Moto supprimée");

    }


public function motovidandeupdate(Request $request, $id)
    {
       $model = Moto::findOrFail($id);
       $model->last_vid = $request->input('last_vid');
       $model->last_km = $request->input('last_km');
       
       


       $model->save();

       return redirect('/moto')->with('status', "Vidange initialisée");

    }



   //payment

     public function paymentregister(Request $request)
    {
       
       $model = new Payment;
       
       
       $model->montant = $request->input('montant');
       $model->payed_by = $request->input('payed_by');
       $model->client_id = $request->input('client');
       $model->payment_date = $request->input('payment_date');
       $model->payment_method = $request->input('payment_method');
       
     

       $model->save();


       return redirect('/payment')->with('status', "Payment effectué");

    }


    public function paymentlist()
    {
    	
        

       $livreurs = Livreur::all(); 
    	$payments = Payment::orderBy('updated_at', 'desc')
               ->paginate(50);
      $payment_encours = Payment::selectRaw('SUM(montant) montant, (client_id) client_id')
    ->where('etat', 'en attente')
    ->groupBy('client_id')
    ->get(); 

    $clients  = Client::all();
    	
    	$payment_methods = array('Mobile money', 'Main à main', 'Chèque', 'Virement');
        
        return view('payment')->with('payments', $payments)->with('payment_methods', $payment_methods)->with('livreurs', $livreurs)->with('payment_encours', $payment_encours)->with('clients', $clients);

    }

     public function paymentform()
    {
    	
    	$payment_methods = array('Mobile money', 'Main à main', 'Chèque', 'Virement');
    	$clients = Client::all();


        return view('paymentregister')->with('payment_methods', $payment_methods)->with('clients', $clients);

    }

     
     public function paymentedit($id)
    {
       $payment = Payment::findOrFail($id);
       $clients = Client::all();
    	
    	$payment_methods = array('Mobile money', 'Main à main', 'Chèque', 'Virement');

       return view('paymentedit')->with('clients', $clients)->with('payment', $payment);
    }


    public function paymentupdate(Request $request, $id)
    {
        
        $model = Payment::findOrFail($id);
        $user_id = Auth::user()->id;
        

       $model->montant = $request->input('montant');
       $model->user_id = $user_id;
       
       $model->client_id = $request->input('client');
       $model->payment_method = $request->input('payment_method');

       $model->update();


       return redirect('/payment')->with('status', "Payment modifiée");
    }

    public function payall(Request $request)
    {
      $model = Payment::where('client_id', $request->input('client'))
                        ->where('etat', 'en attente')->get();


     foreach($model as $raw)
     {
      $raw->etat = 'termine';

      $raw->update();
     }

      return redirect()->back()->with('status', "Payement effectué");
    }



    public function assignall(Request $request)
    {
      $model = Payment::where('client_id', $request->input('client'))
                        ->where('etat', 'en attente')->get();


     foreach($model as $raw)
     {
      $raw->livreur_id =  $request->input('livreur_id');

      $raw->update();
     }

      return redirect()->back()->with('status', "Payement assigné");
    }


public function paymentdelete($id)
    {
       $payment = Payment::find($id);
       $payment->delete();

       return redirect('/payment')->with('status', "Payment supprimé");

    }



public function paymentdone($id)
    {
       $payment = Payment::find($id);
       $payment->etat = "termine";
       $payment->user_id = Auth::user()->id;
       $payment->update();

       return redirect('/payment')->with('status', "Payment effectué");

    }    




public function paymentassign(Request $request, $id)
    {
       $payment = Payment::find($id);
       $payment->livreur_id = $request->livreur_id;
       $payment->update();

       return redirect('/payment')->with('status', "Payment assigné");

    }        






//charge
 public function chargeregister(Request $request)
    {
       
       $model = new Charge;
       
       
       $model->type = $request->input('type');
       $model->montant = $request->input('montant');
       
       $model->detail = $request->input('detail');
       $model->charge_date = $request->input('charge_date');
       $model->moto_id = $request->input('moto_id');
       
     

       $model->save();


       return redirect('/charge')->with('status', "Charge ajoutée");

    }


    public function chargelist()
    {
    	
        

        
    	$charges = Charge::all();
    	
    	$charge_types = array('Vidange', 'Reparation', 'carburant', 'Autre');
        
        return view('charge')->with('charges', $charges)->with('charge_types', $charge_types);

    }

     public function chargeform()
    {
    	
    	$charge_types = array('Vidange', 'Reparation', 'carburant', 'Autre');
    	$motos = Moto::all();


        return view('chargeregister')->with('charge_types',$charge_types )->with('motos', $motos);

    }

     
     public function chargeedit($id)
    {
       $charge = Charge::findOrFail($id);
       $motos = Moto::all();
    	
    	$charge_types = array('Vidange', 'Reparation', 'carburant', 'Autre');

       return view('chargeedit')->with('motos', $motos)->with('charge', $charge)->with('charge_types', $charge_types);
    }


    public function chargeupdate(Request $request, $id)
    {
        
        $model = Charge::findOrFail($id);
        

       $model->type = $request->input('type');
       $model->montant = $request->input('montant');
       $model->detail = $request->input('detail');
       $model->charge_date = $request->input('charge_date');
       $model->moto_id = $request->input('moto_id');

       $model->save();


       return redirect('/charge')->with('status', "Charge modifiée");
    }


public function chargedelete($id)
    {
       $charge = Payment::find($id);
       $charge->delete();

       return redirect('/charge')->with('status', "charge supprimée");

    }







     public function etatupdatel(Request $request, $id)
    {
        
        $model = Command::findOrFail($id);
        $livreur_id = Auth::user()->livreur_id;
        $command_adress = $model->adresse;
        $command_client_adresse = $model->client->adresse;
        $command_client_id = $model->client_id;
        $command_client_phone = $model->client->phone;

        if($request->input('etat') == "recupere")
        {
          $model2 = new Lesroute;
          $model2->livreur_id=$livreur_id;
          $model2->action_date = now();
          $model2->action = "Recup: #" . $command_client_id. " ".$command_client_adresse;
          $model2->save();
        }


        if($request->input('etat') == "en chemin")
        {
          $model3 = new Lesroute;
          $model3->livreur_id=$livreur_id;
          $model3->action_date = now();
          $model3->action = "En chemin: #" . $id. " ".$command_adress;
          $model3->save();
        }


        if($request->input('etat') == "termine")
        {
          $model4 = new Lesroute;
          $model4->livreur_id=$livreur_id;
          $model4->action_date = now();

          $model4->action = "Livré: #" . $id. " ".$command_adress;
          $model4->save();



          $check_model = Payment::where('command_id', $id)->get();

          if($check_model->count() == 0)
          {        $model2 = new Payment;
                    
                    $model2->etat = 'en attente';
                    $model2->montant = $model->montant;
                    $model2->livreur_id = $livreur_id;
                    $model2->client_id=$model->client_id;
                    $model2->command_id = $id;
                    $model2->save();
          }   
        }


        

       

       $model->etat = $request->input('etat');
       

       $model->update();


       return redirect()->back()->with('status', "Satus modifié");
    }




     public function bulketatupdate(request $request)
 {
  $ids = explode(",", $request->ids);
  $livreur_id = Auth::user()->livreur_id;
  

  foreach ($ids as $id) {
    $model = Command::findOrFail($id);

    $model->etat = 'recupere';

    $model->update();


    
  $command_client_adresse[] = $model->client->adresse;
  $command_client_id[] = $model->client_id;
  

  }


      foreach ($command_client_adresse as $key => $value) {
        $model2 = new Lesroute;
          $model2->livreur_id=$livreur_id;
          $model2->action_date = now();
          $model2->action = "Recup: #" . $command_client_id[$key]. " ".$value;
          $model2->save();
          
        }  

          

          return response()->json(['status'=>"Status mofifié."]);
 }






public function relay(Request $request, $id)
    {
        
        $model = Command::findOrFail($id);
        $livreur_id = Auth::user()->livreur_id;
        $relais = Livreur::findOrFail($request->relais);
        $command_adress = $model->adresse;
        $command_client_adresse = $model->client->adresse;
        $command_client_id = $model->client_id;
        $command_client_phone = $model->client->phone;

        
          $model2 = new Lesroute;
          $model2->livreur_id=$livreur_id;
          $model2->action_date = now();
          $model2->action = "(".$id. ")". "Relais avec : " .$relais->nom. "à:". $request->lieu .". Recuperé chez: #". $command_client_id. " ".$command_client_adresse. "Pour livrer à: #". $command_adress;
          $model2->save();
        


        


        

       

       $model->livreur_id = $request->relais;
       

       $model->update();


       return redirect()->back()->with('status', "Satus modifié");
    }




public function rapport(Request $request)
    {
      $months  = array('01' =>'Janvier' , '02' =>'Fevrier' , '03' =>'Mars' ,'04' =>'Avril' ,'05' =>'Mai' ,'06' =>'Juin' ,'07' =>'Juillet' ,'08' =>'Aout' ,'09' =>'Septembre' ,'10' =>'Octobre' ,'11' =>'Novembre' ,'12' =>'Decembre' );

      $livraisons = array();
      $month = date('m');
      $year = date('Y');
      $clients = Client::all();


      if($request->has('month'))
      {
        

        if($request->input('month') == "last")
        {
          $month = date('m')-1;

        }

        
      }  

      $commands = Command::where('etat', 'termine')->whereMonth('delivery_date', $month)->get();
          $charges = Charge::whereMonth('charge_date', $month)->sum('montant');


          $days = cal_days_in_month(CAL_GREGORIAN,$month,date('Y'));


     $all_fees = Fee::all();
     $all_livreurs = Livreur::all();     

     $charges_by_type = Charge::selectRaw('SUM(montant) Montant, (type) Nature')
    ->whereMonth('charge_date', $month)
    ->orderBy('Montant', 'desc')
    ->groupBy('Nature')
    ->get();     

    $command_by_clients = Command::selectRaw('COUNT(montant) Montant, (client_id) Client_id')
    ->whereMonth('delivery_date', $month)
    ->where('etat', 'termine')
     ->orderBy('Montant', 'desc')
    ->groupBy('client_id')
    ->get();


    $command_by_fees = Command::selectRaw('COUNT(fee_id) destination, (fee_id) fee_id')
    ->whereMonth('delivery_date', $month)
    ->where('etat', 'termine')
     ->orderBy('destination', 'desc')
    ->groupBy('fee_id')
    ->get();
   


   $command_by_livreurs = Command::selectRaw('COUNT(montant) livreur,  (livreur_id) livreur_id')
    ->whereMonth('delivery_date', $month)
    ->where('etat', 'termine')
     ->orderBy('livreur', 'desc')
    ->groupBy('livreur_id')
    ->get();


      if($request->has('year'))
      {
        if($request->input('year') == "last")
        {
          $year = date('Y')-1;
          

          
        }


        if($request->input('year') == "current")
        {
          $year = date('Y');


          
        }


        $command_by_clients = Command::selectRaw('COUNT(montant) Montant,  (client_id) Client_id')
    ->whereYear('delivery_date', $year)
    ->where('etat', 'termine')
     ->orderBy('Montant', 'desc')
    ->groupBy('client_id')
    ->get();


        $commands = Command::where('etat', 'termine')->whereYear('delivery_date', $year)->get();
          $charges = Charge::whereYear('charge_date', $year)->sum('montant'); 
         

          $days = cal_days_in_month(CAL_GREGORIAN,date('m'),$year);

          $charges_by_type = Charge::selectRaw('SUM(montant) Montant, (type) Nature')
    ->whereYear('charge_date', $year)
    ->groupBy('Nature')
    ->get(); 


    $command_by_fees = Command::selectRaw('COUNT(fee_id) destination, (fee_id) fee_id')
    ->whereYear('delivery_date', $year)
    ->where('etat', 'termine')
     ->orderBy('destination', 'desc')
    ->groupBy('fee_id')
    ->get();


    $command_by_livreurs = Command::selectRaw('COUNT(montant) livreur,  (livreur_id) livreur_id')
    ->whereYear('delivery_date', $year)
    ->where('etat', 'termine')
     ->orderBy('livreur', 'desc')
    ->groupBy('livreur_id')
    ->get();

    $month = "";


      }



         
     if($commands->count()>0)
      {foreach($commands as $command)
              { 
                if($command->fee != NULL)
               { $fees[] = $command->fee->price;}
              }
           
            
            $livraisons = array_sum($fees);
          }else{$fees = 0; $livraisons = 0;}


          if(!$charges ){$chatges = 0;}



        
      
        
        return view('rapport')->with('charges', $charges)->with('livraisons', $livraisons)->with('days', $days)->with('fees', $fees)->with('charges_by_type', $charges_by_type)->with('year', $year)->with('month', $month)->with('months', $months)->with('command_by_clients', $command_by_clients)->with('clients', $clients)->with('all_fees', $all_fees)->with('command_by_fees', $command_by_fees)->with('command_by_livreurs', $command_by_livreurs)->with('all_livreurs', $all_livreurs);

    }



    public function fuelist()
    {
      $model = Fuel::selectRaw(' SUM(montant) montant, (card_number) card_number')
                     ->groupBy('card_number')
                     ->get();

     $total_entree =  Fuel::selectRaw(' SUM(montant) montant, (card_number) card_number')
                     ->where('type', 'entree')
                     ->groupBy('card_number')
                     ->get();

     $total_sortie =  Fuel::selectRaw(' SUM(montant) montant, (card_number) card_number')
                     ->where('type', 'sortie')
                     ->groupBy('card_number')
                     ->get();                               

      $livreurs = Livreur::all(); 

      $cards = array('222862', '222875', '222871', '222860', '243294');              

       return view('fuel')->with('fuels', $model)->with('livreurs', $livreurs)->with('cards', $cards)->with('total_sortie', $total_sortie)->with('total_entree', $total_entree);              
    }


    public function fuelregister(Request $request)
    {
        
        $model = new Fuel;
       
       if($request->input('type') == 'sortie')
        {$montant = $request->input('montant')*(-1);}
      else{$montant = $request->input('montant');}

      $model->montant = $montant;
       $model->type = $request->input('type');
       $model->card_number = $request->input('card_number');
       $model->fuel_date = $request->input('fuel_date');
       


       $model->save();




       return redirect()->back()->with('status', "Donnée ajoutée");
    }

    public function fuelupdate(Request $request)
    {
        
        $model = Fuel::findOrFail($id);
        if($request->input('type') == 'sortie')
        {$montant = $request->input('montant')*(-1);}
      else{$montant = $request->input('montant');}

      $model->montant = $montant;
       $model->type = $request->input('type');
       $model->card_number = $request->input('card_number');
       $model->fuel_date = $request->input('fuel_date');
       


       $model->update();


       return redirect()->back()->with('status', "Mise à jour effectuée");
    }


  public function delivnote(Request $request)
{
  $model = new Note;
   $note = $request->input('note');
   if($request->input('note') == "Reporté par le client")
    {
      $note = $request->input('note'). " au ". $request->input('report_date');}
  $model->description = $note;
  $model->command_id = $request->input('command_id');
 
  $model->save();

 
 $command_phone = $request->input('command_phone');
 $client_phone = $request->input('client_phone');
 $command_id = $request->input('command_id');


 


  return redirect()->back()->with('status',"Note ajoutée.");
}


}
