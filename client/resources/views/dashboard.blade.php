<!doctype html>
<html lang="fr">

<head>
    <meta charset="utf-8" />

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Jibiat - tableau de bord</title>
   
    <link rel="stylesheet" href="../assets/css/style.css">
    <meta name="viewport"
        content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, viewport-fit=cover" />
    <meta name="description" content="Application pour vendeur en ligne">
    <meta name="keywords" content="Vente en ligne, facebook, livraison, livreurs" />
    <link rel="apple-touch-icon" sizes="180x180" href="assets/img/apple-touch-icon.png">
    <link rel="icon" type="image/png" href="../assets/img/favicon.png" sizes="32x32">
    <link rel="shortcut icon" href="../assets/img/favicon.png">
    <link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap-switch-button@1.1.0/css/bootstrap-switch-button.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

    <link rel = " manifest " href="../assets/manifest/client.json">

   <!-- ios support -->
    <link rel="apple-touch-icon" href="../assets/manifest/img/logo-icon.png" />
    
    
     
    
    
    <meta name="apple-mobile-web-app-status-bar" content="#db4938" />
    
    
    <style type="text/css">
        /* Tooltip */
  .livreurs + .tooltip > .tooltip-inner {
    background-color: #73AD21; 
    color: #FFFFFF; 
    border: 1px solid green; 
    padding: 15px;
    font-size: 20px;
  }
     
    </style>
    <script type="module" src="https://unpkg.com/ionicons@5.2.3/dist/ionicons/ionicons.esm.js"></script>

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
           @include("includes.commands_modal")

       
    

   
    <!-- loader -->
    <div id="loader">
        <img src="assets/img/logo-icon.png" alt="icon" class="loading-icon">
    </div>
    <!-- * loader -->

    <!-- App Header -->
   
        
        
    
    <div class="appHeader  bg-primary text-light">
      
        <div class="left">
            <a href="#" class="headerButton" data-toggle="modal" data-target="#sidebarPanel">
                <ion-icon name="menu-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">
            <a style="font-size: 20px;" class="phone btn btn-success  " href="https://wa.me/2250153141666">
         <ion-icon  name="logo-whatsapp"></ion-icon>Demander de l'aide</a> <!-- <br>
            <img src="assets/img/675x175orange.png" alt="logo" class="logo"> -->
        
        
        
        </div>


        
        <!-- <div class="right">
            <a href="app-notifications.html" class="headerButton">
                <ion-icon class="icon" name="notifications-outline"></ion-icon>
                <span class="badge badge-danger">4</span>
            </a>
            <a href="app-settings.html" class="headerButton">
                <img src="assets/img/sample/avatar/avatar1.jpg" alt="image" class="imaged w32">
                <span class="badge badge-danger">6</span>
            </a>
        </div> -->

    </div>
    
    <!-- * App Header -->


    <!-- App Capsule -->
    <div id="appCapsule">
     

      
        <!-- Wallet Card -->
        <div class="section wallet-card-section pt-1">
            <div class="wallet-card">
                <!-- Balance -->
                <div class="balance">
                    <div class="left">
                        <span class="title">Total commandes @if($day != "Aujourd'hui")
                                         {{date_create($day)->format('d-m-Y')}}
                                        @else
                                        {{$day}}
                                        @endif
                        </span>
                        <h2 class="total"> {{$total}}
                            ({{$all_commands->count()}}) 
                        </h2>
                        @if($commands->count()>0)
                        <a id="dashboard_btn" data-state="all"  class="btn btn-primary btn-sm ">Voir les commandes</a>
                        @endif
                    </div>
                    <div class="right">
                    <a href="#" class="button" data-toggle="modal" data-target="#depositActionSheet">
                            <ion-icon name="add-outline"></ion-icon>
                        </a>
                    </div>
                </div>
                <!-- * Balance -->
                <!-- Wallet Footer -->
                <div class="wallet-footer">
                    <!-- <div class="item">
                        <a href="#" data-toggle="modal" data-target="#withdrawActionSheet">
                            <div class="icon-wrapper bg-primary">
                                <ion-icon name="calendar-outline"></ion-icon>
                            </div>
                            <strong>Date</strong>
                        </a>
                    </div> -->
                    <div class="item">
                        <a href="#" class="pay">
                            <div class="icon-wrapper badge-warning" >
                                <ion-icon name="cash-outline"></ion-icon>
                            </div>
                            <strong>Payement</strong>
                             @if($payments_by_livreurs->count()>0)<span style="color: red; font-size: 15px"> {{$payments_by_livreurs->count()}}</span>
                                @endif
                        </a>
                    </div>
                    <div class="item">
                        <a href="#" class="cmdRtrn">
                            <div class="icon-wrapper bg-danger">
                                <ion-icon name="return-down-back-outline"></ion-icon>
                            </div>
                           <strong>Retours</strong> 
                                @if($undone_by_livreurs->count()>0)<span style="color: red; font-size: 15px"> {{$undone_by_livreurs->count()}}</span>
                                @endif
                        </a>
                    </div>
                    <div class="item">
                        <a href="meslivreurs" >
                            <div class="icon-wrapper bg-success">
                                <ion-icon name="bicycle-outline"></ion-icon>
                            </div>
                            <strong>Mes Livreurs</strong>
                        </a>
                    </div>

                </div>
                <!-- * Wallet Footer -->
            </div>
        </div>
        <div>
        
         </div>
        

         
  @include('includes.cmdvalidation')

  
     <div class="section full mt-4">
            <!-- <div class="section-heading padding">
                <h2 class="title">Nouvelle Commande</h2>
                
            </div> -->
            <div class="item">
                <div class="card">
                    <div class="card-body">
             
               
               
            @if($client->is_certifier == 'yes')
             <strong >Vous avez été désigné comme certificateur. Vous pouvez voir les depmandes de certification des livreurs et les valider</strong>
             <a href="certifications" class="btn btn-secondary btn-block btn-lg">

                            <ion-icon name="thumbs-up-outline"></ion-icon>
                            Voir les demandes de certifiction
                            @if($certifications->count()>0)
                            <span class="badge badge-danger">{{$certifications->count()}}</span>
                            @else
                            <span class="badge badge-primary">{{$certifications->count()}}</span>
                            @endif
                        </a>
                        @endif
              <a href="#" class="btn btn-success btn-block btn-lg" data-toggle="modal" data-target="#depositActionSheet">

                            <ion-icon name="add-outline"></ion-icon>
                            NOUVELLE COMMANDE
                        </a>
          </div>  
          </div>    
            </div>
        </div>



  <!-- Monthly Bills -->
        <!-- <div class="section full mt-4">
            <div class="section-heading padding">
                <h2 class="title">Enregitrement rapide</h2>
                <a href="#" class="link text-warning " data-toggle="modal" data-target="#addNewFast">Ajouter</a>
            </div>
            <div class="item">
                <div class="card">
                    <div class="card-body">
             @if($client->fast_commands->count()>0)
      
         
         @foreach($client->fast_commands  as $fast)

          <div id="fast{{$fast->id}}" class="btn-group">
  <button style="margin-bottom: 5px; border-top-left-radius: 20px; border-bottom-left-radius: 20px" style=" border-radius: 20px;" data-desc2="{{$fast->description}}" data-id2="" data-date2="{{date('Y-m-d')}}" data-montant2="{{$fast->price}}" data-fee2="{{$fast->fee_id}}" data-adrs2="" data-phone2="" data-observation2=""  data-price="{{$fast->price}}" data-description="{{$fast->description}}" class="btn btn-secondary btn-sm duplicate">{{$fast->description}} : {{$fast->fee->destination}} </button>
  <button style="margin-bottom: 5px; border-top-right-radius: 20px; border-bottom-right-radius: 20px" type="button" class="btn btn-secondary btn-sm dropdown-toggle" data-toggle="dropdown">
    <span class="caret"></span>
  </button>
  <ul class="dropdown-menu" role="menu">
    <li><a class="delete_fast" data-id='{{$fast->id}}' data-curfast="#fast{{$fast->id}}" href="#">Supprimer de la liste</a></li>
  </ul>
