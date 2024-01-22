@extends("layouts.master")
@section("title")
{{$client->nom}}
@endsection
@section("content")

<style type="text/css">
   th { white-space: nowrap; }
   
</style>

<script
   src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDsIOetOqXmUutxkLiMQBQC3H98Gfd_sEg&callback=initMap&libraries=&v=weekly"
   defer
   ></script>


@foreach($errors->all() as $error)
{{$error}}
@endforeach
<div  class="row">
 <div style="overflow:auto; white-space: nowrap;  background-color: green;" >
         <button  style="font-size: 12px; background-color: black" class="mx-auto  font-weight-bold text-uppercase btn btn-sm   " 
         type="button">{{$total}}</button>

         <button id="dashboard_btn" style="font-size: 9px" class="mx-auto  font-weight-bold text-uppercase btn btn-sm  @if($state && $state == 'all') btn-outline-warning @else btn-outline-light @endif" 
         type="button">Tout {{$all_commands->count()}}</button>

          <button id="termine_btn" style="font-size: 9px" class="mx-auto font-weight-bold text-uppercase btn btn-sm align-middle @if($state && $state == 'termine') btn-outline-primary @else btn-outline-light @endif" type="button">Terminé {{$all_commands->where('etat', 'termine')->count()}}</button>

          <button id="enchemin_btn" style="font-size: 9px" class="mx-auto font-weight-bold text-uppercase btn btn-sm align-middle @if($state && $state == 'enchemin') btn-outline-warning @else btn-outline-light @endif" type="button">En chemin {{$all_commands->where('livreur_id', '!=', 11)->where('etat', 'en chemin')->count()}}</button>

          <button id="recupere_btn" style="font-size: 9px" class="mx-auto font-weight-bold text-uppercase btn btn-sm align-middle @if($state && $state == 'recupere') btn-outline-warning @else btn-outline-light @endif" type="button">Recuperé {{$all_commands->where('livreur_id', '!=', 11)->where('etat', 'recupere')->count()}}</button>
          
          <button id="encours_btn" style="font-size: 9px" class="mx-auto font-weight-bold text-uppercase btn btn-sm align-middle @if($state && $state == 'encours' && $attente && $attente != 'attente') btn-outline-warning @else btn-outline-light @endif" type="button">En cours {{$all_commands->where('livreur_id', '!=', 11)->where('etat', 'encours')->count()}}</button>
        
          <button id="enattente_btn" style="font-size: 9px" class="mx-auto font-weight-bold text-uppercase btn btn-sm align-middle @if($attente && $attente == 'attente') btn-outline-warning @else btn-outline-light @endif " type="button">En attente {{$all_commands->where('livreur_id', 11)->where('etat', '!=', 'annule')->where('etat','=', 'encours')->count()}}</button>
          
          <button id="annule_btn" style="font-size: 9px" class="mx-auto font-weight-bold text-uppercase btn btn-sm align-middle @if($state && $state == 'annule') btn-outline-primary @else btn-outline-light @endif" type="button">
          Annulé {{$all_commands->where('etat', 'annule')->count()}}
         </button>
      
      
     <button style="display: none; font-weight: bolder;" class="btn btn-danger btn-block add-button">
  Installer l'application Jibiat</button>
      
       
      </div>


