<!doctype html>

<html lang="fr">



<head>

    <meta charset="utf-8" />

    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="csrf-token" content="{{ csrf_token() }}">

     <meta name="viewport"

        content="width=device-width, viewport-fit=cover" />

    <meta name="description" content="Jibiat - Système de gestion pour vendeur en ligne">

    <meta name="keywords" content="vendeur en ligne, livraison, livreur" />

    <title>Course</title>

     <link rel="stylesheet" type="text/css" href="https://unpkg.com/ionicons@4.5.10-0/dist/css/ionicons.min.css">

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" >

    <link rel="stylesheet" href="../assets/css/style.css">

     <link rel="stylesheet" href="../assets/css/bootstrap-switch-button.min.css">

     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />

      

      <link rel="apple-touch-icon" sizes="180x180" href="assets/img/apple-touch-icon.png">

    <link rel="icon" type="image/png" href="../assets/img/favicon.png" sizes="32x32">

    <link rel="shortcut icon" href="../assets/img/favicon.png">

   

     <link rel = " manifest " href="../assets/manifest/client.json">

   

   <!-- ios support -->

    <link rel="apple-touch-icon" href="../assets/manifest/img/logo-icon.png" />

     <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

 

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css">   

 

<style>

  .toggle.ios, .toggle-on.ios, .toggle-off.ios { border-radius: 20px; }

  .toggle.ios .toggle-handle { border-radius: 20px; }



  .stamp {

  transform: rotate(12deg);

    color: #555;

    font-size: 1rem;

    font-weight: 700;

    border: 0.25rem solid #555;

    display: inline-block;

    padding: 0.25rem 1rem;

    text-transform: uppercase;

    border-radius: 1rem;

    font-family: 'Courier';

    -webkit-mask-image: url('https://s3-us-west-2.amazonaws.com/s.cdpn.io/8399/grunge.png');

  -webkit-mask-size: 944px 604px;

  mix-blend-mode: multiply;

}



.is-approved {

    color: #0A9928;

    border: 0.5rem solid #0A9928;

    -webkit-mask-position: 13rem 6rem;

    transform: rotate(-14deg);

  border-radius: 0;

} 

</style>

</head>


<body>



   <script src="https://unpkg.com/axios/dist/axios.min.js"></script>

 <script src="https://unpkg.com/vue@3"></script> 

    <div  id="app">

    

   <div class="modal fade" id="modal-success" role="dialog">

<div class="modal-dialog">

<div class="modal-content bg-success">

<div class="modal-header">

<h4 class="modal-title">Nouvelle course!</h4>

<button type="button" class="close" data-dismiss="modal" aria-label="Close">

<span aria-hidden="true">×</span>

</button>

</div>

<form action="assign" method="post">

<div class="modal-body ">

    <div class="successBody">

        

    </div>



    <div class="form-group">

        <label>Assigner</label>

        <select name="livreur_id" required class="form-control">

            <option :value="livreur.id" v-for="livreur in deliverymen">@{{livreur.nom}}</option>

        </select>

    </div>

    <div>

        <button class="btn btn-primary" type="submit">Assigner</button>

    </div>



</div>

</form>

<div class="modal-footer justify-content-between successFooter">

<button type="button" class="btn btn-outline-light" data-dismiss="modal">Fermer</button>

<a href="" class="btn btn-outline-light">Actualiser la page</a>

</div>

</div>



</div>



</div>

<audio id="myAudio" >

  <source src="notify.wav" type="audio/wav">

 

  Your browser does not support the audio element.

