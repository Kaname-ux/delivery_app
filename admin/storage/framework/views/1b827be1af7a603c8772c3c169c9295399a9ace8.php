<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
  <title>Payements</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
  <!-- SweetAlert2 -->
  <link rel="stylesheet" href="../../plugins/sweetalert2/sweetalert2.min.css">
  <!-- Toastr -->
  <link rel="stylesheet" href="../../plugins/toastr/toastr.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../../dist/css/adminlte.min.css">
</head>
<body class="hold-transition sidebar-mini">
  <script src="https://unpkg.com/vue@3"></script> 
<div class="wrapper"  id="app">
 <div class="modal fade " id="payModal" tabindex="-1"  role="dialog">
            <div  class="modal-dialog modal-lg" role="document">
                <div  class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title">Detail Payements </h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                       
                         
                    </div>
                 
                    <div   class="modal-body">
                        <div class="action-sheet-content " >
                          <?php if(session('by_livreur')): ?>
                            
                          <h4>Par livreur</h4>

                          <?php $__currentLoopData = session('by_livreur'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $one): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                             <div class="row mb-2 border border-primary">
                              <div class="col"><?php echo e($one->livreur->nom); ?></div>
                              <div class="col"><span style="font-weight: bold; color: black;"><?php echo e($one->montant); ?></span></div>
                               
                             </div>
                             <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                              <?php
                             $nom = session('client')->nom;
                             $delivdate = date_format(date_create($day), "d-m-Y");

                             ?>

                            <hr>
                            <button onclick="printElement('clientpoint')" class="btn btn-light mr-2"><i class="fas fa-print"></i>Imprimer point </button>
                          <button class="btn btn-light" onclick="exportToPDF('clientpoint', 'point_<?php echo e($nom); ?>_<?php echo e($delivdate); ?>')" >Exporter en PDF</button>
                           
                             <div id="" style="font-size: 20px;">
                               <p class="mb-2">
                        <img src="dist/img/AdminLTELogo.png" width="48" height="48" alt="image" class="imaged w48">
                        <?php echo e(config("app.name")); ?> - <?php echo e(config("app.phone")); ?> - <?php echo e(config("app.adresse")); ?>

                    </p>
                    <hr>
                             <div  class="row mb-2" >
                              <div class="col">
                                Client: <span style="font-weight: bold; color: black;"><?php echo e(session('client')->nom); ?></span>
                              </div>
                             
                            </div>
                             <div  class="row mb-2" >
                              <div class="col">
                                Date: <span style="font-weight: bold; color: black;"><?php echo e(date_format(date_create($day), "d-m-Y")); ?></span>
                              </div>
                              <div class="col">
                                Total à verser: <span style="font-weight: bold; color: black;"><?php echo e(session('unpayed_commands')->sum('montant')); ?></span>
                              </div>

                              <div class="col">
                                Colis non livrés: <span style="font-weight: bold; color: black;"><?php echo e(session('undelivered')->count()); ?></span>
                              </div>
                            </div>
                           <?php if(session('unpayed_commands')->count() > 0): ?>
                            <h4>Commandes livrées</h4>
                            <?php $__currentLoopData = session('unpayed_commands'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cmd): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="border border-primary mb-2">
                             <div class="row  ">
                              <div class="col"><span style="font-weight: bold; color: black;">#<?php echo e($cmd->id); ?> : <?php echo e($cmd->description); ?></span></div>
                              <div class="col">Montant: <span style="font-weight: bold; color: black;"><?php echo e($cmd->montant); ?></span></div>
                               
                             </div>
                             

                              
                             </div>
                             <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                             <?php endif; ?>
                             <div class="mb-2"></div>
                             <?php if(session('undelivered')->count()>0): ?>
                             <h4>Commandes non livrées</h4>
                            <?php $__currentLoopData = session('undelivered'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cmdu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="border border-primary mb-2">
                             <div class="row  ">
                              <div class="col"><span style="font-weight: bold; color: black;">#<?php echo e($cmdu->id); ?> : <?php echo e($cmdu->description); ?></span></div>
                              <div class="col">Montant: <span style="font-weight: bold; color: black;"><?php echo e($cmdu->montant); ?></span></div>
                               
                             </div>
                             <div class="row mb-2">
                               <div class="col text-warning">
                               <?php if($cmdu->note->count()>0): ?>
                                  <?php echo e($cmdu->note->last()->description); ?>

                                  <?php endif; ?>
                               </div>
                             </div>
                             
                             <div class="row">
                             
                                 <div class="form-group col mb-2">
                           <label class="form-label">
                               Date livraison
                              </label>
                                <input 
                              type="date" id="date<?php echo e($cmdu->id); ?>" @change="updateCmd('<?php echo e($cmdu->id); ?>', 'date<?php echo e($cmdu->id); ?>', '/reportcmd' )" name="delivery_date" value="<?php echo e($day); ?>" class="form-control"  id="cmddate" >
     
                                   </div>
                              

                               
                                 <div class="form-group col  mb-2">
                           <label class="form-label">
                               Status
                              </label>
                              <select id="status<?php echo e($cmdu->id); ?>"  @change="updateCmd('<?php echo e($cmdu->id); ?>', 'status<?php echo e($cmdu->id); ?>', '/statuscmd' )" class="form-control">
                                <option  v-for="state in states" :selected="state.value == '<?php echo e($cmdu->etat); ?>'">{{state.text}}</option>
                              </select>
                                
     
                                   </div>


                                     <div class="form-group col  mb-2">
                           <label class="form-label">
                               Retour
                              </label>
                              <select id="retour<?php echo e($cmdu->id); ?>" @change="updateCmd('<?php echo e($cmdu->id); ?>', 'retour<?php echo e($cmdu->id); ?>', '/returncmd' )" class="form-control">
                                <option   v-for="retour in retours" :value="retour.value" :selected="retour.value == '<?php echo e($cmdu->retour); ?>'">{{retour.text}}</option>
                              </select>
                                
     
                                   </div>


                                       <div class="form-group col  mb-2">
                           <label class="form-label">
                               Livreur
                              </label>
                              <select id="livreur<?php echo e($cmdu->id); ?>" @change="updateCmd('<?php echo e($cmdu->id); ?>', 'livreur<?php echo e($cmdu->id); ?>', '/livreurcmd' )" class="form-control">
                                <?php $__currentLoopData = $livreurs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $livreur): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option   value="<?php echo e($livreur->id); ?>" <?php if($livreur->id == $cmdu->livreur_id): ?> selected <?php endif; ?> ><?php echo e($livreur->nom); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                              </select>
                                
     
                                   </div>
                                
                            
                               
                             </div>

                             <?php if($cmdu->retour == "retourne" && $cmdu->retour_by != null): ?>
                             <div class="row">
                                <div class="col">
                                Retouné par: <span style="font-weight: bold; color: black;"><?php echo e($cmdu->retour_by); ?></span>  le  <span style="font-weight: bold; color: black;"><?php echo e(date_create($cmdu->retour_at)->format("d-m-Y H:i:s")); ?></span>
                                </div>
                                 
                             </div>
                             <?php endif; ?>

                              
                             </div>
                             <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                             <?php endif; ?>
                          </div>
                         
                          <?php endif; ?>
                        </div>
                       
                      
                    </div>
                </div>
            </div>
        </div>


