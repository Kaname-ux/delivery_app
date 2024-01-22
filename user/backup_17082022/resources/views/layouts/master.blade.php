<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />

  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="../assets/img/favicon.png">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>
     @yield("title")
  </title>


  <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
  <!--     Fonts and icons     -->
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
  <!-- CSS Files -->
  <link href="../assets/css/bootstrap4.min.css" rel="stylesheet" />
  

 
<link rel = " manifest " href="../assets/manifest/client.json">

   <!-- ios support -->
    <link rel="apple-touch-icon" href="../assets/manifest/img/logo.png" />
    
    <meta name="apple-mobile-web-app-status-bar" content="#db4938" />

<script src="../assets/js/core/jquery.min.js"></script>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
            integrity= 
"sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
            crossorigin="anonymous"> </script>

</head>

<body style="background-color: #D8D8D8" class="">

 
    <div class="main-panel" id="main-panel">

     
      <!-- Navbar -->
     <div class="fixed-top" >
      <nav class="navbar navbar-expand-md navbar-light" style="background-color: #0B3B2E;">
            <div class="container" style="margin-bottom: 15px">
                
                <a href="commencer" style="font-size: 30px; color: white"><i class="fa fa-home"></i></a>
               <h4 style="color: white"> {{'dashboard' == request()->path() ? 'Commandes' : 'Livreurs'}}</h4>
               @if(request()->path() == 'dashboard')
               <p style="color: white">{{$total}} FCFA</p>
               @endif
                  
                 


                <button   class="navbar-toggler btn btn-light" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span style="color: white"  class="navbar-toggler-icon" ></span>
                </button>


                   
               
                
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                   

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                       
                      <li class="nav-item">
                         <a class="nav-link" href="point">
                                     Mes ventes 
                                    </a>

                         </li>
                       <li class="nav-item">
                         <a class="nav-link" onclick="initMap()" href="#">
                                     Ma localisation
                                    </a>

                         </li>

                        @auth
                          <li class="nav-item">
                         <a class="nav-link" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Deconnexion') }}
                                    </a>

                         </li>
                        @endauth


                    </ul>

                   
                </div>
            </div>

           

@if(request()->path() == 'dashboard')
           <div style="overflow:auto; white-space: nowrap; width: 100%;  " >
         <!-- <button  style=" background-color: black; color: white" class="mx-auto  font-weight-bold text-uppercase btn    " 
         type="button">{{$total}} FCFA</button> -->

         


          <div  class="btn-group">
  <button style="color: white"  id="dashboard_btn"  class="mx-auto  font-weight-bold text-uppercase btn   @if($state && $state == 'all') btn-outline-light @else btn-outline-default @endif" 
         type="button">Tout {{$all_commands->count()}} </button>
   @if($state && $state == 'all')
  <button type="button" class="btn btn-outline-light dropdown-toggle" data-toggle="modal" data-target="#cmdDtlModal">
    <span class="caret"></span>
  </button>
  
  @endif
</div>


<div  class="btn-group">
  
          <button style="color: white" id="enattente_btn"  class="mx-auto font-weight-bold text-uppercase btn  align-middle @if($attente && $attente == 'attente') btn-outline-light @else btn-outline-default @endif " type="button">En attente {{$all_commands->where('livreur_id', 11)->where('etat', '!=', 'annule')->where('etat','=', 'encours')->count()}}</button>
 @if($attente && $attente == 'attente')
  <button type="button" class="btn btn-outline-light dropdown-toggle" data-toggle="modal" data-target="#cmdDtlModal">
    <span class="caret"></span>
  </button>
  
  @endif
</div>
         


         <div  class="btn-group">
   <button style="color: white" id="termine_btn"  class="mx-auto font-weight-bold text-uppercase btn  align-middle @if($state && $state == 'termine') btn-outline-light @else btn-outline-default @endif" type="button">Terminé {{$all_commands->where('etat', 'termine')->count()}}</button>
  @if($state && $state == 'termine')
  <button type="button" class="btn btn-outline-light dropdown-toggle" data-toggle="modal" data-target="#cmdDtlModal">
    <span class="caret"></span>
  </button>
  
  @endif
</div>



         


           <div  class="btn-group">
    <button style="color: white" id="enchemin_btn"  class="mx-auto font-weight-bold text-uppercase btn  align-middle @if($state && $state == 'en chemin') btn-outline-light @else btn-outline-default @endif" type="button">En chemin {{$all_commands->where('livreur_id', '!=', 11)->where('etat', 'en chemin')->count()}}</button>
  @if($state && $state == 'en chemin')
  <button type="button" class="btn btn-outline-light dropdown-toggle" data-toggle="modal" data-target="#cmdDtlModal">
    <span class="caret"></span>
  </button>
  
  @endif
</div>

         

      <div  class="btn-group">
     <button style="color: white" id="recupere_btn"  class="mx-auto font-weight-bold text-uppercase btn  align-middle @if($state && $state == 'recupere') btn-outline-light @else btn-outline-default @endif" type="button">Recuperé {{$all_commands->where('livreur_id', '!=', 11)->where('etat', 'recupere')->count()}}</button>
  @if($state && $state == 'recupere')
  <button type="button" class="btn btn-outline-light dropdown-toggle" data-toggle="modal" data-target="#cmdDtlModal">
    <span class="caret"></span>
  </button>
  
  @endif
