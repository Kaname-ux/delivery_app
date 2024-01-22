<div v-for="cmd in cmds">
<div    class="section full target  mt-2">
      <div class="card">
          <div class="card-body">
            <div class=" row ">
             
              <div style="line-height: 1.6;" class="col-4">
                <span v-if="cmd.etat != 'termine' && cmd.etat != 'annule'">
                   
                    <input id="" type="checkbox" class="cmd_chk" data-id="">
                  </span>
                    <span id="" style="font-size:20px;color:black; ">
                        <ion-icon v-if="cmd.is_difused == 'yes'" class="text-info" name="radio-outline"></ion-icon>@{{ cmd.id }} 
                   </span>
                    <span style="font-size:11px">
                   </span>
                 </div>
              <div class="col-7">
                  <span  style="font-size:17px; " class="ml-3">
                   <ion-icon name="cash-outline"></ion-icon>
                    @{{ cmd.livraison + cmd.montant }} 
                  </span>
                    <span v-if="cmd.payment" v-for="payment in cmd.payment"  v-if="payment == termine" class="badge badge-success">
                    Payé
                    </span> 
             </div>
                <div class="col-1 float-right">
                  <button>
                    <ion-icon class="text-primary" name="ellipsis-vertical"></ion-icon>
                    </button>  
                </div>
             </div>

             <div class="row mt-0">
                 <div style="line-height: 1.6; font-size:13px" class="col-4">
                 <i v-if="cmd.etat == 'en chemin'"  class="fas fa-walking text-warning "></i>En chemin
                 <i v-if="cmd.etat == 'recuperer'"  class="fas fa-dot-circle text-warning "></i>Récupéré
                 <i v-if="cmd.etat == 'encours'"   class="fas fa-dot-circle text-danger "></i>encours
                 <i v-if="cmd.etat == 'annule'"   class="fas fa-window-close  "></i>Annulé
                 <i  v-if="cmd.etat == 'termine'" class="fa fa-check text-success "></i>Livré
                  <br>
                    @{{ cmd.updated_at }}
                    </div>

            <div v-if="cmd.note.lenght > 0" class="col-2">
            <button class="note btn text-warning">Note</button>
            </div>
          <div class="col-6">
            <button ><ion-icon name="radio-outline"></ion-icon> Diffuser</button>
        </div>

     <div v-if="cmd.observation" class="col-6">
           <ion-icon class="text-danger ml-1" name="information-circle-outline"></ion-icon>
        @{{ cmd.observation }}
    </div>
    
             </div>
             <a  href="#" >
             <div class="row mt-2" style="color: black;" >
                     <div class="col-6" style=" line-height: 1.6; font-weight: bold;"> 
                        <ion-icon name="location-outline"></ion-icon>
                        @{{ cmd.adresse }}</div>

                     <div class="col-6" style="font-size: 13px; line-height: 1.6; font-weight: bold;"> 
                         <ion-icon class="" src="assets/img/bag-outline.svg"></ion-icon>@{{ cmd.description }} </div>
 
                     
                 </div>
                 <div  class="row">
                     <div    style=" font-weight: bold;">
                     <ion-icon class="" name="bicycle-outline"></ion-icon> 
                        <span  >
                     
                     
  <span v-if="cmd.livreur_id == 11">Non assigné</span> 
  <span v-if="cmd.livreur_id != 11" v-for="livreur in cmd.livreur" >@{{ livreur.nom }}</span> 
    
</span>
                         </div>
                 </div>
                 </a>
            <div class="mt-2 row">
                <div class="col-2">
                 <input  type="checkbox" value="" data-onstyle="primary" data-offstyle="secondary" class="ready"  data-onlabel="Prêt" data-offlabel="prêt?"  data-toggle="switchbutton" data-size="sm" >
                 </div>
                 
                 <div v-if="cmd.livreur_id != 11" class="col-6" >
                 
                        
                            
                        
                              <a class="btn  btn-primary  phone btn-sm" href="#" >
                            <ion-icon name="mail-outline"></ion-icon>
                            Ecrire au client et au livreur
                         </a>
                          
                         </div>

                          
   
      <div v-if="cmd.etat != 'termine' && cmd.etat != 'annule'" class="col-4">
      <span  class="dropup mt-1" >
      
      <button style="font-weight: bold;"  class="btn btn-primary    dropdown-toggle btn-sm" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span  hidden="hidden" class="spinner-border spinner-border-sm " role="status" aria-hidden="true"></span><span class="sr-only"></span>
      
      
      <span v-if="cmd.livreur_id == 11">Assigner</span>
      <span v-else>Réassigner</span>
                         
                        
      
      </button>
      <span class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
      <button v-if="client.livreurs.lenght > 0" href="#"  class="dropdown-item showLivreur"  >
      
        <ion-icon  name="list-outline"></ion-icon>
        Choisir un livreur dans ma liste
    
      </button>

     
      <button v-else onclick="window.location.href = 'livreurs'" class="dropdown-item" > <ion-icon  name="list-outline"></ion-icon>Ajouter des livreurs à votre liste</button>
     
      <a class="dropdown-item nearByLivreur phone"   ><ion-icon  name="navigate-outline"></ion-icon>Trouver un livreur à proximité</a>
      </span>
      </span>
      </div>
 
    
</div>
          </div>
         
      </div>   

    
        </div>
        </div>