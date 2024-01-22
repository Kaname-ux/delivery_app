<?php

namespace App\Http\Controllers;
use App\Product;
use App\Client;
use App\Fee;
use App\Mooving;
use App\Command;
use App\Product_category;

use App\Source;


use Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
class ProductsController extends Controller
{
   public function products(){

    $client = Client::findOrFail(Auth::user()->client_id);
   
    
    $products = Product::where("client_id", $client->id)->get();
     $stocks = array();
     $sources = Source::get();
    foreach($products as $product){
        if($product->moovings->count() > 0){

            $product->stock = $product->moovings->where("type", "IN")->sum("qty") - $product->moovings->where("type", "OUT")->sum("qty");
            $product->update();
          $stocks[] = [$product->id, $product->moovings->where("type", "IN")->sum("qty") - $product->moovings->where("type", "OUT")->sum("qty")];
        }
    }
    $categories = Product_category::where("client_id", $client->id)->get(); 
    $fees = Fee::where("category", 1)->orderBy("destination")->get();
    return view("products")->with("products", $products->toJson())->with("categories", $categories->toJson())->with("stocks",json_encode( $stocks))->with("client", $client)->with("fees", $fees)->with("sources", $sources);

   }


   public function catalog(Request $request){

    $client = Client::findOrFail($request->client);
    $products = Product::with("images")->where("client_id", $request->client)->get();

    $title = ""; 

    if($request->search){
        $products = Product::where('name', 'LIKE', "%{$request->search}%")
                             ->where("client_id", $request->client)
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
        'name' => 'required|string|max:500',
        'price' => 'required|numeric|max:99999999999',
        
         'description'=> 'string|max:2000' 
        
    ]);
 
    $product = new Product;
    $product->name = $request->name;
    $product->price = $request->price;
    $product->client_id = Auth::user()->client_id;

    $product->description = substr($request->input('description'),0,2000);
    $product->category = $request->category;



     if($request->hasFile('file')) { 
            
            $path = Storage::disk('s3')->put('image',$request->file, 'public');
            
            
            $product->photo = $path;
            
        }
        


   
     $product->save();


     $variants = array(['size1', 'stock1'],
                       ['size2', 'stock2'],
                       ['size3', 'stock3'],
                       ['size4','stock4'],
                       ['size5', 'stock5'],
                       ['size6', 'stock6'],
                       ['size7','stock7'],
                       ['size8', 'stock8']);

     foreach($variants as $variant){
        if($request->input($variant[0]) != ""){
            $product_variant = new Product_variant;

            $product_variant->attribute = 'Taille'; 
             $product_variant->value = $request->input($variant[0]);
            if(is_numeric($request->input($variant[1]))){
              $product_variant->stock = $request->input($variant[1]);
            }
            $product_variant->product_id = $product->id;
            $product_variant->save();
        }
     }


      if($request->hasFile('file1')) { 
            
        $path1 = Storage::disk('s3')->put('image',$request->file1, 'public');
            
            $img1 = new Product_image;
            $img1->path = $path1;
            $img1->product_id = $product->id;

            $img1->save();
            
        }

       if($request->hasFile('file2')) { 
            
            $path2 = Storage::disk('s3')->put('image',$request->file2, 'public');
            $img2 = new Product_image;
            $img2->path = $path2;
            $img2->product_id = $product->id;

            $img2->save();
            
        }

        if($request->hasFile('file3')) { 
            
            $path3 = Storage::disk('s3')->put('image',$request->file3, 'public');
            $img3 = new Product_image;
            $img3->path = $path3;
            $img3->product_id = $product->id;

            $img3->save();
            
        }

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
    $product = Product::findOrFail($request->id);
      $validated = $request->validate([
        'name' => 'required|string|max:500',
        'price' => 'required|numeric|max:99999999999',
        
         'description'=> 'string|max:2000',
        
        
         
    ]);
 
    
    $product->name = $request->name;
    $product->price = $request->price;
    $product->client_id = Auth::user()->client_id;

    $product->description = substr($request->input('description'),0,2000);
    $product->category = $request->category;



     if($request->hasFile('file')) { 
            
            $path = Storage::disk('s3')->put('image',$request->file, 'public');
            
            
            $product->photo = $path;
            
        }
        


   
     $product->save();


     $variants = array(['size1', 'stock1'],
                       ['size2', 'stock2'],
                       ['size3', 'stock3'],
                       ['size4','stock4'],
                       ['size5', 'stock5'],
                       ['size6', 'stock6'],
                       ['size7','stock7'],
                       ['size8', 'stock8']);

     foreach($variants as $variant){
        if($request->input($variant[0]) != ""){
            $product_variant = new Product_variant;

            $product_variant->attribute = 'Taille'; 
             $product_variant->value = $request->input($variant[0]);
            if(is_numeric($request->input($variant[1]))){
              $product_variant->stock = $request->input($variant[1]);
            }
            $product_variant->product_id = $product->id;
            $product_variant->save();
        }
     }


      if($request->hasFile('file1')) { 
            
        $path1 = Storage::disk('s3')->put('image',$request->file1, 'public');
            
            $img1 = new Product_image;
            $img1->path = $path1;
            $img1->product_id = $product->id;

            $img1->save();
            
        }

       if($request->hasFile('file2')) { 
            
            $path2 = Storage::disk('s3')->put('image',$request->file2, 'public');
            $img2 = new Product_image;
            $img2->path = $path2;
            $img2->product_id = $product->id;

            $img2->save();
            
        }

        if($request->hasFile('file3')) { 
            
            $path3 = Storage::disk('s3')->put('image',$request->file3, 'public');
            $img3 = new Product_image;
            $img3->path = $path3;
            $img3->product_id = $product->id;

            $img3->save();
            
        }

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


   public function removeproduct(Request $request){
    $id = $request->id;

    $product = Product::findOrFail($id);
    $moovings = Mooving::where("product_id", $id)->get();

    if($moovings){
       foreach($moovings as $mooving)
        {$mooving->delete();}
    }

    if($product->command){
         foreach($product->command as $command)
        {$command->delete();}
    }

    $product->delete();

    $products = Product::where("client_id", Auth::user()->$client_id)->get();

    

    return response()->json(["updatedProducts"=> $products]);
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

  public function addcategory(Request $request){
     $name = $request->name;

     $category = new Product_category;
     $category->name = $name;
     $category->client_id = Auth::user()->client_id;
     $category->save();


     $categories = Product_category::where("client_id", Auth::user()->client_id)->get();

     return response()->json(["updatedCategory"=>$categories]);
  }

  public function removecategory(Request $request){
     $id = $request->id;

     $category = Product_category::findOrFail($id);
     $category->delete();

     $categories = Product_category::where("client_id", Auth::user()->client_id)->get();

     return response()->json(["updatedCategory"=>$categories]);
  }


 public function createproductfirststep(Request $request){
    $validated = $request->validate([
        'name' => 'required',
        'price' => 'required',

    ]);
 
    $product = new Product;
    $product->name = $request->name;
    $product->price = $request->price;
    $product->cost = $request->cost;
    $product->category = $request->category;
    $product->client_id = Auth::user()->client_id;
    $product->description = $request->description;

    $product->save();

    return response()->json(['newProd'=> $product]);
 }
}
