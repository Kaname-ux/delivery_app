<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Hash;

use App\Client;
use App\Client_fee;
use App\Livreur;
use App\Offer;
use App\Fee;
use App\Command;
use App\Subscription;
use App\Billing_period;
use App\Bill_payment;
use App\Helpers\Sms;
use App\Helpers\LivreurHelper;
use App\Helpers\Billing;
use DB;
use DateTime;
use Auth;
use Illuminate\Support\MessageBag;
use Carbon\Carbon;
use DateInterval;
use DatePeriod;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Builder;
use Geocoder\Laravel\ProviderAndDumperAggregator as Geocoder;
class OffersController extends Controller
{
  public function getstatus(Request $request){
    $id = $request->id;
    $bill = Billing_period::findOrFail($id);

    $billing = new Billing;
     $cost = $billing->getCost($bill->subscription_id, $bill->start, $bill->end);

     $urgent = $billing->getUrgentCost($bill->subscription_id, $bill->start, $bill->end);

     $extra_qty = $billing->getExtraQty($bill->subscription_id, $bill->start, $bill->end);

     $extra_weights = $billing->getExtraWeight($bill->subscription_id, $bill->start, $bill->end);

     $extra_zones = $billing->getExtraZones($bill->subscription_id, $bill->start, $bill->end);

     $taxes = $billing->taxes();
       $total = 0;

     $total += ($cost["cost"]*($taxes+1));

     if($urgent != 0)
        {$total += ($urgent->sum("urgent_cost")*($taxes+1));}
        if($extra_qty != 0)
        {$total +=($extra_qty->sum("urgent_cost+client_livraison")*($taxes+1));}

         if($extra_weights->count())

      {$total += ($extra_weights->sum("extraw_cost")*($taxes+1));}

        if($extra_zones != 0)
        {$total += ($extra_zones->sum("client_livraison")*($taxes+1));}
     $status = "";
     $payment = "";
    if(date_create($bill->issue_date)->format("Y-m-d") < date("Y-m-d")){
       $status .= "Non emis.";
    }

    if(date_create($bill->issue_date)->format("Y-m-d") >= date("Y-m-d")){
      $status .= "Encours. ";
    }

    if(date_create($bill->expiration)->format("Y-m-d") < date("Y-m-d")){
      $status .= "Expiré.";
    }

    if($bill->payments->count() == 0 ){
       $payment = "Non payé"; 
    }

    if($bill->payments->sum("montant") >= $total ){
       $payment = "Payé"; 
    }
    if($bill->payments->sum("montant") > 0 &&  $bill->payments->sum("montant") < $total){
       $payment = "Payment partiel"; 
    }

    return response()->json(["status"=>$status, "payment"=>$payment, 'payed'=>$bill->payments->sum("montant"), ]);
  }


public function deletesubscription(Request $request){
    


    $id = $request->id;

    $subscription = Subscription::findOrFail($id);

    if($subscription->commands->count() > 0)
    {$subscription->commands()->delete();}

    if($subscription->periods->count() > 0)
    {   
        foreach($subscription->periods as $period){
            if($period->payments->count() > 0){
                $period->payments()->delete();
            }
        }
        $subscription->periods()->delete();
    }

    $subscription->delete();

    return redirect()->back()->with("status", "Abonnement supprimé");
}
 public function addbillpay(Request $request){
   $validatedData = $request->validate([
        'id' => 'required', 
        'subs_id' => 'required',
        'montant' => 'required',
        'pay_date' => 'required',
        'ref' => 'required',
        'pay_method' => 'required',
           
    ]);
   
 $payment = new Bill_payment;
 $payment->pay_date = $request->pay_date;
 $payment->billing_period_id = $request->id;
 $payment->montant = $request->montant;
 $payment->pay_ref = $request->ref;
 $payment->pay_method = $request->pay_method;
 $payment->subscription_id = $request->subs_id;
 $payment->save();

 return redirect()->back()->with("paysuccess", "Paiement enregistré");

 }  


 public function editbillpay(Request $request){
   $validatedData = $request->validate([
        'pay_id' => 'required',
        'id' => 'required', 
        'subs_id' => 'required',
        'montant' => 'required',
        'pay_date' => 'required',
        'ref' => 'required',
        'pay_method' => 'required',
           
    ]);
   
 $payment = Bill_payment::findOrFail($request->pay_id);
 $payment->pay_date = $request->pay_date;
 $payment->billing_period_id = $request->id;
 $payment->montant = $request->montant;
 $payment->pay_ref = $request->ref;
 $payment->pay_method = $request->pay_method;
 $payment->subscription_id = $request->subs_id;
 $payment->save();

 return redirect()->back()->with("paysuccess", "Paiement Modifier");

 }  

 public function deletebillpay(Request $request){
    $payment = Bill_payment::findOrFail($request->id);
    $payment->delete();

    return redirect()->back()->with("paysuccess", "Paiement Supprimé");
 }

 public function issuedate(Request $request){
    $payment = Billing_period::findOrFail($request->id);
    $payment->issue_date = $request->issue_date;
    $payment->update();

    return redirect()->back()->with("issuesuccess", "Date modifiée");
 }
  
  public function setbill(Request $request){

     $validatedData = $request->validate([
        'id' => 'required',
            'billed_at' => 'required',
           
    ]);
    $bill = Subscription::findOrFail($request->id);
    $bill->billed_at = $request->bill_date;

    $bill->update();

    return redirect()->back()->with("status", "Facture arrêtée le");
  }



   public function billing(Request $request){
    $start = $request->start;
     $end = $request->end;
     $id = $request->id;
     $period_id = $request->period_id;
     

     $subscription = Subscription::findOrFail($id);
     $period = Billing_period::findOrFail($period_id);
     $client_id = $subscription->client_id;
     $client = Client::findOrFail($client_id);

     $billing = new Billing;
     $cost = $billing->getCost($id, $start, $end);
     $urgent = $billing->getUrgentCost($id, $start, $end);
     $extra_qty = $billing->getExtraQty($id, $start, $end);
     $extra_weights = $billing->getExtraWeight($id, $start, $end);

     $extra_zones = $billing->getExtraZones($id, $start, $end);

     $taxes = $billing->taxes();
     
     
    return view("billing")->with("cost",$cost)->with("extra_weights",$extra_weights)->with("extra_zones",$extra_zones)->with("subscription", $subscription)->with("client", $client)->with("period", $period)->with("start", $start)->with("end", $end)->with("taxes", $taxes)->with("billing", $billing)->with("urgent", $urgent)->with("extra_qty", $extra_qty);

  }


  public function bill(Request $request){
    $offer = Subscription::findOrFail($request->id);


    $client = Client::findOrFail($offer->client_id);

    $fees = $client->fees;

    $cost = 0;
    $extra = 0;
    $extra_cost = 0;
    $extra_details = "";

     $start = date_create($offer->start);
     $end = date_create($offer->end);
    $selectedend = date_create($request->billdate);

    $globalinterval = $start->diff($end);
    $interval = $start->diff($selectedend);

    if($offer->commands()->whereBetween("delivery_date", [$offer->start, $request->billdate])->count() > $offer->qty){
        $extra = $offer->commands()->whereBetween("delivery_date", [$offer->start, $request->billdate])->count()-$offer->qty;
        $extra_commands = Command::orderBy("id", "asc")->whereBetween("delivery_date", [$offer->start, $request->billdate])->offset($offer->qty)->limit($offer->commands()->count()+$extra)->where("subscription_id", $offer->id)->get(); 
      foreach($extra_commands as $command){
        $extra_details .= "[". $command->delivery_date->format("d-m-Y"). ": ".$command->client_destination. " ". $command->client_livraison. "]";

        $extra_cost += $command->client_livraison;

      }
    }
    

    $done = $offer->commands()->whereBetween("delivery_date", [$offer->start, $request->billdate])->get();

    if($offer->subscription_type == "MAD")
     { 
        if($interval->days < $globalinterval->days)
        {$cost = ((($offer->livreurs()->count()*$offer->cost)/$globalinterval->days)*$interval->days)+$extra_cost;}
    else{
        $cost = ($offer->livreurs()->count()*$offer->cost)+$extra_cost;
    }
    }
        


        if($offer->subscription_type == "DISTRIBUTION")
     { if($interval->days < $globalinterval->days)
        {$cost = (($offer->cost/$globalinterval->days)*$interval->days)+$extra_cost;}
    else{
        $cost = $offer->cost+$extra_cost;
    }}
        
       

    return view("bill")->with("offer", $offer)->with("client", $client)->with("extra_details", $extra_details)->with("extra_cost", $extra_cost)->with("extra", $extra)->with("cost", $cost)->with("interval", $interval)->with("globalinterval", $globalinterval);
  }



  public function bulkbill(Request $request){
    
    $offers = array();

    

    foreach($request->ids as $id)
    {
        $cost = 0;
    $extra = 0;
    $extra_cost = 0;
    $extra_details = "";
$offer = Subscription::findOrFail($id);


    $client = Client::findOrFail($offer->client_id); 

        $start = date_create($offer->start);
     $end = date_create($offer->end);
    $selectedend = date_create($request->billdate);

    $globalinterval = $start->diff($end);
    $interval = $start->diff($selectedend);

    if($offer->commands()->whereBetween("delivery_date", [$offer->start, $request->billdate])->count() > $offer->qty){
        $extra = $offer->commands()->whereBetween("delivery_date", [$offer->start, $request->billdate])->count()-$offer->qty;
        $extra_commands = Command::orderBy("id", "asc")->whereBetween("delivery_date", [$offer->start, $request->billdate])->offset($offer->qty)->limit($offer->commands()->count()+$extra)->where("subscription_id", $offer->id)->get(); 
      foreach($extra_commands as $command){
        $extra_details .= "[". $command->delivery_date->format("d-m-Y"). ": ".$command->client_destination. " ". $command->client_livraison. "]";

        $extra_cost += $command->client_livraison;

      }
    }
    

    $done = $offer->commands()->whereBetween("delivery_date", [$offer->start, $request->billdate])->get();

    if($offer->subscription_type == "MAD")
     { 
        if($interval->days < $globalinterval->days)
        {$cost = ((($offer->livreurs()->count()*$offer->cost)/$globalinterval->days)*$interval->days)+$extra_cost;}
    else{
        $cost = ($offer->livreurs()->count()*$offer->cost)+$extra_cost;
    }
    }
        


        if($offer->subscription_type == "DISTRIBUTION")
     { if($interval->days < $globalinterval->days)
        {$cost = (($offer->cost/$globalinterval->days)*$interval->days)+$extra_cost;}
    else{
        $cost = $offer->cost+$extra_cost;
    }
   }

   $offers[] = ["id"=>$offer->id, "subscription_type"=>$offer->subscription_type, "cost"=>$cost, "extrac"=>$extra_cost, "description"=>$offer->description, "livreurs"=>$offer->livreurs()->count(), "qty"=>$offer->qty, "commands"=>$offer->commands()->count(), "extra"=>$extra, "extrad"=>$extra_details, "interval"=>$interval->days, "globalinterval"=>$globalinterval->days, "client"=>$client, "globalcost"=>$offer->cost];
    }

    return view("bulkbill")->with("offers", $offers);
  }
   public function getsubscriptions(Request $request){
    $id = $request->id;

    $subscriptions = Subscription::where("client_id", $id)->where("end", ">=", today())->with("commands")->get();

    return response()->json(["subscriptions"=>$subscriptions]);
   }


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


