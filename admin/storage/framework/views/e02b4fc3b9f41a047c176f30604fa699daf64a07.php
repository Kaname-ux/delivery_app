<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Charges</title>

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
  <!-- Navbar -->
 <?php echo $__env->make("includes.navbar", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

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
                                         
                                         <input  hidden value='<?php echo e(date("Y-m-d",strtotime("first day of last month"))); ?>'   class="form-control " type="date" name="start">
                                         <input  hidden value='<?php echo e(date("Y-m-d",strtotime("last day of last month"))); ?>'   class="form-control " type="date" name="end">
                                         <button type="submit" class="btn btn-outline-primary btn-block "   >Le mois dernier</button>

                                        </div>
                                         </form>

                                         <form  autocomplete="off"  action='?' >
                                         <?php echo csrf_field(); ?>
                                         <div  class="form-group ">
                                         
                                         <input  hidden value='<?php echo e(date("Y-m-d",strtotime("first day of this month"))); ?>'   class="form-control " type="date" name="start">
                                         <input  hidden value='<?php echo e(date("Y-m-d",strtotime("last day of this month"))); ?>'   class="form-control " type="date" name="end">
                                         <button type="submit" class="btn btn-outline-warning btn-block "   >Ce mois</button>

                                        </div>
                                         </form>
                                        
                                        <form  autocomplete="off"  action='?' >
                                         <?php echo csrf_field(); ?>
                                         <div  class="form-group ">
                                         
                                         <input hidden value='<?php echo e(date("Y-m-d",strtotime("first day of january this year"))); ?>'    class="form-control "  name="start">
                                         <input hidden value='<?php echo e(date("Y-m-d",strtotime("last day of december this year"))); ?>'    class="form-control "  name="end">
                                         <button class="btn btn-outline-success btn-block " type="submit"  >Cette annee</button>

                                        </div>
                                         </form>


                                         <form  autocomplete="off"  action='?' >
                                         <?php echo csrf_field(); ?>
                                         <div  class="form-group ">
                                         
                                         <input hidden value='<?php echo e(date("Y-m-d",strtotime("first day of january last year"))); ?>'    class="form-control "  name="start">
                                         <input hidden value='<?php echo e(date("Y-m-d",strtotime("last day of december last year"))); ?>'    class="form-control "  name="end">
                                         <button class="btn btn-outline-success btn-block " type="submit"  >L'annee derniere</button>

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

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Liste des charges</h1>
            <button data-toggle="modal" data-target="#dateModal" class="btn btn-outline-primary mr-2 d-print-none"><?php echo e($day); ?></button>

          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="dashboard">Home</a></li>
              <li class="breadcrumb-item active">Charges</li>
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
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
              <span class="info-box-icon bg-info elevation-1"><i class="fas fa-cog"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Total</span>
                <span class="info-box-number">
                  <?php echo e($charges->sum("montant")); ?>

                  <small>FCFA</small>
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>


             <div v-for="shop in shops" class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
              <span class="info-box-icon bg-info elevation-1"><i class="fas fa-store"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">{{shop.name}}</span>
                <span class="info-box-number">
                  {{totalByShop(shop.id)}}
                  <small>FCFA</small>
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>

          <div v-for="type in chargeTypes" class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
              <span class="info-box-icon bg-secondary elevation-1"><i class="fas fa-cog"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">{{type}}</span>
                <span class="info-box-number">
                  {{totalByType(type)}}
                  <small>FCFA</small>
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>

        </div>
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Liste des charges</h3>

                <div class="card-tools">
                  <a href="/charge-form"  class="btn btn-success">Nouvelle Charge</a>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0" >
                <table class="table table-head-fixed text-nowrap">
                  <thead class=" text-primary">
                      <th></th>
                      <th>
                        Boutique
                      </th>
                       <th>
                        Type
                      </th>
                      <th>
                        Nature
                      </th>
                      
                      <th>
                        Detail
                      </th>
                      <th>
                        Date
                      </th>
                      <th>
                        Montant
                      </th>

              
                      <th>
                        Source
                      </th>
                      <th>
                        Periodicite
                      </th>
                     
                     
                      
                    </thead>
                    <tbody>
                      <?php $__currentLoopData = $charges; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $charge): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                      <tr>
                        
                        <td>
                          
                          <form  onsubmit="return confirm('Souhaitez vous vraiment supprimer?');"   method="POST" action="/charge-delete/<?php echo e($charge->id); ?>">
                            <a href="/chargeedit/<?php echo e($charge->id); ?>" ><i class="fas fa-edit"></i></a>

                            <?php echo e(csrf_field()); ?>

                        <?php echo e(method_field('DELETE')); ?>

                          <button  type="submit" name="btn" class="btn btn-danger btn-sm">Supprimer</button>
                         
                       </form>

                       <script>
                   function myFunction<?php echo e($charge->id); ?>() {
                    confirm("Confirmer!");
                            }
                    </script>
                          
                        </td>

                        <td>
                          <?php echo e($charge->shop_name); ?>

                        </td>
                        <td>
                          <?php echo e($charge->type); ?>

                        </td>
                        <td>
                          <?php echo e($charge->nature); ?>

                        </td>

                        <td>
                          <?php echo e($charge->detail); ?>

                        </td>
                        <td>
                          <?php echo e($charge->charge_date->format('d/m/Y')); ?>

                        </td>
                        
                        
                        <td>
                          <?php echo e($charge->montant); ?>

                        </td>

                        <td>
                          <?php if($charge->source): ?>
                          <?php echo e($charge->source); ?>

                          <?php else: ?>
                          Aucune
                          <?php endif; ?>
                        </td>

                        <td>
                          <?php if($charge->periode == 52): ?>
                          Hebdomadiare
                          <?php endif; ?>

                          <?php if($charge->periode == 12): ?>
                          Mensuel
                          <?php endif; ?>

                          <?php if($charge->periode == 6): ?>
                          bi-Mensuel
                          <?php endif; ?>

                          <?php if($charge->periode == 4): ?>
                          Trimestriel
                          <?php endif; ?>
                         
                         <?php if($charge->periode == 2): ?>
                          Semestriel
                          <?php endif; ?>

                        </td>

                        
                      </tr>
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
            
            chargeTypes: ['Facture eau', 'Facture electricite', 'Publicite', 'Loyer', 'Taxes','Consommables', 'Salaires', 'Autres'],
            shops: <?php echo $shops; ?>,
            costumStart:"",
            intStart:null,
            charges: <?php echo $vuecharges; ?>

           
        }
    },
    methods:{ 

      totalByShop(id){
       total = 0
        for(i=0; i < this.charges.length; i++){
          if(this.charges[i].shop_id == id){
            total += this.charges[i].montant
          }
        }

        return total

      },

       totalByType(type){
       total = 0
        for(i=0; i < this.charges.length; i++){
          if(this.charges[i].nature == type){
            total += this.charges[i].montant
          }
        }

        return total

      }
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
<?php /**PATH /htdocs/clients/logistica/admin/resources/views/charge.blade.php ENDPATH**/ ?>