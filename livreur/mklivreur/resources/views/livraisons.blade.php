<!doctype html>
<html lang="fr">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>JibiaT - Mes livraisons</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <meta name="viewport"
        content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, viewport-fit=cover" />
    <meta name="description" content="Mes livraison">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="keywords" content="Livraisons, assignations" />
    <link rel="apple-touch-icon" sizes="180x180" href="assets/img/apple-touch-icon.png">
    <link rel="icon" type="image/png" href="assets/img/favicon.png" sizes="32x32">
    <link rel="shortcut icon" href="assets/img/favicon.png">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

     <link rel = " manifest " href="../assets/manifest/livreur.json">

   <!-- ios support -->
    <link rel="apple-touch-icon" href="../assets/manifest/img/logo.png" />
    
    <meta name="apple-mobile-web-app-status-bar" content="#db4938" />
</head>

<body>
   <!-- Dialog with Image -->
        
        <!-- * Dialog with Image -->

  <!-- App Sidebar -->
    <div class="modal fade panelbox panelbox-left" id="sidebarPanel" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body p-0">
                    <!-- profile box -->
                    <div class="profileBox pt-2 pb-2">
                        <div class="image-wrapper">
                            <img 
                             @if($livreur->photo != NULL)
                          src="{{Storage::disk('s3')->url($livreur->photo)}}" 
                         @else src="assets/img/sample/brand/1.jpg"  @endif
                        class="imaged  w36">
                        </div>
                        <div class="in">
                            <strong>{{$livreur->nom}}</strong>
                            <div class="text-muted">{{$livreur->phone}}</div>
                        </div>
                        <a href="#" class="btn btn-link btn-icon sidebar-close" data-dismiss="modal">
                            <ion-icon name="close-outline"></ion-icon>
                        </a>
                    </div>
                    <!-- * profile box -->
                    <!-- balance -->
                    <div class="sidebar-balance">
                        <div class="listview-title">{{$day}}</div>
                        <div class="in">
                            <h1 class="amount">{{$commands->where('etat', 'termine')->sum('livraison')}} FCFA</h1>
                        </div>
                    </div>
                    
                    <ul class="listview flush transparent no-line image-listview">

                         <li>
                            <a href="livraisons" class="item">
                                <div class="icon-box bg-primary">
                                    <ion-icon name="bicycle-outline"></ion-icon>
                                </div>
                                <div class="in">
                                    Mes livraisons
                                    <span class="badge badge-primary">{{$commands->where('etat', 'encours')->count()}}</span>
                                </div>
                            </a>
                        </li>

                          <li>
                            <a href="commencer" class="item">
                                <div class="icon-box bg-primary">
                                    <ion-icon name="home-outline"></ion-icon>
                                </div>
                                <div class="in">
                                    Acceuil
                                </div>
                            </a>
                        </li>

                        <li>
                            <a href="difusions" class="item">
                                <div class="icon-box bg-primary">
                                    <ion-icon name="radio-outline"></ion-icon>
                                </div>
                                <div class="in">
                                  Diffusions  
                                </div>
                            </a>
                        </li>

                        <li>
                            <a href="compte" class="item">
                                <div class="icon-box bg-primary">
                                    <ion-icon name="person-outline"></ion-icon>
                                </div>
                                <div class="in">
                                    Mon compte
                                </div>
                            </a>
                        </li>
                      
                        <li>

                            <a href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();" class="item">
                                <div class="icon-box bg-primary">
                                    <ion-icon name="log-out-outline"></ion-icon>
                                </div>
                                <div class="in">
                                   {{ __('Deconnexion') }}
                                </div>
                            </a>
                        </li>
                    </ul>
                    <!-- * others -->

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
                    

                </div>
            </div>
        </div>
    </div>
    <!-- * App Sidebar -->


    <div class="modal fade dialogbox" id="domModal" data-backdrop="static" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    
                    <div class="modal-header">
                        <h5 class="modal-title ">Confirmer les coodonnées de mon domicile</h5>
                        <a href="javascript:;" data-dismiss="modal">Fermer</a>
                    </div>
                    <div class="modal-body">
                        <span class="text-danger mt-2">Assure toi que tu es à ton domicile et que ton GPS est activé! Une fois confirmer, tu ne pourra plus modifier</span>
                       <button onclick="setdom()" class="btn btn-primary btn-block">Envoyer les coordonnées de mon domicile</button> 
                    </div>
                    
                </div>
            </div>
        </div>


     <!-- Dialog with Image -->
      <div class="modal fade action-sheet  " id="noteViewModal" tabindex="-1" role="dialog">
            <div  class="modal-dialog" role="document">
                <div  class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h5 class="modal-title">Notes de livraison</h5>
                        

                    </div>
                    <div   class="modal-body">
                        <div class="action-sheet-content noteViewBody">
                            
                        </div>
                    </div>
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
                        <h5 class="modal-title">Installer l'application Jibiat</h5>
                    </div>
                    <div class="modal-body">
                        Accedez a jibiaT en un clique!
                    </div>
                    <div class="modal-footer">
                        <div class="btn-inline">
                            <a href="#" class="btn btn-text-secondary " data-dismiss="modal">Plus tard</a>
                            <a href="#" class="btn btn-text-success add-button" data-dismiss="modal">Installer</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- * Dialog with Image -->


       


     <div class="modal fade dialogbox" id="pendingModal" data-backdrop="static" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div id="newPending" class="modal-icon">
                        
                    </div>
                    <div class="modal-header">
                        <h5 class="modal-title">Nouvelle(s) assignation(s) reçues</h5>
                    </div>
                    <div class="modal-body">
                        <div class="spinner-border " role="status"></div>
                        Actualisation...
                    </div>
                    
                </div>
            </div>
        </div>
        <!-- * DialogIconedInfo -->

    <!-- Form Action Sheet -->
        <div class="modal fade action-sheet" id="noteModal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Note de livraison</h5>
                    </div>
                    <div class="modal-body">
                        <div class="action-sheet-content">

                            <form     method="POST" action="deliv-note">
                            @csrf
                                <input id="commandId"  type="hidden" name="command_id" >

                               <input id="clientPhone" type="hidden" name="client_phone" >

                              <input id="commandPphone"  type="hidden" name="command_phone" >

                                <div class="form-group basic">
                                    <div class="input-wrapper">
                                        <label class="label" for="account1">Note</label>
                                        <select required name="note" class="form-control custom-select" id="d2">
                                            <option value="">Choisir une note</option>
                                        @foreach($notes as $note)
                                        <option value="{{$note}}" >{{$note}}</option>
                                        @endforeach
                                        <option value="Autre">Autre</option>
                                        </select>
                                    </div>
                                    <div class="input-info">Choisir une note</div>
                                </div>
                                  
                                <div hidden id="report_date_div" class="form-group basic" >
                                  <label  class="label" >
                                 Date de report</label>
                                <input class="form-control form-control-lg" id="report_date" type="date" name="report_date">
                               
                                </div>


                                <div hidden id="rdv_date_div" class="form-group basic" >
                                  <label  class="label" >
                                 Heure du RDV</label>
                                <input class="form-control form-control-lg" id="rdv_date" type="time" name="rdv_date">
                               
                                </div>


                                <div hidden id="autre_div" class="form-group basic" >
                                  <label  class="label" >
                                 Details</label>
                                 <textarea rows="4" cols="4" class="form-control border border-primary" id="autre_detail"  name="autre_detail"></textarea>
                                
                               
                                </div>
                                
    <div hidden id="new_adress_div">
            <div class="form-group basic">
                <div class="input-wrapper">
                <label class="label" for="account1">Commune</label>
                <select  name="new_fee" class="form-control custom-select" id="new_fee">
                <option value="">Choisir la Commune</option>
                    @foreach($fees as $fee)
                    <option value="{{$fee->id}}" >{{$fee->destination}}</option>
                    @endforeach
                                        
                </select>
                </div>
                                    
        </div>

    <div  id="new_adress" class="form-group basic" >
        <label  class="label" >Detail de l'adresse</label>
    <textarea rows="4" cols="4" class="form-control border border-primary" id="new_adress"  name="new_adress"></textarea>
    </div>
        </div>
