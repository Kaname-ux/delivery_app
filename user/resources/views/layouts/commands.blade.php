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
    <title>Jibiat - Mes commandes</title>
    <link rel="stylesheet" href="../assets/css/style.css">
     <link rel="stylesheet" href="../assets/css/bootstrap-switch-button.min.css">
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />
      <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
      <link rel="apple-touch-icon" sizes="180x180" href="assets/img/apple-touch-icon.png">
    <link rel="icon" type="image/png" href="../assets/img/favicon.png" sizes="32x32">
    <link rel="shortcut icon" href="../assets/img/favicon.png">
   
     <link rel = " manifest " href="../assets/manifest/client.json">
   
   <!-- ios support -->
    <link rel="apple-touch-icon" href="../assets/manifest/img/logo-icon.png" />
    
 
<style>
  .toggle.ios, .toggle-on.ios, .toggle-off.ios { border-radius: 20px; }
  .toggle.ios .toggle-handle { border-radius: 20px; }

  
</style>
<!-- Inclusion des feuilles de styles et script pour le composant Bootstrap-select -->



 <script src="https://unpkg.com/vue@3"></script> 
 
 
</head>

<body>

   
    <div  id="app">

         <div class="modal fade action-sheet" id="dateModal" tabindex="-1" role="dialog">
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
                        
                        <h5 class="modal-title">Filter</h5>
                        
                        <a href="javascript:;" data-dismiss="modal">Fermer</a>
                    </div>
                    <div   class="modal-body">
                        <div class="action-sheet-content ">
                            <form action="?">
                                <div hidden>
                                     <input value="{{$state}}" type="text" name="state">
                                       <input value="{{$start}}" type="text" name="start">
                                    <input value="{{$end}}"  type="text" name="end">
                                </div>
                                    
                                
                            @if($client->livreurs->count() > 0)
                          <div class="form-group">
                            <label class="form-label ">Filter par livreur</label>
                              <select data-style="btn-dark" v-model="livreurs" title="Choisir livreurs..." id="livreur-select" class="selectpicker form-control" multiple  name="livreurs[]">
                               
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


                          <div class="form-group">
                            <label class="form-label">Filter par source</label>
                              <select data-style="btn-dark" v-model="sources" title="Choisir sources..." id="source-select" class=" selectpicker form-control" multiple  name="sources[]">
                                 <option value="catalogue">Catalogue</option>
                                 @if($client->sources->count() > 0)
                                 @foreach($client->sources as $source)
                                  <option value="{{$source->type. '_'.$source->antity}}">{{$source->type. '_'.$source->antity}}</option>
                                 @endforeach
                                 @endif
                                 </select>
                                

                          </div>

                          <button :disabled="livreurs.length == 0 && fees.length == 0 && sources.length == 0" class="btn btn-primary btn-block">Filtrer</button>
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
                        
                        <h5 class="modal-title">Faire le point</h5>
                        
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



                          
                          <button :disabled="livreur2 == ''" class="btn btn-primary btn-block">Faire le point</button>
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
                        <a href="javascript:;" data-dismiss="modal">Fermer</a>
                        
                        

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
                        <div  v-for="(product, index) in products" :key="product.id" @mouseover="updateVariant(index)"  class="transactions mb-2">
                         
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
                <input onkeyup="search2()" id="Search2" type="text" class="form-control">
                <i class="input-icon">
                    <ion-icon name="search-outline"></ion-icon>
                </i>
            </div>
                       <div v-for="(product, index) in products" :key="product.id" @mouseover="updateVariant(index)" class="transactions mt-2 row target2">
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


        
 <form hidden action="?" class="range-form ">
    <input value="{{$state}}" type="text" name="state">
          <input class="start" type="text" name="start">
          <input class="end" type="text" name="end">
        </form>



   
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


    
    <!-- loader -->
   
    <!-- * loader -->

    <!-- App Header -->
    <div class="appHeader">
        <div class="left">
            <a href="#" class="headerButton" data-toggle="modal" data-target="#sidebarPanel">
                <ion-icon name="menu-outline"></ion-icon>
            </a>
        </div>
        <div class="right">
            <a href="#" class="headerButton toggle-searchbox">
                <ion-icon name="search-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">
             <button data-toggle="modal" data-target="#dateModal" class="btn btn-outline-primary btn-sm">{{$day}}</button>

        </div>
        

        <div class="extraHeader">
      <div class="left">
          Total:<span style="font-size:12px; font-weight: bold;">{{$total}}({{$commands->count()}})</span>/  
          Livres: <span style="font-size:12px; font-weight: bold;">{{$commands->where('etat', 'termine')->sum('montant')}}({{$commands->where('etat', 'termine')->count()}})</span>
           
       </div> 
       
       <div class="right">
          
        </div>
    </div>
    
     
    </div>

    <div id="search" class="appHeader">
        <form class="search-form">
            <div class="form-group searchbox">
                <input id="Search" onkeyup="search()" name="text" type="text" class="form-control" placeholder="Recherche...">
                <i class="input-icon icon ion-ios-search"></i>
                <a href="#" class="ms-1 close toggle-searchbox"><ion-icon name="close-circle-outline"></ion-icon></a>
            </div>
        </form>
    </div>


    <!-- * App Header -->


    <!-- Add Card Action Sheet -->
    
    <!-- * Add Card Action Sheet -->

    <!-- App Capsule -->
   
   
         
    <div id="appCapsule" style="margin-top:40px;">
        <div style=" z-index: 1000; width: 100%; height: auto; padding-top: 0;" class="card position-fixed  mb-3 ">
    
        <div class="card-body ">
        