</div>


          

          <div  class="btn-group">
  <button style="color: white" id="encours_btn"  class="mx-auto font-weight-bold text-uppercase btn align-middle @if($state && $state == 'encours' && $attente != 'attente' ) btn-outline-light @else btn-outline-default @endif" type="button">En cours {{$all_commands->where('livreur_id', '!=', 11)->where('etat', 'encours')->count()}}</button>
  @if($state && $state == 'encours' && $attente != 'attente' )
  <button type="button" class="btn btn-outline-light dropdown-toggle" data-toggle="modal" data-target="#cmdDtlModal">
    <span class="caret"></span>
  </button>
  
  @endif
</div>
          
        


          
          
         

         <div  class="btn-group">
  
           <button style="color: white;" id="annule_btn"  class="mx-auto font-weight-bold text-uppercase btn  align-middle @if($state && $state == 'annule') btn-outline-light  @else btn-outline-default  @endif" type="button">
          Annulé {{$all_commands->where('etat', 'annule')->count()}}
         </button>
 @if($state && $state == 'annule')
  <button type="button" class="btn btn-outline-light dropdown-toggle" data-toggle="modal" data-target="#cmdDtlModal">
    <span class="caret"></span>
  </button>
  
  @endif
</div>
      </div>
     @endif

     @if(request()->path() == 'livreurs')
     <a style="color: white" class="btn font-weight-bold text-uppercase



       {{ $zone =='Tous les livreurs' ? 'btn-outline-light' : 'btn-outline-default'}}" href="/livreurs">Tous les livreurs</a>

                         <a style="color: white" id="my_liv" class="btn font-weight-bold text-uppercase  {{'Mes Livreurs' == $zone ? ' btn-outline-light' : 'btn-outline-default'}}" >Mes livreur</a>
     @endif
        </nav>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
  </div>    
 
      <div style="margin-top: 120px; margin-bottom: 80px"  class="content">



         @yield("content")
        

      </div>
      <footer class="footer" >
        <div class="container-fluid">
          <!-- <nav>
            <ul>
              <li>
                <a class="{{'dashboard' == request()->path() ? 'active' : ''}}" href="dashboard">
                  Mes commandes 
                </a>
              </li>
               <li>
                <a class="{{'dashboard' == request()->path() ? 'active' : ''}}" href="payment">
                  Payements
                </a>
              </li>
             
            </ul>
          </nav> --> 

          <!-- <div><img width="5%" height="5%" src="../assets/img/phone.jpg">75 10 33 78 / 02 41 74 80 / 88 62 86 12</div> -->
          <div class="copyright" id="copyright">
            &copy;
            <script>
              document.getElementById('copyright').appendChild(document.createTextNode(new Date().getFullYear()))
            </script>, Jibia'T Sarl
            <!-- <a href="https://www.invisionapp.com" target="_blank">Invision</a>. Coded by
            <a href="https://www.creative-tim.com" target="_blank">Creative Tim</a>. -->
          </div>
        </div>

      
      </footer>
      
   
  </div>
  <!--   Core JS Files   -->
 
  <script src="../assets/js/core/jquery.min.js"></script>
  <script src="../assets/js/core/popper.min.js"></script>
  <script src="../assets/js/core/bootstrap.min.js"></script>
  <script src="../assets/js/plugins/perfect-scrollbar.jquery.min.js"></script>
  <!--  Google Maps Plugin    -->

   
  
  <!-- Chart JS -->
  <script src="../assets/js/plugins/chartjs.min.js"></script>
  <!--  Notifications Plugin    -->
  <script src="../assets/js/plugins/bootstrap-notify.js"></script>
  <!-- Control Center for Now Ui Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="../assets/js/now-ui-dashboard.min.js?v=1.3.0" type="text/javascript"></script>
  <!-- Now Ui Dashboard DEMO methods, don't include it in your project! -->
  <script src="../assets/demo/demo.js"></script>
 
 <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.1/js/bootstrap-select.js"></script>

 
  <script src="../assets/manifest/js/app.js"></script>
  


 <script >

  $( document ).ready(function() {
      
     
     let deferredPrompt;
const addBtn = document.querySelector('.add-button');





window.addEventListener('beforeinstallprompt', (e) => {
  // Prevent Chrome 67 and earlier from automatically showing the prompt
  e.preventDefault();
  // Stash the event so it can be triggered later.
  deferredPrompt = e;
  // Update UI to notify the user they can add to home screen
  addBtn.style.display = 'block';

  addBtn.addEventListener('click', (e) => {
    // hide our user interface that shows our A2HS button
    addBtn.style.display = 'none';
    // Show the prompt
    deferredPrompt.prompt();
    // Wait for the user to respond to the prompt
    deferredPrompt.userChoice.then((choiceResult) => {
        if (choiceResult.outcome === 'accepted') {
          console.log('User accepted the A2HS prompt');
        } else {
          console.log('User dismissed the A2HS prompt');
        }
        deferredPrompt = null;
      });
  });
});
      
});
   
 </script>
 


  
  


  @yield("script")


</body>

</html>