</audio>



        <div class="modal fade dialogbox" id="stateModal" data-backdrop="static" tabindex="-1" role="dialog">

            <div class="modal-dialog" role="document">

                <div class="modal-content">

                    <div class="modal-header">

                        <button type="button" class="close" data-dismiss="modal">&times;</button>

                        <h5 class="modal-title"></h5>

                       



                    </div>

                    

                    <div class="modal-body" id="stateModalBody">

                         Action effectuee: @{{ successText }}

                    </div>

                   

                </div>

            </div>

        </div>

         

         <div class="modal fade " id="dateModal" tabindex="-1" role="dialog">

            <div class="modal-dialog" role="document">

                <div class="modal-content">

                    <div class="modal-header">

                        <h5 class="modal-title">Date</h5>

                    </div>

                    <div class="modal-body">

                        <div class="action-sheet-content">

                            

                                <div class="form-group basic">

                                    <div class="input-wrapper">

                                        <form  autocomplete="off"  action='?bydate' >

                                         @csrf

                                         <div  class="form-group ">

                                         

                                         <input  hidden value='{{date("Y-m-d",strtotime("yesterday"))}}'   class="form-control " type="date" name="start">

                                         <input  hidden value='{{date("Y-m-d",strtotime("yesterday"))}}'   class="form-control " type="date" name="end">

                                         <button type="submit" class="btn btn-outline-primary btn-block "   >Hier</button>



                                        </div>

                                         </form>



                                         <form  autocomplete="off"  action='?' >

                                         @csrf

                                         <div  class="form-group ">

                                         

                                         <input  hidden value='{{date("Y-m-d",strtotime("today"))}}'   class="form-control " type="date" name="start">

                                         <input  hidden value='{{date("Y-m-d",strtotime("today"))}}'   class="form-control " type="date" name="end">

                                         <button type="submit" class="btn btn-outline-warning btn-block "   >Aujourd'hui</button>



                                        </div>

                                         </form>

                                        

                                        <form  autocomplete="off"  action='?' >

                                         @csrf

                                         <div  class="form-group ">

                                         

                                         <input hidden value='{{date("Y-m-d",strtotime("tomorrow"))}}'    class="form-control "  name="start">

                                         <input hidden value='{{date("Y-m-d",strtotime("tomorrow"))}}'    class="form-control "  name="end">

                                         <button class="btn btn-outline-success btn-block " type="submit"  >Demain</button>



                                        </div>

                                         </form>

                                       

                                    </div>

                                </div>

                                <div>

                              <form autocomplete="off" id="date-form" action="?">

                                @csrf

                                <div class="form-group basic">

                                    <div class="input-wrapper">

                                        <label class="label" for="text11d">Choisir une date</label>

                                       

                                         <div  class="form-row">

                                         <div class="col">

                                         <input v-model="costumStart" value=""  class="form-control"type="date" name="start">

                                         

                                         </div>

                                         <div class="col">

                                            <button class="btn btn-primary btn-sm">Valider</button> 

                                         </div>

                                         

                                         <input hidden id="costumEnd" :value="costumStart"  class="form-control" 

                                          

                                         type="date" name="end">



                                        </div>

                                        

                                    </div>

                                </div>

                             </form>

                             </div>



                             <form autocomplete="off" id="date-form" action="?">

                                @csrf

                                <div class="form-group basic">

                                    <div class="input-wrapper">

                                        <label class="label" for="text11d">Choisir un interval</label>

                                       

                                         <div  class="form-row">

                                         

                                         <div class="col">

                                         <input v-model="intStart" value=""  class="form-control" 

                                        

                                         type="date" name="start">

                                          </div>

                                          <div class="col">

                                         <input :disabled="!intStart" :min="intStart"  class="form-control" 

                                          

                                         type="date" name="end">

                                        </div>

                                       

                                        </div>

                                        <button class="btn btn-primary btn-sm">Valider</button> 

                                    </div>

                                </div>

                             </form>

                                



                                

                            

                        </div>

                    </div>

                </div>

            </div>

        </div>

      



        <div class="modal fade" id="filterModal" tabindex="-1" role="dialog">

            <div  class="modal-dialog" role="document">

                <div  class="modal-content">

                    <div class="modal-header">

                        

                        <h5 class="modal-title">Filtrer</h5>

                      

                        <a href="javascript:;" data-dismiss="modal">Fermer</a>

                    </div>

                    <div   class="modal-body">

                        <div class="action-sheet-content ">

                            <form action="?">

                                <div hidden>

                                     <input value="{{$state}}" type="text" name="state">

                                       <input value="{{$start}}" type="text" name="start">

                                    <input value="{{$end}}"  type="text" name="end">

                                    <input type="" name="filter">

                                </div>

                                    

                                

                            @if($livreurs->count() > 0)

                          <div class="form-group">

                            <label class="form-label ">Filtrer par livreur</label>

                              <select data-style="btn-dark" v-model="livreurs" title="Choisir livreurs..." id="livreur-select" class="selectpicker form-control" multiple  name="livreurs[]">

                               

                                 @foreach($livreurs as $livreur)

                                  <option value="{{$livreur->id}}">{{$livreur->nom}}</option>

                                 @endforeach

                                 </select>

                                 @error('livreur')

                                   <span class="invalid-feedback" role="alert">

                               <strong>{{ $message }}</strong>

                                </span>

                              @enderror

                          </div>

                          @endif



                           <div class="form-group">

                            <label class="form-label">Filter par commune</label>

                              <select data-style="btn-dark" v-model="fees" title="Choisir communes..." id="fee-select" class=" selectpicker form-control" multiple  name="fees[]">

                               

                                 @foreach($fees as $fee)

                                  <option value="{{$fee->id}}">{{$fee->destination}}</option>

                                 @endforeach

                                 </select>

                                 @error('fee')

                                   <span class="invalid-feedback" role="alert">

                               <strong>{{ $message }}</strong>

                                </span>

                              @enderror



                          </div>



                        @if($command_roles->contains("action", "R_ALL"))

                         <div class="form-group">

                            <label class="form-label">Filter par client</label>

                              <select data-style="btn-dark" v-model="providers" title="Tous les clients" id="provider-select" class=" selectpicker form-control" multiple  name="providers[]">

                                

                                 @if($providers->count() > 0)

                                 @foreach($providers as $prov)

                                  <option value="{{$prov->id}}">{{$prov->nom}}</option>

                                 @endforeach

                                 @endif

                                 </select>

                                



                          </div>

                          @endif

                          <div class="form-group">

                            <label class="form-label">Filtrer par Etat</label>

                              <select data-style="btn-dark" v-model="etats" title="Choisir etat(s)..." id="state-select" class="selectpicker form-control" multiple="multiple" data-placeholder="selectionner commune(s)" name="etats[]">

                               

                                

                                  <option value="encours">Encours</option>

                                  <option value="recupere">Récuperé</option>

                                   <option value="en chemin">En chemin</option>

                                   <option value="termine">Livré</option>

                                   <option value="annule">Annulé</option>

                                

                                 </select>

                                

                          </div>



                          <button :disabled="livreurs.length == 0 && fees.length == 0 && providers.length == 0 && etats.length == 0"  class="btn btn-primary btn-block">Filtrer</button>

                          </form>

                        </div>

                    </div>

                </div>

            </div>

        </div>





        <div class="modal fade modalbox  " id="checkoutModal" tabindex="-1" role="dialog">

            <div  class="modal-dialog" role="document">

                <div  class="modal-content">

                    <div class="modal-header">

                        

                        <h5 class="modal-title">Faire le point complet</h5>

                        

                        <a href="javascript:;" data-dismiss="modal">Fermer</a>

                    </div>

                    <div   class="modal-body">

                        <div class="action-sheet-content ">

                            <form action="checkout" >

                               

                                    

                                

                            @if($client->livreurs->count() > 0)

                          <div class="form-group">

                            <label class="form-label ">Choisir un livreur pour faire son point</label>

                              <select v-model="livreur2" data-style="btn-dark"   class="form-control"   name="livreur">

                               

                                 @foreach($client->livreurs as $livreur)

                                  <option value="{{$livreur->id}}">{{$livreur->nom}}</option>

                                 @endforeach

                                 </select>

                                 @error('livreur')

                                   <span class="invalid-feedback" role="alert">

                               <strong>{{ $message }}</strong>

                                </span>

                              @enderror

                          </div>

                          @endif







                          

                          <button :disabled="livreur2 == ''" class="btn btn-primary btn-block">Faire le point complet</button>

                          </form>

                        </div>

                    </div>

                </div>

            </div>

        </div>

     

      <div class="modal fade modalbox" id="etatModal" data-backdrop="static" tabindex="-1" role="dialog">

            <div class="modal-dialog" role="document">

                <div class="modal-content">

                    <div class="modal-header">

                        

                        <h5 class="modal-title">Modifier etat Commande @{{selectedCommand}}</h5>

                       <a href="javascript:;" data-dismiss="modal">Fermer</a>

 

                    </div>

                    

                    <div class="modal-body" >

                        <form method="post" action="updatestatus">

                            @csrf

                            <input hidden type="" :value="selectedCommand" name="cmdid">

                        <div class="row mb-2">

                          Etat actuel: <strong class="text-dark" style="font-weight: bold;">@{{state}}</strong>  

                        </div>

                        <div class="form-group">

                            <label>Choisir nouvel etat</label>

                            <select  name="etat"  v-model="etat" class="form-control" >

                                <option v-for="(status, index) in states" v-bind:key="index"  :selected="status.value == state" :value="status.value">@{{status.text}}</option>

                                

                            </select>

                        </div>



                            <div v-if="etat == 'termine' && state != etat" class="form-check">

                                  <input name="payed" class="form-check-input" type="checkbox" value="1" id="flexCheckDefault">

                                   <label class="form-check-label" for="flexCheckDefault">

                                          Commande encaissée

                                     </label>

                                  </div>

                             



                        <div v-if="etat == 'termine' && livreur == '11'" class="row">

                            <span class="text-warning" style="font-weight: bold;">Attention!! Cette commande n'est assignee a aucun livreur, si elle a ete effectuee par un livreur de votre liste, veuillez l'assigner a ce dernier.</span>


                            @if($client->livreurs->count() > 0)

                            <button type="button" @click="updateAssign(1)" v-if="!assign" class="btn btn-primary mb-2">Assigner a un livreur</button>

                            <button type="button" @click="updateAssign(null)" v-else class="btn btn-primary mb-2">Ne pas assigner</button>

                             <div v-if="assign" class="form-group">

                               <label class="form-label">Livreur</label>

                                  <select v-model="selectedLivreur" :required="assign == 1" class="form-control livreur" name="livreur">

                                    <option value="">Choisir un livreur</option>

                                    @foreach($client->livreurs as $livreur)

                                    <option value="{{$livreur->id}}">{{$livreur->nom}}</option>

                                     @endforeach

                                 </select>

                             </div>

                            

                                 

                             @else

                             Il n'y a pas de livreur dans votre liste. 

                             <a class="btn btn-primary btn-block" href="livreurs">Voir la liste des livreur</a>

                            @endif

                            



                        </div>



                        

                        <button :disabled="etat == '' || etat == state" class="btn btn-primary btn-block">Valider</button>



                    </form>

                    </div>

                   

                </div>

            </div>

        </div>

       

      

      <div   class="modal fade modalbox" id="productsModal"  tabindex="-1" role="dialog">

            <div  class="modal-dialog" role="document">

                <div  class="modal-content">

                    <div class="modal-header">

                      <h5  class="modal-title editModalTitle">Mes produit</h5>

                        <a href="javascript:;" @click="resetProducts" data-dismiss="modal">Fermer</a>

                        

                        



                    </div>

                    <div   class="modal-body">

                        <div class="row">

                           <div class="col">

                            <h3>Produits de la commande @{{ selectedCommand }}</h3>

                           </div>

                           <div class="col">

                            <h3>Total: @{{ total }} </h3> 

                           </div> 

                        </div>

                        <form method="post" action="updatecmdprod">

                            @csrf

                           <button class="btn btn-primary mb-2" type="submit">Valider</button>

                         <input hidden type="" name="id" :value="selectedCommand">

                        <div  v-for="(product, index) in products" :key="product.id" @mouseover="updateSelectedProduct(index)"  class="transactions mb-2">

                         

                        <div class="item border border-success" v-if="product.qty > 0">

                            <input hidden type="" :value="product.id+'_'+product.qty" name="products[]">

                <a href="#" >

                    <div class="detail">

                        <img :src="findImage(product.photo)" alt="img" class="image-block imaged w48">

                        <div >

                           

                            <strong>@{{ product.name }}</strong>

                            

                            

                        </div>

                    </div>



                     <button :disabled="product.qty > 0 ? false : true"  v-on:click="removeFromCart()" class="btn btn-danger btn-sm  mt-1" type="button"><ion-icon name="remove-outline"></ion-icon></button>

                      <button  :disabled="product.stock > 0 ? false : true"  v-on:click="addToCart()" class="btn btn-success btn-sm mr-1 mt-1" type="button"><ion-icon name="add-outline"></ion-icon></button>

                       

                    </a>

                    <div class="right">



                      

                       @{{ product.qty }} * @{{ product.price }} = @{{ product.price* product.qty}}<br>

                     

                      <span :class="product.stock > 0 ? 'text-success' : 'text-danger'">Stock @{{ product.stock }}</span>

                       

                        

                    </div>

                

                </div>

                </div>

            </form>

                <!-- * item -->

                

                

                       <hr style="height: 12px;"> 

                       <h3>Mes produits</h3> <div class="form-group searchbox ">

                <input onkeyup="search4()" id="Search4" type="text" class="form-control">

                <i class="input-icon">

                    <ion-icon name="search-outline"></ion-icon>

                </i>

            </div>

                       <div v-for="(product, index) in products" :key="product.id" @mouseover="updateSelectedProduct(index)" class="transactions mt-2 row target4">

                <!-- item -->

                <div  v-if="product.qty == 0" class="item border border-primary col">

                <a href="#" >

                    <div class="detail">

                        <img

                        :src="findImage(product.photo)"



                        alt="img" 

                         

                        



                         class="image-block imaged w48">

                        <div >

                           <p v-if="product.qty > 0"> @{{ product.qty }} dans le panier </p>

                            <strong>@{{ product.name }}</strong>

                            <p>@{{ product.description }}</p>

                        </div>

                    </div>

                      

                      <button :disabled="product.qty > 0 ? false : true"  v-on:click="removeFromCart()" class="btn btn-danger btn-sm  mt-1"><ion-icon name="remove-outline"></ion-icon></button>

                      <button  :disabled="product.stock > 0 ? false : true"  v-on:click="addToCart()" class="btn btn-success btn-sm mr-1 mt-1"><ion-icon name="add-outline"></ion-icon></button>

                     

                       

                    </a>

                    <div class="right">



                    Prix:  @{{ product.price }} F<br>

                     

                      <span :class="product.stock > 0 ? 'text-success' : 'text-danger'">Stock @{{ product.stock }}</span>

                      

                      

                        

                        

                    </div>



                  

                

                </div>

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

                        <h5 class="modal-title">Installez l'application {{config("app.name")}} User</h5>

                    </div>

                    <div class="modal-body">

                        Installez l'application {{config("app.name")}} User

                          <ul>

                              



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





        <div class="modal fade" id="InfoModal"  data-backdrop="static" tabindex="-1" role="dialog">

            <div class="modal-dialog" role="document">

                <div class="modal-content">

                    <div class="pt-3 text-center">

                        <img src="" style="height: 100px; width: 100px;" alt="image" class="imaged   mb-1 infoImg"><br>

                        <h5 class="infoTitle"></h5>

                         <div class="livRating"></div>

                       

                    </div>

                    <div class="modal-header pt-2">

                        

                    </div>

                    <div class="modal-body">

                        <div class="infoText">

                            

                        </div>

                        

                          <button onclick="$('#depositActionSheet').modal('show')" class="btn btn-success" >Enregistrez une commande maintenant</button>

                    </div>

                    <div class="modal-footer">

                        <div class="btn-inline">

                            <a href="#" class="btn btn-text-secondary " data-dismiss="modal">Fermer</a>

                           

                        </div>

                    </div>

                </div>

            </div>

        </div>

        @include("includes.commands_modal")

    <!-- * Add Card Action Sheet -->

 

    <!-- App Capsule -->

   

   <div class="appHeader">

        <div class="left">

            <a href="#" class="headerButton" data-toggle="modal" data-target="#sidebarPanel">

                <ion-icon name="menu-outline"></ion-icon>

            </a>

        </div>

        <div class="right">

            
              <form class="form-inline">
            <div class="input-group input-group-sm">
              <input class="form-control form-control-navbar" name="search" type="search" placeholder="Recherche globale" aria-label="Search">
              <div class="input-group-append">
                <button class="btn btn-navbar" type="submit">
                  <i class="fas fa-search"></i>
                </button>
               
              </div>
            </div>
          </form>
        </div>

        <div class="pageTitle">

             <button data-toggle="modal" data-target="#dateModal" class="btn btn-outline-primary btn-lg">{{$day}}</button>



        </div>

        

    </div>



    

         

    <div id="appCapsule" style="margin-top:50px;">



        <div class="section-full">

       <ul class="nav nav-tabs capsuled" id="cmdsection" role="tablist">





                      <li class="nav-item">

                            <a class="nav-link  aphone" data-toggle="tab" href="#chiffres" role="tab">

                                Chiffres

                            </a>

                        </li>

                        <li class="nav-item">

                            <a class="nav-link  active  phone" data-toggle="tab" href="#overview" role="tab">

                                Courses 

                            </a>

                        </li>



                        <li class="nav-item">

                            <a id="cmdtab" class="nav-link phone" data-toggle="tab" href="#card" role="tab">

                                Nouvelle Course ecommerce

                            </a>

                        </li>
                      
                      @if($command_roles->contains('action', 'MAD_C'))
                        <li class="nav-item">

                            <a @click="subsType = 'MAD'; livraison = 0" id="madtab" class="nav-link phone" data-toggle="tab" href="#mad" role="tab">

                                Nouvelle Course MAD

                            </a>

                        </li>
                        @endif

                        @if($command_roles->contains('action', 'DISTRIB_C'))

                         <li class="nav-item">

                            <a id="distribtab" class="nav-link phone" data-toggle="tab" @click="subsType = 'DISTRIBUTION'; livraison = 0" href="#distrib" role="tab">

                                Nouvelle Course DISTRIBUTION

                            </a>

                        </li>
                        @endif

                        @if($payment_roles->contains('action','CASH'))

   

      

                        <li class="nav-item ml-2">

                            <a href="payements" target="_blank" class="btn btn-success   "><i class="fa fa-hand-holding-usd"></i>Faire le point</a> 

                        </li>

                         @endif

                        

                    </ul>    

        

      </div>



          

         

             

       

    

                

                

                

               





