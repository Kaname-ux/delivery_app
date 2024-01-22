<?php

namespace App\Http\Controllers\Admin;
use App\User;
use App\Command;
use App\Client;
use App\Fee;
use App\Livreur;
use App\Friendship;



use App\Payment;
use Illuminate\Support\Facades\Validator;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;

class DashboardController extends Controller
{
    

    


    public function commandlist(Request $request)
    {

      $phone_check = NULL;
    	$id = Auth::user()->client_id;
      $livreurs = Livreur::where('id','!=', 11)->where('status','active')
                                               ->orderBy('id', 'asc')->get();
      


      
      $commands = Command::where('client_id', $id)
                  ->whereDate('delivery_date', today())
                  ->orderBy('updated_at', 'desc')
                 ->get();

             
     $assigned = Command::where('livreur_id','=', 11)
                           ->where('client_id', $id)
                          ->whereDate('delivery_date', today())
                          ->get();

      $commands_by_livreurs = Command::selectRaw('SUM(montant) montant, (livreur_id) livreur_id')
     ->where('client_id', $id)
     ->where('etat', 'termine')
     ->whereDate('delivery_date', today())
    ->groupBy('livreur_id')
    ->get();

   

     $payment = Payment::where('etat', 'en attente')
                       ->where('client_id', $id)
                       ->sum('montant'); 

     $retours = Command::where('client_id', $id)
                         ->where('loc', 'retour')
                         ->get();
                                          

      


     

      $done =  Command::where('client_id', $id)
                        ->whereDate('delivery_date', today())
                        ->where('etat', 'termine')->count(); 


     $ready =  Command::where('client_id', $id)
                        ->whereDate('delivery_date', today())
                        ->where('ready', 'yes')->count();                    

      $done_montant =  Command::where('client_id', $id)
                        ->whereDate('delivery_date', today())
                        ->where('etat', 'termine')->sum('montant');

                       

                                         


      $cancel =  Command::where('client_id', $id)
                      ->whereDate('delivery_date', today())
                        ->where('etat', 'annule')->count();


    $canceled_montant =  Command::where('client_id', $id)
                      ->whereDate('delivery_date', today())
                        ->where('etat', 'annule')->sum('montant'); 
                       

      $day = "Aujourd'hui";                  

      if($request->input('route_day'))
      {

        $commands = Command::where('client_id', $id)
                  ->where('delivery_date', date_format(date_create($request->input('route_day')), 'Y-m-d'))
                  ->orderBy('updated_at', 'desc')
                 ->get();



       $assigned = Command::where('livreur_id','=', 11)
                           ->where('client_id', $id)
                          ->where('delivery_date', date_format(date_create($request->input('route_day')), 'Y-m-d'))
                          ->get();
       $commands_by_livreurs = Command::selectRaw('SUM(montant) montant, (livreur_id) livreur_id')
     ->where('client_id', $id)
     ->where('etat', 'termine')
     ->whereDate('delivery_date',  date_format(date_create($request->input('route_day')), 'Y-m-d'))
    ->groupBy('livreur_id')
    ->get();          

      $done =  Command::where('client_id', $id)
                        ->where('delivery_date', date_format(date_create($request->input('route_day')), 'Y-m-d'))
                        ->where('etat', 'termine')->count();



     $ready =  Command::where('client_id', $id)
                        ->where('delivery_date', date_format(date_create($request->input('route_day')), 'Y-m-d'))
                        ->where('ready', 'yes')->count();                   


                     


     $done_montant =  Command::where('client_id', $id)
                        ->whereDate('delivery_date', date_format(date_create($request->input('route_day')), 'Y-m-d'))
                        ->where('etat', 'termine')->sum('montant'); 


                      
                        


      $cancel =  Command::where('client_id', $id)
                      ->where('delivery_date', date_format(date_create($request->input('route_day')), 'Y-m-d'))
                        ->where('etat', 'annule')->count();
      

      $canceled_montant =  Command::where('client_id', $id)
                      ->whereDate('delivery_date', date_format(date_create($request->input('route_day')), 'Y-m-d'))
                        ->where('etat', 'annule')->sum('montant');
      
     
      if($request->input('route_day') == today())
        {$day = "Aujourd'hui";}

      else{ $day = date_create($request->input('route_day'))->format('d-m-Y') ;}
        
      }
                                           
     
    

     $total =  $commands->sum('montant');

      $client = Client::findOrFail($id);
      
      $fees = Fee::where('category', Auth::user()->category)->orderBy('destination', 'asc')->get();
     

    $actif_ids = array();
    foreach ($commands as $command) {
                   if($command->payment)
                   {
                    if($command->payment->etat == 'termine')
                    {$actif_ids[] = $command->id;}
                   }
                 }    

     $payed_by_livreurs = Payment::selectRaw('SUM(montant) montant, (livreur_id) livreur_id')
         ->where('client_id', $id)
         ->whereIn('command_id', $actif_ids)
        ->groupBy('livreur_id')
        ->get();

  

        
        return view('dashboard')->with('commands', $commands)->with('done', $done)->with('cancel', $cancel)->with('day', $day)->with('done_montant', $done_montant)->with('client', $client)->with('fees', $fees)->with('total', $total)->with('canceled_montant', $canceled_montant)->with('payment', $payment)->with('retours', $retours)->with("phone_check", $phone_check)->with('ready', $ready)->with('livreurs', $livreurs)->with('commands_by_livreurs', $commands_by_livreurs)->with('payed_by_livreurs', $payed_by_livreurs)->with('assigned', $assigned)->with('id', $id);

    }



