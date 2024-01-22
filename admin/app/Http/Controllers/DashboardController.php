<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\Command;
use App\Client;
use App\Manager;
use App\Livreur;
use App\Fee;
use App\Moto;
use App\Payment;
use App\Charge;
use App\Lesroute;
use App\Product;
use App\Mooving;
use App\Certification;
use App\Fuel;
use App\Note;
use App\Source;
use App\User_type;
use App\Command_product;
use App\Helpers\Sms;
use DateTime;
use Auth;
use Illuminate\Support\MessageBag;



use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Builder;
class DashboardController extends Controller
{

    public function roles(){
        return view("roles");
    }
    
   public function start()
    {
        
        $start = date('Y-m-01');
        $end = date('Y-m-t');
        $products = Product::get();
         $term = "COMMAND_";
        $products_ranking = array();

        foreach($products as $product){
         $in = $product->moovings->where("type", "IN")->where('description', '!=', "STOCK_INITIAL")->sum('qty');
         $out = $product->moovings->where("type", "OUT")->where('description', '!=', "STOCK_INITIAL")->sum('qty');
         $sold = $out-$in;

        $products_ranking[] = [$sold,$product->name, $product->photo];
        }

         sort($products_ranking);
        

        
        $notes = Note::with('command')->with('command.livreur')->orderBy("created_at", "desc")->whereDate("created_at", today())->get()->toJson();
        
        $livreurs = Livreur::where("certified_at", '!=', null)->with(['commands' => function($q) {
            $q->where('delivery_date', today());}])
        ->with('notes')
        ->with("lesroutes")
        ->get()->toJson();
        return view('dashboard')
             ->with("total_sum", Command::where("delivery_date", today())->sum('montant'))
            ->with("total_count", Command::where("delivery_date", today())->count())

            ->with("sum_done", Command::where("delivery_date", today())->where('etat', "termine")->sum('montant'))
            ->with("count_done", Command::where("delivery_date", today())->where('etat', "termine")->count())

            ->with("sum_undone", Command::where("delivery_date", today())->whereIn('etat', ["encours", "recupere", "en chemin"])->sum('montant'))
            ->with("count_undone", Command::where("delivery_date", today())->whereIn('etat', ["encours", "recupere", "en chemin"])->count())


             ->with("sum_cancel", Command::where("delivery_date", today())->where('etat', "annule")->sum('montant'))
            ->with("count_cancel", Command::where("delivery_date", today())->where('etat', "annule")->count())
            
            ->with("notes", $notes)->with("livreurs", $livreurs)->with("products_ranking", $products_ranking);


    }

    public function refreshnotes(){
        $start = date('Y-m-01');
        $end = date('Y-m-t');
        $products = Product::get();
         $term = "COMMAND_";
        $products_ranking = array();

        foreach($products as $product){
         $in = $product->moovings->where("type", "IN")->where('description', '!=', "STOCK_INITIAL")->sum('qty');
         $out = $product->moovings->where("type", "OUT")->where('description', '!=', "STOCK_INITIAL")->sum('qty');
         $sold = $out-$in;

        $products_ranking[] = [$sold,$product->name, $product->photo];
        }

       
        $sum_undone = Command::where('delivery_date', today())->whereIn('etat', ["encours", "recupere", "en chemin"])->sum('montant');
        $count_undone = Command::where('delivery_date', today())->whereIn('etat', ["encours", "recupere", "en chemin"])->count();
      

      $sum_cancel = Command::where('delivery_date', today())->where('etat', "annule")->sum('montant');
       $count_cancel = Command::where('delivery_date', today())->where('etat', "annule")->count();

       $sum_done = Command::where('delivery_date', today())->where('etat', "termine")->sum('montant');
       $count_done = Command::where('delivery_date', today())->where('etat', "termine")->count();

       $total_sum = Command::where('delivery_date', today())->sum('montant');
       $total_count = Command::where('delivery_date', today())->count();
        
        $notes = Note::with('command')->with('command.livreur')->orderBy("created_at", "desc")->whereDate("created_at", today())->get();
        
        $livreurs = Livreur::where("certified_at", '!=', null)->with(['commands' => function($q) {
            $q->where('delivery_date', today());}])
        ->get();

       

        return response()->json(["notes"=>$notes, "livreurs"=>$livreurs,

                                   "sum_undone"=> $sum_undone,
                                    "count_undone"=> $count_undone,



                                  "sum_cancel"=>$sum_cancel,
                                  "count_cancel"=> $count_cancel,


                                    "sum_done"=> $sum_done,
                                    "count_done"=> $count_done,

                                 "total_sum"=>$total_sum,
                                 "total_count"=> $total_count,

                                

                                  ]);

    }


