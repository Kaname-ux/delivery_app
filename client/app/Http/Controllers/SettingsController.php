<?php

namespace App\Http\Controllers;

use App\User;
use App\Command_event;

use App\Setting;
use App\Client;
use App\Command;
use App\Sms_mooving;
use App\Helpers\Sms;
use DB;
use DateTime;
use Auth;
use Illuminate\Support\MessageBag;



use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SettingsController extends Controller
{

    public function settings(){
        


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
 

        $settings = Setting::get();
        
        return view("settings")->with("settings", $settings)->with("client", $client)->with("smscount", $smscount);

    }
  
 
 public function switchsetting(Request $request){
    $client_id = Auth::user()->client_id;
    $id = $request->id;
    $text = $request->text;

    $client = Client::findOrFail($client_id);

    if(!$client->settings->contains($id)){
     $client->settings()->attach($id, ['text' => $text]);
    }else{
      $client->settings()->detach($id);
    }

    




    return response()->json([]);
 }


public function getmessage(Request $request){
   $id = $request->id;

   $client = Client::findOrFail(Auth::user()->client_id);

    $setting = $client->settings()->find($id);
     $warning = "";
     if($setting)
     {$text = $setting->pivot->text;}
  else{
   $text = "";
   $warning = "Veuillez d'abord activer la fonction pour pouvoir modifier son message";
  }

     return response()->json(["text"=>$text, "warning"=>$warning]);
}


 public function setmessage(Request $request){
    $id = $request->id;
    $text = $request->text;

    $client = Client::findOrFail(Auth::user()->client_id);

    $setting = $client->settings->find($id);

     $setting->pivot->text = $text;
    

    $setting->pivot->update();

    return response()->json(["text"=>$setting->pivot->text]);
 }

}    