 public function commandfastregister(Request $request)
    {
        $client_id = Auth::user()->client_id;
        $delivery_date = $request->input('delivery_date');
        $phone = str_replace(' ', '',$request->input('phone'));
        $fee_id = $request->input('fee');
        $adresse = $request->input('adresse');
        $observation = substr($request->input('observation'),0,150);

        $actual_fee = Fee::findOrFail($request->input('fee'));
       
        $client = Client::findOrFail($client_id);
        $montant = preg_replace('/[^0-9]/', '', $request->input('montant'));
        
        if(!is_numeric($montant)){$montant = 0;}
         
        $goods_type = $request->input('type');

       $command_adress = $actual_fee->destination . ":".$adresse;
      
       // if(Auth::user()->approved !== "yes")
       //  {return redirect()->back()->with('new_id', 'Compte restreint');}


                    


      
      
        
       


      if($request->input('confirm')==NULL )
     {$phone_check = Command::where('phone', str_replace(' ', '',$request->input('phone')))->where("client_id", $client_id)->whereDate('created_at', today())->get();
     
            if(count($phone_check)>0)
             {
         
               return redirect()->back()->with('phone_check', 'phone exist')->with("goods_type", $goods_type)->with("delivery_date", $delivery_date)->with("observation", $observation)->with("montant", $montant)->with("fee_id", $fee_id)->with("adresse", $adresse)->with("phone", $phone);
             }
           }
       

      $name = Auth::user()->name;
      $model = new Command;
       
       
       $model->description = $goods_type;
       $model->montant = $montant;
       $model->delivery_date = $delivery_date;
       $model->adresse = $command_adress;
       $model->livreur_id = 11;
       $model->client_id = $client_id;
       $model->phone = $phone;
       $model->fee_id = $fee_id;
       $model->etat = "encours";

       
       $model->observation = $observation;
        



       
       $model->save();
     

       $new_id = $model->id;

       // the message
$msg = "$name a ajouté la commande numero $new_id\n";

// use wordwrap() if lines are longer than 70 characters
$msg = wordwrap($msg,70);

// send email
mail("jibiatonline@gmail.com","Commande $new_id de $name",$msg);
      

       
       return redirect()->back()->with('status', "Commande Ajoutée.")->with('new_id', $new_id);
    }