<div  class="col-md-12">
<div class="card">
   <div class="content">
      <form hidden id='encours' action="dashboard" >
         @csrf
         <input type="text" name="route_day"  value="{{$day}}">
         <input type="text" name="state"  value="encours">
      </form>
      <form hidden id='enattente' action="dashboard" >
         @csrf
         <input type="text"  name="route_day" value="{{$day}}">
         <input type="text" name="state"  value="encours">
         <input type="text" name="attente"  value="encours">
      </form>
      <form hidden id="annule"  action="dashboard" >
         @csrf
         <input type="text"  name="route_day" value="{{$day}}">
         <input type="text" name="state"  value="annule">
      </form>
      <form hidden id='enchemin' action="dashboard" >
         @csrf
         <input type="text"  name="route_day" value="{{$day}}">
         <input type="text" name="state"  value="en chemin">
      </form>
      <form hidden id="recupere"  action="dashboard" >
         @csrf
         <input type="text"  name="route_day" value="{{$day}}">
         <input type="text" name="state"  value="recupere">
      </form>
      <form hidden id="termine"  action="dashboard" >
         @csrf
         <input  type="text" name="route_day" value="{{$day}}">
         <input type="text" name="state"  value="termine">
      </form>
      <form hidden id="dashboard"  action="dashboard" >
         @csrf
         <input  type="text" name="route_day" value="{{$day}}">

      </form>
      
      <div class="card-header">
      @if (session('status') && session('status'))
      <div class="alert alert-success" role="alert">
      {{ session('status') }}
      </div>
      @endif
      @if(session('new_id'))
      <div class="alert alert-danger" role="alert">         
      <h5>Numero de commande <strong>{{ session('new_id') }}</strong></h5>
       <div>
       <span class="dropdown">
      
      <button style="font-size: 9px; font-weight: bold; text-transform: uppercase;" class="btn btn-secondary  dropdown-toggle " type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
      Choisir un livreur 
      </button>
      <span class="dropdown-menu" aria-labelledby="dropdownMenuButton">
      <button class="dropdown-item showLivreur"  value="{{ session('new_id') }}" >
         <span  hidden="hidden" class="spinner-border spinner-border-sm spinner{{ session('new_id') }}" role="status" aria-hidden="true"></span><span class="sr-only"></span>
        @if($client->livreurs->count()>0)
      Choisir un livreur dans ma liste
      
      </button>@else
      <a class="dropdown-item" href="livreur">Ajouter des livreurs à votre liste</a>
      @endif
      <button class="dropdown-item nearByLivreur"  value="{{ session('new_id') }}" >Trouver un livreur à proximité</button>
      </span>
      </span>
       
       <span class="dropdown">
      <button style="font-size: 9px; font-weight: bold; text-transform: uppercase;" class="btn btn-secondary  dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
      Facture
      </button>
         <span class="dropdown-menu" aria-labelledby="dropdownMenuButton">
      <a class="dropdown-item"  href="sms:{{substr(preg_replace('/[^0-9]/', '', session('new_phone') ), 0, 8)}}?body=Votre commande {{ session('new_id') }} a été enregistrée. Cliquez ici pour voir le status : https://client.livreurjibiat.site/tracking/{{ session('new_id') }} {{$client->nom}}" ><i class="fas fa-sms"></i> envoyer facture</a>
      <a class="dropdown-item" href="#" onclick="CopyBill()"><i class="fas fa-copy"></i>Copier facture</a>
      </span>
      </span>
       </div>

      <strong> Inscrivez ce numero au marker sur votre colis(pas besoin d'autres information). </strong>
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
         alert("Lien de facture copié");
         
         document.getElementById("myInput").hidden = true;
         }
      </script>
      @endif
      <div class="card-title" style="width: 100%; margin-right: 0">
      <h6> 
      @if($day != "Aujourd'hui")
      {{date_create($day)->format('d-m-Y')}}
      @else
      {{$day}}
      @endif
      </h6> 
     
      <form  autocomplete="off" id="date-form" action='?bydate' >
      @csrf
      <div class="form-group date">
      <label  class="form-label">Choisir une date</label>
      <input placeholder="Date de livraison" value="{{$day}}" id="day" class="form-control" type="date" name="route_day">
      </div>
      </form>
      </div> 
      @if(session('phone_check'))
      <!-- Modal content-->
      <div class="alert alert-danger">
      ATTENTION
      Vous avez déja enregistré une  commande avec ce numéro aujourd'hui<br>
      <p><strong>{{session('phone')}}</strong></p>
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
      </div>

      <div style="font-weight: bold;" id="ncModal" class="modal fade" role="dialog">
      <div class="modal-dialog">
      <div class="modal-content">
      <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal">&times;</button>
      <h4 class="modal-title">Ajouter une commande</h4>
      </div>
      <div class="modal-body">
      <form  action="/command-fast-register" method="POST">
      @csrf
      <div class="form-group">
      <label class="form-label">Nature du colis</label>
      <input maxlength="150" required value="{{ old('type') }}" id="type" name="type" class="form-control" type="text" placeholder="Nature du colis" >
      </div>
      <div class="form-group">
      <label class="form-label">Date de livraison</label>
      <input 
         min="
         <?php
            echo date('Y-m-d');
            ?>
         " required type="date" value="{{ old('delivery_date') }}" name="delivery_date" class="form-control" type="text"  >
      @error('delivery_date')
      <span class="invalid-feedback" role="alert">
      <strong>{{ $message }}</strong>
      </span>
      @enderror
      </div>
      <div class="form-group"> 
      <label class="form-label">Prix(sans la livraison)</label>
      <input   value="{{ old('montant') }}"  name="montant" class="form-control @error('montant') is-invalid @enderror" type="number" placeholder="Prix (sans la livraison)" autocomplete="off">
      @error('montant')
      <span class="invalid-feedback" role="alert">
      <strong>{{$massage}}</strong>
      </span>
      @enderror
      </div>
      <div class="form-group">
      <label class="form-label">Ville/commune</label>
      <select  required id="fee"  class="form-control" name="fee">
      <option  value="">selectionner Une ville/commune</option>
      @foreach($fees as $fee)
      <option 
      @if(old('fee') == $fee->id) selected @endif
      value="{{$fee->id}}">{{$fee->destination}} : {{$fee->price}} CFA</option>
      <div id="fee_price"></div>
      @endforeach
      </select>
      @error('fee')
      <span class="invalid-feedback" role="alert">
      <strong>{{ $message }}</strong>
      </span>
      @enderror
      </div>
      <div class="form-group">
      <label class="form-label"> Précision sur l'adresse de livraison</label>
      <input maxlength="150" value="{{ old('lieu') }}" id="lieu" name="adresse" class="form-control" type="text" placeholder="Exemple: grand carrefour... pharmacie... rivera jardin..." >
      </div>
      <div class="form-group">
      <label class="form-label">Contact</label>
      <input value="{{ old('phone') }}" required  name="phone" class="form-control" type="number" placeholder="Numero du client sans l'indicatif(225)"  autocomplete="off">
      @error('phone')
      <span class="invalid-feedback" role="alert">
      <strong>{{ $message }}</strong>
      </span>
      @enderror         
      </div>
      <div class="form-group">
      <label  class="form-label"> Information supplementaire.</label>
      <input maxlength="150" value="{{ old('observation') }}"  name="observation" class="form-control" type="text" placeholder="Information supplementaire">
      </div>
      </div>
      <div class="modal-footer">
      <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
      <button type="submit" class="btn btn-success" >Confirmer</button>
      </div>
      </form>
      </div>
      </div>
      </div>
      <div  class="container box">
      @if($client->longitute != null & $client->latitude != null)
      <button type="button" onclick="setGeoloc()" >Définir comme votre adreese de ramassage</button>
      <div style="height:10rem; width: 100%;border-style: solid; border-width: 1px;" id="map"></div>
      @else
      <div  id="mapModal" class="modal fade" role="dialog">
      <div class="modal-dialog">
      <!-- Modal content-->
      <div style="height:15rem; width: 100%;" class="modal-content">
      <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal">&times;</button>
      <h4 class="modal-title">  </h4>
      <button type="button" onclick="setGeoloc()" >Définir comme votre adresse de ramassage</button>
      </div>
      <div style="height:10rem; width: 100%;border-style: solid; border-width: 1px;" id="map" class="modal-body">
      </div>
      </div>
      </div>
      </div>
      @endif
     <!--  <div>
      <button type="button" style="font-weight: bold;" class="btn btn-success "  data-toggle="modal" data-target="#ncModal" >Nouvelle<br> Commande</button>
      <div class="float-right card text-white badge-info mb-3 " style="width: 12rem;">
      <div class="card-header">Header</div> -->
      
      <!-- </div>
      </div> --> 




      <div style="font-weight: bold;" id="duplicateModal" class="modal fade" role="dialog">
      <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
      <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal">&times;</button>
      <h4 class="modal-title duplicateTitle"></h4>
      </div>
      <div class="modal-body duplicateBody">
      <form  action="/command-fast-register" method="POST"> 
      @csrf
      <div class="duplicateBody1">
      </div>
      <div class="form-group">
      <label class="form-label">Ville / Commune</label>
      <select  required   class="form-control duplicateFee" name="fee">
      <option   value="">selectionner Une ville/commune</option>
      @foreach($fees as $fee2)
      <option  
      
      value="{{$fee2->id}}">{{$fee2->destination}} : {{$fee2->price}} CFA</option>
      <div id="fee_price"></div>
     @endforeach
      </select>
      @error('fee')
      <span class="invalid-feedback" role="alert">
      <strong>{{ $message }}</strong>
      </span>
      @enderror
      </div>
      <div class="duplicateBody2">
      </div>
      </div>
      <div class="modal-footer">
      <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
      <button type="submit" class="btn btn-success" >Confirmer</button>
      </div>
      </form>
      </div>
      </div>
      </div>
      <!--  <a data-toggle="modal" data-target="#ncModal" style="color: blue;text-align: center;" href="#"><i class="fa  fa-plus"></i><br> Nouvelle<br> Commande</a> -->
      <!-- @if($payments_by_livreurs->count()>0)
      <p  style="color: red; font-weight: bold;">
      Vous avez 
      Des payment(s) non réglé
      <form   action="daily" id="due_form">
      @csrf
      <select style="color: white; font-weight: bold;" name="livreur_id" id='due_list' class="alert alert-danger form-control">
      <option disabled selected>Choisir un livreur pour faire son point</option>
      @foreach($payments_by_livreurs as $pay_by_liv)
      @if($pay_by_liv->montant>0)
      @foreach($livreurs as $livreur3)
      @if($livreur3->id == $pay_by_liv->livreur_id)
      <option value="{{$pay_by_liv->livreur_id}}">{{$livreur3->nom}} - {{$pay_by_liv->montant}} CFA impayé</option>
      @endif
      @endforeach
      @endif
      @endforeach
      @foreach($livreurs as $livreur5)
      @if($pay_by_liv->livreur_id != $livreur5->id)
      <option value="{{$livreur5->id}}">{{$livreur5->nom}} </option>
      @endif
      @endforeach
      </select>
      </p>
      </form> 
      @else
      <p  style="font-weight: bold;">
      Liste de vos livreurs
      <form   action="daily" id="due_form">
      @csrf
      <select style="font-weight: bold;" name="livreur_id" id='due_list' class=" form-control">
      <option disabled selected>Choisir un livreur pour voir son point</option>
      @foreach($livreurs as $livreur5)
      <option value="{{$livreur5->id}}">{{$livreur5->nom}} </option>
      @endforeach
      </select>
      </p>
      </form> 
      </div>
      @endif
      <div>--> 
      <div class="input-group md-form form-sm form-1 pl-0">
      <div class="input-group-prepend">
      <span class="input-group-text purple lighten-3" id="basic-text1"><i class="fas fa-search text-dark"
         aria-hidden="true"></i></span>
      </div>
      <input onkeyup="myFunction()" id="Search" class="form-control my-0 py-1" type="text" style="font-weight: bold;" placeholder="Recherche" aria-label="Search">
      </div>           
      @if($commands->count()>0)     
      
      
      @foreach($commands as $command)
  <div  class="card target" style="width: 100%;border-style: solid; border-width: 1px;">
      <ul  class="list-group list-group-flush">
         
      <li  class="pt-6 list-group-item">
      <div ><strong>#{{$command->id}}</strong> <span 
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
      
      <span >
      @if($command->ready == NULL)
      <span hidden id="unready2_{{$command->id}}" >
      <img width="30" height="30" src="/assets/img/packing.ico">
      <button style="font-size: 9px; font-weight: bold; text-transform: uppercase;"  data-cur="ready_{{$command->id}}"  data-sp="unready2_{{$command->id}}" value="no" data-id="{{$command->id}}"  class=" ready btn btn-dark btn-sm">Pas prêt?</button>
      </span>
      <span   id="ready_{{$command->id}}" >
      <button style="font-size: 9px; font-weight: bold; text-transform: uppercase;"  data-sp="ready_{{$command->id}}" data-cur="unready2_{{$command->id}}" value="yes" data-id="{{$command->id}}" class=" ready btn  btn-sm">Commande Prête?</button>
      </span>
      @else
      <span hidden id="ready2_{{$command->id}}" >
      <button style="font-size: 9px; font-weight: bold; text-transform: uppercase;" data-cur="unready_{{$command->id}}" data-sp="ready2_{{$command->id}}" value="yes"  data-id="{{$command->id}}" class=" ready btn btn-dark btn-sm">Commande Prête?</button>
      </span>
      <span id="unready_{{$command->id}}"  >
      <img width="30" height="30" src="/assets/img/packing.ico">
      <button style="font-size: 9px; font-weight: bold; text-transform: uppercase;" data-cur="ready2_{{$command->id}}" data-sp="unready_{{$command->id}}" value="no" data-id="{{$command->id}}"  class=" ready btn btn-dark btn-sm">Pas prêt?</button>
      </span>
      @endif
   </span>



