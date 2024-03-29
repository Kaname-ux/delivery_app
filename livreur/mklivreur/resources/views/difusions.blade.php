<!doctype html>
<html lang="fr">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Jibiat - Diffusions</title>
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

    <!-- Inclusion des feuilles de styles et script pour le composant Bootstrap-select -->
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">



<style>
  .toggle.ios, .toggle-on.ios, .toggle-off.ios { border-radius: 20px; }
  .toggle.ios .toggle-handle { border-radius: 20px; }
</style>

</head>

<body>
    <?php
    $communes = array("Adjamé", "Cocody", "Biabou", "Gonzackville", "Attécoubé", "Bingerville", "Agnama", "Koumassi", "Plateau", "Treichville", "Marcory", "Port-Bouet", "Grand Bassam", "Songon", "Abobo", "Yopougon", "N'dotre","KM17", "Abobodoumé", "Azito", "Abatta", "Faya" );


                          sort($communes);
             ?>
   

     <!-- App Sidebar -->
    <div class="modal fade panelbox panelbox-left" id="sidebarPanel" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body p-0">
                    <!-- profile box -->
                    <div class="profileBox pt-2 pb-2">
                        <div class="image-wrapper">
                            <img 
                             @if($livreur->photo != NULL)
                          src="{{Storage::disk('s3')->url($livreur->photo)}}" 
                         @else src="assets/img/sample/brand/1.jpg"  @endif
                        class="imaged  w36">
                        </div>
                        <div class="in">
                            <strong>{{$livreur->nom}}</strong>
                            <div class="text-muted">{{$livreur->phone}}</div>
                        </div>
                        <a href="#" class="btn btn-link btn-icon sidebar-close" data-dismiss="modal">
                            <ion-icon name="close-outline"></ion-icon>
                        </a>
                    </div>
                    
                    <ul class="listview flush transparent no-line image-listview">

                         <li>
                            <a href="livraisons" class="item">
                                <div class="icon-box bg-primary">
                                    <ion-icon name="bicycle-outline"></ion-icon>
                                </div>
                                <div class="in">
                                    Mes livraisons
                                    
                                </div>
                            </a>
                        </li>

                          <li>
                            <a href="commencer" class="item">
                                <div class="icon-box bg-primary">
                                    <ion-icon name="home-outline"></ion-icon>
                                </div>
                                <div class="in">
                                    Acceuil
                                </div>
                            </a>
                        </li>

                        <li>
                            <a href="difusions" class="item">
                                <div class="icon-box bg-primary">
                                    <ion-icon name="radio-outline"></ion-icon>
                                </div>
                                <div class="in">
                                  Diffusions  
                                </div>
                            </a>
                        </li>

                        <li>
                            <a href="compte" class="item">
                                <div class="icon-box bg-primary">
                                    <ion-icon name="person-outline"></ion-icon>
                                </div>
                                <div class="in">
                                    Mon compte
                                </div>
                            </a>
                        </li>
                      
                        <li>

                            <a href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();" class="item">
                                <div class="icon-box bg-primary">
                                    <ion-icon name="log-out-outline"></ion-icon>
                                </div>
                                <div class="in">
                                   {{ __('Deconnexion') }}
                                </div>
                            </a>
                        </li>
                    </ul>
                    <!-- * others -->

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
                   

                </div>
            </div>
        </div>
    </div>
    <!-- * App Sidebar -->

    
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
            Diffusions

        </div>
        @include("includes.rightmenu")

        
    </div>
    <!-- * App Header -->


    <!-- Add Card Action Sheet -->
    
    <!-- * Add Card Action Sheet -->
    
    <div id="appCapsule" >

         @if(request()->has('departs')) 
     <div class="section mt-2">
      <a href="difusions">
      <ion-icon name="chevron-back-outline"></ion-icon>
      Retours à liste</a><br>
      
      Lieux de depart:
      @foreach(request()->departs as $depart)
       {{$depart}}, 
      @endforeach

      @if(request()->has('arrivees'))
      <br>
      Lieux de livraisons: 
      @foreach(request()->arrivees as $arrivee)
       {{$arrivee}}, 
      @endforeach
      @else
      Partout
      @endif
     </div> 
     @else
     Toutes les zones
     @endif
      <div class="section  mt-2">
        <div class="section-title">Filtrer</div>

        <div class="card border border-warning">
            <div class="card-body">
         <form action="?search" class="">
            

     <div class="form-group">
             <label>Lieux de depart</label>