<div class="modal fade action-sheet  " id="doneModal" tabindex="-1" role="dialog">
            <div  class="modal-dialog" role="document">
                <div  class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4>Detail payment</h4> 
                       <span class="donee"></span> 
                       
                    
                     
                        

                    </div>
                    <div   class="modal-body doneModalBody">
                        
                   
                
                    </div>
                    
                </div>
            </div>
        </div>

    
<div class="modal fade " id="moneyModal" tabindex="-1" role="dialog">
            <div  class="modal-dialog modal-lg" role="document">
                <div  class="modal-content">
                    <div class="modal-header">
                      <h4>Detail recette</h4> 
                      <button type="button" class="close" data-dismiss="modal">Fermer</button>
                        
                      
                    </div>
                    <div   class="modal-body">
                        <?php if(session('by_client')): ?>
                           
                         
                          <h4>Par Client</h4>

                          <?php $__currentLoopData = session('by_client'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $two): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                             <div class="row mb-2 border border-primary">
                              <div class="col">
                                <?php if($two->client): ?>
                                <?php echo e($two->client->nom); ?>

                                <?php endif; ?>
                              </div>
                              <div class="col">Pour le client:<span style="font-weight: bold; color: black;"><?php echo e($two->montant); ?></span></div>
                              <div class="col">Recette livraison:<span style="font-weight: bold; color: black;"><?php echo e($two->livraison); ?></span></div>

                              <div class="col">Total:<span style="font-weight: bold; color: black;"><?php echo e($two->livraison+$two->montant); ?></span></div>
                               
                             </div>
                             <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            
                            @☺php
                            $nom = session('livreur')->nom;
                             $delivdate = date_format(date_create($day), "d-m-Y");
                            @endphp

                            <hr>
                           <button onclick="printElement('livreurpoint')" class="btn btn-light mr-2"><i class="fas fa-print"></i>Imprimer point </button>
                            <button class="btn btn-light" onclick="exportToPDF('livreurpoint', 'point_<?php echo e($nom); ?>_<?php echo e($delivdate); ?>')" >Exporter en PDF</button>
                             <div id="livreurpoint" style="font-size: 20px;">
                              <hr>
                           <p class="mb-2">
                        <img src="assets/img/logo-icon.png" alt="image" class="imaged w48">
                        <?php echo e(config("app.name")); ?> - <?php echo e(config("app.phone")); ?> - <?php echo e(config("app.adresse")); ?>

                    </p>
                    <hr>
                             <div  class="row mb-2" >
                              <div class="col">
                                Livreur: <span style="font-weight: bold; color: black;"><?php echo e(session('livreur')->nom); ?></span>
                              </div>
                             <div class="col">
                                Date: <span style="font-weight: bold; color: black;"><?php echo e(date_format(date_create($day), "d-m-Y")); ?></span>
                              </div>
                            </div>
                             
                            <div class="row mb-2">
                              <div class="col">
                                Encaisser pour les clients: <span style="font-weight: bold; color: black;"><?php echo e(session('unpayed_commands')->sum('montant')); ?></span>
                              </div>

                               <div class="col">
                                Recette livrason: <span style="font-weight: bold; color: black;"><?php echo e(session('unpayed_commands')->sum('livraison')); ?></span>
                              </div>
                              <div class="col">
                                Total: <span style="font-weight: bold; color: black;"><?php echo e(session('unpayed_commands')->sum('montant')+session('unpayed_commands')->sum('livraison')); ?></span>
                              </div>
                            </div>

                          
                            <h2>Commandes</h2>
                            <?php $__currentLoopData = session('unpayed_commands'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cmd): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="border border-primary mb-2">
                             <div class="row  ">
                              <div class="col"><span style="font-weight: bold; color: black;">#<?php echo e($cmd->id); ?> : <?php echo e($cmd->description); ?></span></div>
                              <div class="col">Montant: <span style="font-weight: bold; color: black;"><?php echo e($cmd->montant); ?></span></div>
                              <div class="col">Livraison: <span style="font-weight: bold; color: black;"><?php echo e($cmd->livraison); ?></span></div>
                               <div class="col">Total: <span style="font-weight: bold; color: black;"><?php echo e($cmd->montant+$cmd->livraison); ?></span></div>
                             </div>
                             

                              
                             </div>
                             <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                           
                          </div>
                          <?php endif; ?>
                   
                
                    </div>
                    
                    
                </div>
            </div>
        </div>
      


      <div class="modal fade " id="receiptModal" tabindex="-1" role="dialog">
            <div  class="modal-dialog modal-lg" role="document">
                <div  class="modal-content">
                    <div class="modal-header">
                      <h4>Reçu de versement</h4> 
                      <button type="button" class="close" data-dismiss="modal">Fermer</button>
                        
                      
                    </div>
                    <div   class="modal-body">
                        <?php if(session('payed_commands')): ?>
                           
                         
                           <?php
                          $nom = session('singleinfo')->client->nom;
                          $delivdate = date_format(date_create($day), "d-m-Y");
                           ?>
                            

                            <hr>
                             <button onclick="printElement('receipt')" class="btn btn-light mr-2"><i class="fas fa-print"></i>Imprimer point </button>
                            <button class="btn btn-light" onclick="exportToPDF('receipt', 'point_<?php echo e($nom); ?>_<?php echo e($delivdate); ?>')" >Exporter en PDF</button>
                             <div id="receipt" style="font-size: 20px;">
                              
                              <hr>
                           <p class="mb-2">
                        <img src="assets/img/logo-icon.png" alt="image" class="imaged w48">
                        <?php echo e(config("app.name")); ?> - <?php echo e(config("app.phone")); ?> - <?php echo e(config("app.adresse")); ?>

                    </p>
                    <hr>
                    <h2>Reçu de versement</h2>
                             <div  class="row mb-2" >
                              <div class="col">
                                Client: <span style="font-weight: bold; color: black;"><?php echo e(session('singleinfo')->client->nom); ?></span>
                              </div>
                             <div class="col">
                                Date: <span style="font-weight: bold; color: black;"><?php echo e(date_format(date_create($day), "d-m-Y")); ?></span>
                              </div>
                               <div class="col">
                                Code: <span style="font-weight: bold; color: black;"><?php echo e(session('singleinfo')->cashedback_key); ?></span>
                              </div>
                            </div>
                             
                            <div class="row mb-2">
                              
                              <div class="col">
                                Total: <span style="font-weight: bold; color: black;"><?php echo e(session('payed_commands')->sum('montant')); ?></span>
                              </div>
                            </div>

                          
                            <h2>Commandes</h2>
                            <?php $__currentLoopData = session('payed_commands'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cmd): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="border border-primary mb-2">
                             <div class="row  ">
                              <div class="col"><span style="font-weight: bold; color: black;">#<?php echo e($cmd->id); ?> : <?php echo e($cmd->description); ?></span></div>
                              <div class="col">Montant: <span style="font-weight: bold; color: black;"><?php echo e($cmd->montant); ?></span></div>
                              
                             </div>
                             

                              
                             </div>
                             <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                           
                          </div>
                          <?php endif; ?>
                   
                
                    </div>
                    
                    
                </div>
            </div>
        </div>
        


        <div class="modal fade " id="rReceiptModal" tabindex="-1" role="dialog">
            <div  class="modal-dialog modal-lg" role="document">
                <div  class="modal-content">
                    <div class="modal-header">
                      <h4>Reçu de versement</h4> 
                      <button type="button" class="close" data-dismiss="modal">Fermer</button>
                        
                      
                    </div>
                    <div   class="modal-body">
                        <?php if(session('payed_recettes')): ?>
                           
                         
                         
                            
                             <?php
                             $nom = session('singleinfo')->livreur->nom;
                             $delivdate = date_format(date_create($day), "d-m-Y");

                             ?>
                            

                            <hr>
                            <button onclick="printElement('recettereceipt')" class="btn btn-light mr-2"><i class="fas fa-print"></i>Imprimer point </button>
                          <button class="btn btn-light" onclick="exportToPDF('recettereceipt', 'point_<?php echo e($nom); ?>_<?php echo e($delivdate); ?>')" >Exporter en PDF</button>
                             <div id="recettereceipt" style="font-size: 20px;">
                              
                              <hr>
                           <p class="mb-2">
                        <img src="dist/img/AdminLTELogo.png" alt="image" class="imaged w48">
                        <?php echo e(config("app.name")); ?> - <?php echo e(config("app.phone")); ?> - <?php echo e(config("app.adresse")); ?>

                    </p>
                    <hr>
                    <h2>Reçu de d'encaissement</h2>
                             <div  class="row mb-2" >
                              <div class="col">
                                livreur: <span style="font-weight: bold; color: black;"><?php echo e(session('singleinfo')->livreur->nom); ?></span>
                              </div>
                             <div class="col">
                                Date: <span style="font-weight: bold; color: black;"><?php echo e(date_format(date_create($day), "d-m-Y")); ?></span>
                              </div>
                               <div class="col">
                                Code: <span style="font-weight: bold; color: black;"><?php echo e(session('singleinfo')->cashkey); ?></span>
                              </div>
                            </div>
                             
                            <div class="row mb-2">
                              <div class="col">
                                Pour les clients: <span style="font-weight: bold; color: black;"><?php echo e(session('payed_recettes')->sum('montant')); ?></span>
                              </div>
                              <div class="col">
                               Livraison: <span style="font-weight: bold; color: black;"><?php echo e(session('payed_recettes')->sum('livraison')); ?></span>
                              </div>
                              <div class="col">
                                Total: <span style="font-weight: bold; color: black;"><?php echo e(session('payed_recettes')->sum('montant')+session('payed_recettes')->sum('livraison')); ?></span>
                              </div>
                            </div>

                          
                            <h2>Commandes</h2>
                            <?php $__currentLoopData = session('payed_recettes'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cmd): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="border border-primary mb-2">
                             <div class="row  ">
                              <div class="col"><span style="font-weight: bold; color: black;">#<?php echo e($cmd->id); ?> : <?php echo e($cmd->description); ?></span></div>
                              <div class="col">Montant: <span style="font-weight: bold; color: black;"><?php echo e($cmd->montant); ?></span></div>
                              <div class="col">Montant: <span style="font-weight: bold; color: black;"><?php echo e($cmd->livraison); ?></span></div>

                               <div class="col">Total: <span style="font-weight: bold; color: black;"><?php echo e($cmd->livraison+$cmd->montant); ?></span></div>
                              
                             </div>
                             

                              
                             </div>
                             <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                           
                          </div>
                          <?php endif; ?>
                   
                
                    </div>
                    
                    
                </div>
            </div>
        </div>
    <?php echo $__env->make("includes.navbar", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
               <?php if(session('status')): ?>
                        <div class="alert alert-success" role="alert">
                            <?php echo e(session('status')); ?>

                        </div>
                    <?php endif; ?>
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>
              Payements
             
            </h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="/dashboadr">Home</a></li>
              <li class="breadcrumb-item active">Payements</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <?php if(session('status')): ?>
        <div class="alert alert-success"><?php echo e(session("status")); ?></div>

 
 <?php endif; ?>
          <div class="section">
          <div class="row mb-2 mt-2">
                <div class="col-sm-3">
       <form action="" class="date_form">
        <div class="input-group mb-2">
       <div class="input-group-prepend">
    <span class="input-group-text" id="">Date </span>
  </div>
  <input hidden type="" name="route_day1" value="1">
<input  onchange="$('.date_form').submit()" required type="date" value="<?php echo e($day); ?>" name="route_day" class="form-control" type="text" id="cmddate" >
      <?php if ($errors->has('route_day')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('route_day'); ?>
      <span class="invalid-feedback" role="alert">
      <strong><?php echo e($message); ?></strong>
      </span>
      <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>
      </div>
    </form>
     </div>
     </div>  
   </div>


                <div class="section mt-2">
            <div class="section-title"></div>

           <div class="row">
          <div class="col-md-12">
            <div class="card card-primary card-tabs">
              <div class="card-header p-0 pt-1">
                <ul class="nav nav-tabs" id="custom-tabs-five-tab" role="tablist">
                  <li class="nav-item">
                    <a class="nav-link active" id="custom-tabs-five-overlay-tab" data-toggle="pill" href="#custom-tabs-five-overlay" role="tab" aria-controls="custom-tabs-five-overlay" aria-selected="true">POINS CLIENTS</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link " id="custom-tabs-five-overlay-recette-tab" data-toggle="pill" href="#custom-tabs-five-overlay-recette" role="tab" aria-controls="custom-tabs-five-overlay" aria-selected="true">POINTS LIVREURS</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-five-overlay-dark-tab" data-toggle="pill" href="#custom-tabs-five-overlay-dark" role="tab" aria-controls="custom-tabs-five-overlay-dark" aria-selected="false">HISTORIQUE VERSEMENT CLIENT</a>
                  </li>

                   <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-five-overlay-caisse-tab" data-toggle="pill" href="#custom-tabs-five-overlay-caisse" role="tab" aria-controls="custom-tabs-five-overlay-dark" aria-selected="false">HISTORIQUE ENCAISSEMENT LIVREUR</a>
                  </li>
                 
                </ul>
              </div>
              <div class="card-body table-responsive p-0">
                <div class="tab-content" id="custom-tabs-five-tabContent">
                  <div class="tab-pane fade show active" id="custom-tabs-five-overlay" role="tabpanel" aria-labelledby="custom-tabs-five-overlay-tab">
                    <div class="overlay-wrapper">
                      
                      <table class="table table-head-fixed text-nowrap">
                    <thead class=" text-primary">
                      <th>Client</th>
                      <th>
                     Montant
                      </th>
                      <th>
                        Colis non livrés
                      </th>
                      <th>
                        Action
                      </th>
                     
                     
                      
                    </thead>
                    <tbody>
                     
                      <?php $__currentLoopData = $clients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $clt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                      <?php if($clt->commands->where("delivery_date",  date_create($day))->where("etat", "termine")->where("cashedback_key", null)->sum("montant") -$clt->commands->where("delivery_date",  date_create($day))->where("etat", "termine")->where("cashedback_key", null)->sum("remise") > 0


                        || $clt->commands->where("delivery_date", date_create($day))->whereIn("etat", ["encours", "recupere", "en chemin", "annule"])->count() > 0): ?>
                      <tr>
                        
                        <td>
                          
                               
                            <?php echo e($clt->nom); ?>   
                               
                        </td>
                        <td>
                         <span style="font-weight: bold; font-size: 18px"><?php echo e(number_format($clt->commands->where("delivery_date",  date_create($day))->where("etat", "termine")->where("cashedback_key", null)->sum("montant") -$clt->commands->where("delivery_date",  date_create($day))->where("etat", "termine")->where("cashedback_key", null)->sum("remise")

                         , 0, " ", " ")); ?></span>

                         
                        </td>
                        <td> 
                          <span style="font-weight: bold; font-size: 18px">
                          <?php echo e($clt->commands->where("delivery_date",  date_create($day))->whereIn("etat", ["encours", "recupere", "en chemin", "annule"])->count()); ?>

                        </span>
                          
        </td>
                        
                     <td>
                        <?php if($clt->commands->where("delivery_date",  date_create($day))->where("etat", "termine")->where("cashedback_key", null)->sum("montant") -$clt->commands->where("delivery_date",  date_create($day))->where("etat", "termine")->where("cashedback_key", null)->sum("remise") > 0   || $clt->commands->where("delivery_date", date_create($day))->whereIn("etat", ["encours", "recupere", "en chemin", "annule"])->count() > 0): ?>
                           <form method="post" action="payedbylivreur">
                            <?php echo csrf_field(); ?>
                            <input hidden type="" name="payedbylivreur" value="1">
                            <input type="date" hidden name="delivdate" value="<?php echo e($day); ?>">
                            <input hidden type="" name="id" value="<?php echo e($clt->id); ?>">
                          <button    class="btn btn-primary">Voir detail</button>

                           <?php if($clt->commands->where("delivery_date",  date_create($day))->where("etat", "termine")->where("cashedback_key", null)->sum("montant") -$clt->commands->where("delivery_date",  date_create($day))->where("etat", "termine")->where("cashedback_key", null)->sum("remise") > 0): ?>
                           <button  id='allPay<?php echo e($clt->id); ?>' type="button" class='btn btn-success mt-1 payall' value='<?php echo e($clt->id); ?>'>Verser</button>
                           <?php endif; ?>
                         </form>
                           

                            <br>
                                 <span hidden id='allPayButtons<?php echo e($clt->id); ?>'>
                                   <form method="post" action="payall">   
                                <?php echo csrf_field(); ?>
                                <input hidden type="" name="montant" value='<?php echo e($clt->commands->where("delivery_date", $day)->where("etat", "termine")->where("cashedback_key", null)->sum("montant") -$clt->commands->where("delivery_date", $day)->where("etat", "termine")->where("cashedback_key", null)->sum("remise")); ?>'>
                                <div class="form-group"> 
                                <select name="method" class='form-control ' required >
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
        <input hidden type="" name="client_id" value="<?php echo e($clt->id); ?>">
        <input hidden type="" name="client_name" value="<?php echo e($clt->nom); ?>">
        <input hidden type="" name="delivdate" value="<?php echo e($day); ?>">

       <button  type="submit"  class='btn btn-info '  >
       
        <span  hidden class="spinner-border spinner-border-sm allPaySpinner<?php echo e($clt->id); ?>" role=status aria-hidden="true"></span><span class=sr-only></span>
       
       Confirmé</button>
       <button value='<?php echo e($clt->id); ?>'  class='btn btn-danger allPayCancel<?php echo e($clt->id); ?> allPayCancel'>Annuler</button>
      
          </form>   
          </span>          
          <?php endif; ?>  
                     </td>
                        
                      </tr>
                      <?php endif; ?>
                      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    
                    </tbody>
                   
                  </table>
                  
                    </div>
                  </div>
                  <div class="tab-pane fade" id="custom-tabs-five-overlay-dark" role="tabpanel" aria-labelledby="custom-tabs-five-overlay-dark-tab">
                    <div class="overlay-wrapper">

                       
                      <table class="table table-striped">
  <thead class=" text-primary">
   
    <th>Code versment</th>
    <th>Montant</th>
  
    <th>Action</th>
  
  </thead>

  <tbody>
      <?php $__currentLoopData = $payed_by_client; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $done2): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <tr>
      
      <td>
       
        <?php echo e($done2->cashedback_key); ?> 
        
      </td>
      <td><?php echo e($done2->montant); ?></td>  
      
      
            <td>
              <form method="post" class="mb-2" action="receipt">
                <?php echo csrf_field(); ?>
                <input hidden type="" name="cashedback_key" value="<?php echo e($done2->cashedback_key); ?>">
                 <input hidden type="" name="delivdate" value="<?php echo e($day); ?>">
               <button type="submit" class="btn btn-primary ">Reçu de versement</button> 
             
               </form>

                <form  method="post" action="cancelpay">
                <?php echo csrf_field(); ?>
                <input hidden type="" name="cashedback_key" value="<?php echo e($done2->cashedback_key); ?>">
                 
            
               <button onclick="return confirmSubmit()" type="submit" class="btn btn-danger">Annuler paiement</button>
          
               </form>
            </td>
     
    </tr>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

  </tbody>
</table>
                    </div>
                  </div>




                  <div class="tab-pane fade" id="custom-tabs-five-overlay-caisse" role="tabpanel" aria-labelledby="custom-tabs-five-overlay-dark-tab">
                    <div class="overlay-wrapper">
                 
                      <table class="table table-striped">
  <thead class=" text-primary">
   <th>Code Encaissement</th>
   
    <th>Recette livraison</th>
    <th>Encaissé pour les client</th>
    <th>Total</th>
    <th>Action</th>
  
  </thead>

  <tbody>
      <?php $__currentLoopData = $payed_by_livreur; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cash): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <tr>
     
      <td><?php echo e($cash->cashkey); ?> </td>
      <td><?php echo e($cash->livraison); ?></td>   
      
                <td>
                 <?php echo e($cash->montant); ?>

                </td>

                <td>
                 <?php echo e($cash->montant+$cash->livraison); ?>

                </td>
            <td>
               <form method="post" class="mb-2" action="moneyreceipt">
                <?php echo csrf_field(); ?>
                <input hidden type="" name="payed_key" value="<?php echo e($cash->cashkey); ?>">
                 <input hidden type="" name="delivdate" value="<?php echo e($day); ?>">
               <button type="submit" class="btn btn-primary ">Reçu d'encaissement</button> 
             
               </form>

                <form  method="post" action="cancelmoneypay">
                <?php echo csrf_field(); ?>
                <input hidden type="" name="payed_key" value="<?php echo e($cash->cashkey); ?>">
                 
             
               <button onclick="return confirmSubmit()" type="submit" class="btn btn-danger">Annuler encaissement</button>
          
               </form>
            </td>
     
    </tr>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

  </tbody>
