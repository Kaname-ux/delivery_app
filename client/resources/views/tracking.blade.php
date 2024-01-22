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
   

     <!-- <link rel = " manifest " href="../assets/manifest/client.json"> -->

   <!-- ios support -->
    <link rel="apple-touch-icon" href="../assets/manifest/img/logo-icon.png" />
    
</head>
<body>
     <div class="modal fade dialogbox add-modal" id="bigModal"  data-backdrop="static" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    
                    <div class="modal-header pt-2">
                        <button class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body bigModalBody">
                        
                    </div>
                   
                      
                    
                </div>
            </div>
        </div>


        


       <div class="modal fade dialogbox loc-modal" id="LocModal"  data-backdrop="static" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="pt-3 text-center">
                        <ion-icon name="location-outline"></ion-icon>
                    </div>
                    <div class="modal-header pt-2">
                        <h5 class="modal-title">Envoyer ma localisation</h5>
                    </div>
                    <div class="modal-body">
                        <form  method="post" action="/loc" id="locform">
                           @csrf
                           <input hidden id="lat" type="text" name="lat">
                           <input hidden id="long" type="text" name="long">
                           <input hidden type="text" name="cmd_id" id="id">
                          
                         
                    </div>
                    <div class="modal-footer">
                        <div class="btn-inline">
                            <a href="#"  class="btn btn-text-secondary " data-dismiss="modal">Annuler</a>
                            <button  type="submit" class="btn btn-text-success add-button" >Confirmer</button>
                        </div>
                    </div>
                    </form>
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
                          <a class="btn btn-success" href="https://wa.me/2250153141666">Contactez nous sur whatsapp</a>
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
                <div class="card-header">
                <span id="lessView">
                    #{{$order->id}} - Total={{$order->montant-$order->remise+$order->livraison}} - {{substr($order->description,0, 50)}}
               <a href="#" id="more">Voir plus</a>
               </span>
               <span hidden id="moreView">
                   <p>Numero:{{$order->id}}</p>
                   <p>Nature:{{$order->description}}</p>
                   

                    <p>Montant total:{{$order->montant-$order->remise+ $order->livraison}}</p>
                    <p>Adresse de livraison:{{$order->adresse}}</p>
                    
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

                         @if($order->note->count() > 0)
                          Note de livraison:
                         <ul>

                         @foreach($order->note as $note)
                         
                             <li>{{$note->created_at->format("d-m-Y")}} - {{$note->description}}</li>
                         
                         @endforeach
                         </ul>
                         @endif
                   <a href="#" id="less">Voir moins</a>
               </span>
                </div>

                <div class="card-body">
                   <div class="row">
                          @if ($status != "" )
      <div class="alert alert-success mb-1" role="alert">
      {{ $status }}
      </div>
      @endif
                            <h3>Si vous êtes actuellemenet sur le lieu de livraison</h3>
                            <span id="result" class="text-success"></span>
                         <button style="font-size: 15px" data-id="{{$order->id}}" class="btn btn-success setloc btn-block" onclick="setloc()">Cliquer ici pour nous envoyer votre localisation </button>

                         
                         </div>
                </div>
                <div class="card-footer">
                     <h5>Votre livreur</h5>
                    @if($order->livreur_id != 11)
                    <?php $livreur3 = $order->livreur;  ?>
                            <img style="height:48px" @if(Storage::disk('s3')->exists($livreur3->photo))
                          src="https://livreurjibiat.s3.eu-west-3.amazonaws.com/{{$livreur3->photo}}"  @else src="assets/img/sample/brand/1.jpg" @endif alt="img" class="image-block imaged w48 big" >  {{$order->livreur->nom}} {{$order->livreur->phone}}
                @else
                Pas encore assigné 
                @endif
                </div>
              </div>

              <!-- <div class="card mt-2 mb-2">
                  <div class="card-body">
                      
                  </div>
              </div> -->
            <h3 class="listview-title mt-2">Retrouvez aussi</h3>
            <ul class="listview image-listview media">

                <li>
                <a target="_blank" href="https://wa.me/c/22553141666" class="item">
                    <div class="imageWrapper">
                        <img src="../assets/img/sample/photo/32963.jpg" alt="image" class="imaged w64">
                    </div>
                    <div class="in">
                        <div>
                            Montre+bracelet 3000f
                            <div class="text-muted">Cliquez ici pour d'autres modeles et articles</div>
                        </div>
                        <span class="badge badge-primary"></span>
                    </div>
                </a>
            </li>
            
            
            <li>
                <a target="_blank" href="https://m.facebook.com/story.php?story_fbid=pfbid0MmeVw51mnXxoTtENrFTcwDhkZgHLNifX3KcLL8WiSAPziBPEwGSgeqYWomeymRCAl&id=100064164363431&mibextid=Nif5oz" class="item">
                    <div class="imageWrapper">
                        <img src="../assets/img/sample/photo/rond.jpeg" alt="image" class="imaged w64">
                    </div>
                    <div class="in">
                        <div>
                            Produits rondeurs
                            <div class="text-muted">Affutez vos courbre en cette fin d'annee.</div>
                        </div>
                        <span class="badge badge-primary"></span>
                    </div>
                </a>
            </li>
            

             <li>
                <a target="_blank" href="https://fb.watch/h6Ro7pOkPA/" class="item">
                    <div class="imageWrapper">
                        <img src="../assets/img/sample/photo/antiflamme.jpeg" alt="image" class="imaged w64">
                    </div>
                    <div class="in">
                        <div>
                            Couverture anti flamme
                            <div class="text-muted">Protegez votre famille contre les incendies. N'attendez pas le pire pour agir.</div>
                        </div>
                        <span class="badge badge-primary"></span>
                    </div>
                </a>
            </li>

            <li>
                <a target="_blank" href="https://fb.watch/h6Ro7pOkPA/" class="item">
                    <div class="imageWrapper">
                        <img src="../assets/img/sample/photo/pochette_rouge.jpeg" alt="image" class="imaged w64">
                    </div>
                    <div class="in">
                        <div>
                            Coffret pochette et montre
                            <div class="text-muted">Ajouter du style a votre habillement</div>
                        </div>
                        <span class="badge badge-primary"></span>
                    </div>
                </a>
            </li>
 
 
            
            <li>
                <a target="_blank" href="https://m.facebook.com/story.php?story_fbid=pfbid02eLFk8deRaGukXvjQUZiGuwrpLzRro6GjQymGA9QhKWJe7GUPyBBytyPb62KDd2wBl&id=148443355734685&mibextid=Nif5oz" class="item">
                    <div class="imageWrapper">
                        <img src="../assets/img/sample/photo/anniv1.jpeg" alt="image" class="imaged w64">
                    </div>
                    <div class="in">
                        <div>
                            Kits pour anniversaire
                            <div class="text-muted">Tout ce dont vous avez besoin pour les anniversaires de vos boudchoux</div>
                        </div>
                        <span class="badge badge-primary"></span>
                    </div>
                </a>
            </li>

             <li>
                <a target="_blank" href="https://m.facebook.com/story.php?story_fbid=pfbid02GJ4TDqsHmyxAs566g4cfyppxB36znU3ecLesgYEBonhBRkuuBfWiCDd7ScJ87tJHl&id=100064164363431&mibextid=Nif5oz" class="item">
                    <div class="imageWrapper">
                        <img src="../assets/img/sample/photo/farine.jpeg" alt="image" class="imaged w64">
                    </div>
                    <div class="in">
                        <div>
                            Cereale pour bebe emelio
                            <div class="text-muted">La farine la plus riche pour bien grandir</div>
                        </div>
                        <span class="badge badge-primary"></span>
                    </div>
                </a>
            </li>

            <li>
                <a target="_blank" href="https://m.facebook.com/story.php?story_fbid=pfbid0SwY14x3CDJ69kN98datbsHMiQBAM5MRZ865WiBdDpEZ2bfWuC1k6qWrMtg6RegZsl&id=100064164363431&mibextid=Nif5oz" class="item">
                    <div class="imageWrapper">
                        <img src="../assets/img/sample/photo/sticker.jpg" alt="image" class="imaged w64">
                    </div>
                    <div class="in">
                        <div>
                            Stickers Muraux
                            <div class="text-muted">Decorations murale pour embellir votre interier</div>
                        </div>
                        <span class="badge badge-primary"></span>
                    </div>
                </a>
            </li>
            
 
            
            <li>
                <a target="_blank" href="https://m.facebook.com/story.php?story_fbid=pfbid02DxkRMyPdNBFGNPBzrcgArwvDkFVWnLuurY3vb4wvAm2MWNmGFEBSvNXDdegry2tcl&id=100064164363431&mibextid=Nif5oz" class="item">
                    <div class="imageWrapper">
                        <img src="../assets/img/sample/photo/epilateur.jpeg" alt="image" class="imaged w64">
                    </div>
                    <div class="in">
                        <div>
                            Epilateur facial
                            <div class="text-muted">Enlever les poiles du visage et retracez vos sourciles facilement et sans douleur</div>
                        </div>
                        <span class="badge badge-primary"></span>
                    </div>
                </a>
            </li>

             <li>
                <a target="_blank" href="https://m.facebook.com/story.php?story_fbid=pfbid036oy9SFeXpz9v7TvqQog2nGD9sKVfUD7vNSkQkZNZwP6ybKgaficxykQK1mBSNK25l&id=100064164363431&mibextid=Nif5oz" class="item">
                    <div class="imageWrapper">
                <img src="../assets/img/sample/photo/rangement.jpeg" alt="image" class="imaged w64">
                    </div>
                    <div class="in">
                        <div>
                            Organisateur de sac
                            <div class="text-muted">Rangez vos sacs efficacement et avec style</div>
                        </div>
                        <span class="badge badge-primary"></span>
                    </div>
                </a>
            </li>

            <li>
                <a target="_blank" href="https://fb.watch/hsjZIwEL_y/" class="item">
                    <div class="imageWrapper">
                <img src="../assets/img/sample/photo/stelilisateur_bross.jpg" alt="image" class="imaged w64">
                    </div>
                    <div class="in">
                        <div>
                            Sterilisateur de brosse
                            <div class="text-muted">Debarassez vos brosse des germes et rangez les avec style</div>
                        </div>
                        <span class="badge badge-primary"></span>
                    </div>
                </a>
            </li>
            
        </ul>

          
