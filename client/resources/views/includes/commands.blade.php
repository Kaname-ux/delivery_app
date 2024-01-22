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
@include("includes.commands_modal")
    
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
            Mes commandes 
        </div>
        <div class="right">
            <a href="#" class="headerButton" data-toggle="modal" data-target="#depositActionSheet">
                <ion-icon name="add-outline"></ion-icon>
            </a>
        </div>

        <div class="extraHeader">
        <form class="search-form">
            <div class="form-group searchbox">
                <input onkeyup="search()" id="Search" type="text" class="form-control">
                <i class="input-icon">
                    <ion-icon name="search-outline"></ion-icon>
                </i>
            </div>
        </form>
    </div>
    </div>
    <!-- * App Header -->


    <!-- Add Card Action Sheet -->
    
    <!-- * Add Card Action Sheet -->

    <!-- App Capsule -->
    <div id="appCapsule" style="margin-top: 40px">


             <div class="section  pt-1" >
            <div class="wallet-card">
                <!-- Balance -->
                <div class="balance">
                    <div class="left">
                        <span class="title">Total commands 
                                  @if($state) 
            <span
        @if($state == 'encours')     
      class="badge badge-danger"
      @endif

      @if($state == 'recupere')
      class="badge badge-warning"
      @endif

      @if($state == 'en chemin')
      class="badge badge-info"
      @endif

      @if($state == 'termine')
      class="badge badge-success"
      @endif
      
      @if($state == 'annule')
      class="badge badge-secondary"
      @endif

      >
      @if($state == 'encours' && $attente)
      En attente 
      @else
      @if($state == 'termine' )
      Livrés 
      @else
      {{$state}}
      @endif
      @endif 
      

      
      @endif
      </span>

                          @if($day != "Aujourd'hui")
                                         {{date_create($day)->format('d-m-Y')}}
                                        @else
                                        {{$day}}
                                        @endif
                        </span>
                        <h5 class="total"> {{$total}} @if($state)
                            ({{$commands->count()}})
                            @else
                            ({{$all_commands->count()}}) 
                            @endif </h5>
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
        
       
            <div class="section full mb-3">
            <div class="section-title"></div>

            <div class="carousel-multiple owl-carousel owl-theme">


              <div class="item">
                    <div class="card">
                       <a id="dashboard_btn" data-state="all"> 
                        <div class="card-body " >
                            <h5 >Tout  {{$all_commands->sum('montant')}} ({{$all_commands->count()}})</h5>
                            
                        </div>
                        </a>
                    </div>
                </div>
                <div class="item">
                    <div class="card">
                       <a class="state_btn" data-state="termine"> 
                        <div class="card-body " >
                            <h5 >Terminé {{$all_commands->where('etat', 'termine')->sum('montant')}} ({{$all_commands->where('etat', 'termine')->count()}})</h5>
                            
                        </div>
                        </a>
                    </div>
                </div>
                <div class="item">
                    <div class="card">
                        <a class="enattente_btn" > 

                        <div class="card-body">
                            <h5 >En attente {{$all_commands->where('livreur_id', 11)->where('etat','=', 'encours')->sum('montant')}}({{$all_commands->where('livreur_id', 11)->where('etat','=', 'encours')->count()}})</h5>
                           
                        </div>
                    </a>
                    </div>
                </div>
                <div class="item">
                    <div class="card">
                        <a class="state_btn" data-state="encours"> 
                        <div class="card-body">
                            <h5 >Encours {{$all_commands->where('livreur_id', '!=', 11)->where('etat', 'encours')->sum('montant')}}({{$all_commands->where('livreur_id', '!=', 11)->where('etat', 'encours')->count()}})</h5>
                            
                        </div>
                    </a>
                    </div>
                </div>
                <div class="item">
                    <div class="card">
                        <a class="state_btn" data-state="recupere"> 
                        <div class="card-body">
                            <h5 >Récupéré {{$all_commands->where('etat', 'recupere')->sum('montant')}} ({{$all_commands->where('etat', 'recupere')->count()}})</h5>
                            
                        </div>
                    </a>
                    </div>
                </div>
                <div class="item">
                    <div class="card">
                        <a class="state_btn" data-state="en chemin"> 
                        <div class="card-body">
                            <h5 >En chemin  {{$all_commands->where('livreur_id', '!=', 11)->where('etat', 'en chemin')->sum('montant')}}({{$all_commands->where('livreur_id', '!=', 11)->where('etat', 'en chemin')->count()}})</h5>
                           
                        </div>
                    </a>
                    </div>
                </div>
                <div class="item">
                    <div class="card">
                        <a class="state_btn" data-state="annule"> 
                        <div class="card-body">
                            <h5 >Annulé {{$all_commands->where('etat','=', 'annule')->sum('montant')}}({{$all_commands->where('etat','=', 'annule')->count()}})</h5>
                            
                        </div>
                    </a>
                    </div>
                </div>
            </div>
        </div>
       


       <div class="section">
      @if (session('status') && session('status'))
      <div class="alert alert-success mb-1" role="alert">
      {{ session('status') }}
      </div>
      @endif
      @if(session('new_id'))
      <div class="alert alert-outline-danger mb-1" role="alert">         
      Numero de commande <strong style="font-size: 35px">{{ session('new_id') }}</strong>
       <div>
       <span class="dropdown">
      
      <button style=" font-weight: bold; text-transform: uppercase;" class="btn btn-primary  dropdown-toggle " type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
      <ion-icon name="bicycle-outline"></ion-icon>Assigner
      </button>
      <span class="dropdown-menu" aria-labelledby="dropdownMenuButton">
      <button class="dropdown-item showLivreur"  value="{{ session('new_id') }}" data-liv_id="11">
         <span  hidden="hidden" class="spinner-border spinner-border-sm spinner{{ session('new_id') }}" role="status" aria-hidden="true"></span><span class="sr-only"></span>
        @if($client->livreurs->count()>0)
      <ion-icon name="list-outline"></ion-icon>Choisir un livreur dans ma liste
      
      </button>@else
      <a class="dropdown-item" href="livreur">Ajouter des livreurs à votre liste</a>
      @endif
      <button class="dropdown-item nearByLivreur"  value="{{ session('new_id') }}" ><ion-icon name="navigate-outline"></ion-icon>Trouver un livreur à proximité</button>
      </span>
      </span>
       
       <span class="dropdown">
      <button style=" font-weight: bold; text-transform: uppercase;" class="btn btn-primary  dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <ion-icon name="calculator-outline"></ion-icon>
      Facture
      </button>
         <span class="dropdown-menu" aria-labelledby="dropdownMenuButton">
      <a class="dropdown-item text-primary"  href="sms:{{substr(preg_replace('/[^0-9]/', '', session('new_phone') ), 0, 8)}}?body=Votre commande {{ session('new_id') }} a été enregistrée. Cliquez ici pour voir le status : https://client.livreurjibiat.site/tracking/{{ session('new_id') }} {{$client->nom}}" ><ion-icon name="send-outline"></ion-icon> envoyer facture</a>
      <a class="dropdown-item text-primary" href="#" onclick="CopyBill()"><ion-icon name="copy-outline"></ion-icon>Copier facture</a>
      </span>
      </span>
       </div>

      <strong> Inscrivez ce numero au marker sur votre colis(pas besoin d'autres information). </strong>

      @if(session('add_fast') && session('add_fast') == 'ok')
        
        <button value="{{session('new_id')}}" class="btn btn-dark add_fast">
         <span  hidden="hidden" class="spinner-border spinner-border-sm addFastSpinner" role="status" aria-hidden="true"></span><span class="sr-only"></span>

            Ajouter a la liste d'enregistrement rapide
        <span  hidden="hidden" class="spinner-border spinner-border-sm addFastSpinner" role="status" aria-hidden="true"></span><span class="sr-only"></span>
        </button>
        
        @endif
      </div>


      <input hidden="hidden" type="text" value="Votre commande {{session('new_id')}} a été enregistrée. Cliquez ici pour voir le status : https://client.livreurjibiat.site/tracking/{{session('new_id')}}  - {{$client->nom}}" id="myInput">
      <script type="text/javascript">
         function CopyBill(){
         
          /* Get the text field */
         
         document.getElementById("myInput").hidden = false;
         var copyText = document.getElementById("myInput");
         
         /* Select the text field */
         
         copyText.select();
         copyText.setSelectionRange(0, 99999); /*For mobile devices*/
         
         /* Copy the text inside the text field */
         document.execCommand("copy");
         
         /* Alert the copied text */
         toastbox('toast-8', 2000);
         
         document.getElementById("myInput").hidden = true;
         }
      </script>
        
      @endif

   </div>


   @if(session('phone_check'))
     

     
      <!-- Modal content-->
      <div class="alert alert-outline-danger mb-1" role="alert">
      ATTENTION
      Vous avez déja enregistré une  commande avec ce numéro aujourd'hui<br>
      <p><strong>{{session('phone')}}</strong></p>
      <button data-desc2="{{ session('goods_type') }}" data-id2="" data-date2="{{ session('delivery_date') }}" data-montant2="{{ session('montant') }}" data-fee2="{{ session('fee_id') }}" data-adrs2="{{ session('adresse') }}" data-phone2="{{ session('phone') }}" data-observation2="{{ session('observation') }}"  data-price="{{ session('montant') }}" data-description="{{$fast->description}}"

      class="btn btn-primary btn-block duplicate">Modifier</button>
      </div>     
      <form   action="/command-fast-register" method="POST">
      @csrf
      <div hidden="hidden">
      <input type="text" name="confirm" value="yes">
      <input required value="{{ session('goods_type') }}"  name="type"  type="text" >
      <input type="text"   required  value="{{ session('delivery_date') }}" name="delivery_date"  >
      <input  value="{{ session('montant') }}"  name="montant"  type="text" >
      <input value="{{ session('fee_id') }}"  required   name="fee">
      <input value="{{ session('adresse') }}" name="adresse"  type="text"  >
      <input value="{{ session('phone') }}" required  name="phone"  type="text" >
      <input maxlength="150" value="{{ session('observation') }}"  name="observation"  type="text" >
      </div>
      <button type="submit" class="btn btn-success" >Confirmer?</button>
      <a href="/dashboard" class="btn btn-success" >Annuler</a>
      </form>

      @endif



       <!-- Monthly Bills -->
        <div class="section full mt-4">
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
        </div>
        <!-- * Monthly Bills -->
    
            <!-- card block -->
               @if($commands->count()>0)
                
               @foreach($commands->sortBy("adresse") as $x=>$command)
                 @include("includes.commandlist")
                 <?php $chk++; ?>
                 @endforeach


                  <!-- by state -->
       
                @endif
            <!-- * card block -->

        </div>
       @include("includes.footer")

    </div>
    <!-- * App Capsule -->


    
    <!-- App Bottom Menu -->
    @include("includes.bottom")
    
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
     <script src="../assets/js/commands.js"></script>
    <!-- Google map -->
    <script
   src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDsIOetOqXmUutxkLiMQBQC3H98Gfd_sEg&libraries=&v=weekly"
   defer
   ></script>
  <script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap-switch-button@1.1.0/dist/bootstrap-switch-button.min.js"></script>
  
</body>

</html>