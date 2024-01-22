<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Stats utilisateurs</title>

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
<div class="wrapper" id="app">

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
              <li class="breadcrumb-item active">Stats utilisateurs</li>
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
                <h3 class="card-title">Stats utilisateurs</h3>

                <div class="card-tools">
                  <button data-toggle="modal" data-target="#dateModal" class="btn btn-outline-primary mr-2 d-print-none">
                    <?php echo e($day); ?>

                  </button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0" >
                <table class="table table-head-fixed text-nowrap">
                   <thead class=" text-primary">
                     
                      <th>Type</th>
                      
                      <th>
                        Nom
                      </th>
                      <th>
                        Objectif
                      </th>
                      <th>
                        Enregistrés
                      </th>
                      <th>
                        Livrés
                      </th>
                      <th>
                        Annulés
                      </th>
                      
                      
                    </thead>
                    <tbody>
                      <?php $__currentLoopData = $clients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $x=>$client): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                      
                      <tr >
                        
                        <td>
                           
                          <?php echo e($client->client_type); ?>


                        </td>

                        <td><a href="useractions?id=<?php echo e($client->user_id); ?>&start=<?php echo e($start); ?>&end=<?php echo e($end); ?>"><?php echo e($client->nom); ?></a></td>
                        <td><?php echo e($userobj($client->client_type, $start, $end)); ?></td>


                        <td>
                          <?php echo e($client->command->whereBetween("delivery_date", [$start, $end])->count()); ?><br>
                          <div class="progress">
                          <?php if($client->command->whereBetween("delivery_date", [$start, $end])->count() > 0): ?>
       <div class="progress-bar 
       <?php if(round(($client->command->whereBetween("delivery_date", [$start, $end])->count()/($userobj($client->client_type, $start, $end)))*100) < 50): ?> bg-danger <?php endif; ?>

       
       <?php if(round(($client->command->whereBetween("delivery_date", [$start, $end])->count()/($userobj($client->client_type, $start, $end)))*100) >= 100): ?> bg-success <?php endif; ?>


       " role="progressbar" style="width: <?php echo e(round(($client->command->whereBetween("delivery_date", [$start, $end])->count()/($userobj($client->client_type, $start, $end)))*100)); ?>%;" aria-valuenow="<?php echo e(round(($client->command->whereBetween("delivery_date", [$start, $end])->count()/($userobj($client->client_type, $start, $end)))*100)); ?>" aria-valuemin="0" aria-valuemax="100"><?php echo e(round(($client->command->whereBetween("delivery_date", [$start, $end])->count()/($userobj($client->client_type, $start, $end)))*100)); ?>%</div>
       <?php endif; ?>
      </div>

                        </td>


                        <td>
                          <?php echo e($client->command->whereBetween("delivery_date", [$start, $end])->where("etat", "termine")->count()); ?><br>




                           <div class="progress">
                          <?php if($client->command->whereBetween("delivery_date", [$start, $end])->where("etat", "termine")->count() > 0): ?>
       <div class="progress-bar 
       <?php if(round(($client->command->whereBetween("delivery_date", [$start, $end])->where("etat", "termine")->count()/($userobj($client->client_type, $start, $end)))*100) < 50): ?> bg-danger <?php endif; ?>

       
       <?php if(round(($client->command->whereBetween("delivery_date", [$start, $end])->where("etat", "termine")->count()/($userobj($client->client_type, $start, $end)))*100) >= 100): ?> bg-success <?php endif; ?>


       " role="progressbar" style="width: <?php echo e(round(($client->command->whereBetween("delivery_date", [$start, $end])->where("etat", "termine")->count()/($userobj($client->client_type, $start, $end)))*100)); ?>%;" aria-valuenow="<?php echo e(round(($client->command->whereBetween("delivery_date", [$start, $end])->where("etat", "termine")->count()/($userobj($client->client_type, $start, $end)))*100)); ?>" aria-valuemin="0" aria-valuemax="100"><?php echo e(round(($client->command->whereBetween("delivery_date", [$start, $end])->where("etat", "termine")->count()/($userobj($client->client_type, $start, $end)))*100)); ?>%</div>
       <?php endif; ?>
      </div>


                        </td>
                        <td>
                          


<?php echo e($client->command->whereBetween("delivery_date", [$start, $end])->where("etat", "annule")->count()); ?><br>




                           <div class="progress">
                          <?php if($client->command->whereBetween("delivery_date", [$start, $end])->where("etat", "annule")->count() > 0): ?>
       <div class="progress-bar 
       <?php if(round(($client->command->whereBetween("delivery_date", [$start, $end])->where("etat", "annule")->count()/($userobj($client->client_type, $start, $end)))*100) < 50): ?> bg-danger <?php endif; ?>

       
       <?php if(round(($client->command->whereBetween("delivery_date", [$start, $end])->where("etat", "annule")->count()/($userobj($client->client_type, $start, $end)))*100) >= 100): ?> bg-success <?php endif; ?>


       " role="progressbar" style="width: <?php echo e(round(($client->command->whereBetween("delivery_date", [$start, $end])->where("etat", "annule")->count()/($userobj($client->client_type, $start, $end)))*100)); ?>%;" aria-valuenow="<?php echo e(round(($client->command->whereBetween("delivery_date", [$start, $end])->where("etat", "annule")->count()/($userobj($client->client_type, $start, $end)))*100)); ?>" aria-valuemin="0" aria-valuemax="100"><?php echo e(round(($client->command->whereBetween("delivery_date", [$start, $end])->where("etat", "annule")->count()/($userobj($client->client_type, $start, $end)))*100)); ?>%</div>
       <?php endif; ?>
      </div>

                          
                        </td>
                        
                      </tr>
                     
                     <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


                    </tbody>

                             <tfoot>
            <tr>
                <th colspan="4" style="text-align:right"></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>

                 

            </tr>


        </tfoot>
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
<script>

   const app = Vue.createApp({
    data() {
        return {
            
           
           
            costumStart:"",
            intStart:null,
            
        }
    },
    methods:{ 
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
    

   
   },
   computed:{
      
}
});

  const mountedApp = app.mount('#app')     
  </script>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="../../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="../../dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../../dist/js/demo.js"></script>
</body>
</html>
<?php /**PATH /var/www/html/admin/resources/views/userstat.blade.php ENDPATH**/ ?>