<!-- 
              <div class="card mb-2">
                <div class="card-header">
                    <h5>Votre livreur</h5>
                    @if($order->livreur_id != 11)
                    <?php $livreur3 = $order->livreur;  ?>
                            <img style="height:48px" @if(Storage::disk('s3')->exists($livreur3->photo))
                          src="https://livreurjibiat.s3.eu-west-3.amazonaws.com/{{$livreur3->photo}}"  @else src="assets/img/sample/brand/1.jpg" @endif alt="img" class="image-block imaged w48 big" >  {{$order->livreur->nom}} {{$order->livreur->phone}}
                @else
                Pas encore assigné 
                @endif
                </div>
                <div class="card-body">
                    <p>Numero:{{$order->id}}</p>
                   <p>Nature:{{$order->description}}</p>
                   

                    <p>Montant total:{{$order->montant + $order->livraison}}</p>
                    <p>Adresse de livraison:{{$order->adresse}}</p>
                    
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
                </div>
                
            </div> -->
             
            
            <!-- <div class="card">
                <div class="card-header">Suivie de votre commande {{$order->id}}</div>

                <div class="card-body">


                 
                    <p>Nature:{{$order->description}}</p>
                   

                    <p>Montant total:{{$order->montant + $order->livraison}}</p>
                    <p>Adresse de livraison:{{$order->adresse}}</p>
                    
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
                        



                        @if($order->note->count()>0)
                        <div>
                            <h5>Notes de livraison</h5>
                        <ul>
                        @foreach($order->note as $note)
                        <li>{{$note->created_at->format('d-m-Y')}} - {{$note->description}}</li>
                        @endforeach
                        </ul>
                        </div>
                        @endif
                         
                   
                  
                </div>
            </div> -->
            

        </div>
    </div>

    