</div>
      <div>
        <strong>{{$command->description}}</strong> <br>
        {{$command->adresse}} <br>
        Montant: {{$command->montant}}CFA<br>
         
         
   
      </div>
      
         <span id="cur_liv{{$command->id}}">
      @if($command->livreur_id != 11)
   <i class="fa fa-bicycle"></i> {{substr($command->livreur->nom, 0, 30)}}@if(strlen($command->livreur->nom>31))...@endif
   @if($command->note->count()>0)
      <a  data-toggle="modal" data-target="#noteViewModal{{$command->id}}" href=""> <i class="fa fa-sticky-note" >Note de livraison</i></a>
      @endif
   <br>
      
     
      @endif
      </span>
      @if($command->observation)
      <span style="color: green">{{$command->observation}}</span>
      @endif
         <div>
       


         @if($command->etat == 'encours')
      @if($client->livreurs->count()>0)
      <span class="dropdown">
      
      <button style="font-size: 13px; font-weight: bold; text-transform: uppercase; color: green" class="btn btn-outline-success   dropdown-toggle " type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span  hidden="hidden" class="spinner-border spinner-border-sm spinner{{$command->id}}" role="status" aria-hidden="true"></span><span class="sr-only"></span>
      Livreur 
      </button>
      <span class="dropdown-menu" aria-labelledby="dropdownMenuButton">
      <button class="dropdown-item showLivreur"  value="{{$command->id}}" >
       

         @if($command->livreur->id == 11)
      Choisir un livreur dans ma liste
      @else
      Choisir un autre livreur
      @endif</button>@else
      <a class="dropdown-item" href="livreur">Ajouter des livreurs à votre liste</a>
      @endif
      <button class="dropdown-item nearByLivreur"  value="{{$command->id}}" >Trouver un livreur à proximité</button>
      </span>
      </span>

      
      @endif

         <span class="dropdown">
      
      <button style="font-size: 13px; font-weight: bold; text-transform: uppercase; color: green" class="btn btn-outline-success dropdown-toggle " type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
      Facture
      </button>
      <span class="dropdown-menu dropdown-menu-right " aria-labelledby="dropdownMenuButton">
      <a class="dropdown-item"  href="sms:{{substr(preg_replace('/[^0-9]/', '',$command->phone), 0, 8)}}?body=Votre commande {{$command->id}} a été enregistrée. Cliquez ici pour voir le status : https://client.livreurjibiat.site/tracking/{{$command->id}} {{$client->nom}}" ><i class="fas fa-sms"></i> envoyer facture</a>
      <a class="dropdown-item" href="#" onclick="CopyBill{{$command->id}}()"><i class="fas fa-copy"></i>Copier facture</a>
      </span>
      </span>



       <span  class="btn-group dropup float-right">
         <button  class="btn btn-outline-light btn-sm " id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
         <svg style="color: black"  width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-three-dots-vertical" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
  <path fill-rule="evenodd" d="M9.5 13a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z"/>
