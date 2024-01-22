<!doctype html>
<html lang="fr">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Payements</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <meta name="viewport"
        content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, viewport-fit=cover" />
    <meta name="description" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="keywords" content="bootstrap, mobile template, cordova, phonegap, mobile, html, responsive" />
    <link rel="apple-touch-icon" sizes="180x180" href="assets/img/apple-touch-icon.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="icon" type="image/png" href="assets/img/favicon.png" sizes="32x32">
    <link rel="shortcut icon" href="assets/img/favicon.png">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

     <link rel = " manifest " href="../assets/manifest/livreur.json">

   <!-- ios support -->
    <link rel="apple-touch-icon" href="../assets/manifest/img/logo.png" />
    
    <meta name="apple-mobile-web-app-status-bar" content="#db4938" />
</head>

<body>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
 <script src="https://unpkg.com/vue@3"></script> 
<div id="app">
  
<div id="loader">
        <img src="assets/img/logo-icon.png" alt="icon" class="loading-icon">
    </div>

    
 <!-- return modal -->
       <div class="modal fade " id="payModal" tabindex="-1" role="dialog">
            <div  class="modal-dialog modal-lg" role="document">
                <div  class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title">Detail Payements </h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                       
                         
                    </div>
                 
                    <div   class="modal-body">
                        <div class="action-sheet-content " >
                          @if(session('by_livreur'))
                           
                         
                           
                          
                          
                           
                            
                           
                            
                          <h4>Par livreur</h4>

                          @foreach(session('by_livreur') as $one)
                             <div class="row mb-2 border border-primary">
                              <div class="col">{{$one->livreur->nom}}</div>
                              <div class="col"><span style="font-weight: bold; color: black;">{{$one->montant}}</span></div>
                               
                             </div>
                             @endforeach
                            
                             @php
                             $nom = session('client')->nom;
                             $delivdate = date_format(date_create($day), "d-m-Y");

                             @endphp
                            <hr>
                            <button onclick="printElement('clientpoint')" class="btn btn-light mr-2"><i class="fas fa-print"></i>Imprimer point </button>
                            <button class="btn btn-light" onclick="exportToPDF('clientpoint', 'point_{{$nom}}_{{$delivdate}}')" >Exporter en PDF</button>
                             <div id="clientpoint" style="font-size: 20px;">
                               <p class="mb-2">
                        <img src="assets/img/logo-icon.png" alt="image" class="imaged w48">
                        {{config("app.name")}} - {{config("app.phone")}} - {{config("app.adresse")}}
                    </p>
                    <hr>
                             <div  class="row mb-2" >
                              <div class="col">
                                Client: <span style="font-weight: bold; color: black;">{{session('client')->nom}}</span>
                              </div>
                             
                            </div>
                             <div  class="row mb-2" >
                              <div class="col">
                                Date: <span style="font-weight: bold; color: black;">{{date_format(date_create($day), "d-m-Y")}}</span>
                              </div>
                              <div class="col">
                                Total à versé: <span style="font-weight: bold; color: black;">{{session('unpayed_commands')->sum('montant')}}</span>
                              </div>

                              <div class="col">
                                Colis non livrés: <span style="font-weight: bold; color: black;">{{session('undelivered')->count()}}</span>
                              </div>
                            </div>
                           @if(session('unpayed_commands')->count() > 0)
                            <h4>Commandes livrées</h4>
                            @foreach(session('unpayed_commands') as $cmd)
                            <div class="border border-primary mb-2">
                             <div class="row  ">
                              <div class="col"><span style="font-weight: bold; color: black;">#{{$cmd->id}} : {{$cmd->description}}</span></div>
                              <div class="col">Montant: <span style="font-weight: bold; color: black;">{{$cmd->montant}}</span></div>
                               
                             </div>
                             

                              
                             </div>
                             @endforeach
                             @endif
                             <div class="mb-2"></div>
                             @if(session('undelivered')->count()>0)
                             <h4>Commandes non livrées</h4>
                            @foreach(session('undelivered') as $cmdu)
                            <div class="border border-primary mb-2">
                             <div class="row  ">
                              <div class="col"><span style="font-weight: bold; color: black;">#{{$cmdu->id}} : {{$cmdu->description}}</span></div>
                              <div class="col">Montant: <span style="font-weight: bold; color: black;">{{$cmdu->montant}}</span></div>
                               
                             </div>
                             <div class="row mb-2">
                               <div class="col text-warning">
                               @if($cmdu->note->count()>0)
                                  {{$cmdu->note->last()->description}}
                                  @endif
                               </div>
                             </div>
                             
                             <div class="row">
                             
                                 <div class="form-group col mb-2">
                           <label class="form-label">
                               Date livraison
                              </label>
                                <input 
                              type="date" id="date{{$cmdu->id}}" @change="updateCmd('{{$cmdu->id}}', 'date{{$cmdu->id}}', '/reportcmd' )" name="delivery_date" value="{{$day}}" class="form-control"  id="cmddate" >
     
                                   </div>
                              

                               
                                 <div class="form-group col  mb-2">
                           <label class="form-label">
                               Status
                              </label>
                              <select id="status{{$cmdu->id}}"  @change="updateCmd('{{$cmdu->id}}', 'status{{$cmdu->id}}', '/statuscmd' )" class="form-control">
                                <option  v-for="state in states" :selected="state.value == '{{$cmdu->etat}}'">@{{state.text}}</option>
                              </select>
                                
     
                                   </div>


                                     <div class="form-group col  mb-2">
                           <label class="form-label">
                               Retour
                              </label>
                              <select id="retour{{$cmdu->id}}" @change="updateCmd('{{$cmdu->id}}', 'retour{{$cmdu->id}}', '/returncmd' )" class="form-control">
                                <option   v-for="retour in retours" :value="retour.value" :selected="retour.value == '{{$cmdu->retour}}'">@{{retour.text}}</option>
                              </select>
                                
     
                                   </div>


                                       <div class="form-group col  mb-2">
                           <label class="form-label">
                               Livreur
                              </label>
                              <select id="livreur{{$cmdu->id}}" @change="updateCmd('{{$cmdu->id}}', 'livreur{{$cmdu->id}}', '/livreurcmd' )" class="form-control">
                                @foreach($livreurs as $livreur)
                                <option   value="{{$livreur->id}}" @if($livreur->id == $cmdu->livreur_id) selected @endif >{{$livreur->nom}}</option>
                                @endforeach
                              </select>
                                
     
                                   </div>
                                
                            
                               
                             </div>

                             @if($cmdu->retour == "retourne" && $cmdu->retour_by != null)
                             <div class="row">
                                <div class="col">
                                Retouné par: <span style="font-weight: bold; color: black;">{{$cmdu->retour_by}}</span>  le  <span style="font-weight: bold; color: black;">{{date_create($cmdu->retour_at)->format("d-m-Y H:i:s")}}</span>
                                </div>
                                 
                             </div>
                             @endif

                              
                             </div>
                             @endforeach
                             @endif
                          </div>
                          @endif
                        </div>
                  
                      
                    </div>
                </div>
            </div>
        </div>


