<?php

namespace App\Http\Controllers;

use App\User;
use App\Command;
use App\Command_product;
use App\Product_category;
use App\Command_event;
use App\Difuse;
use App\Client;
use App\Source;
use App\Fee; 
use App\Livreur;
use App\Friendship;
use App\Fast_command;
use App\Manager_fee;
use App\Lesroute;
use App\Payment;
use App\Product;
use App\Certification;
use App\Mooving;
use App\Setting;
use App\Sms_mooving;
use App\Helpers\Sms;
use App\Events\newCommand;


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

class CommandController extends Controller
{

  public function payincommands(){
    $commands = Command::whereBetween('delivery_date',["01-01-2023", today()])->get();

    foreach($commands as $command){
      if($command->payment){
        if($command->payment->etat == "termine"){
          $command->payed_at = $command->payment->created_at;
          $command->cashed_by = $command->payment->client->nom;
          $command->cashed_id = $command->payment->client->id;
          $command->update();

        }
      }
    }
  }


   public function updatepay(Request $request){
       $cmdid = $request->cmdid;
        $command = Command::findOrFail($cmdid);
       

       $status = $request->etat;
       $method = $request->payMethod;
        $previous = "Inconnu";
        $current = "Inconnu";

     if($command->payment){

       if($status == "termine" || $status == "en attente"){

         if($command->payment->etat == "en attente"){
      $previous = "Non Encaissée";
     }

     if($command->payment->etat == "termine"){
      $previous = "Encaissée";
     }
        $command->payment->etat = $status;
        $command->payment->payment_method = $method;
        $command->payment->update();
       }
     }

     if(!$command->payment){
      $previous = "Non Encaissée";
      $payment = new Payment;
      $payment->montant = $command->montant;
      $payment->command_id = $command->id;
      $payment->etat = $status;
      $payment->payment_method = $method;
      $payment->save();
     }

    
      if($command->payment->etat == "en attente"){
      $current = "Non Encaissée";
     }

     if($command->payment->etat == "termine"){
      $current = "Encaissée";
     }
    

   $event = new Command_event;
   $event->description = "Payment mis a jour. Precedent: ".$previous. ". Modification: ".$current;

   $client = Client::findOrFail(Auth::user()->client_id);
   $event->client = $client->id. ": ".$client->nom;
    $event->command_id = $command->id;  
    $event->user_id = Auth::user()->id;   
  $event->save();
      
  return response()->json(["payment"=> $command->payment]);
  }

  public function updatestatus(Request $request){
    $status = $request->etat;
    $cmdid = $request->cmdid;


    $command = Command::findOrFail($cmdid);
    $previoustatus = $command->etat;
    

    if($request->livreur){
      $livreur = $request->livreur;
      
    }else{
      $livreur = $command->livreur_id;
    }

    if($status == "termine"){
      if($command->payment){
        if($request->payed == 1){
          $command->payment->etat = "termine";
          
        }else{
          $command->payment->etat = "en attente";
        }
        $command->payment->update();

      }else{
        $payment = new Payment;
        $payment->command_id = $cmdid;
        $payment->etat = "termine";

        if($livreur != 11){
          $payment->livreur_id = $livreur;
        }
        
        if($request->payed == 1){
          $payment->etat = "termine";
        }else{
          $payment->etat = "en attente";
        }
        $payment->montant = $command->montant;
        $payment->client_id = Auth::user()->client_id;
        $payment->save();
      }

      if($command->products->count()>0){

        foreach($command->products as $product){

          $mooving = Mooving::where("product_id", $product->id)->where("description", "COMMAND_".$cmdid);
          if($mooving->count()<=0){
          $mooving = new Mooving;
          $mooving->product_id = $product->id;
          $mooving->type = "OUT";
          $mooving->qty = $product->qty;
          $mooving->description = "COMMAND_".$cmdid;

          $mooving->save();
          }
          
        }

      }
    }
    if($status == "annule" || $status == "encours"){
      if($command->payment){
        $command->payment()->delete();
      }

      if($command->products->count()>0){

        foreach($command->products as $product){
          $mooving = Mooving::where("product_id", $product->id)->where("description", "COMMAND_".$cmdid);
          if($mooving->count()>0){
            $mooving->delete();
          }
          
        }
        
      }
    }

    $command->etat = $status;
    $command->livreur_id = $livreur;

    $command->update();

    $event = new Command_event;
   $event->description = "Etat modifié. Precedent: ".$previoustatus. ". Modification: ".$status;

   $client = Client::findOrFail(Auth::user()->client_id);
   $event->client = $client->id. ": ".$client->nom;
    $event->command_id = $command->id;  
    $event->user_id = Auth::user()->id;   
  $event->save();

   
    return response()->json(['etat'=>$command->etat]);
  }


   public function updateclient(Request $request){
       $cmdid = $request->cmdid;
        $command = Command::findOrFail($cmdid);
       $previous = $command->costumer;

       if($request->client)
        {
          $client = substr($request->input('client'),0,50);
          $command->nom_client = $client;
          $command->update();
         }

         $command->etat = $status;
         $command->livreur_id = $livreur;

         $command->update();

      $event = new Command_event;
   $event->description = "Client modifié. Precedent: ".$previous. ". Modification: ".$request->client;

$client = Client::findOrFail(Auth::user()->client_id);
   $event->client = $client->id. ": ".$client->nom;
    $event->command_id = $command->id;  
    $event->user_id = Auth::user()->id;   
  $event->save();
  return response()->json(["client"=> $command->nom_client]);
  }


   public function updatesource(Request $request){
       $cmdid = $request->cmdid;
        $command = Command::findOrFail($cmdid);
         $previous = $command->canal;
        $source = $request->source;

        
         $command->canal = $source;
       
       $command->update();
  
  $event = new Command_event;
   $event->description = "Canal modifié. Precedent: ".$previous. ". Modification: ".$request->source;

   $client = Client::findOrFail(Auth::user()->client_id);
   $event->client = $client->id. ": ".$client->nom;
    $event->command_id = $command->id;  
    $event->user_id = Auth::user()->id;   
  $event->save();
      
       
  return response()->json(["source"=> $command->canal]);
  }


   public function updateobservation(Request $request){
       $cmdid = $request->cmdid;
       $command = Command::findOrFail($cmdid);
       $previous =  $command->observation;
       
        $obs = substr($request->obs,0,200);

            $command->observation = $obs;
             $command->update();


$event = new Command_event;
   $event->description = "Info modifié. Precedent: ".$previous. ". Modification: ".$request->obs;

  $client = Client::findOrFail(Auth::user()->client_id);
   $event->client = $client->id. ": ".$client->nom;
    $event->command_id = $command->id;     
    $event->user_id = Auth::user()->id;
  $event->save(); 
        
       
  return response()->json(["observation"=> $command->observation]);
  }


  public function updatedescription(Request $request){
       $cmdid = $request->cmdid;
       $command = Command::findOrFail($cmdid);
       $previous = $command->description;
       
        if($request->type != '')
         {$goods_type = substr($request->type,0,1000);

            $command->description = $goods_type;
             $command->update();
         }

       $event = new Command_event;
   $event->description = "Nature modifiée. Precedent: ".$previous. ". Modification: ".$request->obs;

   $client = Client::findOrFail(Auth::user()->client_id);
   $event->client = $client->id. ": ".$client->nom;
    $event->command_id = $command->id; 
    $event->user_id = Auth::user()->id;    
  $event->save();    
       
  return response()->json(["description"=> $command->description]);
  }


  public function updatedate(Request $request){
       $cmdid = $request->cmdid;
       $command = Command::with("livreur")
                      ->with("fee")
                      ->with("payment")
                      ->with("note")
                      ->with("products")
                      ->with("client")
                      ->findOrFail($cmdid);
       $client_id = Auth::user()->client_id;

       $previous = date_create($command->delivery_date)->format("d-m-Y");
       
        if($request->ddate)
         {

            $command->delivery_date = $request->ddate;
             $command->update();
         }

         


      
     

    $commands = Command::where("client_id", $client_id)
                        ->whereBetween("delivery_date", [$request->start, $request->end])
                        ->orderBy('delivery_date', 'desc')
                       ->with("payment")
                        ->orderBy('adresse', 'asc')
                        ->with("products")
                        ->with("livreur")
                        ->with("fee")
                        ->with("note")
                        ->get();
    

        
   
$event = new Command_event;
   $event->description = "Date de livraison modifiée. Precedent: ".$previous. ". Modification: ".date_create($request->ddate)->format("d-m-Y");

   $client = Client::findOrFail($client_id);
   $event->client = $client->id. ": ".$client->nom;
    $event->command_id = $command->id;  
    $event->user_id = Auth::user()->id;   
  $event->save(); 
       
  return response()->json(["commands"=> $commands, 'singleCommand'=>$command]);
  }

  public function updateadresse(Request $request){
       $cmdid = $request->cmdid;
        $command = Command::findOrFail($cmdid);
        $previous = $command->adresse;
       if($request->fee)
        {
          $actual_fee = Fee::findOrFail($request->input('fee'));
          $command->fee_id = $request->input('fee');
          $command->adresse = $actual_fee->destination.":".$request->adresse;
          $command->update();
         }
      
   
        $event = new Command_event;
   $event->description = "Adresse modifiée. Precedent: ".$previous. ". Modification: ".$command->adresse;

   $client = Client::findOrFail(Auth::user()->client_id);
   $event->client = $client->id. ": ".$client->nom;
    $event->command_id = $command->id;  
    $event->user_id = Auth::user()->id;   
  $event->save();   
       
  return response()->json(["fee_id"=> $command->fee_id, "adresse"=>$command->adresse]);
  }


  public function updatephone(Request $request){
       $cmdid = $request->cmdid;
        $command = Command::findOrFail($cmdid);
        $previous = $command->phone;
       if($request->phone)
        {
          $phone = str_replace(' ', '',$request->input('phone'));
          $command->phone = $phone;
          $command->update();
         }
      

     $event = new Command_event;
   $event->description = "Contact modifié. Precedent: ".$previous. ". Modification: ".$command->phone;

   $client = Client::findOrFail(Auth::user()->client_id);
   $event->client = $client->id. ": ".$client->nom;
    $event->command_id = $command->id;   
    $event->user_id = Auth::user()->id;  
  $event->save();  
       
       
  return response()->json(["phone"=> $command->phone]);
  }


  public function updatecost(Request $request){
       $cmdid = $request->cmdid;
        $command = Command::findOrFail($cmdid);
        $previousliv = $command->livraison;
        $previouscost = $command->montant;
        $montant = preg_replace('/[^0-9]/', '', $request->input('montant'));
         if(!is_numeric($montant)){$montant = 0;}

        $livraison =  preg_replace('/[^0-9]/', '', $request->input('livraison'));
         if(!is_numeric($livraison)){$livraison = 0;}
      
         
         $command->livraison = $livraison;
         $command->montant = $montant;
       
       $command->update();

       if($command->payment){
        $command->payment->montant = $command->montant;
        $command->payment->update();
       }
       

    $event = new Command_event;
   $event->description = "Couts modifié. Precedent > montant: ".$previouscost. "Livraison:".$previousliv.". Modification > montant:".$montant
      . ". Livraison:".$livraison;

   $client = Client::findOrFail(Auth::user()->client_id);
   $event->client = $client->id. ": ".$client->nom;
    $event->command_id = $command->id;  
    $event->user_id = Auth::user()->id;   
  $event->save();  

  return response()->json(["livraison"=> $command->livraison, "montant"=> $command->montant]);
  }


