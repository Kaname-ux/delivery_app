<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\Livreur;
use App\Client;
use App\Helpers\Sms;
use Auth;




use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SmsController extends Controller
{
    
public function sms(){
    return view('sms');
}

public function send(Request $request){
    if(!$request->manager && !$request->client && !$request->livreur)
    {return redirect()->back()->with("error", "Vous n'avez selectionné aucun destinataire");}
    $model = User::where("phone", "!=", null)->where("phone", "!=", "00000000")->where("phone", "!=", " 
99999999");
    if($request->manager)
    {
        $model = $model->where('usertype', 'manager');
    }

    if($request->client)
    {
        $model = Client::where("phone", "!=", null)->where("phone", "!=", "00000000")->where("phone", "!=", " 
99999999");
    }


    if($request->livreur)
    {

        $model = Livreur::where("certified_at", "!=", null);
        
    }

    $model = $model->get();
    $phones = array();

    $orange = array('07', '08', '09', '47', '48', '49', '57', '58', '59', '67', '68', '69', '77', '78', '79', '87', '88', '89', '97');

   $mtn = array('04', '05', '06', '44', '45', '46', '54', '55', '56', '64', '65', '66', '74', '75', '76', '84', '85', '86');


   $moov = array('01', '02', '03', '41', '42', '43', '51', '52', '53', '61', '62', '63', '71', '72', '73', '81', '82', '83', '97');
    foreach($model as $result)
    {
      

      

       if(strlen(preg_replace('/[^0-9]/', '', $result->phone)) == 8)
     { 
        foreach($orange as $or){ 
          if(substr(preg_replace('/[^0-9]/', '', $result->phone), 0,-6) == $or)
          {
            $phones[] = '07'.$result->phone;
          }
        }
        foreach($mtn as $mt){
          if(substr(preg_replace('/[^0-9]/', '', $result->phone), 0,-6) == $mt)
          {
            $phones[] = '05'.$result->phone;
          }
        }
        foreach($moov as $mv){
          if(substr(preg_replace('/[^0-9]/', '', $result->phone), 0,-6) == $mv)
          {
            $phones[] = '01'.$result->phone;
          }
        } 

      }
      if(strlen(preg_replace('/[^0-9]/', '', $result->phone)) == 10)
      {$phones[] = $result->phone;}
    }
   
    $message = $request->sms;


    $config = array(
            'clientId' => config('app.clientId'),
            'clientSecret' =>  config('app.clientSecret'),
        );

        $osms = new Sms($config);

        $data = $osms->getTokenFromConsumerKey();
        $token = array(
            'token' => $data['access_token']
        );



        
        foreach($phones as $phone)
        {
            $response = $osms->sendSms(
                // sender
                    'tel:+22509980885',
                    // receiver
                    'tel:+225'.$phone,
                    // message
                    $message,
                    'Jibiat'
                );
           }

      return redirect()->back()->with("status", "Message envoyée");
  
}
}
