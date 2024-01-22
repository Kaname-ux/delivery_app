







<!-- Dialog with Image -->

         <div class="modal fade dialogbox" id="stateModal" data-backdrop="static" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h5 class="modal-title"></h5>
                       

                    </div>
                    
                    <div class="modal-body" id="stateModalBody">
                        
                    </div>
                   
                </div>
            </div>
        </div>



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






        <div class="modal fade dialogbox" id="delModal" data-backdrop="static" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h5 class="modal-title"></h5>
                       

                    </div>
                    
                    <div class="modal-body" >
                      <div id="delModalBody">
                        
                      </div>
                        <button class="btn btn-success" id="del_btn">Confirmer</button>
                   <button type="button" class="btn btn-secondary" class="close" data-dismiss="modal">Annuler</button>
                    </div>
                   
                </div>
            </div>
        </div>





         <!-- Dialog Form -->
        <div class="modal fade dialogbox" id="rptModal" data-backdrop="static" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Reporter commande</h5>
                    </div>
                  
                        <div class="modal-body text-left mb-2">

                            <div class="form-group basic">
                                <div class="input-wrapper">
                                    <label class="label" for="account1">Date</label>
                                    <input required type="date" class="form-control custom-input" id="rpt_date">
                                       
                                </div>
                                <div class="input-info">Choisir date de report</div>
                            </div>
                         <input id="ynassign" type="checkbox" name="ynassign">Désassigner 

                         <input id="ynreset" type="checkbox" name="ynreset">Reiniialiser
                        </div>
                        <div class="modal-footer">
                            <div class="btn-inline">
                                <button type="button" class="btn btn-text-primary" data-dismiss="modal">ANNULER</button>
                                <button  type="button" class="btn btn-primary" id="rpt_btn" 
                                    data-dismiss="modal">CONFIRMER</button>
                                
                            </div>
                        </div>
                    
                </div>
            </div>
        </div>
        <!-- * Dialog Form -->



      <div class="modal fade dialogbox" id="bulkRptModal" data-backdrop="static" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Reporter la selection</h5>
                    </div>
                  
                        <div class="modal-body text-left mb-2">

                            <div class="form-group basic">
                                <div class="input-wrapper">
                                    <label class="label" for="account1">Date</label>
                                    <input required type="date" class="form-control custom-input" id="bulk_rpt_date">
                                    <div class="text-danger date_err"></div>   
                                </div>
                                <div class="input-info">Choisir date de report</div>
                            </div>
                       <input id="ynbassign" type="checkbox" name="ynbassign">Désassigner 

                       <input id="ynbreset" type="checkbox" name="ynbreset">Reiniialiser
                        </div>


                        <div class="modal-footer">
                            <div class="btn-inline">
                                <button type="button" class="btn btn-text-primary" data-dismiss="modal">ANNULER</button>
                                <button  type="button" class="btn btn-primary" id="bulk_rpt_btn" 
                                    >CONFIRMER</button>
                                
                            </div>
                        </div>
                    
                </div>
            </div>
        </div>
        <!-- * Dialog Form -->




        <!-- Assign modal -->
        <div class="modal fade action-sheet  " id="LivChoice" tabindex="-1" role="dialog">
            <div  class="modal-dialog" role="document">
                <div  class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h5 class="modal-title">Assinger</h5>
                        <div class="top"></div>
                        <div class="curLiv"></div>

                    </div>
                    <div   class="modal-body">
                        <div class="action-sheet-content LivChoiceBody">
                            
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
                        <div class="action-sheet-content noteViewBody">
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- return modal -->
        <div class="modal fade action-sheet  " id="cmdRtrnModal" tabindex="-1" role="dialog">
            <div  class="modal-dialog" role="document">
                <div  class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <div hidden class="left cmdRtrnReturn">
                    <a href="#" class="headerButton cmdRtrnBack">
                        <ion-icon name="chevron-back-outline"></ion-icon>
                        Retour
                    </a>
                     </div>
                        <h5 class="modal-title">Commandes non livré</h5>

                        
                        

                    </div>
                    <div   class="modal-body">
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
                        <h5 class="modal-title">Payements</h5>
                      
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

                     <div  class="col ">
                        <a class="headerButton mb-2" href="payments">Voir tous les payements</a>
                    </div>
                           
                       </div>
                      


                      <span class="payLivreur"></span> <span class="payTotal float-right"></span>
                        
                   
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
        <div style="height: 100rem" class="modal fade modalbox" id="depositActionSheet" tabindex="-1" role="dialog">
            <div  class="modal-dialog" role="document">
                <div  class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title cmdModalTitle">Nouvelle commande</h5>
                        <a href="javascript:;" data-dismiss="modal">Fermer</a>
                        

                    </div>
                    <div   class="modal-body">
                        <div class="action-sheet-content">
        <form id="cmdform" action="command-fast-register" method="POST">
      @csrf


      <div class="form-group basic">
                                    <button type="submit" class="btn btn-primary btn-block btn-lg"
                                        >Enregister</button>
                                </div>

      <input id="cmdid" value="" hidden name="command_id">
      <div class="form-group">
      <label class="form-label">Nature du colis</label>
      <input id="cmdnature" maxlength="150" required value="{{ old('type') }}"  name="type" class="form-control" type="text" placeholder="Nature du colis" >
      </div>
      <div class="form-group">
      <label class="form-label">Date de livraison</label>
      <input 
         min="
         <?php
            echo date('Y-m-d');
            ?>
         " required type="date" value="{{ old('delivery_date') }}" name="delivery_date" class="form-control" type="text" id="cmddate" >
      @error('delivery_date')
      <span class="invalid-feedback" role="alert">
      <strong>{{ $message }}</strong>
      </span>
      @enderror
      </div>
      <div class="form-group"> 
      <label class="form-label">Prix(sans la livraison)</label>
      <input id="cmdprice"  value="{{ old('montant') }}"  name="montant" class="form-control @error('montant') is-invalid @enderror" type="number" placeholder="Prix (sans la livraison)" autocomplete="off">
      @error('montant')
      <span class="invalid-feedback" role="alert">
      <strong>{{$massage}}</strong>
      </span>
      @enderror
      </div>

      <div class="form-group">
      <div class="form-row">
       <div class="col-8">
      <label class="form-label ">Ville/commune</label>
      <select id="cmddestination"  required  class="form-control" name="fee">
      <option  value="">selectionner Une ville/commune</option>
      @foreach($fees as $fee)
      <option 
      @if(old('fee') == $fee->id) selected @endif
      value="{{$fee->id}}">{{$fee->destination}}</option>
      <div id="fee_price"></div>
      @endforeach
      </select>
      @error('fee')
      <span class="invalid-feedback" role="alert">
      <strong>{{ $message }}</strong>
      </span>
      @enderror
      </div>
      

      <div class="col">
      <label class="form-label">Tarif livrai.</label>
      <select   required   class="form-control livraison" name="livraison">
        <option value="">Chosir</option>
      <option value="1000">1000f</option>
      <option value="1500">1500f</option>
      <option value="2000">2000f</option>
      <option value="2500">2500f</option>
      <option value="3000">3000f</option>
      <option value="0">Gratuit</option>
      <option value="autre">Autre</option>
      </select>
      @error('fee')
      <span class="invalid-feedback" role="alert">
      <strong>{{ $message }}</strong>
      </span>
      @enderror
      </div>
     </div> 
   </div>


     <div hidden class="form-group autre">
      <label class="form-label"> Saisir tarif de livraison</label>
      <input name="other_liv"  value="{{ old('other_liv') }}" id="cmdothfee"  class="form-control tarif" type="number" placeholder="" >
      </div>


      <div class="form-group">
      <label class="form-label"> Précision sur l'adresse de livraison</label>
      <input maxlength="150" value="{{ old('lieu') }}" id="cmdlieu" name="adresse" class="form-control" type="text" placeholder="Exemple: grand carrefour... pharmacie... rivera jardin..." >
      </div>
      <div class="form-row">
        <div class="col">
          <label class="form-label">Indicatif</label>
          <select class="form-control">
            <option>+225</option>
          </select>
        </div>
        <div class="col-8">
      <label class="form-label">Contact</label>
      <input id="cmdphone" value="{{ old('phone') }}" required  name="phone" class="form-control" type="number" placeholder="Numero du client sans l'indicatif(225)"  autocomplete="off">
      @error('phone')
      <span class="invalid-feedback" role="alert">
      <strong>{{ $message }}</strong>
      </span>
      @enderror
      </div>         
      </div>



      <!-- <div class="bg-primary mt-2" style="border-radius: 10px">
     <div class="form-group"> 
      <label class="form-label"> Lieu de ramassage</label>
      <input id="ramadresse" maxlength="150" value="{{ old('ram_adresse') }}" id="ramadresse" name="ram_adresse" class="form-control" required type="text" placeholder="Exemple: grand carrefour... pharmacie... rivera jardin..." >
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
      <input id="ramphone" value="{{ old('ram_phone') }}" required  name="ram_phone" class="form-control" type="number" placeholder="Numero de ramassage sans l'indicatif(225)"  autocomplete="off">
      @error('phone')
      <span class="invalid-feedback" role="alert">
      <strong>{{ $message }}</strong>
      </span>
      @enderror
      </div>         
      </div>
    
         

        

     

      <div class="form-group">
        <label class="form-label">
        <input value="1" type="checkbox" id="same" name="same" > Ramassage à  mon adresse.
        </label>
        
      </div>