@if($client->commands->where("livreur_id","!=", 11)->where("delivery_date", today())->count()>0)

@if($payment_roles->contains('action','LIVREUR_P'))

 <div class="section full mb-3">

            <div class="section-title">Progression des livreurs</div>

             <div class="transactions">

            <div  class="carousel-single owl-carousel owl-theme">

                @foreach($livreurs as $livreur3)

              @if($livreur3->commands->where('delivery_date', today())->where('client_id', $client->id)->count() > 0)

                

                    <div  class="item">

                    <div class="detail">

                        <img style="height:48px" @if(Storage::disk('s3')->exists($livreur3->photo))

                          src="https://livreurjibiat.s3.eu-west-3.amazonaws.com/{{$livreur3->photo}}"  @else src="assets/img/sample/brand/1.jpg" @endif alt="img" class="image-block imaged w48 " >

                        <div>

                            <strong>{{substr($livreur3->nom,0,20)}}</strong>

                            <p class="price"><div class="progress">

                        <div class="progress-bar" role="progressbar" style="width:{{($livreur3->commands->where('etat', 'termine')->where('delivery_date', today() )->where('client_id', $client->id)->count() / $livreur3->commands->where('delivery_date', today())->where('client_id', $client->id)->count()) *100}}%;" aria-valuenow="{{round(($livreur3->commands->where('etat', 'termine')->where('delivery_date', today() )->where('client_id', $client->id)->count() / $livreur3->commands->where('delivery_date', today())->where('client_id', $client->id)->count()) *100)}}"

                            aria-valuemin="0" aria-valuemax="100">

                             {{$livreur3->commands->where('delivery_date','=', today())->where('etat', 'termine')->where('client_id', $client->id)->count()}}/{{$livreur3->commands->where('delivery_date', today())->where('client_id', $client->id)->count()}} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                            {{round(($livreur3->commands->where('etat', 'termine')->where('delivery_date', today() )->where('client_id', $client->id)->count() / $livreur3->commands->where('delivery_date', today())->where('client_id', $client->id)->count()) *100)}}%</div>

                       

                    </div>

                    {{$livreur3->commands->where('etat', '!=', 'termine')->where('etat', '!=', 'annule')->where('delivery_date', today())->count()}} livraisons encours actuellement. 

                     {{LivreurHelper::getLivreursCmds($livreur3->id)}}

                </p>

                        </div>



                       

                    </div>

                    <div class="right">

                        <div class="price text-primary"> </div>

                    </div>

                 

                  

                   

                 

                </div>





               

                 @endif

                @endforeach

               

                

               

               

               

                 </div>

               

                

            </div>

        </div>

        @endif

   @endif





        



      <div class="tab-content mt-1">

        <div class="tab-pane fade show " id="chiffres" role="tabpanel">

            <div class="section mb-3" >

            <div class="section-title">Chiffres</div>

          <div class="row">

            <div class="col-sm-3 mb-2">

                <div class="card ">

                    <div class="card-header text-center"><h1>@{{ getTotal() }} FCFA (@{{ commands.length }})</h1></div>

                    <div class="card-body">

                        Total

                    </div>

                    

                </div>

            </div>





            <div class="col-sm-3 mb-2">

                <div class="card">

                    <div class="card-header text-center text-lg"><h1>@{{getLivre()[0]}} FCFA (@{{getLivre()[1]}})</h1></div>

                    <div class="card-body">

                         Livrés

                    </div>

                    

                </div>

            </div>



            <div class="col-sm-3 mb-2">

                <div class="card">

                    <div class="card-header text-center text-lg"><h1>@{{getUndone()[0]}} FCFA (@{{getUndone()[1]}})</h1></div>

                    <div class="card-body">

                         Encours de livraison

                    </div>

                    

                </div>

            </div>



             <div class="col-sm-3 mb-2">

                <div class="card">

                    <div class="card-header text-center text-lg"><h1>@{{getEncours()[0]}} FCFA (@{{getEncours()[1]}})</h1></div>

                    <div class="card-body">

                         Colis enregistrés et non collectés

                    </div>

                    

                </div>

            </div>



            <div class="col-sm-3 mb-2">

                <div class="card">

                    <div class="card-header text-center text-lg"><h1>@{{getDelai()[0]}} FCFA (@{{getDelai()[1]}})</h1></div>

                    <div class="card-body">

                         Colis hors delai

                    </div>

                    

                </div>

            </div>



             <div class="col-sm-3 mb-2">

                <div class="card">

                    <div class="card-header text-center text-lg"><h1>@{{getAnnule()[0]}} FCFA (@{{getAnnule()[1]}})</h1></div>

                    <div class="card-body">

                         Annulés

                    </div>

                    

                </div>

            </div>

              

          </div>



        </div>















          

         <div class="section mb-3" >

             <div class="section-title">Mes chiffres</div>

                <div class="card">

                    <div class="card-body">

                   <div class="row">

                       <div class="col">

                           <h3>Aujoud'hui</h3>

               @if($client_type->mensual_goal > 0)

               Objectif journalier: {{round($client_type->mensual_goal/30)}}<br>

               @endif

               Enregitré: {{$client->commands->where("delivery_date", today())->count()}}<br>

               Livré: {{$client->commands->where("delivery_date", today())->where("etat", "termine")->count()}}

              </div>

                 <div class="col">

                    <h3>Ce mois</h3>

              @if($client_type->mensual_goal > 0)

               Objectif Mensuel: {{round($client_type->mensual_goal)}}<br>

               @endif              

              <?php $f = new DateTime('first day of this month');

                    $l = new DateTime('last day of this month');  ?>

               Enregitré: {{$client->commands->whereBetween("delivery_date", [$f->format("Y-m-d"), $l->format("Y-m-d")])->count()}}<br>

                                             Livré: {{$client->commands->whereBetween("delivery_date", [$f->format("Y-m-d"), $l->format("Y-m-d")])->where("etat", "termine")->count()}}

                       </div>

                   </div>     

             

                

             

             

            <hr>

             

            <div class="row">

               



                <div class="col">

                     <div class="progress">



       <div class="progress-bar" role="progressbar" style="width: {{round($client->commands->where('delivery_date', today())->count()/($client_type->mensual_goal/30)*100)}}%;" aria-valuenow="{{round($client->commands->where('delivery_date', today())->count()/($client_type->mensual_goal/30)*100)}}" aria-valuemin="0" aria-valuemax="100">{{round($client->commands->where("delivery_date", today())->count()/($client_type->mensual_goal/30)*100)}}%</div>

       </div>

                </div>





                 <div class="col">

                    <div class="progress">



       <div class="progress-bar" role="progressbar" style="width: {{round($client->commands->whereBetween('delivery_date', [$f->format('Y-m-d'), $l->format('Y-m-d')])->count()/($client_type->mensual_goal)*100)}}%;" aria-valuenow="{{round($client->commands->whereBetween('delivery_date', [$f->format('Y-m-d'), $l->format('Y-m-d')])->count()/($client_type->mensual_goal)*100)}}" aria-valuemin="0" aria-valuemax="100">{{round($client->commands->whereBetween('delivery_date', [$f->format('Y-m-d'), $l->format('Y-m-d')])->count()/($client_type->mensual_goal)*100)}}%</div>

       </div>

                </div>

            </div>

      

          </div>  

          </div>    

           

        

      

       </div>



        </div>

        <div class="tab-pane fade show  active " id="overview" role="tabpanel">

             

            <div class="section mb-3 ml-2" >



         

                <div class="section-title">Courses à venir 

                {{$upcomings->sum('montant')}}F ({{$upcomings->count()}})

                </div>

                

                <div class="card">

                    <div class="card-body">

             

          @if($upcomings->count()>0)

         @foreach($upcomings  as $x=>$upcoming)



            <a class="btn-group mb-2 ml-2" href="commands?state=all&start={{$upcoming->delivery_date->format('Y-m-d')}}&end={{$upcoming->delivery_date->format('Y-m-d')}}">

       <button  class="btn btn-secondary btn-sm square">{{$upcoming->delivery_date->format('d-m-Y')}}</button>

      <button   class="btn btn-success btn-sm square" >

    {{$upcoming->montant}}F ({{$upcomings_count[$x]->nbre}})

  </button>

  </a>



         @endforeach

         @endif  

      

          </div>  

          </div>    

       </div>

     



    <!-- 

        <div class="section-full mt-2" >

            <ul class="nav nav-tabs lined"  role="tablist"  >

                        <li class="nav-item">

                            <a style="font-size:11px;" class="nav-link @if(!request()->has('state') || request()->state == 'all') active @endif"  href="?state=all&start={{$start}}&end={{$end}}" role="tab" aria-selected="true">

                               Tout &nbsp; <span  @if($all_commands->count() > 0) class="text-danger" @endif>{{$all_commands->count()}}</span>

                            </a>

                        </li>

                        <li class="nav-item">

                            <a style="font-size:11px; " class="nav-link state_btn @if(request()->has('state') && request()->state == 'unassigned') active @endif"  href="?state=unassigned&start={{$start}}&end={{$end}}" role="tab" aria-selected="false">

                                Non assignes &nbsp;  <span @if($all_commands->where("livreur_id",  11)->count() > 0) class="text-danger" @endif>{{$all_commands->where("livreur_id",  11)->count()}}</span>

                            </a>

                        </li>

                        <li class="nav-item">

                            <a style="font-size:11px; " class="nav-link state_btn @if(request()->has('state') && request()->state == 'assigned') active @endif"  href="?state=assigned&start={{$start}}&end={{$end}}" role="tab" aria-selected="false">

                                Assignes &nbsp;  <span @if($all_commands->where("livreur_id", "!=",  11)->count() > 0) class="text-danger" @endif>{{$all_commands->where("livreur_id", "!=",  11)->count()}}</span>

                            </a>

                        </li>

                        <li class="nav-item">

                            <a style="font-size:11px;"  class="nav-link  @if(request()->has('state') && request()->state == 'dlvm') active @endif "   href="?state=dlvm&start={{$start}}&end={{$end}}" role="tab" aria-selected="false">

                                En Livraison &nbsp;  <span @if($all_commands->whereIn("etat", ["recupere","en chemin"])->count() > 0) class="text-danger" @endif>{{$all_commands->whereIn("etat", ["recupere","en chemin"])->count()}}</span>

                            </a>

                        </li>



                        <li class="nav-item">

                            <a style="font-size:11px;"  class="nav-link  @if(request()->has('state') && request()->state == 'termine') active @endif "  href="?state=termine&start={{$start}}&end={{$end}}" role="tab" aria-selected="false">

                                Livres &nbsp;  <span @if($all_commands->where("etat", "termine")->count() > 0) class="text-danger" @endif>{{$all_commands->where("etat", "termine")->count()}}</span>

                            </a>

                        </li>



                        <li class="nav-item">

                            <a style="font-size:11px;"   class="nav-link  @if(request()->has('state') && request()->state == 'annule') active @endif "  href="?state=annule&start={{$start}}&end={{$end}}" role="tab" aria-selected="false">

                                Annule &nbsp;   <span  @if($all_commands->where("etat", "annule")->count() > 0) class="text-danger" @endif>{{$all_commands->where("etat", "annule")->count()}}</span>

                            </a>

                        </li>

                    </ul>

            

        </div> -->



        <div class="section-full mt-2">

        <div class="row">

       <div class="col"> <button data-toggle="modal" data-target="#bulkModal"  :disabled="Object.keys(selectedCommands).length < 1" class="btn btn-primary">Choisir une action</button> 





            <button  @click="printElement('cmdTable')"  rel="noopener"  class="btn btn-default d-print-none mr-2"><i class="fas fa-print"></i> Imprimer</button>

           



            <button data-toggle="modal" data-target="#filterModal" class="btn btn-sm btn-light phone"><ion-icon name="filter-outline"></ion-icon>Filtrer</button>

             <button  @click="printElement('cmdEti')" rel="noopener" class="btn  btn-default d-print-none" >Imprimer Etiquettes</button>

             <button  class="btn btn-default d-print-none mr-2" onclick="ExportToExcel()"><i class="fa fa-sheets"></i>Excel</button>



        



             

                <label> Mode d'affichage:</label>

                <select @change="resetCheck"  v-model="displayed" >

                    <option :selected="displayed == 'box'" value="box">Box</option>

                    <option :selected="displayed == 'table'" value="table">Tableau</option>

                </select>

               

            



           

        </div>

          

    </div>



          

         <div class="ml-2 mb-2 card">

       <div class="card-body">

        <div class="row mb-2">
        
        
                      @if($all_commands->count() > 0)
                      <form action="?" id="pageForm">
                      <span class="mr-2">  page {{$page}}/{{$pages}} ({{$all_commands->count()}} Courses)</span>
                         <input hidden type="" name="start" value="{{$start}}" >
                         <input hidden type="" name="end" value="{{$end}}" >
                         <input hidden type="" name="limit" value="{{$limit}}" >
                         @if(request()->has("assigns"))
                         @foreach(request('assigns') as $asg)
                           <input hidden type="" name="assigns[]" value="{{$asg}}" >
                           @endforeach
                         @endif

                         @if(request()->has("clients"))
                         @foreach(request('clients') as $clt)
                           <input hidden type="" name="clients[]" value="{{$clt}}" >
                           @endforeach
                         @endif

                          @if(request()->has("providers"))
                         @foreach(request('providers') as $prov)
                           <input hidden type="" name="providers[]" value="{{$prov}}" >
                           @endforeach
                         @endif

                          @if(request()->has("livreurs"))
                         @foreach(request('livreurs') as $liv)
                           <input hidden type="" name="livreurs[]" value="{{$liv}}" >
                           @endforeach
                         @endif

                          @if(request()->has("etats"))
                         @foreach(request('etats') as $et)
                           <input hidden type="" name="etats[]" value="{{$et}}" >
                           @endforeach
                         @endif
                      <select onchange="document.getElementById('pageForm').submit()" name="begining">

                          @for($x = 1; $x<= $pages; $x++)
                           <option  
                            @if($x == $page)
                                selected 
                            @endif

                            value="{{$x}}">{{$x}}</option>
                          @endfor
                      </select>
                      </form>

                      <form action="?" id="limitForm" class="mt-2">
                      <span class="mr-2">  Nombre par page </span>
                         <input hidden type="" name="start" value="{{$start}}" >
                         <input hidden type="" name="end" value="{{$end}}" >
                         <input hidden type="" name="begining" value="{{$begining}}" >
                         @if(request()->has("assigns"))
                         @foreach(request('assigns') as $asg)
                           <input hidden type="" name="assigns[]" value="{{$asg}}" >
                           @endforeach
                         @endif

                         @if(request()->has("clients"))
                         @foreach(request('clients') as $clt)
                           <input hidden type="" name="clients[]" value="{{$clt}}" >
                           @endforeach
                         @endif

                          @if(request()->has("livreurs"))
                         @foreach(request('livreurs') as $liv)
                           <input hidden type="" name="livreurs[]" value="{{$liv}}" >
                           @endforeach
                         @endif

                          @if(request()->has("etats"))
                         @foreach(request('etats') as $et)
                           <input hidden type="" name="etats[]" value="{{$et}}" >
                           @endforeach
                         @endif
                      <select onchange="document.getElementById('limitForm').submit()" name="limit">

                          @for($x = 50; $x<= 500; $x+=50)
                           <option  
                            @if($x == $limit)
                                selected 
                            @endif

                            value="{{$x}}">{{$x}}</option>
                          @endfor
                      </select>
                      </form>
                      @endif
