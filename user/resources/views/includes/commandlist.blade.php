

<div :hidden="displayed != 'box'" class="section mt-2">



    <div class="row">



        <div class="col">



         <form class="search-form form-inline">



            <div class="form-group searchbox">



                <input id="Search" @keyup="search()" v-model="input" name="text" type="text"  placeholder="Recherche...">



        
            </div>


        </form>



        <input @change="checkAll('cmds_chk1', 'checkAll1')"  type="checkbox" class="ml-2 mr-2" id="checkAll1" >@{{Object.keys(selectedCommands).length}} Slectionn(s)



    </div>



    <div class="col">



         <form action="?">
                                <div hidden>
                                     <input value="{{$state}}" type="text" name="state">
                                       <input value="{{$start}}" type="text" name="start">
                                    <input value="{{$end}}"  type="text" name="end">
                                    <input value="{{$page}}"  type="text" name="begining">
                                     <input value="unassigned"  type="text" name="assigns[]">
                                </div>
                                    
          <button v-if="input2 == 'en attente'"  type="button" @click="input2 = '';  searchInput()" class="btn phone btn-dark  ">< Retour</button>
                        <button v-if="getUnassigned > 0"  type="button" @click="input2 = 'en attente';  searchInput()" type="button" class="btn phone btn-warning mr-2 text-dark">@{{getUnassigned}} courses non assignées sur cette page</button>
                         
                        <button class="btn btn-warning" type="submit"  style="font-weight: bold;">@{{allAssigned}} courses non assignées sur la période</button>
                    </form>


    </div>



</div>



<div  class="row">



<div   v-for="(command, index) in commands" :key="command.id" @mouseover="updateVariant(index)" class=" target col-sm-6 col-lg-4 mt-2 ">







<div class="card squared ">



    <div class="card-body table-responsive">







         <div class="col" v-if="command.payment">



                <span v-if="command.payment.etat != 'termine'" class="badge badge-danger">Non Encaissée</span>



            </div >



        <div class="row " style="color: black;" >



                     <div class="col" style="font-size: 13px; line-height: 1.6; font-style: italic; font-weight: bold;"> 



                      (@{{index}})  By: @{{command.client.nom}}



                        </div>







                         <div class="col" style="font-size: 13px; line-height: 1.6; font-style: italic; font-weight: bold;"> 



                        via: @{{command.canal}}



                        </div>







                 </div>



        



        <div style="font-weight: bold; color: black;" class="row">



            



            <span class="mr-2" >



               <input :value="command.id" @change="checkCmd(command.id, 'cmds_chk1')"  type="checkbox" class="cmds_chk1" >



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



                     @{{command.id}} 



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



                @{{command.adresse.substring(0, 40)}}.



                @{{command.nom_client.substring(0, 40)}}



                



            </span>



        </div>



        <div class="row">



            <div class="col">



                <span class="badge badge-primary">1</span>



                <ion-icon name="call"></ion-icon>



                @{{command.phone}}



                



            </div>







            <div class="col">



                 <span class="badge badge-primary">2</span>



                <ion-icon class="icon" name="call"></ion-icon>



                @{{command.phone2}}



               



            </div>



        </div>



        <div class="row">



            <div class="col" style="font-weight: bold; color:black;">



                <ion-icon class="icon" name="cash"></ion-icon>



                @{{command.montant+command.livraison-command.remise}}



            </div>



             <div class="col" v-if="command.payment">



                <span v-if="command.payment.etat == 'termine'" class="stamp is-approved">Encaissée</span>



            </div >



        </div>



      </div>



         <div   class="row" style="font-size: 12px; line-height: 1.6; font-style: italic; font-weight: bold;">



            @if($command_roles->contains('action', 'LIVREUR_R'))



             <div class="col-4">



            <button data-toggle="modal" data-target="#cmdDetailModal" onclick="document.getElementById('livDEtail').click()" class="btn btn-primary btn-sm " v-if="command.livreur.id != '11'">



                <ion-icon name="bicycle"></ion-icon>



                @{{command.livreur.nom.substring(0, 15)}}



            </button>



             



            <button data-toggle="modal" data-target="#cmdDetailModal" onclick="document.getElementById('livDEtail').scrollIntoView({behavior: 'smooth', block: 'end', inline: 'nearest'})" class="btn btn-primary btn-sm "  v-else>



                <ion-icon name="bicycle"></ion-icon>



                Non assigne



            </button>



          </div>



        @endif











                







                    <div class="col-3">



                        @if($command_roles->contains('action', 'PRODUCT_U'))



                       <a v-if="command.products.length > 0" @click="updateProducts(command.products,command.id)" data-toggle="modal" data-target="#productsModal" class="btn  btn-primary  phone btn-sm " href="#" >



                            <ion-icon name="cart-outline"></ion-icon>



                            @{{command.products.length}} articles



                         </a>







                         <a  data-toggle="modal" data-target="#productsModal" @click="updateProducts({}, command.id)" class="btn  btn-primary  phone btn-sm " href="#" v-else>



                            <ion-icon name="cart-outline"></ion-icon>



                            Ajoueter articles



                         </a>



                         @endif



                        



                       </div>



                       @if($command_roles->contains('action', 'PREPARE_U'))



                       <div class="col-3">



                          <input  @change="prepareCmd(command.id)" type="checkbox"  data-onstyle="primary" data-offstyle="secondary"   :checked="command.ready == 'yes'"data-onlabel="Prêt" data-offlabel="Prêt?"  data-toggle="switchbutton" data-size="sm" >



                         </div> 



                    @endif







                    <div class="col-2">



                        <button @click="duplicate(command.products,command.id)" class="btn btn-sm btn-primary">



                            <i class="fa fa-copy"></i>



                        </button>



                    </div>    



        </div>







         <div v-if="command.observation" class="row">



            <a href="#" data-toggle="modal" data-target="#eventViewModal" @click="getEvent(command.id)"  class="text-primary">



             


            </a>
             <i class="fa fa-info"></i> @{{command.observation}}



        </div>



        @if($command_roles->contains('action', 'NOTE_R'))



         <div class="row">



            <span data-toggle="modal" data-target="#noteViewModal" @click="getNote(command.id)" v-if='command.note.length > 0' >







                <ion-icon name="document"></ion-icon>



               @{{command.note[command.note.length-1].created_at.substring(8, 10)}}-



               @{{command.note[command.note.length-1].created_at.substring(5, 7)}}-



               @{{command.note[command.note.length-1].created_at.substring(0, 4)}} @{{command.note[command.note.length-1].created_at.substring(11, 16)}}  



               <span class="text-warning"> @{{command.note[command.note.length-1].description}} </span>



            </span>



        </div>



        @endif







        @if($command_roles->contains('action', 'EVENT_R'))



         <div class="row">



            <a href="#" data-toggle="modal" data-target="#eventViewModal" @click="getEvent(command.id)"  class="text-primary">



              Historique



            </a>



        </div>



        @endif



    </div>   



