<!doctype html>
<html lang="en">

<head>
     <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>JibiaT - Mes livraisons</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <meta name="viewport"
        content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, viewport-fit=cover" />
    <meta name="description" content="Livraisons - Accueuil">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <meta name="keywords" content="livreur, jibiat" />
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



    <div class="modal fade dialogbox add-modal" id="InstalAppModal"  data-backdrop="static" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="pt-3 text-center">
                        <img src="../assets/img/logo-icon.png" alt="image" class="imaged w48  mb-1">
                    </div>
                    <div class="modal-header pt-2">
                        <h5 class="modal-title">Installer l'application Jibiat</h5>
                    </div>
                    <div class="modal-body">
                        Accedez a jibiaT en un clique!
                    </div>
                    <div class="modal-footer">
                        <div class="btn-inline">
                            <a href="#" class="btn btn-text-secondary " data-dismiss="modal">Plus tard</a>
                            <a href="#" class="btn btn-text-success add-button" data-dismiss="modal">Installer</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    <!-- loader -->
    <!-- <div id="loader">
        <img src="assets/img/logo-icon.png" alt="icon" class="loading-icon">
    </div> -->
    <!-- * loader -->

    <!-- App Header -->
    <div class="appHeader">
        <img src="assets/img/675x175orange.png" width="67" height="17" alt="logo" class="logo">
    </div>
    <!-- * App Header -->

    <!-- App Capsule -->
    <div id="appCapsule">

       

        

        <div class="section mt-2">
            <div class="section-title"></div>

            <div class="row">
             
                <div  class="col-6">
                    <a href="livraisons">
                    <div class="card text-white bg-primary text-center">
                <div class="card-header">Livraisons</div>
                <div class="card-body">
                    <ion-icon style="width: 100px; height: 100px" name="bicycle-outline"></ion-icon>
                </div>
            </div>
            </a>
                   Ma liste de livraisons.
                </div>
                 
                <div class="col-6">
                    <a href="difusions">
                     <div class="card text-white bg-info text-center">
                 <div class="card-header">Diffusions</div>
                <div class="card-body">
                    <ion-icon style="width: 100px; height: 100px"  name="radio-outline"></ion-icon>
                </div>
            </div>
            </a>
                   Trouver des livraisons.<br>
                   <span class="text-info">Nouveau!</span> 

                </div>
                
            </div>

        </div>




        <div class="section mt-2 mb-2">
            <div class="section-title">Dis aux vendeurs que tu es disponible à cet endroit</div>

            <div class="row">
             <span class="text-danger mt-2">Assure toi que ton GPS est activé!</span>
                <button onclick="set()" class="btn btn-primary btn-block">Je suis disponible ici</button>
                
            </div>

            <div class="location row">
         
     </div>

        </div>
        

        <?php echo e(CertificationHelper::checkcertify($livreur, $livreur->id)); ?>


     
     <div class="section mt-2 mb-2">
            <div class="card">
                <div class="card-body border border-danger">
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

    </div>
    <!-- * App Capsule -->

   

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
    <script src="https://cdn.jsdelivr.net/gh/bigdatacloudapi/js-reverse-geocode-client@latest/bigdatacloud_reverse_geocode.min.js" type="text/javascript"></script>
    <script src="../assets/js/livraisons.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDsIOetOqXmUutxkLiMQBQC3H98Gfd_sEg&libraries=&v=weekly"></script>
    <script src="../assets/manifest/js/app.js"></script>
    
    <!-- Base Js File -->
    
<script type="text/javascript">
  

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

</html><?php /**PATH /htdocs/mklivreur/resources/views/commencer.blade.php ENDPATH**/ ?>