</table>
                    </div>
                  </div>


                   <div class="tab-pane fade" id="custom-tabs-five-overlay-recette" role="tabpanel" aria-labelledby="custom-tabs-five-overlay-recette-tab">
                    <div class="overlay-wrapper">


                        <table class="table table-head-fixed text-nowrap">
                    <thead class=" text-primary">
                      <th>Livreur</th>
                      <th>
                     Recette livraison
                      </th>
                      <th>
                        Encaissé pour les clients
                      </th>
                      
                       <th>
                        Total
                      </th>

                      
                     <th>
                        Action
                      </th>
                     
                     
                      
                    </thead>
                    <tbody>
                      <?php if($recette->count()>0): ?>
                      <?php $__currentLoopData = $recette; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $money): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                      <tr>
                        
                        <td>
                          
                               
                                <?php echo e($money->livreur->nom); ?>

                               
                        </td>
                        <td>
                          <?php echo e($money->livraison); ?>

                        </td>

                        <td>
                         <?php echo e($money->montant); ?>

                       </td>
                       <td>
                       <strong>  <?php echo e($money->livraison+$money->montant); ?> </strong>

                           
                       </td>
                        <td> 
                           <form method="post" action="payedbyclient">
                            <?php echo csrf_field(); ?>
                            <input type="date" hidden name="delivdate" value="<?php echo e($day); ?>">
                            <input hidden type="" name="id" value="<?php echo e($money->livreur_id); ?>">
                            <input hidden type="" name="payedbyclient" value="1">
                          <button    class="btn btn-primary">Voir detail</button>
                          <button id='allMoney<?php echo e($money->livreur_id); ?>' type="button" class='btn btn-success mt-1 allMoney' value='<?php echo e($money->livreur_id); ?>' class="btn btn-primary mr-2">Encaisser</button>
                           
                         </form>
                      <span hidden id='allMoneyButtons<?php echo e($money->livreur_id); ?>'>
                          <form class="form-inline" action="moneypay" method="post">
                        <?php echo csrf_field(); ?>
                        <input hidden type="" name="money" value="">


                             <div class="form-group">
                              <select class="form-control" required>
                                <option value="">Moyen de paiement</option>
                                <option >Main à main</option>
                                <option >Mobile money</option>
                              </select>
                             </div>
                              <input hidden type="" name="livreur_id" value="<?php echo e($money->livreur->id); ?>">
                             <input hidden type="" name="client_name" value="<?php echo e($money->livreur->nom); ?>">
                          <input hidden type="" name="delivdate" value="<?php echo e($day); ?>">

                             <button  type="submit"  class='btn btn-info '  >
       
        <span  hidden class="spinner-border spinner-border-sm allMoneySpinner<?php echo e($money->livreur_id); ?>" role=status aria-hidden="true"></span><span class=sr-only></span>
       
       Confirmé</button>
       <button value='<?php echo e($money->livreur_id); ?>' type="button"  class='btn btn-danger allMoneyCancel<?php echo e($money->livreur_id); ?> allMoneyCancel'>Annuler</button>
                          </form>    
                        
                        
                         </span>

                         <!--  <button  value=" <?php $__currentLoopData = $money->livreur->commands->where('payed_at', NULL); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $command): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                           <div class='card mb-2'>
                                            <div class='card-body'>
                                              <div class='row'>
                                            Client: <?php if($command->client): ?> <?php echo e($command->client->nom); ?> <?php endif; ?>
                                            </div>
                                              <div class='row'>
                                            #<?php echo e($command->id); ?> - <?php echo e($command->description); ?>

                                            </div>
                                            <div class='row'>
                                            livraison: <?php echo e($command->livraison); ?>f<br>
                                            Encaissé pour le client: <?php echo e($command->montant-$command->remise); ?><br>
                                            Total: <?php echo e($command->montant-$command->remise-$command->livraison); ?>

                                            </div>
                                           </div>
                                         </div>
                                           <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>"  class="btn btn-primary moneydetail">Voir detail</button> -->


                                    

                                           

                     </td>
                     <td>
                      
                     </td>
                        
                       
                        
                      </tr>
                      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                      <?php endif; ?>
                    </tbody>
                   
                  </table>


                    </div>
                  </div>
                 
                </div>
              </div>
              <!-- /.card -->
            </div>
          </div>
        </div>

            <!-- * waiting tab -->



            <!-- paid tab -->
            <div class="tab-pane fade" id="paid" role="tabpanel">

                 <div class="section mt-2">
            <div class="section-title"></div>
            <div class="row mb-2">
                <div class="col-3">
            <form  autocomplete="off" id="date-form" action='?bydate' class=" form-inline">
                  <?php echo csrf_field(); ?>
            <div class="input-group  date">
                     
      <div class="input-group-prepend">
      <span class="input-group-text purple lighten-3" id="basic-text1"><i class="fas fa-calendar text-dark"
         aria-hidden="true"><?php echo e(date_create($day)->format('d-m-Y')); ?></i></span>
      </div>
      <input placeholder="Choisir une date"  id="day" class="form-control" type="text" onfocus="(this.type='date')" name="route_day">
      </div>
    </form>
    </div>
    </div>
            <div class="row">
               <?php $__currentLoopData = $payed_by_livreur; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $done): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
               
                    <div class="col-6 mb-2">
                        <div class="bill-box">
                            <div class="img-wrapper donee<?php echo e($done->id); ?>">
                              
                                <?php $__currentLoopData = $livreurs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $livreur2): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if($livreur2->id == $done->livreur_id): ?>
                                <?php echo e($livreur2->nom); ?>

                                <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                            </div>
                            
                            <div class="price"><?php echo e($done->montant); ?></div>
                            
                            <button data-done="<?php echo e($done->id); ?>" data-id="<?php echo e($done->livreur_id); ?>" data-montant="<?php echo e($done->montant); ?>" data-date=""  value="<?php echo e($done->observation); ?>"  class="btn btn-primary doneDetail">
                           <span  hidden class="spinner-border spinner-border-sm doneSpinner<?php echo e($done->id); ?>" role=status aria-hidden="true"></span><span class=sr-only></span>

                            DETAIL</button>


     


                        </div>
                    </div>
                
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        </div>


        </div>
    
            </div>
            <!-- * paid tab -->
          



        </div>

       
        <!-- /.card -->
      </div>
      <!-- /.container-fluid -->
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
</div>
<!-- ./wrapper -->