</div>


         
         @endforeach
      
      @endif   
          </div>  
          </div>    
            </div>
        </div> -->
        <!-- * Monthly Bills -->

<div class="section full mt-4">
     <div class="item">
                <div class="card">
                    <div class="card-body">
    <a href="livreurs" class="btn btn-primary btn-block btn-lg"><ion-icon name="bicycle-outline"></ion-icon> VOIR LA LISTE DES LIVREURS</a>
     <span class="text-danger mt-2">Assurez vous que votre GPS est activé!</span>
    <button class="btn btn-primary btn-lg btn-block globalNearByLivreur mb-2"><ion-icon name="location-outline"></ion-icon>Voir les livreurs à proximité</button>  

    <a href="commands" class="btn btn-primary btn-block btn-lg"><ion-icon name="cart-outline"></ion-icon> MES COMMANDES</a>

    <a href="difusions" class="btn btn-primary btn-block btn-lg"><ion-icon name="radio-outline"></ion-icon> MES DIFFUSIONS</a>
    
</div>
</div>
</div>


<div class="item">
                <div class="card">
                    <div class="card-header">
    <h2>Comment ca marche?</h2>
   </div>
<div class="card-body">
<video width="320" height="240" controls="" preload="none">
  <source src="https://livreurjibiat.s3.eu-west-3.amazonaws.com/videos/commentcamarche.mp4" type="video/mp4">
  Your browser does not support the video tag.
</video>

</div>
</div>
</div>
</div>

 <!-- Monthly Bills -->
