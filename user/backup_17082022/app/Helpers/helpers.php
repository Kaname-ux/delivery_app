<?php
namespace App\Helpers; // Your helpers namespace 
use App\User;
use App\Command;
use App\Fee;
use Auth;


class LivreurHelper
{
    
    public static function getLivreursCmds($id)
    {
        $fees = Fee::all();

        $by_zone = Command::where("livreur_id", $id)->selectRaw('COUNT(fee_id) nbre, (fee_id) fee_id')
     ->where('etat', '!=', 'termine')->where('etat', '!=', 'annule')->where('delivery_date', today())
    ->groupBy('fee_id')
    ->get();


    foreach($by_zone as $zone)
  {
   $zone_output .= "<div class='chip chip-media' style='margin-bottom: 3px'>
                     <i class='chip-icon  bg-success '>
                      $zone->nbre
                        </i>
                       <span class='chip-label'>";
     foreach($fees as $fee2)
       {
         if($zone->fee_id == $fee2->id)
           {$zone_output .= $fee2->destination;}
       }

       $zone_output .= "</span>
                    </div>";
    }

    return $zone_output;
        
    }



}