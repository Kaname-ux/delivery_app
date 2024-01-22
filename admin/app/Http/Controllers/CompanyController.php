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

class CompanyController extends Controller
{

   public function updatecompany(Request $request)
{
  $validated = $request->validate([
        'name' => 'required',
        'contact' => 'required',
    ]);
   
   $company = Company::find(1);

   $name = $request->name;
   $location = $request->adresse;
   $wa = $request->wa;
   $mail = $request->mail;
   $contact = $request->contact;

   $company->name = $name;
   $company->location = $location;
   $company->wa = $wa;
   $company->mail = $mail;
   $company->contact = $contact;

   $company->update();



  return redirect()->back()->with('status', 'Modifications effectuées');
}
}    