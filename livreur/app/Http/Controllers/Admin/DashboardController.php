<?php

namespace App\Http\Controllers\Admin;
use App\User;
use App\Command;
use App\Client;
use App\Livreur;
use App\Fee;
use App\Lesroute;
use App\Payment;
use App\Note;
use App\Code;
use App\Setting;
use App\Sms_mooving;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\MessageBag;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\Helpers\Sms;
class DashboardController extends Controller
{
  
  public function editaccount(Request $request) 
  {


        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string'],
            'adresse' => ['required', 'string', 'max:255'],
           
        ]);

        $id = Auth::user()->livreur_id;

        $livreur = Livreur::findOrFail($id);

        $livreur->nom = $request->name;
        $livreur->city = $request->city;
        $livreur->adresse = $request->adresse;
         
        $livreur->update();  

        return redirect()->back()
            ->with('status','Profile modifié.');

  } 


  public function editpassword(Request $request) 
  {
       $id = Auth::user()->livreur_id;

        $livreur = Livreur::findOrFail($id);

        



        $request->validate([

            'password' => ['required', 'string', 'min:8', 'same:confirm_password'],
            
           
        ]);

        if( !Hash::check($request->current_password, Auth::user()->password))
        {
            
          $errors = new MessageBag();
           $errors->add('current_password', "Le mot de passe actuel n'est pas correct ");
          
           return back()->withErrors($errors);
        }

        Auth::user()->password = Hash::make($request->password);
        
         
        Auth::user()->update();  

        return redirect()->back()
            ->with('status','Mot de passe modifié.');

  } 


  public function compte(){
    $id = Auth::user()->livreur_id;

    $communes = array("Adjamé", "Cocody", "Attécoubé", "Bingerville", "Anyama", "Koumassi", "Plateau", "Treichville", "Marcory", "Port-Bouet", "Bassam", "Songon", "Abobo", "Yopougon" );

        sort($communes);

    $livreur = Livreur::findOrFail($id);
    return view('compte')->with('livreur', $livreur)->with("communes", $communes);
  } 

  public function photoupload(Request $req){
        $req->validate([
        'file' => 'required|mimes:jpeg,png|max:2048'
        ]);
        
        $id = Auth::user()->livreur_id;
        
        $fileModel = Livreur::findOrFail($id);

        if($req->file()) { 
            
            $path = Storage::disk('s3')->put('image',$req->file, 'public');
            
            
            
            
            $fileModel->photo = $path;
            $fileModel->update();

            return redirect()->back()
            ->with('status','Photo enregistrée.');
        }
   }







   public function getloc(Request $request)
  {   
     $livreur_id = Auth::user()->livreur_id;
      $livreur = Livreur::findOrFail($livreur_id);
       $lat  = null;
       $long = null;
       $geo_time = null;
       $duration = "";

       if($livreur->latitude != null && $livreur->longitude != null && $livreur->geotime != null)
       {
        $lat  = $livreur->latitude;
       $long   =   $livreur->longitude;
       $geo_time = $livreur->geotime;
        $date1=date_create($geo_time);
        $date2=date_create(date("Y-m-d H:i:s"));
        $diff=date_diff($date1,$date2);
       $days = $diff->format("%d");
       $hours = $diff->format("%H");
       $mn =  $diff->format("%i");
       $periode = array('Jours'=>$days, 'h'=>$hours, 'mns'=>$mn);
      
       
       foreach ($periode as $key => $value) {
         if($value != 0)
         {
          $duration .= $value.$key;
         }
       }
       }

       return response()->json(['lat'=>$lat, 'long'=>$long, 'geo_time'=>$geo_time, 'duration'=>$duration]);
  }
    


    public function commandlist(request $request)
    {
      $day = "Aujourd'hui";

      $etats_chauds = array('encours', 'en chemin', 'recupere');
      $notes = array("Ne décroche pas", "Injoignable", "En déplacement", "Décommandé", "Reporté par le client", "Indisponible", "Promesse de rappeler", "Article réfusé", "Client déja livré");


       
       sort($notes);

      
      
    	$livreur_id = Auth::user()->livreur_id;

      

      $commands = Command::orderBy('etat', "asc")
                   ->orderBy('fee_id', "desc")
                  
                  ->orderBy('adresse', "desc")
                  ->where('livreur_id', $livreur_id)
                  ->whereDate('delivery_date', today())
                
                 ->get();
     $client_phones = array();
      
      foreach($commands as $command)
      { 
        if($command->etat == "encours")
        {$client_phones[] = $command->client->phone;}
      } 

      $client_phones = array_unique($client_phones);       

      $commands_by_fee = Command::
                      where('livreur_id', $livreur_id)
                  ->whereDate('delivery_date', today())
                  ->whereIn('etat', $etats_chauds)
                       ->get();



      $destinations = array();
      foreach ($commands_by_fee as $value) {
                 
                    $destinations[] = $value->fee->destination;
                   
                  
                 }           
       $final_destinations = array_count_values($destinations);
      $livreurs = Livreur::whereNotIn('id', [$livreur_id])->get(); 



      $done = Command::where('livreur_id', $livreur_id)
                  ->whereDate('delivery_date', today())
                  ->where('etat', 'termine')
                 ->get();


      $done_fees = array();

    foreach($done as $one)
    {
      $done_fees[] = $one->fee->price;
    }
                 
      
       $payments = Payment::selectRaw('SUM(montant) montant, (client_id) client_id')
     ->where('livreur_id', $livreur_id)
    ->where('etat', 'en attente')
    ->groupBy('client_id')
    ->get();
   
   $real_payments =  Payment::selectRaw('SUM(montant) montant, (client_id) client_id')
   ->where('montant', '>', 0)
     ->where('livreur_id', $livreur_id)
    ->where('etat', 'en attente')
    ->groupBy('client_id')
    ->get();

    $retours = Command::selectRaw('COUNT(montant) nombre, (client_id) client_id')
       ->where('loc', 'retour')
     ->where('livreur_id', $livreur_id)
    ->groupBy('client_id')
    ->get();

    $clients = Client::all();  

    $command_by_status =  Command::selectRaw('COUNT(montant) nombre, (etat) etat')
    ->whereDate('delivery_date', today())
    ->where('livreur_id', $livreur_id)
     ->orderBy('Montant', 'desc')
    ->groupBy('etat')
    ->get();  



    $commands_by_clients = Command::selectRaw('SUM(montant) montant, (client_id) client_id')
     ->where('livreur_id', $livreur_id)
     ->where('etat', 'termine')
     ->whereDate('delivery_date', today())
    ->groupBy('client_id')
    ->get();      
    	
    if($request->input('route_day'))
    {
       $day = date_format(date_create($request->input('route_day')), 'd-m-Y');

      $ranks = Command::selectRaw("COUNT(montant) number_done,  (livreur_id) livreur_id")
              ->whereDate('delivery_date',  date_format(date_create($request->input('route_day')), 'Y-m-d'))
              ->where('etat', 'termine')
              ->orderBy('number_done', 'desc')
              ->groupBy('livreur_id')
              ->get();
      


      

      $commands = Command::orderBy('etat', "asc")
                   ->orderBy('fee_id', "desc")
                  
                  ->orderBy('adresse', "desc")
                  ->where('livreur_id', $livreur_id)
                  ->whereDate('delivery_date',  date_format(date_create($request->input('route_day')), 'Y-m-d'))
                
                 ->get();
     



     $commands_by_fee = Command::
                      where('livreur_id', $livreur_id)
                  ->whereDate('delivery_date',  date_format(date_create($request->input('route_day')), 'Y-m-d'))
                  ->whereIn('etat', $etats_chauds)
                       ->get();


      $done = Command::where('livreur_id', $livreur_id)
                  ->whereDate('delivery_date',  date_format(date_create($request->input('route_day')), 'Y-m-d'))
                  ->where('etat', 'termine')
                 ->get();

      $command_by_status =  Command::selectRaw('COUNT(montant) nombre, (etat) etat')
    ->whereDate('delivery_date',  date_format(date_create($request->input('route_day')), 'Y-m-d'))
    ->where('livreur_id', $livreur_id)
     ->orderBy('Montant', 'desc')
    ->groupBy('etat')
    ->get();


      $commands_by_clients = Command::selectRaw('SUM(montant) montant, (client_id) client_id')
     ->where('livreur_id', $livreur_id)
     ->where('etat', 'termine')
     ->whereDate('delivery_date',  date_format(date_create($request->input('route_day')), 'Y-m-d'))
    ->groupBy('client_id')
    ->get();

    }
    	$etats = array('encours', 'annule', 'termine', 'en chemin', 'recupere');
      
      $total_fees = array();
      foreach($commands as $command1){
       if($command1->etat == "termine"){
        if($command1->livraison == NULL)
        {$total_fees[] = $command1->fee->price;}
       else{$total_fees[] = $command1->livraison;}
      }
      }
     

     $livreur = Livreur::findOrFail($livreur_id);
      
        
        return view('dashboard')->with('commands', $commands)->with('etats', $etats)->with('livreur_id', $livreur_id)->with('livreurs', $livreurs)->with('final_destinations', $final_destinations)->with('commands_by_fee', $commands_by_fee)->with('payments', $payments)->with('clients', $clients)->with('done', $done)->with('done_fees', $done_fees)->with('retours', $retours)->with('real_payments', $real_payments)->with('client_phones', $client_phones)->with('command_by_status', $command_by_status)->with('notes', $notes)->with('commands_by_clients', $commands_by_clients)->with('day', $day)->with('total_fees',$total_fees)->with('livreur', $livreur);
    }
    

    



    public function paymentlist()
    {

      $etats_chauds = array('encours', 'en chemin', 'recupere');
      $livreur_id = Auth::user()->livreur_id;


      

                 
      
       $payments = Payment::selectRaw('SUM(montant) montant, (client_id) client_id')
     ->where('livreur_id', $livreur_id)
    ->where('etat', 'en attente')
    ->groupBy('client_id')
    ->get();

    $clients = Client::all();
      
        
        return view('payment')->with('payments', $payments)->with('livreur_id', $livreur_id)->with('clients', $clients);

    }

    


    public function etatupdate(Request $request, $id)
    {
        
        $model = Command::findOrFail($id);
        $livreur_id = Auth::user()->livreur_id;

        if($model->livreur_id != $livreur_id)
        {
          redirect()->back()->with("status", "Vous ne pouvez pas effectuer cette action car la commande ne vous est plus assignée.");
        }

        
        $command_adress = $model->adresse;
        $command_client_adresse = $model->client->adresse;
        $command_client_id = $model->client_id;
        $command_client_phone = $model->client->phone;

        if($request->input('etat') == "recupere")
        {
          if(strtolower($model->loc) == 'jb')
        {$model->loc = NULL;}

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
                    $model2->client_id=$model->client_id;
                    $model2->command_id = $id;
                    $model2->livreur_id = $livreur_id;

                    $model2->save();
          }


 }


     $model->etat = $request->input('etat');


       
      
       $model->update();


       
         $cmd_id = $model->id;
         $cmd_mt = $model->montant; 
         $cmd_phone = $model->phone;
         $cmd_ad = $model->adresse; 
         $client_phone = substr(preg_replace('/[^0-9]/', '',$model->client->phone), 0, 8); 
        // return redirect("https://wa.me/$wme?text=Jibia'T Livraison: Votre Commande numero $cmd_id. Total $cmd_mt  CFA. contact $cmd_phone $cmd_ad a été livrée. connectez vous a votre espace client.livreurjibiat.site pour suivre vos colis en temps reel");

       if($request->input('etat') == "termine")
       {
        
        if(strstr($_SERVER['HTTP_USER_AGENT'],'iPhone') || strstr($_SERVER['HTTP_USER_AGENT'],'iPad')) { return redirect('/dashboard')->with('status', "Satus modifié")->with('success', "sms:$client_phone&body=Jibia'T Livraison: Votre Commande numero $cmd_id. Total $cmd_mt  CFA. contact $cmd_phone $cmd_ad a été livrée. connectez vous a votre espace https://client.livreurjibiat.site pour suivre vos colis en temps reel");}
        else
        {return redirect('/dashboard')->with('status', "Satus modifié")->with('success', "sms:$client_phone?body=Jibia'T Livraison: Votre Commande numero $cmd_id. Total $cmd_mt  CFA. contact $cmd_phone $cmd_ad a été livrée. connectez vous a votre espace https://client.livreurjibiat.site pour suivre vos colis en temps reel");}
      }
     else{return redirect('/dashboard')->with('status', "Satus modifié");}
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






