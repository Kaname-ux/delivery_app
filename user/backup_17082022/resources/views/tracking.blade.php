<html lang="fr">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Jibiat - Tracking</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <meta name="viewport"
        content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, viewport-fit=cover" />
    <meta name="description" content="Jibiat - Application pour vendeur en ligne">
    <meta name="keywords" content="tracking - commande" />
    <link rel="apple-touch-icon" sizes="180x180" href="assets/img/apple-touch-icon.png">
    <link rel="icon" type="image/png" href="../assets/img/favicon.png" sizes="32x32">
    <link rel="shortcut icon" href="../assets/img/favicon.png">
    <link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap-switch-button@1.1.0/css/bootstrap-switch-button.min.css" rel="stylesheet">

     <link rel = " manifest " href="../assets/manifest/client.json">

   <!-- ios support -->
    <link rel="apple-touch-icon" href="../assets/manifest/img/logo-icon.png" />
    
</head>
<body>


     <div class="modal fade dialogbox add-modal" id="InstalAppModal"  data-backdrop="static" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="pt-3 text-center">
                        <img src="../assets/img/logo-icon.png" alt="image" class="imaged w48  mb-1">
                    </div>
                    <div class="modal-header pt-2">
                        <h5 class="modal-title">Vous vendez en ligne?</h5>
                    </div>
                    <div class="modal-body">
                        Installez l'application Jibiat.
                          <ul>
                              <li>Enregistrez vos commandes</li>
                              <li>Trouvez des livreurs fiables</li>
                              <li>Suivez vos commandes en temps réel</li>
                              <li>Vos points sont automatiques</li>

                          </ul>
                          <a class="btn btn-success" href="https://wa.me/2250554269035">Contactez nous sur whatsapp</a>
                    </div>
                    <div class="modal-footer">
                        <div class="btn-inline">
                            <a href="#" class="btn btn-text-secondary " data-dismiss="modal">Annuler</a>
                            <a href="#" class="btn btn-text-success add-button" data-dismiss="modal">Installer</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

          <div class="card mt-2 mb-2">
                <div class="card-header">Localisation</div>

                <div class="card-body">
                   <div class="row">
                          @if ($status != "" )
      <div class="alert alert-success mb-1" role="alert">
      {{ $status }}
      </div>
      @endif
                            <h1>Si vous êtes actuellemenet sur le lieu de livraison</h1>
                            <span id="result" class="text-success"></span>
                         <button style="font-size: 15px" data-id="{{$order->id}}" class="btn btn-success setloc btn-block" onclick="setloc()">Cliquer ici pour nous envoyer votre localisation </button>

                         <form hidden method="post" action="/loc" id="locform">
                           @csrf
                           <input id="lat" type="text" name="lat">
                           <input id="long" type="text" name="long">
                           <input type="text" name="cmd_id" id="id">
                         </form>
                         </div>
                </div>
              </div>
            <div class="card">
                <div class="card-header">Suivie de votre commande {{$order->id}}</div>

                <div class="card-body">


                 
                    <p>Nature:{{$order->description}}</p>
                   

                    <p>Montant total:{{$order->montant + $order->livraison}}</p>
                    <p>Adresse de livraison:{{$order->adresse}}</p>
                    <p>Contact:{{$order->phone}}</p>
                    <p></p>
                    <p>Date de livraison:{{$order->delivery_date->format('d-m-Y')}}</p>
                    <p>Etat:

                        @if($order->etat == 'encours')
                        Commande en attente de récuperation
                        @endif
                      
                        @if($order->etat == 'recupere')
                        Commande récupérée par le livreur<br>

                        @endif


                        @if($order->etat == 'en chemin')
                        Commande en chemin
                        @endif

                        @if($order->etat == 'termine')
                        Commande Livrée
                        @endif
                         </p>
                         <p>
                             votre livreur: {{$order->livreur->nom}} {{$order->livreur->phone}}
                         </p> 



                        @if($order->note->count()>0)
                        <div>
                        <ul>
                        @foreach($order->note as $note)
                        <li>{{$note->created_at->format('d-m-Y')}} - {{$note->description}}</li>
                        @endforeach
                        </ul>
                        </div>
                        @endif
                         
                   
                   <strong> </strong>
                </div>
            </div>
        </div>
    </div>
</div>

 <script src="../assets/js/lib/jquery-3.4.1.min.js"></script>
 <script src="../assets/manifest/js/app.js"></script>
    <!-- Bootstrap-->
    <script src="../assets/js/lib/popper.min.js"></script>
    <script src="../assets/js/lib/bootstrap.min.js"></script>
    <!-- Ionicons -->
    <script src="https://unpkg.com/ionicons@5.0.0/dist/ionicons.js"></script>

<script type="text/javascript">
   var spinner = '<span  class="spinner-border  siteSpinner" role="status" aria-hidden="true"></span><span class="sr-only"></span>';
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    function setloc(){
    var cmd_id = $(".setloc").data("id");
    $(".setloc").html(spinner+"Localisation en cours");
   if (navigator.geolocation) {  
    navigator.geolocation.getCurrentPosition(function(position) {
        var lat = position.coords.latitude;
        var long = position.coords.longitude;
        var accuracy = position.coords.accuracy;

        $('#long').val(long);
        $('#lat').val(lat);
        $('#id').val(cmd_id);
        
        $('#locform').submit();
        
    },
    function error(msg) {},
    {maximumAge:10000, timeout:5000, enableHighAccuracy: true});
} else {
    alert("Une erreur s'est produite, veuillez réessayer.");
}
}


let deferredPrompt;

  const addBtn = document.querySelector('.add-button');
  window.addEventListener('beforeinstallprompt', (e) => {
    // Prevent Chrome 67 and earlier from automatically showing the prompt
    e.preventDefault();
    // Stash the event so it can be triggered later.
    deferredPrompt = e;
    // Update UI to notify the user they can add to home screen
    $("#InstalAppModal").modal("show");

    addBtn.addEventListener('click', (e) => {
      // hide our user interface that shows our A2HS button
      $('#InstalAppModal').modal("hide");
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



</script>
</body>
</html>