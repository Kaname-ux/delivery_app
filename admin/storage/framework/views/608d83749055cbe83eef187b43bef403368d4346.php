<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Clients</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">

   <link rel="stylesheet" href="../../plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="../../plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="../../plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <link rel="stylesheet" href="../../plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="../../plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
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
  <!-- Navbar -->
 <?php echo $__env->make("includes.navbar", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Liste des client</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="dashboard">Home</a></li>
              <li class="breadcrumb-item active">Clients</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

       <div class="modal fade" id="filterModal" tabindex="-1" role="dialog">
            <div  class="modal-dialog" role="document">
                <div  class="modal-content">
                    <div class="modal-header">
                        
                        <h5 class="modal-title">Filter</h5>
                        
                        <a href="javascript:;" data-dismiss="modal">Fermer</a>
                    </div>
                    <div   class="modal-body">
                        <div class="action-sheet-content ">
                            <form action="?">
                                
                                <div class="form-group">
                            <label class="form-label">Filter par commune/ville</label>
                              <select  id="fee-select" class="select2 form-control" multiple="multiple" data-placeholder="selectionner communes(s)"  name="fees[]">
                               
                                 <?php $__currentLoopData = $fees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                  <option value="<?php echo e($fee->destination); ?>"><?php echo e($fee->destination); ?></option>
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
                                    
                                
                          
                          <div class="form-group">
                            <label class="form-label ">Filter par sexe</label>
                              <select title="Choisir sexes..." id="sexe-select" class="select2 form-control" multiple="multiple" data-placeholder="selectionner sexe(s)"   name="sexes[]">
                               
                                  
                                  
                                  <option  value="F">Femme</option>
                                  <option  class="H">Homme</option>
                                
                                 
                                 </select>
                                 <?php if ($errors->has('sexes')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('sexes'); ?>
                                   <span class="invalid-feedback" role="alert">
                               <strong><?php echo e($message); ?></strong>
                                </span>
                              <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>
                          </div>
                          

                           

                        <div class="form-group">
                            <label class="form-label">Montant achat superieur ou egal a</label>
                            <input name="montant" type="number" class="form-control"  >
                                

                          </div>

                          <button  class="btn btn-primary btn-block">Filtrer</button>
                          </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>



       <div   class="modal fade" id="addCostumer"  tabindex="-1" role="dialog">
            <div  class="modal-dialog" role="document">
                <div  class="modal-content">
                    <div class="modal-header">
                      <h5 @click="addProduct" class="modal-title editModalTitle">{{costumerTitle}}</h5>
                        <a href="javascript:;" data-dismiss="modal">Fermer</a>
                        
                        

                    </div>
                    <div   class="modal-body">
                        <form method="post" enctype="multipart/form-data" :action="costumerAction" >
                            <?php echo csrf_field(); ?>

                            <input hidden :value="costumerId" name="id">
                            <input hidden type="" name="errorTrigger" v-model="errorTrigger">
                            <div class="form-group">
                                <label>Nom du Client</label>
                                <input value="<?php echo e(old('name')); ?>" v-model="costumerName" name="name"  autocomplete="off" placeholder="Saisir le nom du client" class="form-control border border-primary" type="" >

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

                            <div class="form-group">
                                <label>Ville/Commune*</label>
                          <select  v-model="costumerLocality"  required  class="form-control" name="locality">
                             <option  value="">selectionner Une ville/commune</option>
                             <?php $__currentLoopData = $fees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                           <option 
                            <?php if(old('fee') == $fee->id): ?> selected <?php endif; ?>
                            value="<?php echo e($fee->destination); ?>"><?php echo e($fee->destination); ?></option>
                           <div id="fee_price"></div>
                           <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                            <?php if ($errors->has('locality')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('locality'); ?>
                            <span class="invalid-feedback" role="alert">
                            <strong><?php echo e($message); ?></strong>
                                </span>
                              <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>
                                
                            </div>

                            <div class="form-group">
                                <label>Adresse</label>
                                <input value="<?php echo e(old('adress')); ?>" v-model="costumerAdress" name="adress" autocomplete="off" placeholder="Saisir adresse du client" class="form-control border border-primary" type="" >
                                <?php if ($errors->has('adress')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('adress'); ?>
                            <span class="invalid-feedback" role="alert">
                            <strong><?php echo e($message); ?></strong>
                                </span>
                              <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>
                            </div>

                             <div class="form-group">
                                <label>Contact*</label>
                                <input v-model="costumerContact" required name="contact" value="<?php echo e(old('contact')); ?>" autocomplete="off" placeholder="Saisir contact du client" class="form-control border border-primary" type="number" >

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
                             <div class="form-group">
                                <label>Whatsapp</label>
                                <input v-model="costumerWhatsapp" name="whatsapp" value="<?php echo e(old('whatsapp')); ?>"  autocomplete="off" placeholder="Saisir numero whatsapp du client" class="form-control border border-primary" type="number" >

                                <?php if ($errors->has('whatsapp')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('whatsapp'); ?>
                            <span class="invalid-feedback" role="alert">
                            <strong><?php echo e($message); ?></strong>
                                </span>
                              <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>
                                
                            </div>

                            <div class="form-group">
                                <label>Email</label>
                                <input v-model="costumerEmail" name="email" autocomplete="off" placeholder="Saisir adresse email du client" value="<?php echo e(old('email')); ?>" class="form-control border border-primary" type="email" >

                                <?php if ($errors->has('email')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('email'); ?>
                            <span class="invalid-feedback" role="alert">
                            <strong><?php echo e($message); ?></strong>
                                </span>
                              <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>
                                
                            </div>

                            <div class="form-group">
                                <label>Sexe</label>
                                <select v-model="costumerSexe" required class="form-control" name="sexe">
                                  <option value="">Choisir Sexe</option>
                                  <option :selected="costumerSexe == 'N'" value="N">Je ne sais pas</option>
                                  <option :selected="costumerSexe == 'F'" value="F">Femme</option>
                                  <option :selected="costumerSexe == 'H'" class="H">Homme</option>
                                </select>

                                <?php if ($errors->has('sexe')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('sexe'); ?>
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
      <div class="container-fluid">
        
            <?php if(session('status')): ?>
                        <div class="alert alert-success" role="alert">
                            <?php echo e(session('status')); ?>

                        </div>
                    <?php endif; ?>

        <?php if($filter != "" || $search_result): ?>    
        <div class="row">
           
           <p> <a href="/clients" class=" d-print-none">Voir tous les clients</a></p>
            </div>
        <?php endif; ?>        
       <div class="row mb-2">
            <form>
              <div class="input-group input-group-sm" style="width: 300px;">

                    <select name="search_type" class="form-control">
                      <option value="contact">Par contact</option>
                      <option value="email">Par mail</option>
                      <option value="name">Par nom</option>
                      <option value="whatsapp">Par Numero whatspp</option>
                    </select>
                    <input  type="text" name="search_term" class="form-control float-right" placeholder="Recherche">

                    <div class="input-group-append">
                      <button type="submit" class="btn btn-default">
                        <i class="fas fa-search"></i>
                      </button>
                    </div>
                  </div>
                </form> 

                
       </div>

          <?php if($search_result != ""): ?>
                 <div class="row">
           <p> <?php echo e($search_result); ?> </p>

            </div>

             
            <?php endif; ?>

        <!-- /.row -->
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Liste des clients</h3>
                 <?php if($filter != ""): ?>
                 <br>
            <?php echo $filter; ?> 

            <a href="/clients" class=" d-print-none">Voir tous les clients</a>
            
            <?php endif; ?>

                <div class="card-tools">
                  <!-- <div class="input-group input-group-sm" style="width: 150px;">
                    <input id="Search" onkeyup="search()" type="text" name="table_search" class="form-control float-right" placeholder="Recherche">

                    <div class="input-group-append">
                      <button type="submit" class="btn btn-default">
                        <i class="fas fa-search"></i>
                      </button>
                    </div>
                  </div> -->

                  <button @click="addCostumer" data-toggle="modal" data-target="#addCostumer" class="btn btn-primary mr-2">Ajouter un client</button>

                   <button data-toggle="modal" data-target="#filterModal" class="btn btn-sm btn-light phone"><ion-icon name="filter-outline"></ion-icon>Filtrer</button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0" style="height: 600px;">
                <table id="example" class="table table-head-fixed text-nowrap">
                  <thead class=" text-primary">
                      
                      <th></th>
                      
                      <th>
                        Nom
                      </th>
                      <th>
                        Ville/commune
                      </th>
                      <th>
                        Adresse
                      </th>
                      <th>
                        contact
                      </th>
                      <th>
                        whatsapp
                      </th>

                      <th>
                        Email
                      </th>

                      <th>
                        Sexe
                      </th>
                      
                      
                      
                    </thead>
                    <tbody>
                     
                      <tr @mouseover="updateVariant(index)" class="target" v-for="(costumer, index) in costumers.data">
                        <td>
                      <button :id="edit+index" data-toggle="modal" data-target="#addCostumer" class="btn btn-primary" @click="editCostumer">Modifier</button>
                        </td>
                        <td>
                         {{costumer.name}}
                         
                        </td>
                        
                        <td>
                          {{costumer.locality}}

                        </td>
                        <td>
                          {{costumer.adress}}
                        </td>
                        <td>
                          {{costumer.contact}}
                        </td>
                        <td>
                          {{costumer.whatsapp}}
                        </td>

                        <td>
                          {{costumer.email}}
                        </td>

                        <td>
                          {{costumer.sexe}}
                        </td>
                       
                      </tr>



                     
                    </tbody>
                </table>
                <?php echo e($clients->links()); ?>

              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        </div>
      <button hidden id="addCostumerBtn" data-toggle="modal" data-target="#addCostumer"></button>
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
  const app = Vue.createApp({
    data() {
        return {
            selectedVariant: 0,
            costumerAction: "createcostumer",
            costumerName: "",
            costumerLocality: "",
            costumerAdress: "",
            costumerContact: "",
            costumerWhatsapp: "",
            costumerSexe: "",
            costumerTitle:"Ajouter un client",
            costumers: <?php echo $costumers; ?>,
            costumerEmail:"",
            costumerId: 0,
            errorTrigger:"",



        }
    },
    methods:{ 
     

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

   


        updateVariant(index) {
        this.selectedVariant = index
        
    },



    editCostumer(){
            this.costumerAction= "editcostumer",
            this.costumerName= this.costumers.data[this.selectedVariant].name
            this.costumerLocality= this.costumers.data[this.selectedVariant].locality
            this.costumerAdress= this.costumers.data[this.selectedVariant].adress
            this.costumerContact= this.costumers.data[this.selectedVariant].contact 
            this.costumerWhatsapp= this.costumers.data[this.selectedVariant].whatsapp
            this.costumerEmail= this.costumers.data[this.selectedVariant].email
            this.costumerSexe= this.costumers.data[this.selectedVariant].sexe
            this.costumerId= this.costumers.data[this.selectedVariant].id

            this.costumerTitle = "Modifier client "+ this.costumers.data[this.selectedVariant].name

            this.errorTrigger = "edit"+this.selectedVariant
    },

    
    addCostumer(){
            this.costumerAction= "createcostumer",
            this.costumerName= ""
            this.costumerLocality= ""
            this.costumerAdress= ""
            this.costumerContact= "" 
            this.costumerWhatsapp= ""
            this.costumerEmail= ""
            this.costumerSexe= ""
            this.costumerId= 0

            this.costumerTitle = "Ajouter client "
            this.errorTrigger = "addCostumerBtn"
    },


    deleteCostumer(){
           
            
            this.costumerId = this.costumers[this.selectedVariant].id
            
             this.costumerName= this.costumers[this.selectedVariant].name
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

  
   },
   computed:{
     
    }
});

    const mountedApp = app.mount('#app')


</script>
<?php if(old('errorTrigger')): ?>
<script type="text/javascript">
  $('#'+<?php echo e(old('errorTrigger')); ?>).click();
</script>
<?php endif; ?>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="../../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../../plugins/select2/js/select2.full.min.js"></script>
<script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="../../dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../../dist/js/demo.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
<script type="text/javascript">
 $('#sexe-select').select2();
$('#fee-select').select2();
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
  }
</script>
</body>
</html>
<?php /**PATH /htdocs/clients/logistica/admin/resources/views/clients.blade.php ENDPATH**/ ?>