<button class="float-left btn btn-outline-success bulkaction">
Action
</button>

<button data-toggle="modal" data-target="#checkoutModal" class="btn  btn-success  ml-3"><i class="fa fa-hand-holding-usd"></i>Faire le point</button>


<button onclick="$('#cmdform').trigger('reset'); $('.cmdModalTitle').html('Nouvelle commande'); $('#cmdform').attr('action', 'command-fast-register');"
 data-toggle="modal" data-target="#depositActionSheet" class="float-right btn btn-success btn-rounded"><ion-icon name="add-outline"></ion-icon></button>

</div>
 
       
   </div>
             
          <div class="section-full mb-3" style="margin-top:100px;">
         
       @if($upcomings->count()>0)
                <div class="section-title">Commandes à venir 
                {{$upcomings->sum('montant')}}F ({{$upcomings->count()}})
                </div>
                

            
                <div class="card">
                    <div class="card-body">
             
      
         
         @foreach($upcomings  as $x=>$upcoming)

         
            <a class="btn-group mb-2" href="commands?state=all&start={{$upcoming->delivery_date->format('Y-m-d')}}&end={{$upcoming->delivery_date->format('Y-m-d')}}">
       <button  class="btn btn-secondary btn-sm square">{{$upcoming->delivery_date->format('d-m-Y')}}</button>
      <button   class="btn btn-success btn-sm square" >
    {{$upcoming->montant}}F ({{$upcomings_count[$x]->nbre}})
  </button>
  </a>



         
         @endforeach
        
      
      
          </div>  
          </div>    
           
        </div>
       @endif  
        @include('includes.cmdvalidation')

      @if($recomended_livreurs->count()>0)
         <div class="section full mb-3 ">
            <div  class="section-title text-primary">Livreurs recommandes </div>
             <div class="transactions ">
            <div  class="carousel-single owl-carousel owl-theme  ">
               
                @foreach($recomended_livreurs as $livreur10)
                     @if(!$client->livreurs->contains($livreur10->id))
                    <div  class="item " style="background-color: #B0C4FF;">
                    <div data-experience="{{$livreur10->commands->where('etat', 'termine')->count()}}" data-rating="{{ $livreur10->AverageRating }}" data-livreur="{{$livreur10->toJson()}}" data-livreurcmds="{{LivreurHelper::getLivreursCmds($livreur10->id)}}" data-currentcmds="{{$livreur10->commands->where('etat', '!=', 'termine')->where('etat', '!=', 'annule')->where('delivery_date', today())->count()}} livraisons encours actuellement." class="detail livreurDetail">
                        <img style="height:48px" @if(Storage::disk('s3')->exists($livreur10->photo))
                          src="https://livreurjibiat.s3.eu-west-3.amazonaws.com/{{$livreur10->photo}}"  @else src="assets/img/sample/brand/1.jpg" @endif alt="img" class="image-block imaged w48 " >
                        <div>
                            <strong>{{substr($livreur10->nom,0,20)}}</strong>
                            <p class="price">{{$livreur10->commands->where("etat", "termine")->count()}} Livraisons effectuees</p>

                            <p class="price">  <input  disabled class="rating rating-loading"  data-step="1" value="{{ $livreur10->AverageRating }}" data-size="xs"></p>
                        </div>
                    </div>
                    <div class="right">
                        <button data-id="{{$livreur10->id}}" style="font-size:10px"  type="button" class="addlivreur btn  btn-primary  w-100">
                 Ajouter à ma liste</button> 
                    </div>
                </div>
              @endif

                @endforeach
                
               
               
                 </div>
               
                
            </div>
        </div>
        @endif
     @if($payments_by_livreurs->count()>0)
        <div class="section full mb-3">
            <div class="section-title">Les livreurs vous doivent {{$payments_by_livreurs->sum("montant")}} f <button  type="button" class="pay btn btn-sm btn-primary  " >
     Details</button></div>
             <div class="transactions">
            <div class="carousel-single owl-carousel owl-theme">
                
                @foreach($payments_by_livreurs as $payment)
                
                    <div class="item">
                    <div class="detail">
                        <img style="height:48px" @if(Storage::disk('s3')->exists($payment->livreur->photo))
                          src="https://livreurjibiat.s3.eu-west-3.amazonaws.com/{{$payment->livreur->photo}}"  @else src="assets/img/sample/brand/1.jpg" @endif alt="img" class="image-block imaged w48">
                        <div>
                            <strong>{{$payment->montant}} f</strong>
                            <p >{{substr($payment->livreur->nom,0,20)}}</p>
                        </div>
                    </div>
                    <div class="right">
                        <div  class="price text-primary"> 
                            <button value="{{$payment->livreur->id}}" class="btn paydetail">
                                <ion-icon name="chevron-forward-outline"></ion-icon>
                            </button>
                        </div>
                    </div>
                </div>
               

                @endforeach
                
                
                
               
               
                 </div>
               
                
            </div>
        </div>