</div>



</div>



</div>







</div>















<div class="card" :hidden="displayed != 'table'">



    <div class="card-header">



       



        <div class="row">



      <div class="col">



          <input type="text" id="searchInput" v-model="input2" @keyup="searchInput" class="form-controle" placeholder="Recherche">



      </div>







      <div class="col">


 <form action="?">
                                <div hidden>
                                     <input value="{{$state}}" type="text" name="state">
                                       <input value="{{$start}}" type="text" name="start">
                                    <input value="{{$end}}"  type="text" name="end">
                                    <input value="{{$page}}"  type="text" name="begining">
                                     <input value="unassigned"  type="text" name="assigns[]">
                                </div>
                                    
          <button v-if="input2 == 'en attente'"  type="button" @click="input2 = '';  searchInput()" class="btn phone btn-dark  ">< Retour</button>
                        <button v-if="getUnassigned > 0"  type="button" @click="input2 = 'en attente';  searchInput()" type="button" class="btn phone btn-warning mr-2 text-dark">@{{getUnassigned}} courses non assignées sur cette page</button>
                         
                        <button class="btn btn-warning" type="submit"  style="font-weight: bold;">@{{allAssigned}} courses non assignées sur la période</button>
                    </form>



    </div>



        </div>



        



    </div>



    



    <div class="card-body table-responsive" id="cmdTable">



        <table id="example2"  class="table table-bordered table-striped table-responsive dataTable">



                  <thead>



                  <tr>



                    <th class="d-print-none"><input @change="checkAll('cmds_chk', 'checkAll')" type="checkbox" id="checkAll" >



                       @{{Object.keys(selectedCommands).length}} Selection(s)</th>



                    <th>Numero</th>



                     



                     <th>Client </th>



                    <th>Description</th>



                    <th>Date de livraison</th>



                    <th>Ramassage</th>



                    <th>Destination</th>



                    <th>Livreur</th>



                    <th>Prix</th>



                    <th>Livraison</th>



                    <th>Total</th>



                    <th>Info</th>
                    <th>Decharge</th>



                  </tr>



                  </thead>



                  <tbody>



                                       <tr  :class="getClass(index) " v-for="(command, index) in commands" :key="command.id" @mouseover="updateVariant(index)" >



                       <td class="d-print-none">

                           <div class="position-relative">
  
  <div v-if="command.subscription_type == 'MAD'" class="position-absolute bottom-0 end-0 bg-success">MAD</div>

  <div v-if="command.subscription_type == 'DISTRIBUTION'" class="position-absolute bottom-0 end-0 bg-warning">DISTRIB</div>

  <div v-if="command.subscription_type == NULL" class="position-absolute bottom-0 end-0 bg-danger">ECOM</div>