   public function printing(Request $request){
    $client = Client::findOrFail(Auth::user()->client_id);
    $day = date("d-m-Y");   

    $commands = Command::orderBy("delivery_date")->orderBy("adresse", "desc")->where('client_id', Auth::user()->client_id);
    if($request->state && $request->state != 'all')
    {

      $state = $request->state;
      if($state == "dlvm"){
        $commands = $commands->whereIn('etat', ["recupere", "en chemin"])->where("livreur_id", "!=", 11);
       

       
      }
      elseif($state == "unassigned"){
        $commands = $commands->where('etat', "!=", "annule")->where("livreur_id", 11);
       
      }
    else
      {
      $commands = $commands->where('etat', $state);
      
      }
    }


    if($request->start && $request->end && $request->start !="" && $request->end !="")
      {

         $start = $request->start;
         $end = $request->end;
  
          $commands = $commands
                  ->whereBetween("delivery_date", [$start, $end])
                  ;


       if($start == $end)
       {
         
         $day =date_create($start)->format("d-m-Y");
       
       }else{
         $day = "Du " .date_create($start)->format("d-m-Y") . " au " .date_create($end)->format("d-m-Y");
       }

     }else{
      $commands = $commands
                  ->whereDate("delivery_date", today());
                  ;
     }

     $commands=$commands->get();


     return view("print")->with("commands", $commands)->with("client", $client)->with("day", $day);

   } 
  
 public function checkout(Request $request)
    {
       $client = Client::findOrFail(Auth::user()->client_id);
      $products = $client->products;
       $fees = Fee::where('category', Auth::user()->category)->orderBy('destination', 'asc')->get();    


      
      
       
      $ddate = date("Y-m-d");
      $state = "all";



      if($request->ddate){
        $ddate = $request->ddate;
      }

        $commands = Command::where("livreur_id", $request->livreur)
                         ->where("client_id", $client->id)
                         ->where("delivery_date", $ddate);

        $all_commands = $commands->get();                 

      if($request->state && $request->state != "all"){
       $state = $request->state;

       if($state == "delivered"){
        $commands = $commands->where("etat", "termine");
       }

       if($state == "undelivered"){
        $commands = $commands->whereIn("etat", ["recupere", "en chemin"]);
       }

       if($state == "canceled"){
        $commands = $commands->where("etat", "annule");
       }

       if($state == "encours"){
        $commands = $commands->where("etat", "encours");
       }
      }

       

       $commands = $commands->get();

                     
       
       $payments = Payment::where("client_id", $client->id)
                           ->where("livreur_id", $request->livreur)
                          ->where("etat", "en attente") 
                          ->get();

        $payments_by_date = Payment::
        join('commands', 'commands.id', '=', 'payments.command_id')
        ->orderBy('commands.delivery_date', 'desc')
      ->selectRaw('SUM(payments.montant) montant, (commands.delivery_date) delivery_date' )
     ->where('payments.client_id', $client->id)
     ->where('payments.etat', 'en attente')
      ->where('payments.montant', '>', 0)
     ->where('commands.livreur_id', $request->livreur)
    ->groupBy('delivery_date')
    ->get();                   

   $undone_by_date = Command::selectRaw("(delivery_date) delivery_date, COUNT('id') nbre")
                            ->whereIn("etat", ["recupere", "en chemin"])
                            ->where("livreur_id", $request->livreur)
                             ->where("client_id", $client->id)
                             ->groupBy("delivery_date")
                             ->get();

   $undone = Command::whereIn("etat", ["recupere", "en chemin"])
                            ->where("livreur_id", $request->livreur)
                             ->where("client_id", $client->id)

                             ->get();                          
              
         
         $day = date_create($ddate)->format("d-m-Y");

         $curlivreur = Livreur::findOrFail($request->livreur);
        return view('checkout')->with("ddate", $ddate)->with("commands", $commands)->with("all_commands", $all_commands)->with("payments", $payments)->with("curlivreur", $curlivreur)->with("day", $day)->with("client", $client)->with('state', $state)->with("products", $products)->with("fees", $fees)->with("payments_by_date", $payments_by_date)->with("undone_by_date", $undone_by_date)->with("undone", $undone);
    }

   public function commands(Request $request)
    {

      
    $filteredlivreurs = array();
    $filteredfees = array();
 
    $filter = "";
    
      $encours_states = array("encours", "en chemin", "recupere");
      $phone_check = NULL;
      $id = Auth::user()->client_id;
      $client = Client::findOrFail($id);
      $livreurs =Livreur::where('certified_at', "!=", null)->get();
      $state = "all";
      $attente ="";
      $active_liv_ids = array();
     $products = $client->products;
     $stocks = array();
     $sources = $client->sources;
     if($products->count()>0)
    {foreach($products as $product){
            if($product->moovings->count() > 0){
    
                $product->stock = $product->moovings->where("type", "IN")->sum("qty") - $product->moovings->where("type", "OUT")->sum("qty");
                $product->update();
              $stocks[] = [$product->id, $product->moovings->where("type", "IN")->sum("qty") - $product->moovings->where("type", "OUT")->sum("qty")];
            }
        }
      }
      
      
      
      

           
      foreach ($livreurs as $key => $livreur) {
        $active_liv_ids[] = $livreur->id;
        

      }


      


      $day = "Aujourd'hui";   
      
      $current_date = date('Y-m-d');

      $start = $current_date;
      $end = $current_date;


if($request->start && $request->end )
      {

         $start = $request->start;
         $end = $request->end;

       
        $current_date = $day;
      
     if($start == $end)
       {
         if($start == date("Y-m-d"))
       {
           $day = "Aujourd'hui";
       }
       elseif($start == date('Y-m-d',strtotime("-1 days")))
       {
          $day = "Hier";
       }else{
         $day =date_create($start)->format("d-m-Y");
       }


       }else{
         $day = "Du " .date_create($start)->format("d-m-Y") . " au " .date_create($end)->format("d-m-Y");
       }
        
      }
   
    
    
     
      
    


      $payments_by_livreurs = Payment::selectRaw('SUM(montant) montant, (livreur_id) livreur_id')
     ->where('client_id', $id)
    
     ->where('etat', 'en attente')
      ->where('montant', '>', 0)
     ->whereIn('livreur_id', $active_liv_ids)
    ->groupBy('livreur_id')
    ->get();


     $upcomings = Command::selectRaw('SUM(montant) montant, (delivery_date) delivery_date')
     ->where('client_id', $id)
     
     ->where('delivery_date','>', (today()))
    ->groupBy('delivery_date')
    ->get();

$upcomings_count = Command::selectRaw('COUNT(montant) nbre, (delivery_date) delivery_date')
    ->where("client_id", $client->id)
    
     ->where('delivery_date','>', (today()))
    ->groupBy('delivery_date')
    ->get();

    $undone_by_livreurs = Command::selectRaw('COUNT(montant) nbre, (livreur_id) livreur_id')
    
     ->where('client_id', $id)
     
     ->whereIn('etat', ['recupere', 'en chemin'])
    ->whereDate('delivery_date', '>=', "2020-11-10")
     ->whereIn('livreur_id', $active_liv_ids)
    ->groupBy('livreur_id')
    ->get();
  
   $commands = Command::whereBetween("delivery_date", [$start, $end])
              
                ->where('client_id', $id)
               ->with("payment")
                ->with("livreur")
                ->with("note")
                ->with("fee")
                ->with("products")
                ->with("client")
                ;
                  
        $all_commands = $commands->get();

        $cmds_by_livreur = Command::whereBetween("delivery_date", [$start, $end])
            
              ->where('client_id', $id)
              ->selectRaw('COUNT(id) nbre, (livreur_id) livreur_id');

    

                          
      


                                            
     
    if($request->state && $request->state != 'all')
    {

      $state = $request->state;
      if($state == "dlvm"){
        $commands = $commands->whereIn('etat', ["recupere", "en chemin"])->where("livreur_id", "!=", 11);
       

       $cmds_by_livreur = $cmds_by_livreur->whereIn('etat', ["recupere", "en chemin"])->where("livreur_id", "!=", 11);
      }
      elseif($state == "unassigned"){
        $commands = $commands->where('etat', "!=", "annule")->where("livreur_id", 11);
       

       $cmds_by_livreur = $cmds_by_livreur->where('etat', "!=", "annule")->where("livreur_id", 11);
      }

      elseif($state == "assigned"){
        $commands = $commands->where('etat', "encours")->where("livreur_id", "!=", 11);
       

       $cmds_by_livreur = $cmds_by_livreur->where('etat', "encours")->where("livreur_id", "!=", 11);
      }
    else
      {
      $commands = $commands->where('etat', $state);
      
      $cmds_by_livreur = $cmds_by_livreur->where('etat', $state);
      }
    }

   if($request->fees || $request->livreurs || $request->sources){
    if(!empty($request->fees)){
      $filteredfees = $request->fees;
      $filter .=  "<div>Filtre communes: ";
      $commands = $commands->whereIn('fee_id', $request->fees);
      
      $cmds_by_livreur = $cmds_by_livreur->whereIn('fee_id', $request->fees);

      foreach($request->fees as $fee){
        $filredfee = Fee::findOrFail($fee);

        $filter .="<strong class='text-dark'>". $filredfee->destination. "</strong>. ";  
      }
      $filter .=  "</div>";
    }

    if(!empty($request->livreurs)){
      $filteredlivreurs = $request->livreurs;
      $filter .=  "<div>Filtre livreurs: ";
      $commands = $commands->whereIn('livreur_id', $request->livreurs);
     
      $cmds_by_livreur = $cmds_by_livreur->whereIn('livreur_id', $request->livreurs);
      foreach($request->livreurs as $livreur){
        $filredlivreur = Livreur::findOrFail($livreur);

        $filter .= "<strong class='text-dark'>". $filredlivreur->nom. "</strong>. ";  
      }
      $filter .=  "</div>";
    }


     if(!empty($request->sources)){
      $filteredlivreurs = $request->livreurs;
      $filter .=  "<div>Filtre canaux: ";
      $commands = $commands->whereIn('canal', $request->sources);
      
      $cmds_by_livreur = $cmds_by_livreur->whereIn('canal', $request->sources);
      foreach($request->sources as $source){
        

        $filter .= "<strong class='text-dark'>". $source. "</strong>. ";  
      }
      $filter .=  "</div>";
    }
    $filter .=  "</div>";
   }
    


     
     
     
      $commands = $commands->orderBy('adresse', 'asc')->get();
      $total =  $commands->sum('montant');
     $nbre = $commands->count('montant');
       
       
       $cmds_by_livreur =  $cmds_by_livreur
                         ->where('livreur_id','!=', 11)
                       ->groupBy('livreur_id')->get();
      
                 
       
      $fees = Fee::with("tarifs")->where('category', Auth::user()->category)->orderBy('destination', 'asc')->get();

      $categories = $client->categories;
     
      $chk = 4;
      $certifications = Certification::where("status", "pending")->get();
       $clientlivreurs = $client->livreurs;
        return view('commands')->with("filter", $filter)->with('commands', $commands->toJson())->with('day', $day)->with('client', $client)->with('fees', $fees)->with('total', $total)->with("phone_check", $phone_check)->with('livreurs', $livreurs)->with('id', $id)->with('all_commands', $all_commands)->with('payments_by_livreurs', $payments_by_livreurs)->with('detail', 'tout')->with('encours_states', $encours_states)->with('nbre', $nbre)->with('state', $state)->with('attente', $attente)->with('undone_by_livreurs', $undone_by_livreurs)->with('cmds_by_livreur', $cmds_by_livreur)->with('current_date', $current_date)->with('chk', $chk)->with('upcomings', $upcomings)->with('certifications', $certifications)->with("start", $start)->with("end", $end)->with("products", $products->toJson())->with("filteredfees", $filteredfees)->with("filteredlivreurs", $filteredlivreurs)->with('upcomings_count', $upcomings_count)->with('allfees', $fees->toJson())->with("clientlivreurs",$clientlivreurs->toJson())->with('srces', $sources->toJson())->with('categories', $categories->toJson());
}

