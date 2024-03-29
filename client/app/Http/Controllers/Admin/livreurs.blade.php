<!doctype html>
<html lang="fr">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Jibiat - Livreurs</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <meta name="viewport"
        content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, viewport-fit=cover" />
    <meta name="description" content="Listes des livreurs">
    <meta name="keywords" content="Jibiat, livreurs, livraisons," />
    <link rel="apple-touch-icon" sizes="180x180" href="assets/img/apple-touch-icon.png">
    <link rel="icon" type="image/png" href="../assets/img/favicon.png" sizes="32x32">
    <link rel="shortcut icon" href="../assets/img/favicon.png">
    <link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap-switch-button@1.1.0/css/bootstrap-switch-button.min.css" rel="stylesheet">
    
</head>

<style type="text/css">

  body {
    background-color: #EDEDF5;
    border-radius: 10px
}
  
  .stats {
    background: #f2f5f8 !important;
    color: #000 !important
}

.articles {
    font-size: 10px;
    color: #a1aab9
}

.number1 {
    font-weight: 500
}

.followers {
    font-size: 10px;
    color: #a1aab9
}

.number2 {
    font-weight: 500
}

.rating {
    font-size: 10px;
    color: #a1aab9
}

.number3 {
    font-weight: 500
}
.page-item {
   background-color: #5987B3
  
}
</style>

<body>

<div class="modal fade modalbox" id="AsearchModal" data-backdrop="static" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        
                        <h5 class="modal-title confirmModalTitle"></h5>
                       <a href="javascript:;" data-dismiss="modal">Fermer</a>

                    </div>
                    
                    <div class="modal-body " >
                        
                        <form method="POST" action="">
                    @csrf
                    <input hidden type="" value="1" name="asearch">
                    <div class="form-check ">
  <input name="certified" class="form-check-input" type="checkbox"  value="1">
  <label class="form-check-label" >Afficher seulement les livreurs certifier</label>
  </div>
  <hr>
                    
                     <div class="mb-2 ">
                    <span style="font-weight:bold;"> Lieu d'habitation</span>
  <div class="col-12">                  

   

</div> 
               </div>
<hr>



                     
                    
                   <button type="submit"  class="btn btn-success phone">Confirmer</button>
                   <button  class="btn btn-default phone" data-dismiss="modal">Annuler</button>
                   </form>
                    </div>
                  
                </div>
            </div>
        </div>





