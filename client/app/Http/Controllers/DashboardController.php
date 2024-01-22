<?php

namespace App\Http\Controllers\Admin;
use App\User;
use App\Command;
use App\Client;
use App\Manager;
use App\Fee;
use App\Livreur;
use App\Friendship;
use App\Verify;
use App\Fast_command;
use App\Lesroute;
use App\Payment;
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

class DashboardController extends Controller
{

  public function editaccount(Request $request) 
  {


        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string'],
            'adresse' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'max:10'],
           
        ]);

        $id = Auth::user()->client_id;

        $client = Client::findOrFail($id);

        $client->nom = $request->name;
        $client->city = $request->city;
        $client->adresse = $request->adresse;
        $client->phone = $request->phone;

        Auth::user()->phone = $request->phone;
       
        Auth::user()->update();
        $client->update();  

        return redirect()->back()
            ->with('status','Profile modifié.');

  } 


  public function editpassword(Request $request) 
  {
      



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


public function photoupload(Request $req){
        $req->validate([
        'file' => 'required|mimes:jpeg,png|max:2048'
        ]);
        
        $id = Auth::user()->client_id;
        
        $fileModel = Client::findOrFail($id);

        if($req->file()) { 
            
            $path = Storage::disk('s3')->put('image',$req->file, 'public');
            
            
            
            
            $fileModel->photo = $path;
            $fileModel->update();

            return redirect()->back()
            ->with('status','Photo enregistrée.');
        }
   }





   
   public function ratelivreur(Request $request)
  {
   request()->validate(['rate' => 'required']);
   $livreur = Livreur::findOrFail($request->id);

   $rating = new Rating; 

   $rating->rating = $request->rate;
   $rating->user_id = auth()->user()->id;

   $livreur->ratings()->save($rating);
   response()->json([]);
  }

  public function getnearby(Request $request)
  {
    
   function datediff($date1, $date2){
  
        $diff=date_diff($date1,$date2);
       $days = $diff->format("%d");
       $hours = $diff->format("%H");
       $mn =  $diff->format("%i");
       $periode = array('Jours'=>$days, 'h'=>$hours, 'mns'=>$mn);
      $duration = "";
       
       foreach ($periode as $key => $value) {
         if($value != 0)
         {
          $duration .= $value.$key;
         }

      
   }
     return $duration ;
 }
   function distance($lat1, $lon1, $lat2, $lon2, $unit) {
  if (($lat1 == $lat2) && ($lon1 == $lon2)) {
    return 0;
  }
  else {
    $theta = $lon1 - $lon2;
    $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
    $dist = acos($dist);
    $dist = rad2deg($dist);
    $miles = $dist * 60 * 1.1515;
    $unit = strtoupper($unit);

    if ($unit == "K") {
      return ($miles * 1.609344);
    } elseif ($unit == "N") {
      return ($miles * 0.8684);
    } else {
      return $miles;
    }
  }
}


$cmd_id = $request->cmd_id;
    $lat = $request->lat; 
    $long = $request->long;
    $cur = date_create(date("Y-m-d H:i:s"));
    

    $livreurs = Livreur::where('latitude', '!=', null)->where('longitude', '!=', null)
                        ->where('geotime', '!=', null)->orderBy('geotime', 'desc')
                        ->where('status', 'active')->limit(10)->get();

 
  $nearby = '';
  $title = "Livreurs à proximité " ;
 $title2 = "";
 $assign_script="";
  if(count($livreurs)>0){
    foreach($livreurs as $livreur){
      if( distance($livreur->latitude, $livreur->longitude, $lat, $long, 'K') <=3 ){
       $remaining = $livreur->commands->where('etat', '!=', 'termine')->where('etat', '!=', 'annule')->where('delivery_date', today())->count();
            
          $nearby .="<div>" .mb_strtoupper(mb_substr($livreur->nom,0,15))."... <div class='float-right'><button  type='button' class='assign btn btn-outline-primary ' data-mdl='LivChoice".$cmd_id."' data-cur='cur_liv".$cmd_id."' data-id='".$cmd_id. "' value='".$livreur->id. "'  > Assigner  </button><a style=' font-weight: bold;' href='tel:".$livreur->phone."' class='btn btn-primary '>
                 <ion-icon name='call-outline'></ion-icon></a></div></div> <strong style='font-size:10px;' >A ". $remaining  . " livraison(s) encours </strong><br> se trouve à ".number_format(distance($livreur->latitude, $livreur->longitude, $lat, $long, 'K') , 2, '.', ',')
      ."km il y a ".datediff(date_create($livreur->geotime), $cur). "<hr>";

      }
    }

 
    $assign_script = "<script>
        $('.assign').click( function() {
  var cmd_id = $(this).data('id');
  var cur_liv = $(this).data('cur');
  var cur_mdl = $(this).data('mdl');
  var livreur_id = $(this).val();
  var current = $(this);

  var current_livreur = $('#'+cur_liv);
  var current_modal =  $('#LivChoice');
 
    $.ajax({
      url: 'assigncmd',
      type: 'post',
      data: {_token: CSRF_TOKEN,cmd_id: cmd_id,livreur_id: livreur_id},
      success: function(response){
        if(response.livreur_id == 11)
         {alert('Assignation annulée');
               (current_livreur).text('');
               (current_modal).modal('hide');
             }
       else
         {alert('Commande assigné à '+response.cur_liv);
               (current_livreur).html(response.cur_liv);
                 (current_modal).modal('hide');

             }
             }

             
    });
});  
       </script>";
  }
    else{
   $title2 ="Il n'y a aucun livreur à proximité";
    }

    return response()->json(['nearby'=>$nearby, 'assign_script'=>$assign_script, 'title'=>$title, 'title2'=>$title2]);
  
  }




public function getglobalnearby(Request $request)
  {             
    
   function datediff($date1, $date2){
  
        $diff=date_diff($date1,$date2);
       $days = $diff->format("%d");
       $hours = $diff->format("%H");
       $mn =  $diff->format("%i");
       $periode = array('Jours'=>$days, 'h'=>$hours, 'mns'=>$mn);
      $duration = "";
       
       foreach ($periode as $key => $value) {
         if($value != 0)
         {
          $duration .= $value.$key;
         }

      
   }
     return $duration ;
 }
   function distance($lat1, $lon1, $lat2, $lon2, $unit) {
  if (($lat1 == $lat2) && ($lon1 == $lon2)) {
    return 0;
  }
  else {
    $theta = $lon1 - $lon2;
    $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
    $dist = acos($dist);
    $dist = rad2deg($dist);
    $miles = $dist * 60 * 1.1515;
    $unit = strtoupper($unit);

    if ($unit == "K") {
      return ($miles * 1.609344);
    } elseif ($unit == "N") {
      return ($miles * 0.8684);
    } else {
      return $miles;
    }
  }
}



    $lat = $request->lat; 
    $long = $request->long;
    $cur = date_create(date("Y-m-d H:i:s"));
    

    $livreurs = Livreur::where('latitude', '!=', null)->where('longitude', '!=', null)
                        ->where('geotime', '!=', null)->orderBy('geotime', 'desc')
                        ->where('status', 'active')->limit(10)->get();

 
  $nearby = "<div class='transactions'>";
  
 $title2 = "";
 $assign_script="";
  if(count($livreurs)>0){
    foreach($livreurs as $livreur){
      if( distance($livreur->latitude, $livreur->longitude, $lat, $long, 'K') <=5 ){
       $remaining = $livreur->commands->where('etat', '!=', 'termine')->where('etat', '!=', 'annule')->where('delivery_date', today())->count();
            $cert = "";
          if($livreur->certified_at != NULL)
          {
            $cert = "<span class='text-success'><ion-icon name='checkmark-outline'></ion-icon>Certifié</span><br>";
          }


      $nearby .=    "<span  class='item'>
                    <div class='detail'>
                        
                        <img ";

                         if(Storage::disk('s3')->exists($livreur->photo))
                        {$nearby .= "  src='https://livreurjibiat.s3.eu-west-3.amazonaws.com/".$livreur->photo."'  class='image-block imaged big' ";}
                         else { $nearby .= "src='assets/img/sample/brand/1.jpg' alt='img' ";}
                        

  $nearby .=  "class='image-block imaged'
                    alt='img' width='80'>



                        <div>

                        <strong>".$livreur->nom." ".$cert ."</strong>
                           ";

                      $nearby .= "<ion-icon name='location-outline'></ion-icon> Se trouve à ".number_format(distance($livreur->latitude, $livreur->longitude, $lat, $long, 'K') , 2, '.', ',')
      ."km il y a ".datediff(date_create($livreur->geotime), $cur).".<br><br>";     
              $nearby .=  $remaining  . " livraison(s) encours";
              

              $fees = Fee::all();

        $zone_output = "";


         $by_zone = Command::where("livreur_id", $livreur->id)->selectRaw('COUNT(fee_id) nbre, (fee_id) fee_id')
     ->where('etat', '!=', 'termine')->where('etat', '!=', 'annule')->where('delivery_date', today())
    ->groupBy('fee_id')
    ->get();


    foreach($by_zone as $zone)
  {
   $zone_output .= "<div class='chip chip-media' style='margin-bottom: 3px'>
                     <i class='chip-icon  bg-success '>".
                      $zone->nbre
                        ."</i>
                       <span class='chip-label'>";
     foreach($fees as $fee2)
       {
         if($zone->fee_id == $fee2->id)
           {$zone_output .= $fee2->destination;}
       }

       $zone_output .= "</span>
                    </div>";
    }

        $route = Lesroute::where('livreur_id', $livreur->id)->where('action', "STATUS")->orderBy('created_at', "desc")->first();

        if($route)
         {$zone_output .= "<div class='text-primary'>Dernière Action: ". $route->observation. " - ".$route->created_at->format("d-m-Y H:i"). "</div>";}
$nearby .= $zone_output;


                

                     $nearby .=   "<a type='button' style=' font-weight: bold;' href='tel:".$livreur->phone."' class='btn btn-primary phone'>
                       <ion-icon name='call-outline'></ion-icon></a>";

                          
                    

              

          

      
      $nearby .=  " </div>
                    </div>";
                   
                   $nearby .= "</span> ";

      }
    }

 
   
  }
    else{
   $nearby ="Il n'y a aucun livreur à proximité";
    }
   $nearby .= "</div>";
    return response()->json(['nearby'=>$nearby]);
  
  }







   public function commands(Request $request)
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

      $payments_by_livreurs = Payment::orderBy('created_at', 'desc')
      ->selectRaw('SUM(montant) montant, (livreur_id) livreur_id')
     ->where('client_id', $id)
     ->where('etat', 'en attente')
      ->where('montant', '>', 0)
     ->whereIn('livreur_id', $active_liv_ids)
    ->groupBy('livreur_id')
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

 if($request->input('route_day') && validateDate($request->input('route_day')))
      {


        $day = date_format(date_create($request->input('route_day')), 'Y-m-d');
        $current_date = $day;
      $commands = Command::orderBy('delivery_date', 'desc')

                  ->whereDate('delivery_date', $day)
                  ->where('client_id', $id);
                  

      $cmds_by_city = Command::selectRaw('COUNT(id) nbre, (fee_id) fee_id')
                              ->whereDate('delivery_date', $day)
                             ->where('client_id', $id);

      $cmds_by_livreur = Command::selectRaw('COUNT(id) nbre, (livreur_id) livreur_id')
                              ->whereDate('delivery_date', $day)
                             ->where('client_id', $id);                       

      $all_commands = Command::orderBy('delivery_date', 'desc')
              ->whereDate('delivery_date', $day)
                ->where('client_id', $id)
                  ->orderBy('fee_id', 'desc')
                 ->get();
 
      if($request->input('route_day') == today())
        {$day = "Aujourd'hui";  $current_date = date('Y-m-d');}

      else{ $day = $request->input('route_day') ;  $current_date = $day;}
        
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
     
     
      $commands = $commands->orderBy('adresse', 'asc')->get();
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

        return view('commands')->with('commands', $commands)->with('day', $day)->with('client', $client)->with('fees', $fees)->with('total', $total)->with("phone_check", $phone_check)->with('livreurs', $livreurs)->with('id', $id)->with('all_commands', $all_commands)->with('payments_by_livreurs', $payments_by_livreurs)->with('detail', 'tout')->with('encours_states', $encours_states)->with('nbre', $nbre)->with('state', $state)->with('attente', $attente)->with('undone_by_livreurs', $undone_by_livreurs)->with('cmds_by_city', $cmds_by_city)->with('cmds_by_livreur', $cmds_by_livreur)->with('current_date', $current_date)->with('chk', $chk)->with('final_destinations', $final_destinations);

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

 if($request->input('route_day') && validateDate($request->input('route_day')))
      {


        $day = date_format(date_create($request->input('route_day')), 'Y-m-d');
        $current_date = $day;
      $commands = Command::orderBy('delivery_date', 'desc')

                  ->whereDate('delivery_date', $day)
                  ->where('client_id', $id);
                  

      $cmds_by_city = Command::selectRaw('COUNT(id) nbre, (fee_id) fee_id')
                              ->whereDate('delivery_date', $day)
                             ->where('client_id', $id);

      $cmds_by_livreur = Command::selectRaw('COUNT(id) nbre, (livreur_id) livreur_id')
                              ->whereDate('delivery_date', $day)
                             ->where('client_id', $id);                       

      $all_commands = Command::orderBy('delivery_date', 'desc')
              ->whereDate('delivery_date', $day)
                ->where('client_id', $id)
                  ->orderBy('fee_id', 'desc')
                 ->get();
 
      if($request->input('route_day') == today())
        {$day = "Aujourd'hui";  $current_date = date('Y-m-d');}

      else{ $day = $request->input('route_day') ;  $current_date = $day;}
        
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

     
    
        return view('dashboard')->with('commands', $commands)->with('day', $day)->with('client', $client)->with('fees', $fees)->with('total', $total)->with("phone_check", $phone_check)->with('livreurs', $livreurs)->with('id', $id)->with('all_commands', $all_commands)->with('payments_by_livreurs', $payments_by_livreurs)->with('detail', 'tout')->with('encours_states', $encours_states)->with('nbre', $nbre)->with('state', $state)->with('attente', $attente)->with('undone_by_livreurs', $undone_by_livreurs)->with('cmds_by_city', $cmds_by_city)->with('cmds_by_livreur', $cmds_by_livreur)->with('current_date', $current_date)->with('chk', $chk)->with('final_destinations', $final_destinations);

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
        
        $client_id = Auth::user()->client_id;
        $delivery_date = $request->input('delivery_date');
        $phone = str_replace(' ', '',$request->input('phone'));
        $fee_id = $request->input('fee');
        $adresse = substr($request->input('adresse'),0,150);
        $observation = substr($request->input('observation'),0,150);
        $livraison = $request->input('livraison');
        $other_livraison = $request->input('other_liv');
        $actual_fee = Fee::findOrFail($request->input('fee'));
       
        $client = Client::findOrFail($client_id);
        $montant = preg_replace('/[^0-9]/', '', $request->input('montant'));
        
        if(!is_numeric($montant)){$montant = 0;}
         
        $goods_type = substr($request->input('type'),0,150);

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

       if($livraison == 'autre' && is_numeric($other_livraison))
       {
        $model->livraison = $other_livraison;
       }

       if(is_numeric($livraison)){$model->livraison = $livraison;}

       
       $model->observation = $observation;
        



       
       $model->save();
     

       $new_id = $model->id;
       $new_phone = $model->phone;
       // the message
// $msg = "$name a ajouté la commande numero $new_id\n";

// use wordwrap() if lines are longer than 70 characters
// $msg = wordwrap($msg,70);

// send email
// mail("jibiatonline@gmail.com","Commande $new_id de $name",$msg);
      

   $check_fast_command = Fast_command::where('description', $model->description)
                                               ->where('price', $model->montant)
                                               ->where('fee_id', $model->fee_id)
                                               ->where('client_id', $client_id)
                                               ->get();

   $add_fast = '';                                            

   if($check_fast_command->count() == 0 )
   {
     $add_fast = 'ok';
   }  

   $command = $model;

   if($command->livraison != NULL) {$total = $command->montant+$command->livraison;}  
            else {$total = $command->montant+$command->fee->price;} 

  $new_command =  array('data-desc' => $command->description, 'data-id'=>$command->id, 'data-date'=>$command->delivery_date->format('Y-m-d'), "data-montant"=>$command->montant, "data-fee"=>$command->fee_id, "data-adrs"=>$command->adresse, "data-phone"=>$command->phone, "data-observation"=>$command->observation, "data-etat" =>$command->etat, "data-livphone" =>$command->livreur->phone, 'data-total'=>$total,
"data-com"=>substr($command->adresse,strlen($command->fee->destination)+1), "data-liv"=>$command->livraison);
    
          
   
   


   
       
       return redirect()->back()->with('status', "Commande Ajoutée.")->with('new_id', $new_id)->with('new_phone', $new_phone)->with('add_fast', $add_fast)->with('new_command', $new_command);
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

       
       if($livraison == 'autre' && is_numeric($other_livraison))
       {
        $model->livraison = $other_livraison;
       }

       if(is_numeric($livraison)){$model->livraison = $livraison;}

       
       $model->observation = substr($request->input('observation'),0,150);

       $model->update();
      
      if($model->payment)
        {
          $model->payment->montant = $model->montant;

          $model->payment->update();
        }

       
      

       
       return redirect()->back()->with('status', "Commande modifiée.");
    }

    

    
public function point(Request $request)
{
  $id = Auth::user()->client_id;
  $client = Client::findOrFail($id);
  $etats = array('annule', 'termine');
  $months  = array('01' =>'Janvier' , '02' =>'Fevrier' , '03' =>'Mars' ,'04' =>'Avril' ,'05' =>'Mai' ,'06' =>'Juin' ,'07' =>'Juillet' ,'08' =>'Aout' ,'09' =>'Septembre' ,'10' =>'Octobre' ,'11' =>'Novembre' ,'12' =>'Decembre' );

  $month = "";
  $year = "";
 
  $all_fees = Fee::all();
  $sales = Command::where("etat", "termine")->where('client_id', $id);

  $sales_by_zone = Command::selectRaw('SUM(montant) montant, (fee_id) fee_id')
       ->where('client_id', $id)
       ->where('etat', 'termine');

 if($request->has('period'))
  {
    
      $period = $request->period;
      

      if($period == "curmonth"){$month = date('m'); $year = date('Y'); $sales = $sales->whereMonth('delivery_date', $month)->whereYear("delivery_date", $year); 
        $sales_by_zone = $sales_by_zone->whereMonth('delivery_date', $month)->whereYear("delivery_date", $year);

    }

      if($period == "lastmonth"){
        if(date('m')-1 == 0){$month = 12; $year = date('Y')-1;}else{$month = date('m'); $year = date('Y');}

          $sales = $sales->whereMonth('delivery_date', $month)->whereYear("delivery_date", $year);

          $sales_by_zone = $sales_by_zone->whereMonth('delivery_date', $month)->whereYear("delivery_date", $year);
        }

         if($period == "curyear"){$year = date('Y');
         $sales = $sales->whereYear("delivery_date", $year);

    $sales_by_zone = $sales_by_zone->whereYear("delivery_date", $year);
       }

      if($period == "lastyear"){
        $year = date('Y')-1;
        $sales = $sales->whereYear("delivery_date", $year);

        $sales_by_zone = $sales_by_zone->whereYear("delivery_date", $year);

      }


        }
  
  


$sales = $sales->get();
$sales_by_zone = $sales_by_zone->groupBy('fee_id')->orderBy('montant', 'desc')->get();
  

  return view('point')->with('$month', $month)->with('sales', $sales)->with('sales_by_zone', $sales_by_zone)->with('year', $year)->with('month', $month)->with('months', $months)->with('all_fees', $all_fees)->with('client', $client);
}

public function setready(Request $request){
  $id = $request->input('cmd_id');

  $model = Command::findOrFail($id);
  if($request->input('ready') == "yes")

  {
    $model->ready = "yes";
    $message = "Commande prête pour récupération";
  }

   else{
       $model->ready = null;
       $message = "Statut 'prêt' annulé";
       }

  $model->update();
  return response()->json(['message'=>$message]);
  
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


public function reset(Request $request){
  $id = $request->id;

  $model = Command::findOrFail($id);
   $model->etat = 'encours';
   $model->livreur_id = 11;
   

  $model->update();

  return redirect()->back()->with('status', "Commande reinitialisée.");
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





public function livreurs(Request $request){
 $id = Auth::user()->client_id;
 $client=Client::findOrFail($id); 
 $client_commands = Command::where('client_id', $id)->where("etat", "encours")->where("delivery_date", "=", today())->orWhere("delivery_date", "=", date("Y-m-d", strtotime('tomorrow')))->orderBy('delivery_date', 'asc')->get();


 $client_verify = Verify::where('client_id', $client->id)->get();
 $verify = Verify::all();

$cmd_by_zone  = Command::selectRaw('COUNT(id) nbre, (fee_id) fee_id')
       ->where('client_id', $id)
       ->where('etat', 'encours')
       ->whereDate('delivery_date','>=', today())
      ->groupBy('fee_id')
      ->get();
 

 





$livreurs = Livreur::where('status', 'active')->where('id', '!=', 9)->where('id', '!=', 20)->where('id', '!=', 81);


          
 $zone = "Tous les livreurs"; 
 if($request->input('city'))
  {$livreurs = Livreur::where('city', $request->city)->where('status', 'active'); $zone = $request->city;}

   
 if($request->input('livreur_id'))
  {
    $livreurs = Livreur::where('id',$request->input('livreur_id'))                ->where('status', 'active')
                        ->orWhere('nom', 'like','%'.$request->input('livreur_id').'%')
                        ->orWhere('phone', 'like','%'.$request->input('livreur_id').'%');  
   $zone = "Resultat de votre recherche";
  }

  if($request->input('asearch'))
  {
     $livreurs = Livreur::where("status","active");

     if(!empty($request->input("cities")) )
     {
      $cities = $request->input("cities");
      $livreurs = $livreurs->whereIn("city", $cities);
     }
     
     if($request->input("certified") == 1)
     {
      $livreurs = $livreurs->where("certified_at", "!=", NULL); 
     }

    $zone = "Resultat de votre recherche";
  }


$livreurs = $livreurs->where("certified_at", "!=", "NULL")->orderBy("jibiat_reliability", "desc")->paginate(20);

 $fees = Fee::where('category', Auth::user()->category)->orderBy('destination', 'asc')->get();
 return view('livreurs')->with('livreurs', $livreurs)->with('client', $client)->with('zone', $zone)->with('id', $id)->with('client_commands', $client_commands)->with('fees', $fees)->with('verify', $verify)->with('client_verify', $client_verify);
}




public function managers(Request $request){
 $id = Auth::user()->manager_id;
 $client=Manager::findOrFail($id); 
 
 

 



 $oth_city_managers = Manager::where('city', '!=', $client->city);

$client_city_managers = Manager::where('city', $client->city);


$managers = $client_city_managers
           ->union($oth_city_managers);


          
 $zone = "Toutes les entreprises"; 
 

   
 if($request->input('manager_search'))
  {
    $managers = Manager::where('id',$request->input('manager_id'))
                        ->orWhere('nom', 'like','%'.$request->input('manager_search').'%')
                        ->orWhere('phone', 'like','%'.$request->input('manager_search').'%')->orWhere('company', 'like','%'.$request->input('manager_search').'%');  
   $zone = "Resultat de votre recherche";
  }



$managers = $managers->paginate(20);

 
 return view('managers')->with('managers', $managers)->with('client', $client)->with('zone', $zone)->with('id', $id);
}



public function meslivreurs(){
  $id = Auth::user()->client_id;
 $client=Client::findOrFail($id);

  $livreurs = $client->livreurs()->get();
  return view('meslivreurs')->with('livreurs', $livreurs)->with('client', $client);

}





function daily(Request $request){
   $client_id = Auth::user()->client_id;
   $client = Client::findOrFail($client_id); 
  $livreur_id = $request->input('livreur_id');
  $livreurs = $client->livreurs;
  $livreur = Livreur::findOrFail($livreur_id);

  $commands_by_date = Command::selectRaw('SUM(montant) montant, (delivery_date) cmd_date')
       ->where('client_id', $client->id)
       ->where('livreur_id', $livreur_id)
       ->orderBy('delivery_date', 'desc')
      ->groupBy('delivery_date')
      ->limit(20)
       ->get();




  $commands_nbre_by_date = Command::selectRaw('COUNT(id) nbre, (delivery_date) cmd_date')
       ->where('client_id', $client->id)
       ->where('livreur_id', $livreur_id)
       ->orderBy('delivery_date', 'desc')
      ->groupBy('delivery_date')
           
      ->get();

   $active_liv_ids = array();

      foreach ($livreurs as $key => $livreur2) {
        if($livreur2->id != $livreur->id)
        {$active_liv_ids[] = $livreur2->id;}
      }


      $payments_by_livreurs = Payment::selectRaw('SUM(montant) montant, (livreur_id) livreur_id')
     ->where('client_id', $client->id)
     ->where('etat', 'en attente')
     ->whereIn('livreur_id', $active_liv_ids)
    ->groupBy('livreur_id')
    ->get();


   
  $unpayed_by_date = Payment::selectRaw('SUM(montant) montant, DATE_FORMAT(created_at, "%Y-%m-%d") pay_date')
         ->where('client_id', $client->id)
         ->where('etat', 'en attente')
         ->where('livreur_id', $livreur_id)
        ->groupBy('pay_date')
        ->get();  

  $done_by_date = Command::selectRaw('COUNT(id) nbre, (delivery_date) cmd_date')
       ->where('client_id', $client->id)
       ->where('etat', 'termine')
       ->where('livreur_id', $livreur_id)
      ->groupBy('delivery_date')
      ->get();


 $done_mt_by_date = Command::selectRaw('SUM(montant) montant, (delivery_date) cmd_date')
       ->where('client_id', $client->id)
       ->where('etat', 'termine')
       ->where('livreur_id', $livreur_id)
      ->groupBy('delivery_date')
      ->get();     

 $undone_by_date = Command::selectRaw('COUNT(id) nbre, (delivery_date) cmd_date')
       ->where('client_id', $client->id)
       ->where('etat', '!=', 'termine')
       ->where('livreur_id', $livreur_id)
      ->groupBy('delivery_date')
      ->get();     



return view('daily')->with('commands_by_date', $commands_by_date)->with('livreur', $livreur)->with('done_by_date',$done_by_date)->with('undone_by_date', $undone_by_date)->with('livreurs', $livreurs)->with('unpayed_by_date', $unpayed_by_date)->with('payments_by_livreurs', $payments_by_livreurs)->with('done_mt_by_date', $done_mt_by_date)->with('commands_nbre_by_date', $commands_nbre_by_date);
  

}




 // Update record
  public function assigncommand(Request $request){

    $livreur_id = $request->input('livreur_id');
    
    $cmd_id = $request->input('cmd_id');
    
    $livreur = Livreur::findOrFail($livreur_id);
    $command = Command::findOrFail($cmd_id);
    $command->livreur_id = $livreur_id;

    $command->update();
    $cur_liv = substr($livreur->nom, 0, 20).'<a class="btn btn-icon btn-primary mr-1 phone" href="tel:$livreur->phone" >
                            <ion-icon class="" name="call-outline"></ion-icon>
                         </a>
                         <a class="btn btn-icon btn-primary mr-1 " href="sms:$livreur->phone?body=une commande assignée $command->adresse  $command->client->nom" >
                            <ion-icon class="phone" name="mail-outline"></ion-icon>
                         </a>';
    return response()->json(['cur_liv'=>$cur_liv, 'livreur_id'=>$livreur->id, 'liv_phone'=>$livreur->phone]);
  }



  // Update record
  public function assigncommandbulk(Request $request){

    $livreur_id = $request->input('livreur_id');
    
    $cmd_id = $request->input('cmd_id');
    
    $livreur = Livreur::findOrFail($livreur_id);
    $ids = explode(',', $cmd_id);

    foreach($ids as $id)
    { 
      $command = Command::findOrFail($id);
      $command->livreur_id = $livreur_id;
      $command->update();
    }

    

   return response()->json(['cur_liv'=>$livreur->nom, 'livreur_id'=>$livreur->id, 'liv_phone'=>$livreur->phone]);
  }


  public function addlivreur(Request $request){
    $client_id = Auth::user()->client_id;
    $livreur_id = $request->input('livreur_id');

    $client = Client::findOrFail($client_id);

    $client->livreurs()->attach($livreur_id);

    $livreur = Livreur::findOrFail($livreur_id);
     return response()->json(['status'=>'Livreur ajouté', 'livreur'=>$livreur]);

   
    
  }


  public function removelivreur(Request $request){
    $client_id = Auth::user()->client_id;
    $livreur_id = $request->input('livreur_id');

    $client = Client::findOrFail($client_id);

     $client->livreurs()->detach($livreur_id);
     return response()->json(['status'=>'Livreur supprimé']);

    
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



  function bydatedetail(Request $request){
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

  public function pay(Request $request){
    $unpayed_ids = $request->unpayed;
    $cmd_ids = array();
    $pay_methode = $request->pay_methode;
    $livreur_phone = $request->livreur_phone;

    foreach($unpayed_ids as $unpayed_id)
    {
      $payment = Payment::findOrFail($unpayed_id);
      $payment->etat = 'termine';
      $payment->payment_method;
      $payment->update();


      $cmd_ids[] = $payment->command_id;
      $pay_mt[] = $payment->montant;
    }
    $pay_montant = array_sum($pay_mt);
    $each_id = implode( ", ", $cmd_ids );

  if(strstr($_SERVER['HTTP_USER_AGENT'],'iPhone') || strstr($_SERVER['HTTP_USER_AGENT'],'iPad')) {
    $recu = "sms:$livreur_phone&body=Payement recu: " .$pay_montant . "FCFA Pour commandes numero $each_id. ".Auth::user()->nom.".";}

  else{$recu = "sms:$livreur_phone?body=Payement recu: " .$pay_montant . "FCFA Pour commandes numero $each_id. ".Auth::user()->name.".";}
    
    return redirect()->back()->with("status", "Payement effectué")->with("facture", $recu);
  }

  public function report(Request $request)
  {
    $cmd_id = $request->cmd_id;
    $cmd_date = $request->rprt_date;

    $command = Command::findOrFail($cmd_id);
    $command->delivery_date = $cmd_date;
    $command->etat = 'encours';

    $command->update();

  return response()->json(['status'=>"reporté"]);
  }



  public function cancelcmd(Request $request)
  {
    $cmd_id = $request->cmd_id;
    $cmd_state = $request->state;
     
    $command = Command::findOrFail($cmd_id);
    
    $command->etat = $cmd_state;

    $command->update();

  return response()->json(['state'=>$cmd_state]);
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
     $zone_output = "<div class='transactions'>";
     $other_output = "<div class='transactions'>";
    $title1 = "<h4>Ceux qui ont dejà des colis pour la zone "."<strong>" .$command->fee->zone ."</strong></h4>" ;
     

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
           $ot_remaining = $zn_lv->commands->where('etat', '!=', 'termine')->where('etat', '!=', 'annule')->where('delivery_date', today())->count();
      
      $by_zone = Command::where("livreur_id", $zn_lv->id)->selectRaw('COUNT(fee_id) nbre, (fee_id) fee_id')
     ->where('etat', '!=', 'termine')->where('etat', '!=', 'annule')->where('delivery_date', today())
    ->groupBy('fee_id')
    ->get();

    $zone_output .= "<span  class='item'>
                    <div class='detail'>
                        
                        <img ";

                         if(Storage::disk('s3')->exists($zn_lv->photo))
                        {$zone_output .= "  src='https://livreurjibiat.s3.eu-west-3.amazonaws.com/$zn_lv->photo'  class='image-block imaged big' ";}
                         else { $zone_output .= "src='assets/img/sample/brand/1.jpg' alt='img' ";}
                        

  $zone_output .=  "class='image-block imaged'
                    alt='img' width='80'>



                        <div>
                            <strong>$zn_lv->nom</strong>
                           ";
                  
                         
                        $zone_output .= $ot_remaining ." livraison(s) encours actuellement<br>";

                        foreach($by_zone as $zone)
                          {
                          
                         
                         $zone_output .= "<div class='chip chip-media' style='margin-bottom: 3px'>
                                                  <i class='chip-icon  bg-success '>
                                                      $zone->nbre
                                                  </i>
                                                  <span class='chip-label'>";

                        foreach($fees as $fee2)
                          {
                            if($zone->fee_id == $fee2->id)
                            {$zone_output .= $fee2->destination;}
                        }

                        $zone_output .=   "</span>
                    </div>";
                      }
                   
                         $route = Lesroute::where('livreur_id', $zn_lv->id)->where('action', "STATUS")->orderBy('created_at', "desc")->first();

                     $zone_output .=   "<br><button  type='button' class='assign btn  btn-primary ml-2' data-mdl='LivChoice".$command->id."' data-cur='cur_liv".$command->id."' data-id='".$command->id. "' value='".$zn_lv->id. "'> ".'Assigner'. "  </button><a type='button' style=' font-weight: bold;' href='tel:".$zn_lv->phone."' class='btn btn-primary phone'>
                       <ion-icon name='call-outline'></ion-icon></a>";

                          if($route)
                    {$zone_output .= "<div class='text-primary'>Dernière Action: ". $route->observation. " ".$route->created_at->format("H:i"). "</div>";}
                    $zone_output .=  " </div>
                    </div>";
                   
                   $zone_output .= "</span> ";
        }
       }else{$zone_output = "Aucun<br>";}  






       
       $title2 = "<h4>Les autres</h4>";
       $other_livreurs = $livreurs->whereNotIn('id', $liv_in_zone);
       $ot_covered = "";
       foreach($other_livreurs as $ot_lv)
         {
          
           $ot_remaining = $ot_lv->commands->where('etat', '!=', 'termine')->where('etat', '!=', 'annule')->where('delivery_date', today())->count();

       
     $by_zone2 = Command::where("livreur_id", $ot_lv->id)->selectRaw('COUNT(fee_id) nbre, (fee_id) fee_id')
     ->where('etat', '!=', 'termine')->where('etat', '!=', 'annule')->where('delivery_date', today())
    ->groupBy('fee_id')
    ->get();

     $other_output .= "<span  class='item'>
                    <div class='detail'>
                        
                        <img ";

                         if(Storage::disk('s3')->exists($ot_lv->photo))
                        {$other_output .= "  src='https://livreurjibiat.s3.eu-west-3.amazonaws.com/$ot_lv->photo'  class='image-block imaged big' ";}
                         else { $other_output .= "src='assets/img/sample/brand/1.jpg' alt='img' ";}
                        

  $other_output .=  "class='image-block imaged'
                    alt='img' width='80'>



                        <div>
                            <strong>$ot_lv->nom</strong>
                           ";
                  
                         
                        $other_output .= $ot_remaining ." livraison(s) encours actuellement<br>";

                        foreach($by_zone2 as $zone2)
                          {
                          
                         
                         $other_output .= "<div class='chip chip-media' style='margin-bottom: 3px'>
                                                  <i class='chip-icon  bg-success '>
                                                      $zone2->nbre
                                                  </i>
                                                  <span class='chip-label'>";

                        foreach($fees as $fee)
                          {
                            if($zone2->fee_id == $fee->id)
                            {$other_output .= $fee->destination;}
                        }

                        $other_output .=   "</span>
                    </div>";
                      }
                   
                         $route2 = Lesroute::where('livreur_id', $ot_lv->id)->where('action', "STATUS")->orderBy('created_at', "desc")->first();

                     $other_output .=   "<br><button  type='button' class='assign btn ml-2  btn-primary' data-mdl='LivChoice".$command->id."' data-cur='cur_liv".$command->id."' data-id='".$command->id. "' value='".$ot_lv->id. "'> ".'Assigner'. "  </button><a type='button' style=' font-weight: bold;' href='tel:".$ot_lv->phone."' class='btn btn-primary phone'>
                       <ion-icon name='call-outline'></ion-icon></a>";

                          if($route2)
                    {$other_output .= "<div class='text-primary'>Dernière Action: ". $route2->observation. " ".$route2->created_at->format("H:i"). "</div>";}
                    $other_output .=  " </div>
                    </div>";
                   
                   $other_output .= "</span> ";


               }
     
    
       
       $assign_script = "<script>
        $('.assign').click( function() {
  var cmd_id = $(this).data('id');
  var cur_liv = $(this).data('cur');
  var cur_mdl = $(this).data('mdl');
  var livreur_id = $(this).val();
  var current = $(this);

  var current_livreur = $('#'+cur_liv);
  var current_modal =  $('#LivChoice');
 
    $.ajax({
      url: 'assigncmd',
      type: 'post',
      data: {_token: CSRF_TOKEN,cmd_id: cmd_id,livreur_id: livreur_id},
      success: function(response){
        if(response.livreur_id == 11)
         {
          $('#stateModalBody').html('Assignation annulée');

               $('#'+cur_liv).html('Non assigné');
               (current_modal).modal('hide');
               $('#stateModal').modal('show');
             }
       else
         {
          $('#stateModalBody').html('Commande assigné à '+response.cur_liv);
          $('#'+cur_liv).html(response.cur_liv);
                 (current_modal).modal('hide');

      $('#stateModal').modal('show');

      setTimeout(function(){"."$('#stateModal').modal('hide')}, 2000);

          
               
             }
             }

             
    });
});  
       </script>
       ";
  $zone_output .= "</div>";
  $other_output .= "</div>";
  $unassign_btn = "";

  if($command->livreur_id != 11){
    $unassign_btn = " <button class='btn btn-danger assign' data-mdl='LivChoice$command->id' data-cur='cur_liv$command->id' data-id='$command->id' value='11'>Desassigner</button>";
  }
  
    return response()->json(['other_output'=>$other_output, 'zone_output'=>$zone_output, 'title1'=>$title1, 'title2'=>$title2, 'assign_script'=>$assign_script, 'unassign_btn'=>$unassign_btn]);
     }









  public function verify(Request $request){

    $livreur_id = $request->livreur_id;
    $piece = $request->piece;
    $state = "verified";



    $verify = new Verify;
    $verify->livreur_id = $livreur_id;
    $verify->piece = $piece;
    $verify->state = $state;
    $verify->client_id = Auth::user()->client_id;

    $verify->save();

    return redirect()->back()->with('status', "Identité vérifiée");


  }



  public function unverify(Request $request){

    $id = $request->livreur_id;
    
    $verify = Verify::where('livreur_id', $id)->where('client_id', Auth::user()->client_id);
    $verify->delete();

    return redirect()->back()->with('status', "Authentification supprimée");


  }


  public function setloc(Request $request)
  {
    $long = $request->long;
    $lat = $request->lat;

    $client = Client::findOrFail(Auth::user()->client_id);
    $client->longitude = $long;
    $client->latitude = $lat;

    $client->update();

  return response()->json(['status'=>"Position"]);
  }


public function currentpay(Request $request){
  $livreurs = Livreur::where("status", "active")->get();
  $client_id = Auth::user()->client_id;
  foreach($livreurs as $livreur){
    $active_liv_ids[] = $livreur->id;
  }

   $payments_by_livreurs = Payment::selectRaw('SUM(montant) montant, (livreur_id) livreur_id')
     ->where('client_id', $client_id)
     ->where('etat', 'en attente')
     ->where('montant', '>', 0)
     ->whereIn('livreur_id', $active_liv_ids)
    ->groupBy('livreur_id')
    ->get();

   $payed_field = "";
    
    if($payments_by_livreurs->count() > 0)
    {foreach($payments_by_livreurs as $payed){
          $payed_field .= '<div  class="card target" style="width: 100%;border-style: solid; border-width: 1px;">
                <ul  class="list-group list-group-flush">
                <li  class="pt-6 list-group-item">';
    
                foreach($livreurs as $livreur2){
        if($payed->livreur_id == $livreur2->id){
          $payed_field .= $livreur2->nom;
         }
       }
    
      
       $payed_field .= "<span style='font-weight: bold; color:red' class='float-right'>$payed->montant</span><br>

       <button id='payDetail$payed->livreur_id' class='btn btn-info btn-sm detail' value='$payed->livreur_id'>Voir details</button> 

       <button id='allPay$payed->livreur_id' class='btn btn-info btn-sm payall' value='$payed->livreur_id'>Tout payer</button>
                       </li></ul>


      <span hidden id='allPayButtons$payed->livreur_id'>
      <select class='form-control payMethod$payed->livreur_id' >
       <option value='no'>
        Choisir mode de paiement
       </option>

       <option value='Main à main'>
       Main à main
       </option>
       <option value='Mobile money'>
       Mobile money
       </option>
       <option value='Virement bancaire'>
        Virement bancaire
       </option>
      </select>
      
      
       <button id='allPayConfirm$payed->livreur_id' value='$payed->livreur_id'  class='btn btn-info allPayConfirm'  data-allPayButtons='allPayButtons$payed->livreur_id'>
        
        <span  hidden=\"hidden\" class=\"spinner-border spinner-border-sm allPaySpinner$payed->livreur_id\" role=\"status\" aria-hidden=\"true\"></span><span class=\"sr-only\"></span>
       
       Confirmé</button>
       <button value='$payed->livreur_id'  class='btn btn-danger allPayCancel$payed->livreur_id allPayCancel'>Annuler</button>
      </span>
 </div>";



      }



  $payed_field .= "


  <script>

 $('.allPayConfirm').click( function() {
       var livreur_id = $(this).val();
       var method = $('.payMethod'+livreur_id).val();
       var curallPaybtns = $(this).data('allPayButtons');
    
   
   $('.allPaySpinner'+livreur_id).removeAttr('hidden');

     if(method == 'no')
     {alert('veuillez choisr une methode de paiement');

      $('.allPaySpinner'+livreur_id).attr('hidden', 'hidden');}
     else {
      $.ajax({
            url: 'payall',
            type: 'post',
            data: {_token: CSRF_TOKEN,livreur_id: livreur_id, method:method},
        
            success: function(response){
                     $('#allPayButtons'+livreur_id).attr('class', 'alert alert-success');
                     $('#allPayButtons'+livreur_id).html('Payement effectué');
                     $('#payDetail'+livreur_id).attr('hidden', 'hidden');

                     $('.payeur').removeAttr('hidden');
                     $('.payeurid').val(livreur_id);
                     $('.payeurimg').attr('src', response.src);
                     $('.payeurnom').html(response.nom);
                      
                   },
        error: function(response){
                    
                     alert('Une erruer s\'est produite');
                     $('.allPaySpinner'+livreur_id).attr('hidden', 'hidden');
                   }
                  
          });}
   });


$('.payall').click(function(){
       $(this).attr('hidden', 'hidden');
    var id = $(this).val();
  $('#allPayButtons'+id).removeAttr('hidden');
  $('.allPayCancel'+id).removeAttr('hidden');
 
});


 $(\".allPayCancel\").click(function(){
   id = $(this).val();
     $(this).attr('hidden', 'hidden');
   $('#allPayButtons'+id).attr('hidden', 'hidden');
   $('#allPay'+id).removeAttr('hidden');
   $('#payDetail'+id).removeAttr('hidden');
});



           $('.detail').click( function() {
   var livreur_id = $(this).val();
   
    
   $('.payBody').html('<span   class=\"spinner-border spinner-border paySpinner\" role=\"status\" aria-hidden=\"true\"></span><span class=\"sr-only\"></span>');


     $.ajax({
       url: 'paydetail',
       type: 'post',
       data: {_token: CSRF_TOKEN,livreur_id: livreur_id},
   
       success: function(response){
                 $('.payReturn').removeAttr('hidden');
                $('.payBody').html(response.display);
                $('.payTotal').html('<strong>Total:' +response.total + '</strong>');
                 $('.payLivreur').html(response.livreur);
                 $('#singlePayScript').html(response.single_pay_script);
              },
   error: function(response){
               
                alert('Une erruer s\'est produite');
              }
             
     });
   });
   </script>";    
    }else{
      $payed_field = "Vous n'avez pas de commande impayées.";
    }

  return response()->json(['payed_field'=>$payed_field]);
}




public function paydetail(Request $request){
    $client_id = Auth::user()->client_id;
    $livreur_id = $request->livreur_id;

    $livreur =Livreur::findOrFail($livreur_id);

    $commands = Command::where('client_id', $client_id)
                         ->where('livreur_id', $livreur_id)
                         ->orderBy('delivery_date', 'desc')
                         ->where('etat', 'termine')
                         ->orderBy('etat', 'asc')

                         ->limit(100)
                         ->get();
$payed = array(); $done = array(); $total = array(); $unpayed_ids = array();

$single_pay_script = "<script>

    $('.singlePay').click(function(){
       $(this).attr('hidden', 'hidden');
    var id = $(this).val();
  $('#singlePayButtons'+id).removeAttr('hidden');
  $('.singlePayCancel'+id).removeAttr('hidden');
 
});


 $(\".singlePayCancel\").click(function(){
   id = $(this).val();
     $(this).attr('hidden', 'hidden');
   $('#singlePayButtons'+id).attr('hidden', 'hidden');
   $('#singlePay'+id).removeAttr('hidden');
   
});



  $('.singlePayConfirm').click( function() {
       var cmd_id = $(this).val();
       var method = $('.payMethod'+cmd_id).val();
       var curSinglePaybtns = $(this).data('singlePayButtons');
    
   
   $('.singlePaySpinner'+cmd_id).removeAttr('hidden');

     if(method == 'no')
     {alert('veuillez choisr une methode de paiement');

      $('.singlePaySpinner'+cmd_id).attr('hidden', 'hidden');}
     else {
      $.ajax({
            url: 'singlepay',
            type: 'post',
            data: {_token: CSRF_TOKEN,cmd_id: cmd_id, method:method},
        
            success: function(response){
                 
                     $('#singlePayButtons'+cmd_id).html('<span class=\'alert alert-success\'>Payement effectué</span>');
                      
                   },
        error: function(response){
                    
                     alert('Une erruer s\'est produite');
                     $('.singlePaySpinner'+cmd_id).attr('hidden', 'hidden');
                   }
                  
          });}
   });
</script>";

  foreach($commands as $command){
    $pay_state = "";
 
  if($command->payment && $command->payment->etat != 'termine')
    {
      
      $unpayed_ids[] = $command->payment->id;
      $total[] =       $command->montant;
        
    $class = 'class="badge badge-success"';
    $txt = "Livré";


      $note = "";
      $note_date ="";
     if($command->note->count() > 0)
      {
        $note = $command->note->last()->description;
       
       }


       $display[] = "<div  class='card target' style='width: 100%;border-style: solid; border-width: 1px;'>
    <ul class='list-group list-group-flush' id='cmd_id".$command->id."'><li  class='pt-6 list-group-item'><strong>#" .$command->id. "</strong><span id='cmd_state".$command->id."' ". $class .">".$txt ." ".$command->updated_at->format('d-m-Y H:i:s'). "</span><br> ". $command->montant. "<br> ".$command->adresse ." ". "<span id='paystate$command->id' >$pay_state</span><br>$note<br>
    <span class='payArea$command->id'>
      <button class='btn btn-info singlePay' id='singlePay$command->id' value='$command->id' >Payer</button> 
      </span>
      
     <span hidden id='singlePayButtons$command->id'>
      <select class='form-control payMethod$command->id' >
       <option value='no'>
        Choisir mode de paiement
       </option>

       <option value='Main à main'>
       Main à main
       </option>
       <option value='Mobile money'>
       Mobile money
       </option>
       <option value='Virement bancaire'>
        Virement bancaire
       </option>
      </select>
      
      
       <button id='singlePayConfirm$command->id' value='$command->id'  class='btn btn-info singlePayConfirm'  data-singlePayButtons='singlePayButtons$command->id'>
        
        <span  hidden=\"hidden\" class=\"spinner-border spinner-border-sm singlePaySpinner$command->id\" role=\"status\" aria-hidden=\"true\"></span><span class=\"sr-only\"></span>
       
       Confirmé</button>
       <button value='$command->id'  class='btn btn-danger singlePayCancel$command->id singlePayCancel'>Annuler</button>
      </span>
     
      </li></ul></div>
     
      

    
      ";
   }
       
}


   
   return response()->json(['single_pay_script'=>$single_pay_script, 'livreur'=>$livreur->nom,  'total'=>array_sum($total), 'display'=>$display]);                      
  }


public function singlepay(Request $request){
  $cmd_id = $request->cmd_id;
  $method = $request->method;
  $command = Command::findOrFail($cmd_id);
  $command->payment->etat = 'termine';
  $command->payment->payment_method = $method;
  $command->payment->update();

  return response()->json(['status'=>'Payé']);

  }

public function payall(Request $request){


    $livreur_id = $request->livreur_id;
    $client_id = Auth::user()->client_id;
    $method = $request->method;
    $unpayeds = Payment::where('livreur_id', $livreur_id)->where('client_id', $client_id)
                         ->where("etat", "en attente")->get();
    
    $livreur = Livreur::findOrFail($livreur_id);

    if(Storage::disk('s3')->exists($livreur->photo))
      {$src=Storage::disk('s3')->url($livreur->photo);}
              else {$src="assets/img/sample/brand/1.jpg";}


       $nom = $livreur->nom;
    $route_ids = "";
    $route_montant = array();

    foreach($unpayeds as $payment)
    {
      $route_montant[] = $payment->montant;
      $route_ids .= $payment->command_id. ",";
      $payment->etat = 'termine';
      $payment->payment_method = $method;
      $payment->update();
    }

  //   foreach($unpayed_ids as $unpayed_id)
  //   {
  //     $payment = Payment::findOrFail($unpayed_id);
  //     $payment->etat = 'termine';
  //     $payment->payment_method;
  //     $payment->update();


  //     $cmd_ids[] = $payment->command_id;
  //     $pay_mt[] = $payment->montant;
  //   }
  //   $pay_montant = array_sum($pay_mt);
  //   $each_id = implode( ", ", $cmd_ids );

  // if(strstr($_SERVER['HTTP_USER_AGENT'],'iPhone') || strstr($_SERVER['HTTP_USER_AGENT'],'iPad')) {
  //   $recu = "sms:$livreur_phone&body=Payement recu: " .$pay_montant . "FCFA Pour commandes numero $each_id. ".Auth::user()->nom.".";}

  // else{$recu = "sms:$livreur_phone?body=Payement recu: " .$pay_montant . "FCFA Pour commandes numero $each_id. ".Auth::user()->name.".";}

    $route = new Lesroute;
    $route->action = "PAY";
    $route->observation = $route_ids;
    $route->montant = array_sum($route_montant);
    $route->client_id = $client_id;
    $route->livreur_id = $livreur_id;
    $route->save();


    
    return response()->json(['status'=>'Payé', 'src'=>$src, 'nom'=>$nom]);
  }

  function payments(request $request){
  $livreurs = Livreur::where("status", "active")->get();
  $client_id = Auth::user()->client_id;
  foreach($livreurs as $livreur){
    $active_liv_ids[] = $livreur->id;
  }



  
  $unpayed = Payment::selectRaw('SUM(montant) montant, (livreur_id) livreur_id')
     ->where('client_id', $client_id)
     ->where('etat', 'en attente')
     ->where('montant', '>', 0)
     ->whereIn('livreur_id', $active_liv_ids)
    ->groupBy('livreur_id')
    ->get();

    function validateDate($date, $format = 'Y-m-d'){
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) === $date;}

    $day = date('Y-m-d');

    if($request->route_day && validateDate($request->route_day))
    {
      $day = date_format(date_create($request->input('route_day')), 'Y-m-d');
    }

  $payed = Lesroute::where("client_id", Auth::user()->client_id)->orderBy("created_at", "desc")->whereDate("created_at", $day)->get();



  return view("payments")->with("payed",$payed)->with("unpayed", $unpayed)->with('livreurs', $livreurs)->with("day",$day);
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
       var cur_cmd = $(this).data('curCmd');
    
   
   $('.cmdRprtSpinner'+cmd_id).removeAttr('hidden');

     if(rprt_date == '0000-00-00')
     {alert('veuillez choisr la date de report');

      $('.cmdRprtSpinner'+cmd_id).attr('hidden', 'hidden');}
     else {
      $.ajax({
            url: 'report',
            type: 'post',
            data: {_token: CSRF_TOKEN,cmd_id: cmd_id, rprt_date:rprt_date},
        
            success: function(response){
                 
                     $('#'+cur_cmd).html('<span class=\'alert alert-success\'>Commande ' +cmd_id+ 'Reportée au '+rprt_date +'</span>');
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
  
  
         $display[] = "<div id='cur$command'  class='card target' style='width: 100%;border-style: solid; border-width: 1px;'>
      <ul class='list-group list-group-flush' id='cmd_id".$command->id."'><li  class='pt-6 list-group-item'><strong>#" .$command->id. " ". "<span id='cmd_state".$command->id."' ". $class .">".$txt ." ".$command->updated_at->format('d-m-Y H:i:s'). "</span><br> ".$command->adresse ." ". "</strong><br>$command->montant FCFA<br>$note<br>
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
        
        
         <button id='cmdRprtConfirm$command->id' value='$command->id' data-curCmd='cur$command->id'  class='btn btn-info cmdRprtConfirm'  data-singlePayButtons='cmdRprtButtons$command->id'>
          
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



public function bulkassigncmd(Request $request)
{
  $cmd_ids  = $request->cmd_ids;
   
   $ids = explode(",", $cmd_ids);
  foreach($ids as $id)
  {
    $command = Command::findOrFail($id);
    $command->livreur_id = $request->livreur_id;
    $command->update();


  }
   
  return response()->json(['success'=>'success']);
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
    $cmd_id = $request->cmd_id;
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
        $result .= "</li>";
       
    }  
    }else{$result .= "Il n'y a aucune note pour cette commande";}             
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




}