<div class="modal fade action-sheet  " id="doneModal" tabindex="-1" role="dialog">
            <div  class="modal-dialog" role="document">
                <div  class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4>Detail payment</h4> 
                       <span class="donee"></span> 
                       
                    
                     
                        

                    </div>
                    <div   class="modal-body doneModalBody">
                        
                   
                
                    </div>
                    
                </div>
            </div>
        </div>

    
<div class="modal fade " id="moneyModal" tabindex="-1" role="dialog">
            <div  class="modal-dialog modal-lg" role="document">
                <div  class="modal-content">
                    <div class="modal-header">
                      <h4>Detail recette</h4> 
                      <button type="button" class="close" data-dismiss="modal">Fermer</button>
                        
                      
                    </div>
                    <div   class="modal-body">
                        @if(session('by_client'))
                           
                         
                          <h4>Par Client</h4>

                          @foreach(session('by_client') as $two)

                             <div class="row mb-2 border border-primary">
                              <div class="col">
                                @if($two->client)
                                {{$two->client->nom}}
                                @endif
                              </div>
                              <div class="col">Pour le client:<span style="font-weight: bold; color: black;">{{$two->montant}}</span></div>
                              <div class="col">Recette livraison:<span style="font-weight: bold; color: black;">{{$two->livraison}}</span></div>

                              <div class="col">Total:<span style="font-weight: bold; color: black;">{{$two->livraison+$two->montant}}</span></div>
                               
                             </div>
                             @endforeach
                             @php
                            $nom = session('livreur')->nom;
                            $delivdate = date_format(date_create($day), "d-m-Y");
                            @endphp
                            <hr>
                            <button onclick="printElement('livreurpoint')" class="btn btn-light mr-2"><i class="fas fa-print"></i>Imprimer point </button>
                            <button class="btn btn-light" onclick="exportToPDF('livreurpoint', 'point_{{$nom}}_{{$delivdate}}')" >Exporter en PDF</button>
                             <div id="livreurpoint" style="font-size: 20px;">
                              <hr>
                           <p class="mb-2">
                        <img src="assets/img/logo-icon.png" alt="image" class="imaged w48">
                        {{config("app.name")}} - {{config("app.phone")}} - {{config("app.adresse")}}
                    </p>
                    <hr>
                             <div  class="row mb-2" >
                              <div class="col">
                                Livreur: <span style="font-weight: bold; color: black;">{{session('livreur')->nom}}</span>
                              </div>
                             <div class="col">
                                Date: <span style="font-weight: bold; color: black;">{{date_format(date_create($day), "d-m-Y")}}</span>
                              </div>
                            </div>
                             
                            <div class="row mb-2">
                              <div class="col">
                                Encaisser pour les clients: <span style="font-weight: bold; color: black;">{{session('unpayed_commands')->sum('montant')}}</span>
                              </div>

                               <div class="col">
                                Recette livrason: <span style="font-weight: bold; color: black;">{{session('unpayed_commands')->sum('livraison')}}</span>
                              </div>
                              <div class="col">
                                Total: <span style="font-weight: bold; color: black;">{{session('unpayed_commands')->sum('montant')+session('unpayed_commands')->sum('livraison')}}</span>
                              </div>
                            </div>

                          
                            <h2>Commandes</h2>
                            @foreach(session('unpayed_commands') as $cmd)
                            <div class="border border-primary mb-2">
                             <div class="row  ">
                              <div class="col"><span style="font-weight: bold; color: black;">#{{$cmd->id}} : {{$cmd->description}}</span></div>
                              <div class="col">Montant: <span style="font-weight: bold; color: black;">{{$cmd->montant}}</span></div>
                              <div class="col">Livraison: <span style="font-weight: bold; color: black;">{{$cmd->livraison}}</span></div>
                               <div class="col">Total: <span style="font-weight: bold; color: black;">{{$cmd->montant+$cmd->livraison}}</span></div>
                             </div>
                             

                              
                             </div>
                             @endforeach
                           
                          </div>
                          @endif
                   
                
                    </div>
                    
                    
                </div>
            </div>
        </div>
      


      <div class="modal fade " id="receiptModal" tabindex="-1" role="dialog">
            <div  class="modal-dialog modal-lg" role="document">
                <div  class="modal-content">
                    <div class="modal-header">
                      <h4>Reçu de versement</h4> 
                      <button type="button" class="close" data-dismiss="modal">Fermer</button>
                        
                      
                    </div>
                    <div   class="modal-body">
                        @if(session('payed_commands'))
                           
                         
                           @php
                          $nom = session('singleinfo')->client->nom;
                          $delivdate = date_format(date_create($day), "d-m-Y");
                           @endphp
                            

                            <hr>
                             <button onclick="printElement('receipt')" class="btn btn-light mr-2"><i class="fas fa-print"></i>Imprimer point </button>
                            <button class="btn btn-light" onclick="exportToPDF('receipt', 'point_{{$nom}}_{{$delivdate}}')" >Exporter en PDF</button>
                             <div id="receipt" style="font-size: 20px;">
                              
                              <hr>
                           <p class="mb-2">
                        <img src="assets/img/logo-icon.png" alt="image" class="imaged w48">
                        {{config("app.name")}} - {{config("app.phone")}} - {{config("app.adresse")}}
                    </p>
                    <hr>
                    <h2>Reçu de versement</h2>
                             <div  class="row mb-2" >
                              <div class="col">
                                Client: <span style="font-weight: bold; color: black;">{{session('singleinfo')->client->nom}}</span>
                              </div>
                             <div class="col">
                                Date: <span style="font-weight: bold; color: black;">{{date_format(date_create($day), "d-m-Y")}}</span>
                              </div>
                               <div class="col">
                                Code: <span style="font-weight: bold; color: black;">{{session('singleinfo')->cashedback_key}}</span>
                              </div>
                            </div>
                             
                            <div class="row mb-2">
                              
                              <div class="col">
                                Total: <span style="font-weight: bold; color: black;">{{session('payed_commands')->sum('montant')}}</span>
                              </div>
                            </div>

                          
                            <h2>Commandes</h2>
                            @foreach(session('payed_commands') as $cmd)
                            <div class="border border-primary mb-2">
                             <div class="row  ">
                              <div class="col"><span style="font-weight: bold; color: black;">#{{$cmd->id}} : {{$cmd->description}}</span></div>
                              <div class="col">Montant: <span style="font-weight: bold; color: black;">{{$cmd->montant}}</span></div>
                              
                             </div>
                             

                              
                             </div>
                             @endforeach
                           
                          </div>
                          @endif
                   
                
                    </div>
                    
                    
                </div>
            </div>
        </div>
        


        <div class="modal fade " id="rReceiptModal" tabindex="-1" role="dialog">
            <div  class="modal-dialog modal-lg" role="document">
                <div  class="modal-content">
                    <div class="modal-header">
                      <h4>Reçu de versement</h4> 
                      <button type="button" class="close" data-dismiss="modal">Fermer</button>
                        
                      
                    </div>
                    <div   class="modal-body">
                        @if(session('payed_recettes'))
                           
                         
                         @php
                             $nom = session('singleinfo')->livreur->nom;
                             $delivdate = date_format(date_create($day), "d-m-Y");

                             @endphp
                            

                            <hr>
                            <button onclick="printElement('recettereceipt')" class="btn btn-light mr-2"><i class="fas fa-print"></i>Imprimer point </button>
                          <button class="btn btn-light" onclick="exportToPDF('recettereceipt', 'point_{{$nom}}_{{$delivdate}}')" >Exporter en PDF</button>
                             <div id="recettereceipt" style="font-size: 20px;">
                              
                              <hr>
                           <p class="mb-2">
                        <img src="assets/img/logo-icon.png" alt="image" class="imaged w48">
                        {{config("app.name")}} - {{config("app.phone")}} - {{config("app.adresse")}}
                    </p>
                    <hr>
                    <h2>Reçu de d'encaissement</h2>
                             <div  class="row mb-2" >
                              <div class="col">
                                livreur: <span style="font-weight: bold; color: black;">{{session('singleinfo')->livreur->nom}}</span>
                              </div>
                             <div class="col">
                                Date: <span style="font-weight: bold; color: black;">{{date_format(date_create($day), "d-m-Y")}}</span>
                              </div>
                               <div class="col">
                                Code: <span style="font-weight: bold; color: black;">{{session('singleinfo')->cashkey}}</span>
                              </div>
                            </div>
                             
                            <div class="row mb-2">
                              <div class="col">
                                Pour les clients: <span style="font-weight: bold; color: black;">{{session('payed_recettes')->sum('montant')}}</span>
                              </div>
                              <div class="col">
                               Livraison: <span style="font-weight: bold; color: black;">{{session('payed_recettes')->sum('livraison')}}</span>
                              </div>
                              <div class="col">
                                Total: <span style="font-weight: bold; color: black;">{{session('payed_recettes')->sum('montant')+session('payed_recettes')->sum('livraison')}}</span>
                              </div>
                            </div>

                          
                            <h2>Commandes</h2>
                            @foreach(session('payed_recettes') as $cmd)
                            <div class="border border-primary mb-2">
                             <div class="row  ">
                              <div class="col"><span style="font-weight: bold; color: black;">#{{$cmd->id}} : {{$cmd->description}}</span></div>
                              <div class="col">Montant: <span style="font-weight: bold; color: black;">{{$cmd->montant}}</span></div>
                              <div class="col">Montant: <span style="font-weight: bold; color: black;">{{$cmd->livraison}}</span></div>

                               <div class="col">Total: <span style="font-weight: bold; color: black;">{{$cmd->livraison+$cmd->montant}}</span></div>
                              
                             </div>
                             

                              
                             </div>
                             @endforeach
                           
                          </div>
                          @endif
                   
                
                    </div>
                    
                    
                </div>
            </div>
        </div>
        

    <!-- loader -->
    <!-- <div id="loader">
        <img src="assets/img/logo-icon.png" alt="icon" class="loading-icon">
    </div> -->
    <!-- * loader -->

    <!-- App Header -->
    <div class="appHeader">
        <div class="left">
            <a href="commands" class="headerButton goBack">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        
        
        Payements
    </div>
    <!-- * App Header -->
   
   

    <!-- App Capsule -->
    <div id="appCapsule" class="extra-header-active">
        @if (session('status'))
        <div class="alert alert-success">{{session("status")}}</div>

 
 @endif
          <div class="section">
          <div class="row mb-2 mt-2">
                <div class="col-sm-3">
       <form action="" class="date_form">
        <div class="input-group mb-2">
       <div class="input-group-prepend">
    <span class="input-group-text" id="">Date </span>
  </div>
  <input hidden type="" name="route_day1" value="1">
