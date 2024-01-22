<?php

namespace App\Http\Controllers;
use App\User;
use App\Client;
use App\Difuse;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\MessageBag;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use DateTime;

use Illuminate\Database\Eloquent\Builder;

class DifusionsController extends Controller
{


  public function difusions()
{
  $client = Client::findOrFail(Auth::user()->client_id);
  $difusions = Difuse::where("client_id", $client->id)->orderBy("status", "desc")->get();

  return view("difusions")->with("difusions", $difusions)->with("client", $client);
}

public function delete(request $request){

   
    $id = $request->id;

    $difusion = Difuse::findOrFail($id);
   
    
    $difusion->delete();


    return response()->json(['status'=>'Difusion supprimé']);
}


public function changestatus(request $request){

   
    $id = $request->id;
    $status = $request->status;


    $difusion = Difuse::findOrFail($id);
   
    if($status == "encours"){
      $change = "termine";
      

    }

    if($status == "termine"){
      $change = "encours";
      
    }

    $difusion->status = $change;
    $difusion->update();

    return response()->json(['status'=>'Difusion mise à jour']);
}
  
  
  public function candidates(Request $request){

    $id = $request->id;
    $difusion = Difuse::findOrFail($id);
    $candidates = "<ul>";
    foreach($difusion->livreurs as $liv){

      $candidates .= "<li>".$liv->nom."<a class='btn btn-primary' href='tel:$liv->phone'><ion-icon name='call-outline'></ion-icon></a><br>".$liv->pivot->updated_at->format('d-m-Y H:i')."<br><span id='loc$liv->id'>".$liv->pivot->longitude."</span></li>";
      $candidates .= "<script>
    var reverseGeocoder$liv->id=new BDCReverseGeocode();
    reverseGeocoder$liv->id.getClientLocation({
        latitude: ".$liv->pivot->latitude.",
        longitude: ".$liv->pivot->longitude.",
    },function(result) {
        $('#loc$liv->id').html('Se trouve à <span style=\'font-weight:bold\'>'+result.city+ ' '+result.locality+'</span>');
         console.log(result);
    });
    </script>";
  }

  $candidates .= "</ul>";

   return response()->json(['candidates'=>$candidates]);
}
}






