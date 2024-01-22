<?php

namespace App\Http\Controllers;

use App\User;
use App\Command_event;
use App\User_type;
use App\Role;
use App\Client;
use App\Command;
use App\Helpers\Sms;
use DB;
use DateTime;
use Auth;
use Illuminate\Support\MessageBag;



use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RolesController extends Controller
{

    public function roles(){
        

        $roles = User_type::get();
        return view("roles")->with("roles", $roles);

    }
  
  public function add(Request $request){
    $type = strtoupper(str_replace(' ', '_',$request->input('type')));
    $type = substr($type, 0, 50);
    $description = substr($request->input('description'),0,150);
    $goal = $request->goal;

    $role = new User_type;
    $role->type = $type;
    $role->description = $description;
    $role->mensual_goal = $goal;

    $role->save();

    $permissions = Role::where('client_type', "GESTIONNAIRE")->get();

    foreach ($permissions as $permission) {
        $newRolePerm = new Role;
        $newRolePerm->create(["client_type"=>$type, "antity"=>$permission->antity, "action"=>$permission->action, "switch"=>0, "description"=>$permission->description]);

    }

    return redirect()->back()->with("status", "Groupe enregistre");
  }

 public function permissions(Request $request){
    $id = $request->id;
    $client_type = User_type::findOrFail($id);

    
    $roles = Role::where("client_type", $client_type->type)->get();

     $antities = array();
     $actions = array();
    foreach($roles as $role){
        $antities[] = $role->antity;
        $actions[] = $role->action;
    }

    $newpermissions = Role::whereNotIn('action', $actions)->where('client_type', "GESTIONNAIRE")->get();
    if($newpermissions->count() > 0){
        foreach($newpermissions as $permission){
            $newRolePerm = new Role;
        $newRolePerm->create(["client_type"=>$client_type->type, "antity"=>$permission->antity, "action"=>$permission->action, "switch"=>0, "description"=>$permission->description]);
        }
    }

    return view("permissions")->with("roles", $roles->toJson())->with('id', $id)->with("client_type", $client_type);
 }

 public function switchrole(Request $request){
    $id = $request->id;
    $current = $request->current;

    $role = Role::findOrFail($id);

    if($current == 1){
     $role->switch = 0;
    }
    if($current == 0){
     $role->switch = 1;
    }

    $role->update();

    return response()->json(["switch"=>$role->switch]);
 }

 public function useractions(Request $request){
    $user = User::findOrFail($request->id);
    $client = Client::where("user_id", $user->id)->first();
     $day = "Aujourd'hui";   
      
      $current_date = date('Y-m-d');

      $start = $current_date;
      $end = $current_date;


if($request->start && $request->end )
      {

         $start = $request->start;
         $end = $request->end;

       
        $current_date = $day;
      
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

$client_type = User_type::where("type", $client->client_type)->first();  

       $mensual_goal = $client_type->mensual_goal;
       $daily = round($mensual_goal/30);
                          
       $registered =  $client->command->whereBetween("delivery_date", [$start, $end]);

       function dateDiff($date1, $date2)
   {
    $date1_ts = strtotime($date1);
    $date2_ts = strtotime($date2);
    $diff = $date2_ts - $date1_ts;
    return round($diff / 86400) + 1;
   }

$dif = dateDiff($start, $end);
       
                                             

    $actions = Command::whereBetween(DB::raw('DATE(created_at)'), [$start, $end])
                          ->where("client_id", $client->id)->get();

                        

   return view("useractions")->with("actions", $actions)->with("user", $user)->with("day", $day)->with("client", $client)->with("client_type", $client_type)->with("registered", $registered)->with("daily", $daily)->with("dif", $dif)->with("start", $start)->with("end", $end);                       
 }

 public function setgoal(Request $request){
    $id = $request->id;
    $goal = $request->goal;

    $role = User_type::findOrFail($id);
    $role->mensual_goal = $goal;

    $role->update();

    return redirect()->back()->with("status", "Objectif mensuel defini");


 }
}    