</svg>
</button>

<span class="dropdown-menu dropdown-menu-right " aria-labelledby="dropdownMenuButton">

         @if($command->etat == 'encours' || $command->etat == 'recupere' || $command->etat == 'en chemin')
      <form id="cancelForm{{$command->id}}" hidden class="form-inline" action="/cancel" method="POST">
      @csrf
      <input value="{{$command->id}}" type="text" name="id" hidden>
      <input type="text" value="yes" name="cancel" hidden>
      </form>
      
      <a onclick="submitActive{{$command->id}}()" id="sbmtActivate{{$command->id}}"  href="#" class="dropdown-item"><i class="fa fa-fw fa-window-close"></i> Annuler</a>

      <a class=" dropdown-item" onclick="submitReset{{$command->id}}()" id="sbmtActivate{{$command->id}}"  href="#"><i class="fa  fa-retweet"></i> Reinitiliser</a>
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
      <a onclick="submitCancel{{$command->id}}()" id="sbmtCancel{{$command->id}}"  href="#" class="dropdown-item"><i class="fa  fa-power-off"></i> Activer</a>
      <script type="text/javascript">
         function submitCancel{{$command->id}}(){
           document.getElementById("activateForm{{$command->id}}").submit();
         }
         
         
      </script>
      @endif
   


        


        <a data-desc="{{$command->description}}" data-id="{{$command->id}}" data-date="{{$command->delivery_date->format('Y-m-d')}}" data-montant="{{$command->montant}}" data-fee="{{$command->fee_id}}" data-adrs="{{str_replace($command->fee->destination.':','',$command->adresse)}}" data-phone="{{$command->phone}}" data-observation="{{$command->observation}}"  class="edit  dropdown-item" href="#"><i class="fa fa-fw fa-edit"></i> Modifier </a>


       <a class="duplicate dropdown-item" data-desc2="{{$command->description}}" data-id2="{{$command->id}}" data-date2="{{$command->delivery_date->format('Y-m-d')}}" data-montant2="{{$command->montant}}" data-fee2="{{$command->fee_id}}" data-adrs2="{{str_replace($command->fee->destination.':','',$command->adresse)}}" data-phone2="{{$command->phone}}" data-observation2="{{$command->observation}}"   href="#"><i class="fa  fa-clone "></i> Dupliquer</a>
      
      
     
       <a  href="tel:{{$command->phone}}" class="dropdown-item"><i class="fa fa-phone"></i>Appeler client</a>
       <a  href="tel:{{$command->livreur->phone}}" class="dropdown-item"><i class="fa fa-phone"></i>Appeler livreur</a>     
   
      </span>
      </span>
   </div>
      </li>
     
      @if($command->etat != 'annule')
      <input hidden="hidden" type="text" value="Votre commande {{$command->id}} a été enregistrée. Cliquez ici pour voir le status : https://client.livreurjibiat.site/tracking/{{$command->id}}  - {{$client->nom}}" id="myInput{{$command->id}}">
      <script type="text/javascript">
         function CopyBill{{$command->id}}(){
         
          /* Get the text field */
         
         document.getElementById("myInput{{$command->id}}").hidden = false;
         var copyText = document.getElementById("myInput{{$command->id}}");
         
         /* Select the text field */
         
         copyText.select();
         copyText.setSelectionRange(0, 99999); /*For mobile devices*/
         
         /* Copy the text inside the text field */
         document.execCommand("copy");
         
         /* Alert the copied text */
         alert("Lien de facture copié");
         
         document.getElementById("myInput{{$command->id}}").hidden = true;
         }
      </script>
      @endif
      
     
     
      </ul>
      </div>
      @if($command->note->count()>0)
      <div  id="noteViewModal{{$command->id}}" class="modal fade" role="dialog">
      <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
      <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal">&times;</button>
      <h4 class="modal-title">Note: {{$command->id}} ({{$command->note->count()}}) </h4>
      </div>
      <div class="modal-body">
      @foreach( $command->note->sortByDesc('created_at')  as $one)
      <p><strong>{{$one->updated_at->format('d-m-Y')}}</strong> - {{$one->updated_at->format('H:i:s')}} - {{$one->description}}  </p>
      @endforeach  
      </div>
      </div>
      </div>
      </div>
      @endif
      @endforeach
     
      







 





       
  


      
      {{ $commands->links() }}
      @else
      <div  class="card target" style="width: 100%;border-style: solid; border-width: 1px;">
      <ul  class="list-group list-group-flush">
         
      <li  class="pt-6 list-group-item">
      
      Vous n'avez aucune commande 
      
   </li>
