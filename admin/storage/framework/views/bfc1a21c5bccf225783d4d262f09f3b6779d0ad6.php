<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
  <title>Commandes</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="../../plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
  <link rel="stylesheet" href="../../plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="../../plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
  <!-- Toastr -->
  <link rel="stylesheet" href="../../plugins/toastr/toastr.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="../../plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="../../plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="../../plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../../dist/css/adminlte.min.css">




</head>
<body class="hold-transition sidebar-mini">
  
 <script src="https://unpkg.com/vue@3"></script> 
<div class="wrapper" id="app">
  <!-- Navbar -->
  <?php echo $__env->make("includes.navbar", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>


<div class="modal fade" id="modal-success" role="dialog">
<div class="modal-dialog">
<div class="modal-content bg-success">
<div class="modal-header">
<h4 class="modal-title">Nouvelle course!</h4>
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
<span aria-hidden="true">×</span>
</button>
</div>
<form action="assign" method="post">
<div class="modal-body ">
    <div class="successBody">
        
    </div>

    <div class="form-group">
        <label>Assigner</label>
        <select name="livreur_id" required class="form-control">
            <option :value="livreur.id" v-for="livreur in deliverymen">{{livreur.nom}}</option>
        </select>
    </div>
    <div>
        <button class="btn btn-primary" type="submit">Assigner</button>
    </div>

</div>
</form>
<div class="modal-footer justify-content-between successFooter">
<button type="button" class="btn btn-outline-light" data-dismiss="modal">Fermer</button>
<a href="" class="btn btn-outline-light">Actualiser la page</a>
</div>
</div>

</div>

</div>

  
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
   <div class="modal fade action-sheet" id="dateModal" tabindex="-1" role="dialog">
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
                                         <?php echo csrf_field(); ?>
                                         <div  class="form-group ">
                                         
                                         <input  hidden value='<?php echo e(date("Y-m-d",strtotime("yesterday"))); ?>'   class="form-control " type="date" name="start">
                                         <input  hidden value='<?php echo e(date("Y-m-d",strtotime("yesterday"))); ?>'   class="form-control " type="date" name="end">
                                         <button type="submit" class="btn btn-outline-primary btn-block "   >Hier</button>

                                        </div>
                                         </form>

                                         <form  autocomplete="off"  action='?' >
                                         <?php echo csrf_field(); ?>
                                         <div  class="form-group ">
                                         
                                         <input  hidden value='<?php echo e(date("Y-m-d",strtotime("today"))); ?>'   class="form-control " type="date" name="start">
                                         <input  hidden value='<?php echo e(date("Y-m-d",strtotime("today"))); ?>'   class="form-control " type="date" name="end">
                                         <button type="submit" class="btn btn-outline-warning btn-block "   >Aujourd'hui</button>

                                        </div>
                                         </form>
                                        
                                        <form  autocomplete="off"  action='?' >
                                         <?php echo csrf_field(); ?>
                                         <div  class="form-group ">
                                         
                                         <input hidden value='<?php echo e(date("Y-m-d",strtotime("tomorrow"))); ?>'    class="form-control "  name="start">
                                         <input hidden value='<?php echo e(date("Y-m-d",strtotime("tomorrow"))); ?>'    class="form-control "  name="end">
                                         <button class="btn btn-outline-success btn-block " type="submit"  >Demain</button>

                                        </div>
                                         </form>
                                       
                                    </div>
                                </div>
                                <div>
                              <form autocomplete="off" id="date-form" action="?">
                                <?php echo csrf_field(); ?>
                                <div class="form-group basic">
                                    <div class="input-wrapper">
                                        <label class="label" for="text11d">Choisir une date</label>
                                       
                                         <div  class="form-row">
                                         <div class="col">
                                         <input v-model="costumStart" value=""  class="form-control"type="date" name="start">
                                         
                                         </div>
                                         <div class="col">
                                            <button class="btn btn-primary btn-sm">Valider</button> 
                                         </div>
                                         
                                         <input hidden id="costumEnd" :value="costumStart"  class="form-control" 
                                          
                                         type="date" name="end">

                                        </div>
                                        
                                    </div>
                                </div>
                             </form>
                             </div>

                             <form autocomplete="off" id="date-form" action="?">
                                <?php echo csrf_field(); ?>
                                <div class="form-group basic">
                                    <div class="input-wrapper">
                                        <label class="label" for="text11d">Choisir un interval</label>
                                       
                                         <div  class="form-row">
                                         
                                         <div class="col">
                                         <input v-model="intStart" value=""  class="form-control" 
                                        
                                         type="date" name="start">
                                          </div>
                                          <div class="col">
                                         <input :disabled="!intStart" :min="intStart"  class="form-control" 
                                          
                                         type="date" name="end">
                                        </div>
                                       
                                        </div>
                                        <button class="btn btn-primary btn-sm">Valider</button> 
                                    </div>
                                </div>
                             </form>
                                

                                
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
 
   <div  class="modal fade " id="cmdDetailModal" tabindex="-1" role="dialog">
            <div  class="modal-dialog" role="document">
                <div  class="modal-content">
                    <div class="modal-header">
                        
                        <h5 class="modal-title">Assigner</h5>
                        <a id="closeDetail" href="javascript:;" data-dismiss="modal">Fermer</a>

                    </div>
                    <div v-if="selectedVariant != null"  class="modal-body detailBody">
                      <button @click="assignLiv(11)" type='button' class='btn  btn-danger mt-2' v-if="Number(commands[selectedVariant].livreur_id) != 11">Desassigner</button>

                      <div v-if="deliverymen.length > 0" v-for="(livreur, ind) in deliverymen" class="card card-widget widget-user-2">
              <!-- Add the bg color to the header using any of the bg-* classes -->
              <div class="widget-user-header bg-warning">
                <div class="widget-user-image">
                  <img class="img-circle elevation-2" :src="findImage(livreur.photo)" alt="User Avatar">
                </div>
                <!-- /.widget-user-image -->
                <h3 class="widget-user-username">{{livreur.nom}}</h3>
                <div class="widget-user-desc">
                  <button @click='assignLiv(Number(livreur.id))' type='button' class='btn  btn-primary btn-sm mr-2' > Assigner</button>
                  <button @click="getLivreurCmds(livreur.id, ind, 'other')"   class="btn btn-primary btn-sm">voir assigantions</button>
                  
                </div>
              </div>
              <div class="float-right mt-2">
              <button type="button" class="btn btn-tool  float-right" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
              </div>    
              <div class="card-footer p-0">

                <ul class="nav flex-column">
                  <li class="nav-item">
                    <a href="#" class="nav-link">
                      <div  :id="'otherDetail'+ind">
                        
                        </div>
                    </a>
                  </li>
                  
                </ul>
              </div>
              
            </div>

                        <div v-else>
                            
                      Aucun livreur enregistre
                        </div>


         </div>
      </div>
    </div>
  </div>   

  <div   class="modal fade " id="depositActionSheet" tabindex="-1" role="dialog" aria-hidden="true" >
            <div  class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
                <div  class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title cmdModalTitle">Créer une course</h5>
                        <a href="javascript:;" data-dismiss="modal">Fermer</a>
                        

                    </div>
                    <div   class="modal-body">
                        <div class="action-sheet-content">
       
           
          
       <form id="cmdForm" onsubmit="return false;">
   <div  id="cmdSuccess"  class="card mb-2">
         <div v-if="newR" class="card-body">
                <button onclick="exportToImage('newR')" type="button" @click="" class="btn btn-primary  mt-2 squared" id="bill">ENVOYER COMME IMAGE</button>

               <a  @click="copyText('newRR')" type="button"  class="btn btn-primary ml-2  mt-2 squared" id="bill">Copier</a>
                <div class="row" >
                    <input id="newRR" class="d-none"  :value="'Numero de commande:'+newR.id+ '(a inscrire sur le colis).' +newR.description +'.' +newR.adresse+'.'+ newR.phone" >
               <div id="newR" class="col-4">
              <span style="color:red; font-size: 30px; font-weight: bold;">#{{newR.id}}</span>(a inscrire sur le colis). {{newR.description}}.{{newR.adresse}}. {{newR.phone}}
             </div>
              </div>
           </div>
            </div>

           <div class="card mb-1">
          <div class="card-body">
              
          
      <h3 >Client </h3><div class="bg-warning" style="font-weight: bold; color: black;">{{clientTip}}</div>

      <div   class="input-group input-group-lg mb-2">
       <div class="input-group-prepend">
    <span class="input-group-text" id="basic-addon1">Client*</span>
  </div><input placeholder="Commencer à taper le nom"  @input="handleProvInput" id="provider"  v-model="providerName" 
    class="form-control" >
    
      
      </div>
       <div  id="swu">
    <span v-for="sw in swu" class="badge badge-primary" :key="sw" class="suggestion" @click="selectProvSuggestion(sw)">
      {{ sw.nom }}
    </span>
  </div>
      <div v-if="showProvSuggestions" id="suggestions">
    <span v-for="suggestion in filteredProvSuggestions" class="badge badge-primary" :key="suggestion" class="suggestion" @click="selectProvSuggestion(suggestion)">
      {{ suggestion.nom }}
    </span>
  </div>
    
    <div v-if="subcriptionSearch"  class="input-group input-group-lg mb-2">
        {{subcriptionSearch}}
      </div>
      <div v-if="clientSubscriptions.length > 0">
    <div   class="input-group input-group-lg mb-2">
      

       <select @change="checkDistrib(index)" v-model="subscription"      class="form-control" >
        <option value="">Choisir une souscriprion</option>
        
      <option v-for="(clientSubscription, index) in clientSubscriptions" :value="clientSubscription.id">{{clientSubscription.nom}}, {{getRemaining(index)}} Courses/plis restant</option>
      
      </select>
      </div>

      <div v-if="isDistrib == 1"  class="input-group input-group-lg mb-2">
       <div class="input-group-prepend">
    <span class="input-group-text" id="basic-addon1">Nombre de plis*</span>
  </div>
      <input v-model="pliQty" id="pliqty"      class="form-control" type="number" placeholder="Nombre de plis" aria-label="Client" aria-describedby="basic-addon1" >
      </div>
     </div>

      <div  class="input-group input-group-lg mb-2">
       <div class="input-group-prepend">
    <span class="input-group-text" id="basic-addon1">Nom*</span>
  </div>
      <input v-model="provName" id="povname" maxlength="150"     class="form-control" type="text" placeholder="Nom du client" aria-label="Client" aria-describedby="basic-addon1" >
      </div>


        <div class="input-group input-group-lg mb-2">
       <div class="input-group-prepend">
    <span class="input-group-text" id="">Contact*</span>
  </div>
      <input v-model="provPhone"   required  name="phone" class="form-control" type="tel" placeholder="Numero du client sans l'indicatif(225)"  autocomplete="off">
      <?php if ($errors->has('phone')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('phone'); ?>
      <span class="invalid-feedback" role="alert">
      <strong><?php echo e($message); ?></strong>                   
      </span>
      <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>
      <span class="contact_div text-warning"></span> 
      </div>


      <div class="input-group input-group-lg mb-2">
       <div class="input-group-prepend">
    <span class="input-group-text" id="">Commune de ramassage*</span>
  </div>
      <select v-model="provCity"   required  class="form-control" >
      <option  value="">selectionner Une ville/commune</option>
      <?php $__currentLoopData = $fees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <option 
     
      value="<?php echo e($fee->destination); ?>"><?php echo e($fee->destination); ?></option>
      <div id="fee_price"></div>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </select>
      
      </div>

      <div  class="input-group input-group-lg mb-2">
       <div class="input-group-prepend">
    <span class="input-group-text" id="basic-addon1">Adresse de ramassage*</span>
  </div>
      <input v-model="provAdresse" id="povadresse" maxlength="150"     class="form-control" type="text" placeholder="Adresse du client" aria-label="Client" aria-describedby="basic-addon1" >
      </div>

     
     </div>
 </div>
        
      <div class="card mb-1">
          <div class="card-body">
      


       <h3>Destinataire</h3>
      <div class="input-group input-group-lg mb-2">
       <div class="input-group-prepend">
    <span class="input-group-text" id="basic-addon1">Nom</span>
  </div>
      <input @input="handleInput" v-model="costumer" id="cmdcostumer" maxlength="150"    name="costumer" class="form-control" type="text" placeholder="Nom du client" aria-label="Client" aria-describedby="basic-addon1" >
      </div>

       <div v-if="showSuggestions" id="suggestions">
    <span v-for="suggestion in filteredSuggestions" class="badge badge-primary" :key="suggestion" class="suggestion" @click="selectSuggestion(suggestion)">
      {{ suggestion.nom }}
    </span>
  </div>

      <div class="input-group input-group-lg mb-2">
       <div class="input-group-prepend">
    <span class="input-group-text" id="">Contact1*</span>
  </div>
      <input v-model="phone"   required  name="phone" class="form-control" type="text" pattern="[0-9]+" placeholder="Numero du client sans l'indicatif(225)"  autocomplete="off">
      <?php if ($errors->has('phone')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('phone'); ?>
      <span class="invalid-feedback" role="alert">
      <strong><?php echo e($message); ?></strong>                   
      </span>
      <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>
      <span class="contact_div text-warning"></span> 
      </div>

      <div class="input-group input-group-lg mb-2">
       <div class="input-group-prepend">
    <span class="input-group-text" id="">Contact2</span>
  </div>
      <input pattern="[0-9]+" v-model="phone2"   required   class="form-control" type="text" placeholder="Numero du client sans l'indicatif(225)"  autocomplete="off">
      <?php if ($errors->has('phone')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('phone'); ?>
      <span class="invalid-feedback" role="alert">
      <strong><?php echo e($message); ?></strong>                   
      </span>
      <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>
      <span class="contact_div text-warning"></span> 
      </div>

      <div class="input-group input-group-lg mb-2">
       <div class="input-group-prepend">
    <span class="input-group-text" id="">Commune*</span>
  </div>
      <select @change="getTarif" v-model="fee"   required  class="form-control" name="fee">
      <option  value="">selectionner Une ville/commune</option>
      <?php $__currentLoopData = $fees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <option 
      <?php if(old('fee') == $fee->id): ?> selected <?php endif; ?>
      value="<?php echo e($fee->id); ?>"><?php echo e($fee->destination); ?></option>
      <div id="fee_price"></div>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </select>
      <?php if ($errors->has('fee')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('fee'); ?>
      <span class="invalid-feedback" role="alert">
      <strong><?php echo e($message); ?></strong>
      </span>
      <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>
      </div>

      <div class="input-group input-group-lg mb-2">
       <div class="input-group-prepend">
    <span class="input-group-text" id="">Adresse</span>
  </div>
      <input v-model="adresse"  maxlength="150" value="<?php echo e(old('lieu')); ?>" id="cmdlieu" name="adresse" class="form-control" type="text" placeholder="Ex: grand carrefour... pharmacie... rivera jardin..." autocomplete="off">
      </div>

      <span hidden v-if="tarif != null && feeTarifs == null">
       <button v-if="livraison == tarif" @click="fastTarif(tarif)" type="button" class="btn btn-primary mr-1 mb-1">{{tarif}}f Normal(48h)</button>
       <button v-else @click="fastTarif(tarif, 2)" type="button" class="btn btn-secondary mr-1 mb-1">{{tarif}}f Normal(48h)</button>
       </span>
       <span hidden v-if="feeTarifs != null" v-for="feeTarif in feeTarifs">
         <button v-if="livraison == feeTarif.price" @click="fastTarif(feeTarif.price, feeTarif.delai)" type="button" class="btn btn-primary mr-1 mb-1">{{feeTarif.price}}f {{feeTarif.description}}</button>
       <button v-else @click="fastTarif(feeTarif.price, feeTarif.delai)" type="button" class="btn btn-secondary mr-1 mb-1">{{feeTarif.price}}f {{feeTarif.description}}</button>
           
       </span>

   </div>
</div>


<div class="card mb-1">
          <div class="card-body">
            <div class="row">
           <div class="col"> <h3>Colis</h3></div>
           <div class="col"> 

            <button v-if="products.length > 0"  data-target="#newCmdProdModal" data-toggle="modal"  type="button"  class="btn btn-primary btn-sm" ><ion-icon name="add-circle-outline"></ion-icon>Ajouter des produits</button>
        </div>
       </div>
       <div class="row mb-2" v-if="productPlus.length > 0" v-for="(fields, index) in productPlus">
          
           <div class="col-8">
           <select  data-live-search="true" :id="'prod-select'" :class="'selectpicker form-control'" >
               <option :data-tokens="field.name" v-for="field in fields" >{{field.name}}</option>
           </select>
           </div>
           <div class="col-2">
           <input min="1" type="number" class="form-control " >
       </div>
       <div @click="removeField(index)" class="col-2">
           <ion-icon name="close-circle-outline"></ion-icon>
       </div>

       </div>


        <div class="input-group input-group-lg mb-2">
       <div class="input-group-prepend">
    <span class="input-group-text" id="">Nature*</span>
  </div>
      <input v-model="nature"   id="cmdnature" maxlength="150" required   name="type"  class="form-control" type="text" placeholder="Nature du colis" >
      <strong class="text-dark"></strong>
      
      </div>

      <?php if($sources->count() > 0): ?>

      <div class="input-group input-group-lg mb-2">
       <div class="input-group-prepend">
    <span class="input-group-text" id="">Canal</span>
  </div>
      <select v-model="source"  id="cmdsource"    class="form-control" name="source">
        <option value="">Choisir un canal</option>
        <?php $__currentLoopData = $sources; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $source): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <option value="<?php echo e($source->type. '_'.$source->antity); ?>"><?php echo e($source->type. "_".$source->antity); ?></option>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </select>
      <?php if ($errors->has('source')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('source'); ?>
      <span class="invalid-feedback" role="alert">
      <strong><?php echo e($message); ?></strong>
      </span>
      <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>
      </div>
      <?php endif; ?>


    

      <div class="input-group input-group-lg mb-2">
       <div class="input-group-prepend">
    <span class="input-group-text" id="">Prix*</span>
  </div>
      <input   v-model="montant" id="cmdprice"     class="form-control <?php if ($errors->has('montant')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('montant'); ?> is-invalid <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>" type="number" placeholder="Prix (sans la livraison)" autocomplete="off">

      
      
      <?php if ($errors->has('montant')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('montant'); ?>
      <span class="invalid-feedback" role="alert">
      <strong><?php echo e($massage); ?></strong>
      </span>
      <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>
      </div>

      <div :hidden="cart < 1" class="input-group input-group-lg mb-2"> 
      <div class="input-group-prepend">
    <span class="input-group-text" id="">Remise</span>
  </div>
      <input v-model="remise" id="cmdremise"  value="<?php echo e(old('montant')); ?>"  name="remise" class="form-control <?php if ($errors->has('montant')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('montant'); ?> is-invalid <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>" type="number" placeholder="Remise" autocomplete="off">
      <?php if ($errors->has('montant')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('montant'); ?>
      <span class="invalid-feedback" role="alert">
      <strong><?php echo e($massage); ?></strong>
      </span>
      <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>
      </div>

        <div hidden class="form-check">
  <input v-model="payed" value="1" class="form-check-input" type="checkbox" value="1" id="payed">
  <label class="form-check-label" for="flexCheckDefault">
    Deja paye?
  </label>
</div>

 </div>
 </div>           


     
      
     
     <div class="card mb-1">
          <div class="card-body">
       
      <hr>
       <div class="row">
           <div class="col"> <h3>Livraison</h3></div>
           
       </div>

       <button v-if="delivery_date == '<?php echo e(date('Y-m-d',strtotime('today'))); ?>'" type="button" @click="fastDate('<?php echo e(date('Y-m-d',strtotime('today'))); ?>')" class="btn btn-primary mr-1 mb-1">Aujourd'hui</button>
<button v-else type="button" @click="fastDate('<?php echo e(date('Y-m-d',strtotime('today'))); ?>')" class="btn btn-secondary mr-1 mb-1">Aujourd'hui</button>

       <button v-if="delivery_date == '<?php echo e(date('Y-m-d',strtotime('tomorrow'))); ?>'" @click="fastDate('<?php echo e(date('Y-m-d',strtotime('tomorrow'))); ?>')" type="button" class="btn btn-primary mr-1 mb-1">Demain</button>
       <button v-else @click="fastDate('<?php echo e(date('Y-m-d',strtotime('tomorrow'))); ?>')" type="button" class="btn btn-secondary mr-1 mb-1">Demain</button>


        <div class="input-group input-group-lg mb-2">
        
       <div class="input-group-prepend">
    <span class="input-group-text" id="">Date livraison*</span>
  </div>


      <input 
          required type="date" value="<?php echo e(old('delivery_date')); ?>" name="delivery_date" v-model="delivery_date" class="form-control"  id="cmddate" >
      <?php if ($errors->has('delivery_date')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('delivery_date'); ?>
      <span class="invalid-feedback" role="alert">
      <strong><?php echo e($message); ?></strong>
      </span>
      <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>
      </div>
      

     <div  class="input-group  mb-2">

       <div class="input-group-prepend">
    <span class="input-group-text" id="">Tarif livraison*</span>
  </div>
   <div class="row">
        <div class="col">
       <button v-if="livraison == 1000" @click="fastTarif(1000)" type="button" class="btn btn-primary mr-1 mb-1">1000f</button>
       <button v-else @click="fastTarif(1000)" type="button" class="btn btn-secondary mr-1 mb-1">1000f</button>

       <button v-if="livraison == 1500" @click="fastTarif(1500)" type="button" class="btn btn-primary mr-1 mb-1">1500f</button>
       <button v-else @click="fastTarif(1500)" type="button" class="btn btn-secondary mr-1 mb-1">1500f</button>

        <button v-if="livraison == 2000" @click="fastTarif(2000)" type="button" class="btn btn-primary mr-1 mb-1">2000f</button>
       <button v-else @click="fastTarif(2000)" type="button" class="btn btn-secondary mr-1 mb-1">2000f</button>

        <button v-if="livraison == 2500" @click="fastTarif(2500)" type="button" class="btn btn-primary mr-1 mb-1">2500f</button>
       <button v-else @click="fastTarif(2500)" type="button" class="btn btn-secondary mr-1 mb-1">2500f</button>

        <button v-if="livraison == 3000" @click="fastTarif(3000)" type="button" class="btn btn-primary mr-1 mb-1">3000f</button>
       <button v-else @click="fastTarif(3000)" type="button" class="btn btn-secondary mr-1 mb-1">3000f</button>

        <button v-if="livraison == 3500" @click="fastTarif(3500)" type="button" class="btn btn-primary mr-1 mb-1">3500f</button>
       <button v-else @click="fastTarif(3500)" type="button" class="btn btn-secondary mr-1 mb-1">3500f</button>

       <button v-if="livraison == 4000" @click="fastTarif(4000)" type="button" class="btn btn-primary mr-1 mb-1">4000f</button>
       <button v-else @click="fastTarif(4000)" type="button" class="btn btn-secondary mr-1 mb-1">4000f</button>

        <button v-if="livraison == 0" @click="fastTarif(0)" type="button" class="btn btn-primary mr-1 mb-1">Gratuit</button>
       <button v-else @click="fastTarif(0)" type="button" class="btn btn-secondary mr-1 mb-1">Gratuit</button>

        <button v-if="livraison == 'autre'" @click="fastTarif('autre')" type="button" class="btn btn-primary  mb-1">Autre</button>
       <button v-else @click="fastTarif('autre')" type="button" class="btn btn-secondary  mb-1">Autre</button>

       </div>
   </div>


      <select hidden v-model="livraison"  required   class="form-control livraison" name="livraison">
        <option value="">Choisir tarif</option>
      <option value="1000">1000f</option>
      <option value="1500">1500f</option>
      <option value="2000">2000f</option>
      <option value="2500">2500f</option>
      <option value="3000">3000f</option>
      <option value="0">Gratuit</option>
      <option value="autre">Autre tarif</option>
      </select>
      <?php if ($errors->has('fee')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('fee'); ?>
      <span class="invalid-feedback" role="alert">
      <strong><?php echo e($message); ?></strong>
      </span>
      <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>
      </div>


       
     


     <div v-if="livraison == 'autre'" class="input-group mb-2 " >
       <div class="input-group-prepend">
    <span  class="input-group-text" id="">Autre Tarif*</span>
  </div>
     
      <input :required="livraison == 'autre'" v-model="oth_fee" name="other_liv"  value="<?php echo e(old('other_liv')); ?>" id="cmdothfee"  class="form-control tarif" type="number" placeholder="" >
      </div>


          <div class="input-group input-group-lg mb-2">
       <div class="input-group-prepend">
    <span class="input-group-text" id="">Delai de livraison(en jour)</span>
  </div>
      <input 
         required type="number" value="2" name="delai" v-model="delai" class="form-control"  id="cmdddlai" >
      <?php if ($errors->has('delivery_date')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('delivery_date'); ?>
      <span class="invalid-feedback" role="alert">
      <strong><?php echo e($message); ?></strong>
      </span>
      <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>
      </div>


    

<?php if($livreurs->count() > 0): ?>
 <div class="input-group mb-3 livreurInput">
       <div class="input-group-prepend">
    <span class="input-group-text" id="">Livreur</span>
</div>
      <select  v-model="livreur"    class="form-control livreur" name="livreur">
        <option value="">Choisir livreur</option>
        <?php $__currentLoopData = $livreurs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $livreur): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <option value="<?php echo e($livreur->id); ?>"><?php echo e($livreur->nom); ?></option>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </select>
      <?php if ($errors->has('livreur')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('livreur'); ?>
      <span class="invalid-feedback" role="alert">
      <strong><?php echo e($message); ?></strong>
      </span>
      <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>
      </div>

      <?php else: ?>


      <div hidden class="input-group mb-3 livreurInput">
       <div class="input-group-prepend">
    <span class="input-group-text" id="">Livreur</span>
</div>
      <select class="form-control livreur" name="livreur">
        <option value="">Choisir livreur</option>
       
      </select>
      <?php if ($errors->has('livreur')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('livreur'); ?>
      <span class="invalid-feedback" role="alert">
      <strong><?php echo e($message); ?></strong>
      </span>
      <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>
      </div>

      <?php endif; ?>


</div>
</div>


      <div class="form-group">
      <label  class="form-label">Information supplementaire.</label>
      
      <textarea v-model="observation" id="comobservation" maxlength="150" value="<?php echo e(old('observation')); ?>"  name="observation" class="form-control" type="text" placeholder="Information supplementaire" rows="4" cols="4">
      </textarea>
      </div>
                         
               <div>
                   <span v-if="livraison == 'autre'" style="font-weight: bold; font-size: 22px; color:black">Total: {{ Number(greatTotal)+Number(oth_fee) }}</span>
                  
                   <span v-else style="font-weight: bold; font-size: 22px; color:black">Total: {{ Number(greatTotal)+Number(livraison) }}</span>

               </div>
                          

            <span v-if="cmdError" class="mb-2 alert alert-danger" >{{cmdError}}</span>

                            <div v-if="confirm">
                               <strong class="text-warning">Il existe deja {{confirm}}  commande(s) enregistree avec ce numero {{phone}}. Souhaitez vous confirmer?</strong><br>

                               <button v-if="livraison =='autre'" type="button" @click="confirmCmd" :disabled="nature == '' || delivery_date == '' ||  destination == ''|| fee == '' || phone == '' || livraison == '' || provider == '' || provAdresse == '' || provPhone == '' || provName == '' || provCity == ''"   class="btn btn-success  mr-2" 
                                        >Oui confirmer</button>

                               <button v-else type="button" @click="confirmCmd" :disabled="nature == '' || delivery_date == '' ||  destination == ''|| fee == '' || phone == '' || livraison == '' || provider == '' || provAdresse == '' || provPhone == '' || provName == '' || provCity == ''"  class="btn btn-success  mr-2" 
                                        >Oui confirmer</button>         

                               <button @click="cancelCmd" type="button"  class="btn btn-danger" >Non Annuler</button>         
                           </div>

                                <div v-else  >


                                       
                                    <button v-if="livraison =='autre'" type="button" @click="newCmd" :disabled="nature == '' || delivery_date == '' || montant == '' || destination == ''|| fee == '' || phone == '' || livraison == '' || provider == '' || provAdresse == '' || provPhone == '' || provName == '' || provCity == ''"   class="btn btn-primary btn-block btn-lg" id="addCmd"
                                        >Enregister</button>


                                    <button v-else type="button" @click="newCmd" :disabled="nature == '' || delivery_date == '' ||  destination == ''|| fee == '' || phone == '' || livraison == '' || provider == '' || provAdresse == '' || provPhone == '' || provName == '' || provCity == ''"   class="btn btn-primary btn-block btn-lg" id="addCmd"
                                        >Enregister</button>    
                                </div>

                            
                           </form> 
                        </div>
                    </div>
                </div>
            </div>
        </div> 

        <div  class="modal fade "  id="newCmdProdModal"  tabindex="-1" aria-hidden="true">
            <div  class="modal-dialog modal-dialog-scrollable" role="document">
                <div  class="modal-content">
                    <div class="modal-header">
                      <h5  class="modal-title editModalTitle">Mes produit</h5>
                        <a data-toggle="modal" data-target="#depositActionSheet" data-dismiss="modal">Fermer</a>
                        
                        

                    </div>
                    <div   class="modal-body">
                        <div class="row">
                           <div class="col">
                            <h3>Liste des produits</h3>
                           </div>
                           <div class="col">
                            <h3>Total: {{ total }} </h3> 
                           </div> 
                        </div>
                        
                           <button data-toggle="modal" data-target="#depositActionSheet"  data-dismiss="modal" class="btn btn-primary"  >Terminer ajout</button>
                         
                        <div  v-for="(product, index) in products" :key="product.id" @mouseover="updateSelectedProduct(index)"  class="transactions mb-2 ">
                         
                       

                 <div v-if="product.qty > 0"  class="card card-widget widget-user-2 shadow-sm">
                    <input hidden type="" :value="product.id+'_'+product.qty" name="products[]">
              <!-- Add the bg color to the header using any of the bg-* classes -->
              <div class="widget-user-header bg-success">
                <div class="widget-user-image">
                  <img class="img-circle elevation-2" :src="findImage(product.photo)" alt="User Avatar">
                </div>
                <!-- /.widget-user-image -->
                <h3 class="widget-user-username">{{ product.name }}</h3>
                <h5 class="widget-user-desc">{{ product.qty }} * {{ product.price }} = {{ product.price* product.qty}}</h5>
              </div>
              <div class="card-footer p-0">
                <ul class="nav flex-column">
                  <li class="nav-item">
                    <button type="button" :disabled="product.stock > 0 ? false : true" v-on:click="addToCart()" class="btn btn-success mr-1 btn-sm">Ajouter au Panier</button>
                    <button type="button" v-if="product.qty > 0" v-on:click="removeFromCart()" class="btn btn-danger btn-sm ">Retirer du Panier</button>
                  </li>
                  <li class="nav-item">
                    <a href="#" class="nav-link">
                      Stock <span :class="product.stock > 0 ? 'float-right badge bg-success' : 'float-right badge bg-danger' ">{{ product.stock }}</span>
                    </a>
                  </li>
                </ul>
              </div>
            </div>
                </div>
            
                <!-- * item -->
                
                
                       <hr > 
                       <h3>Mes produits</h3> 

                     <div class="form-group searchbox mb-2">
        <select onchange="searchcat()" id="searchCat" data-column="2" class="form-control">
                    <option value="">Toutes les categories</option>
                    <option :value="category.name" v-if="categories.length > 0" v-for="category in categories">{{ category.name }}</option>
                 </select>
             </div> 

                       <div class="form-group searchbox ">
                <input onkeyup="search3()" id="Search3" type="text" class="form-control">
            <i class="input-icon">
                <ion-icon name="search-outline"></ion-icon>
            </i>
        </div>
           
            <div v-for="(product, index) in products" :key="product.id" @mouseover="updateSelectedProduct(index)" class="transactions mt-2  target3">
                <!-- item -->

                <div v-if="product.qty == 0"  class="card card-widget widget-user-2 shadow-sm">
                   
              <!-- Add the bg color to the header using any of the bg-* classes -->
              <div class="widget-user-header bg-warning">
                <div class="widget-user-image">
                  <img class="img-circle elevation-2" :src="findImage(product.photo)" alt="User Avatar">
                </div>
                <!-- /.widget-user-image -->
                <h3 class="widget-user-username">{{ product.name }}</h3>
                <h5 class="widget-user-desc">{{ product.price }} </h5>
                <h5 class="widget-user-desc">{{ product.category }} </h5>
              </div>
              <div class="card-footer p-0">
                <ul class="nav flex-column">
                  <li class="nav-item">
                    <button type="button" :disabled="product.stock > 0 ? false : true" v-on:click="addToCart()" class="btn btn-success mr-1 btn-sm">Ajouter au Panier</button>
                    <button type="button" v-if="product.qty > 0" v-on:click="removeFromCart()" class="btn btn-danger btn-sm ">Retirer du Panier</button>
                    <a href="#" class="nav-link">
                      Stock <span :class="product.stock > 0 ? 'float-right badge bg-success' : 'float-right badge bg-danger' ">{{ product.stock }}</span>
                    </a>
                  </li>
                  
                </ul>
              </div>
            </div>
                
            </div>
                        
                </div>
            </div>
        </div>

      </div>

      <div class="modal fade" id="filterModal" tabindex="-1" role="dialog">
            <div  class="modal-dialog" role="document">
                <div  class="modal-content">
                    <div class="modal-header">
                        
                        <h5 class="modal-title">Filter</h5>
                        {{livreurs.length}} -  {{fees.length}} -  {{sources.length}}
                        <a href="javascript:;" data-dismiss="modal">Fermer</a>
                    </div>
                    <div   class="modal-body">
                        <div class="action-sheet-content ">
                            <form action="?">
                                <div hidden>
                                     <input value="<?php echo e($state); ?>" type="text" name="state">
                                       <input value="<?php echo e($start); ?>" type="text" name="start">
                                    <input value="<?php echo e($end); ?>"  type="text" name="end">
                                    <input value="<?php echo e($page); ?>"  type="text" name="page">
                                </div>
                                    
                                
                            <?php if($livreurs->count() > 0): ?>
                          <div class="form-group">
                            <label class="form-label ">Filter par livreur</label>
                              <select  v-model="livreurs" title="Choisir livreurs..." id="livreur-select" class="select2 form-control" multiple="multiple" data-placeholder="selectionner livreur(s)"  name="livreurs[]">
                               
                                 <?php $__currentLoopData = $livreurs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $livreur): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                  <option value="<?php echo e($livreur->id); ?>"><?php echo e($livreur->nom); ?></option>
                                 <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                 </select>
                                 <?php if ($errors->has('livreur')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('livreur'); ?>
                                   <span class="invalid-feedback" role="alert">
                               <strong><?php echo e($message); ?></strong>
                                </span>
                              <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>
                          </div>
                          <?php endif; ?>


                           <div class="form-group">
                            <label class="form-label ">Filter par etat d'assignation</label>
                              <select  v-model="assigns" title="Choisir livreurs..." id="assign-select" class="select2 form-control" multiple="multiple" data-placeholder="selectionner livreur(s)"  name="assigns[]">
                               
                                
                                  <option value="assigned">Assignés</option>
                                   <option value="unassigned">No assignés</option>
                               
                                 </select>
                                 <?php if ($errors->has('livreur')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('livreur'); ?>
                                   <span class="invalid-feedback" role="alert">
                               <strong><?php echo e($message); ?></strong>
                                </span>
                              <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>
                          </div>

                          <div class="form-group">
                            <label class="form-label">Filtrer par utilisateur</label>
                              <select data-style="btn-dark" v-model="clients" title="Tous les utilisateurs" id="client-select" class=" selectpicker form-control" multiple  name="clients[]">
                                <option value="<?php echo e($client->id); ?>}">Moi-meme</option>
                                 <?php if($clients->count() > 0): ?>
                                 <?php $__currentLoopData = $clients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $clt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                 <?php if($clt->user): ?>
                                  <option value="<?php echo e($clt->user->id); ?>"><?php echo e($clt->nom); ?></option>
                                  <?php endif; ?>
                                 <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                 <?php endif; ?>
                                 </select>
                                

                          </div>

                           <div class="form-group">
                            <label class="form-label">Filter par client</label>
                              <select data-style="btn-dark" v-model="providers" title="Tous les clients" id="provider-select" class=" selectpicker form-control" multiple  name="providers[]">
                                
                                 <?php if($providers->count() > 0): ?>
                                 <?php $__currentLoopData = $providers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $prov): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                  <option value="<?php echo e($prov->id); ?>"><?php echo e($prov->nom); ?></option>
                                 <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                 <?php endif; ?>
                                 </select>
                          </div>

                           <div class="form-group">
                            <label class="form-label">Filter par commune</label>
                              <select data-style="btn-dark" v-model="fees" title="Choisir communes..." id="fee-select" class="select2 form-control" multiple="multiple" data-placeholder="selectionner commune(s)" name="fees[]">
                               
                                 <?php $__currentLoopData = $fees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                  <option value="<?php echo e($fee->id); ?>"><?php echo e($fee->destination); ?></option>
                                 <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                 </select>
                                 <?php if ($errors->has('fee')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('fee'); ?>
                                   <span class="invalid-feedback" role="alert">
                               <strong><?php echo e($message); ?></strong>
                                </span>
                              <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>

                          </div>

                          <?php if($sources->count() > 0): ?>
                          <div class="form-group">
                            <label class="form-label">Filter par source</label>
                              <select  v-model="sources" title="Choisir sources..." id="source-select" class="select2 form-control" multiple="multiple" data-placeholder="selectionner source(s)"  name="sources[]">
                                 <option value="catalogue">Catalogue</option>
                                
                                 <?php $__currentLoopData = $sources; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $source): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                  <option value="<?php echo e($source->type. '_'.$source->antity); ?>"><?php echo e($source->type. '_'.$source->antity); ?></option>
                                 <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                 
                                 </select>
                                

                          </div>
                         <?php endif; ?>

                         <div class="form-group">
                            <label class="form-label">Filtre par Etat</label>
                              <select  v-model="etats" title="Choisir etat(s)..." id="state-select" class="select2 form-control" multiple="multiple" data-placeholder="selectionner commune(s)" name="etats[]">
                               
                                
                                  <option value="encours">Encours</option>
                                  <option value="recupere">Récuperé</option>
                                   <option value="en chemin">En chemin</option>
                                   <option value="termine">Livré</option>
                                   <option value="annule">Annulé</option>
                                
                                 </select>
                                
                          </div>
                          <button  class="btn btn-primary btn-block">Filtrer</button>
                          </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

     <div  class="modal fade " id="bulkAssignModal" tabindex="-1" role="dialog">
            <div  class="modal-dialog" role="document">
                <div  class="modal-content">
                    <div class="modal-header">
                        
                        <h5 class="modal-title">Assigner selection</h5>
                        <a id="closeBulkAssign" href="javascript:;" data-dismiss="modal">Fermer</a>

                    </div>
                    <div v-if="Object.keys(selectedCommands).length > 0"  class="modal-body detailBody">
                      <button @click="bulkAssign('11')" type='button' class='btn  btn-danger mt-2' >Desassigner</button>

                      <div v-if="deliverymen.length > 0" v-for="(livreur, index) in deliverymen" class="card card-widget widget-user-2">
              <!-- Add the bg color to the header using any of the bg-* classes -->
              <div class="widget-user-header bg-warning">
                <div class="widget-user-image">
                  <img class="img-circle elevation-2" :src="findImage(livreur.photo)" alt="User Avatar">
                </div>
                <!-- /.widget-user-image -->
                <h3 class="widget-user-username">{{livreur.nom}}</h3>
                <div class="widget-user-desc">
                  <button @click='bulkAssign(livreur.id)' type='button' class='btn  btn-primary btn-sm mr-2' > Assigner</button>
                  <button @click="getLivreurCmds(livreur.id, index, 'other')"   class="btn btn-primary btn-sm">voir assigantions</button>
                  
                </div>
              </div>
              <div class="float-right mt-2">
              <button type="button" class="btn btn-tool  float-right" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
              </div>    
              <div class="card-footer p-0">

                <ul class="nav flex-column">
                  <li class="nav-item">
                    <a href="#" class="nav-link">
                      <div  :id="'otherDetail'+index">
                        
                        </div>
                    </a>
                  </li>
                  
                </ul>
              </div>
              
            </div>

                        <div v-else>
                            
                      Aucun livreur enregistre
                        </div>


         </div>
      </div>
    </div>
  </div>  


   <div   class="modal fade modalbox" id="productsModal"  tabindex="-1" role="dialog">
            <div  class="modal-dialog" role="document">
                <div  class="modal-content">
                    <div class="modal-header">
                      <h5  class="modal-title editModalTitle">Mes produit</h5>
                        <a href="javascript:;" data-dismiss="modal" @click="resetProducts">Fermer</a>
                        
                        

                    </div>
                    <div   class="modal-body">
                        <div class="row">
                           <div class="col">
                            <h3>Produits de la commande {{ selectedCommand }}</h3>
                           </div>
                           <div class="col">
                            <h3>Total: {{ total }} </h3> 
                           </div> 
                        </div>
                        <form method="post" action="updatecmdprod">
                            <?php echo csrf_field(); ?>
                           <button class="btn btn-primary mb-2" type="submit">Valider</button>
                         <input hidden type="" name="id" :value="selectedCommand">
                        <div  v-for="(product, index) in products" :key="product.id" @mouseover="updateSelectedProduct(index)"  class="transactions mb-2">
                         
                       

                 <div v-if="product.qty > 0"  class="card card-widget widget-user-2 shadow-sm">
                    <input hidden type="" :value="product.id+'_'+product.qty" name="products[]">
              <!-- Add the bg color to the header using any of the bg-* classes -->
              <div class="widget-user-header bg-warning">
                <div class="widget-user-image">
                  <img class="img-circle elevation-2" :src="findImage(product.photo)" alt="User Avatar">
                </div>
                <!-- /.widget-user-image -->
                <h3 class="widget-user-username">{{ product.name }}</h3>
                <h5 class="widget-user-desc">{{ product.qty }} * {{ product.price }} = {{ product.price* product.qty}}</h5>
              </div>
              <div class="card-footer p-0">
                <ul class="nav flex-column">
                  <li class="nav-item">
                    <button type="button" :disabled="product.stock > 0 ? false : true" v-on:click="addToCart()" class="btn btn-success mr-1 btn-sm">Ajouter au Panier</button>
                    <button type="button" v-if="product.qty > 0" v-on:click="removeFromCart()" class="btn btn-danger btn-sm ">Retirer du Panier</button>
                  </li>
                  <li class="nav-item">
                    <a href="#" class="nav-link">
                      Stock <span :class="product.stock > 0 ? 'float-right badge bg-success' : 'float-right badge bg-danger' ">{{ product.stock }}</span>
                    </a>
                  </li>
                </ul>
              </div>
            </div>
                </div>
            </form>
                <!-- * item -->
                
                
                       <hr> 
                       <h3>Mes produits</h3> 
                       <div class="form-group searchbox ">
                <input onkeyup="search2()" id="Search2" type="text" class="form-control">
                <i class="input-icon">
                    <ion-icon name="search-outline"></ion-icon>
                </i>
            </div>
                       <div v-for="(product, index) in products" :key="product.id" @mouseover="updateSelectedProduct(index)" class="transactions mt-2 row target2">
                <!-- item -->

                <div v-if="product.qty == 0"  class="card card-widget widget-user-2 shadow-sm">
                   
              <!-- Add the bg color to the header using any of the bg-* classes -->
              <div class="widget-user-header bg-warning">
                <div class="widget-user-image">
                  <img class="img-circle elevation-2" :src="findImage(product.photo)" alt="User Avatar">
                </div>
                <!-- /.widget-user-image -->
                <h3 class="widget-user-username">{{ product.name }}</h3>
                <h5 class="widget-user-desc">{{ product.price }} </h5>
              </div>
              <div class="card-footer p-0">
                <ul class="nav flex-column">
                  <li class="nav-item">
                    <button type="button" :disabled="product.stock > 0 ? false : true" v-on:click="addToCart()" class="btn btn-success mr-1 btn-sm">Ajouter au Panier</button>
                    <button type="button" v-if="product.qty > 0" v-on:click="removeFromCart()" class="btn btn-danger btn-sm ">Retirer du Panier</button>
                    <a href="#" class="nav-link">
                      Stock <span :class="product.stock > 0 ? 'float-right badge bg-success' : 'float-right badge bg-danger' ">{{ product.stock }}</span>
                    </a>
                  </li>
                  
                </ul>
              </div>
            </div>
                
            </div>
                        
                </div>
            </div>
        </div>

      </div>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">

            
                <div class="card">
                    <div class="card-header">
                        Course à venir 
                <?php echo e($upcomings->sum('montant')); ?>F (<?php echo e($upcomings->count()); ?>)
                    </div>
                    <div class="card-body">
             
      
          <?php if($upcomings->count()>0): ?>
         <?php $__currentLoopData = $upcomings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $x=>$upcoming): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

         
            <a class="btn-group mb-2 mr-2" href="commands?state=all&start=<?php echo e($upcoming->delivery_date->format('Y-m-d')); ?>&end=<?php echo e($upcoming->delivery_date->format('Y-m-d')); ?>">
       <button  class="btn btn-secondary btn-sm square"><?php echo e($upcoming->delivery_date->format('d-m-Y')); ?></button>
      <button   class="btn btn-success btn-sm square" >
    <?php echo e($upcoming->montant); ?>F (<?php echo e($upcomings_count[$x]->nbre); ?>)
  </button>
  </a>



         
         <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
         <?php endif; ?>  
      
      
          </div>  
          </div> 
        </div>
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Mes courses <button data-toggle="modal" data-target="#dateModal" class="btn btn-outline-primary mr-2 d-print-none"><?php echo e($day); ?></button></h1> 

     
            
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="/">Home</a></li>
              <li class="breadcrumb-item active">Mes courses</li>
            </ol>
          </div>
        </div>
        
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <?php if($start == $end): ?>
        <div class="d-none d-print-block row mb-2"><h4><?php echo e(date_create($end)->format("d-m-Y")); ?></h4></div> 
        <?php else: ?>
         <div class="d-none d-print-block row"><h4>Du <?php echo e(date_create($start)->format("d-m-Y")); ?> au <?php echo e(date_create($end)->format("d-m-Y")); ?></h4></div>

        <?php endif; ?>
        <div class="row mb-2">
        
        
                      <?php if($all_commands->count() > 0): ?>
                      <form action="?" id="pageForm">
                      <span class="mr-2">  page <?php echo e($page); ?>/<?php echo e($pages); ?> (<?php echo e($all_commands->count()); ?> Courses)</span>
                         <input hidden type="" name="start" value="<?php echo e($start); ?>" >
                         <input hidden type="" name="end" value="<?php echo e($end); ?>" >
                         <input hidden type="" name="limit" value="<?php echo e($limit); ?>" >
                         <?php if(request()->has("assigns")): ?>
                         <?php $__currentLoopData = request('assigns'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $asg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                           <input hidden type="" name="assigns[]" value="<?php echo e($asg); ?>" >
                           <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                         <?php endif; ?>

                         <?php if(request()->has("clients")): ?>
                         <?php $__currentLoopData = request('clients'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $clt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                           <input hidden type="" name="clients[]" value="<?php echo e($clt); ?>" >
                           <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                         <?php endif; ?>

                           <?php if(request()->has("providers")): ?>
                         <?php $__currentLoopData = request('providers'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $prov): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                           <input hidden type="" name="providers[]" value="<?php echo e($prov); ?>" >
                           <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                         <?php endif; ?>

                          <?php if(request()->has("livreurs")): ?>
                         <?php $__currentLoopData = request('livreurs'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $liv): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                           <input hidden type="" name="livreurs[]" value="<?php echo e($liv); ?>" >
                           <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                         <?php endif; ?>

                          <?php if(request()->has("etats")): ?>
                         <?php $__currentLoopData = request('etats'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $et): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                           <input hidden type="" name="etats[]" value="<?php echo e($et); ?>" >
                           <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                         <?php endif; ?>
                      <select onchange="document.getElementById('pageForm').submit()" name="begining">

                          <?php for($x = 1; $x<= $pages; $x++): ?>
                           <option  
                            <?php if($x == $page): ?>
                                selected 
                            <?php endif; ?>

                            value="<?php echo e($x); ?>"><?php echo e($x); ?></option>
                          <?php endfor; ?>
                      </select>
                      </form>

                      <form action="?" id="limitForm" class="ml-2">
                      <span class="mr-2">  Nombre par page </span>
                         <input hidden type="" name="start" value="<?php echo e($start); ?>" >
                         <input hidden type="" name="end" value="<?php echo e($end); ?>" >
                         <input hidden type="" name="begining" value="<?php echo e($begining); ?>" >
                         <?php if(request()->has("assigns")): ?>
                         <?php $__currentLoopData = request('assigns'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $asg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                           <input hidden type="" name="assigns[]" value="<?php echo e($asg); ?>" >
                           <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                         <?php endif; ?>

                         <?php if(request()->has("clients")): ?>
                         <?php $__currentLoopData = request('clients'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $clt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                           <input hidden type="" name="clients[]" value="<?php echo e($clt); ?>" >
                           <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                         <?php endif; ?>

                          <?php if(request()->has("livreurs")): ?>
                         <?php $__currentLoopData = request('livreurs'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $liv): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                           <input hidden type="" name="livreurs[]" value="<?php echo e($liv); ?>" >
                           <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                         <?php endif; ?>

                          <?php if(request()->has("etats")): ?>
                         <?php $__currentLoopData = request('etats'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $et): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                           <input hidden type="" name="etats[]" value="<?php echo e($et); ?>" >
                           <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                         <?php endif; ?>
                      <select onchange="document.getElementById('limitForm').submit()" name="limit">

                          <?php for($x = 50; $x<= 500; $x+=50): ?>
                           <option  
                            <?php if($x == $limit): ?>
                                selected 
                            <?php endif; ?>

                            value="<?php echo e($x); ?>"><?php echo e($x); ?></option>
                          <?php endfor; ?>
                      </select>
                      </form>
                      <?php endif; ?>
<!-- 
        <h3>Total:</h3><h2 style=" font-weight: bold;">{{ getTotal() }}({{commands.length}})</h2> &nbsp;&nbsp;<h3>/</h3>&nbsp;&nbsp;  
          <h3>Livres: </h3><h2 style="font-weight: bold;">{{getLivre()[0]}}({{getLivre()[1]}})</h2> -->
        
            </div>

            <div class="row mb-2">
               <?php if($filter != ""): ?>
            
            <?php echo $filter; ?> 

            <a href="?start=<?php echo e($start); ?>&&end=<?php echo e($end); ?>" class="btn btn-primary d-print-none">Retour aux courses</a>
            
            <?php endif; ?>
            </div>
        <div class="row">
          <div class="col-12">
            

            <div class="card table-responsive p-0">
              <div class="card-header">
                 <div class="mb-2">
                        <form action="?">
                                <div hidden>
                                     <input value="<?php echo e($state); ?>" type="text" name="state">
                                       <input value="<?php echo e($start); ?>" type="text" name="start">
                                    <input value="<?php echo e($end); ?>"  type="text" name="end">
                                    <input value="<?php echo e($page); ?>"  type="text" name="begining">
                                     <input value="unassigned"  type="text" name="assigns[]">
                                </div>
                                    
          <button v-if="input2 == 'en attente'"  type="button" @click="input2 = '';  searchInput()" class="btn phone btn-dark  ">< Retour</button>
                        <button v-if="getUnassigned > 0"  type="button" @click="input2 = 'en attente';  searchInput()" type="button" class="btn phone btn-warning mr-2 text-dark">{{getUnassigned}} courses non assignées sur cette page</button>
                         
                        <button class="btn btn-warning" type="submit"  style="font-weight: bold;">{{allAssigned}} courses non assignées sur la période</button>
                    </form>
          </div>
                
          <input type="text" id="searchInput" @keyup="searchInput" v-model="input2" class="" placeholder="Recherche">
         


                
                <div class="card-tools">

                    <button  type="button" class="btn btn-success d-print-none mr-2" data-toggle="modal" data-target="#depositActionSheet">
                      <i class="fas fa-plus"></i> Creer une course
                    </button>
                     <button  onclick="window.print();return false;"  rel="noopener"  class="btn btn-default d-print-none mr-2"><i class="fas fa-print"></i> Imprimer</button>
            <button  class="btn btn-default d-print-none" onclick="ExportToExcel()"><i class="fas fa-sheets"></i>Excel</button>
                  
                   <button hidden id="toastrDefaultSuccess"  ></button>
                   



                    <button :disabled="commands.length < 1" data-toggle="modal" data-target="#filterModal" class="btn  btn-light mr-2 d-print-none"><i class="fas fa-filter d-print-none"></i> Filtrer</button>
                
                      <a target="_blank" href="printing?etiquettes&state=<?php echo e($state); ?>&start=<?php echo e($start); ?>&end=<?php echo e($end); ?>" class="btn  btn-light d-print-none" >Imprimer Etiquettes</a>
                    
                  <div class="btn-group show" >
                    <button :disabled="Object.keys(selectedCommands).length < 1" type="button" class="btn btn-info btn-flat d-print-none">Action groupee</button>

                    
                   
                    <button :disabled="Object.keys(selectedCommands).length < 1" type="button" class="btn btn-info btn-flat dropdown-toggle dropdown-icon d-print-none" data-toggle="dropdown" aria-expanded="true">
                      <span class="sr-only">Toggle Dropdown</span>
                    </button>
                    <div class="dropdown-menu" role="menu" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(68px, 38px, 0px);">
                      <a data-toggle="modal" data-target="#bulkAssignModal" class="dropdown-item" href="#">Assigner</a>
                      <a data-toggle="modal" data-target="#bulkRptModal" class="dropdown-item" href="#">Reporter</a>
                      <a class="dropdown-item" @click="bulkReset" href="#">Reinitialiser</a>
                      
                    </div>
                  </div>

                 
                  
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="tbl_exporttable_to_xls" class="table table-bordered table-striped d-print-none table-responsive">
                  <thead>
                  <tr>
                    <th class="d-print-none"><input @change="checkAll" type="checkbox" id="checkAll" ></th>
                    <th>Numero </th>
                     
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
                  </tr>
                  </thead>
                  <tbody>

                  <tr  v-for="(command, index) in commands" :class="getClass(index)">

                    <td class="d-print-none">


                        <input  :value="command.id" @change="checkCmd(command.id)"  type="checkbox" class="cmds_chk" ></td>
                    <td>
                      
                       <span v-if="command.user">Enregistrée par {{command.user.name}}</span>
                        <span v-else>Enregistrée par le client</span><br>
                      
            <div class="accordion " :id="'cmdEtat'+index">
                <div class="item">
                    <div class="accordion-header">
                        <button :id="'EtatDetail'+index" class="btn   collapsed" type="button" data-toggle="collapse"
                            :data-target="'#accordion7'+index">
                            <div>
                           # <strong>{{command.id}}</strong><br>
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
                <i class="fas fa-edit d-print-none"></i>
                <div v-else  class="col">
                  
                  
                </div>
                  
                    </div>
                        </button>
                    </div>
                    <div :id="'accordion7'+index" class="accordion-body collapse d-print-none d-print-none" :data-parent="'#cmdEtat'+index">
                        <div class="accordion-content">
                             
                            <div class="form-group">
                                <div class="form-group">
                            <label>Choisir nouvel etat</label>
                            <select  :id="'cmdState'+index" name="etat"   class="form-control" >
                                <option v-for="status in states"   :selected="status.value == command.etat" :value="status.value">{{status.text}}</option>
                                
                            </select>
                             
                        </div>
                        <button @click="updateStatus(index)"  class="btn btn-primary mt-1 mr-1">Modifier</button>
                        <button :id="'EtatDetail'+index" class="btn  btn-danger collapsed" type="button" data-toggle="collapse"
                            :data-target="'#accordion7'+index">
                            Fermer
                          </button>
                               
                            </div>
                           
                        </div>
                    </div>
                </div>
            </div>

                <span data-toggle="modal" data-target="#noteViewModal" @click="getNote(command.id)" v-if='command.note.length > 0' class="text-info">
                <i   class="fa fa-note d-print-none"></i>
                 {{command.note[0].created_at.substring(8, 10)}}-
               {{command.note[0].created_at.substring(5, 7)}}-
               {{command.note[0].created_at.substring(0, 4)}} {{command.note[0].created_at.substring(11, 16)}}  
                {{command.note[0].description}} 
              </span>
              <br>
              <a href="#" data-toggle="modal" data-target="#eventViewModal" @click="getEvent(command.id)"  class="text-primary d-print-none">
              Historique
            </a>
                    </td>
                   


             <td>
                      
              <div  class="accordion " :id="'cmdProvider'+index">
                <div class="accordion-item">
                    <div  class="accordion-header">
                        <button class="btn   collapsed" type="button" data-toggle="collapse"
                            :data-target="'#accordion900'+index">
                            <div v-if="command.client" class="tools">
                              {{command.client.nom}}<br>
                               {{command.client.adresse}} 
                                         {{command.client.phone}} 
                                         
                      <i class="fas fa-edit d-print-none"></i>
                      <i class="fas fa-trash-o d-print-none"></i>
                    </div>
                           
                        </button>
                    </div>
                    <div :id="'accordion900'+index" class="accordion-body collapse d-print-none" :data-parent="'#cmdProvider'+index">
                        <div  class="accordion-content">
                              
                            <div class="form-group">
                                 <div class="input-group mb-2">
                 <div class="input-group-prepend">
                  <span class="input-group-text" id="">Client</span>
                    </div>
                 <select v-model="selectedSubscriber"  :id="'cmdProv'+index"    class="form-control">
                  <option value="">Choisir un client</option>
                 <?php $__currentLoopData = $providers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $provider2): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <option value="<?php echo e($provider2->id); ?>"><?php echo e($provider2->nom); ?> <?php echo e($provider2->id); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                  </select>
      
                        </div>  

                      </div>

                    
                            <button :disabled="processing == 1 || selectedSubscriber == '' " @click="updateProvider(index)"  class="btn btn-primary mt-1 mr-1">Modifier</button>
                             <button class="btn  btn-danger collapsed" type="button" data-toggle="collapse"
                            :data-target="'#accordion900'+index">
                            Fermer
                          </button>
                           
                        </div>
                       
                    </div>
                </div>
            </div>

                    </td>







                    <td>
                      <!-- <a v-if="command.products.length > 0" @click="updateProducts(command.products ,command.id)" data-toggle="modal" data-target="#productsModal" class="btn  btn-primary  phone btn-sm ml-1 d-print-none" href="#" >
                            <ion-icon name="cart-outline"></ion-icon>
                            {{command.products.length}} articles
                         </a>
                         
                          <a v-else data-toggle="modal" data-target="#productsModal" @click="updateProducts({}, command.id)" class="btn  btn-primary  phone btn-sm ml-1 d-print-none" href="#" >
                            <ion-icon name="cart-outline"></ion-icon>
                            Ajoueter articles
                         </a> -->
              <div  class="accordion " :id="'cmdDescription'+index">
                <div class="accordion-item">
                    <div class="accordion-header">
                        <button class="btn   collapsed" type="button" data-toggle="collapse"
                            :data-target="'#accordion2'+index">
                            <div class="tools">
                              {{command.description}}
                      <i class="fas fa-edit d-print-none"></i>
                       </button>
                       <i @click="deleteConfirm = index" class="fas fa-trash ml-2 text-danger d-print-none"></i>
                    </div>

                    <div v-if="deleteConfirm == index"  class="row mb-1 d-print-none">
                    
                   Souhaitez vous vraiment supprimer cette commande?
                    <div>
                    <button @click="deleteCmd(index)" class="btn btn-danger mr-2">Oui</button> 
                    <button @click="deleteConfirm = null" class="btn btn-success">Non</button>
                    </div>
                </div>
                    </div>
                    <div :id="'accordion2'+index" class="accordion-body collapse d-print-none" :data-parent="'#cmdDescription'+index">
                        <div class="accordion-content">
                              
                            <div class="form-group">
                                <input :id="'cmdDesc'+index" :value="command.description" class="form-control" type="" name="">

                                
                            </div>
                            <button @click="updateDescription(index)" :disabled="command.description == '' " class="btn btn-primary mt-1 mr-1">Modifier</button>
                             <button class="btn  btn-danger collapsed" type="button" data-toggle="collapse"
                            :data-target="'#accordion2'+index">
                            Fermer
                          </button>
                           
                        </div>
                    </div>
                </div>
            </div>



                    </td>
                    <td>
                      <div class="accordion" :id="'cmdDate'+index">
                <div class="item">
                    <div class="accordion-header">
                        <button class="btn   collapsed" type="button" data-toggle="collapse"
                            :data-target="'#accordion1'+index">
                           <div class="tools">
                             
                            {{command.delivery_date.substring(8, 10)}}-
                             {{command.delivery_date.substring(5, 7)}}-
                            {{command.delivery_date.substring(0, 4)}}
                      <i class="fas fa-edit d-print-none"></i>
                      <i class="fas fa-trash-o"></i>
                    </div>

                        </button>


                    </div>
                    <div :id="'accordion1'+index" class="accordion-body collapse d-print-none" :data-parent="'#cmdDate'+index">
                        <div class="accordion-content">
                         
                            <div class="form-group">
                                <input :id="'ddate'+index" :value="command.delivery_date" class="form-control" type="date" name="">

                                
                            </div>

                            <button @click="updateDate(index)" :disabled="command.delivery_date == '' " class="btn btn-primary mt-1 mr-1">Modifier</button>

                            <button class="btn btn-danger  collapsed" type="button" data-toggle="collapse"
                            :data-target="'#accordion1'+index">
                            Fermer
                          </button>
                           
                        </div>
                    </div>
                </div>
            </div>
                    </td>
                   






                    <td>


              <div class="accordion" :id="'cmdRam'+index">
                <div class="item">
                    <div class="accordion-header">
                        
                        <button class="btn   collapsed" type="button" data-toggle="collapse"
                            :data-target="'#accordion100'+index">
                            <div class="tools">
                              <span  style="font-size: 13px; line-height: 1.6; font-style: italic;"> 
                        Nom: {{command.ram_name}}
                        </span><br>
                        <strong>
                           {{command.ram_commune}} 
                          {{command.ram_adresse}}<br>
                          {{command.ram_phone}}
                        </strong>
                      <i class="fas fa-edit d-print-none"></i>
                      <i class="fas fa-trash-o"></i>
                    </div>
                            
                           
                        </button>
                    </div>
                    <div :id="'accordion100'+index" class="accordion-body collapse d-print-none" :data-parent="'#cmdRam'+index">
                        <div class="accordion-content">
                           <div class="input-group mb-2">
                        <div class="input-group-prepend">
                           <span class="input-group-text" id="">Contact</span>
                         </div>
                                <input :id="'ramPhone'+index" :value="command.ram_phone" class="form-control" type="tel" name="">

                            </div>

                           

                           <div class="input-group mb-2">
                        <div class="input-group-prepend">
                           <span class="input-group-text" id="">Nom</span>
                         </div>
                                <input :id="'ramName'+index" :value="command.ram_name" class="form-control" type="" name="">
                              </div>  
                            <div class="form-group mb-1">
                        
                          <select :id="'ramCommune'+index"   required  class="form-control" name="fee">
                             <option  value="">selectionner Une ville/commune</option>
                             <?php $__currentLoopData = $fees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option 
                         
                          value="<?php echo e($fee->destination); ?>"><?php echo e($fee->destination); ?></option>
                          
                          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                         </select>
                         </div>
                           <div class="input-group mb-2">
                        <div class="input-group-prepend">
                           <span class="input-group-text" id="">Adresse</span>
                           </div>
                                <input :id="'ramAdresse'+index" :value="command.ram_adresse" class="form-control" type="" name="">

                            </div>
                                
                            

                            <button @click="updateRam(index)"  class="btn btn-primary mt-1 mr-1">Modifier</button>
                            <button class="btn btn-danger  collapsed" type="button" data-toggle="collapse"
                            :data-target="'#accordion100'+index">
                            Fermer
                          </button>
                        </div>
                    
                </div>
            </div>
            </div>          
                        
                    </td>



                 



                  <td>


              <div class="accordion" :id="'cmdClient'+index">
                <div class="item">
                    <div class="accordion-header">
                        <span v-if="command.longitude && command.latitude">
                            <a target="_blank" :href="'https://www.google.com/maps/search/?api=1&query='+command.latitude+'%2C'+command.longitude">Voir possition sur map</a>
                        </span>
                        <button class="btn   collapsed" type="button" data-toggle="collapse"
                            :data-target="'#accordion3'+index">
                            <div class="tools">
                              <span  style="font-size: 13px; line-height: 1.6; font-style: italic;"> 
                        Nom: {{command.nom_client}}
                        </span><br>
                        <strong>
                          {{command.adresse}}<br>
                          {{command.phone}} / {{command.phone2}}
                        </strong>
                      <i class="fas fa-edit d-print-none"></i>
                      <i class="fas fa-trash-o"></i>
                    </div>
                            
                           
                        </button>
                    </div>
                    <div :id="'accordion3'+index" class="accordion-body collapse d-print-none" :data-parent="'#cmdClient'+index">
                        <div class="accordion-content">
                           <div class="input-group mb-2">
                        <div class="input-group-prepend">
                           <span class="input-group-text" id="">Contact 1</span>
                         </div>
                                <input :id="'cmdPhone'+index" :value="command.phone" class="form-control" type="tel" name="">

                            </div>

                            <div class="input-group mb-2">
                        <div class="input-group-prepend">
                           <span class="input-group-text" id="">Contact 2</span>
                         </div>
                                <input :id="'cmdPhone2'+index" :value="command.phone2" class="form-control" type="tel" name="">

                            </div>

                           <div class="input-group mb-2">
                        <div class="input-group-prepend">
                           <span class="input-group-text" id="">Nom</span>
                         </div>
                                <input :id="'cmdClt'+index" :value="command.nom_client" class="form-control" type="" name="">
                              </div>  
                            <div class="form-group mb-1">
                        
                          <select :id="'cmdFee'+index"   required  class="form-control" name="fee">
                             <option  value="">selectionner Une ville/commune</option>
                             <?php $__currentLoopData = $fees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option v-if="command.fee" :selected ="command.fee.id == '<?php echo e($fee->id); ?>'"
                         
                          value="<?php echo e($fee->id); ?>"><?php echo e($fee->destination); ?></option>
                           <option v-else 
                         
                          value="<?php echo e($fee->id); ?>"><?php echo e($fee->destination); ?></option>

                          
                          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                         </select>
                         </div>
                           <div class="input-group mb-2">
                        <div class="input-group-prepend">
                           <span class="input-group-text" id="">Adresse</span>
                           </div>
                                <input v-if='command.fee' :id="'cmdAdrs'+index" :value="command.adresse.substring(command.fee.destination.length+1)" class="form-control" type="" name="">

                                <input v-else :id="'cmdAdrs'+index" :value="command.adresse" class="form-control" type="" name="">

                            </div>
                                
                            

                            <button @click="updateClient(index)"  class="btn btn-primary mt-1 mr-1">Modifier</button>
                            <button class="btn btn-danger  collapsed" type="button" data-toggle="collapse"
                            :data-target="'#accordion3'+index">
                            Fermer
                          </button>
                        </div>
                    
                </div>
            </div>
            </div>          
                        
                    </td>

















                    <td>
                      <button @click="updateVariant(index)"  data-toggle="modal" data-target="#cmdDetailModal"  class="btn btn-primary btn-sm d-print-none" >
                      <span v-if="command.livreur_id == '11'">Non assigne</span>
                      <span v-if="command.livreur && command.livreur_id != '11'">{{command.livreur.nom}}</span>
                    </button>

                    <span class="d-none d-print-block" v-if="command.livreur_id == '11'">Non assigne</span>
                      <span class="d-none d-print-block" v-if="command.livreur && command.livreur_id != '11'">{{command.livreur.nom}}</span>
                    </td>


                    <td>
                     <div class="accordion mt-2" :id="'cmdCost'+index">
                      <div class="item">
                          <h2 class="accordion-header">
                        <button class="btn   collapsed" type="button" data-toggle="collapse"
                            :data-target="'#accordion5'+index">
                            <div class="tools">
                             {{command.montant}}
                      <i class="fas fa-edit d-print-none"></i>
                      <i class="fas fa-trash-o"></i>
                    </div>
                        </button>
                    </h2>
                    <div :id="'accordion5'+index" class="accordion-body collapse d-print-none" :data-parent="'#cmdCost'+index">
                        <div class="accordion-body">
                           
                            <div class="input-group mb-2">
                          
                                <input :id="'cmdMontant'+index" :value="command.montant" class="form-control" type="number" name="">

                                
                            </div>


                            <button @click="updateCost(index)" class="btn btn-primary mt-1 mr-1">Modifier</button> 

                            <button class="btn  btn-danger collapsed" type="button" data-toggle="collapse"
                            :data-target="'#accordion5'+index">
                            Fermer
                            </button>
                            
                        </div>
                    </div>
                </div>

            </div>
</td>
                    <td> 


                      <div class="accordion " :id="'cmdLivraison'+index">

                <div class="item">
                    <div class="accordion-header">
                      
                        <button class="btn   collapsed" type="button" data-toggle="collapse"
                            :data-target="'#accordion6'+index">
                          
                             <div class="tools">
                              {{command.livraison}}
                      <i class="fas fa-edit d-print-none"></i>
                      <i class="fas fa-trash-o"></i>
                    </div>
                        </button>
                    </div>
                    <div :id="'accordion6'+index" class="accordion-body collapse d-print-none" :data-parent="'#cmdLivraison'+index">
                        <div class="accordion-body">
                            

                            <div class="input-group mb-2">
                        <div class="input-group-prepend">
                           <span class="input-group-text" id="">Livraison</span>
                          </div>
                                <input :id="'cmdLiv'+index" :value="command.livraison" class="form-control" type="number" name="">
                              
                                
                            </div>

                            <button @click="updateLiv(index)" class="btn btn-primary mt-1 mr-1">Modifier</button>

                             <button class="btn btn-danger  collapsed" type="button" data-toggle="collapse"
                            :data-target="'#accordion6'+index">
                            Fermer
                          </button>
                           
                        </div>
                    </div>
                </div>

            </div>

</td>
                    <td>{{command.montant-command.remise+command.livraison}}</td>
                    <td>
                      

            <div class="accordion" :id="'cmdObservavation'+index">
                <div class="item">
                    <div class="accordion-header">
                        <button class="btn   collapsed" type="button" data-toggle="collapse"
                            :data-target="'#accordion8'+index">
                             <div class="tools">
                             {{command.observation}}
                      <i class="fas fa-edit d-print-none"></i>
                      <i class="fas fa-trash-o"></i>
                    </div>
                            
                        </button>
                    </div>
                    <div :id="'accordion8'+index" class="accordion-body collapse d-print-none" :data-parent="'#cmdObservavation'+index">
                        <div class="accordion-content">
                             
                            <div class="form-group">
                                <input :id="'cmdObs'+index" :value="command.observation" class="form-control" type="" name="">

                                <button @click="updateObs(index)"  class="btn btn-primary mt-1 mr-1">Modifier</button>

                                <button class="btn btn-danger  collapsed" type="button" data-toggle="collapse"
                            :data-target="'#accordion8'+index">
                            Fermer
                          </button>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
                    </td>
                  </tr>
              </tbody>
                  <tfoot>
                  </tfoot>
                </table>
                <?php echo $__env->make("includes.printable", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>

      
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer d-print-none">
    <div class="float-right d-none d-sm-block">
      <b>Version</b> 3.2.0
    </div>
    <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights reserved.
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
                
</div>
<!-- ./wrapper -->

<div id="toastsContainerTopRight" class="toasts-top-right fixed">
      
  </div>

  
  <script>

   const app = Vue.createApp({
    data() {
        return {
            allAssigned: '<?php echo e($all_commands->where("livreur_id", 11)->count()); ?>',

            clientTip: "Si vous avez dejà enregistré une course pour le client, commencez à taper son nom pour le selectionner. Si non cliquez sur 'Nouveau client'",
            providerName: "",
              showSuggestions: false,
              swu: [{"id":"SWU","created_at":"2023-06-20 06:37:52","updated_at":"2023-06-20 06:37:52","nom":"Nouveau client","phone":"","city":"","adresse":"","":null,"wme":null,"user_id":"","latitude":null,"longitude":null,"photo":null,"manager_id":null,"is_manager":null,"is_certifier":null,"is_collecter":null,"client_type":null,"cc_id":null}],
             filteredSuggestions: [],
            
            selectedVariant: null,
            selectedCommand:"",
            total:0,
            cartProducts: [],
            cart:0,
            products: <?php echo $products; ?>,
            commands: <?php echo $commands; ?>,
            assignBody: "",
            state:"",
            states:[{"text":"Encours", "value":"encours"},{"text":"Récupéré", "value":"recupere"},{"text":"En chemin", "value":"en chemin"},{"text":"Livré", "value":"termine"},{"text":"Annule", "value":"annule"},],
            assign:null,
            livreur:"",
            livreur2:"",
            etat:"",
            selectedLivreur:null,
            fees:[],
            sources:[],
            srces:<?php echo $srces; ?>,
            livreurs:[],
            deliverymen:<?php echo $deliverymen; ?>,
            assignee:"",
            allVals:[],
            zoneLivreur:null,
            otherLivreur:null,
            costumStart:"",
            intStart:null,
            fee:"",
            costumer:"",
            nature:"",
            source:"",
            delivery_date:"",
            montant:"",
            livraison:"",
            adresse:"",
            provider:"",
            delai:"",
            oth_fee:"",
            phone:"",
            phone2:"",
            livreur:"",
            observation:"",
            newR:null,
            cmdError:null,
            cmdNature:"",
            assignees:"",
            singleCommand:[],
            deleteConfirm:null,
            zoneLast:null,
            otherLast:null,
            confirm:null,
            allFees: <?php echo $allfees; ?>,
            selectedCommands:{},
            bulkRptDate:null,
            selectedProduct:null,
            productPlus:[],
            cmdTotal:[],
            categories: <?php echo $categories; ?>,
             cmdProducts:[],
             users: <?php echo $users; ?>,
             clients: <?php echo $providers; ?>,
             provName: "",
             provPhone:"",
             provAdresse: "",
             provCity: "",
             providers: <?php echo $providers; ?>,
             processing: 0,
             selectedFee: null,
            tarif: null,
            feeTarifs: null,
            selectedSubscriber: '',
            input2: "",
             suggestionsList:<?php echo $bclients; ?>,
              showSuggestions: false,
             filteredSuggestions: [],
             clientSubscriptions: [],
             subcriptionSearch: "",
             subscription: "",
             isDistrib: null,
           

        }
    },
    methods:{ 

        handleProvInput() {
      this.showProvSuggestions = true;
      const inputText = this.providerName.toLowerCase().trim();
      this.filteredProvSuggestions = this.providers.filter((suggestion) =>
        suggestion.nom.toLowerCase().startsWith(inputText)
      );
    },

    getRemaining(index){
        qty = 0
        
     if(this.clientSubscriptions[index].subscription_type == "MAD"){
        qty = this.clientSubscriptions[index].commands.length
     }else{
        for(x = 0; x<this.clientSubscriptions[index].commands.length; x++){
          if(this.clientSubscriptions[index].commands[x] != null){
            qty += this.clientSubscriptions[index].commands[x].subscription_qty
          }

          
        }

       
     }
     
     remaining = this.clientSubscriptions[index].qty - qty

     return remaining


    },

    checkDistrib(index){
        this.isDistrib = null
        if(this.clientSubscriptions[index].subscription_type == "DISTRIBUTION"){
       this.isDistrib = 1
     }
        
    },

         selectProvSuggestion(suggestion) {
        if(suggestion.id == "SWU"){
         this.clientTip = "Entrez les informations du nouveau client"

         this.providerName = ""
             this.provider = suggestion.id
             this.provName = ""
           this.provPhone = ""
           this.provCity = ""
           this.provAdresse = ""
        }else
       { this.clientTip = "Si vous avez dejà enregistré une course pour le client, commencez à tapper son nom pour le selectionner. Si non cliquez sur 'Nouveau client'"
        this.providerName = suggestion.nom
             this.provider = suggestion.id;
             this.provName = suggestion.nom
           this.provPhone = suggestion.phone
           this.provCity = suggestion.city
           this.provAdresse = suggestion.adresse
       
            
         }
   
      this.showProvSuggestions = false;

       vm = this
       vm.clientSubscriptions = []
       vm.subcriptionSearch = "Recherche de souscription active pour ce client..."
       axios.post('/getsubscriptions', {
            id: vm.provider,
            _token: CSRF_TOKEN
  })

         
  .then(function (response) {
    
        vm.clientSubscriptions = response.data.subscriptions 

        if(vm.clientSubscriptions.length > 0)
        {vm.subcriptionSearch = ""}
    else{
        {vm.subcriptionSearch = "Aucune souscription active pour ce client."}
    }
       
  
  })
  .catch(function (error) {
    vm.subcriptionSearch = null
    console.log(error);
  });
    },



         fastDate(delivery_date){
        this.delivery_date = delivery_date
    }, 

        handleInput() {
      this.showSuggestions = true;
      const inputText = this.costumer.toLowerCase().trim();
      this.filteredSuggestions = this.suggestionsList.filter((suggestion) =>
        suggestion.nom.toLowerCase().startsWith(inputText)
      );
    },
    selectSuggestion(suggestion) {
      this.costumer = suggestion.nom;
      this.phone = suggestion.contact

      for(i=0; i<this.allFees.length;i++){
        if(this.allFees[i].destination.toLowerCase() == suggestion.commune.toLowerCase()){
            this.fee = this.allFees[i].id
        }
      }
      this.adresse = suggestion.adresse
      this.showSuggestions = false;



     


    },

        copyText(id) {
      const textToCopy = document.getElementById(id).value;

      // Check if the Clipboard API is supported by the browser
      if (navigator.clipboard) {
        navigator.clipboard.writeText(textToCopy)
          .then(() => {
            alert('Copie!');
          })
          .catch((err) => {
            console.error('Failed to copy text: ', err);
          });
      } else {
        // Fallback for browsers that do not support the Clipboard API
        const textArea = document.createElement('textarea');
        textArea.value = textToCopy;
        document.body.appendChild(textArea);
        textArea.select();
        document.execCommand('copy');
        document.body.removeChild(textArea);
        alert('Text copied to clipboard!');
      }
    },

        searchInput(){



const dataTable = document.getElementById('tbl_exporttable_to_xls');
const tableRows = dataTable.getElementsByTagName('tr');


    const searchTerm = this.input2.toLowerCase();

    // Loop through all table rows and hide/show based on the search term
    for (let i = 1; i < tableRows.length; i++) {
        const row = tableRows[i];
        const rowData = row.getElementsByTagName('td');

        let foundMatch = false;
        for (let j = 0; j < rowData.length; j++) {
            const cell = rowData[j];
            if (cell) {
                const cellValue = cell.textContent.toLowerCase();
                if (cellValue.includes(searchTerm)) {
                    foundMatch = true;
                    break;
                }
            }
        }

        if (foundMatch) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    }


    },
   

    fastFee(fee, index){
        this.fee = fee
        this.selectedFee = index
    },

    fastTarif(livraison, delai){
        this.livraison = livraison
        this.delai = delai
    },

    getTarif(){
        this.tarif = null
        this.feeTarifs = null
        for(i = 0; i<this.allFees.length; i++){
            if(this.allFees[i].id == this.fee){
                this.tarif = this.allFees[i].price
                this.feeTarifs = this.allFees[i].tarifs
            }
        }
    },    
    
    getClass(index){
        if(this.commands[index].livreur_id == 11 ){
            return "bg-warning"
        }
    },
    addProductPlus(){
        this.productPlus.push(this.products)
    },

    removeField(index){
        this.productPlus.splice(index, 1)
    },
    cmdsByfee(fee_id){
        var qties = []
        var destination = 0
        destinations = []
        for(i=0; i < this.commands.length; i++){
            if(this.commands[i].fee_id == fee_id){
                qties.push(1) 
                destination = this.commands[i].fee_id
                
            }
        }

    
       

        return [qties.length, destination]
    },


    cmdsByClient(client_id){
        var qties = []
        var client = 0
        destinations = []
        for(i=0; i < this.commands.length; i++){
            if(this.commands[i].client_id == client_id){
                qties.push(1) 
                client = this.commands[i].client_id
                
            }
        }

    
       

        return [qties.length, client]
    },


    checkAll(){

        checkboxes = document.getElementsByClassName("cmds_chk")
        if(document.getElementById("checkAll").checked == true)
        { this.selectedCommands = {}
         for (var i = 0; i < checkboxes.length; i++) { 
              checkboxes[i].checked = true;
              
            }


       for (var i = 0; i < checkboxes.length; i++) { 
              if(checkboxes[i].checked == true){
                this.selectedCommands[i] = checkboxes[i].value


              }
           }
       }
    else{
        this.selectedCommands = {}
        for (var i = 0; i < checkboxes.length; i++) { 
              checkboxes[i].checked = false;
            }
    }

        
    },

    
    
    updateAssign(index){
        this.assign = index
    },  

    updateVariant(index) {
        this.selectedVariant = index
        this.singleCommand = this.commands[index]

       
    },

    updateSelectedProduct(index) {
        this.selectedProduct = index
        

       
    },



   


    addToCart() {
          this.cart += 1 
          this.products[this.selectedProduct].qty += 1
          this.products[this.selectedProduct].stock -= 1
           this.total += this.products[this.selectedProduct].price 
 

    },
 
   removeFromCart() {
        this.cart -= 1
        this.products[this.selectedProduct].qty -= 1
         this.products[this.selectedProduct].stock += 1
        this.total -= this.products[this.selectedProduct].price 
      
    },
    
    getDefaultFee(){
   var defaultFee = 0
        for(i = 0; i < this.allFees.length; i++){
            if(this.fee == this.allFees[i].id){
             defaultFee = this.allFees[i].price
            }
        }

        return defaultFee
    },
    findImage(productImg){
        if(productImg == null){
            src = "assets/img/sample/brand/1.jpg"
        }
        else{
            src = "https://livreurjibiat.s3.eu-west-3.amazonaws.com/"+productImg
        }

        return src
    },
  

    updateProducts(productIds = {}, commandid = 0) {
         this.total = 0
         this.selectedCommand = commandid

        for (a=0; a <  this.products.length; a++) {
            
                
                this.products[a].qty = 0
               
            
        }
        
        for (i=0; i < productIds.length; i++) {
            
            for (y=0; y <  this.products.length; y++) {
            if(this.products[y].id == productIds[i].id){
                
                this.products[y].qty = productIds[i].pivot.qty
                this.total += this.products[y].price*this.products[y].qty

                console.log(productIds)
            }
            
        }
      }
      

    },

    updateSelectedState(state, commandId, livreur){
        this.state = state
        this.livreur = livreur
        this.selectedCommand = commandId
    },

    resetProducts() {
       this.total = 0
       this.nature = ""
        

        for (a=0; a <  this.products.length; a++) {
            
                
                this.products[a].qty = 0
               
            
        }
    },


     bulkAssign(id){
            vm = this
           


         axios.post('/bulkassigncmd', {
            start:'<?php echo e($start); ?>',
            end:'<?php echo e($end); ?>',
            page: '<?php echo e($page); ?>',
            cmd_ids: this.selectedCommands,
            livreur_id:id,
            _token: CSRF_TOKEN
  })

         
  .then(function (response) {
    
        vm.commands = response.data.commands 
        
        if(id == 11){
    vm.allAssigned = Number(vm.allAssigned)+ vm.selectedCommands.length
    }else{
        vm.allAssigned = Number(vm.allAssigned) - vm.selectedCommands.length
    }

        
        document.getElementById("checkAll").checked = false


        checkboxes = document.getElementsByClassName("cmds_chk")
         vm.selectedCommands = {}
         for (var i = 0; i < checkboxes.length; i++) { 
              checkboxes[i].checked = false
              
            }

        document.getElementById("closeBulkAssign").click()
   
       document.getElementById("toastrDefaultSuccess").click()
       
       
  
  })
  .catch(function (error) {
    
    console.log(error);
  });
    },


    bulkReport(){
            vm = this
           
   var rprt_date = document.getElementById("bulk_rpt_date").value
      var assign = 0
       var reset = 0
       if(document.getElementById("ynbassign").checked == true){
          assign = 1
       }

        if(document.getElementById("ynbreset").checked == true){
            reset = 1
        }
         axios.post('/bulkreport', {
            start:'<?php echo e($start); ?>',
            end:'<?php echo e($end); ?>',
            reset:reset,
            assign:assign,
            cmd_ids: this.selectedCommands,
            rprt_date:rprt_date,
            _token: CSRF_TOKEN
  })

         
  .then(function (response) {
    
        vm.commands = response.data.commands 
        

        
        document.getElementById("checkAll").checked = false


        checkboxes = document.getElementsByClassName("cmds_chk")
         vm.selectedCommands = {}
         for (var i = 0; i < checkboxes.length; i++) { 
              checkboxes[i].checked = false
              
            }

        document.getElementById("bulkReportClose").click()
        document.getElementById("toast-10").classList.add("show")
       
       
  
  })
  .catch(function (error) {
    
    console.log(error);
  });
    },


    bulkReset(){
            vm = this
  
         axios.post('/bulkreset', {
            start:'<?php echo e($start); ?>',
            end:'<?php echo e($end); ?>',
            
            cmd_ids: this.selectedCommands,
            _token: CSRF_TOKEN
           
  })

         
  .then(function (response) {
    
        vm.commands = response.data.commands 
        

        
        document.getElementById("checkAll").checked = false


        checkboxes = document.getElementsByClassName("cmds_chk")
         vm.selectedCommands = {}
         for (var i = 0; i < checkboxes.length; i++) { 
              checkboxes[i].checked = false
              
            }

        document.getElementById("bulkActionClose").click()
       document.getElementById("toastrDefaultSuccess").click()
       
  
  })
  .catch(function (error) {
    
    console.log(error);
  });
    },

    newCmd(){
            vm = this
            fee= this.fee
            costumer= this.costumer
            nature= this.nature
            source= this.source
            delivery_date= this.delivery_date
            montant= this.montant
            livraison = this.livraison
            adresse= this.adresse
            oth_fee= this.oth_fee
            phone= this.phone
            phone2= this.phone2
            livreur= this.livreur
            provider = this.provider
            observation = this.observation
            delai = this.delai
            provName = this.provName
            provPhone = this.provPhone
            provAdresse = this.provAdresse
            provCity = this.provCity

             for(i = 0; i < this.products.length; i++){
                if(this.products[i].qty > 0){
                    this.cmdProducts.push(this.products[i].id+'_'+this.products[i].qty)
                }
            }
             
             products = this.cmdProducts

             
             var element = document.getElementById("cmdcostumer")
            document.getElementById("addCmd").disabled = true

         axios.post('/command-fast-register', {
            products:products,
            start:'<?php echo e($start); ?>',
            end:'<?php echo e($end); ?>',
            page: '<?php echo e($page); ?>',
            fee: fee,
            provider:provider,
            delai:delai,
            confirm:vm.confirm,
            costumer: costumer,
            type: nature,
            source: source,
            delivery_date: delivery_date,
            montant: montant,
            livraison: livraison,
            adresse: adresse,
            other_liv: oth_fee,
            phone: phone,
            phone2: phone2,
            livreur: livreur,
            observation: observation,
            provName: provName,
            provPhone: provPhone,
            provAdresse: provAdresse,
            provCity: provCity,
            _token: CSRF_TOKEN
  })

         
  .then(function (response) {
    if(response.data.confirm != null){
        vm.confirm = response.data.confirm
    }else{
        
        vm.newR = response.data.newCmd
        vm.commands = response.data.commands 
        vm.providers = response.data.providers
    
                 vm.fee= ""
                 vm.provider = ""
                 vm.delai = ""
                vm.costumer= ""
                vm.nature= ""
                vm.source= ""
                vm.delivery_date= ""
                vm.montant= ""
                vm.livraison = ""
                vm.adresse= ""
                vm.oth_fee= ""
                vm.phone= ""
                vm.livreur= ""
                vm.observation = ""
                
                element.scrollIntoView({behavior: "smooth", block: "end", inline: "nearest"});

                for(i = 0; i < this.products.length; i++){
                
                    vm.products[i].qty = 0
                           }
            vm.total = 0
            }
   
 
   
  
  })
  .catch(function (error) {
    
    vm.cmdError = "Une erreur s'est produite"
    alert("Une erreur s'est produite")
    console.log(error);
  });
    },



    confirmCmd(){
            vm = this

            
            fee= this.fee
            costumer= this.costumer
            nature= this.nature
            source= this.source
            provider = this.provider
            delai = this.delai
            delivery_date= this.delivery_date
            montant= this.montant
            livraison = this.livraison
            adresse= this.adresse
            oth_fee= this.oth_fee
            phone= this.phone
            phone2= this.phone2
            livreur= this.livreur
            observation = this.observation
            provName = this.provName
            provPhone = this.provPhone
            provAdresse = this.provAdresse
            provCity = this.provCity
             
             var element = document.getElementById("cmdcostumer")
             var cmdForm = document.getElementById("cmdForm")
             
         axios.post('/command-fast-register', {
            products:vm.cmdProducts,
            start:'<?php echo e($start); ?>',
            end:'<?php echo e($end); ?>',
            page: '<?php echo e($page); ?>',
            fee: fee,
            confirm:vm.confirm,
            costumer: costumer,
            type: nature,
            source: source,
            provider: provider,
            delai:delai,
            delivery_date: delivery_date,
            montant: montant,
            livraison: livraison,
            adresse: adresse,
            other_liv: oth_fee,
            phone: phone,
            phone2: phone2,
            livreur: livreur,
            observation: observation,
            provName: provName,
            provPhone: provPhone,
            provAdresse: provAdresse,
            provCity: provCity,
            _token: CSRF_TOKEN
  })

         
  .then(function (response) {
    
        
        vm.newR = response.data.newCmd
        vm.commands = response.data.commands 
                vm.confirm = null
                 vm.fee= ""
                vm.costumer= ""
                vm.nature= ""
                vm.provider = ""
                vm.delai = ""
                vm.source= ""
                vm.delivery_date= ""
                vm.montant= ""
                vm.livraison = ""
                vm.adresse= ""
                vm.oth_fee= ""
                vm.phone= ""
                vm.phone2= ""
                vm.livreur= ""
                vm.observation = ""
               
        
      element.scrollIntoView({behavior: "smooth", block: "end", inline: "nearest"});
 
   for(i = 0; i < this.products.length; i++){
                
                    vm.products[i].qty = 0
               
            }
            vm.total = 0
  
  })
  .catch(function (error) {
    
    vm.cmdError = "Une erreur s'est produite"
    console.log(error);
  });
    },


    cancelCmd(){
                vm.fee= ""
                vm.costumer= ""
                vm.nature= ""
                vm.source= ""
                vm.delivery_date= ""
                vm.montant= ""
                vm.provider = ""
                vm.delai = ""
                vm.livraison = ""
                vm.adresse= ""
                vm.oth_fee= ""
                vm.phone= ""
                vm.phone2= ""
                vm.livreur= ""
                vm.observation = ""
                vm.confirm = null
                provName = ""
                provPhone = ""
                provAdresse = ""
                provCity = ""
    },

    getProvName(){
        if(this.provider != ""){
            for(x= 0; x<this.providers.length; x++){
               if(this.providers[x].id == this.provider){
                this.provName = this.providers[x].nom
                this.provPhone = this.providers[x].phone
                this.provAdresse = this.providers[x].city + " " + this.providers[x].adresse
               }
            }
        }

    },

   getSelectedSubscriber(id){
    this.selectedSubscriber = id
   },

      updateProvider(index){
      this.processing = 1  
     var vm = this
     subscriber = this.selectedSubscriber
    
     

    axios.post('/updateprovider', {
           
            cmdid: vm.commands[index].id ,
          
            subscriber: subscriber,
          

            _token: CSRF_TOKEN
  })

         
  .then(function (response) {
    vm.commands[index].client = null
    vm.commands[index].client = response.data.client
     vm.commands[index].client_id = response.data.client.id
  
    vm.processing = 0

   

    




  })
  .catch(function (error) {
   vm.processing = 0
    console.log(error);
  });
    },

      updateRam(index){
      this.processing = 1  
     var vm = this
     
     ramCommune = document.getElementById("ramCommune"+index).value
     ramAdresse = document.getElementById("ramAdresse"+index).value
     ramPhone = document.getElementById("ramPhone"+index).value
     ramName = document.getElementById("ramName"+index).value
     

    axios.post('/updateram', {
           
            cmdid: vm.commands[index].id ,
          
           
            ram_adresse: ramAdresse,
            ram_phone: ramPhone,
            ram_name: ramName,
            ram_commune: ramCommune,

            _token: CSRF_TOKEN
  })

         
  .then(function (response) {
  
vm.commands[index].ram_nom =    response.data.name
vm.commands[index].ram_adresse =    response.data.adresse
vm.commands[index].ram_phone =    response.data.phone
vm.commands[index].ram_commune =    response.data.commune
   
    vm.processing = 0


  })
  .catch(function (error) {
   vm.processing = 0
    console.log(error);
  });
    },


    updateStatus(index){
     var vm = this

    axios.post('/updatestatus', {
           
            cmdid: vm.commands[index].id ,
            etat: document.getElementById("cmdState"+index).value,
            _token: CSRF_TOKEN
  })

         
  .then(function (response) {
    vm.commands[index].etat = response.data.etat

  })
  .catch(function (error) {
 
    console.log(error);
  });
    },


     updateDescription(index){
     var vm = this

    axios.post('/updatedescription', {
           
            cmdid: vm.commands[index].id ,
            type: document.getElementById("cmdDesc"+index).value,
            _token: CSRF_TOKEN
  })

         
  .then(function (response) {
    vm.commands[index].description = response.data.description

  })
  .catch(function (error) {
 
    console.log(error);
  });
    },




    updateObs(index){
     var vm = this

    axios.post('/updateobservation', {
           
            cmdid: vm.commands[index].id ,
            obs: document.getElementById("cmdObs"+index).value,
            _token: CSRF_TOKEN
  })

         
  .then(function (response) {
    vm.commands[index].observation = response.data.observation

  })
  .catch(function (error) {
 
    console.log(error);
  });
    },


    updateClient(index){
     var vm = this

    axios.post('/updateclient', {
           
            cmdid: vm.commands[index].id ,
            client: document.getElementById("cmdClt"+index).value,
            fee: document.getElementById("cmdFee"+index).value,
            adresse: document.getElementById("cmdAdrs"+index).value,
            phone: document.getElementById("cmdPhone"+index).value,
            phone2: document.getElementById("cmdPhone2"+index).value,

            _token: CSRF_TOKEN
  })

         
  .then(function (response) {
    vm.commands[index].nom_client = response.data.client
    vm.commands[index].fee = response.data.fee
    vm.commands[index].adresse = response.data.adresse
    vm.commands[index].phone = response.data.phone
    vm.commands[index].phone2 = response.data.phone2
  })
  .catch(function (error) {
 
    console.log(error);
  });
    },


     updateAdresse(){
     var vm = this

    axios.post('/updateadresse', {
           
            cmdid: vm.singleCommand.id ,
            fee: document.getElementById("cmdFee").value,
            adresse: document.getElementById("cmdAdrs").value,
            _token: CSRF_TOKEN
  })

         
  .then(function (response) {
    vm.singleCommand.fee = response.data.fee
    vm.singleCommand.adresse = response.data.adresse
    
   


  })
  .catch(function (error) {
 
    console.log(error);
  });
    },



    updateCost(index){
     var vm = this
     montant = document.getElementById("cmdMontant"+index).value
     

    axios.post('/updatecost', {
           
            cmdid: vm.commands[index].id ,
          
            montant: montant,
            _token: CSRF_TOKEN
  })

         
  .then(function (response) {
    vm.commands[index].montant = Number(response.data.montant)
    


  })
  .catch(function (error) {
 
    console.log(error);
  });
    },


    updateSource(index){
     var vm = this
     source = document.getElementById("cmdSrc"+index).value
     

    axios.post('/updatesource', {
           
            cmdid: vm.commands[index].id ,
          
            source: source,
            _token: CSRF_TOKEN
  })

         
  .then(function (response) {
    vm.commands[index].canal = response.data.source
    


  })
  .catch(function (error) {
 
    console.log(error);
  });
    },



    updateLiv(index){
     var vm = this
     
     livraison = document.getElementById("cmdLiv"+index).value

    axios.post('/updateliv', {
           
            cmdid: vm.commands[index].id ,
            livraison: livraison, 
            
            _token: CSRF_TOKEN
  })

         
  .then(function (response) {
    vm.commands[index].livraison = Number(response.data.livraison)
    


  })
  .catch(function (error) {
 
    console.log(error);
  });
    },



    updateDate(index){
     var vm = this

    axios.post('/updatedate', {
           
            cmdid: vm.commands[index].id ,
            ddate: document.getElementById("ddate"+index).value,
            start:'<?php echo e($start); ?>',
            end:'<?php echo e($end); ?>',
            
            _token: CSRF_TOKEN
  })

         
  .then(function (response) {
    
    vm.commands = response.data.commands


 

  })
  .catch(function (error) {
 
    console.log(error);
  });
    },


    updatePhone(){
     var vm = this

    axios.post('/updatephone', {
           
            cmdid: vm.singleCommand.id ,
            phone: document.getElementById("cmdPhone").value,
            _token: CSRF_TOKEN
  })

         
  .then(function (response) {
    vm.singleCommand.phone = response.data.phone

  })
  .catch(function (error) {
 
    console.log(error);
  });
},

deleteCmd(index){
     var vm = this

    axios.post('/deletecmd', {
           
            cmdid: vm.commands[index].id ,
            
            _token: CSRF_TOKEN
  })

         
  .then(function (response) {
    vm.commands.splice(vm.commands[index], 1)
    vm.deleteConfirm = null

  })
  .catch(function (error) {
 
    console.log(error);
  });
},


    getLivreurs(){
     var vm = this
     document.getElementById("assignees").innerHTML = '<span   class="spinner-border spinner-border-sm " role="status" aria-hidden="true"></span><span class="sr-only"></span>'
    axios.post('/assign', {
           
            cmd_id: vm.singleCommand.id ,
           
            _token: CSRF_TOKEN
  })

         
  .then(function (response) {
  
   vm.zoneLivreur = response.data.zone_livreurs
   vm.otherLivreur = response.data.other_livreurs
   vm.zoneLast = response.data.zonelast
   vm.otherLast = response.data.otherlast

   
    document.getElementById("assignees").innerHTML = ''
    

  })
  .catch(function (error) {
   document.getElementById("assignees").innerHTML = "Une erreur s'est produite"
    console.log(error);
  });
    },


    assignLiv(id){
     var vm = this
  
    
    axios.post('/assigncommand', {
           
            cmd_id: vm.commands[vm.selectedVariant].id ,
            livreur_id:id ,
           
            _token: CSRF_TOKEN
  })

         
  .then(function (response) {
    vm.commands[vm.selectedVariant].livreur = response.data.livreur
    vm.commands[vm.selectedVariant].livreur_id = id

    if(id == 11){
        vm.allAssigned = Number(vm.allAssigned)+ 1
    }else{
        vm.allAssigned = Number(vm.allAssigned)- 1
    }
   document.getElementById("closeDetail").click()
   
  document.getElementById("toastrDefaultSuccess").click()
    
    
  

  })
  .catch(function (error) {
    
    console.log(error);
  });
    },



    getLivreurCmds(id, index, type){
     var vm = this
    document.getElementById(type+"Detail"+index).innerHTML = '<span   class="spinner-border spinner-border-sm " role="status" aria-hidden="true"></span><span class="sr-only"></span>'
    axios.post('/getlivreurcmds', {
           
            livreur_id:id ,
           
            _token: CSRF_TOKEN
  })

         
  .then(function (response) {
   
    
    document.getElementById(type+"Detail"+index).innerHTML = response.data.livreurcmds
  })
  .catch(function (error) {
   document.getElementById(type+"Detail"+index).innerHTML = "Une erreur s'est produite"
    console.log(error);
  });
    },



    prepareCmd(id){
     var vm = this
     
    axios.post('/ready', {
           
            cmdid:id,
           
            
            _token: CSRF_TOKEN
  })

         
  .then(function (response) {
    vm.singleCommand.ready = response.data.newstate
    
  

  })
  .catch(function (error) {
    
    console.log(error);
  });
    },



     getNote(id){
     var vm = this
     
    axios.post('/getnote', {
           
            cmdid:id,
           
            
            _token: CSRF_TOKEN
  })

         
  .then(function (response) {
    
    
  document.getElementById('noteViewBody').innerHTML = response.data.result

  })
  .catch(function (error) {
    
    console.log(error);
  });
    },




     getEvent(id){
     var vm = this
     
    axios.post('/getevent', {
           
            cmdid:id,
           
            
            _token: CSRF_TOKEN
  })

         
  .then(function (response) {
    
    
  document.getElementById('eventViewBody').innerHTML = response.data.result

  })
  .catch(function (error) {
    
    console.log(error);
  });
    },
    

    shareBill(text){
       
  if (navigator.share) {
    navigator.share({
      title: 'Facture',
      text: text,
      
    }).then(() => {
      console.log('Thanks for sharing!');
    })
    .catch(console.error);
  } else {
    shareDialog.classList.add('is-open');
  }

    },

 checkCmd(id){

      var checkboxes = document.getElementsByClassName("cmds_chk")
       for (var i = 0; i < checkboxes.length; i++) { 
              if(checkboxes[i].checked == true){
                this.selectedCommands[i] = checkboxes[i].value


              }
              if(checkboxes[i].checked == false)
              {
                
                delete this.selectedCommands[i]; 
              }
            }
          
 },

 getTotal(){
  var total = 0
  for(i=0; i < this.commands.length; i++){
    total += Number(this.commands[i].livraison)
  }

  return total
 },

 getLivre(){
  var total = 0
  var nbre = 0
  for(i=0; i < this.commands.length; i++){
    if(this.commands[i].etat == 'termine')
    {total +=  Number(this.commands[i].montant)
        nbre  += 1}
  }

  livre = [total, nbre]
  return livre
 }



   },
   computed:{

     getUnassigned(){
    this.unasigned = 0
       if(this.commands.length > 0)
       { for (var i = 0; i < this.commands.length; i++) { 
                   if(this.commands[i].livreur_id == 11){
                       this.unasigned += 1
                   }
                   }
               }
 return this.unasigned
 }, 

      greatTotal(){
      if (this.cart > 0)
        { this.montant = this.total}

       return this.montant
     },
     getSelectedProducts(){
        this.selectedProducts = ""
        for(i=0; i<this.products.length; i++){
        if(this.products[i].qty > 0){ 
         this.selectedProducts +=   this.products[i].qty + ' '+ this.products[i].name + "," 
        }
      } 
      if(this.selectedProducts != "")
      {this.nature = this.selectedProducts}
      return this.nature
    },
}
});

  const mountedApp = app.mount('#app')     
  </script>

 

  <audio id="myAudio" >
  <source src="notify.wav" type="audio/wav">
 
  Your browser does not support the audio element.
</audio>

<!-- jQuery -->
<script src="../../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="../../plugins/select2/js/select2.full.min.js"></script>
<!-- DataTables  & Plugins -->
<script src="../../plugins/datatables/jquery.dataTables.min.js"></script>
<script src="../../plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="../../plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="../../plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="../../plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="../../plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="../../plugins/jszip/jszip.min.js"></script>
<script src="../../plugins/pdfmake/pdfmake.min.js"></script>
<script src="../../plugins/pdfmake/vfs_fonts.js"></script>
<script src="../../plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="../../plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="../../plugins/datatables-buttons/js/buttons.colVis.min.js"></script>

<script src="../../plugins/sweetalert2/sweetalert2.min.js"></script>
<!-- Toastr -->
<script src="../../plugins/toastr/toastr.min.js"></script>
<!-- AdminLTE App -->
<script src="../../dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../../dist/js/demo.js"></script>
<script type="text/javascript" src="https://unpkg.com/xlsx@0.15.1/dist/xlsx.full.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<!-- Page specific script -->

<script src="https://js.pusher.com/7.2/pusher.min.js"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.5.0-beta4/html2canvas.min.js"></script>
 <?php echo $__env->make("includes.notifications", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<script>

   

function playAudio() {
     var x = document.getElementById("myAudio");
  x.play();
}

   function ExportToExcel(type, fn, dl) {
       var elt = document.getElementById('printable');
       var wb = XLSX.utils.table_to_book(elt, { sheet: "sheet1" });
       return dl ?
         XLSX.write(wb, { bookType: type, bookSST: true, type: 'base64' }):
         XLSX.writeFile(wb, fn || ('Commandes<?php echo e($start); ?>_<?php echo e($end); ?>.' + (type || 'xlsx')));
    }

     

    function search() {
    
    var input = document.getElementById("Search");
    var filter = input.value.toLowerCase();
    var nodes = document.getElementsByClassName('target');
    for (i = 0; i < nodes.length; i++) {
      if (nodes[i].innerText.toLowerCase().includes(filter)) {
        nodes[i].style.display = "block";
      } else {
        nodes[i].style.display = "none";
      }
    }

    $('html, body').animate({
  scrollTop: $(".commands").offset().top
});
  }


  function search2() {
    
    var input = document.getElementById("Search2");
    var filter = input.value.toLowerCase();
    var nodes = document.getElementsByClassName('target2');
    for (i = 0; i < nodes.length; i++) {
      if (nodes[i].innerText.toLowerCase().includes(filter)) {
        nodes[i].style.display = "block";
      } else {
        nodes[i].style.display = "none";
      }
    }

    
  }

function search3() {
    
    var input = document.getElementById("Search3");
    var filter = input.value.toLowerCase();
    var nodes = document.getElementsByClassName('target3');
    for (i = 0; i < nodes.length; i++) {
      if (nodes[i].innerText.toLowerCase().includes(filter)) {
        nodes[i].style.display = "block";
      } else {
        nodes[i].style.display = "none";
      }
    }

    
  }


  function searchcat() {
    
    var input = document.getElementById("searchCat");
    var filter = input.value.toLowerCase();
    var nodes = document.getElementsByClassName('target3');
    for (i = 0; i < nodes.length; i++) {
      if (nodes[i].innerText.toLowerCase().includes(filter)) {
        nodes[i].style.display = "block";
      } else {
        nodes[i].style.display = "none";
      }
    }

    
  }
  $('#livreur-select').select2()
  $('#source-select').select2()
  $('#fee-select').select2()
  $('#client-select').select2()
  $('#provider-select').select2()
  $('#state-select').select2()
  $('#assign-select').select2()
var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
  $(function() {
    var Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 3000
    });

    $('.swalDefaultSuccess').click(function() {
      Toast.fire({
        icon: 'success',
        title: ''
      })
    });
    $('.swalDefaultInfo').click(function() {
      Toast.fire({
        icon: 'info',
        title: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
      })
    });
    $('.swalDefaultError').click(function() {
      Toast.fire({
        icon: 'error',
        title: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
      })
    });
    $('.swalDefaultWarning').click(function() {
      Toast.fire({
        icon: 'warning',
        title: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
      })
    });
    $('.swalDefaultQuestion').click(function() {
      Toast.fire({
        icon: 'question',
        title: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
      })
    });

    $('#toastrDefaultSuccess').click(function() {
      toastr.success('Effectué')
    });
    $('.toastrDefaultInfo').click(function() {
      toastr.info('Lorem ipsum dolor sit amet, consetetur sadipscing elitr.')
    });
    $('.toastrDefaultError').click(function() {
      toastr.error('Lorem ipsum dolor sit amet, consetetur sadipscing elitr.')
    });
    $('.toastrDefaultWarning').click(function() {
      toastr.warning('Lorem ipsum dolor sit amet, consetetur sadipscing elitr.')
    });

    $('.toastsDefaultDefault').click(function() {
      $(document).Toasts('create', {
        title: 'Toast Title',
        body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
      })
    });
    $('.toastsDefaultTopLeft').click(function() {
      $(document).Toasts('create', {
        title: 'Toast Title',
        position: 'topLeft',
        body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
      })
    });
    $('.toastsDefaultBottomRight').click(function() {
      $(document).Toasts('create', {
        title: 'Toast Title',
        position: 'bottomRight',
        body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
      })
    });
    $('.toastsDefaultBottomLeft').click(function() {
      $(document).Toasts('create', {
        title: 'Toast Title',
        position: 'bottomLeft',
        body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
      })
    });
    $('.toastsDefaultAutohide').click(function() {
      $(document).Toasts('create', {
        title: 'Toast Title',
        autohide: true,
        delay: 750,
        body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
      })
    });
    $('.toastsDefaultNotFixed').click(function() {
      $(document).Toasts('create', {
        title: 'Toast Title',
        fixed: false,
        body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
      })
    });
    $('.toastsDefaultFull').click(function() {
      $(document).Toasts('create', {
        body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.',
        title: 'Toast Title',
        subtitle: 'Subtitle',
        icon: 'fas fa-envelope fa-lg',
      })
    });
    $('.toastsDefaultFullImage').click(function() {
      $(document).Toasts('create', {
        body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.',
        title: 'Toast Title',
        subtitle: 'Subtitle',
        image: '../../dist/img/user3-128x128.jpg',
        imageAlt: 'User Picture',
      })
    });
    $('.toastsDefaultSuccess').click(function() {
      $(document).Toasts('create', {
        class: 'bg-success',
        title: 'Toast Title',
        subtitle: 'Subtitle',
        body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
      })
    });
    $('.toastsDefaultInfo').click(function() {
      $(document).Toasts('create', {
        class: 'bg-info',
        title: 'Toast Title',
        subtitle: 'Subtitle',
        body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
      })
    });
    $('.toastsDefaultWarning').click(function() {
      $(document).Toasts('create', {
        class: 'bg-warning',
        title: 'Toast Title',
        subtitle: 'Subtitle',
        body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
      })
    });
    $('.toastsDefaultDanger').click(function() {
      $(document).Toasts('create', {
        class: 'bg-danger',
        title: 'Toast Title',
        subtitle: 'Subtitle',
        body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
      })
    });
    $('.toastsDefaultMaroon').click(function() {
      $(document).Toasts('create', {
        class: 'bg-maroon',
        title: 'Toast Title',
        subtitle: 'Subtitle',
        body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
      })
    });
  });
  $(function () {
    $("#example1").DataTable({
      "responsive": true,
       "lengthChange": false,
        "autoWidth": false,
        "ordering": false,
        "paging": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

    $('#example2').DataTable({
      "paging": false,
      "lengthChange": false,
      "searching": false,
      "ordering": false,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  });
  

   function exportToImage(elementToExport){

      
            // Select the HTML element you want to convert to an image
            const element = document.getElementById(elementToExport);

            // Use html2canvas to capture the element as an image
            html2canvas(element).then(function(canvas) {
                // Convert the canvas to an image and set the image source to the data URL
                const image = new Image();
                image.src = canvas.toDataURL();

                // Open the image in a new window
                const newWindow = window.open();
                newWindow.document.write('<img src="' + image.src + '" alt="Converted HTML to Image"/>');
                     });
        

      }
        


        function printElement(elementToPrint) {
    // Get the element with the desired ID
    const element = document.getElementById(elementToPrint);

    // Check if the element exists
    if (element) {
        // Print the innerHTML of the element
        old = document.body.innerHTML
        document.body.innerHTML = element.innerHTML
          window.print();
          location.reload()
        console.log(element.innerHTML);
    } else {
        console.log('Element not found.');
    }
}
</script>
</body>
</html>
<?php /**PATH /var/www/html/admin/resources/views/commands.blade.php ENDPATH**/ ?>