@endif

@if($undone_by_livreurs->count()>0)
         <div class="section full mb-3">
            <div class="section-title">Colis Non livrés {{$undone_by_livreurs->sum("nbre")}} <button class="btn btn-primary btn-sm cmdRtrn" >Details</button></div>
             <div class="transactions">
            <div  class="carousel-single owl-carousel owl-theme">
                
                @foreach($undone_by_livreurs as $undone)
                
                    <div  class="item">
                    <div class="detail">
                        <img style="height:48px" @if(Storage::disk('s3')->exists($undone->livreur->photo))
                          src="https://livreurjibiat.s3.eu-west-3.amazonaws.com/{{$undone->livreur->photo}}"  @else src="assets/img/sample/brand/1.jpg" @endif alt="img" class="image-block imaged w48 " >
                        <div>
                            <strong>{{$undone->nbre}} coli(s)</strong>
                            <p class="price">{{substr($undone->livreur->nom,0,20)}}</p>
                        </div>
                    </div>
                    <div class="right">
                        <div class="price text-primary"> <button  value="{{$undone->livreur->id}}" class="detail2 btn"><ion-icon name="chevron-forward-outline"></ion-icon></button> </div>
                    </div>
                </div>
               

                @endforeach
              
               
               
                 </div>
               
                
            </div>
        </div>