</ul>
      </div>
    
      @endif


   <div id="editModal" class="modal fade" role="dialog">
      <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
      <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal">&times;</button>
      <h4 class="modal-title editTitle"></h4>
      </div>
      <div class="modal-body editBody">
      <form  action="/command-update" method="POST"> 
      @csrf
      <div class="editBody1">
      </div>
      <div class="form-group">
      <label class="form-label">Ville / Commune</label>
      <select  required id="fee3"  class="form-control editFee" name="fee">
      <option   value="">selectionner Une ville/commune</option>
      @foreach($fees as $fee)
      <option  
     
      value="{{$fee->id}}">{{$fee->destination}} : {{$fee->price}} CFA</option>
      <div id="fee_price"></div>
      @endforeach
      </select>
      @error('fee')
      <span class="invalid-feedback" role="alert">
      <strong>{{ $message }}</strong>
      </span>
      @enderror
      </div>
      <div class="editBody2">
      </div>
      </div>
      <div class="modal-footer">
      <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
      <button type="submit" class="btn btn-success" >Confirmer</button>
      </div>
      </form>
      </div>
      </div>
      </div>

   <div id="payModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
      <h6 class="modal-title ">Payements</h6>
      
      </div>
      <div class="modal-body">
      <span hidden="hidden" class="payReturn"><button type='button' class='btn btn-warning btn-sm returnPay' ><span hidden="hidden"   class="spinner-border spinner-border-sm returnPaySpinner" role="status" aria-hidden="true"></span><span class="sr-only"></span>
      Revenir à la liste des payements</button></span><br>
       <span class="payLivreur"></span> <span class="payTotal float-right"></span>
      </div>
      <div class="modal-body payBody">
      <span  hidden="hidden" class="spinner-border  paySpinner" role="status" aria-hidden="true"></span><span class="sr-only"></span>
      </div>
      
    
    </div>
   </div>
   <button type="button" class="btn btn-default float-right" data-dismiss="modal">Fermer</button>