<!-- 
        <div class="section full mt-4">
            <div class="section-heading padding">
                <h2 class="title">Commande à venir</h2>
                <span style="font-size:20px" class="link text-success ">
                    @if($upcomings->count()>0)
                {{$upcomings->sum('montant')}}F ({{$upcomings_count->sum('nbre')}})
                @endif
            </span>
                
            </div>
            
            <div class="item">
                <div class="card">
                    <div class="card-body">
             @if($upcomings->count()>0)
      
         
         @foreach($upcomings  as $x=>$upcoming)

         
            <a class="btn-group" href="commands?bydate&route_day={{$upcoming->delivery_date->format('Y-m-d')}}">
  <button style="margin-bottom: 5px; border-top-left-radius: 20px; border-bottom-left-radius: 20px" style=" border-radius: 20px;"  class="btn btn-secondary btn-sm ">{{$upcoming->delivery_date->format('d-m-Y')}}</button>
  <button style="margin-bottom: 5px; border-top-right-radius: 20px; border-bottom-right-radius: 20px" type="button" class="btn btn-success btn-sm " >
    {{$upcoming->montant}}F ({{$upcomings_count[$x]->nbre}})
  </button>
  </a>



         
         @endforeach
         @else
         Aucune commande dans les prochains jours
      
      @endif   
          </div>  
          </div>    
            </div>
        </div>
 -->        <!-- * Monthly Bills -->



   <!-- @if($commands->count()>0)
        <div class="section full mt-4">
            <div class="section-heading padding">
                <h2 class="title">Mes commandes</h2>
                <a  id="dashboard_btn" class="link text-warning">Voir tout</a>
            </div>
            <div class="carousel-single owl-carousel owl-theme shadowfix">
                 
               
                
            </div>
        </div> -->
         
        <!-- * my cards -->


        <!-- by state -->
        <!-- <div class="section full mb-3">
            <div class="section-title"></div>

            <div class="carousel-multiple owl-carousel owl-theme">
                <div class="item">
                    <div class="card">
                       <a class="state_btn" data-state="termine"> 
                        <div class="card-body " >
                            <h5 class="card-title">Terminé</h5>
                            <p class="card-text">
                                {{$all_commands->where('etat', 'termine')->sum('montant')}} ({{$all_commands->where('etat', 'termine')->count()}})
                            </p>
                        </div>
                        </a>
                    </div>
                </div>
                <div class="item">
                    <div class="card">
                        <a class="enattente_btn" > 

                        <div class="card-body">
                            <h5 class="card-title">En attente</h5>
                            <p class="card-text">
                                {{$all_commands->where('livreur_id', 11)->where('etat','=', 'encours')->sum('montant')}}({{$all_commands->where('livreur_id', 11)->where('etat','=', 'encours')->count()}})
                            </p>
                        </div>
                    </a>
                    </div>
                </div>
                <div class="item">
                    <div class="card">
                        <a class="state_btn" data-state="encours"> 
                        <div class="card-body">
                            <h5 class="card-title">Encours</h5>
                            <p class="card-text">
                                {{$all_commands->where('livreur_id', '!=', 11)->where('etat', 'encours')->sum('montant')}}({{$all_commands->where('livreur_id', '!=', 11)->where('etat', 'encours')->count()}})
                            </p>
                        </div>
                    </a>
                    </div>
                </div>
                <div class="item">
                    <div class="card">
                        <a class="state_btn" data-state="recupere"> 
                        <div class="card-body">
                            <h5 class="card-title">Récupéré</h5>
                            <p class="card-text">
                                {{$all_commands->where('etat', 'recupere')->sum('montant')}} ({{$all_commands->where('etat', 'recupere')->count()}})
                            </p>
                        </div>
                    </a>
                    </div>
                </div>
                <div class="item">
                    <div class="card">
                        <a class="state_btn" data-state="en chemin"> 
                        <div class="card-body">
                            <h5 class="card-title">En chemin</h5>
                            <p class="card-text">
                                {{$all_commands->where('livreur_id', '!=', 11)->where('etat', 'en chemin')->sum('montant')}}({{$all_commands->where('livreur_id', '!=', 11)->where('etat', 'en chemin')->count()}})
                            </p>
                        </div>
                    </a>
                    </div>
                </div>
                <div class="item">
                    <div class="card">
                        <a class="state_btn" data-state="annule"> 
                        <div class="card-body">
                            <h5 class="card-title">Annulé</h5>
                            <p class="card-text">
                                {{$all_commands->where('etat','=', 'annule')->sum('montant')}}({{$all_commands->where('etat','=', 'annule')->count()}})
                            </p>
                        </div>
                    </a>
                    </div>
                </div>
            </div>
        </div>

       @endif -->

        
        <!-- * Monthly Bills -->


        <!-- Saving Goals -->
        @if($commands->where('delivery_date', date_create($current_date))->where('client_id', $client->id)->count())
        <div class="section mt-4">
            <div class="section-heading">
                <h2 class="title">Progression livreurs</h2>
                <!-- <a href="app-savings.html" class="link">View All</a> -->
            </div>
   
            <div class="goals">
                <!-- item -->
                @foreach($livreurs as $livreur3)
              @if($livreur3->commands->where('delivery_date', date_create($current_date))->where('client_id', $client->id)->count() > 0)
                <div class="item">
                    <div class="in">
                        
                        <div>
                            <button value="{{$livreur3->id}}"data-name="{{$livreur3->nom}}"class="btn btn-danger  signal mb-1">Signaler</button>
                            <h4>
                             {{$livreur3->nom}}
                             @if($livreur3->certified_at != NULL)<span class="text-success"> <ion-icon  name="checkmark-outline"></ion-icon>Certifié</span> @endif
                             </h4>
                              @if($livreur3->signalings->count() > 0)
                               <span class="text-danger">A été Signalé {{$livreur3->signalings->count()}} fois</span><br>
                               @endif
                             {{$livreur3->commands->where('delivery_date','=', date_create($current_date))->where('etat', 'termine')->where('client_id', $client->id)->count()}} terminé sur {{$livreur3->commands->where('delivery_date', date_create($current_date))->where('client_id', $client->id)->count()}}
                            
                       
                        </div>
                        @if($livreur3->commands->where('etat', 'encours')->where('delivery_date', date_create($current_date))->where('client_id', $client->id)->count() > 0)
                        <div class="chip chip-warning ml-05 mb-05"><label class="chip-label">{{$livreur3->commands->where('etat', 'encours')->where('delivery_date', date_create($current_date))->where('client_id', $client->id)->count()}} à recuperer</label></div>
                        @endif
                        @if($livreur3->commands->where('etat', 'termine')->where('delivery_date', date_create($current_date) )->where('client_id', $client->id)->sum('montant')>0)
                           <span class="price"> {{$livreur3->commands->where('etat', 'termine')->where('delivery_date', date_create($current_date) )->where('client_id', $client->id)->sum('montant')}} </span>
                    @endif

                    </div>


                    <div class="progress">
                        <div class="progress-bar" role="progressbar" style="width:{{($livreur3->commands->where('etat', 'termine')->where('delivery_date', date_create($current_date) )->where('client_id', $client->id)->count() / $livreur3->commands->where('delivery_date', date_create($current_date))->where('client_id', $client->id)->count()) *100}}%;" aria-valuenow="{{round(($livreur3->commands->where('etat', 'termine')->where('delivery_date', date_create($current_date) )->where('client_id', $client->id)->count() / $livreur3->commands->where('delivery_date', date_create($current_date))->where('client_id', $client->id)->count()) *100)}}"
                            aria-valuemin="0" aria-valuemax="100">{{round(($livreur3->commands->where('etat', 'termine')->where('delivery_date', date_create($current_date) )->where('client_id', $client->id)->count() / $livreur3->commands->where('delivery_date', date_create($current_date))->where('client_id', $client->id)->count()) *100)}}%</div>
                      
                    </div>
                   
                    
                   <br>

                   <a class="btn btn-primary phone" href="sms:{{$livreur3->phone}}?body=Nouvelles commands assignées. "><ion-icon name="mail-outline"></ion-icon>Envoyer une alert</a>
                   <a class="btn btn-primary phone" href="tel:{{$livreur3->phone}}"><ion-icon name="call-outline"></ion-icon></a>
                    
                    <br>
                    {{$livreur3->commands->where('etat', '!=', 'termine')->where('etat', '!=', 'annule')->where('delivery_date', today())->count()}} livraisons encours actuellement. <br>
                     {{LivreurHelper::getLivreursCmds($livreur3->id)}}
                     <br>
                    Noter 
                       
                         <input id="input-{{$livreur3->id}}"  name='rate'  class='rating rating-loading' data-min='1' data-max='5' data-step='1'  data-size='xs'><button data-id="{{$livreur3->id}}" type='submit' class='btn btn-success rateLivreur2'>Envoyer Note</button>
                          
                </div>
                <!-- * item -->

            @endif
            @endforeach
            
            </div>
            
         
        </div>
        @endif

        <div class="section mt-2">
            <div class="item">
                <div class="card">
                    <div class="card-header">
    <h2>Comment faire le point?</h2>
   </div>
<div class="card-body">
<video width="320" height="240" controls="" defer="">
  <source src="https://livreurjibiat.s3.eu-west-3.amazonaws.com/videos/point.mp4" type="video/mp4">
  Your browser does not support the video tag.
</video>