  public function getmanagerfees(Request $request){
    $id = $request->id;
    $managerfees = Manager_fee::where("manager_id", $id)->get(); 
    $feedisplay = "";

    if($managerfees->count()>0)
      {$feedisplay .= "<option value=''>Choisir une ville/commune</option> ";
          foreach($managerfees as $fee){
          $feedisplay .= "<option value='$fee->id'>$fee->destination: $fee->fee</option> ";
          }
        }
    return response()->json(["managerfees"=>$feedisplay]);
  }


    public function commandlist(Request $request)
    {

      function validateDate($date, $format = 'Y-m-d'){
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) === $date;}

    $ref_date = validateDate("2020-11-10", 'Y-m-d');
 
      $encours_states = array("encours", "en chemin", "recupere");
      $phone_check = NULL;
      $id = Auth::user()->client_id;
      $client = Client::findOrFail($id);
      $livreurs =Livreur::where('status', 'active')->get();
      $state = "all";
      $attente ="";
      $active_liv_ids = array();
      
      foreach ($livreurs as $key => $livreur) {
        $active_liv_ids[] = $livreur->id;
      }

      $payments_by_livreurs = Payment::selectRaw('SUM(montant) montant, (livreur_id) livreur_id')
     ->where('client_id', $id)
     ->where('etat', 'en attente')
      ->where('montant', '>', 0)
     ->whereIn('livreur_id', $active_liv_ids)
     ->orderBy('created_at', 'desc')
    
    ->groupBy('livreur_id')
    ->get();


    $upcomings = Command::selectRaw('SUM(montant) montant, (delivery_date) delivery_date')
     ->where('client_id', $id)
     ->where('delivery_date','>', (today()))
    ->groupBy('delivery_date')
    ->get();


    $upcomings_count = Command::selectRaw('COUNT(montant) nbre, (delivery_date) delivery_date')
     ->where('client_id', $id)
     ->where('delivery_date','>', (today()))
    ->groupBy('delivery_date')
    ->get();


    $undone_by_livreurs = Command::orderBy('updated_at', 'desc')
      
     ->where('client_id', $id)
     ->where('etat', '!=', 'termine')
     ->where('etat', '!=', 'annule')
     ->where('etat', '!=', 'encours')
    ->where('delivery_date', '>=', "2020-11-10")
     ->whereIn('livreur_id', $active_liv_ids)
    
    ->get();


      $day = "Aujourd'hui"; 
      $start = "";
      $end = "";  
      
      $current_date = date('Y-m-d');

 if($request->start && $request->end )
      {

         $start = $request->start;
     $end = $request->end;

       
        $current_date = $day;
      $commands = Command::orderBy('delivery_date', 'desc')

                  ->whereBetween("delivery_date", $start, $end)
                  ->where('client_id', $id);
                  

      $cmds_by_city = Command::selectRaw('COUNT(id) nbre, (fee_id) fee_id')
                              ->whereBetween("delivery_date", $start, $end)
                             ->where('client_id', $id);

      $cmds_by_livreur = Command::selectRaw('COUNT(id) nbre, (livreur_id) livreur_id')
                              ->whereBetween("delivery_date", $start, $end)
                             ->where('client_id', $id);                       

      $all_commands = Command::orderBy('delivery_date', 'desc')
              ->whereBetween("delivery_date", $start, $end)
                ->where('client_id', $id)
                  ->orderBy('fee_id', 'desc')
                 ->get();
     if($start == $end){
      
         $day =date_create($start)->format("d-m-Y");
       

        


       }else{
         $day = "Du " .date_create($start)->format("d-m-Y") . " au " .date_create($end)->format("d-m-Y");
       }
        
      }else{
        

      $commands = Command::orderBy('delivery_date', 'desc')
                   ->where('client_id', $id)
                  ->whereDate('delivery_date', today());
                  
    $cmds_by_city = Command::selectRaw('COUNT(id) nbre, (fee_id) fee_id')
                             ->whereDate('delivery_date', today())
                             ->where('client_id', $id);


    $cmds_by_livreur = Command::selectRaw('COUNT(id) nbre, (livreur_id) livreur_id')
                             ->whereDate('delivery_date', today())
                             ->where('client_id', $id);                         


                  $all_commands = Command::orderBy('delivery_date', 'desc')
                   ->where('client_id', $id)
                  ->whereDate('delivery_date', today())
                  ->orderBy('fee_id', 'desc')
                  ->get();
}
                                           
     
    if($request->state && $request->state != 'all')
    {
      $state = $request->state;
      $commands = $commands->where('etat', $state);
       $cmds_by_city = $cmds_by_city->where('etat', $state);

       $cmds_by_livreur = $cmds_by_livreur->where('etat', $state);
    }

    if($request->attente)
    {
      
      
      $commands = $commands->where('livreur_id', 11);
       $cmds_by_city = $cmds_by_city->where('livreur_id', 11);

      $attente = 'attente';
    }


     $total =  $commands->get()->sum('montant');
     $nbre = $commands->get()->count('montant');
     
     
      $commands = $commands->get();
       $cmds_by_city =  $cmds_by_city->groupBy('fee_id')->get();
       $cmds_by_livreur =  $cmds_by_livreur
                         ->where('livreur_id','!=', 11)
                       ->groupBy('livreur_id')->get();
      
      
      $fees = Fee::where('category', Auth::user()->category)->orderBy('destination', 'asc')->get();
    

      $orange = array('07', '08', '09', '47', '48', '49', '57', '58', '59', '67', '68', '69', '77', '78', '79', '87', '88', '89', '97');

   $mtn = array('04', '05', '06', '44', '45', '46', '54', '55', '56', '64', '65', '66', '74', '75', '76', '84', '85', '86');


   $moov = array('01', '02', '03', '41', '42', '43', '51', '52', '53', '61', '62', '63', '71', '72', '73', '81', '82', '83', '97');

       if(strlen(preg_replace('/[^0-9]/', '', $client->phone)) == 8)
     { 
        foreach($orange as $or){ 
          if(substr(preg_replace('/[^0-9]/', '', $client->phone), 0,-6) == $or)
          {
            $client->phone = '07'.$client->phone;
          }
        }
        foreach($mtn as $mt){
          if(substr(preg_replace('/[^0-9]/', '', $client->phone), 0,-6) == $mt)
          {
            $client->phone = '05'.$client->phone;
          }
        }
        foreach($moov as $mv){
          if(substr(preg_replace('/[^0-9]/', '', $client->phone), 0,-6) == $mv)
          {
            $client->phone = '01'.$client->phone;
          }
        } 

        $client->update(); 
     }


      $destinations = array();
      foreach ($cmds_by_city as $value) {
                 
                    $destinations[] = $value->fee->destination;
                   
                  
                 }           
       $final_destinations = array_count_values($destinations);
      