 public function commandupdate(Request $request)
    {
        
      

$montant = preg_replace('/[^0-9]/', '', $request->input('montant'));
if(!is_numeric($montant)){$montant = 0;}

      $model = Command::findOrFail($request->input('command_id'));
       $actual_fee = Fee::findOrFail($request->input('fee'));
       $client_id = Auth::user()->client_id;
        $client = Client::findOrFail($client_id);

        $goods_type =  $request->input('type');

       $command_adress = $actual_fee->destination . ":".$request->input('adresse');
       
       $model->description = $goods_type;
       $model->montant = $montant;
       $model->delivery_date = $request->input('delivery_date');
       $model->adresse = $command_adress;
       
       $model->client_id = $client_id;
       $model->phone = $request->input('phone');
       $model->fee_id = $request->input('fee');
       

       
       $model->observation = $request->input('observation');

       $model->update();
      

       if($model->etat == 'termine' && $model->montant != $montant)
        {
          $payment = Payment::where('command_id', $model->id)->limit(1);
          $payment->montant = $montant;
          $payment->update();
        }
      

       
       return redirect()->back()->with('status', "Commande modifiée.");
    }

    

    
public function point(Request $request)
{
  $id = Auth::user()->client_id;
  $client = Client::findOrFail($id);
  $etats = array('annule', 'termine');
  $months  = array('01' =>'Janvier' , '02' =>'Fevrier' , '03' =>'Mars' ,'04' =>'Avril' ,'05' =>'Mai' ,'06' =>'Juin' ,'07' =>'Juillet' ,'08' =>'Aout' ,'09' =>'Septembre' ,'10' =>'Octobre' ,'11' =>'Novembre' ,'12' =>'Decembre' );

  $month = date('m');
  $year = date('Y');
 
  $all_fees = Fee::all();

 if($request->has('month'))
  {
    
      $month  = $request->input('month');
  
  }




  $point_par_etat =  Command::selectRaw('SUM(montant) montant, (etat) etat')
           ->whereMonth('delivery_date', $month)
           ->whereIn('etat', $etats)
           ->where('client_id', $id)
           ->groupBy('etat')
           ->get();

  $point_par_adresse =  Command::selectRaw('SUM(montant) montant, (fee_id) adresse')
           ->whereMonth('delivery_date', $month)
           ->where('etat', 'termine')
           ->whereNotNull('fee_id')
           ->orderBy('montant', 'desc')
           ->where('client_id', $id)
           ->groupBy('fee_id')
           ->get();         

  $point_total =  Command::whereMonth('delivery_date', $month)
           ->whereIn('etat', $etats)
           ->where('client_id', $id)
          ->sum('montant');

  


  


  if($request->has('year'))
  {
    $month = "";
    $year = $request->input('year');
    $point_par_etat =  Command::selectRaw('SUM(montant) montant, (etat) etat')
                     ->whereYear('delivery_date', $year)
                     ->whereIn('etat', $etats)
                     ->where('client_id', $id)
                     ->groupBy('etat')
                     ->get();
          
            $point_par_adresse =  Command::selectRaw('SUM(montant) montant, (fee_id) adresse')
                     ->whereYear('delivery_date', $year)
                       ->where('etat', 'termine')
                     ->where('client_id', $id)
                     ->orderBy('montant', 'desc')
                     ->whereNotNull('fee_id')
                     
                     ->groupBy('fee_id')
                     ->get();         
          
            $point_total =  Command::whereYear('delivery_date', $year)
                     ->whereIn('etat', $etats)
                     ->where('client_id', $id)
             
                     ->sum('montant');
  }        
  
  $adresses = array();
  $fees_num = array();

  if(count($point_par_adresse)>0)
  {foreach($point_par_adresse as $point)
  {  if($point->adresse != NULL)
    {$model = Fee::where('id', $point->adresse)->get();
    
        foreach($model as $fee)
        {
          $adresses[] = $fee->destination;
        }}
    
    $fees_num[] = count($adresses);

  }
}

  return view('point')->with('$month', $month)->with('point_par_adresse', $point_par_adresse)->with('point_total', $point_total)->with('point_par_etat',  $point_par_etat)->with('year', $year)->with('month', $month)->with('months', $months)->with('adresses', $adresses)->with('fees_num', $fees_num)->with('all_fees', $all_fees)->with('point_par_adresse', $point_par_adresse)->with('client', $client);
}

public function setready(Request $request){
  $id = $request->id;

  $model = Command::findOrFail($id);

  $model->ready = "yes";

  $model->update();

  return redirect()->back()->with('status', "Commande $id prêt à être récupéré.");
}


public function cancel(Request $request){
  $id = $request->id;

  $model = Command::findOrFail($id);
   
   if($request->cancel == "yes")
  {$model->etat = "annule";}
  if($request->cancel == "no")
  {$model->etat = "encours";}

  $model->update();

  return redirect()->back()->with('status', "Statut modifié.");
}

public function unsetready(Request $request){
  $id = $request->id;

  $model = Command::findOrFail($id);

  $model->ready = NULL;

  $model->update();

  return redirect()->back()->with('status', "préparation annulée");
}

public function tracking($id)
{
   $order = Command::findOrFail($id);
   
   return view('tracking')->with('order',$order); 
   
}


public function relay(Request $request, $id)
    {
        
        $model = Command::findOrFail($id);
        
        $relais = Livreur::findOrFail($request->relais);
        
 
       $model->livreur_id = $request->relais;
       

       $model->update();


       return redirect()->back()->with('status', "Commande assignée");
    }


public function frienships(){

}


public function livreurs(Request $request){
 $id = Auth::user()->client_id;
 $client=Client::findOrFail($id); 
 
 $livreurs = Livreur::where('status', 'active')
            ->paginate(20);
 $zone = "Toutes les zones"; 
 if($request->input('city'))
  {$livreurs = Livreur::where('city', $request->city)
               ->where('status', 'active')
              ->paginate(20); $zone = $request->city;}

 return view('livreurs')->with('livreurs', $livreurs)->with('client', $client)->with('zone', $zone)->with('id', $id);
}



public function sendfriendrequest(Request $request){
  

  $frienship = new Friendship;
  $frienship->first_user = $request->first_user;
  $frienship->second_user = $request->second_user;
  $frienship->acted_user = $request->first_user;
  $frienship->status = "pending";

  $frienship->save();

  return redirect()->back()->with('status', "Invitation envoyée");
}



public static function checkfriendship($first_user, $second_user, $user_id)
{
  $token  = Auth::user()->remember_token;

  $relation = Friendship::where('acted_user', $user_id)->where('second_user', $second_user)->where('first_user', $user_id)->first();

  $reverse_relation =  Friendship::where('acted_user', $second_user)->where('second_user', $user_id)->where('first_user', $second_user)->first();

  if($relation && !$reverse_relation)

  {
        if($relation->status == "approuved")
          {return array("Est mon livreur");}

        if($relation->status == "pending")
          {return array("pending", $relation->id);}
        if($relation->status == "blocked")
          {return array("Livreur bloqué <button>Debloquer</button>");}
  }
    else
    {
       if($reverse_relation)
         {
          if($reverse_relation->status == "approuved")
          {return array("Est mon livreur");}

        if($reverse_relation->status == "pending")
          {return array("Vous a envoyé une demande <button>Accepter</button><button>Refuser</button>");}
        if($relation->status == "blocked")
          {return array("Vendeur bloqué <button>Debloquer</button>");}
         }

         else{
                      return array("invitation_button");
         }
    }
}

public function daily($id){
  $client_id = Auth::user()->client_id;
  $client = Client::findOrFail($client_id); 
  if($id == "Aujourd'hui")
  {
    $commands = Command::where('client_id', $client->id)
                  ->whereDate('delivery_date', today())
                  ->orderBy('updated_at', 'desc')
                 ->get();



    $commands_by_livreurs = Command::selectRaw('SUM(montant) montant, (livreur_id) livreur_id')
       ->where('client_id', $client->id)
       ->where('etat', 'termine')
       ->whereDate('delivery_date', today())
      ->groupBy('livreur_id')
      ->get();



      $done_by_livreurs = Command::selectRaw('COUNT(montant) nbre, (livreur_id) livreur_id')
       ->where('client_id', $client->id)
       ->where('etat', 'termine')
       ->whereDate('delivery_date', today())
      ->groupBy('livreur_id')
      ->get();

      $undone_by_livreurs = Command::selectRaw('COUNT(montant) nbre, (livreur_id) livreur_id')
       ->where('client_id', $client->id)
       ->where('etat', '!=', 'termine')
       ->whereDate('delivery_date', today())
      ->groupBy('livreur_id')
      ->get();
    
    }

    else
      {
        $commands = Command::where('client_id', $client->id)
                  ->where('delivery_date', date_format(date_create($id), 'Y-m-d'))
                  ->orderBy('updated_at', 'desc')
                 ->get();

        $commands_by_livreurs = Command::selectRaw('SUM(montant) montant, (livreur_id) livreur_id')
       ->where('client_id', $client->id)
       ->where('etat', 'termine')
       ->whereDate('delivery_date', date_format(date_create($id), 'Y-m-d'))
      ->groupBy('livreur_id')
      ->get();

      $done_by_livreurs = Command::selectRaw('COUNT(montant) nbre, (livreur_id) livreur_id')
       ->where('client_id', $client->id)
       ->where('etat', 'termine')
       ->whereDate('delivery_date', date_format(date_create($id), 'Y-m-d'))
      ->groupBy('livreur_id')
      ->get();

      $undone_by_livreurs = Command::selectRaw('COUNT(montant) nbre, (livreur_id) livreur_id')
       ->where('client_id', $client->id)
       ->where('etat', '!=', 'termine')
       ->whereDate('delivery_date', date_format(date_create($id), 'Y-m-d'))
      ->groupBy('livreur_id')
      ->get();

      

    }


    $livreurs = Livreur::all();
    $actif_ids = array();
    foreach ($commands as $command) {
                   if($command->payment)
                   {
                    if($command->payment->etat == 'termine')
                    {$actif_ids[] = $command->id;}
                   }
                 }    

     $payed_by_livreurs = Payment::selectRaw('SUM(montant) montant, (livreur_id) livreur_id')
         ->where('client_id', $client->id)
         ->whereIn('command_id', $actif_ids)
        ->groupBy('livreur_id')
        ->get();

   return view('daily')->with('commands_by_livreurs', $commands_by_livreurs)->with('day', $id)->with('done_by_livreurs',$done_by_livreurs)->with('undone_by_livreurs', $undone_by_livreurs)->with('livreurs', $livreurs)->with('payed_by_livreurs', $payed_by_livreurs)->with('client', $client);
}

// public function payment()
// {
//   $point_payment = Payment::
// }

}
