<?php

namespace App\Http\Controllers;
use App\Difuse;
use App\Livreur;
use App\Fee;
use App\Command;
use App\Client;
use App\Product;
use App\Mooving;
use App\User;
use App\Lesroute;
use App\Company;


use Illuminate\Pagination\Paginator;
use Illuminate\Support\MessageBag;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\LivreurHelper;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use DateTime;
use willvincent\Rateable\Rating;
use App\Helpers\Sms;

class PublicController extends Controller
{
    public function livreurs(Request $request){


$livreurs = Livreur::where('status', 'active')->where('id', '!=', 9)->where('id', '!=', 20)->where('id', '!=', 81)->where("certified_at", "!=", null);


          
 $zone = "Tous les livreurs"; 
 if($request->input('city'))
  {$livreurs = Livreur::where('city', $request->city)->where('status', 'active'); $zone = $request->city;}

   
 if($request->input('livreur_id'))
  {
    $livreurs = Livreur::where('id',$request->input('livreur_id'))                ->where('status', 'active')
                        ->orWhere('nom', 'like','%'.$request->input('livreur_id').'%')
                        ->orWhere('phone', 'like','%'.$request->input('livreur_id').'%');  
   $zone = "Resultat de votre recherche";
  }

  if($request->input('asearch'))
  {
     $livreurs = Livreur::where("status","active");

     if(!empty($request->input("cities")) )
     {
      $cities = $request->input("cities");
      $livreurs = $livreurs->whereIn("city", $cities);
     }
     
     if($request->input("certified") == 1)
     {
      $livreurs = $livreurs->where("certified_at", "!=", NULL); 
     }

    $zone = "Resultat de votre recherche";
  }


$livreurs = $livreurs->orderBy("certified_at", "desc")->paginate(20);

 $fees = Fee::where('category', '1')->orderBy('destination', 'asc')->get();
 return view('livreurs_public')->with('livreurs', $livreurs)->with('zone', $zone)->with('fees', $fees);
}



public function getglobalnearby(Request $request)
  {             
    
   function datediff($date1, $date2){
  
        $diff=date_diff($date1,$date2);
       $days = $diff->format("%d");
       $hours = $diff->format("%H");
       $mn =  $diff->format("%i");
       $periode = array('Jours'=>$days, 'h'=>$hours, 'mns'=>$mn);
      $duration = "";
       
       foreach ($periode as $key => $value) {
         if($value != 0)
         {
          $duration .= $value.$key;
         }

      
   }
     return $duration ;
 }
   function distance($lat1, $lon1, $lat2, $lon2, $unit) {
  if (($lat1 == $lat2) && ($lon1 == $lon2)) {
    return 0;
  }
  else {
    $theta = $lon1 - $lon2;
    $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
    $dist = acos($dist);
    $dist = rad2deg($dist);
    $miles = $dist * 60 * 1.1515;
    $unit = strtoupper($unit);

    if ($unit == "K") {
      return ($miles * 1.609344);
    } elseif ($unit == "N") {
      return ($miles * 0.8684);
    } else {
      return $miles;
    }
  }
}



    $lat = $request->lat; 
    $long = $request->long;
    $cur = date_create(date("Y-m-d H:i:s"));
    

    $livreurs = Livreur::where('latitude', '!=', null)->where('longitude', '!=', null)
                        ->where('geotime', '!=', null)->orderBy('geotime', 'desc')
                        ->where('status', 'active')->limit(10)->get();

 
  $nearby = "<div class='transactions'>";
  
 $title2 = "";
 $assign_script="";
  if(count($livreurs)>0){
    foreach($livreurs as $livreur){
      if( distance($livreur->latitude, $livreur->longitude, $lat, $long, 'K') <=5 ){
       $remaining = $livreur->commands->where('etat', '!=', 'termine')->where('etat', '!=', 'annule')->where('delivery_date', today())->count();
            $cert = "";
          if($livreur->certified_at != NULL)
          {
            $cert = "<span class='text-success'><ion-icon name='checkmark-outline'></ion-icon>Certifié</span><br>";
          }


      $nearby .=    "<span  class='item'>
                    <div class='detail'>
                        
                        <img ";

                         if(Storage::disk('s3')->exists($livreur->photo))
                        {$nearby .= "  src='https://livreurjibiat.s3.eu-west-3.amazonaws.com/".$livreur->photo."'  class='image-block imaged big' ";}
                         else { $nearby .= "src='assets/img/sample/brand/1.jpg' alt='img' ";}
                        

  $nearby .=  "class='image-block imaged'
                    alt='img' width='80'>



                        <div>

                        <strong>".$livreur->nom." ".$cert ."</strong>
                           ";

                      $nearby .= "<ion-icon name='location-outline'></ion-icon> Se trouve à ".number_format(distance($livreur->latitude, $livreur->longitude, $lat, $long, 'K') , 2, '.', ',')
      ."km il y a ".datediff(date_create($livreur->geotime), $cur).".<br><br>";     
              $nearby .=  $remaining  . " livraison(s) encours";
              

              $fees = Fee::all();

        $zone_output = "";


         $by_zone = Command::where("livreur_id", $livreur->id)->selectRaw('COUNT(fee_id) nbre, (fee_id) fee_id')
     ->where('etat', '!=', 'termine')->where('etat', '!=', 'annule')->where('delivery_date', today())
    ->groupBy('fee_id')
    ->get();


    foreach($by_zone as $zone)
  {
   $zone_output .= "<div class='chip chip-media' style='margin-bottom: 3px'>
                     <i class='chip-icon  bg-success '>".
                      $zone->nbre
                        ."</i>
                       <span class='chip-label'>";
     foreach($fees as $fee2)
       {
         if($zone->fee_id == $fee2->id)
           {$zone_output .= $fee2->destination;}
       }

       $zone_output .= "</span>
                    </div>";
    }

        $route = Lesroute::where('livreur_id', $livreur->id)->where('action', "STATUS")->orderBy('created_at', "desc")->first();

        if($route)
         {$zone_output .= "<div class='text-primary'>Dernière Action: ". $route->observation. " - ".$route->created_at->format("d-m-Y H:i"). "</div>";}
$nearby .= $zone_output;


                

                     $nearby .=   "<a type='button' style=' font-weight: bold;' href='tel:".$livreur->phone."' class='btn btn-primary phone'>
                       <ion-icon name='call-outline'></ion-icon></a>";

                          
                    

              

          

      
      $nearby .=  " </div>
                    </div>";
                   
                   $nearby .= "</span> ";

      }
    }

 
   
  }
    else{
   $nearby ="Il n'y a aucun livreur à proximité";
    }
   $nearby .= "</div>";
    return response()->json(['nearby'=>$nearby]);
  
  }