<!-- 
        <h3>Total:</h3><h2 style=" font-weight: bold;">@{{ getTotal() }}(@{{commands.length}})</h2> &nbsp;&nbsp;<h3>/</h3>&nbsp;&nbsp;  
          <h3>Livres: </h3><h2 style="font-weight: bold;">@{{getLivre()[0]}}(@{{getLivre()[1]}})</h2> -->
        
            </div>

       <div v-for="allfee in allFees" class="d-inline ">

            <span class='chip chip-media' style='margin-bottom: 3px'  v-if="cmdsByfee(allfee.id)[0] > 0">

            <i  class='chip-icon bg-dark'>@{{ cmdsByfee(allfee.id)[0] }}</i><span  class='chip-label'>@{{ allfee.destination }}

            </span>

        </span>

     </div>

     </div>

 </div>     

               



             @if($filter != "")

             <div class="row ml-2">

            {!! $filter !!} 

            <form action="?">

                <input hidden name="state" value="{{$state}}">

            <input hidden name="start" value="{{$start}}">

            <input hidden name="end" value="{{$end}}">

            <button class="btn btn-primary btn-sm">Retour aux commandes</button>

            </form>

          </div>

             @endif

       </div>

       

      <div class="commands section row justify-content-center">

         

               

          

               

                <div class="col-md-12">

                 @include("includes.commandlist")

                 

               </div>

            

            </div> 

            <!-- * card block -->

          </div>

           

         <div  id="cmdSuccess"  class="card mb-2">



            <div v-if="newR" class="card-body">

               <span class="alert alert-success mb-2">Commande enregistree</span>

               Numero:<span style="color:red; font-size: 20px; font-weight: bold;">@{{newR.id}}</span>(a inscrire sur votre colis)



               <button type="button" @click="shareBill('Commande'+ ' '+ newR.id+'. '+newR.description+ '. Total:'+ (Number(newR.montant)+Number(newR.livraison))+'. '+newR.adresse+ '. '+newR.phone+ '. Plus de detail sur {{ url('/') }}/tracking/'+newR.id)" class="btn btn-primary btn-block mt-2 squared" id="bill">ENVOYER FACTURE</button>

           </div>

            </div>

         <div class="tab-pane fade " id="card" role="tabpanel">

            <div class="section row justify-content-center">
                

                

                 <div class="col-sm-6 ">

                  

                <div class="section-title">Nouvelle course <button @click="resetCmdForm()" class="btn btn-light">Vider le formulaire</button>
                </div>

               @if($command_roles->contains('action', 'C'))

        

       

                @include("includes.commandform")

                 @endif

            </div>

    </div>

  </div>

