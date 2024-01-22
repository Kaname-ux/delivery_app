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


  <div  id="geoModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div style="height:25rem; width: 100%;" class="modal-content">
      <div class="modal-header">
        <button  type="button" class="close float-left" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">  </h4>
         <button style="text-transform: bold; font-size: 15px" id="set" class="btn btn-success set" data-id="set" type="button"  >Je suis disponible ici</button>
         <button style="text-transform: bold; font-size: 15px" class="btn btn-warning set" data-id="unset" type="button"  >Je ne suis pas disponible</button>
      </div>
     
      <div style="height:20rem; width: 100%;border-style: solid; border-width: 1px;" id="map" class="modal-body">
       
    </div>

  </div>
</div>
</div>


<div  id="position" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 style="color: green" class="modal-title"><i class="fa fa-map-marker-alt"></i> Active ton GPS Pour avoir plus de Commande!</h4>
      </div>
      <div class="modal-body">

     <img style="width: 100%" src="/assets/img/locationoff.gif">
     <div style=" width: 100%;border-style: solid; border-width: 1px;" id="map" >
       
    </div>
    </div>
  <div class="modal-footer">
    <button type="button" class="close btn" data-dismiss="modal">Fermer</button>
  </div>
  </div>
</div>
</div>

<div  id="geoStatus" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div  class="modal-content">
      
     
      <div  id="geoStatusBody" class="modal-body">
       
    </div>

  </div>
</div>
</div>



 
  
  <div id="hereDiv" class="fixed-bottom">
          <p style='margin-bottom: 0; '  ></p>
            <button hidden="hidden" type='button' class=' btn btn-info btn-block'  style='text-transform: uppercase; font-weight: bold;font-size: 15px; margin-top: 0' id='here'> </button>
    </div>

 
    <div class="main-panel" id="main-panel">

     
      <!-- Navbar -->
     <div class="fixed-top" >
      <nav  class="navbar navbar-expand-md navbar-light bg-light"  >
         <div class="container" >
        <img width="70px" height="25px" src="../assets/img/Jibiatlogo.jpg">
           
      


     <button  class="navbar-toggler " type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon" ></span>
                </button>
</div>
         
                
                <div class="collapse navbar-collapse " id="navbarSupportedContent" >
                    <!-- Left Side Of Navbar -->
                   

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto " >
                        <!-- Authentication Links -->
                       
                      <li class="nav-item ">
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

 <div class="container bg-dark">
                   <ul  class="nav nav-pills bg-dark ">

    <li  ><a id="homeLink"  data-toggle="tab" class="nav-link" style="color: white" href="#home">livraisons({{$commands->count()}})</a></li>
    <li   class=""><a  data-toggle="tab" class="nav-link" style="color: white" href="#menu1">Payment({{$real_payments->count('client_id')}})</a></li>
    <li class=""><a  data-toggle="tab" class="nav-link" style="color: white" href="#menu2">Retours</a></li>
    
  </ul>
    </div>    
