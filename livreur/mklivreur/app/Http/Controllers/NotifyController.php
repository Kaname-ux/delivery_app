<?php

namespace App\Http\Controllers;
 
use App\Http\Controllers\Controller;
use App\Subscription;
 use Illuminate\Http\Request;
 use App\Helpers\Cinetpay;
class NotifyController extends Controller
{
    /**
     * Provision a new web server.
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {

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


            $souscription = Subscription::where("transaction_id", $id_transaction)->first();
          $souscription->code = '00';

          if($souscription->amount == $amount)
          {         $souscription->payed_at = date("Y-m-d");
          
                    $souscription->formula = "monthly";
                    $souscription->start = date("Y-m-d");
          
                    $future_timestamp = strtotime("+1 month");
                    $end = date('Y-m-d', $future_timestamp);
                    $souscription->end = $end;
                }
          $souscription->update();
            

          echo "status", 'Vous avez souscrit avec succès. Connectez-vous vite, des milliers de vendeurs vous attendent';
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
}