<input  onchange="$('.date_form').submit()" required type="date" value="{{ $day }}" name="route_day" class="form-control" type="text" id="cmddate" >
      @error('route_day')
      <span class="invalid-feedback" role="alert">
      <strong>{{ $message }}</strong>
      </span>
      @enderror
      </div>
    </form>
     </div>
     </div>  
   </div>


                <div class="section mt-2">
            <div class="section-title"></div>

           <div class="row">
          <div class="col-md-12">
            <div class="card card-primary card-tabs">
              <div class="card-header p-0 pt-1">
                <ul class="nav nav-tabs" id="custom-tabs-five-tab" role="tablist">
                  <li class="nav-item">
                    <a class="nav-link active" id="custom-tabs-five-overlay-tab" data-toggle="pill" href="#custom-tabs-five-overlay" role="tab" aria-controls="custom-tabs-five-overlay" aria-selected="true">POINS CLIENTS</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link " id="custom-tabs-five-overlay-recette-tab" data-toggle="pill" href="#custom-tabs-five-overlay-recette" role="tab" aria-controls="custom-tabs-five-overlay" aria-selected="true">POINTS LIVREURS</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-five-overlay-dark-tab" data-toggle="pill" href="#custom-tabs-five-overlay-dark" role="tab" aria-controls="custom-tabs-five-overlay-dark" aria-selected="false">HISTORIQUE VERSEMENT CLIENT</a>
                  </li>

                   <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-five-overlay-caisse-tab" data-toggle="pill" href="#custom-tabs-five-overlay-caisse" role="tab" aria-controls="custom-tabs-five-overlay-dark" aria-selected="false">HISTORIQUE ENCAISSEMENT LIVREUR</a>
                  </li>
                 
                </ul>
              </div>
              <div class="card-body table-responsive p-0">
                <div class="tab-content" id="custom-tabs-five-tabContent">
                  <div class="tab-pane fade show active" id="custom-tabs-five-overlay" role="tabpanel" aria-labelledby="custom-tabs-five-overlay-tab">
                    <div class="overlay-wrapper">
                      
                      <table class="table table-head-fixed text-nowrap">
                    <thead class=" text-primary">
                      <th>Client</th>
                      <th>
                     Montant
                      </th>
                      <th>
                        Colis non livrés
                      </th>
                      <th>
                        Action
                      </th>
                     
                     
                      
                    </thead>
                    <tbody>
                     
                      @foreach($clients as $clt)
                      @if($clt->commands->where("delivery_date",  date_create($day))->where("etat", "termine")->where("cashedback_key", null)->sum("montant") -$clt->commands->where("delivery_date",  date_create($day))->where("etat", "termine")->where("cashedback_key", null)->sum("remise") > 0


                        || $clt->commands->where("delivery_date", date_create($day))->whereIn("etat", ["encours", "recupere", "en chemin", "annule"])->count() > 0)
                      <tr>
                        
                        <td>
                          
                               
                            {{$clt->nom}}   
                               
                        </td>
                        <td>
                         <span style="font-weight: bold; font-size: 18px">{{number_format($clt->commands->where("delivery_date",  date_create($day))->where("etat", "termine")->where("cashedback_key", null)->sum("montant") -$clt->commands->where("delivery_date",  date_create($day))->where("etat", "termine")->where("cashedback_key", null)->sum("remise")

                         , 0, " ", " ")}}</span>

                         
                        </td>
                        <td> 
                          <span style="font-weight: bold; font-size: 18px">
                          {{$clt->commands->where("delivery_date",  date_create($day))->whereIn("etat", ["encours", "recupere", "en chemin", "annule"])->count()}}
                        </span>
                          
        </td>
                        
                     <td>
                        @if($clt->commands->where("delivery_date",  date_create($day))->where("etat", "termine")->where("cashedback_key", null)->sum("montant") -$clt->commands->where("delivery_date",  date_create($day))->where("etat", "termine")->where("cashedback_key", null)->sum("remise") > 0   || $clt->commands->where("delivery_date", date_create($day))->whereIn("etat", ["encours", "recupere", "en chemin", "annule"])->count() > 0)
                           <form method="post" action="payedbylivreur">
                            @csrf
                            <input hidden type="" name="payedbylivreur" value="1">
                            <input type="date" hidden name="delivdate" value="{{$day}}">
                            <input hidden type="" name="id" value="{{$clt->id}}">
                          <button    class="btn btn-primary">Voir detail</button>

                           @if($clt->commands->where("delivery_date",  date_create($day))->where("etat", "termine")->where("cashedback_key", null)->sum("montant") -$clt->commands->where("delivery_date",  date_create($day))->where("etat", "termine")->where("cashedback_key", null)->sum("remise") > 0)
                           <button  id='allPay{{$clt->id}}' type="button" class='btn btn-success mt-1 payall' value='{{$clt->id}}'>Verser</button>
                           @endif
                         </form>
                           

                            <br>
                                 <span hidden id='allPayButtons{{$clt->id}}'>
                                   <form method="post" action="payall">   
                                @csrf
                                <input hidden type="" name="montant" value='{{$clt->commands->where("delivery_date", $day)->where("etat", "termine")->where("cashedback_key", null)->sum("montant") -$clt->commands->where("delivery_date", $day)->where("etat", "termine")->where("cashedback_key", null)->sum("remise")}}'>
                                <div class="form-group"> 
                                <select name="method" class='form-control ' required >
                                  <option value=''>
                                    Choisir mode de paiement
                                     </option>

                                 <option value='Main à main'>
                                 Main à main
                                     </option>
                                   <option value='Mobile money'>
                                 Mobile money
                                   </option>
                                    <option value='Virement bancaire'>
                                       Virement bancaire
                                     </option>
                               </select>
      </div>  
        <input hidden type="" name="client_id" value="{{$clt->id}}">
        <input hidden type="" name="client_name" value="{{$clt->nom}}">
        <input hidden type="" name="delivdate" value="{{$day}}">

       <button  type="submit"  class='btn btn-info '  >
       
        <span  hidden class="spinner-border spinner-border-sm allPaySpinner{{$clt->id}}" role=status aria-hidden="true"></span><span class=sr-only></span>
       
       Confirmé</button>
       <button value='{{$clt->id}}'  class='btn btn-danger allPayCancel{{$clt->id}} allPayCancel'>Annuler</button>
      
          </form>   
          </span>          
          @endif  
                     </td>
                        
                      </tr>
                      @endif
                      @endforeach
                    
                    </tbody>
                   
                  </table>
                  
                    </div>
                  </div>
                  <div class="tab-pane fade" id="custom-tabs-five-overlay-dark" role="tabpanel" aria-labelledby="custom-tabs-five-overlay-dark-tab">
                    <div class="overlay-wrapper">

                       
                      <table class="table table-striped">
  <thead class=" text-primary">
   
    <th>Code versment</th>
    <th>Montant</th>
  
    <th>Action</th>
  
  </thead>

  <tbody>
      @foreach($payed_by_client as $done2)
    <tr>
      
      <td>
       
        {{ $done2->cashedback_key}} 
        
      </td>
      <td>{{$done2->montant}}</td>  
      
      
            <td>
              <form method="post" class="mb-2" action="receipt">
                @csrf
                <input hidden type="" name="cashedback_key" value="{{ $done2->cashedback_key}}">
                 <input hidden type="" name="delivdate" value="{{$day}}">
               <button type="submit" class="btn btn-primary ">Reçu de versement</button> 
             
               </form>

                <form  method="post" action="cancelpay">
                @csrf
                <input hidden type="" name="cashedback_key" value="{{$done2->cashedback_key}}">
                 
              @if($payment_roles->contains("action", "CANCEL"))
               <button onclick="return confirmSubmit()" type="submit" class="btn btn-danger">Annuler paiement</button>
               @endif
               </form>
            </td>
     
    </tr>
