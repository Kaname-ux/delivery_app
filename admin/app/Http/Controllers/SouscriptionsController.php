<?php

namespace App\Http\Controllers;
use App\User;
use App\Livreur;
use App\Client;
use App\Sms_mooving;


use Illuminate\Support\Facades\Storage;
use Illuminate\Support\MessageBag;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Exception;
use Auth;
use App\Helpers\Sms;
use App\Helpers\Cinetpay;

class SouscriptionsController extends Controller
{
  public function subscribe(Request $request){
    if(!Auth()->check()){
        return redirect('login');
    }
    $user = Auth::user();
    $user_id = $user->id;
    $use_name = $user->name;
    $client_id = $user->client_id;
    $amount = $request->amount;
    $qty = $amount/10;
// La class gère la table "Commande"( A titre d'exemple)


try {
    
        $customer_name = $use_name;
        $customer_surname = " ";
        $description = "Souscription au service SMS Marketing";
        $amount = $amount;
        $currency = 'XOF';
    
    //transaction id
    $id_transaction = date("YmdHis"); // or $id_transaction = Cinetpay::generateTransId()

    $apikey = '1696316833627ff88f9843f5.96868897';
   $site_id =  '548510';

    

    //notify url
    $notify_url = "https://client.livreurjibiat.site/notify";
    //return url
    $return_url = "https://client.livreurjibiat.site/marketing";
    $channels = "ALL";
        
        $subscription = new Sms_mooving;
            $subscription->amount = $amount;
          $subscription->transaction_id = $id_transaction;
          $subscription->type = "IN";
          $subscription->qty = $qty;
          
          $subscription->user_id = Auth::user()->id;
          
          $subscription->save(); 

          // the message
$msg = "Demande de ". $qty. " SMS - Meta Kiwi";

// use wordwrap() if lines are longer than 70 characters
$msg = wordwrap($msg,70);

// send email
mail("jibiatonline@gmail.com",$qty. " SMS - Meta Kiwi",$msg, "From: marketing@livreurjibiat.site");

    //
    $formData = array(
        "transaction_id"=> $id_transaction,
        "amount"=> $amount,
        "currency"=> $currency,
        "customer_surname"=> $customer_surname,
        "customer_name"=> $customer_name,
        "description"=> $description,
        "notify_url" => $notify_url,
        "return_url" => $return_url,
        "channels" => $channels,
        "metadata" => $id_transaction, // utiliser cette variable pour recevoir des informations personnalisés.
        "alternative_currency" => "",//Valeur de la transaction dans une devise alternative
        //pour afficher le paiement par carte de credit
        "customer_email" => "", //l'email du client
        "customer_phone_number" => "", //Le numéro de téléphone du client
        "customer_address" => "", //l'adresse du client
        "customer_city" => "", // ville du client
        "customer_country" => "",//Le pays du client, la valeur à envoyer est le code ISO du pays (code à deux chiffre) ex : CI, BF, US, CA, FR
        "customer_state" => "", //L’état dans de la quel se trouve le client. Cette valeur est obligatoire si le client se trouve au États Unis d’Amérique (US) ou au Canada (CA)
        "customer_zip_code" => "" //Le code postal du client
    );
    // enregistrer la transaction dans votre base de donnée
    /*  $commande->create(); */

    $CinetPay = new CinetPay($site_id, $apikey);
    $result = $CinetPay->generatePaymentLink($formData);

    $subscription->code =  $result["code"];
        $subscription->update();

    if ($result["code"] == '201')
    {
        
        $url = $result["data"]["payment_url"];

        // ajouter le token à la transaction enregistré
        /* $commande->update(); */
        //redirection vers l'url de paiement
      return redirect()->away($url);

    }
} catch (Exception $e) {
    echo $e->getMessage();
}
  }





public function return(Request $request){


    

if ($request->transaction_id || $request->token) {

    
    $id_transaction = $request->transaction_id;
    $transaction = Sms_mooving::where("transaction_id", $transaction_id)->first();

    try {

        $apikey = '1696316833627ff88f9843f5.96868897';
        $site_id =  '548510';
        // Verification d'etat de transaction chez CinetPay
        $CinetPay = new CinetPay($site_id, $apikey);

        $CinetPay->getPayStatus($id_transaction, $site_id);
        $message = $CinetPay->chk_message;
        $code = $CinetPay->chk_code;

        //recuperer les info du clients pour personnaliser les reponses.
        /* $commande->getUserByPayment(); */

        // redirection vers une page en fonction de l'état de la transaction
        if ($code == '00') {
   

  return view("marketing");
            die();
        }
        else {
           // header('Location: '.$commande->getCurrentUrl().'/');
            return view("souscriptions")->with("warning", 'Echec, votre paiement a échoué ');
            die();
        }

    } catch (Exception $e) {
        echo "Erreur :" . $e->getMessage();
    }
} else {
    echo 'transaction_id non transmis';
    die();

}
}




public function notify(Request $request){

if ($request->cpm_trans_id) {
  
    try {
    
        

        //Création d'un fichier log pour s'assurer que les éléments sont bien exécuté
        $log  = "User: ".$_SERVER['REMOTE_ADDR'].' - '.date("F j, Y, g:i a").PHP_EOL.
        "TransId:".$request->cpm_trans_id.PHP_EOL.
        "SiteId: ".$request->cpm_site_id.PHP_EOL.
        "-------------------------".PHP_EOL;
        //Save string to log, use FILE_APPEND to append.
        file_put_contents('./log_'.date("j.n.Y").'.log', $log, FILE_APPEND);

        //La classe commande correspond à votre colonne qui gère les transactions dans votre base de données
        
        // Initialisation de CinetPay et Identification du paiement
        $id_transaction = $request->cpm_trans_id;
        $apikey = '1696316833627ff88f9843f5.96868897';
        $site_id = $request->cpm_site_id;


        $CinetPay = new CinetPay($site_id, $apikey);
        //On recupère le statut de la transaction dans la base de donnée
        /* $commande->set_transactionId($id_transaction);
             //Il faut s'assurer que la transaction existe dans notre base de donnée
         * $commande->getCommandeByTransId();
         */

        // On verifie que la commande n'a pas encore été traité
        $VerifyStatusCmd = "1"; // valeur du statut à recupérer dans votre base de donnée
        if ($VerifyStatusCmd == '00') {
            // La commande a été déjà traité
            // Arret du script
            die();
        }

        // Dans le cas contrait, on verifie l'état de la transaction en cas de tentative de paiement sur CinetPay

        $CinetPay->getPayStatus($id_transaction, $site_id);


        $amount = $CinetPay->chk_amount;
        $currency = $CinetPay->chk_currency;
        $message = $CinetPay->chk_message;
        $code = $CinetPay->chk_code;
        $metadata = $CinetPay->chk_metadata;

        //Something to write to txt log
        $log  = "User: ".$_SERVER['REMOTE_ADDR'].' - '.date("F j, Y, g:i a").PHP_EOL.
            "Code:".$code.PHP_EOL.
            "Message: ".$message.PHP_EOL.
            "Amount: ".$amount.PHP_EOL.
            "currency: ".$currency.PHP_EOL.
            "-------------------------".PHP_EOL;
        //Save string to log, use FILE_APPEND to append.
        file_put_contents('./log_'.date("j.n.Y").'.log', $log, FILE_APPEND);

        // On verifie que le montant payé chez CinetPay correspond à notre montant en base de données pour cette transaction
        if ($code == '00') {
            // correct, on delivre le service


            $souscription = Sms_mooving::where("transaction_id", $id_transaction)->first();
         

          if($souscription->amount == $amount)
          {         $souscription->payment = $id_transaction;
                    $souscription->code = '00';
                    
                }
          $souscription->update();
            

          echo "status", 'Vous avez souscrit avec succès. <br>
           <a href="https://client.livreurjibiat.site/marketing"> < Retour sur jibiat</a>';
            die();

        } else {
            // transaction n'est pas valide

            echo "Echec";
            die();
        }
        // mise à jour des transactions dans la base de donnée
          
           
            


    } catch (Exception $e) {
        echo "Erreur :" . $e->getMessage();
    }
} else {
    // direct acces on IPN
    echo "cpm_trans_id non fourni";
}
}


