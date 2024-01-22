<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
  <title>Abonnées</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../../dist/css/adminlte.min.css">
  <link rel="stylesheet" href="../../plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="../../plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
  <style type="text/css">
    .dot {
  height: 10px;
  width: 10px;
  background-color: green;
  border-radius: 50%;
  display: inline-block;
}
  </style>
</head>
<body class="hold-transition sidebar-mini">




<script src="https://unpkg.com/vue@3"></script> 
 <!-- use the latest vue-select release -->

<div id="app" class="wrapper">



  <!-- Navbar -->
 <?php echo $__env->make("includes.navbar", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
  

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Liste des abonnés</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="dashboard">Home</a></li>
              <li class="breadcrumb-item active">Abonnés</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        
       <?php if(session('status')): ?>
                        <div class="alert alert-success" role="alert">
                            <?php echo e(session('status')); ?>

                            <?php if(session("client_fee")): ?>
                            <button class='btn btn-primary ml-2' data-toggle='modal' data-target='#clientFeeModal'>Defininir les tarif</button>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
        <!-- /.row -->
        <div class="row">
          <div class="col-sm-6">
            <form>
              <div class="input-group input-group-sm" style="width: 300px;">
                    <input  type="text" name="search" class="form-control float-right" placeholder="Recherche">
                    <input hidden value="<?php echo e($status); ?>" type="" name="status">
                    <div class="input-group-append">
                      <button type="submit" class="btn btn-default">
                        <i class="fas fa-search"></i>
                      </button>
                    </div>
                  </div>
                </form> 
          </div>

          <div class="col-sm-6">
            <form>
             <div class="input-group input-group-sm" style="width: 500px;">
                   <label>Status</label>
                    <select name="status" class="form-control">
                      <option value="Tout">Tout</option>
                      <option value="En cours">En cours</option>
                      <option value="Expiré">Expiré</option>
                      
                    </select>
                   
                     <input hidden value="<?php echo e($search_result); ?>" type="" name="search">
                    <div class="input-group-append">
                      <button type="submit" class="btn btn-default">
                        <i class="fas fa-search"></i>
                      </button>
                    </div>
                  </div>
                </form> 
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Liste des Abonnés <?php if($search_result != ""): ?>
                (<?php echo e($search_result); ?>) 
                 
              <?php endif; ?>
              <?php if($status != ""): ?>
                (<?php echo e($status); ?>) 
                 
              <?php endif; ?>

            </h3>
              <?php if($search_result != "" || $status != ""): ?>
              <br> <a href="/subscriptions" class=" d-print-none">Retour à la liste complète</a>
              <?php endif; ?>
                <form target="_blank" action="bulkbill" class="bulkBillForm">

                    </form>
                <div class="card-tools">
                  

                   <button type="button" data-toggle="modal" data-target="#subscriptionModal" @click="addSubscription"  class="btn btn-success mr-2">Nouvel abonnement</button>
                  <button type="button" data-toggle="modal" data-target="#bulkBillModal" :disabled="bulkBillInfo.length < 1"   class="btn btn-primary">Génération facture pour la selection</button>
                  
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body  p-0" >
                <table class="table table-head-fixed text-nowrap table-responsive">
                  <thead class=" text-primary">
                    <th></th>
                      <th></th>
                       <th>
                        Client
                      </th>
                      <th>Type</th>
                     
                      <th>
                        Description
                      </th>
                      <th>
                     Coût
                     </th>
                     <th>
                      Quantité
                     </th>
                     <th>
                       Durée
                     </th>
                     <th>
                       Début
                     </th>
                     <th>
                       Fin
                     </th>
                     <th>
                       Consommés
                     </th>

                     <th>
                       Reste
                     </th>

                     <th>
                       extra
                     </th>

                     <th>
                       Facture
                     </th>
                      
                    </thead>
                    <tbody>
                     <?php $__currentLoopData = $offers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index=>$offer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                      <tr >
                        <td> <input v-model="bulkBillInfo" type="checkbox" name="" :value="{'id':'<?php echo e($offer->id); ?>', 'description':'<?php echo e($offer->description); ?>', 'subscriber':'<?php echo e($offer->client); ?>', 'maxDate':'<?php echo e(date_create($offer->end)->format('Y-m-d')); ?>', 'minDate':'<?php echo e(date_create($offer->start)->format('Y-m-d')); ?>', 'period':'Entre le <?php echo e(date_create($offer->start)->format('d-m-Y')); ?> et le <?php echo e(date_create($offer->end)->format('d-m-Y')); ?>'}" @change="generateBulkBill()" >  </td>
                        <td>
                          

                          
                       
                        <button data-toggle="modal" data-target="#confirmModal" @click="deleteSubscription(<?php echo e($index); ?>)" class="btn btn-danger btn-sm mr-1" ><i   name="btn" value="Supprimer"  class="fas fa-trash"  ></i></button>

                          <button type="button" data-toggle="modal" data-target="#subscriptionModal" @click="editOffer(<?php echo e($index); ?>)" class="btn btn-sm btn-primary mr-1" ><i class="fas fa-edit"></i></button>

                          <button type="button" data-toggle="modal" data-target="#cFeeModal" @click="getClientFees(<?php echo e($offer->client_id); ?>,'<?php echo e($offer->client); ?>', '<?php echo e($offer->description); ?>')" class="btn btn-sm btn-primary mr-1" >Tarifs</button>

                        
                    


                          
                        </td>
                         <td><a  href="?search=<?php echo e($offer->client); ?>" > <?php echo e($offer->client); ?></a></td>
                        <td> <?php echo e($offer->subscription_type); ?></td>
                        <td>
                          <?php echo e($offer->description); ?>

                        </td>
                        <td>
                          <?php echo e($offer->cost); ?>

                        </td>

                        <td>
                          <?php echo e($offer->qty); ?>

                        </td>

                        <td>
                           <?php echo e($offer->duration); ?> jours
                        </td>

                        <td>
                           <?php echo e($offer->start); ?>

                        </td>
                         
                         <td>
                           <?php echo e($offer->end); ?>

                        </td>
                         <td><?php echo e($offer->commands->count()); ?></td>
                         <td><?php echo e($offer->qty-$offer->commands->count()); ?></td>
                         <td></td>
                         <td>
                           <?php $startDate =  date_create($offer->start)->format("Y-m-d"); $endDate = date_create($offer->end)->format('Y-m-d'); ?>
                          <a href="#" data-toggle="modal" data-target="#billModal" @click="generateBill(<?php echo e($offer->id); ?>, '<?php echo e($offer->description); ?>', '<?php echo e($offer->client); ?>', '<?php echo e(date_create($offer->end)->format('Y-m-d')); ?>', '<?php echo e(date_create($offer->start)->format('Y-m-d')); ?>', 'Entre le <?php echo e(date_create($offer->start)->format('d-m-Y')); ?> et le <?php echo e(date_create($offer->end)->format('d-m-Y')); ?>' )"> Générer</a></td>
                        
                      </tr>
                      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                     
                    </tbody>
                </table>
                <?php echo e($offers->links()); ?>

              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        </div>
      
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
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




  <div   class="modal fade" id="subscriptionModal"  tabindex="-1" role="dialog">
            <div  class="modal-dialog modal-lg" role="document">
                <div  class="modal-content">
                    <div class="modal-header">
                      <h5 @click="addProduct" class="modal-title editModalTitle">{{title}}</h5>
                        <a href="javascript:;" data-dismiss="modal">Fermer</a>
                        
                        

                    </div>
                    <div   class="modal-body">
                        <form method="post" enctype="multipart/form-data" :action="subscriptionAction" >
                            <?php echo csrf_field(); ?>

                            <input hidden v-model="id" name="id">
                            <input hidden type="" name="errorTrigger" v-model="errorTrigger">
                             


                            <div hidden>
                              <input  v-model="providerName" type="" name="">
                               <input require v-model="provider" type="" name="provider">
                                <input v-model="provName" type="" name="">
                                <input v-model="provPhone" type="" name="">
                               <input v-model="provCity" type="" name="">
                                <input v-model="provAdresse" type="" name="">
                            </div>
                           

                             <div class="form-group">
                                <label>Type d'offre*</label>
                          <select @change="getSelectedOffers" v-model="offerType"  required  class="form-control" name="offer_type">
                             <option  value="">selectionner le type d'offre</option>
                             
                           <option 
                              <?php if(old('offer_type') == 'MAD'): ?> selected <?php endif; ?>
                            value="MAD">MAD</option>

                             <option 
                              <?php if(old('offer_type') == 'DISTRIBUTION'): ?> selected <?php endif; ?>
                            value="DISTRIBUTION">DISTRIBUTION</option>
                                               
                        </select>
                            <?php if ($errors->has('offer_type')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('offer_type'); ?>
                            <span class="invalid-feedback" role="alert">
                            <strong><?php echo e($message); ?></strong>
                                </span>
                              <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>
                                
                            </div>

                              <div v-if="selectedOffers.length > 0" class="form-group">
                                <label>Offre*</label>
                          <select @change="fillOfferFields"   v-model="offer"  required  class="form-control" >
                             <option  value="">selectionner Une d'offre</option>
                             
                           <option v-for="(selectedOffer, index) in selectedOffers"
                              
                            :value="index">{{selectedOffer.nom}}</option>

                            
                                               
                        </select>

                        <input hidden type="" name="offer" v-model="chosenOffer">
                            <?php if ($errors->has('offer_type')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('offer_type'); ?>
                            <span class="invalid-feedback" role="alert">
                            <strong><?php echo e($message); ?></strong>
                                </span>
                              <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>
                                
                            </div>



                            
                           
                           <div  class="form-group">
                            <label class="form-label ">Zones </label>
                              <select  data-style="btn-dark" required name="zones[]" v-model="zones" title="Choisir Zones..." id="zone-select" class="select2 form-control" multiple="multiple" data-placeholder="selectionner livreur(s)" >
                               
                                 <?php $__currentLoopData = $fees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                  <option value="<?php echo e($fee->id); ?>"><?php echo e($fee->destination); ?></option>
                                 <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                 </select>
                                 <?php if ($errors->has('zone')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('zone'); ?>
                                   <span class="invalid-feedback" role="alert">
                               <strong><?php echo e($message); ?></strong>
                                </span>
                              <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>
                          </div>





                             <div class="form-group">
                              <div class="bg-warning" style="font-weight: bold; color: black;">{{clientTip}}</div>

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
                                
                            </div>



                            <div v-if="selectedSuggestion == 'SWU' ">
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
    <span class="input-group-text" id="">Ville/Commune*</span>
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
    <span class="input-group-text" id="basic-addon1">Adresse*</span>
  </div>
      <input v-model="provAdresse" id="povadresse" maxlength="150"     class="form-control" type="text" placeholder="Adresse du client" aria-label="Client" aria-describedby="basic-addon1" >
      </div>
                            </div>





                            <div class="form-group">
                                <label>Description*</label>
                                <input value="<?php echo e(old('description')); ?>" v-model="description" name="description"  autocomplete="off" placeholder="Saisir la description" class="form-control border border-primary" type="" >

                                <?php if ($errors->has('description')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('description'); ?>
                            <span class="invalid-feedback" role="alert">
                            <strong><?php echo e($message); ?></strong>
                                </span>
                              <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>
                                
                            </div>

                             <div class="form-group">
                                <label>Durée*</label>
                                <input  value="<?php echo e(old('duration')); ?>" v-model="duration" name="duration"  autocomplete="off" placeholder="Durée en jours" class="form-control border border-primary" type="number" >

                                <?php if ($errors->has('duration')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('duration'); ?>
                            <span class="invalid-feedback" role="alert">
                            <strong><?php echo e($message); ?></strong>
                                </span>
                              <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>
                                
                            </div>



                             <div class="form-group">
                                <label>Date de début*</label>
                                <input  value="<?php echo e(old('start')); ?>" v-model="startDate" name="start"  autocomplete="off"  class="form-control border border-primary" type="date" >

                                <?php if ($errors->has('start')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('start'); ?>
                            <span class="invalid-feedback" role="alert">
                            <strong><?php echo e($message); ?></strong>
                                </span>
                              <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>
                                
                            </div>




                            

                            <div class="form-group">
                                <label>Coût*</label>
                                <input required value="<?php echo e(old('cost')); ?>" v-model="cost" name="cost" autocomplete="off" placeholder="Saisir le coût de l'offre" class="form-control border border-primary" type="" >
                                <?php if ($errors->has('cost')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('cost'); ?>
                            <span class="invalid-feedback" role="alert">
                            <strong><?php echo e($message); ?></strong>
                                </span>
                              <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>
                            </div>

                             <div class="form-group">
                                <label>Quantité*</label>
                                <input required v-model="qty" required name="qty" value="<?php echo e(old('qty')); ?>" autocomplete="off" placeholder="Saisir Quantité de l'offre" class="form-control border border-primary" type="number" >

                                <?php if ($errors->has('contact')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('contact'); ?>
                            <span class="invalid-feedback" role="alert">
                            <strong><?php echo e($message); ?></strong>
                                </span>
                              <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>
                                
                            </div>
                             <div hidden class="form-group">
                                <label>Coût supplementaire standard</label>
                                <input v-model="supSend" name="sup_send" value="<?php echo e(old('sup_send')); ?>"  autocomplete="off" placeholder="" class="form-control border border-primary" type="number" >

                                <?php if ($errors->has('sup_send')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('sup_send'); ?>
                            <span class="invalid-feedback" role="alert">
                            <strong><?php echo e($message); ?></strong>
                                </span>
                              <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>
                                
                            </div>

                            <div hidden class="form-group">
                                <label>Coût supplementaire Express</label>
                                <input v-model="supSendUrgent" name="sup_sendurgent" value="<?php echo e(old('sup_sendurgent')); ?>"  autocomplete="off" placeholder="" class="form-control border border-primary" type="number" >

                                <?php if ($errors->has('sup_sendurgent')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('sup_sendurgent'); ?>
                            <span class="invalid-feedback" role="alert">
                            <strong><?php echo e($message); ?></strong>
                                </span>
                              <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>
                                
                            </div>

                              <div hidden class="form-group">
                                <label>Coût supplementaire Banlieu</label>
                                <input v-model="supSendRingroad" name="sup_sendringroad" value="<?php echo e(old('sup_sendringroad')); ?>"  autocomplete="off" placeholder="" class="form-control border border-primary" type="number" >

                                <?php if ($errors->has('sup_sendringroad')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('sup_sendringroad'); ?>
                            <span class="invalid-feedback" role="alert">
                            <strong><?php echo e($message); ?></strong>
                                </span>
                              <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>
                                
                            </div>

                            <div hidden class="form-group">
                                <label>Coût supplementaire Intérieur</label>
                                <input v-model="supSendRingroad" name="sup_sendringroad" value="<?php echo e(old('sup_sendringroad')); ?>"  autocomplete="off" placeholder="" class="form-control border border-primary" type="number" >

                                <?php if ($errors->has('sup_sendringroad')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('sup_sendringroad'); ?>
                            <span class="invalid-feedback" role="alert">
                            <strong><?php echo e($message); ?></strong>
                                </span>
                              <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>
                                
                            </div>

                             
                          
                           <div :hidden="offerType != 'MAD'" class="form-group">
                            <label class="form-label ">Coursier </label>
                              <select data-style="btn-dark" :disabled="offerType != 'MAD'" :required="offerType == 'MAD'" v-model="livreurs" title="Choisir livreurs..." id="livreur-select" class="select2 form-control" multiple="multiple" data-placeholder="selectionner livreur(s)"  name="livreurs[]">
                               
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

                            


                            <button type="submit" class="btn btn-primary">Enregistrer</button>
                        </form>
                    
                </div>
            </div>
        </div>

      </div>


        <div   class="modal fade" id="billModal"  tabindex="-1" role="dialog">
            <div  class="modal-dialog" role="document">
                <div  class="modal-content">
                    <div class="modal-header">
                      <h5 @click="addProduct" class="modal-title editModalTitle">Générer facture</h5>
                        <a href="javascript:;" data-dismiss="modal">Fermer</a>
                        
                        

                    </div>
                    <div v-if="billInfo.length > 0"   class="modal-body">
                      <h3 >{{billInfo[0]["description"]}} - {{billInfo[0]["subscriber"]}}</h3>
                        <form target="_blank"  action="bill" >
                            <?php echo csrf_field(); ?>

                            <input hidden :value="billInfo[0]['id']" name="id">
                           
                           <div class="form-group">
                            <label class="form-label">{{billInfo[0]["period"]}}</label>
                            <br>
                            <button type="button" @click="billDate = billInfo[0]['max']" class="btn btn-primary">Toute la durée de l'abonnement</button>
                             <input v-model ="billDate" id="billdate" :min="billInfo[0]['min']" :max="billInfo[0]['max']" class="form-control" type="date" name="billdate">
                           </div>

                            <button type="submit" class="btn btn-success">Confirmer</button>
                            
                        </form>
                    
                </div>
            </div>
        </div>

      </div>

      <div   class="modal fade" id="bulkBillModal"  tabindex="-1" role="dialog">
            <div  class="modal-dialog" role="document">
                <div  class="modal-content">
                    <div class="modal-header">
                      <h5 @click="addProduct" class="modal-title editModalTitle">Générer factures</h5>
                        <a href="javascript:;" data-dismiss="modal">Fermer</a>
                        
                        

                    </div>
                    <div v-if="bulkBillInfo.length > 0"   class="modal-body">
                      <h3 ></h3>
                        <form target="_blank"  action="bulkbill" >
                            <?php echo csrf_field(); ?>
                          <div class="mb-2 border row" v-for="info in bulkBillInfo">
                            <div class="col">
                            <input hidden :value="info['id']" name="ids[]">
                            <h5>{{info["description"]}} - {{info["subsciber"]}}</h5>
                           <div class="form-group">
                            <label class="form-label">{{info["period"]}}</label>
                            <br>
                            <button type="button" @click="billDate = info['max']" class="btn btn-primary">Toute la durée de l'abonnement</button>
                             <input required  :min="info['min']" :max="info['max']" class="form-control" type="date" name="billdates[]">
                           </div>
                           </div>
                          </div>
                            <button type="submit" class="btn btn-success">Confirmer</button>
                            
                        </form>
                    
                </div>
            </div>
        </div>

      </div>


      <div   class="modal fade" id="confirmModal"  tabindex="-1" role="dialog">
            <div  class="modal-dialog" role="document">
                <div  class="modal-content">
                    <div class="modal-header">
                      <h5 @click="addProduct" class="modal-title editModalTitle">{{title}}</h5>
                        <a href="javascript:;" data-dismiss="modal">Fermer</a>
                        
                        

                    </div>
                    <div   class="modal-body">
                        <form method="post" enctype="multipart/form-data" action="deleteoffer" >
                            <?php echo csrf_field(); ?>

                            <input hidden v-model="id" name="id">
                           

                            <button type="submit" class="btn btn-danger">Confirmer</button>
                            <button type="button" class="btn btn-primary">Annuler</button>
                        </form>
                    
                </div>
            </div>
        </div>

      </div>


      <div   class="modal fade" id="clientFeeModal"  tabindex="-1" role="dialog">
            <div  class="modal-dialog" role="document">
                <div  class="modal-content">
                    <div class="modal-header">
                      <h5  class="modal-title ">{{cTitle}}</h5>
                        <a href="javascript:;" data-dismiss="modal">Fermer</a>
                        
                        

                    </div>
                    <div   class="modal-body">
                        <?php if(session("client_fee")): ?>
                        <?php $__currentLoopData = session("client_fee"); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cfee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="row">
                          <div class="col"><?php echo e($cfee->destination); ?></div>

                          <div class="col">
                            <input id="cfee<?php echo e($cfee->price); ?>" type="number" value="<?php echo e($cfee->price); ?>" name="">
                          </div>

                          <div class="col" @click="changeClientFee('<?php echo e($cfee->id); ?>')"><button>Modifier</button></div>

                          <div class="col" @click="changeClientFee('<?php echo e($cfee->id); ?>')"><button>Modifier</button>
                          <span class="text-success" :id="'success'+cfee.id"></span>
                          </div>
                        </div>

                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>

                    
                </div>
            </div>
        </div>

      </div>






      <div   class="modal fade" id="cFeeModal"  tabindex="-1" role="dialog">
            <div  class="modal-dialog" role="document">
                <div  class="modal-content">
                    <div class="modal-header">
                      <h5  class="modal-title ">{{cTitle}}</h5>
                        <a href="javascript:;" data-dismiss="modal">Fermer</a>
                        
                        

                    </div>
                    <div   class="modal-body">
                        
                        <div v-if="cFees" v-for="cfee in cFees" class="row">
                          <div class="col">{{cfee.destination}}</div>

                          <div class="col">
                            <input :id="'cfee2'+cfee.id" type="number" :value="cfee.price" name="">
                          </div>

                          <div class="col" @click="changeCFee(cfee.id)"><button>Modifier</button>
                           <span class="text-success" :id="'csuccess'+cfee.id"></span>
                          </div>



                          
                        </div>

                        

                    
                </div>
            </div>
        </div>

      </div>



      <div   class="modal fade" id="cSubsModal"  tabindex="-1" role="dialog">
            <div  class="modal-dialog modal-lg" role="document">
                <div  class="modal-content">
                    <div class="modal-header">
                      <h5  class="modal-title ">{{cSubsTitle}}</h5>
                        <a href="javascript:;" data-dismiss="modal">Fermer</a>
                        
                        

                    </div>
                    <div   class="modal-body">
                        
                        <div v-if="cSubs" v-for="cSub in cSubs" class="row">
                          <div class="col">{{cSub.description}}</div>

                          <div class="col">
                            {{cSub.subscription_type}}
                          </div>

                          <div class="col" @click="changeCFee(cfee.id)">{{cSub.end}}
                          </div>



                          
                        </div>

                        

                    
                </div>
            </div>
        </div>

      </div>


       <button hidden id="addCostumerBtn" data-toggle="modal" data-target="#offerModal"></button>
</div>
<!-- ./wrapper -->


<script>

   const app = Vue.createApp({
    data() {
        return {

            clientTip: "Si vous avez dejà enregistré une course pour le client, commencez à taper son nom pour le selectionner. Si non cliquez sur 'Nouveau client'",
            providerName: "",
              showSuggestions: false,
              swu: [{"id":"SWU","created_at":"2023-06-20 06:37:52","updated_at":"2023-06-20 06:37:52","nom":"Nouveau client","phone":"","city":"","adresse":"","":null,"wme":null,"user_id":"","latitude":null,"longitude":null,"photo":null,"manager_id":null,"is_manager":null,"is_certifier":null,"is_collecter":null,"client_type":null,"cc_id":null}],
             filteredSuggestions: [],
             providers: <?php echo $providers; ?>,
          subscriptions: <?php echo $subscriptions; ?>,
          
          id: null,
          processing: null,
          success: "",
          editSuccess: "",
          livreurs: [],
        
          selected: null,
          subscriptionAction: "createsubscription",
          offerType: "",
           duration: null,
          description: "",
          cost : "",
          qty : "" ,
          nom: "",
          zones: "",
          offer: null,
          client: "",
          supSend : "",
          supSendUrgent : "",
          supSendRingroad : "",
          supSendOut : "",
          startDate: "",
          chosenOffer:"",
          title: "Ajouter offre",
          errorTrigger: "addOfferBtn",

          selectedOffers: [],


          selectedSuggestion: null,

        providerName: "",
          provider: "",
          provName: "",
        provPhone: "",
        provCity: "",
        provAdresse: "",
        cTitle: "",
        cFees: null,
        cSubs: null,
        cSubsTitle: "",
        billInfo: [],
        billDate:"", 
        bulkBillInfo:[] 
              }
    },
    methods:{

     generateBill(id, description, subscriber, maxDate, minDate, period){
       
       this.billInfo =  [{"id":id, "description":description, "subscriber":subscriber, "max":maxDate, "min":minDate, "period": period}]
     },

     generateBulkBill() {
      // Update the checkedItems object when a checkbox changes
      
      
    },
     getClientSubs(id, client){
     var vm = this
     this.cSubs = null

     
     this.cSubsTitle = "Abonnement " + " Client: "+client+ " "+id

     this.processing = 1

    
      axios.post('/getsubs', {
                
                id:id,
                
                
                _token: CSRF_TOKEN
      })
    
             
      .then(function (response) {
        vm.cSubs = response.data.subscriptions
      })
      .catch(function (error) {
         vm.processing = null
        console.log(error);
        alert("Une erreur s'est produite")
      });
    
    },  

    getSelectedOffers(){
      this.selectedOffers = []
      if(this.offerType == "MAD"){
        this.selectedOffers = <?php echo $mads; ?>

      }

      if(this.offerType == "DISTRIBUTION"){
        this.selectedOffers = <?php echo $distribs; ?>

      }
    },
    handleProvInput() {
      this.showProvSuggestions = true;
      const inputText = this.providerName.toLowerCase().trim();
      this.filteredProvSuggestions = this.providers.filter((suggestion) =>
        suggestion.nom.toLowerCase().startsWith(inputText)
      );
    },

         selectProvSuggestion(suggestion) {
          this.selectedSuggestion = suggestion.id
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
       
             for(i=0; i<this.allFees.length;i++){
               if(this.allFees[i].destination.toLowerCase() == suggestion.city.toLowerCase()){
                   this.fee = this.allFees[i].id
               }
             }
         }
   
      this.showProvSuggestions = false;
    },


    fillOfferFields(){
            this.offerType= this.selectedOffers[this.offer].offer_type
            this.description= this.selectedOffers[this.offer].description
            this.cost = this.selectedOffers[this.offer].cost
            this.qty = this.selectedOffers[this.offer].qty
            this.duration = this.selectedOffers[this.offer].duration
            this.id = this.selectedOffers[this.offer].id
            this.nom = this.selectedOffers[this.offer].nom
            this.zones = this.selectedOffers[this.offer].offer_zones
            this.chosenOffer = this.selectedOffers[this.offer].nom
    }, 


    editOffer(index){
           this.offerAction= "editoffer"
            this.offerType= this.subscriptions[index].offer_type
            this.description= this.subscriptions[index].description
            this.cost = this.subscriptions[index].cost
            this.qty = this.subscriptions[index].qty
            this.duration = this.subscriptions[index].duration
            this.id = this.subscriptions[index].id

          

            this.title = "Modifier offre "+ this.subscriptions[index].description

            this.errorTrigger = "edit"+index
    },

    
    addSubscription(){
            this.subscriptionAction= "createsubscription"
            this.offer_type= ""
            this.offer = ""
            this.description= ""
            this.cost = ""
            this.qty = "" 
            this.supSend = ""
            this.supSendUrgent = ""
            this.supSendRingroad = ""
            this.supSendOut = ""

            this.title = "Nouvelle souscription"
            this.errorTrigger = "addOfferBtn"
    },


    deleteOffer(index){
           
            
            this.id = this.offers[index].id
             this.title = "Supprimer "+ this.subscriptions[index].description
    },

     confirmDelete(id){
    vm = this
    axios.post('/deletecostumer', {
    id: id,

    _token: CSRF_TOKEN,
  })

         
  .then(function (response) {
    vm.products = response.data.updatedProducts
    
  })
  .catch(function (error) {
    console.log(error);
  });
    },  
    getSelected(index){
      this.selected = index
    },

    updatePrice(){
     var vm = this

     this.processing = 1
    axios.post('/updateprice', {
            
            id:vm.offers[vm.selected].id,
            description: vm.description,
            price: vm.price,
            name:vm.name,
           
            
            _token: CSRF_TOKEN
  })

         
  .then(function (response) {
    vm.success = "Prix enregistré"
     vm.processing = null
     vm.offers = response.data.offers
  })
  .catch(function (error) {
     vm.processing = null
    console.log(error);
    alert("Une erreur s'est produite")
  });
    },


changeClientFee(id){
     var vm = this

     id = id
     fee = Number(document.getElementById('cfee'+id).value)

     this.processing = 1

     if(fee > 0)
    {
      axios.post('/changecfee', {
                
                id:id,
                fee: fee,
                
                _token: CSRF_TOKEN
      })
    
             
      .then(function (response) {
        document.getElementById('cfee'+id).value = fee
        document.getElementById('success'+id).innerHTML = "Effectué"
      })
      .catch(function (error) {
         vm.processing = null
        console.log(error);
        alert("Une erreur s'est produite")
      });
    }
    },



    changeCFee(id){
     var vm = this

     id = id
     fee = Number(document.getElementById('cfee2'+id).value)

     this.processing = 1

     if(fee > 0)
    {
      axios.post('/changecfee', {
                
                id:id,
                fee: fee,
                
                _token: CSRF_TOKEN
      })
    
             
      .then(function (response) {
        document.getElementById('cfee2'+id).value = fee
        document.getElementById('csuccess'+id).innerHTML = "Effectué"
      })
      .catch(function (error) {
         vm.processing = null
        console.log(error);
        alert("Une erreur s'est produite")
      });
    }
    },




    getClientFees(id, client, subscription){
     var vm = this
     this.cFees = null

    
     this.cTitle = "Tarif "+subscription + ". Client: "+client

     this.processing = 1

    
      axios.post('/getfees', {
                
                id:id,
                
                
                _token: CSRF_TOKEN
      })
    
             
      .then(function (response) {
        vm.cFees = response.data.cfees
      })
      .catch(function (error) {
         vm.processing = null
        console.log(error);
        alert("Une erreur s'est produite")
      });
    
    },

     updateTarif(id){
     var vm = this
     description = document.getElementById("desc"+id).value
     price = document.getElementById("prc"+id).value
     name = document.getElementById("name"+id).value
     this.processing = 1
    axios.post('/updatetarif', {
            
            id:id,
            description: description,
            price: price,
            name:name,
           
            
            _token: CSRF_TOKEN
  })

         
  .then(function (response) {
    vm.editSuccess = response.data.editSuccess
     vm.processing = null
     vm.offers = response.data.offers
    
  })
  .catch(function (error) {
     vm.processing = null
    console.log(error);
    alert("Une erreur s'est produite")
  });
    },





     deleteTarif(id){
     var vm = this
     
     this.processing = 1
    axios.post('/deletetarif', {
            
            id:id,
            
           
            
            _token: CSRF_TOKEN
  })

         
  .then(function (response) {
    vm.editSuccess = response.data.editSuccess
     vm.processing = null
     vm.offers = response.data.offers
     
  })
  .catch(function (error) {
     vm.processing = null
    console.log(error);
    alert("Une erreur s'est produite "+ id)
  });
    },

    },
   computed:{
   
    
}
});

  const mountedApp = app.mount('#app')     
</script>
<!-- jQuery -->
<script src="../../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="../../dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../../dist/js/demo.js"></script>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<script type="text/javascript">var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');</script>
<script src="../../plugins/select2/js/select2.full.min.js"></script>
<script type="text/javascript">
  $('#livreur-select').select2();
    $('#zone-select').select2();
     $(".offerbtn").click( function() {
             $(".bulkBillForm").html("");
             var ids = [];
              $(".offer_chk:checked").each(function() {  

                  $(".bulkBillForm").append($(this).val());
                  ids.push($(this).attr('data-id'));
              });


              if(ids.length > 0){
                $(".bulkBillForm").submit();
              }
  });
</script>
</body>
</html>
<?php /**PATH /var/www/html/admin/resources/views/subscriptions.blade.php ENDPATH**/ ?>