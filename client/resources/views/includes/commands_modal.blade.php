


<style type="text/css">
    .modal { overflow: auto !important; }
 

    

</style>



      



        <div class="modal fade dialogbox" id="difusionModal" data-backdrop="static" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h5 class="modal-title"><ion-icon name="radio-outline"></ion-icon> Diffusion</h5>
                       

                    </div>
                    
                    <div class="modal-body" id="diffusionModalBody">
                        
                        <button class="btn btn-primary btn-block difuse">Diffuser </button>


                        <hr>
               <span class="text-center">Ramassage</span>

               <div class="form-group">
        <label class="form-label">
        <input class="ram" value="1" type="checkbox"  name="same" > Ramassage à mon adresse.
        </label>
        
      </div>  
     <div class="form-group"> 
      <label class="form-label"> Lieu de ramassage</label>

      <input value="" maxlength="150" value="" id="ram_adress" name="ram_adress" class="form-control" required type="text" placeholder="Exemple: grand carrefour... pharmacie... rivera jardin..." >

      <span class="text-danger" id="ram_adress_er"></span>
      </div>

         

       <div class="form-row">
        <div class="col">
          <label class="form-label">Indicatif</label>
          <select class="form-control">
            <option>+225</option>
          </select>
        </div>
        <div class="col-8">
      <label class="form-label">Contact de ramassage</label>
      <input id="ram_phone" value="" required  name="ram_phone" class="form-control" type="number" placeholder="Numero de ramassage sans l'indicatif(225)"  autocomplete="off">
      <span class="text-danger" id="ram_phone_er"></span>
      </div>         
      </div>

                    </div>
                    <!-- <div class="form-group">
                    <select class="form-control ram">
                       <option value="ownadresse">Ramassage à mon a mon adresse</option>
                       <option value="other">Ramassage à une autre adresse</option> 
                    </select>    
                    </div> -->
                    
      
                
            </div>
        </div>
      </div>





      
        <div class="modal fade dialogbox" id="bulkdifusionModal" data-backdrop="static" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h5 class="modal-title"><ion-icon name="radio-outline"></ion-icon> Diffusion</h5>
                       

                    </div>
                    
                    <div class="modal-body" id="bulkdiffusionModalBody">
                        
                        <button class="btn btn-primary btn-block bulkdifuse">Diffuser </button>


                        <hr>
               <span class="text-center">Ramassage</span>

               <div class="form-group">
        <label class="form-label">
        <input class="bulkram" value="1" type="checkbox"  name="same" > Ramassage à mon adresse.
        </label>
        
      </div>  
     <div class="form-group"> 
      <label class="form-label"> Lieu de ramassage</label>

      <input value="" maxlength="150" value="" id="bulkram_adress" name="ram_adress" class="form-control" required type="text" placeholder="Exemple: grand carrefour... pharmacie... rivera jardin..." >

      <span class="text-danger" id="bulkram_adress_er"></span>
      </div>

         

       <div class="form-row">
        <div class="col">
          <label class="form-label">Indicatif</label>
          <select class="form-control">
            <option>+225</option>
          </select>
        </div>
        <div class="col-8">
      <label class="form-label">Contact de ramassage</label>
      <input id="bulkram_phone" value="" required  name="ram_phone" class="form-control" type="number" placeholder="Numero de ramassage sans l'indicatif(225)"  autocomplete="off">
      <span class="text-danger" id="bulkram_phone_er"></span>
      </div>         
      </div>

                    </div>
                    <!-- <div class="form-group">
                    <select class="form-control ram">
                       <option value="ownadresse">Ramassage à mon a mon adresse</option>
                       <option value="other">Ramassage à une autre adresse</option> 
                    </select>    
                    </div> -->
                    
      
                
            </div>
        </div>
      </div>










      <div class="modal fade dialogbox" id="bulkRptModal" data-backdrop="static" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Reporter la selection</h5>
                        <button id="bulkReportClose" type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                  
                        <div class="modal-body text-left mb-2">

                            <div class="form-group basic">
                                <div class="input-wrapper">
                                    <label class="label" for="account1">Date</label>
                                    <input v-model='bulkRptDate' type="date" class="form-control custom-input" id="bulk_rpt_date">
                                    <div class="text-danger date_err"></div>   
                                </div>
                                <div class="input-info">Choisir date de report</div>
                            </div>
                       <input id="ynbassign" type="checkbox" name="ynbassign">Désassigner 

                       <input id="ynbreset" type="checkbox" name="ynbreset">Reiniialiser
                        </div>


                        <div class="modal-footer">
                            <div class="btn-inline">
                                <button  type="button" class="btn btn-text-primary" data-dismiss="modal">ANNULER</button>
                                <button @click="bulkReport" :disabled="!bulkRptDate" type="button" class="btn btn-primary" 
                                    >CONFIRMER</button>
                                
                            </div>
                        </div>
                    
                </div>
            </div>
        </div>
        <!-- * Dialog Form -->

        <div style="z-index: 1000;" id="toast-10" class="toast-box toast-center">
            <div class="in">
                <ion-icon name="checkmark-circle" class="text-success"></ion-icon>
                <div class="text">
                    Action effectuee
                </div>
            </div>
            <button type="button" class="btn btn-sm btn-text-light close-button">FERMER</button>
        </div>


        <!-- Assign modal -->
        <div class="modal fade modalbox " id="LivChoice" tabindex="-1" role="dialog">
            <div  class="modal-dialog" role="document">
                <div  class="modal-content">
                    <div class="modal-header">
                        
                        <h5 class="modal-title">Assinger la selection</h5>
                        <button type="button" id="LivChoiceClose" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div   class="modal-body">
                        <div  class="action-sheet-content LivChoiceBody">
                            
                           <div  class='transactions'>
                            <button @click='bulkAssign(11)' type='button' class='btn  btn-danger' > Desassigner</button>
                    <span v-for="(zone_livreur, index) in clientLivreurs "  class='item'>
                     <div class='detail'>
                        <img 
                          :src="findImage(zone_livreur.photo)"  class='image-block imaged big' 
                          alt='img'  
                        alt='img' width='80'>


                        <div>
                        <strong>@{{zone_livreur.nom}}</strong>

                        
                        <div >
                        
                        
                        
                        <button @click="getLivreurCmds(zone_livreur.id, index, 'zone')"  class="btn btn-primary btn-sm">Voir assigantions actuelles</button><br>

                       <div  :id="'zoneDetail'+index">
                        
                        </div>
                    </div>
                    <br><button @click='bulkAssign(zone_livreur.id)' type='button' class='btn  btn-primary mr-2' > Assigner</button><a type='button' style=' font-weight: bold;' href="tel:@{{zone_livreur.phone}}" class='btn btn-primary phone'>
                       <ion-icon name='call-outline'></ion-icon></a>
                       
                        </div>
                    </div>
                    </span>
                    </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- Note modal -->
        <div class="modal fade action-sheet  " id="noteViewModal" tabindex="-1" role="dialog">
            <div  class="modal-dialog" role="document">
                <div  class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h5 class="modal-title">Notes de livraison</h5>
                        

                    </div>
                    <div   class="modal-body">
                        <div id="noteViewBody" class="action-sheet-content noteViewBody">
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="modal fade action-sheet  " id="eventViewModal" tabindex="-1" role="dialog">
            <div  class="modal-dialog" role="document">
                <div  class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h5 class="modal-title">Evenement commande</h5>
                        

                    </div>
                    <div   class="modal-body">
                        <div id="eventViewBody" class="action-sheet-content eventViewBody">
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- return modal -->
        <div class="modal fade " id="cmdRtrnModal" tabindex="-1" role="dialog">
            <div  class="modal-dialog" role="document">
                <div  class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Commandes non livré</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                       
                        

                        
                         

                    </div>
                    <div   class="modal-body">
                        <div hidden class="float-left cmdRtrnReturn">
                    <a href="#" class="headerButton cmdRtrnBack">
                        <ion-icon name="chevron-back-outline"></ion-icon>
                        Retour
                    </a>
                     </div>
                     <div  class="float-right cmdRtrnLivreur">
                    
                     </div>
                        <div class="action-sheet-content cmdRtrnBody">
                            <span  hidden="hidden" class="spinner-border  cmdRtrnSpinner" role="status" aria-hidden="true"></span><span class="sr-only"></span>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>


         <!-- return modal -->
        <div class="modal fade modalbox  " id="payModal" tabindex="-1" role="dialog">
            <div  class="modal-dialog" role="document">
                <div  class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Points livreurs</h5>
                      
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        
                        
                         
                       
                       
                    
                     
                        

                    </div>
                    <div   class="modal-body">

                       <div class="row">
                        <div hidden class="col left payReturn">
                        <a href="#" class="headerButton returnPay">
                        <ion-icon name="chevron-back-outline"></ion-icon>
                        Retour
                    </a>
                    </div>

                    
                           
                       </div>
                      


                      <span class="payLivreur"></span><br> <span class="payTotal float-right"></span><span class="rtrnTotal float-left"></span>
                        
                   
                        <div class="action-sheet-content payBody">
                            <span  hidden="hidden" class="spinner-border  paySpinner" role="status" aria-hidden="true"></span><span class="sr-only"></span>
                            
                        </div>
                        <hr>
                        <div hidden class="text-center payeur">
                           
                        <img  src='' alt='img'  class='payeurimg image-block imaged w48'>
                        <br>
                          Noter  <strong class="payeurnom"></strong>
                           
                        
                    

                    
                         <input  id='input-1' name='rate' class='rating rating-loading' data-min='1' data-max='5' data-step='1'  data-size='xs'><button type='submit' class='btn btn-success rateLivreur'>Envoyer Note</button>
                          <input class="payeurid" type='hidden' name='id' required value=''>
                            
                   
                    
                
                    </div>
                    <div class="paySuccess">
                      
                    </div>
                </div>
            </div>
        </div>
      </div>

        <!-- Dialog with Image -->

        <!-- Deposit Action Sheet -->
     
        

         <div  class="modal fade "  id="newCmdProdModal"  tabindex="-1" aria-hidden="true">
            <div  class="modal-dialog modal-dialog-scrollable" role="document">
                <div  class="modal-content">
                    <div class="modal-header">
                      <h5  class="modal-title editModalTitle">Mes produit</h5>
                        <a href="javascript:;" data-dismiss="modal">Fermer</a>
                        
                        

                    </div>
                    <div   class="modal-body">
                        <div class="row">
                           <div class="col">
                            <h3>Liste des produits</h3>
                           </div>
                           <div class="col">
                            <h3>Total: @{{ total }} </h3> 
                           </div> 
                        </div>
                        
                           <button   data-dismiss="modal" class="btn btn-primary"  >Terminer ajout</button>
                         
                        <div  v-for="(product, index) in products" :key="product.id" @mouseover="updateSelectedProduct(index)"  class="transactions mb-2 ">
                         
                        <div class="item border border-success" v-if="product.qty > 0 ">
                            <input hidden type="" :value="product.id+'_'+product.qty" name="products[]">
                <a href="#" >
                    <div class="detail">
                        <img :src="findImage(product.photo)" alt="img" class="image-block imaged w48">
                        <div >
                           
                            <strong>@{{ product.name }}</strong>
                            
                            
                        </div>
                    </div>

                     <button :disabled="product.qty > 0 ? false : true"  v-on:click="removeFromCart()" class="btn btn-danger btn-sm  mt-1" type="button"><ion-icon name="remove-outline"></ion-icon></button>
                      <button  :disabled="product.stock > 0 ? false : true"  v-on:click="addToCart()" class="btn btn-success btn-sm mr-1 mt-1" type="button"><ion-icon name="add-outline"></ion-icon></button>
                       
                    </a>
                    <div class="right">

                      
                       @{{ product.qty }} * @{{ product.price }} = @{{ product.price* product.qty}}<br>
                     
                      <span :class="product.stock > 0 ? 'text-success' : 'text-danger'">Stock @{{ product.stock }}</span>
                       
                        
                    </div>
                
                </div>
                </div>
            
                <!-- * item -->
                
                
                       <hr style="height: 12px;"> 
                       <h3>Mes produits</h3> 

                     <div class="form-group searchbox mb-2">
        <select onchange="searchcat()" id="searchCat" data-column="2" class="form-control">
                    <option value="">Toutes les categories</option>
                    <option :value="category.name" v-if="categories.length > 0" v-for="category in categories">@{{ category.name }}</option>
                 </select>
             </div> 

                       <div class="form-group searchbox ">
                <input onkeyup="search3()" id="Search3" type="text" class="form-control">
            <i class="input-icon">
                <ion-icon name="search-outline"></ion-icon>
            </i>
        </div>
           
            <div v-for="(product, index) in products" :key="product.id" @mouseover="updateSelectedProduct(index)" class="transactions mt-2 row target3">
                <!-- item -->
                <div  v-if="product.qty == 0" class="item border border-primary col">
                <a href="#" >
                    <div class="detail">
                        <img
                        :src="findImage(product.photo)"

                        alt="img" 
                         
                        

                         class="image-block imaged w48">
                        <div >
                           <p v-if="product.qty > 0"> @{{ product.qty }} dans le panier </p>
                            <strong>@{{ product.name }}</strong>
                            <p>@{{ product.category }}</p>
                        </div>
                    </div>
                      
                      <button :disabled="product.qty > 0 ? false : true"  v-on:click="removeFromCart()" class="btn btn-danger btn-sm  mt-1"><ion-icon name="remove-outline"></ion-icon></button>
                      <button  :disabled="product.stock > 0 ? false : true"  v-on:click="addToCart()" class="btn btn-success btn-sm mr-1 mt-1"><ion-icon name="add-outline"></ion-icon></button>
                     
                       
                    </a>
                    <div class="right">

                    Prix:  @{{ product.price }} F<br>
                     
                      <span :class="product.stock > 0 ? 'text-success' : 'text-danger'">Stock @{{ product.stock }}</span>
                      
                      
                        
                        
                    </div>

                  
                
                </div>
            </div>
                        
                </div>
            </div>
        </div>

      </div>
    
        <!-- * Deposit Action Sheet -->






       




       <!-- Deposit Action Sheet -->
        <div  class="modal fade " id="cmdDetailModal" tabindex="-1" role="dialog">
            <div  class="modal-dialog" role="document">
                <div  class="modal-content">
                    <div class="modal-header">
                        
                        <h5 class="modal-title">Details commande</h5>
                        <a @click="deleteConfirm = null" href="javascript:;" data-dismiss="modal">Fermer</a>

                    </div>
                    <div v-if="selectedVariant != null && checkAvailability(singleCommand.id) == 1"   class="modal-body detailBody">
                        
                        
            <div class="row mb-1">
                <div style="font-weight: bold;" class="col">
                    @{{singleCommand.id}}
                </div>

                
                <div class="col">
                    <button type="button" @click="shareBill('Commande'+ ' '+ singleCommand.id+'. '+singleCommand.description+ '. Total:'+ (Number(singleCommand.montant)+Number(singleCommand.livraison))+'. '+singleCommand.adresse+ '. '+singleCommand.phone+ '. Plus de detail sur {{ url('/') }}/tracking/'+singleCommand.id)" class="btn btn-primary btn-block mt-2 squared" id="bill"><ion-icon name="share-social"></ion-icon> FACTURE</button>
                </div>
                
               
                <div v-else  class="col">
                  
                   <button @click="deleteConfirm = 1" class="btn btn-sm float-right btn-danger btn-icon "><ion-icon name="trash"></ion-icon></button>
                </div>
             
            
           </div>
          
           <div v-if="deleteConfirm"  class="row mb-1">
                    
                   Souhaitez vous vraiment supprimer cette commande?
                    <div>
                    <button @click="deleteCmd" class="btn btn-danger mr-2">Oui</button> 
                    <button @click="deleteConfirm = null" class="btn btn-success">Non</button>
                    </div>
                </div>

                 
                 <div class="accordion" id="cmdPay">
                <div class="item">
                    <div class="accordion-header">
                        <button id="PayDetail" class="btn   collapsed" type="button" data-toggle="collapse"
                            data-target="#accordion200">
                           Payement:
                            <span v-if="singleCommand.payment"   class="text-warning">
                 <span v-if="singleCommand.payment.etat == 'termine'" class="badge badge-success">Encaissée</span>
                  <span v-else class="badge badge-danger">Non Encaissée</span>
                </span>
                <span v-else class="badge badge-danger">Non Encaissée</span>
                </button>
                    </div>
                    <div id="accordion200" class="accordion-body collapse" data-parent="#cmdPay">
                        <div class="accordion-content">
                            
                            <div v-if="singleCommand.payment" class="form-group">
                                <div class="form-group">
                            <label>Modifier etat de payment</label>
                            <select  id="cmdPayment" name="pay" v-model="cmdPayment"   class="form-control" >
                                <option>Choisir un etat</option>
                                <option    :selected="singleCommand.payment.etat == 'termine'" value="termine">Encaissée</option>

                                <option    :selected="singleCommand.payment.etat == 'en attente'" value="en attente">Non Encaissée</option>
                                
                            </select>

                             
                        </div>

                               
                            </div>

                             <div v-else class="form-group">
                                <div class="form-group">
                            <label>Modifier etat de payment</label>
                            <select  id="cmdPayment" name="pay" v-model="cmdPayment"  class="form-control" >
                                <option value="">Choisir un etat</option>
                                <option     value="termine">Encaissée</option>

                                <option  value="en attente">Non Encaissée</option>
                                
                            </select>



                             
                        </div>
                         </div>
                          <div v-if="cmdPayment == 'termine'" class='form-group'>
      <select class='form-control ' v-model="payMethod" id="payMethod">
       <option value=''>
        Choisir mode de paiement
       </option>

       <option value='Main à main'>
       Main à main
       </option>
       <option value='Mobile money'>
       Mobile money
       </option>
       <option value='Virement bancaire'>
        Virement bancaire
       </option>
      </select>

                               
                            </div>
                          <button :disabled="cmdPayment == ''" @click="updatePay"  class="btn btn-primary mt-1">Modifier</button>
                       
                    </div>
                </div>
            </div>
            </div>
        
            
            <div class="accordion" id="cmdEtat">
                <div class="item">
                    <div class="accordion-header">
                        <button id="EtatDetail" class="btn   collapsed" type="button" data-toggle="collapse"
                            data-target="#accordion000">
                           
                            <span v-if="singleCommand.etat == 'en chemin'"   class="text-warning">
                 <i   class="fas fa-walking text-warning "></i>En chemin
                </span>
                <span v-if="singleCommand.etat == 'recupere'"    value="" class="text-warning">
                <i   class="fas fa-dot-circle text-warning "></i>Récupéré
                </span>
                <span v-if="singleCommand.etat == 'encours'"    value="" class="text-danger">
                <i id=""   class="fas fa-dot-circle text-danger "></i>
                <span v-if="singleCommand.livreur.id == 11">En Attente</span>
                <span v-else>Encours</span>
                </span>
                <span v-if="singleCommand.etat == 'annule'"     value="" class="text-secondary">      
                <i id="state_c"   class="fas fa-window-close  "></i>Annulé
                </span>
                <span v-if="singleCommand.etat == 'termine'"   value="" class="text-success">
                <i   class="fa fa-check text-success "></i>Livré
                </span>
                        </button>
                    </div>
                    <div id="accordion000" class="accordion-body collapse" data-parent="#cmdEtat">
                        <div class="accordion-content">
                             
                            <div class="form-group">
                                <div class="form-group">
                            <label>Choisir nouvel etat</label>
                            <select  id="cmdState" name="etat"   class="form-control" >
                                <option v-for="(status, index) in states" v-bind:key="index"  :selected="status.value == singleCommand.etat" :value="status.value">@{{status.text}}</option>
                                
                            </select>
                             <button @click="updateStatus"  class="btn btn-primary mt-1">Modifier</button>
                        </div>

                               
                            </div>
                          
                        </div>
                    </div>
                </div>
            </div>



            <div class="accordion" id="cmdDate">
                <div class="item">
                    <div class="accordion-header">
                        <button class="btn   collapsed" type="button" data-toggle="collapse"
                            data-target="#accordion0010">
                            <ion-icon name="calendar"></ion-icon>
                            @{{singleCommand.delivery_date.substring(8, 10)}}-
                             @{{singleCommand.delivery_date.substring(5, 7)}}-
                            @{{singleCommand.delivery_date.substring(0, 4)}}
                        </button>
                    </div>
                    <div id="accordion0010" class="accordion-body collapse" data-parent="#cmdDate">
                        <div class="accordion-content">
                           
                            <div class="form-group">
                                <input id="ddate" :value="singleCommand.delivery_date" class="form-control" type="date" name="">

                                <button @click="updateDate" :disabled="singleCommand.delivery_date == '' " class="btn btn-primary mt-1">Modifier</button>
                            </div>
                           
                        </div>
                    </div>
                </div>
            </div>








            <div class="accordion" id="cmdDescription">
                <div class="item">
                    <div class="accordion-header">
                        <button class="btn   collapsed" type="button" data-toggle="collapse"
                            data-target="#accordion001">
                            <ion-icon name="bag"></ion-icon>
                            @{{singleCommand.description}}
                        </button>
                    </div>
                    <div id="accordion001" class="accordion-body collapse" data-parent="#cmdDescription">
                        <div class="accordion-content">
                             
                            <div class="form-group">
                                <input id="cmdDesc" :value="singleCommand.description" class="form-control" type="" name="">

                                <button @click="updateDescription" :disabled="singleCommand.description == '' " class="btn btn-primary mt-1">Modifier</button>
                            </div>
                           
                        </div>
                    </div>
                </div>
            </div>


              <div class="accordion" id="cmdClient">
                <div class="item">
                    <div class="accordion-header">
                        <button class="btn   collapsed" type="button" data-toggle="collapse"
                            data-target="#accordion0011">
                            <ion-icon name="person"></ion-icon>
                            @{{singleCommand.nom_client}}
                        </button>
                    </div>
                    <div id="accordion0011" class="accordion-body collapse" data-parent="#cmdClient">
                        <div class="accordion-content">
                            <div class="form-group">
                                <input id="cmdClt" :value="singleCommand.nom_client" class="form-control" type="" name="">

                                <button @click="updateClient" :disabled="singleCommand.non_client == '' " class="btn btn-primary mt-1">Modifier</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>



            <div class="accordion mt-2" id="cmdAdresse">
                <div class="item">
                    <h2 class="accordion-header">
                        <button class="btn   collapsed" type="button" data-toggle="collapse"
                            data-target="#accordion002">
                            <ion-icon name="location"></ion-icon>
                            @{{singleCommand.adresse}}
                        </button>
                    </h2>
                    <div id="accordion002" class="accordion-body collapse" data-parent="#cmdAdresse">
                        <div class="accordion-body">
                          
                            <div class="form-group mb-1">
                        
                          <select id="cmdFee"   required  class="form-control" name="fee">
                             <option  value="">selectionner Une ville/commune</option>
                             @foreach($fees as $fee)
                            <option :selected ="singleCommand.fee.id == '{{$fee->id}}'"
                         
                          value="{{$fee->id}}">{{$fee->destination}}</option>
                          
                          @endforeach
                         </select>
                           </div>
                            <div class="form-group ">
                                <input id="cmdAdrs" :value="singleCommand.adresse.substring(singleCommand.fee.destination.length+1)" class="form-control" type="" name="">

                            </div>
                            

                           <button @click="updateAdresse" class="btn btn-primary mt-1">Modifier</button>
                           
                        </div>
                    </div>
                </div>

                <div class="item">
                    <h2 class="accordion-header">
                        <button class="btn   collapsed" type="button" data-toggle="collapse"
                            data-target="#accordion003">
                            <ion-icon name="call"></ion-icon>
                            @{{singleCommand.phone}} 
                        </button>
                    </h2>
                    <div id="accordion003" class="accordion-body collapse" data-parent="#cmdAdresse">
                        <a class="btn btn-primary" :href="'tel:'+singleCommand.phone"><ion-icon name="call" ></ion-icon>Appeler</a>
                        <div class="accordion-body">
                           
                            <div class="form-group">
                                <input id="cmdPhone" :value="singleCommand.phone" class="form-control" type="tel" name="">

                                <button @click="updatePhone" class="btn btn-primary mt-1">Modifier</button>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>



             <div class="accordion mt-2" id="cmdCost">
                <div class="item">
                    <h2 class="accordion-header">
                        <button class="btn   collapsed" type="button" data-toggle="collapse"
                            data-target="#accordion004">
                            <ion-icon name="cash"></ion-icon>
                            @{{singleCommand.montant+singleCommand.livraison}}
                        </button>
                    </h2>
                    <div id="accordion004" class="accordion-body collapse" data-parent="#cmdCost">
                        <div class="accordion-body">
                            
                            <div class="input-group mb-2">
                          <div class="input-group-prepend">
                          <span class="input-group-text" id="">Prix</span>
                               </div>
                                <input id="cmdMontant" :value="singleCommand.montant" class="form-control" type="number" name="">

                                
                            </div>

                            <div class="input-group mb-2">
                        <div class="input-group-prepend">
                           <span class="input-group-text" id="">Livraison</span>
                          </div>
                                <input id="cmdLiv" :value="singleCommand.livraison" class="form-control" type="number" name="">
                              
                                
                            </div>

                            <button @click="updateCost" class="btn btn-primary mt-1">Modifier</button>
                            
                        </div>
                    </div>
                </div>

            </div>




            <div class="accordion" id="cmdObservavation">
                <div class="item">
                    <div class="accordion-header">
                        <button class="btn   collapsed" type="button" data-toggle="collapse"
                            data-target="#accordion0012">
                            <ion-icon name="information"></ion-icon>
                            @{{singleCommand.observation}}
                        </button>
                    </div>
                    <div id="accordion0012" class="accordion-body collapse" data-parent="#cmdObservavation">
                        <div class="accordion-content">
                           
                            <div class="form-group">
                                <input id="cmdObs" :value="singleCommand.observation" class="form-control" type="" name="">

                                <button @click="updateObs"  class="btn btn-primary mt-1">Modifier</button>
                            </div>
                         
                        </div>
                    </div>
                </div>
            </div>

             <div  class="accordion " id="cmdSource">
                <div class="accordion-item">
                    <div  class="accordion-header">
                        <button class="btn   collapsed" type="button" data-toggle="collapse"
                            data-target="#accordion9">
                            <div v-if="srces.length > 0" class="tools">
                              @{{singleCommand.canal}}
                      <i class="fa-thin fa-chart-network"></i>
                      <i class="fas fa-trash-o"></i>
                    </div>
                           
                        </button>
                    </div>
                    <div id="accordion9" class="accordion-body collapse" data-parent="#cmdSource">
                        <div v-if="srces.length > 0" class="accordion-content">
                             
                            <div class="form-group">
                                 <div class="input-group mb-2">
                 <div class="input-group-prepend">
                  <span class="input-group-text" id="">Canal</span>
                    </div>
                 <select   id="cmdSrc"    class="form-control">
                  <option value="">Choisir un canal</option>
       
                  <option v-for="srce in srces" :selected="singleCommand.canal == srce.type+ '_'+srce.antity"  :value="srce.type+ '_'+srce.antity">@{{srce.type+ "_"+srce.antity}}</option>
      
                  </select>
      
                            </div>    
                      </div>
                            <button @click="updateSource()"  class="btn btn-primary mt-1 mr-1">Modifier</button>
                             <button class="btn  btn-danger collapsed" type="button" data-toggle="collapse"
                            data-target="#accordion9">
                            Fermer
                          </button>
                          
                        </div>
                        <div v-else class="accordion-content">
                          Aucun canal enregistre
                        </div>
                    </div>
                </div>
            </div>

            
             <div class="accordion mt-2" id="cmdLivreur">
                <div class="item">
                    <h2 class="accordion-header">
                        <button id="livDEtail"   class="btn   collapsed" type="button" data-toggle="collapse"
                            data-target="#accordion005">
                            
                          <ion-icon name="bicycle"></ion-icon>
                          <span v-if="singleCommand.livreur.id != 11"> @{{singleCommand.livreur.nom}}</span>
                          <span v-else> Non assigne</span>
                            
                         
                        </button>

                       
                    </h2>
                    <div id="accordion005" class="accordion-body collapse" data-parent="#cmdLivreur">
                        <div  class="accordion-body">
                            <span v-if="singleCommand.livreur.id != 11">@{{singleCommand.livreur.phone}}</span>
                            <a class="btn btn-primary ml-2" :href="'tel:'+singleCommand.livreur.phone"><ion-icon name="call" v-if="singleCommand.livreur.id != 11"></ion-icon></a>
                        </div>
                    </div>
                </div>

            </div>
         
         
             <!-- <div v-if="clientLivreurs.length > 0" class='transactions'>
                <button @click="assignLiv('11')" type='button' class='btn  btn-danger mt-2' v-if="singleCommand.livreur.id != '11'">Desassigner</button>
                    <span v-for="(livreur, index) in clientLivreurs"  class='item'>
                     <div class='detail'>
                        <img 
                          :src="findImage(livreur.photo)"  class='image-block imaged big' 
                          alt='img'  
                        alt='img' width='80'>


                        <div>
                        <strong>@{{livreur.nom}}</strong>

                        
                        <div >
                        <div class='text-primary'>
                        </div>
                        
                        
                        <button @click="getLivreurCmds(livreur.id, index, 'other')"   class="btn btn-primary btn-sm">Voir assigantions actuelles</button><br>

                       <div  :id="'otherDetail'+index">
                        
                        </div>
                    </div>
                    <br><button @click='assignLiv(livreur.id)' type='button' class='btn  btn-primary mr-2' > Assigner</button><a type='button' style=' font-weight: bold;' href="tel:@{{livreur.phone}}" class='btn btn-primary phone'>
                       <ion-icon name='call-outline'></ion-icon></a>
                       
                        </div>
                    </div>
                    </span>
                    </div>
                        <div v-else>
                            <a href="livreurs" class="btn btn-warning btn-block phone">
                       <ion-icon name="bicycle"></ion-icon>Voir la liste des livreurs</a>
                        </div> -->
                   

                        <div id="assignees">
                                 
                        </div>
                         <div v-if="zoneLivreur">
                           
                        <div  class='transactions'>
                    <span v-for="(zone_livreur, index) in zoneLivreur "  class='item'>
                     <div class='detail'>
                        <img 
                          :src="findImage(zone_livreur.photo)"  class='image-block imaged big' 
                          alt='img'  
                        alt='img' width='80'>


                        <div>
                        <strong>@{{zone_livreur.nom}}</strong>

                        
                        <div >
                        <div class='text-primary'>Dernière Action: @{{zoneLast[index]}}
                        </div>
                        
                        
                        <button @click="getLivreurCmds(zone_livreur.id, index, 'zone')"  class="btn btn-primary btn-sm">Voir assigantions actuelles</button><br>

                       <div  :id="'zoneDetail'+index">
                        
                        </div>
                    </div>
                    <br><button @click='assignLiv(zone_livreur.id)' type='button' class='btn  btn-primary mr-2' > Assigner</button><a type='button' style=' font-weight: bold;' href="tel:@{{zone_livreur.phone}}" class='btn btn-primary phone'>
                       <ion-icon name='call-outline'></ion-icon></a>
                       
                        </div>
                    </div>
                    </span>
                    </div>
                </div>
               


                <div v-if="otherLivreur">
                          
                        <div  class='transactions'>
                    <span v-for="(other_livreur, index2) in otherLivreur"  class='item'>
                     <div class='detail'>
                        <img 
                         :src="findImage(other_livreur.photo)"  class='image-block imaged big' 
                          alt='img'  
                        alt='img' width='80'>


                        <div>
                        <strong>@{{other_livreur.nom}}</strong>

                        
                        <div >
                        <div class='text-primary'>Dernière Action: Dernière Action: @{{otherLast[index2]}}
                        </div>
                       

                        <button   @click="getLivreurCmds(other_livreur.id, index2, 'other')" class="btn btn-primary btn-sm">Voir assigantions actuelles</button><br>
                        <div :id="'otherDetail'+index2">
                       
                </div>
                    </div>
                        
                    <br><button @click='assignLiv(other_livreur.id)' type='button' class='btn  btn-primary ml-2' > Assigner</button><a type='button' style=' font-weight: bold;' href="tel:@{{other_livreur.phone}}" class='btn btn-primary phone'>
                       <ion-icon name='call-outline'></ion-icon></a>
                       
                        </div>
                    </div>
                    </span>
                    </div>
                </div>
                      
                        
                        <div>
                            
                        </div>
                        </div>
                        <div class="modal-body" v-else>
                            <span class="alert alert-danger">Commande supprimee ou reportee!</span>
                            
                        </div>
                    </div>
                </div>
            
        </div>
        <!-- * Deposit Action Sheet -->

        





       <div class="modal fade action-sheet" id="bulkModal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Action groupée</h5>
                        <a id="bulkActionClose" href="javascript:;" data-dismiss="modal">Fermer</a>
                    </div>
                    <div class="modal-body">
                        <div class="action-sheet-content">
                              
                                <button class="btn btn-block btn-primary " onclick="$('#bulkModal').modal('hide'); $('#LivChoice').modal('show');">
                              <span  hidden class="spinner-border spinner-border-sm spinnerbulk" role="status" aria-hidden="true"></span><span class="sr-only"></span>
                              <ion-icon name="bicycle-outline"></ion-icon>
                              Assigner la selection</button>
                              
                               
                              <button onclick="$('#bulkModal').modal('hide'); $('#bulkRptModal').modal('show');"  class="btn btn-block btn-primary bulkRprt">
                              <ion-icon name="arrow-forward-outline"></ion-icon>
                              Reporter la selection</button>
                             
                              
                              <button @click="bulkReset" class="btn btn-block btn-primary ">
                              <ion-icon name="refresh-outline"></ion-icon>
                              Réinitialiser la selection</button>
                             
                             
                              <!-- <button onclick="$('#bulkModal').modal('hide'); $('#bulkdifusionModal').modal('show');" class="btn btn-block btn-primary bulkDifusion" data-phone="{{$client->phone}}" data-adresse="{{$client->city}} {{$client->adresse}}">

                                <span  hidden class="spinner-border spinner-border-sm bulkdifusespinner" role="status" aria-hidden="true"></span><span class="sr-only"></span>
                              <ion-icon name="radio-outline"></ion-icon>
                              Diffuser selection</button> -->
                             
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
      
        <div id="toast-8" class="toast-box  toast-bottom">
            <div class="in">
                <div class="text toasText">
                    Facture copiée.
                </div>
            </div>
        </div>


         <div id="toast-err" class="toast-box toast-bottom toast-danger">
            <div class="in">
                <div class="text toasTerrText">
                    Une erreur s'est produite.
                </div>
            </div>
        </div>
        

        <div id="toast-11" class="toast-box toast-center">
            <div class="in">
                <div class="text">
               Chargement...
                </div>
            </div>
           
        </div>
        
         <!-- State forme -->
       <form hidden id='stateForm' action="commands" >
         @csrf
         <input type="text"  name="route_day" value="{{$day}}">
         <input id="state" type="text" name="state"  value="">
      </form>

      <form hidden id='dashboard' action="commands" >
         @csrf
         <input type="text"  name="route_day" value="{{$day}}">
         
      </form>

      <form hidden id='enattenteForm' action="commands" >
         @csrf
         <input type="text"  name="route_day" value="{{$day}}">
         <input type="text" name="state"  value="encours">
         <input type="text" name="attente"  value="encours">
      </form>

        <form id="activateForm" style="display: none;" class="form-inline" action="/cancel" method="POST">
      @csrf
      <input class="activateValue" value="" type="text" name="id" >
      <input type="text" value="no" name="cancel" >
      </form>
       


   <!-- Dialog with Image -->
        <div class="modal fade dialogbox add-modal" id="InstalAppModal"  data-backdrop="static" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="pt-3 text-center">
                        <img src="../assets/img/logo-icon.png" alt="image" class="imaged w48  mb-1">
                    </div>
                    <div class="modal-header pt-2">
                        <h5 class="modal-title">Installer l'application Jibiat</h5>
                    </div>
                    <div class="modal-body">
                        Accedez a jibiaT en un clique!
                    </div>
                    <div class="modal-footer">
                        <div class="btn-inline">
                            <a href="#" class="btn btn-text-secondary " data-dismiss="modal">Annuler</a>
                            <a href="#" class="btn btn-text-primary add-button" data-dismiss="modal">Installer</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- * Dialog with Image -->



 
        <div class="modal fade dialogbox add-modal" id="bigModal"  data-backdrop="static" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    
                    <div class="modal-header pt-2">
                        
                    </div>
                    <div class="modal-body bigModalBody">
                        
                    </div>
                   
                      <button class="close" data-dismiss="modal">&times;</button>
                    
                </div>
            </div>
        </div>
        <!-- * Dialog with Image -->       