  public function publicdifuse(Request $request){

    $request->validate([
        "from" => "required",
        "qty" => "required",
        "deliv_date" => "required",
        "contact" => "required",
        "wa" => "required"
    ]);

   $qties = array();
   $cities = array();
   $fees = array();
   $destinations = "";

    $text = $request->qty. " colis.<br> Lieu de Récuperation: ". $request->from . ".<br> Date de livraison: ".date_create($request->deliv_date)->format("d-m-Y");

    if(!empty($request->single_fee)){
        $text .= ".<br> Tarif unique:". $request->single_fee . "FCFA.";

      if($request->cities && $request->qties)
      {  $cities = $request->cities; $qties = $request->qties;
        if(count($cities) == count($qties)){

          for($x=0; $x < count($request->cities); $x++){
            $text .= "<div class='chip chip-media' style='margin-bottom: 3px'>
                        <i class='chip-icon bg-dark'>$qties[$x]</i><span class='chip-label'>$cities[$x].</span></div>";

                        $destinations .= $cities[$x].",";
          }
        }


      }
    }

    if(empty($request->single_fee)){
if($request->cities && $request->qties && $request->fees)
      {  $cities = $request->cities; $qties = $request->qties; $fees = $request->fees;
        if(count($cities) == count($qties) && count($cities) == count($fees)){

          for($x=0; $x < count($request->cities); $x++){
            $text .= "<div class='chip chip-media' style='margin-bottom: 3px'>
                        <i class='chip-icon bg-dark'>$qties[$x]</i><span class='chip-label'>$cities[$x]: $fees[$x]F.</span>
                    </div>";
                    $destinations .= $cities[$x].",";
          }

          
        }
      }

    }
    

     

$difuse = new Difuse;

$difuse->description = $text;
$difuse->wa = $request->wa;

$difuse->delivery_date = $request->deliv_date;
$difuse->ram_adress = $request->from;
$difuse->destinations = $destinations;
$difuse->ram_phone = $request->contact;
$difuse->status = "encours";

$difuse->save();
$ref = date_create("2022-06-31");
if(date("Y-m-d")<$ref)
{
    $sms = "Colis disponibles. Un vendeur vient de publier une recherche de livreur. Connecte toi vite pour avoir le marché. https://livreurjibiat.site/difusions";
    $livreurs = Livreur::where("certified_at", "!=", null)->get();
    
    $config = array(
                'clientId' => config('app.clientId'),
                'clientSecret' =>  config('app.clientSecret'),
            );
    
            $osms = new Sms($config);
    
            $data = $osms->getTokenFromConsumerKey();
            $token = array(
                'token' => $data['access_token']
            );


            $response = $osms->sendSms(
                          // sender
                            'tel:+2250709980885',
                           // receiver
                          'tel:+2250153141666',
                          // message
                           $sms,
                           'Jibiat'
                                                   );



            $response = $osms->sendSms(
                          // sender
                            'tel:+2250709980885',
                           // receiver
                          'tel:+225'.$request->contact,
                          // message
                           "Votre annonce a été postée, numero d'annonce".$difuse->id. ". Entrez ce numero dans la partie vérifier l'etat d'une annonce pour votre l'annonce et les livreurs qui y ont postulé. RDV sur https://client.livreurjibiat.site/livreurs_public",
                           'Jibiat 0153141666'
                                                   );


            $response = $osms->sendSms(
                          // sender
                            'tel:+2250709980885',
                           // receiver
                          'tel:+225'.$request->contact,
                          // message
                           "Vous vendez en ligne? créez votre compte sur https://client.livreurjibiat.site/register. trouvez des livreurs certifiés, suivez vos commandes de la récuperation jusqu'à la livraison. ",
                           'Jibiat 0153141666'
                                                   );
    
    // foreach($livreurs as $livreur)
    //      {   if(strlen($livreur->phone == 10))
    //                {  
    //                  $response = $osms->sendSms(
    //                       // sender
    //                         'tel:+2250153141666',
    //                        // receiver
    //                       'tel:+225'.$livreur->phone,
    //                       // message
    //                        $sms,
    //                        'Jibiat'
    //                                                );
    //                }
    //      }

}


    
    

return redirect()->back()->with("status", "Demande Postéé. Numero de publication <stron> $difuse->id </strong> (Veuillez enregister ce numero, il vous permettra de voir les livreur qui y ont postulé.)  <button class='btn-primary difusecheck'>Voir</button>")->with("id", $difuse->id);
  }