         $chk = 4;

     
    $certifications = Certification::where("status", "pending")->get();
        return view('dashboard')->with('commands', $commands)->with('day', $day)->with('client', $client)->with('fees', $fees)->with('total', $total)->with("phone_check", $phone_check)->with('livreurs', $livreurs)->with('id', $id)->with('all_commands', $all_commands)->with('payments_by_livreurs', $payments_by_livreurs)->with('detail', 'tout')->with('encours_states', $encours_states)->with('nbre', $nbre)->with('state', $state)->with('attente', $attente)->with('undone_by_livreurs', $undone_by_livreurs)->with('cmds_by_city', $cmds_by_city)->with('cmds_by_livreur', $cmds_by_livreur)->with('current_date', $current_date)->with('chk', $chk)->with('final_destinations', $final_destinations)->with('upcomings', $upcomings)->with('upcomings_count', $upcomings_count)->with('certifications', $certifications)->with("start", $start)->with("end", $end);

    }




    

 public function addnewfast(Request $request)
    {
        
        $client_id = Auth::user()->client_id;
        
        
        $fee_id = $request->input('fee');
       
       
        $client = Client::findOrFail($client_id);
        $montant = preg_replace('/[^0-9]/', '', $request->input('montant'));
        
        if(!is_numeric($montant)){$montant = 0;}
         
        $goods_type = $request->input('type');

       
      
       // if(Auth::user()->approved !== "yes")
       //  {return redirect()->back()->with('new_id', 'Compte restreint');}


      
       

      $name = Auth::user()->name;
      $model = new Fast_command;
       
       
       $model->description = $goods_type;
       $model->price = $montant;
       $model->client_id = $client_id;
       $model->fee_id = $fee_id;
      
        



       
       $model->save();
     

       


       
       return redirect()->back()->with('status', "Ajouté à la liste d'enregistrement rapide.");
    }






     public function commandfastregister(Request $request)
    {   
        $phone = str_replace(' ', '',$request->input('phone'));
        $phone2 = str_replace(' ', '',$request->input('phone2'));
        $client_id = Auth::user()->client_id;
         $checkphone = 0;
        if($request->confirm == null)
        {$checkphone =  Command::where("delivery_date", today())
                                       ->where("client_id", $client_id)
                                       ->where("phone", $phone)
                                       ->count();

                                     

        }
        
        if($checkphone > 0){
          return response()->json(['confirm'=>$checkphone]);
        }else
        {


          $delivery_date = $request->input('delivery_date');
        
        $fee_id = $request->input('fee');
        $adresse = substr($request->input('adresse'),0,150);
        $observation = substr($request->input('observation'),0,150);
        
        
        $other_livraison = $request->input('other_liv');

        if($request->fee)
        {$actual_fee = Fee::findOrFail($request->input('fee'));}

        $goods_type = "colis";
        if($request->type)
         {$goods_type = substr($request->type,0,1000);}


        if($request->managerfee)
        {$actual_fee = Manager_fee::findOrFail($request->input('fee'));}
       
        $client = Client::findOrFail($client_id);
        $montant = preg_replace('/[^0-9]/', '', $request->input('montant'));
         if(!is_numeric($montant)){$montant = 0;}

        $costumer = substr($request->costumer,0,150);
        $remise = preg_replace('/[^0-9]/', '', $request->remise);
        $source =  $request->source;
        if(!is_numeric($remise)){$remise = 0;}
         
       

       $command_adress = $actual_fee->destination . ":".$adresse;
      
       // if(Auth::user()->approved !== "yes")
       //  {return redirect()->back()->with('new_id', 'Compte restreint');}


     
       

      $name = Auth::user()->name;
      $model = new Command;
       

       $model->description = $goods_type;
       $model->montant = $montant;
       $model->delivery_date = $delivery_date;
       $model->adresse = $command_adress;
       
       $model->client_id = $client_id;
       $model->phone = $phone;
       $model->phone2 = $phone2;
       $model->fee_id = $fee_id;
       $model->etat = "encours";

       $model->canal = $source;
       $model->remise = $remise;
       $model->nom_client = $costumer;
       
       if($request->input("livraison"))
       {
        $livraison = $request->input("livraison");
        if($livraison == 'autre' && is_numeric($other_livraison))
              {
               $model->livraison = $other_livraison;
              }
       
              if(is_numeric($livraison)){$model->livraison = $livraison;}
            }

            elseif(!$request->input("livraison")){
              $model->livraison = $actual_fee->fee;
            }else{
              $model->livraison = 0;
            }


         if($request->delai)
       {
        if($request->delai > 0)
        {$model->delai = $request->delai;
          $model->date_delai = date("Y-m-d",strtotime($delivery_date. " + ".$request->delai. " days"));
          }
        }
       $model->observation = $observation;
        
        if($request->same != "1"){
        $model->ram_adresse = $request->ram_adresse;
        $model->ram_phone = $request->ram_phone;
       }

       if(!empty($request->livreur))
        {$model->livreur_id = $request->livreur;}else{
          $model->livreur_id = 11;
        }


       
       $model->save();

       if($request->payed){
        if($request->payed == 1){
        $payment = new Payment;
        $payment->montant = $model->montant-$model->remise;
        $payment->command_id = $model->id;
        $payment->etat = "termine";
        $payment->client_id = $client_id;
        $payment->save();
        }
      }
     

       $new_id = $model->id;
       $new_phone = $model->phone;

       $mooved = array();

       



       if($request->products){
        $goods_type = "";
        $montant = array();
        $products = $request->products;

        foreach($products as $product){
          $data = explode("_",$product);
        
       
        $prod = Product::findOrFail($data[0]);
        $prod->stock = $prod->stock-$data[1];
        $mooving = new Mooving;
        
        $mooving->product_id = $data[0];
        $mooving->type = "OUT";
        $mooving->qty = $data[1];
        $mooving->description = "COMMAND_$model->id";

        $mooving->save();
        $prod->update();

        $goods_type .= $data[1]. " ".$prod->name. ", ";
        $model->products()->attach($data[0], ['qty' => $data[1], 'price' =>$prod->price]);
        
        $montant[] = $prod->price*$data[1];

        }



        $model->description = $goods_type;
        $model->montant = array_sum($montant);

        $model->update();
       }

       // the message
// $msg = "$name a ajouté la commande numero $new_id\n";

// use wordwrap() if lines are longer than 70 characters
// $msg = wordwrap($msg,70);

// send email
// mail("jibiatonline@gmail.com","Commande $new_id de $name",$msg);
      

   
   

   $command = $model;

   $commands = null;

   

  if($request->start && $request->end)
   {
     $commands = Command::where("client_id", $client_id)
                             ->whereBetween("delivery_date", [$request->start, $request->end])
                             ->orderBy('delivery_date', 'desc')
                             ->orderBy('adresse', 'desc')
                             ->with("livreur")
                             ->with("payment")
                             ->with("fee")
                             ->with("note")
                             ->with("client")
                             ->with("products")
                             ->get();
        }
            

           $setting = Setting::where("type", "AUTOMATION")->where("action", "SEND_BILL_C")->first();

    if($client->settings->contains($setting->id)){
      $clientsetting = $client->settings->find($setting->id);

     $text = $clientsetting->pivot->text;
     $smsin = Sms_mooving::where("user_id", Auth::user()->id)->where("type", "IN")->where("payment", "!=", null)->sum("qty");
     $smsout = Sms_mooving::where("user_id", Auth::user()->id)->where("type", "OUT")->sum("qty");
    $smscount = $smsin-$smsout; 
  
    if($smscount > 0){
      $livreur_info = "";
      if($model->livreur_id != 11){
        $livreur_info = "Livreur ".$model->livreur->nom. " ". $model->livreur->phone;
      }
      $codifieds = array("NUMERO_CMD"=>$model->id, "TOTAL_CMD"=>$model->montant+$model->livraison-$model->remise, "TRACKING_CMD"=>'https://client.livreurjibiat.site/tracking/'.$model->id, "LIVREUR_CMD"=>$livreur_info);

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
                          "Ma Commande"
                          
                      );

                      
              
                
           $outs = new Sms_mooving;
                $outs->type = "OUT";
                $outs->qty = 1;
                $outs->user_id = Auth::user()->id;
                   
                $outs->save();
  
    }
    }            
  
   $notify = "Numero: " .$command->id. ". Expéditeur: ". $command->client->nom. "<br> Date de livraison: ". $command->delivery_date->format("d-m-Y"). ".<input type='' hidden name='cmd_id' value='".$command->id."'>";              
               
      event(new newCommand($notify));

       return response()->json(['newCmd'=>$command,'commands'=> $commands]);
     }
    }







public function setmanager(Request $request)
    {
        
        $manager_id = $request->manager_id;

        $client = Client::findOrfail(Auth()->user()->client_id);

        $client->manager_id = $manager_id;
        $client->update();

        $manager_name = $client->manager->company;
       return redirect()->back()->with('status', "Vos Assignations son désormais gérées par ". $manager_name);
    }


    public function unsetmanager(Request $request)
    {
        
        $client = Client::findOrfail(Auth()->user()->client_id);

        $client->manager_id = NULL;
        $client->update();
       return redirect()->back()->with('status', "Vos Assignations son désormais gérées par Vous-même.");
    }


public function addfast(Request $request){
  $cmd_id = $request->cmd_id;
  $client_id = Auth::user()->client_id;

  $cmd = Command::findOrFail($cmd_id);


  $add_fast = new Fast_command;


  $add_fast->description = $cmd->description;
  $add_fast->price = $cmd->montant;
  $add_fast->fee_id = $cmd->fee_id;
  $add_fast->client_id = $cmd->client_id;

  $add_fast->save();
  return response()->json(["status"=>""]);
  
}


public function difuse(Request $request){
  $difuse = new Difuse;
  $client_id = Auth::user()->client_id;
  $cmd_id = $request->cmd_id;

  $difuse->description = $request->description;
  $difuse->client_id = $client_id;
  $difuse->ram_adress = $request->ramadress;
  $difuse->ram_phone = $request->ramphone;
  $difuse->status = "encours";

  $difuse->save();

  $id = $difuse->id;
  $command = Command::findOrFail($cmd_id);
  $command->is_difused = "yes";
  $command->update();

  $share = "<br>
<button id='shareDifuse'><ion-icon name='share-outline'></ion-icon>Partager</button>
  <script >
         
         shareButton3 = document.getElementById('shareDifuse');


shareButton3.addEventListener('click', event => {
  if (navigator.share) {
    navigator.share({
      title:'Diffusion',
      text:'".$request->description.
    "'}).then(() => {
      console.log('Thanks for sharing!');
    })
    .catch(console.error);
  } else {
    shareDialog.classList.add('is-open');
  }
});
       </script>";
  return response()->json(["client_id"=>$client_id, "share"=>$share]);
  
}



public function deletefast(Request $request){
  $fast_id = $request->fast_id;
  

  $fast = Fast_command::findOrFail($fast_id);


 $fast->delete();
  return response()->json(["status"=>""]);
  
}


public function cmddel(Request $request){
  $cmd_id = $request->cmd_id;
  

  $cmd = Command::findOrFail($cmd_id);


 $cmd->delete();
  return response()->json(["status"=>""]);
  
}








 public function commandupdate(Request $request)
    {
        

      
      

$montant = preg_replace('/[^0-9]/', '', $request->input('montant'));
     if(!is_numeric($montant)){$montant = 0;}

     $costumer = substr($request->costumer,0,150);
        $remise = preg_replace('/[^0-9]/', '', $request->remise);
        $source =  $request->source;
        if(!is_numeric($remise)){$remise = 0;}

      $model = Command::findOrFail($request->input('command_id'));
       $actual_fee = Fee::findOrFail($request->input('fee'));
       $client_id = Auth::user()->client_id;
        $client = Client::findOrFail($client_id);
       
         $goods_type = substr($request->input('type'),0,150);
       $command_adress = $actual_fee->destination . ":".substr($request->input('adresse'),0,150);
       
       $model->description = $goods_type;
       $model->montant = $montant;
       $model->delivery_date = $request->input('delivery_date');
       $model->adresse = $command_adress;

       $livraison = $request->input('livraison');
        $other_livraison = $request->input('other_liv');
       
       $model->client_id = $client_id;
       $model->phone = $request->input('phone');
       $model->fee_id = $request->input('fee');
       $model->canal = $source;
       $model->remise = $remise;
       $model->nom_client = $costumer;
       
       if($livraison == 'autre' && is_numeric($other_livraison))
       {
        $model->livraison = $other_livraison;
       }

       if(is_numeric($livraison)){$model->livraison = $livraison;}

       
       $model->observation = substr($request->input('observation'),0,150);
        

        if($request->same != "1"){
        $model->ram_adresse = $request->ram_adresse;
        $model->ram_phone = $request->ram_phone;
       }
       $model->update();
      
      if($model->payment)
        {
          $model->payment->montant = $model->montant;

          $model->payment->update();
        }

       
      

       
       return redirect()->back()->with('status', "Commande modifiée.");
    }

    

    

public function setready(Request $request){
  $id = $request->cmdid;

  $model = Command::findOrFail($id);
  if($model->ready == "yes")

  {
    $model->ready = null;
    
  }

   else{
       $model->ready = 'yes';
     
       }

  $model->update();
  return response()->json(['newstate'=>$model->ready]);
  
}


public function cancel(Request $request){
  $id = $request->id;

  $command = Command::findOrFail($id);
   
   if($request->cancel == "yes")
  {
    $command->etat = "annule";

    if($command->products->count()>0){
      foreach($command->products as $product){
        if($product->moovings->where("description", "COMMAND_".$cmd_id)->count()>0){
          foreach($product->moovings->where("description", "COMMAND_".$cmd_id) as $moov){
            $moov->delete();
          }
        }
      }
    }

   }
  if($request->cancel == "no")
  {
    $command->etat = "encours";

    if($command->products->count()>0){
      foreach($command->products as $product){
           $mooving = new Mooving;
           $mooving->product_id = $product->id;
           $mooving->type = "OUT";
           $mooving->qty = $product->qty;
          $mooving->description = "COMMAND_$model->id";
      }
    }
  }

  $command->update();

  

  return redirect()->back()->with('status', "Statut modifié.");
}


public function reset(Request $request){
  $id = $request->id;

  $model = Command::findOrFail($id);
   $model->etat = 'encours';
   $model->livreur_id = 11;
   
   if($model->payment){
   
    
    $model->payment->delete();
   }
  $model->update();

  return redirect()->back()->with('status', "Commande reinitialisée.");
}


