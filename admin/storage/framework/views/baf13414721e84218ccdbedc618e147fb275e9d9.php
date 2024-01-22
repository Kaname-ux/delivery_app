<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
  <title>Abonnements</title>

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
            <h1>Liste des offres d'Abonnement</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="dashboard">Home</a></li>
              <li class="breadcrumb-item active">Abonnements</li>
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
                <h3 class="card-title">Liste des Offres</h3>

                <div class="card-tools">
                  <button data-toggle="modal" data-target="#offerModal" @click="addOffer"  class="btn btn-success">Nouvelle offre</button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0" >
                <table class="table table-head-fixed text-nowrap">
                  <thead class=" text-primary">
                      <th></th>
                      <th>Type</th>
                      <th>Nom</th>
                      <th>
                        Description
                      </th>
                      <th>
                        Couverture
                      </th>
                      <th>
                        Cout
                      </th>
                     <th>
                      Quantité
                     </th>
                     <th>
                       Durée
                     </th>
                      
                    </thead>
                    <tbody>
                     
                      <tr v-for="(offer, index) in offers">
                       
                        
                        <td>
                          

                          
                       
                        <button data-toggle="modal" data-target="#confirmModal" @click="deleteOffer(index)" class="btn btn-danger btn-sm mr-1" ><i   name="btn" value="Supprimer"  class="fas fa-trash"  ></i></button>

                          <button type="button" data-toggle="modal" data-target="#offerModal" @click="editOffer(index)" class="btn btn-sm btn-primary mr-1" ><i class="fas fa-edit"></i>Modifier</button>

                        
                    


                          
                        </td>
                         <td>{{offer.offer_type}} </td>
                        <td>{{offer.nom}} </td>
                        <td>
                          {{offer.description}}
                        </td>
                         <td>
                          {{offer.offer_zones}} 
                        </td>
                        <td>
                          {{offer.cost}}
                        </td>

                        <td>
                          {{offer.qty}}
                        </td>

                        <td>
                           {{offer.duration}}
                        </td>


                        
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




  <div   class="modal fade" id="offerModal"  tabindex="-1" role="dialog">
            <div  class="modal-dialog" role="document">
                <div  class="modal-content">
                    <div class="modal-header">
                      <h5 @click="addProduct" class="modal-title editModalTitle">{{title}}</h5>
                        <a href="javascript:;" data-dismiss="modal">Fermer</a>
                        
                        

                    </div>
                    <div   class="modal-body">
                        <form method="post" enctype="multipart/form-data" :action="offerAction" >
                            <?php echo csrf_field(); ?>

                            <input hidden v-model="id" name="id">
                            <input hidden type="" name="errorTrigger" v-model="errorTrigger">


                             <div class="form-group">
                                <label>Type d'offre*</label>
                          <select  v-model="offerType"  required  class="form-control" name="offer_type">
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

                            <div  class="form-group">
                            <label class="form-label ">Zone de couverture </label>
                              <select data-style="btn-dark"  v-model="zones" title="Choisir zones..." id="zone-select" class="select2 form-control" multiple="multiple" data-placeholder="selectionner livreur(s)"  name="zones[]">
                                <option value="Abidjan">Abidjan</option>
                                 <?php $__currentLoopData = $zones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $zone): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                  <option value="<?php echo e($zone->destination); ?>"><?php echo e($zone->destination); ?></option>
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
                                <label>Nom*</label>
                                <input value="<?php echo e(old('nom')); ?>" v-model="nom" name="nom"  autocomplete="off" placeholder="Saisir un nom" class="form-control border border-primary" type="" >

                                <?php if ($errors->has('nom')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('nom'); ?>
                            <span class="invalid-feedback" role="alert">
                            <strong><?php echo e($message); ?></strong>
                                </span>
                              <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>
                                
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

                         

                           

                            


                            <button type="submit" class="btn btn-primary">Enregistrer</button>
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
       <button hidden id="addCostumerBtn" data-toggle="modal" data-target="#offerModal"></button>
</div>
<!-- ./wrapper -->


<script>

   const app = Vue.createApp({
    data() {
        return {
          offers: <?php echo $offers; ?>,
        
          id: null,
          processing: null,
          success: "",
          editSuccess: "",
        
          selected: null,
          offerAction: "createoffer",
          offerType: "",
           duration: "",
          description: "",
          cost : "",
          qty : "" ,
          supSend : "",
          supSendUrgent : "",
          supSendRingroad : "",
          supSendOut : "",
          nom: "",
          zone: "",
          title: "Ajouter offre",
          errorTrigger: "addOfferBtn",

              }
    },
    methods:{  





    editOffer(index){
           this.offerAction= "editoffer"
            this.offerType= this.offers[index].offer_type
            this.description= this.offers[index].description
            this.cost = this.offers[index].cost
            this.qty = this.offers[index].qty
            this.duration = this.offers[index].duration
            this.id = this.offers[index].id
            this.nom = this.offers[index].nom
            this.zones = this.offers[index].offer_zones

          

            this.title = "Modifier offre "+ this.offers.data[index].nom

            this.errorTrigger = "edit"+index
    },

    
    addOffer(){
            this.offerAction= "createoffer"
            this.offer_type= ""
            this.description= ""
            this.cost = ""
            this.qty = "" 
            this.nom = ""
            this.supSend = ""
            this.supSendUrgent = ""
            this.supSendRingroad = ""
            this.supSendOut = ""
             this.nom = ""
            this.title = "Ajouter offre"
            this.errorTrigger = "addOfferBtn"
    },


    deleteOffer(index){
           
            
            this.id = this.offers[index].id
             this.title = "Supprimer "+ this.offers[index].nom
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
<script src="../../plugins/select2/js/select2.full.min.js"></script>

<script type="text/javascript">var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');</script>

<script type="text/javascript">
  $('#zone-select').select2()
</script>
</body>
</html>
<?php /**PATH /var/www/html/jibiat/admin/resources/views/abonnements.blade.php ENDPATH**/ ?>