</div>

      <div id="cmdRtrnModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
      
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
      <h6 class="modal-title ">Liste des RETOURS</h6>
      
      </div>
      <div class="modal-body">
      <span hidden="hidden" class="cmdRtrnReturn"><button type='button' class='btn btn-info btn-sm cmdRtrnBack' ><span hidden="hidden"   class="spinner-border spinner-border-sm cmdRtrnReturnSpinner" role="status" aria-hidden="true"></span><span class="sr-only"></span>
      Revenir à la liste des retours</button></span><br>
       <span class="cmdRtrnLivreur"></span> <span class="cmdRtrnTotal float-right"></span>
      </div>
      <div class="modal-body cmdRtrnBody">
      <span  hidden="hidden" class="spinner-border  cmdRtrnSpinner" role="status" aria-hidden="true"></span><span class="sr-only"></span>
      </div>
      
    
    </div>
   </div>
   <button type="button" class="btn btn-default float-right" data-dismiss="modal">Fermer</button>
</div>

     <div  id="position" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 style="color: green" class="modal-title"><i class="fa fa-map-marker-alt"></i> Veuillez d'abord activer votre GPS pour utiliser cette fonctinalité</h4>
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





    <div  id="LivChoice" class="modal fade" role="dialog">
      <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
      <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal">&times;</button>
      <h6 class="top modal-title">  </h6>
      </div>
      <div class="LivChoiceBody modal-body">
      </div>
      </div>
      </div>
      </div>





      </div>
   </div>



 <nav style="margin-bottom: 0; " class="fixed-bottom navbar navbar-expand-lg navbar-light bg-light">

  <a href="#" style="text-align: center; color: black;" class="cmdRtrn">
        <i class="fa fa-undo-alt" aria-hidden="true">@if($undone_by_livreurs->count()>0)<span style="color: red"> {{$undone_by_livreurs->count()}}</span>@endif</i>  <br>     