public function bulkreset(Request $request){
  $cmd_ids = $request->cmd_ids;

 $client_id = Auth::user()->client_id;
foreach($cmd_ids as $id)   
{
  $model = Command::findOrFail($id);
   $model->etat = 'encours';
   $model->livreur_id = 11;
   
   if($model->payment){
    $model->payment->delete();
   }

   $model->update();
   }


  
 
     


    
    $commands = Command::where("client_id", $client_id)
                        ->whereBetween("delivery_date", [$request->start, $request->end])
                        ->orderBy('delivery_date', 'asc')
                        ->orderBy('adresse', 'desc')
                        ->with("livreur")
                        ->with("fee")
                        ->with("note")
                        ->get();
    
 
 




  return response()->json(['commands'=>$commands]);
  

  
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









 // Update record
  public function assigncommand(Request $request){

    $livreur_id = $request->input('livreur_id');
    
    $cmd_id = $request->input('cmd_id');
    
    $livreur = Livreur::findOrFail($livreur_id);
    $command = Command::findOrFail($cmd_id);
    $command->livreur_id = $livreur_id;

    $command->update();
    if($command->payment){
      $command->payment->livreur_id = $livreur_id;
      $command->payment->update();
    }

    
   $event = new Command_event;
    if($livreur_id == 11){
      $description = "commades desassignée";
    }
    else{
      $description = "Commande assignée a: ".$command->livreur->nom;
    }
   $event->description = $description;
   
   $client = Client::findOrFail(Auth::user()->client_id);
   $event->client = $client->id. ": ".$client->nom;
    $event->command_id = $command->id;
    $event->user_id = Auth::user()->id;     
  $event->save();


   $setting = Setting::where("type", "AUTOMATION")->where("action", "SEND_DLVM_A")->first();

    if($client->settings->contains($setting->id)){
     $text = $setting->text;
     $smsin = Sms_mooving::where("user_id", Auth::user()->id)->where("type", "IN")->where("payment", "!=", null)->sum("qty");
     $smsout = Sms_mooving::where("user_id", Auth::user()->id)->where("type", "OUT")->sum("qty");
    $smscount = $smsin-$smsout; 

    if($smscount > 0){
      $codifieds = array("NUMERO_CMD"=>$command->id, "TOTAL_CMD"=>$command->montant+$command->livraison-$command->remise, "TRACKING_CMD"=>'https://client.livreurjibiat.site/tracking/'.$command->id);

      if($command->livreur_id != 11){
        $codifieds["LIVREUR_CMD"] = "Votre livreur:".$command->livreur->nom." ".$command->livreur->phone;
      }

      foreach($codifieds as $code=>$value){
        $text = str_replace($code,$value,$text);
      }

      $config = array(
                        'clientId' => config('app.clientId'),
                        'clientSecret' =>  config('app.clientSecret'),
                    );
            
                    $osms = new Sms($config);
            
                   
                $message = $request->message;
              
                  
              
                      $data = $osms->getTokenFromConsumerKey();
                      $token = array(
                          'token' => $data['access_token']
                      );
              
              
                      $response = $osms->sendSms(
                      
                          'tel:+2250709980885',
                          
                          'tel:+225'.$command->phone,
                          
                          $text,
                          "Ma Commande"
                          
                      );

                      
              
                
           $outs = new Sms_mooving;
                $outs->type = "OUT";
                $outs->qty = 1;
                $outs->user_id = Auth::user()->id;
                   
                $outs->save();
  
    }
    }     
   
    return response()->json(['livreur'=>$livreur]);
  }



  // Update record
  public function assigncommandbulk(Request $request){

    $livreur_id = $request->input('livreur_id');
    
    $cmd_id = $request->input('cmd_id');
    
    $livreur = Livreur::findOrFail($livreur_id);
    $ids = explode(',', $cmd_id);
   
   $phones = "";
    foreach($ids as $id)
    { 
      $command = Command::findOrFail($id);
      $phones .= $command->phone. ",";
      $command->livreur_id = $livreur_id;
      $command->update();

 // $message = "Commande numero ".$command->id. ". Total:".($command->montant+$command->livraison). "FCFA. " . substr($command->description, 0, 20). ". Livreur: ". substr($livreur->nom, 0, 20).": ".$livreur->phone. ".Activez votre GPS et Cliquez ici pour envoyer votre localisation: https://client.livreurjibiat.site/tracking/".$command->id;
 //    $config = array(
 //            'clientId' => config('app.clientId'),
 //            'clientSecret' =>  config('app.clientSecret'),
 //        );

 //        $osms = new Sms($config);

 //        if($osms->getAdminContracts()['availableUnits'] >0)
 //  {$message = "Commande numero ".$command->id. ". Total:".($command->montant+$command->livraison). "FCFA. " . substr($command->description, 0, 20). ". Livreur: ". substr($livreur->nom, 0, 20).": ".$livreur->phone. ".Activez votre GPS et Cliquez ici pour envoyer votre localisation: https://client.livreurjibiat.site/tracking/".$command->id;
  
      
  
 //          $data = $osms->getTokenFromConsumerKey();
 //          $token = array(
 //              'token' => $data['access_token']
 //          );
  
  
 //          $response = $osms->sendSms(
          
 //              'tel:+2250709980885',
              
 //              'tel:+225'.$command->phone,
              
 //              $message,
 //              'Jibiat'
 //          );
 //  }

    }

 $client = Client::finOrfail(Auth::user()->client_id);
 $sms_btn =  '
                         <a class="btn btn-icon btn-primary  phone" href="tel:'.$livreur->phone.'" >
                            <ion-icon class="" name="call-outline"></ion-icon>
                            
                         </a>
                          <br><br>
                         <a class="btn  btn-primary  btn-sm" href="sms:'.$livreur->phone.','.$phones.'?body=Commande  assignée au livreur '. substr($livreur->nom, 0, 20). ': ' . $livreur->phone. '. '.  $client->nom.'" >
                            <ion-icon class="phone" name="mail-outline"></ion-icon> Ecrire au(x) client(s) et au livreur...
                         </a>';
    $cur_liv = substr($livreur->nom, 0, 20);

  

     
    

   return response()->json(['cur_liv'=>$cur_liv, 'livreur_id'=>$livreur->id, 'liv_phone'=>$livreur->phone, 'sms_btn'=>$sms_btn]);
  }






 // Update record
  public function unassigncommand(Request $request){

    $livreur_id = $request->input('livreur_id');
    
    $cmd_id = $request->input('cmd_id');
    
  
    $command = Command::findOrFail($cmd_id);
    $command->livreur_id = 11;

    $command->update();

   
    return response()->json(['status'=>"Desassigner"]);
  }



public  function bydatedetail(Request $request){
    $client_id = Auth::user()->client_id;
    $cmd_date = $request->cmd_date;
    $livreur_id = $request->livreur_id;

    $livreur =Livreur::findOrFail($livreur_id);

    $commands = Command::where('client_id', $client_id)
                         ->where('livreur_id', $livreur_id)
                         ->where('delivery_date', $cmd_date)
                         ->orderBy('etat', 'asc')
                         ->get();
$payed = array(); $done = array(); $total = array(); $unpayed_ids = array();

  foreach($commands as $command){
    $pay_state = "";
    
    $total[] =  $command->montant;

     if($command->payment && $command->payment->etat == 'termine')
      {$payed[] = $command->payment->montant;
       $pay_state =" <span 'class='badge badge-success float-right'>Payé</span>";
        }

        if($command->payment && $command->payment->etat != 'termine')
      {$unpayed_ids[] = $command->payment->id;
       
        }
       
       
       
       if($command->etat == 'termine')
       {$done[] = $command->montant;} 
       

    if($command->etat == 'encours') 
                          {$class = 'class="badge badge-danger"';}
                          

                          if($command->etat == 'recupere')
                          {$class = 'class="badge badge-warning"';}
                          

                          if($command->etat == 'en chemin')
                          {$class = 'class="badge badge-warning"';}
                          


                          if($command->etat == 'termine')
                          {$class = 'class="badge badge-success"';}
                         

                          if($command->etat == 'annule')
                          {$class = 'class="badge badge-secondary"';}

          if($command->etat != 'termine')
                          {$txt = $command->etat;

                      
                          }
                           else
                           {$txt = "Livré"; }              
     $note = "";
     $note_date ="";
     if($command->note->count() > 0)
      {$note = $command->note->last()->description;
       
     }
     $cancel_btn ="";
     $active_btn ="";
     $report_btn = "";
     if($command->etat != 'termine' && $command->etat != 'annule')
     {
      $cancel_btn = "<button id='cancel_btn".$command->id."' data-id='annule' class='cancel_btn".$command->id." btn btn-danger btn-sm' value='".$command->id."' >Annuler</button>";

      $active_btn = "<button hidden='hidden' data-id='encours' class='cancel_btn".$command->id." btn btn-success btn-sm' id='active_btn".$command->id."' value='".$command->id."' >Activer</button>";
      $report_btn = "<button class='report_btn".$command->id." btn btn-success btn-sm' value='".$command->id."'>Report</button><label  hidden='hidden' class='form-label rprt_date_label".$command->id."'>Choisir date de report<input  type='date' class='form-control rprt_date".$command->id."'></label>
        <button hidden='hidden' class='cancel_report".$command->id." btn btn-danger btn-sm'  >Annuler report</button>

      <script>
      var CSRF_TOKEN = $('meta[name=\"csrf-token\"]').attr('content');
      $('.report_btn".$command->id."').click(function(){
   $('.cancel_btn".$command->id."').attr('hidden', 'hidden');
   $('.report_btn".$command->id."').attr('hidden', 'hidden');
  $('.rprt_date_label".$command->id."').removeAttr('hidden');
  $('.rprt_date".$command->id."').attr('data-id', $(this).val());
  $('.rprt_date".$command->id."').attr('data-cur', cmd_id".$command->id.");
  $('.cancel_report".$command->id."').removeAttr('hidden');
  $(this).attr('hidden', 'hidden');
}); 


$('.cancel_report".$command->id."').click(function(){
   $('#cancel_btn".$command->id."').removeAttr('hidden');
   $('.report_btn".$command->id."').removeAttr('hidden');
  $('.rprt_date_label".$command->id."').attr('hidden', 'hidden');
 
  $(this).attr('hidden', 'hidden');
}); 



 $('.rprt_date".$command->id."').change(function(){

  var cmd_id = $(this).data('id');
  var rprt_date = $(this).val();
  

  var cur_cmd = $('#cmd_id".$command->id."');
    $.ajax({
      url: 'report',
      type: 'post',
      data: {_token: CSRF_TOKEN,cmd_id: cmd_id,cmd_date: rprt_date},
      success: function(response){
       alert('Commande reportée');
       (cur_cmd).attr('hidden', 'hidden');
               
    }
});
   
}); 



$('.cancel_btn".$command->id."').click(function(){

  var state = $(this).data('id');
  var cmd_id = $(this).val();
  var active_btn = $('#active_btn".$command->id."');
  var cancel_btn = $('#cancel_btn".$command->id."');
  var cur_cmd = $('#cmd_state".$command->id."');

    $.ajax({
      url: 'cancel_cmd',
      type: 'post',
      data: {_token: CSRF_TOKEN,cmd_id: cmd_id,state: state},
      success: function(response){
        if(response.state == 'annule')
       {alert('Commande annulée');
              (cur_cmd).attr('class', 'badge badge-secondary');
              (cur_cmd).text('annule');
              (active_btn).removeAttr('hidden');
              (cancel_btn).attr('hidden', 'hidden');

            }else
            {
              alert('Commande activée');
              (cur_cmd).attr('class', 'badge badge-danger');
              (cur_cmd).text('encours');
              (active_btn).attr('hidden', 'hidden');
              (cancel_btn).removeAttr('hidden');
            }
       
    }
});
   
}); 
 </script>

      ";

     }

    $display[] = "<ul id='cmd_id".$command->id."'><li><strong>#" .$command->id. " ". $command->montant. " " .$command->fee->destination ." ". "</strong><span id='cmd_state".$command->id."' ". $class .">".$txt ." ".$command->updated_at->format('H:i:s'). "</span>$pay_state<br>$note<br>$report_btn  $cancel_btn $active_btn</li></ul>";
                
    
  }


   $pay_form = "";
   $total = array_sum($total); $payed = array_sum($payed); $done = array_sum($done); 
   $remain = $done-$payed;
   
   if($remain>0)
    {$pay_form = '';

  foreach($unpayed_ids as $unpayed_id)
    {$pay_form .= '<input hidden type="text" name="unpayed[]" value="'.$unpayed_id.'">
                   <input hidden name="livreur_phone" value="'.$livreur->phone.'">';}
  $pay_form .= '<label class="form-label">
                Valider Payement
            <select name="pay_methode" required  class="form-control">
            <option disabled selected >Choisir mode de payement</option>
         
          
          <option value="Main a Main">Main à main</option>
          <option value="Mobile money">Mobile money</option>
          
          </select>
           </label>
          <button type="submit" class"btn btn-sm btn-success">Valider</button>';}
   return response()->json(['display'=>$display, 'livreur_nom'=>$livreur->nom, 'payed'=>$payed, 'total'=>$total, 'done'=>$done, 'remain'=>$remain, 'pay_form'=>$pay_form]);                      
  }

  public function report(Request $request)
  {
    $cmd_id = $request->cmd_id;
    $cmd_date = $request->rprt_date;
    $assign = $request->assign;
    $reset = $request->reset;
    $command = Command::findOrFail($cmd_id);
    $command->delivery_date = $cmd_date;
    if($reset == 1)
    {$command->etat = 'encours';}
    
    if($assign == 1){$command->livreur_id = 11;}
    
    $command->update();

    $formated_date = $command->delivery_date->format("d-m-Y");

  return response()->json(['status'=>"reporté", "formated_date" => $formated_date]);
  }



  public function bulkreport(Request $request)
  {
    
    $cmd_ids = $request->cmd_ids;
    
  
   $client_id = Auth::user()->client_id;
   
  foreach($cmd_ids as $id)
  {
    $command = Command::findOrFail($id);
    

    $command->delivery_date = $request->rprt_date;
  

    $reset = $request->reset;
        if($reset == 1)
          {
          $command->etat = 'encours';
          
          if($command->payment){
          $command->payment->delete();
         }

    }
           $assign = $request->assign;
        if($assign == 1){
          $command->livreur_id = 11;
         if($command->payment){
          $command->payment->delete();

        }
      }

    $command->update();
    
  
 

  }



     


   
  
  
    $commands = Command::where("client_id", $client_id)
                        ->whereBetween("delivery_date", [$request->start, $request->end])
                        ->orderBy('delivery_date', 'asc')
                        ->orderBy('adresse', 'desc')
                        ->with("livreur")
                        ->with("fee")
                        ->with("note")
                        ->get();
    
 
 




  return response()->json(['commands'=>$commands]);
  }



  public function cancelcmd(Request $request)
  {
    $cmd_id = $request->cmd_id;
    $cmd_state = $request->state;
     
    $command = Command::findOrFail($cmd_id);
    
    $command->etat = $cmd_state;

    $command->update();

    if($command->etat == "annule")
  {
    

    if($command->products->count()>0){
      foreach($command->products as $product){
        if($product->moovings->where("description", "COMMAND_".$cmd_id)->count()>0){
          foreach($product->moovings->where("description", "COMMAND_".$cmd_id) as $moov){
            $moov->delete();
          }
        }
      }
    }

   }
  if($command->etat == "encours")
  {
    

    if($command->products->count()>0){
      foreach($command->products as $product){
           $mooving = new Mooving;
           $mooving->product_id = $product->id;
           $mooving->type = "OUT";
           $mooving->qty = $product->qty;
          $mooving->description = "COMMAND_$model->id";
      }
    }
  }


  return response()->json(['state'=>$cmd_state]);
  }



   public function deletecmd(Request $request)
  {
    $cmd_id = $request->cmdid;
   
    $command = Command::findOrFail($cmd_id);
    
    

    if($command->products->count()>0){
      foreach($command->products as $product){
        if($product->moovings->where("description", "COMMAND_".$cmd_id)->count()>0){
          foreach($product->moovings->where("description", "COMMAND_".$cmd_id) as $moov){
            $moov->delete();
          }
        }
      }

      
    }

  if($command->payment)
    {$command->payment()->delete();} 

      
     $command->delete();
   

  return response()->json([]);
  }

 

  public function assign(Request $request){
    $client_id = Auth::user()->client_id;
     $cmd_id = $request->cmd_id;
      $fees = Fee::all();

      $client = Client::findOrFail($client_id);
     $command = Command::findOrFail($cmd_id);

     

     $livreurs = $client->livreurs;
     $liv_in_zone = array();
     $zone_livreurs = array();
     $zonelast = array();
     $otherlast = array();

     

     foreach($livreurs as $livreur)
     {
      if($livreur->commands->count()>0)
      {
        foreach($livreur->commands->where('delivery_date', today()) as $liv_cmd)
                {
                  
                   if($liv_cmd->fee->zone == $command->fee->zone && $liv_cmd->etat != 'termine'  && $liv_cmd->etat != 'annule')
                   {
                     $liv_in_zone[] = $livreur->id;
                   }
                  }
                }
          }



       if(count($liv_in_zone) > 0)
       {
         
         array_unique($liv_in_zone);
         $zone_livreurs = $livreurs->whereIn('id', $liv_in_zone);
         
         foreach($zone_livreurs as $zn_lv)
         { 
      
      
    
     $route = Lesroute::where('livreur_id', $zn_lv->id)->where('action', "STATUS")->orderBy('created_at', "desc")->first();
       
       if($route)
            {$zonelast[] =  $route->observation. " ".$route->created_at->format("d-m-Y H:i");}
          else{
           $zonelast[] = "";
          }

           
        }
  }






       
 
       $other_livreurs = $livreurs->whereNotIn('id', $liv_in_zone);


    foreach($other_livreurs as $ot_lv)
    {   
       
       
     
      $route2 = Lesroute::where('livreur_id', $ot_lv->id)->where('action', "STATUS")->orderBy('created_at', "desc")->first();
       
       if($route2)
            {$otherlast[] =  $route2->observation. " ".$route2->created_at->format("d-m-Y H:i");}
          else{
           $otherlast[] = "";
          }

           
        }
       
      
     
 
    return response()->json(["zone_livreurs"=>$zone_livreurs,  "other_livreurs"=>$other_livreurs, 'zonelast'=>$zonelast, 'otherlast'=>$otherlast ]);
     }




public function getlivreurcmds(Request $request){
$id = $request->livreur_id;
$livreurcmds = "";
$by_zone = Command::where("livreur_id", $id)->selectRaw('COUNT(fee_id) nbre, (fee_id) fee_id')
     ->where('etat', '!=', 'termine')->where('etat', '!=', 'annule')->where('delivery_date', today())
    ->groupBy('fee_id')
    ->get();

$remaining = $by_zone->sum('nbre');

$route2 = Lesroute::where('livreur_id', $id)->where('action', "STATUS")->orderBy('created_at', "desc")->first();
       
       if($route2)
            {
             $livreurcmds .= "Dernière Action: <div class='text-primary'>".  $route2->observation. " ".$route2->created_at->format("d-m-Y H:i"). "</div>";
          }

$livreurcmds .=   "<div class='text-warning'>$remaining Commandes encours actuellement
                        </div>";
foreach($by_zone as $zone){

       $livreurcmds .= " 

       

                       <div class='chip chip-media mt-1' style='margin-bottom: 3px'>
                                <i class='chip-icon  bg-success '>".
                                         $zone->nbre
                                        ."</i>
                                        <span class='chip-label'>"
                                            .$zone->fee->destination
                                        ."</span>
                                </div>";


}


return response()->json(["livreurcmds"=>$livreurcmds]);
}



  public function donedetail(Request $request){

    $livreur = Livreur::findOrFail($request->id);
    $livreur_nom = $livreur->nom;
    $ids = explode(',', $request->ids);
    $commands = Command::whereIn("id", $ids)->get();
   
   $dones = "<ul>";
    foreach($commands as $command)
    {
      $dones .= '<li>n°'.$command->id. "-" .$command->adresse. "-" .$command->montant .'FCFA</li>';
    }

    $dones .= "<ul>";

    return response()->json(["dones"=>$dones, "livreur_nom"=>$livreur_nom]);
  }

  
  public function cmdrtrn(Request $request){
    $id = Auth::user()->client_id;
    $livreurs = Livreur::where('status', 'active')->get();

     $active_liv_ids = array();

      foreach ($livreurs as $key => $livreur) {
        $active_liv_ids[] = $livreur->id;
      }
    function validateDate($date, $format = 'Y-m-d'){
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) === $date;}

    $ref_date = validateDate("2020-11-10");


    $undone_by_livreurs = Command::orderBy('updated_at', 'desc')
      ->selectRaw('COUNT(montant) undone, (livreur_id) livreur_id')
     ->where('client_id', $id)
     ->where('etat', '!=', 'termine')
     ->where('etat', '!=', 'encours')
     ->where('etat', '!=', 'annule')
     ->whereIn('livreur_id', $active_liv_ids)
    
      ->whereDate('delivery_date', '>=', "2020-11-10")
    ->groupBy('livreur_id')
    ->get();

    $cmd_return = "";

  if($undone_by_livreurs->count() > 0)
    {foreach($undone_by_livreurs as $undone){
          $cmd_return .= '<div  class="card target" style="width: 100%;border-style: solid; border-width: 1px;">
                <ul  class="list-group list-group-flush">
                <li  class="pt-6 list-group-item">';
    
                foreach($livreurs as $livreur2){
        if($undone->livreur_id == $livreur2->id){
          $cmd_return .= $livreur2->nom;
         }
       }
    
      
       $cmd_return .= "<span style='font-weight: bold; color:red' class='float-right'>$undone->undone</span><br>

       <button id='allPay$undone->livreur_id' class='btn btn-danger btn-sm detail' value='$undone->livreur_id'>Voir détail</button>
                       </li></ul>


      
 </div>";



      }

      $cmd_return .= "
      <script>

       $('.detail').click( function() {
   var livreur_id = $(this).val();
   
    $('.cmdRtrnBack').removeAttr('hidden');
   $('.cmdRtrnBody').html('<span   class=\"spinner-border spinner-border cmdRtrnSpinner\" role=\"status\" aria-hidden=\"true\"></span><span class=\"sr-only\"></span>');


     $.ajax({
       url: 'cmdrtrndetail',
       type: 'post',
       data: {_token: CSRF_TOKEN,livreur_id: livreur_id},
   
       success: function(response){
                 $('.cmdRtrnReturn').removeAttr('hidden');
                $('.cmdRtrnBody').html(response.display);
                $('.cmdRtrnTotal').html('<strong>Total:' +response.total + '</strong>');
                 $('.cmdRtrnLivreur').html(response.livreur);
                 $('#cmdRtrnScript').html(response.cmd_rtrn_script);
              },
   error: function(response){
               
                alert('Une erruer s\'est produite');
              }
             
     });
   });
      </script>";


 

  }else{$cmd_return = "Vous n'avez pas de retours";}

   return response()->json(['status'=>'Payé', 'cmd_return'=>$cmd_return]);
}




public function cmdrtrndetail(Request $request){
    $client_id = Auth::user()->client_id;
    $livreur_id = $request->livreur_id;

     function validateDate($date, $format = 'Y-m-d'){
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) === $date;}

    $ref_date = validateDate("2020-11-10", 'Y-m-d');
  
    $livreur =Livreur::findOrFail($livreur_id);

    $commands = Command::where('client_id', $client_id)
                         ->where('livreur_id', $livreur_id)
                         ->orderBy('delivery_date', 'desc')
                         ->where('etat', '!=', 'termine')
                         ->where('etat', '!=', 'annule')
                         ->where('etat', '!=', 'encours')
                         ->whereDate('delivery_date', '>=', "2020-11-10")
                         ->orderBy('etat', 'asc')

                         ->limit(100)
                         ->get();
$payed = array(); $done = array(); $total = array(); $unpayed_ids = array();

$cmd_rtrn_script = "<script>

    $('.cmdRprt').click(function(){
      var id = $(this).val();
       $('#cmdArea'+id).attr('hidden', 'hidden');
    
  $('#cmdRprtButtons'+id).removeAttr('hidden');
 
 
});


$('.cmdCncl').click(function(){
  var cur_btn = $(this);
  var state = $(this).data('id');
  var cmd_id = $(this).val();
  var active_btn = $('#active_btn'+cmd_id);
  var cancel_btn = $('#cancel_btn'+cmd_id);
  var cur_cmd = $('#cmd_state'+cmd_id);
  $(this).find('span').removeAttr('hidden');

    $.ajax({
      url: 'cancel_cmd',
      type: 'post',
      data: {_token: CSRF_TOKEN,cmd_id: cmd_id,state: state},
      success: function(response){
        cur_btn.find('span').attr('hidden', 'hidden')
        if(response.state == 'annule')
       {
              (cur_cmd).attr('class', 'badge badge-secondary');
              (cur_cmd).text('annule');
              (active_btn).removeAttr('hidden');
              (cancel_btn).attr('hidden', 'hidden');


            }else
            {
              
              (cur_cmd).attr('class', 'badge badge-danger');
              (cur_cmd).text('encours');
              (active_btn).attr('hidden', 'hidden');
              (cancel_btn).removeAttr('hidden');
            }
       
    }
});
   
}); 

 $(\".cmdCancel\").click(function(){
   id = $(this).val();
     $('#cmdCancelButtons'+id).removeAttr('hidden');
      $('#cmdArea'+id).attr('hidden', 'hidden');
});



  $('.cmdRprtConfirm').click( function() {
       var cmd_id = $(this).val();
       var rprt_date = $('.rprtDate'+cmd_id).val();
       
       var assign = 0;
       if($('#assign'+cmd_id).is(':checked')){var assign = 1;}
    
   
   $('.cmdRprtSpinner'+cmd_id).removeAttr('hidden');

     if(rprt_date == '0000-00-00')
     {alert('veuillez choisr la date de report');

      $('.cmdRprtSpinner'+cmd_id).attr('hidden', 'hidden');}
     else {
      $.ajax({
            url: 'report',
            type: 'post',
            data: {_token: CSRF_TOKEN,cmd_id: cmd_id, rprt_date:rprt_date, assign: assign},
        
            success: function(response){
                 
       $('#cur'+cmd_id).html('<span class=\'alert alert-success\'>Commande ' +cmd_id+ ' Reportée au '+rprt_date +'</span>');
                      $('.cmdRprtSpinner'+cmd_id).attr('hidden', 'hidden');
                   },
        error: function(response){
                    
                     alert('Une erreur s\'est produite');
                     $('.cmdRprtSpinner'+cmd_id).attr('hidden', 'hidden');
                   }
                  
          });}
   });
</script>";
 if($commands->count()>0)
  {foreach($commands as $command){
      
   
    
        
       
        $total[] =       $command->montant;
       
       if($command->etat == 'encours')   
      {$class = 'class="badge badge-danger"';
       }
  
  
        else 
      {$class = 'class="badge badge-warning"';
        }
     
      $txt = $command->etat;
  
        $note = "";
        $note_date ="";
       if($command->note->count() > 0)
        {
          $note = $command->note->last()->description;
         
         }
  
  
         $display[] = "<div id='cur".$command->id."'  class='card target' style='width: 100%;border-style: solid; border-width: 1px;'>
      <ul class='list-group list-group-flush' id='cmd_id".$command->id."'><li  class='pt-6 list-group-item'><strong>#" .$command->id. " ". "<span id='cmd_state".$command->id."' ". $class .">".$txt ." ".$command->updated_at->format('d-m-Y H:i:s').  "</span><br> Date de livraison:".$command->delivery_date->format('d-m-Y') ."<br>".$command->adresse ." ". "</strong><br>$command->description<br>$command->montant FCFA<br>$note<br>
      <span id='cmdArea$command->id'>
        <button class='btn btn-info btn-sm cmdRprt' id='cmdRprt$command->id' value='$command->id' >Reporter</button> 
        
        <button class='btn btn-danger btn-sm cmdCncl' id='cancel_btn$command->id' data-id='annule' value='$command->id' >
        
        <span  hidden=\"hidden\" class=\"spinner-border spinner-border-sm \" role=\"status\" aria-hidden=\"true\"></span><span class=\"sr-only\"></span>


        Annuler</button> 
        <button hidden class='btn btn-success btn-sm cmdCncl' id='active_btn$command->id' data-id='encours' value='$command->id' >
          
          <span  hidden=\"hidden\" class=\"spinner-border spinner-border-sm \" role=\"status\" aria-hidden=\"true\"></span><span class=\"sr-only\"></span>

        Activer</button>
        </span>
        
       <span hidden id='cmdRprtButtons$command->id'>
       <label class'form-label'><strong>Reporter la commande</strong></label>
        <input type='date' class='form-control rprtDate$command->id'>
        <input id='assign$command->id' type='checkbox' name='unassigne'> Reinitialiser.
        
         <button id='cmdRprtConfirm$command->id' value='$command->id' data-curCmd='cur".$command->id."'  class='btn btn-info cmdRprtConfirm'  data-singlePayButtons='cmdRprtButtons$command->id'>
          
          <span  hidden=\"hidden\" class=\"spinner-border spinner-border-sm cmdRprtSpinner$command->id\" role=\"status\" aria-hidden=\"true\"></span><span class=\"sr-only\"></span>
         
         Confirmé</button>
         <button value='$command->id'  class='btn btn-danger cmdRprtCancel$command->id cmdRprtCancel'>Annuler</button>
        </span>
       
        </li></ul></div>
       
        
  
      
        ";
     
         
  }}else{
    $display = ["Vous n'avez pas de retour"];
  }


   
   return response()->json(['cmd_rtrn_script'=>$cmd_rtrn_script, 'livreur'=>$livreur->nom,  'total'=>array_sum($total), 'display'=>$display]);                      
  }


