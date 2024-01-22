<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Certifications</title>

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
<div class="wrapper">
  <!-- Navbar -->
 <?php echo $__env->make("includes.navbar", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<div class="modal fade modalbox" id="refusedModal" data-backdrop="static" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        
                        <h5 class="modal-title refusedModalTitle"></h5>
                       <a href="javascript:;" data-dismiss="modal">Fermer</a>

                    </div>
                    
                    <div class="modal-body " >
                        <div class="refusedModalBody">
                          
                        </div>

                        <form method="POST" action="refused">
                    <?php echo csrf_field(); ?>
                    
            

                     <div class="form-group">
                      <label class="form-label">Id Demande
                      </label>
                    <input required class="form-control" id="refused_id" type="" name="refused_id" readonly >
                     </div>

                     

                    


                     <div class="form-group">
                      <label class="form-label">Raison du refus de certification
                      </label>

                      <textarea required placeholder="" class="form-control" id="comment" row="3" name="reasons"></textarea>
                    
                     </div>
                    
                   <button type="submit" class="btn btn-danger ">Refuser</button>
                   <button  class="btn btn-default" data-dismiss="modal">Fermer</button>
                   </form>
                    </div>
                  
                </div>
            </div>
        </div>

  <div class="modal fade dialogbox add-modal" id="bigModal"  data-backdrop="static" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    
                    <div class="modal-header pt-2">
                        
                    </div>
                    <div class="modal-body bigModalBody">
                        
                    </div>
                   
                      <button class="close" data-dismiss="modal">&times;</button>
                    
                </div>
            </div>
        </div>
  <div class="modal fade dialogbox" id="stateModal" data-backdrop="static" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h5 class="modal-title"></h5>
                       

                    </div>
                    
                    <div class="modal-body" id="stateModalBody">
                        
                    </div>
                   
                </div>
            </div>
        </div>




        <div class="modal fade dialogbox" id="confirmModal" data-backdrop="static" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h5 class="modal-title confirmModalTitle"></h5>
                       

                    </div>
                    
                    <div class="modal-body " >
                        <div class="confirmModalBody">
                          
                        </div>

                        <form method="POST" action="certify">
                    <?php echo csrf_field(); ?>
                    
                    <div class="form-group">
                      <label class="form-label">Id utilisateur
                      </label>
                    <input required class="form-control" id="user_id" type="" name="user_id" readonly >
                     </div>


                     <div class="form-group">
                      <label class="form-label">Id livreur
                      </label>
                    <input required class="form-control" id="liv_id" type="" name="liv_id" readonly >
                     </div>


                     <div class="form-group">
                      <label class="form-label">Id Demande
                      </label>
                    <input required class="form-control" id="cert_id" type="" name="cert_id" readonly >
                     </div>

                     <div class="form-group">
                      <label class="form-label">Nom
                      </label>
                    <input required class="form-control" id="liv_name" type="" name="liv_name" >
                     </div>


                     <div class="form-group">
                      <label class="form-label">Contact
                      </label>
                    <input required class="form-control" id="liv_phone" type="" name="liv_phone" >
                     </div>
                    

                    <div class="form-group">
                      <label class="form-label">Whatsapp
                      </label>
                    <input required class="form-control" id="liv_wphone" type="" name="liv_wphone" >
                     </div>

                     <div class="form-group">
                      <label class="form-label">Numero pièce d'identité
                      </label>
                    <input id="pieces" required class="form-control"  type="" name="pieces" >
                     </div>
                    
                   <button class="btn btn-success confirm">Confirmer</button>
                   <button  class="btn btn-default" data-dismiss="modal">Annuler</button>
                   </form>
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
            <h1>Demandes de certification livreurs</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="dashboard">Home</a></li>
              <li class="breadcrumb-item active">Certification</li>
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
                <h3 class="card-title">Liste des demandes</h3>

                <div class="card-tools">
                  
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0" >
                <table class="table table-head-fixed text-nowrap">
                 <thead class=" text-primary">
                      <th>Id</th>
                      
                      <th>
                        Date de demande
                      </th>
                      <th>
                         Nom
                      </th>
                      <th>
                        Photo
                      </th>
                      <th>
                        Piece d'identité
                      </th>
                      <th>
                        Contact
                      </th>
                      <th>
                        whatsapp
                      </th>
                     <th>
                       Status
                     </th>
                      <th>
                        Decision
                      </th>
                    </thead>
                    <tbody>
                      <?php $__currentLoopData = $certifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $certification): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                      <tr>
                        
                        <td>
                           
                          <?php echo e($certification->id); ?> 
                          

                        
                         
                        </td>
                        
                        <td>
                           <?php echo e($certification->created_at->format("d-m-Y")); ?>


                        </td>
                        <td>
                            <?php echo e($certification->name); ?>

                        </td>
                        
                          
                        <td>
                          

                          <img width="200px" height="200px" 
                          src="<?php echo e(Storage::disk('s3')->url($certification->photo_ref)); ?>" 
                            class="image-block imaged w48 big">

                         
                        </td>
                       
                        <td>
                          

                          <img width="200px" height="200px"
                          src="<?php echo e(Storage::disk('s3')->url($certification->piece_ref)); ?>" 
                            class="image-block imaged w48 big">

                          
                        </td>
                        <td>
                          <?php echo e($certification->phone); ?>

                        </td>

                        <td>
                          <?php echo e($certification->wphone); ?>

                        </td>

                        <td>
                          <button data-liv="<?php echo e($certification->livreur_id); ?>" value="<?php echo e($certification->user_id); ?>" data-name="<?php echo e($certification->name); ?>" class="btn btn-success accept" data-photo="<?php echo e(Storage::disk('s3')->url($certification->photo_ref)); ?>" data-p_photo="<?php echo e(Storage::disk('s3')->url($certification->piece_ref)); ?>" data-phone='<?php echo e($certification->phone); ?>'
                            data-wphone='<?php echo e($certification->wphone); ?>' data-cert_id="<?php echo e($certification->id); ?>">Accepter</button>
                          <button value="<?php echo e($certification->id); ?>" class="btn btn-danger refused">Refuser</button>
                        </td>

                        <td>
                          <?php echo e($certification->status); ?>

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
<!-- ./wrapper -->