@endif
@if($client->commands->where("livreur_id","!=", 11)->where("delivery_date", today())->count()>0)
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
                            aria-valuemin="0" aria-valuemax="100">{{round(($livreur3->commands->where('etat', 'termine')->where('delivery_date', today() )->where('client_id', $client->id)->count() / $livreur3->commands->where('delivery_date', today())->where('client_id', $client->id)->count()) *100)}}%</div>
                       {{$livreur3->commands->where('delivery_date','=', today())->where('etat', 'termine')->where('client_id', $client->id)->count()}}/{{$livreur3->commands->where('delivery_date', today())->where('client_id', $client->id)->count()}}
                    </div>
                    {{$livreur3->commands->where('etat', '!=', 'termine')->where('etat', '!=', 'annule')->where('delivery_date', today())->count()}} livraisons encours actuellement. <br>
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

           
        
   


      <div class="item">
                <div class="card">
                    <div class="card-body">
             
    
            @if($client->is_certifier == 'yes')
             
             <a href="certifications" class="btn btn-outline-primary btn-block mb-1">

                            <ion-icon name="thumbs-up-outline"></ion-icon>
                            Voir les demandes de certifiction 
                            @if($certifications->count()>0)
                            <span class="badge badge-danger">{{$certifications->count()}}</span>
                            @else
                            <span class="badge badge-primary">{{$certifications->count()}}</span>
                            @endif
                        </a >
                        @endif
               
               

           <!--  <button data-toggle="modal" data-target="#checkoutModal" class="btn btn-success btn-block  mb-1"><i class="fa fa-hand-holding-usd"></i>Faire le point</button> -->         

               <!-- <div class="row">
                <div class="col">
              <div class="btn-group" role="group">
    <button  type="button" class="pay btn btn-outline-primary  " >
     <ion-icon name="cash-outline"></ion-icon> Payements

                  @if($payments_by_livreurs->count()>0)
                            <span class="badge badge-danger">{{$payments_by_livreurs->count()}}</span>
                            @else
                            <span class="badge badge-primary">{{$payments_by_livreurs->count()}}</span>
                            @endif
    </button>
   
  </div>
</div>
<div class="col">
  <button class="btn btn-outline-primary cmdRtrn" ><ion-icon name="return-down-back-outline"></ion-icon>Non livres 
  @if($undone_by_livreurs->count()>0)
  <span class="badge badge-danger"> 
    {{$undone_by_livreurs->count()}}</span>
    @else
    <span class="badge badge-primary"> 
    {{$undone_by_livreurs->count()}}</span>
    @endif


  </button>
  </div>  
  </div>  -->
              
              <!-- <div class="row mt-2">
                <div class="col">
              <div class="btn-group" role="group">
    <button id="btnGroupDrop1" type="button" class="btn btn-outline-primary  dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
     <ion-icon name="add-outline"></ion-icon> Commande
    </button>
    <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
      <a data-toggle="modal" data-target="#depositActionSheet" class="dropdown-item" href="#">Sans articles</a>
      <a class="dropdown-item" href="products">Avec des article</a>
    </div>
  </div>