@endforeach

  </tbody>
</table>
                    </div>
                  </div>




                  <div class="tab-pane fade" id="custom-tabs-five-overlay-caisse" role="tabpanel" aria-labelledby="custom-tabs-five-overlay-dark-tab">
                    <div class="overlay-wrapper">
                 
                      <table class="table table-striped">
  <thead class=" text-primary">
   <th>Code Encaissement</th>
   
    <th>Recette livraison</th>
    <th>Encaissé pour les client</th>
    <th>Total</th>
    <th>Action</th>
  
  </thead>

  <tbody>
      @foreach($payed_by_livreur as $cash)
    <tr>
     
      <td>{{ $cash->cashkey}} </td>
      <td>{{$cash->livraison}}</td>   
      
                <td>
                 {{$cash->montant}}
                </td>

                <td>
                 {{$cash->montant+$cash->livraison}}
                </td>
            <td>
               <form method="post" class="mb-2" action="moneyreceipt">
                @csrf
                <input hidden type="" name="payed_key" value="{{ $cash->cashkey}}">
                 <input hidden type="" name="delivdate" value="{{$day}}">
               <button type="submit" class="btn btn-primary ">Reçu d'encaissement</button> 
             
               </form>

                <form  method="post" action="cancelmoneypay">
                @csrf
                <input hidden type="" name="payed_key" value="{{$cash->cashkey}}">
                 
               @if($payment_roles->contains("action", "CANCEL"))
               <button onclick="return confirmSubmit()" type="submit" class="btn btn-danger">Annuler encaissement</button>
               @endif
               </form>
            </td>
     
    </tr>