 public function difusecheck(Request $request){
  $id = $request->id;
  
  $difusion = Difuse::findOrFail($id);
    $candidates = "<h2>Postulants</h2><ul>";
    foreach($difusion->livreurs as $liv){

      $candidates .= "<li >".$liv->nom." </ion-icon></a><br>"
                    ."<input  readonly class='rating rating-loading'  data-step='1' value=' ".$liv->AverageRating()." ' data-size='xs'>".
                                      $liv->Ratings()->count() .
                                    " vote(s)<br>"

      .$liv->pivot->updated_at->format('d-m-Y H:i')."<br><span id='loc$liv->id'>".$liv->pivot->longitude."</span><br>
          <a  class='link' href='https://www.google.com/maps/search/?api=1&amp;query=".$liv->pivot->latitude."%2C".$liv->pivot->longitude."'><ion-icon name='navigate-outline' role='img' class='md hydrated' aria-label='navigate outline'></ion-icon>Voir sa position sur map</a>
      <br>

     <a class='btn btn-sm btn-primary' href='tel:$liv->phone'><ion-icon name='call-outline'></ion-icon></a> <a class='btn btn-sm btn-outline-success' href='https://wa.me/225$liv->wa'><ion-icon name='logo-whatsapp'></ion-icon></a>

      </li><hr>";
      $candidates .= "
      
      
    

<script src='../assets/js/star-rating.min.js'></script>
      <script>
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


  
  return response()->json(["difuse"=>$difusion, "livreurs"=>$candidates]);
 }


 public function commandfastregister(Request $request)
    {
        
        $client_id = $request->client;
        $delivery_date = $request->input('delivery_date');
        $phone = str_replace(' ', '',$request->input('phone'));
        $fee_id = $request->input('fee');
        $adresse = substr($request->input('adresse'),0,200);
        $observation = substr($request->input('observation'),0,200);
        
        
        

        if($request->fee)
        {$actual_fee = Fee::findOrFail($request->input('fee'));}

        $goods_type = "colis";
        if($request->type)
         {$goods_type = substr($request->type,0,1000);}


        
       
        $client = Client::findOrFail($client_id);
        $montant = preg_replace('/[^0-9]/', '', $request->input('montant'));
         if(!is_numeric($montant)){$montant = 0;}

        $costumer = substr($request->costumer,0,150);
        
        
        
         
       

       $command_adress = $actual_fee->destination . ":".$adresse;
      


     
       

      
      $model = new Command;
       

       $model->description = $goods_type;
       $model->montant = $montant;
       $model->delivery_date = $delivery_date;
       $model->adresse = $command_adress;
       
       $model->client_id = $client_id;
       $model->phone = $phone;
       $model->fee_id = $fee_id;
       $model->etat = "encours";

       $model->canal = "catalogue";
       $model->remise = 0;
       $model->nom_client = $costumer;
        $model->livraison = 0;
            


       
       $model->observation = $observation;
        
          $model->livreur_id = 11;
        

       
       $model->save();
     


       $mooved = array();

       if($request->products){
        $goods_type = "";
        $montant = array();
        $products = $request->products;

        foreach($products as $product){
          $data = explode("_",$product);
        
       
        $prod = Product::findOrFail($data[0]);
        $prod->stock = $prod->stock-$data[1];
        $mooving = new Mooving;
        
        $mooving->product_id = $data[0];
        $mooving->type = "OUT";
        $mooving->qty = $data[1];
        $mooving->description = "COMMAND_$model->id";

        $mooving->save();
        $prod->update();

        $goods_type .= $data[1]. " ".$prod->name. ", ";
        $model->products()->attach($data[0], ['qty' => $data[1], 'price' =>$prod->price]);
        
        $montant[] = $prod->price*$data[1];

        }



        $model->description = $goods_type;
        $model->montant = array_sum($montant);

        $model->update();
       }


         if($request->product_id){
        $goods_type = "";
        
        $product_id = $request->product_id;

          
        
       
        $prod = Product::findOrFail($product_id);


        $prod->stock = $prod->stock-$request->qty;
        $mooving = new Mooving;
        
        $mooving->product_id = $product_id;
        $mooving->type = "OUT";
        $mooving->qty = $request->qty;
        $mooving->description = "COMMAND_$model->id";

        $mooving->save();
        $prod->update();

        $goods_type .= $request->qty. " ".$prod->name;
        $model->products()->attach($product_id, ['qty' => $request->qty, 'price' =>$prod->price]);
        
        $montant = $prod->price*$request->qty;

        



        $model->description = $goods_type;
        $model->montant = $montant;

        $model->update();
       }
   
       Session::flush();
   

       return redirect()->back()->with('status', "Votre commande numero <span style='font-weight:bold; font-size:25px'>$model->id</span> a ete envoyee a $client->nom. cliquez ici pour voir le statut de votre commande. <a target='blank' href='/tracking/$model->id' class='btn btn-warning'>Tracking</a>");
    }


     public function catalog(Request $request){

    $client = Client::findOrFail($request->client);
    

    $title = ""; 

     $stocks = array();

     $products = Product::with("images")->with("variants");

    if($request->search){
        $products = $products->where('name', 'LIKE', "%{$request->search}%")
                               ->orWhere('description', 'LIKE', "%{$request->search}%")
                               ;

       $title = "Resultat de la recherche:(".$products->count().")<br> <a href='?client=$request->client'>Voir tous les article</a>";                        
    }




   


  $total =0;
  $cart= 0;

  $products = $products->get();
    foreach($products as $product){
        if($product->moovings->count() > 0){

          $product->stock = $product->moovings->where("type", "IN")->sum("qty") - $product->moovings->where("type", "OUT")->sum("qty");
            $product->update();
          $stocks[] = [$product->id, $product->moovings->where("type", "IN")->sum("qty") - $product->moovings->where("type", "OUT")->sum("qty")];
        }
    }
 
  

$products = $products->toJson();
$cartproducts = new Product();
 if(Session::has('cart') && Session::get('cart') > 0)
    {   $cartproducts = Session::get('products');
        $stocks = Session::get('stocks');
        $cart = Session::get('cart');
        
        $total = Session::get('total');
      }
  
   $company = Company::first();
    
    $fees = Fee::where("category", 1)->orderBy("destination")->get();
    return view("catalog")->with("products", $products)->with("stocks", json_encode($stocks))->with("client", $client)->with("fees", $fees)->with("title", $title)->with("cart", $cart)->with("total", $total)->with("company", $company)->with("cartproducts", $cartproducts);

   }


    public function detail(Request $request){



    $client = Client::findOrFail($request->client);
    
   if(Session::has('cart') && Session::get('cart') > 0)
    {   $products = Session::get('products');
        $stocks = Session::get('stocks');
        $cart = Session::get('cart');
        $variant = $request->variant;
        $total = Session::get('total');
      }

        else{ 

            $stocks = array();
           $cart = 0;
        
            $total = 0;
             $products = Product::with("images")->with("variants")->get();

             foreach($products as $index=>$product){
        if($product->moovings->count() > 0){

          $product->stock = $product->moovings->where("type", "IN")->sum("qty") - $product->moovings->where("type", "OUT")->sum("qty");
            $product->update();
          $stocks[] = [$product->id, $product->moovings->where("type", "IN")->sum("qty") - $product->moovings->where("type", "OUT")->sum("qty")];

          
        }

        if($product->id ==  $request->id)
          {
            $variant = $index;
          }
    }
        }


    $title = ""; 


    $selectedproduct = Product::with("images")->findOrFail($request->id);
    $stock = $selectedproduct->stock;
    $fees = Fee::where("category", 1)->orderBy("destination")->get();
    return view("productdetail")->with("products", $products)->with("stocks",json_encode( $stocks))->with("client", $client)->with("fees", $fees)->with("title", $title)->with("product", $selectedproduct)->with("stock", $stock)->with("cart", $cart)->with('variant', $variant)->with("total", $total);
  }

  public function updatesession(Request $request){
    Session::put("products",$request->products);
    Session::put("cart",$request->cart);
    Session::put("stocks",$request->stocks);
    Session::put("total",$request->total);

    $product = Product::findOrFail($request->id);
    
   
     
        $stock = $product->stock;
        
     
     

    return response()->json(["stock"=>$stock]);
    
  }

  public function productavailability(Request $request){
    $id = $request->id;
     $available = 0;
    $product = Product::find($id);

    if($product){
      $available = 1;
    }
    return response()->json(["available"=>$available]);
  }

}