public function bulkassign(Request $request)
{
  $validated = $request->validate([
        'assignee' => 'required',
        'ids' => 'required',
    ]);
   
   $ids = explode(",", $request->ids);
  foreach($ids as $id)
  {
    $command = Command::findOrFail($id);
    $command->livreur_id = $request->assignee;
    $command->update();
  }

  return redirect()->back()->with('status', 'Commandes assignées');
}



public function bulkdifusion(Request $request)
{
  $validated = $request->validate([
        
        'ids' => 'required',
         'ramphone'=> 'required',
         'ramadress' =>'required'
    ]);
   
   $fees = Fee::all();
   $ids = $request->ids;
  
    $commands = Command::selectRaw('COUNT(fee_id) nbre, (fee_id) fee_id')
              ->whereIn("id", $ids)
              ->groupBy("fee_id")
           ->get();
    $description = "";
     $description .= count($ids). " Commandes: ";
    foreach($commands as $command)
    {
                   
        foreach($fees as $fee) {
                          if($fee->id == $command->fee_id)
                          {
                            $description .= $fee->destination;
                          }
                        }
                      $description .= $command->nbre;
                    $description .= ". ";
    $command->is_difused = "yes";
    $command->update();
    }
    
  $ramadress = $request->ramadress;
  $ramphone = $request->ramphone;
  $client_id = Auth::user()->client_id;

  $difuse = new Difuse;

  $difuse->description = $description;
  $difuse->client_id = $client_id;
  $difuse->status = "encours";
  $difuse->ram_phone = $ramphone;
  $difuse->ram_adress = $ramadress;

  $difuse->save();
  $id = $difuse->id;

  $share = "<br>
<button id='shareDifuse'><ion-icon name='share-outline'></ion-icon>Partager</button>
  <script >
         
         shareButton3 = document.getElementById('shareDifuse');


shareButton3.addEventListener('click', event => {
  if (navigator.share) {
    navigator.share({
      title:'Diffusion',
      text:'".$description."',url: 'https://client.livreurjibiat.site/difusion/".$id.
    "'}).then(() => {
      console.log('Thanks for sharing!');
    })
    .catch(console.error);
  } else {
    shareDialog.classList.add('is-open');
  }
});
       </script>";

  return response()->json(["description"=>$description, "share"=>$share]);
}



