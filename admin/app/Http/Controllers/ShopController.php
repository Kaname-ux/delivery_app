<?php

namespace App\Http\Controllers;

use App\User;
use App\Command;
use App\Difuse;
use App\Client;
use App\Fee; 
use App\Livreur;
use App\Friendship;
use App\Source;
use App\Manager_fee;
use App\Command_event;
use App\Product_category;
use App\Lesroute;
use App\Payment;
use App\Product;
use App\Certification;
use App\Mooving;
use App\Shop;

use App\Helpers\Sms;


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

class ShopController extends Controller
{
  public function shops(){
    $shops = Shop::get();

    return view("shops")->with("shops", $shops);
  }


  public function shopform(){
   

    return view("shopregister");
  }

  public function shopeditform(Request $request){
   
    $shop = Shop::findOrFail($request->id);
    return view("shopedit")->with("shop", $shop);
  }


  public function create(Request $request){
   

  $validated = $request->validate([
        'name' => 'required|max:250',
        'adresse' => 'string|max:500',
        'contact' => 'string|max:10',
        "owner" => 'max:100'
    ]);

  $shop = New Shop;
  $shop->name = $request->name;
  $shop->adresse = $request->adresse;
  $shop->contact = $request->contact;
  $shop->owner = $request->owner;

  $shop->save();

  return redirect()->back()->with("status", "Boutique Ajoutée");
  }



  public function edit(Request $request){
   

  $validated = $request->validate([
        'name' => 'required|max:250',
        'adresse' => 'string|max:500',
        'contact' => 'string|max:10',
        "owner" => 'max:100'
    ]);

  $shop = Shop::findOrFail($request->id);
  $shop->name = $request->name;
  $shop->adresse = $request->adresse;
  $shop->contact = $request->contact;
  $shop->owner = $request->owner;

  $shop->update();

  return redirect()->back()->with("status", "Boutique modifée");
  }


  public function setshop(Request $request){
    $product = Product::findOrFail($request->id);
    
    

    

    if($request->shop != "NULL")
    { 
      $product->shop_id = $request->shop;
      $shop = Shop::findOrFail($request->shop);
    }
  else
  {
    $product->shop_id = NULL;
    $shop = NULL;
  }
 
 $product->update();
   return response()->json(["shop"=>$shop]);
  }
 
}