<div class="form-group basic">
    <button type="submit" class="btn btn-primary btn-block  btn-lg">Confirmer</button>
    </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- * Form Action Sheet -->

      
        

    <!-- loader -->
    <!-- <div id="loader">
        <img src="assets/img/logo-icon.png" alt="icon" class="loading-icon">
    </div> -->
    <!-- * loader -->

    <!-- App Header -->
    <div class="appHeader">
        <div class="left">
            <a href="commencer" class="headerButton goBack">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        @include("includes.rightmenu")
        
        <img src="assets/img/675x175orange.png" width="67" height="17" alt="logo" class="logo">
    </div>
    <!-- * App Header -->

    <!-- Extra Header -->
    <div class="extraHeader pr-0 pl-0">
        <ul class="nav nav-tabs lined" role="tablist">
            <li class="nav-item">
                <a  class="nav-link active phone" data-toggle="tab" href="#waiting" role="tab">
                    Livraisons @if($commands->count()>0) {{$commands->count()}}  @endif
                </a>
            </li>
            <li class="nav-item">
                <a  class="nav-link phone" data-toggle="tab" href="#paid" role="tab">
                    Payement @if($payments->count()>0) {{$payments->count()}}  @endif
                </a>
            </li>
            <li class="nav-item">
                <a  class="nav-link phone" data-toggle="tab" href="#retours" role="tab">
                    Non livres <span value="{{$retours->count()}}" id="rt_count"> {{$retours->count()}}</span>
                </a>
            </li>
        </ul>
    </div>
    <!-- * Extra Header -->
    @include("includes.cmdvalidation")

    <!-- App Capsule -->
    <div id="appCapsule" class="extra-header-active">
      
      <div class="section mt-2 mb-2">
            <div class="section-title">Dis aux vendeurs que tu es disponible à cet endroit</div>

            <div class="row">
             <span class="text-danger mt-2">Assurez toi que ton GPS est activé!</span>
                <button onclick="set()" class="btn btn-primary btn-block">Je suis disponible ici</button>
                
            </div>

            <div class="location row">
         
     </div>

        </div>

        <div class="section mt-2">
            <div class="section-title"></div>

            <div class="row">

                <div  class="col-12">
                    
                    

                  <div class="section mt-2 mb-2">
                     @if($livreur->domlat == NULL || $livreur->domlong == NULL)
            <div class="card border border-danger">
                <div class="card-body">
                   
            <div class="section-title">Envois Les coordonnés GPS de ton domicile pour être en contact avec les vendeurs près de chez toi!</div>

            <div class="row">
             <span class="text-danger mt-2">Assurez toi que tu es à ton domicile et que ton GPS est activé!</span>
                <button  class="btn btn-primary btn-block locate">Envoyer les coordonnées de mon domicile</button>
                
            </div>
            
            
            
          </div>
        </div>
         @endif
       </div>
                </div>
            </div>
         </div>





        <div class="section  tab-content mt-2 mb-1">
           
            <!-- waiting tab -->
            <div class="tab-pane fade show active" id="waiting" role="tabpanel">

                <div >


                     <form  autocomplete="off" id="date-form" action='?bydate' class=" form-inline">
                  @csrf
                  
      <div class="input-group  date">
                     
      <div class="input-group-prepend">
      <span class="input-group-text purple lighten-3" id="basic-text1"><i class="fas fa-calendar text-dark"
         aria-hidden="true">{{$day}}</i></span>
      </div>
      <input placeholder="Choisir une date"  id="day" class="form-control" type="text" onfocus="(this.type='date')" name="route_day">
      </div>
                  <button id="submit_day" hidden type="submit" class="btn btn-primary">Choisir</button>
                  
                </form> <br>
                @if(count($final_destinations)>0)    
               @foreach($final_destinations as $destination=> $nomber)
               

               <div class="chip chip-media">
                        <i class="chip-icon  bg-success ">
                            <ion-icon name="location"></ion-icon>
                        </i>
                        <span class="chip-label">{{$destination}}({{ $nomber}})</span>
                    </div>
               @endforeach
               <br><br>
               @endif
               <a class="btn btn-success  phone" href="sms:@foreach($commands as $x=>$client_phone)
              @if($client_phone->etat != 'termine' && $client_phone->etat != 'annule')
               @if($x == 19 || $x == $commands->count()-1)
               {{substr(preg_replace('/[^0-9]/', '',$client_phone->phone), 0, 8)}}
               <?php break; ?>
               @else
               {{$client_phone->phone}},
               @endif
               @endif
               @endforeach
                ?body=Bonjour! je suis {{Auth::user()->name}}  votre livreur. soyez rassuré, Je viens vous livrer aujourd'hui. Vous pouvez me joindre au {{$livreur->phone}} pour plus de détails."><ion-icon name="mail-outline"></ion-icon>Envoyer un sms aux clients</a>
                  
                  
                </div> 



                <div class="section mt-2">
            <div class="section-title"></div>

            <div class="row">

                <div  class="col-6">
                    
                    <div class="card  bg-light text-center">
                <div class="card-header">En attente</div>
                <div class="card-body">
                    <span data-total="{{$commands->where('etat', 'encours')->count()}}" style="font-size: 60px" 
                        class="pending text-center text-danger">{{$commands->where('etat', 'encours')->count()}}</span><br>
                    <span style="font-size: 15px" class="text-center text-danger">{{$commands->where('etat', 'encours')->sum('livraison')}} FCFA</span>
                </div>
            </div>
                   
                </div>
                 
                <div  class="col-6">
                    
                    <div class="card  bg-light text-center">
                <div class="card-header">Livré</div>
                <div class="card-body">
                    <span style="font-size: 60px" class="text-center text-success">{{$commands->where('etat', 'termine')->count()}}</span><br>
                    <span style="font-size: 15px" class="text-center text-success">{{$commands->where('etat', 'termine')->sum('livraison')}} FCFA</span>
                </div>
            </div>
                   
                </div>
                
            </div>

        </div>

   

      <!--  <img @if($livreur->photo != NULL)
                          src="{{Storage::disk('s3')->url($livreur->photo)}}" 
                         @else src="assets/img/sample/brand/1.jpg"  @endif class="image-block imaged w48"> -->

                        
           @if($commands->count()>0)     
             
        @foreach($commands as $command)  
                             
       <div class="section full  mt-2">
            
            <div   class="accordion" id="accordion02">


                <div class="item">
                    <div class="accordion-header">
                        <button class="btn collapsed" type="button" data-toggle="collapse" data-target="#accordion1b{{$command->id}}">
                            @if($command->etat == 'termine')
                           <i style="margin-right: 10px"  class="fa fa-check text-success fa-2x"></i>
                           @endif

                           @if($command->etat == 'en chemin')
                           <i style="margin-right: 10px"  class="fas fa-walking text-warning fa-2x"></i>
                           @endif

                            @if($command->etat == 'recupere')
                           <i style="margin-right: 10px"  class="fas fa-ellipsis-h text-warning fa-2x"></i>
                           @endif

                           @if($command->etat == 'encours')

                           <i id="state_c{{$command->id}}" style="margin-right: 10px"  class="fas fa-ellipsis-h text-danger fa-2x"></i>
                           @endif
                            


                           <strong style="font-size: 25px; margin-right: 20px"> {{$command->id}}</strong>  
                           @if($command->note->where('description', 'RDV')->count()>0 && $command->etat != 'termine')
                         <span class="text-danger">RDV le {{$command->note->where('description', 'RDV')->where('rdv_time', '!=', 'NULL')->last()->updated_at->format("d-m-Y")}} à {{$command->note->where('description', 'RDV')->where('rdv_time', '!=', 'NULL')->last()->rdv_time}}</span>
                         @endif


             @if($command->note->count()>0)
            <a   href="#" data-notes="<ul> @if($command->note->count()>0) @foreach($command->note as $cmd_note) <li><strong>
                  {{$cmd_note->updated_at->format('d-m-Y')}}</strong> - 
                  {{$cmd_note->updated_at->format('H:i:s')}}
                   

                   {{$cmd_note->description}} @if($cmd_note->description == 'RDV') donné à {{$cmd_note->rdv_time}}  @endif
                   
                    </li> @endforeach @else Il n'y a aucune note pour cette commande @endif </ul>"  class="note text-warning ml-2"> Voire Notes</a>
            @endif
                        </button>

                    </div>
                    
                
                    
                    <div id="accordion1b{{$command->id}}" class="accordion-body collapse" data-parent="#accordion02">
                        <div class="accordion-content">
                            @if($command->etat == 'encours')
                <button  data-id="{{$command->id}}" value="recupere" name="etat"  class="btn btn-danger  recup " type="">
                    <i style=" margin-right: 10px" class="fas fa-hand-holding fa-2x"></i>
              Je Recupère
               </button>

              <button   data-id="{{$command->id}}" id="scndDep{{$command->id}}" hidden value="en chemin" name="etat"  class="btn btn-warning  recup " >
                 <ion-icon name="walk-outline"></ion-icon>          
               Je Démarre
              </button>
                            
           <button  hidden data-id="{{$command->id}}" id="liv{{$command->id}}"  value="termine" name="etat"  class="btn btn-success  recup" >
            <ion-icon name="checkbox-outline"></ion-icon>
               <ion-icon name="checkbox-outline"></ion-icon>             
             Je livre
                          
          </button>
                        
                           @endif


                           @if($command->etat == 'recupere')
            <button  data-id="{{$command->id}}" id=""  value="en chemin" name="etat"  class="btn btn-warning  recup " >
                   <ion-icon name="walk-outline"></ion-icon>
                       Je Demarre
                </button>
                          
                           @endif



                           @if($command->etat == 'en chemin')

    <button  data-id="{{$command->id}}" id=""  value="termine" name="etat"  class="btn btn-success recup " >
        <ion-icon name="checkbox-outline"></ion-icon>
        
     Je livre
     </button>        
  
  @endif        
                
                      <a class="visible{{$command->id}}" @if($command->etat == "encours")  @endif class="btn btn-icon btn-primary mr-1 float-right phone" href="tel:{{$command->phone}}" >
                            1<ion-icon name="call-outline"></ion-icon>
                         </a>
                         
                         @if($command->phone2)
                         <a class="visible{{$command->id}}" @if($command->etat == "encours")  @endif class="btn btn-icon btn-primary mr-1 float-right phone" href="tel:{{$command->phone2}}" >
                            2<ion-icon name="call-outline"></ion-icon>
                         </a>
                         @endif

                         <a class="visible{{$command->id}}" @if($command->etat == "encours")  @endif class="btn btn-icon btn-primary mr-1 float-right phone" href="sms:{{$command->phone}}" >
                            <ion-icon name="mail-outline"></ion-icon>
                         </a>

                           <button @if($command->etat == "encours") hidden @endif  data-id="{{$command->id}}" data-clientphone="{{$command->client->phone}}" data-phone="{{$command->phone}}" class="noteBtn btn btn-icon btn-primary mr-1 float-right visible{{$command->id}}">
                            <ion-icon   name="create-outline"></ion-icon> 
                            </button><br><br>
                            <strong >{{$command->observation}}</strong>
                        </div>
                    </div>
                </div>

                <div @if($command->etat == "encours")  @endif class="item visible{{$command->id}}" >
                    <div class="accordion-header">
                        <button class="btn collapsed" type="button" data-toggle="collapse" data-target="#accordion2b{{$command->id}}">
                           <ion-icon name="location-outline"></ion-icon>
                             
                            
                            {{substr($command->adresse, 0, 50)}}@if(strlen($command->adresse)>49)... @endif  @if($command->longitude != NULL && $command->latitude != NULL) 
                            <a style="font-size: 10px" class="phone" href="https://www.google.com/maps/search/?api=1&query={{$command->latitude}}%2C{{$command->longitude}}">Voir itinerraire</a>
                            @else
                            <a style="font-size: 10px" class="phone" href="sms:{{$command->phone}}?body=je suis {{Auth::user()->name}}  votre livreur. Veuillez cliquer sur ce lien suivant pour m'envoyer votre localisation. cela m'aidera à vous retrouver facilement. https://client.livreurjibiat.site/tracking/{{$command->id}}">Demander itineraire</a>
                            @endif
                        </button>

                    </div>
                    <div id="accordion2b{{$command->id}}" class="accordion-body collapse" data-parent="#accordion02">
                        <div class="accordion-content">
                            {{ $command->adresse}}<br>{{$command->phone}}<br>
                            <a href="https://www.google.com/maps/search/?api=1&query={{urlencode($command->adresse)}}">Rechercher dans google map</a>
                        </div>
                    </div>
                </div>


                <div class="item">
                    <div class="accordion-header">
                        <button class="btn collapsed" type="button" data-toggle="collapse" data-target="#accordion6b{{$command->id}}">
                           <ion-icon src="assets/img/bag-outline.svg"></ion-icon>
                           
                           {{substr($command->description, 0, 50)}}@if(strlen($command->description)>49)... @endif
                        </button>
                    </div>
                    <div id="accordion6b{{$command->id}}" class="accordion-body collapse" data-parent="#accordion02">
                        <div class="accordion-content">
                           {{$command->description}} 
                        </div>
                    </div>
                </div>

                <div class="item">
                    <div class="accordion-header">
                        <button class="btn collapsed" type="button" data-toggle="collapse" data-target="#accordion3b{{$command->id}}">
                            <ion-icon name="cash-outline"></ion-icon>
                            @if($command->livraison == 'NULL') {{$command->fee->price + $command->montant}} @else {{$command->livraison + $command->montant - $command->remise}} @endif CFA
                        </button>
                    </div>
                    <div id="accordion3b{{$command->id}}" class="accordion-body collapse" data-parent="#accordion02">
                        <div class="accordion-content">
                            Prix: {{$command->montant - $command->remise}}.
                            Livraisons:
                            @if($command->livraison == 'NULL') {{$command->fee->price}} @else {{$command->livraison}} @endif.

                        </div>
                    </div>
                </div>

                 <div class="item">
                    <div class="accordion-header">
                        <button class="btn collapsed" type="button" data-toggle="collapse" data-target="#accordion4b{{$command->id}}">
                           <ion-icon src="assets/img/storefront-outline.svg"></ion-icon>
                           
                            {{$command->client->nom}}
                        </button>
                    </div>
                    <div id="accordion4b{{$command->id}}" class="accordion-body collapse" data-parent="#accordion02">
                        <div class="accordion-content">
                            {{$command->client->adresse}}<br>
                            {{$command->client->phone}} 
                             @if($command->phone2)
                             <br>
                             {{$command->phone2}}
                             @endif
                            <a class="btn btn-icon btn-primary mr-1 float-right phone" href="sms:{{$command->client->phone}}" >
                            <ion-icon name="mail-outline"></ion-icon>
                         </a>

                            <a class="btn btn-icon btn-primary mr-1 float-right phone" href="tel:{{$command->client->phone}}" >
                            <ion-icon name="call-outline"></ion-icon>
                         </a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
          @endforeach

          @endif

         
            </div>
           
            <div class="tab-pane fade show" id="retours" role="tabpanel">
                
                @if($retours->count() > 0)
                 @foreach($retours as $retour)
    <div class="card mb-2 rt_$retour->id">
          <div class="card-body ">
                <div class="row " style="color: black;" >
                     <div class="col" style="font-size: 13px; line-height: 1.6; font-style: italic;"> 
                        Date de livraison: {{$retour->delivery_date->format('d-m-Y')}}
                        </div>

                     <div class="col" style="font-size: 13px; line-height: 1.6; font-style: italic;"> 
                       vendeur: {{substr($retour->client->nom, 0, 50)}}@if(strlen($retour->client->nom)>50)...@else . @endif
                       </div>  
                 </div>
            
            <div class=" row ">
             <div style="line-height: 1.6;" class="col">
                <span  style="font-size:20px;color:black; ">
                    {{$retour->id}} 
                 </span>
                </div>
                 <div style="line-height: 1.6; font-size:13px" class="col">
                @if($retour->etat == 'en chemin')
                           <i   class="fas fa-walking text-warning "></i>En chemin
                           @endif

                            @if($retour->etat == 'recupere')
                           <i   class="fas fa-dot-circle text-warning "></i>Récupéré
                           @endif
                    </div>
                <div class="col-7">
                    <span  style="font-size:17px; " >
                        <ion-icon name="cash-outline"></ion-icon>
                           {{$retour->livraison  + $retour->montant - $retour->remise}} 
                    </span>
             </div>
             </div>

             <div class="row mt-0">
                

          

         
  @if($retour->note->count() > 0)
  <div class="col">
           <ion-icon class="text-danger ml-1" name="information-circle-outline"></ion-icon>
    {{$retour->note->last()->description}}
    </div>
    @endif
             </div>
             
            
          </div>
         
      </div>   
                 @endforeach
                @else
                 Aucun retour
                @endif
            
            </div>

            <!-- * waiting tab -->



            <!-- paid tab -->