</div>
<div class="col">
  <a class="btn btn-outline-primary" href="products"><ion-icon name="bag-outline"></ion-icon>Mes articles </a>
  </div>  
  </div>  -->
  <button class="btn btn-outline-primary btn-block globalNearByLivreur mt-2"><ion-icon name="location-outline"></ion-icon>Voir les livreurs à proximité</button>
          </div>  
          </div>    
            </div>


    
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
            
        </div>

        <div class="section-full mt-2">
        
      


                    


 <div class="row">
       @if($commands->count() > 0)
          
       <div class="col">
           <form target="_blank" method="post" action="printing?print">
            @csrf
            <input hidden name="state" value="{{$state}}">
            <input hidden name="start" value="{{$start}}">
            <input hidden name="end" value="{{$end}}">
           <button class="btn btn-sm btn-light phone" type="submit"><ion-icon name="print-outline"></ion-icon>Imprimer</button>
                      
           </form>
       </div>
           <div class="col">
           <form target="_blank" method="post" action="printing?etiquettes">
            @csrf
            <input hidden name="state" value="{{$state}}">
            <input hidden name="start" value="{{$start}}">
            <input hidden name="end" value="{{$end}}">
           <button class="btn btn-sm btn-light phone" type="submit"><ion-icon name="print-outline"></ion-icon>Imprimer Etiquettes</button>
                      
           </form>
           </div>

           
       
                       
       @endif
       <div class="col">
            <button data-toggle="modal" data-target="#filterModal" class="btn btn-sm btn-light phone"><ion-icon name="filter-outline"></ion-icon>Filtrer</button>
            
           </div>
           </div>
         <br> 
       

       @if(count($final_destinations)>0)    
               @foreach($final_destinations as $destination=> $nomber)
               

               <div class="chip chip-media" style="margin-bottom: 3px">
                        <i class="chip-icon bg-dark">
                            {{ $nomber}}
                        </i>
                        <span class="chip-label">{{$destination}}</span>
                    </div>
               @endforeach
               
               @endif
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
            <div class="commands section-full">
                <div class="transactions">
                <div class="row">
               @if($commands->count()>0)
                
               @foreach($commands->sortBy("adresse")->chunk(20) as $chunks)
                
                @foreach($chunks as $command)
                 @include("includes.commandlist")
                 <?php $chk++; ?>
                 @endforeach
                 @endforeach


                  <!-- by state -->
               
                @endif
            </div>
                </div>
                </div> 
            <!-- * card block -->

          
        
        <div class="mb-3"></div>
       

    </div>
    
    </div>
    <script>
   const app = Vue.createApp({
    data() {
        return {
            
            selectedVariant: 0,
            selectedCommand:"",
            total:0,
            cartProducts: [],
            cart:0,
            products: {!! $products !!},
            assignBody: "",
            state:"",
            states:[{"text":"Encours", "value":"encours"},{"text":"Livre", "value":"termine"},{"text":"Annule", "value":"annule"},],
            assign:null,
            livreur:"",
            livreur2:"",
            etat:"",
            selectedLivreur:null,
            fees:[],
            sources:[],
            livreurs:[],
            allVals:[],
            costumStart:"",
            intStart:null

        }
    },
    methods:{ 
    
    
    updateAssign(index){
        this.assign = index
    },  

    updateVariant(index) {
        this.selectedVariant = index
        
    },

   


    addToCart() {
          this.cart += 1 
          this.products[this.selectedVariant].qty += 1
          this.products[this.selectedVariant].stock -= 1
           this.total += this.products[this.selectedVariant].price 
 

    },
 
   removeFromCart() {
        this.cart -= 1
        this.products[this.selectedVariant].qty -= 1
         this.products[this.selectedVariant].stock += 1
        this.total -= this.products[this.selectedVariant].price 
      
    },

    findImage(productImg){
        if(productImg == null){
            src = "assets/img/sample/brand/1.jpg"
        }
        else{
            src = "https://livreurjibiat.s3.eu-west-3.amazonaws.com/"+productImg
        }

        return src
    },
  

    updateProducts(productIds = {}, commandid = 0) {
         this.total = 0
         this.selectedCommand = commandid

        for (a=0; a <  this.products.length; a++) {
            
                
                this.products[a].qty = 0
               
            
        }
        
        for (i=0; i < productIds.length; i++) {
            
            for (y=0; y <  this.products.length; y++) {
            if(this.products[y].id == productIds[i].product_id){
                
                this.products[y].qty = productIds[i].qty
                this.total += this.products[y].price*this.products[y].qty

                console.log(this.products[y].qty)
            }
            
        }
      }
      

    },

    updateSelectedState(state, commandId, livreur){
        this.state = state
        this.livreur = livreur
        this.selectedCommand = commandId
    }

   },
   computed:{
     
}
});

  const mountedApp = app.mount('#app')     
  </script>
    <!-- * App Capsule -->

    @include("includes.commands_modal")
    <div></div>
    
    <!-- App Bottom Menu -->
     
   
    @include("includes.sidebar")
    @include("includes.footer")
     @include("includes.bottom")
    <!-- * App Bottom Menu -->

    <!-- App Sidebar -->
   
   
  

    <!-- ///////////// Js Files ////////////////////  -->
    <!-- Jquery -->
     <script src="../assets/js/lib/jquery-3.4.1.min.js"></script>

    
      
     <script src="../assets/manifest/js/app.js"></script>
    <!-- Bootstrap-->
    <script src="../assets/js/lib/popper.min.js"></script>
    <script src="../assets/js/lib/bootstrap.min.js"></script>
    <!-- Ionicons -->
    
    <!-- Owl Carousel -->
    <script src="../assets/js/owl.carousel.min.js"></script>
    <!-- Base Js File -->
    <script src="../assets/js/base.js"></script>
     <script src="../assets/js/star-rating.min.js"></script>
     <script src="../assets/js/commands.js"></script>
     
    
   <script src="../assets/js/bootstrap-switch-button1.1.0.js"></script>


 
  <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>