    public function refreshlivreurs(){
        $notes = Note::with('command')->with('command.livreur')->orderBy("created_at", "desc")->whereDate("created_at", today())->get();
   
      $livreurs = Livreur::where("certified_at", '!=', null)->with(['commands' => function($q) {
            $q->where('delivery_date', today());}])
        ->get();
        return response()->json(["livreurs"=>$livreurs]);
    }


     public function printing(Request $request){
  $day = date("d-m-Y");   
   $commands = Command::orderBy("delivery_date")->orderBy("adresse", "desc");
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


     return view("print")->with("commands", $commands)->with("day", $day);

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
      $livreurs =Livreur::where('status', 'active')->with("lesroutes")->with("notes")->get();
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
        return view('dashboard')->with("filter", $filter)->with("sources", $sources)->with('commands', $commands)->with('day', $day)->with('fees', $fees)->with('total', $total)->with("phone_check", $phone_check)->with('livreurs', $livreurs)->with('all_commands', $all_commands)->with('payments_by_livreurs', $payments_by_livreurs)->with('detail', 'tout')->with('encours_states', $encours_states)->with('nbre', $nbre)->with('state', $state)->with('attente', $attente)->with('undone_by_livreurs', $undone_by_livreurs)->with('cmds_by_city', $cmds_by_city)->with('cmds_by_livreur', $cmds_by_livreur)->with('current_date', $current_date)->with('chk', $chk)->with('final_destinations', $final_destinations)->with('upcomings', $upcomings)->with('upcomings_count', $upcomings_count)->with('certifications', $certifications)->with("start", $start)->with("end", $end)->with("cmds", $cmds->toJson())->with("products", $products->toJson())->with("filteredfees", $filteredfees)->with("filteredlivreurs", $filteredlivreurs)->with("clients", $clients);

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
            
      
     $client->client_type = $request->type;
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
    
   return view('users')->with('status', "Utilisateur Ajouté");

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
       
       $model = new Fee;
       
       $model->destination = $request->input('destination');
       $model->price = $request->input('price');
       $model->category = 1;
       $model->zone = $request->input('zone');

       $model->save();


       return redirect('/fees')->with('status', "Tarif Ajouté");

    }


    public function feelist()
    {
        
       $fees = Fee::paginate(100);
        
        
        return view('fee')->with('fees', $fees);

    }