     public function userupdate(Request $request)
    {
       $user = User::find($request->id);
       $user->name = $request->input('username');
       $user->usertype = $request->input('usertype');
       $user->update();

       return redirect('/role-register')->with('status', "Modification enregistrée");

    }


    public function setreliability(Request $request)
    {
       $id = $request->id;
       $livreur = Livreur::find($id);
       $livreur->jibiat_reliability = $request->note;
      
       $livreur->update();

       return redirect()->back()->with('status', "Enregistrée");

    }


    public function userform()
    {
        

        return view('userregister');

    }


    public function etiquettes()
    {
        

        return view('etiquettes');

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




    protected function updateuser(Request $request)
    {
        

        $validatedData = $request->validate([
            'email' => 'required| string| email| max:255, unique:users',
            'password' => 'required| string| min:8| confirmed',
    ]);


     $user = User::findOrFail($request->id);

      $user->update([
            
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
        ]);

      return redirect()->back()->with('status', "Compte Utilisateur Modifié");
    

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
         
        function validateDate($date, $format = 'Y-m-d'){
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) === $date;}
    $filteredlivreurs = array();
    $filteredfees = array();
    $ref_date = validateDate("2020-11-10", 'Y-m-d');
    $filter = "";
    
      $encours_states = array("encours", "en chemin", "recupere");
      $phone_check = NULL;
     
      $clients = Client::get();
      $livreurs =Livreur::where('status', 'active')->get();
      $state = "all";
      $attente ="";
      $active_liv_ids = array();
     $products = Product::get();
     $stocks = array();
    foreach($products as $product){
        if($product->moovings->count() > 0){

            $product->stock = $product->moovings->where("type", "IN")->sum("qty") - $product->moovings->where("type", "OUT")->sum("qty");
            $product->update();
          $stocks[] = [$product->id, $product->moovings->where("type", "IN")->sum("qty") - $product->moovings->where("type", "OUT")->sum("qty")];
        }
    }
      
      foreach ($livreurs as $key => $livreur) {
        $active_liv_ids[] = $livreur->id;
      }

      $payments_by_livreurs = Payment::orderBy('created_at', 'desc')
      ->selectRaw('SUM(montant) montant, (livreur_id) livreur_id')
    
     ->where('etat', 'en attente')
      ->where('montant', '>', 0)
     ->whereIn('livreur_id', $active_liv_ids)
    ->groupBy('livreur_id')
    ->get();


     $upcomings = Command::selectRaw('SUM(montant) montant, (delivery_date) delivery_date')
    
     ->where('delivery_date','>', (today()))
    ->groupBy('delivery_date')
    ->get();


    $upcomings_count = Command::selectRaw('COUNT(montant) nbre, (delivery_date) delivery_date')
    
     ->where('delivery_date','>', (today()))
    ->groupBy('delivery_date')
    ->get();

    $undone_by_livreurs = Command::orderBy('updated_at', 'desc')
      
   
     ->where('etat', '!=', 'termine')
     ->where('etat', '!=', 'annule')
     ->where('etat', '!=', 'encours')
    ->whereDate('delivery_date', '>=', "2020-11-10")
     ->whereIn('livreur_id', $active_liv_ids)
    
    ->get();


      $day = "Aujourd'hui";   
      
      $current_date = date('Y-m-d');

      $start = "";
      $end = "";

 if($request->start && $request->end )
      {

         $start = $request->start;
         $end = $request->end;

       
        $current_date = $day;
      $commands = Command::orderBy('delivery_date', 'desc')

                  ->whereBetween("delivery_date", [$start, $end]);
                 
                  

      $cmds_by_city = Command::selectRaw('COUNT(id) nbre, (fee_id) fee_id')
                              ->whereBetween("delivery_date", [$start, $end])
                             ;

      $cmds_by_livreur = Command::selectRaw('COUNT(id) nbre, (livreur_id) livreur_id')
                              ->whereBetween("delivery_date", [$start, $end])
                            ;                       

      $all_commands = Command::whereBetween("delivery_date", [$start, $end])
               
                
                 ->get();
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
        
      }else{
        

      $commands = Command::orderBy('delivery_date', 'desc')
                  
                  ->whereDate('delivery_date', today());
                  
    $cmds_by_city = Command::selectRaw('COUNT(id) nbre, (fee_id) fee_id')
                             ->whereDate('delivery_date', today())
                             ;


    $cmds_by_livreur = Command::selectRaw('COUNT(id) nbre, (livreur_id) livreur_id')
                             ->whereDate('delivery_date', today())
                             ;                         


                  $all_commands = Command::whereDate('delivery_date', today())
                 
                  ->get();
}
     
      $cmds = $commands->with("products")->with("payment")->with("note")->with("livreur")->orderBy('adresse', 'asc')->get();                                      
     
    if($request->state && $request->state != 'all')
    {

      $state = $request->state;
      if($state == "dlvm"){
        $commands = $commands->whereIn('etat', ["recupere", "en chemin"])->where("livreur_id", "!=", 11);
       $cmds_by_city = $cmds_by_city->whereIn('etat', ["recupere", "en chemin"])->where("livreur_id", "!=", 11);

       $cmds_by_livreur = $cmds_by_livreur->whereIn('etat', ["recupere", "en chemin"])->where("livreur_id", "!=", 11);
      }
      elseif($state == "unassigned"){
        $commands = $commands->where('etat', "!=", "annule")->where("livreur_id", 11);
       $cmds_by_city = $cmds_by_city->where('etat', "!=", "annule")->where("livreur_id", 11);

       $cmds_by_livreur = $cmds_by_livreur->where('etat', "!=", "annule")->where("livreur_id", 11);
      }

      elseif($state == "assigned"){
        $commands = $commands->where('etat', "encours")->where("livreur_id", "!=", 11);
       $cmds_by_city = $cmds_by_city->where('etat', "encours")->where("livreur_id", "!=", 11);

       $cmds_by_livreur = $cmds_by_livreur->where('etat', "encours")->where("livreur_id", "!=", 11);
      }
    else
      {
      $commands = $commands->where('etat', $state);
      $cmds_by_city = $cmds_by_city->where('etat', $state);
      $cmds_by_livreur = $cmds_by_livreur->where('etat', $state);
      }
    }

   if($request->fees || $request->livreurs || $request->sources || $request->clients){
    if(!empty($request->fees)){
      $filteredfees = $request->fees;
      $filter .=  "<div>Filtre communes: ";
      $commands = $commands->whereIn('fee_id', $request->fees);
      $cmds_by_city = $cmds_by_city->whereIn('fee_id', $request->fees);
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
      $cmds_by_city = $cmds_by_city->whereIn('livreur_id', $request->livreurs);
      $cmds_by_livreur = $cmds_by_livreur->whereIn('livreur_id', $request->livreurs);
      foreach($request->livreurs as $livreur){
        $filredlivreur = Livreur::findOrFail($livreur);

        $filter .= "<strong class='text-dark'>". $filredlivreur->nom. "</strong>. ";  
      }
      $filter .=  "</div>";
    }


     if(!empty($request->sources)){
      $filteredsources = $request->sources;
      $filter .=  "<div>Filtre canaux: ";
      $commands = $commands->whereIn('canal', $request->sources);
      $cmds_by_city = $cmds_by_city->whereIn('canal', $request->sources);
      $cmds_by_livreur = $cmds_by_livreur->whereIn('canal', $request->sources);
      foreach($request->sources as $source){
        

        $filter .= "<strong class='text-dark'>". $source. "</strong>. ";  
      }

   
    $filter .=  "</div>";
   }


       if(!empty($request->clients)){
      
      $filter .=  "<div>Filtre utilisateur: ";
      $commands = $commands->whereIn('client_id', $request->clients);
      $cmds_by_city = $cmds_by_city->whereIn('client_id', $request->clients);
      $cmds_by_livreur = $cmds_by_livreur->whereIn('client_id', $request->clients);
      foreach($request->clients as $client){
        $filteredclient = Client::findOrFail($client);

        $filter .= "<strong class='text-dark'>". $filteredclient->nom. "</strong>. ";  
      }
      $filter .=  "</div>";
    }
 }   


     $total =  $commands->get()->sum('montant');
     $nbre = $commands->get()->count('montant');
     
     $cmds = $commands->with("products")->orderBy('adresse', 'asc')->get();
      $commands = $commands->orderBy('adresse', 'asc')->paginate(50);
       
       $cmds_by_city =  $cmds_by_city->groupBy('fee_id')->get();
       $cmds_by_livreur =  $cmds_by_livreur
                         ->where('livreur_id','!=', 11)
                       ->groupBy('livreur_id')->get();
      
                 
       
      $fees = Fee::where('category', 1)->orderBy('destination', 'asc')->get();

      $final_destinations = array();
      foreach ($cmds_by_city as $value) {
                 
                   foreach ($fees as $fee) {
                     if($fee->id == $value->fee_id){
                      $final_destinations[$fee->destination] = $value->nbre;
                     }
                   }
                    
                   
                  
                 } 
      $chk = 4;
      $certifications = Certification::where("status", "pending")->get();
     $sources = Source::get();
        return view('dashboard')->with("filter", $filter)->with("sources", $sources)->with('commands', $commands)->with('day', $day)->with('fees', $fees)->with('total', $total)->with("phone_check", $phone_check)->with('livreurs', $livreurs)->with('all_commands', $all_commands)->with('payments_by_livreurs', $payments_by_livreurs)->with('detail', 'tout')->with('encours_states', $encours_states)->with('nbre', $nbre)->with('state', $state)->with('attente', $attente)->with('undone_by_livreurs', $undone_by_livreurs)->with('cmds_by_city', $cmds_by_city)->with('cmds_by_livreur', $cmds_by_livreur)->with('current_date', $current_date)->with('chk', $chk)->with('final_destinations', $final_destinations)->with('upcomings', $upcomings)->with('upcomings_count', $upcomings_count)->with('certifications', $certifications)->with("start", $start)->with("end", $end)->with("cmds", $cmds->toJson())->with("products", $products->toJson())->with("filteredfees", $filteredfees)->with("filteredlivreurs", $filteredlivreurs)->with("clients", $clients)->with("products", $products);

    }