public function bulkassigncmd(Request $request)
{
   $cmd_ids = $request->cmd_ids;
    
  $livreur = Livreur::findOrFail($request->livreur_id);
   $client_id = Auth::user()->client_id;
   
  foreach($cmd_ids as $id)
  {
    $command = Command::findOrFail($id);
    

    $command->livreur_id = $request->livreur_id;
    $command->update();

    $command->update();
    if($command->payment){
      $command->payment->livreur_id = $livreur->id;
      $command->payment->update();
    }
  
 
  

  }

        
     


   
    $commands = Command::where("client_id", $client_id)
                        ->whereBetween("delivery_date", [$request->start, $request->end])
                        ->orderBy('delivery_date', 'desc')
                        ->orderBy('adresse', 'asc')
                        ->with("products")
                        ->with("livreur")
                        ->with("fee")
                        ->with("note")
                        ->get();
    
 
 if($livreur->id == 11){
  $message = "Selection dessagnee";
 }else{
     $message = "Selection dessagnee a " . $livreur->nom;
   }




  return response()->json(['commands'=>$commands, 'message'=>$message]);
}



public function showlivreurs(Request $request){
    $client_id = Auth::user()->client_id;
     $cmd_ids = $request->cmd_ids;
     $fees = Fee::all();
      
      $client = Client::findOrFail($client_id);
  

     $livreurs = $client->livreurs;

     $output = "<div class='transactions'>";

     foreach($livreurs as $livreur)
     {
      $ot_remaining = $livreur->commands->where('etat', '!=', 'termine')->where('etat', '!=', 'annule')->where('delivery_date', today())->count();
      
      $by_zone = Command::where("livreur_id", $livreur->id)->selectRaw('COUNT(fee_id) nbre, (fee_id) fee_id')
     ->where('etat', '!=', 'termine')->where('etat', '!=', 'annule')->where('delivery_date', today())
    ->groupBy('fee_id')
    ->get();

    $output .= "<span  class='item'>
                    <div class='detail'>
                        
                        <img ";

                         if(Storage::disk('s3')->exists($livreur->photo))
                        {$output .= "  src='https://livreurjibiat.s3.eu-west-3.amazonaws.com/$livreur->photo'  class='image-block imaged big' ";}
                         else { $output .= "src='assets/img/sample/brand/1.jpg' alt='img' ";}
                        

  $output .=  "class='image-block imaged'
                    alt='img' width='80'>



                        <div>
                            <strong>$livreur->nom</strong>
                           ";
                  
                         
                        $output .= $ot_remaining ." livraison(s) encours actuellement<br>";

                        foreach($by_zone as $zone)
                          {
                          
                         
                         $output .= "<div class='chip chip-media' style='margin-bottom: 3px'>
                                                  <i class='chip-icon  bg-success '>
                                                      $zone->nbre
                                                  </i>
                                                  <span class='chip-label'>";

                        foreach($fees as $fee)
                          {
                            if($zone->fee_id == $fee->id)
                            {$output .= $fee->destination;}
                        }

                        $output .=   "</span>
                    </div>";
                      }
                   
                         $route = Lesroute::where('livreur_id', $livreur->id)->where('action', "STATUS")->orderBy('created_at', "desc")->first();

                     $output .=   "<br><button  type='button' class='assign btn  btn-primary ml-2' data-ids='".implode(",", $cmd_ids). "' value='".$livreur->id. "' data-nom='".substr($livreur->nom, 0, 10).".' > ".'Assigner'. "  </button><a type='button' style=' font-weight: bold;' href='tel:".$livreur->phone."' class='btn btn-primary phone'>
                       <ion-icon name='call-outline'></ion-icon></a>";

                          if($route)
                    {$output .= "<div class='text-primary'>Dernière Action: ". $route->observation. " ".$route->created_at->format("H:i"). "</div>";}
                    $output .=  " </div>
                    </div>";
                   
                   $output .= "</span> ";
                                        
         
     
     }

     $title = "choisir un livreur";


      $assign_script = "<script>
        $('.assign').click( function() {
  var cmd_ids = $(this).data('ids');
  var command_ids = cmd_ids+'';
  var livreur_id = $(this).val();
  var livreur_nom = $(this).data('nom');

  var current_modal =  $('#LivChoice');
   var cur_livs = command_ids.split(',');
    $.ajax({
      url: 'bulkassigncmd',
      type: 'post',
      data: {_token: CSRF_TOKEN,cmd_ids: cmd_ids,livreur_id: livreur_id},
      success: function(response){
        if(response.livreur_id == 11)
         {alert('Assignation annulée');
               
               (current_modal).modal('hide');
             }
       else
         {
          $('#stateModalBody').html('Commandes assignées à '+livreur_nom+'<br>'+ response.cur_liv+response.sms_btn+response.call_btn);

          
                 (current_modal).modal('hide');
                 for (i = 0; i < cur_livs.length; i++) {
               $('#cur_liv'+cur_livs[i]).html(response.cur_liv);

               $('.cmd_chk').each(function() {
                 this.checked = false;
                });
}

      $('#stateModal').modal('show');
      

      

          
               
             }
             }

             
    });
});  
       </script>
       ";
     $output .= "<div>";
    return response()->json(['output'=>$output,  'title'=>$title, 'assign_script'=>$assign_script]);
     }