  public function souscriptions(Request $request){
    return view('souscrire');
  }




  public function checksubscription(Request $request)
          {
            
                 $message = "no_auth";
                
              $user_id = Auth()->user()->id;

                if($user_id)
                {
                        $subscription = Subscription::where('user_id', $user_id)->latest()->first();
            
                        $message = "";
            
                        if($subscription)
                        {
                            if( $subscription->end != NULL)
                            {
                                $date_now = date("Y-m-d");
                                $end_date = $subscription->end;
            
                                if($end_date >=$date_now)
                                {
                                    $message = "<p>Vous avez une souscription en cours de validité.</p> <p>Date d'expiration: ".date_format(date_create($end_date), "d-m-Y"). "</p>Souhaitez-vous souscrire à nouveau? Cela prolongera la date d'expiration selon la formule choisie.";
                                }
                                if($end_date <= $date_now){
                                    $message = "Souscription expirée le: ". date_format($end_date, "d-m-Y");
                                }
                            }
            
                        } 
            }
            
             
            
            return response()->json(['message'=>$message]);
          } 




  public function verse(Request $request){
    
     $request->validate([
            'verse_date' => ['required'],
            
           
        ]);

     $id = $request->id;
     $verse_date = $request->verse_date;

     $souscription = Subscription::findOrFail($id);

     $souscription->payed_at = $verse_date;

      $souscription->update();
        return redirect()->back()->with("status", "Versement effectué");

  }


