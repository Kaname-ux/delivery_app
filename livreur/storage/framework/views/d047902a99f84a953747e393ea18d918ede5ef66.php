<!doctype html>
<html lang="fr">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>JibiaT - Mon compte</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <meta name="viewport"
        content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, viewport-fit=cover" />
    <meta name="description" content="Jibiat - Mon compte">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <meta name="keywords" content="compte jibiat, livreur" />
    <link rel="apple-touch-icon" sizes="180x180" href="assets/img/apple-touch-icon.png">
    <link rel="icon" type="image/png" href="assets/img/favicon.png" sizes="32x32">
    <link rel="shortcut icon" href="assets/img/favicon.png">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

     <link rel = " manifest " href="../assets/manifest/livreur.json">

   <!-- ios support -->
    <link rel="apple-touch-icon" href="../assets/manifest/img/logo.png" />
    
    <meta name="apple-mobile-web-app-status-bar" content="#db4938" />
</head>


<body>
  <div class="modal fade dialogbox" id="codeModal" data-backdrop="static" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div id="newPending" class="modal-icon">
                        
                    </div>
                    <div class="modal-header">
                        <h5 class="modal-title codetitle"></h5>
                        <a href="javascript:;" data-dismiss="modal">Fermer</a>
                    </div>
                    <div class="modal-body codebody">
                        
                    </div>
                    
                </div>
            </div>
        </div>





         <div class="modal fade dialogbox" id="domModal" data-backdrop="static" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    
                    <div class="modal-header">
                        <h5 class="modal-title ">Confirmer les coodonnées de mon domicile</h5>
                        <a href="javascript:;" data-dismiss="modal">Fermer</a>
                    </div>
                    <div class="modal-body">
                        <span class="text-danger mt-2">Assure toi que tu es à ton domicile et que ton GPS est activé! Une fois confirmer, tu ne pourra plus modifier</span>
                       <button onclick="setdom()" class="btn btn-primary btn-block">Envoyer les coordonnées de mon domicile</button> 
                    </div>
                    
                </div>
            </div>
        </div>
    <!-- loader -->
   <!--  <div id="loader">
        <img src="assets/img/logo-icon.png" alt="icon" class="loading-icon">
    </div> -->
    <!-- * loader -->

    <!-- App Header -->
    <div class="appHeader">
        <div class="left">
            <a href="#" class="headerButton goBack">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">
            Mon compte
        </div>
        <div class="right">
            <a href="livraisons" class="headerButton">
                <ion-icon class="icon" name="notifications-outline"></ion-icon>
                <?php if($livreur->command->where('delivery_date', today())->where('etat', 'encours')->count()>0): ?>
                <span class="badge badge-danger">
                    
                    <?php echo e($livreur->command->where('delivery_date', today())->where('etat', 'encours')->count()); ?>

                    
                </span>
                <?php endif; ?>
            </a>
        </div>
    </div>
    <!-- * App Header -->

    <!-- App Capsule -->
    <div id="appCapsule">
        
        <div class="section mt-3 text-center">
            <div class="avatar-section">
                
                    <img <?php if($livreur->photo != NULL): ?>
                          src="<?php echo e(Storage::disk('s3')->url($livreur->photo)); ?>" 
                         <?php else: ?> src="assets/img/sample/brand/1.jpg"  <?php endif; ?> class="imaged w100 rounded">
                   
               
            </div>
        </div>

        <!-- <div class="listview-title mt-1">Notifications</div>
        <ul class="listview image-listview text inset">
            <li>
                <div class="item">
                    <div class="in">
                        <div>
                            Payment Alert
                            <div class="text-muted">
                                Send notification when new payment received
                            </div>
                        </div>
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="customSwitch4" checked/>
                            <label class="custom-control-label" for="customSwitch4"></label>
                        </div>
                    </div>
                </div>
            </li>
            <li>
                <a href="#" class="item">
                    <div class="in">
                        <div>Notification Sound</div>
                        <span class="text-primary">Beep</span>
                    </div>
                </a>
            </li>
        </ul> -->
        <div class="section mt-2">
         <?php echo $__env->make("includes.cmdvalidation", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div> 
       
        <div class="section mt-2 mb-2">
            <div class="card boder badge-danger">
                <div class="card-body">
                    <?php if($livreur->domlat == NULL || $livreur->domlong == NULL): ?>
            <div class="section-title">Envois Les coordonnés GPS de ton domicile pour être en contact avec les vendeurs près de chez toi!</div>

            <div class="row">
             <span class="text-danger mt-2">Assurez toi que tu es à ton domicile et que ton GPS est activé!</span>
                <button  class="btn btn-primary btn-block locate">Envoyer les coordonnées de mon domicile</button>
                
            </div>
            <?php else: ?>
            Vos coordonnées de domicile son enregistrées!
             <?php endif; ?>
            
          </div>
        </div>
       </div>
        
        <div class="section mt-2">
            <div class="section-title">Mes informations personnelles</div>
            <div class="card">
                <div class="card-body">

                        <div class="form-group basic">
                            <div class="input-wrapper">
                                <label class="label" for="userid1">Nom et prénom</label>
                                <input readonly name="name" value="<?php echo e($livreur->nom); ?>" type="text" class="form-control" id="userid1" placeholder="Nom et premon">
                                <i class="clear-input">
                                    <ion-icon name="close-circle"></ion-icon>
                                </i>
                            </div>
                        </div>

                        <div class="form-group basic">
                            <div class="input-wrapper">
                                <label class="label" for="select4">Ville / Commune</label>
                                 <input readonly  value="<?php echo e($livreur->city); ?>" type="text" class="form-control" id="userid1" >
                            </div>
                        </div>

                        <div class="form-group basic">
                            <div class="input-wrapper">
                                <label class="label" for="userid1">Adresse</label>
                                <input readonly name="adresse" value="<?php echo e($livreur->adresse); ?>" type="text" class="form-control" id="userid1" >
                                <i class="clear-input">
                                    <ion-icon name="close-circle"></ion-icon>
                                </i>
                            </div>
                        </div>
                       

                </div>
            </div>
        </div>

        <div class="section mt-2"> 
        <div class="section-title">Modifier Mot de Passe</div>
            <div class="card">
                <div class="card-body">
                    
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <p class="text-danger"><?php echo e($error); ?></p>
                         <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
                    
                    
                    <form method="POST" action="editpassword" >
                       <?php echo csrf_field(); ?>
                        <div class="form-group basic">
                            <div class="input-wrapper">
                                <label class="label" for="userid1">Mot de passe actuel</label>
                                <input name="current_password" value="" type="password" class="form-control" id="userid1" placeholder="Saisir mot de passe actuel">
                                <i class="clear-input">
                                    <ion-icon name="close-circle"></ion-icon>
                                </i>
                            </div>
                        </div>

                        

                       <div class="form-group basic">
                            <div class="input-wrapper">
                                <label class="label" for="new_password">Nouveau Mot de passe</label>
                                <input name="password" value="" type="password" class="form-control" id="userid1" placeholder="Saisir Nouveau mot de passe">
                                <i class="clear-input">
                                    <ion-icon name="close-circle"></ion-icon>
                                </i>
                            </div>
                        </div>

                         <div class="form-group basic">
                            <div class="input-wrapper">
                                <label class="label" for="new_password">Confirmer Nouveau Mot de passe</label>
                                <input name="confirm_password"  value="" type="password" class="form-control" id="userid1" placeholder="Confirmer Nouveau mot de passe">
                                <i class="clear-input">
                                    <ion-icon name="close-circle"></ion-icon>
                                </i>
                            </div>
                        </div>
                        <button class="btn btn-primary btn-block" type="submit">Modifier</button>
                    </form>

                </div>
            </div>
        </div>
        <div class="section mt-2">
         <button class="btn btn-danger btn-block genarate">Generer un code de validation</button>
        </div>

    </div>
    <!-- * App Capsule -->


    <!-- Dialog Form -->
        <div class="modal fade dialogbox" id="photoForm" data-backdrop="static" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Modifier photo</h5>
                    </div>
                    <form action="photo_upload" enctype="multipart/form-data" method="post">
                        <?php echo csrf_field(); ?>
                        <div class="modal-body text-left mb-2">

                            

                            <div class="form-group basic">
                                <div class="input-wrapper">
                                    <label class="label" >Choisir une photo</label>
                                    <input name="file" type="file" class="form-control"  accept="image/*">
                                    <span class="help-block text-danger"><?php echo e($errors->first('file')); ?></span>
                                    
                                </div>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <div class="btn-inline">
                                <button type="button" class="btn btn-text-secondary"
                                    data-dismiss="modal">ANNULER</button>
                                <button  class="btn btn-text-primary" >ENVOYER</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- * Dialog Form -->


    <!-- App Bottom Menu -->
    <!-- <div class="appBottomMenu">
        <a href="app-index.html" class="item">
            <div class="col">
                <ion-icon name="pie-chart-outline"></ion-icon>
                <strong>Overview</strong>
            </div>
        </a>
        <a href="app-pages.html" class="item">
            <div class="col">
                <ion-icon name="document-text-outline"></ion-icon>
                <strong>Pages</strong>
            </div>
        </a>
        <a href="app-components.html" class="item">
            <div class="col">
                <ion-icon name="apps-outline"></ion-icon>
                <strong>Components</strong>
            </div>
        </a>
        <a href="app-cards.html" class="item">
            <div class="col">
                <ion-icon name="card-outline"></ion-icon>
                <strong>My Cards</strong>
            </div>
        </a>
        <a href="app-settings.html" class="item active">
            <div class="col">
                <ion-icon name="settings-outline"></ion-icon>
                <strong>Settings</strong>
            </div>
        </a>
    </div> -->
    <!-- * App Bottom Menu -->

    <!-- ///////////// Js Files ////////////////////  -->
    <!-- Jquery -->
    <script src="../assets/js/lib/jquery-3.4.1.min.js"></script>
    <!-- Bootstrap-->
    <script src="../assets/js/lib/popper.min.js"></script>
    <script src="../assets/js/lib/bootstrap.min.js"></script>
    <!-- Ionicons -->
    <script src="https://unpkg.com/ionicons@5.0.0/dist/ionicons.js"></script>
    <!-- Owl Carousel -->
   <script src="../assets/js/owl.carousel.min.js"></script>
    <!-- Base Js File -->
    <script src="../assets/js/base.js"></script>
    <script src="../assets/js/livraisons.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDsIOetOqXmUutxkLiMQBQC3H98Gfd_sEg&libraries=&v=weekly"></script>
    <script src="../assets/manifest/js/app.js"></script>
    <script type="text/javascript">
        
        $('.genarate').click(function(){
            var code = Math.floor(1000 + Math.random() * 9000);

      $.ajax({
        url: 'codecreate',
        type: 'post',
        data: {_token: CSRF_TOKEN, code: code},
        success: function(response){
         
         $(".codetitle").text("Code: "+code);
         $(".codebody").html("<span class='text-dark'>Communiquez ce code au manager de l'entreprise pour laquelle vous travaillez, pour lui permettre de vous ajouter à la liste de ses livreurs.</span> <br><br> NB: Ce code expirera dans 24h."); 
         $("#codeModal").modal("show");
       },

  });
     
  }); 


$('.locate').click(function(){
    $("#domModal").modal("show");
   if (navigator.geolocation) {  
    navigator.geolocation.getCurrentPosition(function(position) {
        var lat = position.coords.latitude;
        var long = position.coords.longitude;
        var accuracy = position.coords.accuracy;
   },
    function error(msg) {},
    {maximumAge:10000, timeout:5000, enableHighAccuracy: true});
} else {
    alert("Geolocation API is not supported in your browser.");
}
       
  });         


function setdom(){
 
   if (navigator.geolocation) {  
    navigator.geolocation.getCurrentPosition(function(position) {
        var lat = position.coords.latitude;
        var long = position.coords.longitude;
        var accuracy = position.coords.accuracy;
        
      
         
        
 $.ajax({
      url: 'setdom',
      type: 'post',
      data: {_token: CSRF_TOKEN,lat: lat, long:long},
      success: function(response){
         location.reload();
      },

     error: function(response){
     alert("une erreur s'est produite");
     }        

            
    });
       
    },
    function error(msg) {},
    {maximumAge:10000, timeout:5000, enableHighAccuracy: true});
} else {
    alert("Geolocation API is not supported in your browser.");
}

 
}
    </script>

</body>

</html><?php /**PATH /htdocs/clients/logistica/livreur/resources/views/compte.blade.php ENDPATH**/ ?>