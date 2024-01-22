<?php

namespace App\Http\Controllers;

use App\User;
use App\Command_event;

use App\Setting;
use App\Client;
use App\Company;
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
        

        $settings = Setting::get();

        $company = Company::findOrFail(1);
        return view("settings")->with("settings", $settings)->with("company", $company);

    }
  
 
 public function switchsetting(Request $request){
    $id = $request->id;
    $current = $request->current;

    $setting = Setting::findOrFail($id);

    if($current == 1){
     $setting->switch = 0;
    }
    if($current == 0){
     $setting->switch = 1;
    }

    $setting->update();

    return response()->json(["switch"=>$setting->switch]);
 }


 public function setmessage(Request $request){
    $id = $request->id;
    $text = $request->text;

    $setting = Setting::findOrFail($id);

     $setting->text = $text;
    

    $setting->update();

    return response()->json(["text"=>$setting->text]);
 }

}    