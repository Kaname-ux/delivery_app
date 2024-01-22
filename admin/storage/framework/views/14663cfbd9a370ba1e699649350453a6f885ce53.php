<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title>Commande - <?php echo e($day); ?></title>
    <link rel="stylesheet" href="../assets/css/style.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">

    <meta name="viewport"
        content="width=device-width,  viewport-fit=cover" />
    <meta name="description" content=" Système de gestion pour vendeur en ligne">
    <meta name="keywords" content="venl.n ligne, livraison, livreur" />
    <link rel="apple-touch-icon" size="180" href="assets/img/apple-touch-icon.png">
    <link rel="icon" type="image/png" href=".../assets/img/favicon.png" sizes="32x32">
    <link rel="shortcut icon" href="../img/favicon.png">
   <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.12.1/datatables.min.css"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-print-css/css/bootstrap-print.min.css" media="print">

    
<style>
  .toggle.ios, .toggle-on.ios, .toggle-off.ios { border-radius: 20px; }
  .toggle.ios .toggle-handle { border-radius: 20px; }


 
@media  print {
 
  .noprint{
    display: none;
  }
}
 
</style>
 <script src="https://unpkg.com/ionicons@5.0.0/dist/ionicons.js"></script>

</head>

<body>
 
    <!-- * App Header -->


    <!-- App Capsule -->
    <div id="appCapsule mt-0">
       <div class="section-full">
             
             <?php if(request()->has("print")): ?>
             <div class="section-title "><?php echo e($day); ?></div>
            <table id="myTable" class="table table-striped" >
                    <thead class=" text-primary">
                     
                      <th>Etat</th>
                      
                      <th> Numero</th>
                      <th> Description</th>
                      <th>
                        adresse
                      </th>
                      <th>
                        Contact  
                      </th>
                        
                      <th>
                        Date de livraison
                      </th>

                      <th>
                        Montant
                      </th>

                      <th>
                        livraison
                      </th>

                      <th>
                        Total
                      </th>
                       
                      <th>
                        Livreur
                      </th>
                      <th>
                        Derniere note
                      </th>
                    </thead>
                    <tbody>
                      <?php $__currentLoopData = $commands; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $command): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                    
                      <tr>
                        
                        <td>
                             <span 

                        
                          <?php if($command->etat == 'encours'): ?> 
                          class="badge badge-danger"
                          <?php endif; ?>

                          <?php if($command->etat == 'en attente'): ?> 
                          class="badge badge-warning"
                          <?php endif; ?>

                          <?php if($command->etat == 'recupere'): ?>
                          class="badge badge-warning"
                          <?php endif; ?>

                          <?php if($command->etat == 'en chemin'): ?>
                          class="badge badge-warning"
                          <?php endif; ?>


                          <?php if($command->etat == 'termine'): ?>
                          class="badge badge-success"
                          <?php endif; ?>
                          ><?php echo e($command->etat); ?></span>

                          <?php if($command->ready == 'yes'): ?> 
                          <img width="30" height="30" src="/assets/img/packing.ico">
                          <?php endif; ?> 
                           <?php if($command->loc == 'retour'): ?>
                        <strong style="color: red">Retour en attente</strong>
                        <?php endif; ?>
                        </td>

                        <td>
                           <?php echo e($command->id); ?>

                        </td>
                        

                        <td>
                            <span class="col" style="font-size: 13px; line-height: 1.6; font-style: italic;"> 
                        Via: <?php echo e($command->canal); ?>

                        </span><br>
                           <?php echo e($command->description); ?>

                      
                        </td>


                        <td>
                        
                          <strong>

                          <span class="col" style="font-size: 13px; line-height: 1.6; font-style: italic;"> 
                        Client: <?php echo e($command->nom_client); ?>

                        </span><br>
                          <?php echo e($command->adresse); ?><br>
                          <?php if($command->observation): ?>
                          Info: <?php echo e($command->observation); ?>

                          <?php endif; ?> 
                           </strong>
                          
                           
                        </td>
                        <td>
                           <?php echo e($command->phone); ?> 
                        </td>
                       

                        <td>
                          <?php echo e($command->delivery_date->format('d/m/Y')); ?>

                        </td>
                        <td >
                          <?php echo e($command->montant); ?>

                        </td>
                        <td>
                         
                          <?php echo e($command->livraison); ?>

                         
                        </td>

                        <td>
                         
                          <?php echo e($command->livraison + $command->montant); ?>

                          
                        </td>
                        
                        
                        <td >
                          <?php if($command->livreur_id != 11): ?>
                          <?php echo e($command->livreur->nom); ?>

                          <?php else: ?>
                          Non assigne
                          <?php endif; ?>
                        </td>

                        <td>
                          <?php if($command->note->count() > 0): ?>
                          <?php echo e($command->note->last()->description); ?> - <?php echo e($command->note->last()->updated_at->format('d/m/Y')); ?>

                          <?php else: ?>
                          <?php endif; ?> 
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

            </tr>


        </tfoot>
                  </table>
                  <?php else: ?>
                  
                   <div class="container mb" >
                    <div class="row d-print-none">
                    <div class="col"> <a class="btn" href="javascript:window.print();">Imprimer</a></div>
                  <div class="form-group searchbox col ">
                <!-- <input onkeyup="search()" id="Search" type="text" class="form-control">
                <i class="input-icon">
                    <ion-icon name="search-outline"></ion-icon>
                </i> -->
            </div>

            </div>
                     <div class="row target" >
                      <?php $__currentLoopData = $commands; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $x=>$command): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                   
                       <div class="col-3 border position-relative"  style="height: 12cm">
                        
                                <span 

                          <?php if($command->etat == 'encours'): ?> 
                          class="badge badge-danger"
                          <?php endif; ?>

                          <?php if($command->etat == 'en attente'): ?> 
                          class="badge badge-warning"
                          <?php endif; ?>

                          <?php if($command->etat == 'recupere'): ?>
                          class="badge badge-warning"
                          <?php endif; ?>

                          <?php if($command->etat == 'en chemin'): ?>
                          class="badge badge-warning"
                          <?php endif; ?>


                          <?php if($command->etat == 'termine'): ?>
                          class="badge badge-success"
                          <?php endif; ?>
                          ><?php echo e($command->etat); ?>

                      </span> 
                          <strong><?php echo e($command->id); ?></strong> <br>
                          Date de livraison:  <?php echo e($command->delivery_date->format('d/m/Y')); ?><br>
                          prix: <?php echo e($command->montant-$command->remise); ?>. Livraison: <?php echo e($command->livraison); ?><br>
                         
                          <strong>Total: <?php echo e($command->livraison + $command->montant); ?></strong><br>
                            
                           Colis  <?php echo e($command->description); ?><br><br>

                        <span>

                          Expéditeur: 
                          <?php if($command->client ): ?> 
                           <?php echo e($command->client->nom); ?> <br><br>
                          <?php endif; ?> 
                          Destinataire:<br>
                           <strong><?php echo e($command->phone); ?></strong><br>
                           <?php if($command->nom_client): ?>
                          <span class="col" style="font-size: 13px; line-height: 1.6; font-style: italic;"> 
                         <?php echo e($command->nom_client); ?>

                        </span><br>
                        <?php endif; ?>
                          <?php echo e($command->adresse); ?><br>
                          <?php if($command->observation): ?>
                          Info: <?php echo e($command->observation); ?><br>
                          <?php endif; ?> 
                           </span> 
                           <ion-icon class="" name="bicycle-outline"></ion-icon> 
                            <?php if($command->livreur_id != 11): ?>
                          <?php echo e($command->livreur->nom); ?>

                          <?php else: ?>
                          Non assigne
                          <?php endif; ?> <br>
                           
                          
                        <div class="position-absolute bottom-0 end-0"><img width="64" height="64"  src="dist/img/AdminLTELogo.png"></div>
                          
                   </div>
                      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                       
                      </div>
                      </div>
                  <?php endif; ?>
            
        </div>
        </div>
       

    <!-- * App Capsule -->


    <!-- App Bottom Menu -->
    
  
    <!-- * App Bottom Menu -->


    <!-- ========= JS Files =========  -->
    <!-- Bootstrap -->
     <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
     <script src="../assets/manifest/js/app.js"></script>
    <!-- Bootstrap-->
    <script src="../assets/js/lib/popper.min.js"></script>
    <!-- JavaScript Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
    <!-- Ionicons -->
   
    <!-- Owl Carousel -->
    <script src="../assets/js/owl.carousel.min.js"></script>
    <!-- Base Js File -->
    <script src="../assets/js/base.js"></script>
   
 
 
 <script type="text/javascript" src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
 <script src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
 
 
 <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>

<script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.print.min.js"></script>







     
    <!-- Google map -->
   
 

  
  
  <script type="text/javascript">
     
$('#myTable').DataTable(  {

        select: true,
        dom: 'Bfrtip',
         buttons: [
        {
            extend: 'print',
            text: 'Imprimer'
        },
        'excel',
        
    ]
        
    });


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

</html>  <?php /**PATH /var/www/html/admin/resources/views/print.blade.php ENDPATH**/ ?>