<?php
namespace App\Helpers;
use App\User;
use App\Command;
use App\Fee;
use App\Lesroute;
use DateTime;
use Auth;
use Illuminate\Pagination\Paginator;
use Geocoder\Laravel\ProviderAndDumperAggregator as Geocoder;

class LivreurHelper
{
    public static function actionint($start, $end)
    {
      $units = array("%D"=>"Jrs", "%H"=>"h", "%I"=>"mns", "%S"=>"s");
      $dtediff  = $start->diff($end);
      $int = "";
      foreach($units as $code=>$unit)
      { 
        if($dtediff->format($code) != 00)
        {
          $int .= $dtediff->format($code. $unit. " ");
          
        }
      }
      return $int;
    }

    public static function getLivreursCmds($id)
    {
        

       

        $fees = Fee::all();

        $zone_output = "";

        $routes = Lesroute::where('livreur_id', $id)->where('action', "STATUS")->orderBy('created_at', "desc")->limit(3)->get();


       $zone_output .= "<div >Dernières Actions: <button class='btn float-right action' value='$id'>Voir Toutes les actions</button><br>";
        if($routes)
         {
          foreach($routes as $x=> $route)
           { $zone_output .= "<i  class='fas  fa-circle text-success'></i>". $route->created_at->format("d-m-Y H:i") ." - <span class='text-primary'>". $route->observation . "</span>"; 
        if($route->latitude != null && $route->longitude != null)
        {
          

           $zone_output .= "<br><ion-icon name='navigate-outline'></ion-icon>".  app('geocoder')->reverse($route->longitude,$route->latitude)->get();
          
        }


        if($x + 1 < 3)
          
            {$zone_output .= " <div style='text-align: center;'><strong>";
         


      $units = array("%D"=>"Jrs", "%H"=>"h", "%I"=>"mns", "%S"=>"s");
      $dtediff  = $route->created_at->diff($routes[$x+1]->created_at);
      $int = "";
      foreach($units as $code=>$unit)
      { 
        if($dtediff->format($code) != 00)
        {
          $int .= $dtediff->format($code. $unit. " ");
          
        }
      }
      $zone_output .= $int;
    
         $zone_output .="</strong><br>
                            <ion-icon name='arrow-down-outline'></ion-icon>
                        </div>";
          }
          
          
        $zone_output .=  "<br>";
       }

      $zone_output .= "</div>";}

        $by_zone = Command::where("livreur_id", $id)->selectRaw('COUNT(fee_id) nbre, (fee_id) fee_id')
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

    echo $zone_output;
        
    }

   public static function getLivreursCount($id, $field)
    {
      return Command::where('etat', 'termine')->where($field, $id)->count('livraison');
    }


    public static function detail($id, $name)
    {
      echo "<a href='livreurdatail/$id'>$name</a>";
    }


    public static function actions($id)
    {
      $zone_output = "";

        $routes = Lesroute::where('livreur_id', $id)->where('action', "STATUS")->orderBy('created_at', "desc")->paginate(20);


       
        if($routes)
         {
          foreach($routes as $route)
           { $zone_output .= "<i  class='fas  fa-circle text-success'></i>". $route->created_at->format("d-m-Y H:i") ." - <span class='text-primary'>". $route->observation . "</span>"; 
        if($route->latitude != null && $route->longitude != null)
        {
          

           $zone_output .= "<br><ion-icon name='navigate-outline'></ion-icon>".  app('geocoder')->reverse($route->longitude,$route->latitude)->get();
          
        }
        $zone_output .=  "<br><br>";
       }

      $zone_output .= "</div>";}
      echo $zone_output;
    }

 

}