<script  src="../assets/js/bootstrap-select.min.js"></script>
<script src="assets/js/plugins/splide/splide.min.js"></script>
  <script>

$(".addlivreur").click( function() {
    
    var livreur_id = $(this).data('id');
    var current = $(this);
    
      $.ajax({
        url: 'addlivreur',
        type: 'post',
        data: {_token: CSRF_TOKEN,livreur_id: livreur_id},
        success: function(response){
           var livreur = response.livreur;
          (current).attr("disabled", "disabled");
          (current).text("Livreur ajouté");

          $('#InfoModal').modal('show');
          $('.infoTitle').html("Dites a "+ livreur['nom']+ "que vous l'avez ajouté a votre liste");
          $('.infoText').html("<a class='btn btn-primary mr-2 mb-2' href='tel:"+livreur['phone']+"'><ion-icon name='call-outline'></a>"+"<a class='btn btn-success mr-2 mb-2' href='https://wa.me/"+livreur['wme']+"?text=Bonjour%20"+livreur['nom']+".Je%20suis%20{{$client->nom}}%20.%20Je%20viens%20de%20t%20ajouter%20à%20ma%20liste%20de%20livreur%20sur%20Jibiat.Je%20souhaite%20travailler%20avec%20toi.'><ion-icon name='logo-whatsapp'></a>" +"<a class='btn btn-success mr-2 mb-2' href='sms:"+livreur['phone']+"'><ion-icon name='mail-outline'></a>");
          $('.infoImg').attr("src", 'https://livreurjibiat.s3.eu-west-3.amazonaws.com/'+livreur['photo']);
          $(".livreurInput").removeAttr("hidden");
          $(".livreur").append("<option value='"+livreur['id']+"'>"+livreur['nom']+"</option>");
       }
      });
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
$('#livreur-select').selectpicker();
$('#fee-select').selectpicker();
$('#source-select').selectpicker();
 
$(".contact").on('change', function() {
    
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
    $('#cmdMenumodal').modal('hide');
   
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



       

      $('.detail2').click( function() {
   var livreur_id = $(this).val();
   
    $('.cmdRtrnBack').removeAttr('hidden');
   $('.cmdRtrnBody').html('<span   class="spinner-border spinner-border cmdRtrnSpinner" role="status" aria-hidden="true"></span><span class="sr-only"></span>');


     $.ajax({
       url: 'cmdrtrndetail',
       type: 'post',
       data: {_token: CSRF_TOKEN,livreur_id: livreur_id},
   
       success: function(response){
                 $('.cmdRtrnReturn').removeAttr('hidden');
                $('.cmdRtrnBody').html(response.display);
                $('.cmdRtrnTotal').html('<strong>Total:' +response.total + '</strong>');
                 $('.cmdRtrnLivreur').html(response.livreur);
                 $('#cmdRtrnScript').html(response.cmd_rtrn_script);
                 $("#cmdRtrnModal").modal("show");
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
                $('.payTotal').html('<strong>Total:' +response.total + '</strong>');
                 $('.payLivreur').html(response.livreur);
                 $('#singlePayScript').html(response.single_pay_script);
                 $("#payModal").modal("show");
              },
   error: function(response){
               
                alert('Une erruer s\'est produite');
              }
             
     });
   }); 

</script>


</body>

</html>