public function search(Request $request)
  {
    $search = $request->search;
    $search_command = Command::where('id', $search)
                      ->orWhere('phone', $search)
                      ->limit(10)
                      ->get();

     $result = "";                 
    if(count($search_command)>0) 
    {
       foreach($search_command as $cmd)
       {
        $result .= "<ul><li>". "<strong>". $cmd->id ." $cmd->adresse <br>$cmd->phone</strong><li><ul>";
       }
    }               

  
  return response()->json(['result'=>$result]);
  }


  public function getnote(Request $request)
  {
    $cmd_id = $request->cmdid;
    $cmd = Command::findOrFail($cmd_id);

    $notes = $cmd->note;

     $result = "<ul>";                 
    if(count($notes)>0) 
    {
       foreach($notes->sortByDesc('created_at') as $note)
       {
        $result .= "<li><strong>".
                  $note->updated_at->format('d-m-Y'). "</strong> -". 
                  $note->updated_at->format('H:i:s') ."-".
                   $note->description;
        if($note->description == 'RDV'){ $result .= " donné à ".$note->rdv_time;}
        if($note->livreur != null){
          $result .= ". Par:".$note->livreur;
        }
        $result .= "</li>";
       
    }  
    }else{$result .= "Il n'y a aucune note pour cette commande";}             
    $result .= "</ul>";
  
  return response()->json(['result'=>$result]);
  }



  public function getevent(Request $request)
  {
    $cmd_id = $request->cmdid;
    $cmd = Command::findOrFail($cmd_id);

    $events = $cmd->events;

     $result = "Creer le:".$cmd->created_at->format("d-m-Y"). "<br><ul>";               
    if(count($events)>0) 
    {
       foreach($events->sortByDesc('created_at') as $event)
       {
        $result .= "<li><strong>".
                  $event->updated_at->format('d-m-Y'). "</strong> -". 
                  $event->updated_at->format('H:i:s') ."-".
                   $event->description. ". Par: ".$event->client;
        
        $result .= "</li>";
       
    }  
    }else{$result .= "Il n'y a aucun evenement pour cette commande";}             
    $result .= "</ul>";
  
  return response()->json(['result'=>$result]);
  }






public function commencer(){return view('commencer');}


public function account()
{
  $client_id = Auth::user()->client_id;

  $client = Client::findOrFail($client_id);

  $communes = array("Adjamé", "Cocody", "Attécoubé", "Bingerville", "Anyama", "Koumassi", "Plateau", "Treichville", "Marcory", "Port-Bouet", "Bassam", "Songon", "Abobo", "Yopougon" );

        sort($communes);

  return view('account')->with('client',$client)->with('communes', $communes);
}


// public function account()
// {
//   $client_id = Auth::user()->client_id;

//   $client = Client::findOrFail($client_id);

//   $communes = array("Adjamé", "Cocody", "Attécoubé", "Bingerville", "Anyama", "Koumassi", "Plateau", "Treichville", "Marcory", "Port-Bouet", "Bassam", "Songon", "Abobo", "Yopougon" );

//         sort($communes);

//   return view('account')->with('client',$client)->with('communes', $communes);
// }


public function difusions()
{
  $client = Client::findOrFail(Auth::user()->client_id);
  $difusions = Difuse::where("client_id", $client->id)->orderBy("status", "desc")->get();

  return view("difusions")->with("difusions", $difusions)->with("client", $client);
}


    
public function point(Request $request)
{
  $id = Auth::user()->client_id;
  $client = Client::findOrFail($id);
 
  $title = "Rapport complet";
  $all = "";
 
  $all_fees = Fee::all();
  $sales = Command::where("etat", "termine")->where('client_id', $id);
$sales_by_zone = Command::selectRaw('SUM(montant) montant, (fee_id) fee_id')
                ->where('etat', 'termine')
                ->where('client_id', $id);
                  

  


   $start = date("Y")."-01-01";
   $end = date("Y")."-12-31";


 if($request->start && $request->end)
  {
    
     $start = $request->start;
     $end = $request->end;

     $all = "<a class='btn btn-primary' href='point'>Voir toutes les ventes</a>";
   }   
      


      if($start == $end)
       {
         if($start == date("Y-m-d"))
       {
           $title = "Aujourd'hui";
       }
       elseif($start == date('Y-m-d',strtotime("-1 days")))
       {
          $title = "Hier";
       }else{
         $title =date_create($start)->format("d-m-Y");
       }

        


       }else{
         $title = "Du " .date_create($start)->format("d-m-Y") . " au " .date_create($end)->format("d-m-Y");
       }


        


        $sales = $sales->whereBetween("delivery_date", [$start, $end])->get();
      $sales_by_zone = $sales_by_zone->whereBetween("delivery_date", [$start, $end])->groupBy('fee_id')->orderBy('montant', 'desc')->get();
     
  
  



  
  

 $commands_with_products = Command::with("products")->where("client_id", $id)->whereBetween('delivery_date', [$start, $end])->get();

   $cmd_ids = array();
   $canceled_ids = array(); 
   foreach($commands_with_products as $command){
     if($command->etat == "termine")
      {$cmd_ids[] = "COMMAND_".$command->id;}

  if($command->etat == "annule"){
   $canceled_ids[]  = $command->id;
  }
    }


    $products = Mooving::selectRaw("SUM(qty) qty, (product_id) product_id")
                      ->whereIn('description', $cmd_ids)
                      ->orderBy("qty", "desc")
                      ->groupBy("product_id")
                      ->get();
   
 $canceled_products = Command_product::selectRaw("SUM(qty) qty, (product_id) product_id")
                      ->whereIn('command_id', $canceled_ids)
                      ->orderBy("qty", "desc")
                      ->groupBy("product_id")
                      ->get();

  return view('point')->with('sales', $sales)->with('sales_by_zone', $sales_by_zone)->with('all_fees', $all_fees)->with('client', $client)->with("title", $title)->with("all", $all)->with("products", $products);
}

public function usersales(Request $request){
   $id = Auth::user()->client_id;
  $client = Client::findOrFail($id);
 
  $title = "Rapport complet";
  $all = "";
 
  $all_fees = Fee::all();
  $sales = Command::where("etat", "termine")->where('client_id', $id);
$sales_by_zone = Command::selectRaw('SUM(montant) montant, (fee_id) fee_id')
                ->where('etat', 'termine')
                ->where('client_id', $id);
                  

  


   $start = date_create(date("Y")."-01-01");
   $end = date_create(date("Y")."-12-31");


 if($request->start && $request->end)
  {
    
     $start = $request->start;
     $end = $request->end;

     $all = "<a class='btn btn-primary' href='point'>Voir toutes les ventes</a>";
   }   
      


      if($start == $end)
       {
         if($start == date("Y-m-d"))
       {
           $title = "Aujourd'hui";
       }
       elseif($start == date('Y-m-d',strtotime("-1 days")))
       {
          $title = "Hier";
       }else{
         $title =date_create($start)->format("d-m-Y");
       }

        


       }else{
         $title = "Du " .date_create($start)->format("d-m-Y") . " au " .date_create($end)->format("d-m-Y");
       }


        


        $sales = $sales->whereBetween("delivery_date", [$start, $end])->get();
      $sales_by_zone = $sales_by_zone->whereBetween("delivery_date", [$start, $end])->groupBy('fee_id')->orderBy('montant', 'desc')->get();
     
  
  



  
  

 $commands_with_products = Command::with("products")->whereBetween('delivery_date', [$start, $end])->get();

   $cmd_ids = array();
   $canceled_ids = array(); 
   foreach($commands_with_products as $command){
     if($command->etat == "termine")
      {$cmd_ids[] = "COMMAND_".$command->id;}

  if($command->etat == "annule"){
   $canceled_ids[]  = $command->id;
  }
    }


    $products = Mooving::selectRaw("SUM(qty) qty, (product_id) product_id")
                      ->whereIn('description', $cmd_ids)
                      ->orderBy("qty", "desc")
                      ->groupBy("product_id")
                      ->get();
   
 $canceled_products = Command_product::selectRaw("SUM(qty) qty, (product_id) product_id")
                      ->whereIn('command_id', $canceled_ids)
                      ->orderBy("qty", "desc")
                      ->groupBy("product_id")
                      ->get();

  return view('point')->with('sales', $sales)->with('sales_by_zone', $sales_by_zone)->with('all_fees', $all_fees)->with('client', $client)->with("title", $title)->with("all", $all)->with("products", $products);

}
}