</div>

                           <input :value="command.id" @change="checkCmd(command.id, 'cmds_chk')"  type="checkbox" class="cmds_chk" > 







                           <button data-toggle="modal" data-target="#cmdDetailModal" @click="updateVariant(index)" class="btn ml-2"><i class="fas fa-edit"></i> </button>


                         
                       </td>



                        



                       <td>



                           <span v-if="command.user" style="color: black; font-weight: bold;">Enregistrée par @{{command.user.name}}</span>



                        <span style="color: black; font-weight: bold;" v-else>Enregistrée par le client</span><br>







                        # <strong style="color: black; font-weight: bold; font-size: 20px">@{{command.id}}</strong><br>



                            <span v-if="command.etat == 'en chemin'"   class="text-warning">



                 <i   class="fas fa-walking text-warning "></i>En chemin



                </span>



                <span v-if="command.etat == 'recupere'"    value="" class="text-warning">



                <i   class="fas fa-dot-circle text-warning "></i>Récupéré



                </span>



                <span v-if="command.etat == 'encours'"    value="" class="text-danger">



                <i id=""   class="fas fa-dot-circle text-danger "></i>



                <span v-if="command.livreur_id == 11">En Attente</span>



                <span v-else>Encours</span>



                </span>



                <span v-if="command.etat == 'annule'"     value="" class="text-secondary">      



                <i id="state_c"   class="fas fa-window-close  "></i>Annulé



                </span>



                <span v-if="command.etat == 'termine'"   value="" class="text-success">



                <i   class="fa fa-check text-success "></i>Livré



                </span> 

                 @if($command_roles->contains('action', 'NOTE_R'))



         <div class="row">



            <span data-toggle="modal" data-target="#noteViewModal" @click="getNote(command.id)" v-if='command.note.length > 0' >







                <ion-icon name="document"></ion-icon>



               @{{command.note[command.note.length-1].created_at.substring(8, 10)}}-



               @{{command.note[command.note.length-1].created_at.substring(5, 7)}}-



               @{{command.note[command.note.length-1].created_at.substring(0, 4)}} @{{command.note[command.note.length-1].created_at.substring(11, 16)}}  



               <span class="text-warning"> @{{command.note[command.note.length-1].description}} </span>



            </span>



        </div>



        @endif

         @if($command_roles->contains('action', 'EVENT_R'))



         <div class="row">



            <a href="#" data-toggle="modal" data-target="#eventViewModal" @click="getEvent(command.id)"  class="text-primary">



              Historique



            </a>



        </div>



        @endif



                       </td>







                       <td style="color: black; font-weight: bold;">

                          <span v-if="command.client">

                          @{{command.client.nom}} - @{{command.department}}<br>



                         @{{command.client.adresse}} 



                        @{{command.client.phone}}  

                       </span>
                       <span v-else>
                           @{{command.ram_commune}} 



                          @{{command.ram_adresse}}<br>



                          @{{command.ram_phone}} 
                       </span>

                       </td>







                       <td style="color: black; font-weight: bold;">



                           @{{command.description}}



                       </td>







                       <td style="color: black; font-weight: bold;">



                          @{{command.delivery_date.substring(8, 10)}}-



                             @{{command.delivery_date.substring(5, 7)}}-



                            @{{command.delivery_date.substring(0, 4)}} 



                       </td>







                       <td style="color: black; font-weight: bold;">



                          @{{command.ram_commune}} 



                          @{{command.ram_adresse}}<br>



                          @{{command.ram_phone}} 



                       </td>







                       <td style="color: black; font-weight: bold;">



                           <span  style="font-size: 13px; line-height: 1.6; font-style: italic;"> 



                        Nom: @{{command.nom_client}}



                        </span><br>



                        <strong>



                          @{{command.adresse}}<br>



                          @{{command.phone}} / @{{command.phone2}}



                        </strong> 



                       </td>







                       <td style="color: black; font-weight: bold;">



                         @if($command_roles->contains('action', 'LIVREUR_R'))



                           <button @click="updateVariant(index)"  data-toggle="modal" data-target="#cmdDetailModal"  class="btn btn-primary btn-sm d-print-none" >



                      <span v-if="command.livreur_id == '11'">Non assigne</span>



                      <span v-if="command.livreur && command.livreur_id != '11'">@{{command.livreur.nom}}</span>



                    </button>







                    <span class="d-none d-print-block" v-if="command.livreur_id == '11'">Non assigne</span>



                      <span class="d-none d-print-block" v-if="command.livreur && command.livreur_id != '11'">@{{command.livreur.nom}}</span>



                      @endif



                       </td>







                       <td style="color: black; font-weight: bold;">



                            @{{command.montant}}



                       </td>







                       <td style="color: black; font-weight: bold;">



                           @{{command.livraison}} 



                       </td>







                       <td style="color: black; font-weight: bold;">



                          @{{command.montant-command.remise+command.livraison}} 



                       </td>







                       <td style="color: black; font-weight: bold;">



                          @{{command.observation}} 



                       </td>

                       <td style="color: black; font-weight: bold;">



                          @{{command.decharge}} 



                       </td>



                   </tr>



                  </tbody>



              </table>



        



    </div>