@if($command_roles->contains('action', 'MAD_C'))
    <div class="tab-pane fade " id="mad" role="tabpanel">

            <div class="section row justify-content-center">

                

                 <div class="col-sm-6 ">

                  

                <div class="section-title">Nouvelle course MAD<button @click="resetCmdForm()" class="btn btn-light">Vider le formulaire</button></div>

               

        

       

                @include("includes.madform")

                

            </div>

    </div>

  </div>
 @endif
@if($command_roles->contains('action', 'DISTRIB_C'))

<div class="tab-pane fade " id="distrib" role="tabpanel">

            <div class="section row justify-content-center">

                

                 <div class="col-sm-6 ">

                  

                <div class="section-title">Nouvelle course Distribution<button @click="resetCmdForm()" class="btn btn-light">Vider le formulaire</button></div>

               
        

       

                @include("includes.distribform")

                

            </div>

    </div>

  </div>
   @endif
</div>

</div>



</div>

   @include("includes.commandsvue")

    <!-- * App Capsule -->



   

   

    

    <!-- App Bottom Menu -->

     

   

    

    

     

    @include("includes.footer")

    <!-- * App Bottom Menu -->

  

    <!-- App Sidebar -->

   @include("includes.sidebar")

    

  



    <!-- ///////////// Js Files ////////////////////  -->

    <!-- Jquery -->

 <script src="../assets/js/lib/jquery-3.4.1.min.js"></script>



    

      

     <script src="../assets/manifest/js/app.js"></script>

    <!-- Bootstrap-->

    <script src="../assets/js/lib/popper.min.js"></script>

    <script src="../assets/js/lib/bootstrap.min.js"></script>

    <!-- Ionicons -->

    

    <!-- Owl Carousel -->

   

    <!-- Base Js File -->

    <script src="../assets/js/base.js"></script>

     <script src="../assets/js/star-rating.min.js"></script>

    <script src="../assets/js/commands.js"></script>

     

    

   <script src="../assets/js/bootstrap-switch-button1.1.0.js"></script>





 

  <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>