</div> -->

@if($client->livreurs->count() > 0)
<div class="form-group">
      <label class="form-label">Livreur(Vous pouvez le faire plustard)</label>
      <select      class="form-control livreur" name="livreur">
        <option value="">Chosir</option>
        @foreach($client->livreurs as $livreur)
      <option value="{{$livreur->id}}">{{$livreur->nom}}</option>
      @endforeach
      </select>
      @error('livreur')
      <span class="invalid-feedback" role="alert">
      <strong>{{ $message }}</strong>
      </span>
      @enderror
      </div>
      @endif

      <div class="form-group">
      <label  class="form-label"> Information supplementaire.</label>
      <input id="comobservation" maxlength="150" value="{{ old('observation') }}"  name="observation" class="form-control" type="text" placeholder="Information supplementaire">
      </div>


                                <div class="form-group basic">
                                    <button type="submit" class="btn btn-primary btn-block btn-lg"
                                        >Enregister</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- * Deposit Action Sheet -->



        <!-- Deposit Action Sheet -->
        <div  class="modal fade modalbox" id="editModal" tabindex="-1" role="dialog">
            <div  class="modal-dialog" role="document">
                <div  class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title editModalTitle"></h5>
                        <a href="javascript:;" data-dismiss="modal">Fermer</a>
                        
                        

                    </div>
                    <div   class="modal-body">
                        <div class="action-sheet-content editBody">
                            <form  action="/command-update" method="POST"> 
                               @csrf
                               <div class="editBody1">
                               </div>
                                <div class="form-row">
       <div class="col-8">
      <label class="form-label ">Ville/commune</label>
      <select  required   class="form-control editFee" name="fee">
      <option  value="">selectionner Une ville/commune</option>
      @foreach($fees as $fee)
      <option 
      @if(old('fee') == $fee->id) selected @endif
      value="{{$fee->id}}">{{$fee->destination}}</option>
      <div id="fee_price"></div>
      @endforeach
      </select>
      @error('fee')
      <span class="invalid-feedback" role="alert">
      <strong>{{ $message }}</strong>
      </span>
      @enderror
      </div>


      <div class="col">
      <label class="form-label">Tarif Livrai.</label>
      <select   required   class="form-control livraison" name="livraison">
        <option value="">Chosir</option>
      <option value="1000">1000f</option>
      <option value="1500">1500f</option>
      <option value="2000">2000f</option>
      <option value="2500">2500f</option>
      <option value="3000">3000f</option>
      <option value="0">Gratuit</option>
      <option value="autre">Autre</option>
      </select>
      @error('fee')
      <span class="invalid-feedback" role="alert">
      <strong>{{ $message }}</strong>
      </span>
      @enderror
      </div>
     </div> 
     <div hidden class="form-group autre">
      <label class="form-label"> Saisir tarif livraison</label>
      <input name="other_liv"  value="{{ old('other_liv') }}"   class="form-control tarif" type="number" placeholder="" >
      </div>
                                <div class="editBody2">
                               </div>

                               <div class="form-group basic">
                                    <button type="submit" class="btn btn-primary btn-block btn-lg"
                                        >Confirmer</button>
                                </div>
                           </div>
                               
                           </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- * Deposit Action Sheet -->


        <!-- Deposit Action Sheet -->
        <div style="height: 100rem" class="modal fade modalbox" id="duplicateModal" tabindex="-1" role="dialog">
            <div  class="modal-dialog" role="document">
                <div  class="modal-content">
                    <div class="modal-header">
                        
                        <h5 class="modal-title">Nouvelle commande</h5>
                        <a href="javascript:;" data-dismiss="modal">Fermer</a>

                    </div>
                    <div   class="modal-body">
                        <div class="action-sheet-content duplicateBody">
                            <form  action="command-fast-register" method="POST"> 
      @csrf
      <div class="duplicateBody1">
      </div>
      
      <div class="form-group">
       <div class="form-row">
       <div class="col-8">
      <label class="form-label">Ville / Commune</label>
      <select  required   class="form-control duplicateFee" name="fee">
      <option   value="">selectionner Une ville/commune</option>
      @foreach($fees as $fee2)
      <option  
      
      value="{{$fee2->id}}">{{$fee2->destination}}</option>
      <div id="fee_price"></div>
     @endforeach
      </select>
      @error('fee')
      <span class="invalid-feedback" role="alert">
      <strong>{{ $message }}</strong>
      </span>
      @enderror
      </div>


      <div class="col">
      <label class="form-label">Tarif livrai.</label>
      <select id="cmdfee"  required   class="form-control livraison" name="livraison">
        <option value="">Chosir</option>
      <option value="1000">1000f</option>
      <option value="1000">1500f</option>
      <option value="2000">2000f</option>
      <option value="2500">2500f</option>
      <option value="3000">3000f</option>
      <option value="0">Gratuit</option>
      <option value="autre">Autre</option>
      </select>
      @error('fee')
      <span class="invalid-feedback" role="alert">
      <strong>{{ $message }}</strong>
      </span>
      @enderror
      </div>
     </div> 
     <div hidden class="form-group autre">
      <label class="form-label"> Saisir tarif livraison</label>
      <input name="other_liv"  value="{{ old('other_liv') }}"   class="form-control tarif" type="number" placeholder="" >
      </div>
     </div>



      <div class="duplicateBody2">
      </div>
      </div>
      <div class="form-group basic">
                                    <button type="submit" class="btn btn-primary btn-block btn-lg"
                                        >Enregister</button>
                                </div>
      </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- * Deposit Action Sheet -->




       <!-- Deposit Action Sheet -->
        <div style="height: 100rem" class="modal fade modalbox" id="cmdDetailModal" tabindex="-1" role="dialog">
            <div  class="modal-dialog" role="document">
                <div  class="modal-content">
                    <div class="modal-header">
                        
                        <h5 class="modal-title">Details commande</h5>
                        <a href="javascript:;" data-dismiss="modal">Fermer</a>

                    </div>
                    <div   class="modal-body detailBody">
                        
      
                        </div>
                    </div>
                </div>
            
        </div>
        <!-- * Deposit Action Sheet -->






        <!-- Withdraw Action Sheet -->
        <div class="modal fade action-sheet" id="withdrawActionSheet" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Date</h5>
                    </div>
                    <div class="modal-body">
                        <div class="action-sheet-content">
                            
                                <div class="form-group basic">
                                    <div class="input-wrapper">
                                        <form  autocomplete="off"  action='?bydate' >
                                         @csrf
                                         <div  class="form-group ">
                                         
                                         <input  hidden value='{{date("Y-m-d",strtotime("yesterday"))}}'   class="form-control " type="date" name="route_day">
                                         <button type="submit" class="btn btn-outline-primary btn-block "   >Hier</button>

                                        </div>
                                         </form>

                                         <form  autocomplete="off"  action='?bydate' >
                                         @csrf
                                         <div  class="form-group ">
                                         
                                         <input hidden     class="form-control " type="date" name="route_day">
                                         <button type="submit" class="btn btn-outline-warning btn-block "   >Aujourd'hui</button>

                                        </div>
                                         </form>
                                        
                                        <form  autocomplete="off"  action='?bydate' >
                                         @csrf
                                         <div  class="form-group ">
                                         
                                         <input hidden value='{{date("Y-m-d",strtotime("tomorrow"))}}'    class="form-control "  name="route_day">
                                         <button class="btn btn-outline-success btn-block " type="submit"  >Demain</button>

                                        </div>
                                         </form>
                                       
                                    </div>
                                </div>
                              <form autocomplete="off" id="date-form" action="?bydate">
                                @csrf
                                <div class="form-group basic">
                                    <div class="input-wrapper">
                                        <label class="label" for="text11d">Choisir une date</label>
                                       
                                         <div  class="form-group">
                                         
                                         <input value=""  class="form-control" 
                                         onchange="$('#date-form').submit();" 
                                         type="date" name="route_day">
                                         

                                        </div>
                                        
                                    </div>
                                </div>
                             </form>
                                

                                
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- * Withdraw Action Sheet -->


       <div class="modal fade action-sheet" id="bulkModal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Action groupée</h5>
                    </div>
                    <div class="modal-body">
                        <div class="action-sheet-content">
                            
                                <button class="btn btn-block btn-primary showLivreurs">
                              <span  hidden class="spinner-border spinner-border-sm spinnerbulk" role="status" aria-hidden="true"></span><span class="sr-only"></span>
                              <ion-icon name="bicycle-outline"></ion-icon>
                              Assigner la selection</button>

                              <button onclick="$('#bulkModal').modal('hide'); $('#bulkRptModal').modal('show');"  class="btn btn-block btn-primary bulkRprt">
                              <ion-icon name="arrow-forward-outline"></ion-icon>
                              Reporter la selection</button>

                                
                              <button  class="btn btn-block btn-primary bulkReset">
                              <ion-icon name="refresh-outline"></ion-icon>
                              Réinitialiser la selection</button>
                              
                             
                              <button onclick="$('#bulkModal').modal('hide'); $('#bulkdifusionModal').modal('show');" class="btn btn-block btn-primary bulkDifusion" data-phone="{{$client->phone}}" data-adresse="{{$client->city}} {{$client->adresse}}">

                                <span  hidden class="spinner-border spinner-border-sm bulkdifusespinner" role="status" aria-hidden="true"></span><span class="sr-only"></span>
                              <ion-icon name="radio-outline"></ion-icon>
                              Diffuser selection</button>
                             
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- * Withdraw Action Sheet -->




        <!-- Send Action Sheet -->
        <div class="modal fade action-sheet" id="sendActionSheet" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Send Money</h5>
                    </div>
                    <div class="modal-body">
                        <div class="action-sheet-content">
                            <form>
                                <div class="form-group basic">
                                    <div class="input-wrapper">
                                        <label class="label" for="account2">From</label>
                                        <select class="form-control custom-select" id="account2">
                                            <option value="0">Savings (*** 5019)</option>
                                            <option value="1">Investment (*** 6212)</option>
                                            <option value="2">Mortgage (*** 5021)</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group basic">
                                    <div class="input-wrapper">
                                        <label class="label" for="text11">To</label>
                                        <input type="email" class="form-control" id="text11"
                                            placeholder="Enter bank ID">
                                        <i class="clear-input">
                                            <ion-icon name="close-circle"></ion-icon>
                                        </i>
                                    </div>
                                </div>

                                <div class="form-group basic">
                                    <label class="label">Enter Amount</label>
                                    <div class="input-group mb-2">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="input14">$</span>
                                        </div>
                                        <input type="text" class="form-control form-control-lg" placeholder="0">
                                    </div>
                                </div>

                                <div class="form-group basic">
                                    <button type="button" class="btn btn-primary btn-block btn-lg"
                                        data-dismiss="modal">Send</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- * Send Action Sheet -->

        <!-- Exchange Action Sheet -->
        <div class="modal fade action-sheet" id="exchangeActionSheet" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Exchange</h5>
                    </div>
                    <div class="modal-body">
                        <div class="action-sheet-content">
                            <form>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group basic">
                                            <div class="input-wrapper">
                                                <label class="label" for="currency1">From</label>
                                                <select class="form-control custom-select" id="currency1">
                                                    <option value="1">EUR</option>
                                                    <option value="2">USD</option>
                                                    <option value="3">AUD</option>
                                                    <option value="4">CAD</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group basic">
                                            <div class="input-wrapper">
                                                <label class="label" for="currency2">To</label>
                                                <select class="form-control custom-select" id="currency2">
                                                    <option value="1">USD</option>
                                                    <option value="1">EUR</option>
                                                    <option value="2">AUD</option>
                                                    <option value="3">CAD</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group basic">
                                    <label class="label">Enter Amount</label>
                                    <div class="input-group mb-2">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="input1">$</span>
                                        </div>
                                        <input type="text" class="form-control form-control-lg" value="100">
                                    </div>
                                </div>



                                <div class="form-group basic">
                                    <button type="button" class="btn btn-primary btn-block btn-lg"
                                        data-dismiss="modal">Deposit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>



