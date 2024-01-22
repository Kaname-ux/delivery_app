<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Hash;
use Auth;
use App\Subscription;
use App\Incoming_subscription;
use Illuminate\Validation\Rule;

use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    //
    public function subscriptions(Request $request){
      $incommings = Incoming_subscription::orderBy("created_at", "desc");

   if($request->has("pending"))
   {
    $incommings = $incommings->where("status", "pending");
   }

   if($request->has("validated"))
   {
    $incommings = $incommings->where("status", "validated");
   }

   if($request->has("canceled"))
   {
    $incommings = $incommings->where("status", "canceled");
   }

  $incommings = $incommings->paginate('50');
        return view('subscriptions')->with("incommings", $incommings);
    }
    
    

    public function confirm(Request $request)
   {
    $validatedData = $request->validate([
        'user_id' => 'required| exists:users,id',
        'in_id' => 'required| exists:incoming_subscriptions,id',
            'formula' => [
        'required',
        Rule::in(['yearly', 'monthly']),
    ],


    'pay_method' => [
        'required',
        Rule::in(['mm', 'bt', 'cash']),
    ],
            'pay_ref' => 'required| string',
            'pay_date' => 'required| date',
    ]);
    
    $in_id = $request->in_id;
    $user_id = $request->user_id;
    $formula = $request->formula;
    $pay_method = $request->pay_method;
    $pay_ref = $request->pay_ref;
    $pay_date = $request->pay_date;

    $subscription = Subscription::where("user_id", $user_id)->latest()->first();
    
    $last_date = date('Y-m-d');

    if($subscription)
    {
       if($subscription->end != null)
        {$last_date = $subscription->end;}
    }else{
        $subscription = new Subscription;
    }

    if($formula == "yearly")
    {
        $new_end = date('Y-m-d', strtotime($last_date. ' + 365 days'));
    }

    if($formula == "monthly")
    {
        $new_end = date('Y-m-d', strtotime($last_date. ' + 30 days'));
    }

  $subscription->end = $new_end;
  $subscription->user_id = $user_id;
  
  $subscription->save();

  $incoming = Incoming_subscription::findOrFail($in_id);
  $incoming->pay_method = $pay_method;
  $incoming->pay_date = $pay_date;
  $incoming->pay_ref = $pay_ref;
  $incoming->status = "validated";
  
  $incoming->update();


  return redirect()->back()->with('status', "Souscription validée");
  } 



  

  public function cancel(Request $request)
  {
    $id = $request->id;
    $incoming = Incoming_subscription::findOrFail($id);
    $incoming->status = "canceled";

    $incoming->update();

    return redirect()->back()->with('status', "Souscription Annulée");
  }

  public function pend(Request $request)
  {
    $id = $request->id;
    $incoming = Incoming_subscription::findOrFail($id);
    $incoming->status = "pending";

    $incoming->update();

    return redirect()->back()->with('status', "Souscription remise en attente");
  }

}