@endforeach

  </tbody>
</table>
                    </div>
                  </div>


                   <div class="tab-pane fade" id="custom-tabs-five-overlay-recette" role="tabpanel" aria-labelledby="custom-tabs-five-overlay-recette-tab">
                    <div class="overlay-wrapper">


                        <table class="table table-head-fixed text-nowrap">
                    <thead class=" text-primary">
                      <th>Livreur</th>
                      <th>
                     Recette livraison
                      </th>
                      <th>
                        Encaissé pour les clients
                      </th>
                      
                       <th>
                        Total
                      </th>

                      
                     <th>
                        Action
                      </th>
                     
                     
                      
                    </thead>
                    <tbody>
                      @if($recette->count()>0)
                      @foreach($recette as $money)
                      <tr>
                        
                        <td>
                          
                               
                                {{$money->livreur->nom}}
                               
                        </td>
                        <td>
                          {{$money->livraison}}
                        </td>

                        <td>
                         {{$money->montant}}
                       </td>
                       <td>
                       <strong>  {{$money->livraison+$money->montant}} </strong>

                           
                       </td>
                        <td> 
                           <form method="post" action="payedbyclient">
                            @csrf
                            <input type="date" hidden name="delivdate" value="{{$day}}">
                            <input hidden type="" name="id" value="{{$money->livreur_id}}">
                            <input hidden type="" name="payedbyclient" value="1">
                          <button    class="btn btn-primary">Voir detail</button>
                          <button id='allMoney{{$money->livreur_id}}' type="button" class='btn btn-success mt-1 allMoney' value='{{$money->livreur_id}}' class="btn btn-primary mr-2">Encaisser</button>
                           
                         </form>
                      <span hidden id='allMoneyButtons{{$money->livreur_id}}'>
                           <form class="form-inline" action="moneypay" method="post">
                        @csrf
                        <input hidden type="" name="money" value="">


                             <div class="form-group">
                              <select class="form-control" required>
                                <option value="">Moyen de paiement</option>
                                <option >Main à main</option>
                                <option >Mobile money</option>
                              </select>
                             </div>
                              <input hidden type="" name="livreur_id" value="{{$money->livreur->id}}">
                             <input hidden type="" name="client_name" value="{{$money->livreur->nom}}">
                          <input hidden type="" name="delivdate" value="{{$day}}">

                             <button  type="submit"  class='btn btn-info '  >
       
        <span  hidden class="spinner-border spinner-border-sm allMoneySpinner{{$money->livreur_id}}" role=status aria-hidden="true"></span><span class=sr-only></span>
       
       Confirmé</button>
       <button value='{{$money->livreur_id}}' type="button"  class='btn btn-danger allMoneyCancel{{$money->livreur_id}} allMoneyCancel'>Annuler</button>
                          </form>     
                        
                        
                         </span>

                         <!--  <button  value=" @foreach($money->livreur->commands->where('payed_at', NULL) as $command)
                                           <div class='card mb-2'>
                                            <div class='card-body'>
                                              <div class='row'>
                                            Client: @if($command->client) {{$command->client->nom}} @endif
                                            </div>
                                              <div class='row'>
                                            #{{$command->id}} - {{$command->description}}
                                            </div>
                                            <div class='row'>
                                            livraison: {{$command->livraison}}f<br>
                                            Encaissé pour le client: {{$command->montant-$command->remise}}<br>
                                            Total: {{$command->montant-$command->remise-$command->livraison}}
                                            </div>
                                           </div>
                                         </div>
                                           @endforeach"  class="btn btn-primary moneydetail">Voir detail</button> -->


                                    

                                           

                     </td>
                     <td>
                      
                     </td>
                        
                       
                        
                      </tr>
                      @endforeach
                      @endif
                    </tbody>
                   
                  </table>


                    </div>
                  </div>
                 
                </div>
              </div>
              <!-- /.card -->
            </div>
          </div>
        </div>

            <!-- * waiting tab -->



            <!-- paid tab -->
            <div class="tab-pane fade" id="paid" role="tabpanel">

                 <div class="section mt-2">
            <div class="section-title"></div>
            <div class="row mb-2">
                <div class="col-3">
            <form  autocomplete="off" id="date-form" action='?bydate' class=" form-inline">
                  @csrf
            <div class="input-group  date">
                     
      <div class="input-group-prepend">
      <span class="input-group-text purple lighten-3" id="basic-text1"><i class="fas fa-calendar text-dark"
         aria-hidden="true">{{date_create($day)->format('d-m-Y')}}</i></span>
      </div>
      <input placeholder="Choisir une date"  id="day" class="form-control" type="text" onfocus="(this.type='date')" name="route_day">
      </div>
    </form>
    </div>
    </div>
            <div class="row">
               @foreach($payed_by_livreur as $done)
               
                    <div class="col-6 mb-2">
                        <div class="bill-box">
                            <div class="img-wrapper donee{{$done->id}}">
                              
                                @foreach($livreurs as $livreur2)
                                @if($livreur2->id == $done->livreur_id)
                                {{$livreur2->nom}}
                                @endif
                                @endforeach

                            </div>
                            
                            <div class="price">{{$done->montant}}</div>
                            
                            <button data-done="{{$done->id}}" data-id="{{$done->livreur_id}}" data-montant="{{$done->montant}}" data-date=""  value="{{$done->observation}}"  class="btn btn-primary doneDetail">
                           <span  hidden class="spinner-border spinner-border-sm doneSpinner{{$done->id}}" role=status aria-hidden="true"></span><span class=sr-only></span>

                            DETAIL</button>


     


                        </div>
                    </div>
                
                @endforeach

        </div>


        </div>
    
            </div>
            <!-- * paid tab -->

        </div>

    </div>
