<!doctype html>
<html lang="fr">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Jibiat - Mes Diffusions</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <meta name="viewport"
        content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, viewport-fit=cover" />
    <meta name="description" content="Finapp HTML Mobile Template">
    <meta name="keywords" content="bootstrap, mobile template, cordova, phonegap, mobile, html, responsive" />
    <link rel="apple-touch-icon" sizes="180x180" href="assets/img/apple-touch-icon.png">
    <link rel="icon" type="image/png" href="../assets/img/favicon.png" sizes="32x32">
    <link rel="shortcut icon" href="../assets/img/favicon.png">
    <link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap-switch-button@1.1.0/css/bootstrap-switch-button.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
<style>
  .toggle.ios, .toggle-on.ios, .toggle-off.ios { border-radius: 20px; }
  .toggle.ios .toggle-handle { border-radius: 20px; }
</style>

</head>

<body>
   

    <div class="modal fade dialogbox" id="confirmModal" data-bs-backdrop="static" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Supprimer diffusion</h5>
                    </div>
                    <div class="modal-body">
                        Êtes-vous sûr?
                    </div>
                    <div class="modal-footer">
                        <div class="btn-inline">
                            <a href="#" class="btn btn-text-secondary" data-dismiss="modal">ANNULER</a>
                            <a href="#" class="btn btn-text-primary delete" >CONFIRMER</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>


      <div style="height: 100rem" class="modal fade modalbox" id="candidates" tabindex="-1" role="dialog">
            <div  class="modal-dialog" role="document">
                <div  class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title cmdModalTitle">Postulants</h5>
                        <a href="javascript:;" data-dismiss="modal">Fermer</a>
                        

                    </div>
                    <div   class="modal-body">
                        <div class="action-sheet-content candidates-content">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    
    <!-- loader -->
    <div id="loader">
        <img src="assets/img/logo-icon.png" alt="icon" class="loading-icon">
    </div>
    <!-- * loader -->

    <!-- App Header -->
    <div class="appHeader">
        <div class="left">

<a href="javascript:;" class="headerButton goBack">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
            
        </div>
        <div class="pageTitle">
            Mes Diffusions

        </div>
        <div class="right">
            <a href="#" class="headerButton" data-toggle="modal" data-target="#sidebarPanel">
                <ion-icon name="menu-outline"></ion-icon>
            </a>
        </div>

        <div class="extraHeader">
        <form class="search-form">
            <div class="form-group searchbox">
                <input onkeyup="search()" id="Search" type="text" class="form-control">
                <i class="input-icon">
                    <ion-icon name="search-outline"></ion-icon>
                </i>
            </div>
        </form>
    </div>
    </div>
    <!-- * App Header -->


    <!-- Add Card Action Sheet -->
    
    <!-- * Add Card Action Sheet -->

    <div id="appCapsule" style="margin-top: 40px">
      <div class="section full mt-4">
      
            <div class="difusions">
               @if($difusions->count()>0)
                
               @foreach($difusions as $x=>$difusion)
                

                 @include("includes.difusionlist")
                 
                 @endforeach


                  <!-- by state -->
               
                @endif
                </div> 
            <!-- * card block -->
          
        </div>
        <div class="mb-3"></div>
       @include("includes.footer")

    </div>
    <!-- * App Capsule -->


    <div></div>
    <!-- App Bottom Menu -->
    @include("includes.bottom")
    @include("includes.sidebar")
    
    <!-- * App Bottom Menu -->

    <!-- App Sidebar -->
   
   
   

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
     <script src="../assets/js/commands.js"></script>
     
    <!-- Google map -->
    <script
   src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDsIOetOqXmUutxkLiMQBQC3H98Gfd_sEg&libraries=&v=weekly"
   defer
   ></script>
  <script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap-switch-button@1.1.0/dist/bootstrap-switch-button.min.js"></script>

  <script src="../assets/js/star-rating.min.js"></script>
  <script src="https://cdn.jsdelivr.net/gh/bigdatacloudapi/js-reverse-geocode-client@latest/bigdatacloud_reverse_geocode.min.js" type="text/javascript"></script>
  <script type="text/javascript">
       shareButton = document.getElementById("share");

  $(".share").click( function() {
    if (navigator.share) {
    navigator.share({
      title: 'Diffusion',
      text: $(this).val(),
      
    }).then(() => {
      console.log('Thanks for sharing!');
    })
    .catch(console.error);
  } else {
    shareDialog.classList.add('is-open');
  }
  });


  


  $(".delete").click( function() {
    $(this).prepend(spinner);
     var id = $(this).val();
     
       $.ajax({
         url: 'delete',
         type: 'post',
         data: {_token: CSRF_TOKEN, id: id},
     
         success: function(response){
                  
                  
                  $("#confirmModal").modal('hide');
                  $('.toasText9').text('Commande supprimée');
                   toastbox('toast-9', 2000);
                   $("#"+id).css("display", "none");
                   
                   $(".siteSpinner").attr('hidden', 'hidden');
                },
     error: function(response){
                 $("#confirmModal").modal('hide');
                 $("#stateModalBody").html("Une erruer s'est produite");
                  $("#stateModal").modal('show');
                  $(".siteSpinner").attr('hidden', 'hidden');
                 
                }
               
       });
  });




  $(".changestatus").click( function() {
    $(this).prepend(spinner);
     var id = $(this).val();
     var status = $(this).data("status");


       $.ajax({
         url: 'changestatus',
         type: 'post',
         data: {_token: CSRF_TOKEN, id: id, status: status},
     
         success: function(response){
                  
                  $('.toasText9').text('Statut Modifié');
                   toastbox('toast-9', 2000);

                    if(status == "encours"){
                  $("#status"+id).removeClass("text-danger");
                  $("#status"+id).addClass("text-success");
                   $("#status"+id).html("termine");


                 
                   $("#changestatus"+id).html("Difusion terminée");
                   
                   $("#changestatus"+id).attr("disabled",  "disabled");
                   }


                   if(status == "termine"){
                  $("#status"+id).removeClass("text-success");
                  $("#status"+id).addClass("text-danger");
                   $("#status"+id).html("encours");


                 
                   $("#changestatus"+id).html("Difusion encours");
                  

                   $("#changestatus"+id).attr("disabled",  "disabled");
                   
                }
            },
     error: function(response){
                 
                 $("#stateModalBody").html("Une erruer s'est produite");
                  $("#stateModal").modal('show');
                  $(".siteSpinner").attr('hidden', 'hidden');
                 
                }
               
       });
  });



$(".candidates").click( function() {
    
     var id = $(this).val();
    
       $.ajax({
         url: 'candidates',
         type: 'post',
         data: {_token: CSRF_TOKEN, id: id},
     
         success: function(response){
         $(".candidates-content").html(response.candidates);
       
        $("#candidates").modal("show");
                  

            },
     error: function(response){
                 
                 $("#stateModalBody").html("Une erruer s'est produite");
                  $("#stateModal").modal('show');
                  $(".siteSpinner").attr('hidden', 'hidden');
                 
                }
               
       });
  });

  </script>
 
</body>

</html>