</div>







<div class="container d-none"  id="cmdEti">



<div class="row " >



                     



                   



                       <div v-for="command in commands" class="col-3 border position-relative"  style="height: 13cm">



                        



                                # <strong>@{{command.id}}</strong><br>



                            <span v-if="command.etat == 'en chemin'"   class="text-warning">



                 <i   class="fas fa-walking text-warning "></i>En chemin



                </span>



                <span v-if="command.etat == 'recupere'"    value="" class="text-warning">



                <i   class="fas fa-dot-circle text-warning "></i>Récupéré



                </span>



                <span v-if="command.etat == 'encours'"    value="" class="text-danger">



                <i id=""   class="fas fa-dot-circle text-danger "></i>



                <span v-if="command.livreur_id == 11">En Attente</span>



                <span v-else>Encours</span>



                </span>



                <span v-if="command.etat == 'annule'"     value="" class="text-secondary">      



                <i id="state_c"   class="fas fa-window-close  "></i>Annulé



                </span>



                <span v-if="command.etat == 'termine'"   value="" class="text-success">



                <i   class="fa fa-check text-success "></i>Livré



                </span> 



                          <strong>@{{command.id}}</strong> <br>



                          Date de livraison:  @{{command.delivery_date.substring(8, 10)}}-



                             @{{command.delivery_date.substring(5, 7)}}-



                            @{{command.delivery_date.substring(0, 4)}} <br>



                          prix: @{{command.montant-command.remise}}. Livraison: @{{command.livraison}}<br>



                         



                          <strong>Total: @{{command.livraison + command.montant}}</strong><br>



                            



                           Colis:  @{{command.description}}<br><br>







                        







                          Expéditeur: 



                          <span v-if="command.client">@{{command.client.nom}}</span>



                          <br><br>



                          



                          Destinataire:<br>



                           <strong>@{{command.phone}}</strong><br>



                           



                          <span v-if="command.client_non" class="col" style="font-size: 13px; line-height: 1.6; font-style: italic;"> 



                         @{{command.nom_client}}



                        </span><br>



                       



                          @{{command.adresse}}<br>



                          



                          <span v-if="command.observation">



                          Info: @{{command.observation}}<br>



                          



                           </span> 



                           <span v-if="command.livreur_id == 11">



                           <ion-icon class="" name="bicycle-outline"></ion-icon> 



                           



                          @{{command.livreur.nom}}



                      </span>



                      <span v-else>



                         



                          Non assigne



                          </span><br>



                           



                          



                        <div class="position-absolute bottom-0 end-0"><img width="64" height="64"  src="assets/img/logo.png"></div>



                          



                   </div>



                      



                       </div>



                      </div>







































































