</div>
    
    <!-- * App Capsule -->
 <script>

   const app = Vue.createApp({
    data() {
        return {
          delivery_date: {!! $day !!},
          states:[{"text":"Encours", "value":"encours"},{"text":"Livre", "value":"termine"},{"text":"Annule", "value":"annule"},],

          retours:[{"text":"Non retourné", "value":null},{"text":"Encours", "value":"encours"},{"text":"Retourné", "value":"retourne"},],
        }
},

  methods:{




   updateCmd(id, part, link){
     
    element = document.getElementById(part).value
    axios.post(link, {
           
            cmdid:id,
            part: element,
            
            _token: CSRF_TOKEN
  })

         
  .then(function (response) {
    alert("Action effectuée "+ element+ " " + id)
    
  

  })
  .catch(function (error) {
    
    console.log(error);
  });
    },
   },
   computed:{

   
}
});

  const mountedApp = app.mount('#app')    
   
  </script>

    <!-- App Bottom Menu -->
    <!-- <div class="appBottomMenu">
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
    </div> -->
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
    <script src="../assets/js/commands.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDsIOetOqXmUutxkLiMQBQC3H98Gfd_sEg&libraries=&v=weekly"></script>
    <script src="../assets/manifest/js/app.js"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.5.0-beta4/html2canvas.min.js"></script>
     <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.3/html2pdf.bundle.min.js"></script>
   @if (session('by_livreur'))
 <script type="text/javascript">
    $("#payModal").modal("show");
    $("#custom-tabs-five-overlay-tab").click();
 </script>
 
 @endif

 @if (session('by_client'))
 <script type="text/javascript">
    $("#moneyModal").modal("show");
 
    $("#custom-tabs-five-overlay-recette-tab").click();
