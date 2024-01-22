<?php

namespace App\Http\Controllers;
use App\Product;
use App\Client;
use App\Fee;
use App\Mooving;
use App\Command;
use Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
class ProductsController extends Controller
{
   public function products(){

    $client = Client::findOrFail(Auth::user()->client_id);
    $products = $client->products;
     $stocks = array();
    foreach($products as $product){
        if($product->moovings->count() > 0){

            $product->stock = $product->moovings->where("type", "IN")->sum("qty") - $product->moovings->where("type", "OUT")->sum("qty");
            $product->update();
          $stocks[] = [$product->id, $product->moovings->where("type", "IN")->sum("qty") - $product->moovings->where("type", "OUT")->sum("qty")];
        }
    }
    $fees = Fee::where("category", 1)->orderBy("destination")->get();
    return view("products")->with("products", $products->toJson())->with("stocks",json_encode( $stocks))->with("client", $client)->with("fees", $fees);

   }


   public function catalog(Request $request){

    $client = Client::findOrFail($request->client);
    $products = $client->products;

    $title = ""; 

    if($request->search){
        $products = Product::where("client_id", $request->client)
                            ->where('name', 'LIKE', "%{$request->search}%")
                               ->orWhere('description', 'LIKE', "%{$request->search}%")
                               ->get();

       $title = "Resultat de la recherche:(".$products->count().")<br> <a href='?client=$request->client'>Voir tous les article</a>";                        
    }



     $stocks = array();

    foreach($products as $product){
        if($product->moovings->count() > 0){

          $product->stock = $product->moovings->where("type", "IN")->sum("qty") - $product->moovings->where("type", "OUT")->sum("qty");
            $product->update();
          $stocks[] = [$product->id, $product->moovings->where("type", "IN")->sum("qty") - $product->moovings->where("type", "OUT")->sum("qty")];
        }
    }
    $fees = Fee::where("category", 1)->orderBy("destination")->get();
    return view("catalog")->with("products", $products->toJson())->with("stocks",json_encode( $stocks))->with("client", $client)->with("fees", $fees)->with("title", $title);

   }

   public function create(Request $request){
     $validated = $request->validate([
        'name' => 'required',
        'price' => 'required',

    ]);
 
    $product = new Product;
    $product->name = $request->name;
    $product->price = $request->price;
    $product->client_id = Auth::user()->client_id;

    $product->description = $request->description;


     if($request->file()) { 
            
            $path = Storage::disk('s3')->put('image',$request->file, 'public');
            
            
            $product->photo = $path;
            
        }
   
     $product->save();

     if(is_numeric($request->qty) && $request->qty>0){
        $mooving = new Mooving;
        $mooving->type = "IN";
        $mooving->qty = $request->qty;
        $mooving->description = "STOCK_INITIAL";
        $mooving->product_id = $product->id;
        $mooving->save();
     }

     return redirect()->back()->with("status", "produit enregistre");

  }


  public function edit(Request $request){
     $validated = $request->validate([
        'name' => 'required',
        'price' => 'required',

    ]);
 
    $product = Product::findOrFail($request->id);
    $product->name = $request->name;
    $product->price = $request->price;
    $product->client_id = Auth::user()->client_id;

    $product->description = $request->description;


     if($request->file()) { 
            
            $path = Storage::disk('s3')->put('image',$request->file, 'public');
            
            
            $product->photo = $path;
            
        }
   
     $product->update();

     if(is_numeric($request->qty) && $request->qty>0){
        $mooving = Mooving::where("product_id", $request->id)->where("description", "STOCK_INITIAL")->first();
        $mooving->type = "IN";
        $mooving->qty = $request->qty;
        $mooving->description = "STOCK_INITIAL";
        $mooving->product_id = $product->id;
        $mooving->update();
     }

     return redirect()->back()->with("status", "produit modifie");

  }



   public function mooving(Request $request){
     $validated = $request->validate([
        'qty' => 'required',
        'type' => 'required',
        'description' => 'required',

    ]);
 
    

     if(is_numeric($request->qty) && $request->qty>0){
        $mooving = new Mooving;
        $mooving->type = $request->type;
        $mooving->qty = $request->qty;
        $mooving->description = $request->description;
        $mooving->product_id = $request->id;
        $mooving->save();
     }

     return redirect()->back()->with("status", "Mouvement enregistre");

  }

  public function updatecmdprod(Request $request){
       $model = Command::findOrFail($request->id);
    if($request->products){
        $model->products()->detach();
        $deletemoov = Mooving::where("description", "COMMAND_".$request->id)->delete();
        $goods_type = "";
        $montant = array();
        $products = $request->products;

      
        foreach($products as $product){
            
          $data = explode("_",$product);
        
        //Get current product
        $prod = Product::findOrFail($data[0]);
        
        //Check product mooving related to current command
    
      
            $mooving = new Mooving;
            

            $mooving->product_id = $data[0];
           $mooving->type = "OUT";
           $mooving->qty = $data[1];
            $mooving->description = "COMMAND_$model->id";

        $mooving->save();
      

        $stock = $prod->moovings->where("type", "IN")->sum("qty") - $prod->moovings->where("type", "OUT")->sum("qty");
        
        //pdate product stock
        $prod->stock = $stock;
        $prod->update();
        

        $goods_type .= $data[1]. " ".$prod->name. ", ";

        
        
          $model->products()->attach($data[0], ['qty' => $data[1], 'price' =>$prod->price]);  
        
       
        
        
        $montant[] = $prod->price*$data[1];

        }



        $model->description = $goods_type;
        $model->montant = array_sum($montant);

        
       
      }else{
        $model->products()->detach();
        $model->description = "Aucun produit";
        $model->montant = 0;

        $deletemoov = Mooving::where("description", "COMMAND_".$request->id)->delete();
      } 

      $model->update();
    return redirect()->back()->with("status", "Articles mis a jour");
  }
}
