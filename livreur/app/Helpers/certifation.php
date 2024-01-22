<?php
namespace App\Helpers;
use App\Certification;
use 

public function checkcertify($livreur, $id){
    $demand = Certification::where("livreur_id", $id)->where("status", "pending")->first();
   if($livreur->certified_at == NULL)
   {
    if(!$demand)
    {echo '<div class="section mt-2">
                <div class="section-title"></div>
    
                <div class="row">
    
                    <div  class="col-12">
                        
                        <div class="card border border-danger bg-light text-center">
                    <div class="card-header">Certifiez votre compte</div>
                    <div class="card-body">
                        <strong>A partir du 31 Janvier 2022, seuls les livreurs certifiés par Jibiat pourront recevoir des assignations et figurer dans la liste des livreurs</strong>
                        <a href="certification" class="btn btn-primary btn-block">Certifier Mon compte</a>
                     </div>
                 </div></div></div>
             </div>';
         }else{
            echo '<div class="section mt-2">
                <div class="section-title"></div>
    
                <div class="row">
    
                    <div  class="col-12">
                        
                        <div class="card border border-danger bg-light text-center">
                    <div class="card-header">Certifiez votre compte</div>
                    <div class="card-body">
                        votre demande est encours d\'examen.<br>
                        demande effectuée le.'.$demand->created_at->format('d-m-Y').' 
                     </div>
                 </div></div></div>
             </div>'
         }

   }else
   {
     if($livreur->certified_at != null)
     {
        echo '<i style="margin-right: 10px"  class="fa fa-check text-success fa-2x"></i> Votre compte est certifié!';
     }
   }
}