<div class="tab-pane fade" id="paid" role="tabpanel">
    @if($payments->count()>0)
    <div class="row">  
      @foreach($payments as $payment)
        @if($payment->montant > 0)
         
          @foreach($clients as $client)
            @if($client->id == $payment->client_id)
               
                    <div class="col-6 mb-2">
                        <div class="bill-box">
                            <div class="img-wrapper">
                                {{$client->nom}}
                            </div>
                            <div class="price">{{$payment->montant}}</div>
                            
                            <a href="#" class="btn btn-primary ">DETAIL</a>
                        </div>
                    </div>
                

          @endif                         
         @endforeach
         
       @endif
    @endforeach
    </div>
  @else
  Il n'y a aucun impayé
@endif      
            </div>
            <!-- * paid tab -->

        </div>

    </div>
   

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
    <script src="https://cdn.jsdelivr.net/gh/bigdatacloudapi/js-reverse-geocode-client@latest/bigdatacloud_reverse_geocode.min.js" type="text/javascript"></script>
    <script src="../assets/js/livraisons.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDsIOetOqXmUutxkLiMQBQC3H98Gfd_sEg&libraries=&v=weekly"></script>
    <script src="../assets/manifest/js/app.js"></script>
    

    <script type="text/javascript">



   $('.locate').click(function(){
    $("#domModal").modal("show");
   if (navigator.geolocation) {  
    navigator.geolocation.getCurrentPosition(function(position) {
        var lat = position.coords.latitude;
        var long = position.coords.longitude;
        var accuracy = position.coords.accuracy;
   },
    function error(msg) {},
    {maximumAge:10000, timeout:5000, enableHighAccuracy: true});
} else {
    alert("Geolocation API is not supported in your browser.");
}
       
  });         