    public function commandfastregister(Request $request)
    {



      $client_id = $request->client;
        $delivery_date = $request->input('delivery_date');
        $phone = str_replace(' ', '',$request->input('phone'));
        $fee_id = $request->input('fee');
        $adresse = substr($request->input('adresse'),0,150);
        $observation = substr($request->input('observation'),0,150);
        
        
        $other_livraison = $request->input('other_liv');

        if($request->fee)
        {$actual_fee = Fee::find($request->input('fee'));}

        $goods_type = "colis";
        if($request->type)
         {$goods_type = substr($request->type,0,1000);}


        if($request->managerfee)
        {$actual_fee = Manager_fee::findOrFail($request->input('fee'));}
       
        
        $montant = preg_replace('/[^0-9]/', '', $request->input('montant'));
         if(!is_numeric($montant)){$montant = 0;}

        $costumer = substr($request->costumer,0,150);
        $remise = preg_replace('/[^0-9]/', '', $request->remise);
        $source =  $request->source;
        if(!is_numeric($remise)){$remise = 0;}
         
       

       $command_adress = $actual_fee->destination . ":".$adresse;
      


     
       

      $name = Auth::user()->name;
      $model = new Command;
       

       $model->description = $goods_type;
       $model->montant = $montant;
       $model->delivery_date = $delivery_date;
       $model->adresse = $command_adress;
       
       $model->client_id = $client_id;
       $model->phone = $phone;
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

        $goods_type .= $data[1]. " ".$prod->name. " ";
        $model->products()->attach($data[0], ['qty' => $data[1], 'price' =>$prod->price]);
        
        $montant[] = $prod->price*$data[1];

        }



        $model->description = $goods_type;
        $model->montant = array_sum($montant);

        $model->update();
       }


    


      

       
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
        
           
      

$montant = preg_replace('/[^0-9]/', '', $request->input('montant'));
     if(!is_numeric($montant)){$montant = 0;}

     $costumer = substr($request->costumer,0,150);
        $remise = preg_replace('/[^0-9]/', '', $request->remise);
        $source =  $request->source;
        if(!is_numeric($remise)){$remise = 0;}

      $model = Command::findOrFail($request->input('command_id'));
       $actual_fee = Fee::findOrFail($request->input('fee'));

       
      $client_id = $request->client;
       
       
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
       
      $request->validate( [
            'name' => ['required', 'string', 'max:50'],
            'city' => ['required', 'string'],
            'adresse' => ['required', 'string', 'max:100'],
            
            'phone' => ['required', 'string', 'max:10', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'max:20', 'confirmed'],
        ]);

       

       $client = new Client;

            $user = new User;

            $user->name = $request->name;
            $user->phone = $request->phone;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->usertype = 'client';
           
            $user->approved  = 'yes';
            $user->category  = 1 ;
            
      if($request->type != "CLIENT")
     {$client->client_type = $request->type;}
      $client->nom = $request->name;
     $client->phone = $request->phone;
     
     $client->city = $request->city;
     $client->adresse = $request->adresse;
          

    $user->save(); 
    $client->save();


      $user->client_id = $client->id;
      $client->user_id = $user->id; 

      $user->save();
      $client->save();
    
   return redirect()->back()->with('status', "Utilisateur Ajouté");

    }


    public function clientaccount(Request $request)
    {
       
      $request->validate( [
            
            
          
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'max:20', 'confirmed'],
        ]);

       

       $client = Client::findOrFail($request->id);

            $user = new User;

            $user->name = $client->nom;
            $user->phone = $client->phone;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->usertype = 'client';
           
            $user->approved  = 'yes';
            $user->category  = 1 ;
            
      
          

    $user->save(); 
    $client->update();


      $user->client_id = $client->id;
      $client->user_id = $user->id; 

      $user->update();
      $client->update();
    
   return redirect()->back()->with('status', "Compte créé");

    }


    public function clientlist()
    {
        
       
       $clients = Command::selectRaw('SUM(montant) montant, (phone) phone, (adresse) adresse, (nom_client) nom_client')

    ->groupBy(['phone', 'adresse', 'nom_client'])
    ->get(); 
          
       
         
        
        return view('client')->with('clients', $clients);

    }

     public function clients()
    {
        
       
       $clients = Command::selectRaw('SUM(montant) montant, (phone) phone, (adresse) adresse, (nom_client) nom_client')

    ->groupBy(['phone', 'adresse', 'nom_client'])
    ->get(); 
          
       $fees = Fee::get();
         
        
        return view('clients')->with('clients', $clients)->with("fees", $fees);

    }


   



     public function salesmen()
    {
        
       $clients = Client::salesmen()->paginate(50);
          $available_accounts = User::where('usertype', NULL)->get();
      

        $active_commands = Command::selectRaw('SUM(montant) montant, (client_id) client_id')
    ->where('delivery_date', today())
    ->where('etat', 'termine')
    ->groupBy('client_id')
    ->get(); 
       
         
        
        return view('salesmen')->with('clients', $clients)->with('available_accounts', $available_accounts)->with('active_commands', $active_commands);

    }




     public function vendeurs(Request $request)
    {
        
      $vendeurs = Command::where("phone", "!=", null)->where("phone", "!=", "00000000")->where("phone", "!=", " 
99999999")->where("fee_id", "!=", null)->where("phone", "!=", "0000000")->where("phone", "!=", "000000")->where("phone", "!=", "0")->where("phone", "!=", "00")->where("phone", "!=", "000");
  
  if($request->fee)
    { $vendeurs = $vendeurs->where("fee_id", $request->fee); }

  $vendeurs = $vendeurs->distinct()->get(['phone']);

     

      


      $orange = array('07', '08', '09', '47', '48', '49', '57', '58', '59', '67', '68', '69', '77', '78', '79', '87', '88', '89', '97');

   $mtn = array('04', '05', '06', '44', '45', '46', '54', '55', '56', '64', '65', '66', '74', '75', '76', '84', '85', '86');


   $moov = array('01', '02', '03', '41', '42', '43', '51', '52', '53', '61', '62', '63', '71', '72', '73', '81', '82', '83', '97');
    foreach($vendeurs as $vendeur)
    {
      

      

       if(strlen(preg_replace('/[^0-9]/', '', $vendeur->phone)) == 8)
     { 
        foreach($orange as $or){ 
          if(substr(preg_replace('/[^0-9]/', '', $vendeur->phone), 0,-6) == $or)
          {

            $vendeur->phone = '07'.preg_replace('/[^0-9]/', '', $vendeur->phone);
            $vendeur->update();
          }
        }
        foreach($mtn as $mt){
          if(substr(preg_replace('/[^0-9]/', '', $vendeur->phone), 0,-6) == $mt)
          {
           $vendeur->phone = '05'.preg_replace('/[^0-9]/', '', $vendeur->phone);
           $vendeur->update();
          }
        }
        foreach($moov as $mv){
          if(substr(preg_replace('/[^0-9]/', '', $vendeur->phone), 0,-6) == $mv)
          {
           $vendeur->phone = '01'.preg_replace('/[^0-9]/', '', $vendeur->phone);
           $vendeur->update();
          }
        } 

      }
    
    }   


    $fees = Fee::where("category", 1)->get();
         
        
        return view('vendeurs')->with('vendeurs', $vendeurs)->with("fees", $fees);

    }


    public function clientdetail(Request $request, $id)
    {  
      
     function validateDate($date, $format = 'Y-m-d'){
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) === $date;}
    $filteredlivreurs = array();
    $filteredfees = array();
    $ref_date = validateDate("2020-11-10", 'Y-m-d');
    $filter = "";
    
      $encours_states = array("encours", "en chemin", "recupere");
      $phone_check = NULL;
     
      $client = Client::findOrFail($id);
      $livreurs =Livreur::where('status', 'active')->get();
      $state = "all";
      $attente ="";
      $active_liv_ids = array();
     $products = Product::get();
     $stocks = array();
    foreach($products as $product){
        if($product->moovings->count() > 0){

            $product->stock = $product->moovings->where("type", "IN")->sum("qty") - $product->moovings->where("type", "OUT")->sum("qty");
            $product->update();
          $stocks[] = [$product->id, $product->moovings->where("type", "IN")->sum("qty") - $product->moovings->where("type", "OUT")->sum("qty")];
        }
    }
      
      foreach ($livreurs as $key => $livreur) {
        $active_liv_ids[] = $livreur->id;
      }

      $payments_by_livreurs = Payment::orderBy('created_at', 'desc')
      ->selectRaw('SUM(montant) montant, (livreur_id) livreur_id')
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
     ->where('client_id', $id)
     ->where('delivery_date','>', (today()))
    ->groupBy('delivery_date')
    ->get();

    $undone_by_livreurs = Command::orderBy('updated_at', 'desc')
      
     ->where('client_id', $id)
     ->where('etat', '!=', 'termine')
     ->where('etat', '!=', 'annule')
     ->where('etat', '!=', 'encours')
    ->whereDate('delivery_date', '>=', "2020-11-10")
     ->whereIn('livreur_id', $active_liv_ids)
    
    ->get();


      $day = "Aujourd'hui";   
      
      $current_date = date('Y-m-d');

      $start = "";
      $end = "";

 if($request->start && $request->end )
      {

         $start = $request->start;
         $end = $request->end;

       
        $current_date = $day;
      $commands = Command::orderBy('delivery_date', 'desc')

                  ->whereBetween("delivery_date", [$start, $end])
                  ->where('client_id', $id);
                  

      $cmds_by_city = Command::selectRaw('COUNT(id) nbre, (fee_id) fee_id')
                              ->whereBetween("delivery_date", [$start, $end])
                             ->where('client_id', $id);

      $cmds_by_livreur = Command::selectRaw('COUNT(id) nbre, (livreur_id) livreur_id')
                              ->whereBetween("delivery_date", [$start, $end])
                             ->where('client_id', $id);                       

      $all_commands = Command::whereBetween("delivery_date", [$start, $end])
                ->where('client_id', $id)
                
                 ->get();
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


                  $all_commands = Command::where('client_id', $id)
                  ->whereDate('delivery_date', today())
                 
                  ->get();
}
     
      $cmds = $commands->with("products")->with("payment")->with("note")->with("livreur")->orderBy('adresse', 'asc')->get();                                      
     
    if($request->state && $request->state != 'all')
    {

      $state = $request->state;
      if($state == "dlvm"){
        $commands = $commands->whereIn('etat', ["recupere", "en chemin"])->where("livreur_id", "!=", 11);
       $cmds_by_city = $cmds_by_city->whereIn('etat', ["recupere", "en chemin"])->where("livreur_id", "!=", 11);

       $cmds_by_livreur = $cmds_by_livreur->whereIn('etat', ["recupere", "en chemin"])->where("livreur_id", "!=", 11);
      }
      elseif($state == "unassigned"){
        $commands = $commands->where('etat', "!=", "annule")->where("livreur_id", 11);
       $cmds_by_city = $cmds_by_city->where('etat', "!=", "annule")->where("livreur_id", 11);

       $cmds_by_livreur = $cmds_by_livreur->where('etat', "!=", "annule")->where("livreur_id", 11);
      }

      elseif($state == "assigned"){
        $commands = $commands->where('etat', "encours")->where("livreur_id", "!=", 11);
       $cmds_by_city = $cmds_by_city->where('etat', "encours")->where("livreur_id", "!=", 11);

       $cmds_by_livreur = $cmds_by_livreur->where('etat', "encours")->where("livreur_id", "!=", 11);
      }
    else
      {
      $commands = $commands->where('etat', $state);
      $cmds_by_city = $cmds_by_city->where('etat', $state);
      $cmds_by_livreur = $cmds_by_livreur->where('etat', $state);
      }
    }

   if($request->fees || $request->livreurs || $request->sources){
    if(!empty($request->fees)){
      $filteredfees = $request->fees;
      $filter .=  "<div>Filtre communes: ";
      $commands = $commands->whereIn('fee_id', $request->fees);
      $cmds_by_city = $cmds_by_city->whereIn('fee_id', $request->fees);
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
      $cmds_by_city = $cmds_by_city->whereIn('livreur_id', $request->livreurs);
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
      $cmds_by_city = $cmds_by_city->whereIn('canal', $request->sources);
      $cmds_by_livreur = $cmds_by_livreur->whereIn('canal', $request->sources);
      foreach($request->sources as $source){
        

        $filter .= "<strong class='text-dark'>". $source. "</strong>. ";  
      }
      $filter .=  "</div>";
    }
    $filter .=  "</div>";
   }
    


     $total =  $commands->get()->sum('montant');
     $nbre = $commands->get()->count('montant');
     
     $cmds = $commands->with("products")->orderBy('adresse', 'asc')->get();
      $commands = $commands->orderBy('adresse', 'asc')->paginate(50);
       
       $cmds_by_city =  $cmds_by_city->groupBy('fee_id')->get();
       $cmds_by_livreur =  $cmds_by_livreur
                         ->where('livreur_id','!=', 11)
                       ->groupBy('livreur_id')->get();
      
                 
       
      $fees = Fee::where('category', Auth::user()->category)->orderBy('destination', 'asc')->get();

      $final_destinations = array();
      foreach ($cmds_by_city as $value) {
                 
                   foreach ($fees as $fee) {
                     if($fee->id == $value->fee_id){
                      $final_destinations[$fee->destination] = $value->nbre;
                     }
                   }
                    
                   
                  
                 } 
      $chk = 4;
      $certifications = Certification::where("status", "pending")->get();
     $sources = Source::get();
        return view('clientdetails')->with("filter", $filter)->with("sources", $sources)->with('commands', $commands)->with('day', $day)->with('client', $client)->with('fees', $fees)->with('total', $total)->with("phone_check", $phone_check)->with('livreurs', $livreurs)->with('id', $id)->with('all_commands', $all_commands)->with('payments_by_livreurs', $payments_by_livreurs)->with('detail', 'tout')->with('encours_states', $encours_states)->with('nbre', $nbre)->with('state', $state)->with('attente', $attente)->with('undone_by_livreurs', $undone_by_livreurs)->with('cmds_by_city', $cmds_by_city)->with('cmds_by_livreur', $cmds_by_livreur)->with('current_date', $current_date)->with('chk', $chk)->with('final_destinations', $final_destinations)->with('upcomings', $upcomings)->with('upcomings_count', $upcomings_count)->with('certifications', $certifications)->with("start", $start)->with("end", $end)->with("cmds", $cmds->toJson())->with("clt", $client->toJson())->with("products", $products->toJson())->with("filteredfees", $filteredfees)->with("filteredlivreurs", $filteredlivreurs);

           
    }

     public function clientform()
    {
    
        $usertypes = User_type::get();
        return view('clientregister')->with("usertypes", $usertypes);

    }

     
     public function clientedit($id)
    {
       $client = Client::findOrFail($id);
       
       $types = User_type::get();
       return view('clientedit')->with('client', $client)->with('types', $types);
    }


    public function clientupdate(Request $request, $id)
    {
        
        $model = Client::findOrFail($id);
       $model->nom = $request->input('name');
       $model->phone = $request->input('phone');
       $model->adresse = $request->input('adresse');
       $model->city = $request->city;
       $model->client_type = $request->type;


       $model->update();


       return redirect()->back()->with('status', "Utilisateur modifié");
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

       return redirect()->back()->with('status', "Compte associé");
       
    }



    public function unsetclientaccount($id)
    {
       $model = User::findOrFail($id);
       
       $model->usertype = NULL;
       $model->client_id = NULL;

       $model->save();

       return redirect()->back()->with('status', "Compte dissocié");
       
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
      $livreurs = Livreur::all();  

      $last_action = Lesroute::where('livreur_id', $id)->orderBy('action_date','desc')->limit(1)->get();        
      

      $etats = array('encours', 'annule', 'termine', 'en chemin', 'recupere');


      $clients = Client::orderBy('nom', 'asc')->get();
      
      $fees = Fee::orderBy('destination', 'asc')->get();
     
     $sources = Source::get();

     $products = Product::get();
        
        return view('laroutes')->with('commands', $commands)->with('etats', $etats)->with('livreurs', $livreurs)->with('livreur', $livreur)->with('done', $done)->with('cancel', $cancel)->with('day', $day)->with('wme',$livreur->wme)->with('done_montant', $done_montant)->with('done_livraison',$done_livraison)->with('last_action', $last_action)->with('clients', $clients)->with('fees', $fees)->with('actions', $actions)->with('payments', $payments)->with('payment_sum', $payment_sum)->with('notes', $notes)->with("sources", $sources)->with("products", $products);
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
       $request->validate([
        'destination' => 'required|max:100',
        'price' => 'required|numeric'
        ]);


       $fee = new Fee;
       
       $fee->destination = $request->input('destination');
       $fee->price = $request->input('price');
       $fee->extraprice = $request->input('extraprice');
       $fee->category = 1;
       $fee->zone = $request->input('zone');
        $fee->saved_by = Auth::user()->client->nom;
       $fee->save();


       return redirect('/fees')->with('status', "Tarif Ajouté");

    }


    public function feelist()
    {
        
       $fees = Fee::paginate(100);
        
        
        return view('fee')->with('fees', $fees);

    }

     public function offers()
    {
        
       $offers = Offer::orderBy("offer_type")->get();

        $zones = Fee::orderBy("destination", "asc")->get();
        
        
        return view('abonnements')->with('offers', $offers->toJson())->with("zones", $zones);

    }


    public function subscriptions(Request $request)
    {
        
       $subscriptions = Subscription::orderBy("end", "desc")->with("commands");
     
       $search_result = "";
       $status = "";

            if($request->search ){
                if($request->search != "")
               {$subscriptions = $subscriptions->where("client", 'like', '%' . $request->search . '%' );
               
                              $search_result = $request->search;}
            }


            if($request->status ){
               if($request->status != "")
               { 
              $status = $request->status;
                if($status == "En cours")
               {$subscriptions = $subscriptions->where("end", ">" ,today());}

              if($status == "Expiré")
               {$subscriptions = $subscriptions->where("end", "<" ,today());}
            }

               
            }
       
      

      $offers = $subscriptions->paginate(100);
      $subscriptions = $subscriptions->get();
      
       $clients = Client::where("client_type", null)->get();
       $livreurs = Livreur::orderByDesc("nom")->get();

       $mads = Offer::where("offer_type", "MAD")->get();
       $distribs = Offer::where("offer_type", "DISTRIBUTION")->get(); 
       $zones = Fee::orderBy("destination")->where("zone", "interieur")->get();
       $fees = Fee::orderBy("destination")->get();

       $subscriptions = $subscriptions->toJson();
       $billing = new Billing;

      
        
        return view('subscriptions')->with('subscriptions', $subscriptions)->with("offers", $offers)->with("clients", $clients)->with("providers", $clients->toJson())->with("livreurs", $livreurs)->with("mads", $mads->toJson())->with("distribs", $distribs->toJson())->with("zones", $zones)->with("fees", $fees)->with("search_result", $search_result)->with("status", $status)->with("billing", $billing);

    }


    public function createoffer(Request $request){


  $validatedData = $request->validate([
             'offer_type' => ['required', 'string', 'max:150'],
            'description' => ['required', 'string'],
            'cost' => ['required', 'numeric'],
            'wqty' => ['required', 'numeric'],
            'nom' =>  ['required', 'string'],
            'qty' => ['required', 'numeric'],
            'zones' => ['required'],
            'duration' => ['required', 'numeric'],
           
            
    ]);

    $zones = "";
    foreach($request->zones as $zone){
      $zones .= $zone.", ";
    }

     $offer = new Offer;
     $offer->offer_type = $request->offer_type;
     $offer->description = $request->description;
     $offer->cost = $request->cost;
     $offer->qty = $request->qty;
      $offer->offer_zones = $zones;
     $offer->nom = $request->nom;
     $offer->duration = $request->duration;
     $offer->wqty = $request->wqty; 

     $offer->save();      
     

      return redirect()->back()->with("status", "Offre enregistrée");
}



    public function editoffer(Request $request){


  $validatedData = $request->validate([
             'offer_type' => ['required', 'string', 'max:150'],
            'description' => ['required', 'string'],
            'cost' => ['required', 'numeric'],
            'nom' =>  ['required', 'string'],
            'qty' => ['required', 'numeric'],
            'wqty' => ['required', 'numeric'],
            'zones' => ['required'],
            'duration' => ['required', 'numeric'],
           
            
    ]);

    $zones = "";
    foreach($request->zones as $zone){
      $zones .= $zone.", ";
    }


     $offer = Offer::findOrFail($request->id);
     $offer->offer_type = $request->offer_type;
     $offer->description = $request->description;
     $offer->cost = $request->cost;
     $offer->qty = $request->qty;
     $offer->wqty = $request->wqty;
     $offer->nom = $request->nom;
     $offer->duration = $request->duration;
           
     $offer->update();      
     

      return redirect()->back()->with("status", "Offre modifiée");
}