<script>

   const app = Vue.createApp({
    data() {
        return {
          delivery_date: <?php echo $day; ?>,
          states:[{"text":"Encours", "value":"encours"},{"text":"Livre", "value":"termine"},{"text":"Annule", "value":"annule"},],

          retours:[{"text":"Non retourné", "value":null},{"text":"Encours", "value":"encours"},{"text":"Retourné", "value":"retourne"},],
        }
},

  methods:{




   updateCmd(id, part, link){
     
    element = document.getElementById(part).value
    axios.post(link, {
           
            cmdid:id,
            part: element,
            
            _token: CSRF_TOKEN
  })

         
  .then(function (response) {
    alert("Action effectuée "+ element+ " " + id)
    
  

  })
  .catch(function (error) {
    
    console.log(error);
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
  <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.5.0-beta4/html2canvas.min.js"></script>

 <?php if(session('by_livreur')): ?>
 <script type="text/javascript">
    $("#payModal").modal("show");
 </script>
 
 <?php endif; ?>

<?php if(request()->has('route_day') && !request()->has('route_day2')): ?>
<script type="text/javascript">
    $("#custom-tabs-five-overlay-dark-tab").click();
</script>
<?php endif; ?>

<?php if(request()->has('route_day2')): ?>
<script type="text/javascript">
    $("#custom-tabs-five-overlay-caisse").click();
</script>
<?php endif; ?>

<?php if(request()->has('money')): ?>
<script type="text/javascript">
    $("#custom-tabs-five-overlay-recette-tab").click();
</script>
<?php endif; ?>

<div id="singlePayScript">
  
</div>

<script type="text/javascript">

  var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

  $(".moneydetail").click(function(){
    $('#moneyModal').modal('show');
    
   $('.moneyBody').html($(this).val());

  });
  $('.detail').click( function() {
   var livreur_id = $(this).val();
   
   $('#payModal').modal('show');
    
   $('.payBody').html('<span   class="spinner-border spinner-border paySpinner" role="status" aria-hidden="true"></span><span class="sr-only"></span>');


     $.ajax({
       url: 'paydetail',
       type: 'post',
       data: {_token: CSRF_TOKEN,livreur_id: livreur_id},
   
       success: function(response){
                 $('.payReturn').removeAttr('hidden');
                $('.payBody').html(response.display);
                $('.payTotal').html('<strong>Total:' +response.total + '</strong>');
                 $('.payLivreur').html(response.livreur);
                 $('#singlePayScript').html(response.single_pay_script);
              },
   error: function(response){
               
                alert('Une erruer s\'est produite');
              }
             
     });
   });



    $('.allPayConfirm').click( function() {
       var livreur_id = $(this).val();
       var method = $('.payMethod'+livreur_id).val();
       var curallPaybtns = $(this).data('allPayButtons');
    
   
   $('.allPaySpinner'+livreur_id).removeAttr('hidden');

     if(method == 'no')
     {alert('veuillez choisr une methode de paiement');

      $('.allPaySpinner'+livreur_id).attr('hidden', 'hidden');}
     else {
      $.ajax({
            url: 'payall',
            type: 'post',
            data: {_token: CSRF_TOKEN,livreur_id: livreur_id, method:method},
        
            success: function(response){
                     $('#allPayButtons'+livreur_id).attr('class', 'alert alert-success');
                     $('#allPayButtons'+livreur_id).html('Payé');
                     $('#payDetail'+livreur_id).attr('hidden', 'hidden');

                     
                      
                   },
        error: function(response){
                    
                     alert('Une erruer s\'est produite');
                     $('.allPaySpinner'+livreur_id).attr('hidden', 'hidden');
                   }
                  
          });}
   });


$('.payall').click(function(){
       $(this).attr('hidden', 'hidden');
    var id = $(this).val();
  $('#allPayButtons'+id).removeAttr('hidden');
  $('.allPayCancel'+id).removeAttr('hidden');
 
});


 $(".allPayCancel").click(function(){
   id = $(this).val();
     $(this).attr('hidden', 'hidden');
   $('#allPayButtons'+id).attr('hidden', 'hidden');
   $('#allPay'+id).removeAttr('hidden');
   $('#payDetail'+id).removeAttr('hidden');
});


 $('.doneDetail').click(function(){
  
    var doneDate = $(this).data("date"); 
    var id = $(this).data("id");
    var ids = $(this).val();
    var montant = $(this).data("montant");
    var done = $(this).data("done");
    $(".doneSpinner"+done).removeAttr("hidden");

    $.ajax({
            url: 'donedetail',
            type: 'post',
            data: {_token: CSRF_TOKEN,ids: ids, id: id},
        
            success: function(response){
                     $('.doneModalBody').html(response.dones);
                     $('.donee').html(response.livreur_nom + " - "+ montant + " - "+ doneDate);
                     $('#doneModal').modal('show');
                      $('.doneSpinner'+done).attr('hidden', 'hidden');
                   },
        error: function(response){
                    
                     alert('Une erruer s est produite');
                     $('.doneSpinner'+done).attr('hidden', 'hidden');
                   }
                  
          });
  

});


  function exportToImage(elementToExport){

      
            // Select the HTML element you want to convert to an image
            const element = document.getElementById(elementToExport);
           const ctx = canvas.getContext('2d');
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






        // Function to save the canvas as an image
        function saveCanvasAsImage(element) {
          const canvas = document.getElementById(element);
            const image = canvas.toDataURL(); // Default is PNG format

            // Create a link element and set its attributes
            const link = document.createElement('a');
            link.href = image;
            link.download = 'canvas_image.png'; // Change the filename if needed

            // Append the link to the DOM and click it to trigger the download
            document.body.appendChild(link);
            link.click();

            // Clean up by removing the link from the DOM
            document.body.removeChild(link);
        }

        // Add a click event listener to the save button
         function exportToPDF(elementToExport, file) {
            const element = document.getElementById(elementToExport);

            // Set the options for the PDF
            const options = {
                margin: 10,
                filename: file, // Change the filename if needed
                image: { type: 'jpeg', quality: 0.98 },
                html2canvas: { scale: 2 },
                jsPDF: { unit: 'mm', format: 'a4', orientation: 'portrait' }
            };

            // Use html2pdf.js to export the element to PDF
            html2pdf().from(element).set(options).save();
        }
    </script>


</script>
</body>
</html>
<?php /**PATH /htdocs/clients/logistica/admin/resources/views/payements.blade.php ENDPATH**/ ?>