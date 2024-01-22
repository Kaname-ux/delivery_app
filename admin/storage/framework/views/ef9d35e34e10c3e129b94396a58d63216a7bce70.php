<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
  <title>Facture <?php echo e($offer->description); ?></title>

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
            <h1>Facture <?php echo e($offer->description); ?></h1>
            <div class="card">
              <div class="card-header">Regénérer</div>
              <div class="card-body">
            <form class="" action="bill">

               <input hidden value="<?php echo e($offer->id); ?>" name="id">
              <div class="form-group">
                <label class="form-label">Entre le <?php echo e(date_create($offer->start)->format("d-m-Y")); ?> et le  <?php echo e(date_create($offer->end)->format("d-m-Y")); ?></label><br>
                <button type="button" onclick="document.getElementById('billdate').value = '<?php echo e($offer->end); ?>';" class="btn btn-primary">Toute la durée de l'abonnement</button>
                <input id="billdate" max="<?php echo e($offer->end); ?>"  min="<?php echo e($offer->start); ?>" value="<?php echo e(Request('billdate')); ?>" class="form-control" type="date" name="billdate">
              </div>
              <button class="btn btn-success">Valider</button>
            </form>
            </div>
            </div>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="dashboard">Abonnés</a></li>
              <li class="breadcrumb-item active">facture</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        
     
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Facture <?php echo e($offer->description); ?>


            </h3><br>
            <h3 class="card-title">Numero: <?php echo e($offer->id); ?>


            </h3><br>

             <h3 class="card-title">Période: du  <?php echo e(date_create($offer->start)->format("d-m-Y")); ?> au <?php echo e(date_create($offer->end)->format("d-m-Y")); ?>


            </h3>
             

                <div class="card-tools">
                  <?php echo e($client->nom); ?> <br>
                    
                  <?php echo e($client->adresse); ?><br>
                  <?php echo e($client->phone); ?>


                   
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body  p-0" >
                <table class="table table-responsive table-head-fixed text-nowrap">
                  <thead class=" text-primary">
                     
                       <th>
                        Description
                      </th>
                      <?php if($offer->subscription_type == "DISTRIBUTION"): ?>
                      <th>Prise en charge mensuelle</th>
                      <?php endif; ?>
                     
                      <th>
                        Quantité
                      </th>
                      <th>
                     Coût unitaire
                     </th>
                     <th>
                       Limitation
                     </th>
                     <th>
                       Effectué
                     </th>
                     <th>
                       Extra
                     </th>
                     <th>
                       Jours consommés
                     </th>
                     <th>
                       Cout extra
                     </th>
                     <th>
                      Total Hors taxe
                     </th>
                     <th>
                       TVA 18%
                     </th>
                     <th>
                       Total TTC
                     </th>
                     
                     
                      
                    </thead>
                    <tbody>
                     
                      <tr >
                        
                       
                         <td> <?php echo e($offer->subscription_type); ?><br>

                             <?php echo e($offer->cost); ?><br>
                             <?php echo e($offer->description); ?>

                         </td>
                          <?php if($offer->subscription_type == "DISTRIBUTION"): ?>
                        <td>
                          
                          <?php echo e($offer->cost); ?>

                          
                        </td>
                        <?php endif; ?>
                        <td>
                          <?php if($offer->subscription_type == "MAD"): ?>
                          <?php echo e($offer->livreurs()->count()); ?>

                          <?php endif; ?>
                        </td>

                        <td>
                          <?php echo e($offer->cost); ?>

                          
                        </td>
                        <td>
                          <?php echo e($offer->qty); ?>

                        </td>
                        <td>
                          <?php echo e($offer->commands()->count()); ?>

                        </td>
                          
                         <td>
                          <?php echo e($extra); ?> <?php echo e($extra_details); ?>

                        </td>
                        <td>
                          <?php if($interval->days == $globalinterval->days): ?>
                          Totalité
                          <?php else: ?>
                          <?php echo e($interval->days); ?>

                          <?php endif; ?>
                        </td>
                        <td>
                          <?php echo e($extra_cost); ?>

                        </td>

                        <td>

                           <?php echo e(ceil($cost)); ?>

                          
                        </td>

                        
                         <td>
                          <?php echo e(ceil($cost*18/100)); ?>

                          </td>

                          <td>
                          <?php echo e(ceil($cost*1.18)); ?>

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




      


       <button hidden id="addCostumerBtn" data-toggle="modal" data-target="#offerModal"></button>
</div>
<!-- ./wrapper -->


<script>

   const app = Vue.createApp({
    data() {
        return {

          

              }
    },
    methods:{



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
    $('#zone-select').select2()
</script>
</body>
</html>
<?php /**PATH /var/www/html/admin/resources/views/bill.blade.php ENDPATH**/ ?>