public function deleteoffer(Request $request){


 


     $offer = Offer::findOrFail($request->id);
    
           
     $offer->delete();      
     

      return redirect()->back()->with("status", "Offre supprimée");
}



public function createsubscription(Request $request){


  

    $zones = "";
    foreach($request->zones as $zone){
      $zones .= $zone.", ";
    }




     $offer = new Subscription;
    
     $offer->subscription_type = $request->offer_type;
     $offer->description = $request->description;
     $offer->cost = $request->cost;
     $offer->qty = $request->qty;
      $offer->zones = $zones;
     $offer->nom = $request->offer;
     $offer->start = $request->start;
     
     $offer->duration = $request->duration;
     $duration = $request->duration;
     
     $end = date('Y-m-d', strtotime("+$request->duration months", strtotime($request->start)));
     // Add 1 year to the date
     $offer->end = $end;
function getEndOfMonthDates($startDate, $endDate) {
     $startTimestamp = strtotime($startDate);
    $endTimestamp = strtotime($endDate);

    $result = array();

    while ($startTimestamp <= $endTimestamp) {
        $startOfMonth = date('Y-m-d', $startTimestamp);
        $endOfMonth = date('Y-m-t', $startTimestamp);
        
        $result[] = [
            'start' => $startOfMonth,
            'end' => $endOfMonth,
        ];

        // Move to the next month
        $startTimestamp = strtotime('+1 month', $startTimestamp);

        // Adjust the start timestamp to the first day of the next month
        $startTimestamp = strtotime('first day of', $startTimestamp);
    }

    return $result;
}     
     

function getMonthlyIntervals($startDate, $endDate) {
    $startDate = new DateTime($startDate);
    $endDate = new DateTime($endDate);

    // Set the interval to 1 month
    $interval = new DateInterval('P1M');

    // Create a DatePeriod object
    $period = new DatePeriod($startDate, $interval, $endDate);

    $intervals = [];

    // Iterate through the DatePeriod and store each interval in an array
    foreach ($period as $date) {
        $intervalStart = clone $date;
        $intervalEnd = clone $date;
        $intervalEnd->add($interval);

        // Adjust the end date if it exceeds the original end date
        if ($intervalEnd > $endDate) {
            $intervalEnd = $endDate;
        }


        // Remove one day from the start and end, except for the last interval
        if ($intervalEnd != $endDate) {
            
            $intervalEnd->modify('-1 day');
        }

        $intervals[] = [
            'start' => $intervalStart->format('Y-m-d'),
            'end'   => $intervalEnd->format('Y-m-d')
        ];
    }

    return $intervals;
}

// Example usage
$startDate = $request->start;
$endDate = $end;

$intervals = getEndOfMonthDates($startDate, $endDate);

// Display the result







     if($request->provider == "SWU"){
       
            $client = new Client;

      $client->nom = $request->provName;

     $client->phone = $request->provPhone;

     

     $client->city = $request->provCity;

     $client->adresse = $request->provAdresse;



     $client->save();



     $offer->client_id = $client->id;
     $client_id = $client->id;

       }



       else

       {

        $offer->client_id = $request->provider;

          $client_id = $request->provider;

          $client = Client::findOrFail($client_id);
       }
           
        $offer->client = $client->nom;
        $livreurs = "";
        

        $offer->save();  


        if(!empty($request->livreurs)){
            $livs = Livreur::whereIn("id", $request->livreurs)->get();
            foreach($livs as $livreur){
             
             $livreurs .= $livreur->nom. ","; 

             $offer->livreurs()->attach($livreur->id);
            }

            $offer->livreurs = $livreurs;
        } 

      $offer->update();  




        $fees = Fee::get();

        

        if($fees->count() > 0){
            foreach($fees as $fee){
                $checkfee = Client_fee::where("client_id", $client_id)->where("destination", $fee->destination)->get();

                if($checkfee->count()<1)
                {
                    $client_fee = new Client_fee;
                
                        $client_fee->destination = $fee->destination;
                        $client_fee->price = 0;
                        $client_fee->client_id = $client_id;
                
                        $client_fee->save();
                    }
            }
        }  


     $client_fee = Client_fee::where("client_id", $client_id)->get();


      

foreach ($intervals as $interval) {
    $period = new Billing_period;

      $period->start = $interval["start"];
      $period->end = $interval["end"];
      $issuedate = date('Y-m-d', strtotime($interval["end"]." +1 day"));
      $period->issue_date = $issuedate;
      $expiration = date('Y-m-d', strtotime($issuedate." +30 days"));
      $period->expiration = $expiration;
      $period->subscription_id = $offer->id;
      $period->save();
}

      return redirect()->back()->with("status", "Abonnement enregistré ")->with("offer", $offer);
}



    public function updateprice(Request $request){
        $id = $request->id;
        $price = $request->intraprice;
        $extraprice = $request->extraprice;
        $description = $request->description;
        $name = $request->name;
        $fee = Fee::findOrFail($id);

        $tarif = new Tarif;

        $tarif->fee_id = $id;
        $tarif->description = $description;
        $tarif->price = $price;
        $tarif->name = $name;
        $tarif->extraprice = $extraprice;

        $tarif->save();

         $success = "Tarif modifié";
        
        $fees = Fee::with("command")->with("tarifs")->get();

        return response()->json(["fees"=> $fees, "success"=>$success]);

    }



    public function changecfee(Request $request){
        $id = $request->id;
        
        $fee = Client_fee::findOrFail($id);
        

        

        $fee->price = $request->coliFee;
        $fee->price_urgent = $request->coliUrgent;
        $fee->extraw = $request->coliExtraw;
        $fee->poidsmax = $request->coliPoidsmax;

        $fee->price_courier = $request->courierFee;
        $fee->courier_urgent = $request->courierUrgent;
        $fee->extra_courier = $request->courierExtraw;
        $fee->poidsmax_courier = $request->courierPoidsmax;
        

        $fee->update();

         $success = "Tarif modifié";
        
        $cfees = Client_fee::where("client_id", $fee->client_id)->orderBy("destination")->get();

        return response()->json(["cfees"=>$cfees]);

    }


    public function getfees(Request $request){
        $id = $request->id;
        $cfees = Client_fee::where("client_id", $id)->orderBy("destination")->get();

        return response()->json(["cfees"=>$cfees]);
    }


    public function getsubs(Request $request){
        $id = $request->id;
        $subscriptions = Subscription::orderBy("subscription_type")->with("commands")->where("client_id", $id)->get();

        return response()->json(["subscriptions"=>$subscriptions]);
    }




    public function updatetarif(Request $request){
        $id = $request->id;
        $price = $request->price;
        $extraprice = $request->extraprice;
        $description = $request->description;
        $name = $request->name;

        

        $tarif = Tarif::findOrFail($id);
        $success = "Aucune modification effectuée";
        if(!empty($price) && !empty($description) && !empty($name) && !empty($extraprice))
        {$tarif->description = $description;
                $tarif->price = $price;
                $tarif->name = $name;
                $tarif->extraprice = $extraprice;
            $success = "Tarif modifié";
            $tarif->update();
            }

        


        
        $fees = Fee::with("command")->with("tarifs")->get();

        return response()->json(["fees"=> $fees, "editSuccess"=>$success, "tarif" => $tarif]);

    }

 public function  deletetarif(Request $request){
    $id = $request->id;

    $tarif = Tarif::findOrFail($id);
    $tarif->delete();


        $fees = Fee::with("command")->with("tarifs")->get();

        return response()->json(["fees"=> $fees, "editSuccess"=>"Tarif supprimé"]);

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
        
        $fee = Fee::findOrFail($id);
        $fee->destination = $request->input('destination');
       $fee->price = $request->input('price');
       
       $fee->category = 1;
       $fee->zone = $request->input('zone');
       $fee->extraprice = $request->extraprice;

       $fee->save();


       return redirect('/fees')->with('status', "Tarif modifié");
    }


