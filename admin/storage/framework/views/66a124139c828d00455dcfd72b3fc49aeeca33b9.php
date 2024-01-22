<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
  <title>Véhicules</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../../dist/css/adminlte.min.css">
  <style type="text/css">
    
  </style>
</head>
<body class="hold-transition sidebar-mini">
  <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
 <script src="https://unpkg.com/vue@3"></script>
<div class="wrapper" id="app">
  <!-- Navbar -->
 <?php echo $__env->make("includes.navbar", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>



 
  <div class="modal fade action-sheet" id="actionsModal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content" >
                    <div class="modal-header">
                        <h5 class="modal-title">{{title}} </h5>
                        <a  href="javascript:;" data-dismiss="modal">Fermer</a>
                    </div>
                    <div class="modal-body">
                      <div v-if="selectedMoto" class="row">
                        <strong>{{selectedMoto.mark}} - {{selectedMoto.modele}}</strong>
                      </div>
                      
                        <div class="action-sheet-content" id="actionsOutput">
                            <div v-if="selectedMoto">
                                <ul >
                           <li v-if="selectedAction == 'affect'" v-for="affectation in selectedMoto.affectations">
                               {{affectation.created_at}} -  {{affectation.description}}
                           </li>

                           <li v-if="selectedAction == 'spend'" v-for="(spend, index) in selectedMoto.spends">
                               {{spend.created_at}} -{{spend.description}}-  {{spend.montant}} <button class="btn-primary btn mr-2 ml-2" data-toggle="modal" data-target="#editActionModal" @click="editSpend(index)"><i class="fas fa-edit"></i></button>

                               <button data-toggle="modal" data-target="#confirmModal" @click="deleteSpendConfirm(index)" class="btn-danger btn"><i class="fas fa-trash"></i></button>
                           </li>
                       </ul>


                       <form enctype="multipart/form-data" v-if="selectedAction == 'addSpend'" method="post" action="addspend">
                        <?php echo csrf_field(); ?>
                           <input type="" hidden :value="selectedMoto.id" name="id">
                           <input type="" hidden :value="motoDescription" name="motodescription">
                           <input type="" hidden :value="selectedMoto.chassi" name="chassi">
                           <input type="" hidden name="oldspend" :value="oldSpend">

                            <?php if ($errors->has('id')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('id'); ?>
                                    <span class="invalid-feedback" role="alert">
                                        <strong><?php echo e($message); ?></strong>
                                    </span>
                                <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>

                           <div class="form-group">
                            <label>Date</label>
                            <input value="<?php echo e(old('spenddate')); ?>" v-model="spendDate" name="spenddate" required type="date" class="form-control">

                            <?php if ($errors->has('spenddate')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('spenddate'); ?>
                                    <span class="invalid-feedback" role="alert">
                                        <strong><?php echo e($message); ?></strong>
                                    </span>
                                <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>
                        </div>


                        <div class="form-group">
                            <label>Montant</label>
                            <input v-model="spendAmount" value="<?php echo e(old('amount')); ?>" name="amount" min="1" required type="number" class="form-control">
                        </div>
                            <div class="form-group">
                            <label for="phone" >Nature de la panne</label>

                           
                              <select v-model="spendNature" class="form-control" name="nature" required>
                                <option  value="">
                                  Choisir Nature
                                </option>
                                 
                                
                                   <option  v-for="nature in natures">{{nature}}</option>
                                
                                
                              </select>
 
                                <?php if ($errors->has('nature')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('nature'); ?>
                                    <span class="invalid-feedback" role="alert">
                                        <strong><?php echo e($message); ?></strong>
                                    </span>
                                <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>
                            
                        </div>

                        <div class="form-group">
                            <label>Descriptiion</label>
                            <textarea value="<?php echo e(old('description')); ?>" name="description" class="form-control" rows="4" cols="4"></textarea>

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
                            <label>Pièce</label>
                            <input  accept="image/png, image/jpeg, image/jpg" name="file"  type="file" class="form-control">

                            <?php if ($errors->has('file')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('file'); ?>
                                    <span class="invalid-feedback" role="alert">
                                        <strong><?php echo e($message); ?></strong>
                                    </span>
                                <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>
                        </div>

                        <button type="submit" :disabled="spendNature == '' || spendDate == '' || spendAmount < 1" class="btn btn-primary">Valider</button>

                       </form>
                            </div>
                       
                       
                        
                </div>
            </div>
        </div>
    </div>
</div>


  <div class="modal fade show" data-backdrop="static" tabindex="-1" id="confirmModal"  role="dialog">
        <div class="modal-dialog">
          <div class="modal-content bg-danger">
            <div class="modal-header">
              <h4 class="modal-title">Souhaitez Vous vraiment supprimer?</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
              </button>
            </div>
            <form v-if="toBeDeleted == 'spend'" method="post" action="deletespend">
                <?php echo csrf_field(); ?>
                <input type="" hidden  name="id" :value="selectedSpend.id">
            <div class="modal-body">
              <p>{{selectedSpend.nature}} - {{selectedSpend.description}} </p>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-outline-light" data-dismiss="modal">Annuler</button>
              <button type="submit" class="btn btn-outline-light">Confirmer</button>
            </div>
        </form>

        <form v-if="toBeDeleted == 'moto'" method="post" action="deletemoto">
                <?php echo csrf_field(); ?>
                <input type="" hidden  name="id" :value="selectedMoto.id">
            <div class="modal-body">
              <p>{{selectedMoto.mark}} - {{selectedMoto.modele}} - {{selectedMoto.color}}</p>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-outline-light" data-dismiss="modal">Annuler</button>
              <button type="submit" class="btn btn-outline-light">Confirmer</button>
            </div>
        </form>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>





<div class="modal fade action-sheet" data-backdrop="static" id="editActionModal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content" >
                    <div class="modal-header">
                        <h5 class="modal-title">{{editTitle}} </h5>
                        <a  href="javascript:;" @click=" backToSpends" data-dismiss="modal">Fermer</a>
                    </div>
                    <div class="modal-body">
                      <div v-if="selectedSpend" class="row">
                        <strong>{{selectedSpend.nature}} - {{selectedSpend.description}} </strong>
                      </div>


                      <div v-if="selectedAction == 'editAffect'" class="row">
                        <strong>{{selectedMoto.nom}} - {{selectedMoto.mark}} - {{selectedMoto.modele}} </strong>
                      </div>
                      
                        <div class="action-sheet-content" id="actionsOutput">
                            <form v-if="selectedAction == 'editAffect'" method="post" action="affectmoto"> <?php echo csrf_field(); ?>
                                <input type="" hidden :value="selectedMoto.id" name="id">
                                <div class="form-group">
                            <label for="phone" >Affecté à</label>

                           
                              <select v-model="livreur" class="form-control" name="livreur_id" required="required">
                                <option value="">
                                  Choisir un un livreur
                                </option>
                                 
                                <?php $__currentLoopData = $livreurs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $livreur): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
                                   <option value="<?php echo e($livreur->id); ?>"><?php echo e($livreur->nom); ?></option>;
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                
                              </select>
 
                                <?php if ($errors->has('livreur_id')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('livreur_id'); ?>
                                    <span class="invalid-feedback" role="alert">
                                        <strong><?php echo e($message); ?></strong>
                                    </span>
                                <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>
                            
                        </div>
                        <button class="btn btn-primary" type="submit">Valider</button>
                                
                            </form>
                            
                            <form enctype="multipart/form-data" v-if="selectedAction == 'editSpend'" method="post" action="editspend">
                                {{selectedMoto.mark}} - {{selectedMoto.modele}}
                        <?php echo csrf_field(); ?>
                        <input type="" hidden :value="selectedSpend.id" name="id">
                           <div class="form-group">
                            <label for="phone" >Choisir véhicule</label>

                           
                              <select v-model="motoId" class="form-control" name="moto_id" required>
                                
                                 
                                
                                   <option   v-for="moto in motos" :value="moto.id">{{moto.nom}}_{{moto.mark}}_{{moto.modele}}</option>
                                
                                
                              </select>
 
                                <?php if ($errors->has('nature')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('nature'); ?>
                                    <span class="invalid-feedback" role="alert">
                                        <strong><?php echo e($message); ?></strong>
                                    </span>
                                <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>
                            
                        </div>

                            <?php if ($errors->has('id')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('id'); ?>
                                    <span class="invalid-feedback" role="alert">
                                        <strong><?php echo e($message); ?></strong>
                                    </span>
                                <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>

                           <div class="form-group">
                            <label>Date</label>
                            <input  v-model="spendDate2" name="spenddate" required type="date" class="form-control">

                            <?php if ($errors->has('spenddate')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('spenddate'); ?>
                                    <span class="invalid-feedback" role="alert">
                                        <strong><?php echo e($message); ?></strong>
                                    </span>
                                <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>
                        </div>


                        <div class="form-group">
                            <label>Montant</label>
                            <input v-model="spendAmount2"  name="amount" min="1" required type="number" class="form-control">
                        </div>
                            <div class="form-group">
                            <label for="phone" >Nature de la panne</label>

                           
                              <select v-model="spendNature2" class="form-control" name="nature" required>
                                <option  value="">
                                  Choisir Nature
                                </option>
                                 
                                
                                   <option  v-for="nature in natures">{{nature}}</option>
                                
                                
                              </select>
 
                                <?php if ($errors->has('nature')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('nature'); ?>
                                    <span class="invalid-feedback" role="alert">
                                        <strong><?php echo e($message); ?></strong>
                                    </span>
                                <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>
                            
                        </div>

                        <div class="form-group">
                            <label>Descriptiion</label>
                            <textarea  name="description" class="form-control" rows="4" cols="4">{{selectedSpend.description}}</textarea>

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
                            <label>Pièce</label>
                            <input  accept="image/png, image/jpeg, image/jpg" name="file"  type="file" class="form-control">

                            <?php if ($errors->has('file')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('file'); ?>
                                    <span class="invalid-feedback" role="alert">
                                        <strong><?php echo e($message); ?></strong>
                                    </span>
                                <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>
                        </div>

                        <button type="submit" :disabled="spendNature2 == '' || spendDate2 == '' || spendAmount2 < 1 || motoId == ''" class="btn btn-primary">Valider</button>

                       </form>
                       
                        
                </div>
            </div>
        </div>
    </div>
</div>









 <div class="modal fade" id="addLivModal" tabindex="-1" role="dialog">
            <div  class="modal-dialog modal-lg" role="document">
                <div  class="modal-content">
                    <div class="modal-header">
                        
                        <h5 class="modal-title">{{motoTitle}}</h5>
                       
                        <a href="javascript:;" data-dismiss="modal">Fermer</a>
                    </div>
                    <div   class="modal-body">
                        <div class="action-sheet-content ">
                          <form enctype="multipart/form-data" class="send" method="POST" :action="action">
                <?php echo csrf_field(); ?>
                <input v-if="action == 'editmoto'" v-model='id' hidden name="id" />
                <div class="card">
                    <div class="card-body">

                       <div class="form-group basic">
                            

                            <div class="input-wrapper">
                                <label for="name" class="label">Nom</label>
                                <input max="50"  id="name" type="text" class="form-control " name="name" value="<?php echo e(old('name')); ?>" v-model="motoName"  autocomplete="name" autofocus="">

                          </div>

                          <?php if ($errors->has('name')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('name'); ?>
                                   <span class="invalid-feedback" role="alert">
                               <strong><?php echo e($message); ?></strong>
                                </span>
                              <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>
                        </div>


                        <div class="form-group basic">
                            

                            <div class="input-wrapper">
                                <label for="mark" class="label">Marque*</label>
                                <input v-model="mark" max="50"  id="mark" type="text" class="form-control " name="mark" value="<?php echo e(old('mark')); ?>" required autocomplete="mark" autofocus="">

                          </div>


                          <?php if ($errors->has('mark')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('mark'); ?>
                                   <span class="invalid-feedback" role="alert">
                               <strong><?php echo e($message); ?></strong>
                                </span>
                              <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>
                        </div>


                         <div class="form-group basic">
                            

                            <div class="input-wrapper">
                                <label for="modele" class="label">Modèle*</label>
                                <input max="50"  id="modele" v-model="modele" type="text" class="form-control " name="modele" value="<?php echo e(old('modele')); ?>" required autocomplete="modele" autofocus="">

                          </div>



                          <?php if ($errors->has('modele')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('modele'); ?>
                                   <span class="invalid-feedback" role="alert">
                               <strong><?php echo e($message); ?></strong>
                                </span>
                              <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>
                        </div>

                          <div class="form-group basic">
                            

                            <div class="input-wrapper ">
                                <label class="label">Couleur</label>
                                <input v-model="color"  id="color" type="text" class="form-control " name="color" value="<?php echo e(old('color')); ?>"   autofocus="">

                               </div>

                               <?php if ($errors->has('color')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('color'); ?>
                                   <span class="invalid-feedback" role="alert">
                               <strong><?php echo e($message); ?></strong>
                                </span>
                              <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>
                        </div>


                         <div class="form-group basic">
                            

                            <div class="input-wrapper ">
                                <label class="label">Photo</label>
                                <input   accept="image/png, image/jpeg" class="form-control" type="file" name="file"   autofocus="">

                               </div>

                               <?php if ($errors->has('file')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('file'); ?>
                                   <span class="invalid-feedback" role="alert">
                               <strong><?php echo e($message); ?></strong>
                                </span>
                              <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>



                        </div>

                         <div class="form-group basic">
                            

                            <div class="input-wrapper">
                                <label for="cost" class="label">Coût d'achat*</label>
                                <input  v-model="motoCost" id="cost" type="number" class="form-control " name="cost" value="<?php echo e(old('cost')); ?>" required autocomplete="cost" autofocus="">

                          </div>



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

                        <div class="form-group basic">
                            

                            <div class="input-wrapper">
                                <label for="cost_vign" class="label">Coût vignette</label>
                                <input v-model="vignCost"  id="cost_vign" type="number" class="form-control " name="cost_vign" value="<?php echo e(old('cost_vign')); ?>"autocomplete="cost_vign" autofocus="">

                          </div>



                          <?php if ($errors->has('cost_vign')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('cost_vign'); ?>
                                   <span class="invalid-feedback" role="alert">
                               <strong><?php echo e($message); ?></strong>
                                </span>
                              <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>
                        </div>

                         <div class="form-group basic">
                            

                            <div class="input-wrapper">
                                <label for="cost_ass" class="label">Coût assurance</label>
                                <input v-model="assCost"  id="cost_ass" type="number" class="form-control " name="cost_ass" value="<?php echo e(old('cost_ass')); ?>"autocomplete="cost_ass" autofocus="">

                          </div>



                          <?php if ($errors->has('cost_ass')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('cost_ass'); ?>
                                   <span class="invalid-feedback" role="alert">
                               <strong><?php echo e($message); ?></strong>
                                </span>
                              <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>
                        </div>

                         <div class="form-group basic">
                            

                            <div class="input-wrapper">
                                <label for="cost_vis" class="label">Coût visite technique</label>
                                <input v-model="visCost"  id="cost_vis" type="number" class="form-control " name="cost_vis" value="<?php echo e(old('cost_vis')); ?>"autocomplete="cost_vis" autofocus="">

                          </div>


                          <?php if ($errors->has('cost_vis')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('cost_vis'); ?>
                                   <span class="invalid-feedback" role="alert">
                               <strong><?php echo e($message); ?></strong>
                                </span>
                              <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>
                        </div>




                        <div class="form-group basic">
                            

                            <div class="input-wrapper ">
                                <label class="label">Numero de Chassi*</label>
                                <input  v-model="chassi" id="chassi" type="text" class="form-control " name="chassi" value="<?php echo e(old('chassi')); ?>" required  autofocus="">

                               </div>

                               <?php if ($errors->has('chassi')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('chassi'); ?>
                                   <span class="invalid-feedback" role="alert">
                               <strong><?php echo e($message); ?></strong>
                                </span>
                              <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>
                        </div>



                          <div class="form-group basic">
                            

                            <div class="input-wrapper ">
                                <label class="label">Immatriculation*</label>
                                <input v-model="imm"  id="immatriculation" type="text" class="form-control " name="immatriculation" value="<?php echo e(old('immatriculation')); ?>" required  autofocus="">

                               </div>

                               <?php if ($errors->has('immatriculation')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('immatriculation'); ?>
                                   <span class="invalid-feedback" role="alert">
                               <strong><?php echo e($message); ?></strong>
                                </span>
                              <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>
                        </div>




                        <div class="form-group basic ">
                            <div class="input-wrapper">
                                <label class="label" for="email1">Date d'achat*</label>
                                <input v-model="buyDate" required type="date" class="form-control " name="buy_date" value="<?php echo e(old('buy_date')); ?>"  >
                                <i class="clear-input">
                                    <ion-icon name="close-circle" role="img" class="md hydrated" aria-label="close circle"></ion-icon>
                                </i>

                              </div>
                         

                              <?php if ($errors->has('buy_date')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('buy_date'); ?>
                                   <span class="invalid-feedback" role="alert">
                               <strong><?php echo e($message); ?></strong>
                                </span>
                              <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>
                        </div>


                         <div class="form-group basic ">
                            <div class="input-wrapper">
                                <label class="label" for="email1">Date de mise en service</label>
                                <input v-model="startDate" type="date" class="form-control " name="start_date" value="<?php echo e(old('start_date')); ?>"  >
                                <i class="clear-input">
                                    <ion-icon name="close-circle" role="img" class="md hydrated" aria-label="close circle"></ion-icon>
                                </i>

                              </div>

                          

                              <?php if ($errors->has('start_date')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('start_date'); ?>
                                   <span class="invalid-feedback" role="alert">
                               <strong><?php echo e($message); ?></strong>
                                </span>
                              <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>
                        </div>

                         <div class="form-group basic ">
                            <div class="input-wrapper">
                                <label class="label" for="email1">Date d'expiration assurance</label>
                                <input v-model="assDate" type="date" class="form-control " name="ass_exp" value="<?php echo e(old('ass_exp')); ?>"  >
                                <i class="clear-input">
                                    <ion-icon name="close-circle" role="img" class="md hydrated" aria-label="close circle"></ion-icon>
                                </i>

                              </div>



                              <?php if ($errors->has('ass_exp')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('ass_exp'); ?>
                                   <span class="invalid-feedback" role="alert">
                               <strong><?php echo e($message); ?></strong>
                                </span>
                              <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>
                        </div>


                        <div class="form-group basic ">
                            <div class="input-wrapper">
                                <label class="label" for="email1">Date d'expiration visite technique</label>
                                <input v-model="visitDate" type="date" class="form-control " name="visit_exp" value="<?php echo e(old('visit_exp')); ?>"  >
                                <i class="clear-input">
                                    <ion-icon name="close-circle" role="img" class="md hydrated" aria-label="close circle"></ion-icon>
                                </i>

                              </div>



                              <?php if ($errors->has('visit_exp')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('visit_exp'); ?>
                                   <span class="invalid-feedback" role="alert">
                               <strong><?php echo e($message); ?></strong>
                                </span>
                              <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>
                        </div>


                        <div class="form-group basic ">
                            <div class="input-wrapper">
                                <label class="label" for="email1">Date d'expiration vignette</label>
                                <input v-model="vignDate" type="date" class="form-control " name="vign_exp" value="<?php echo e(old('vign_exp')); ?>"  >
                                <i class="clear-input">
                                    <ion-icon name="close-circle" role="img" class="md hydrated" aria-label="close circle"></ion-icon>
                                </i>

                              </div>

                         

                              <?php if ($errors->has('vign_exp')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('vign_exp'); ?>
                                   <span class="invalid-feedback" role="alert">
                               <strong><?php echo e($message); ?></strong>
                                </span>
                              <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>
                        </div>


                         <div class="form-group">
                            <label for="phone" >Affecté à</label>

                           
                              <select v-model="affectTo" class="form-control" name="livreur_id" >
                                <option value="">
                                  Choisir un un livreur
                                </option>
                                 
                                <?php $__currentLoopData = $livreurs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $livreur): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
                                   <option <?php if($livreur->id == old('livreur_id')): ?> selected <?php endif; ?> value='<?php echo e($livreur->id); ?>'><?php echo e($livreur->nom); ?></option>;
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                
                              </select>
 
                                <?php if ($errors->has('livreur_id')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('livreur_id'); ?>
                                    <span class="invalid-feedback" role="alert">
                                        <strong><?php echo e($message); ?></strong>
                                    </span>
                                <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>
                            
                        </div>


                    </div>
                </div>



<div o="" class="form-button-group transparent sendbtn">
                    <button type="submit" class="btn btn-primary btn-block btn-lg">Enregistrer</button>
                </div>

            </form>
                           
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
          <div class="col-sm-6">
            <h1>Liste des Véhicules</h1> 
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="dashboard">Home</a></li>
              <li class="breadcrumb-item active">Véhicules</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        
       
        <!-- /.row -->
        <div class="row">
          <div class="col-12">
            <?php if(session('status')): ?>
                        <div class="alert alert-success" role="alert">
                            <?php echo e(session('status')); ?>

                        </div>
                    <?php endif; ?>
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Liste des Véhicules</h3>

                <div class="card-tools">
                  <div class="input-group input-group-sm" >
                 

                    
                      <button @click="addMoto" data-toggle="modal" @click="addmoto" id="addBtn" data-target="#addLivModal" class="btn btn-success">
                       Ajouter un Véhicule
                      </button>
                   
                  </div>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body  p-0" >
                <table class="table  table-responsive">
                  <thead>
                    <tr>
                      <th>
                        Description
                      </th>
                      <th>
                        Depanses
                      </th>
                      
                      
                      <th>
                        Expiration visite
                      </th>
                      <th>
                        Expiration vignette
                      </th>

                      <th>
                        Expiration assurance
                      </th>

                      <th>
                        Affecté à
                      </th>
                     <th>
                        Action
                      </th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php if($motos->count() > 0): ?>
                    <?php $__currentLoopData = $motos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $x=>$moto): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                      <tr>
                        <td>
                          <?php echo e($moto->mark); ?> - <?php echo e($moto->modele); ?>

                          <?php if($moto->name): ?>
                         <br> Alias: <?php echo e($moto->name); ?> 
                          <?php endif; ?>
                        </td>
                        <td>
                          <?php echo e($moto->spends()->sum("montant")); ?><br>

                          <a href="#" @click="getSpends(<?php echo e($x); ?>)" class="mr-2" data-toggle="modal" data-target="#actionsModal">Voir Liste </a><br>

                          <a href="#" @click="addSpend(<?php echo e($x); ?>)" id="oldspend<?php echo e($x); ?>" data-toggle="modal" data-target="#actionsModal">+ Ajouter </a>

                        </td>

                        

                        <td><?php if($moto->visit_exp): ?>
                          <?php echo e(date_create($moto->visit_exp)->format("d-m-Y")); ?> 
                          <?php endif; ?></td>
                        <td><?php if($moto->vign_exp): ?>
                          <?php echo e(date_create($moto->vign_exp)->format("d-m-Y")); ?> 
                          <?php endif; ?></td>
                        <td><?php if($moto->ass_exp): ?>
                          <?php echo e(date_create($moto->ass_exp)->format("d-m-Y")); ?> 
                          <?php endif; ?></td>


                        <td>
                          
                          <?php echo e($moto->livreur_nom); ?> <?php if($moto->livreur_nom): ?> <a class="btn btn-primary ml-2" href="#" @click="affect
                          (<?php echo e($x); ?>)" data-toggle="modal" data-target="#editActionModal">Réaffecter</a> <?php else: ?> 
                          <a class="btn btn-primary ml-2" href="#" @click="affect
                          (<?php echo e($x); ?>)" data-toggle="modal" data-target="#editActionModal">Affecter</a>
                          <?php endif; ?>
                          <?php if($moto->affectations->count() > 0): ?>
                          <br>
                          <a href="#" @click="getAffects(<?php echo e($x); ?>)" data-toggle="modal" data-target="#actionsModal">Voir historique d'affectation (<?php echo e($moto->affectations->count()); ?>)</a>
                           
                          <?php endif; ?>
                         
                        </td>

                        <td>
                          <a href="#" @click="editMoto(<?php echo e($x); ?>)" data-toggle="modal" data-target="#addLivModal" class="btn btn-primary mr-2"><i class="fas fa-edit"></i></a>
                          <a href="#" class="btn btn-danger " data-toggle="modal" data-target="#confirmModal" @click="deleteMotoConfirm(<?php echo e($x); ?>)"><i class="fas fa-trash"></i></a>
                        </td>
                      </tr>
                      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                      <?php endif; ?>
                    
                  </tbody>
                </table>
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
</div>
<!-- ./wrapper -->
<script>
   
   const app = Vue.createApp({
    data() {
        return {
           
            selectedMoto:null,
            title: "",
            motos: <?php echo $vmotos; ?>,
            selectedAction: null,
            action: "",
            motoTitle: "",
            natures: ["Réparation/Pièce", "Carburant", "Vidange", "Assurance", "Vignette", "Visite technique", "Infraction", "Autre"],
            spendNature:"<?php echo e(old('nature')); ?>",
            spendDate: "<?php echo e(old('spenddate')); ?>",
            spendAmount:"<?php echo e(old('amount')); ?>",

            spendNature2:"",
            spendDate2: "",
            spendAmount2:null,
            motoId:"",
            
            livreur: "",

            motoDescription: "",
            oldSpend: "",
            selectedSpend: null,


             motoName: "",
             mark: "",
             modele: "",
             color: "",
             motoCost: "",
             vignCost: "",
             assCost: "",
             visCost: "",
             chassi: "",
             imm: "",
             buyDate: "",
             startDate: "",
             assDate: "",
             visitDate: "",
             vignDate: "",
             affectedTo: "",
             id:"",
             toBeDeleted:"",



        }
    },
    methods:{ 
    
    addMoto(){
        this.action = "addmoto"
        this.motoTitle = "Ajouter un Véhicule"

             this.motoName = ""
             this.mark = ""
             this.modele = ""
             this.color = ""
             this.motoCost = ""
             this.vignCost = ""
             this.assCost = ""
             this.visCost = ""
             this.chassi = ""
             this.imm = ""
             this.buyDate = ""
             this.startDate = ""
             this.assDate = ""
             this.visitDate = ""
             this.vignDate = ""
             this.affectedTo = ""
             this.id = ""

    },


    editMoto(index){
        this.action = "editmoto"
        this.selectedMoto = this.motos[index]
        this.motoDescription = ""

         if(this.selectedMoto.name){
            this.motoDescription += this.selectedMoto.name + "_"
         }
        this.motoTitle = "Modifier un Véhicule "+this.motoDescription

             this.motoName = this.selectedMoto.name
             this.mark = this.selectedMoto.mark
             this.modele = this.selectedMoto.modele
             this.color = this.selectedMoto.color
             this.motoCost = this.selectedMoto.cost
             this.vignCost = this.selectedMoto.vign_cost
             this.assCost = this.selectedMoto.ass_cost
             this.visCost = this.selectedMoto.vis_cost
             this.chassi = this.selectedMoto.chassi
             this.imm = this.selectedMoto.imm
             this.buyDate = this.selectedMoto.buy_date
             this.startDate = this.selectedMoto.first_day
             this.assDate = this.selectedMoto.ass_exp
             this.visitDate = this.selectedMoto.visit_exp
             this.vignDate = this.selectedMoto.vign_exp
             this.affectedTo = this.selectedMoto.livreur_id
             this.id = this.selectedMoto.id
        
    },


    getSelectedMoto(index){
      this.selectedMoto = this.motos[index]
    },

     getAffects(index){
            
         this.selectedAction = "affect"
         this.selectedMoto = this.motos[index]
         
         id = this.selectedMoto.id
         this.title = "Historique d'affectation de véhicule"
         
    
    },


     getSpends(index){
         
         this.selectedAction = "spend"
         this.selectedMoto = this.motos[index]
         
         id = this.selectedMoto.id
         this.title = "Liste de dépense de véhicule"
         
    
    },

    backToSpends(){
        this.selectedAction = "spend"
         
    },


    addSpend(index){
         
         this.selectedAction = "addSpend"
         this.selectedMoto = this.motos[index]
         
         id = this.selectedMoto.id
         this.title = "Ajouter une dépense"

         this.motoDescription = ""

         if(this.selectedMoto.name){
            this.motoDescription += this.selectedMoto.name + "_"
         }

         this.motoDescription += this.selectedMoto.mark + "_" + this.selectedMoto.modele + "_" + this.selectedMoto.color
         
         this.oldSpend = "#oldspend"+index
    
    },

    editSpend(index){
         
          this.selectedAction = "editSpend"
         this.selectedSpend = this.selectedMoto.spends[index]
         
         
         this.editTitle = "Modifier une dépense"

         this.spendNature2 = this.selectedSpend.nature
            this.spendDate2 = this.selectedSpend.spend_date
            this.spendAmount2 = this.selectedSpend.montant
            this.motoId = this.selectedMoto.id
    
    },


     affect(index){
         
         selectedSpend = null
         
         this.selectedAction = "editAffect"
         this.selectedMoto = this.motos[index]
         this.livreur = this.motos[index].livreur_id
        
         this.EditTitle = "Affecter véhicule"
    
    },

    deleteSpendConfirm(index){
        this.toBeDeleted = 'spend'
        this.selectedSpend = this.selectedMoto.spends[index]
       
    },


    deleteMotoConfirm(index){

        this.toBeDeleted = 'moto'
        this.selectedMoto = this.motos[index]
       
    }


  
  
   

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
<script type="text/javascript">
  var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
</script>
<?php if($errors->count() > 0 && !old('oldspend')): ?>
<script type="text/javascript">
  $("#addBtn").click();
</script>
<?php endif; ?>


</body>
</html>
<?php /**PATH /htdocs/clients/logistica/admin/resources/views/motos.blade.php ENDPATH**/ ?>