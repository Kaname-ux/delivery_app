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
  

 
<link rel = " manifest " href="../assets/manifest/livreur.json">

   <!-- ios support -->
    <link rel="apple-touch-icon" href="../assets/manifest/img/logo.png" />
    
    <meta name="apple-mobile-web-app-status-bar" content="#db4938" />



</head>

<body  class="">

 
    <div class="main-panel" id="main-panel">

     
      <!-- Navbar -->
     <div class="fixed-top" >
      <nav class="navbar navbar-expand-md navbar-dark bg-dark " >
           
      <ul class="nav nav-tabs">

    <li class="nav-item active"><a style="" data-toggle="tab" class="nav-link" href="#home">livraisons({{$commands->count()}})</a></li>
    <li  class="nav-item"><a style="" data-toggle="tab" class="nav-link" href="#menu1">Payment({{$real_payments->count('client_id')}})</a></li>
    <li class="nav-item"><a style="" data-toggle="tab" class="nav-link" href="#menu2">Retours</a></li>
    
  </ul>


     <button  class="navbar-toggler " type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon" ></span>
                </button>


                   
               
                
                <div class="collapse navbar-collapse bg-dark" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                   

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto bg-dark">
                        <!-- Authentication Links -->
                       
                      <li class="nav-item bg-dark">
                         <a class="nav-link" href="livreur-stat">
                           <i class="now-ui-icons media-2_sound-wave"></i>Mes stats 
                                    </a>

                         </li>
                       <li class="nav-item">
                         <a class="nav-link"  href="#">
                                     Mon compte
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

      
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
     

</nav>
</div>
      <div style="margin-top: 80px"  class="content">



         @yield("content")
        

      </div>
      <footer class="footer">
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

 <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
 <script src="https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js"></script>
 <script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.print.min.js"></script>
 <script src="https://cdn.datatables.net/select/1.3.0/js/dataTables.select.min.js"></script>
 <script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.flash.min.js"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
 <script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-confirmation/1.0.5/bootstrap-confirmation.min.js"></script>
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