</div>
      <div style="margin-top: 100px; margin-bottom: 30px"  class="content">



         @yield("content")
        

      </div>
      <footer class="footer" style="margin-top: 100px">
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
  <script src="../assets/js/core/bootstrap4.min.js"></script>
 <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDsIOetOqXmUutxkLiMQBQC3H98Gfd_sEg&libraries=&v=weekly"></script>
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
  


  <script type="text/javascript">
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

 



    $(".set").click(function(){
    var state = $(this).data('id');
   x = navigator.geolocation;
   x.getCurrentPosition(success, failure, {enableHighAccuracy: true, maximumAge:10000, timeout:5000} );
   
 function success (position) {

    lat = position.coords.latitude;
    long = position.coords.longitude;
    
   
   $.ajax({
      url: 'setloc',
      type: 'post',
      data: {_token: CSRF_TOKEN,lat: lat, long:long, state:state},

       
      success: function(response){
             $('#geoModal').modal('hide');
               $("#geoStatusBody").html(response.status);
               $('#geoStatus').modal('show');
               setTimeout(function(){$('#geoStatus').modal('hide')}, 4000);
               if(state == 'set')
               {
                var settings = {
  "async": true,
  "crossDomain": true,
  "url": "https://us1.locationiq.com/v1/reverse.php?key=pk.6819f5c4d29266f17f5da25147b5b9a9&lat="+lat+"&lon="+long+"&format=json",
  "method": "GET"
}

$.ajax(settings).done(function (resp) {
  console.log(resp);
  $("#hereDiv p").html("Tu es Disponible a  <i class='fas fa-map-marker-alt'></i>"+ resp.address.suburb+ " "+resp.address.city +" Depuis "+ "<i class='fas fa-clock'></i>0mns" );
  $("#hereDiv p").attr("class", "text-white bg-success");
  $("#here").text('Redefinis ta disponibilité');
  $("#here").removeAttr('hidden');

});
               }
              else{

                

    $("#hereDiv p").html("Tu es Indisponible(Les vendeurs  ne te vois pas dans la liste)");
  $("#hereDiv p").attr("class", "text-white bg-danger");
  $("#here").text('Definis ta disponibilité');
  $("#here").removeAttr('hidden');

              }
             },

     error: function(response){
             $('#geoModal').modal('hide');
               $("#geoStatusBody").text("Une erreur s'sest produite");
               $('#geoStatus').modal('show');
               setTimeout(function(){$('#geoStatus').modal('hide')}, 4000);
             }        

            
    });
   
  }

  function failure (position) {

    
    
   $('#position').modal('show');
   
  }
 });


    
    $(document).ready(function() {



$("#homeLink").click();

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
      

    $("#app-close").click(function(){
        $("#app-div").hide();
    });


  $("#here").click(function(){
    
   map = new google.maps.Map(document.getElementById("map"), {
    center: { lat: -34.397, lng: 150.644 },
    zoom: 16,
  });
  infoWindow = new google.maps.InfoWindow();

  // Try HTML5 geolocation.
  if (navigator.geolocation) {
    x = navigator.geolocation;
   x.getCurrentPosition(success, failure);
   function success (position){
    
      
        const pos = {
          lat: position.coords.latitude,
          lng: position.coords.longitude,
        };
        infoWindow.setPosition(pos);
        infoWindow.setContent("Je suis ici actuellement.");
        infoWindow.open(map);
        map.setCenter(pos);
        $('#geoModal').modal('show');
      
      () => {
        handleLocationError(true, infoWindow, map.getCenter());
      }
}
      function failure (position) {

 $('#position').modal('show');
   
  }
    
  
} else {
    // Browser doesn't support Geolocation
     $('#geoModal').modal('show');
    handleLocationError(false, infoWindow, map.getCenter());
}
  
   
  });


  function handleLocationError(browserHasGeolocation, infoWindow, pos) {
  infoWindow.setPosition(pos);
  infoWindow.setContent(
    browserHasGeolocation
      ? "Error: La localisation a échoué."
      : "Error: Votre navigateur ne prend pas en compte la géolocalisation."
  );
  infoWindow.open(map);
}




 var id = <?php $livreur->id; ?>

 $.ajax({
      url: 'getloc',
      type: 'post',
      data: {_token: CSRF_TOKEN,id: id},

       
      success: function(response){
             // Step 1: Get user coordinates 
     if(response.lat != null && response.long != null && response.geo_time != null)        
{lat = response.lat; long = response.long; 
 
 // Step 2: Get city name 
 var settings = {
  "async": true,
  "crossDomain": true,
  "url": "https://us1.locationiq.com/v1/reverse.php?key=pk.6819f5c4d29266f17f5da25147b5b9a9&lat="+lat+"&lon="+long+"&format=json",
  "method": "GET"
}

$.ajax(settings).done(function (resp) {
  console.log(resp);
 $("#hereDiv p").html("Tu es Disponible a <i class='fas fa-map-marker-alt'></i>"+ resp.address.suburb+ " "+resp.address.city +"  Depuis "+ "<i class='fas fa-clock'></i>"+ response.duration);
  $("#hereDiv p").attr("class", "text-white bg-success");
  $("#here").text('Redefinis ta disponibilité');
  $("#here").removeAttr('hidden');
});
 
 


}else{

  
    $("#hereDiv p").html("Tu es Indisponible(Les vendeurs ne te vois pas dans la liste) ");
  $("#hereDiv p").attr("class", "text-white bg-danger");
  $("#here").text('Definis ta disponibilité');
  $("#here").removeAttr('hidden');

 } 
             },

     error: function(response){
             $('#geoModal').modal('hide');
               $("#geoStatusBody").text("Une erreur s'sest produite ");
               $('#geoStatus').modal('show');
               setTimeout(function(){$('#geoStatus').modal('hide')}, 4000);
             }        

            
    });


});
  </script>
 


  
  


  @yield("script")


</body>

</html>