<div class="modal fade modalbox" id="confirmModal" data-backdrop="static" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        
                        <h5 class="modal-title confirmModalTitle"></h5>
                       <a href="javascript:;" data-dismiss="modal">Fermer</a>

                    </div>
                    
                    <div class="modal-body " >
                        <div class="confirmModalBody">
                          
                        </div>

                        <form method="POST" action="signal">
                    @csrf
                    
                    
                    <input  required class="form-control" id="liv_id"  name="liv_id" hidden >
                     <div class="mb-2 ">
                    <span style="font-weight:bold;"> Quelles sont les raisons du signalement </span>
                     
                   
                     <div class="form-group">
                     
                    <select name="reasons" class="form-control">
                        <option>Choisir les raisons</option>
                        <option value="Recette non versée">Recette non versée</option>
                        <option value="colis non rétournés">colis non rétournés</option>
                        <option value="Recette et colis non rétournés">Recette et colis non rétournés</option>
                    </select>
                     </div>
               </div>



                     <div class="form-group">
                      <label class="form-label">Date des faits
                      </label>
                    <input id="fact_date" required class="form-control"  type="date" name="fact_date"  >
                     </div>

                     <div class="form-group">
                      <label class="form-label">Commentaire (Facultatif)
                      </label>
                      <textarea placeholder="" class="form-control" id="comment" row="3" name="comment"></textarea>
                     </div>


                     
                    
                   <button  class="btn btn-success phone">Confirmer</button>
                   <button  class="btn btn-default phone" data-dismiss="modal">Annuler</button>
                   </form>
                    </div>
                  
                </div>
            </div>
        </div>
    <div id="loader">
        <img src="assets/img/logo-icon.png" alt="icon" class="loading-icon">
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
    

    <!-- App Header -->
    <div class="appHeader">
        <div class="left">
            <a href="#" class="headerButton goBack">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">
            Livreurs
        </div>
        <div class="right">
            <a href="#" class="headerButton" data-toggle="modal" data-target="#sidebarPanel">
                <ion-icon name="menu-outline"></ion-icon>
            </a>
        </div>



    </div>
    <!-- * App Header -->
    <div class="extraHeader">
        <div class="row">
            
        <form action="?find_by_id" class="search-form ">
            
            <div class="form-group searchbox ">
                
                <input  value="{{old('livreur_id')}}" name="livreur_id"  type="text" class="form-control">
              
                <i class="input-icon">
                    <ion-icon name="search-outline"></ion-icon>
                </i>
                
            
            <button class="btn btn-success" type="submit"><ion-icon name="arrow-forward-outline"></ion-icon></button>
            </div>

            
            
        
        </form>
        <!-- <button data-toggle="modal" data-target="#AsearchModal" class="btn btn-primary" ><ion-icon name="funnel-outline"></ion-icon></button> -->
          
        </div>
    </div>

    <!-- App Capsule -->
    <div id="appCapsule">

        <!-- Transactions -->

       <div class="section mt-2">
            <div class="section-title"></div>
            <div class="transactions">
                <!-- item -->
                
             

               
               
                <!-- * item -->
            </div>
        </div>



        <div class="section mt-2">
            <div class="section-title"></div>
            <div class="transactions">
                <!-- item -->
                <strong>Afficher par commune</strong>
              <form action="?" class="search-form form-inline">
            
            <div class="form-group searchbox ">
                <select required name="city" class="form-control">
                    <option>Choisir une commune</option>
                @foreach($fees as $fee)
                <option value="{{$fee->destination}}">{{$fee->destination}}</option>
                @endforeach
               </select>
            <button class="btn btn-success" type="submit"><ion-icon name="arrow-forward-outline"></ion-icon></button>
            </div>

            
            
        
        </form>

               
               
                <!-- * item -->
            </div>
        </div>
        <!-- * Transactions -->

        <!-- Transactions -->
        <div class="section mt-2">
            <div class="section-title">{{$zone}}  @if( $zone == "Resultat de votre recherche").  {{$livreurs->count()}} trouvé(s) 
            <div class="left">
            <a href="livreurs" class="headerButton goBack">
                <ion-icon name="chevron-back-outline"></ion-icon>Revenir à la liste
            </a>
        </div>


            @endif</div>

            <div class="section-heading">
               <button class="btn btn-warning" id="invite"><ion-icon name="share-social-outline"></ion-icon>Inviter des livreurs a s'incrire</button>
               @if($client->livreurs->count()>0)
               <a href="meslivreurs" class="btn btn-light right ">Mes livreur</a>
               @endif

            </div>
            
        <button class="btn btn-primary btn-block globalNearByLivreur">Voir les livreurs à proximité</button>

            @if (session('status') && session('status'))
      <div class="alert alert-success mb-1" role="alert">
      {{ session('status') }}
      </div>
      @endif
            <div class="transactions">
              <div style="overflow-x: auto;white-space: nowrap">{{$livreurs->links()}}</div>  
                
                <!-- item -->

                @if($livreurs->count()>0 )

               @include("includes.livreurs")
                @endif
               
                <!-- * item -->
                
            </div>
        </div>
        <!-- * Transactions -->

       
        

       <!--  <div class="section mt-2 mb-2">
            <a href="javascript:;" class="btn btn-primary btn-block btn-lg">Load More</a>
        </div> -->

        <div class="row ">
           <div class="col-12">
               
               </div>
 
        </div>

         
                <!-- item -->
                
              
              <div style="overflow-x: auto;white-space: nowrap">{{$livreurs->links()}}</div> 
               
               
               



        <div class="section mt-2">
            <div class="section-title"></div>
            <div class="transactions">
                <!-- item -->
                
              

               
               
                <!-- * item -->
            </div>
        </div>
 @include("includes.footer")

    </div>
    <!-- * App Capsule -->


    <!-- App Bottom Menu -->
   
 @include("includes.bottom")
    <!-- * App Bottom Menu -->
@include("includes.sidebar")

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
    
    <!-- Google map -->
    <script
   src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDsIOetOqXmUutxkLiMQBQC3H98Gfd_sEg&libraries=&v=weekly"
   defer
   ></script>
  <script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap-switch-button@1.1.0/dist/bootstrap-switch-button.min.js"></script>




<script src="../assets/js/star-rating.min.js"></script>

<script src="../assets/js/commands.js"></script>
<script type="text/javascript">

   





    $(".signal").click( function() {
   
   
   
   var liv_id = $(this).val();
   var name = $(this).data("name");
   

    $(".confirmModalTitle").html("Signaler "+name);
    
     
     $("#liv_id").val(liv_id);
     
    $("#confirmModal").modal("show");
    
   }); 
  
  // add livreur
  $(".addlivreur").click( function() {
    
    var livreur_id = $(this).data('id');
    var current = $(this);
    
      $.ajax({
        url: 'addlivreur',
        type: 'post',
        data: {_token: CSRF_TOKEN,livreur_id: livreur_id},
        success: function(response){
           
          (current).attr("disabled", "disabled");
          (current).text("Livreur ajouté");
       }
      });
    });


  // add livreur
  $(".removelivreur").click( function() {
    
    var livreur_id = $(this).data('id');
    var current = $(this);

    $.ajax({
        url: 'removelivreur',
        type: 'post',
        data: {_token: CSRF_TOKEN,livreur_id: livreur_id},
        success: function(response){
           
          (current).attr("disabled", "disabled");
          (current).text("Livreur rétiré");
       }
      });
   
  });


  invite = document.getElementById("invite");
invite.addEventListener('click', event => {
  if (navigator.share) {
    navigator.share({
      title: 'Jibiat - Il y a des colis à livrer',
      text: "J'utilse l'application jibiat pour mes ventes en ligne. Inscris-toi pour être parmi mes livreur.",
      url: 'https://livreurjibiat.site/register'
    }).then(() => {
      console.log('Thanks for sharing!');
    })
    .catch(console.error);
  } else {
    shareDialog.classList.add('is-open');
  }
}); 
</script>

</body>

</html>