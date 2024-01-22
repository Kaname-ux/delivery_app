<!doctype html>
<html lang="fr">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Jibiat - Certification</title>
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
                    <!-- * profile box -->
                   

                    <!-- action group -->
                    <!-- <div class="action-group">
                        <a href="app-index.html" class="action-button">
                            <div class="in">
                                <div class="iconbox">
                                    <ion-icon name="add-outline"></ion-icon>
                                </div>
                                Deposit
                            </div>
                        </a>
                        <a href="app-index.html" class="action-button">
                            <div class="in">
                                <div class="iconbox">
                                    <ion-icon name="arrow-down-outline"></ion-icon>
                                </div>
                                Withdraw
                            </div>
                        </a>
                        <a href="app-index.html" class="action-button">
                            <div class="in">
                                <div class="iconbox">
                                    <ion-icon name="arrow-forward-outline"></ion-icon>
                                </div>
                                Send
                            </div>
                        </a>
                        <a href="app-cards.html" class="action-button">
                            <div class="in">
                                <div class="iconbox">
                                    <ion-icon name="card-outline"></ion-icon>
                                </div>
                                My Cards
                            </div>
                        </a>
                    </div> -->
                    <!-- * action group -->

                    <!-- menu -->
                    <!-- <div class="listview-title mt-1">Menu</div>
                    <ul class="listview flush transparent no-line image-listview">
                        <li>
                            <a href="app-index.html" class="item">
                                <div class="icon-box bg-primary">
                                    <ion-icon name="pie-chart-outline"></ion-icon>
                                </div>
                                <div class="in">
                                    Overview
                                    <span class="badge badge-primary">10</span>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="app-pages.html" class="item">
                                <div class="icon-box bg-primary">
                                    <ion-icon name="document-text-outline"></ion-icon>
                                </div>
                                <div class="in">
                                    Pages
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="app-components.html" class="item">
                                <div class="icon-box bg-primary">
                                    <ion-icon name="apps-outline"></ion-icon>
                                </div>
                                <div class="in">
                                    Components
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="app-cards.html" class="item">
                                <div class="icon-box bg-primary">
                                    <ion-icon name="card-outline"></ion-icon>
                                </div>
                                <div class="in">
                                    My Cards
                                </div>
                            </a>
                        </li>
                    </ul> -->
                    <!-- * menu -->

                    <!-- others -->
                    <!-- <div class="listview-title mt-1">Others</div> -->
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
                    <!-- * others -->

                    <!-- send money -->
                   <!--  <div class="listview-title mt-1">Send Money</div>
                    <ul class="listview image-listview flush transparent no-line">
                        <li>
                            <a href="#" class="item">
                                <img src="assets/img/sample/avatar/avatar2.jpg" alt="image" class="image">
                                <div class="in">
                                    <div>Artem Sazonov</div>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="item">
                                <img src="assets/img/sample/avatar/avatar4.jpg" alt="image" class="image">
                                <div class="in">
                                    <div>Sophie Asveld</div>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="item">
                                <img src="assets/img/sample/avatar/avatar3.jpg" alt="image" class="image">
                                <div class="in">
                                    <div>Kobus van de Vegte</div>
                                </div>
                            </a>
                        </li>
                    </ul> -->
                    <!-- * send money -->

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

        <div class="extraHeader">
        
    </div>
    </div>
    <!-- * App Header -->


    <!-- Add Card Action Sheet -->
    
    <!-- * Add Card Action Sheet -->

    <div id="appCapsule" style="margin-top: 40px">
       <div class="section mt-2 text-center">
            <h1>Certification</h1>
            <h4>Certifier mon compte</h4>
        </div>
        <div class="section mb-5 p-2">
            <form enctype="multipart/form-data" method="POST" action="certification">
                @csrf


                <div class="card">
                    <div class="card-body">

                        <div class="card border border-danger">
            <div class="card-header">Photo De votre pièce d'identité</div>

            <div class="card-body">
               
                    <div class="form-group">
                        <input accept="image/*" type="file" name="piece_photo" id="">
                        <span class="help-block text-danger">
                             @error('piece_photo')
                            {{$errors->first('piece_photo')}}</span>
                            @enderror
                    </div>
                                     
            </div>
        </div>

                       <div class="form-group basic">
                            

                            <div class="input-wrapper  @error('name') alert alert-outline-danger @enderror">
                                <label for="name" class="label">Numero de pièce</label>
                                <input max="50" placeholder="Nom et Prenom" id="name" type="text" class="form-control " name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>



                        <div class="form-group basic">
                            

                            <div class="input-wrapper @error('phone') alert alert-outline-danger @enderror">
                                <label for="phone" class="label">Contact</label>
                                <input maxlength="10" placeholder="Ex: 07000000" id="phone" type="number" class="form-control " name="phone" value="{{ old('phone') }}" required autocomplete="phone" autofocus>

                                @error('phone')
                                    <span class="text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>





                        <?php 
                         
                          $photo_title = "Ajouter une photo";
                           ?>


                    

                   @if(Storage::disk('s3')->exists($livreur->photo))
                   <div>
                    <div class="row">
                        Votre photo actuelle <br>
                   <img height="40px" width="40px" src="{{Storage::disk('s3')->url($livreur->photo)}}">
                   </div>
                   </div>
                    <?php $photo_title = "Modifier photo"; ?>
                   @endif
    
      <div class="card border border-danger">
            <div class="card-header">{{$photo_title}}</div>

            <div class="card-body">
               
                    <div class="form-group">
                        <input accept="image/*" type="file" name="file" id="">
                         @error('file')
                        <span class="help-block text-danger">{{$errors->first('file')}}</span>
                        @enderror
                    </div>
                                     
            </div>
        </div>
       
      
        
                        

                       
        
                    </div>
                </div>



                <div class="form-button-group transparent">
                    <button type="submit" class="btn btn-primary btn-block btn-lg">Envoyer</button>
                </div>

            </form>
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


$(".postule").click( function() {
    var id = $(this).val();
        var post = $(this).data("post");
        var postule = $(this);
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
                {postule.css("display", "none");
            $("#cancel"+id).css("display", "block");}

            if(post == "cancel")
                {postule.css("display", "none");
            $("#postule"+id).css("display", "block");}
                
            }
       if(response.status == '2')
       {
        alert("Vous avez déja postulé pour cette diffusion");
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