public function feedelete($id)
    {
       $fee = Fee::find($id);
       $fee->delete();

       return redirect()->back()->with('status',"Tarif supprimée");

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
        
       $livreurs = Livreur::orderBy('created_at', 'desc')->get();
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



    public function livreurs()
    {
        
       $livreurs = Livreur::orderBy('created_at', 'desc')->where("certified_at", "!=", null)->get();
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
        
        return view('livreurs')->with('livreurs', $livreurs)->with('available_accounts', $available_accounts);

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


//Livreurs

public function addlivreur(Request $request){


  $validatedData = $request->validate([
             'name' => ['required', 'string', 'max:150'],
            'city' => ['required', 'string'],
            'adresse' => ['required', 'string', 'max:150'],
           
            'phone' => ['required', 'string', 'max:10', 'min:10'],
            'email' => ['required', 'string', 'email', 'max:100', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
    ]);


     $user = new User;
        $livreur = new Livreur;


            $user->name = $request->name;
            $user->phone = $request->phone;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->usertype = 'livreur';
           
            
            
            


    $livreur->nom = $request->name;
     $livreur->phone = $request->phone;
     
     $livreur->city = $request->city;
     $livreur->adresse = $request->phone;
     $livreur->status  = 'active';  
        

    $user->save(); 
    $livreur->save();


      $user->livreur_id = $livreur->id;
      $livreur->user_id = $user->id; 

      $user->save();
      $livreur->save();  

      return redirect()->back()->with("status", "livreur Ajouté");
}



//charge
 public function chargeregister(Request $request)
    {
       
       $model = new Charge;
       

       
       $model->type = $request->input('type');
       $model->nature = $request->input('nature');
       $model->montant = $request->input('montant');

       if($request->shop){
        $shop = Shop::find($request->shop);

        if($shop)
        {$model->shop_id = $shop->id;
         $model->shop_name = $shop->name;}

       }


       if($request->periode && is_numeric($request->periode)){
        $model->periode = $request->periode;
       }
       
       $model->detail = $request->input('detail');
       $model->charge_date = $request->input('charge_date');
       $model->source = $request->source;
       
     

       $model->save();


       return redirect('/charge')->with('status', "Charge ajoutée");

    }


    public function chargelist(Request $request)
    {
        
        
         $day = "Ce mois du (". date("d-m-Y",strtotime("first day of this month")). " au ".date("d-m-Y",strtotime("last day of this month")). ")";   
      
      $start = date("Y-m-d",strtotime("first day of this month"));

      $end = date("Y-m-d",strtotime("last day of this month"));
     $shops = Shop::get();

if($request->start && $request->end )
      {

         $start = $request->start;
         $end = $request->end;

       
        
      
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
   
        
        $charges = Charge::orderBy('charge_date', 'desc')->whereBetween("charge_date", [$start, $end])->get();
        
        $charge_types = array('Vidange', 'Reparation', 'carburant', 'Autre');
        
        return view('charge')->with('charges', $charges)->with('charge_types', $charge_types)->with("start", $start)->with("end", $end)->with("day", $day)->with("shops", $shops->toJson())->with("vuecharges", $charges->toJson());

    }

     public function chargeform()
    {
        $charge_natures = array('Facture eau', 'Facture electricite', 'Publicite', 'Loyer', 'Taxes','Consommables', 'Salaires', 'Autres');

        $charge_types = array('Fixe', 'Variable');
        $sources = Source::all();
        $shops = Shop::get();
         sort($charge_natures);

        return view('chargeregister')->with('charge_types',$charge_types )
        ->with('charge_natures',$charge_natures )->with('sources', $sources)
        ->with("shops", $shops);

    }

     
     public function chargeedit($id)
    {
       $charge = Charge::findOrFail($id);
      
        $sources = Source::all();
       

         $charge_natures = array('Facture eau', 'Facture electricite', 'Publicite', 'Loyer', 'Taxes','Consommables', 'Salaires', 'Autres');

         sort($charge_natures);

        $charge_types = array('Fixe', 'Variable');
        $shops = Shop::get();

       return view('chargeedit')->with('charge', $charge)->with('charge_types', $charge_types)->with('charge_natures',$charge_natures )->with("sources", $sources)->with("shops", $shops);
    }


    public function chargeupdate(Request $request, $id)
    {
        
        $model = Charge::findOrFail($id);
        
$model->type = $request->input('type');
       $model->nature = $request->input('nature');
       $model->montant = $request->input('montant');

       if($request->periode && is_numeric($request->periode)){
        $model->periode = $request->periode;
       }
       
       $model->detail = $request->input('detail');
       $model->charge_date = $request->input('charge_date');
       $model->source = $request->source;


       if($request->shop){
        $shop = Shop::find($request->shop);

        if($shop)
        {$model->shop_id = $shop->id;
         $model->shop_name = $shop->name;}

       }

       $model->save();


       return redirect()->back()->with('status', "Charge modifiée");
    }


public function chargedelete($id)
    {
       $charge = Charge::find($id);
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

public function rapports(Request $request)
    {
      
      $clients = Client::get();

      $day = "Cette année"; 
      $day1 = "Aujourd'hui";
      $day2 = "Cette semaine"; 
      $day3 = "Ce mois";  
      
      $currentY = date("Y");
      $previousY = $currentY -1;

      $januarycmds = Command::whereBetween('delivery_date', [date("Y-01-01"), date("Y-01-31")])->where('etat', 'termine')->sum("livraison");


      $februarycmds = Command::whereBetween('delivery_date', [date("Y-02-01"), date("Y-02-29")])->where('etat', 'termine')->sum("livraison");

      $marchcmds = Command::whereBetween('delivery_date', [date("Y-03-01"), date("Y-03-31")])->where('etat', 'termine')->sum("livraison");

      $aprilcmds = Command::whereBetween('delivery_date', [date("Y-04-01"), date("Y-04-30")])->where('etat', 'termine')->sum("livraison");

      $maycmds = Command::whereBetween('delivery_date', [date("Y-05-01"), date("Y-05-31")])->where('etat', 'termine')->sum("livraison");
     
      
      $juncmds = Command::whereBetween('delivery_date', [date("Y-06-01"), date("Y-06-30")])->where('etat', 'termine')->sum("livraison");

      $julycmds = Command::whereBetween('delivery_date', [date("Y-07-01"), date("Y-07-31")])->where('etat', 'termine')->sum("livraison");


      $augustcmds = Command::whereBetween('delivery_date', [date("Y-08-01"), date("Y-08-31")])->where('etat', 'termine')->sum("livraison");

      $septembercmds = Command::whereBetween('delivery_date', [date("Y-09-01"), date("Y-09-30")])->where('etat', 'termine')->sum("livraison");

      $octobercmds = Command::whereBetween('delivery_date', [date("Y-10-01"), date("Y-10-31")])->where('etat', 'termine')->sum("livraison");

      $novembercmds = Command::whereBetween('delivery_date', [date("Y-11-01"), date("Y-11-30")])->where('etat', 'termine')->sum("livraison");
     
      
      $decembercmds = Command::whereBetween('delivery_date', [date("Y-12-01"), date("Y-12-31")])->where('etat', 'termine')->sum("livraison");


     //previous
      $pjanuarycmds = Command::whereBetween('delivery_date', [date($previousY."-01-01"), date($previousY."-01-31")])->where('etat', 'termine')->sum("livraison");


      $pfebruarycmds = Command::whereBetween('delivery_date', [date($previousY."-02-01"), date($previousY."-02-29")])->where('etat', 'termine')->sum("livraison");

      $pmarchcmds = Command::whereBetween('delivery_date', [date($previousY."-03-01"), date($previousY."-03-31")])->where('etat', 'termine')->sum("livraison");

      $paprilcmds = Command::whereBetween('delivery_date', [date($previousY."-04-01"), date($previousY."-04-30")])->where('etat', 'termine')->sum("livraison");

      $pmaycmds = Command::whereBetween('delivery_date', [date($previousY."-05-01"), date($previousY."-05-31")])->where('etat', 'termine')->sum("livraison");
     
      
      $pjuncmds = Command::whereBetween('delivery_date', [date($previousY."-06-01"), date($previousY."-06-30")])->where('etat', 'termine')->sum("livraison");

      $pjulycmds = Command::whereBetween('delivery_date', [date($previousY."-07-01"), date($previousY."-07-31")])->where('etat', 'termine')->sum("livraison");


      $paugustcmds = Command::whereBetween('delivery_date', [date($previousY."-08-01"), date($previousY."-08-31")])->where('etat', 'termine')->sum("livraison");

      $pseptembercmds = Command::whereBetween('delivery_date', [date($previousY."-09-01"), date($previousY."-09-30")])->where('etat', 'termine')->sum("livraison");

      $poctobercmds = Command::whereBetween('delivery_date', [date($previousY."-10-01"), date($previousY."-10-31")])->where('etat', 'termine')->sum("livraison");

      $pnovembercmds = Command::whereBetween('delivery_date', [date($previousY."-11-01"), date($previousY."-11-30")])->where('etat', 'termine')->sum("livraison");
     
      
      $pdecembercmds = Command::whereBetween('delivery_date', [date($previousY."-12-01"), date($previousY."-12-31")])->where('etat', 'termine')->sum("livraison");


          $all_fees = Fee::all();
     $all_livreurs = Livreur::all();   
     
     $start = date("Y-m-d",strtotime("first day of january this year"));
      $end = date("Y-m-d",strtotime("last day of december this year"));

      $start1 = today();
      $end1 = today();

      $start2 = date("Y-m-d",strtotime("first day of this week"));
      $end2 = today();


      $start3 = date("Y-m-d",strtotime("first day of this month"));
      $end3 = today();
 




      if($request->start && $request->end )
      {$start = $request->start;
         $end = $request->end;

       
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



      if($request->start1 && $request->end1 )
      {$start1 = $request->start1;
         $end1 = $request->end1;

       
     if($start1 == $end1)
       {
         if($start1 == date("Y-m-d"))
       {
           $day1 = "Aujourd'hui";
       }
       elseif($start1 == date('Y-m-d',strtotime("-1 days")))
       {
          $day1 = "Hier";
       }else{
         $day1 =date_create($start1)->format("d-m-Y");
       }

        

       }else{
         $day1 = "Du " .date_create($start1)->format("d-m-Y") . " au " .date_create($end1)->format("d-m-Y");
       }
        
      }




      if($request->start2 && $request->end2 )
      {$start2 = $request->start2;
         $end2 = $request->end2;

       
     if($start2 == $end2)
       {
         if($start2 == date("Y-m-d"))
       {
           $day2 = "Aujourd'hui";
       }
       elseif($start2 == date('Y-m-d',strtotime("-1 days")))
       {
          $day2 = "Hier";
       }else{
         $day2 =date_create($start2)->format("d-m-Y");
       }

        

       }else{
         $day2 = "Du " .date_create($start2)->format("d-m-Y") . " au " .date_create($end2)->format("d-m-Y");
       }
        
      }


       if($request->start3 && $request->end3 )
      {$start3 = $request->start3;
         $end3 = $request->end3;

       
     if($start3 == $end3)
       {
         if($start3 == date("Y-m-d"))
       {
           $day3 = "Aujourd'hui";
       }
       elseif($start3 == date('Y-m-d',strtotime("-1 days")))
       {
          $day3 = "Hier";
       }else{
         $day3 =date_create($start3)->format("d-m-Y");
       }

        

       }else{
         $day3 = "Du " .date_create($start3)->format("d-m-Y") . " au " .date_create($end3)->format("d-m-Y");
       }
        
      }





    

function days_between_dates($date1, $date2) {
    $startDate = Carbon::parse($date1);
    $endDate = Carbon::parse($date2);

    // Initialize the count of non-Sunday days
    $count = 0;

    // Loop through each day between the start and end dates
    while ($startDate <= $endDate) {
        // Check if the current day is not a Sunday (Carbon's dayOfWeek returns 0 for Sunday)
        if ($startDate->dayOfWeek !== 0) {
            $count++;
        }

        // Move to the next day
        $startDate->addDay();
    }

    return $count*11*60;


}









    //all data
      $all_actifs = Client::has('commands', '>' , 0)->with('commands')->count();
    $all_inactifs = Client::has('commands', '<' , 1)->with('commands')->count();

    $all_actifsl = Livreur::has('commands', '>' , 0)->with('commands')->count();
    $all_inactifsl = Livreur::has('commands', '<' , 1)->with('commands')->count();


    $all_actifs_zones = Fee::has('commands', '>' , 0)->with('commands')->count();
    $all_inactifs_zones = Fee::has('commands', '<' , 1)->with('commands')->count();
  $clients_by_zone =  Client::selectRaw("COUNT(city) qty,  (city) city")
                      
                      ->groupBy("city")
                      ->get(); 



       $commands = Command::whereBetween('delivery_date', [$start, $end])->where('etat', 'termine')->get();


          
          $charges = Charge::whereBetween('charge_date', [$start, $end])->sum('montant'); 




          //$day-- Year 

     $charges_by_type = Charge::selectRaw('SUM(montant) Montant, (type) type')
    ->whereBetween('charge_date', [$start, $end])
    ->orderBy('Montant', 'desc')
    ->groupBy('type')
    ->get();     

    $command_by_clients = Command::selectRaw('SUM(livraison) montant, COUNT(montant) qty, (client_id) client_id')
   ->whereBetween('delivery_date', [$start, $end])
    
     ->orderBy('montant', 'desc')
    ->groupBy('client_id')
    ->get();


     $command_by_clients_delivered = Command::selectRaw('SUM(livraison) montant, COUNT(montant) qty, (client_id) client_id')
   ->whereBetween('delivery_date', [$start, $end])
    ->where("etat", "termine")
     ->orderBy('montant', 'desc')
    ->groupBy('client_id')
    ->get();


     $command_by_clients_undelivered = Command::selectRaw('SUM(livraison) montant, COUNT(montant) qty, (client_id) client_id')
   ->whereBetween('delivery_date', [$start, $end])
     ->where("etat", "annule")
     ->orderBy('montant', 'desc')
    ->groupBy('client_id')
    ->get();


    $command_by_fees = Command::selectRaw('SUM(livraison) montant, COUNT(livraison) qty, (fee_id) fee_id')
    ->whereBetween('delivery_date', [$start, $end])
    
     ->orderBy('montant', 'desc')
    ->groupBy('fee_id')
    ->get();
   


   $command_by_livreurs = Command::selectRaw('SUM(livraison) montant, COUNT(livraison) qty, (livreur_id) livreur_id')
  ->whereBetween('delivery_date', [$start, $end])
   
     ->orderBy('montant', 'desc')
    ->groupBy('livreur_id')
    ->get();

    $command_by_livreurs_delivered = Command::selectRaw('SUM(livraison) montant, COUNT(livraison) qty, (livreur_id) livreur_id')
  ->whereBetween('delivery_date', [$start, $end])
   ->where("etat", "termine")
     ->orderBy('montant', 'desc')
    ->groupBy('livreur_id')
    ->get();


      $actifs = Client::whereHas("commands", function($q) use($start, $end){
    $q->whereBetween("delivery_date", [$start, $end]);
   })

   ->with('commands')->selectRaw("COUNT(id) qty, (city) city")->groupBy("city")->get();

  $inactifs = Client::whereDoesntHave("commands", function($q) use($start, $end){
    $q->whereBetween("delivery_date", [$start, $end]);
   })

   ->with('commands')->selectRaw("COUNT(id) qty, (city) city")->groupBy("city")->get();



   //Active L
    $actifsl = Livreur::whereHas("commands", function($q) use($start, $end){
    $q->whereBetween("delivery_date", [$start, $end]);
   })

   ->with('commands')->selectRaw("COUNT(id) qty, (city) city")->groupBy("city")->get();



  $inactifsl = Livreur::whereDoesntHave("commands", function($q) use($start, $end){
    $q->whereBetween("delivery_date", [$start, $end]);
   })

   ->with('commands')->selectRaw("COUNT(id) qty, (city) city")->groupBy("city")->get();


    $actifs_by_zone = Fee::whereHas("commands", function($q) use($start, $end){
    $q->whereBetween("delivery_date", [$start, $end]);
   })

   ->with('commands')->selectRaw("COUNT(id) qty, (id) id")->groupBy("id")->get();

  $inactifs_by_zone = Fee::whereDoesntHave("commands", function($q) use($start, $end){
    $q->whereBetween("delivery_date", [$start, $end]);
   })

   ->with('commands')->selectRaw("COUNT(id) qty, (id) city")->groupBy("id")->get();

   
    //$day1 - today
     $charges_by_type1 = Charge::selectRaw('SUM(montant) Montant, (type) type')
    ->whereBetween('charge_date', [$start1, $end1])
    ->orderBy('Montant', 'desc')
    ->groupBy('type')
    ->get();     

    $command_by_clients1 = Command::selectRaw('SUM(livraison) montant, COUNT(montant) qty, (client_id) client_id')
    ->whereBetween('delivery_date', [$start1, $end1])
    
     ->orderBy('montant', 'desc')
    ->groupBy('client_id')
    ->get();

    $command_by_clients_delivered1 = Command::selectRaw('SUM(livraison) montant, COUNT(montant) qty, (client_id) client_id')
    ->whereBetween('delivery_date', [$start1, $end1])
  ->where("etat", "termine")
     ->orderBy('montant', 'desc')
    ->groupBy('client_id')->get()
    ;

    $command_by_clients_undelivered1 = Command::selectRaw('SUM(livraison) montant, COUNT(montant) qty, (client_id) client_id')
    ->whereBetween('delivery_date', [$start1, $end1])
  ->where("etat", "annule")
     ->orderBy('montant', 'desc')
    ->groupBy('client_id')->get()
    ;


    $command_by_fees1 = Command::selectRaw('SUM(livraison) montant, COUNT(livraison) qty, (fee_id) fee_id')
   ->whereBetween('delivery_date', [$start1, $end1])
 
     ->orderBy('montant', 'desc')
    ->groupBy('fee_id')
    ->get();
   


   $command_by_livreurs1 = Command::selectRaw('SUM(livraison) montant, COUNT(livraison) qty, (livreur_id) livreur_id')
   ->whereBetween('delivery_date', [$start1, $end1])

     ->orderBy('montant', 'desc')
    ->groupBy('livreur_id')
    ->get();

     $command_by_livreurs_delivered1 = Command::selectRaw('SUM(livraison) montant, COUNT(livraison) qty, (livreur_id) livreur_id')
   ->whereBetween('delivery_date', [$start1, $end1])
  ->where("etat", "termine")
     ->orderBy('montant', 'desc')
    ->groupBy('livreur_id')
    ->get();


    $command_by_livreurs_undelivred1 = Command::selectRaw('SUM(livraison) montant, COUNT(livraison) qty, (livreur_id) livreur_id')
   ->whereBetween('delivery_date', [$start1, $end1])
  ->where("etat", "annule")
     ->orderBy('montant', 'desc')
    ->groupBy('livreur_id')
    ->get();



      $actifs1 = Client::whereHas("commands", function($q) use($start1, $end1){
    $q->whereBetween("delivery_date", [$start1, $end1]);
   })

   ->with('commands')->selectRaw("COUNT(id) qty, (city) city")->groupBy("city")->get();

  $inactifs1 = Client::whereDoesntHave("commands", function($q) use($start1, $end1){
    $q->whereBetween("delivery_date", [$start1, $end1]);
   })

   ->with('commands')->selectRaw("COUNT(id) qty, (city) city")->groupBy("city")->get();


   //Active L
    $actifsl1 = Livreur::whereHas("commands", function($q) use($start1, $end1){
    $q->whereBetween("delivery_date", [$start1, $end1]);
   })

   ->with('commands')->selectRaw("COUNT(id) qty, (city) city")->groupBy("city")->get();



  $inactifsl1 = Livreur::whereDoesntHave("commands", function($q) use($start1, $end1){
    $q->whereBetween("delivery_date", [$start1, $end1]);
   })

   ->with('commands')->selectRaw("COUNT(id) qty, (city) city")->groupBy("city")->get();






    $actifs_by_zone1 = Fee::whereHas("commands", function($q) use($start1, $end1){
    $q->whereBetween("delivery_date", [$start1, $end1]);
   })

   ->with('commands')->selectRaw("COUNT(id) qty, (id) id")->groupBy("id")->get();

  $inactifs_by_zone1 = Fee::whereDoesntHave("commands", function($q) use($start1, $end1){
    $q->whereBetween("delivery_date", [$start1, $end1]);
   })

   ->with('commands')->selectRaw("COUNT(id) qty, (id) city")->groupBy("id")->get();
    

    //$day2 week
   
     $charges_by_type2 = Charge::selectRaw('SUM(montant) Montant, (type) type')
    ->whereBetween('charge_date', [$start2, $end2])
    ->orderBy('Montant', 'desc')
    ->groupBy('type')
    ->get();     

    $command_by_clients2 = Command::selectRaw('SUM(livraison) montant, COUNT(montant) qty, (client_id) client_id')
    ->whereBetween('delivery_date', [$start2, $end2])

     ->orderBy('montant', 'desc')
    ->groupBy('client_id')
    ->get();


    $command_by_clients_delivered2 = Command::selectRaw('SUM(livraison) montant, COUNT(montant) qty, (client_id) client_id')
    ->whereBetween('delivery_date', [$start2, $end2])
     ->where("etat", "termine")
     ->orderBy('montant', 'desc')
    ->groupBy('client_id')
    ->get();

    $command_by_clients_undelivered2 = Command::selectRaw('SUM(livraison) montant, COUNT(montant) qty, (client_id) client_id')
    ->whereBetween('delivery_date', [$start2, $end2])
     ->where("etat", "annule")
     ->orderBy('montant', 'desc')
    ->groupBy('client_id')
    ->get();


    $command_by_fees2 = Command::selectRaw('SUM(livraison) montant, COUNT(livraison) qty, (fee_id) fee_id')
   ->whereBetween('delivery_date', [$start2, $end2])

     ->orderBy('montant', 'desc')
    ->groupBy('fee_id')
    ->get();
   


   $command_by_livreurs2 = Command::selectRaw('SUM(livraison) montant, COUNT(livraison) qty, (livreur_id) livreur_id')
   ->whereBetween('delivery_date', [$start2, $end2])

     ->orderBy('montant', 'desc')
    ->groupBy('livreur_id')
    ->get();


    $command_by_livreurs_delivered2 = Command::selectRaw('SUM(livraison) montant, COUNT(livraison) qty, (livreur_id) livreur_id')
   ->whereBetween('delivery_date', [$start2, $end2])
  ->where("etat", "termine")
     ->orderBy('montant', 'desc')
    ->groupBy('livreur_id')
    ->get();
   
       $actifs2 = Client::whereHas("commands", function($q) use($start2, $end2){
    $q->whereBetween("delivery_date", [$start2, $end2]);
   })

   ->with('commands')->selectRaw("COUNT(id) qty, (city) city")->groupBy("city")->get();

  $inactifs2 = Client::whereDoesntHave("commands", function($q) use($start2, $end2){
    $q->whereBetween("delivery_date", [$start2, $end2]);
   })

   ->with('commands')->selectRaw("COUNT(id) qty, (city) city")->groupBy("city")->get();




   //Active L
    $actifsl2 = Livreur::whereHas("commands", function($q) use($start2, $end2){
    $q->whereBetween("delivery_date", [$start2, $end2]);
   })

   ->with('commands')->selectRaw("COUNT(id) qty, (city) city")->groupBy("city")->get();



  $inactifsl2 = Livreur::whereDoesntHave("commands", function($q) use($start2, $end2){
    $q->whereBetween("delivery_date", [$start2, $end2]);
   })

   ->with('commands')->selectRaw("COUNT(id) qty, (city) city")->groupBy("city")->get();






    $actifs_by_zone2 = Fee::whereHas("commands", function($q) use($start2, $end2){
    $q->whereBetween("delivery_date", [$start2, $end2]);
   })

   ->with('commands')->selectRaw("COUNT(id) qty, (id) id")->groupBy("id")->get();

  $inactifs_by_zone2 = Fee::whereDoesntHave("commands", function($q) use($start2, $end2){
    $q->whereBetween("delivery_date", [$start2, $end2]);
   })

   ->with('commands')->selectRaw("COUNT(id) qty, (id) city")->groupBy("id")->get();







   //$day3 month
   
     $charges_by_type3 = Charge::selectRaw('SUM(montant) Montant, (type) type')
    ->whereBetween('charge_date', [$start3, $end3])
    ->orderBy('Montant', 'desc')
    ->groupBy('type')
    ->get();     

    $command_by_clients3 = Command::selectRaw('SUM(livraison) montant, COUNT(montant) qty, (client_id) client_id')
    ->whereBetween('delivery_date', [$start3, $end3])

     ->orderBy('montant', 'desc')
    ->groupBy('client_id')
    ->get();


    $command_by_clients_delivered3 = Command::selectRaw('SUM(livraison) montant, COUNT(montant) qty, (client_id) client_id')
    ->whereBetween('delivery_date', [$start3, $end3])
     ->where("etat", "termine")
     ->orderBy('montant', 'desc')
    ->groupBy('client_id')
    ->get();

    $command_by_clients_undelivered3 = Command::selectRaw('SUM(livraison) montant, COUNT(montant) qty, (client_id) client_id')
    ->whereBetween('delivery_date', [$start3, $end3])
     ->where("etat", "annule")
     ->orderBy('montant', 'desc')
    ->groupBy('client_id')
    ->get();


    $command_by_fees3 = Command::selectRaw('SUM(livraison) montant, COUNT(livraison) qty, (fee_id) fee_id')
   ->whereBetween('delivery_date', [$start3, $end3])

     ->orderBy('montant', 'desc')
    ->groupBy('fee_id')
    ->get();
   


   $command_by_livreurs3 = Command::selectRaw('SUM(livraison) montant, COUNT(livraison) qty, (livreur_id) livreur_id')
   ->whereBetween('delivery_date', [$start3, $end3])

     ->orderBy('montant', 'desc')
    ->groupBy('livreur_id')
    ->get();


    $command_by_livreurs_delivered3 = Command::selectRaw('SUM(livraison) montant, COUNT(livraison) qty, (livreur_id) livreur_id')
   ->whereBetween('delivery_date', [$start3, $end3])
  ->where("etat", "termine")
     ->orderBy('montant', 'desc')
    ->groupBy('livreur_id')
    ->get();
   
       $actifs3 = Client::whereHas("commands", function($q) use($start3, $end3){
    $q->whereBetween("delivery_date", [$start3, $end3]);
   })

   ->with('commands')->selectRaw("COUNT(id) qty, (city) city")->groupBy("city")->get();

  $inactifs3 = Client::whereDoesntHave("commands", function($q) use($start3, $end3){
    $q->whereBetween("delivery_date", [$start3, $end3]);
   })

   ->with('commands')->selectRaw("COUNT(id) qty, (city) city")->groupBy("city")->get();



   //Active L
    $actifsl3 = Livreur::whereHas("commands", function($q) use($start3, $end3){
    $q->whereBetween("delivery_date", [$start3, $end3]);
   })

   ->with('commands')->selectRaw("COUNT(id) qty, (city) city")->groupBy("city")->get();



  $inactifsl3 = Livreur::whereDoesntHave("commands", function($q) use($start3, $end3){
    $q->whereBetween("delivery_date", [$start3, $end3]);
   })

   ->with('commands')->selectRaw("COUNT(id) qty, (city) city")->groupBy("city")->get();







    $actifs_by_zone3 = Fee::whereHas("commands", function($q) use($start3, $end3){
    $q->whereBetween("delivery_date", [$start3, $end3]);
   })

   ->with('commands')->selectRaw("COUNT(id) qty, (id) id")->groupBy("id")->get();



  $inactifs_by_zone3 = Fee::whereDoesntHave("commands", function($q) use($start3, $end3){
    $q->whereBetween("delivery_date", [$start3, $end3]);
   })

   ->with('commands')->selectRaw("COUNT(id) qty, (id) city")->groupBy("id")->get();
   

  
  $int = days_between_dates($start, $end);
$int1 = days_between_dates($start1, $end1);
$int2 = days_between_dates($start2, $end2);
$int3 = days_between_dates($start3, $end3);


function convert_minutes_to_hours_minutes($minutes) {
    // Calculate the number of hours and remaining minutes
    $hours = floor($minutes / 60);
    $remaining_minutes = $minutes % 60;

    // Return the result as an array with hours and minutes
    return [
        'minutes' => $minutes,
        'hours' => $hours,
        'remaining_minutes' => $remaining_minutes,
    ];
}

$result = 0;
$result1 = 0;
$result2 = 0;
$result3 = 0;

if($command_by_clients_delivered->sum("qty") > 0)
{$result = convert_minutes_to_hours_minutes(round($int/$command_by_clients_delivered->sum("qty")));}

if($command_by_clients_delivered1->sum("qty") > 0)
{$result1 = convert_minutes_to_hours_minutes(round($int1/$command_by_clients_delivered1->sum("qty")));}

if($command_by_clients_delivered2->sum("qty") > 0)
{$result2 = convert_minutes_to_hours_minutes(round($int2/$command_by_clients_delivered2->sum("qty")));}

if($command_by_clients_delivered3->sum("qty") > 0)
{$result3 = convert_minutes_to_hours_minutes(round($int3/$command_by_clients_delivered3->sum("qty")));}



 

                                          
        
        return view('rapports')->with('charges', $charges)->with('charges_by_type', $charges_by_type)->with('all_livreurs', $all_livreurs)->with("commands", $commands)->with("januarycmds", $januarycmds)->with("februarycmds", $februarycmds)->with("marchcmds", $marchcmds)->with("aprilcmds", $aprilcmds)->with("maycmds", $maycmds)->with("juncmds", $juncmds)->with("julycmds", $julycmds)->with("augustcmds", $augustcmds)->with("septembercmds", $septembercmds)->with("octobercmds", $octobercmds)->with("novembercmds", $novembercmds)->with("decembercmds", $decembercmds)->with("pjanuarycmds", $pjanuarycmds)->with("pfebruarycmds", $pfebruarycmds)->with("pmarchcmds", $pmarchcmds)->with("paprilcmds", $paprilcmds)->with("pmaycmds", $pmaycmds)->with("pjuncmds", $pjuncmds)->with("pjulycmds", $pjulycmds)->with("paugustcmds", $paugustcmds)->with("pseptembercmds", $pseptembercmds)->with("poctobercmds", $poctobercmds)->with("pnovembercmds", $pnovembercmds)->with("pdecembercmds", $pdecembercmds)->with("currentY", $currentY)->with("previousY", $previousY)->with('clients', $clients)->with("clients_by_zone", $clients_by_zone)->with("all_actifs", $all_actifs)->with("all_inactifs", $all_inactifs)->with("all_inactifs_zones", $all_inactifs_zones)->with("all_actifs_zones", $all_actifs_zones)->with('all_fees', $all_fees)->with("actifs_by_zone", $actifs_by_zone)->with("all_actifsl", $all_actifsl)->with("all_inactifsl", $all_inactifsl)



           ->with("start", $start)->with("end", $end)->with("actifs", $actifs)->with("inactifs", $inactifs)->with("inactifs_by_zone", $inactifs_by_zone)->with('command_by_clients', $command_by_clients)->with('command_by_fees', $command_by_fees)->with('command_by_livreurs', $command_by_livreurs)->with("day", $day)->with('command_by_clients_delivered', $command_by_clients_delivered)->with('command_by_clients_undelivered', $command_by_clients_undelivered)->with("int", $int)->with("command_by_livreurs_delivered", $command_by_livreurs_delivered)->with("result", $result)->with("actifsl", $actifsl)->with("inactifsl", $inactifsl)


            ->with("start1", $start1)->with("end1", $end1)->with("actifs1", $actifs1)->with("inactifs1", $inactifs1)->with("inactifs_by_zone1", $inactifs_by_zone1)->with('command_by_clients1', $command_by_clients1)->with('command_by_fees1', $command_by_fees1)->with('command_by_livreurs1', $command_by_livreurs1)->with("day1", $day1)->with('command_by_clients_delivered1', $command_by_clients_delivered1)->with('command_by_clients_undelivered1', $command_by_clients_undelivered1)->with("int1", $int1)->with("command_by_livreurs_delivered1", $command_by_livreurs_delivered1)->with("result1", $result1)->with("actifsl1", $actifsl1)->with("inactifsl1", $inactifsl1)


            ->with("start2", $start2)->with("end2", $end2)->with("actifs2", $actifs2)->with("inactifs2", $inactifs2)->with("actifs_by_zone2", $actifs_by_zone2)->with("inactifs_by_zone2", $inactifs_by_zone2)->with('command_by_clients2', $command_by_clients2)->with('command_by_fees2', $command_by_fees2)->with('command_by_livreurs2', $command_by_livreurs2)->with("day2", $day2)->with('command_by_clients_delivered2', $command_by_clients_delivered2)->with('command_by_clients_undelivered2', $command_by_clients_undelivered2)->with("int2", $int2)->with("result2", $result2)->with("command_by_livreurs_delivered2", $command_by_livreurs_delivered2)->with("actifsl2", $actifsl2)->with("inactifsl2", $inactifsl2)


            ->with("start3", $start3)->with("end3", $end3)->with("actifs3", $actifs3)->with("inactifs3", $inactifs3)->with("actifs_by_zone3", $actifs_by_zone3)->with("inactifs_by_zone3", $inactifs_by_zone3)->with('command_by_clients3', $command_by_clients3)->with('command_by_fees3', $command_by_fees3)->with('command_by_livreurs3', $command_by_livreurs3)->with("day3", $day3)->with('command_by_clients_delivered3', $command_by_clients_delivered3)->with('command_by_clients_undelivered3', $command_by_clients_undelivered3)->with("int3", $int3)->with("result3", $result3)->with("command_by_livreurs_delivered3", $command_by_livreurs_delivered3)->with("actifsl3", $actifsl3)->with("inactifsl3", $inactifsl3);

    }


public function getcancelreasons(Request $request)
    {
      $start = $request->start;
      $end = $request->end;
      $notes = null;

       $commands = Command::has('note', '>' , 0)->with('note')
     ->where("etat", "annule")->select("id")->get()->toArray();

   if(count($commands) > 0)
   {
    $notes = Note::whereIn("command_id", $commands)
                   ->selectRaw("COUNT('command_id') commands, (description) description")
                   ->groupBy("description")
                   ->get();
               }

    return response()->json(["notes"=>$notes]);            



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

public function sms(){
    return view('sms');
}

public function sendsms(Request $request){
    // if(!$request->Manager && !$request->client && !$request->livreur)
    // {return redirect()->back()->with("error", "Vous n'avez selectionné aucun destinataire")}
    // $model = User::limit(100);
    // if($request->manager)
    // {
    //     $model = $model->where('usertype', 'manager');
    // }

    // if($request->client)
    // {
    //     $model = $model->where('usertype', 'client');
    // }


    // if($request->livreur)
    // {
    //     $model = $model->where('usertype', 'livreur');
    // }

    // $model = $model->get();
    // $phones = array();
    // foreach($model as $result)
    // {
    //   $phones[] = $result->phone;
    // }

    $message = "test";
    $config = array(
            'clientId' => config('app.clientId'),
            'clientSecret' =>  config('app.clientSecret'),
        );

        $osms = new Sms($config);

   
      
  
          $data = $osms->getTokenFromConsumerKey();
          $token = array(
              'token' => $data['access_token']
          );
  
     // foreach($phones as $phone)
     //      {$response = $osms->sendSms(
                    
     //                    'tel:+2250709980885',
                        
     //                    'tel:+225'.$phone,
                        
     //                    $message,
     //                    'Jibiat Manager'
     //                );}


     $response = $osms->sendSms(
                    
                         'tel:+2250709980885',
                        
                        'tel:+22553141666',
                        
                        $message,
                        'Jibiat Manager');     

      return redirect()->back()->with("status", "Message envoyée");
  
}

public function manager()
{
 $clients = Client::paginate(50);
          $available_accounts = User::where('usertype', NULL)->get();
      

        $active_commands = Command::selectRaw('SUM(montant) montant, (client_id) client_id')
    ->where('delivery_date', today())
    ->where('etat', 'termine')
    ->groupBy('client_id')
    ->get(); 
       
         
        
        return view('managers')->with('clients', $clients)->with('available_accounts', $available_accounts)->with('active_commands', $active_commands);
}


public function users()
{
 $clients = Client::get();
          $available_accounts = User::where('usertype', NULL)->get();
      

        $active_commands = Command::selectRaw('SUM(montant) montant, (client_id) client_id')
    ->where('delivery_date', today())
    ->where('etat', 'termine')
    ->groupBy('client_id')
    ->get(); 
       
         
        
        return view('users')->with('clients', $clients)->with('available_accounts', $available_accounts)->with('active_commands', $active_commands);
}



public function userstat(Request $request)
{
 $clients = Client::where("client_type", "!=", null)->where("client_type", "!=", "ADMIN")->get();

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

                  function dateDiff($date1, $date2)
                            {
                                $date1_ts = strtotime($date1);
                                $date2_ts = strtotime($date2);
                                      $diff = $date2_ts - $date1_ts;
                                      return round($diff / 86400) + 1;
                            }
          
               $dif = dateDiff($start, $end);


       $userobj =  function($client_type, $start, $end){
                   $type = User_type::where("type", $client_type)->first();
                    $mensual_goal = $type->mensual_goal;
                   $periode_goal = 0;

                   if($mensual_goal > 0)
       
                   {
                          
                    $daily = round($mensual_goal/30);
                     $dif = dateDiff($start, $end);     
                        
                $periode_goal = $daily*$dif;}
       
                   return $periode_goal;
                 } ;
             
      
       

      
       
         
        
        return view('userstat')->with('clients', $clients)->with("userobj", $userobj)->with("start", $start)->with("end", $end)->with("day", $day)->with("dif", $dif);
}


public function setconseiller(Request $request){
  $client = Client::findOrFail($request->client_id);
  $client->cc_id = $request->cc_id;

  $client->update();

  return redirect()->back()->with("status", "Conseiller defini");
}
}
