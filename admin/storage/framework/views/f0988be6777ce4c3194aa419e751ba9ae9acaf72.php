<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Utilisateurs</title>

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
  <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
 <script src="https://unpkg.com/vue@3"></script>
<div class="wrapper" id="app">

     <div class="modal fade" id="departmentModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header text-center">
        <h4 class="modal-title w-100 font-weight-bold">
          Ajouter département {{client}}
        </h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body mx-3">
        <div class="md-form mb-5">
            <form method="POST" action="/add-department">
              <?php echo csrf_field(); ?>
              <input v-model="id" :value="id" name="id" hidden>
              <div class="form-group">
                <label>Nom du département</label>
                <input v-model="nom" class="form-control" type="" name="nom">
                
              </div>
            <button :disabled="processing == 1 || id=='' || nom == ''" @click="addDepartment" type="button" class="btn btn-primary">Definir</button>
         </form>
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
            <h1>Liste des Utilisateurs</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="dashboard">Home</a></li>
              <li class="breadcrumb-item active">Utilisateurs</li>
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
            <div class="card">
              <div class="card-header">
                <h3 class="card-title"><a href="users"> Liste des utilisateurs</a></h3>
                    
                <div class="card-tools">
                  <a href="/client-form" class="btn btn-success">Ajouter</a>
                </div>

              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0" >
                <form class="form-inline ml-2">
                      <input placeholder="Recherche par nom ou par numero de téléphone" class="form-control" type="" name="search">
                      <button class="btn btn-primary">Rechercher</button>
                    </form>
                <table class="table table-bordered table-striped d-print-none table-responsive">
                   <thead class=" text-primary">
                      <th>Id</th>
                      <th>Type</th>
                      
                      <th>
                        Nom
                      </th>
                      <th>
                        Total cmds
                      </th>
                      <th>
                        contact
                      </th>
                      <th>
                        Commune
                      </th>
                      <th>
                        Adresse
                      </th>
                      <th>
                        Departements
                      </th>
                      <th>
                        Date d'inscription
                      </th>
                      <th>
                         Montant actif
                      </th>
                      <th>
                     Compte
                      </th>
                   <th>Whatsapp</th>
                      
                    </thead>
                    <tbody>
                      <?php $__currentLoopData = $clients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $x=>$client): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                      <tr>
                        
                        <td>
                           
                          <?php echo e($client->id); ?> 
                          <a href="/clientedit/<?php echo e($client->id); ?>" ><i class="fas fa-edit"></i></a>

                         <!--  <form  id="myForm"   method="POST" action="/client-delete/<?php echo e($client->id); ?>">
                            <?php echo e(csrf_field()); ?>

                        <?php echo e(method_field('DELETE')); ?>

                         <input onclick="myFunction<?php echo e($client->id); ?>()" name="btn" value="Supprimer" size="7px" id="submitBtn" data-toggle="modal"  class="btn btn-danger btn-sm" />
                       </form>


                      <script>