<!-- DataTables  & Plugins -->

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>





<script  src="../assets/js/bootstrap-select.min.js"></script>

<script src="../assets/js/plugins/splide/splide.min.js"></script>

<script type="text/javascript" src="https://unpkg.com/xlsx@0.15.1/dist/xlsx.full.min.js"></script>

<script src="https://js.pusher.com/7.2/pusher.min.js"></script>

 <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.5.0-beta4/html2canvas.min.js"></script>

@if($command_roles->contains("action", "R_ALL"))

  <script>







    // Enable pusher logging - don't include this in production

    Pusher.logToConsole = true;



    var pusher = new Pusher('54e83f52c122567eb7af', {

      cluster: 'eu'

    });



    var channel = pusher.subscribe('my-channel');

    channel.bind('my-event', function(data) {

      alert(JSON.stringify(data));

    });

  </script>

  @endif

  <script>



 $(function () {

    $("#example1").DataTable({

      "responsive": true,

       "lengthChange": false,

        "autoWidth": false,

        "ordering": false,

        "paging": false,

      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]

    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');



    $('#example2').DataTable({

      "paging": false,

      "lengthChange": false,

      "searching": true,

      "ordering": false,

      "info": true,

      "autoWidth": false,

      "responsive": true,

    });

  });





    

var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');









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



function search3() {

    

    var input = document.getElementById("Search3");

    var filter = input.value.toLowerCase();

    var nodes = document.getElementsByClassName('target3');

    for (i = 0; i < nodes.length; i++) {

      if (nodes[i].innerText.toLowerCase().includes(filter)) {

        nodes[i].style.display = "block";

      } else {

        nodes[i].style.display = "none";

      }

    }



    

  }





  function search4() {

    

    var input = document.getElementById("Search4");

    var filter = input.value.toLowerCase();

    var nodes = document.getElementsByClassName('target4');

    for (i = 0; i < nodes.length; i++) {

      if (nodes[i].innerText.toLowerCase().includes(filter)) {

        nodes[i].style.display = "block";

      } else {

        nodes[i].style.display = "none";

      }

    }



    

  }











  function searchcat() {

    

    var input = document.getElementById("searchCat");

    var filter = input.value.toLowerCase();

    var nodes = document.getElementsByClassName('target3');

    for (i = 0; i < nodes.length; i++) {

      if (nodes[i].innerText.toLowerCase().includes(filter)) {

        nodes[i].style.display = "block";

      } else {

        nodes[i].style.display = "none";

      }

    }



    

  }



  function searchcat2() {

    

    var input = document.getElementById("searchCat2");

    var filter = input.value.toLowerCase();

    var nodes = document.getElementsByClassName('target3');

    for (i = 0; i < nodes.length; i++) {

      if (nodes[i].innerText.toLowerCase().includes(filter)) {

        nodes[i].style.display = "block";

      } else {

        nodes[i].style.display = "none";

      }

    }



    

  }

$( document ).ready(function() {

    $('#livreur-select').selectpicker();

$('#fee-select').selectpicker();

$('#source-select').selectpicker();

$('#state-select').selectpicker();

$('#prod-select').selectpicker();

});





$(".livreurDetail").click( function() {

    $('#InfoModal').modal('show');

    var livreur = $(this).data('livreur');

    var rating = $(this).data("rating");

    var experience = $(this).data("experience");

    var livreurCmds = $(this).data("livreurcmds");

    var currentCmds = $(this).data("currentcmds");

    $('.infoTitle').html(livreur['nom']);

   



    $('.infoText').html("Lieu d'habitation:"+livreur['adresse']+"<br>"+"Contact:"+livreur['phone']+"<br>Experience:"+experience+" livraisons effectuees.<br> <br>"+currentCmds + "<br>"+ livreurCmds);

          $('.infoImg').attr("src", 'https://livreurjibiat.s3.eu-west-3.amazonaws.com/'+livreur['photo']);

    

     

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













 $(".rateLivreur").click( function() {

  

   id = $('.payeurid').val();

   rate = $('#input-1').val();

   $(this).prepend('<span  class="spinner-border  " role="status" aria-hidden="true"></span><span class="sr-only"></span>');



   btn = $(this);





     $.ajax({

       url: 'ratelivreur',

       type: 'post',

       data: {_token: CSRF_TOKEN,id: id, rate: rate},

   

       success: function(response){

               $('.payeur').attr('hidden', 'hidden');

               $('.paySuccess').html("<strong class='fadein'>Votre note a été prise en compte. Merci pour votre contribution.</strong>");

               btn.html("Noter livreur")

                

              },

   error: function(response){

               

                 toastbox('toast-err', 2000);

                 btn.html("Noter livreur");



              }

             

     });

   });







  







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







       



     $('.detail2').click( function() {

   var livreur_id = $(this).val();

   

    $("#payModal").modal("show");

   $('.payBody').html('<span   class=\"spinner-border spinner-border paySpinner\" role=\"status\" aria-hidden=\"true\"></span><span class=\"sr-only\"></span>');





     $.ajax({

       url: 'paydetail',

       type: 'post',

       data: {_token: CSRF_TOKEN,livreur_id: livreur_id},

   

       success: function(response){

                 $('.payReturn').removeAttr('hidden');

                $('.payBody').html(response.display);

                $('.payTotal').html('<strong>Payement:' +response.total + '</strong>');



                $('.rtrnTotal').html('<strong>Non livré:' +response.totalundone + '</strong>');

                 $('.payLivreur').html(response.livreur);

                 $('#singlePayScript').html(response.single_pay_script);

              },

   error: function(response){

               

                alert('Une erruer s\'est produite');

              }

             

     });

   });





   $('.paydetail').click( function() {

   var livreur_id = $(this).val();

   

    

   $('.payBody').html('<span   class=\"spinner-border spinner-border paySpinner\" role=\"status\" aria-hidden=\"true\"></span><span class=\"sr-only\"></span>');





     $.ajax({

       url: 'paydetail',

       type: 'post',

       data: {_token: CSRF_TOKEN,livreur_id: livreur_id},

   

       success: function(response){

                 $('.payReturn').removeAttr('hidden');

                $('.payBody').html(response.display);

                $('.payTotal').html('<strong style="color:black">Payement:' +response.total + '</strong>');



                $('.rtrnTotal').html('<strong style="color:black">Non livré:' +response.totalundone + '</strong>');

                 $('.payLivreur').html(response.livreur);

                 $('#singlePayScript').html(response.single_pay_script);

                 $("#payModal").modal("show");

              },

   error: function(response){

               

                alert('Une erruer s\'est produite');

              }

             

     });

   }); 





   function ExportToExcel(type, fn, dl) {

       var elt = document.getElementById('cmdTable');

       var wb = XLSX.utils.table_to_book(elt, { sheet: "sheet1" });

       return dl ?

         XLSX.write(wb, { bookType: type, bookSST: true, type: 'base64' }):

         XLSX.writeFile(wb, fn || ('Commandes{{$start}}_{{$end}}.' + (type || 'xlsx')));

    }



















$('#mySelect').select2();





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









</script>





</body>



</html>