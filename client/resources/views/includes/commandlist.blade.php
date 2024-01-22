<div    v-for="(command, index) in commands" :key="command.id" @click="updateVariant(index)" class="card squared target col-sm-6 col-lg-4 mt-2 ">
    <div class="card-body">
      
        <div class="row " style="color: black;" >
                     
                         <div class="col" style="font-size: 13px; line-height: 1.6; font-style: italic; font-weight: bold;"> 
                        via: @{{command.canal}}
                        </div>

                 </div>
        
        <div style="font-weight: bold; color: black;" class="row">
            
            <span class="mr-2" >
               <input :value="command.id" @change="checkCmd(command.id)"  type="checkbox" class="cmds_chk" >
              </span>
                <div class="chip chip-media bg-light">
                    <i class="chip-icon bg-success">
                        <ion-icon name="bag"></ion-icon>
                    </i>
                    <span class="chip-label">@{{command.description.substring(0, 100)}}</span>
                </div>
            
            
        </div>

        <div data-toggle="modal" data-target="#cmdDetailModal">
       <div class=" row ">
            <div style="line-height: 1.6;" class="col">
             
              <span id="" style="font-size:20px;color:black; ">
                    (@{{index+1}}) @{{command.id}} 
               </span>
               <span class="ml-2">
                <button v-if="command.etat == 'en chemin'" onclick="document.getElementById('EtatDetail').click()" class="btn btn-outline-warning btn-sm">
                 <i   class="fas fa-walking text-warning "></i>En chemin
                </button>
                <button v-if="command.etat == 'recupere'" onclick="document.getElementById('EtatDetail').click()" class="btn btn-outline-warning btn-sm">
                <i   class="fas fa-dot-circle text-warning "></i>Récupéré
                </button>
                <button v-if="command.etat == 'encours'" onclick="document.getElementById('EtatDetail').click()" value="" class="btn btn-outline-danger btn-sm">
                <i id=""   class="fas fa-dot-circle text-danger "></i>
                <span v-if="command.livreur_id == 11">En Attente</span>
                <span v-else>Encours</span>
                </button>
                <button v-if="command.etat == 'annule'" onclick="document.getElementById('EtatDetail').click()" class="btn btn-outline-secondary btn-sm">      
                <i id="state_c"   class="fas fa-window-close  "></i>Annulé
                </button>
                <button v-if="command.etat == 'termine'" onclick="document.getElementById('EtatDetail').click()" class="btn btn-outline-success btn-sm">
                <i   class="fa fa-check text-success "></i>Livré
                </button>
               </span>
            </div>       
        </div>

        <div class="row">
            <span>
                <ion-icon name="location"></ion-icon>
                @{{command.adresse.substring(0, 40)}}
            </span>
        </div>
        <div class="row">
            <span>
                <ion-icon name="call"></ion-icon>
                @{{command.phone}}
            </span>
        </div>
        <div class="row">

            <div class="col" style="font-weight: bold; color:black;">
                <ion-icon name="cash"></ion-icon>
                @{{command.montant+command.livraison-command.remise}}
            </div>
             <div class="col" v-if="command.payment">
                <span v-if="command.payment.etat == 'termine'" class="stamp is-approved">PAYE</span>
            </div >
             
        </div>
      </div>
         <div   class="row" class="row" style="font-size: 12px; line-height: 1.6; font-style: italic; font-weight: bold;">
           
             <!-- <div class="col-4">
            <button data-toggle="modal" data-target="#cmdDetailModal" onclick="document.getElementById('livDEtail').click()" class="btn btn-primary btn-sm " v-if="command.livreur.id != '11'">
                <ion-icon name="bicycle"></ion-icon>
                @{{command.livreur.nom.substring(0, 15)}}
            </button>
             
            <button data-toggle="modal" data-target="#cmdDetailModal" onclick="document.getElementById('livDEtail').scrollIntoView({behavior: 'smooth', block: 'end', inline: 'nearest'})" class="btn btn-primary btn-sm"  v-else>
                <ion-icon name="bicycle"></ion-icon>
                Non assigne
            </button>
          </div> -->
       


                

                    <div class="col-4">
                       
                       <a v-if="command.products.length > 0" @click="updateProducts(command.products,command.id)" data-toggle="modal" data-target="#productsModal" class="btn  btn-primary  phone btn-sm " href="#" >
                            <i class="fa fa-cart-plus"></i>
                            
                            @{{command.products.length}} articles
                         </a>

                         <a  data-toggle="modal" data-target="#productsModal" @click="updateProducts({}, command.id)" class="btn  btn-primary  phone btn-sm " href="#" v-else>
                            <i class="fa fa-cart-plus"></i>
                            Articles
                         </a>
                        
                        
                       </div>
                      
                       <div class="col-4">
                          <input  @change="prepareCmd(command.id)" type="checkbox"  data-onstyle="primary" data-offstyle="secondary"   :checked="command.ready == 'yes'"data-onlabel="Prêt" data-offlabel="Prêt?"  data-toggle="switchbutton" data-size="sm" >
                         </div> 

                         <div class="col-4">
                        <button @click="duplicate(command.products,command.id)" class="btn btn-sm btn-primary">
                            <i class="fa fa-copy"></i>
                        </button>
                    </div>   
                   
        </div>
       
         <div class="row">
            <span data-toggle="modal" data-target="#noteViewModal" @click="getNote(command.id)" v-if='command.note.length > 0' >

                <ion-icon name="document"></ion-icon>
               @{{command.note[command.note.length-1].created_at.substring(8, 10)}}-
               @{{command.note[command.note.length-1].created_at.substring(5, 7)}}-
               @{{command.note[command.note.length-1].created_at.substring(0, 4)}} @{{command.note[command.note.length-1].created_at.substring(11, 16)}}  
               <span class="text-warning"> @{{command.note[command.note.length-1].description}} </span>
               <span v-if="command.note[command.note.length-1].livreur != null">.Par: @{{command.note[command.note.length-1].livreur.substring(0, 50)}}</span>

            </span>
        </div>
          <div class="row">
            <a href="#" data-toggle="modal" data-target="#eventViewModal" @click="getEvent(command.id)"  class="text-primary">
              Historique
            </a>
        </div>

    </div>   
</div>



