</div>
</div>
</div>
            
        </div>
        <!-- * Saving Goals -->

            <!-- Transactions -->
        <div class="section mt-4 livreurs" >

            <div class="section-heading">
                <h2 class="title">Liste des livreurs</h2>
                
                <a href="livreurs" class="link text-warning">Voir plus</a>
            </div>

            <div class="section-heading">
               <button class="btn btn-warning" id="invite"><ion-icon name="share-social-outline"></ion-icon>Inviter des livreurs a s'incrire</button>
            </div>
   
            <div class="transactions">

                <!-- item -->
                <?php $z = 0;  ?>
               
               @if($livreurs->where('id', '!=', 9)->where('id', '!=', 20)->where('id', '!=', 81)->where("certified_at", "!=", null)->count()>0)
               @foreach($livreurs->where('id', '!=', 9)->where('id', '!=', 20)->where('id', '!=', 81)->where("certified_at", "!=", null)->sortByDesc('average') as $livreur) 
               @if($z == 10) @break @endif
                <span  class="item">
                    <div class="detail">
                        
                        <img @if(Storage::disk('s3')->exists($livreur->photo))
                          src="https://livreurjibiat.s3.eu-west-3.amazonaws.com/{{$livreur->photo}}"  class="image-block imaged big"
                         @else src="assets/img/sample/brand/1.jpg" alt="img"
                         class="image-block imaged"
                          @endif alt="img" width="80">
                         
                        <div>

                            <strong>{{$livreur->nom}}</strong>
                           Inscrit le: {{$livreur->created_at->format('d-m-Y')}}
                            <p>{{$livreur->city}}  {{$livreur->adresse}}</p>

                          {{$livreur->phone}}<br>

                          @if($client->livreurs->contains($livreur->id))
                 

                 <button data-id="{{$livreur->id}}"  type="button" class="removelivreur btn  btn-light btn-sm">
                 Retirer de ma liste</button> 


                 @else
                 <button data-id="{{$livreur->id}}"  type="button" class="addlivreur btn  btn-primary btn-sm">
                 Ajouter à ma liste</button> 
                 @endif 

                 <a class="btn btn-primary" href="tel:{{$livreur->phone}}"><ion-icon class="" name="call-outline"></ion-icon></a>

                          <input  disabled class="rating rating-loading" data-min="1" data-max="5" data-step="1" value="{{ $livreur->averageRating }}" data-size="xs">



                                           {{ $livreur->Ratings()->count() }} @if($livreur->Ratings()->count() <= 1) vote @else votes @endif
                                         <div>
                                           {{$livreur->commands->where('etat', '!=', 'termine')->where('etat', '!=', 'annule')->where('delivery_date', today())->count()}} livraisons encours actuellement. <br>
                     {{LivreurHelper::getLivreursCmds($livreur->id)}}
                      </div>
                        </div>


                    </div>
                     
                </span>


                <?php $z++;  ?>
                @endforeach
                @endif
              
                
                <!-- * item -->
               
            </div>
        </div>


               <!-- * Transactions -->


        <!-- News -->
        <div class="section full mt-4 mb-3">
            
        </div>
        <!-- * News -->


        @include("includes.footer")

    </div>
    <!-- * App Capsule -->


    <!-- App Bottom Menu -->
    @include("includes.bottom")
    
    <!-- * App Bottom Menu -->

    <!-- App Sidebar -->
    @include("includes.sidebar")
    <!-- * App Sidebar -->

    <!-- ///////////// Js Files ////////////////////  -->
    <!-- Jquery -->
    
   <script src="../assets/js/lib/jquery-3.5.1.min.js"></script>
   <script src="../assets/manifest/js/app.js"></script>
    <!-- Bootstrap-->
    <script src="../assets/js/lib/popper.min.js"></script>
    <script src="../assets/js/lib/bootstrap.min.js"></script>
    <!-- Ionicons -->
    <script src="../assets/js/commands.js"></script>
    <script src="../assets/js/install.js"></script>
    <!-- Owl Carousel -->
    <script src="../assets/js/owl.carousel.min.js"></script>
    <!-- Base Js File -->
    <script src="../assets/js/base.js"></script>
    
</script>
    
  <script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap-switch-button@1.1.0/dist/bootstrap-switch-button.min.js"></script>
  

<script src="../assets/js/star-rating.min.js"></script>

    <script type="text/javascript">
