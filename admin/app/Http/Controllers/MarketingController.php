<?php

namespace App\Http\Controllers;

use App\User;
use App\Command;
use App\Command_event;
use App\Product_category;
use App\Difuse;
use App\Client;

use App\Fee; 




use App\Lesroute;
use App\Payment;


use App\User_type;
use App\Sms_mooving;
use App\Helpers\Sms;
use App\Helpers\Roles;


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

class MarketingController extends Controller
{



  public function marketing(Request $request){




   $err = "";
   $res = array();
    $fees = Fee::where("category", 1)->orderBy("destination", "asc")->get();
    $client = Client::findOrFail(Auth::user()->client_id);

   $ins = Sms_mooving::where("user_id", Auth::user()->id)->where("type", "IN")->where("payment", null)->where("transaction_id", "!=", null)->get();
  
   if($ins->count() > 0)
    {
      foreach($ins as $in)
      {
        
        $curl = curl_init();
            
                curl_setopt_array($curl, array(
                  CURLOPT_URL => 'https://api-checkout.cinetpay.com/v2/payment/check',
                  CURLOPT_RETURNTRANSFER => true,
                  CURLOPT_ENCODING => '',
                  CURLOPT_MAXREDIRS => 10,
                  CURLOPT_TIMEOUT => 0,
                  CURLOPT_FOLLOWLOCATION => true,
                  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                  CURLOPT_CUSTOMREQUEST => 'POST',
                  CURLOPT_POSTFIELDS =>'{
                    "transaction_id":"'.$in->transaction_id.'", 
                    "site_id": "548510", 
                    "apikey" : "1696316833627ff88f9843f5.96868897" 
            
                }',
                  CURLOPT_HTTPHEADER => array(
                    'Content-Type: application/json'
                  ),
                ));
            
                $response = curl_exec($curl);
            
                $err = curl_error($curl);
                curl_close($curl);
                if ($err) {
                  echo $err;
                  //throw new Exception("Error :" . $err);
                } 
                else{
                 $res = json_decode($response,true);
                   if($res['code'] == '00'){

                    $in->payment = $in->transaction_id;
                    $in->update();
                   }
                }
              
            }
            } 
      
    
    $smsin = Sms_mooving::where("user_id", Auth::user()->id)->where("type", "IN")->where("payment", "!=", null)->sum("qty");
    $smsout = Sms_mooving::where("user_id", Auth::user()->id)->where("type", "OUT")->sum("qty");
    $smscount = $smsin-$smsout;

             $vendeurs = Command::where("phone", "!=", null)->where("phone", "!=", "00000000")->where("phone", "!=", " 
99999999")->where("fee_id", "!=", null)->where("phone", "!=", "0000000")->where("phone", "!=", "000000")->where("phone", "!=", "0")->where("phone", "!=", "00")->where("phone", "!=", "000");

             $vendeurs = $vendeurs->distinct()->get();

    return view("marketing")->with("client", $client)->with("fees", $fees)->with("prospects", $vendeurs->count(). " contacts")->with("smscount", $smscount)->with("err", $err)->with("res",$res);
    }

    public function countprospects(Request $request){

        $client = Client::findOrFail(Auth::user()->client_id);
            $end = $request->end;
            $start = $request->start;
            $alldates = $request->alldates;
            $status = $request->status;
            $cities = $request->cities;
            $amount = $request->amount;



             $vendeurs = Command::where("phone", "!=", null)->where("phone", "!=", "00000000")->where("phone", "!=", " 
99999999")->where("fee_id", "!=", null)->where("phone", "!=", "0000000")->where("phone", "!=", "000000")->where("phone", "!=", "0")->where("phone", "!=", "00")->where("phone", "!=", "000");
  
  if(!empty($cities))
    { $vendeurs = $vendeurs->whereIn("fee_id", $cities); }

  if($start && $end && !$alldates)
      {
         $vendeurs = $vendeurs->whereBetween("delivery_date",  [$start, $end]);   
      }

      if($status == "termine"){
        $vendeurs = $vendeurs->where("etat", $status);
      }

      if($amount > 0){
        $vendeurs = $vendeurs->where("montant", ">=", $amount);
      }

  $vendeurs = $vendeurs->distinct()->get();

     

      


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

     return response()->json(['prospects'=>$vendeurs->count()]);
    }



   public function testsms(Request $request){
    $smsin = Sms_mooving::where("user_id", Auth::user()->id)->where("type", "IN")->where("payment", "!=", null)->sum("qty");
    $smsout = Sms_mooving::where("user_id", Auth::user()->id)->where("type", "OUT")->sum("qty");
    $smscount = $smsin-$smsout;

      if($smscount > 0)
            {
             

              $client = Client::findOrFail(Auth::user()->client_id);
                        $phone = $request->phone;
               
            
                         
                  
            
            
                  
            
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
                          
                          'tel:+225'.$phone,
                          
                          $message,
                          
                      );

                      
              
                
           $outs = new Sms_mooving;
                                   $outs->type = "OUT";
                                   $outs->qty = 1;
                                   $outs->user_id = Auth::user()->id;
                   
                                   $outs->save();
            
                 return response()->json(["status", "Message envoye"]);
                

        }
        else{
           return response()->json(["status"=>"Vous n'avez pas de SMS"]);
        }
   }

    public function sendsms(Request $request){

      $smsin = Sms_mooving::where("user_id", Auth::user()->id)->where("type", "IN")->where("payment", "!=", null)->sum("qty");
    $smsout = Sms_mooving::where("user_id", Auth::user()->id)->where("type", "OUT")->sum("qty");
    $smscount = $smsin-$smsout;

      if($smscount > 0)
            {
              $messages = array();

              $client = Client::findOrFail(Auth::user()->client_id);
                        $end = $request->end;
                        $start = $request->start;
                        $alldates = $request->alldates;
                        $status = $request->status;
                        $cities = $request->cities;
                        $amount = $request->amount;
            $limit = $smscount;
             if($request->limit > 0){
              $limit = $request->limit;
             }         
            
                         $vendeurs = Command::where("phone", "!=", null)->where("phone", "!=", "00000000")->where("phone", "!=", " 
            99999999")->where("fee_id", "!=", null)->where("phone", "!=", "0000000")->where("phone", "!=", "000000")->where("phone", "!=", "0")->where("phone", "!=", "00")->where("phone", "!=", "000");
              
              if(!empty($cities))
                { $vendeurs = $vendeurs->whereIn("fee_id", $cities); }
            
              if($start && $end && !$alldates)
                  {
                     $vendeurs = $vendeurs->whereBetween("delivery_date",  [$start, $end]);   
                  }
            
                  if($status == "termine"){
                    $vendeurs = $vendeurs->where("etat", $status);
                  }
            
                  if($amount > 0){
                    $vendeurs = $vendeurs->where("montant", ">=", $amount);
                  }
            
              $vendeurs = $vendeurs->distinct()->limit($limit)->get();
            
                 
            
                  
            
            
                foreach($vendeurs as $vendeur)
                {
                  
            
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
                          
                          'tel:+225'.$vendeur->phone,
                          
                          $message,
                          'Ma Commande'
                      );

                      $messages[] = $vendeur->phone;
              
                

                } 
                if(count($messages)>0)
                {$outs = new Sms_mooving;
                                   $outs->type = "OUT";
                                   $outs->qty = count($messages);
                                   $outs->user_id = Auth::user()->id;
                   
                                   $outs->save();}   
            
                 return redirect()->back()->with("status", "messages envoyes!");
                

        }
        else{
          return redirect()->back()->with("warning", "Vous n'avez pas de SMS");
        }
 }
}






