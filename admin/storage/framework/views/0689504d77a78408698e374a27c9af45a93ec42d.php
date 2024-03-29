<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
  <title>Factures</title>

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
            <h1>Factures </h1><button onclick="printElement('bills')">Imprimer</button>
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
      <div id="bills" class="container-fluid">
        
        <?php $__currentLoopData = $offers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $x=>$offer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="row ">
          <div class="col-12">
            <div class="card border border-success">
              <div class="card-header">
                <h3 class="card-title">Facture <?php echo e($offer['description']); ?>


            </h3><br>
            <h3 class="card-title">Numero: <?php echo e($offer["id"]); ?>


            </h3>
             

                <div class="card-tools">
                  <?php echo e($offer["client"]->nom); ?> <br>
                  <?php echo e($offer["client"]->adresse); ?> <br>
                  <?php echo e($offer["client"]->phone); ?>

                    
                  <br>
                  

                   
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0" >
                <table class="table table-responsive ">
                  <thead class=" text-primary">
                     
                       <th>
                        Description
                      </th>
                     
                      <th>Prise en charge mensuelle</th>
                     
                     
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
                        
                       
                         <td> <?php echo e($offer["subscription_type"]); ?><br>

                             
                             <?php echo e($offer["description"]); ?>

                         </td>
                         
                        <td>
                          
                          <?php echo e($offer["globalcost"]); ?>

                          
                        </td>
                        
                        <td>
                          <?php if($offer["subscription_type"] == "MAD"): ?>
                          <?php echo e($offer["livreurs"]); ?>

                          <?php endif; ?>
                        </td>

                        <td>
                          <?php echo e(ceil($offer["cost"])); ?>

                          
                        </td>
                        <td>
                          <?php echo e($offer["qty"]); ?>

                        </td>
                        <td>
                          <?php echo e($offer["commands"]); ?>

                        </td>
                          
                         <td>
                          <?php echo e($offer["extra"]); ?> <?php echo e($offer["extrad"]); ?>

                        </td>
                        <td>
                          <?php if($offer['interval'] == $offer["globalinterval"]): ?>
                          Totalité
                          <?php else: ?>
                          <?php echo e($offer['interval']); ?>

                          <?php endif; ?>
                        </td>
                        <td>
                          <?php echo e($offer["extrac"]); ?>

                        </td>

                        <td>

                           <?php echo e(ceil($offer["cost"])); ?>

                          
                        </td>

                        
                         <td>
                          <?php echo e(ceil($offer["cost"]*18/100)); ?>

                          </td>

                          <td class="float-right">
                          <?php echo e(ceil($offer["cost"]*1.18)); ?>

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
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-body">
                <table DIR="RTL" class="table table-responsive table-head-fixed text-nowrap">
                  <thead class=" text-primary">
                     
                      <th>
                     Total TTC
                     </th>
                      <th>
                       Total TVA
                      </th>
                     
                      <th>Total HT</th>
                     
                     <th>
                        Total Extra
                      </th>
                      
                    </thead>
                    <tbody>
                     <tr>
                      
                     
                    
                     <td>
                       <?php echo e(ceil(array_sum(array_column($offers, 'cost'))*1.18)); ?>

                     </td>

                      

                      <td>
                       <?php echo e(ceil(array_sum(array_column($offers, 'cost'))*18/100)); ?>

                     </td>

                     <td>
                      <?php echo e(ceil(array_sum(array_column($offers, 'cost')))); ?>

                     </td>
                     <td>
                       <?php echo e(array_sum(array_column($offers, 'extrac'))); ?>

                     </td>
                     </tr>
                     
                     
                     
                    </tbody>
                </table>
                
              </div>
            </div>
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
    $('#zone-select').select2();

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
</script>
</body>
</html>
<?php /**PATH /var/www/html/admin/resources/views/bulkbill.blade.php ENDPATH**/ ?>