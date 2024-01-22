<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
  <title><?php echo e($subscription->description); ?></title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../../dist/css/adminlte.min.css">
  <link rel="stylesheet" href="../../plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="../../plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
</head>
<body class="hold-transition sidebar-mini">
  <script src="https://unpkg.com/vue@3"></script> 
<div class="wrapper" id="app">
 
  <button id="paymentModalTrigger" hidden data-toggle="modal" data-target="#paymentModal"></button>
  <div class="modal fade" id="paymentModal" role="dialog">
 <div class="modal-dialog">
<div class="modal-content ">
<div class="modal-header">
<h4 class="modal-title">Paiements</h4>
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
<span aria-hidden="true">×</span>
</button>
</div>

<div class="modal-body ">
  <?php if(session("paysuccess")): ?>
   <div class="alert alert-success">
    <?php echo e(session("paysuccess")); ?>

   </div>
  <?php endif; ?>
  <h2>Total: <?php echo e($period->payments()->sum("montant")); ?></h2>
  <div class="row mb-2">
    <div class="col-12">
      <form method="post" action="addbillpay">
        <?php echo csrf_field(); ?>
        <input  hidden type="" value="<?php echo e($period->id); ?>" name="id">
        <input  hidden type="" value="<?php echo e($subscription->id); ?>" name="subs_id">
        <div class="row mb-2">
        <div class="col">
          <label class="form-label">Date</label>
          <input required type="date" class="form-control" name="pay_date">
          <?php if ($errors->has('pay_date')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('pay_date'); ?>
         <span class="invalid-feedback" role="alert">
          <strong>Veuillez saisir une date valide</strong>
           </span>
        <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>
        </div>
        <div class="col">
          <label class="form-label">Montant</label>
          <input required type="number" class="form-control" name="montant">
        </div>
        <?php if ($errors->has('montant')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('montant'); ?>
         <span class="invalid-feedback" role="alert">
          <strong>Montant saisir un montant valide</strong>
           </span>
        <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>
        </div>

        <div class="row mb-2">
        <div class="col">
          <label class="form-label">Methode de paiement</label>
          <select required name="pay_method" class="form-control">
            <option value="">Choisir</option>
            <option value="Virement">Virement</option>
            <option value="Chèque">Chèque</option>
            <option value="Espèce">Espèce</option>
          </select>

          <?php if ($errors->has('pay_method')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('pay_method'); ?>
         <span class="invalid-feedback" role="alert">
          <strong>Veuillez choisir une methode de paiement</strong>
           </span>
        <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>
        </div>
        <div class="col">
          <label class="form-label">reférences</label>
          <input required type="" class="form-control" name="ref">
          <?php if ($errors->has('ref')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('ref'); ?>
         <span class="invalid-feedback" role="alert">
          <strong><?php echo e($message); ?></strong>
           </span>
        <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>
        </div>
        </div>
        <button type="submit" class="btn btn-success btn-block">Ajouter</button>
      </form>
     
    </div>
  </div> 
  <div class="row">
    <div class="col-12">
      <?php if($period->payments->count() > 0): ?>

    
    <?php $__currentLoopData = $period->payments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
    <div class="row mb-2">
    <div class="col"><?php echo e(date_create($payment->pay_date)->format("d-m-Y")); ?> - <strong><?php echo e($payment->montant); ?></strong> 
  </div>
  <div class="col">
      <button v-if="item != '<?php echo e($payment->id); ?>'" @click="editPay('<?php echo e($payment->id); ?>')" class="btn btn-primary btn-sm mr-2">
      <i class="fas fa-edit"></i>
    </button>
    <button v-if="item == '<?php echo e($payment->id); ?>'" @click="cancelEditPay('<?php echo e($payment->id); ?>')" class="btn btn-primary btn-sm mr-2">
      <i class="fas fa-edit"></i>
    </button>
      <button @click="confirmDelete('<?php echo e($payment->id); ?>')" class="btn btn-danger btn-sm">
        <i class="fas fa-trash"></i>
      </button>
    </div>

    </div>

    <div :hidden="confirm != '<?php echo e($payment->id); ?>'" class="row">
      <div class="col-12">
        <h3>Souhaitez-vous vraiment supprimer ce payement?</h3>
        <form method="post" action="deletebillpay">
          <?php echo csrf_field(); ?>
          <input type="" hidden value="<?php echo e($payment->id); ?>" name="id">
          <button type="submit" class="btn btn-danger mr-2">Confirmer</button> <button @click="cancelDelete" type="button" class="btn btn-success">Annuler</button>
        </form>
      </div>
    </div>
      
     <div :hidden="item != '<?php echo e($payment->id); ?>'" class="row mb-2">
    <div class="col-12">
      <form method="post" action="editbillpay">
        <?php echo csrf_field(); ?>
        <input  hidden type="" value="<?php echo e($period->id); ?>" name="id">
        <input  hidden type="" value="<?php echo e($subscription->id); ?>" name="subs_id">
        <input  hidden type="" value="<?php echo e($payment->id); ?>" name="pay_id">
        <div class="row mb-2">
        <div class="col">
          <label class="form-label">Date</label>
          <input value="<?php echo e($payment->pay_date); ?>" required type="date" class="form-control" name="pay_date">
          <?php if ($errors->has('pay_date')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('pay_date'); ?>
         <span class="invalid-feedback" role="alert">
          <strong>Veuillez saisir une date valide</strong>
           </span>
        <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>
        </div>
        <div class="col">
          <label class="form-label">Montant</label>
          <input value="<?php echo e($payment->montant); ?>" required type="number" class="form-control" name="montant">
        </div>
        <?php if ($errors->has('montant')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('montant'); ?>
         <span class="invalid-feedback" role="alert">
          <strong>Montant saisir un montant valide</strong>
           </span>
        <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>
        </div>

        <div class="row mb-2">
        <div class="col">
          <label class="form-label">Methode de paiement</label>
          <select value="<?php echo e($payment->pay_method); ?>" required name="pay_method" class="form-control">
            <option value="">Choisir</option>
            <option value="Virement">Virement</option>
            <option value="Chèque">Chèque</option>
            <option value="Espèce">Espèce</option>
          </select>

          <?php if ($errors->has('pay_method')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('pay_method'); ?>
         <span class="invalid-feedback" role="alert">
          <strong>Veuillez choisir une methode de paiement</strong>
           </span>
        <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>
        </div>
        <div class="col">
          <label class="form-label">reférences</label>
          <input value="<?php echo e($payment->pay_ref); ?>" required type="" class="form-control" name="ref">
          <?php if ($errors->has('ref')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('ref'); ?>
         <span class="invalid-feedback" role="alert">
          <strong><?php echo e($message); ?></strong>
           </span>
        <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>
        </div>
        </div>
        <button type="submit" class="btn btn-success mr-2">Modifier</button> <button @click="cancelEditPay" type="button" class="btn btn-danger mr-2">Annuler</button>
      </form>
     
    </div>
  </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    
    <?php endif; ?>
    </div>
    </div>
  </div> 
   
   
   

</div>


</div>

</div>

</div>
  <!-- Navbar -->
  <?php echo $__env->make("includes.navbar", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
 

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Invoice</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Invoice</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <!-- <div class="callout callout-info d-print-none">
              <h5><i class="fas fa-info"></i> Note:</h5>
              This page has been enhanced for printing. Click the print button at the bottom of the invoice to test.
            </div> -->


            <!-- Main content -->
            <div class="invoice p-3 mb-3">
              <!-- title row -->
              <div class="row">
                <div class="col-12">
                  <h4>
                    <a href="" class="brand-link">
      <img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" >
      <span class="brand-text font-weight-light"><?php echo e(config('app.name')); ?></span>
    </a>

    <address>
                    <strong>Logistica</strong><br>
                    <?php echo e(config('app.location')); ?><br>
                   
                    Contact: <?php echo e(config('app.phone')); ?><br>
                    Email: 
                  </address>
                   
                  </h4>
                </div>
                <!-- /.col -->
              </div>
              <!-- info row -->
              <div class="row invoice-info">
                <!-- /.col -->
                <div class="col-sm-6 invoice-col">
                  <b>Numero Facture #00<?php echo e($period->id); ?></b><br>
                  <br>
                  <b>Periode de facturation:</b> <?php echo e(date_create($start)->format("d-m-Y")); ?> / <?php echo e(date_create($end)->format("d-m-Y")); ?><br>
                  <b>Delai de paiement:</b> 30 jours<br>
                  <b>Code Client: </b> <?php echo e($client->id); ?>

                </div>
                <!-- /.col -->
                
                <!-- /.col -->
                <div class="col-sm-6 invoice-col">
                  Client
                  <address>
                    <strong><?php echo e($client->nom); ?></strong><br>
                    <?php echo e($client->adresse); ?><br>
                    San Francisco, CA 94107<br>
                    Contact: <?php echo e($client->phone); ?><br>
                    Email: <?php echo e($client->mail); ?><br>
                    NCC:
                  </address>
                </div>
                
              </div>
              <!-- /.row -->

              <!-- Table row -->
              <div class="row">
                <div class="col-12 table-responsive">
                  <table class="table table-striped">
                    <thead>
                    <tr>
                      
                      <th>Description</th>
                      <th>Prise en charge mensuelle</th>
                      <th>Quantité
                          <?php if($cost["interval_days"] > 0): ?><br>
                        (Nombre de jours) <?php echo e($cost["interval_days"]); ?> jours.
                        <?php endif; ?>
                      </th>
                      <th>Prix unitaire
                          <?php if($cost["interval_days"] > 0): ?><br>

                        (ratio journalier) 
                        <?php endif; ?>
                      </th>
                      <th>Total HT</th>
                      <th>TVA <?php echo e($taxes*100); ?>%</th>
                      <th>Total TTC</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                      <td><?php echo e($subscription->description); ?>

                        <br>
                         Zones de couverture: <strong><?php echo e($subscription->zones); ?></strong><br>
                        <?php if($cost["interval_days"] > 0): ?>
                        Consommation partiel <?php echo e($cost["interval_days"]); ?> jours.
                        <?php endif; ?>

                          </td>
                      <td>
                          <?php echo e($subscription->cost); ?> 
                      </td>
                      <td>
                       <?php if($subscription->subscription_type == "MAD"): ?>
                        <?php echo e($subscription->livreurs()->count()); ?>

                       <?php endif; ?>
                      </td>
                      <td><?php echo e($subscription->cost); ?></td>
                      <td><?php echo e($cost["cost"]); ?></td>
                      <td><?php echo e($taxes*$cost["cost"]); ?></td>
                      <td><?php echo e(($taxes+1)*$cost["cost"]); ?></td>
                    </tr>
                    <tr>
                      <td>Courses hors zone</td>
                      <td></td>
                      <td><?php if($extra_zones == 0): ?>
                        0
                        <?php else: ?>
                       
                        <?php echo e($extra_zones->count()); ?>

                        
                        <?php endif; ?>
                      </td>
                      <td></td>
                      <td><?php if($extra_zones == 0): ?>

                        <?php
                       $extra_zones_sum = 0; 
                        ?>
                        0
                        <?php else: ?>
                       
                        <?php echo e($extra_zones->sum("client_livraison")); ?>

                        <?php
                       $extra_zones_sum = $extra_zones->sum("client_livraison"); 
                        ?>
                        <?php endif; ?></td>
                      <td><?php echo e($taxes*$extra_zones_sum); ?></td>
                      <td><?php echo e(($taxes+1)*$extra_zones_sum); ?></td>
                    </tr>
                    <tr>
                      <td>Excedent poids</td>
                      <td> 
                      </td>
                      <td><?php if($extra_weights->count() > 0): ?>
                          <?php echo e($extra_weights->count()); ?>


                          <?php
                       $extra_weights_sum = $extra_weights->sum("extraw_cost"); 
                        ?>
                          <?php else: ?>
                          <?php
                       $extra_weights_sum = 0; 
                        ?>
                           0
                          <?php endif; ?>
                        </td>
                      <td>
                        
                       
                      </td>
                      <td> <?php if($extra_weights->count() > 0): ?>
                          <?php echo e($extra_weights->sum("extraw_cost")); ?>

                           <?php else: ?>         
                           0
                          <?php endif; ?></td>
                      <td><?php echo e($taxes*$extra_weights_sum); ?></td>
                      <td><?php echo e(($taxes+1)*$extra_weights_sum); ?></td>
                    </tr>
                    <tr>
                      <td>Course urgente</td>
                      <td></td>
                      <td><?php if($urgent == 0): ?>

                        <?php
                       $urgent_sum = 0; 
                        ?>
                        0
                        <?php else: ?>
                       
                        <?php echo e($urgent->count()); ?>

                        <?php
                       $urgent_sum = $urgent->sum("urgent_cost"); 
                        ?>
                        <?php endif; ?></td>
                      <td></td>
                      <td><?php if($urgent == 0): ?>

                        0
                        <?php else: ?>
                       
                        <?php echo e($urgent_sum); ?>

                        <?php endif; ?></td>
                      <td><?php echo e($taxes*$urgent_sum); ?></td>
                      <td><?php echo e(($taxes+1)*$urgent_sum); ?></td>
                    </tr>

                    <tr>
                      <td>Excédent la limite de <?php echo e($subscription->qty); ?></td>
                      <td></td>
                      <td><?php if($extra_qty == 0): ?>

                        <?php
                       $extra_qty_sum = 0; 
                        ?>
                        0
                        <?php else: ?>
                       
                        <?php echo e($extra_qty->count()); ?>

                        <?php
                       $extra_qty_sum = $extra_qty->sum("urgent_cost+client_livraison"); 
                        ?>
                        <?php endif; ?></td>
                      <td></td>
                      <td><?php if($extra_qty == 0): ?>

                        0
                        <?php else: ?>
                       
                        <?php echo e($extra_qty_sum); ?>

                        <?php endif; ?></td>
                      <td><?php echo e($taxes*$extra_qty_sum); ?></td>
                      <td><?php echo e(($taxes+1)*$extra_qty_sum); ?></td>
                    </tr>


                    </tbody>
                  </table>
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->

              <div class="row">
                <!-- accepted payments column -->
                <div class="col-6">
                  <p class="lead">Methode de paiement:</p>
                  Prière effectuer le paiement sur le numéro de compte BGFI BANK ci après :<br>


                  <p class="text-muted well well-sm shadow-none" style="margin-top: 10px;">
                    Arrêté la présente facture à la somme de 
                    <?php echo e($billing->convertCurrencyToFrenchWords(($extra_zones_sum*($taxes+1))+($cost["cost"]*($taxes+1))+($extra_qty_sum*($taxes+1))+($urgent_sum*($taxes+1))+($extra_weights_sum*($taxes+1)))); ?>

                  </p>
                </div>
                <!-- /.col -->
                <div class="col-6">
                  <p class="lead">Montant Due au <?php echo e(date_create(request("end"))->format("d-m-Y")); ?></p>

                  <div class="table-responsive">
                    <table class="table">
                      <tr>
                        <th style="width:50%">SousTotal:</th>
                        <td><?php echo e($extra_zones_sum+$cost["cost"]+$urgent_sum+$extra_weights_sum+$extra_qty_sum); ?></td>
                      </tr>
                      <tr>
                        <th>TVA (18%)</th>
                        <td><?php echo e(($extra_zones_sum*($taxes))+($cost["cost"]*($taxes))+($urgent_sum*($taxes))+($extra_qty_sum*($taxes))+($extra_weights_sum*($taxes))); ?></td>
                      </tr>
                      
                      <tr>
                        <th>Total:</th>
                        <td>
                         <?php $total = ($extra_zones_sum*($taxes+1))+($cost["cost"]*($taxes+1))+($urgent_sum*($taxes+1))+($extra_qty_sum*($taxes+1))+($extra_weights_sum*($taxes+1)); ?>
                        <?php echo e($total); ?></td>
                      </tr>

                      <tr>
                        <th>Payé:</th>
                        <td><?php echo e($period->payments->sum("montant")); ?>


                         </td>
                      </tr>
                      <tr>
                        <th>Solde:</th>
                        <td>
                         
                        <?php echo e($total-$period->payments->sum("montant")); ?></td>
                      </tr>
                    </table>
                  </div>
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->

              <!-- this row will not appear when printing -->
              <div class="row no-print mb-2">
                <div class="col-12">
                  <span>
                  <?php if($period->issue_date): ?>
                   <?php if(date_create($period->issue_date)->format("Y-m-d") >= date("Y-m-d")): ?>
                  <strong> Encours</strong>. Facture émise le:<strong> <?php echo e(date_create($period->issue_date)->format("d-m-Y")); ?> </strong>
                  <?php else: ?>
                  En attente d'emission.
                  <?php endif; ?>
                  <?php else: ?>
                  Aucune date d'émission définie
                  <?php endif; ?>
                   <form class="float-center ml-2"  method="post" action="issuedate">
                    <?php echo csrf_field(); ?>
                    <input hidden type="" name="id" value="<?php echo e($period->id); ?>">
                    <div class="row">
                      <div class="col">
                        
                        <input value="<?php echo e($period->issue_date); ?>" type="date" class="form-control" name="issue_date">
                      </div>
                      <div class="col">
                        <button class="btn btn-success">Modifier</button>
                      </div>
                    </div>
                  </form>
                  </span>

                  <span class="float-right">
                    <?php if($period->payments()->sum("montant") >= $total): ?>
                    <span class="text-success">Soldé</span>
                    <?php elseif($period->payments()->sum("montant") >= $total): ?>
                    Non-payé
                    <?php endif; ?>
                  </span>
                </div>
              </div>
              <div class="row no-print">
                <div class="col-12">
                  <button onclick="print()" rel="noopener" target="_blank" class="btn btn-default"><i class="fas fa-print"></i> Imprimer</button>
                  <button type="button" class="btn btn-primary " style="margin-right: 5px;">
                    <i class="fas fa-download"></i> Générer PDF
                  </button>
                

                  <button data-toggle="modal" data-target="#paymentModal" type="button" class="btn btn-success float-right ml-2"><i class="far fa-credit-card"></i> 
                    Paiement
                  </button>
                   
                  
                </div>
              </div>
            </div>
            <!-- /.invoice -->
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer no-print">
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
           item: null,
           confirm: null,
        }
},

  methods:{

  editPay(item){
    this.item = item
  },

  cancelEditPay(item){
    this.item = null
  },

  confirmDelete(item){
    this.confirm = item
  },

  cancelDelete(){
    this.confirm = null
  },


   updateCmd(id, part, link){
     
    element = document.getElementById(part).value
    axios.post(link, {
           
            cmdid:id,
            part: element,
            
            _token: CSRF_TOKEN
  })

         
  .then(function (response) {
    alert("Action effectuée "+ element+ " " + id)
    
  

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
<!-- jQuery -->
<script src="../../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="../../dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../../dist/js/demo.js"></script>
<script src="../../plugins/pdfmake/pdfmake.min.js"></script>
<script src="../../plugins/pdfmake/vfs_fonts.js"></script>
 <?php if($errors->count() || session("paysuccess")): ?>
   <script type="text/javascript">
     $("#paymentModalTrigger").click();
   </script>
  <?php endif; ?>
</body>
</html>
<?php /**PATH /var/www/html/jibiat/admin/resources/views/billing.blade.php ENDPATH**/ ?>