$(".contact").on('change keyup', function() {
    
    var phone = $(this).val();
    
        $.ajax({
              url: 'phonecheck',
              type: 'post',
              data: {_token: CSRF_TOKEN,phone: phone},
              success: function(response){

                $('.contact_div').html(response.result);
             },
      
             error: function(response){
                 
               alert("Une erreur s'est produite.");
             }
            });
     
    });



 $(function() {

    var start = moment().subtract(29, 'days');
    var end = moment();

    function cb(start, end) {
        $('#cmdrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
       
      
    }
    


    $('#cmdrange').daterangepicker({
        startDate: start,
        endDate: end,
        ranges: {
           'Aujourd\'hui': [moment(), moment()],
           'Hier': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
           ' 7 dernier Jours': [moment().subtract(6, 'days'), moment()],
           'Les 30 derniers jours': [moment().subtract(29, 'days'), moment()],
           'Ce mois': [moment().startOf('month'), moment().endOf('month')],
           'Le mois passé': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },

      autoUpdateInput: false,
    "locale": {
        "applyLabel": "Valider",
        "cancelLabel": "Annuler",
    "fromLabel": "Du",
        "toLabel": "Au",
        "customRangeLabel": "Personnalisé",
        "weekLabel": "W",
        "daysOfWeek": [
            "Di",
            "Lu",
            "Ma",
            "Me",
            "Je",
            "Ve",
            "Sa"
        ],
        "monthNames": [
            "Janvier",
            "Fevrier",
            "Mars",
            "Avril",
            "Mai",
            "Juin",
            "Juillet",
            "Aout",
            "Septembre",
            "Octobre",
            "Novembre",
            "Decembre"
        ]
    }
   
    }, cb);

    cb(start, end);


$('#cmdrange').on('apply.daterangepicker', function(ev, picker) {
  console.log(picker.startDate.format('YYYY-MM-DD'));
  console.log(picker.endDate.format('YYYY-MM-DD'));

  $(".start").val(picker.startDate.format('YYYY-MM-DD'));
    $(".end").val(picker.endDate.format('YYYY-MM-DD'));
    $(".range-form").submit();
});
});



    $(".globalNearByLivreur").click( function() {
     
     $(this).prepend(spinner);
     $(this).attr("disabled", "disabled");

     var assign_modal = $('#LivChoice');
     var assign_body = $('.LivChoiceBody');
     var top = $('.top');


     if (navigator.geolocation) {
      navigator.geolocation.getCurrentPosition(function(position) {
          var lat = position.coords.latitude;
          var long = position.coords.longitude;
          var accuracy = position.coords.accuracy;
          
          $.ajax({
         url: 'getglobalnearby',
         type: 'post',
         data: {_token: CSRF_TOKEN, lat:lat, long:long},
     
        
     
         success: function(response){
           
                  (assign_body).html(response.nearby);
                  
                  (assign_modal).modal('show');
                   $('.globalNearByLivreur').removeAttr('disabled');
                   $('.globalNearByLivreur').html('<ion-icon name="location-outline"></ion-icon>Voir les livreurs à proximité');

                },
     error: function(response){
                  $('.globalNearByLivreur').removeAttr('disabled');$('.globalNearByLivreur').html('<ion-icon name="location-outline"></ion-icon>Voir les livreurs à proximité');
                  alert("Une erruer s'est produite");

                }
               
       });
      },
      function error(msg) {$('#position').modal('show');},
      {maximumAge:10000, timeout:5000, enableHighAccuracy: true});
  } else {
      alert("Geolocation API is not supported in your browser.");
  }
  
     });  





    $(".ncmdbtn").click( function() {
   if($(".ncmd").val() == "")
   {
    $(".ncmder").html("Veuillez préciser la nature du colis");
   }else{

     $("#cmdnature").val("");
     $("#cmdlieu").val("");
     
     $("#cmddate").val("");
     $("#cmdprice").val("");
     
     
     $("#cmdphone").val("");
     $("#cmdobservation").val("");

      $("#cmddestination").val("");
      $("#livraison").val("");
      var nature = $(".ncmd").val();
      $("#cmdnature").val(nature);
    $("#depositActionSheet").modal("show");
   }
   
   });

   $("#same").change(function(){
    if($(this).is(":checked")){
        $("#ramphone").attr('disabled', 'disabled');
        $("#ramadresse").attr('disabled', 'disabled');

        $("#ramphone").removeAttr('required');
        $("#ramadresse").removeAttr('required');

    }else{
        $("#ramphone").removeAttr('disabled');
        $("#ramadresse").removeAttr('disabled');

        $("#ramphone").attr('required', 'required');
        $("#ramadresse").attr('required', 'required');
    }

});
  $(".cmd_detail").click(function(){
var description = $(this).data('desc');
     var date = $(this).data('date');
     var montant = $(this).data('montant');
     var fee = $(this).data('fee');
     var com = $(this).data('com');
     var adresse = $(this).data('adrs');
     var phone = $(this).data('phone');
     var id = $(this).data('id');
     var etat = $(this).data('etat');
     var observation = $(this).data('observation');
     var livphone = $(this).data('livphone');
     var livnom = $(this).data('livnom');
     var livraison = $(this).data('liv');
     var total = $(this).data('total');
     var notes = $(this).data('notes');
     var products = $(this).data('products');
     var created = $(this).data('created');
     var updated = $(this).data('updated');

     if(etat == 'en chemin')
    {var i = '<i   class="fas fa-walking text-warning "></i>';}
                          
if(etat == 'recupere')
    {var i = '<i   class="fas fa-dot-circle text-warning "></i>';}

if(etat == 'encours')
{var i = '<i    class="fas fa-dot-circle text-danger "></i>';}
                           
if(etat == 'annule')
 {var i = '<i  class="fas fa-window-close  "></i>';}
                          
     
     livcall = ""

     if(livnom !== "Non assigné"){
        livcall = "<br>Contact:"+livphone+" <a  href='tel:"+livphone+ "' class='btn btn-outline-primary '><ion-icon name='call-outline'></ion-icon>Appeler</a>"
     }

     $("#cmdDetailModal").modal("show");
     $(".detailBody").html("<span class='mr-3'>Commande Numero: "+id+ "</span><br>"+i+etat+" "+updated+"<br> enregistrée le "+created+ "<br><ion-icon class='text-danger mr-1' name='information-circle-outline'></ion-icon>" +observation+"<br><br><span>Adresse de livraison:<br></span><span style='font-weight: bold'> "+adresse+"<br>Contact: "+phone+" <a  href='tel:"+phone+ "' class='btn btn-outline-primary '><ion-icon name='call-outline'></ion-icon>Appeler</a></span><br><br><span>Description:</span><br><span style='font-weight: bold'>"+description+"</span><br><br><span>Livreur:</span><br><span style='font-weight: bold'>"+livnom+livcall+"</span><br><br><span style='font-weight: bold'>Total: "+total+"</span><br><span>Prix: "+montant+". Livraison: "+livraison+"</span><br><br><span>Notes</span><br><ul>"+notes+"</ul><br><br><span>Produits</span><ul>"+products+"</ul>");


});



 $(".rateLivreur").click( function() {
  
   id = $('.payeurid').val();
   rate = $('#input-1').val();
   $(this).prepend('<span  class="spinner-border  " role="status" aria-hidden="true"></span><span class="sr-only"></span>');


     $.ajax({
       url: 'ratelivreur',
       type: 'post',
       data: {_token: CSRF_TOKEN,id: id, rate: rate},
   
       success: function(response){
               $('.payeur').attr('hidden', 'hidden');
               $('.paySuccess').html("<strong class='fadein'>Votre note a été prise en compte. Merci pour votre contribution.</strong>");
              },
   error: function(response){
               
                 toastbox('toast-err', 2000);
              }
             
     });
   });



   $(".cmd_menu").click(function(){
var description = $(this).data('desc');
     var date = $(this).data('date');
     var date2 = $(this).data('date2');
     var montant = $(this).data('montant');
     var fee = $(this).data('fee');
     var com = $(this).data('com');
     var adresse = $(this).data('adrs');
     var phone = $(this).data('phone');
     var id = $(this).data('id');
     var etat = $(this).data('etat');
     var observation = $(this).data('observation');
     var livphone = $(this).data('livphone');
     var livraison = $(this).data('liv');
     var livreur = $(this).data('livreur');
     var total = $(this).data('total');
     var costumer = $(this).data("costumer");
     var canal = $(this).data("canal");


     var stats = ['encours', 'recupere', 'en chemin','livre' ,'annule'];
   stats = jQuery.grep(stats, function(value) {
      return value != etat;
    });

     let actual_stats = "<select class='form-control status'><option >Modifier statut</option>";
  for(let i=0; i < stats.length; i++){
  actual_stats += "<option value='"+stats[i]+"'> Marquer "+ stats[i] + "</option>";  
}

actual_stats += "<select>";
     $(".cmdMenumodalTitle").html("Menu commande n° "+ id );

     

    
      
     $("#shareBill").val("Commande n°"+ id + ". " +description+ ". "+adresse +". contact:"+phone +". Total:"+total+ ". Date de livraison: " + date2+" cliquez ici pour envoyer votre localisation map et pour suivre votre commande. https://client.livreurjibiat.site/tracking/"+id);
    
      $('.difuse').val("1 Commande. Destination: "+ adresse +"Tarif livraison:" +livraison); 
      $('.difuse').attr('data-phone', '{{$client->phone}}'); 
      $('.difuse').attr("data-adresse", "{{$client->city}}"+" "+'{{$client->adresse}}'); 
      $('.difuse').attr('data-cmd_id', id);
      
     
    
  $(".cmdMenumodalCalls").html("<a  href='tel:"+phone+ "' class='btn btn-outline-primary btn-block'><ion-icon name='call-outline'></ion-icon>Appeler client</a> <a  href='tel:"+livphone+ "' class='btn btn-outline-primary btn-block'><ion-icon name='call-outline'></ion-icon>Appeler livreur</a> ");

     $("#cmdnature").val(description);
     $("#cmdlieu").val(com);
     $("#cmdid").val(id);
     $("#cmddate").val(date);
     $("#cmdprice").val(montant);
     $("#cmddate").val(date);
     $("#cmdcostumer").val(costumer);

     if(canal != "none"){
        $("#cmdsource").val(canal);
     }
     
     
     $("#cmdphone").val(phone);
     $("#cmdobservation").val(observation);

      $("#cmddestination").val(fee);
     
     if(livraison !== 'no'){
      
      if(livraison != "1000" && livraison != "1500" && livraison != "2000" && livraison != "2500" && livraison != "3000")
       {
        $('.livraison').val('autre');
        $('.autre').removeAttr("hidden");
        $('.tarif').val(livraison);
       }else{$('.livraison').val(livraison);}
     }

    $('.livreur').val(livreur);

     
      $(".add_fast").attr("value", id);
       

  $("#cancel_btn").removeAttr("hidden");
      $("#cancel_btn").data("id", id);
      $("#cancel_btn").val('annule');
      $("#cancel_btn").html("<ion-icon class='text-danger'  name='close-outline'></ion-icon>Annuler");
       $("#rpt").val(id);
       $("#rpt").removeAttr("hidden");
       $("#del").attr("hidden", "hidden");
     $("#cmdResetForm").html("<input type='text' name='_token' value='"+CSRF_TOKEN+"' hidden ><input value="+id+"' type='text' name='id' hidden> <input type='text' value='no' name='cancel' hidden><button type='submit' class='btn btn-outline-primary btn-block'><ion-icon name='refresh-outline'></ion-icon>Réinitialiser</button>");
     

    if(etat == 'annule')
    {
      $("#cancel_btn").removeAttr("hidden");
      $("#del").removeAttr("hidden");
      $("#del").val(id);
      $("#cancel_btn").data("id", id);
      $("#cancel_btn").val('encours');
      $("#cancel_btn").html("<ion-icon class='text-success'  name='power-outline'></ion-icon>Activer");

     
    }

  if(etat == 'termine')
    {
      $("#rpt").attr("hidden", "hidden");
      $("#cancel_btn").attr("hidden", "hidden");
      $("#del").attr("hidden", "hidden");
    } 


    $("#cmdMenumodal").modal("show");

  });




    $(".edit").click( function() {
     var id = $("#cmdid").val();   
    $('.cmdModalTitle').html('Modifier commande n° '+id);
    $('#cmdform').attr('action', 'command-update');    
   
   
   $("#depositActionSheet").modal('show');
   
   
   });



    $(".newcmd").click( function() {

     var manager_id =$(this).data('manager');
     $("#cmdnature").val("");
     $("#cmdlieu").val("");
     
     $("#cmddate").val("");
     $("#cmdprice").val("");
     
     
     $("#cmdphone").val("");
     $("#cmdobservation").val("");

      $("#cmddestination").val("");
      $("#livraison").val("");   
      
    $('.cmdModalTitle').html('Nouvelle Commande');
    $('#cmdform').attr('action', 'command-fast-register');    
   if(manager_id != "NULL")
   {
     $.ajax({
       url: 'getmanagerfees',
       type: 'post',
       data: {_token: CSRF_TOKEN,id: manager_id},
   
       success: function(response){
               
               $('.cmddestination').html(response.managerfees);
              },
   error: function(response){
               
                 toastbox('toast-err', 2000);
              }
             
     });
   
   }
   
   $("#depositActionSheet").modal('show');
   
   
   });


$(".duplicate").click( function() {
     var description = $(this).data('desc2');
     var date = $(this).data('date2');
     var montant = $(this).data('montant2');
     var fee = $(this).data('fee2');
     var adresse = $(this).data('adrs2');
     var phone = $(this).data('phone2');
     var id = $(this).data('id2');
     var observation = $(this).data('observation2');

     
     $('.duplicateBody1').html(' <div class="form-group"> <label class="form-label">Nature du colis</label><input required value="'+description+'"  name="type" class="form-control" type="text" placeholder="Nature du colis" ></div><input value="'+id+'" hidden name="command_id"><div class="form-group"><label class="form-label">Date de livraison<input  required type="date" value="'+date+'" name="delivery_date" class="form-control" type="text" ></label>  </div> <div class="form-group"><label class="form-label">Prix(sans la livraison)</label><input type="number" value="'+montant+'"  name="montant" class="form-control" > </div>');
     
     $('.duplicateBody2').html('<div class="form-group"><label class="form-label">Précision sur l\'adresse de livraison</label><input value="'+adresse+'"  name="adresse" class="form-control" type="text" placeholder="Exemple: grand carrefour... pharmacie... rivera jardin..." ></div><div class="form-group"><label class="form-label">Contact(ex: 07000000)</label><input value="'+phone+'" required  name="phone" class="form-control" type="number" placeholder="Contact du client">  </div><div class="form-group"><label class="form-label"> Information supplementaire.</label><input maxlength="150"   name="observation" class="form-control" type="text" placeholder="Information supplementaire"></div></div>');
     
     $(".duplicateFee").val(fee);
     $('.duplicateTitle').html('Nouvelle Commande');
     
     $("#duplicateModal").modal('show');
     
     
     });



     $('.bulkaction').on('click', function(e) {


              var allVals = [];  
              $(".cmd_chk:checked").each(function() {  
                  allVals.push($(this).attr('data-id'));
              });  


              if(allVals.length <=0)  
              {  
                  $("#assignError").attr("class", "alert alert-danger");
                 $("#stateModalBody").html("Veuillez selectionner au moins une commande"); 

                 $('#stateModal').modal("show")
              } else
              {
                $('#bulkModal').modal("show");
              }
  });

  function search() {
    
    var input = document.getElementById("Search");
    var filter = input.value.toLowerCase();
    var nodes = document.getElementsByClassName('target');
    for (i = 0; i < nodes.length; i++) {
      if (nodes[i].innerText.toLowerCase().includes(filter)) {
        nodes[i].style.display = "block";
      } else {
        nodes[i].style.display = "none";
      }
    }

    $('html, body').animate({
  scrollTop: $(".commands").offset().top
});
  }


  function search2() {
    
    var input = document.getElementById("Search2");
    var filter = input.value.toLowerCase();
    var nodes = document.getElementsByClassName('target2');
    for (i = 0; i < nodes.length; i++) {
      if (nodes[i].innerText.toLowerCase().includes(filter)) {
        nodes[i].style.display = "block";
      } else {
        nodes[i].style.display = "none";
      }
    }

    
  }



  $(".bulkReset").click( function() {
   
  
          var cmd_ids = [];  
              $(".cmd_chk:checked").each(function() {  
                  cmd_ids.push($(this).attr('data-id'));
              });
        $(this).prepend(spinner);

     $.ajax({
       url: 'bulkreset',
       type: 'post',
       data: {_token: CSRF_TOKEN, cmd_ids: cmd_ids},
   
       success: function(response){
                
                $(".siteSpinner").attr('hidden', 'hidden');
                        $("#bulkModal").modal('hide');
                        $('.toasText').text('Selection Reinitialisée. Actualisation...');
                         toastbox('toast-8', 2000);

                         setTimeout(function(){
                  location.reload(true);
                }, 2000);
              },
   error: function(response){
            $(".siteSpinner").attr('hidden', 'hidden');
               $("#stateModalBody").html("Une erruer s'est produite");
                $("#stateModal").modal('show');
               
              }
             
     });
   }); 




   $(".bulkdifuse").click( function() {
   

          var cmd_ids = [];  
              $(".cmd_chk:checked").each(function() {  
                  cmd_ids.push($(this).attr('data-id'));
              });
       

        ramadress = "";
ramphone = "";

if($(".bulkram").is(":checked")){
        var ramadress = $(this).data("adresse");
        var ramphone = $(this).data("phone");

    }else{

        var errs = [];
        if($("#bulkram_adress").val() == "")
        {
            $("#bulkram_adress_er").html("Veuillez saisir l'adresse de ramassage");

            errs.push(1);
        }

        if($("#bulkram_phone").val().length != 10)
        {
            $("#bulkram_phone_er").html("Veuillez saisir un contact valide");

            errs.push(1);
        }

        if(errs.length == 0)
        {
            var ramadress = $("#bulkram_adress").val();
        var ramphone = $("#bulkram_phone").val();
        }
    }

   if(ramphone != "" && ramadress != "")
   {

     $(".bulkdifusespinner").removeAttr("hidden");
     $.ajax({
       url: 'bulkdifusion',
       type: 'post',
       data: {_token: CSRF_TOKEN, ids: cmd_ids, ramphone: ramphone, ramadress: ramadress},
   
       success: function(response){
                
                $(".bulkdifusespinner").attr('hidden', 'hidden');
                        $("#bulkModal").modal('hide');
                        $('.toasText').text('Selection Difusé');


                          for (i = 0; i < cmd_ids.length; i++)
                         {$("#idbox"+cmd_ids[i]).html('<ion-icon  class="text-info" name="radio-outline"></ion-icon>'+cmd_ids[i]);
                            $("#cmd_chk"+cmd_ids[i]).prop( "checked", false );
                           }

                         toastbox('toast-8', 2000);
                         $("#bulkdifusionModal").modal("hide");
                         $("#stateModalBody").html(response.description+response.share+ "<br><a class='btn btn-block btn-primary mt-1' href='difusions'>voir la liste des diffusion</a>");

                         $("#stateModal").modal("show");
                         
              },
   error: function(response){
           $(".bulkdifusespinner").attr('hidden', 'hidden');
               $("#stateModalBody").html("Une erruer s'est produite");
                $("#stateModal").modal('show');
               
              }
             
     });
 }
   });   
  


  $(".add_fast").click( function() {
   
  
   var cmd_id = $(this).val();
   
   $(".addFastSpinner").removeAttr('hidden');


     $.ajax({
       url: 'addfast',
       type: 'post',
       data: {_token: CSRF_TOKEN, cmd_id: cmd_id},
   
       success: function(response){
                
                $(".addFastSpinner").attr('hidden', 'hidden');
                $("#stateModalBody").html("Ajouté à la liste d'Enregistrement rapide");
                $("#stateModal").modal('show');
              },
   error: function(response){
               $("#stateModalBody").html("Une erruer s'est produite");
                $("#stateModal").modal('show');
               
              }
             
     });
   });   



  $(".status").click( function() {
   
  
   var cmd_id = $(this).val();
   
   $(".stausFastSpinner").removeAttr('hidden');


     $.ajax({
       url: 'addfast',
       type: 'post',
       data: {_token: CSRF_TOKEN, cmd_id: cmd_id},
   
       success: function(response){
                
                $(".addFastSpinner").attr('hidden', 'hidden');
                $("#stateModalBody").html("Ajouté à la liste d'Enregistrement rapide");
                $("#stateModal").modal('show');
              },
   error: function(response){
               $("#stateModalBody").html("Une erruer s'est produite");
                $("#stateModal").modal('show');
               
              }
             
     });
   });   





  shareButton = document.getElementById("shareBill");


shareButton.addEventListener('click', event => {
  if (navigator.share) {
    navigator.share({
      title: 'Facture',
      text: $("#shareBill").val(),
      
    }).then(() => {
      console.log('Thanks for sharing!');
    })
    .catch(console.error);
  } else {
    shareDialog.classList.add('is-open');
  }
});



  
  
$("#bulk_rpt_btn").click( function() {



              var cmd_ids = [];  
              $(".cmd_chk:checked").each(function() {  
                  cmd_ids.push($(this).attr('data-id'));
              });  
             

             rprt_date = $("#bulk_rpt_date").val();
             if(rprt_date == ""){
              $(".date_err").html("Veuillez choisir une date");

             }
             else
              
      {
        var assign = 0;
       var reset = 0;
       if($('#ynbassign').is(':checked')){var assign = 1;}
       if($('#ynbreset').is(':checked')){var reset = 1;}
        $.ajax({
                 url: 'bulkreport',
                 type: 'post',
                 data: {_token: CSRF_TOKEN,cmd_ids: cmd_ids, rprt_date: rprt_date, assign: assign, reset: reset},
             
                 success: function(response){
                           $(".siteSpinner").attr('hidden', 'hidden');
                        $("#bulkRptModal").modal('hide');
                        $('.toasText').text('Selection réportée');
                         toastbox('toast-8', 2000);
      
                         for (i = 0; i < cmd_ids.length; i++)
                         {$("#"+cmd_ids[i]).css("display", "none");}
      
                           
                        },
             error: function(response){
                         $(".spinnerbulk").attr('hidden', 'hidden');
                          alert("Une erruer s'est produite");
                        }
                       
               });}
     });


$("#rpt_btn").click( function() {
     
    $(this).prepend(spinner);
     var cmd_id = $(this).val();
     var assign = 0;
     var reset = 0;
       if($('#ynassign').is(':checked')){var assign = 1;}
       if($('#ynreset').is(':checked')){var reset = 1;}

     var date = $("#rpt_date").val();

     
       $.ajax({
         url: 'report',
         type: 'post',
         data: {_token: CSRF_TOKEN, cmd_id: cmd_id, rprt_date: date, assign: assign, reset: reset},
     
         success: function(response){
                  $("#ynassign" ).prop( "checked", false );
                  $("#ynreset" ).prop( "checked", false );
                  $(".siteSpinner").attr('hidden', 'hidden');
                  $("#rptModal").modal('hide');
                  $('.toasText').text('Commande reportée');
                   toastbox('toast-8', 2000);
                   $("#"+cmd_id).css("display", "none");
                },
     error: function(response){
      $(".siteSpinner").attr('hidden', 'hidden');
                 $("#stateModalBody").html("Une erruer s'est produite");
                  $("#stateModal").modal('show');
                 
                }
               
       });
     });


$(".ready").change( function() {
  var cmd_id = $(this).val();if($(this).is(":checked")){var ready = "yes";
  var text =  'Commande prête pour récuperation!';
}
     else{var ready = "no"; var text =  'Commande pas prête!';}
    
  $.ajax({
         url: 'ready',
         type: 'post',
         data: {_token: CSRF_TOKEN,cmd_id: cmd_id,ready: ready},
         success: function(response){
         $('.toasText').text(text);
                   toastbox('toast-8', 2000);
         },
         error : function(response)
         {$("#stateModalBody").html("Une erreur s'est produite");
         
        $("#stateModal").modal("show");
        setTimeout(function(){$('#stateModal').modal('hide')}, 2000);}
       });
     });

$(".bulkDifusion").click( function() {
var description = $(this).data("description");

$(".bulkdifuse").attr('data-phone', $(this).data("phone"));
$(".bulkdifuse").attr('data-adresse', $(this).data("adresse"));

});


$(".difuse").click( function() {
var description = $(this).val();


ramadress = "";
ramphone = "";
cmd_id = $(this).data("cmd_id");
if($(".ram").is(":checked")){
        var ramadress = $(this).data("adresse");
        var ramphone = $(this).data("phone");

    }else{

        var errs = [];
        if($("#ram_adress").val() == "")
        {
            $("#ram_adress_er").html("Veuillez saisir l'adresse de ramassage");

            errs.push(1);
        }

        if($("#ram_phone").val().length != 10)
        {
            $("#ram_phone_er").html("Veuillez saisir un contact valide");

            errs.push(1);
        }

        if(errs.length == 0)
        {
            var ramadress = $("#ram_adress").val();
            var ramphone = $("#ram_phone").val();
        }
    }

   if(ramphone != "" && ramadress != "")
   {
       $.ajax({
         url: 'difuse',
         type: 'post',
         data: {_token: CSRF_TOKEN,description: description,ramadress: ramadress, ramphone: ramphone, cmd_id: cmd_id},
         success: function(response){
            $("#difusionModal").modal("hide");
            $("#idbox"+cmd_id).html('<ion-icon  class="text-info" name="radio-outline"></ion-icon> '+cmd_id);
         $('.toasText').text("Commande diffusée");
                   toastbox('toast-8', 2000);

                   $("#bulkdifusionModal").modal("hide");
                         $("#stateModalBody").html(description+response.share+ "<br><a class='btn btn-block btn-primary mt-1' href='difusions'>voir la liste des diffusion</a>");

                         $("#stateModal").modal("show");
         },
         error : function(response)
         {$("#stateModalBody").html("Une erreur s'est produite");
         $("#difusionModal").modal("hide");
        $("#stateModal").modal("show");
        }
       });
     
   }
});


$(".ram").change( function() {
if($(this).is(":checked")){
        $("#ram_phone").attr('disabled', 'disabled');
        $("#ram_adress").attr('disabled', 'disabled');

        $("#ram_phone").removeAttr('required');
        $("#ram_adress").removeAttr('required');

    }else{
        $("#ram_phone").removeAttr('disabled');
        $("#ram_adress").removeAttr('disabled');

        $("#ram_phone").attr('required', 'required');
        $("#ram_adress").attr('required', 'required');
    }
});


$(".bulkram").change( function() {
if($(this).is(":checked")){
        $("#bulkram_phone").attr('disabled', 'disabled');
        $("#bulkram_adress").attr('disabled', 'disabled');

        $("#bulkram_phone").removeAttr('required');
        $("#bulkram_adress").removeAttr('required');

    }else{
        $("#bulkram_phone").removeAttr('disabled');
        $("#bulkram_adress").removeAttr('disabled');

        $("#bulkram_phone").attr('required', 'required');
        $("#bulkram_adress").attr('required', 'required');
    }
});

    </script>

</body>

</html>