<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
   <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
  <title>Ma boutique</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">

   <link rel="stylesheet" href="../../plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="../../plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="../../plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../../dist/css/adminlte.min.css">
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
    <script src="https://unpkg.com/vue@3.0.11/dist/vue.global.js" ></script>

<div class="wrapper" id="app">


     <div   class="modal fade" id="addProduct"  tabindex="-1" role="dialog">
            <div  class="modal-dialog modal-lg" role="document">
                <div  class="modal-content">
                    <div class="modal-header">
                      <h5 @click="addProduct" class="modal-title editModalTitle">{{ productTitle }}</h5>
                        <a href="javascript:;" data-dismiss="modal">Fermer</a>
                        
                        

                    </div>
                    <div   class="modal-body">
                        <form method="post" enctype="multipart/form-data" :action="productAction" >
                            <?php echo csrf_field(); ?>

                            <input hidden :value="productId" name="id">
                            <input hidden :value="productAction" name="action">
                            <input hidden :value="productTitle" name="title">

                            <div class="form-group">
                                <label>Boutique</label>

                                <select v-if="shops.length > 0" required  class="form-control " type="" name="shop">
                                    <option value="">Choisir une boutique</option>
                                    
                                    <option v-for="shop in shops" :selected="shop.id == productShop" :value="shop.id">{{shop.name}}</option>
                                    
                                </select>

                                 <?php if ($errors->has('shop')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('shop'); ?>
                            <span class="text-alert" role="alert">
                            <strong><?php echo e($message); ?></strong>
                                </span>
                              <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>
                                
                            </div>
                            <div class="form-group">
                                <label>Nom du produit*</label>
                                <input required :value="productName" autocomplete="off" placeholder="Saisir le nom du produit" class="form-control " type="" name="name">
                                 <?php if ($errors->has('name')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('name'); ?>
                            <span class="text-danger" role="alert">
                            <strong><?php echo e($message); ?> </strong>
                                </span>
                              <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>
                            </div>

                            <div class="form-group">
                                <label>Code du produit</label>
                                <input  :value="productCode" autocomplete="off" placeholder="Saisir le code du produit" class="form-control " type="" name="code">

                                <?php if ($errors->has('code')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('code'); ?>
                            <span class="alert alert-danger" role="alert">
                            <strong><?php echo e($message); ?></strong>
                                </span>
                              <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>
                                
                            </div>

                            <div class="form-group">
                                <label>Categorie</label>

                                <select   class="form-control " type="" name="category">
                                    <option value="">Choisir une categorie</option>
                                    
                                    <option v-for="category in categories" :selected="category.name == productCategory" :value="category.name">{{category.name}}</option>
                                    
                                </select>

                                 <?php if ($errors->has('category')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('category'); ?>
                            <span class="text-alert" role="alert">
                            <strong><?php echo e($message); ?></strong>
                                </span>
                              <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>
                                
                            </div>

                            <div class="form-group">
                                <label>Fournisseur</label>

                                <select   class="form-control " type="" name="category">
                                    <option value="">Choisir un fournisseur</option>
                                    
                                    <option v-for="supplier in suppliers" :selected="supplier.id == productSupplier" :value="supplier.id">{{supplier.id}}</option>
                                    
                                </select>

                                 <?php if ($errors->has('category')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('category'); ?>
                            <span class="text-alert" role="alert">
                            <strong><?php echo e($message); ?></strong>
                                </span>
                              <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>
                                
                            </div>



                            <div class="form-group">
                                <label>Description</label>
                                <textarea :value="productDescription" name="description" class="form-control " rows="4" cols="4"></textarea>
                                
                            </div>

                            <div class="form-group">
                                <label>Prix de vente*</label>
                                
                                <input required :value="productPrice" autocomplete="off" placeholder="Saisir le prix du produit" class="form-control " type="number" name="price">
                                 <?php if ($errors->has('price')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('price'); ?>
                            <span class="text-alert" role="alert">
                            <strong><?php echo e($message); ?></strong>
                                </span>
                              <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>
                            </div>


                            <div class="form-group">
                                <label>Prix d'achat</label>
                                
                                <input :value="productCost" autocomplete="off" placeholder="Saisir le prix d'achat' produit" class="form-control " type="number" name="cost">

                                 <?php if ($errors->has('cost')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('cost'); ?>
                           <span class="text-alert" role="alert">
                            <strong><?php echo e($message); ?></strong>
                                </span>
                              <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>
                                
                            </div>

                            <div class="form-group">
                                <label>Frais de port</label>
                                
                                <input :value="productPort" autocomplete="off" placeholder="Saisir le frais de port" class="form-control " type="number" name="port">
                                
                            </div>


                            <div class="form-group">
                                <label>Frais de conditionnement</label>
                                
                                <input :value="productConditioning" autocomplete="off" placeholder="Saisir le frais de conditionnement" class="form-control " type="number" name="conditioning">
                                
                            </div>

                            <div class="form-group">
                                <label>Cout etiquette</label>
                                
                                <input :value="productSticker" autocomplete="off" placeholder="Saisir le cout de conditionnement" class="form-control " type="number" name="etiquette">
                                
                            </div>

                            <div class="form-group">
                                <label>Publicite</label>
                                
                                <input :value="productSticker" autocomplete="off" placeholder="Saisir le cout de Publicite" class="form-control " type="number" name="ad">
                                
                            </div>


                             <div class="form-group">
                                <label>Stock Initial</label>
                                
                                <input :value="productStock" autocomplete="off" placeholder="Saisir le stock initial" class="form-control " type="number" name="qty">

                                 <?php if ($errors->has('qty')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('qty'); ?>
                            <span class="text-alert" role="alert">
                            <strong><?php echo e($message); ?></strong>
                                </span>
                              <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>
                                
                            </div>


                            <div class="form-group">
                                <label>Stock de securite</label>
                                
                                <input :value="productSecStock" autocomplete="off" placeholder="Saisir le stock de securite" class="form-control " type="number" name="secstock">

                                 <?php if ($errors->has('secstock')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('secstock'); ?>
                            <span class="text-alert" role="alert">
                            <strong><?php echo e($message); ?></strong>
                                </span>
                              <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>
                                
                            </div>


                             <div class="form-group">
                                <label>Photo</label>
                                
                                <input accept="image/png, image/jpeg" class="form-control" type="file" name="file">
                                
                            </div>

                            <button type="submit" class="btn btn-primary">Enregistrer</button>
                        </form>
                        
                </div>
            </div>
        </div>

      </div>


      <div   class="modal fade " id="productDetail"  tabindex="-1" role="dialog">
            <div  class="modal-dialog" role="document">
                <div  class="modal-content">
                    <div class="modal-header">
                      <h5 @click="addProduct" class="modal-title editModalTitle">Details produit</h5>
                        <a href="javascript:;" data-dismiss="modal">Fermer</a>
                        
                        

                    </div>
                    <div   class="modal-body">
                       <div class="row">
                         <img :src="findImage(productPhoto)" style="width: 100%; height: 30%;" alt="img">
                           
                       </div> 

                       <div class="row mt-2">
                        Nom du produit: <span style="font-weight: bold;">{{ productName }}</span>  

                           
                       </div>

                       <div class="row mt-2">
                        
                        Prix: {{ productPrice }} <br>
                        Stock: {{ productStock }} <br>
                        Description: {{ productDescription }} <br>

                           
                       </div>
                </div>
            </div>
        </div>

      </div>
      <div class="modal fade  " id="deleteProduct" tabindex="-1" role="dialog">
            <div  class="modal-dialog" role="document">
                <div  class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Supprimer?</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        
                        

                    </div>
                    <div   class="modal-body">
                        <div class="action-sheet-content">
                            Souhaitez-Vous vraiment supprimer <strong>{{productName}}</strong> ?
                            <button data-dismiss="modal" @click="confirmDelete(productId)"  class="btn btn-danger mr-2">Confimer</button>
                            <button  type="button"  data-dismiss="modal" class="btn btn-success">Annuler</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="modal fade  " id="shopModal" tabindex="-1" role="dialog">
            <div  class="modal-dialog" role="document">
                <div  class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Modifier Boutique</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        
                        

                    </div>
                    <div   class="modal-body">
                        <div class="action-sheet-content">
                           <strong> {{productName}}</strong>

                            <div class="form-group">
                                <label>Boutique</label>
                              
                                <select required  class="form-control " type="" name="shop" v-model="selectedShop">
                                    <option value="">Choisir une boutique</option>

                                    <option value="NULL">Aucune boutique</option>
                                    
                                    <option v-for="shop in shops" :selected="shop.id == productShop" :value="shop.id">{{shop.name}}</option>
                                    
                                </select>

                                 <?php if ($errors->has('shop')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('shop'); ?>
                            <span class="text-alert" role="alert">
                            <strong><?php echo e($message); ?></strong>
                                </span>
                              <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>
                                
                            </div>
                            <button :disabled="selectedShop == ''" data-dismiss="modal" @click="setShop(products[selectedVariant].id)"  class="btn btn-success mr-2">Valider</button>
                            <button  type="button"  data-dismiss="modal" class="btn btn-danger">Annuler</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="modal fade action-sheet  " id="moovingModal" tabindex="-1" role="dialog">
            <div  class="modal-dialog" role="document">
                <div  class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h5 class="modal-title">Mouvement {{ productName }}</h5>
                        

                    </div>
                    <div   class="modal-body">
                        <div class="action-sheet-content ">
                            <div>
                                
                                    <input hidden :value="productId" type="" name="id">
                             <div class="form-group">
                                Seuil actuel: {{productSecStock}}<br>
                                <label>Definir seuil critique</label>
                                 <input v-model="secQty"  required min="1" type="number" name="qty" class="form-control ">
                                
                            </div>
                            <button @click="setSecStock"  class="btn btn-primary">Valider</button>
                            
                           
            <div v-if="secsuccess" class="card bg-gradient-success">
              <div class="card-header">
                <h3 class="card-title">Seuille definie avec succes!</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i>
                  </button>
                </div>
                <!-- /.card-tools -->
              </div>
              
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          
                           </div>
                            
                            <hr>
                        <form method="post" action="mooving">
                            <?php echo csrf_field(); ?>
                            <input hidden :value="productId" type="" name="id">
                            
                             <div class="form-group">
                                <label>Type de mouvement</label>
                                <select name="type"  class="form-control " required >
                                    <option value="">Choisir</option>
                                    <option value="IN">ENTREE</option>
                                    <option value="OUT">SORTIE</option>
                                </select>
                                
                            </div>

                            <div class="form-group">
                               <label>Quantite</label>
                                <input required min="1" type="number" name="qty" class="form-control ">
                                
                            </div>

                            <div class="form-group">
                               <label>Description</label>
                                <textarea required name="description" class="form-control " rows="4" cols="4"></textarea>
                                
                            </div>
                           <input type="submit" name="">
                        </form>
                    </div>
                </div>
               </div>
            </div>
        </div>

        <div class="modal fade  " id="categoryModal" tabindex="-1" role="dialog">
            <div  class="modal-dialog" role="document">
                <div  class="modal-content">
                    <div class="modal-header">
                         <h5 class="modal-title">Categories</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                       
                        

                    </div>
                    <div   class="modal-body">
                        <div class="action-sheet-content ">
                        <div class="row mb-2">
                            <h3>Nouvelle categories</h3>

                            <div class="input-group mb-2">
                         <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon1">Nom</span>
                       </div>
                  <input v-model="name" id="cmdcostumer" maxlength="200" required   name="name" class="form-control" type="text" placeholder="Nom de categorie" >
                     </div>
                     <button @click="newCategory" :disabled="name == ''" class="btn btn-primary btn-block">Enregistrer</button>
                        </div>


                        <div class="row" v-for="category in categories">
                            <div class="col">
                            <div class="card  mb-2">
                
                          <div  class="card-body">

                          <div v-if="edit">
                               <div class="input-group mb-2">
                         
                  <input  :value="category.name" id="cmdcostumer" maxlength="200" required   name="name" class="form-control" type="text" placeholder="Nom de categorie" >
   
                     </div>
                     <button    class="btn btn-primary btn-sm mr-1">Confirmer</button>
                      <button @click="categoryEditCancel()" class="btn btn-danger btn-sm mr-1">Annuler</button>
                          </div>  
                        <div v-else>    
                       <strong>{{ category.name }}</strong>
                      <div class="float-right">
                       <!-- <button @click="categoryEdit()"   class="btn btn-primary btn-sm mr-1">Modifier</button> -->
                      <button @click="revomeCategory(category.id)" class="btn btn-danger btn-sm mr-1">Supprimer</button>
                         </div>
                     </div>
                           </div>
                   
                </div>
                </div>
            </div>
                    </div>
                </div>
               </div>
            </div>
        </div>

        <div   class="modal fade " id="cmd"  tabindex="-1" role="dialog">
            <div  class="modal-dialog" role="document">
                <div  class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title editModalTitle">Panier</h5>
                        <a href="javascript:;" data-dismiss="modal">Fermer</a>
                        
                        

                    </div>
                    <div   class="modal-body">
                        <div  class="action-sheet-content selectedProducts">
                            <form id="cmdForm" onsubmit="return false;">
                            <div  id="cmdSuccess"  class="card mb-2">

            <div v-if="newR" class="card-body">
               <span class="alert alert-success mb-2">Commande enregistree</span>
               Numero:<span style="color:red; font-size: 20px; font-weight: bold;">{{newR.id}}</span>(a inscrire sur votre colis)

               <button type="button" @click="shareBill('Commande'+ ' '+ newR.id+'. '+newR.description+ '. Total:'+ (Number(newR.montant)+Number(newR.livraison))+'. '+newR.adresse+ '. '+newR.phone+ '. Plus de detail sur https://client.livreurjibiat.site/tracking/'+newR.id)" class="btn btn-primary btn-block mt-2 squared" id="bill">ENVOYER FACTURE</button>
           </div>
            </div>

                    
           <h3>Client</h3>
            <div class="input-group mb-2">
       <div class="input-group-prepend">
    <span class="input-group-text" id="basic-addon1">Client</span>
  </div>
      <input v-model="custumer" id="cmdcostumer" maxlength="150"    name="costumer" class="form-control" type="text" placeholder="Nom du client" >
      </div>

       <div class="input-group mb-2">
       <div class="input-group-prepend">
    <span class="input-group-text" id="">Contact*</span>
  </div>
      <input v-model="phone"  id="cmdphone" value="<?php echo e(old('phone')); ?>" required  name="phone" class="form-control contact" type="tel" placeholder="Numero du client sans l'indicatif(225)"  autocomplete="off">
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

       <div class="input-group mb-2">
       <div class="input-group-prepend">
    <span class="input-group-text" id="">Contact2*</span>
  </div>
      <input v-model="phone2"  id="cmdphone2"  required  name="phone" class="form-control contact" type="tel" placeholder="Second contact"  autocomplete="off">
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

      <div hidden class="input-group mb-2">
       <div class="input-group-prepend">
    <span class="input-group-text" id="">Contact2</span>
  </div>
      <input id="cmdphone2" value="<?php echo e(old('phone2')); ?>"   name="phone2" class="form-control contact" type="number" placeholder="Second Numero du client sans l'indicatif(225)"  autocomplete="off">
      <?php if ($errors->has('phone2')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('phone2'); ?>
      <span class="invalid-feedback" role="alert">
      <strong><?php echo e($message); ?></strong>                   
      </span>
      <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>
      <span class="contact_div text-warning"></span> 
      </div>

      <div class="input-group mb-2">
       <div class="input-group-prepend">
    <span class="input-group-text" id="">Commune*</span>
  </div>
      <select v-model="fee"   required  class="form-control" name="fee">
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

       <div class="input-group mb-2">
       <div class="input-group-prepend">
    <span class="input-group-text" id="">Adresse</span>
  </div>
      <input  v-model="adresse"  maxlength="150" id="cmdlieu" name="adresse" class="form-control" type="text" placeholder="Ex: grand carrefour... pharmacie... rivera jardin..." autocomplete="off">
      </div>
       
       <hr>
       <div class="row">
           <div class="col"> <h3>Colis</h3></div>
           <div class="col float-right"> <h3 :class="danger">Total: {{ greatTotal }} </h3></div>
       </div>
      
       <div style="font-weight: bold;" class="row"  v-for="product in products">
         <span v-if="product.qty>0">{{product.qty + ' ' +product.name}}.</span>
      </div>

          <?php if($sources->count() > 0): ?>
<div class="input-group mb-2">
       <div class="input-group-prepend">
    <span class="input-group-text" id="basic-addon1">Canal</span>
  </div>
      <select   v-model="source"  id="cmdsource"   class="form-control livreur" name="source">
        <option value="">Chosir le canal</option>
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
     
      <div class="input-group mb-2">
       <div class="input-group-prepend">
    <span class="input-group-text" id="basic-addon1">Date Livraison</span>
  </div>
      <input 
         min="
         <?php
            echo date('Y-m-d');
            ?>
         " required type="date" v-model="delivery_date" name="delivery_date" class="form-control "  id="cmddate"  >
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
      

      


      <div class="input-group mb-2">
       <div class="input-group-prepend">
    <span class="input-group-text" id="">Remise</span>
  </div>
      <input required v-model="remise" id="cmdremise"  value="<?php echo e(old('montant')); ?>"  name="remise" class="form-control <?php if ($errors->has('montant')) :
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

       <div class="input-group  mb-2">
       <div class="input-group-prepend">
    <span class="input-group-text" id="">Tarif livraison*</span>
  </div>
      <select v-model="livraison"  class="form-control livraison" name="livraison">
        <option  value="">Choisir tarif</option>
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

      <div class="input-group mb-2 autre" v-if="livraison == 'autre'" >
       <div class="input-group-prepend">
    <span class="input-group-text" id="">Autre Tarif*</span>
  </div>
      <input :required="livraison == 'autre'" v-model="oth_fee" name="other_liv"  value="<?php echo e(old('other_liv')); ?>" id="cmdothfee"  class="form-control tarif" type="number" placeholder="" >
      </div>

    


     
     



<?php if($livreurs->count() > 0): ?>
 <div class="input-group mb-3 livreurInput">
       <div class="input-group-prepend">
    <span class="input-group-text" id="">Livreur</span>
</div>
      <select  v-model="livreur"    class="form-control livreur" name="livreur">
        <option value="">Choisir livreur</option>
        <option value="">Choisir plutard</option>
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


      <div class="form-group">
      <label  class="form-label">Information supplementaire.</label>
      <input v-model="observation" id="comobservation" id="comobservation" maxlength="150" value="<?php echo e(old('observation')); ?>"  name="observation" class="form-control " type="text" placeholder="Information supplementaire">
      </div>
      <span v-if="cmdError" class="mb-2 alert alert-danger" >{{cmdError}}</span>
         <div v-if="confirm">
           <strong class="text-warning">Il existe deja {{confirm}}  commande(s) enregistree avec ce numero {{phone}}. Souhaitez vous confirmer?
           </strong><br>
            <button type="button" @click="confirmCmd" :disabled="delivery_date == ''  || destination == ''|| livraison == '' || phone == '' || total <= 0 || products.length == 0" id="addCmd"  class="btn btn-success  mr-2">
            Oui confirmer
           </button>

           <button @click="editCmd" type="button"  class="btn btn-warning mr-1" >
            Modifier
           </button>
            <button @click="cancelCmd" type="button"  class="btn btn-danger" >
            Non Annuler
           </button> 

                     
         </div>
      <div v-else  class="form-group basic">
         <button type="button" @click="newCmd" :disabled="delivery_date == ''  || destination == ''|| livraison == '' || phone == '' || total <= 0 || products.length == 0"  class="btn btn-primary btn-block btn-lg" id="addCmd">Enregister
         </button>
       </div>
  </form>
      

        <div v-if="cart>0" v-for="(product, index) in products" :key="product.id" @mouseover="updateVariant(index)" class="card card-widget widget-user-2 shadow-sm">
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
                    <button :disabled="product.stock > 0 ? false : true" v-on:click="addToCart()" class="btn btn-success mr-1 btn-sm">Ajouter au Panier</button>
                    <button v-if="product.qty > 0" v-on:click="removeFromCart()" class="btn btn-danger btn-sm ">Retirer du Panier</button>
                  </li>
                  <li class="nav-item">
                    <a href="#" class="nav-link">
                      Stock <span :class="product.stock > 0 ? 'float-right badge bg-success' : 'float-right badge bg-danger' ">{{ product.stock }}</span>
                    </a>
                  </li>
                </ul>
              </div>
            </div>
    <div v-else>
       Aucum produit dans le panier
    </div>
         </div>
      </div>
    </div>
   </div>
</div>
  <!-- Navbar -->
 <?php echo $__env->make("includes.navbar", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Liste des produits</h1>
             <!--  <a href="#" data-toggle="modal" data-target="#cmd" class="btn btn-primary">
               <i class="fa fa-cart-shopping"></i> Paniner
                <span   class="badge badge-danger">{{ cart }}</span>

            </a> -->
            
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="dashboard">Home</a></li>
              <li class="breadcrumb-item active">Ma boutique</li>
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

                        </div>
                    <?php endif; ?>
        <!-- /.row -->
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">


               

                 <div class="card-title"  >

                    <table cellpadding="3" cellspacing="0" border="0" >
        <thead>
            <tr>
                <th>Categorie</th>
                <th>Boutique</th>
                <th>Etat du stock</th>
            </tr>
        </thead>
        <tbody>
            
            
           
            <tr id="filter_col3" data-column="3">
               <td align="center" class="column_filter" >
                <select id="col3_filter" data-column="3" class="form-control">
                    <option value="">Toutes les categories</option>
                    <option :value="category.name" v-if="categories.length > 0" v-for="category in categories">{{ category.name }}</option>
                 </select>
                    
                </td>

                <td align="center" class="column_filter" >
                <select id="col2_filter" data-column="2" class="form-control">
                    <option value="">Toutes les boutiques</option>
                    <option  v-if="shops.length > 0" v-for="shop in shops">{{ shop.name }}</option>
                 </select>
                    
                </td>

                <td align="center" class="column_filter" >
                <select id="col4_filter" data-column="4" class="form-control">
                    <option value="">Toutes les etats</option>
                    <option  >Seuille critique atteint</option>
                    <option  >Stock suffisant</option>
                 </select>
                    
                </td>
            </tr>
           
        </tbody>
    </table>
                
            </div>
               
                   
                <div class="card-tools">
                  <button v-on:click="addProduct" class="btn btn-success" data-toggle="modal" data-target="#addProduct">+ Nouveau produit</button>
                   <button  class="btn btn-primary ml-1" data-toggle="modal" data-target="#categoryModal">Categories</button>

                   <a target="_blank" class="btn btn-primary ml-1" href="catalog?client=">Mon catalogue en ligne</a>

                    <button id="shareCatalog" class="btn btn-primary ml-1" >
                    <ion-icon name="share-outline"></ion-icon>Partager mon catalogue</button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0" >
                <table id="example" class="table table-head-fixed text-nowrap">
                  <thead class=" text-primary">
                      <th></th>
                      
                      <th>
                        Nom
                      </th>
                      <th>
                        Boutique
                      </th>
                      <th>
                        Categorie
                      </th>
                      <th>
                          Seuil critique
                      </th>
                      <th>
                        Prix d'achat
                      </th>
                      <th>
                        Frais
                      </th>
                      <th>
                        Total Frais
                      </th>
                      <th>
                        Cout de revient
                      </th>
                      <th>
                        Prix de vente
                      </th>
                       <th>
                        Marge
                      </th>
                      
                      <th>
                        Stock
                      </th>
                      <th>
                        Action
                      </th>
                      <th>
                        Panier
                      </th>
                    </thead>
                    <tbody >
                      
                      <tr  class="products" v-for="(product, index) in products" :key="product.id" :class="getSecClass(index)">
                        <span >
                        <td   v-on:click="editProduct" data-toggle="modal" data-target="#productDetail" class="detail">
                           
                         <img
                        :src="findImage(product.photo)"

                        alt="img" 
                         style="width: 50px; height:50px"
                        >
                        </td>
                        
                        <td v-on:click="editProduct"  class="detail">
                         <strong data-toggle="modal" data-target="#productDetail">{{ product.name }}</strong>
                         <br>
                         
                        </td>
                        <td><span v-if="product.shop">{{product.shop.name}}</span><br>
                         <button @click="updateVariant(index)" data-toggle="modal" data-target="#shopModal" class="btn btn-primary btn-sm">Modifier Boutique</button></td>
                        <td >{{ product.category }}</td>
                        <td>
                         {{ product.secstock }}:  {{getSecState(index)}} <br>
                           <button @click="updateVariant(index)" v-on:click="editProduct"  data-toggle="modal" data-target="#moovingModal" class="btn btn-primary btn-sm mr-1">Gerer</button>
                        </td>
                        <td>
                          {{ product.cost }} F
                        </td>
                        <td>
                         Port: {{ product.port }} F<br>
                          Conditionnement: {{ product.conditioning }} F<br>
                          Etiquettes: {{ product.sticker }} F<br>
                          Publicite: {{ product.ad }} F
                        </td>
                        <td>
                          {{product.port+product.conditioning+product.sticker }}
                        </td>
                        <td>
                            {{product.cost+product.port+product.conditioning+product.sticker }}
                        </td>
                        <td>
                           {{ product.price }} F 
                        </td>
                        <td>
                            {{product.price-product.cost-product.port-product.conditioning-product.sticker-product.ad }}
                        </td>
                        
                        
                        <td>

                          <span :class="product.stock > 0 ? 'text-success' : 'text-danger'">Stock {{ product.stock }}</span><br>
                          <span>Seuil critique: {{ product.secstock }}</span>
                          <br>
                      <button @click="updateVariant(index)" v-on:click="editProduct"  data-toggle="modal" data-target="#moovingModal" class="btn btn-primary btn-sm mr-1">Gerer</button>
                        </td>
                        
                        <td>
                           <button data-toggle="modal" data-target="#deleteProduct" v-on:click="deleteProduct" class="btn btn-danger btn-sm mr-1"><i class="fas fa-trash"></i></button>
                            <button @click="updateVariant(index)" data-toggle="modal" data-target="#addProduct" v-on:click="editProduct" class="btn btn-primary btn-sm mr-1"><i class="fas fa-edit"></i></button>
                      
                     </td>
                     <td>
                         <!-- <button  :disabled="product.stock > 0 ? false : true"  v-on:click="addToCart()" class="btn btn-success btn-sm mr-1 mt-1"><i class="fas fa-cart-plus"></i></button>
                     <button :disabled="product.qty < 1" v-on:click="removeFromCart()" class="btn btn-danger btn-sm  mt-1"><i class="fas fa-minus"></i></button> -->
                     </td>
                     </span>
                      </tr>
                    

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
<script type="text/javascript">
    var CSRF_TOKEN = document.querySelector('[name="csrf-token"]');
    const app = Vue.createApp({
    data() {
        return {
            selectedVariant: 0,
            productAction: "<?php echo e(old('action')); ?>",
            productName: "<?php echo e(old('name')); ?>",
            productDescription: "<?php echo e(old('description')); ?>",
            productStock:"",
            productSecStock: "",
            secQty: "",
            secSuccess: null,
            productPrice:"<?php echo e(old('price')); ?>",
            productCost:"<?php echo e(old('cost')); ?>",
            productConditioning:"<?php echo e(old('conditioning')); ?>",
            productSticker:"<?php echo e(old('sticker')); ?>",
            productAd:"<?php echo e(old('ad')); ?>",
            productCode:"<?php echo e(old('code')); ?>",
            productPort:"<?php echo e(old('port')); ?>",
            productCategory:"<?php echo e(old('category')); ?>",
            productShop:"<?php echo e(old('shop')); ?>",
            productSupplier:"<?php echo e(old('supplier')); ?>",
            productId:"<?php echo e(old('id')); ?>",
            otherFee:"",
            remise:"",
            
            productPhoto:"",
            productTitle:"<?php echo e(old('title')); ?>",
            total:0,
            
            grtTotal: 0,
            cartProducts: [],
            cart:0,
            products: <?php echo $products; ?>,
            stocks: <?php echo $stocks; ?>,


            fee:"",
            costumer:"",
            nature:"",
            source:"",
            delivery_date:"",
            montant:"",
            livraison:"",
            adresse:"",
            oth_fee:"",
            phone:"",
            phone2:"",
            livreur:"",
            observation:"",
            newR:null,
            cmdError:null,
            cmdNature:"",
            cmdProducts:[],
            confirm:null,
             categories: <?php echo $categories; ?>,
            name:"",
            shops: <?php echo $shops; ?>,
            selectedShop:""

        }
    },
    methods:{ 
     newCategory(){
         vm = this
       name = this.name
         axios.post('/addcategory', {
    name: name,
    
    _token: CSRF_TOKEN,
  })

         
  .then(function (response) {
    vm.categories = response.data.updatedCategory
    console.log(response.data.updatedCategory);
  })
  .catch(function (error) {
    console.log(error);
  });
    },

     revomeCategory(id){
         vm = this
    axios.post('/removecategory', {
    id: id,
    
    _token: CSRF_TOKEN,
  })

         
  .then(function (response) {
    vm.categories = response.data.updatedCategory
    console.log(response.data.updatedCategory);
  })
  .catch(function (error) {
    console.log(error);
  });
    },

   getSecClass(index){
     if(this.products[index].secstock){
        if(this.products[index].secstock >= this.products[index].stock){
        return "bg bg-danger"
    }
     }else{
        return ""
     }
   },


   getSecState(index){
     if(this.products[index].secstock){
        if(this.products[index].secstock >= this.products[index].stock){
        return "Seuille critique atteint"
    }else{
        return "Stock suffisant"
     }
     }
   },

     newCmd(){
            vm = this
            fee= this.fee
            costumer= this.costumer
            nature= this.nature
            source= this.source
            delivery_date= this.delivery_date
            montant= this.total
            livraison = this.livraison
            adresse= this.adresse
            oth_fee= this.oth_fee
            phone= this.phone
             phone2= this.phone2
            livreur= this.livreur
            observation = this.observation
            remise = this.remise

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
            fee: fee,
            confirm:vm.confirm,
            costumer: costumer,
            type: nature,
            remise: remise,
            source: source,
            delivery_date: delivery_date,
            montant: montant,
            livraison: livraison,
            adresse: adresse,
            oth_fee: oth_fee,
            phone: phone,
            phone2: phone2,
            livreur: livreur,
            observation: observation,
            _token: CSRF_TOKEN
  })

         
  .then(function (response) {
    if(response.data.confirm != null){
        vm.confirm = response.data.confirm
    }else{
        
        vm.newR = response.data.newCmd
        
                
                 vm.fee= ""
                vm.costumer= ""
                vm.nature= ""
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
                vm.cmdProducts = []
                vm.remise= ""
                element.scrollIntoView({behavior: "smooth", block: "end", inline: "nearest"});

                for(i = 0; i < this.products.length; i++){
                
                    vm.products[i].qty = 0
                           }
            vm.total = 0
            vm.cart = 0
            }
   
 
   
  
  })
  .catch(function (error) {
    addBtn.setAttribute("disabled", "disabled")
    vm.cmdError = "Une erreur s'est produite"
    console.log(error);
  });
    },



    confirmCmd(){
            vm = this

           
            fee= this.fee
            costumer= this.costumer
            nature= this.nature
            source= this.source
            delivery_date= this.delivery_date
            montant= this.total
            livraison = this.livraison
            adresse= this.adresse
            oth_fee= this.oth_fee
            phone= this.phone
            phone2= this.phone2
            livreur= this.livreur
            observation = this.observation
            remise = this.remise
            var addBtn = document.getElementById("addCmd")
             
             var element = document.getElementById("cmdcostumer")
             var cmdForm = document.getElementById("cmdForm")

            

         axios.post('/command-fast-register', {
             products:vm.cmdProducts,
            fee: fee,
            confirm:vm.confirm,
            costumer: costumer,
            type: nature,
            source: source,
            delivery_date: delivery_date,
            montant: montant,
            remise: remise,
            livraison: livraison,
            adresse: adresse,
            oth_fee: oth_fee,
            phone: phone,
            livreur: livreur,
            observation: observation,
            _token: CSRF_TOKEN
  })

         
  .then(function (response) {
    
        
        vm.newR = response.data.newCmd
        vm.commands = response.data.commands 
                vm.confirm = null
                 vm.fee= ""
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
                vm.remise= ""
                vm.observation = ""
                vm.cmdProducts = []

                for(i = 0; i < this.products.length; i++){
                
                    vm.products[i].qty = 0
               
            }
            vm.total = 0
            vm.cart = 0
        
      element.scrollIntoView({behavior: "smooth", block: "end", inline: "nearest"});
 
   
  
  })
  .catch(function (error) {
    addBtn.setAttribute("disabled", "disabled")
    vm.cmdError = "Une erreur s'est produite"
    console.log(error);
  });
    },


cancelCmd(){

               var element = document.getElementById("cmdcostumer")
                vm.fee= ""
                vm.costumer= ""
                vm.nature= ""
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
                vm.confirm = null
                vm.remise= ""
                vm.cmdProducts = []
                 element.scrollIntoView({behavior: "smooth", block: "end", inline: "nearest"});
    },

    editCmd(){

               var element = document.getElementById("cmdcostumer")
                
                this.confirm = null
                this.cmdProducts = []
                
                 element.scrollIntoView({behavior: "smooth", block: "end", inline: "nearest"});
    },






        updateVariant(index) {
        this.selectedVariant = index
        
    },



    categoryEdit() {
        this.edit = 1
        
    },

    categoryEditCancel() {
        this.edit = null
        
    },




        addToCart() {
          this.cart += 1 
          this.products[this.selectedVariant].qty += 1
          this.products[this.selectedVariant].stock -= 1
           this.total += this.products[this.selectedVariant].price 
 
         console.log(this.products)
    },
 
   removeFromCart() {
        this.cart -= 1
        this.products[this.selectedVariant].qty -= 1
         this.products[this.selectedVariant].stock += 1
        this.total -= this.products[this.selectedVariant].price 
      
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

    editProduct(){
            this.productAction= "editproduct",
            this.productName= this.products[this.selectedVariant].name
            this.productCode= this.products[this.selectedVariant].code
            this.productDescription = this.products[this.selectedVariant].description
            this.productStock = this.products[this.selectedVariant].moovings[0].qty

            this.productSecStock = this.products[this.selectedVariant].secstock
            this.productPrice = this.products[this.selectedVariant].price
            this.productId = this.products[this.selectedVariant].id
            this.productPhoto = this.products[this.selectedVariant].photo
            this.productCost = this.products[this.selectedVariant].cost
            this.productConditioning = this.products[this.selectedVariant].conditioning
            this.productPort = this.products[this.selectedVariant].port

            this.productSticker = this.products[this.selectedVariant].sticker
            this.productAd = this.products[this.selectedVariant].ad
            this.productCategory = this.products[this.selectedVariant].category

            this.productShop = this.products[this.selectedVariant].shop_id
            this.productSupplier = this.products[this.selectedVariant].supplier_id
            this.productTitle = "Modifier produit "+ this.products[this.selectedVariant].name

            this.secSuccess = null
    },

    
    addProduct(){
            this.productAction = "createproduct"
            this.productTitle = "Ajouter un produit"
            this.productName = ""
            this.productCode = ""
            this.productDescription = ""
            this.productStock = ""
            this.productSecStock = ""
            this.productPrice = ""
            this.productCost = ""
            this.productConditioning = ""
            this.productSticker = ""
            this.productPort = ""
            this.productAd = ""
            this.productCategory = ""
            this.productShop = ""
            this.productSupplier = ""
    },


    deleteProduct(){
           
            
            this.productId = this.products[this.selectedVariant].id
            this.productPhoto = this.products[this.selectedVariant].photo
             this.productName= this.products[this.selectedVariant].name
    },

     confirmDelete(id){
    vm = this
    axios.post('/removeproduct', {
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

    setShop(id){
     vm = this

    axios.post('/setshop', {
    id: id,
    shop:vm.selectedShop,

    _token: CSRF_TOKEN,
  })

         
  .then(function (response) {
    
    vm.products[vm.selectedVariant].shop = response.data.shop
    vm.products[vm.selectedVariant].shop_id = vm.selectedShop
    vm.selectedShop = ''
  })
  .catch(function (error) {
    alert("Une erreur s'est produite")
    console.log(error);
  });
    },

    setSecStock(){
        vm = this
    axios.post('/setsecstock', {
    id: this.productId,
    qty: this.secQty,
    _token: CSRF_TOKEN,
  })

         
  .then(function (response) {
    vm.secSuccess = 1
    vm.products[vm.selectedVariant].secstock = vm.secQty
    vm.productSecStock = vm.secQty
    
  })
  .catch(function (error) {
    console.log(error);
    alert("Une erreur s'est produite!")
  });
    }


   },
   computed:{
     greatTotal(){
        if(this.livraison != 'autre')
        {selectedFee = Number(this.livraison)}
        else{
            selectedFee = Number(this.oth_fee) 
        }
        this.grtTotal = Number(this.total) + selectedFee - Number(this.remise)
        return this.grtTotal
     },

     danger(){
        
        if(this.grtTotal<=0){
            return "text-danger"
        }
     }
    }
});

    const mountedApp = app.mount('#app')
  </script>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="../../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>

<!-- AdminLTE App -->
<script src="../../dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../../dist/js/demo.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

<?php if(old('action')): ?>
<script type="text/javascript">
    $('#addProduct').modal("show");
</script>
<?php endif; ?>
<script type="text/javascript">
    
$('#example').DataTable(
    {"paging": false,}
    );
 
function filterGlobal() {
    $('#example')
        .DataTable()
        .search($('#global_filter').val(), $('#global_regex').prop('checked'), $('#global_smart').prop('checked'))
        .draw();
}
 
function filterColumn(i) {
    $('#example')
        .DataTable()
        .column(i)
        .search(
            $('#col' + i + '_filter').val(),
           
        ).draw();
}
 

    
 
 
    $('#col3_filter').on('change', function () {
        $('#example')
        .DataTable()
        .column(3)
        .search(
            $(this).val(),
           
        ).draw();
    });


    $('#col4_filter').on('change', function () {
        $('#example')
        .DataTable()
        .column(4)
        .search(
            $(this).val(),
           
        ).draw();
    });

     $('#col2_filter').on('change', function () {
        $('#example')
        .DataTable()
        .column(2)
        .search(
            $(this).val(),
           
        ).draw();
    });




    
</script>
</body>
</html>
<?php /**PATH /var/www/html/admin/resources/views/products.blade.php ENDPATH**/ ?>