function setdom(){
 
   if (navigator.geolocation) {  
    navigator.geolocation.getCurrentPosition(function(position) {
        var lat = position.coords.latitude;
        var long = position.coords.longitude;
        var accuracy = position.coords.accuracy;
        
      
         
        
 $.ajax({
      url: 'setdom',
      type: 'post',
      data: {_token: CSRF_TOKEN,lat: lat, long:long},
      success: function(response){
         location.reload();
      },

     error: function(response){
     alert("une erreur s'est produite");
     }        

            
    });
       
    },
    function error(msg) {},
    {maximumAge:10000, timeout:5000, enableHighAccuracy: true});
} else {
    alert("Geolocation API is not supported in your browser.");
}

 
}


        

    $(".note").click( function() {
     var notes = $(this).data('notes');
     
     $("#noteViewModal").modal("show");
     
      $(".noteViewBody").html(notes);
                  
 });



        $("#d2").change(function(){
 if($(this).children("option:selected").val() == "RDV")
    {
      $("#rdv_date_div").removeAttr("hidden");
      $("#rdv_date").attr("required", "required");
    }
 else
    {
      $("#rdv_date_div").attr("hidden", "hidden");
      $("#rdv_date").removeAttr("required");
    }

if($(this).children("option:selected").val() == "Reporté par le client"){$("#report_date_div").removeAttr("hidden");$("#report_date").attr("required", "required");}
else{$("#report_date_div").attr("hidden", "hidden");$("#report_date").removeAttr("required");}


if($(this).children("option:selected").val() == "Adresse modifiée")
    {
      $("#new_adress_div").removeAttr("hidden");
      $("#new_fee").attr("required", "required");
      $("#new_adress").attr("required", "required");
    }
 else
    {
      $("#new_adress_div").attr("hidden", "hidden");
      $("#new_fee").removeAttr("required");
      $("#new_adress").removeAttr("required");
    }


    if($(this).children("option:selected").val() == "Autre")
    {
      $("#autre_div").removeAttr("hidden");
      $("#autre_detail").attr("required", "required");
    }
 else
    {
      $("#autre_div").attr("hidden", "hidden");
      $("#autre_detail").removeAttr("required");
    }

});




  
    </script>

    @if(session('note_message'))
<a hidden id="note_message" href="{{session('note_message')}}"></a>

<script type="text/javascript">



   $( document ).ready(function() {



    document.getElementById("note_message").click();
});


  
</script>
@endif


</body>

</html>