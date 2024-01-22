<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
  <title>Actions utilisatuers</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../../dist/css/adminlte.min.css">
</head>
<body class="hold-transition sidebar-mini">
    <script src="https://unpkg.com/vue@3"></script> 
<div class="wrapper" id="app">
  
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
                                         <input type="" hidden  value="<?php echo e($user->id); ?>" name="id">
                                         <div  class="form-group ">
                                         
                                         <input  hidden value='<?php echo e(date("Y-m-d",strtotime("yesterday"))); ?>'   class="form-control " type="date" name="start">
                                         <input  hidden value='<?php echo e(date("Y-m-d",strtotime("yesterday"))); ?>'   class="form-control " type="date" name="end">
                                         <button type="submit" class="btn btn-outline-primary btn-block "   >Hier</button>

                                        </div>
                                         </form>

                                         <form  autocomplete="off"  action='?' >
                                         <?php echo csrf_field(); ?>
                                         <input type="" hidden  value="<?php echo e($user->id); ?>" name="id">
                                         <div  class="form-group ">
                                         
                                         <input  hidden value='<?php echo e(date("Y-m-d",strtotime("today"))); ?>'   class="form-control " type="date" name="start">
                                         <input  hidden value='<?php echo e(date("Y-m-d",strtotime("today"))); ?>'   class="form-control " type="date" name="end">
                                         <button type="submit" class="btn btn-outline-warning btn-block "   >Aujourd'hui</button>

                                        </div>
                                         </form>
                                        
                                        <form  autocomplete="off"  action='?' >
                                         <?php echo csrf_field(); ?>
                                         <input type="" hidden  value="<?php echo e($user->id); ?>" name="id">
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
                                <input type="" hidden  value="<?php echo e($user->id); ?>" name="id">
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
                                <input type="" hidden  value="<?php echo e($user->id); ?>" name="id">
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
  <!-- /.navbar -->


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1><?php echo e($user->name); ?>  <button data-toggle="modal" data-target="#dateModal" class="btn btn-outline-primary mr-2 d-print-none"><?php echo e($day); ?></button></h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="/userstat?start=<?php echo e($start); ?>&end=<?php echo e($end); ?>">Liste</a></li>
              <li class="breadcrumb-item active">Actions utilisateurs</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
          <?php if(session('status')): ?>
         <div class="alert alert-success alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  <h5><i class="icon fas fa-check"></i> <?php echo e(session('status')); ?></h5>
                  
                </div>
          <?php endif; ?>      
      <div class="container-fluid">
       
        <!-- /.row -->

        <div class="card">
          <div class="card-header"><h2 class="card-title">Objectifs et chiffres</h2>
           <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand"></i>
                  </button>
                </div>


          </div>
                    <div class="card-body">
                        <?php if($client_type->mensual_goal > 0): ?>
                   <div class="row">
                       <div class="col">
                           <h3>Chiffres</h3>
               
               
               


                       </div>

                       <div class="col">
                            <h3>Taux d'achevement</h3>
                      </div>
                   </div>      
              
               <hr>

               <div class="row">
                   <div class="col">
                       
               Objectif de la periode: <span style="font-weight: bold;"><?php echo e($daily*$dif); ?></span>
               
                   </div>
                   <div class="col">
                       
                   </div>
               </div>

               <hr>

               <div class="row">
                <div class="col">
                    Enregitré: <span style="font-weight: bold;"><?php echo e($registered->count()); ?></span>
                </div>
                <div class="col">
                       <div class="progress">
      <?php if($registered->count() > 0): ?>
       <div class="progress-bar 
       <?php if(round(($registered->count()/($daily*$dif))*100) < 50): ?> bg-danger <?php endif; ?>

       

       <?php if(round(($registered->count()/($daily*$dif))*100) >= 100): ?> bg-success <?php endif; ?>


       " role="progressbar" style="width: <?php echo e(round(($registered->count()/($daily*$dif))*100)); ?>%;" aria-valuenow="<?php echo e(round(($registered->count()/($daily*$dif))*100)); ?>" aria-valuemin="0" aria-valuemax="100"><?php echo e(round(($registered->count()/($daily*$dif))*100)); ?>%</div>
       <?php endif; ?>
       </div>   
                </div>
                   
               </div>
                    
            
            <hr>
             
            <div class="row">
               

                <div class="col">
                   Livré: <span style="font-weight: bold;"><?php echo e($registered->where("etat", "termine")->count()); ?></span>  
                </div>


                 <div class="col">
                      <div class="progress">
      <?php if($registered->count() > 0): ?>
       <div class="progress-bar 
       <?php if(round(($registered->where('etat', 'termine')->count()/$registered->count())*100) < 50): ?> bg-danger <?php endif; ?>

       

       <?php if(round(($registered->where('etat', 'termine')->count()/$registered->count())*100) >= 100): ?> bg-success <?php endif; ?>


       " role="progressbar" style="width: <?php echo e(round(($registered->where('etat', 'termine')->count()/$registered->count())*100)); ?>%;" aria-valuenow="<?php echo e(round(($registered->where('etat', 'termine')->count()/$registered->count())*100)); ?>" aria-valuemin="0" aria-valuemax="100"><?php echo e(round(($registered->where('etat', 'termine')->count()/$registered->count())*100)); ?>%</div>
       <?php endif; ?>
       </div>  
            </div>
      
          </div>  

   <hr>
          <div class="row">
               

                <div class="col">
                   Annulé: <span style="font-weight: bold;"><?php echo e($registered->where("etat", "annule")->count()); ?></span>  
                </div>


                 <div class="col">
                      <div class="progress">
       <?php if($registered->count() > 0): ?>
       <div class="progress-bar 
       bg-danger


       " role="progressbar" style="width: <?php echo e(round(($registered->where('etat', 'annule')->count()/$registered->count())*100)); ?>%;" aria-valuenow="<?php echo e(round(($registered->where('etat', 'annule')->count()/$registered->count())*100)); ?>" aria-valuemin="0" aria-valuemax="100"><?php echo e(round(($registered->where('etat', 'annule')->count()/$registered->count())*100)); ?>%</div>
       <?php endif; ?>
       </div>  
            </div>
      
          </div> 
          <?php else: ?>
          Aucun ojectif defini
          <?php endif; ?> 
          

          </div>  
      </div>
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h2 >Actions </h2>

                <div class="card-tools">
                  
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                  <thead>
                    <tr>
                      
                      <th>Date et heure</th>
                      <th>Description</th>
                      <th>Modifications</th>
                      
                      
                    </tr>
                  </thead>
                  <tbody>
                    <?php $__currentLoopData = $actions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $action): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                     
                    <td><?php echo e($action->created_at->format('d-m-Y H:i:s')); ?></td>
                      <td>Commnade numero <?php echo e($action->id); ?> - <?php echo e($action->adresse); ?></td>
                      
                     <td>
                      <a data-toggle="modal" data-target="#eventViewModal" href="#" @click="getEvent(<?php echo e($action->id); ?>)"> 
                       <?php echo e($action->events->count()); ?> modification(s)
                     </a>
                     </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                  </tbody>
                  <tfoot>
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
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script type="text/javascript">
  var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
</script>
</body>
</html>
<?php /**PATH /htdocs/clients/logistica/admin/resources/views/useractions.blade.php ENDPATH**/ ?>