public function bulkpayupdate(request $request)
 {
  $ids = explode(",", $request->ids);
  $livreur_id = Auth::user()->livreur_id;
  

  foreach ($ids as $id) {
    $model = Payment::findOrFail($id);

    $model->etat = 'termine';
    $model->user_id = $livreur_id;

    $model->update();


    
  $payment_client_adresse[] = $model->client->adresse;
  $payment_client_id[] = $model->client_id;
  $payment_montants[] = $model->montant;
  $payment_commands[] = $model->command_id;

  

  }


      foreach ($payment_client_adresse as $key => $value) {
        $model2 = new Lesroute;
          $model2->livreur_id=$livreur_id;
          $model2->action_date = now();
          $model2->action = "Payment a #" . $payment_client_id[$key]. " ".$value . "<br> Commande # ". $payment_commands[$key]."<br> montant =". $payment_montants[$key];
          $model2->save();
          
        }  

          

          return response()->json(['status'=>"Status mofifié."]);
 }










     public function livreurstat(Request $request)
    {  
      
       $id = Auth::user()->livreur_id;

       $months  = array('01' =>'Janvier' , '02' =>'Fevrier' , '03' =>'Mars' ,'04' =>'Avril' ,'05' =>'Mai' ,'06' =>'Juin' ,'07' =>'Juillet' ,'08' =>'Aout' ,'09' =>'Septembre' ,'10' =>'Octobre' ,'11' =>'Novemvre' ,'12' =>'Decembre' );

       $latest_year = Command::orderBy('delivery_date', 'desc')->first();
       $objectif = 420;

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


      $montant = 0;
      foreach($commands as $command)
      {
         $montant += $command->fee->price;
      }

       return view('livreurstat')->with("commands", $commands)->with('months', $months)->with('years', $years)->with('objectif', $objectif)->with('cur_month', $cur_month)->with('cur_year', $cur_year)->with('montant', $montant);
       
    }


 public function retour(Request $request)
    {
       $model = Command::where('client_id', $request->input('client_id'))->get();

       foreach($model as $one)
       {
        $one->loc = NULL;
        $one->update();
       }

       return redirect()->back()->with('status', "Retour effectué");
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


public function delivnote(Request $request)
{

  $command_id = $request->input('command_id');
$command = Command::findOrFail($command_id);
  $model = new Note;
   $note = $request->input('note');
   if($request->input('note') == "Reporté par le client")
    {
      $note = $request->input('note'). " au ". date_create($request->input('report_date'))->format('d-m-Y');
    }


    if($request->input('note') == "Autre")
    {
      $note = $request->autre_detail;
    }

    if($request->input('note') == "Adresse modifiée")
    {
      $fee = Fee::findOrFail($request->new_fee);

      $note = "Adresse modifiée de ". $command->adresse. " a ". $fee->destination. ": ".$request->new_adress;

      $command->fee_id = $request->new_fee;
      $command->adresse = $fee->destination. ": ".$request->new_adress;

      $command->update();
    }


    if($request->input('note') == "RDV")
    {
      $model->rdv_time = $request->input('rdv_date');
    }


  $model->description = $note;
  $model->command_id = $request->input('command_id');
 
  $model->save();

 
 $command_phone = $request->input('command_phone');
 $client_phone = $request->input('client_phone');
 

 if(strstr($_SERVER['HTTP_USER_AGENT'],'iPhone') || strstr($_SERVER['HTTP_USER_AGENT'],'iPad')) {$note_message = "sms:$client_phone,".$command->phone."&body=Note de livraison: Command numero $command_id contact :".$command->phone." : " .$note . ". Créez un compte Jibiat et gérer vos ventes en ligne https://client.livreurjibiat.site/register";}

  else{$note_message = "sms:$client_phone?body=Note de livraison: Command numero $command_id contact :".$command->phone." : " .$note . ". Créez un compte Jibiat et gérer vos ventes en ligne https://client.livreurjibiat.site/register";}


  return redirect()->back()->with('status',"Note ajoutée.")->with('note_message', $note_message);
}


public function piece(Request $request)
{
  $request->validate(['piece'=>'max:100']);

  $livreur = Livreur::findOrFail(Auth::user()->livreur_id);
  $piece = $request->piece;
  $nature = $request->nature;

  $livreur->pieces = $nature. ' '.$piece ;

  $livreur->update();

  return redirect()->back()->with('status',"Profil mis à jour.");

}


public function setloc(Request $request)
  {
    
   
    if($request->state == 'set')
    {$long = $request->long;
        $lat = $request->lat;

        $geo_time = date('Y-m-d H:i:s');
        $display_time = date('d-m-Y H:i');
    $status = "Tu es en mode <strong style='color:green'> disponible</strong>, les vendeurs peuvent te voir et t'assigner des commandes";
      }
     else{
      $long = null;
        $lat = null;
        $geo_time = null;
        $status = "Tu es en mode <strong style='color:red'>Indisponible</strong> Tu n'apparaitra pas dans la liste des livreurs disponibles";
     }   

    $livreur = Livreur::findOrFail(Auth::user()->livreur_id);
    $livreur->longitude = $long;
    $livreur->latitude =  $lat;
    $livreur->geotime =   $geo_time;
    $livreur->update();

    if($request->route_id)
    {
      $route = Lesroute::findOrFail($request->route_id);
      $route->longitude = $long;
      $route->latitude = $lat;

      $route->update();
    }

  return response()->json(['status'=>$status, "display_time"=>$display_time]);
  }




public function setdom(Request $request)
  {
    $long = $request->long;
    $lat = $request->lat;

    
    $livreur = Livreur::findOrFail(Auth::user()->livreur_id);
    $livreur->domlong = $long;
    $livreur->domlat =  $lat;
   
    $livreur->update();

    

  return response()->json(['status'=>"Domicile dédini"]);
  }


public function recup(Request $request){
 $id = $request->cmd_id;
  $etat = $request->etat;

  $model = Command::findOrFail($id);
        $livreur_id = Auth::user()->livreur_id;

        if($model->livreur_id != $livreur_id)
        {
          redirect()->back()->with("status", "Vous ne pouvez pas effectuer cette action car la commande ne vous est plus assignée.");
        }
 
  
  
    $model->etat = $etat;
    if($etat == 'recupere')
   {$message = "Commande récupérée";
    $obs = "Commande récupérée à ". $model->client->adresse;

    $setting = Setting::where("type", "AUTOMATION")->where("action", "SEND_DLVM_P")->where("switch", 1)->first();
   }
  


   if($etat == 'en chemin')
   {$message = "C'est parti pour cette commande!";
   $obs = "En chemin pour ". $model->adresse;

   $setting = Setting::where("type", "AUTOMATION")->where("action", "SEND_DLVM_W")->where("switch", 1)->first();
}

if($etat == 'termine')
   {
    if(!$model->payment)
    {
      $payment = New Payment;
    $payment->montant = $model->montant-$model->remise;
$payment->client_id = $model->client_id;
$payment->livreur_id = $model->livreur_id;
$payment->command_id = $id;
$payment->etat = "en attente";

$payment->save();

$setting = Setting::where("type", "AUTOMATION")->where("action", "SEND_DLVM_D")->where("switch", 1)->first();
    }
    $message = "Commande livrée";
    $obs = "Commande livrée à ". $model->adresse;


}
  $model->update();

  $route = new Lesroute;
   
  $route->action = "STATUS";
  $route->observation = $obs;
  $route->livreur_id = $livreur_id;
  
  
  $route->save();

  $route_id = $route->id;

  $retour = "<div class='card mb-2 rt_$model->id'>
          <div class='card-body '>
                <div class='row ' style='color: black;' >
                     <div class='col' style='font-size: 13px; line-height: 1.6; font-style: italic;'> 
                        Date de livraison: " .$model->delivery_date->format('d-m-Y').
                        "</div>

                     <div class='col' style='font-size: 13px; line-height: 1.6; font-style: italic;'> 
                       vendeur: ". substr($model->client->nom, 0, 50).
                       "</div>  
                 </div>
            
            <div class=' row '>
             <div style='line-height: 1.6;' class='col'>
                <span  style='font-size:20px;color:black; '>
                    $model->id
                 </span>
                </div>
                 <div style='line-height: 1.6; font-size:13px' class='col'><i   class='fas fa-dot-circle text-warning '></i>Récupéré
                           
                    </div>
                <div class='col-7'>
                    <span  style='font-size:17px; ' >
                        <ion-icon name='cash-outline'></ion-icon>".
                           ($model->livraison  + $model->montant - $model->remise) .
                    "</span>
             </div>
             </div>

             <div class='row mt-0'>";
                   
  if($model->note->count() > 0)
  {$retour .= "<div class='col'>
             <ion-icon class='text-danger ml-1' name='information-circle-outline'></ion-icon>".
      $model->note->last()->description.
     " </div>";}
   
         $retour .=    "</div>
             
            
          </div>
         
      </div>   ";
     $ref_date = date_create("2022-06-24");

      $retourscount = Command::whereIn('etat', ["recupere", "en chemin", "annule"])
                  ->orderBy('delivery_date', "desc")
                  ->where('livreur_id', $livreur_id)
                  ->whereDate('delivery_date', ">", $ref_date)
                 ->count();



   if($setting){
     $text = $setting->text;
     $smsin = Sms_mooving::where("type", "IN")->where("payment", "!=", null)->sum("qty");
     $smsout = Sms_mooving::where("type", "OUT")->sum("qty");
    $smscount = $smsin-$smsout; 
   
   $livreur_info = "";
    
    if($smscount > 0){
      
        $livreur_info = "Livreur ".$model->livreur->nom. " ". $model->livreur->phone;
      
      $codifieds = array("NUMERO_CMD"=>$model->id, "TOTAL_CMD"=>$model->montant+$model->livraison-$model->remise, "TRACKING_CMD"=>url('/').'/tracking/'.$model->id, "LIVREUR_CMD"=>$livreur_info);

      foreach($codifieds as $code=>$value){
        $text = str_replace($code,$value,$text);
      }

      $config = array(
                        'clientId' => config('app.clientId'),
                        'clientSecret' =>  config('app.clientSecret'),
                    );
            
                    $osms = new Sms($config);
            
              
                  
              
                      $data = $osms->getTokenFromConsumerKey();
                      $token = array(
                          'token' => $data['access_token']
                      );
              
              
                      $response = $osms->sendSms(
                      
                          'tel:+2250709980885',
                          
                          'tel:+225'.$model->phone,
                          
                          $text,
                          'Livraison'
                          
                      );

                      
              
                
           $outs = new Sms_mooving;
                $outs->type = "OUT";
                $outs->qty = 1;
                $outs->user_id = 705;
                   
                $outs->save();
  
    }
    
   }               

  $total_pending = Command::where('livreur_id', $livreur_id)->where('etat', 'encours')->where("delivery_date", today())->count();
  return response()->json(['message'=>$message, 'total_pending'=> $total_pending, 'route_id'=>$route_id, 'retour'=>$retour, "retourscount", $retourscount]);
  
}

public function commencer()
{
  $livreur = Livreur::findOrFail(Auth::user()->livreur_id);
  return view("commencer")->with("livreur", $livreur);
}



public function returncmd(Request $request)
{
  $id = $request->id;
  $livreur =Livreur::findOrFail(Auth::user()->livreur_id);

  $command = Command::findOrFail($id);
  $command->retour = "retourne";
  $command->retour_by = $livreur->nom. " ". $livreur->phone;
   $command->retour_at = $command->updated_at;
  $command->update();



  return redirect()->back()->with("status", "Coli rétourné");
}

public function livraisons(Request $request)
{

 $fees = Fee::where("category", 1)->orderBy("destination")->get();

  $day = "Aujourd'hui";
  $delivery_date = date("Y-m-d");

      $etats_chauds = array('encours', 'en chemin', 'recupere');
      $notes = array("Ne décroche pas", "Injoignable", "En déplacement", "Décommandé", "Reporté par le client", "Indisponible", "Promesse de rappeler", "Article réfusé", "Client déja livré", "RDV", "Erreur sur l'article", "Livreur sur place, ne décroche pas", "Adresse modifiée");

   $orange = array('07', '08', '09', '47', '48', '49', '57', '58', '59', '67', '68', '69', '77', '78', '79', '87', '88', '89', '97');

   $mtn = array('04', '05', '06', '44', '45', '46', '54', '55', '56', '64', '65', '66', '74', '75', '76', '84', '85', '86');


   $moov = array('01', '02', '03', '41', '42', '43', '51', '52', '53', '61', '62', '63', '71', '72', '73', '81', '82', '83', '97');
       
       sort($notes);

      
      if($request->input('route_day')){
        $delivery_date = $request->route_day;
        $day = date_format(date_create($request->input('route_day')), 'd-m-Y');
      }
      
      $livreur_id = Auth::user()->livreur_id;

      $ref_date = date_create("2022-06-24");

      $commands = Command::orderBy('etat', "asc")
                   ->orderBy('fee_id', "desc")
                  ->where('retour', null)
                  ->orderBy('adresse', "desc")
                  ->where('livreur_id', $livreur_id)
                  ->whereDate('delivery_date', $delivery_date)
                 ->get();

      
       $retours = Command::where('retour', "encours")
                  ->orderBy('delivery_date', "desc")
                  ->where('livreur_id', $livreur_id)
                  ->whereDate('delivery_date', ">", $ref_date)
                 ->get();
               
     $client_phones = array();
      
           

      $commands_by_fee = Command::
                    where('retour', null)
                     -> where('livreur_id', $livreur_id)
                  ->whereDate('delivery_date', $delivery_date)
                  ->whereIn('etat', $etats_chauds)
                       ->get();



      $destinations = array();
      foreach ($commands_by_fee as $value) {
                 
                  
                    if($value->fee)
                   { $destinations[] = $value->fee->destination;}
                 else{
                   $destinations[] = $value->adresse;
                 }

                   
                  
                 }           
       $final_destinations = array_count_values($destinations);
      $livreurs = Livreur::whereNotIn('id', [$livreur_id])->get(); 



      $done = Command::where('livreur_id', $livreur_id)
                  ->whereDate('delivery_date', $delivery_date)
                  ->where('etat', 'termine')
                 ->get();


      $done_fees = array();

    foreach($done as $one)
    {

      $done_fees[] = $one->livraison;
    }
                 
      
       $payments = Payment::selectRaw('SUM(montant) montant, (client_id) client_id')
     ->where('livreur_id', $livreur_id)
    ->where('etat', 'en attente')
    ->groupBy('client_id')
    ->get();
   
   $real_payments =  Payment::selectRaw('SUM(montant) montant, (client_id) client_id')
   ->where('montant', '>', 0)
     ->where('livreur_id', $livreur_id)
    ->where('etat', 'en attente')
    ->groupBy('client_id')
    ->get();


    $collect_adresses =  Command::selectRaw('COUNT(montant) montant, (client_id) client_id, (ram_phone) ram_phone, (ram_adresse) ram_adresse, (ram_commune) ram_commune, (ram_phone) ram_phone, (ram_name) ram_name')
     ->whereDate('delivery_date', $delivery_date)
     ->where('livreur_id', $livreur_id)
    ->where('etat', 'encours')
    ->groupBy('client_id')
    ->get();

   

    $clients = Client::all();  

    $command_by_status =  Command::selectRaw('COUNT(montant) nombre, (etat) etat')
    ->whereDate('delivery_date', $delivery_date)
    ->where('livreur_id', $livreur_id)
     ->orderBy('Montant', 'desc')
    ->groupBy('etat')
    ->get();  



    $commands_by_clients = Command::selectRaw('SUM(montant) montant, (client_id) client_id')
     ->where('livreur_id', $livreur_id)
     ->where('etat', 'termine')
     ->whereDate('delivery_date', $delivery_date)
    ->groupBy('client_id')
    ->get();    


      $ranks = Command::selectRaw("COUNT(montant) number_done,  (livreur_id) livreur_id")
              ->whereDate('delivery_date',  $delivery_date)
              ->where('etat', 'termine')
              ->orderBy('number_done', 'desc')
              ->groupBy('livreur_id')
              ->get();  
      
  
      $etats = array('encours', 'annule', 'termine', 'en chemin', 'recupere');
      
      $total_fees = array();
      foreach($commands as $command1){
       if($command1->etat == "termine"){
        if($command1->livraison == NULL)
        {$total_fees[] = $command1->fee->price;}
       else{$total_fees[] = $command1->livraison;}
      }
      }
     

     $livreur = Livreur::findOrFail($livreur_id);

     if(strlen(preg_replace('/[^0-9]/', '', $livreur->phone)) == 8)
     { 
        foreach($orange as $or){ 
          if(substr(preg_replace('/[^0-9]/', '', $livreur->phone), 0,-6) == $or)
          {
            $livreur->phone = '07'.$livreur->phone;
          }
        }
        foreach($mtn as $mt){
          if(substr(preg_replace('/[^0-9]/', '', $livreur->phone), 0,-6) == $mt)
          {
            $livreur->phone = '05'.$livreur->phone;
          }
        }
        foreach($moov as $mv){
          if(substr(preg_replace('/[^0-9]/', '', $livreur->phone), 0,-6) == $mv)
          {
            $livreur->phone = '01'.$livreur->phone;
          }
        } 

        $livreur->update(); 
     }
      
        
        return view('livraisons')->with('commands', $commands)->with('etats', $etats)->with('livreur_id', $livreur_id)->with('livreurs', $livreurs)->with('final_destinations', $final_destinations)->with('commands_by_fee', $commands_by_fee)->with('payments', $payments)->with('clients', $clients)->with('done', $done)->with('done_fees', $done_fees)->with('retours', $retours)->with('real_payments', $real_payments)->with('command_by_status', $command_by_status)->with('notes', $notes)->with('commands_by_clients', $commands_by_clients)->with('day', $day)->with('total_fees',$total_fees)->with('livreur', $livreur)->with("fees", $fees)->with("collect_adresses", $collect_adresses);
  
}

public function codecreate(Request $request){
$code = $request->code;
$livreur_id = Auth::user()->livreur_id;
$model = Code::where('livreur_id', $livreur_id)->first();
if($model)
  {$model->code = $code;
 $model->update();
}else{
  $model = new Code;
  $model->code = $code;
  $model->livreur_id = $livreur_id;
  $model->save();
}

return response()->json([]);

}
}