     public function fees()
    {
        
       $fees = Fee::paginate(100);
        
        
        return view('fees')->with('fees', $fees);

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
       
       $model->category = 1;
       $model->zone = $request->input('zone');


       $model->save();


       return redirect('/fees')->with('status', "Tarif modifiée");
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






//charge
 public function chargeregister(Request $request)
    {
       
       $model = new Charge;
       
       
       $model->type = $request->input('type');
       $model->montant = $request->input('montant');
       
       $model->detail = $request->input('detail');
       $model->charge_date = $request->input('charge_date');
       $model->source = $request->source;
       
     

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
        
        $charge_natures = array('Facture eau', 'Facture electricite', 'Publicite', 'Loyer', 'Taxes',);

        $charge_types = array('Fixe', 'Variable');
        $sources = Source::all();


        return view('chargeregister')->with('charge_types',$charge_types )
        ->with('charge_natures',$charge_natures )->with('sources', $sources);

    }

     
     public function chargeedit($id)
    {
       $charge = Charge::findOrFail($id);
      
        $sources = Source::all();
        $charge_types = array('Facture eau', 'Facture electricite', 'Publicite', 'Autre');

       return view('chargeedit')->with('charge', $charge)->with('charge_types', $charge_types)->with("sources", $sources);
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

public function rapports(Request $request)
    {
      
      $clients = Client::all();

      $day = "Cette année";   
      
      $currentY = date("Y");
      $previousY = $currentY -1;

      $januarycmds = Command::whereBetween('delivery_date', [date("Y-01-01"), date("Y-01-31")])->where('etat', 'termine')->sum("montant");


      $februarycmds = Command::whereBetween('delivery_date', [date("Y-02-01"), date("Y-02-29")])->where('etat', 'termine')->sum("montant");

      $marchcmds = Command::whereBetween('delivery_date', [date("Y-03-01"), date("Y-03-31")])->where('etat', 'termine')->sum("montant");

      $aprilcmds = Command::whereBetween('delivery_date', [date("Y-04-01"), date("Y-04-30")])->where('etat', 'termine')->sum("montant");

      $maycmds = Command::whereBetween('delivery_date', [date("Y-05-01"), date("Y-05-31")])->where('etat', 'termine')->sum("montant");
     
      
      $juncmds = Command::whereBetween('delivery_date', [date("Y-06-01"), date("Y-06-30")])->where('etat', 'termine')->sum("montant");

      $julycmds = Command::whereBetween('delivery_date', [date("Y-07-01"), date("Y-07-31")])->where('etat', 'termine')->sum("montant");


      $augustcmds = Command::whereBetween('delivery_date', [date("Y-08-01"), date("Y-08-31")])->where('etat', 'termine')->sum("montant");

      $septembercmds = Command::whereBetween('delivery_date', [date("Y-09-01"), date("Y-09-30")])->where('etat', 'termine')->sum("montant");

      $octobercmds = Command::whereBetween('delivery_date', [date("Y-10-01"), date("Y-10-31")])->where('etat', 'termine')->sum("montant");

      $novembercmds = Command::whereBetween('delivery_date', [date("Y-11-01"), date("Y-11-30")])->where('etat', 'termine')->sum("montant");
     
      
      $decembercmds = Command::whereBetween('delivery_date', [date("Y-12-01"), date("Y-12-31")])->where('etat', 'termine')->sum("montant");


     //previous
      $pjanuarycmds = Command::whereBetween('delivery_date', [date($previousY."-01-01"), date($previousY."-01-31")])->where('etat', 'termine')->sum("montant");


      $pfebruarycmds = Command::whereBetween('delivery_date', [date($previousY."-02-01"), date($previousY."-02-29")])->where('etat', 'termine')->sum("montant");

      $pmarchcmds = Command::whereBetween('delivery_date', [date($previousY."-03-01"), date($previousY."-03-31")])->where('etat', 'termine')->sum("montant");

      $paprilcmds = Command::whereBetween('delivery_date', [date($previousY."-04-01"), date($previousY."-04-30")])->where('etat', 'termine')->sum("montant");

      $pmaycmds = Command::whereBetween('delivery_date', [date($previousY."-05-01"), date($previousY."-05-31")])->where('etat', 'termine')->sum("montant");
     
      
      $pjuncmds = Command::whereBetween('delivery_date', [date($previousY."-06-01"), date($previousY."-06-30")])->where('etat', 'termine')->sum("montant");

      $pjulycmds = Command::whereBetween('delivery_date', [date($previousY."-07-01"), date($previousY."-07-31")])->where('etat', 'termine')->sum("montant");


      $paugustcmds = Command::whereBetween('delivery_date', [date($previousY."-08-01"), date($previousY."-08-31")])->where('etat', 'termine')->sum("montant");

      $pseptembercmds = Command::whereBetween('delivery_date', [date($previousY."-09-01"), date($previousY."-09-30")])->where('etat', 'termine')->sum("montant");

      $poctobercmds = Command::whereBetween('delivery_date', [date($previousY."-10-01"), date($previousY."-10-31")])->where('etat', 'termine')->sum("montant");

      $pnovembercmds = Command::whereBetween('delivery_date', [date($previousY."-11-01"), date($previousY."-11-30")])->where('etat', 'termine')->sum("montant");
     
      
      $pdecembercmds = Command::whereBetween('delivery_date', [date($previousY."-12-01"), date($previousY."-12-31")])->where('etat', 'termine')->sum("montant");


          $all_fees = Fee::all();
     $all_livreurs = Livreur::all();   
     
     $start = date_create(date("Y")."-01-01");
      $end =date_create(date("Y")."-12-31");



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

       $commands = Command::whereBetween('delivery_date', [$start, $end])->where('etat', 'termine')->get();


          
          $charges = Charge::whereBetween('charge_date', [$start, $end])->sum('montant');  

     $charges_by_type = Charge::selectRaw('SUM(montant) Montant, (type) Nature')
    ->whereBetween('charge_date', [$start, $end])
    ->orderBy('Montant', 'desc')
    ->groupBy('Nature')
    ->get();     

    $command_by_clients = Command::selectRaw('SUM(montant) montant, (client_id) Client_id')
    ->whereBetween('delivery_date', [$start, $end])
    ->where('etat', 'termine')
     ->orderBy('montant', 'desc')
    ->groupBy('client_id')
    ->get();


    $command_by_fees = Command::selectRaw('SUM(montant) montant, (fee_id) fee_id')
    ->whereBetween('delivery_date', [$start, $end])
    ->where('etat', 'termine')
     ->orderBy('montant', 'desc')
    ->groupBy('fee_id')
    ->get();
   


   $command_by_livreurs = Command::selectRaw('SUM(montant) montant,  (livreur_id) livreur_id')
   ->whereBetween('delivery_date', [$start, $end])
    
     ->orderBy('montant', 'desc')
    ->groupBy('livreur_id')
    ->get();

    $sold_products = array();
    $sales_by_products = array();
    

    $commands_with_products = Command::with("products")->whereBetween('delivery_date', [$start, $end])->where("etat", "termine")->get();

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
        
        return view('rapports')->with('charges', $charges)->with('charges_by_type', $charges_by_type)->with('command_by_clients', $command_by_clients)->with('clients', $clients)->with('all_fees', $all_fees)->with('command_by_fees', $command_by_fees)->with('command_by_livreurs', $command_by_livreurs)->with('all_livreurs', $all_livreurs)->with("commands", $commands)->with("day", $day)->with("januarycmds", $januarycmds)->with("februarycmds", $februarycmds)->with("marchcmds", $marchcmds)->with("aprilcmds", $aprilcmds)->with("maycmds", $maycmds)->with("juncmds", $juncmds)->with("julycmds", $julycmds)->with("augustcmds", $augustcmds)->with("septembercmds", $septembercmds)->with("octobercmds", $octobercmds)->with("novembercmds", $novembercmds)->with("decembercmds", $decembercmds)->with("pjanuarycmds", $pjanuarycmds)->with("pfebruarycmds", $pfebruarycmds)->with("pmarchcmds", $pmarchcmds)->with("paprilcmds", $paprilcmds)->with("pmaycmds", $pmaycmds)->with("pjuncmds", $pjuncmds)->with("pjulycmds", $pjulycmds)->with("paugustcmds", $paugustcmds)->with("pseptembercmds", $pseptembercmds)->with("poctobercmds", $poctobercmds)->with("pnovembercmds", $pnovembercmds)->with("pdecembercmds", $pdecembercmds)->with("products", $products)->with("canceled_products", $canceled_products)->with("currentY", $currentY)->with("previousY", $previousY);

    }


public function rapport(Request $request)
    {
      
      $clients = Client::all();

      $day = "Cette année";   
      
      $currentY = date("Y");

      $januarycmds = Command::whereBetween('delivery_date', [date("Y-01-01"), date("Y-01-31")])->where('etat', 'termine')->sum("montant");


      $februarycmds = Command::whereBetween('delivery_date', [date("Y-02-01"), date("Y-02-29")])->where('etat', 'termine')->sum("montant");

      $marchcmds = Command::whereBetween('delivery_date', [date("Y-03-01"), date("Y-03-31")])->where('etat', 'termine')->sum("montant");

      $aprilcmds = Command::whereBetween('delivery_date', [date("Y-04-01"), date("Y-04-30")])->where('etat', 'termine')->sum("montant");

      $maycmds = Command::whereBetween('delivery_date', [date("Y-05-01"), date("Y-05-31")])->where('etat', 'termine')->sum("montant");
     
      
      $juncmds = Command::whereBetween('delivery_date', [date("Y-06-01"), date("Y-06-30")])->where('etat', 'termine')->sum("montant");

      $julycmds = Command::whereBetween('delivery_date', [date("Y-07-01"), date("Y-07-31")])->where('etat', 'termine')->sum("montant");


      $augustcmds = Command::whereBetween('delivery_date', [date("Y-08-01"), date("Y-08-31")])->where('etat', 'termine')->sum("montant");

      $septembercmds = Command::whereBetween('delivery_date', [date("Y-09-01"), date("Y-09-30")])->where('etat', 'termine')->sum("montant");

      $octobercmds = Command::whereBetween('delivery_date', [date("Y-10-01"), date("Y-10-31")])->where('etat', 'termine')->sum("montant");

      $novembercmds = Command::whereBetween('delivery_date', [date("Y-11-01"), date("Y-11-30")])->where('etat', 'termine')->sum("montant");
     
      
      $decembercmds = Command::whereBetween('delivery_date', [date("Y-12-01"), date("Y-12-31")])->where('etat', 'termine')->sum("montant");


          $all_fees = Fee::all();
     $all_livreurs = Livreur::all();   
     
     $start = date_create(date("Y")."-01-01");
      $end =date_create(date("Y")."-12-31");



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

       $commands = Command::whereBetween('delivery_date', [$start, $end])->where('etat', 'termine')->get();
          
          $charges = Charge::whereBetween('charge_date', [$start, $end])->sum('montant');  

     $charges_by_type = Charge::selectRaw('SUM(montant) Montant, (type) Nature')
    ->whereBetween('charge_date', [$start, $end])
    ->orderBy('Montant', 'desc')
    ->groupBy('Nature')
    ->get();     

    $command_by_clients = Command::selectRaw('SUM(montant) montant, (client_id) Client_id')
    ->whereBetween('delivery_date', [$start, $end])
    ->where('etat', 'termine')
     ->orderBy('Montant', 'desc')
    ->groupBy('client_id')
    ->get();


    $command_by_fees = Command::selectRaw('SUM(montant) montant, (fee_id) fee_id')
    ->whereBetween('delivery_date', [$start, $end])
    ->where('etat', 'termine')
     ->orderBy('montant', 'desc')
    ->groupBy('fee_id')
    ->get();
   


   $command_by_livreurs = Command::selectRaw('SUM(montant) montant,  (livreur_id) livreur_id')
   ->whereBetween('delivery_date', [$start, $end])
    ->where('etat', 'termine')
     ->orderBy('montant', 'desc')
    ->groupBy('livreur_id')
    ->get();

   

        
        return view('rapport')->with('charges', $charges)->with('charges_by_type', $charges_by_type)->with('command_by_clients', $command_by_clients)->with('clients', $clients)->with('all_fees', $all_fees)->with('command_by_fees', $command_by_fees)->with('command_by_livreurs', $command_by_livreurs)->with('all_livreurs', $all_livreurs)->with("commands", $commands)->with("day", $day)->with("januarycmds", $januarycmds)->with("februarycmds", $februarycmds)->with("marchcmds", $marchcmds)->with("aprilcmds", $aprilcmds)->with("maycmds", $maycmds)->with("juncmds", $juncmds)->with("julycmds", $julycmds)->with("augustcmds", $augustcmds)->with("septembercmds", $septembercmds)->with("octobercmds", $octobercmds)->with("novembercmds", $novembercmds)->with("decembercmds", $decembercmds);

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


public function setconseiller(Request $request){
  $client = Client::findOrFail($request->client_id);
  $client->cc_id = $request->cc_id;

  $client->update();

  return redirect()->back()->with("status", "Conseiller defini");
}
}