  public function delete(Request $request){
    
     $id = $request->id;
     
     $souscription = Subscription::findOrFail($id);
     foreach($souscription->echeanciers as $echeancier)
     {
      $echeancier->delete();
     }

     

      $souscription->delete();
        return redirect()->back()->with("status", "Subscription supprimée!");

  }


   public function terminate(Request $request){
    
     $id = $request->id;
     
      $souscription = Subscription::findOrFail($id);
      $souscription->status = "termine";
      $souscription->update();
        return redirect()->back()->with("status", "Subscription terminée!");

  }



  public function encours(Request $request){
    
     $id = $request->id;
     
      $souscription = Subscription::findOrFail($id);
      $souscription->status = "encours";
      $souscription->update();
        return redirect()->back()->with("status", "Subscription remise encours");

  }


  public function edit(Request $request){
    
     $id = $request->id;
     $souscription = Subscription::findOrFail($id);

     $client_id = $request->client;
     $duree = $request->duree;
     $montant = $request->montant;

     $souscription->client_id = $client_id;
     $souscription->duree  = $duree;
     $souscription->montant = $montant;
     $souscription->commission = $montant;
     
     
     $souscription->save();

     
     


        return redirect()->back()->with("status", "Subscription Modifiée");

  }




  public function add(Request $request){
    



     $souscription = new Subscription;

     $client_id = $request->client;
     $duree = $request->duree;
     $montant = $request->montant;

     $souscription->client_id = $client_id;
     $souscription->duree  = $duree;
     $souscription->montant = $montant;
     $souscription->commission = $montant;
     $souscription->status = "encours";
     
     $souscription->save();

     
     for($x = 1; $x <= $duree; $x++){
      $echeancier = new Echeancier;
      $echeancier->souscription_id = $souscription->id;
      $echeancier->echeance = $x;

      $echeancier->save();
     }






        return redirect()->back()->with("status", "Subscription enregistrée");

  }

     public function paysous(Request $request){
    
     $request->validate([
            'qty' => ['required', 'numeric'],
            
           
        ]);
 
    $id = $request->id;
    $qty = $request->qty;
    $payment_date = $request->payment_date;
     for($x = 1; $x <= $qty; $x++){
      $echeancier = Echeancier::where("souscription_id", $id)->where("date_payment", null)->orderBy("echeance", "asc")->first();
      $echeancier->date_payment = $payment_date;

      $echeancier->update();
     } 
     
     $souscription = Subscription::findOrFail($id);
     if($souscription->echeanciers->where("date_payment", null)->count() == 0)
     {
        
        $souscription->status = "termine";
        $souscription->update();
     }
    
    

     
     $cur = $request->cur;

     

        

        return redirect()->back()->with("cur", $cur);

  }


  public function reversepaysous(Request $request){
    
     $request->validate([
            'qty' => ['required', 'numeric'],
            
           
        ]);
 
    $id = $request->id;
    $qty = $request->qty;
    $payment_date = null;
     for($x = 1; $x <= $qty; $x++){
      $echeancier = Echeancier::where("souscription_id", $id)->where("date_payment", "!=", null)->orderBy("echeance", "desc")->first();
      $echeancier->date_payment = $payment_date;

      $echeancier->update();
     } 
     
     $souscription = Subscription::findOrFail($id);
     
    
     $cur = $request->cur;

     
        return redirect()->back()->with("cur", $cur);

  }


  public function commissions(Request $request){
    $user = Auth::user();
   $clients = $user->clients;
   $title = "Rapport complet";
    $ids = array();
    $sous_ids = array();
    $commissions = array();
    $versements = array();
    foreach($clients as $client)
    {
      $ids[] = $client->id;
    }
    $souscriptions = Subscription::whereIn("client_id", $ids); 
    $all = $souscriptions->get();
    foreach($all as $one)
    {
      $sous_ids[] = $one->id; 
    }


     $echeanciers = Echeancier::where("date_payment", "!=", null)->whereIn("souscription_id", $sous_ids);
      
    
    if($request->start && $request->end)
    {

       $start = $request->start;
       $end = $request->end;
       $souscriptions = $souscriptions->whereBetween('updated_at', [$start, $end]);
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


       
       $echeanciers = $echeanciers->whereBetween('date_payment', [$start, $end]);
      

    }

    $echeanciers = $echeanciers->get();
    foreach($echeanciers as $echeance)
      {
           
        $versements[] = $echeance->souscription->montant;
      }


    $souscriptions = $souscriptions->get();
    

    foreach($souscriptions as $souscription){
      if($souscription->status == "termine" && $souscription->echeanciers->where("date_payment", "!=", null)->count()>0)
      {
        $commissions[] = $souscription->commission;
      }
      
      
          
    }


   

    return view("commissions")->with("commissions", $commissions)->with("title", $title)->with("souscriptions", $souscriptions)->with("versements", $versements)->with("echeanciers",$echeanciers);


  }

 


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

  





  
public function commencer()
{
  
  return view("commencer");
}

}