</script>
 
 @endif

 @if (session('payed_commands'))
 <script type="text/javascript">
    $("#receiptModal").modal("show");
 
    $("#custom-tabs-five-overlay-dark-tab").click();
</script>
 
 @endif

 @if (session('payed_recettes'))
 <script type="text/javascript">
    $("#rReceiptModal").modal("show");
 
    $("#custom-tabs-five-overlay-caisse-tab").click();
</script>
 
 @endif



<div id="singlePayScript">
  
</div>

<script type="text/javascript">
  <!--
function confirmSubmit()
{
var agree=confirm("Voulez-vous vraiment annuler le versment?");
if (agree)
 return true ;
else
 return false ;
}
// -->

  var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

  $(".moneydetail").click(function(){
    $('#moneyModal').modal('show');
    
   $('.moneyBody').html($(this).val());

  });
  $('.detail').click( function() {
   var livreur_id = $(this).val();
   
   $('#payModal').modal('show');
    
   $('.payBody').html('<span   class="spinner-border spinner-border paySpinner" role="status" aria-hidden="true"></span><span class="sr-only"></span>');


     $.ajax({
       url: 'paydetail',
       type: 'post',
       data: {_token: CSRF_TOKEN,livreur_id: livreur_id},
   
       success: function(response){
                 $('.payReturn').removeAttr('hidden');
                $('.payBody').html(response.display);
                $('.payTotal').html('<strong>Total:' +response.total + '</strong>');
                 $('.payLivreur').html(response.livreur);
                 $('#singlePayScript').html(response.single_pay_script);
              },
   error: function(response){
               
                alert('Une erruer s\'est produite');
              }
             
     });
   });



    $('.allPayConfirm').click( function() {
       var livreur_id = $(this).val();
       var method = $('.payMethod'+livreur_id).val();
       var curallPaybtns = $(this).data('allPayButtons');
    
   
   $('.allPaySpinner'+livreur_id).removeAttr('hidden');

     if(method == 'no')
     {alert('veuillez choisr une methode de paiement');

      $('.allPaySpinner'+livreur_id).attr('hidden', 'hidden');}
     else {
      $.ajax({
            url: 'payall',
            type: 'post',
            data: {_token: CSRF_TOKEN,livreur_id: livreur_id, method:method},
        
            success: function(response){
                     $('#allPayButtons'+livreur_id).attr('class', 'alert alert-success');
                     $('#allPayButtons'+livreur_id).html('Payé');
                     $('#payDetail'+livreur_id).attr('hidden', 'hidden');

                     
                      
                   },
        error: function(response){
                    
                     alert('Une erruer s\'est produite');
                     $('.allPaySpinner'+livreur_id).attr('hidden', 'hidden');
                   }
                  
          });}
   });