<!-- jQuery -->
<script src="../../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="../../dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../../dist/js/demo.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
$(".refused").click( function() {
   
   
   
   var cert_id = $(this).val();
   $("#refused_id").val(cert_id); 

    $(".refusedModalTitle").html("Refuser certification");
    $(".refusedModalBody").html("soyez sûr de votre déision et expliquez bien les raisons. Une fois refusé, le livreur devra introduire une nouvelle demande.");
     $("#refused_id").val(cert_id);
     $("#confirmModal").modal("hide");
    $("#refusedModal").modal("show");
    
   }); 


    


$('#submitBtn').click(function() {
     /* when the button in the form, display the entered values in the modal */
     
});

$('#submit').click(function(){
     /* when the submit button in the modal is clicked, submit the form */
    
    $('#myForm').submit();
});




    $(".accept").click( function() {
   
   
   var user_id = $(this).val();
   var liv_id = $(this).data("liv");
   var name = $(this).data("name");
   var photo = $(this).data("photo");
   var p_photo = $(this).data("p_photo");
   var cert_id = $(this).data("cert_id");
    var phone = $(this).data("phone");
    var wphone = $(this).data("wphone")

    $(".confirmModalTitle").html("Certifier "+name);
    $(".confirmModalBody").html("Points a verifier <br><ul><li>Pièce d'identité lisible(texte et photo)</li><li>Photo de bonne qualité avec visage bien visible</li><li>Nom complet conforme à celui inscrit sur la pièce d'identité</li><li>Numero de telephone correcte et appartenant au concerné</li><li>Numero whatsapp correcte et appartenant au concerné</li></ul><br>Nom: "+name+ " Contact:"+phone+" Whatsapp:"+wphone+" <br><br> <img width='100%' src='"+photo+"' ><img width='100%' src='"+p_photo+"' >");
     $("#user_id").val(user_id);
     $("#liv_id").val(liv_id);
     $("#liv_phone").val(phone);
     $("#liv_wphone").val(wphone);
     $("#liv_name").val(name);
     $("#cert_id").val(cert_id);
    $("#confirmModal").modal("show");
    
   }); 



    $(".confirm").click( function() {
   
   var formula = $(this).data("formula");
   var client_id = $(this).val();
   if(formula == "monthly"){var title = "Formule mensuelle";}
    if(formula == "yearly"){var title = "Formule annuelle";}


     $.ajax({
       url: 'checksubscription',
       type: 'post',
       data: {_token: CSRF_TOKEN, formula: formula},
   
       success: function(response){
               $("#subscribeModal").modal("show");
               $(".message").html(response.message);
               $(".modal-title").html(title);
               $('#formula_btn').val(formula);
              },
   error: function(response){
               $("#stateModalBody").html("Une erruer s'est produite");
                $("#stateModal").modal('show');
               
              }
             
     });
   }); 
     
} );

$('.big').click(function(){var src = $(this).attr('src');$('.bigModalBody').html("<img src='"+src+"' width='100%' height='100%'>");$("#bigModal").modal("show");});
</script>
</body>
</html>
<?php /**PATH /htdocs/clients/logistica/admin/resources/views/certifications.blade.php ENDPATH**/ ?>