<!doctype html>
<html lang="fr">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Jibiat - Mes commandes</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <meta name="viewport"
        content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, viewport-fit=cover" />
    <meta name="description" content="Finapp HTML Mobile Template">
    <meta name="keywords" content="bootstrap, mobile template, cordova, phonegap, mobile, html, responsive" />
    <link rel="apple-touch-icon" sizes="180x180" href="assets/img/apple-touch-icon.png">
    <link rel="icon" type="image/png" href="../assets/img/favicon.png" sizes="32x32">
    <link rel="shortcut icon" href="../assets/img/favicon.png">
    <link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap-switch-button@1.1.0/css/bootstrap-switch-button.min.css" rel="stylesheet">
</head>

<body>
@extends("layouts.commands_modal")
    @section("modal")

@endsection
    <!-- loader -->
    <div id="loader">
        <img src="assets/img/logo-icon.png" alt="icon" class="loading-icon">
    </div>
    <!-- * loader -->

    <!-- App Header -->
    <div class="appHeader">
        <div class="left">


            <form  autocomplete="off"  action='dashboard?bydate' >
             @csrf
             <div  class="form-group ">
                                         
                <input style="display: none;" value='{{$day}}'    class="form-control "  name="route_day">
                <button class="btn btn-text-primary headerButton goBack" type="submit"  ><ion-icon name="chevron-back-outline"></ion-icon></button>

            </div>
                </form>
            
        </div>
        <div class="pageTitle">
            Mes commandes
        </div>
        <div class="right">
            <a href="#" class="headerButton" data-toggle="modal" data-target="#depositActionSheet">
                <ion-icon name="add-outline"></ion-icon>
            </a>
        </div>
    </div>
    <!-- * App Header -->


    <!-- Add Card Action Sheet -->
    
    <!-- * Add Card Action Sheet -->

    <!-- App Capsule -->
    <div id="appCapsule">


             <div class="section  pt-1">
            <div class="wallet-card">
                <!-- Balance -->
                <div class="balance">
                    <div class="left">
                        <span class="title">Total commands @if($day != "Aujourd'hui")
                                         {{date_create($day)->format('d-m-Y')}}
                                        @else
                                        {{$day}}
                                        @endif
                        </span>
                        <h5 class="total"> {{$total}}({{$all_commands->count()}}) </h5>
                    </div>
                    
                </div>
                
                <!-- * Balance -->
                <!-- Wallet Footer -->
                <div class="wallet-footer">
                    <div class="item">
                        <a href="#" data-toggle="modal" data-target="#withdrawActionSheet">
                            <div class="icon-wrapper bg-primary">
                                <ion-icon name="calendar-outline"></ion-icon>
                            </div>
                            <strong>Date</strong>
                        </a>
                    </div>
                    <div class="item">
                        <a class="pay">
                            <div class="icon-wrapper badge-warning" >
                                <ion-icon name="logo-euro"></ion-icon>
                            </div>
                            <strong>Payement</strong>
                             @if($payments_by_livreurs->count()>0)<span style="color: red; font-size: 15px"> {{$payments_by_livreurs->count()}}</span>
                                @endif
                        </a>
                    </div>
                    <div class="item">
                        <a class="cmdRtrn">
                            <div class="icon-wrapper bg-danger">
                                <ion-icon name="return-down-back-outline"></ion-icon>
                            </div>
                           <strong>Retours</strong> 
                                @if($undone_by_livreurs->count()>0)<span style="color: red; font-size: 15px"> {{$undone_by_livreurs->count()}}</span>
                                @endif
                        </a>
                    </div>
                    <div class="item">
                        <a class="bulkaction" >
                            <div class="icon-wrapper bg-success">
                                <ion-icon name="list-outline"></ion-icon>
                            </div>
                            <strong>Action groupée</strong>
                        </a>
                    </div>

                </div>
                <!-- * Wallet Footer -->
            </div>
        </div>

        <div class="section mt-2">


            <!-- card block -->
            @if($commands->count()>0)
                @foreach($commands as $x=>$command)
               <div class="item">
                    <!-- card block -->

            <div class="card text-white badge-secondary mb-2">
                <div class="card-header">
              

               <div class="custom-control custom-checkbox d-inline">
                <input value="{{$command->id}}" data-livid="{{$command->livreur->id}}"
                         data-livname="{{$command->livreur->nom}}" type="checkbox" class="custom-control-input cmd_chk" id="@if($x <= 3)customCheck{{$x+4}}a @else customCheck{{$x+1}}a @endif" />
                        <label class="custom-control-label p-0" for="@if($x <= 3)customCheck{{$x+4}}a @else customCheck{{$x+1}}a @endif" name="id[]" ></label>
                    </div> 
            <strong style="font-size: 25px">{{$command->id}}</strong>


                  @if($command->etat == 'annule')
    <button class="btn btn-danger del" value="{{$command->id}}">Supprimer</button>
    @endif

         @if($command->etat == 'encours')
      @if($client->livreurs->count()>0)
      <span class="dropdown">
      
      <button  class="btn btn-primary btn-sm   dropdown-toggle " type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span  hidden="hidden" class="spinner-border spinner-border-sm spinner{{$command->id}}" role="status" aria-hidden="true"></span><span class="sr-only"></span>
      <ion-icon name="bicycle-outline"></ion-icon>Assigner 
      </button>
      <span class="dropdown-menu dropdown-menu-left" aria-labelledby="dropdownMenuButton">
      <button  class="dropdown-item showLivreur"  value="{{$command->id}}" data-livid="{{$command->livreur->id}}"
         data-livname="{{$command->livreur->nom}}">
       <i style="color: #C42A59" class="fas fa-list"></i>
       
      @if($command->livreur->id == 11)
      Choisir un livreur dans ma liste
      @else
      Choisir un autre livreur
      @endif</button>@else
      <a class="dropdown-item" href="livreur"><i class="fas fa-list">Ajouter des livreurs à votre liste</a>
      @endif
      <button class="dropdown-item nearByLivreur"  value="{{$command->id}}" ><i style="color: #0D10CD" class="fas fa-map-marker-alt"></i>Trouver un livreur à proximité</button>
      </span>
      </span>

      
      @endif



                    <span  class="dropdown float-right" >
                    
                  <button type="button" class="btn btn-link btn-icon float-right" data-toggle="dropdown">
                                    <ion-icon name="ellipsis-vertical"></ion-icon>
                                </button>

            <span class="dropdown-menu dropdown-menu-right "   aria-labelledby="dropdownMenuButton">
                 @if($command->etat == 'encours' || $command->etat == 'recupere' || $command->etat == 'en chemin')
               <form id="cancelForm{{$command->id}}" hidden class="form-inline" action="/cancel" method="POST">
                @csrf
                <input value="{{$command->id}}" type="text" name="id" hidden>
                 <input type="text" value="yes" name="cancel" hidden>
              </form>
      
             <a onclick="submitActive{{$command->id}}()" id="sbmtActivate{{$command->id}}"  href="#" class=" btn btn-light btn-block"><i style="color: red" class="fa fa-fw fa-window-close"></i> Annuler</a>

              <a class=" btn btn-light btn-block" onclick="submitReset{{$command->id}}()" id="sbmtActivate{{$command->id}}"  href="#"><i class="fa  fa-retweet"></i> Reinitiliser</a>
              <script type="text/javascript">
              function submitActive{{$command->id}}(){
              document.getElementById("cancelForm{{$command->id}}").submit();
              }
         
         
              function submitReset{{$command->id}}(){
              document.getElementById("resetForm{{$command->id}}").submit();
             }
            </script>
            <form id="resetForm{{$command->id}}" hidden class="form-inline" action="/reset" method="POST">
            @csrf
            <input value="{{$command->id}}" type="text" name="id" hidden>
            <input type="text" value="no" name="cancel" hidden>
            </form>
             @endif
             @if($command->etat == 'annule')
             <form id="activateForm{{$command->id}}" hidden class="form-inline" action="/cancel" method="POST">
             @csrf
             <input value="{{$command->id}}" type="text" name="id" hidden>
             <input type="text" value="no" name="cancel" hidden>
             </form>
             <a onclick="submitCancel{{$command->id}}()" id="sbmtCancel{{$command->id}}"  href="#" class="dropdown-item btn btn-light btn-block"><i style="color: red" class="fa  fa-power-off"></i> Activer</a>
             <script type="text/javascript">
             function submitCancel{{$command->id}}(){
             document.getElementById("activateForm{{$command->id}}").submit();
             }
         
         
            </script>
            @endif
   

           <a data-desc="{{$command->description}}" data-id="{{$command->id}}" data-date="{{$command->delivery_date->format('Y-m-d')}}" data-montant="{{$command->montant}}" data-fee="{{$command->fee_id}}" data-adrs="{{str_replace($command->fee->destination.':','',$command->adresse)}}" data-phone="{{$command->phone}}" data-observation="{{$command->observation}}"  class="edit  btn btn-light btn-block" href="#"><i class="fa fa-fw fa-edit"></i> Modifier </a>


          <a class="duplicate btn btn-light btn-block" data-desc2="{{$command->description}}" data-id2="{{$command->id}}" data-date2="{{$command->delivery_date->format('Y-m-d')}}" data-montant2="{{$command->montant}}" data-fee2="{{$command->fee_id}}" data-adrs2="{{str_replace($command->fee->destination.':','',$command->adresse)}}" data-phone2="{{$command->phone}}" data-observation2="{{$command->observation}}"   href="#"><i class="fa  fa-clone "></i> Dupliquer</a>
      
          <a  href="tel:{{$command->phone}}" class="btn btn-light btn-block"><i class="fa fa-phone"></i>Appeler client</a>
           <a  href="tel:{{$command->livreur->phone}}" class="btn btn-light btn-block"><i class="fa fa-phone"></i>Appeler livreur</a>

           <a data-toggle="modal" data-target="#billModal{{$command->id}}"  class="btn btn-light btn-block"><i class="fa fa-bill"></i>facture</a>

            <button value="{{$command->id}}"  class="btn btn-light btn-block add_fast">Ajouter aux enregitrements rapides</button>     
   
            </span>
            </span>

            <input  type="checkbox" value="{{$command->id}}" data-onstyle="primary" data-offstyle="light" class="ready" @if($command->ready != NULL) checked @endif data-onlabel="Prêt" data-offlabel="Pas prêt"  data-toggle="switchbutton"  data-size="sm">
        </div>
                <div class="card-body">
                    <h5 class="card-title">{{substr($command->description, 0, 30)}} @if(strlen($command->description)>31)... @endif</h5>
                    <p class="card-text">
                        {{ substr($command->adresse, 0, 30)}}
                        @if(strlen($command->adresse)>31)... @endif
                        {{$command->phone}}
                   </p>

                   
                            <div class="section mt-2">
                                <div  class="row">
                                    <div  class="col-4">
                                        <span class="label">montant</span>
                                         {{$command->montant}}CFA 
                                    </div>
                                    <div  class="col-4">
                                        <span class="label">{{$command->updated_at->format('H:i:s')}} 
                                            </span>
                                        <span 
                                        @if($command->etat == 'encours') 
                                        class="badge badge-danger"
                                        @endif
                                        @if($command->etat == 'recupere')
                                        class="badge badge-warning"
                                        @endif
                                        @if($command->etat == 'en chemin')
                                        class="badge badge-warning"
                                        @endif
                                        @if($command->etat == 'termine')
                                        class="badge badge-success"
                                        @elseif($command->etat == 'annule')
                                        class="badge badge-secondary"
                                        @endif
                                        >
                                        @if($command->livreur_id == 11 && $command->etat != 'annule')
                                        En attente  
                                        @else
                                        @if($command->etat != 'termine')
                                        {{$command->etat}}
                                        @else
                                        Livré 
                                        @endif
                                        
                                        @endif
                                        </span>
                                         @if($command->payment)
                                        @if($command->payment->etat == 'termine' )
                                        <span class="badge badge-success">Payé</span>
                                        @endif
                                        @endif
                                            
                                    </div>
                                    
                                    <div class="col-4">
                                        <span class="label">Livreur</span>@if($command->note->count()>0)
                                         <a style="color: orange" data-toggle="modal" 
                                         data-target="#noteViewModal" href=""> 
                                         <i class="fa fa-sticky-note" >Note</i></a>
                                         @endif<br>
                                        @if($command->livreur_id != 11)
                                          <span id="cur_liv{{$command->id}}">
                                         {{substr($command->livreur->nom, 0, 10)}}.
                                         
                                         </span>
                                          @endif 

                                          
                                    </div>
                                    
                                   
                                </div>
                            </div>
                            
                </div>
            </div>
                    
                </div>
                @endforeach
                @endif
            <!-- * card block -->

        </div>


    </div>
    <!-- * App Capsule -->


    <!-- App Bottom Menu -->
    <div class="appBottomMenu">
        <a href="app-index.html" class="item">
            <div class="col">
                <ion-icon name="pie-chart-outline"></ion-icon>
                <strong>Overview</strong>
            </div>
        </a>
        <a href="app-pages.html" class="item">
            <div class="col">
                <ion-icon name="document-text-outline"></ion-icon>
                <strong>Pages</strong>
            </div>
        </a>
        <a href="app-components.html" class="item">
            <div class="col">
                <ion-icon name="apps-outline"></ion-icon>
                <strong>Components</strong>
            </div>
        </a>
        <a href="app-cards.html" class="item active">
            <div class="col">
                <ion-icon name="card-outline"></ion-icon>
                <strong>My Cards</strong>
            </div>
        </a>
        <a href="app-settings.html" class="item">
            <div class="col">
                <ion-icon name="settings-outline"></ion-icon>
                <strong>Settings</strong>
            </div>
        </a>
    </div>
    <!-- * App Bottom Menu -->


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
   <script src="../assets/js/commands.js"></script>
</body>

</html>