$('.payall').click(function(){
       $(this).attr('hidden', 'hidden');
    var id = $(this).val();
  $('#allPayButtons'+id).removeAttr('hidden');
  $('.allPayCancel'+id).removeAttr('hidden');
 
});

$('.allMoney').click(function(){
       $(this).attr('hidden', 'hidden');
    var id = $(this).val();
  $('#allMoneyButtons'+id).removeAttr('hidden');
  $('.allMoneyCancel'+id).removeAttr('hidden');
 
});


 $(".allPayCancel").click(function(){
   id = $(this).val();
     $(this).attr('hidden', 'hidden');
   $('#allPayButtons'+id).attr('hidden', 'hidden');
   $('#allPay'+id).removeAttr('hidden');
   $('#payDetail'+id).removeAttr('hidden');
});

 $(".allMoneyCancel").click(function(){
   id = $(this).val();
     $(this).attr('hidden', 'hidden');
   $('#allMoneyButtons'+id).attr('hidden', 'hidden');
   $('#allMoney'+id).removeAttr('hidden');
   $('#moneyDetail'+id).removeAttr('hidden');
});


 $('.doneDetail').click(function(){
  
    var doneDate = $(this).data("date"); 
    var id = $(this).data("id");
    var ids = $(this).val();
    var montant = $(this).data("montant");
    var done = $(this).data("done");
    $(".doneSpinner"+done).removeAttr("hidden");

    $.ajax({
            url: 'donedetail',
            type: 'post',
            data: {_token: CSRF_TOKEN,ids: ids, id: id},
        
            success: function(response){
                     $('.doneModalBody').html(response.dones);
                     $('.donee').html(response.livreur_nom + " - "+ montant + " - "+ doneDate);
                     $('#doneModal').modal('show');
                      $('.doneSpinner'+done).attr('hidden', 'hidden');
                   },
        error: function(response){
                    
                     alert('Une erruer s est produite');
                     $('.doneSpinner'+done).attr('hidden', 'hidden');
                   }
                  
          });
  

});


        // Add a click event listener to the capture button

      function exportToImage(elementToExport){

      
            // Select the HTML element you want to convert to an image
            const element = document.getElementById(elementToExport);

            // Use html2canvas to capture the element as an image
            html2canvas(element).then(function(canvas) {
                // Convert the canvas to an image and set the image source to the data URL
                const image = new Image();
                image.src = canvas.toDataURL();

                // Open the image in a new window
                const newWindow = window.open();
                newWindow.document.write('<img src="' + image.src + '" alt="Converted HTML to Image"/>');
                     });
        

      }
        


        function printElement(elementToPrint) {
    // Get the element with the desired ID
    const element = document.getElementById(elementToPrint);

    // Check if the element exists
    if (element) {
        // Print the innerHTML of the element
        old = document.body.innerHTML
        document.body.innerHTML = element.innerHTML
          window.print();
          location.reload()
        console.log(element.innerHTML);
    } else {
        console.log('Element not found.');
    }
}


 function exportToPDF(elementToExport, file) {
            const element = document.getElementById(elementToExport);

            // Set the options for the PDF
            const options = {
                margin: 10,
                filename: file, // Change the filename if needed
                image: { type: 'jpeg', quality: 0.98 },
                html2canvas: { scale: 2 },
                jsPDF: { unit: 'mm', format: 'a4', orientation: 'portrait' }
            };

            // Use html2pdf.js to export the element to PDF
            html2pdf().from(element).set(options).save();
        }
</script>
</body>

</html>