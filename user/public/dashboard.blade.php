<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Jibiat - tableau de bord</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <meta name="viewport"
        content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, viewport-fit=cover" />
    <meta name="description" content="Finapp HTML Mobile Template">
    <meta name="keywords" content="bootstrap, mobile template, cordova, phonegap, mobile, html, responsive" />
    <link rel="apple-touch-icon" sizes="180x180" href="assets/img/apple-touch-icon.png">
    <link rel="icon" type="image/png" href="../assets/img/favicon.png" sizes="32x32">
    <link rel="shortcut icon" href="../assets/img/favicon.png">
</head>

<body>

    <!-- loader -->
    <div id="loader">
        <img src="assets/img/logo-icon.png" alt="icon" class="loading-icon">
    </div>
    <!-- * loader -->

    <!-- App Header -->
    <div class="appHeader bg-primary text-light">
        <div class="left">
            <a href="#" class="headerButton" data-toggle="modal" data-target="#sidebarPanel">
                <ion-icon name="menu-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">
            <img src="assets/img/logo.png" alt="logo" class="logo">
        </div>
        <div class="right">
            <a href="app-notifications.html" class="headerButton">
                <ion-icon class="icon" name="notifications-outline"></ion-icon>
                <span class="badge badge-danger">4</span>
            </a>
            <a href="app-settings.html" class="headerButton">
                <img src="assets/img/sample/avatar/avatar1.jpg" alt="image" class="imaged w32">
                <span class="badge badge-danger">6</span>
            </a>
        </div>
    </div>
    <!-- * App Header -->


    <!-- App Capsule -->
    <div id="appCapsule">
       
       <!-- State forme -->
       <form hidden id='stateForm' action="dashboard" >
         @csrf
         <input type="text"  name="route_day" value="{{$day}}">
         <input id="state" type="text" name="state"  value="">
      </form>
        <!-- Wallet Card -->
        <div class="section wallet-card-section pt-1">
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
                        <h2 class="total"> {{$total}}({{$all_commands->count()}}) FCFA</h2>
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
                            <div class="icon-wrapper bg-danger">
                                <ion-icon name="arrow-down-outline"></ion-icon>
                            </div>
                            <strong>Withdraw</strong>
                        </a>
                    </div>
                    <div class="item">
                        <a href="#" data-toggle="modal" data-target="#sendActionSheet">
                            <div class="icon-wrapper">
                                <ion-icon name="arrow-forward-outline"></ion-icon>
                            </div>
                            <strong>Send</strong>
                        </a>
                    </div>
                    <div class="item">
                        <a href="app-cards.html">
                            <div class="icon-wrapper bg-success">
                                <ion-icon name="card-outline"></ion-icon>
                            </div>
                            <strong>Cards</strong>
                        </a>
                    </div>
                    <div class="item">
                        <a href="#" data-toggle="modal" data-target="#exchangeActionSheet">
                            <div class="icon-wrapper bg-warning">
                                <ion-icon name="swap-vertical"></ion-icon>
                            </div>
                            <strong>Exchange</strong>
                        </a>
                    </div>

                </div>
                <!-- * Wallet Footer -->
            </div>
        </div>
        <!-- Wallet Card -->
        
        <!-- Dialog with Image -->
         <div class="modal fade dialogbox" id="stateModal" data-backdrop="static" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="pt-3 text-center stateImg">
                        
                    </div>
                    
                    <div class="modal-body" id="stateModalBody">
                        
                    </div>
                   
                </div>
            </div>
        </div>
        <!-- Dialog with Image -->

        <!-- Deposit Action Sheet -->
        <div class="modal fade action-sheet" id="depositActionSheet" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Balance</h5>
                    </div>
                    <div class="modal-body">
                        <div class="action-sheet-content">
                            <form>
                                <div class="form-group basic">
                                    <div class="input-wrapper">
                                        <label class="label" for="account1">From</label>
                                        <select class="form-control custom-select" id="account1">
                                            <option value="0">Savings (*** 5019)</option>
                                            <option value="1">Investment (*** 6212)</option>
                                            <option value="2">Mortgage (*** 5021)</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group basic">
                                    <label class="label">Enter Amount</label>
                                    <div class="input-group mb-2">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="input2">$</span>
                                        </div>
                                        <input type="text" class="form-control form-control-lg" value="100">
                                    </div>
                                </div>


                                <div class="form-group basic">
                                    <button type="button" class="btn btn-primary btn-block btn-lg"
                                        data-dismiss="modal">Deposit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- * Deposit Action Sheet -->

        <!-- Withdraw Action Sheet -->
        <div class="modal fade action-sheet" id="withdrawActionSheet" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Withdraw</h5>
                    </div>
                    <div class="modal-body">
                        <div class="action-sheet-content">
                            <form>
                                <div class="form-group basic">
                                    <div class="input-wrapper">
                                        <label class="label" for="account2d">From</label>
                                        <select class="form-control custom-select" id="account2d">
                                            <option value="0">Savings (*** 5019)</option>
                                            <option value="1">Investment (*** 6212)</option>
                                            <option value="2">Mortgage (*** 5021)</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group basic">
                                    <div class="input-wrapper">
                                        <label class="label" for="text11d">To</label>
                                        <input type="email" class="form-control" id="text11d" placeholder="Enter IBAN">
                                        <i class="clear-input">
                                            <ion-icon name="close-circle"></ion-icon>
                                        </i>
                                    </div>
                                </div>

                                <div class="form-group basic">
                                    <label class="label">Enter Amount</label>
                                    <div class="input-group mb-2">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="input14d">$</span>
                                        </div>
                                        <input type="text" class="form-control form-control-lg" placeholder="0">
                                    </div>
                                </div>

                                <div class="form-group basic">
                                    <button type="button" class="btn btn-primary btn-block btn-lg"
                                        data-dismiss="modal">Send</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- * Withdraw Action Sheet -->

        <!-- Send Action Sheet -->
        <div class="modal fade action-sheet" id="sendActionSheet" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Send Money</h5>
                    </div>
                    <div class="modal-body">
                        <div class="action-sheet-content">
                            <form>
                                <div class="form-group basic">
                                    <div class="input-wrapper">
                                        <label class="label" for="account2">From</label>
                                        <select class="form-control custom-select" id="account2">
                                            <option value="0">Savings (*** 5019)</option>
                                            <option value="1">Investment (*** 6212)</option>
                                            <option value="2">Mortgage (*** 5021)</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group basic">
                                    <div class="input-wrapper">
                                        <label class="label" for="text11">To</label>
                                        <input type="email" class="form-control" id="text11"
                                            placeholder="Enter bank ID">
                                        <i class="clear-input">
                                            <ion-icon name="close-circle"></ion-icon>
                                        </i>
                                    </div>
                                </div>

                                <div class="form-group basic">
                                    <label class="label">Enter Amount</label>
                                    <div class="input-group mb-2">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="input14">$</span>
                                        </div>
                                        <input type="text" class="form-control form-control-lg" placeholder="0">
                                    </div>
                                </div>

                                <div class="form-group basic">
                                    <button type="button" class="btn btn-primary btn-block btn-lg"
                                        data-dismiss="modal">Send</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- * Send Action Sheet -->

        <!-- Exchange Action Sheet -->
        <div class="modal fade action-sheet" id="exchangeActionSheet" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Exchange</h5>
                    </div>
                    <div class="modal-body">
                        <div class="action-sheet-content">
                            <form>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group basic">
                                            <div class="input-wrapper">
                                                <label class="label" for="currency1">From</label>
                                                <select class="form-control custom-select" id="currency1">
                                                    <option value="1">EUR</option>
                                                    <option value="2">USD</option>
                                                    <option value="3">AUD</option>
                                                    <option value="4">CAD</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group basic">
                                            <div class="input-wrapper">
                                                <label class="label" for="currency2">To</label>
                                                <select class="form-control custom-select" id="currency2">
                                                    <option value="1">USD</option>
                                                    <option value="1">EUR</option>
                                                    <option value="2">AUD</option>
                                                    <option value="3">CAD</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group basic">
                                    <label class="label">Enter Amount</label>
                                    <div class="input-group mb-2">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="input1">$</span>
                                        </div>
                                        <input type="text" class="form-control form-control-lg" value="100">
                                    </div>
                                </div>



                                <div class="form-group basic">
                                    <button type="button" class="btn btn-primary btn-block btn-lg"
                                        data-dismiss="modal">Deposit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- * Exchange Action Sheet -->

        <!-- Stats -->
        <div class="section">
            <div class="row mt-2">
                <div class="col-6">
                    <div class="stat-box">
                        <div class="title">Terminé</div>
                        <div class="value text-success">{{$total}} FCFA({{$all_commands->where('etat', 'termine')->count()}})</div>
                        <a  data-state="termine" href="#" class="link state_btn">detail</a>
                    </div>
                </div>
                <div class="col-6">
                    <div class="stat-box">
                        <div class="title">En Attente</div>
                        <div class="value text-danger">{{$total}}FCFA({{$all_commands->where('livreur_id', 11)->where('etat','=', 'encours')->count()}})</div>
                        <a  data-state="en attente" href="#" class="link state_btn">detail</a>
                    </div>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-6">
                    <div class="stat-box">
                        <div class="title">En chemin</div>
                        <div class="value text-warning">{{$total}}FCFA({{$all_commands->where('livreur_id', '!=', 11)->where('etat', 'en chemin')->count()}})</div>
                        <a  data-state="en attente" href="#" class="link state_btn">detail</a>
                    </div>
                </div>
                <div class="col-6">
                    <div class="stat-box">
                        <div  class="title">En cours</div>
                        <div class="value text-danger">{{$total}}FCFA({{$all_commands->where('livreur_id', '!=', 11)->where('etat', 'encours')->count()}})</div>
                        <a data-state="encours" href="#" class="link state_btn">detail</a>
                    </div>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-6">
                    <div class="stat-box">
                        <div class="title">Recupéré</div>
                        <div class="value text-success">{{$total}} FCFA({{$all_commands->where('etat', 'recupere')->count()}})</div>
                        <a  data-state="recupere" href="#" class="link state_btn">detail</a>
                    </div>
                </div>
                <div class="col-6">
                    <div class="stat-box">
                        <div class="title">Annulé</div>
                        <div class="value text-danger">{{$total}}FCFA({{$all_commands->where('etat','=', 'annule')->count()}})</div>
                        <a  data-state="annule" href="#" class="link state_btn">detail</a>
                    </div>
                </div>
            </div>
        </div>
        <!-- * Stats -->

        <!-- Transactions -->
        <!-- <div class="section mt-4">
            <div class="section-heading">
                <h2 class="title">Transactions</h2>
                <a href="app-transactions.html" class="link">View All</a>
            </div>
            <div class="transactions"> -->
                <!-- item -->
                <!-- <a href="app-transaction-detail.html" class="item">
                    <div class="detail">
                        <img src="assets/img/sample/brand/1.jpg" alt="img" class="image-block imaged w48">
                        <div>
                            <strong>Amazon</strong>
                            <p>Shopping</p>
                        </div>
                    </div>
                    <div class="right">
                        <div class="price text-danger"> - $ 150</div>
                    </div>
                </a> -->
                <!-- * item -->
                <!-- item -->
               <!--  <a href="app-transaction-detail.html" class="item">
                    <div class="detail">
                        <img src="assets/img/sample/brand/2.jpg" alt="img" class="image-block imaged w48">
                        <div>
                            <strong>Apple</strong>
                            <p>Appstore Purchase</p>
                        </div>
                    </div>
                    <div class="right">
                        <div class="price text-danger">- $ 29</div>
                    </div>
                </a> -->
                <!-- * item -->
                <!-- item -->
               <!--  <a href="app-transaction-detail.html" class="item">
                    <div class="detail">
                        <img src="assets/img/sample/avatar/avatar3.jpg" alt="img" class="image-block imaged w48">
                        <div>
                            <strong>Alex Ljung</strong>
                            <p>Transfer</p>
                        </div>
                    </div>
                    <div class="right">
                        <div class="price">+ $ 1,000</div>
                    </div>
                </a> -->
                <!-- * item -->
                <!-- item -->
               <!--  <a href="app-transaction-detail.html" class="item">
                    <div class="detail">
                        <img src="assets/img/sample/avatar/avatar4.jpg" alt="img" class="image-block imaged w48">
                        <div>
                            <strong>Beatriz Brito</strong>
                            <p>Transfer</p>
                        </div>
                    </div>
                    <div class="right">
                        <div class="price text-danger">- $ 186</div>
                    </div>
                </a> -->
                <!-- * item -->
            <!-- </div>
        </div> -->
        <!-- * Transactions -->

        <!-- my cards -->
        <div class="section full mt-4">
            <div class="section-heading padding">
                <h2 class="title">Mes commandes</h2>
                <a href="app-cards.html" class="link">Voir tout</a>
            </div>
            <div class="carousel-single owl-carousel owl-theme shadowfix">
                 
                @if($commands->count()>0)
                @foreach($commands as $x=>$command)
                <div class="item">
                    <!-- card block -->
                    <div class="card-block @if($x % 2 == 0) bg-secondary @else bg-dark @endif">
                        <div class="card-main">

                            <span class="custom-control custom-switch">
                                    Pret?
                                <input @if($command->ready != NULL) checked @else  @endif type="checkbox" class="custom-control-input ready" id="customSwitch3">
                                <label class="custom-control-label" for="customSwitch3"></label>
                            </span>
                            <div class="card-button dropdown">
                                <button type="button" class="btn btn-link btn-icon" data-toggle="dropdown">
                                    <ion-icon name="ellipsis-horizontal"></ion-icon>
                                </button>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item" href="javacript:;">
                                        <ion-icon name="pencil-outline"></ion-icon>Modifier
                                    </a>
                                    <a class="dropdown-item" href="javacript:;">
                                        <ion-icon name="close-outline"></ion-icon>Remove
                                    </a>
                                    <a class="dropdown-item" href="javacript:;">
                                        <ion-icon name="arrow-up-circle-outline"></ion-icon>Upgrade
                                    </a>
                                </div>
                            </div>
                            <div class="balance">
                                <span class="label"> 
                                    
                                   
                                <h1 class="title">{{$command->id}}</h1>

                            </div>
                            <div class="in">
                                <div class="card-number">
                                    <span class="label">Client</span>
                                    {{$command->description}}
                                    {{$command->adresse}}
                                    {{$command->phone}}
                                </div>
                                <div class="bottom">
                                    <div class="card-expiry">
                                        <span class="label">montant</span>
                                         {{$command->montant}}CFA
                                    </div>
                                    <div class="card-ccv">
                                        <span class="label">Status</span>
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
                                        {{$command->updated_at->format('H:i:s')}}
                                        @endif
                                        </span>
                                            @if($command->payment)
                                        @if($command->payment->etat == 'termine' )
                                        <span class="badge badge-success">Payé</span>
                                        @endif
                                        @endif 
                                    </div>
                                    @if($command->livreur_id != 11)
                                    <div class="card-expiry">
                                        <span class="label">Livreur</span>
                                         {{substr($command->livreur->nom, 0, 30)}}
                                         @if(strlen($command->livreur->nom>31))...@endif
                                         @if($command->note->count()>0)
                                         <a style="color: orange" data-toggle="modal" 
                                         data-target="#noteViewModal{{$command->id}}" href=""> 
                                         <i class="fa fa-sticky-note" >Note</i></a>
                                          @endif
                                    </div>
                                    @endif 
                                    @if($command->etat == 'encours')
                                    
                                    <div class="dropdown">
                                      <span  hidden="hidden" class="spinner-border spinner-border-sm spinner{{$command->id}}" role="status" aria-hidden="true"></span><span class="sr-only"></span>  
                                     <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">
                                     Assigner
                                     </button>
                                     <div class="dropdown-menu">
                                        @if($client->livreurs->count()>0)
                                        <a class="dropdown-item showLivreur" value="{{$command->id}}" data-livid="{{$command->livreur->id}}"
                                          data-livname="{{$command->livreur->nom}}" href="#">
                                        <ion-icon name="list-outline"></ion-icon>    
                                        Dans ma liste</a>
                                        @else
                                        <a class="dropdown-item" href="livreur">Ajouter des livreurs à ma liste</a>
                                        @endif
                                        <a class="dropdown-item nearByLivreur" href="#"><ion-icon name="location-outline"></ion-icon>A proximité</a>
                                        
                                    </div>
                                  </div>
                                 @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- * card block -->
                </div>
                @endforeach
                @endif
                
            </div>
        </div>
        <!-- * my cards -->

        <!-- Send Money -->
        <div class="section full mt-4">
            <div class="section-heading padding">
                <h2 class="title">Send Money</h2>
                <a href="javascript:;" class="link">Add New</a>
            </div>
            <div class="shadowfix carousel-small owl-carousel owl-theme">
                <!-- item -->
                <div class="item">
                    <a href="#">
                        <div class="user-card">
                            <img src="assets/img/sample/avatar/avatar2.jpg" alt="img" class="imaged w-48">
                            <strong>Jurrien</strong>
                        </div>
                    </a>
                </div>
                <!-- * item -->
                <!-- item -->
                <div class="item">
                    <a href="#">
                        <div class="user-card">
                            <img src="assets/img/sample/avatar/avatar3.jpg" alt="img" class="imaged w-48">
                            <strong>Elwin</strong>
                        </div>
                    </a>
                </div>
                <!-- * item -->
                <!-- item -->
                <div class="item">
                    <a href="#">
                        <div class="user-card">
                            <img src="assets/img/sample/avatar/avatar4.jpg" alt="img" class="imaged w-48">
                            <strong>Alma</strong>
                        </div>
                    </a>
                </div>
                <!-- * item -->
                <!-- item -->
                <div class="item">
                    <a href="#">
                        <div class="user-card">
                            <img src="assets/img/sample/avatar/avatar5.jpg" alt="img" class="imaged w-48">
                            <strong>Justine</strong>
                        </div>
                    </a>
                </div>
                <!-- * item -->
                <!-- item -->
                <div class="item">
                    <a href="#">
                        <div class="user-card">
                            <img src="assets/img/sample/avatar/avatar6.jpg" alt="img" class="imaged w-48">
                            <strong>Maria</strong>
                        </div>
                    </a>
                </div>
                <!-- * item -->
                <!-- item -->
                <div class="item">
                    <a href="#">
                        <div class="user-card">
                            <img src="assets/img/sample/avatar/avatar7.jpg" alt="img" class="imaged w-48">
                            <strong>Pamela</strong>
                        </div>
                    </a>
                </div>
                <!-- * item -->
                <!-- item -->
                <div class="item">
                    <a href="#">
                        <div class="user-card">
                            <img src="assets/img/sample/avatar/avatar8.jpg" alt="img" class="imaged w-48">
                            <strong>Neville</strong>
                        </div>
                    </a>
                </div>
                <!-- * item -->
                <!-- item -->
                <div class="item">
                    <a href="#">
                        <div class="user-card">
                            <img src="assets/img/sample/avatar/avatar9.jpg" alt="img" class="imaged w-48">
                            <strong>Alex</strong>
                        </div>
                    </a>
                </div>
                <!-- * item -->
                <!-- item -->
                <div class="item">
                    <a href="#">
                        <div class="user-card">
                            <img src="assets/img/sample/avatar/avatar10.jpg" alt="img" class="imaged w-48">
                            <strong>Stina</strong>
                        </div>
                    </a>
                </div>
                <!-- * item -->
            </div>
        </div>
        <!-- * Send Money -->

        <!-- Monthly Bills -->
        <div class="section full mt-4">
            <div class="section-heading padding">
                <h2 class="title">Monthly Bills</h2>
                <a href="app-bills.html" class="link">View All</a>
            </div>
            <div class="carousel-multiple owl-carousel owl-theme shadowfix">
                <!-- item -->
                <div class="item">
                    <div class="bill-box">
                        <div class="img-wrapper">
                            <img src="assets/img/sample/brand/1.jpg" alt="img" class="image-block imaged w48">
                        </div>
                        <div class="price">$ 14</div>
                        <p>Prime Monthly Subscription</p>
                        <a href="#" class="btn btn-primary btn-block btn-sm">PAY NOW</a>
                    </div>
                </div>
                <!-- * item -->
                <!-- item -->
                <div class="item">
                    <div class="bill-box">
                        <div class="img-wrapper">
                            <img src="assets/img/sample/brand/2.jpg" alt="img" class="image-block imaged w48">
                        </div>
                        <div class="price">$ 9</div>
                        <p>Music Monthly Subscription</p>
                        <a href="#" class="btn btn-primary btn-block btn-sm">PAY NOW</a>
                    </div>
                </div>
                <!-- * item -->
                <!-- item -->
                <div class="item">
                    <div class="bill-box">
                        <div class="img-wrapper">
                            <div class="iconbox bg-danger">
                                <ion-icon name="medkit-outline"></ion-icon>
                            </div>
                        </div>
                        <div class="price">$ 299</div>
                        <p>Monthly Health Insurance</p>
                        <a href="#" class="btn btn-primary btn-block btn-sm">PAY NOW</a>
                    </div>
                </div>
                <!-- * item -->
                <!-- item -->
                <div class="item">
                    <div class="bill-box">
                        <div class="img-wrapper">
                            <div class="iconbox">
                                <ion-icon name="card-outline"></ion-icon>
                            </div>
                        </div>
                        <div class="price">$ 962</div>
                        <p>Credit Card Statement
                        </p>
                        <a href="#" class="btn btn-primary btn-block btn-sm">PAY NOW</a>
                    </div>
                </div>
                <!-- * item -->
            </div>
        </div>
        <!-- * Monthly Bills -->


        <!-- Saving Goals -->
        <div class="section mt-4">
            <div class="section-heading">
                <h2 class="title">Saving Goals</h2>
                <a href="app-savings.html" class="link">View All</a>
            </div>
            <div class="goals">
                <!-- item -->
                <div class="item">
                    <div class="in">
                        <div>
                            <h4>Gaming Console</h4>
                            <p>Gaming</p>
                        </div>
                        <div class="price">$ 499</div>
                    </div>
                    <div class="progress">
                        <div class="progress-bar" role="progressbar" style="width: 85%;" aria-valuenow="85"
                            aria-valuemin="0" aria-valuemax="100">85%</div>
                    </div>
                </div>
                <!-- * item -->
                <!-- item -->
                <div class="item">
                    <div class="in">
                        <div>
                            <h4>New House</h4>
                            <p>Living</p>
                        </div>
                        <div class="price">$ 100,000</div>
                    </div>
                    <div class="progress">
                        <div class="progress-bar" role="progressbar" style="width: 55%;" aria-valuenow="55"
                            aria-valuemin="0" aria-valuemax="100">55%</div>
                    </div>
                </div>
                <!-- * item -->
                <!-- item -->
                <div class="item">
                    <div class="in">
                        <div>
                            <h4>Sport Car</h4>
                            <p>Lifestyle</p>
                        </div>
                        <div class="price">$ 42,500</div>
                    </div>
                    <div class="progress">
                        <div class="progress-bar" role="progressbar" style="width: 15%;" aria-valuenow="15"
                            aria-valuemin="0" aria-valuemax="100">15%</div>
                    </div>
                </div>
                <!-- * item -->
            </div>
        </div>
        <!-- * Saving Goals -->


        <!-- News -->
        <div class="section full mt-4 mb-3">
            <div class="section-heading padding">
                <h2 class="title">Lastest News</h2>
                <a href="app-blog.html" class="link">View All</a>
            </div>
            <div class="shadowfix carousel-multiple owl-carousel owl-theme">

                <!-- item -->
                <div class="item">
                    <a href="app-blog-post.html">
                        <div class="blog-card">
                            <img src="assets/img/sample/photo/1.jpg" alt="image" class="imaged w-100">
                            <div class="text">
                                <h4 class="title">What will be the value of bitcoin in the next...</h4>
                            </div>
                        </div>
                    </a>
                </div>
                <!-- * item -->

                <!-- item -->
                <div class="item">
                    <a href="app-blog-post.html">
                        <div class="blog-card">
                            <img src="assets/img/sample/photo/2.jpg" alt="image" class="imaged w-100">
                            <div class="text">
                                <h4 class="title">Rules you need to know in business</h4>
                            </div>
                        </div>
                    </a>
                </div>
                <!-- * item -->

                <!-- item -->
                <div class="item">
                    <a href="app-blog-post.html">
                        <div class="blog-card">
                            <img src="assets/img/sample/photo/3.jpg" alt="image" class="imaged w-100">
                            <div class="text">
                                <h4 class="title">10 easy ways to save your money</h4>
                            </div>
                        </div>
                    </a>
                </div>
                <!-- * item -->

                <!-- item -->
                <div class="item">
                    <a href="app-blog-post.html">
                        <div class="blog-card">
                            <img src="assets/img/sample/photo/4.jpg" alt="image" class="imaged w-100">
                            <div class="text">
                                <h4 class="title">Follow the financial agenda with...</h4>
                            </div>
                        </div>
                    </a>
                </div>
                <!-- * item -->

            </div>
        </div>
        <!-- * News -->


        <!-- app footer -->
        <div class="appFooter">
            <div class="footer-title">
                Copyright © Finapp 2020. All Rights Reserved.
            </div>
            Bootstrap 4 based mobile template.
        </div>
        <!-- * app footer -->

    </div>
    <!-- * App Capsule -->


    <!-- App Bottom Menu -->
    <div class="appBottomMenu">
        <a href="app-index.html" class="item active">
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
        <a href="app-cards.html" class="item">
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

    <!-- App Sidebar -->
    <div class="modal fade panelbox panelbox-left" id="sidebarPanel" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body p-0">
                    <!-- profile box -->
                    <div class="profileBox pt-2 pb-2">
                        <div class="image-wrapper">
                            <img src="assets/img/sample/avatar/avatar1.jpg" alt="image" class="imaged  w36">
                        </div>
                        <div class="in">
                            <strong>Sebastian Doe</strong>
                            <div class="text-muted">4029209</div>
                        </div>
                        <a href="#" class="btn btn-link btn-icon sidebar-close" data-dismiss="modal">
                            <ion-icon name="close-outline"></ion-icon>
                        </a>
                    </div>
                    <!-- * profile box -->
                    <!-- balance -->
                    <div class="sidebar-balance">
                        <div class="listview-title">Balance</div>
                        <div class="in">
                            <h1 class="amount">$ 2,562.50</h1>
                        </div>
                    </div>
                    <!-- * balance -->

                    <!-- action group -->
                    <div class="action-group">
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
                    </div>
                    <!-- * action group -->

                    <!-- menu -->
                    <div class="listview-title mt-1">Menu</div>
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
                    </ul>
                    <!-- * menu -->

                    <!-- others -->
                    <div class="listview-title mt-1">Others</div>
                    <ul class="listview flush transparent no-line image-listview">
                        <li>
                            <a href="app-settings.html" class="item">
                                <div class="icon-box bg-primary">
                                    <ion-icon name="settings-outline"></ion-icon>
                                </div>
                                <div class="in">
                                    Settings
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="component-messages.html" class="item">
                                <div class="icon-box bg-primary">
                                    <ion-icon name="chatbubble-outline"></ion-icon>
                                </div>
                                <div class="in">
                                    Support
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="app-login.html" class="item">
                                <div class="icon-box bg-primary">
                                    <ion-icon name="log-out-outline"></ion-icon>
                                </div>
                                <div class="in">
                                    Log out
                                </div>
                            </a>
                        </li>
                    </ul>
                    <!-- * others -->

                    <!-- send money -->
                    <div class="listview-title mt-1">Send Money</div>
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
                    </ul>
                    <!-- * send money -->

                </div>
            </div>
        </div>
    </div>
    <!-- * App Sidebar -->

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

    <script >
   $(".ready").change( function() {
   var cmd_id = $(this).data('id');
   if(this.checked)
   {var ready = "yes";}
   else  
    {var ready = "yes";}
  
$.ajax({
       url: 'ready',
       type: 'post',
       data: {_token: CSRF_TOKEN,cmd_id: cmd_id,ready: ready},
       success: function(response){
    
       }
       error : function(response)
       {$("#stateModalBody").html("Une erreur s'est produite");
    
      $("#stateModal").modal("show");
      setTimeout(function(){$('#stateModal').modal('hide')}, 2000);
    }
     });
   });


   $(".state_btn").click(function(){
    var state = $(this).data('state');
    $("#state").val() = state;
   $("#stateForm").submit();


   });


   $(".showLivreur").click( function() {
   var cmd_id = $(this).val();
   var cur_liv = $(this).data('livid');
   var cur_liv_name =  $(this).data('livname');
   var assign_modal = $('#LivChoice');
   var assign_body = $('.LivChoiceBody');
   var top = $('.top');
   
   $(".spinner"+cmd_id).removeAttr('hidden');


     $.ajax({
       url: 'assign',
       type: 'post',
       data: {_token: CSRF_TOKEN,cmd_id: cmd_id},
   
       success: function(response){
                $(".spinner"+cmd_id).attr('hidden', 'hidden');
                (assign_body).html(response.title1+ "<br>" +response.zone_output +"<br>"+response.title2+"<br>"+ response.other_output + response.assign_script);
                if(cur_liv != "11"){$('.curLiv').html("livreur actuel: "+ cur_liv_name);}
                (top).text('Assigner Commande '+cmd_id);
                (assign_modal).modal('show');
                 $('#loader').attr('hidden', 'hidden');
              },
   error: function(response){
               $(".spinner"+cmd_id).attr('hidden', 'hidden');
                alert("Une erruer s'est produite");
              }
             
     });
   });



   // Note: This example requires that you consent to location sharing when
   // prompted by your browser. If you see the error "The Geolocation service
   // failed.", it means you probably did not give permission for the browser to
   // locate you.
   let map, infoWindow;
   
   function initMap() {
      $("#mapModal").modal('show');
   map = new google.maps.Map(document.getElementById("map"), {
     center: { lat: 5.3718386, lng: -4.0033868
   },
     zoom: 16,
   });
   infoWindow = new google.maps.InfoWindow();
   
   // Try HTML5 geolocation.
   if (navigator.geolocation) {
     navigator.geolocation.getCurrentPosition(
       (position) => {
         const pos = {
           lat: position.coords.latitude,
           lng: position.coords.longitude,
         };
         infoWindow.setPosition(pos);
         infoWindow.setContent("Vous êtes ici.");
         infoWindow.open(map);
         map.setCenter(pos);
       },
       () => {
         handleLocationError(true, infoWindow, map.getCenter());
       }
     );
   } else {
     // Browser doesn't support Geolocation
     handleLocationError(false, infoWindow, map.getCenter());
   }
   }
   
   
   
   function setGeoloc(){
    x = navigator.geolocation;
    x.getCurrentPosition(success, failure);
   function success (position) {
   
     lat = position.coords.latitude;
     long = position.coords.longitude;
     
    
    $.ajax({
       url: 'setloc',
       type: 'post',
       data: {_token: CSRF_TOKEN,lat: lat, long:long},
   
        
       success: function(response){
         
                alert('Position associée à votre adresse');
              }
   
             
     });
    
   }
   
   function failure (position) {
   
     
     
    alert('Geolocation failed');
    
   }
   }


   $(".nearByLivreur").click( function() {
   var cmd_id = $(this).val();
   
   var assign_modal = $('#LivChoice');
   var assign_body = $('.LivChoiceBody');
   var top = $('.top');


   if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(function(position) {
        var lat = position.coords.latitude;
        var long = position.coords.longitude;
        var accuracy = position.coords.accuracy;
        
        $.ajax({
       url: 'getnearby',
       type: 'post',
       data: {_token: CSRF_TOKEN,cmd_id: cmd_id, lat:lat, long:long},
   
      
   
       success: function(response){
         
                (assign_body).html(response.nearby +"<br>"+response.title2+"<br>"+ response.assign_script);
                (top).text('Assigner Commande '+cmd_id+'<br>Livreurs à proximité');
                (assign_modal).modal('show');
                 $('#loader').attr('hidden', 'hidden');
              },
   error: function(response){
         
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
   

function handleLocationError(browserHasGeolocation, infoWindow, pos) {
  infoWindow.setPosition(pos);
  infoWindow.setContent(
    browserHasGeolocation
      ? "Error: La localisation a échoué."
      : "Error: Votre navigateur ne prend pas en compte la géolocalisation."
  );
  infoWindow.open(map);
}
    </script>

</body>

</html>