<select deselectAllText="Decocher tout" selectAllText="Cocher tout" required name="departs[]" class="selectpicker form-control" data-style="btn-outline-warning" multiple title="Parout" data-actions-box="true">
  @foreach($communes as $commune)
  <option @if(request()->has('departs'))

   @foreach(request()->departs as $depart2)
      @if($depart2 == $commune) 
      selected
      @endif
      @endforeach


   @endif 


   value="{{$commune}}">{{$commune}}</option>
  @endforeach
  
</select>
</div>
 <div class="form-group ">
          <label>Lieux d'arrivée</label>
<select  name="arrivees[]" class="selectpicker form-control arrivees"  data-style="btn-outline-warning" mobile="true"  multiple title="Partout" data-actions-box="true" deselectAllText="Decocher tout" selectAllText="Cocher tout">

  
  @foreach($communes as $commune2)
  <option 

   @if(request()->has('arrivees'))

   @foreach(request()->arrivees as $arrivee2)
      @if($arrivee2 == $commune2) 
      selected
      @endif
      @endforeach


   @endif 


  value="{{$commune2}}">{{$commune2}}</option>
  @endforeach
  
</select>

            </div>

            <button type="submit" class="btn btn-primary btn-block" >GO</button>
        </form>

        
    </div>
      </div>
            <div class="difusions">
               @if($difusions->count()>0)
                
               @foreach($difusions as $x=>$difusion)
                

                 @include("includes.difusionlist")
                 
                 @endforeach

            {!! $difusions->links() !!}
                  <!-- by state -->
               @else
               Aucune diffusion encours
                @endif
                </div> 
            <!-- * card block -->
          
        </div>
        <div class="mb-3"></div>
       

    </div>
    <!-- * App Capsule -->


    <div></div>
    <!-- App Bottom Menu -->
    
    
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
    <script src="../assets/js/livraisons.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDsIOetOqXmUutxkLiMQBQC3H98Gfd_sEg&libraries=&v=weekly"></script>
    <script src="../assets/manifest/js/app.js"></script>

    <!-- Latest compiled and minified JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>

<!-- (Optional) Latest compiled and minified JavaScript translation files -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/i18n/defaults-*.min.js"></script>
    
  <script type="text/javascript">
    $('select').selectpicker();
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


$(".postule").click( function() {
    var id = $(this).data("id");
        var post = $(this).val();
        var postule = $(this);
        var canal = $(this).data("canal");
      if (navigator.geolocation) {  
    navigator.geolocation.getCurrentPosition(function(position) {
        var lat = position.coords.latitude;
        var long = position.coords.longitude;
        var accuracy = position.coords.accuracy;
        
        
        $.ajax({
      url: 'postule',
      type: 'post',
      data: {_token: CSRF_TOKEN,lat: lat, long:long, id:id, post:post},
      success: function(response){
        if(response.status == '1')
        {
            

            if(post == "postule")
                {
            $(".postule"+id).val("cancel");
            $(".postule"+id).html("Me retirer");
            $(".contact_status"+id).html("Je suis intéressé");
            
            $(".postule"+id).removeClass("btn-success");
            $(".postule"+id).addClass("btn-danger");
                
        }

            if(post == "cancel")
                {
              $(".postule"+id).val("postule");
            $(".postule"+id).html("Postuler");
            $(".postule"+id).removeClass("btn-danger");
            $(".postule"+id).addClass("btn-success");
            $(".contact_status"+id).html("");
        }
                
            }
       if(response.status == '2')
       {
          
       }
      },

     error: function(response){
        alert("Une erreur s'est produite");
     }        

            
    });
    },
    function error(msg) {},
    {maximumAge:10000, timeout:5000, enableHighAccuracy: true});
} else {
    alert("Geolocation API is not supported in your browser.");
}    

            
    });


 
   




  


  </script>
 
</body>

</html>