<div class="modal fade action-sheet  " id="cmdMenumodal" tabindex="-1" role="dialog">
            <div  class="modal-dialog" role="document">
                <div  class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h5 class="modal-title cmdMenumodalTitle"></h5>
                        

                    </div>
                    <div   class="modal-body">

                        <div id="stateToast" class="toast-box toast-top">
            <div class="in">
                <div class="text toasText stateToastText">
                    Facture copiée.
                </div>
            </div>
        </div>


                        <div class="action-sheet-content cmdMenumodalBody">

                      <button onclick="$('#cmdMenumodal').modal('hide');$('#depositActionSheet').modal('show');" class="btn btn-outline-primary btn-block edit"><ion-icon name="pencil-outline"></ion-icon>Modifier</button>
                     <button onclick="$('#cmdMenumodal').modal('hide');$('#depositActionSheet').modal('show');" class=" btn btn-outline-primary btn-block"><ion-icon name="copy-outline"></ion-icon>Dupliquer</button>

                     <button value=""  class="btn btn-outline-primary btn-block add_fast">
                    <span  hidden="hidden" class="spinner-border spinner-border-sm addFastSpinner" role="status" aria-hidden="true"></span><span class="sr-only"></span>
                   <ion-icon name="color-wand-outline"></ion-icon>Ajouter à la liste enregitrement rapides</button>

                     <form style="margin-top: 5px; " id="cmdResetForm"  class="form-inline" action="/reset" method="POST">
                     @csrf
                   </form>

                   <button style="margin-top: 5px;" hidden class="btn btn-outline-primary btn-block rpt" id="rpt"  ><ion-icon name="arrow-forward-outline"></ion-icon>Reporter</button>


                   

                   <button style="margin-top: 5px;" hidden id="cancel_btn" type='button' value ='annule' class='btn btn-outline-primary btn-block cancel_btn '><ion-icon class="text-danger" name='close-outline'></ion-icon>Annuler</button>
                 <button  class="btn btn-danger btn-block del" id="del" hidden >Supprimer</button>


                     <hr>
                    
                     <h4><ion-icon name="calculator-outline"></ion-icon>Facture</h4>
                     
                     <button id="shareBill" class=" btn btn-outline-primary btn-block " ><ion-icon name="share-social-outline"></ion-icon>Partager la facture</button>
                     <input hidden type="text" id="billInput" name="">
                     <hr>
                    
                   <div style="margin-top: 5px; margin-bottom: 5px" class="cmdMenumodalCalls">
                     
                   </div>

                   

                   
                        </div>
                    </div>
                </div>
            </div>
        </div>





   <div  class="modal fade modalbox" id="addNewFast" tabindex="-1" role="dialog">
            <div  class="modal-dialog" role="document">
                <div  class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title">Ajouter un enregistrement rapide</h5>
                        <a href="javascript:;" data-dismiss="modal">Fermer</a>
                        

                    </div>
                    <div   class="modal-body">
                        <div class="action-sheet-content">
                            <form  action="/add-new-fast" method="POST">
      @csrf
      <div class="form-group">
      <label class="form-label">Nature du colis</label>
      <input maxlength="150" required value="{{ old('type') }}"  name="type" class="form-control" type="text" placeholder="Nature du colis" >
      </div>
      
      <div class="form-group"> 
      <label class="form-label">Prix(sans la livraison)</label>
      <input   value="{{ old('montant') }}"  name="montant" class="form-control @error('montant') is-invalid @enderror" type="number" placeholder="Prix (sans la livraison)" autocomplete="off">
      @error('montant')
      <span class="invalid-feedback" role="alert">
      <strong>{{$massage}}</strong>
      </span>
      @enderror
      </div>
      <div class="form-group">
      <label class="form-label">Ville/commune</label>
      <select  required   class="form-control" name="fee">
      <option  value="">selectionner Une ville/commune</option>
      @foreach($fees as $fee)
      <option 
      @if(old('fee') == $fee->id) selected @endif
      value="{{$fee->id}}">{{$fee->destination}} : {{$fee->price}} CFA</option>
      
      @endforeach
      </select>
      @error('fee')
      <span class="invalid-feedback" role="alert">
      <strong>{{ $message }}</strong>
      </span>
      @enderror
      </div>
     

                                <div class="form-group basic">
                                    <button type="submit" class="btn btn-primary btn-block btn-lg"
                                        >Enregister</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- * Deposit Action Sheet -->     
         

<!-- toast center auto close in 2 seconds -->
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