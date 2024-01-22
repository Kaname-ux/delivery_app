<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
  <title>Tarifs</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
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

<script src="https://unpkg.com/vue@3"></script> 
 <!-- use the latest vue-select release -->

<div id="app" class="wrapper">
  <!-- Navbar -->
 <?php echo $__env->make("includes.navbar", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
  <div class="modal fade " id="priceModal" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" v-if="selected != null">AJouter tarif {{fees[selected].destination}}</h5>
                        <a id="bulkActionClose" href="javascript:;" data-dismiss="modal">Fermer</a>
                    </div>
                    <div class="modal-body">
                        <div class="action-sheet-content">
                               <div class="alert alert-success" v-if="success != ''">{{success}}</div>
                                 <div class="form-group">
                                  <label>Désignation</label>
                                  <input v-model="name" type="" name="name" class="form-control">
                                </div>

                                <div class="form-group">
                                  <label>Prix</label>
                                  <input v-model="price" type="number" name="price" class="form-control">
                                </div>

                                <div class="form-group">
                                  <label>Delai(en jour)</label>
                                  <input v-model="description" type="number" name="description" class="form-control">
                                </div>

                                <button @click="updatePrice" :disabled="id == '' || description == '' || price == '' || name == '' || processing == 1" class="btn btn-primary btn-block">Enregistrer</button>
                             
                            <hr>
                            <div v-if='selected != null'>
                              <div v-if="fees[selected].tarifs.length > 0">
                              <div class="alert alert-success" v-if="editSuccess != ''">{{editSuccess}}</div>
                              <h5>Modifier tarifs</h5>
                              <form class="form-inline">
                              <div v-for="tarif in fees[selected].tarifs" class="form-group">
                                <input :id="'prc'+tarif.id" class="form-control" type="number" :value="tarif.price" name="">
                                <input :id="'name'+tarif.id" class="form-control" type="" :value="tarif.name" name="">
                                <input :id="'desc'+tarif.id" class="form-control" type="number" :value="tarif.description" name="">
                                <button :disabled="processing == 1"  @click="updateTarif(tarif.id)" type="button" class="btn btn-sm btn-primary">modifer</button>
                                 <button @click="deleteTarif(tarif.id)" :disabled="processing == 1" type="button" class="btn btn-sm btn-danger"><i   name="btn" value="Supprimer"  class="fas fa-trash"  ></i></button>
                              </div>
                              </form>
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
          <div class="col-sm-6">
            <h1>Liste des tarifs</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="dashboard">Home</a></li>
              <li class="breadcrumb-item active">Tarifs</li>
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
                <h3 class="card-title">Liste des tarifs</h3>

                <div class="card-tools">
                  <a href="fee-form"  class="btn btn-success">Nouveau tarif</a>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0" >
                <table class="table table-head-fixed text-nowrap">
                  <thead class=" text-primary">
                      <th></th>

                      <th>
                        Destination
                      </th>
                      <th>
                        Tarif
                      </th>
                     <th>
                       nbre de commande
                     </th>
                      
                    </thead>
                    <tbody>
                     
                      <tr v-for="(fee, index) in fees">
                        
                        <td>
                          

                          <form  :id="'myForm'+fee.id"   method="POST" :action="'/fee-delete/'+fee.id">
                            <?php echo e(csrf_field()); ?>

                        <?php echo e(method_field('DELETE')); ?>

                       
                        <button :id="'submitBtn'+fee.id" @click="confirm('Voulez vous vraiment supprimer '+fee.destination)" class="btn btn-danger btn-sm mr-1" type="submit"><i   name="btn" value="Supprimer"  class="fas fa-trash"  ></i></button>

                          <a :href="'/feeedit/'+fee.id" class="btn btn-sm btn-primary mr-1" ><i class="fas fa-edit"></i>Modifier</a>

                         <button @click="getSelected(index)" type="button" data-toggle="modal" data-target="#priceModal" class="btn btn-sm btn-primary">Modifier tarif</button>
                       </form>


                          
                        </td>
                        <td>
                          {{fee.destination}}
                        </td>
                        <td>
                         par de defaut: {{fee.price}}<br>

                         <span v-if="fee.tarifs.length > 0" v-for="tarif in fee.tarifs">
                           {{tarif.name}} : {{tarif.description}} : {{tarif.price}}<br>
                         </span>
                        </td>

                        <td>
                          {{fee.command.length}}
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
</div>
<!-- ./wrapper -->


<script>

   const app = Vue.createApp({
    data() {
        return {
          fees: <?php echo $fees; ?>,
          price: "",
          name:"",
          description: "",
          destination: "",
          id: null,
          processing: null,
          success: "",
          editSuccess: "",
          tarifs: null,
          selected: null

              }
    },
    methods:{  
    getSelected(index){
      this.selected = index
    },

    updatePrice(){
     var vm = this

     this.processing = 1
    axios.post('/updateprice', {
            
            id:vm.fees[vm.selected].id,
            description: vm.description,
            price: vm.price,
            name:vm.name,
           
            
            _token: CSRF_TOKEN
  })

         
  .then(function (response) {
    vm.success = "Prix enregistré"
     vm.processing = null
     vm.fees = response.data.fees
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
     vm.fees = response.data.fees
    
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
     vm.fees = response.data.fees
     
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
</body>
</html>
<?php /**PATH /htdocs/clients/logistica/admin/resources/views/fees.blade.php ENDPATH**/ ?>