function myFunction<?php echo e($client->id); ?>() {
  confirm("Confirmer!");
}
</script> -->
                         
                        </td>
                        <td>
                          <?php echo e($client->client_type); ?>

                        </td>
                        
                        <td>
                          
                          <form action="useractions">
                            
                            <input hidden type="" value="<?php echo e($client->user_id); ?>" name="id">
                            <button class="btn  btn-light" type="submit"> <?php if($active_commands->count()>0): ?>
                          <?php $__currentLoopData = $active_commands; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $active): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                          <?php if($active->client_id == $client->id): ?>
                          <span class="dot"></span>
                          <?php endif; ?>
                          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                          <?php else: ?>
                          <?php endif; ?><?php echo e($client->nom); ?></button>
                          </form>
                          
                          <?php if($client->client_type == "PARTENAIRE"): ?>
                          <?php if(App\Client::where("id", $client->cc_id)->count() == 1): ?>
                          

                           <div class="accordion" id="cmdDate<?php echo e($x); ?>">
                <div class="item">
                    <div class="accordion-header">
                        <button class="btn   collapsed" type="button" data-toggle="collapse"
                            data-target="#accordion1<?php echo e($x); ?>">
                           <div class="tools">
                            <?php echo e(App\Client::where("id", $client->cc_id)->first()->nom); ?>

                      <i class="fas fa-edit"></i>
                      <i class="fas fa-trash-o"></i>
                    </div>

                        </button>


                    </div>

                          <div id="accordion1<?php echo e($x); ?>" class="accordion-body collapse" data-parent="#cmdDate<?php echo e($x); ?>">
                        <div class="accordion-content">
                            <form method="POST" action="set-conseiller">
                              <?php echo csrf_field(); ?>
                              <input type="" value="<?php echo e($client->id); ?>" hidden name="client_id">
                            <div class="form-group">
                                <select name="cc_id" class="form-control" required>
                                  <option value="">Chosir Conseiller client</option>
                                  <?php $__currentLoopData = App\Client::where('client_type', "CONSEILLER_CLIENT")->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $conseiller): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                   <option <?php if($conseiller->id == App\Client::where("id", $client->cc_id)->first()->id): ?> selected <?php endif; ?> value="<?php echo e($conseiller->id); ?>"> <?php echo e($conseiller->nom); ?> </option>
                                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>

                                
                            </div>

                            <button  class="btn btn-primary mt-1 mr-1">Defifinir</button>

                            <button class="btn btn-danger  collapsed" type="button" data-toggle="collapse"
                            data-target="#accordion1<?php echo e($x); ?>">
                            Fermer
                          </button>
                           </form>
                        </div>
                    </div>
                </div>
            </div>


                         



                          <?php else: ?>
                          

                              <div class="accordion" id="cmdDate<?php echo e($x); ?>">
                <div class="item">
                    <div class="accordion-header">
                        <button class="btn   collapsed" type="button" data-toggle="collapse"
                            data-target="#accordion1<?php echo e($x); ?>">
                           <div class="tools">
                            Conseiller client non defini
                      <i class="fas fa-edit"></i>
                      <i class="fas fa-trash-o"></i>
                    </div>

                        </button>


                    </div>

                          <div id="accordion1<?php echo e($x); ?>" class="accordion-body collapse" data-parent="#cmdDate<?php echo e($x); ?>">
                        <div class="accordion-content">
                            <form method="POST" action="set-conseiller">
                              <?php echo csrf_field(); ?>
                              <input type="" value="<?php echo e($client->id); ?>" hidden name="client_id">
                            <div class="form-group">
                                <select name="cc_id" class="form-control" required>
                                  <option value="">Chosir Conseiller client</option>
                                  <?php $__currentLoopData = App\Client::where('client_type', "CONSEILLER_CLIENT")->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $conseiller): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                   <option value="<?php echo e($conseiller->id); ?>"> <?php echo e($conseiller->nom); ?> </option>
                                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>

                                
                            </div>

                            <button  class="btn btn-primary mt-1 mr-1">Defifinir</button>

                            <button class="btn btn-danger  collapsed" type="button" data-toggle="collapse"
                            data-target="#accordion1<?php echo e($x); ?>">
                            Fermer
                          </button>
                           </form>
                        </div>
                    </div>
                </div>
            </div>




                          
                          <?php endif; ?>
                          <?php endif; ?>

                        </td>

                        <td>
                          <?php echo e($client->command->count()); ?>

                        </td>
                        <td>
                          <?php echo e($client->phone); ?>

                        </td>
                        <td>
                          <?php echo e($client->city); ?>

                        </td>
                        <td>
                          <?php echo e($client->adresse); ?>

                        </td>
                        <td>
                          <?php if($client->departments->count() > 0): ?>
                          <ul>
                             <?php $__currentLoopData = $client->departments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $department): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                          <li><?php echo e($department->name); ?> <i :disabled="processing == 1" @click="deleteDepartment('<?php echo e($department->id); ?>')" class="fas fa-trash text-danger"></i></li>
                          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                          </ul>
                         
                          <?php endif; ?>
                          

                          <button @click="getSelectedClient('<?php echo e($client->id); ?>', '<?php echo e(addslashes($client->nom)); ?>')" data-toggle="modal" data-target="#departmentModal" class="btn btn-primary">Modifier</button>
                        </td>
                        
                        <td>
                          <?php echo e($client->created_at); ?>

                        </td>
                        
                        <td >
                          <?php if($active_commands->count()>0): ?>
                          <?php $__currentLoopData = $active_commands; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $active): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                          <?php if($active->client_id == $client->id): ?>
                          <?php echo e($active->montant); ?>

                          <?php endif; ?>
                          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                          <?php else: ?>
                          <?php endif; ?>
                        </td>
                        <td>
                         <?php if($client->user): ?>
                          <?php echo e($client->user->email); ?>

                          <form method="POST" action="/unset-client-account/<?php echo e($client->user->id); ?>">
                            <?php echo csrf_field(); ?>
                          <button   type="submit"   class="btn btn-success btn-sm" >
                            Dissocier</button>
                          </form>
                          <?php else: ?>

                           
                         <button  class="mt-1"  name="btn" data-toggle="modal" data-target="#modalLoginForm<?php echo e($client->id); ?>"  class="btn btn-succes btn-sm" >Associer un compte</button>
                       

                          <?php endif; ?>



                          <?php if($client->is_certifier == NULL): ?>
                          
                          <form class="mt-1" method="POST" action="/makecertifier">
                            <?php echo csrf_field(); ?>
                            <input hidden name="client_id" value="<?php echo e($client->id); ?>">
                          <button   type="submit"   class="btn btn-success btn-sm" >
                            Rendre certificateur</button>
                          </form>
                          <?php else: ?>

                           
                          <form class="mt-1" method="POST" action="/unset-certifier">
                            <?php echo csrf_field(); ?>
                           <input type="" hidden name="client_id" value="<?php echo e($client->id); ?>">
                          <button   type="submit"   class="btn btn-danger btn-sm" >Ne plus certifier</button>
                          </form>
                       

                          <?php endif; ?>

                          
                         </td>
                        <td>
                          <a target="blank" class="text-success" href="https://wa.me/225<?php echo e($client->phone); ?>?text=Bonjour <?php echo e($client->nom); ?>. Merci de votre inscription sur notre plateform. Retrouvez ici une liste de livreurs certifiés(pièces d'identite et photos vérifiées et stockées dans la base de donnée)
                            https://client.livreurjibiat.site/livreurs_public" aria-hidden="true">WhatsApp</a>
                        </td>

                       
                      </tr>




                      <div class="modal fade" id="modalLoginForm<?php echo e($client->id); ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header text-center">
        <h4 class="modal-title w-100 font-weight-bold"></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body mx-3">
        <div class="md-form mb-5">
            <form method="POST" action="/set-client-account">
             <?php echo csrf_field(); ?>
              <input hidden value="<?php echo e($client->id); ?>" type="text" name="client_id">
              <select name="user_id" class="form-control">
                <?php $__currentLoopData = $available_accounts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $account): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($account->id); ?>"><?php echo e($account->name); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            </select>
            <button type="submit" class="btn btn-default">Definir</button>
         </form>
             </div>
    </div>
  </div>
</div>
</div>
                      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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

      <div class="row">
        <div class="col">
          <?php echo e($clients->links()); ?>

        </div>
      </div>
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

<script type="text/javascript">
   const app = Vue.createApp({
    data() {
        return {
           
            id:"",
            nom: "",
            client: "",
            processing: 0
           



        }
    },
    methods:{ 


    getSelectedClient(id, client){
      this.client = client
      this.id = id
    },

    addDepartment(){
      id = this.id
      nom = this.nom
      this.processing = 1
      vm = this
     axios.post('/add-department', {
            id: id,
            nom: nom,
            _token: CSRF_TOKEN
  })

         
  .then(function (response) {
   
      location.reload()
       
  
  })
  .catch(function (error) {
   vm.processing = 0
    console.log(error);
  });
    },

    deleteDepartment(id){
      this.processing = 1
      vm = this
      axios.post('/delete-department', {
            id: id,
            
            _token: CSRF_TOKEN
  })

         
  .then(function (response) {
    
      location.reload()
       
  
  })
  .catch(function (error) {
   vm.processing = 0
    console.log(error);
  });
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
</body>
</html>
<?php /**PATH /var/www/html/jibiat/admin/resources/views/users.blade.php ENDPATH**/ ?>