Retours 
    </a>   



    
  
<a  href="#" style="text-align: center;color: black" data-toggle="modal" data-target="#ncModal">

   <i style="size:20px" class="fa fa-plus" aria-hidden="true"></i> <br>

 Commandes
 </a>

            

   <a href="#" class="pay"  style="text-align: center;color: black" >
   <i class="fa fa-dollar-sign" aria-hidden="true">@if($payments_by_livreurs->count()>0) <span style="color: red"> {{$payments_by_livreurs->count()}}</span>

@endif </i> <br>      
Payements

    </a>


</nav>




</div>

<div id="singlePayScript">
         
</div>

<div id="cmdRtrnScript">
         
</div>
@endsection
@section("script")
<script type="text/javascript">
   
   var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
   $(".pay").click( function() {
   
  
   $("#payModal").modal("show");
   
   $(".paySpinner").removeAttr('hidden');


     $.ajax({
       url: 'currentpay',
       type: 'post',
       data: {_token: CSRF_TOKEN},
   
       success: function(response){
                $(".payLivreur").html('');
              $(".payTotal").html('');
                 $(".payReturn").attr('hidden', 'hidden');
                $(".paySpinner").attr('hidden', 'hidden');
                $(".payBody").html(response.payed_field);
                
              },
   error: function(response){
               
                alert("Une erruer s'est produite");
              }
             
     });
   });




   $(".cmdRtrn").click( function() {
   
   
   $("#cmdRtrnModal").modal("show");
   
   $(".cmdRtrnSpinner").removeAttr('hidden');
  
    $(".cmdRtrnLivreur").html('');
    $(".cmdRtrnTotal").html('');

     $.ajax({
       url: 'cmdrtrn',
       type: 'post',
       data: {_token: CSRF_TOKEN},
   
       success: function(response){
                $(".cmdRtrnSpinner").attr('hidden', 'hidden');
                $(".cmdRtrnBody").html(response.cmd_return );
                
              },
   error: function(response){
               
                alert("Une erruer s'est produite");
              }
             
     });
   });


   $(".cmdRtrnBack").click( function() {
   
   $('.cmdRtrnReturn').attr('hidden', 'hidden');
   $("#cmdRtrnModal").modal("show");
   
   $(".cmdRtrnSpinner").removeAttr('hidden');
   $(".cmdRtrnReturnSpinner").removeAttr('hidden');
    $(".cmdRtrnLivreur").html('');
    $(".cmdRtrnTotal").html('');

     $.ajax({
       url: 'cmdrtrn',
       type: 'post',
       data: {_token: CSRF_TOKEN},
   
       success: function(response){
                $(".cmdRtrnSpinner").attr('hidden', 'hidden');
                $(".cmdRtrnReturnSpinner").attr('hidden', 'hidden');
                $(".cmdRtrnBody").html(response.cmd_return );
                
              },
   error: function(response){
               
                alert("Une erruer s'est produite");
              }
             
     });
   });















   $(".returnPay").click( function() {
   
  
   
   
   $(".returnPaySpinner").removeAttr('hidden');
   
    $(".payLivreur").html('');
    $(".payTotal").html('');
     $.ajax({
       url: 'currentpay',
       type: 'post',
       data: {_token: CSRF_TOKEN},
   
       success: function(response){
                $(".returnPaySpinner").attr('hidden', 'hidden');
                $(".payReturn").attr('hidden', 'hidden');
                $(".payBody").html(response.payed_field);
                
              },
   error: function(response){
               
                alert("Une erruer s'est produite");
              }
             
     });
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
   
   $('.duplicateBody1').html(' <div class="form-group"> <label class="form-label">Nature du colis</label><input required value="'+description+'" id="type" name="type" class="form-control" type="text" placeholder="Nature du colis" ></div><input value="'+id+'" hidden name="command_id"><div class="form-group"><label class="form-label">Date de livraison<input  required type="date" value="'+date+'" name="delivery_date" class="form-control" type="text" ></label> @error("delivery_date")<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span> @enderror  </div> <div class="form-group"><label class="form-label">Prix(sans la livraison)</label><input  value="'+montant+'"  name="montant" class="form-control @error("montant") is-invalid @enderror" type="text" placeholder="Prix(sans la livraison)"> @error("montant")<span class="invalid-feedback" role="alert"><strong>{{$massage}}</strong></span>@enderror </div>')
   
   $('.duplicateBody2').html('<div class="form-group"><label class="form-label">Précision sur l\'adresse de livraison</label><input value="'+adresse+'" id="lieu" name="adresse" class="form-control" type="text" placeholder="Exemple: grand carrefour... pharmacie... rivera jardin..." ></div><div class="form-group"><label class="form-label">Contact(ex: 07000000)</label><input value="'+phone+'" required  name="phone" class="form-control" type="text" placeholder="Contact du client"> @error('phone')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror </div><div class="form-group"><label class="form-label"> Information supplementaire.</label><input maxlength="150"   name="observation" class="form-control" type="text" placeholder="Information supplementaire"></div></div>')
   
   $(".duplicateFee").val(fee);
   $('.duplicateTitle').html('Nouvelle Commande')
   
   $("#duplicateModal").modal('show');
   
   
   });



   function myFunction() {
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
}
   // Note: This example requires that you consent to location sharing when
   // prompted by your browser. If you see the error "The Geolocation service
   // failed.", it means you probably did not give permission for the browser to
   // locate you.
   let map, infoWindow;
   
   function initMap() {
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
     alert('succes');
    
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
   
     
    
   $(".edit").click( function() {
   var description = $(this).data('desc');
   var date = $(this).data('date');
   var montant = $(this).data('montant');
   var fee = $(this).data('fee');
   var adresse = $(this).data('adrs');
   var phone = $(this).data('phone');
   var id = $(this).data('id');
   var observation = $(this).data('observation');
   
   $('.editBody1').html(' <div class="form-group"> <label class="form-label">Nature du colis</label><input required value="'+description+'" id="type" name="type" class="form-control" type="text" placeholder="Nature du colis" ></div><input value="'+id+'" hidden name="command_id"><div class="form-group"><label class="form-label">Date de livraison<input  required type="date" value="'+date+'" name="delivery_date" class="form-control" type="text" ></label> @error("delivery_date")<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span> @enderror  </div> <div class="form-group"><label class="form-label">Prix(sans la livraison)</label><input type"numric"  value="'+montant+'"  name="montant" class="form-control @error("montant") is-invalid @enderror" type="text" placeholder="Prix(sans la livraison)"> @error("montant")<span class="invalid-feedback" role="alert"><strong>{{$massage}}</strong></span>@enderror </div>')
   
   $('.editBody2').html('<div class="form-group"><label class="form-label">Précision sur l\'adresse de livraison</label><input value="'+adresse+'" id="lieu" name="adresse" class="form-control" type="text" placeholder="Exemple: grand carrefour... pharmacie... rivera jardin..." ></div><div class="form-group"><input value="'+phone+'" required  name="phone" class="form-control" type="text" placeholder="Contact du client"> @error('phone')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror </div><div class="form-group"><label class="form-label"> Information supplementaire.</label><input maxlength="150" value="'+observation+'"  name="observation" class="form-control" type="text" placeholder="Information supplementaire"></div></div>')
   
   $(".editFee").val(fee);
   $('.editTitle').html('Modifier commande '+ id)
   
   $("#editModal").modal('show');
   
   
   });
   
   
   
   
   
   
     
   
   
   
   $(".showLivreur").click( function() {
   var cmd_id = $(this).val();
   
    
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
   
   


  
   
   
   
   
   
   
   
   
   $(".ready").click( function() {
   var cmd_id = $(this).data('id');
   var ready = $(this).val();
   var cur_stt = $(this).data('cur');
   
   var current = $(this).data('sp');
   
   var current = $("#"+current);
   
   var current_state = $("#"+cur_stt);
   
   
   
   
     $.ajax({
       url: 'ready',
       type: 'post',
       data: {_token: CSRF_TOKEN,cmd_id: cmd_id,ready: ready},
       success: function(response){
         
          alert(response.message);
       (current_state).attr('hidden', null);
        (current).attr("hidden", "hidden");
   
      }
     });
   });  
   
   
   
   
   
     $("#enattente_btn").click(function(){
   $("#enattente").submit();
   });
   
     $("#encours_btn").click(function(){
   $("#encours").submit();
   });
   
   
     $("#termine_btn").click(function(){
   $("#termine").submit();
   });
   
     $("#annule_btn").click(function(){
   $("#annule").submit();
   });
   
   
   $("#dashboard_btn").click(function(){
   $("#dashboard").submit();
   }); 
   
   
   $("#enchemin_btn").click(function(){
   $("#enchemin").submit();
   }); 
   
   
   $("#recupere_btn").click(function(){
   $("#recupere").submit();
   });  
   
   
   
   
   
   
   
     // $('#myTable').DataTable(  {
   
      
   
   
         
     // }  );
   
   
   
   
        
   
   
         $("#day").change(function(){
   $("#date-form").submit();
   });
   
   
   $("#due_list").change(function(){
   $("#due_form").submit();
   });       
   
       
   
 
   
   
   
   
   
   
   
   
</script>
@if (isset($update_error) && update_error == 'yes')
<script>
   $( document ).ready(function() {
       $('.editModal').modal('show');
   });
</script>
@endif
@endsection