</div>
<div class="appBottomMenu mt-2 bg-dark" style="font-size:11px; font-style: italic;">
    <img src="../assets/img/logo-icon.png" alt="image" class="imaged w24  ">Jibiat - Systeme de gestion pour e-commercant.
    <a class="flaot-right btn btn-sm btn-outline-primary" href="https://wa.me/2250153141666?text={{urlencode('Bonjour, Je souhaite avoir des informations sur le systeme de gestion pour e-commercant')}}">Info</a>
</div>
@include("includes.footer")

 <script src="../assets/js/lib/jquery-3.4.1.min.js"></script>
 <!-- <script src="../assets/manifest/js/app.js"></script> -->
    <!-- Bootstrap-->
    <script src="../assets/js/lib/popper.min.js"></script>
    <script src="../assets/js/lib/bootstrap.min.js"></script>
    <!-- Ionicons -->
   <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

<script type="text/javascript">
   var spinner = '<span  class="spinner-border  siteSpinner" role="status" aria-hidden="true"></span><span class="sr-only"></span>';
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');


    function setloc(){
    var cmd_id = $(".setloc").data("id");
    


    var options = {
    timeout: 5000,
    maximumAge: 0
  };

  function success(pos) {
    var crd = pos.coords;
       $('#long').val(crd.longitude);
        $('#lat').val(crd.latitude);
        $('#id').val(cmd_id);
        
        $('#LocModal').modal("show");

  }

  function error(err) {
    console.warn(`ERROR(${err.code}): ${err.message}`);
    alert("Une erreur s'est produite");
  }

  navigator.geolocation.getCurrentPosition(success, error, options);


}


// let deferredPrompt;

//   const addBtn = document.querySelector('.add-button');
//   window.addEventListener('beforeinstallprompt', (e) => {
//     // Prevent Chrome 67 and earlier from automatically showing the prompt
//     e.preventDefault();
//     // Stash the event so it can be triggered later.
//     deferredPrompt = e;
//     // Update UI to notify the user they can add to home screen
//     $("#InstalAppModal").modal("show");

//     addBtn.addEventListener('click', (e) => {
//       // hide our user interface that shows our A2HS button
//       $('#InstalAppModal').modal("hide");
//       // Show the prompt
//       deferredPrompt.prompt();
//       // Wait for the user to respond to the prompt
//       deferredPrompt.userChoice.then((choiceResult) => {
//           if (choiceResult.outcome === 'accepted') {
//             console.log('User accepted the A2HS prompt');
//           } else {
//             console.log('User dismissed the A2HS prompt');
//           }
//           deferredPrompt = null;
//         });
//     });
//   });


$('.big').click(function(){var src = $(this).attr('src');$('.bigModalBody').html("<img src='"+src+"' width='100%' height='100%'>");$("#bigModal").modal("show");});


$('#more').click(function(){
    $("#moreView").removeAttr("hidden");
    $("#lessView").attr("hidden", "hidden");
});

$('#less').click(function(){
    $("#lessView").removeAttr("hidden");
    $("#moreView").attr("hidden", "hidden");
});

</script>
</body>
</html>